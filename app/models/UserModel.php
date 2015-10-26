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

class UserModel extends BaseModel {

    public function logon($user)
    {
        $user = $this->db->queryPrepared('SELECT * FROM user WHERE email = ? AND password = ? LIMIT 1',
        'ss', array($user['email'], $user['password']));

        if (!empty($user)) {
            //return the user
            return $this->returnFirst($user);
        } else {
            return False;
        }
    }

    public function save($user)
    {
        $result = $this->db->queryPrepared('INSERT INTO user (email,password) VALUES(?,?)',
        'ss', array($user['email'], $user['password']));

        if (!empty($result)) {
            return $this->db->insertId();
        } else {
            return False;
        }
    }

    public function update($user)
    {
        $result = $this->db->queryPrepared('UPDATE user SET email = ? WHERE id = ?',
        'si', array($user['email'], $user['id']));

        return $result;
    }

    public function updatePassword($user)
    {
        $result = $this->db->queryPrepared('UPDATE user SET password = ? WHERE id = ?',
        'si', array($user['password'], $user['id']));

        return $result;
    }

    public function getUserByEmail($email)
    {
        $user = $this->db->queryPrepared('SELECT * FROM user WHERE email = ? LIMIT 1', 's', array($email));
        return $this->returnFirst($user);
    }

    public function newPasswordResetToken($id)
    {

        $token = $this->getToken();

        $result = $this->db->queryPrepared('UPDATE user SET token = ? WHERE id = ?',
        'si', array($token, $id));

        return $token;
    }

    public function resetUser($id, $token)
    {
        $user = $this->db->queryPrepared('SELECT * FROM user WHERE id = ? AND token = ? LIMIT 1', 'is', array($id, $token));
        return $this->returnFirst($user);
    }

    public function get($id)
    {
        $user = $this->db->queryPrepared('SELECT * FROM user WHERE id = ? LIMIT 1', 'i', array($id));
        return $this->returnFirst($user);
    }

}
