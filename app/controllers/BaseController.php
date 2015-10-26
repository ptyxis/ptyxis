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

class BaseController
{

    protected $baseUrl;
    protected $salt;

    protected $session;
    protected $validation;

    protected $data;

    protected $settingModel;

    protected $theme;

    protected $settings;

    function BaseController()
    {
        $this->session      = new PtyxisSessions();
        $this->session->start();

        $this->validation   = new PtyxisValidation();

        $this->handleFlash();

        //check if the application is installed
        if (!$this->isInstalled()) {
            if (get_class($this) != 'InstallController') {
                echo "Configuration required";
                die();
            } else {
                return;
            }
        }

        $this->loadConfig();

        $this->set('errors', null);

        //set the base url by default
        $this->set('base_url', $this->baseUrl);

        $logged_in = $this->isLoggedIn();
        $this->set('logged_in', $logged_in);

        $this->initSettings();

        $this->initMeta();

    }

    private function initMeta()
    {
        $meta = array();
        $meta['title']          = $this->settings['comic_title'];
        $meta['description']    = $this->settings['comic_description'];

        $this->set('meta', $meta);
    }

    private function loadConfig()
    {
        global $kc_config;
        $this->baseUrl  = $kc_config['base_url'];
        $this->salt     = $kc_config['salt'];
    }

    private function initSettings()
    {
        $this->settingModel = new SettingModel();

        $this->settings = $this->settingModel->getAll();
        $this->set('comic_settings', $this->settings);

        $this->theme = $this->settings['theme'];
    }

    private function handleFlash()
    {
        $flash_message  = $this->session->get('flash_message');
        $flash_type     = $this->session->get('flash_type');
        if (!empty($flash_message)) {
            $this->set('flash_message', $flash_message);
            $this->set('flash_type', $flash_type);
            $this->session->set('flash_message', False);
        }
    }

    protected function isInstalled()
    {
        global $missingConfig, $db_config;

        if (!empty($missingConfig)) {
            return False;
        }

        try {
            $db = new PtyxisMySQL();
            $db->connect($db_config);

            //get version setting
            $version = $db->query("SELECT * FROM setting WHERE name = 'version' " );
            if (!empty($version[0]['value'])) {
                return True;
            }

        } catch (Exception $e) {
            return False;
        }
    }

    protected function hash_password($password)
    {
        $hash = crypt($password, $this->salt);
        return $hash;
    }

    protected function baseUrl()
    {
        return $this->baseUrl;
    }

    protected function isLoggedIn()
    {
        $loggedin = $this->session->get('user_id');
        if (!empty($loggedin)) {
            return True;
        } else {
            return False;
        }
    }

    protected function checkLogon()
    {
        if (!$this->isLoggedIn()) {
            $this->session->flashRedirect('You must be logged in.', $this->baseUrl . 'user/login');
        }
    }

    protected function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    protected function setTemplate($value)
    {
        $this->set('template', $value);
    }

    protected function setLayout($value)
    {
        $this->set('layout', $value);
    }

    protected function sendEmail($to, $from, $subject, $body, $altBody = '')
    {
        require 'app/lib/PHPMailer/PHPMailerAutoload.php';

        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Set who the message is to be sent from
        $mail->setFrom( $from );
        //Set an alternative reply-to address
        $mail->addReplyTo( $from );
        //Set who the message is to be sent to

        if (is_array($to)) {
            foreach ($to as $contact) {
                $mail->addAddress( $contact );
            }
        } else {
            $mail->addAddress( $to );
        }

        //Set the subject line
        $mail->Subject  = $subject;
        $mail->Body     = $body;
        $mail->AltBody  = $altBody;

        $mail->send();
    }

}
