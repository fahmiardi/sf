<?php

class mpage extends CI_Model {
    
    public function create() {
        $data = array(
            'name'  => $this->input->post( 'cName', true ),
            'email' => $this->input->post( 'cEmail', true )
        );
        
        $this->db->insert( 't_menu', $data );
        return $this->db->insert_id();
    }
    
    public function getById( $id ) {
        $id = intval( $id );
        
        $query = $this->db->where( 'id', $id )->limit( 1 )->get( 't_menu' );
        
        if( $query->num_rows() > 0 ) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    public function getAll() {
        //get all records from users table
        $query = $this->db->get( 't_menu' );
        
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll
    
    public function update() {
        $data = array(
            'name' => $this->input->post( 'name', true ),
            'email' => $this->input->post( 'email', true )
        );
        
        $this->db->update( 't_menu', $data, array( 'id' => $this->input->post( 'id', true ) ) );
    }
    
    public function delete( $id ) {
        /*
        * Any non-digit character will be excluded after passing $id
        * from intval function. This is done for security reason.
        */
        $id = intval( $id );
        
        $this->db->delete( 't_menu', array( 'id' => $id ) );
    } //end delete
    
} //end class