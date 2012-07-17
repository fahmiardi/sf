<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journey_cycle extends CI_Controller {

	function journey_cycle()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->model('mmaster');
                $this->load->model('mservices');
		$this->load->model('mterritory');
		$this->load->model('mjourney');
		$this->load->model('musers');
		$this->is_logged_in();
		#$this->mjadwal->saveLog();
	}
        
        function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect(base_url() .'index.php/login');
		}		
	}
        
        function index($sfa="",$bulan=""){
                $data['template']       = "shell/smooth";
		$data['main_view']      = "f-journey-cycle";
		
		#if($bulan=="") $bulan = date('m');
                $data['sfa']            = $sfa;
                $data['bulan']          = $bulan;
		$data['tahun']          = date("Y");
		$data['getSFA']		= $this->mjourney->getSFA();
		
		$data['getJourney'] = array();
		$data['getHoliday'] = array();
		
		$data['cluster'] = "-";
		$data['region']="-";
			
		if($sfa<>"" && $bulan <> ""){
			$this->mjourney->createTabel("t_jc_".$sfa);
			
			$data['getHoliday']	= $this->mjourney->getHoliday($bulan,date("Y"));
			
			$ter_id = $this->mglobal->showdata("territory_id","t_mtr_user_territory",array("user_id"=>$data['sfa']),"dblokal");
			$par_id = "";
			$reg_id = "";
			if($ter_id <> ""){
				$par_id = $this->mglobal->showdata("parent_id","t_mtr_territory",array("territory_id"=>$ter_id),"dblokal");
				$reg_id = $this->mglobal->showdata("parent_id","t_mtr_territory",array("territory_id"=>$par_id),"dblokal");
				$data['cluster'] = $this->mglobal->showdata("territory_name","t_mtr_territory",array("territory_id"=>$par_id),"dblokal");
				$data['region'] = $this->mglobal->showdata("territory_name","t_mtr_territory",array("territory_id"=>$reg_id),"dblokal");
			}
			
			$getJourney 	= $this->mjourney->getJourney($data['sfa'],$bulan,$data['tahun']);
			if(count($getJourney)==0){
				#input data journey
				$this->mjourney->insertJourney($data['sfa'],$bulan,$data['tahun']);
			}
			$data['getJourney'] 	= $this->mjourney->getJourney($data['sfa'],$bulan,$data['tahun']);
		
		}
		
                $this->load->view($data['template'],$data);
        }
	
	function smartfren_ambassador($sfa="",$bulan=""){
		$this->index($sfa,$bulan);
	}
	
	function direct_sales($sfa="",$minggu=""){
                $data['template']       = "shell/smooth";
		$data['main_view']      = "f-journey-cycle-direct-sales";
		
		#if($bulan=="") $bulan = date('m');
                $data['sfa']            = $sfa;
                $data['minggu']          = $minggu;
		$data['tahun']          = date("Y");
		$data['getDS']		= $this->mjourney->getDS();
		$data['getAgent']	= $this->musers->getUser();;//$this->mterritory->getTerritoryByType(5);
		
		$data['getJourney'] = array();
		$data['getHoliday'] = array();
		
		$data['cluster'] = "-";
		$data['region']="-";
		
		
		if($this->input->post("submit")){
			$c_agent = $this->input->post("c_agent");
			$this->mjourney->insertJourney_ds($c_agent,$sfa,$minggu,date("Y"));
		}
		
		
		if($sfa<>"" && $minggu <> ""){
			$this->mjourney->createTabel("t_jc_".$sfa);
			$data['getHoliday']	= "";//$this->mjourney->getHoliday($bulan,date("Y"));
			
			$ter_id = $this->mglobal->showdata("territory_id","t_mtr_user_territory",array("user_id"=>$data['sfa']),"dblokal");
			$par_id = "";
			$reg_id = "";
			if($ter_id <> ""){
				$par_id = $this->mglobal->showdata("parent_id","t_mtr_territory",array("territory_id"=>$ter_id),"dblokal");
				$reg_id = $this->mglobal->showdata("parent_id","t_mtr_territory",array("territory_id"=>$par_id),"dblokal");
				$data['cluster'] = $this->mglobal->showdata("territory_name","t_mtr_territory",array("territory_id"=>$par_id),"dblokal");
				$data['region'] = $this->mglobal->showdata("territory_name","t_mtr_territory",array("territory_id"=>$reg_id),"dblokal");
			}
			
			$data['getJourney'] 	= $this->mjourney->getJourney_ds($data['sfa'],$minggu,$data['tahun']);
		
		}
		
		
                $this->load->view($data['template'],$data);
        }
	
	function saveJC(){
		$nilai = $this->input->post("nilai");
		$sfa = $this->input->post("sfa"); //$this->session->userdata("username");
		$outlet = $this->input->post("outlet");
		$tgl = $this->input->post("tgl");
		$bulan = $this->input->post("bulan");
		
		if($nilai == true){$nilai = 1;}else{$nilai = 0;}
		$this->mjourney->saveJourney($sfa,$outlet,$tgl,$bulan,$nilai);
	}
	
	function saveJC_ds(){
		$nilai = $this->input->post("nilai");
		$sfa = $this->input->post("sfa"); //$this->session->userdata("username");
		$outlet = $this->input->post("outlet");
		$tgl = $this->input->post("tgl");
		$minggu = $this->input->post("minggu");
		
		if($nilai == true){$nilai = 1;}else{$nilai = 0;}
		$this->mjourney->saveJourney($sfa,$outlet,$tgl,$minggu,$nilai);
	}
	
	function copyJC(){
		$sfa = $this->input->post("sfa"); //$this->session->userdata("username");
		$bulan = date("m");
		$tahun = date("Y");
		$bulan_asal = $this->input->post("bulan");
		$tahun_asal = $this->input->post("tahun");
		
		$this->mjourney->deleteJourney($sfa,$bulan,$tahun);
		$this->mjourney->copyJourney($sfa,$bulan_asal,$tahun_asal,$bulan,$tahun);
		
		echo json_encode(array(
			'status'=>'OK',
			'pesan' => 'Success to Copy Journey Cycle'
		));
		return; 
	}
	
	####################
	### Get JSON DATA
	function week_json(){
	    echo($this->mjourney->getWeek_json());
	}
	function agent_json(){
	    echo($this->mjourney->getAgent_json());
	}
}