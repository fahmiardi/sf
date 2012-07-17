<?php
class Mjourney extends CI_Model {

	function Mjourney(){
		parent::__construct();
                $this->setVars();
        }
        
        function setVars()
        {
            $this->result = '';
            $this->idnya = 0;
        }
        
        function getJourney($sfa, $bulan, $tahun)
        {
                $dblokal = $this->load->database("default", TRUE);
		
                $dblokal->select('*');
                $dblokal->from("t_jc_".$sfa);
                $dblokal->join("t_mtr_outlet", "t_mtr_outlet.outlet_id = t_jc_".$sfa.".channel_id ");
                $dblokal->where('yyyymm', $tahun.$bulan);
                $dblokal->order_by("outlet_name", "asc"); 
                $query = $dblokal->get();
                
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
        }
        
        function getJourney_ds($sfa, $bulan, $tahun)
        {
                $dblokal = $this->load->database("default", TRUE);
		
                $dblokal->select('*');
                $dblokal->from("t_jc_".$sfa);
                $dblokal->join("t_mtr_agent", "t_mtr_agent.agent_id = t_jc_".$sfa.".channel_id ");
                $dblokal->where('yyyymm', $tahun.$bulan);
                $dblokal->order_by("agent_name", "asc"); 
                $query = $dblokal->get();
                
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
        }
        
        function copyJourney($sfa, $bulan_asal, $tahun_asal, $bulan, $tahun)
        {
                $dblokal = $this->load->database("default", TRUE);
		
                $num = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
                $getJourney = $this->getJourney($sfa, $bulan_asal, $tahun_asal);
                foreach($getJourney as $r){
                        $data = array("parent_id"=>$r->parent_id,
                                      "yyyymm"=>$tahun.$bulan,
                                      "channel_id"=>$r->channel_id,
                                      "created_by"=>$this->session->userdata("username"),
                                      "created_on"=>date("Y-m-d H:i:s"));
                        for($i=1;$i<=$num;$i++){
                                $nama = "d".$i;
                                $data[$nama] = $r->{$nama};
                        }
                        $dblokal->insert("t_jc_".$sfa,$data);
                }
        }
        
        function deleteJourney($sfa,$bulan,$tahun){
                $dblokal  = $this->load->database("default", TRUE);
		$dblokal->delete("t_jc_".$sfa,array("yyyymm"=>$tahun.$bulan));                
	}
        
        function getOutlet($sfa){
                $dblokal = $this->load->database("default", TRUE);
		
                $dblokal->select('*');
                $dblokal->from("t_mtr_user_territory");
                $dblokal->join("t_mtr_outlet", "t_mtr_outlet.territory_id = t_mtr_user_territory.territory_id ");
                $dblokal->where('user_id', $sfa);
                $query = $dblokal->get();
                
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
        }
        
        function getHoliday($bulan,$tahun){
                $dblokal = $this->load->database("default", TRUE);
		
                $dblokal->select('*');
                $dblokal->from("t_mtr_holiday");
                $dblokal->like('tanggal', $tahun.$bulan, 'after'); 
                $query = $dblokal->get();
                
                if( $query->num_rows() > 0 ) {
                        return $query->result();
                } else {
                        return array();
                }
        }
	
        function insertJourney($sfa, $bulan, $tahun)
        {
                $dblokal = $this->load->database("default", TRUE);
		
                $getOutlet = $this->getOutlet($sfa);
                foreach($getOutlet as $r){
                        $data = array("parent_id"=>$r->territory_id,
                                      "yyyymm"=>$tahun.$bulan,
                                      "channel_id"=>$r->outlet_id,
                                      "created_by"=>$this->session->userdata("username"),
                                      "created_on"=>date("Y-m-d H:i:s"));
                        $dblokal->insert("t_jc_".$sfa,$data);
                }
        }
        
        function insertJourney_ds($agent, $sfa, $minggu, $tahun)
        {
                $dblokal = $this->load->database("default", TRUE);
		for($i=0;$i<count($agent);$i++){
                        #periksa dulu, data sudah ada ?
                        $ada = $this->mglobal->showdata("channel_id","t_jc_".$sfa,array("channel_id"=>$agent[$i],"yyyymm"=>$tahun.$minggu),"dblokal");
                        if($ada==""){
                                $data = array("parent_id"=>$this->mglobal->showdata("territory_id","t_mtr_agent",array("agent_id"=>$agent[$i]),"dblokal"),
                                              "yyyymm"=>$tahun.$minggu,
                                              "channel_id"=>$agent[$i],
                                              "created_by"=>$this->session->userdata("username"),
                                              "created_on"=>date("Y-m-d H:i:s"));
                                $dblokal->insert("t_jc_".$sfa,$data);
                        }
                }
        }
        
        function saveJourney($sfa, $outlet, $tgl, $bulan, $nilai)
        {
                $dblokal = $this->load->database("default", TRUE);
                $data = array("d".$tgl=>$nilai);
		
		$dblokal->where(array("channel_id"=>$outlet,"yyyymm"=>$bulan));
		$dblokal->update("t_jc_".$sfa,$data);
        }
        
        function saveJourney_ds($sfa, $outlet, $tgl, $minggu, $nilai)
        {
                $dblokal = $this->load->database("default", TRUE);
                $data = array("d".$tgl=>$nilai);
		
		$dblokal->where(array("channel_id"=>$outlet,"yyyymm"=>$minggu));
		$dblokal->update("t_jc_".$sfa,$data);
        }
        
