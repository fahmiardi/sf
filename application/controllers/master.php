<?php 
class Master extends CI_Controller {
	
	function master()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
                $this->load->model('mmaster');
                $this->load->model('mglobal');
		#$this->is_logged_in();
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
	
	function usermanagement($proses="",$id="")
	{
		$data['template'] = "shell/smooth";
                $data['users']    = $this->mmaster->getUser();
                $data['main_view']      = 'f-users';
		$data['proses']		= $proses;
		$data['id']	= $id;
		
		$data['data'] = array("name"=>"","email"=>"","username"=>"","password"=>"");
		if($proses<>"" && $id<>""){
		    $getdata = $this->mmaster->getUser($id);
		    foreach($getdata as $r){
			$data['data']['name'] 		= $r->name;
			$data['data']['email'] 		= $r->email;
			$data['data']['username'] 	= $r->username;
			$data['data']['password'] 	= $r->password;
		    }
		}
		#inisialisasi elemen form yang harus diisi
		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_vemail_check');
		
		$this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
		$this->form_validation->set_message('valid_email', 'Kolom <b>%s</b> harus diisi dengan alamat email yang benar.');
                
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->mmaster->saveUser($id);
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/master/usermanagement");
		}	
		
                $hasil = "";
                $this->load->view($data['template'],$data);
	}
        
        
        function distributor($proses="",$id="")
	{
		$data['template'] = "shell/smooth";
                $data['users']    = $this->mmaster->getDistributor();
                $data['main_view']      = 'f-distributor';
		$data['proses']		= $proses;
		$data['id']	= $id;
		
		$data['data'] = array("name"=>"","distributor_add"=>"","distributor_id"=>"");
		if($proses<>"" && $id<>""){
		    $getdata = $this->mmaster->getDistributor($id);
		    foreach($getdata as $r){
			$data['data']['name'] 		        = $r->distributor_name;
			$data['data']['distributor_add'] 	= $r->distributor_add;
			$data['data']['distributor_id'] 	= $r->distributor_id;
		    }
		}
		
		#inisialisasi elemen form yang harus diisi
		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_rules('distributor_add', 'Dstributor Add', 'required');
		
		$this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->mmaster->saveDistributor($id);
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/master/distributor");
		}	
		
                $hasil = "";
                $this->load->view($data['template'],$data);
	}
        
        //Donnie
    function news($proses="add", $id="") {
        $this->load->model('Ext_Mnews');

        $data['template'] = "shell/smooth";
        $data['users'] = $this->mmaster->getUser();
        $data['main_view'] = 'ext-f-news';
        $data['proses'] = $proses;
        $data['id'] = $id;

        $data['data'] = array("news_header" => "", "news_content" => "", "territory_id" => "");
        if ($proses <> "" && $id <> "") {
            $getdata = $this->Ext_Mnews->selectById($id);
            foreach ($getdata as $r) {
                $data['data']['news_header'] = $r->news_header;
                $data['data']['news_content'] = $r->news_content;
                $data['data']['territory_id'] = $r->territory_id;
            }
        }
        #inisialisasi elemen form yang harus diisi
        $this->form_validation->set_rules('news_header', 'News Header', 'required');
        $this->form_validation->set_rules('news_content', 'News Content', 'required');
        $this->form_validation->set_rules('territory_id', 'Territory ID', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');

        if ($this->form_validation->run() != FALSE) {
            // masukkan data di sini
            $territoryIdList = $this->input->post("territory_id");
            $newsHeader = $this->input->post("news_header");
            $newsContent = $this->input->post("news_content");
            for ($i = 0; $i < sizeof($territoryIdList); $i++) {
                $territoryId = $territoryIdList[$i];
                if ($proses == "add") {
                    $this->Ext_Mnews->insert($territoryId, $newsHeader, $newsContent, $this->session->userdata("username"));
                } else if ($proses == "update") {
                    $this->Ext_Mnews->update($territoryId, $newsHeader, $newsContent, $this->session->userdata("username"), $id);
                }
            }
            $this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
            redirect(base_url() . "index.php/master/news/");
        }

        $hasil = "";
        $this->load->view($data['template'], $data);
    }

    function agents($proses="",$id="")
	{
		$data['template'] = "shell/smooth";
		//$data['users']    = $this->mmaster->getAgents();
		$data['main_view']      = 'f-agents';
		$data['proses']		= $proses;
		$data['id']	= $id;
		
		$arr = array( 'agent_status', 'identity', 'o_location', 'o_type', 'b_focus' );
		
		foreach( $arr as $combo )
		{
			$query = $this->mmaster->getComboData( $combo );
			
			$i = 0;
			
			foreach( $query->result() as $r )
			{
				$data[ 'data' ][ $combo ][ 'member_value' ][ $i ] = $r->member_value;
				$data[ 'data' ][ $combo ][ 'member_display' ][ $i ] = $r->member_display;
				$i++;
			}
		}
		
		
		$query = $this->mmaster->getRecord( 't_mtr_province' );
		$i = 0;
		foreach( $query->result() as $r )
		{
			$data[ 'data' ][ 'province' ][ $i ] = $r->province_name;
			$i++;
		}
		
		$usr_id = $this->session->userdata( 'username' );
		$query = $this->mmaster->getTerritory( $usr_id );
		$row = $query->row();
		$result = '';
		
		if( $query->num_rows() == 0 )
			$data[ 'data' ][ 'path' ] = 'You are not a cluster responsible person';
		else
		{
			$parent_id = $row->parent_id;
			$result = $row->territory_name;
			$territory_id = $row->territory_id;
			$data[ 'data' ][ 'territory_id' ] = $territory_id;
			$t_id = $territory_id;
			
			while( $parent_id != 0 )
			{	
				$query = $this->mmaster->getTerritory( $parent_id );
				$row = $query->row();
				$parent_id = $row->parent_id;
				$result = $row->territory_name.' -> '.$result;
				$territory_id = $row->territory_id;				
			}
			
			$data[ 'data' ][ 'path' ] = $result;
		}

		$query = $this->mmaster->getMaintainName();
		$i = 0;
		
		foreach( $query->result() as $r )
		{
			$data[ 'data' ][ 'username' ][ $i ] = $r->user_name;
			$data[ 'data' ][ 'pos' ][ $i ] = $this->mmaster->getPosition( $r->user_id )->row()->user_group_name;
			$i++;
		}
		/*$data['data'] = array("name"=>"","address"=>"","teritory_id"=>"");
		if($proses<>"" && $id<>""){
		    $getdata = $this->mmaster->getAgents($id);
		    foreach($getdata as $r){
			$data['data']['name'] 		= $r->agent_name;
			$data['data']['address'] 	= $r->address;
			$data['data']['teritory_id'] 	= $r->teritory_id;
		    }
		}*/
		
		#inisialisasi elemen form yang harus diisi
		/*
		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_rules('address', 'Alamat', 'required');
                $this->form_validation->set_rules('teritory_id', 'Territory', 'required');
		
		$this->form_validation->set_error_delimiters('<li>','</li>');
		$this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
		if ($this->form_validation->run() != FALSE){
			// masukkan data di sini
			$this->mmaster->saveAgents($id);
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/master/agents");
		}*/			
                $hasil = "";
                $this->load->view($data['template'],$data);
	}
//End news and agents
	
        public function readuser() {
		echo json_encode( $this->mmaster->getUser() );
	}
	
	function pagemanagement($act="",$page="")
	{
		$data['template'] = "shell/smooth";
                $data['main_view']     = 'f-pages';
                $this->load->view($data['template'],$data);
	}
	
	
	
	/* @author: Willy Halim Dinata
	 * @function: controller dari halaman outlet
	 */
	function outlets()
	{
		$data['template'] = "shell/smooth";
		$data['main_view'] = "f-outlets";
		
		
		/****************************** ISI COMBO**********************************/
		$arr = array( 'building', 'gender', 'religion', 'identity', 'o_status', 'o_type', 'o_size', 'o_location', 'o_ownership', 'b_structure', 'b_focus', 
				'b_size', 'c_type', 'l_package', 'e_package', 'position', 'full_branding', 'outbond' );
		
		foreach( $arr as $combo )
		{
			$query = $this->mmaster->getComboData( $combo );
			$i = 0;
			foreach( $query->result() as $r )
			{
				$data[ 'data' ][ $combo ][ 'member_value' ][ $i ] = $r->member_value;
				$data[ 'data' ][ $combo ][ 'member_display' ][ $i ] = $r->member_display;
				$i++;
			}
		}
		
		/**************************** ISI COMBO PROVINCE *****************************/
		$query = $this->mmaster->getRecord( 't_mtr_province' );
		$i = 0;
		foreach( $query->result() as $r )
		{
			$data[ 'data' ][ 'province' ][ $i ] = $r->province_name;
			$i++;
		}
		
		/*******************************ISI TERRITORY PATH******************************/
		$usr_id = $this->session->userdata( 'username' );
		$query = $this->mmaster->getTerritory( $usr_id );
		$row = $query->row();
		$result = '';
		
		$parent_id = $row->parent_id;
		$result = $row->territory_name;
		$territory_id = $row->territory_id;
		$data[ 'data' ][ 'territory_id' ] = $territory_id;
		$t_id = $territory_id;
		
		while( $parent_id != 0 )
		{	
			$query = $this->mmaster->getTerritory( $parent_id );
			$row = $query->row();
			$parent_id = $row->parent_id;
			$result = $row->territory_name.' -> '.$result;
			$territory_id = $row->territory_id;				
		}
		
		$data[ 'data' ][ 'path' ] = $result;
		
		/************* ISI COMBO FIELD NAME PADA MAINTAINED BY *************************/
		$query = $this->mmaster->getMaintainName();
		$i = 0;
		foreach( $query->result() as $r )
		{
			$data[ 'data' ][ 'username' ][ $i ] = $r->user_name;
			$data[ 'data' ][ 'pos' ][ $i ] = $this->mmaster->getPosition( $r->user_id )->row()->user_group_name;
			$i++;
		}
	
		/*************** GENERATE ID DUMMY ****************/
		$data[ 'data' ][ 'outlet_id' ] = $this->mmaster->generateID();
		
		
		/******************************** VALIDATION *************************/
		$this->form_validation->set_rules( 'name_owner', 'Owner Name', 'required|alpha|max_length[30]' );
		$this->form_validation->set_rules( 'outlet_name', 'Outlet Name', 'required|max_length[255]' );
		$this->form_validation->set_rules( 'address', 'Outlet Address', 'required|max_length[255]' );
		$this->form_validation->set_rules( 'city', 'Outlet City', 'required|max_length[100]' );
		$this->form_validation->set_rules( 'province', 'Province', 'required|max_length[100]' );
		$this->form_validation->set_rules( 'post_code', 'Post Code', 'numeric|max_length[10]' );
		$this->form_validation->set_rules( 'employee_nume', 'Employee Number', 'numeric|max_length[10]' );
		$this->form_validation->set_rules( 'birth_place', 'Birth Place', 'max_length[50]' );
		$this->form_validation->set_rules( 'birth_date', 'Birth Date', 'required' );
		$this->form_validation->set_rules( 'email', 'Email', 'valid_email|max_length[50]' );
		$this->form_validation->set_rules( 'phone', 'Phone', 'integer|max_length[20]' );
		$this->form_validation->set_rules( 'identity_number', 'Identity Number', 'integer|max_length[50]' );
		$this->form_validation->set_rules( 'branding_value', 'Branding Value', 'numeric' );
		$this->form_validation->set_rules( 'identity_number', 'Identity Number', 'integer|max_length[50]' );
		
		
		if( $this->form_validation->run() != FALSE )
		{
			$this->mmaster->saveOutlets();
			$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
			redirect(base_url()."index.php/master/outlets");
		}		
		
		$this->load->view($data['template'],$data);
	}
	
	function salesOrder($act="",$page="")
	{
		$data['template'] = "shell/smooth";
        $data['main_view']     = 'f-sales';
        $this->load->view($data['template'],$data);
	}
    
    function gallery($proses = "", $id = "")
	{
		$data['template'] = "shell/smooth";
        $data['main_view']     = 'f-gallery';
        $data['proses'] = $proses;
        $data['id'] = $id;
        $data['cluster'] = $this->mmaster->getCluster();
        
        /**$data['data'] = array("name" => "", "distributor_add" => "", "distributor_id" =>
            "");
        /**if ($proses <> "" && $id <> "") {
            $getdata = $this->mmaster->getDistributor($id);
            foreach ($getdata as $r) {
                $data['data']['name'] = $r->distributor_name;
                $data['data']['distributor_add'] = $r->distributor_add;
                $data['data']['distributor_id'] = $r->distributor_id;
            }
        }*/
        
        #inisialisasi elemen form yang harus diisi
        $this->form_validation->set_rules('gallery_name', 'Gallery Name', 'required');
        $this->form_validation->set_rules('gallery_address', 'Dstributor Add','required');
        $this->form_validation->set_rules('territory_id', 'Gallery Cluster','required|numeric');
        

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');

        if ($this->form_validation->run() != false) {
            // masukkan data di sini
            $this->mmaster->saveGallery($id);
            $this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
            redirect(base_url() . "index.php/master/gallery");
        }
        $this->load->view($data['template'],$data);
	}

        

	/*
	function vemail_check($str)
	{
		$where = array("email"=>$str);
		if($this->uri->segment(4) <> "") $where = array("email"=>$str,"username !="=>$this->uri->segment(4));
		$v = $this->mglobal->showdata('username','t_users',$where,'dblokal');
		if ($v <> "")
		{
			$this->form_validation->set_message('vemail_check', 'Email <b>'. $str .'</b> sudah memiliki akun.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}*/
}