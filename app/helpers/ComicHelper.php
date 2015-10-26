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

class ComicHelper {

    public function getComicImage($comicId)
    {

        $comicImage = 'strips/'.$comicId.'.jpg';
        if (file_exists($comicImage)) {
            return $comicImage;
        }

        $comicImage = 'strips/'.$comicId.'.jpeg';
        if (file_exists($comicImage)) {
            return $comicImage;
        }

        $comicImage = 'strips/'.$comicId.'.png';
        if (file_exists($comicImage)) {
            return $comicImage;
        }

        $comicImage = 'strips/'.$comicId.'.gif';
        if (file_exists($comicImage)) {
            return $comicImage;
        }
    }

    public function getLogo()
    {

        $logoImage = 'images/logo.png';
        if (file_exists($logoImage)) {
            return $logoImage;
        } else {
            return false;
        }

    }

    // public function getComicLink($data,$name)
    // {
    //
    //     if ($data['comic_settings']['seo_urls']) {
    //         if (!empty($data[$name]['slug'])) {
    //             return $data['base_url'].'comic/'.$data[$name]['slug'];
    //         } else {
    //             return "#";
    //         }
    //     } else {
    //         if (!empty($data[$name]['number'])) {
    //             return $data['base_url'].'comic/'.$data[$name]['number'];
    //         } else {
    //             return "#";
    //         }
    //     }
    //
    //
    // }

    public function getComicLink($data, $comic)
    {

        if ($data['comic_settings']['seo_urls']) {
            if (!empty($comic['slug'])) {
                return $data['base_url'].'comic/'.$comic['slug'];
            } else {
                return "#";
            }
        } else {
            if (!empty($comic['number'])) {
                return $data['base_url'].'comic/'.$comic['number'];
            } else {
                return "#";
            }
        }


    }

    public function getContentColSizes($data)
    {

        $cols = array();

        $left   = $data['comic_settings']['comic_content_left'];
        $right  = $data['comic_settings']['comic_content_right'];

        if (!empty($left) && !empty($right)) {
            $cols = array(
                            'left' => '3',
                            'center' => '6',
                            'right' => '3'
                            );
        }

        if (empty($left) && !empty($right)) {
            $cols = array(
                            'left' => False,
                            'center' => '9',
                            'right' => '3'
                            );
        }

        if (!empty($left) && empty($right)) {
            $cols = array(
                            'left' => '3',
                            'center' => '9',
                            'right' => False
                            );
        }

        if (empty($left) && empty($right)) {
            $cols = array(
                            'left' => False,
                            'center' => '8 col-sm-offset-2',
                            'right' => False
                            );
        }

        return $cols;

    }

}
