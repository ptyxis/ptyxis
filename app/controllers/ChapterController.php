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

class ChapterController extends BaseController
{

    private $chapterModel;

    function ChapterController()
    {
        parent::__construct();
        $this->chapterModel = new ChapterModel();
    }

    public function chapters()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('chapter/index');

        $this->input = $_REQUEST;

        $chapters = $this->chapterModel->getAll();
        $this->set('chapters', $chapters);

        return $this->data;
    }

    public function add()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('chapter/new');

        $this->input = $_REQUEST;

        $this->validation->setRules('name', 'Name', 'required|check_unique['.$this->checkUnique('name').']');

        if (!$this->validation->validate()) {

            if (!empty($this->input)) {
                $chapter = $this->input;
                $this->set('chapter', $chapter);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $chapter = array();
            $chapter['name']      = trim($this->input['name']);
            if ($this->chapterModel->save($chapter)) {
                $this->session->flashRedirect('Chapter saved successfully', $this->baseUrl().'chapters');
            } else {
                $chapter = $this->input;
                $this->set('chapter', $chapter);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save chapter');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

    public function edit($id=null)
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('chapter/edit');

        $this->input = $_REQUEST;

        $id = (!empty($id) ? $id : (!empty($this->input['id']) ? $this->input['id'] : ''));

        $this->validation->setRules('id', 'Id', 'numeric');
        $this->validation->setRules('name', 'Name', 'required|check_unique['.$this->checkUnique('name', $id).']');

        if (!$this->validation->validate()) {

            if (empty($this->input)) {
                $chapter = $this->chapterModel->get($id);
                $this->set('chapter', $chapter);
            } else {
                $chapter = $this->input;
                $this->set('chapter', $chapter);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $chapter = array();
            $chapter['id']        = $this->input['id'];
            $chapter['name']      = trim($this->input['name']);

            if ($this->chapterModel->update($chapter)) {
                $this->session->flashRedirect('Chapter saved successfully', $this->baseUrl().'chapters');
            } else {
                $chapter = $this->input;
                $this->set('chapter', $chapter);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save chapter');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

    public function delete()
    {

        $this->checkLogon();

        $this->input = $_REQUEST;

        if (!empty($this->input['id'])) {
            if ($this->chapterModel->delete($this->input['id'])) {
                $this->session->flashRedirect('Chapter deleted successfully', $this->baseUrl().'chapters');
            } else {
                $this->session->flashRedirect('Unable to delete chapter', $this->baseUrl().'chapters', 'danger');
            }
        }

        return $this->data;
    }

    private function checkUnique($field, $id = null)
    {
        if (!empty($_REQUEST[$field])) {
            $value = $_REQUEST[$field];
            return $this->chapterModel->checkUnique($field, $value, $id);
        } else {
            return 'notunique';
        }
    }

}
