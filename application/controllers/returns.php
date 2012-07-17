<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Returns extends CI_Controller
{

    function returns()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('mmaster');
        $this->load->model('mservices');
        $this->load->model('mterritory');
        $this->load->model('mpage');
        $this->load->model('mreturns');
        $this->load->helper('url');
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect(base_url() . 'index.php/login');
        }
    }


    function index()
    {
        $this->create();
    }
	
	function save()
    {
		$entry = $this->input->post("jumlah_entry");
		$check = false;
		for($i=1; $i<=$entry; $i++){
			if($this->input->post("nomorBarang".$i)){
					$salesOrder = $this->mreturns->saveReturn();
					$return_id = $salesOrder->return_id;
					
					
					$buy = "buying";
					$id = "nomorBarang";
					$cost = "price";
					for($i=1; $i<=$entry; $i++){
						$buying_date = $this->input->post($buy.$i);
						$iccid = $this->input->post($id.$i);
						$price = $this->input->post($cost.$i);
						
						if($buying_date && $iccid && $price){
							$this->mreturns->saveReturnDetail($return_id, $buying_date, $iccid, $price);
						}
					}	
					$this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
					redirect(base_url() . "index.php/returns");
				
				$i=$entry+1;
				$check = true;
			}
		}
		if(!$check){
			$this->session->set_flashdata('message', 'Tidak Ada Barang Yang Di Return');
			redirect(base_url() . "index.php/returns");
		}
		
		
    }
	
	
	
    function create($proses = "add", $id = "")
    {
        $data['template'] = "shell/smooth";
		$data['main_view'] = "f-returns";
        $data['jenis'] = "create";
        $data['proses'] = $proses;
        $data['id'] = $id;
		
		$territory = $this->mreturns->getTerritoryId();
		$territory_id = $territory->territory_id;
		
		$data['cluster'] = $this->mreturns->getCluster();
		$data['sales'] = $this->mreturns->getSales($territory_id);
		$data['itemname'] = $this->mreturns->getItemName();
		$data['itemprice'] = $this->mreturns->getPrice();
		$data['buyingdate'] = $this->mreturns->getBuyingDate();
        
        
        $hasil = "";

        $this->load->view($data['template'], $data);
    }
    
	
}
