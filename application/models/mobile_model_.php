<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_item($itemID)
    {
		$this->db->select('item_name');
		$this->db->from('t_mtr_item');
		$this->db->where('item_id', $itemID);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   return $row->item_name;
		}
		else
			return NULL;
    }

	function cekhandset($userid,$imsi,$imei)
    {
		$this->db->select('imei,imsi');
		$this->db->from('t_mtr_handset');
		$this->db->where("user_id = '".$userid."' and imsi = '".$imsi."' and imei = '".$imei."'");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
    }

	function get_itemsfromarray($matchs)
	{
		$intcek = 0;
		$cocokan = "";
		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				continue;

			if($intcek == 0)
				$cocokan .= "'".$dataitem['value']."'";
			else
				$cocokan .= ",'".$dataitem['value']."'";
			$intcek++;
		}

		if($intcek == 0)
			$cocokan = "''";

		$this->db->select("iccid,item_id,item_name,default_price,item_group_id");
		$this->db->from("t_mtr_item");
		$this->db->where("iccid = ANY(ARRAY[$cocokan])");
		$query = $this->db->get();

		$itemada = array();
		$intcek = 0;
		
		if($query->num_rows() > 0)
		foreach($query->result_array() as $hasilperbaris)
		{
			$itemada[$intcek] = $hasilperbaris['iccid'];
			$detailitem[$hasilperbaris['iccid']] = array("item_id" => $hasilperbaris['item_id'], "item_name" => $hasilperbaris['item_name'], "item_code" => $hasilperbaris['iccid'], "price" => $hasilperbaris['default_price'], "item_group_id" => $hasilperbaris['item_group_id']);
			$intcek++;
		}
		
		$hasilnya = array();
		$intcek = 0;

		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
			else
			{
				if(in_array($dataitem['value'],$itemada))
				{
					$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value'], "detail" => $detailitem[$dataitem['value']]);
				}
				else
				{
					$hasilnya[$intcek] = array("true" => "invalid", "value" => $dataitem['value']);
				}
			}
			$intcek++;
		}

		return $hasilnya;
	}

	function get_iccidsellscaninfromarray($matchs)
	{
		$intcek = 0;
		$cocokan = "";
		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				continue;

			if($intcek == 0)
				$cocokan .= "'".$dataitem['value']."'";
			else
				$cocokan .= ",'".$dataitem['value']."'";
			$intcek++;
		}

		if($intcek == 0)
			$cocokan = "''";

		$this->db->select("iccid");
		$this->db->from("t_trx_scan_in_detail");
		$this->db->where("iccid = ANY(ARRAY[$cocokan])");
		$query = $this->db->get();

		$itemada = array();
		$intcek = 0;

		if($query->num_rows() > 0)
		foreach($query->result_array() as $hasilperbaris)
		{
			$itemada[$intcek] = $hasilperbaris['iccid'];
			$intcek++;
		}

		$hasilnya = array();
		$intcek = 0;

		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
			else
			{
				if(in_array($dataitem['value'],$itemada))
				{
					$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);

				}
				else
				{
					$hasilnya[$intcek] = array("true" => "invalid", "value" => $dataitem['value']);
				}
			}
			$intcek++;
		}

		return $hasilnya;
	}

	function get_iccidscaninfromarray($matchs)
	{
		$intcek = 0;
		$cocokan = "";
		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				continue;

			if($intcek == 0)
				$cocokan .= "'".$dataitem['value']."'";
			else
				$cocokan .= ",'".$dataitem['value']."'";
			$intcek++;
		}

		if($intcek == 0)
			$cocokan = "''";

		$this->db->select("iccid");
		$this->db->from("t_trx_scan_in_detail");
		$this->db->where("iccid = ANY(ARRAY[$cocokan])");
		$query = $this->db->get();

		$itemada = array();
		$intcek = 0;
		
		if($query->num_rows() > 0)
		foreach($query->result_array() as $hasilperbaris)
		{
			$itemada[$intcek] = $hasilperbaris['iccid'];
			$intcek++;
		}

		$hasilnya = array();
		$intcek = 0;

		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
			else
			{
				if(in_array($dataitem['value'],$itemada))
				{
					$hasilnya[$intcek] = array("true" => "invalid", "value" => $dataitem['value']);

				}
				else
				{
					$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value'], "detail" => $dataitem['detail']);
				}
			}
			$intcek++;
		}

		return $hasilnya;
	}

	function get_iccidsellinfromarray($matchs)
	{
		$intcek = 0;
		$cocokan = "";
		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				continue;

			if($intcek == 0)
				$cocokan .= "'".$dataitem['value']."'";
			else
				$cocokan .= ",'".$dataitem['value']."'";
			$intcek++;
		}

		if($intcek == 0)
			$cocokan = "''";

		$this->db->select("iccid");
		$this->db->from("t_trx_sell_in_detail");
		$this->db->where("iccid = ANY(ARRAY[$cocokan])");
		$query = $this->db->get();

		$itemada = array();
		$intcek = 0;
		
		if($query->num_rows() > 0)
		foreach($query->result_array() as $hasilperbaris)
		{
			$itemada[$intcek] = $hasilperbaris['iccid'];
			$intcek++;
		}

		$hasilnya = array();
		$intcek = 0;

		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
			else
			{
				if(in_array($dataitem['value'],$itemada))
				{
					$hasilnya[$intcek] = array("true" => "invalid", "value" => $dataitem['value']);

				}
				else
				{
					$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
				}
			}
			$intcek++;
		}

		return $hasilnya;
	}

	function get_iccidsellreturnfromarray($matchs)
	{
		$intcek = 0;
		$cocokan = "";
		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				continue;

			if($intcek == 0)
				$cocokan .= "'".$dataitem['value']."'";
			else
				$cocokan .= ",'".$dataitem['value']."'";
			$intcek++;
		}

		if($intcek == 0)
			$cocokan = "''";

		$this->db->select("iccid");
		$this->db->from("t_trx_sell_return_detail");
		$this->db->where("iccid = ANY(ARRAY[$cocokan])");
		$query = $this->db->get();

		$itemada = array();
		$intcek = 0;
		
		if($query->num_rows() > 0)
		foreach($query->result_array() as $hasilperbaris)
		{
			$itemada[$intcek] = $hasilperbaris['iccid'];
			$intcek++;
		}

		$hasilnya = array();
		$intcek = 0;

		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
			else
			{
				if(in_array($dataitem['value'],$itemada))
				{
					$hasilnya[$intcek] = array("true" => "invalid", "value" => $dataitem['value']);

				}
				else
				{
					$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
				}
			}
			$intcek++;
		}

		return $hasilnya;
	}

	function get_iccidstockscanfromarray($matchs)
	{
		$intcek = 0;
		$cocokan = "";
		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				continue;

			if($intcek == 0)
				$cocokan .= "'".$dataitem['value']."'";
			else
				$cocokan .= ",'".$dataitem['value']."'";
			$intcek++;
		}
		
		if($intcek == 0)
			$cocokan = "''";

		$this->db->select("iccid");
		$this->db->from("t_trx_stock_scan_detail");
		$this->db->where("iccid = ANY(ARRAY[$cocokan])");
		$query = $this->db->get();

		$itemada = array();
		$intcek = 0;
		
		if($query->num_rows() > 0)
		foreach($query->result_array() as $hasilperbaris)
		{
			$itemada[$intcek] = $hasilperbaris['iccid'];
			$intcek++;
		}

		$hasilnya = array();
		$intcek = 0;

		foreach($matchs as $dataitem)
		{
			if($dataitem['true'] == "invalid")
				$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
			else
			{
				if(in_array($dataitem['value'],$itemada))
				{
					$hasilnya[$intcek] = array("true" => "invalid", "value" => $dataitem['value']);

				}
				else
				{
					$hasilnya[$intcek] = array("true" => $dataitem['true'], "value" => $dataitem['value']);
				}
			}
			$intcek++;
		}

		return $hasilnya;
	}

	function get_prodcatalog()
	{
		$this->db->select("item_id, item_name, item_code, iccid, istatus, default_price");
		$this->db->from("t_mtr_item");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_prodcatalog2($itemgroupid)
	{
		$this->db->select("item_id, item_name, item_code, iccid, istatus, default_price");
		$this->db->from("t_mtr_item");
		$this->db->where("item_group_id",$itemgroupid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_itemgroup()
	{
		$this->db->select("item_group_id, item_group_name");
		$this->db->from("t_mtr_item_group");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function add_scanin($data,$jumlah,$client)
    {
		$userid = $data['user_id'];
		$data = array(
			'user_id' => $userid,
			'scan_date' => date("Y-m-d"),
			//'quantity' => $jumlah,
			//'real_qty' => $jumlah,
			'created_by' => $userid,
			'updated_by' => $userid,
			'istatus' => 1,
			'acess_via' => $client
		);
		$this->db->insert('t_trx_scan_in', $data);
		return $this->db->insert_id();
    }

	function add_scanin_detail($ICCID,$scanid)
	{
		$data = array(
			'scan_in_id' => $scanid,
			'iccid' => $ICCID,
			'istatus' => 1
		);
		$this->db->insert('t_trx_scan_in_detail', $data);
	}

	function add_sellin($data,$client)
    {
		$userid = $data['user_id'];
		$channelid = $data['channel_id'];
		$sell_event_id = $data['sell_event_id'];

		if($data['date'] == "")
		{
			$tanggal = date("Y-m-d H:i:s");
		}
		else
			$tanggal = $data['date'];

		$data = array(
			'user_id' => $userid,
			'channel_id' => $channelid,
			'created_by' => $userid,
			'created_on' => $tanggal,
			'updated_by' => $userid,
			'sell_event_id' => $sell_event_id,
			'istatus' => 1,
			'acess_via' => $client
		);
		$this->db->insert('t_trx_sell_in', $data);
		return $this->db->insert_id();
    }

	function add_sellin_detail($ICCID,$sellinid)
	{
		$data = array(
			'sell_in_id' => $sellinid,
			'iccid' => $ICCID,
			'istatus' => 1
		);
		$this->db->insert('t_trx_sell_in_detail', $data);
	}

	function update_scanin($iccid,$istatus)
    {
		$data = array(
			'istatus' => $istatus
		);
		$this->db->where("iccid = '".$iccid."'");
		return $this->db->update('t_trx_scan_in_detail', $data);
    }

	function update_journey($journeyid,$userid,$check_in_date)
    {
		if($check_in_date == "")
			$tanggal = date("Y-m-d");
		else
			$tanggal = $check_in_date;

		$data = array(
			'check_in_date' => $tanggal
		);
		$this->db->where("journey_id = '".$journeyid."' and user_id = '".$userid."'");
		return $this->db->update('t_trx_journey', $data);
    }

	function add_journey($userid,$check_in_date,$route_date,$data)
    {
		if($check_in_date == "")
			$tanggal = date("Y-m-d");
		else
			$tanggal = $check_in_date;

		$data = array(
			'user_id' => $userid,
			'jc_id' => $data['jc_id'],
			'check_in_date' => $tanggal,
			'channel_id' => $data['channel_id'],
			'route_date' => $route_date,
			'created_by' => $userid,
			'created_on' => date("Y-m-d h:i:s"),
			'updated_by' => $userid,
			'updated_on' => date("Y-m-d h:i:s")
		);
		return $this->db->insert('t_trx_journey', $data);
    }

	function add_sellreturn($data,$client)
    {
		$userid = $data['user_id'];
		$channelid = $data['channel_id'];
		
		if($data['date'] == "")
		{
			$tanggal = date("Y-m-d H:i:s");
		}
		else
			$tanggal = $data['date'];

		$data = array(
			'user_id' => $userid,
			'channel_id' => $channelid,
			'created_by' => $userid,
			'created_on' => $tanggal,
			'updated_by' => $userid,
			'updated_on' => $tanggal,
			'istatus' => 1,
			'acess_via' => $client
		);
		$this->db->insert('t_trx_sell_return', $data);
		return $this->db->insert_id();
    }

	function add_sellreturn_detail($ICCID,$sellreturnid)
	{
		$data = array(
			'return_id' => $sellreturnid,
			'iccid' => $ICCID,
			'istatus' => 1
		);
		$this->db->insert('t_trx_sell_return_detail', $data);
	}

	function add_stockscan($data,$jumlah)
    {
		$userid = $data['user_id'];
		$channelid = $data['channel_id'];
		
		if($data['date'] == "")
		{
			$tanggal = date("Y-m-d H:i:s");
		}
		else
			$tanggal = $data['date'];

		$data = array(
			'channel_id' => $channelid,
			'created_by' => $userid,
			'created_on' => $tanggal,
			'updated_by' => $userid,
			'updated_on' => $tanggal,
			'quantity' => $jumlah
		);
		$this->db->insert('t_trx_stock_scan', $data);
		return $this->db->insert_id();
    }

	function add_stockscan_detail($ICCID,$stockscanid)
	{
		$data = array(
			'stock_scan_id' => $stockscanid,
			'iccid' => $ICCID
		);
		$this->db->insert('t_trx_stock_scan_detail', $data);
	}

	function add_trackuser($lon,$lat,$userid,$cellid,$lac)
	{
		if(($lon == "" || $lon === NULL) && ($lat == "" || $lat === NULL))
			$data = array(
				'user_id' => $userid,
				'track_date' => date('Y-m-d'),
				'lon' => "",
				'lat' => "",
				'created_by' => $userid,
				'cell_id' => $cellid,
				'lac' => $lac
			);
		else
			$data = array(
				'user_id' => $userid,
				'track_date' => date('Y-m-d'),
				'lon' => $lon,
				'lat' => $lat,
				'created_by' => $userid
			);
		$this->db->insert('t_trx_track', $data);
	}

	function get_user($data)
	{
		$this->db->select("user_id, user_group_id, is_allowed_time");
		$this->db->from("t_mtr_user");
		$this->db->where("user_id = '".$data['username']."' and user_password = md5('".$data['password']."')");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_servicetarget($data)
	{
		$this->db->select("services_id");
		$this->db->from("t_trx_service_target");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_servicedetail()
	{
		$this->db->select("services_name, services_tabel, services_id");
		$this->db->from("t_trx_service");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_fieldname($namatabel)
	{
		$this->db->query("SELECT a.attname as Column, pg_catalog.format_type(a.atttypid, a.atttypmod) as Datatype FROM pg_catalog.pg_attribute a WHERE a.attnum > 0 AND NOT a.attisdropped AND a.attrelid = (SELECT c.oid FROM pg_catalog.pg_class c LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace WHERE c.relname ~ '^($namatabel)$' AND pg_catalog.pg_table_is_visible(c.oid))");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function add_formdinamik($query)
	{
		$this->db->query($query);
	}

	function get_fieldnamefromproperty($serviceid)
	{
		$this->db->select("t_services_column,t_elm_type,t_elm_label,t_source_name,t_source_column_display,t_source_column_value");
		$this->db->from("t_trx_service_property");
		$this->db->where("services_id = $serviceid and enabled_mobile=1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_datasourcelink($namatabel,$kolom1,$kolom2)
	{
		if($namatabel != "" && $kolom1 != "" && $kolom2 != "")
		{
			$this->db->select($kolom1." as jjj0,".$kolom2." as jjj1");
			$this->db->from($namatabel);
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else
				return NULL;
		}
		else
			return NULL;
	}

	function get_availtjc($userid)
	{
		$this->db->select("count(1)");
		$this->db->from("pg_tables");
		$this->db->where("tablename = 't_jc_".$userid."' and schemaname = 'public'");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_journey($userid,$jcid)
	{
		$this->db->select("jc_id, channel_id");
		$this->db->from("t_jc_".$userid);
		$this->db->where("jc_id",$jcid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_journeyagenttoday($userid)
	{
		if(date("N") == 1)
			$hds = 7;
		else
			$hds = date("N") - 1;

		$this->db->select("jc_id, channel_id, '".date("Y-m-d")."' as tglku", FALSE);
		$this->db->from("t_jc_".$userid);
		$this->db->where("yyyymm = '".date("YW")."' and d".$hds." = 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_journeyoutlettoday($userid)
	{
		$this->db->select("jc_id, channel_id, '".date("Y-m-d")."' as tglku", FALSE);
		$this->db->from("t_jc_".$userid);
		$this->db->where("yyyymm = '".date("Ym")."' and d".date("j")." = 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_agent($agentid)
	{
		$this->db->select("lon, lat, agent_name, agent_address");
		$this->db->from("t_mtr_agent");
		$this->db->where("agent_id = '".$agentid."' and istatus = 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_outlet($outletid)
	{
		$this->db->select("lon, lat, outlet_name, address");
		$this->db->from("t_mtr_outlet");
		$this->db->where("outlet_id = '".$outletid."' and istatus = 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_outletbyterritoryid($territoryid)
	{
		$this->db->select("outlet_id, lon, lat, outlet_name, address, city");
		$this->db->from("t_mtr_outlet");
		$this->db->where("territory_id",$territoryid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_agentbyterritoryid($territoryid)
	{
		$this->db->select("agent_id, lon, lat, agent_name, agent_address, agent_city, agent_business_focus, agent_type");
		$this->db->from("t_mtr_agent");
		$this->db->where("territory_id",$territoryid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_territorybyuserid($userid,$tipeterritory)
	{
		$this->db->select("territory_id");
		$this->db->from("t_mtr_territory");
		$this->db->where("user_id = '".$userid."' and territory_type_id = ".$tipeterritory);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function add_territorymtr($name,$territoryid,$userid,$tipeterritory)
	{
		$data = array(
			'territory_name' => $name,
			'parent_id' => $territoryid,
			'user_id' => $userid,
			'territory_type_id' => $tipeterritory,
			'created_by' => $userid,
			'updated_by' => $userid,
			'istatus' => 0
		);
		$this->db->insert('t_mtr_territory', $data);
		return $this->db->insert_id();
	}

	function add_territorymtruser($userid,$territoryid)
	{
		$data = array(
			'user_id' => $userid,
			'territory_id' => $territoryid,
			'created_by' => $userid,
			'updated_by' => $userid
		);
		$this->db->insert('t_mtr_user_territory', $data);
	}

	function add_outlet($userid,$territoryidlast,$outletname,$outletaddress,$outletcity,$longitude,$latitude,$imagepath,$outletbf)
	{
		$this->db->query("SELECT sp_mobile_outlet('#','".$userid."','".$outletname."',$territoryidlast,'".$outletaddress."','".$outletcity."','".$outletbf."','','".$longitude."','".$latitude."','".$imagepath."')");
		$query = $this->db->get();
		
		$idoutlets = $query->result_array();
		return $idoutlets[0]['sp_mobile_outlet'];

		/*
		$data = array(
			'outlet_id' => "#",
			'territory_id' => $territoryidlast,
			'outlet_name' => $outletname,
			'address' => $outletaddress,
			'city' => $outletcity,
			'lon' => $longitude,
			'lat' => $latitude,
			'image_path' => $imagepath,
			'created_by' => $userid,
			'updated_by' => $userid,
			'istatus' => 0
		);
		$this->db->insert('t_mtr_outlet', $data);
		return $this->db->insert_id();
		*/
	}

	function add_outletdata($outletid,$outletbf)
	{
		$data = array(
			'outlet_id' => $outletid,
			'outlet_business_focus' => $outletbf
		);
		$this->db->insert('t_mtr_outlet_data', $data);
	}

	function add_agent($userid,$agentid,$territoryidlast,$agentname,$agentaddress,$agentcity,$agentbf,$agenttype,$longitude,$latitude)
	{
		$data = array(
			'agent_id' => $agentid,
			'territory_id' => $territoryidlast,
			'agent_name' => $agentname,
			'agent_address' => $agentaddress,
			'agent_city' => $agentcity,
			'agent_business_focus' => $agentbf,
			'agent_type' => $agenttype,
			'created_by' => $userid,
			'updated_by' => $userid,
			'lon' => $longitude,
			'lat' => $latitude,
			'istatus' => 0
		);
		$this->db->insert('t_mtr_agent', $data);
	}

	function update_agent($agentid,$agentname,$agentaddress,$agentcity,$agentbf,$agenttype)
	{
		$data = array(
			'agent_name' => $agentname,
			'agent_address' => $agentaddress,
			'agent_city' => $agentcity,
			'agent_business_focus' => $agentbf,
			'agent_type' => $agenttype
		);
		$this->db->where("agent_id",$agentid);
		$this->db->update('t_mtr_agent', $data);
	}

	function update_outlet($outletid,$outletname,$outletaddress,$outletcity)
	{
		$data = array(
			'outlet_name' => $outletname,
			'address' => $outletaddress,
			'city' => $outletcity
		);
		$this->db->where("outlet_id",$outletid);
		$this->db->update('t_mtr_outlet', $data);
	}

	function update_outletdata($outletid,$outletbf)
	{
		$data = array(
			'outlet_business_focus' => $outletbf
		);
		$this->db->where("outlet_id",$outletid);
		$this->db->update('t_mtr_outlet_data', $data);
	}

	function get_kpi($userid)
	{
		$this->db->select("*");
		$this->db->from("f_get_kpi_by_userid('".$userid."')");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_closestgallery($userid,$lonmax,$lonmin,$latmax,$latmin)
	{
		$this->db->select("gallery_id,gallery_name,gallery_address");
		$this->db->from("t_mtr_gallery");
		$this->db->where("cast(lon as decimal) > ".$lonmin." and cast(lon as decimal) < ".$lonmax." and cast(lat as decimal) > ".$latmin." and cast(lat as decimal) < ".$latmax);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_bisnisfocusbyoutlet($outletid)
	{
		$this->db->select("outlet_business_focus");
		$this->db->from("t_mtr_outlet_data");
		$this->db->where("outlet_id",$outletid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_sellevent()
	{
		$this->db->select("sell_event_id, sell_event_name");
		$this->db->from("t_mtr_sell_event");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_keyword($userid)
	{
		$this->db->select("keyword, valid_date");
		$this->db->from("t_keywords");
		$this->db->where("user_id",$userid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_keywordtoday($userid,$keyword)
	{
		$tanggalskr = date("Y-m-d");
		$this->db->select("keyword,client");
		$this->db->from("t_keywords");
		$this->db->where("user_id = '".$userid."' and keyword='".$keyword."' and valid_date = '".$tanggalskr."'");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function update_keyword($userid,$keyword,$client)
    {
		$data = array(
			'valid_date' => date('Y-m-d'),
			'keyword' => $keyword,
			'client' => $client
		);
		$this->db->where("user_id = '".$userid."'");
		$this->db->update('t_keywords', $data);
    }

	function update_keyword1($userid,$client)
    {
		$data = array(
			'client' => $client
		);
		$this->db->where("user_id = '".$userid."'");
		$this->db->update('t_keywords', $data);
    }

	function add_keyword($userid,$keyword)
    {
		$data = array(
			'user_id' => $userid,
			'valid_date' => date("Y-m-d"),
			'keyword' => $keyword
		);
		$this->db->insert('t_keywords', $data);
    }

	function get_lastnews($territory_id)
	{
		$this->db->select("news_content");
		$this->db->from("t_ntf_news");
		$this->db->where("territory_id = $territory_id order by created_on desc limit 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_trackint()
	{
		$this->db->select("lookup_value");
		$this->db->from("t_mtr_lookup");
		$this->db->where("lookup_key = 'mobile_lonlat_interval' limit 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_reportto($userid)
	{
		$this->db->select("reporting_to");
		$this->db->from("t_mtr_user");
		$this->db->where("user_id",$userid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_parentid($userid)
	{
		$this->db->select("parent_id");
		$this->db->from("t_mtr_territory");
		$this->db->where("user_id = '".$userid."' limit 1");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_parentidbyter($territoryid)
	{
		$this->db->select("parent_id");
		$this->db->from("t_mtr_territory");
		$this->db->where("territory_id = ".$territoryid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function add_merchancapture($datakirim)
	{
		$userid = $datakirim['user_id'];
		$channelid = $datakirim['channel_id'];
		$linkpath = $datakirim['link'];
		$longitude = $datakirim['lon'];
		$latitude = $datakirim['lat'];

		if($datakirim['tanggal'] != NULL || $datakirim['tanggal'] != "")
			$data = array(
			'channel_id' => $channelid,
			'pic1' => $linkpath,
			'lon' => $longitude,
			'lat' => $latitude,
			'istatus' => 1,
			'created_by' => $userid,
			'updated_by' => $userid,
			'user_id' => $userid,
			'created_on' => $datakirim['tangga'],
			'updated_on' => $datakirim['tangga']
			);
		else
			$data = array(
			'channel_id' => $channelid,
			'pic1' => $linkpath,
			'lon' => $longitude,
			'lat' => $latitude,
			'istatus' => 1,
			'created_by' => $userid,
			'updated_by' => $userid,
			'user_id' => $userid
			);
		$this->db->insert('t_trx_merchan_capture', $data);
	}

	function get_vcombobusinessfocus()
	{
		$this->db->select("member_value, member_display");
		$this->db->from("v_combo_business_focus");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_vcomboagenttype()
	{
		$this->db->select("member_value, member_display");
		$this->db->from("v_combo_agent_type");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}

	function get_groupid($userid)
	{
		$this->db->select("user_group_id");
		$this->db->from("t_mtr_user");
		$this->db->where("user_id",$userid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query->result_array();
		}
		else
			return NULL;
	}
}

?>