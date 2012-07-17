<?php

class Ext_Act_News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ext_Mnews');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('mmaster');
        $this->load->model('mglobal');
    }

    ########################################################################
    ########################################################################

    public function getByCreatedById_json($id) {
        if (isset($id)) {
            $data = $this->Ext_Mnews->selectByCreatedById($id);
            for ($i = 0; $i < sizeof($data); $i++) {
                $data[$i]->actions = "<a id=\"dialog_link\" href=\"" . base_url("index.php/master/news/update/".$data[$i]->news_id) . "\">Update</a>";
            }
            echo json_encode($data);
        }
    }

}