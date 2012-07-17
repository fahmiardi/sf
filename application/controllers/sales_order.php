<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_order extends CI_Controller
{

    function sales_order()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->model('mmaster');
        $this->load->model('mservices');
        $this->load->model('mterritory');
        $this->load->model('mpage');
        $this->load->model('msales');
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
        $data['main_view'] = "f-sales-order";
        $data['jenis'] = "create";
        $data['proses'] = $proses;
        $data['id'] = $id;
        $data['sales'] = $this->msales->getSales();
        $data['cluster'] = $this->msales->getCluster();
        
        $data['iccid'] = $this->msales->get_iccid();
        $data['payment_method'] = $this->msales->getPaymentMethod();
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
    
    
    
    function saveSalesOrder()
    {
        $salesOrder = $this->msales->saveSalesOrder();
        
        $so_id = $salesOrder->so_id;
        $iccid = $this->input->post('iccid');
        $item_code = $this->input->post('item_code');
        $item_group_name = $this->input->post('item_group_name');
        $item_name = $this->input->post('item_name');
        $price = $this->input->post('price');
        $discount = $this->input->post('discount');
        
        $count = 0;
        
        for($i = 0; $i < sizeof($iccid); $i++) 
        {
            $this->msales->saveSalesOrderDetail($so_id, $i);   
            $count++;
        }
        echo $count;
    }
    
    function get_iccid_data($iccid)
    {
        $data['test'] = $this->msales->get_single_iccid($iccid); //Search DB
        
        if('IS_AJAX')
        {
            echo json_encode($data['test']); //echo json string if ajax request
 
        }
        
    }
    
    function lookup(){
        // process posted form data (the requested items like province)
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //Set default response
        $query = $this->msales->lookup($keyword); //Search DB
        if( ! empty($query) )
        {
            $data['response'] = 'true'; //Set response
            $data['message'] = array(); //Create array
            foreach( $query as $row )
            {
                $data['message'][] = array(
                                        'id'=> $row->user_id,
                                        'value' => $row->user_name,
                                        'tes' => 'text'
                                     );  //Add a row to array
            }
        }
        if('IS_AJAX')
        {
            echo json_encode($data); //echo json string if ajax request
 
        }
        else
        {
            $this->load->view('sales_order/create',$data); //Load html view of search results
        }
    }
    
    function lookup_iccid($iccid){
        $data['test'] = $this->msales->lookup_iccid($iccid); //Search DB
        
        if('IS_AJAX')
        {
            echo json_encode($data['test']); //echo json string if ajax request
 
        }  
    }
    
    function load_sales_order($sales_id){
        // process posted form data (the requested items like province)
        $data['test'] = $this->msales->getSalesOrder($sales_id); //Search DB
        
        if('IS_AJAX')
        {
            echo json_encode($data['test']);
        }
    }
    
   	

    function chart()
    {
        $data['template'] = "shell/smooth";
        $data['main_view'] = "f-territory";
        $data['jenis'] = "chart";
        $data['proses'] = "";

        $this->load->view($data['template'], $data);
    }

    function territory_iframe()
    {
        $data['template'] = "f-territory-chart";
        $this->load->view($data['template'], $data);
    }

    function territory_json()
    {
        echo ($this->mterritory->getTerritoryTree());
    }
    
    function dummy()
    {
        redirect('http://bitboekoe.com');
    }
    
    
}
