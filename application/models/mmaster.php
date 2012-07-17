<?php
class Mmaster extends CI_Model {

	function Mmaster(){
		parent::__construct();
		$this->load->library( 'calendar' );
	}
	
        ########################################################################
        ####### DATA USER ##############
        ########################################################################
        function saveUser($edituser="")
        {
			$dblokal  = $this->load->database("default", TRUE);
			$name = $this->input->post("name");
			$email = $this->input->post("email");
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			
			$data = array("user_name"=>$name,
					  "email"=>$email,
					  "user_password"=>$password);
			
			if($edituser<>""){ 
				$un = $edituser;
				$dblokal->where(array("user_id"=>$edituser));
				$dblokal->update("t_mtr_user",$data);
			}else{
				$insert = array("user_id"=>$username);
				$dblokal->insert("t_mtr_user",array_merge($data,$insert));
			}
        }
        
        function getUser($id = "")
        {    
                $dblokal  = $this->load->database("default", TRUE);
                if($id<>""){
                        $dblokal->where(array("user_id"=>$id));
                }
                $query = $dblokal->get("t_mtr_user");
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
		}
        
        function deleteUser($username){
			$dblokal  = $this->load->database("default", TRUE);
			$dblokal->delete("t_mtr_user",array("user_id"=>$username));
		}
		
		
        function getPage($id = "")
        {    
                $dblokal  = $this->load->database("default", TRUE);
                $dblokal->order_by("id", "ASC");
                $dblokal->order_by("parent_id", "ASC");
                $dblokal->order_by("ordering", "ASC"); 
                $query = $dblokal->get("t_menu");
                return $query;
	}
        
        function getMenuSistem($pid = 0)
        {    
                $dblokal  = $this->load->database("default", TRUE);
                $dblokal->order_by("ordering", "ASC");
                $dblokal->where("parent_id", $pid);
                $dblokal->where("published", 1);
                $query = $dblokal->get("t_menu");
                return $query;
		}
        
        ########################################################################
        ####### DATA DISTRIBUTOR ##############
        ########################################################################
        function saveDistributor($edituser="")
        {
			$dblokal  = $this->load->database("default", TRUE);
			$name = $this->input->post("name");
			$distributor_add = $this->input->post("distributor_add");
					
			$data = array("distributor_name"=>$name,
					  "distributor_add"=>$distributor_add);
			
			if($edituser<>""){ 
				$un = $edituser;
				$dblokal->where(array("distributor_id"=>$edituser));
				$dblokal->update("t_mtr_distributor",$data);
			}else{
				$dblokal->insert("t_mtr_distributor",$data);
			}
        }
        
        function getDistributor($id = "")
        {    
			$dblokal  = $this->load->database("default", TRUE);
			if($id<>""){
					$dblokal->where(array("distributor_id"=>$id));
			}
			$query = $dblokal->get("t_mtr_distributor");
			if( $query->num_rows() > 0 ) {
					return $query->result();
			} else {
					return array();
			}
		}
        
        function deleteDistributor($id){
			$dblokal  = $this->load->database("default", TRUE);
			$dblokal->delete("t_mtr_distributor",array("distributor_id"=>$id));
		}
		
		function saveAgents()
		{
			$this->saveTerritory( 'agent' );
			$this->saveAgentData();
			$this->saveAgentSchool();
			$this->savePICData();
		}
		
		function saveAgentData()
		{
			$data = array();
			$this->db->select_max( 'territory_id' );
			$parent_id = $this->getTerritory( $this->session->userdata( 'username' ) )->row()->territory_id;
			$data[ 'territory_id' ] = $this->db->get_where( 't_mtr_territory', array( 'parent_id' => $parent_id ) )->row()->territory_id;
			$data[ 'agent_name' ] = $this->input->post( 'agent_name' );
			$data[ 'agent_address' ] = $this->input->post( 'agent_address' );
			$data[ 'agent_city' ] = $this->input->post( 'agent_city' );
			$data[ 'agent_province_id' ] = $this->db->get_where( 't_mtr_province', array( 'province_name' => $this->input->post( 'agent_province' ) ) )->row()->province_id;
			$data[ 'agent_zip_code' ] = $this->input->post( 'agent_zip_code' );
			$data[ 'agent_phone_no' ] = $this->input->post( 'agent_phone_no' );
			$data[ 'agent_status' ] = $this->input->post( 'agent_status' );
			$data[ 'agent_mdn_evo' ] = $this->input->post( 'mdn_evo' );
			$data[ 'agent_number_of_employee' ] = $this->input->post( 'employee_num' );
			$data[ 'agent_location' ] = $this->input->post( 'outlet_location' );
			$data[ 'agent_business_focus' ] = $this->input->post( 'b_focus' );
			$data[ 'agent_website' ] = $this->input->post( 'agent_website' );
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_agent', $data );
		}
		
