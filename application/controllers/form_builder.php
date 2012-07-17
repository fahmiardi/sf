<?php
class Form_builder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'mmaster' );
	}
	
	########################################################################
	########################################################################
	public function index(  ) {
		
                $data['template'] = "shell/smooth";
		$data['main_view']= "form-builder";
		$this->load->view($data['template'],$data);
	}
	
	
	########################################################################
	########################################################################
}