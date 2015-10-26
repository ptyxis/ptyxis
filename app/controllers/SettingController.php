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

class SettingController extends BaseController  {

    public function settings()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('setting/settings');

        $themes = $this->getThemes();
        $this->set('themes', $themes);

        $this->input = $_REQUEST;

        $this->validation->setRules('theme', 'Comic Theme', 'required|max_length[255]');
        $this->validation->setRules('comic_title', 'Comic Title', 'required|max_length[255]');
        $this->validation->setRules('comic_description', 'Comic Description', 'required');
        $this->validation->setRules('creator_name', 'Creator name', 'required');
        $this->validation->setRules('creator_about', 'About the creator', 'required');
        $this->validation->setRules('seo_urls', 'SEO Urls', 'optional|numeric');
        $this->validation->setRules('google_analytics', 'Google Analytics', 'optional');
        $this->validation->setRules('comment_code', 'Comment Code', 'optional');
        $this->validation->setRules('twitter', 'Twitter', 'optional');
        $this->validation->setRules('facebook', 'Facebook', 'optional');

        if (!$this->validation->validate()) {

            if (empty($this->input)) {
                $settings = $this->settingModel->getAll();
                $this->set('settings', $settings);
            } else {
                $settings = $this->input;
                $this->set('settings', $settings);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $settings = array();
            $settings['theme']               = $this->input['theme'];
            $settings['comic_title']         = trim($this->input['comic_title']);
            $settings['comic_description']   = $this->input['comic_description'];
            $settings['creator_name']        = $this->input['creator_name'];
            $settings['creator_about']       = $this->input['creator_about'];
            $settings['seo_urls']            = $this->input['seo_urls'];
            $settings['comment_code']        = $this->input['comment_code'];
            $settings['google_analytics']    = $this->input['google_analytics'];
            $settings['twitter']             = $this->input['twitter'];
            $settings['facebook']            = $this->input['facebook'];

            if ($this->settingModel->updateAll($settings)) {
                $this->session->flashRedirect('Settings saved successfully', $this->baseUrl().'dashboard');
            } else {
                $setting = $this->input;
                $this->set('setting', $setting);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save settings');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

    protected function getThemes()
    {
        $rawDirs = array_filter(glob('app/templates/theme/*'), 'is_dir');
        $dirs = array();

        foreach ($rawDirs as $dir) {
            $dirs[] = basename($dir);
        }

        return $dirs;
    }

    public function theme()
    {
        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('setting/theme');

        $this->input = $_REQUEST;

        if (!empty($this->input['upload'])) {

            //do file upload
            $upload_config['upload_dir']    = 'images';
            $upload_config['max_size']      = '1000000';
            $upload_config['allowed_types'] = array('png');

            $ptyxisUpload = new PtyxisUpload($upload_config);

            $logo_errors = $ptyxisUpload->uploadImage('logo', 'logo');

            $upload_config['upload_dir']    = 'images';
            $upload_config['max_size']      = '1000000';
            $upload_config['allowed_types'] = array('png');

            $ptyxisUpload = new PtyxisUpload($upload_config);

            $bg_errors = $ptyxisUpload->uploadImage('background', 'background');

            $errors = array_merge($logo_errors,$bg_errors);

            if (!empty($errors)) {
                $this->set('errors', $errors);
            } else {
                $this->session->flashRedirect('Upload successful', $this->baseUrl().'dashboard');
            }

        }

        return $this->data;
    }

    public function content()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('setting/content');

        $this->input = $_REQUEST;

        $this->validation->setRules('comic_content_left', 'Content Left', 'optional');
        $this->validation->setRules('comic_content_right', 'Content Right', 'optional');
        $this->validation->setRules('comic_content_top', 'Content Top', 'optional');
        $this->validation->setRules('comic_content_bottom', 'Content Bottom', 'optional');

        if (!$this->validation->validate() || empty($this->input)) {

            if (empty($this->input)) {
                $settings = $this->settingModel->getAll();
                $this->set('settings', $settings);
            } else {
                $settings = $this->input;
                $this->set('settings', $settings);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $settings = array();
            $settings['comic_content_left']      = $this->input['comic_content_left'];
            $settings['comic_content_right']     = $this->input['comic_content_right'];
            $settings['comic_content_top']       = $this->input['comic_content_top'];
            $settings['comic_content_bottom']    = $this->input['comic_content_bottom'];

            if ($this->settingModel->updateAll($settings)) {
                $this->session->flashRedirect('Content saved successfully', $this->baseUrl().'dashboard');
            } else {
                $setting = $this->input;
                $this->set('setting', $setting);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save content');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

}
