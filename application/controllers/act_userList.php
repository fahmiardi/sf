<?php
class Act_userList extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'mmaster' );
	}
	
	########################################################################
	########################################################################
	public function getById( $id ) {
		if( isset( $id ) )
			echo json_encode( $this->mmaster->getUserList ( $id ) );
	}
	
	public function read() {
		echo json_encode( $this->mmaster->getUserList() );
	}
	
	########################################################################
	########################################################################
}
