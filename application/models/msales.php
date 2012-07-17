<?php

class msales extends CI_Model {
    

    
    public function getPaymentOption() {
        //get all records from users table
        $query = $this->db->get('v_combo_payment_method');
        
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll
    
    public function getCluster(){
       	$this->db->select('territory_name, territory_id');
		$this->db->from('t_mtr_territory');
		$this->db->where('user_id', $this->session->userdata('username'));
        $this->db->limit(1, 0);
		$query = $this->db->get();

        return $query->result();
        
    }
    
    public function getSales()
    {
	
	    $dbconn  = $this->load->database("default", TRUE);
		$userlogin = $this->session->userdata('username');
		$sql = "SELECT DISTINCT ter.user_id, usr.user_name
				FROM t_mtr_territory ter
				JOIN t_mtr_user usr on ter.user_id = usr.user_id
				AND ter.parent_id = f_get_cluster('$userlogin')
				UNION
				SELECT DISTINCT ut.user_id, usr.user_name
				FROM t_mtr_user_territory ut
				JOIN t_mtr_user usr on ut.user_id = usr.user_id
				AND usr.reporting_to = '$userlogin'
				ORDER BY user_name";

        $query = $dbconn->query($sql);
        if( $query->num_rows() > 0 ) {
            return $query->result();
          } else {
            return array();
           }
        // $this->db->select('user_id, user_name');
		// $this->db->from('t_mtr_user');
		// $this->db->join('t_mtr_user_group', 't_mtr_user.user_group_id = t_mtr_user_group.user_group_id AND t_mtr_user.istatus = 1 AND t_mtr_user_group.having_stock = 1', 'left');
	    // $this->db->order_by("t_mtr_user.user_name", "asc");
		//$query = $this->db->get();
        //return $query->result();
    }
    
    public function getSalesOrder($sales_id)
    {
        $this->db->select('t_trx_scan_in_detail.iccid,
                            t_mtr_item.item_code,
                            t_mtr_item_group.item_group_name,
                            t_mtr_item.item_name,
                            t_mtr_item.reseller_price,
                            t_mtr_item.default_price');
		$this->db->from('t_trx_scan_in_detail');
		$this->db->join("t_trx_scan_in", "t_trx_scan_in_detail.scan_in_id = t_trx_scan_in.scan_in_id AND t_trx_scan_in_detail.istatus = 2 AND t_trx_scan_in.user_id = '$sales_id'");
        $this->db->join('t_mtr_item', 't_trx_scan_in_detail.iccid = t_mtr_item.iccid AND t_mtr_item.istatus = 1');
        $this->db->join('t_mtr_item_group', 't_mtr_item.item_group_id = t_mtr_item_group.item_group_id');
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
        $discount = $this->input->post('reseller_price');
       
        
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
    
    function lookup_iccid($keyword)
    {
        $this->db->select('*')->from('t_mtr_item');
        $this->db->like('iccid',$keyword,'after');
        
        $query = $this->db->get();   
 
        return $query->result_array();    
    }
	
	/* Ken untuk receipt */
	    public function getById($id) {
        $id = intval( $id );
        
        $query = $this->db->where( 'receipt_id', $id )->limit( 1 )->get( 't_trx_receipt' );
        
        if( $query->num_rows() > 0 ) {
            return $query->row();
        } else {
            return array();
        }
    }
    
	
	public function getItemDetail($id)
	{
		$listItem = array();
		
		$this->db->select('item_name, item_code, item_group_id');
		$this->db->where('iccid', $id);
		$q = $this->db->get('t_mtr_item');
		$listItem = $q->result_array();	
		
		$this->db->select('item_group_name');
		$this->db->where('item_group_id', $listItem[0]['item_group_id']);
		$q = $this->db->get('t_mtr_item_group');
		$q = $q->result_array();	
		
		$listItem[0]['item_group_name'] = $q[0]['item_group_name'];
		return $listItem;
	
	}
	
	
    public function getAllReceipt() {
        //get all records from users table
        $query = $this->db->get( 't_trx_receipt' );
        
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll
    
	function getOrderInfo($id)
	{
		$this->db->select('sales_id');
		$this->db->where('receipt_id', $id);
		$q = $this->db->get('t_trx_receipt');
		$q = $q->result_array();
				
		return $q[0]['sales_id'];
	
	}
	
	
	function getSalesName($id)
	{
		$this->db->select('user_name');
		$this->db->where('user_id', $id);
		$q = $this->db->get('t_mtr_user');
		$q = $q->result_array();
		return $q[0]['user_name'];
	}
	
	 function saveReceipt($ter_id)
    {
        $dblokal = $this->load->database("default", true);
        $receipt_date = $this->input->post("receipt_date");
        $sales_id = $this->input->post("sales_id");
        $remark = $this->input->post("remark");

        $data = array(
			"territory_id" => $ter_id, 
			"receipt_date" => $receipt_date, 
			"sales_id" => $sales_id,
			"remark" => $remark
		);

        
        $dblokal->insert("t_trx_receipt", $data);
		
		//get last id
		$this->db->select_max('receipt_id');
		$Q = $this->db->get('t_trx_receipt');
		$last = $Q->result_array();
		$last = $last[0]['receipt_id'];
		
        return $last;
        
    }
    
    function saveReceiptDetail($rid, $i, $dist_id)
    {
			
        $dblokal = $this->load->database("default", true);
        $iccid = $this->input->post('iccid');
        $item_code = $this->input->post('item_code');
        $item_group_name = $this->input->post('item_group_name');
        $item_name = $this->input->post('item_name');        
		$price = $this->input->post('price');
        $priceEdit = $this->input->post('priceEdit');
	
        $data = array(
			"iccid" => $iccid[$i], 
			"receipt_id" => $rid, 
			"price" => $price[$i], 
			"price_edit" => $priceEdit[$i],
			"distributor_id" => $dist_id,
		);
   
        $dblokal->insert("t_trx_receipt_detail", $data);
        
    }
	
	public function getClusterName($id='')
	{
		if ($id=='')
		{
			// $this->db->select('distro.distributor_id, distro.distributor_name, distro.distributor_address, distro.territory_id');
			// $this->db->from('t_mtr_distributor AS distro');
			// $this->db->join('t_mtr_user_territory AS ut', 'distro.territory_id = ut.territory_id', 'INNER');
			// $this->db->join('t_mtr_territory AS ter', 'distro.territory_id = ter.territory_id', 'INNER');
			// $this->db->join('t_mtr_territory_type AS trtype', 'ter.territory_type_id = trtype.territory_type_id AND trtype.territory_type_id = 3', 'INNER');		
			// $this->db->where('ut.user_id', $this->session->userdata('username'));			
			// //$this->db->limit(1, 20);
			// $q = $this->db->get();
		// return $q->result_array();
		$this->db->select('territory_name, territory_id');
		$this->db->from('t_mtr_territory');
		$this->db->where('user_id', $this->session->userdata('username'));
        $this->db->limit(1, 0);
		$query = $this->db->get();
		}

        return $query->result();
		
	}
	
	
	public function getSalesID($curLogin = "")
    {
		$tes = "cluster";
		
		$this->db->select('ter.territory_name, ter.territory_id');
		$this->db->from('t_mtr_territory AS ter');
		$this->db->join("t_mtr_territory_type AS terty", "ter.territory_type_id = terty.territory_type_id AND lower(terty.territory_type_name)='$tes'");
		$this->db->where('ter.user_id', $curLogin);
		$q = $this->db->get();
        $query = $q->result_array();
		
		$terri = $query[0]['territory_id'];
		
        $this->db->select('usr.user_id, usr.user_name');
		$this->db->group_by('usr.user_id, usr.user_name');
		$this->db->from('t_mtr_user AS usr');
		$this->db->join('t_mtr_user_group AS grp', 'usr.user_group_id = grp.user_group_id AND usr.istatus = 1 AND grp.having_stock = 1');
		$this->db->join('t_trx_scan_in AS scan', 'usr.user_id = scan.user_id AND scan.istatus = 1');
		$this->db->join('t_mtr_user_territory AS uster', 'usr.user_id = uster.user_id');
		$this->db->join("t_mtr_territory AS ter", "uster.territory_id = ter.territory_id AND ter.parent_id = '$terri'");
	    $this->db->order_by("usr.user_name", "asc");
		$query = $this->db->get();
        return $query->result();
		
		
    }
	//sudah ada diatas
	// function getSales($sales_id)
	// {    
	   // $this->db->select('scand.iccid, itm.item_code, grp.item_group_name, itm.item_name, itm.reseller_price, itm.default_price');
		// $this->db->from('t_trx_scan_in_detail AS scand');
		// $this->db->join("t_trx_scan_in AS scan", "scand.scan_in_id = scan.scan_in_id AND scand.istatus = 1 AND scan.user_id = '$sales_id'");		
		// $this->db->join('t_mtr_item AS itm', 'scand.iccid = itm.iccid AND itm.istatus = 1');
		// $this->db->join('t_mtr_item_group AS grp', 'itm.item_group_id = grp.item_group_id');
		// $query = $this->db->get();
		// return $query->result_array();
	// }
	
    public function update() {
        $data = array(
            'name' => $this->input->post( 'name', true ),
            'email' => $this->input->post( 'email', true )
        );
        
        $this->db->update( 't_menu', $data, array( 'id' => $this->input->post( 'id', true ) ) );
    }
    
    public function delete( $id ) {
        /*
        * Any non-digit character will be excluded after passing $id
        * from intval function. This is done for security reason.
        */
        $id = intval( $id );
        
        $this->db->delete( 't_trx_receipt', array( 'receipt_id' => $id ) );
    } //end delete

    
} //end class