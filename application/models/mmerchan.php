<?php

class mmerchan extends CI_Model {
    

    
    public function getPaymentOption() {
        //get all records from users table
        $query = $this->db->get('v_combo_payment_method');
        
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll
    
    
    public function getById( $id ) {
        $id = intval( $id );
        
        $query = $this->db->where( 'so_id', $id )->limit( 1 )->get( 't_trx_sales_order' );
        
        if( $query->num_rows() > 0 ) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    public function getRegion()
    {
        $this->db->select('territory_id, territory_name, parent_id');
		$this->db->from('t_mtr_territory');
		$this->db->where('territory_id !=', 1);
        $this->db->where('parent_id', 1);
		$query = $this->db->get();
        return $query->result();
    }
    
    public function getCluster($region_id)
    {
        $this->db->select('territory_id, territory_name, parent_id');
		$this->db->from('t_mtr_territory');
        $this->db->where('parent_id', $region_id);
		$query = $this->db->get();

        return $query->result_array();
        
    }
    
    public function getMerchan($cluster_id)
    {
        $this->db->select('*');
		$this->db->from('t_mtr_outlet');
        $this->db->join('t_trx_merchan_capture', 't_trx_merchan_capture.channel_id = t_mtr_outlet.outlet_id');
        $this->db->where('outlet_id', $cluster_id);
		$query = $this->db->get();

        return $query->result_array();
        
    }
    
    public function getPaymentMethod()
    {
        $this->db->select('*')->from('v_combo_payment_method');
        $query = $this->db->get();   
 
        return $query->result();   
    }
    
    public function get_iccid()
    {
        $this->db->select('t_trx_scan_in_detail.iccid,
                            t_mtr_item_group.item_group_name,
                            t_mtr_item.item_name,
                            t_mtr_item.reseller_price,
                            t_mtr_item.default_price');
		$this->db->from('t_trx_scan_in_detail');
		$this->db->join('t_mtr_item', 't_trx_scan_in_detail.iccid = t_mtr_item.iccid AND t_mtr_item.istatus = 1');
        $this->db->join('t_mtr_item_group', 't_mtr_item.item_group_id = t_mtr_item_group.item_group_id');
		$query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_single_iccid($iccid)
    {
        $this->db->select('*');
		$this->db->from('t_mtr_item');
        $this->db->join('t_mtr_item_group', 't_mtr_item.item_group_id = t_mtr_item_group.item_group_id');
        $this->db->where("iccid = '$iccid'");
		$query = $this->db->get();
        return $query->row_array();
    }
    
    function saveSalesOrder()
    {
        $dblokal = $this->load->database("default", true);
        $territory_id = $this->input->post("territory_id");
        $so_date = $this->input->post("so_date");
        $sales_id = $this->input->post("sales_id");
        $discount_total = $this->input->post("discount_total");
        $cash_paid = $this->input->post("cash_paid");
        $payment_method = $this->input->post("dListPaymentMethod");

        $data = array("territory_id" => $territory_id, "so_date" => $so_date, "sales_id" => $sales_id,
            "discount" => $discount_total, "cash_paid" => $cash_paid, "payment_method" => $payment_method, "created_by" => $this->session->userdata('username'), "updated_by" => $this->session->userdata('username'));

        
        $dblokal->insert("t_trx_sales_order", $data);
        $freshSalesOrder = $this->getFreshSalesOrder();
        return $freshSalesOrder;
        
    }
    
    function saveSalesOrderDetail($so_id, $i)
    {
        $dblokal = $this->load->database("default", true);
        $iccid = $this->input->post('iccid');
        $item_code = $this->input->post('item_code');
        $item_group_name = $this->input->post('item_group_name');
        $item_name = $this->input->post('item_name');
        $price = $this->input->post('default_price');
        $discount = $this->input->post('reseller_disc');
       
        
        $data = array("iccid" => $iccid[$i], "so_id" => $so_id, "price" => $price[$i], "discount" => $discount[$i], "created_by" => $this->session->userdata('username'), "updated_by" => $this->session->userdata('username'));

        
        $dblokal->insert("t_trx_sales_order_detail", $data);
        
    }
    
    function getFreshSalesOrder()
    {
        $this->db->select('*')->from('t_trx_sales_order');
        $this->db->order_by('so_id', 'desc');
        $query = $this->db->get();   
 
        return $query->row();    
        
    }
    
    function lookup($keyword){
        $this->db->select('*')->from('t_mtr_user');
        $this->db->like('user_name',$keyword,'after');
        $query = $this->db->get();   
 
        return $query->result();
    }
    
    public function getAll() {
        //get all records from users table
        $query = $this->db->get( 't_trx_sales_order' );
        
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll
    
    function lookup_iccid($keyword)
    {
        $this->db->select('*')->from('t_mtr_item');
        $this->db->like('iccid',$keyword,'after');
        
        $query = $this->db->get();   
 
        return $query->result_array();    
    }
    
} //end class