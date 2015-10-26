<?php
/***************************************
PtyxisSessions
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

class PtyxisSessions {

    public function start()
    {
        session_cache_limiter(false);
        session_start();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        if (!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return False;
        }
    }

    public function destroy()
    {
        session_destroy();
    }

    public function setFlash($msg, $type='success')
    {
        $this->set('flash_message',$msg);
        $this->set('flash_type',$type);
    }

    public function redirect($url)
    {
        header("Location: " . $url);
        die();
    }

    public function flashRedirect($msg, $url, $type='success')
    {
        $this->setFlash($msg, $type);
        $this->redirect($url);
    }

    public function getFlashMessage()
    {
        return $this->get('flash_message');
    }

}
