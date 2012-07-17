<?php 
class Sales extends CI_Controller {
	
	function sales()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->library('fpdf');
                $this->load->model('mmaster');
                $this->load->model('mglobal');
				$this->load->model('msales');
		$this->is_logged_in();
		#$this->mjadwal->saveLog();
		$this->load->helper('url');
	}
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect(base_url() .'index.php/login');
		}		
	}
	

	function index($act="",$page="")
	{
		$data['template'] 	= "shell/smooth";
		$data['main_view']  = 'f-receipt';
		$this->load->view($data['template'],$data);
	}

	function newcheckbox()
	{
		$this->load->view('newcheckbox');
	}
	
	
	function newreceipt($proses = "", $id = "")
    {
        $data['template'] = "shell/smooth";
        $data['main_view'] = "f-receipt";
        $data['jenis'] = "create";
        $data['proses'] = $proses;
        $data['id'] = $id;	
		$data['salesID'] = $this->msales->getSalesID($this->session->userdata('username'));
		
		$res = $this->msales->getClusterName();	
		if (count($res) > 0)
			foreach($res as $result)
			{
				$data['dist_name'] = $result['territory_name'];
				$data['dist_address'] = $result['territory_address'];
				$ter_id = $result['territory_id'];
				$dist_id = $result['territory_id'];
			}
		else
		{
			$data['dist_name'] = "no data";
			$data['dist_address'] = "no data";
		}
		
        #proses save data        
        $this->form_validation->set_rules('receipt_date', 'receipt date', 'required');
        $this->form_validation->set_rules('sales_id', 'sales id', 'required');
        $this->form_validation->set_rules('iccid[]', 'iccid', 'required');
        $this->form_validation->set_rules('item_code[]', 'kode item', 'required');
        $this->form_validation->set_rules('item_group_name[]', 'nama group item', 'required');
        $this->form_validation->set_rules('item_name[]', 'nama item', 'required');
        
        
        if ($this->form_validation->run() != false) {
            // masukkan data di sini
            $lastRid = $this->msales->saveReceipt($ter_id);
            $iccid = $this->input->post('iccid');
            $count = 0;
        
            for($i = 0; $i < sizeof($iccid); $i++) 
            {
                $this->msales->saveReceiptDetail($lastRid, $i, $dist_id);   
                $count++;
            }
            //echo $count;
            $this->session->set_flashdata('message', 'Data Berhasil dimasukkan');
            redirect(base_url() . "index.php/sales");
        }
        $hasil = "";

        $this->load->view($data['template'], $data);
    }
	
	
    ################## u/manage data
    public function read() {
		echo json_encode( $this->msales->getAllReceipt() );
	}
	
	public function delete( $id = null ) {
		if( is_null( $id ) ) {
			echo 'ERROR: Id not provided.';
			return;
		}
		$this->msales->delete( $id );
		echo 'Records deleted successfully';
	}
	

    function load_sales($sales_id){
        //process posted form data (the requested items like province)
        $data['test'] = $this->msales->getSales($sales_id); //Search DB
        
        if('IS_AJAX')
        {
            echo json_encode($data['test']);
        }
    }
	
	
	public function concateId($id)
	{
		$tempId = "" . $id;
		if (strlen($tempId) < 4)
		{
			for($ii=strlen($tempId); $ii<4; $ii++)
			{
				$tempId = '0' . $tempId;
			}
		}
		return $tempId;
	}
	
	function getDetail($id1='', $id2='')
	{
		$rcp_id = $id1;
		$ter_id = $id2;
		
		$list = $this->pdfAndDetail($rcp_id, $ter_id);
		$data['strId'] = $list[0];
		$data['dist'] = $list[1];
		$data['receipt'] = $list[2];
		$data['sales_name'] = $list[3];
		$data['receipt_detail'] = $list[4];
		
		for($ii=0;$ii<count($list[4]);$ii++)	
		{
			$data['itemDetail'][$ii] = $list[5+$ii];
		}
		
		$data['template'] 	= "shell/smooth";
		$data['main_view']  = 'f-receipt-detail';
		$this->load->view($data['template'],$data);
		
	
	}
	
	function pdfAndDetail($rcp_id, $ter_id)
	{
		$list = array();
		
		$list[0] = $this->concateId($rcp_id);
		
		//$this->db->select('distributor_name, distributor_address');
		$this->db->select('territory_name, '');
		$this->db->where('territory_id', $ter_id);
		$q = $this->db->get('t_mtr_territory');
		$list[1] = $q->result_array();		
		
		$list[2] = $this->msales->getById($rcp_id);
		
		$this->db->select('user_name');
		$this->db->where('user_id', $list[2]->sales_id);
		$q = $this->db->get('t_mtr_user');
		$list[3] = $q->result_array();		
		
		$this->db->select('*');
		$this->db->where('receipt_id', $rcp_id);
		$q = $this->db->get('t_trx_receipt_detail');
		$list[4] = $q->result_array();
		
		for($ii=0;$ii<count($list[4]);$ii++)
		{
			$list[$ii+5] = $this->msales->getItemDetail($list[4][$ii]['iccid']);
		}
		
			
		return $list;
	
	}
	
	function topdf($id1='', $id2='')
	{
	
		$rcp_id = $id1;
		$ter_id = $id2;	
		
		$list = $this->pdfAndDetail($rcp_id, $ter_id);
		$strId = $list[0];
		$dist = $list[1];
		$receipt = $list[2];
		$sales_name = $list[3];
		$receipt_detail = $list[4];
		
		for($ii=0;$ii<count($list[4]);$ii++)	
		{
			$itemDetail[$ii] = $list[5+$ii];
		}
		
		//begin configuration
		$textColour = array( 0, 0, 0 );
		$headerColour = array( 100, 100, 100 );
		$tableHeaderTopTextColour = array( 255, 255, 255 );
		$tableHeaderTopFillColour = array( 125, 152, 179 );
		$tableHeaderTopProductTextColour = array( 0, 0, 0 );
		$tableHeaderTopProductFillColour = array( 143, 173, 204 );
		$tableHeaderLeftTextColour = array( 99, 42, 57 );
		$tableHeaderLeftFillColour = array( 184, 207, 229 );
		$tableBorderColour = array( 50, 50, 50 );
		$tableRowFillColour = array( 213, 170, 170 );
		

		$chartColours = array(
						  array( 255, 100, 100 ),
						  array( 100, 255, 100 ),
						  array( 100, 100, 255 ),
						  array( 255, 255, 100 ),
						);

		$data = array(
				  array( 9940, 10100, 9490, 11730 ),
				  array( 19310, 21140, 20560, 22590 ),
				  array( 25110, 26260, 25210, 28370 ),
				  array( 27650, 24550, 30040, 31980 ),
				);
		// End configuration
		
		
		$this->load->helper('path');

		$font_directory = './fpdf_fonts/';
		set_realpath($font_directory);
		define('FPDF_FONTPATH',$font_directory);
		
		$this->fpdf->Open();
		$this->fpdf->AddPage();
		$this->fpdf->SetAutoPageBreak(true, 20);
		$this->fpdf->SetMargins(20, 20, 20);
		$this->fpdf->AliasNbPages();
		
		
		//header
		$this->fpdf->Image(base_url().'file/images/logo_smartfren.png',10,3,50,0,'');		
		$this->fpdf->SetFont('Arial','B',16);
		//$this->fpdf->Cell(80);
		$this->fpdf->Cell(149,-5,"Receipt Notes",0,1,'R');	
		$this->fpdf->Ln( 10 );		
		$this->fpdf->Cell(180,0,"(Pengembalian Barang Sales)",0,1,'R');		
		$this->fpdf->Line(10, 20, 200, 20);
		
		//table
		$this->fpdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
		
		//Cluster Information		
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',16);		
		$this->fpdf->Write(19, $dist[0]['territory_name']);
		$this->fpdf->Ln( 6 );
		$this->fpdf->SetFont('Helvetica','',10);
		//$this->fpdf->Write(19, $dist[0]['territory_address']);		
		
		
		// Date and receipt no
		$this->fpdf->Ln(15);
		$this->fpdf->SetXY(130, 42);
		$this->fpdf->SetFont('Arial','B',8);
		$this->fpdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
		$this->fpdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );
		$this->fpdf->Cell( 25, 8, "Date", 1, 0, 'C', true );
		$this->fpdf->Cell( 45, 8, "Receipt No", 1, 0, 'C', true );		
		//$this->fpdf->Ln( 8 );
		$this->fpdf->SetXY(130, 50);
		
		$fill = false;
		$row = 0;		
		$this->fpdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
		$this->fpdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
		$this->fpdf->SetFont( 'Arial', '', 8 );		
		$this->fpdf->Cell( 25, 8, date("d-m-Y", strtotime($receipt->receipt_date)), 1, 0, 'C', $fill );
		$this->fpdf->Cell( 45, 8, $strId, 1, 0, 'C', $fill );
					
						
	
		$this->fpdf->Ln( 20 );
			
		// Order Information
		$this->fpdf->SetXY(20, 42);
		$this->fpdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
		$this->fpdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );
		$this->fpdf->SetFont( 'Arial', 'B', 8 );
		$this->fpdf->Cell( 25, 8, "Sales ID", 1, 0, 'C', true );
		$this->fpdf->Cell( 45, 8, "Sales Name", 1, 0, 'C', true );		
		$this->fpdf->Ln( 8 );
		$this->fpdf->SetFont( 'Arial', '', 8 );
		$this->fpdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
		$this->fpdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
		$this->fpdf->Cell( 25, 8, $receipt->sales_id, 1, 0, 'C', $fill );
		$this->fpdf->Cell( 45, 8, $sales_name[0]['user_name'], 1, 0, 'C', $fill );		

		
		// Order Information
		$this->fpdf->Ln( 25 );
		$this->fpdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
		$this->fpdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );
		$this->fpdf->SetFont( 'Arial', 'B', 8 );
		$this->fpdf->Cell( 40, 8, "ICCID", 1, 0, 'C', true );
		$this->fpdf->Cell( 30, 8, "Item Code", 1, 0, 'C', true );		
		$this->fpdf->Cell( 25, 8, "Item Group", 1, 0, 'C', true );		
		$this->fpdf->Cell( 80, 8, "Description", 1, 0, 'C', true );			
		$this->fpdf->SetFont( 'Arial', '', 8 );
		
		if (count($receipt_detail) > 0)
		{
			for($jj=0; $jj<count($receipt_detail); $jj++)
			{
				$this->fpdf->Ln( 8 );
				$this->fpdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
				$this->fpdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
				$this->fpdf->Cell( 40, 8, $receipt_detail[$jj]['iccid'], 1, 0, 'C', $fill );
				$this->fpdf->Cell( 30, 8, $itemDetail[$jj][0]['item_code'], 1, 0, 'C', $fill );		
				$this->fpdf->Cell( 25, 8, $itemDetail[$jj][0]['item_group_name'], 1, 0, 'C', $fill );		
				$this->fpdf->Cell( 80, 8, $itemDetail[$jj][0]['item_name'], 1, 0, 'C', $fill );			
			}
		}	
		
		  //Position at 1.5 cm from bottom 
        $this->fpdf->SetY(-30); 
        //Arial italic 8 
        $this->fpdf->SetFont('Arial','I',8); 
        //Page number 
        $this->fpdf->Cell(0,10,'Page '.$this->fpdf->PageNo().'/{nb}',0,0,'C'); 
		
		
		$this->fpdf->Output();
	
	}



	
}