<?php

class mUsers extends CI_Model {
    
    function mUsers(){
            parent::__construct();
            $this->setVars();
    }
    
    function setVars()
    {
        $this->result = '';
        $this->idnya = 0;
    }
        
    public function create() {
        $data = array(
            'user_name'  => $this->input->post( 'cName', true ),
            'email' => $this->input->post( 'cEmail', true )
        );
        
        $this->db->insert( 't_mtr_user', $data );
        return $this->db->insert_id();
    }
    
    public function getById( $id ) {
        #$id = intval( $id );
        
        $query = $this->db->where( 'user_id', $id )->limit( 1 )->get( 't_mtr_user' );
        
        if( $query->num_rows() > 0 ) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    public function getAll() {
        //get all records from users table
        $query = $this->db->get( 't_mtr_user' );
        
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll
    
    public function update() {
        $data = array(
            'user_name' => $this->input->post( 'name', true ),
            'email' => $this->input->post( 'email', true )
        );
        
        $this->db->update( 't_mtr_user', $data, array( 'user_id' => $this->input->post( 'id', true ) ) );
    }
    
    public function delete( $id ) {
        /*
        * Any non-digit character will be excluded after passing $id
        * from intval function. This is done for security reason.
        */
        $id = intval( $id );
        
        $this->db->delete( 't_mtr_user', array( 'user_id' => $id ) );
    } //end delete
    
    
        ########################################################################
        ####### DATA USER ##############
        ########################################################################
        function saveUser($edituser="")
        {
                $dblokal  = $this->load->database("default", TRUE);
		$name = $this->input->post("name");
		$email = $this->input->post("email");
		$username = $this->input->post("username");
		$nik = $this->input->post("nik");
                $usergroup = $this->input->post("usergroup");
                $reportingto = $this->input->post("reportingto");
		$hape = $this->input->post("hape");
                
		$data = array("user_name"=>$name,
			      "email"=>$email,
			      "nik"=>$nik,
                              "user_password"=>md5("12345"),
                              "user_group_id"=>$usergroup,
                              "reporting_to"=>$reportingto,
                              "mobile_number"=>$hape);
		
                if($edituser<>""){ 
			$un = $edituser;
			
                        $data2 = array("user_group_id"=>$usergroup,
                                        "reporting_to"=>$reportingto,
                                        "email"=>$email,
                                         "mobile_number"=>$hape);
                        $pwd = $this->input->post("password");
                        if($pwd<>""){
                            $data2['user_password'] = md5($pwd);
                        }
                        
                        $dblokal->where(array("user_id"=>$edituser));
			$dblokal->update("t_mtr_user",$data2);
		}else{
			$insert = array("user_id"=>$username);
			$dblokal->insert("t_mtr_user",array_merge($data,$insert));
		}
        }
        
        function getUser($id = "", $pid="")
        {    
                $dblokal  = $this->load->database("default", TRUE);
                if($id<>""){
                    if($pid<>""){
                        #if($pid = "pida") $dblokal->where(array("resporting_to"=>$id));
                        if($id== "-"){
                            $dblokal->where("reporting_to = user_id");
                        }else{
                            $dblokal->where("reporting_to != user_id");
                            $dblokal->where(array("reporting_to"=>$id));
                        }
                    }else{
                        $dblokal->where(array("user_id"=>$id));
                    }
                }
                $query = $dblokal->get("t_mtr_user");
                if($pid<>""){
                        return $query;
                }else{
                        if( $query->num_rows() > 0 ) {
                                return $query->result();
                        } else {
                                return array();
                        }
                }
	}
        
        function deleteUser($username){
		$dblokal  = $this->load->database("default", TRUE);
		$dblokal->delete("t_mtr_user",array("user_id"=>$username));
	}
    
        function getUserTree($id = "-",$p=0)
        {    
                $query = $this->getUser($id,"pid");
                $k=0;  $p++;
                $jum = $query->num_rows();
                $this->idnya ++;
		
		if($query->num_rows()>0){
                        $this->result .='[';
                        foreach($query->result() as $r){
                                $link="<a href='". base_url() ."index.php/user_management/index/update/". $r->user_id ."'>update</a>";
				
				$this->result .='{"id":"'. $r->user_id .'",
                                                "name":"'. $r->user_name .'",
                                                "size":"'. $r->user_id .'",
                                                "nik":"'. $r->nik .'",
                                                "emails":"'. $r->email .'",
                                                "hapes":"'. $r->mobile_number .'",
                                                "date":"'. $link .'",
                                                "iconCls":"icon-user-'. $p .'"';
                                $k++;
				#cek punya children gak ?
                                $cek = $this->getUser($r->user_id,"pida");
                                if($cek->num_rows()>0){
                                        $this->result .=',"children":';
                                        $this->getUserTree($r->user_id,$p);
                                        $this->result .='}';
                                        if($k!=$jum) $this->result .=',';
                                }else{
                                        $this->result .='}';
                                        if($k!=$jum) $this->result .=',';
                                }
                        }
                        $this->result .="]";
                }
                return $this->result;
	}
        
        
        function change_password($id="")
        {
                $dblokal  = $this->load->database("default", TRUE);
		$pwd = $this->input->post("new-password");
		
		$data = array("user_password"=>md5($pwd));
		$dblokal->where(array("user_id"=>$id));
		$dblokal->update("t_mtr_user",$data);
        }
} //end class