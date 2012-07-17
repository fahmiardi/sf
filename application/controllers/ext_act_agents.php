<?php

class Ext_Act_Agents extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ext_Magents');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('mmaster');
        $this->load->model('mglobal');
    }

    ########################################################################
    ########################################################################

    public function getById($id) {
        if (isset($id))
            echo json_encode($this->mmaster->getAgents($id));
    }

    public function read() {
        echo json_encode($this->mmaster->getAgents());
    }

    public function delete($id = null) {
        if (is_null($id)) {
            echo 'ERROR: Id not provided.';
            return;
        }
        $this->mmaster->deleteAgents($id);
        echo 'Records deleted successfully';
    }

    ########################################################################
    ########################################################################

    public function getStatusAgentsByIdJson($userId, $status) {
        $data = $this->Ext_Magents->selectStatusAgentsById($userId, $status);
        for ($i = 0; $i < sizeof($data); $i++) {
            if ($status == 0) {
                $data[$i]->actions = "<a id=\"dialog_link\" href=\"" . base_url("index.php/master/agents/update_agent_status_new:" . $data[$i]->agent_id) . "\">Approve</a> <a href=\"\">Map</a> <a href=\"\">View Photos</a>";
                //$data[$i]->actions = "<a id=dialog_link href=\"#\">Approve</a> <a href=\"\">Map</a> <a href=\"\">View Photos</a>";
            } else if ($status == 2) {
                $data[$i]->actions = "<a id=\"dialog_link\" href=\"" . base_url("index.php/master/agents/update_agent_status_edited:" . $data[$i]->agent_id) . "\">Approve</a> <a href=\"\">Map</a> <a href=\"\">View Photos</a>";
            } else {
                // $data[$i]->actions = "No Actions Available";
                $data[$i]->actions = "<a id=\"dialog_link\" href=\"" . base_url("index.php/master/agents/update_agent_status_registered:" . $data[$i]->agent_id) . "\">Unapprove</a> <a href=\"\">Map</a> <a href=\"\">View Photos</a>";
            }
        }
        echo json_encode($data);
    }

}