		function saveAgentSchool()
		{
			$data = array();
			$this->db->select_max( 'agent_id' );
			$agentId = $this->db->get( 't_mtr_agent' )->row()->agent_id;
			$data[ 'agent_id' ] = $agentId;
			$data[ 'school_number_of_faculty' ] = $this->input->post( 'faculty_num' );
			$data[ 'school_number_of_student' ] = $this->input->post( 'student_num' );
			$data[ 'school_number_of_teacher' ] = $this->input->post( 'teacher_num' );
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_agent_school', $data );
		}
		
		function savePICData()
		{
			$data = array();
			$this->db->select_max( 'agent_id' );
			$agentId = $this->db->get( 't_mtr_agent' )->row()->agent_id;
			$data[ 'agent_id' ] = $agentId;
			$data[ 'pic_name' ] = $this->input->post( 'pic_name' );
			$data[ 'pic_address' ] = $this->input->post( 'pic_address' );
			$data[ 'pic_city' ] = $this->input->post( 'pic_city' );
			$data[ 'pic_province_id' ] = $this->db->get_where( 't_mtr_province', array( 'province_name' => $this->input->post( 'pic_province' ) ) )->row()->province_id;
			$data[ 'pic_zip_code' ] = $this->input->post( 'pic_zip_code' );
			$data[ 'pic_phone_no' ] = $this->input->post( 'pic_phone_no' );
			$data[ 'pic_status' ] = $this->input->post( 'pic_status' );
			$data[ 'pic_identity_type' ] = $this->input->post( 'pic_identity_type' );
			$data[ 'pic_identity_no' ] = $this->input->post( 'pic_identity_no' );
			$data[ 'pic_birth_place' ] = $this->input->post( 'pic_birth_place' );
			$data[ 'pic_birth_date' ] = $this->input->post( 'pic_birth_date' );
			$data[ 'pic_job_position' ] = $this->input->post( 'pic_job_position' );
			$data[ 'smartfren_no' ] = $this->input->post( 'smartfren_no' );
			$data[ 'mobile_no' ] = $this->input->post( 'mobile_no' );
			$data[ 'pic_email' ] = $this->input->post( 'pic_email' );
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_agent_pic', $data );
		}
        
        ########################################################################
        ####### DATA AGENTS ##############
        ########################################################################
        /*function saveAgents($edituser="")
        {
			$dblokal  = $this->load->database("default", TRUE);
			$name = $this->input->post("name");
			$address = $this->input->post("address");
			$teritory_id = $this->input->post("teritory_id");
					
			$data = array("agent_name"=>$name,"address"=>$address,"teritory_id"=>$teritory_id);
			
			if($edituser<>""){ 
				$un = $edituser;
				$dblokal->where(array("agent_id"=>$edituser));
				$dblokal->update("t_mtr_agent",$data);
			}else{
				$dblokal->insert("t_mtr_agent",$data);
			}
        }
        
        function getAgents($id = "")
        {    
                $dblokal  = $this->load->database("default", TRUE);
                if($id<>""){
                        $dblokal->where(array("agent_id"=>$id));
                }
                $query = $dblokal->get("t_mtr_agent");
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
	}
        
        function deleteAgents($id){
		$dblokal  = $this->load->database("default", TRUE);
		$dblokal->delete("t_mtr_agent",array("agent_id"=>$id));
	}*/
	
		/******************************* TAMBAHAN ****************************************/
		function getTerritory( $id )
		{
			$record = $this->db->get_where( 't_mtr_territory_type', array( 'lower(territory_type_name)' => 'cluster' ) );
			$tr_type_id = $record->row()->territory_type_id;
			$query = $this->db->get_where( 't_mtr_territory', array( 'user_id' => $id, 'territory_type_id' => $tr_type_id ) );
			if( $query->num_rows() != 0 )
				return $query;
			else
				return $this->db->get_where( 't_mtr_territory', array( 'territory_id' => $id ) );
		}
		
