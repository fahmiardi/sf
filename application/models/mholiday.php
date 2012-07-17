<?php

class mHoliday extends CI_Model {
    
        ########################################################################
        ####### DATA HOLIDAY ##############
        ########################################################################
        function save($edit="")
        {
                $dblokal  = $this->load->database("default", TRUE);
		$tanggal = $this->input->post("tanggal");
		$keterangan = $this->input->post("keterangan");
		
		$data = array("tanggal"=>str_replace("-","",$tanggal),
			      "keterangan"=>$keterangan,
			      "created_by"=>$this->session->userdata('username'),
                              "created_on"=>date("Y-m-d H:i:s"));
		
                if($edit<>""){ 
			$dblokal->where(array("id"=>$edit));
			$dblokal->update("t_mtr_holiday",$data);
		}else{
			$dblokal->insert("t_mtr_holiday",$data);
		}
        }
        
        function get($id = "")
        {    
                $dblokal  = $this->load->database("default", TRUE);
                if($id<>""){
                        $dblokal->where(array("id"=>$id));
                }
                $query = $dblokal->get("t_mtr_holiday");
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
	}
        
        #########################
        #########################
        
        public function getById( $id ) {
                #$id = intval( $id );
                
                $query = $this->db->where( 'id', $id )->limit( 1 )->get( 't_mtr_holiday' );
                
                if( $query->num_rows() > 0 ) {
                    return $query->row();
                } else {
                    return array();
                }
        }
        
        public function getAll() {
                //get all records from users table
                $query = $this->db->get( 't_mtr_holiday' );
                
                if( $query->num_rows() > 0 ) {
                    return $query->result();
                } else {
                    return array();
                }
        } //end getAll
        
        public function update() {
                $data = array(
                    'tanggal' => $this->input->post( 'tanggal', true ),
                    'keterangan' => $this->input->post( 'keterangan', true )
                );
                $this->db->update( 't_mtr_holiday', $data, array( 'id' => $this->input->post( 'id', true ) ) );
        }
        
        public function delete( $id ) {
                /*
                * Any non-digit character will be excluded after passing $id
                * from intval function. This is done for security reason.
                */
                $id = intval( $id );
                $this->db->delete( 't_mtr_holiday', array( 'id' => $id ) );
        } //end delete
    
} //end class