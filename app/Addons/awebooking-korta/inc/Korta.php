<?php

use Illuminate\Http\Request;
use \App\Abstracts\Gateways;

class KortaPayment extends Gateways
{
    static $paymentId = 'korta';

    public $url = 'https://netgreidslur.korta.is/';
    public $test_url = 'https://netgreidslur.korta.is/testing/';
    public $merchant_id;
    public $terminal_id;
    public $secret_code;

    public function __construct()
    {
        parent::__construct();
    }

    public static function enable()
    {
        $enable = get_option('enable_' . self::$paymentId, 'off');
        return !!($enable == 'on');
    }

    public static function enableTestMode()
    {
        $enable = get_option(self::$paymentId . '_test_mode', 'off');
        return !!($enable == 'on');
    }

    public static function getHtml()
    {
        return '';
    }

    public static function getID()
    {
        return self::$paymentId;
    }

    public static function getName()
    {
        return __('Korta.is');
    }

    public static function getLogo()
    {
        $img = get_option(self::$paymentId . '_logo');
        if (!$img) {
            return KortaRegister::get_inst()->url . '/assets/img/korta.png';
        }
        return get_attachment_url($img, 'full');
    }

    public static function getDescription()
    {
        return get_option(self::$paymentId . '_description');
    }

    public static function getOptions()
    {
        return [
            'title' => [
                'id' => 'sub_tab_' . self::$paymentId,
                'label' => self::getName()
            ],
            'content' => [
                [
                    'id' => 'enable_' . self::$paymentId,
                    'label' => __('Enable'),
                    'type' => 'on_off',
                    'std' => 'off',
                    'section' => 'sub_tab_' . self::$paymentId
                ],
                [
                    'id' => self::$paymentId . '_logo',
                    'label' => __('Logo'),
                    'type' => 'upload',
                    'translation' => false,
                    'section' => 'sub_tab_' . self::$paymentId
                ],
                [
                    'id' => self::$paymentId . '_test_mode',
                    'label' => __('Sandbox Mode'),
                    'type' => 'on_off',
                    'std' => 'on',
                    'section' => 'sub_tab_' . self::$paymentId
                ],
                [
                    'id' => self::$paymentId . '_merchant_id',
                    'label' => __('Merchant ID'),
                    'type' => 'text',
                    'layout' => 'col-12 col-sm-6',
                    'translation' => false,
                    'section' => 'sub_tab_' . self::$paymentId
                ],
                [
                    'id' => self::$paymentId . '_terminal_id',
                    'label' => __('Terminal ID'),
                    'type' => 'text',
                    'layout' => 'col-12 col-sm-6',
                    'translation' => false,
                    'break' => true,
                    'section' => 'sub_tab_' . self::$paymentId
                ],
                [
                    'id' => self::$paymentId . '_secret_code',
                    'label' => __('Secret Code'),
                    'type' => 'text',
                    'layout' => 'col-12 col-sm-6',
                    'translation' => false,
                    'break' => true,
                    'section' => 'sub_tab_' . self::$paymentId
                ],
                [
                    'id' => self::$paymentId . '_description',
                    'label' => __('Description'),
                    'type' => 'textarea',
                    'translation' => true,
                    'section' => 'sub_tab_' . self::$paymentId
                ],
            ]
        ];
    }

    public function setParams($params)
    {
        $user_data = get_booking_data($this->orderObject->ID, 'user_data');
        $data_hash = [
            'amount' => $this->convertPrice($this->orderObject->total, $this->orderObject->currency),
            'currency' => 'ISK',
            'merchant' => $this->merchant_id,
            'terminal' => $this->terminal_id,
            'description' => $this->orderObject->booking_description,
        ];
        $default = [
            'amount' => $this->convertPrice($this->orderObject->total, $this->orderObject->currency),
            'currency' => 'ISK',
            'merchant' => $this->merchant_id,
            'terminal' => $this->terminal_id,
            'description' => $this->orderObject->booking_description,
            'checkvaluemd5' => $this->calculateHash($data_hash),
            'qty' => 1,
            'reference' => $this->orderObject->booking_id,
            'look' => '',
            'lang' => 'en',
            'encoding' => 'utf-8',
            'refermethod' => 'post',
            'refertarget' => '_top',
            'downloadurl' => $this->successUrl(),
            'callbackurl' => $this->successUrl(),
            'continueurl' => $this->cancelUrl(),
            'readonly' => 'Y',
            's_showcontinueurl' => 'Y',
            'name' => $this->orderObject->first_name,
            'address' => $this->orderObject->address,
            'phone' => $this->orderObject->phone,
            'email' => $this->orderObject->email,
            'email2' => $this->orderObject->email,
            'city' => $user_data['city'],
            'country' => get_country_by_code($user_data['country'])['name'],
            'zip' => $user_data['postCode'],
        ];
        $this->params = wp_parse_args($params, $default);
    }

