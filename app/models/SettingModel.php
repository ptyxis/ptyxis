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

class SettingModel extends BaseModel {

    public function updateAll($settings)
    {

        $finalResult = True;
        if (!empty($settings)) {
            foreach ( $settings as $name => $value ) {
                $formated_setting = array();
                $formated_setting['name'] = $name;
                $formated_setting['value'] = $value;

                $result = $this->update($formated_setting);

                if (!$result) {
                    $finalResult = False;
                }
            }
        } else {
            $finalResult = False;
        }

        return $finalResult;
    }

    public function update($setting)
    {
        $result = $this->db->queryPrepared('UPDATE setting SET name = ?, value = ? WHERE name = ?',
        'sss', array($setting['name'], $setting['value'], $setting['name']));

        return $result;
    }

    public function get($id)
    {
        $setting = $this->db->queryPrepared('SELECT * FROM setting WHERE id = ? LIMIT 1', 'i', array($id));
        return $setting[0];
    }

    public function getAll()
    {
        $raw_settings = $this->db->query('SELECT * FROM setting');

        $settings = array();
        foreach ($raw_settings as $setting) {
            $settings[$setting['name']] = $setting['value'];
        }

        return $settings;
    }

}
