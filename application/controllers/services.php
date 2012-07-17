<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

	function services()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
                $this->load->model('mglobal');
		$this->load->model('mmaster');
                $this->load->model('mservices');
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
        
        public function index($proses="",$id="") {
                $data['template'] = "shell/smooth";
		$data['main_view']= "f-services";
		$data['proses']         = $proses;
                $data['id']             = $id;
		
                #tangani proses save data
                $data['data'] = array("name"=>"","tabel"=>"");
		/*
                if($proses=="update" && $id<>""){
		    $getdata = $this->mservices->getService($id);
		    foreach($getdata as $r){
			$data['data']['name'] 		= $r->territory_name;
			$data['data']['user'] 	        = $r->user_id;
		    }
		}*/
		
		#inisialisasi elemen form yang harus diisi
		$this->form_validation->set_rules('name', 'Service Name', 'required');
				
		$this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->mservices->saveService();
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
		}			
                $hasil = "";
                
                $data['getComponent']   = $this->mservices->getComponent(1);
                $this->load->view($data['template'],$data);
	}
        
        function manage_field($id)
	{
		$data['template']       = "shell/smooth";
		$data['main_view']      = "f-services-manage";
		$data['id']             = $id;
                $data['getComponent']   = $this->mservices->getComponent($id);
                
                if($this->input->post("nama")){
                        $this->mservices->saveComponent($id);
			redirect(base_url()."index.php/services/manage_field/".$id);
                }
                $this->load->view($data['template'],$data);
	}
        
        function delete_component($id,$idc){
                $this->mservices->deleteComponent($idc);
                redirect(base_url()."index.php/services/manage_field/".$id);
        }
        
        ########
        function load_component(){
                $data['jenis'] = $this->input->post("jenis");
                $pesan = $this->load->view("f-services-component",$data,TRUE);
                
                echo json_encode(array(
                        'status'=>'OK',
                        'pesan'=>$pesan
                        
                ));
                return;
        }
        
        function show_data($tabel){
                $data['template']       = "shell/smooth";
		$data['main_view']      = "f-services-show-data";
                $data['tabel']          = $tabel;
                $id = $this->mglobal->showdata("services_id","t_trx_service",array('services_tabel'=>$tabel),"dblokal");
                $data['id']          = $id;
                $data['getComponent']   = $this->mservices->getComponent($id);
                
                $this->load->view($data['template'],$data);
        }
        
        ################## u/manage data
        public function read() {
		echo json_encode( $this->mservices->getService() );
	}
	
	public function delete( $id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->mservices->deleteService( $id );
		echo 'Records deleted successfully';
	}
}