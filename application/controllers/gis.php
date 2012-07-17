<?php 
class Gis extends CI_Controller {
	
	function Gis()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');                
                $this->load->model('musers');
                $this->load->model('mmaster');
                $this->load->model('mgis');
		#$this->is_logged_in();
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
        
        function tracking($proses="",$id="") {
            $data['template'] = "shell/smooth";         
            $data['main_view'] = 'map_tracking';	
            $data['proses'] = $proses;
            $data['id']	= $id;
            $data['hasil'] = "";            
            
            #inisialisasi elemen form yang harus diisi
		$this->form_validation->set_rules('user', 'User ID', 'required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
                
                $this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
            if ($this->form_validation->run() != FALSE){
                    // masukkan data di sini
                    $data['hasil'] = $this->mgis->getMapTracking($this->input->post("user"),$this->input->post("tanggal"));
                    
                    //$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
                    //redirect(base_url()."index.php/master/usermanagement");
            }	
  
            $this->load->view($data['template'],$data);
        }
	
        function outlet($proses="",$id="") {
            $data['template'] = "shell/smooth";         
            $data['main_view'] = 'map_outlet';	
            $data['proses'] = $proses;
            $data['id']	= $id;
            $data['hasil'] = "";   
            $data['bound'] = ""; 
            
            #inisialisasi elemen form yang harus diisi
            $this->form_validation->set_rules('territory', 'Territory ID', 'required');		

            $this->form_validation->set_error_delimiters('<li>','</li>');
            $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
            if ($this->form_validation->run() != FALSE){
                    // masukkan data di sini
                    $data['hasil'] = $this->mgis->getOutletByTerritory($this->input->post("territory"));
                    
                    $data['bound'] = $this->mgis->getTerritoryMember($this->input->post("territory"));
                    //$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
                    //redirect(base_url()."index.php/master/usermanagement");
            }	
  
            $this->load->view($data['template'],$data);
        }	
	
        function boundary($proses="",$id="") {
            $data['template'] = "shell/smooth";         
            $data['main_view'] = 'map_boundary';	
            $data['proses'] = $proses;
            $data['id']	= $id;
            $data['hasil'] = "";            
            
            #inisialisasi elemen form yang harus diisi
            $this->form_validation->set_rules('territory', 'Territory ID', 'required');		

            $this->form_validation->set_error_delimiters('<li>','</li>');
            $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
            if ($this->form_validation->run() != FALSE){
                    // masukkan data di sini
                    $data['hasil'] = $this->mgis->getBoundaryTerritory($this->input->post("territory"));
                    
                    //$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
                    //redirect(base_url()."index.php/master/usermanagement");
            }	
  
            $this->load->view($data['template'],$data);
        }	
	
        function territory_json(){
	    echo($this->mgis->getTerritoryTree());
	}
	
        function manage($proses="",$id="") {
            $data['template'] = "shell/smooth";         
            $data['main_view'] = 'map_boundary_manage';	
            $data['proses'] = $proses;
            $data['id']	= $id;
            $data['hasil'] = "";            
            
            #inisialisasi elemen form yang harus diisi
            $this->form_validation->set_rules('border', 'border', 'required');		

            $this->form_validation->set_error_delimiters('<li>','</li>');
            $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
            if ($this->form_validation->run() != FALSE){
                    // masukkan data di sini
                    $this->mgis->putBoundary();
                    $this->mgis->updateColor();
                    
                    //$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
                    redirect(base_url()."index.php/gis/boundary");
            }	
  
            $this->load->view($data['template'],$data);
        }	
}