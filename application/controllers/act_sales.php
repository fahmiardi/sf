<?php

class Act_sales extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'msales' );
	}
	
	public function getById( $id ) {
		if( isset( $id ) )
			echo json_encode( $this->msales->getById( $id ) );
	}
	
	public function create() {
		if( !empty( $_POST ) ) {
			echo $this->mpage->create();
			//echo 'New user created successfully!';
		}
	}
	
	public function read() {
		echo json_encode( $this->msales->getAll() );
	}
	
	public function update() {
		if( !empty( $_POST ) ) {
			$this->mpage->update();
			echo 'Record updated successfully!';
		}
	}
	
	public function delete( $id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->mpage->delete( $id );
		echo 'Records deleted successfully';
	}
} //end class