		function getMaintainName()
		{
			$login_user = $this->session->userdata( 'username' );
			$this->db->select( "* from t_mtr_user_group WHERE lower(user_group_name) = 'sales ambassador'" );
			$group_id = $this->db->get()->row()->user_group_id;
			
			$query = $this->db->get_where( 't_mtr_user', array( 'user_group_id' => $group_id, 'reporting_to' => $login_user ) );
			
			//echo $query->num_rows();
			return $query;
		}
		
		function getPosition( $id = "" )
		{
			$this->db->select( "user_group_name FROM t_mtr_user_group grp JOIN t_mtr_user usr ON usr.user_group_id = grp.user_group_id AND usr.user_id = '".$id."'" );
			$query = $this->db->get();
			return $query;
		}
		
		function getTerritoryTypeName( $name="" )
		{
			$this->db->select( "* FROM t_mtr_territory_type WHERE lower(territory_type_name) = '".$name."'" );
			return $this->db->get()->row()->territory_type_id;
		}
	
		function saveOutlets( $id="" )
		{
			$this->saveTerritory( 'outlet' );
			$this->saveOutlet();
			$this->saveOwnerData();
			$this->saveOutletData();
			$this->saveBranding();
		}
		
		function saveBranding()
		{
			$data = array();
			$this->db->select_max( 'outlet_id' );
			$outletId = $this->db->get( 't_mtr_outlet' )->row()->outlet_id;
			$data[ 'outlet_id' ] = $outletId;
			$data[ 'branding_status' ] = $this->input->post( 'status_branding' );
			$data[ 'full_branding_by' ] = $this->input->post( 'full_branding' );
			$data[ 'contract_end' ] = $this->input->post( 'contract_end' );
			$data[ 'branding_value' ] = $this->input->post( 'branding_value' );
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_outlet_branding', $data );
		}
		
		function saveOutletData()
		{
			$data = array();
			$this->db->select_max( 'outlet_id' );
			$outletId = $this->db->get( 't_mtr_outlet' )->row()->outlet_id;
			$data[ 'outlet_id' ] = $outletId;
			$data[ 'outlet_status' ] = $this->input->post( 'outlet_status' );
			$data[ 'outlet_type' ] = $this->input->post( 'outlet_type' );
			$data[ 'outlet_size' ] = $this->input->post( 'outlet_size' );
			$data[ 'outlet_location' ] = $this->input->post( 'outlet_location' );
			$data[ 'outlet_employee_number' ] = $this->input->post( 'employee_num' );
			$data[ 'outlet_lifetime' ] = $this->input->post( 'outlet_lifetime' );
			$data[ 'outlet_ownership' ] = $this->input->post( 'outlet_ownership' ); 
			$data[ 'outlet_smart_no' ] = $this->input->post( 'smart_no' );
			$data[ 'outlet_business_focus' ] = $this->input->post( 'b_focus' );
			$data[ 'outlet_customer_type' ] = $this->input->post( 'c_type' );
			$data[ 'outlet_size_of_business' ] = $this->input->post( 'sob' );
			$data[ 'outlet_is_expansion' ] = $this->input->post( 'is_expansion' );
			
			if( $data[ 'outlet_is_expansion' ] == 1 )
				$data[ 'outlet_expansion_package' ] = $this->input->post( 'expansion_pack' );
			else
				$data[ 'outlet_expansion_package' ] = null;
				
			$data[ 'outlet_join_lajang' ] = $this->input->post( 'join_lajang' );
			
			if( $data[ 'outlet_join_lajang' ] == 1 )
			{
				$data[ 'outlet_lajang_is_reorder' ] = $this->input->post( 'is_reorder' );
				if( $data[ 'outlet_lajang_is_reorder' ] == 1 )
					$data[ 'outlet_lajang_package' ] = $this->input->post( 'lajang_pack' );
				else
					$data[ 'outlet_lajang_package' ] = null;
			}
			else
			{
				$data[ 'outlet_lajang_is_reorder' ] = null;
				$data[ 'outlet_lajang_package' ] = null;
			}	
			
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_outlet_data', $data );
		}
		
