<?php

namespace App\Controllers;

use Sentinel;
use App\Models\User;
use App\AffiliateEarning;
use Illuminate\Http\Request;
use App\AffiliateEarningRecord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Charts\currentMonthClickStatistics;
use App\Charts\previousMonthClickStatistics;
use App\Charts\AffiliateClickStatisticsChart;

class DashboardController extends Controller
{

    public function affiliateProgram()
    {
        $folder = $this->getFolder();

        $data['role'] = $folder;
        $data['bodyClass'] = 'hh-dashboard';

        $affliateEarning = AffiliateEarning::where('user_id', get_current_user_id())->first();
        if(!$affliateEarning)
        {
            $affliateEarning = null;
        }

        $totalRefferal = User::where('parent_id', get_current_user_id())->get()->count();
        $data['affiliateEarning'] = $affliateEarning;
        $data['totalRefferal'] = $totalRefferal;

        $earnings = AffiliateEarningRecord::whereMonth('created_at', date('m'))
        ->where('user_id', get_current_user_id())
        ->whereYear('created_at', date('Y'))
        ->get();

        $earningCount = 0;

        foreach($earnings as $item)
        {
            $earningCount += $item->amount;
        }

        $data['lastMontEarning'] = $earningCount;

        return view("dashboard.screens.{$folder}.affiliate", $data);
    }

    public function _updateYourPayoutInformation(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        if (!hh_compare_encrypt($user_id, $user_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }

        $user = get_user_by_id($user_id);

        if (!$user) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }
        $payout_payment = request()->get('payout_payment');
        $payout_detail = request()->get('payout_detail');

        update_user_meta($user_id, 'payout_payment', $payout_payment);
        update_user_meta($user_id, 'payout_detail', $payout_detail);

        return $this->sendJson([
            'status' => 1,
            'title' => __('System Alert'),
            'message' => __('Updated payout information successfully')
        ]);
    }

    public function _updatePassword(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        if (!hh_compare_encrypt($user_id, $user_encrypt)) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }

        $user = get_user_by_id($user_id);

        if (!$user) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user does not exist')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => $validator->errors()->first()
            ]);
        } else {
            $password = trim(request()->get('password'));
            $credentials = [
                'password' => $password,
            ];
            $user_updated = Sentinel::update($user, $credentials);
            return $this->sendJson([
                'status' => 1,
                'title' => __('System Alert'),
                'message' => __('Updated password successfully')
            ]);
        }
    }

    public function _getFontIcon(Request $request)
    {
        global $text;
        $text = request()->get('text', '');
        $text = strtolower(trim($text));
        if (empty($text)) {
            $this->sendJson(
                [
                    'status' => 0,
                    'data' => __('Not found icons')
                ]
                , true);
        }
        include public_path('fonts/fonts.php');
        if (!isset($fonts)) {
            $this->sendJson([
                'status' => 0,
                'data' => __('Not found icons data')
            ], true);
        }
        $results = array_filter($fonts, function ($key) {
            global $text;
            if (strpos(strtolower($key), $text) === false) {
                return false;
            } else {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);
        if (empty($results)) {
            $this->sendJson([
                'status' => 0,
                'data' => __('Not found icons')
            ], true);
        } else {
            $this->sendJson([
                'status' => 1,
                'data' => $results
            ], true);
        }
    }

    public function _updateYourAvatar(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        $avatar = request()->get('avatar');
        if (hh_compare_encrypt($user_id, $user_encrypt) && $user_id == get_current_user_id()) {
            $user_model = new User();
            $updated = $user_model->updateUser($user_id, ['avatar' => $avatar]);
            if (!is_null($updated)) {
                return $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => __('Updated successfully')
                ]);
            } else {
                return $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => __('Can not update this user. Try again!')
                ]);
            }
        } else {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user is invalid')
            ]);
        }
    }

    public function _updateYourProfile(Request $request)
    {
        $user_id = request()->get('user_id');
        $user_encrypt = request()->get('user_encrypt');
        $first_name = request()->get('first_name');
        $last_name = request()->get('last_name');
        $mobile = request()->get('mobile');
        $location = request()->get('location');
        $address = request()->get('address');
        $description = request()->get('description');

        if (hh_compare_encrypt($user_id, $user_encrypt) && $user_id == get_current_user_id()) {
            $args = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'mobile' => $mobile,
                'location' => $location,
                'address' => $address,
                'description' => $description,
            ];
            if (is_admin($user_id)) {
                $email = request()->get('email');
                if (empty($email) || !is_email($email)) {
                    return $this->sendJson([
                        'status' => 0,
                        'title' => __('System Alert'),
                        'message' => __('The email is invalid')
                    ]);
                }
                $args['email'] = $email;
            }

            $user_model = new User();
            $updated = $user_model->updateUser($user_id, $args);
            if (!is_null($updated)) {
                return $this->sendJson([
                    'status' => 1,
                    'title' => __('System Alert'),
                    'message' => __('Updated successfully')
                ]);
            } else {
                return $this->sendJson([
                    'status' => 0,
                    'title' => __('System Alert'),
                    'message' => __('Can not update this user. Try again!')
                ]);
            }
        } else {
            return $this->sendJson([
                'status' => 0,
                'title' => __('System Alert'),
                'message' => __('This user is invalid')
            ]);
        }
    }

    public function _getProfile()
    {
        $folder = $this->getFolder();
        return view("dashboard.screens.{$folder}.profile", ['role' => $folder, 'bodyClass' => 'hh-dashboard']);
    }

    public function index()
    {
        $folder = $this->getFolder();
        return view("dashboard.screens.{$folder}.dashboard", ['role' => $folder, 'bodyClass' => 'hh-dashboard']);
    }

}
