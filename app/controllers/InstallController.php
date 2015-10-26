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

class InstallController  extends BaseController
{

    protected $baseUrl;
    protected $data;
    protected $salt;

    public function install()
    {

        //check if we should be running instal
        if ($this->isInstalled()) {
            die();
        }

        //get base url
        $host   = $_SERVER['HTTP_HOST'];
        $uri    = $_SERVER['REQUEST_URI'];
        $this->baseUrl = "http://$host".str_replace('install','',$uri);
        $this->data['base_url'] = $this->baseUrl;
        $this->data['errors'] = null;

        $this->setLayout('admin/install');
        $this->setTemplate('admin/install');

        $this->input = $_REQUEST;

        $this->validation->setRules('db_hostname', 'Hostname', 'required');
        $this->validation->setRules('db_username', 'Username', 'required');
        $this->validation->setRules('db_password', 'Password', 'required');
        $this->validation->setRules('db_database', 'Database', 'required');

        $this->validation->setRules('email', 'Email', 'required|valid_email');
        $this->validation->setRules('password', 'Password', 'required|matches[passwordconf]');

        if (!$this->validation->validate()) {
            if (!empty($this->input)) {
                $install = $this->input;
                $this->set('install', $install);
                $this->set('errors', $this->validation->getErrors());
            }
        } else {

            //check the database details
            $db_config = array(
                'host' => $this->input['db_hostname'],
                'user' => $this->input['db_username'],
                'password' => $this->input['db_password'],
                'database' => $this->input['db_database']
              );

            //try to connect
            $ptyxisMySQL = new PtyxisMySQL();
            try {
                $ptyxisMySQL->connect($db_config);
            } catch(Exception $e) {
                $errors[] = array('label' => 'Error', 'error' => 'Could not connect using database details provided');
                $this->set('errors', $errors);
            }

            //database details worked
            if (empty($errors)) {
                //write the config
                $configContents = '<?php' . "\n";

                //database
                $configContents .= '$db_config = ' . var_export( $db_config, True ). ";\n\n";

                //base_url
                //salt
                $this->salt = uniqid(mt_rand(), true);
                $kc_config =  array(
                        'base_url' => $this->baseUrl,
                        'salt' => $this->salt
                );

                $configContents .= '$kc_config = ' . var_export( $kc_config, True ). ";";

                //write the config
                try {
                    file_put_contents('app/config/config.php', $configContents);
                } catch (Exception $e) {
                    $this->set('configContents', $configContents);
                }

                //lets check it isn't already installed
                //get version setting
                $installed = false;
                $version = $ptyxisMySQL->query("SELECT * FROM setting WHERE name = 'version' " );
                if (!empty($version[0]['value'])) {
                    $installed =  True;
                }

                if (!$installed) {
                    $ptyxisMySQL->connect($db_config);
                    //run install script
                    $installScript = $this->getInstallScript();

                    if (!$ptyxisMySQL->multiQuery($installScript)) {
                        $errors[] = array('label' => 'Error', 'error' => 'Install script failed.');
                        $this->set('errors', $errors);
                    }
                }

                //if already installed we need a new user cause we have a new salt
                if ($installed) {
                    $ptyxisMySQL->connect($db_config);
                    $ptyxisMySQL->query('DELETE FROM user');
                }

                //add the user to the database
                $user = array();
                $user['email']      = $this->input['email'];
                $user['password']   = $this->hash_password($this->input['password']);

                $ptyxisMySQL->connect($db_config);
                $user_result = $ptyxisMySQL->queryPrepared('INSERT INTO user (email,password) VALUES(?,?)',
                                                          'ss', array($user['email'], $user['password']));

                if (!$user_result) {

                    $errors[] = array('label' => 'Error', 'error' => 'Adding user failed.');
                    $this->set('errors', $errors);
                } else {
                    $this->set('install_success', True);
                }

            }

        }

        return $this->data;

    }

    protected function getInstallScript()
    {

        $installScript =
        "-- user
        CREATE TABLE IF NOT EXISTS `user` (
          `id` int(100) NOT NULL AUTO_INCREMENT,
          `email` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `token` varchar(255) DEFAULT NULL,
          `active` tinyint(1) NOT NULL DEFAULT '1',
          PRIMARY KEY (`id`),
          UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100000;

        -- chapter
        CREATE TABLE IF NOT EXISTS `chapter` (
          `id` int(100) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100000;

        -- comic
        CREATE TABLE IF NOT EXISTS `comic` (
          `id` int(100) NOT NULL AUTO_INCREMENT,
          `chapter_id` int(100) default NULL,
          `number` int(100) NOT NULL,
          `date` date NOT NULL,
          `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
          `comment` text COLLATE utf8_unicode_ci NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `title` (`title`),
          UNIQUE KEY `slug` (`slug`),
          UNIQUE KEY `number` (`number`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100000;

        -- setting
        CREATE TABLE IF NOT EXISTS `setting` (
          `id` int(100) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL,
          `value` TEXT default NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100000;

        -- insert settings
        INSERT INTO setting (name,value) VALUES('version','0.1.0');
        INSERT INTO setting (name,value) VALUES('comic_title','My webcomic');
        INSERT INTO setting (name,value) VALUES('comic_description','My webcomic about a person who..');
        INSERT INTO setting (name,value) VALUES('seo_urls','1');
        INSERT INTO setting (name,value) VALUES('creator_name','S Smith');
        INSERT INTO setting (name,value) VALUES('creator_about','');
        INSERT INTO setting (name,value) VALUES('google_analytics','');
        INSERT INTO setting (name,value) VALUES('comment_code','');
        INSERT INTO setting (name,value) VALUES('twitter','');
        INSERT INTO setting (name,value) VALUES('facebook','');
        INSERT INTO setting (name,value) VALUES('theme','default');

        INSERT INTO setting (name,value) VALUES('comic_content_right','');
        INSERT INTO setting (name,value) VALUES('comic_content_left','');
        INSERT INTO setting (name,value) VALUES('comic_content_top','');
        INSERT INTO setting (name,value) VALUES('comic_content_bottom','');";

        return $installScript;
    }
}
