<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	 //error code normal -> misal json 100
	 //error code keyword salah -> 200
	 //item ada ga valid -> 300

	public function index()
	{
		//$arr = array("user_id" => 2, "items" => array("123","111","111135"), "keyword" => "fsdfdfsfsdfw3");
		//$data = json_encode($arr);
		$this->load->model('Mobile_model');
		$data['item_name'] = $this->Mobile_model->get_item(1);
		//$this->load->view('welcome_message');
	}

	public function addScanIn()
	{
		$this->load->model('Mobile_model');

		$data = file_get_contents("php://input");
		
		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		foreach($hasilkeyword as $clients)
			$client = $clients['client'];

		$matchs = array();
		$intcek = 0;
		if(count($dataray['items']) > 0)
		{	foreach($dataray['items'] as $dataitem)
			{
				$matchs[$intcek] = array("true" => "valid", "value" => $dataitem);
				$intcek++;
			}

			$filteritems = $this->Mobile_model->get_itemsfromarray($matchs);
			//var_dump($filteritems);
			$hasilarray = $this->Mobile_model->get_iccidscaninfromarray($filteritems);
			//var_dump($hasilarray);
			
			$barangok = 0;
			$barangbad = 0;
			$valid_item = array();
			$failed_item = array();
			$good_item = array();
			foreach($hasilarray as $listbarang)
			{
				if($listbarang['true'] == "valid")
				{
					$good_item[$barangok] = $listbarang['value'];
					$valid_item[$barangok] = $listbarang['detail'];
					$barangok++;
				}
				else
				{
					
					$failed_item[$barangbad] = $listbarang['value'];
					$barangbad++;
				}
			}

			if($barangbad == count($hasilarray))
			{
				$result = array("success" => "false", "error_code" => "300", "message" => "All item code are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
				echo json_encode($result);
				exit;
			}
			else
			{
				$scanid = $this->Mobile_model->add_scanin($dataray,$barangok,$client);

				foreach($good_item as $perbaris)
				{
					$this->Mobile_model->add_scanin_detail($perbaris,$scanid);
				}
				
				if($barangok == count($hasilarray))
				{
					$result = array("success" => "true", "user_id" => $dataray['user_id'], "valid_items" => $valid_item);
					echo json_encode($result);
					exit;
				}
				else
				{
					$result = array("success" => "true", "error_code" => "300", "message" => "Some item are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id'], "valid_items" => $valid_item);
					echo json_encode($result);
					exit;
				}
			}
		}

	}

	public function addSellIn()
	{
		$this->load->model('Mobile_model');

		$data = file_get_contents("php://input");
		
		$dataray = json_decode($data,TRUE);
		
		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		foreach($hasilkeyword as $clients)
			$client = $clients['client'];
		
		$matchs = array();
		$intcek = 0;
		if(count($dataray['items']) > 0)
		{	foreach($dataray['items'] as $dataitem)
			{
				$matchs[$intcek] = array("true" => "valid", "value" => $dataitem);
				$intcek++;
			}

			$filteritems = $this->Mobile_model->get_iccidsellscaninfromarray($matchs);
			
			foreach($filteritems as $listbarang)
			{
				if($listbarang['true'] == "valid")
				{
					$this->Mobile_model->update_scanin($listbarang['value'],2);
				}
			}

			$hasilarray = $this->Mobile_model->get_iccidsellinfromarray($filteritems);

			$barangok = 0;
			$barangbad = 0;
			$failed_item = array();
			$good_item = array();
			foreach($hasilarray as $listbarang)
			{
				if($listbarang['true'] == "valid")
				{
					$good_item[$barangok] = $listbarang['value'];
					$barangok++;
				}
				else
				{
					
					$failed_item[$barangbad] = $listbarang['value'];
					$barangbad++;
				}
			}

			if($barangbad == count($hasilarray))
			{
				$result = array("success" => "false", "error_code" => "300", "message" => "All item code are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
				echo json_encode($result);
				exit;
			}
			else
			{
				$sellid = $this->Mobile_model->add_sellin($dataray,$client);

				foreach($good_item as $perbaris)
				{
					$this->Mobile_model->add_sellin_detail($perbaris,$sellid);
				}
				
				if($barangok == count($hasilarray))
				{
					$result = array("success" => "true", "user_id" => $dataray['user_id']);
					echo json_encode($result);
					exit;
				}
				else
				{
					$result = array("success" => "true", "error_code" => "300", "message" => "Some item are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
					echo json_encode($result);
					exit;
				}

			}
		}

	}

	public function updateJourney()
	{
		$this->load->model('Mobile_model');
		
		$data = file_get_contents("php://input");
		
		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		$datajc = $this->Mobile_model->get_journey($dataray['user_id'],$dataray['jc_id']);

		foreach($datajc as $datajc1)
			$this->Mobile_model->add_journey($dataray['user_id'],$dataray['check_in_date'],$dataray['route_date'],$datajc1);

		$result = array("success" => "true", "user_id" => $dataray['user_id']);
		echo json_encode($result);
	}

	public function addSellReturn()
	{
		$this->load->model('Mobile_model');
		
		$data = file_get_contents("php://input");
		
		$dataray = json_decode($data,TRUE);
		
		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		foreach($hasilkeyword as $clients)
			$client = $clients['client'];

		$matchs = array();
		$intcek = 0;
		if(count($dataray['items']) > 0)
		{	foreach($dataray['items'] as $dataitem)
			{
				$matchs[$intcek] = array("true" => "valid", "value" => $dataitem);
				$intcek++;
			}

			$hasilarray = $this->Mobile_model->get_iccidsellreturnfromarray($matchs);

			$barangok = 0;
			$barangbad = 0;
			$failed_item = array();
			$good_item = array();
			foreach($hasilarray as $listbarang)
			{
				if($listbarang['true'] == "valid")
				{
					$good_item[$barangok] = $listbarang['value'];
					$barangok++;
				}
				else
				{
					
					$failed_item[$barangbad] = $listbarang['value'];
					$barangbad++;
				}
			}

			if($barangbad == count($hasilarray))
			{
				$result = array("success" => "false", "error_code" => "300", "message" => "All item code are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
				echo json_encode($result);
				exit;
			}
			else
			{
				$returnid = $this->Mobile_model->add_sellreturn($dataray,$client);

				foreach($good_item as $perbaris)
				{
					$this->Mobile_model->add_sellreturn_detail($perbaris,$returnid);
				}
				
				if($barangok == count($hasilarray))
				{
					$result = array("success" => "true", "user_id" => $dataray['user_id']);
					echo json_encode($result);
					exit;
				}
				else
				{
					$result = array("success" => "true", "error_code" => "300", "message" => "Some item are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
					echo json_encode($result);
					exit;
				}

			}
		}
		
	}

	public function addStockScan()
	{
		$this->load->model('Mobile_model');
		
		$data = file_get_contents("php://input");
		
		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}
		
		$matchs = array();
		$intcek = 0;
		if(count($dataray['items']) > 0)
		{	foreach($dataray['items'] as $dataitem)
			{
				$matchs[$intcek] = array("true" => "valid", "value" => $dataitem);
				$intcek++;
			}

			$hasilarray = $this->Mobile_model->get_iccidstockscanfromarray($matchs);

			$barangok = 0;
			$barangbad = 0;
			$failed_item = array();
			$good_item = array();
			foreach($hasilarray as $listbarang)
			{
				if($listbarang['true'] == "valid")
				{
					$good_item[$barangok] = $listbarang['value'];
					$barangok++;
				}
				else
				{			
					$failed_item[$barangbad] = $listbarang['value'];
					$barangbad++;
				}
			}

			if($barangbad == count($hasilarray))
			{
				$result = array("success" => "false", "error_code" => "300", "message" => "All item code are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
				echo json_encode($result);
				exit;
			}
			else
			{
				$scanid = $this->Mobile_model->add_stockscan($dataray,$barangok);

				foreach($good_item as $perbaris)
				{
					$this->Mobile_model->add_stockscan_detail($perbaris,$scanid);
				}
				
				if($barangok == count($hasilarray))
				{
					$result = array("success" => "true", "user_id" => $dataray['user_id']);
					echo json_encode($result);
					exit;
				}
				else
				{
					$result = array("success" => "true", "error_code" => "300", "message" => "Some item are not valid", "failed_items" => $failed_item, "user_id" => $dataray['user_id']);
					echo json_encode($result);
					exit;
				}

			}
		}
	}

	public function trackUser()
	{
		$this->load->model('Mobile_model');

		$longitude = $this->input->get('lon');
		$latitude = $this->input->get('lat');
		$user_id = $this->input->get('user_id');
		$cell_id = $this->input->get('cell_id');
		$lac = $this->input->get('lac');

		$this->Mobile_model->add_trackuser($longitude,$latitude,$user_id,$cell_id,$lac);
	}
	
	public function getitemgroup() 
	{
		$this->load->model('Mobile_model');

		$hasilarray = $this->Mobile_model->get_itemgroup();

		if(is_null($hasilarray))
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "Data is empty");
			echo json_encode($result);
		}
		else
		{
			$result['success'] = "true";
			$ins = 0;
			foreach($hasilarray as $perbaris)
			{
				$result['item_groups'][$ins] = array("item_group_id" => $perbaris['item_group_id'], "item_group_name" => $perbaris['item_group_name']);
				$ins++;
			}
			echo json_encode($result);
		}
	}

	public function prodCatalog()
	{
		$this->load->model('Mobile_model');

		$hasilarray = $this->Mobile_model->get_prodcatalog();

		if(is_null($hasilarray))
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "Data is empty");
			echo json_encode($result);
		}
		else
		{
			$result['success'] = "true";
			$ins = 0;
			foreach($hasilarray as $perbaris)
			{
				$result['items'][$ins] = array("item_id" => $perbaris['item_id'], "item_name" => $perbaris['item_name'], "item_code" => $perbaris['iccid'], "price" => $perbaris['default_price']);
				$ins++;
			}
			echo json_encode($result);
		}
	}

	public function prodCatalogbyitemgroup()
	{
		$this->load->model('Mobile_model');

		$data = file_get_contents("php://input");

		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}
		else
		{
			$userid = $dataray['user_id'];
			$keyword = $dataray['keyword'];
			$itemgroupid = $dataray['item_group_id'];
		}

		$hasilarray = $this->Mobile_model->get_prodcatalog2($itemgroupid);

		if(is_null($hasilarray))
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "Data is empty");
			echo json_encode($result);
		}
		else
		{
			$result['success'] = "true";
			$result['user_id'] = $userid;
			$ins = 0;
			foreach($hasilarray as $perbaris)
			{
				$result['items'][$ins] = array("item_id" => $perbaris['item_id'], "item_name" => $perbaris['item_name'], "item_code" => $perbaris['iccid'], "price" => $perbaris['default_price']);
				$ins++;
			}
			echo json_encode($result);
		}
	}

	public function addmerchancapture()
	{
		$this->load->library('upload');
		$this->load->model('Mobile_model');

		if(!empty($_FILES['uploadedfile']['name']))
		{
			$config['upload_path'] = 'file/merchan/';
            $config['allowed_types'] = 'gif|jpg|png';
            //$config['max_size'] = '100';
            //$config['max_width']  = '1024';
            //$config['max_height']  = '768';  

			$this->upload->initialize($config);

			if ($this->upload->do_upload('uploadedfile'))
            {
				$tanggalku = $this->input->post('date');

                $dataray = array("user_id" => $this->input->post('user_id'), "channel_id" => $this->input->post('channel_id'), "lon" => $this->input->post('lon'), "lat" => $this->input->post('lat'), "link" => "file/merchan/".$_FILES['uploadedfile']['name'], "tanggal" => $tanggalku);

				$this->Mobile_model->add_merchancapture($dataray);

				$result = array("success" => "true", "user_id" => $this->input->post('user_id'));
				echo json_encode($result);

            }
			else
			{
				$result = array("success" => "false", "error_code" => "100", "message" => "Upload file failed", "user_id" => $this->input->post('user_id'));
				echo json_encode($result);
			}
		}
	}

	public function addagent()
	{
		$this->load->model('Mobile_model');

		$data = file_get_contents("php://input");

		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}
		else
		{
			$userid = $dataray['user_id'];
			$keyword = $dataray['keyword'];
			$agentid = $dataray['agent_id'];
			$agentname = $dataray['agent_name'];
			$agentaddress = $dataray['agent_address'];
			$agentcity = $dataray['agent_city'];
			$agentbf = $dataray['agent_business_focus'];
			$agenttype = $dataray['agent_type'];
			$longitude = $dataray['longitude'];
			$latitude = $dataray['latitude'];
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		$reportsz = $this->Mobile_model->get_reportto($userid);
				
		$reportid = "";
		
		if(count($reportsz) > 0)
		{
			foreach($reportsz as $reports)
				$reportid = $reports['reporting_to'];

			if($reportid == "")
			{
				$result = array("success" => "false", "error_code" => "100", "message" => "Reporting_to not found", "user_id" => $userid);
				echo json_encode($result);
				exit;
			}
		}

		$territories = $this->Mobile_model->get_territorybyuserid($reportid,6);

		$territoryid = 0;
		if(count($territories) > 0)
		{
			foreach($territories as $territoriesx)
				$territoryid = $territoriesx['territory_id'];

			if($territoryid == 0)
			{
				$result = array("success" => "false", "error_code" => "100", "message" => "Territory_id not found", "user_id" => $userid);
				echo json_encode($result);
				exit;
			}
		}

		$territoryidlast = $this->Mobile_model->add_territorymtr($agentname,$territoryid,$userid,6);
		$this->Mobile_model->add_territorymtruser($userid,$territoryidlast);
		$this->Mobile_model->add_agent($userid,$agentid,$territoryidlast,$agentname,$agentaddress,$agentcity,$agentbf,$agenttype,$longitude,$latitude);

		$result = array("success" => "true", "user_id" => $userid);
		echo json_encode($result);
	}

	public function addoutlet()
	{
		$this->load->library('upload');
		$this->load->model('Mobile_model');

		$userid = $this->input->post('user_id');
		$keyword = $this->input->post('keyword');
		$outletname = $this->input->post('outlet_name');
		$outletaddress = $this->input->post('outlet_address');
		$outletcity = $this->input->post('outlet_city');
		$outletbf = $this->input->post('outlet_business_focus');
		$longitude = $this->input->post('longitude');
		$latitude = $this->input->post('latitude');

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($userid,$keyword);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $userid);
			echo json_encode($result);
			exit;
		}

		if(!empty($_FILES['outlet_foto']['name']))
		{
			$config['upload_path'] = 'file/outlet';
            $config['allowed_types'] = 'gif|jpg|png';
            //$config['max_size'] = '100';
            //$config['max_width']  = '1024';
            //$config['max_height']  = '768';  

			$this->upload->initialize($config);

			if ($this->upload->do_upload('outlet_foto'))
            {
				$reportsz = $this->Mobile_model->get_reportto($userid);
				
				$reportid = "";
				if(count($reportsz) > 0)
				{
					foreach($reportsz as $reports)
						$reportid = $reports['reporting_to'];

					if($reportid == "")
					{
						$result = array("success" => "false", "error_code" => "100", "message" => "Reporting_to not found", "user_id" => $userid);
						echo json_encode($result);
						exit;
					}
				}

				$territories = $this->Mobile_model->get_territorybyuserid($reportid,5);

				$territoryid = 0;
				if(count($territories) > 0)
				{
					foreach($territories as $territoriesx)
						$territoryid = $territoriesx['territory_id'];

					if($territoryid == 0)
					{
						$result = array("success" => "false", "error_code" => "100", "message" => "Territory_id not found", "user_id" => $userid);
						echo json_encode($result);
						exit;
					}
				}

				$territoryidlast = $this->Mobile_model->add_territorymtr($outletname,$territoryid,$userid,5);
				$this->Mobile_model->add_territorymtruser($userid,$territoryidlast);
				$outletidlast = $this->Mobile_model->add_outlet($userid,$territoryidlast,$outletname,$outletaddress,$outletcity,$longitude,$latitude,"file/outlet/".$_FILES['outlet_foto']['name']);
				$this->Mobile_model->add_outletdata($outletidlast,$outletbf);
				
            }
			else
			{
				$result = array("success" => "false", "error_code" => "100", "message" => "Upload file failed", "user_id" => $this->input->post('user_id'));
				echo json_encode($result);
			}
		}
		else
		{
				$reportsz = $this->Mobile_model->get_reportto($userid);
				
				$reportid = "";
				if(count($reportsz) > 0)
				{
					foreach($reportsz as $reports)
						$reportid = $reports['reporting_to'];

					if($reportid == "")
					{
						$result = array("success" => "false", "error_code" => "100", "message" => "Reporting_to not found", "user_id" => $userid);
						echo json_encode($result);
						exit;
					}
				}

				$territories = $this->Mobile_model->get_territorybyuserid($reportid,5);

				$territoryid = 0;
				if(count($territories) > 0)
				{
					foreach($territories as $territoriesx)
						$territoryid = $territoriesx['territory_id'];

					if($territoryid == 0)
					{
						$result = array("success" => "false", "error_code" => "100", "message" => "Territory_id not found", "user_id" => $userid);
						echo json_encode($result);
						exit;
					}
				}

				$territoryidlast = $this->Mobile_model->add_territorymtr($outletname,$territoryid,$userid,5);
				$this->Mobile_model->add_territorymtruser($userid,$territoryidlast);
				$outletidlast = $this->Mobile_model->add_outlet($territoryidlast,$outletname,$outletaddress,$outletcity,$longitude,$latitude,"");
				$this->Mobile_model->add_outletdata($outletidlast,$outletbf);
		}

		$result = array("success" => "true", "user_id" => $userid);
		echo json_encode($result);
	}

	public function updateoutlet()
	{
		$this->load->model('Mobile_model');

		$data = file_get_contents("php://input");

		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}
		else
		{
			$outletid = $dataray['outlet_id'];
			$outletname = $dataray['outlet_name'];
			$outletaddress = $dataray['outlet_address'];
			$outletcity = $dataray['outlet_city'];
			$outletbf = $dataray['outlet_business_focus'];
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}
		
		$this->Mobile_model->update_outlet($outletid,$outletname,$outletaddress,$outletcity);
		$this->Mobile_model->update_outletdata($outletid,$outletbf);
		
		$result = array("success" => "true", "user_id" => $dataray['user_id']);
		echo json_encode($result);
	}

	public function updateagent()
	{
		$this->load->model('Mobile_model');

		$data = file_get_contents("php://input");

		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}
		else
		{
			$agentid = $dataray['agent_id'];
			$agentname = $dataray['agent_name'];
			$agentaddress = $dataray['agent_address'];
			$agentcity = $dataray['agent_city'];
			$agentbf = $dataray['agent_business_focus'];
			$agenttype = $dataray['agent_type'];
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		$this->Mobile_model->update_agent($agentid,$agentname,$agentaddress,$agentcity,$agentbf,$agenttype);

		$result = array("success" => "true", "user_id" => $dataray['user_id']);
		echo json_encode($result);
	}

	public function getoutletbyuserid()
	{
		$this->load->model('Mobile_model');
		
		$data = file_get_contents("php://input");

		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		$dataterritory = $this->Mobile_model->get_territorybyuserid($dataray['user_id'],5);
		if(is_null($dataterritory))
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "Data is empty");
			echo json_encode($result);
			exit;
		}

		$ins = 0;
		foreach($dataterritory as $territorys)
		{
			$hasilarray = $this->Mobile_model->get_outletbyterritoryid($territorys['territory_id']);

			$result['success'] = "true";
			$result['user_id'] = $dataray['user_id'];

			if(count($hasilarray) > 0)
			foreach($hasilarray as $perbaris)
			{
				$databisnis = $this->Mobile_model->get_bisnisfocusbyoutlet($perbaris['outlet_id']);
				
				$bisnisfocus1 = "";
				if(count($databisnis) > 0)
				foreach($databisnis as $bisnisfocus)
					$bisnisfocus1 = $bisnisfocus['outlet_business_focus'];

				$result['outlets'][$ins] = array("outlet_id" => $perbaris['outlet_id'], "outlet_name" => $perbaris['outlet_name'], "outlet_address" => $perbaris['address'], "outlet_city" => $perbaris['city'], "outlet_business_focus" => $bisnisfocus1);
				$ins++;
			}
		}
		echo json_encode($result);

	}

	public function getagentbyuserid()
	{
		$this->load->model('Mobile_model');
		
		$data = file_get_contents("php://input");

		$dataray = json_decode($data,TRUE);

		if(count($dataray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "json format send failed");
			echo json_encode($result);
			exit;
		}

		$hasilkeyword = $this->Mobile_model->get_keywordtoday($dataray['user_id'],$dataray['keyword']);

		if(count($hasilkeyword) == 0)
		{
			$result = array("success" => "false", "error_code" => "200", "message" => "keyword failed", "user_id" => $dataray['user_id']);
			echo json_encode($result);
			exit;
		}

		$dataterritory = $this->Mobile_model->get_territorybyuserid($dataray['user_id'],6);
		if(is_null($dataterritory))
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "Data is empty");
			echo json_encode($result);
			exit;
		}

		$ins = 0;
		foreach($dataterritory as $territorys)
		{
			$hasilarray = $this->Mobile_model->get_agentbyterritoryid($territorys['territory_id']);
			$result['success'] = "true";
			$result['user_id'] = $dataray['user_id'];
			if(count($hasilarray) > 0)
			foreach($hasilarray as $perbaris)
			{
				$result['agents'][$ins] = array("agent_id" => $perbaris['agent_id'], "agent_name" => $perbaris['agent_name'], "agent_address" => $perbaris['agent_address'], "agent_city" => $perbaris['agent_city'], "agent_business_focus" => $perbaris['agent_business_focus'], "agent_type" => $perbaris['agent_type']);
				$ins++;
			}
		}
		echo json_encode($result);
	}

	public function addDynamicForm()
	{
		$this->load->model('Mobile_model');
		$this->load->library('upload');

		$namatabel = $this->input->post('tablename');
		$serviceid = $this->input->post('serviceid');

		$getfield = $this->Mobile_model->get_fieldnamefromproperty($serviceid);

		if(count($getfield))
		{
			$fieldku = "(";
			$valueku = "(";
			$kxx = 0;
			foreach($getfield as $fields)
			{
				if($fields['t_elm_type'] == "checkbox")
				{
					$masukan = "";

					$tempcount = 0;
					foreach($this->input->post($fields['t_services_column']) as $nilaic)
					{
						if($tempcount == 0)
							$masukan .= $nilaic;
						else
							$masukan .= "|".$nilaic;
						
						$tempcount++;
					}

					if($kxx == 0)
					{
						$fieldku .= $fields['t_services_column'];
						$valueku .= "'".$masukan."'";
					}
					else
					{
						$fieldku .= ",".$fields['t_services_column'];
						$valueku .= ",'".$masukan."'";
					}
				}
				elseif($fields['t_elm_type'] == "img")
				{
					if(!empty($_FILES[$fields['t_services_column']]['name']))
					{
						$dir_path = "file/imagedf/".$namatabel."/";
						if(!is_dir($dir_path)){
							if (!mkdir($dir_path)) {
								die('Failed to create folders...');
							}
						}

						$config['upload_path'] = $dir_path;
						$config['allowed_types'] = 'gif|jpg|png';
            
						$this->upload->initialize($config);

						if ($this->upload->do_upload($fields['t_services_column']))
						{
							$fieldku .= $fields['t_services_column'];
							$valueku .= "'".$dir_path.$_FILES[$fields['t_services_column']]['name']."'";	
						}
						else
						{
							$fieldku .= $fields['t_services_column'];
							$valueku .= "''";
						}
					}
				}
				else
				{
					if($kxx == 0)
					{
						$fieldku .= $fields['t_services_column'];
						$valueku .= "'".$this->input->post($fields['t_services_column'])."'";
					}
					else
					{
						$fieldku .= ",".$fields['t_services_column'];
						$valueku .= ",'".$this->input->post($fields['t_services_column'])."'";
					}
				}

				$kxx++;
			}

			$fieldku .= ")";
			$valueku .= ")";
			
			$this->Mobile_model->add_formdinamik("insert into $namatabel $fieldku $valueku");
		}
		
		$result = array("success" => "true");
		echo json_encode($result);
	}

	public function getclosestgallery()
	{
		$this->load->model('Mobile_model');

		$userid = $this->input->get('user_id');
		$lat = $this->input->get('lat');
		$lon = $this->input->get('lon');
		
		$radius = 0.045;
		$lat_max = floatval($lat) + $radius;
		$lat_min = floatval($lat) - $radius;
		$lon_max = floatval($lon) + $radius;
		$lon_min = floatval($lon) - $radius;

		$galleries = $this->Mobile_model->get_closestgallery($userid,$lon_max,$lon_min,$lat_max,$lat_min);
		
		if(is_null($galleries))
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "Data is empty");
			echo json_encode($result);
			exit;
		}

		$result['success'] = "true";
		$result['user_id'] = $userid;
		foreach($galleries as $galleryku)
		{
			$result['gallery'][$ins] = array("gallery_id" => $galleryku['gallery_id'], "gallery_name" => $galleryku['gallery_name'], "gallery_address" => $galleryku['gallery_address']);
			$ins++;
		}
		echo json_encode($result);
	}

	public function login()
	{
		$this->load->helper('file');
		$this->load->model('Mobile_model');
		$this->load->library('Helpme');

		$dataray = array("username" => $this->input->post('username'), "password" => $this->input->post('password'), "imei" => $this->input->post('imei'), "imsi" => $this->input->post('imsi'));

		$hasilarray = $this->Mobile_model->get_user($dataray);

		if(count($hasilarray) == 0)
		{
			$result = array("success" => "false", "error_code" => "100", "message" => "User not authenticated");
			echo json_encode($result);
			exit;
		}
		else
		{
			foreach($hasilarray as $hsl1)
			{
				if($hsl1['is_allowed_time'] == 0)
				{
					$result = array("success" => "false", "error_code" => "100", "message" => "Login not allowed");
					echo json_encode($result);
					exit;
				}
			}

			$imsi = $this->input->post('imsi');
			$imei = $this->input->post('imei');

			$cekhandset = $this->Mobile_model->cekhandset($hasilarray[0]['user_id'],$imsi,$imei);
			
			if(count($cekhandset) == 0)
			{
				$result = array("success" => "false", "error_code" => "100", "message" => "Invalid handset");
				echo json_encode($result);
				exit;
			}
		}

		$client = $this->input->post('client');

		$keyword = "";
		
		$tablelist = array();
		$listarrayjourney = array();
		$listarrayevent = array();
		$parseresult = array();

		if(count($hasilarray) > 0)
		{
			foreach($hasilarray as $parseresult)
			{
				$keywords = $this->Mobile_model->get_keyword($parseresult['user_id']);

				$randstring = "".mt_rand();
				
				if(count($keywords) > 0)
				{

					foreach($keywords as $keyword1)
					{
						if($keyword1['valid_date'] == date("Y-m-d"))
						{
							$this->Mobile_model->update_keyword1($parseresult['user_id'],$client);
							$keyword = $keyword1['keyword'];
						}
						else
						{
							$this->Mobile_model->update_keyword($parseresult['user_id'],$randstring,$client);
							$keyword = $randstring;
						}
					}
				}
				else
				{
					$this->Mobile_model->add_keyword($parseresult['user_id'],$randstring,$client);
					$keyword = $randstring;
				}
				
				$servicedetail = $this->Mobile_model->get_servicedetail();

				if(count($servicedetail) > 0)
				{
					$rowx = 0;

					foreach($servicedetail as $tableget)
					{
						//$getfield = $this->Mobile_model->get_fieldname($tableget['services_tabel']);
						$getfield = $this->Mobile_model->get_fieldnamefromproperty($tableget['services_id']);

						$ceki = 0;
						if(count($getfield))
						{
							$ceki ++;
							$isi = "";
							$datecek = 1;
							foreach($getfield as $fields)
							{
								if($fields['t_elm_type'] == "radio" || $fields['t_elm_type'] == "checkbox" || $fields['t_elm_type'] == "dropdown")
								{
									$isi .= $fields['t_elm_label']."<br>";
				
									$getsource = $this->Mobile_model->get_datasourcelink($fields['t_source_name'],$fields['t_source_column_display'],$fields['t_source_column_value']);

									if($fields['t_elm_type'] == "radio")
									{		
										if(count($getsource) > 0)
										{
											foreach($getsource as $detailsource)
											{
													$isi .= "<input type=radio name='".$fields['t_services_column']."' id='".$fields['t_services_column']."' value='".$detailsource['jjj1']."' /> ".$detailsource['jjj0']."<br/>";
											}
										}
									}
									elseif($fields['t_elm_type'] == "checkbox")
									{
										if(count($getsource) > 0)
										{
											foreach($getsource as $detailsource)
											{
													$isi .= "<input type=checkbox name='".$fields['t_services_column']."[]' id='".$fields['t_services_column']."[]' value='".$detailsource['jjj1']."' /> ".$detailsource['jjj0']."<br/>";
											}
										}
									}
									else
									{
										$isi .= "<select name='".$fields['t_services_column']."' id='".$fields['t_services_column']."' style='padding: 6px 10px; border-radius: 6px; -webkit-border-radius: 6px'>";
										if(count($getsource) > 0)
										{
											foreach($getsource as $detailsource)
											{
													$isi .= "<option value='".$detailsource['jjj1']."'> ".$detailsource['jjj0']."</option>";
											}
										}
										$isi .= "</select><br/>";
									}
								}
								elseif($fields['t_elm_type'] == "text")
									$isi .= $fields['t_elm_label']."<br/><input type=text name='".$fields['t_services_column']."' id='".$fields['t_services_column']."' style='padding: 6px 10px; border-radius: 6px; -webkit-border-radius: 6px'/><br/>";
								elseif($fields['t_elm_type'] == "textarea")
									$isi .= $fields['t_elm_label']."<br/><textarea name='".$fields['t_services_column']."' id='".$fields['t_services_column']."' cols='30' rows='5' style='padding: 6px 10px; border-radius: 6px; -webkit-border-radius: 6px'/></textarea><br/>";
								elseif($fields['t_elm_type'] == "gps")
									$isi .= "<a href=\"javascript:window.HTMLOUT.accessLocation('gps');\"><img src='../file/images/gps.png' width='28' height='28' align='left'/>&nbsp;".$fields['t_elm_label']."</a><input type='hidden' name='".$fields['t_services_column']."' id='gps'/><br/>";
								elseif($fields['t_elm_type'] == "img")
									$isi .= "<a href=\"javascript:window.HTMLOUT.accessMedia('camera');\"><img src='../file/images/img.png' width='28' height='28' align='left'/>&nbsp;".$fields['t_elm_label']."</a><input type='hidden' name='".$fields['t_services_column']."' id='img'/><br/>";
								elseif($fields['t_elm_type'] == "barcode")
									$isi .= "<a href=\"javascript:window.HTMLOUT.accessBarcode();\"><img src='../file/images/barcode.png' width='28' height='28' align='left'/>&nbsp;".$fields['t_elm_label']."</a><input type='hidden' name='".$fields['t_services_column']."' id='barcode'/><br/>";
								elseif($fields['t_elm_type'] == "date")
								{
									$isi .= "<a href=\"javascript:window.HTMLOUT.accessDate('".$datecek."');\"><img src='../file/images/date.png' width='28' height='28' align='left'/>&nbsp;".$fields['t_elm_label']."</a><input type='hidden' name='".$fields['t_services_column']."' id='date".$datacek."'/><br/>";
									$datecek++;
								}

							}

							$jsnya = "<script type=\"text/javascript\">
									function parseForm(event) {
										var form = this;
										if (this.tagName.toLowerCase() != 'form')
											form = this.form;    
										var data = '';
										if (!form.method)  form.method = 'get';
											data += 'method==' + form.method;
										data += '&&action==' + form.action;     
										/*	var inputs = document.forms[0].getElementsByTagName('input');
										for (var i = 0; i < inputs.length; i++) {
											var field = inputs[i];
											if (field.type != 'submit' && field.type != 'reset' && field.type != 'button')
												data += '&&' + field.name + '==' + field.value + '==' + field.getAttribute('id');
										} */
										var inputs = document.forms[0].getElementsByTagName('input');
										for (var i = 0; i < inputs.length; i++) {
											var field = inputs[i];
											if (field.type != 'submit' && field.type != 'reset' && field.type != 'button' && field.type != 'radio' && field.type != 'checkbox'){
												data += '&&' + field.name + '==' + field.value + '==' + field.getAttribute('id');
											}
											else if(field.type == 'radio')
											{
												if (field.checked) {
													data += '&&' + field.name + '==' + field.value + '==' + field.getAttribute('id');
												}
											}
											else if(field.type == 'checkbox')
											{
												if (field.checked) {
													data += '&&' + field.name + '==' + field.value + '==' + field.getAttribute('id');
												}
											}	         
										}
			   
										var inputs = document.forms[0].getElementsByTagName('select');
										for (var i = 0; i < inputs.length; i++) {
											var field = inputs[i];
											if (field.type != 'submit' && field.type != 'reset' && field.type != 'button')
												data += '&&' + field.name + '==' + field.value + '==' + field.getAttribute('id');
										}
										window.HTMLOUT.processFormData(data);
									}
	       
									for (var form_idx = 0; form_idx < document.forms.length; ++form_idx)
										document.forms[form_idx].addEventListener('submit', parseForm, false);   
									var inputs = document.getElementsByTagName('input');
									for (var i = 0; i < inputs.length; i++) {
										if (inputs[i].getAttribute('type') == 'button')
											inputs[i].addEventListener('click', parseForm, false);
									}
									</script>";

							$forms = "<html><body style=''><form method=post action='http://202.53.249.209/smartfren/index.php/mobile/adddynamicform'><input type=hidden name=serviceid value=".$tableget['services_id']."><input type=hidden name=tablename value=".$tableget['services_tabel'].">$isi<center><input type=submit value='kirim' style='border-radius: 6px; -webkit-border-radius: 6px; width: 98%'></center></form>".$jsnya."</html>";
							write_file("formgenerate/".$tableget['services_tabel'].".html",$forms);

							$tablelist[$rowx] = array("form_id" => $tableget['services_id'], "form_name" => "form/".$tableget['services_name'], "form_download_url" => "http://202.53.249.209/smartfren/formgenerate/".$tableget['services_tabel'].".html");
								
							$rowx++;
						}
					}
				}
			}

			$berita = "";

			$territoryids = $this->Mobile_model->get_parentid($parseresult['user_id']);

			if(count($territoryids) > 0)
			{
				foreach($territoryids as $territory_id)
				{
					$newsarray = $this->Mobile_model->get_lastnews($territory_id['parent_id']);

					if(count($newsarray) == 0)
					{
						while(true)
						{
							$ceklis = $this->Mobile_model->get_parentidbyter($territory_id['parent_id']);

							if(count($ceklis) == 0)
							{
								$berita = "";
								break;
							}
							else
							{
								$newsarray2 = $this->Mobile_model->get_lastnews($ceklis[0]['parent_id']);
								if(count($newsarray2) > 0)
								{
									$berita = $newsarray2[0]['news_content'];
									break;
								}
							}

						}

					}
					else
						$berita = $newsarray[0]['news_content'];
				}
			}
			
			$cektabletjc = $this->Mobile_model->get_availtjc($parseresult['user_id']);

			if($cektabletjc[0]['count'] > 0)
			{
				if($hasilarray[0]['user_group_id'] == 9)
					$listjourney = $this->Mobile_model->get_journeyagenttoday($parseresult['user_id']);
				else
					$listjourney = $this->Mobile_model->get_journeyoutlettoday($parseresult['user_id']);
			}

			if(isset($listjourney))
			if(count($listjourney) > 0)
			{
				$ixx = 0;
				foreach($listjourney as $datajourney)
				{
					if($this->helpme->startsWithChar($datajourney['channel_id'],'I')) //agent INX
					{
						$agents = $this->Mobile_model->get_agent($datajourney['channel_id']);
						if(count($agents) > 0)
						foreach($agents as $agent1)
						{
							$listarrayjourney[$ixx] = array("jc_id" => $datajourney['jc_id'], "channel_id" => $datajourney['channel_id'], "channel_name" => $agent1['agent_name'], "channel_address" => $agent1['agent_address'], "longitude" => $agent1['lon'], "latitude" => $agent1['lat'], "route_date" => $datajourney['tglku']);
						}
					
					}
					else
					{
					//if($this->helpme->startsWithChar($datajourney['channel_id'],'C')) //outlet CJC
						$outlets = $this->Mobile_model->get_outlet($datajourney['channel_id']);
						if(count($outlets) > 0)
						foreach($outlets as $outlet1)
						{
							$listarrayjourney[$ixx] = array("jc_id" => $datajourney['jc_id'], "channel_id" => $datajourney['channel_id'], "channel_name" => $outlet1['outlet_name'], "channel_address" => $outlet1['address'], "longitude" => $outlet1['lon'], "latitude" => $outlet1['lat'], "route_date" => $datajourney['tglku']);
						}
					}
					$ixx++;
				}
			}

			$listevent = $this->Mobile_model->get_sellevent();
		
			if(count($listevent) > 0)
			{
				$ixx = 0;
				foreach($listevent as $dataevent)
				{
					$listarrayevent[$ixx] = array("sell_event_id" => $dataevent['sell_event_id'], "sell_event_name" => $dataevent['sell_event_name']);
					$ixx++;
				}
			}

			$vcombobisnis = $this->Mobile_model->get_vcombobusinessfocus();
		
			if(count($vcombobisnis) > 0)
			{
				$ixx = 0;
				foreach($vcombobisnis as $datacombo)
				{
					$listarraycombo[$ixx] = array("business_focus_value" => $datacombo['member_value'], "business_focus_name" => $datacombo['member_display']);
					$ixx++;
				}
			}

			$vcomboagenttype = $this->Mobile_model->get_vcomboagenttype();
		
			if(count($vcomboagenttype) > 0)
			{
				$ixx = 0;
				foreach($vcomboagenttype as $dataagenttype)
				{
					$listarrayagenttype[$ixx] = array("agent_type_value" => $dataagenttype['member_value'], "agent_type_name" => $dataagenttype['member_display']);
					$ixx++;
				}
			}

			$user_group_id = $this->Mobile_model->get_groupid($parseresult['user_id']);

			if(count($user_group_id) > 0)
			{
				foreach($user_group_id as $usergroupid)
				{
					$usergroupid1 = $usergroupid['user_group_id'];
				}

			}

			$kpi = "";
			$kpis = $this->Mobile_model->get_kpi($parseresult['user_id']);
			
			if(count($kpis) > 0)
			{
				foreach($kpis as $kpiku)
				{
					$kpi = $kpiku['f_get_kpi_by_userid'];
				}
			}

			$trackint = "";

			$trackints = $this->Mobile_model->get_trackint();

			if(count($trackints) > 0)
				$trackint = $trackints[0]['lookup_value'];
		}

		
		$result = array("success" => "true", "form" => $tablelist, "user_id" => $parseresult['user_id'], "news" => $berita, "keyword" => $keyword, "server_date" => date('Y-m-d'), "server_time" => date('H:i'), "journeys" => $listarrayjourney, "sell_events" => $listarrayevent, "business_focus" => $listarraycombo, "agent_type" => $listarrayagenttype, "user_group_id" => $usergroupid1, "kpi" => $kpi, "track_interval" => $trackint);
		echo json_encode($result);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */