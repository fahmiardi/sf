<?php

class Ext_Mnews extends CI_Model {

    private $selectByCreatedById = "SELECT * from t_ntf_news WHERE created_by=?";
    private $selectById = "SELECT * from t_ntf_news WHERE news_id=?";
    private $insert = "INSERT INTO t_ntf_news(territory_id,news_header,news_content,created_by,created_on,updated_by,updated_on) VALUES(?,?,?,?,now(),null,null)";
    private $update = "UPDATE t_ntf_news SET territory_id = ?, news_header=?, news_content = ?, updated_by = ?, updated_on = now() WHERE news_id = ?";

    function Ext_Magents() {
        parent::__construct();
    }

    function selectByCreatedById($userId) {
        $query = $this->db->query($this->selectByCreatedById, array($userId));
        return $query->result();
    }

    function selectById($id) {
        $query = $this->db->query($this->selectById, array($id));
        return $query->result();
    }
    
    function update($territory_id, $news_header, $news_content, $updated_by,$id) {
        $query = $this->db->query($this->update, array($territory_id, $news_header, $news_content, $updated_by,$id));
    }

    function insert($territory_id, $news_header, $news_content, $created_by) {
        $query = $this->db->query($this->insert, array($territory_id, $news_header, $news_content, $created_by));
    }

}
