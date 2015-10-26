<?php
/***************************************
PtyxisMySQL
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

class PtyxisMySQL {

  private $mysqli;
  private $host;
  private $user;
  private $password;
  private $database;

    public function connect($config)
    {

        $this->host     = $config['host'];
        $this->user     = $config['user'];
        $this->password = $config['password'];
        $this->database = $config['database'];

        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->mysqli->connect_errno) {
            return False;
        } else {
            return True;
        }
    }

    public function query($query)
    {
        $results = array();

        if ($result = $this->mysqli->query($query)) {
            if (gettype($result) == 'object') {
                if (get_class($result) == 'mysqli_result') {
                    /* fetch associative array */
                    while ($row = $result->fetch_assoc()) {
                        $results[] = $row;
                    }
                    /* free result set */
                    $result->free();
                    return $results;
                }
            } else {
                return $result;
            }
        } else {
            return $result;
        }


    }

    public function multiQuery($query)
    {
        $result = $this->mysqli->multi_query($query);
        return $result;
    }

    public function queryPrepared($query, $type, $params)
    {

        $results = array();

        if (!$stmt = $this->mysqli->prepare($query)) {
            return False;
        }

        call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $this->makeValuesReferenced($params)));
        $query_result = $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            $stmt->close();
            return $query_result;
        } else {
            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            /* free result set */
            $result->free();

            return $results;
        }

    }

    public function getResults()
    {

        $results = array();

        if ($result = $this->mysqli->query($query)) {

            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            /* free result set */
            $result->free();

            return $results;
        }
    }

    public function insertId()
    {
        return $this->mysqli->insert_id;
    }

    public function makeValuesReferenced(&$arr){
        $refs = array();
        foreach ($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }

    public function close()
    {
        $this->mysqli->close();
    }

}
