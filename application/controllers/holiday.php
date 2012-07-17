<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holiday extends CI_Controller {

	function Holiday()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->model('mmaster');
                $this->load->model('mholiday');
		$this->load->model('mglobal');
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
	
        function index($proses="",$id="")
	{
		$data['template'] = "shell/smooth";
                $data['users']    = $this->mholiday->get();
                $data['main_view']      = 'f-holiday';
		$data['proses']		= $proses;
		$data['id']	= $id;
		
		$data['data'] = array("tanggal"=>"","keterangan"=>"");
		if($proses<>"" && $id<>""){
		    $getdata = $this->mholiday->get($id);
		    foreach($getdata as $r){
			$data['data']['tanggal'] 		= $r->tanggal;
			$data['data']['keterangan'] 		= $r->keterangan;
		    }
		}
		#inisialisasi elemen form yang harus diisi
		$this->form_validation->set_rules('tanggal', 'Date', 'required');
		$this->form_validation->set_rules('keterangan', 'Information', 'required');
		
		$this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->mholiday->save($id);
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/holiday");
		}	
		
                $hasil = "";
                $this->load->view($data['template'],$data);
	}
        
        
        ########################################################################
	########################################################################
	public function getById( $id ) {
		if( isset( $id ) )
			echo json_encode( $this->mholiday->get( $id ) );
	}
	
	public function read() {
		echo json_encode( $this->mholiday->get() );
	}
	
	public function delete( $id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->mholiday->delete( $id );
		echo 'Records deleted successfully';
	}
}