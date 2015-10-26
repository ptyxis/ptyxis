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

class ComicModel extends BaseModel {

    public function archives()
    {
        $comics = $this->db->query("select comic.*, chapter.id as chapter_id, chapter.name as chapter_name from comic LEFT JOIN chapter ON comic.chapter_id = chapter.id WHERE date <= '" .date('Y-m-d') . "' ORDER BY number DESC");
        return $comics;
    }

    public function getAll()
    {
        $comics = $this->db->query('SELECT * FROM comic ORDER BY number ASC');
        return $comics;
    }

    public function getFirst()
    {
        $comic = $this->db->query("SELECT * FROM comic WHERE date <= '" .date('Y-m-d') . "' ORDER BY number ASC LIMIT 1");
        return $this->returnFirst($comic);
    }

    public function getLatestByNumber($number)
    {
        $comics = $this->db->query("SELECT * FROM comic WHERE date <= '" .date('Y-m-d') . "' ORDER BY number DESC LIMIT " . $number);
        return $comics;
    }

    public function getLatest()
    {
        $comic = $this->db->query("SELECT * FROM comic WHERE date <= '" .date('Y-m-d') . "' ORDER BY number DESC LIMIT 1");
        return $this->returnFirst($comic);
    }

    public function getNext($comicNumber)
    {
        $comic = $this->db->query("SELECT * FROM comic WHERE number > '" . $comicNumber . "' AND date <= '" .date('Y-m-d') . "' ORDER BY number ASC LIMIT 1");
        return $this->returnFirst($comic);
    }

    public function getPrevious($comicNumber)
    {
        $comic = $this->db->query("SELECT * FROM comic WHERE number < '" . $comicNumber . "' AND date <= '" .date('Y-m-d') . "' ORDER BY number DESC LIMIT 1");
        return $this->returnFirst($comic);
    }

    public function save($comic)
    {
        $result = $this->db->queryPrepared('INSERT INTO comic
        (chapter_id,title,slug,number,date,comment)
        VALUES(?,?,?,?,?,?)',
        'ississ', array(
                        $comic['chapter_id'],
                        $comic['title'],
                        $comic['slug'],
                        $comic['number'],
                        $comic['date'],
                        $comic['comment']
                        ));


        if(!empty($result)) {
            return $this->db->insertId();
        } else {
            return False;
        }
    }

    public function update($comic)
    {
        $result = $this->db->queryPrepared('UPDATE comic SET
        chapter_id = ?, title = ?, slug = ?, number = ?, date = ?, comment = ? WHERE id = ?',
        'ississi', array(
                    $comic['chapter_id'],
                    $comic['title'],
                    $comic['slug'],
                    $comic['number'],
                    $comic['date'],
                    $comic['comment'],
                    $comic['id']
                    ));

        return $result;
    }

    public function get($id)
    {
        $comic = $this->db->queryPrepared('SELECT * FROM comic WHERE id = ? LIMIT 1', 'i', array($id));
        return $this->returnFirst($comic);
    }

    public function getBySlug($slug)
    {
        $comic = $this->db->queryPrepared('SELECT * FROM comic WHERE slug = ? LIMIT 1', 's', array($slug));
        return $this->returnFirst($comic);
    }

    public function getByNumber($number)
    {
        $comic = $this->db->queryPrepared('SELECT * FROM comic WHERE number = ? LIMIT 1', 's', array($number));
        return $this->returnFirst($comic);
    }

    public function delete($id)
    {
        $result = $this->db->queryPrepared('DELETE FROM comic WHERE id = ?', 'i', array($id));
        return $result;
    }

    public function getNextNumber()
    {
        $result = $this->db->query('SELECT COUNT(id) as next_number FROM comic');
        $next_number = $result[0]['next_number'];
        $next_number++;
        return $next_number;
    }

    public function checkUnique($field, $value, $id = null)
    {
        $fields = array('title','slug','number');
        if (in_array($field, $fields)) {
            if (!empty($id)) {
                $result = $this->db->queryPrepared('SELECT * FROM comic WHERE ' .$field. ' = ? AND id != ? LIMIT 1', 'si', array($value, $id));
            } else {
                $result = $this->db->queryPrepared('SELECT * FROM comic WHERE ' .$field. ' = ? LIMIT 1', 's', array($value));
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
