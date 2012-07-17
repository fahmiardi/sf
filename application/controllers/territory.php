<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Territory extends CI_Controller {

	function territory()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->model('mmaster');
                $this->load->model('mservices');
		$this->load->model('mterritory');
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
        
        
        function index()
	{
                $this->tree();
		
	}
	
        function tree($proses="",$id=""){
                $data['template']       = "shell/smooth";
		$data['main_view']      = "f-territory";
		$data['jenis']          = "tree";
                $data['proses']         = $proses;
                $data['id']             = $id;
		
                #tangani proses save data
                $data['data'] = array("name"=>"","user"=>"","territory_type"=>"","parent_id"=>"");
		if($proses=="update" && $id<>""){
		    $getdata = $this->mterritory->getTerritoryById($id);
		    foreach($getdata as $r){
			$data['data']['name'] 		= $r->territory_name;
			$data['data']['user'] 	        = $r->user_id;
			$data['data']['territory_type'] = $r->territory_type_id;
                        $data['data']['parent_id'] 	= $r->parent_id;
		    }
		}
		
		#inisialisasi elemen form yang harus diisi
		$this->form_validation->set_rules('name', 'Territory Name', 'required');
		$this->form_validation->set_rules('user', 'Maintenance By', 'required');
                $this->form_validation->set_rules('territory_type', 'Territory Type', 'required');
		
		$this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->mterritory->saveTerritory($proses,$id);
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/territory/tree");
		}			
                $hasil = "";
                
                $this->load->view($data['template'],$data);
        }
        
        function chart(){
                $data['template']   = "shell/smooth";
		$data['main_view']  = "f-territory";
                $data['jenis']  = "chart";
		$data['proses']  = "";
                
                $this->load->view($data['template'],$data);
        }
        
	function territory_iframe()
	{
		$data['template'] = "f-territory-chart";
		$this->load->view($data['template'],$data);
	}
	
	function territory_json(){
	    echo($this->mterritory->getTerritoryTree());
	}

	##donnie, harap dipindah
	function territory_news_json(){
	    
            echo($this->mterritory->getTerritoryTreeForNews());
            
	}
}