<?php
class Mterritory extends CI_Model {

	function Mterritory(){
		parent::__construct();
                $this->setVars();
        }
        
        function setVars()
        {
            $this->result = '';
            $this->idnya = 0;
        }
	
	function saveTerritory($proses,$id)
        {
                $dblokal = $this->load->database("default", TRUE);
		$name 	 = $this->input->post("name");
		$parent  = $this->input->post("parent_id");
		$user 	 = $this->input->post("user");
		$territory_type = $this->input->post("territory_type");
		
		$data = array("territory_name"=>$name,
			      "parent_id"=>$parent,
			      "user_id"=>$user,
			      "territory_type_id"=>$territory_type);
		
		if($proses == "update"){ 
			$dblokal->where(array("territory_id"=>$id));
			$dblokal->update("t_mtr_territory",$data);
		}else{
			$dblokal->insert("t_mtr_territory",$data);
		}
        }
	
        function getTerritory($pid = 0, $type="")
        {    
                $dblokal  = $this->load->database("default", TRUE);
                #$dblokal->order_by("ordering", "ASC");
                $dblokal->where("parent_id", $pid);
		if($type <> "") $dblokal->where("territory_type_id", $type);
                $query = $dblokal->get("t_mtr_territory");
                return $query;
	}
	
	function getTerritoryByType($type)
        {    
                $dblokal  = $this->load->database("default", TRUE);
                $dblokal->where("territory_type_id", $type);
                $query = $dblokal->get("t_mtr_territory");
                return $query;
	}
	
	function getTerritoryById($id)
        {    
                $dblokal  = $this->load->database("default", TRUE);
                $dblokal->where("territory_id", $id);
                $query = $dblokal->get("t_mtr_territory");
                return $query->result();
	}
        
        function getTerritoryChart($id = 0,$p=0)
        {
		$p++;
                $query = $this->getTerritory($id);
                if($query->num_rows()>0){
                        $this->result .="<ul>";
                        foreach($query->result() as $r){
                                $this->result .="<li><b>". $r->territory_name ."</b><br>". $r->user_id ;
				
				if($p == 3){
					#cek punya outlet ? 
					$cek_o = $this->getTerritory($r->territory_id,5)->num_rows();
					$cek_a = $this->getTerritory($r->territory_id,6)->num_rows();
					
					if($cek_o > 0){
						$this->result .="<ul><li><b>Outlet</b>" ;
						$this->getTerritoryChartLast($r->territory_id,5);
						$this->result .="</li></ul>";
					}
					
					if($cek_a >0){
						$this->result .="<ul><li><b>Outlet</b>" ;
						$this->getTerritoryChartLast($r->territory_id,6);
						$this->result .="</li></ul>";
					}
				}else{
					$this->getTerritoryChart($r->territory_id,$p);
				}
				$this->result .="</li>";
                        }
                        $this->result .="</ul>";
                }
                return $this->result;
	}
	
	function getTerritoryChartLast($id,$type)
        {    
                $query = $this->getTerritory($id,$type);
                if($query->num_rows()>0){
                        $this->result .="<ul>";
                        foreach($query->result() as $r){
                                $this->result .="<li><b>". $r->territory_name ."</b><br>". $r->user_id ;
                                $this->result .="</li>";
                        }
                        $this->result .="</ul>";
                }
                return $this->result;
	}
        
