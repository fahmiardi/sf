<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merchandising extends CI_Controller
{

    function merchandising()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('mmaster');
        $this->load->model('mservices');
        $this->load->model('mterritory');
        $this->load->model('mpage');
        //$this->load->model('msales');
        $this->load->model('mmerchan');
        $this->is_logged_in();
        #$this->mjadwal->saveLog();
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

    function create($proses = "add", $id = "")
    {
        $data['template'] = "shell/smooth";
        $data['main_view'] = "grid-merchandising";
        $data['jenis'] = "view";
        $data['proses'] = $proses;
        $data['id'] = $id;
        $data['region'] = $this->mmerchan->getRegion();
        //$data['cluster'] = $this->msales->getCluster();
        
        //$data['iccid'] = $this->msales->get_iccid();
        //$data['payment_method'] = $this->msales->getPaymentMethod();
        //$data['sales_order'] = $this->msales->getSalesOrder("adhon");

        #tangani proses save data
        
        //$this->form_validation->set_rules('so_id', 'Sales Order ID', 'required');
        $this->form_validation->set_rules('so_date', 'sales order date', 'required');
        $this->form_validation->set_rules('sales_id', 'sales id', 'required');
        $this->form_validation->set_rules('iccid[]', 'iccid', 'required');
        //$this->form_validation->set_rules('item_code[]', 'kode item', 'required');
        $this->form_validation->set_rules('item_group_name[]', 'nama group item', 'required');
        $this->form_validation->set_rules('item_name[]', 'nama item', 'required');
        $this->form_validation->set_rules('default_price[]', 'default price', 'required|numeric');
        $this->form_validation->set_rules('reseller_disc[]', 'reseller price', 'required|numeric');
        $this->form_validation->set_rules('discount_total', 'total discount', 'required|numeric');
        $this->form_validation->set_rules('cash_paid', 'cash paid', 'required|numeric');
        

        if ($this->form_validation->run() != false) {
            // masukkan data di sini
            $salesOrder = $this->msales->saveSalesOrder();
            $so_id = $salesOrder->so_id;
            $iccid = $this->input->post('iccid');
            $count = 0;
        
            for($i = 0; $i < sizeof($iccid); $i++) 
            {
                $this->msales->saveSalesOrderDetail($so_id, $i);   
                $count++;
            }
            //echo $count;
            $this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
            redirect(base_url() . "index.php/sales_order");
        }
        $hasil = "";

        $this->load->view($data['template'], $data);
    }
    
    
    
    function load_cluster($region_id){
        // process posted form data (the requested items like province)
        $data['test'] = $this->mmerchan->getCluster($region_id); //Search DB
        
        if('IS_AJAX')
        {
            echo json_encode($data['test']);
        }
    }
    
    function load_merchan($cluster_id){
        // process posted form data (the requested items like province)
        $data['test'] = $this->mmerchan->getMerchan($cluster_id); //Search DB
        
        if('IS_AJAX')
        {
            echo json_encode($data['test']);
        }
    }
    
    
}
