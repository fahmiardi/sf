<?php
class Act_services_show_data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'mservices' );
	}
	
	########################################################################
	########################################################################
	public function getById( $tabel,$id ) {
		if( isset( $id ) )
			echo json_encode( $this->mservices->getDataByTable( $tabel,$id ) );
	}
	
	public function read($tabel) {
		echo json_encode( $this->mservices->getDataByTable($tabel) );
	}
	
	public function delete( $tabel,$id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->mservices->deleteDataByTable( $id, $tabel );
		echo 'Records deleted successfully';
	}
	########################################################################
	########################################################################
}