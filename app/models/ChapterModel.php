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

class ChapterModel extends BaseModel {

    public function getAll()
    {
        $chapters = $this->db->query('SELECT * FROM chapter');
        return $chapters;
    }

    public function save($chapter)
    {
        $result = $this->db->queryPrepared('INSERT INTO chapter (name) VALUES(?)',
        's', array($chapter['name']));

        if (!empty($result)) {
            return $this->db->insertId();
        } else {
            return False;
        }
    }

    public function update($chapter)
    {
        $result = $this->db->queryPrepared('UPDATE chapter SET name = ? WHERE id = ?',
        'si', array($chapter['name'], $chapter['id']));

        return $result;
    }

    public function get($id)
    {
        $chapter = $this->db->queryPrepared('SELECT * FROM chapter WHERE id = ? LIMIT 1', 'i', array($id));
        return $chapter[0];
    }

    public function delete($id)
    {
        $result = $this->db->queryPrepared('DELETE FROM chapter WHERE id = ?', 'i', array($id));
        return $result;
    }

    public function checkUnique($field, $value, $id = null)
    {
        $fields = array('name');
        if (in_array($field, $fields)) {
            if (!empty($id)) {
                $result = $this->db->queryPrepared('SELECT * FROM chapter WHERE ' .$field. ' = ? AND id != ? LIMIT 1', 'si', array($value, $id));
            } else {
                $result = $this->db->queryPrepared('SELECT * FROM chapter WHERE ' .$field. ' = ? LIMIT 1', 's', array($value));
            }

            $comic = $this->returnFirst($result);

            if ($comic[$field] == $value) {
                return 'notunique';
            } else {
                return 'unique';
            }

            return $comic[$field];
        } else {
            return 'notunique';
        }
    }

}
