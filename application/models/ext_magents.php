<?php

class Ext_Magents extends CI_Model {

    private $selectBelowAgentsById = "SELECT agn.agent_id, agn.agent_name, agn.agent_address, agn.agent_city, agn.agent_business_focus, agn.agent_type, \"public\".f_get_agent_parent_path(agn.agent_id) FROM t_mtr_agent agn JOIN t_mtr_territory ter ON agn.territory_id = ter.territory_id AND ter.parent_id = f_get_cluster(?) AND agn.istatus = ? ORDER BY agn.agent_name ASC;";
    private $updateAgentStatusById = "UPDATE t_mtr_agent SET istatus = ? WHERE agent_id = ? AND istatus = ?";

    function Ext_Magents() {
        parent::__construct();
    }

    function selectStatusAgentsById($userId, $status) {
        $query = $this->db->query($this->selectBelowAgentsById, array($userId, $status));
        return $query->result();
    }

    function updateAgentStatusById($newStatus, $agentId, $previousStatus) {
        $query = $this->db->query($this->updateAgentStatusById, array($newStatus, $agentId, $previousStatus));
    }

}
