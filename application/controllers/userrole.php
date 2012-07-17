<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userrole extends CI_Controller {

	function Userrole()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
                $this->load->model('muserrole');
		$this->load->model('mmaster');
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
	
        function index($group="")
	{
		$data['template'] = "shell/smooth-side";
                $data['getUserGroup']   = $this->muserrole->getUserGroup();
                $data['group']          = $group;
                $data['main_view']      = 'f-user-role';
                
                $this->load->view($data['template'],$data);
	}
        
        function saveUserRole(){
                $group = $this->input->post("groupid");
                $menu  = $this->input->post("menuid");
                $nilai  = $this->input->post("nilai");
                $this->muserrole->saveUserRole($group,$menu,$nilai);
        }
}