<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function main()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->model('mmaster');
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
        
        function welcome()
	{
		$data['template'] = "shell/smooth";
		$data['main_view']= "f-welcome";
		$this->load->view($data['template'],$data);
	}
        
        function login()
	{
		$data['template'] = "login-page";
		$this->load->view($data['template']);
	}
        
}