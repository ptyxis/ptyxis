<?php
/***************************************
PtyxisUpload
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

class PtyxisUpload {

    protected $upload_config;

    function PtyxisUpload($upload_config)
    {
        $this->upload_config = $upload_config;
    }

    public function uploadImage($uploadFile,$targetName)
    {
        $errors = array();

        //check the file has been uploaded
        if (!empty($_FILES[$uploadFile]['tmp_name'])) {

            $targetDir = $this->upload_config['upload_dir'];
            $targetFile = $targetDir . '/'. $targetName;

            //check type
            $detectedType = pathinfo($_FILES[$uploadFile]['name'], PATHINFO_EXTENSION);
            if (!in_array($detectedType,$this->upload_config['allowed_types'])) {
                $errors[] = array('label' => $uploadFile, 'error' => 'Unsupported image type.');
            }

            //check file dimensions
            // $imageDimensions = getimagesize($_FILES[$uploadFile]['tmp_name']);
            // var_dump( $imageDimensions );

            $imageSize = filesize($_FILES[$uploadFile]['tmp_name']);
            if ($imageSize > $this->upload_config['max_size']) {
                $max_size = $this->upload_config['max_size'] / 1000;
                $errors[] = array('label' => $uploadFile, 'error' => 'File must be under '.$max_size.'kb.');
            }

            if (empty($errors)) {
                if (!move_uploaded_file($_FILES[$uploadFile]['tmp_name'], $targetFile.'.'.$detectedType)) {
                    $errors[] = array('label' => $uploadFile, 'error' => 'File could not be uploaded.');
                }
            }

        }

        return $errors;
    }

}
