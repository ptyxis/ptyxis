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

class ComicController extends BaseController
{

    private $comicModel;
    private $chapterModel;

    function ComicController()
    {
        parent::__construct();
        $this->comicModel = new ComicModel();
        $this->chapterModel = new ChapterModel();
    }

    public function view($slug = null)
    {

        $this->setLayout('theme/'.$this->theme.'/public');
        $this->setTemplate('comic/view');

        if (!empty($slug)) {
            if ($this->settings['seo_urls']) {
                $comic = $this->comicModel->getBySlug($slug);
            } else {
                $comic = $this->comicModel->getByNumber($slug);
            }

            $latest_comic = $this->comicModel->getLatest();

        } else {
            $comic = $this->comicModel->getLatest();
            $latest_comic = $comic;
        }

        $first_comic = $this->comicModel->getFirst();
        $next_comic = $this->comicModel->getNext($comic['number']);
        $prev_comic = $this->comicModel->getPrevious($comic['number']);
        $this->set('first_comic', $first_comic);
        $this->set('next_comic', $next_comic);
        $this->set('prev_comic', $prev_comic);
        $this->set('latest_comic', $latest_comic);
        $this->set('comic', $comic);

        //set the meta information
        $meta = array();
        $meta['title']          = $this->settings['comic_title'].' - #'.$comic['number'].' '.$comic['title'];
        $meta['description']    = $this->settings['comic_description'];

        $this->set('meta', $meta);

        return $this->data;
    }

    public function feed()
    {
        $this->setLayout('theme/'.$this->theme.'/blank');
        $this->setTemplate('comic/rss');

        $comics = $this->comicModel->getLatestByNumber(20);

        if (!empty($comics)) {
            $items = array();

            foreach ($comics as $comic) {
                $items[] = array(
                    'title' => $comic['title'],
                    'link' => $comic['slug'],
                    'description' => $comic['comment'],
                    'author' => $this->settings['creator_name'],
                    'pubDate' => date('D, d M y H:i:s O', strtotime($comic['date'])),
                    'guid' => $comic['slug']
                );
            }

            $header = array(
                            'title' => $this->settings['comic_title'],
                            'link' => $this->baseUrl(),
                            'description' => $this->settings['comic_description'],
                            'language' => 'en-us',
                            'copyright' => 'Copyright (c) ' . $this->settings['creator_name'],
                            'lastBuildDate' => date('D, d M y H:i:s O', strtotime($comics[0]['date']))
                            );


            //create the RSS feed xml
            $ptyxisRSS = new PtyxisRSS();

            $ptyxisRSS->header($header);

            foreach ($items as $item) {
                $ptyxisRSS->addItem($item);
            }

            $rss = $ptyxisRSS->getRSS();
        } else {
            $rss = '';
        }

        $this->set('rss', $rss);

        return $this->data;
    }

    public function about()
    {
        $this->setLayout('theme/'.$this->theme.'/public');
        $this->setTemplate('comic/about');

        //set the meta information
        $meta = array();
        $meta['title']          = $this->settings['comic_title'].' - About';
        $meta['description']    = $this->settings['comic_description'];

        $this->set('meta', $meta);

        return $this->data;
    }

    public function archive()
    {

        $this->setLayout('theme/'.$this->theme.'/public');
        $this->setTemplate('comic/archive');

        $comics = $this->comicModel->archives();
        $this->set('comics', $comics);

        //set the meta information
        $meta = array();
        $meta['title']          = $this->settings['comic_title'].' - Archive';
        $meta['description']    = $this->settings['comic_description'];

        $this->set('meta', $meta);

        return $this->data;
    }

    public function comics()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('comic/index');

        $this->input = $_REQUEST;

        $comics = $this->comicModel->getAll();
        $this->set('comics', $comics);

        return $this->data;
    }

    public function add()
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('comic/new');

        //get the chapters
        $chapters = $this->chapterModel->getAll();
        $this->set('chapters', $chapters);

        $number = $this->comicModel->getNextNumber();
        $this->set('number', $number);

        $this->input = $_REQUEST;

        $this->validation->setRules('chapter_id', 'Name', 'optional|numeric');
        $this->validation->setRules('number', 'Number', 'required|numeric|check_unique['.$this->checkUnique('number').']');
        $this->validation->setRules('title', 'Title', 'required|check_unique['.$this->checkUnique('title').']');
        $this->validation->setRules('slug', 'Slug', 'required|slug|check_unique['.$this->checkUnique('slug').']');
        $this->validation->setRules('date', 'Date', 'required|valid_date[m/d/Y]');
        $this->validation->setRules('comment', 'Comment', 'optional|required');

        if (!$this->validation->validate()) {

            if (!empty($this->input)) {
                $comic = $this->input;
                $this->set('comic', $comic);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $comic = array();
            $comic['title']     = trim($this->input['title']);
            $comic['slug']      = $this->input['slug'];
            $comic['number']    = $this->input['number'];
            $comic['date']      = date('Y-m-d', strtotime($this->input['date']));
            $comic['comment']   = $this->input['comment'];

            if (!empty( $this->input['chapter_id'])) {
                $comic['chapter_id'] = trim($this->input['chapter_id']);
            } else {
                $comic['chapter_id'] = 0;
            }

            $comic['id'] = $this->comicModel->save($comic);

            if ($comic['id']) {

                //do file upload
                $upload_config['upload_dir']    = 'strips';
                $upload_config['max_size']      = '3000000';
                $upload_config['allowed_types'] = array(
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif'
                                                        );

                $ptyxisUpload = new PtyxisUpload($upload_config);

                $errors = $ptyxisUpload->uploadImage('comic_image', $comic['id']);

                if (!empty($errors)) {
                    $this->set('comic', $comic);
                    $this->set('errors', $errors);
                } else {
                    $this->session->flashRedirect('Comic saved successfully', $this->baseUrl().'comics/edit/'.$comic['id']);
                }

            } else {
                $comic = $this->input;
                $this->set('comic', $comic);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save comic');
                $this->set('errors', $errors);
            }

        }

        return $this->data;
    }

    public function edit($id=null)
    {

        $this->checkLogon();

        $this->setLayout('admin/admin');
        $this->setTemplate('comic/edit');

        //get the chapters
        $chapters = $this->chapterModel->getAll();
        $this->set('chapters', $chapters);

        $this->input = $_REQUEST;

        $id = (!empty($id) ? $id : (!empty($this->input['id']) ? $this->input['id'] : ''));

        $this->validation->setRules('id', 'Id', 'numeric');
        $this->validation->setRules('chapter_id', 'Name', 'optional|numeric');
        $this->validation->setRules('number', 'Number', 'required|numeric|check_unique['.$this->checkUnique('number', $id).']');
        $this->validation->setRules('title', 'Title', 'required|check_unique['.$this->checkUnique('title', $id).']');
        $this->validation->setRules('slug', 'Slug', 'required|slug|check_unique['.$this->checkUnique('slug', $id).']');
        $this->validation->setRules('date', 'Date', 'required|valid_date[m/d/Y]');
        $this->validation->setRules('comment', 'Comment', 'optional|required');

        if (!$this->validation->validate()) {

            if (empty($this->input)) {
                $comic = $this->comicModel->get($id);
                $this->set('comic', $comic);
            } else {
                $comic = $this->input;
                $this->set('comic', $comic);
                $this->set('errors', $this->validation->getErrors());
            }

        } else {
            $comic = array();
            $comic['id']        = $this->input['id'];
            $comic['slug']      = $this->input['slug'];
            $comic['number']    = $this->input['number'];
            $comic['date']      = date('Y-m-d', strtotime($this->input['date']));
            $comic['comment']   = $this->input['comment'];

            if (!empty( $this->input['chapter_id'])) {
                $comic['chapter_id']      = trim($this->input['chapter_id']);
            } else {
                $comic['chapter_id'] = 0;
            }

            $comic['title']      = trim($this->input['title']);
            if ($this->comicModel->update($comic)) {

                //do file upload
                $upload_config['upload_dir']    = 'strips';
                $upload_config['max_size']      = '3000000';
                $upload_config['allowed_types'] = array(
                                                        'jpg',
                                                        'jpeg',
                                                        'png',
                                                        'gif'
                                                        );

                $ptyxisUpload = new PtyxisUpload($upload_config);

                $errors = $ptyxisUpload->uploadImage('comic_image', $comic['id']);

                if (!empty($errors)) {
                    $this->set('comic', $comic);
                    $this->set('errors', $errors);
                } else {

                    //delete any extra comic images
                    $detectedType = pathinfo($_FILES['comic_image']['name'], PATHINFO_EXTENSION);
                    if(!empty($detectedType)) {
                        $this->deleteComicImage($comic['id'], $detectedType);
                    }

                    $this->session->flashRedirect('Comic saved successfully', $this->baseUrl().'comics/edit/'.$comic['id']);
                }

            } else {
                $comic = $this->input;
                $this->set('comic', $comic);
                $errors[] = array('label' => 'Error', 'error' => 'Unable to save comic');
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
            if ($this->comicModel->delete($this->input['id'])) {
                $this->session->flashRedirect('Comic deleted successfully', $this->baseUrl().'comics');
            } else {
                $this->session->flashRedirect('Unable to delete comic', $this->baseUrl().'comics', 'danger');
            }
        }

        return $this->data;
    }

    private function deleteComicImage($comicId, $exludeExt)
    {

        $comicImage = 'strips/'.$comicId.'.jpg';
        if (file_exists($comicImage) && $exludeExt != 'jpg') {
            unlink($comicImage);
        }

        $comicImage = 'strips/'.$comicId.'.jpeg';
        if (file_exists($comicImage) && $exludeExt != 'jpeg') {
            unlink($comicImage);
        }

        $comicImage = 'strips/'.$comicId.'.png';
        if (file_exists($comicImage) && $exludeExt != 'png') {
            unlink($comicImage);
        }

        $comicImage = 'strips/'.$comicId.'.gif';
        if (file_exists($comicImage) && $exludeExt != 'gif') {
            unlink($comicImage);
        }

    }

    private function checkUnique($field, $id = null)
    {
        if (!empty($_REQUEST[$field])) {
            $value = $_REQUEST[$field];
            return $this->comicModel->checkUnique($field, $value, $id);
        } else {
            return 'notunique';
        }
    }

}