        function getTerritoryTree($id = 0,$p=0)
        {    
                $query = $this->getTerritory($id);
                $k=0;  $p =$p+1;
                $jum = $query->num_rows();
                $this->idnya ++;
		
		if($query->num_rows()>0){
                        $this->result .='[';
                        foreach($query->result() as $r){
                                $link="<a href='".base_url()."index.php/territory/tree/add/". $r->territory_id ."'>add</a> | <a href='".base_url()."index.php/territory/tree/update/". $r->territory_id ."'>Update</a> | <a href='".base_url()."index.php/territory/tree/delete/". $r->territory_id ."'>delete</a>";
				
				$this->result .='{"id":'. $this->idnya .',
                                                "name":"'. $r->territory_name .'",
                                                "size":"'. $r->user_id .'",
                                                "date":"'. $link .'",
						"iconCls":"icon-ok"';
                                
				#cek punya children gak ?
                                $cek = $this->getTerritory($r->territory_id);$k++;
                                if($cek->num_rows()>0){
					
					if($p == 3){
						#cek punya outlet ? 
						
						$cek_o = $this->getTerritory($r->territory_id,5)->num_rows();
						$cek_a = $this->getTerritory($r->territory_id,6)->num_rows();
						
						$this->result .=',"children":';
						$this->result .= '[';
						
						if($cek_o > 0){
							$this->result .= '{"id":400, "name":"Outlet", "size":"", "date":"","children":';
							$this->getTerritoryTreeLast($r->territory_id,5);
							$this->result .= '}';
						}
						
						if($cek_o > 0 && $cek_a > 0){
							$this->result .= ',';
						}
						
						if($cek_a >0){
							$this->result .= '{"id":600, "name":"Agent", "size":"", "date":"","children":';
							$this->getTerritoryTreeLast($r->territory_id,6);
							$this->result .= '}';
						}
						
						$this->result .= ']';
						$this->result .='}';
						if($k!=$jum) $this->result .=',';
					}else{
						$this->result .=',"children":';
						$this->getTerritoryTree($r->territory_id,$p);
						$this->result .='}';
						if($k!=$jum) $this->result .=',';
					}
					
                                }else{
                                        $this->result .='}';
                                        if($k!=$jum) $this->result .=',';
                                        $this->getTerritoryTree($r->territory_id,$p);
                                }
                                
                        }
                        $this->result .="]";
                        
                }
		
                return $this->result;
	}
	
	
	function getTerritoryTreeLast($id,$type="")
        {    
                $query = $this->getTerritory($id,$type);
                $k=0;  
                $jum = $query->num_rows();
                $this->idnya ++;
		
		if($query->num_rows()>0){
                        $this->result .='[';
                        foreach($query->result() as $r){
                                $link="- - -";
				$this->result .='{"id":'. $type . $k .$this->idnya .',
                                                "name":"'. $r->territory_name .'",
                                                "size":"'. $r->user_id .'",
                                                "date":"'. $link .'"';
                                $k++;
                                $this->result .='}';
				if($k!=$jum) $this->result .=',';
                        }
                        $this->result .="]";
                }
                return $this->result;
	}
	
