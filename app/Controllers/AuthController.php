<?php

namespace App\Controllers;

use Redirect;
use Sentinel;
use App\Models\User;
use Mockery\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthController extends Controller
{
    public function subscribeEmail()
    {
        $email = request()->get('email');
        $res = \MailChimpSubscribe::get_inst()->addNewSubscriber($email);
        $this->sendJson($res, true);
    }

    public function _getSignUp()
    {
        return view('dashboard.sign-up', ['bodyClass' => 'authentication-bg authentication-bg-pattern']);
    }

    public function _postSignUp(Request $request)
    {

        if(Session::has('ref_id'))
        {
            $refId = Session::get('ref_id');

            $reffUser = User::where('ref_id', $refId)->first();

            if($reffUser)
            {
                $parrentId = $reffUser->id;
            }
            else 
            {
                $parrentId = null;
            }
            
        }
        else
        {
            $parrentId = null;
        }

        $validator = Validator::make($request->all(),
            [
                'email' => 'required',
                'password' => 'required|min:6',
                'term_condition' => 'required'
            ],
            [
                'email.required' =>  __('The email is required'),
                'password.required' => __('The password is required'),
                'password.min' => __('The password has at least 6 characters'),
                'term_condition.required' => __('Please agree with the Term and Condition')
            ]
        );
        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => $validator->errors()->first()])->render()
            ]);
        }
        $password = request()->get('password');
        $credentials = [
            'email' => request()->get('email'),
            'password' => $password,
            'first_name' => request()->get('first_name', ''),
            'last_name' => request()->get('last_name', ''),
        ];
        $user = Sentinel::findByCredentials($credentials);
        if ($user) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('This user already exists')])->render()
            ]);
        }
        try {
            $user = Sentinel::registerAndActivate($credentials);


            // $time = time();

            // $newRefId = substr($time, -4) . $user->id;

            $newUser = User::where('id', $user->id)->first();
            // $newUser->ref_id = $newRefId;
            $newUser->parent_id = $parrentId;
            $newUser->save();

            $user_model = new \App\Models\User();
            $role = $user_model->getRoleByName('customer');
            $user_model->updateUserRole($user->getUserId(), $role->id);

        } catch (Exception $e) {
            return $this->sendJson([
                'status' => 0,
                 'message' => view('common.alert', ['type' => 'danger', 'message' => $e->getMessage()])->render()
            ]);
        }
        if (!$user) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type'
                => 'danger', 'message' => 'Can not create new user'])->render()
            ]);
        } else {
            do_action('hh_registered_user', $user->getUserId(), $password);
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'success', 'message' => __('Registered successfully')])->render(),
	            'redirect' => url('auth/login')
            ]);
        }
    }

    public function _getResetPassword()
    {
        return view('dashboard.reset-password', ['bodyClass' => 'authentication-bg authentication-bg-pattern']);
    }

    public function _postResetPassword(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'email' => 'required|exists:users,email',
            ],
            [
                'email.required' => 'The email is required',
                'email.exists' => 'The email does not exist',
            ]
        );

        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => $validator->errors()->first()])->render()
            ]);
        }

        $credentials = [
            'login' => request()->get('email'),
        ];

        $user = Sentinel::findByCredentials($credentials);
        if (is_null($user)) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('The email does not exist')])->render()
            ]);
        } else {
            $password = createPassword(32);
            $credentials = [
                'password' => $password,
            ];

            $user = Sentinel::update($user, $credentials);

            if (!$user) {
                return $this->sendJson([
                    'status' => 0,
                    'message' => view('common.alert', ['type' => 'danger', 'message' => __('Can not reset password for this account. Try again!')])->render()
                ]);
            } else {
                $subject = sprintf(__('[%s] You have changed the password'), get_option('site_name'));
                $content = view('frontend.email.reset-password', ['user' => $user, 'password' => $password])->render();
                send_mail('', '', $user->email, $subject, $content);
                return $this->sendJson([
                    'status' => 0,
                    'message' => view('common.alert', ['type' => 'success', 'message' => __('Successfully! Please check your email for a new password.')])->render(),
                    'redirect' => auth_url('login')
                ]);
            }
        }
    }

    public function _getLogin()
    {
        return view('dashboard.login', ['bodyClass' => 'authentication-bg authentication-bg-pattern']);
    }

    public function _postLogin(Request $request)
    {
        $input = request()->only('email', 'password');
        $redirect = get_referer(url('dashboard'));
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|exists:users,email',
                'password' => 'required|min:6'
            ],
            [
                'email.required' => __('The email is required'),
                'email.exists' => __('The email does not exist'),
                'password.required' => __('The password is required'),
                'password.min' => __('The password has at least 6 characters')
            ]
        );
        if ($validator->fails()) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => $validator->errors()->first()])->render()
            ]);
        }
        try {

            Sentinel::authenticate($input, request()->has('remember'));

        } catch (NotActivatedException $e) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('User is not activated')])->render()
            ]);

        } catch (ThrottlingException $e) {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('Your account has been suspended due to 5 failed attempts. Try again after 15 minutes.')])->render()
            ]);

        }
        if (Sentinel::check()) {
            return $this->sendJson([
                'status' => 1,
                'message' => view('common.alert', ['type' => 'success', 'message' => __('Logged in successfully. Redirecting ...')])->render(),
                'redirect' => $redirect
            ]);
        } else {
            return $this->sendJson([
                'status' => 0,
                'message' => view('common.alert', ['type' => 'danger', 'message' => __('The email or password is incorrect')])->render()
            ]);
        }
    }

    public function _postLogout(Request $request)
    {
        $redirect_url = request()->get('redirect_url');

        Sentinel::logout();

        if (empty($redirect_url)) {
            $redirect_url = url('auth/login');
        }
        return $this->sendJson([
            'status' => 1,
            'title' => 'System Alert',
            'message' => __('Successfully Logged out'),
            'redirect' => $redirect_url
        ]);
    }

}
