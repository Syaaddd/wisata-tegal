<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['form', 'url', 'CIMail'];
    public function loginForm()
    {
        $data = [
            'pageTitle' => 'Login',
            'validation' => null
        ];
        return view('backend/pages/auth/login', $data);
    }

    public function loginHandler()
    {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|valid_email|is_not_unique[users.email]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Email is not valid',
                        'is_not_unique' => 'Email is not registered'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[45]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password is too short',
                        'max_length' => 'Password is too long'
                    ]
                ]
            ]);
        } else {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[users.username]',
                    'errors' => [
                        'required' => 'username is required',
                        'is_not_unique' => 'username is not registered'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[45]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password is too short',
                        'max_length' => 'Password is too long'
                    ]
                ]
            ]);
        }

        if (!$isValid) {
            return view('backend/pages/auth/login', [
                'pageTitle' => 'Login',
                'validation' => $this->validator
            ]);
        } else {
            $user = new User();
            $userInfo = $user->where($fieldType, $this->request->getVar('login_id'))->first();
            $check_password = Hash::check($this->request->getVar('password'), $userInfo['password']);

            if (!$check_password) {
                return redirect()->route('admin.login.form')->with('fail', 'Password is incorrect')->withInput();
            } else {
                CIAuth::setCIAuth($userInfo);
                return redirect()->route('admin.home');
            }
        }
    }

    public function forgotForm()
    {
        $data = array(
            'pageTitle' => 'Forgot Password',
            'validation' => null
        );
        return view('backend/pages/auth/forgot', $data);
    }

    public function sendPasswordResetLink()
    {
        $isValid = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                    'is_not_unique' => 'Email is not registered'
                ]
            ]
        ]);

        if ( !$isValid ){
            return view('backend/pages/auth/forgot', [
                'pageTitle' => 'Forgot Password',
                'validation' => $this->validator,
            ]);
        } else {
            $user = new User();
            $user_info = $user->asObject()->where('email', $this->request->getVar('email'))->first();

            $token = bin2hex(openssl_random_pseudo_bytes(65));

            $password_reset_token = new PasswordResetToken();
            $isOldTokenExists = $password_reset_token->asObject()->where('email',$user_info->email)->first();
            
            if( $isOldTokenExists ){
                $password_reset_token->where('email', $user_info->email)
                                     ->set(['token'=>$token, 'created_at'=>Carbon::now()])
                                     ->update();
            }else{
                $password_reset_token->insert([
                    'email'=>$user_info->email, 
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
            }

            $actionLink = route_to('admin.reset-password', $token);

            $mail_data = array(
                'actionlink' => $actionLink,
                'user'=>$user_info,
            );

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/forgot-email-template');

            $mailconfig = array(
                'mail_form_email' =>env('EMAI_FORM_ADDRESS'),
                'mail_form_name' =>env('EMAI_FORM_NAME'),
                'mail_recipient_email' => $user_info->email,
                'mail_recipient_name' => $user_info->name,
                'mail_subject' => 'Reset Password',
                'mail_body' => $mail_body,
            );

            if( sendMail($mailconfig) ){
                return redirect()->route('admin.forgot.form')->with('success', 'Password reset link sent to your email');
            }else{
                return redirect()->route('admin.forgot.form')->with('fail', 'Failed to send password reset link');
            }
        }
    }
}