	###Donnie, tolong dipindah ke mnews
	function getTerritoryTreeForNews($data=null, $id = 0, $p=0) {
//Donnie        
//Avoiding recursive lookup by generating sql by depth

        $selectSQL = "SELECT t1.territory_id AS lev1, t2.territory_id as lev2, t3.territory_id as lev3 " .
                "FROM t_mtr_territory AS t1 " .
                "LEFT JOIN t_mtr_territory AS t2 ON t2.parent_id = t1.territory_id " .
                "LEFT JOIN t_mtr_territory AS t3 ON t3.parent_id = t2.territory_id " .
                "WHERE t1.parent_id = 0 ORDER BY lev1,lev2,lev3";
        //echo $selectSQL . "<br/>";
        $selectById = "SELECT territory_id as id, parent_id FROM t_mtr_territory WHERE territory_id = ?";
        $list = $this->db->query($selectSQL, array());
        $list = $list->result();
        $data = array();
        for ($i = 0; $i < sizeof($list); $i++) {
            //echo $i . "<br/>";
            $level1 = $list[$i]->lev1;
            $level2 = $list[$i]->lev2;
            $level3 = $list[$i]->lev3;
            //echo "CHECKING $level1 $level2 $level3<br/>";
            $selectById = "SELECT territory_id as id, parent_id, territory_name as text, user_id, territory_type_id, istatus,ordering FROM t_mtr_territory WHERE territory_id = ?";
            $singleElement = $this->db->query($selectById, array($level1));
            $singleLev1 = $singleElement->result();
            if (empty($data[$level1])) {
                $data[$level1] = $singleLev1[0];
            }
            if (!empty($level2)) {
                $singleElement = $this->db->query($selectById, array($level2));
                $singleLev2 = $singleElement->result();
                if (empty($data[$level1]->children[$level2])) {
                    $data[$level1]->children[$level2] = $singleLev2[0];
                }
            }
            if (!empty($level3)) {
                $singleElement = $this->db->query($selectById, array($level3));
                $singleLev3 = $singleElement->result();
                if (empty($data[$level1]->children[$level2]->children[$level3])) {
                    $data[$level1]->children[$level2]->children[$level3] = $singleLev3[0];
                }
            }
        }
        //Normalize form
        $arrayLevel1 = array();
        $arrayLevel2 = array();
        $arrayLevel3 = array();

        foreach ($data as $id1 => $level1) {

            $arrayLevel2 = array();
            $arrayLevel3 = array();
//            array_push($arrayLevel1, $level1);
            if (isset($level1->children)) {

               // echo "Children level 1 detected<br/>";
                foreach ($level1->children as $id2 => $level2) {

                    if (isset($level2->children)) {
                        foreach ($level2->children as $id3 => $level3) {
                            array_push($arrayLevel3, $level3);
                        }

                        $level2->children = array();
                        //array_push($level2->children, $arrayLevel3);
                        $level2->children = $arrayLevel3;
                    }
                    array_push($arrayLevel2, $level2);
                }
                $level1->children = array();
                //array_push($level1->children, $arrayLevel2);
                $level1->children = $arrayLevel2;
            }
            array_push($arrayLevel1, $level1);
        }


//        echo "<pre>";
//        print_r($arrayLevel1);
//        echo "</pre>";
//
//        echo "<pre>";
//        // print_r($data);
//        echo "</pre>";
        return json_encode($arrayLevel1);
    }
	
	####batas Rizky Ramadhan

	function salesOrder($act="",$page="")
	{
		$data['template'] = "shell/smooth";
        $data['main_view']     = 'f-sales';
        $this->load->view($data['template'],$data);
	}
    
    function gallery($proses = "", $id = "")
	{
		$data['template'] = "shell/smooth";
        $data['main_view']     = 'f-gallery';
        $data['proses'] = $proses;
        $data['id'] = $id;
        $data['cluster'] = $this->mmaster->getCluster();
        
        /**$data['data'] = array("name" => "", "distributor_add" => "", "distributor_id" =>
            "");
        /**if ($proses <> "" && $id <> "") {
            $getdata = $this->mmaster->getDistributor($id);
            foreach ($getdata as $r) {
                $data['data']['name'] = $r->distributor_name;
                $data['data']['distributor_add'] = $r->distributor_add;
                $data['data']['distributor_id'] = $r->distributor_id;
            }
        }*/
        
        #inisialisasi elemen form yang harus diisi
        $this->form_validation->set_rules('gallery_name', 'Gallery Name', 'required');
        $this->form_validation->set_rules('gallery_address', 'Dstributor Add','required');
        $this->form_validation->set_rules('territory_id', 'Gallery Cluster','required|numeric');
        

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');

        if ($this->form_validation->run() != false) {
            // masukkan data di sini
            $this->mmaster->saveGallery($id);
            $this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
            redirect(base_url() . "index.php/master/gallery");
        }
        $this->load->view($data['template'],$data);
	}

    /*
    function vemail_check($str)
    {
    $where = array("email"=>$str);
    if($this->uri->segment(4) <> "") $where = array("email"=>$str,"username !="=>$this->uri->segment(4));
    $v = $this->mglobal->showdata('username','t_users',$where,'dblokal');
    if ($v <> "")
    {
    $this->form_validation->set_message('vemail_check', 'Email <b>'. $str .'</b> sudah memiliki akun.');
    return FALSE;
    }
    else
    {
    return TRUE;
    }
    }*/
}