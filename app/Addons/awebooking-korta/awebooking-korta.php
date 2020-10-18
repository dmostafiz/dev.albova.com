<?php
/*
 * Name: Korta.is
 * Slug: awebooking-korta
 * Description: Korta.is Payment Gateway
 * Author: Salim Mlare
 * Version: 1.0
 * Tags: payment
 */

class KortaRegister
{
    public $path;
    public $url;

    public function __construct()
    {
        $this->path = dirname(__FILE__);
        $this->url = asset('addons/' . basename(__DIR__));

        require_once 'inc/Korta.php';

        add_filter('hh_payment_gateways', [$this, '_register_payment']);
    }

    public function _register_payment($payments)
    {
        $payments['korta'] = 'KortaPayment';
        return $payments;
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

KortaRegister::get_inst();
