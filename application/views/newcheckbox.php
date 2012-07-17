<html>
<head>
	<title>ThaiCreate.Com</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<script language="javascript">
function selValue()
{
	//var val = '';
	var val = new Array();
	var listCount = 0;
	for(i=1;i<=frmPopup.hdnLine.value;i++)
	{
		if(eval("frmPopup.Chk"+i+".checked")==true)
		{
			val[listCount++] = eval("frmPopup.Chk"+i+".value") + ',';
			//listCount++;
		}
	}
	
	
	window.opener.addList(listCount, val);
	
	
	window.opener.document.getElementById("txtSel").value = val;
	window.close();
}
</script>
<?php
	
		$this->db->select('scand.iccid, itm.item_code, grp.item_group_name, itm.item_name, itm.reseller_price, itm.default_price');
		$this->db->from('t_trx_scan_in_detail AS scand');
		$this->db->join("t_trx_scan_in AS scan", "scand.scan_in_id = scan.scan_in_id AND scand.istatus = 1 AND scan.user_id = 'sfa1'");		
		$this->db->join('t_mtr_item AS itm', 'scand.iccid = itm.iccid AND itm.istatus = 1');
		$this->db->join('t_mtr_item_group AS grp', 'itm.item_group_id = grp.item_group_id');
		$query = $this->db->get();
		$query = $query->result_array();
		

?>

<form id="frmPopup" action="" method="post" name="frmPopup">



<table width="750" border="1">
  <tr>
	
    <th width="30"> <div align="center">Select </div></th>
    <th width="87"> <div align="center">ICCID </div></th>
    <th width="87"> <div align="center">Item Code </div></th>
    <th width="87"> <div align="center">Item Group</div></th>
    <th width="200"> <div align="center">Description</div></th>
  </tr>
<?
$ii = 0;
foreach($query as $item)
{
$ii++;
?>
  <tr>
	 <td align="center"><input name="Chk<?=$ii;?>" id="Chk<?=$ii;?>" type="checkbox" value="<?=$item['iccid'] . "," . $item['item_code'] . "," . $item['item_group_name'] . "," . $item['item_name']?>"></td>
    <td><div align="left"><?=$item['iccid'];?></div></td>
    <td><div align="left"><?=$item['item_code'];?></div></td>
    <td><div align="left"><?=$item['item_group_name'];?></div></td>
    <td><div align="left"><?=$item['item_name'];?></div></td>
   
	
  </tr>
<?
}
?>
</table>
 <input name="hdnLine" type="hidden" value="<?=$ii;?>">
  <br>
  <input name="btnSelect" type="button" value="Select" onClick="JavaScript:selValue();">
</form>


</body>
</html>