    public function calculateHash($data)
    {
        $string = $data['amount'] . $data['currency'] . $data['merchant'] . $data['terminal'] . htmlentities($data['description'] , ENT_COMPAT, 'UTF-8');
        $string = preg_replace('/((^(\/)*)|((\/)*$))/m', '', $string);
        $string .= $this->secret_code;
        $string .= self::enableTestMode() ? 'TEST' : '';
        return md5($string);
    }

    public function setDefaultParams()
    {
        $this->merchant_id = get_option(self::$paymentId . '_merchant_id');
        $this->terminal_id = get_option(self::$paymentId . '_terminal_id');
        $this->secret_code = get_option(self::$paymentId . '_secret_code');
    }

    public function validation()
    {
        $required = [
            'city',
            'country',
            'postCode'
        ];
        foreach ($required as $key) {
            $val = request()->get($key);
            if (empty($val)) {
                return [
                    'status' => false,
                    'message' => sprintf(__('%s is required for this payment'), $key)
                ];
            }
        }
        return true;

    }

    public function purchase($orderID = false, $params = [])
    {
        $this->setOrderObject($orderID);

        $this->setDefaultParams();

        $this->setParams($params);

        do_action('hh_purchase_' . self::$paymentId, $this->params);

        try {
            $authorize_args_array = array();

            foreach ($this->params as $key => $value) {
                $authorize_args_array[] = "<input type='hidden' name='{$key}' value='{$value}'/>";
            }

            if (self::enableTestMode()) {
                $processURI = $this->test_url;
            } else {
                $processURI = $this->url;
            }

            $html_form = '<form action="' . e($processURI) . '" method="post" id="korta_payment_form">'
                . implode('', $authorize_args_array)
                . '<script>
                      jQuery(function(){
                            jQuery("#korta_payment_form").submit();
                      });
                    </script>'
                . '</form>';

            return [
                'status' => 'incomplete',
                'redirectForm' => $html_form,
                'formID' => '#korta_payment_form',
                'message' => __('Created payment successfully. The system is redirecting')
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'pending',
                'message' => $e->getMessage()
            ];
        }
    }

    public function completePurchase($orderID = false, $params = [])
    {
        do_action('hh_complete_purchase_' . self::$paymentId, $this->params);
        if (isset($_GET['_payment']) && $_GET['_payment'] == 'korta') {
            $this->setDefaultParams();
            if ($this->checkHash()) {
                $status = \request()->get('_status', 0);
                if($status == 1){
                    return [
                        'status' => 'completed',
                        'message' => __('This payment is completed')
                    ];
                }else{
                    return [
                        'status' => 'canceled',
                        'message' => __('This payment is cancelled')
                    ];
                }
            } else {
                return [
                    'status' => 'canceled',
                    'message' => __('This payment is cancelled')
                ];
            }
        }
    }

    public function checkHash()
    {
        $checkvaluemd5 = request()->get('checkvaluemd5');
        $reference = request()->get('reference');
        $environment = request()->get('environment', 'test');
        $downloadmd5 = request()->get('downloadmd5');

        $strToMd5 = "2" . $checkvaluemd5 . $reference . $this->secret_code;
        if ($environment == 'test') {
            $strToMd5 .= "TEST";
        }
        $calcedDownloadmd5 = md5($strToMd5);

        return ($calcedDownloadmd5 == $downloadmd5);
    }


    protected function convertPrice($price, $currency)
    {
        $currency = maybe_unserialize($currency);
        $price = (float)$price * (float)$currency['exchange'];
        $price = round($price, 2);
        $price = number_format($price, 2, '.', '');
        return $price;
    }

    public static function get_inst()
    {
        static $instance;
        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}

KortaPayment::get_inst();