        public function getSFA()
	{
                $dbconn  = $this->load->database("default", TRUE);
		$userlogin = $this->session->userdata('username');
		$sql = "SELECT DISTINCT ter.user_id, usr.user_name
						FROM t_mtr_territory ter
						JOIN t_mtr_user usr on ter.user_id = usr.user_id
						AND ter.parent_id = f_get_cluster('$userlogin')
						JOIN t_mtr_user_group grp on usr.user_group_id = grp.user_group_id
						AND lower(grp.user_group_name) = 'sales ambassador'
						UNION
						SELECT DISTINCT ut.user_id, usr.user_name
						FROM t_mtr_user_territory ut
						JOIN t_mtr_user usr on ut.user_id = usr.user_id
						AND usr.reporting_to = '$userlogin'
						JOIN t_mtr_user_group grp on usr.user_group_id = grp.user_group_id
						AND lower(grp.user_group_name) = 'sales ambassador'
						ORDER BY user_name";
 
		$query = $dbconn->query($sql);
		if( $query->num_rows() > 0 ) {
			return $query->result();
		} else {
			return array();
		}
	}
   
	public function getDS()
	{
		$dbconn  = $this->load->database("default", TRUE);
		$userlogin = $this->session->userdata('username');
		$sql = "SELECT DISTINCT ter.user_id, usr.user_name
						FROM t_mtr_territory ter
						JOIN t_mtr_user usr on ter.user_id = usr.user_id
						AND ter.parent_id = f_get_cluster('$userlogin')
						JOIN t_mtr_user_group grp on usr.user_group_id = grp.user_group_id
						AND lower(grp.user_group_name) = 'direct sales'
						UNION
						SELECT DISTINCT ut.user_id, usr.user_name
						FROM t_mtr_user_territory ut
						JOIN t_mtr_user usr on ut.user_id = usr.user_id
						AND usr.reporting_to = '$userlogin'
						JOIN t_mtr_user_group grp on usr.user_group_id = grp.user_group_id
						AND lower(grp.user_group_name) = 'direct sales'
						ORDER BY user_name";
     
		$query = $dbconn->query($sql);
		if( $query->num_rows() > 0 ) {
			return $query->result();
		} else {
			return array();
		}
	}
        
        function getAgent(){
                $dblokal = $this->load->database("default", TRUE);
		
                $dblokal->select('*');
                $dblokal->from("t_mtr_agent");
                $query = $dblokal->get();
                
                if( $query->num_rows() > 0 ) {
                        return $query;
                } else {
                        return array();
                }
        }
	
        function createTabel($nmTabel){
                
                $dblokal = $this->load->database("default", TRUE);
                if(!$dblokal->table_exists($nmTabel)){
                        $this->load->dbforge();
                        $fields = array(
                                        'jc_id' => array(
                                                        'type' => 'INT',
                                                        'constraint' => 32, 
                                                        'unsigned' => TRUE,
                                                        'auto_increment' => TRUE
                                                ),
                                        'parent_id' => array(
                                                        'type' => 'INT',
                                                        'constraint' => 32
                                                ),
                                        'yyyymm' => array(
                                                        'type' => 'varchar',
                                                        'constraint' => 6
                                                ),
                                        'channel_id' => array(
                                                        'type' => 'varchar',
                                                        'constraint' => 20
                                                ),
                                        'd1' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd2' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd3' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd4' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd5' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd6' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd7' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd8' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd9' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd10' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd11' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd12' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd13' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd14' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd15' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd16' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd17' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd18' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd19' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd20' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd21' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd22' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd23' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd24' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd25' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd26' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd27' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd28' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd29' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd30' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'd31' => array('type' => 'INT', 'constraint' => 16, 'NULL' => TRUE),
                                        'created_by' => array(
                                                        'type' => 'varchar',
                                                        'constraint' => 30,
                                                        'NULL' => TRUE
                                                ),
                                        'created_on' => array(
                                                        'type' => 'date', 'NULL' => TRUE
                                                ),
                                        'updated_by' => array(
                                                        'type' => 'varchar',
                                                        'constraint' => 30, 'NULL' => TRUE
                                                ),
                                        'updated_on' => array(
                                                        'type' => 'date', 'NULL' => TRUE
                                                )
                                );
                        $this->dbforge->add_field($fields);
                        $this->dbforge->add_key('jc_id', TRUE);
                        $this->dbforge->create_table($nmTabel);
                }
        }
        
        ######################
        ### Get JSON DATA
        
        function getWeek_json()
        {    
                $k=0;  
                $this->idnya ++;
		
		$this->result .='[';
		for($b=1;$b<=54;$b++){
			$link = base_url() ."index.php/journey_cycle/direct_sales/". $b;
			
			$this->result .='{"week":"Week '. $b .'",
                                                "mulai":"'. $this->mglobal->getDays($b,2012) .'",
                                                "selesai":"2",
						"link":"'. $link .'"}';
			if($b!=54) $this->result .=',';
		}
		$this->result .="]";
                return $this->result;
	}
	
        
        
	function getAgent_json()
        {    
                $k=0;  
                $this->idnya ++;
		$getAgent = $this->getAgent();
		$this->result .='[';
		foreach($getAgent->result() as $r){
                        $k++;
			$this->result .='{"tid":"'. $r->territory_id .'",
                                                "id":"'. $r->agent_id .'",
                                                "name":"'. $r->agent_name .'",
                                                "city":"'. $r->agent_city .'"}';
			if($k!=$getAgent->num_rows) $this->result .=',';
		}
		$this->result .="]";
                return $this->result;
	}
}