		function generateID()
		{
			$this->db->select_max( 'outlet_id' );
			$outletId = $this->db->get( 't_mtr_outlet' )->row()->outlet_id;
			$result = '';
			
			if( $this->db->get( 't_mtr_outlet' )->num_rows() == 0 )
				$result = '0001';
			else
			{
				if( $outletId < 10 )
					$loop = 3;
				else if( $outletId < 100 )
					$loop = 2;
				else if( $outletId < 1000 )
					$loop = 1;
				else
					$loop = 0;
					
				for( $i = 0 ; $i < $loop ; $i++ )
				{
					$result = $result.'0';
				}
				
				for( $i = 3 ; $i >= $loop ; $i-- )
				{
					$result = $result.($outletId[ $i + 4 ] + 1);
				}
				
			}
			
			return $result;
		}
		
		function saveOwnerData()
		{
			$data = array();
			$this->db->select_max( 'outlet_id' );
			$outletId = $this->db->get( 't_mtr_outlet' )->row()->outlet_id;
			$data[ 'outlet_id' ] = $outletId;
			$data[ 'owner_name' ] = $this->input->post( 'name_owner' );
			$data[ 'owner_gender' ] = $this->input->post( 'gender' );
			$data[ 'owner_birth_place' ] = $this->input->post( 'birth_place' );
			$data[ 'owner_birth_date' ] = $this->input->post( 'birth_date' );
			$data[ 'owner_religion' ] = $this->input->post( 'religion' );
			//echo $data[ 'owner_religion' ];
			$data[ 'owner_email' ] = $this->input->post( 'email' );
			$data[ 'owner_phone' ] = $this->input->post( 'phone' ); 
			$data[ 'owner_identity_type' ] = $this->input->post( 'identity_type' );
			$data[ 'owner_identity_number' ] = $this->input->post( 'identity_number' );
			//$data[ 'iStatus' ] = '1';
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_outlet_owner', $data );
		}
		
		function saveOutlet()
		{
			$data = array();
			$parent_id = $this->getTerritory( $this->session->userdata( 'username' ) )->row()->territory_id;
			$data[ 'outlet_id' ] = $this->input->post( 'outlet_id' );
			
			$this->db->select_max( 'territory_id' );
			$data[ 'territory_id' ] = $this->db->get_where( 't_mtr_territory', array( 'parent_id' => $parent_id ) )->row()->territory_id;
			$data[ 'outlet_name' ] = $this->input->post( 'outlet_name' );
			//$data[ 'focus' ] = $this->input->post( 'b_focus' );
			$data[ 'address' ] = $this->input->post( 'address' );
			$data[ 'city' ] = $this->input->post( 'city' );
			$data[ 'province_id' ] = $this->db->get_where( 't_mtr_province', array( 'province_name' => $this->input->post( 'province' ) ) )->row()->province_id;
			$data[ 'post_code' ] = $this->input->post( 'post_code' );
			$data[ 'phone' ] = $this->input->post( 'outlet_phone' );
			$data[ 'eload_number' ] = $this->input->post( 'smart_etopup' );
			$data[ 'business_structure' ] = $this->input->post( 'b_structure' );
			$data[ 'istatus' ] = '1';
			$data[ 'outbond_caller_id' ] = $this->db->get_where( 't_mtr_user', array( 'user_name' => $this->input->post( 'outbond_caller' ) ) )->row()->user_id;
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_outlet', $data );
		}
		
		function saveProvince()
		{
			$data = array();
			$data[ 'province_name' ] = $this->input->post( 'province' );
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_province', $data );
		}
		
		function saveTerritory( $name="" )
		{
			$data = array();
			$data[ 'territory_type_id' ] = $this->getTerritoryTypeName( $name ); 
			$data[ 'territory_name' ] = $this->input->post( 'outlet_name' ); 
			$data[ 'parent_id' ] = $this->getTerritory( $this->session->userdata( 'username' ) )->row()->territory_id;
			//echo $data[ 'parent_id' ];
			$user_name = $this->input->post( 'maintain_name' );
			$data[ 'user_id' ] = $this->db->get_where( 't_mtr_user', array( 'user_name' => $user_name ) )->row()->user_id;
			$data[ 'istatus' ] = '1';
			$data[ 'created_by' ] = $this->session->userdata( 'username' );
			$data[ 'created_on' ] = date("Y-m-d H:i:s");
			$data[ 'updated_by' ] = $this->session->userdata( 'username' );
			$data[ 'updated_on' ] = date("Y-m-d H:i:s");
			
			$this->db->insert( 't_mtr_territory', $data );
		}
        
