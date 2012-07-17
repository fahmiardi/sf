<?php

class mreturns extends CI_Model {
    
    public function getTerritoryId(){
		$this->db->select('territory_id');
		$this->db->from('t_mtr_territory');
		$this->db->where('user_id', $this->session->userdata('username'));
		$query = $this->db->get();

        return $query->row();
	}
	
    // public function getCluster(){
       	// $this->db->select('distributor_name, distributor_address, t_mtr_distributor.territory_id');
		// $this->db->from('t_mtr_distributor');
		// $this->db->join('t_mtr_user_territory', 't_mtr_distributor.territory_id = t_mtr_user_territory.territory_id', 'left');
		// $this->db->join('t_mtr_territory', 't_mtr_distributor.territory_id = t_mtr_territory.territory_id', 'left');
        // $this->db->join('t_mtr_territory_type', 't_mtr_territory.territory_type_id = t_mtr_territory_type.territory_type_id AND t_mtr_territory_type.territory_type_id = 3', 'left');
		// $this->db->where('t_mtr_user_territory.user_id', $this->session->userdata('username'));
        // $this->db->limit(1, 0);
		// $query = $this->db->get();

        // return $query->result();
        
    // }
	
	    public function getCluster(){
       	$this->db->select('territory_name, territory_id');
		$this->db->from('t_mtr_territory');
		$this->db->where('user_id', $this->session->userdata('username'));
        $this->db->limit(1, 0);
		$query = $this->db->get();

        return $query->result();
        
    }
    
    public function getSales($territory_id)
    {
        $this->db->select('t_mtr_user.user_id, t_mtr_user.user_name');
		$this->db->from('t_mtr_user');
		$this->db->join('t_mtr_user_group', 't_mtr_user.user_group_id = t_mtr_user_group.user_group_id AND t_mtr_user.istatus = 1 AND t_mtr_user_group.having_stock = 1', 'left');
	    $this->db->join ('t_mtr_territory', 't_mtr_territory.user_id = t_mtr_user.user_id AND t_mtr_territory.parent_id = '.$territory_id);
		$this->db->order_by("t_mtr_user.user_name", "asc");
		$query = $this->db->get();
        return $query->result();
    }
	
	public function getOutlet($sales_id)
    {
		//$sales_id = $this->input->post('sales_id');
        $this->db->select('t_mtr_outlet.outlet_id, t_mtr_outlet.outlet_name');
		$this->db->from('t_mtr_outlet');
		$this->db->join('t_mtr_territory', 't_mtr_outlet.territory_id = t_mtr_territory.territory_id AND t_mtr_territory.user_id = '.$sales_id);
		$this->db->order_by("t_mtr_outlet.outlet_name", "asc");
		$query = $this->db->get();
        return $query->result();
    }
	
	public function getItemName()
    {
        $this->db->select('iccid, item_name');
		$this->db->from('t_mtr_item');
		
	    $this->db->order_by("t_mtr_item.iccid", "asc");
		$query = $this->db->get();
        return $query->result();
    }
	
	public function getPrice()
    {
        $this->db->select('iccid, price, discount');
		$this->db->from('t_trx_sales_order_detail');
		
	    $this->db->order_by("t_trx_sales_order_detail.iccid", "asc");
		$query = $this->db->get();
        return $query->result();
    }
	
	public function getBuyingDate()
    {
        $this->db->select('iccid, created_on');
		$this->db->from('t_trx_sell_in_detail');
		$this->db->where('istatus', 1);
	    $this->db->order_by("t_trx_sell_in_detail.iccid", "asc");
		$query = $this->db->get();
        return $query->result();
    }
    
    
    
    function saveReturn()
    {
        $dblokal = $this->load->database("default", true);
        $return_date = $this->input->post("return_date");
        $sales_id = $this->input->post("sales_id");
		$remark = '';
		if ($this->input->post("remark")){
			$remark = $this->input->post("remark");
		}
		
		$territory = $this->getTerritoryId();
		$channel_id = $territory->territory_id;
		//$channel_id = $this->input->post("territory_id");
        $status = -10;
        

        $data = array("return_date" => $return_date, "user_id" => $sales_id,
            "istatus" => $status, "channel_id" => $channel_id, "remark" => $remark);
		
        $dblokal->insert("t_trx_sell_return", $data);
        $return_id = $this->getReturnNo();
        return $return_id;
        
    }
    
    function saveReturnDetail($return_id, $buying_date, $iccid, $price)
    {
        $dblokal = $this->load->database("default", true);

        $data = array("return_id" => $return_id, "sales_date" => $buying_date, "iccid" => $iccid, "price" => $price);
        $dblokal->insert("t_trx_sell_return_detail", $data);
		
		$data1 = array("istatus" => -10);
		$this->db->update('t_trx_sell_in_detail', $data1, array('iccid' => $iccid));
        
    }
    
    function getReturnNo()
    {
        $this->db->select('*')->from('t_trx_sell_return');
        $this->db->order_by('return_id', 'desc');
        $query = $this->db->get();   
 
        return $query->row();    
        
    }
    
    
    
} //end class