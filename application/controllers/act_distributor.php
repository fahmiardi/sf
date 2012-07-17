<?php
class Act_distributor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'mmaster' );
	}
	
	########################################################################
	########################################################################
	public function getById( $id ) {
		if( isset( $id ) )
			echo json_encode( $this->mmaster->getDistributor( $id ) );
	}
	
	public function read() {
		echo json_encode( $this->mmaster->getDistributor() );
	}
	
	public function delete( $id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->mmaster->deleteDistributor( $id );
		echo 'Records deleted successfully';
	}
	########################################################################
	########################################################################
}