        ########################################################################
        ########################################################################
        
		
		function getRecord( $name )
		{
			return $this->db->get_where( $name );
		}
		
		function getComboData( $field )
		{
			if( $field == 'building' )
				return  $this->db->get( 'v_combo_outlet_type' );	
			if( $field == 'gender' )
				return  $this->db->get( 'v_combo_gender' );	
			if( $field == 'religion' )
				return  $this->db->get( 'v_combo_religion' );
			if( $field == 'identity' )
				return  $this->db->get( 'v_combo_identity_type' );
			if( $field == 'o_status' )
				return  $this->db->get( 'v_combo_outlet_status' );
			if( $field == 'o_type' )
				return  $this->db->get( 'v_combo_tipe_outlet' );
			if( $field == 'o_size' )
				return  $this->db->get( 'v_combo_outlet_size' );
			if( $field == 'o_location' )
				return  $this->db->get( 'v_combo_outlet_location' );
			if( $field == 'o_ownership' )
				return  $this->db->get( 'v_combo_outlet_ownership' );
			if( $field == 'b_structure' )
				return  $this->db->get( 'v_combo_business_structure' );
			if( $field == 'b_focus' )
				return  $this->db->get( 'v_combo_business_focus' );
			if( $field == 'b_size' )
				return  $this->db->get( 'v_combo_size_of_business' );
			if( $field == 'c_type' )
				return  $this->db->get( 'v_combo_customer_type' );
			if( $field == 'l_package' )
				return  $this->db->get( 'v_combo_lajang_list' );
			if( $field == 'e_package' )
				return  $this->db->get( 'v_combo_expansion_list' );
			if( $field == 'position' )
				return  $this->db->get( 'v_combo_position' );	
			if( $field == 'full_branding' )
				return  $this->db->get( 'v_combo_full_branding_by' );
			if( $field == 'outbond' )
			{
				$this->db->select("user_id as member_value, user_name as member_display
					FROM t_mtr_user usr
					JOIN t_mtr_user_group grp
					ON usr.user_group_id = grp.user_group_id
					AND lower(grp.user_group_name) = 'outbound caller'
					ORDER BY grp.user_group_name ASC", FALSE);
					
				/*array( 'usr.user_group_id' => 'grp.user_group_id', 'lower(grp.user_group_name)' => 'outbond caller'
				
				$this->db->select( 'user_id as member_value, user_name as member_display' );
				$this->db->from( 't_mtr_user' );
				$this->db->join( 't_mtr_user_group', array( 't_mtr_user.user_group_id' => 't_mtr_user_group.user_group_id', 'lower(t_mtr_user_group.user_group_name)' => 'outbound caller');
				$this->db->order_by( 't_mtr_user_group.user_group_name', 'asc' );
				*/		
				
				$query = $this->db->get();
				return $query;
			}
			
			if( $field == 'agent_status' )
				return $this->db->get( 'v_combo_agent_status' );
		}

		########################################################################
    ####### DATA GALLERY ##############
    ####### Edited by Rizky Ramadhan ##############
    ####### Edited on 18 Maret 2012 ##############
    ########################################################################


    public function getCluster()
    {
        $this->db->select('*');
        $this->db->from('t_mtr_territory');
        $this->db->where('parent_id !=', 1);
        $query = $this->db->get();

        return $query->result();

    }
    
    function saveGallery($editgallery = "")
    {
        $dblokal = $this->load->database("default", true);
        $gallery_name = $this->input->post("gallery_name");
        $gallery_address = $this->input->post("gallery_address");
        $territory_id = $this->input->post("territory_id");

        $data = array("gallery_name" => $gallery_name, "gallery_address" => $gallery_address, "teritory_id" => $territory_id);

        if ($editgallery <> "") {
            
        } else {
            $dblokal->insert("t_mtr_gallery", $data);
        }
    }
    
    ########################################################################
    ########################################################################
}