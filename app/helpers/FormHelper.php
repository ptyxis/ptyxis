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

class FormHelper {

    public function setValue($field, $default='')
    {
        if (!empty($_REQUEST[$field])) {
            echo $_REQUEST[$field];
        } else {
            echo $default;
        }
    }

    public function showErrors($errors)
    {
        ?>
        <?php if (!empty($errors)):?>
            <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error):?>
                <p><?php echo $error['label'];?> <?php echo $error['error'];?></p>
            <?php endforeach;?>
            </div>
        <?php endif;?>
        <?php
    }

}
