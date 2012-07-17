<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_management extends CI_Controller {

	function User_management()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
                $this->load->model('muserrole');
		$this->load->model('mmaster');
                $this->load->model('musers');
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
		$data['template'] = "shell/smooth-side";
                $data['users']    = $this->musers->getUser();
                $data['main_view']      = 'f-users';
		$data['proses']		= $proses;
		$data['id']	= $id;
		
		$data['data'] = array("name"=>"","username"=>"","nik"=>"","usergroup"=>"","reportingto"=>"","hape"=>"","email"=>"");
		if($proses<>"" && $id<>""){
		    $getdata = $this->musers->getUser($id);
		    foreach($getdata as $r){
			$data['data']['name'] 		= $r->user_name;
			$data['data']['email'] 		= $r->email;
			$data['data']['username'] 	= $r->user_id;
			$data['data']['nik'] 	        = $r->nik;
                        $data['data']['usergroup'] 	= $r->user_group_id;
                        $data['data']['reportingto'] 	= $r->reporting_to;
                        $data['data']['hape'] 	        = $r->mobile_number;
		    }
		}
		
                if($proses <> "update"){
                        #inisialisasi elemen form yang harus diisi
                        $this->form_validation->set_rules('name', 'Name', 'required');
                        $this->form_validation->set_rules('username', 'Username', 'required|callback_vuserid_check');
                        $this->form_validation->set_rules('nik', 'NIK', 'required|callback_vnik_check');
                        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_vemail_check');
                        $this->form_validation->set_rules('hape', 'Mobile Number', 'required');
                        
                }else{
                        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_vemail_check');
                        $this->form_validation->set_rules('hape', 'Mobile Number', 'required');
                }
                
                $this->form_validation->set_error_delimiters('<li>','</li>');
                $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                $this->form_validation->set_message('valid_email', 'Kolom <b>%s</b> harus diisi dengan alamat email yang benar.');
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->musers->saveUser($id);
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/user_management");
		}	
		
                $hasil = "";
                $this->load->view($data['template'],$data);
	}
        
        
        function change_password()
	{
		$data['template'] = "shell/smooth";
                $data['users']    = $this->musers->getUser();
                $data['main_view']      = 'f-user-change-password';
		
                #inisialisasi elemen form yang harus diisi
                $this->form_validation->set_rules('old-password', 'Old Password', 'required|callback_voldpwd_check');
                $this->form_validation->set_rules('new-password', 'New Password', 'required|min_length[5]');
                $this->form_validation->set_rules('re-new-password', 'Retype New Password', 'required|callback_vpassword_check');
                $this->form_validation->set_error_delimiters('<li>','</li>');
                $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->musers->change_password($this->session->userdata('username'));
			$this->session->set_flashdata('message', 'Password Anda Berhasil diganti');
			redirect(base_url()."index.php/user_management/change_password");
		}
                $this->load->view($data['template'],$data);
	}
        
        
        ########################################################################
	########################################################################
	public function getById( $id ) {
		if( isset( $id ) )
			echo json_encode( $this->musers->getUser( $id ) );
	}
	
	public function read() {
		echo json_encode( $this->musers->getUser() );
	}
	
	public function delete( $id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->musers->deleteUser( $id );
		echo 'Records deleted successfully';
	}
        
        
        ##################################################
        #################################################
        function vemail_check($str)
	{
		$where = array("email"=>$str);
		if($this->uri->segment(4) <> "") $where = array("email"=>$str,"user_id !="=>$this->uri->segment(4));
		$v = $this->mglobal->showdata('user_id','t_mtr_user',$where,'dblokal');
		if ($v <> "")
		{
			$this->form_validation->set_message('vemail_check', 'Email <b>'. $str .'</b> sudah digunakan oleh akun lain.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
        function vuserid_check($str)
	{
		$where = array("user_id"=>$str);
                if($this->uri->segment(4) <> "") $where = array("email"=>$str,"user_id !="=>$this->uri->segment(4));
		$v = $this->mglobal->showdata('user_id','t_mtr_user',$where,'dblokal');
		if ($v <> "")
		{
			$this->form_validation->set_message('vuserid_check', 'Username <b>'. $str .'</b> sudah digunakan oleh akun lain.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
        function vnik_check($str)
	{
		$where = array("nik"=>$str);
		$v = $this->mglobal->showdata('nik','t_mtr_user',$where,'dblokal');
		if ($v <> "")
		{
			$this->form_validation->set_message('vnik_check', 'NIK <b>'. $str .'</b> sudah digunakan oleh akun lain.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
        function vpassword_check()
	{
		
		if ($this->input->post('new-password') <> $this->input->post('re-new-password'))
		{
			$this->form_validation->set_message('vpassword_check', '<b>New Password</b> dan <b>Retype New Password</b> harus sama.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
        function voldpwd_check()
	{
		$where = array("user_id"=>$this->session->userdata('username'),"user_password"=>md5($this->input->post('old-password')));
		$v = $this->mglobal->showdata('user_id','t_mtr_user',$where,'dblokal');
		if ($v == "")
		{
			$this->form_validation->set_message('voldpwd_check', 'Password Lama Anda salah.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
        function user_json(){
	    echo($this->musers->getUserTree());
           
	}
}