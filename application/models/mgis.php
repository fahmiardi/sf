<?php
class Mgis extends CI_Model {

	function Mgis(){
		parent::__construct();
                $this->idnya = "";
                $this->result = "";
                $this->result_array = array();
	}
	
	public function getMapTracking($user_id, $tanggal ) {        

            //$query = $this->db->where(array('user_id' =>$user_id,'track_date'=>$tanggal))->get('t_trx_track');
            $query = $this->db->query("select * from t_trx_track where user_id = '$user_id' and track_date = '$tanggal' and lon <> '0.0' and lat <> '0.0' order by track_id");
            
            if( $query->num_rows() > 0 ) {
                return $query->result();  
                //return $query->result_array();  
            } else {
                return array();
            }
        }
        
        public function getUser89() {
                   
            $query = $this->db->query("select a.* from t_mtr_user a, t_mtr_user_group b where a.user_group_id = b.user_group_id and (b.user_group_id = '8' or b.user_group_id = '9') order by b.user_group_id asc");
            
            if( $query->num_rows() > 0 ) {
                return $query->result();  
                //return $query->result_array();  
            } else {
                return array();
            }
        }
        
        public function getTerritory() {
        

            $query = $this->db->query("select a.* from t_mtr_territory a order by territory_id,parent_id asc");
            //$query = $this->db->query("");
            
            if( $query->num_rows() > 0 ) {
                return $query->result();  
                //return $query->result_array();  
            } else {
                return array();
            }
        }
        
         public function getTerritoryById($territory_id) {
        

            $query = $this->db->query("select * from t_mtr_territory where territory_id = '$territory_id'");
            //$query = $this->db->query("");
            
            if( $query->num_rows() > 0 ) {
                //return $query->result();  
                return $query->row_array();  
            } else {
                return array();
            }
        }
        
        public function getOutlet() {
        

            $query = $this->db->query("select * from t_mtr_outlet");
            //$query = $this->db->query("");
            
            if( $query->num_rows() > 0 ) {
                return $query->result();  
                //return $query->result_array();  
            } else {
                return array();
            }
        }
        
        public function getOutletByTerritory($territory_id) {
        
            $q = $this->getTerritoryMember($territory_id);
            $jum = array_count_values($q);                       
            if($jum > 0){  
                $sql = "select * from t_mtr_outlet ";
                
                $i = 0;
                foreach($q as $r){  
                    if($i == 0) {
                        $sql .= "where territory_id = '$r' ";
                    }else {
                        $sql .= "or territory_id = '$r' ";
                    }
                    $i++;
                }
            }
            $query = $this->db->query($sql);
            //$query = $this->db->query("");
            
            if( $query->num_rows() > 0 ) {
                return $query->result();  
                //return $query->result_array();  
            } else {
                return array();
            }
        }
        
        public function getTerritoryMember($id)
        {    
           $this->result_array[] = $id;
                $query = $this->getTerritoryDody($id);
                $k=0;
                $jum = $query->num_rows();                         
                if($query->num_rows()>0){                        
                        foreach($query->result() as $r){                                
                                $this->result_array[] = $r->territory_id;
                                
                                #cek punya children gak ?
                                $cek = $this->getTerritoryDody($r->territory_id);$k++;
                                if($cek->num_rows()>0){
                                        $this->result_array[] = $r->territory_id;
                                        
                                        $this->getTerritoryMember($r->territory_id);
                                       
                                }
                                
                        }                      
                        
                }
                return  $this->result_array;
	}
	
        public function getBoundaryTerritory($territory_id) {
        

            $query = $this->db->query("select * from t_mtr_territory_border where territory_id = '$territory_id'");
            //$query = $this->db->query("");
            
            if( $query->num_rows() > 0 ) {
                return $query->result();  
                //return $query->result_array();  
            } else {
                return array();
            }
        }
        
        function getTerritoryDody($pid = 0)
        {    
                $dblokal  = $this->load->database("default", TRUE);
                $dblokal->order_by("ordering", "ASC");
                $dblokal->where("parent_id", $pid);
                $query = $dblokal->get("t_mtr_territory");
                return $query;
	}
        
        
        function getTerritoryTree($id = 0)
        {    
                $query = $this->getTerritoryDody($id);
                $k=0;
                $jum = $query->num_rows();                         
                if($query->num_rows()>0){
                        $this->result .='[';
                        foreach($query->result() as $r){                                
                                $this->result .='{"id":'. $r->territory_id .',
                                                "text":"'. $r->territory_name .'",
                                                "state":"open"';
                                #cek punya children gak ?
                                $cek = $this->getTerritoryDody($r->territory_id);$k++;
                                if($cek->num_rows()>0){
                                        $this->result .=',"children":';
                                        $this->getTerritoryTree($r->territory_id);
                                        $this->result .='}';
                                        if($k!=$jum) $this->result .=',';
                                }else{
                                        $this->result .='}';
                                        if($k!=$jum) $this->result .=',';
                                        $this->getTerritoryTree($r->territory_id);
                                }
                                
                        }
                        $this->result .="]";
                        
                }
                return $this->result;
	}
        
        public function putBoundary() {
            $data = array();
            
            if($this->input->post("border") <> "") {                
                $this->db->delete( 't_mtr_territory_border', array( 'territory_id' => $this->input->post("territory") ) );
                
                $geo = explode(";",$this->input->post("border"));
                $sum_array = count($geo);
                $x = 0;
                if($sum_array > 0) {
                    foreach($geo as $v => $x) {
                        if($x <> "") {
                            $latlng = explode(",",$x);                     
                            
                            $data[$x] = array(
                                "territory_id" => $this->input->post("territory"),
                                "lat" => $latlng[0],
                                "lon" => $latlng[1]
                            );
                            $x++;
                        }
                    }     
                }
            }

            $this->db->insert_batch( 't_mtr_territory_border', $data );
            return $this->db->insert_id();
        }
        
        public function updateColor() {
            $data = array(
                'fill_color' => $this->input->post( 'fillcolor', true ),
                'border_color' => $this->input->post( 'bordercolor', true )
            );

            $this->db->update( 't_mtr_territory', $data, array( 'territory_id' => $this->input->post( 'territory', true ) ) );
        }
}