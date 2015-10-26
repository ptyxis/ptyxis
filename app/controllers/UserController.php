<?php
/***************************************
Ptyxis Comic CMS
Copyright (C) 2015 Mark Kestler ptyxis.cthonic.com


GNU General Public License, version 2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
****************************************/

class UserController extends BaseController  {

    private $userModel;

    function UserController()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function profile()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('user/profile');

        $this->input = $_REQUEST;

        $this->validation->setRules('email', 'Email', 'required|valid_email');

        if (!$this->validation->validate()) {

            if (empty($this->input)) {
                $user = $this->userModel->get($this->session->get('user_id'));
                $this->set('user', $user);
            } else {
                $user = $this->input;
                $this->set('user', $user);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $user = array();
            $user['id']         = $this->session->get('user_id');
            $user['email']      = $this->input['email'];
            if ($this->userModel->update($user)) {
                $this->session->flashRedirect('Profile saved successfully', $this->baseUrl().'dashboard');
            } else {
                $user = $this->input;
                $this->set('user', $user);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save user');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

    public function changepassword()
    {

        $this->checkLogon();

        $this->setLayout('admin');
        $this->setTemplate('user/changepassword');

        $this->input = $_REQUEST;

        $this->validation->setRules('password', 'Password', 'required|matches[passwordconf]');

        if (!$this->validation->validate()) {

            if (empty($this->input)) {
                $user = $this->userModel->get($this->session->get('user_id'));
                $this->set('user', $user);
            } else {
                $user = $this->input;
                $this->set('user', $user);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $user = array();
            $user['id']         = $this->session->get('user_id');
            $user['password']   = $this->hash_password($this->input['password']);
            if ($this->userModel->updatePassword($user)) {
                $this->session->flashRedirect('Password changed successfully', $this->baseUrl().'dashboard');
            } else {
                $user = $this->input;
                $this->set('user', $user);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save user');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

    public function forgotpassword()
    {
        $this->setLayout('theme/'.$this->theme.'/public');
        $this->setTemplate('user/forgotpassword');

        $this->input = $_REQUEST;

        $this->validation->setRules('email', 'Email', 'required|valid_email');

        if ( !$this->validation->validate() ) {
            if(!empty($this->input)) {
                $user = $this->input;
                $this->set('user', $user);
                $this->set('errors', $this->validation->getErrors());
            }
        } else {

            $user = $this->userModel->getUserByEmail($this->input['email']);
            //check its a valid login
            if ( !empty($user) ) {
                //setup the password reset
                $token = $this->userModel->newPasswordResetToken($user['id']);

                //build the link
                $resetLink = $this->baseUrl . 'user/resetpassword/' . $user['id'] . '/' . $token;

                //build email
                $from       = '';
                $to         = $user['email'];
                $subject    = 'Kalyx Comic Password Reset ';
                $body       = 'To reset your password click the following link: '. $resetLink;

                //send the email
                $this->sendEmail($to, $from, $subject, $body);
            }

        }

        return $this->data;
    }

    public function resetpassword($id, $token)
    {

        $resetUser = $this->userModel->resetUser($id, $token);

        if ($resetUser) {
            $this->session->set('user_id', $resetUser['id']);
            $this->session->set('user_email', $resetUser['email']);

            //reset the hash
            $this->userModel->newPasswordResetToken($resetUser['id']);

            $this->session->flashRedirect('Reset your password below', $this->baseUrl().'user/profile');
        } else {
            $this->session->flashRedirect('Invalid reset link', $this->baseUrl().'user/login');
        }
    }

    public function login()
    {
        $this->setLayout('theme/'.$this->theme.'/public');
        $this->setTemplate('user/login');

        $this->input = $_REQUEST;

        if ( !empty($this->input) ) {
            $user = array();
            $user['email']      = $this->input['email'];
            $user['password']   = $this->hash_password($this->input['password']);
            $logonUser = $this->userModel->logon($user);

            if ($logonUser) {
                $this->session->set('user_id', $logonUser['id']);
                $this->session->set('user_email', $logonUser['email']);

                //reset the hash
                $this->userModel->newPasswordResetToken($logonUser['id']);

                $this->session->flashRedirect('Logon successful', $this->baseUrl().'dashboard');
            } else {
                $this->set('user',$this->input);
                $errors[] = array('label' => 'Login', 'error' => 'Email or password invalid');
                $this->set('errors', $errors);
            }
        }

        return $this->data;
    }

    public function logout()
    {
        $this->checkLogon();
        $this->session->destroy();
        $this->session->flashRedirect('Logout successful', $this->baseUrl().'user/login');
    }

}
