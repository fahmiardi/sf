<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">

<script type="text/javascript" src="<?= base_url() ?>file/js/easyui/jquery.easyui.min.js"></script>

<!--add item-->
<!--<script type="text/javascript" src="<?= base_url() ?>file/js/add-item.js"></script>-->
		
<form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">		
<div class="panel-wrap" style="height: auto">
	
	<div class="panel-header-div">Cluster Information</div>
    <div class="panel-body-div">
        <div class="left-panel-body">
            <h2><?=$dist_name?></h2>
            <p><?=$dist_address?></p>
		
		
        </div>
        <div class="right-panel-body">
            <table class="table-right-panel" width="100%" border="solid black 1px">
                <tr align="center" class="tr-colour">
                    <th width="50%" align="center">Date</th>
                    <th align="center">Receipt No</th>
                </tr>
                
                <script type="text/javascript">
				        $(function() {
                            $("#date2").datepicker({ 
								dateFormat: 'yy-mm-dd',
							});
							$("#date").datepicker({ 
								dateFormat: 'yy-mm-dd',
								showOn: 'button',
								buttonImageOnly: true, 
								buttonImage: '<?= base_url() ?>file/js/easyui/themes/pepper-grinder/images/datebox_arrow.png' 
							});
				        });
				</script>
                <tr align="center" class="gray">
                    <td width="50%" align="center">
						<input size="15%"  type="text" id="date" name="receipt_date" onclick="this.value='';" 
							value="<?php 
								date_default_timezone_set("Asia/Jakarta");
								echo date("Y-m-d");
							?>"/>
						<!--<img height="15px" src="<?= base_url() ?>file/js/easyui/themes/pepper-grinder/images/datebox_arrow.png" />-->
					</td>                    
					<td class="readonly" align="center" >
						<span style="font-size: 16pt"><b>Auto</b></span>
					</td>
                    
                </tr>
            </table>
		
        </div>
        
    </div>
</div>


<script type="text/javascript">
var test = 2;
var hasSalesId = false;
function processSalesId()
{
	hasSalesId = true;
	var add_tuple = "";

	var sf = $('select#sales-id option:selected').attr('class');
	$("#sales-name").val(sf);
	var sales_id = $("#sales-id").val();	
	$(".wide").empty();
	
	$.ajax({
		url: "<?php echo base_url(); ?>index.php/sales/load_sales/"+sales_id,
		dataType:"json",
		success:function(data){
			$.each(data, function(i,n){
					add_tuple = "<tr align='center' id='new_tuple"+test+"' class='wide'>"+                                            
									"<td><input type='checkbox'/></td>"+
									"<td>"+ n["iccid"] +"<input align='left' type='hidden' value='"+ n["iccid"] +"' name='iccid[]' /></td>"+ "|" +
									"<td>"+ n["item_code"] +" <input type='hidden' name='item_code[]' value='"+ n["item_code"] +"' /></td>"+
									"<td>"+ n["item_group_name"] +" <input type='hidden' name='item_group_name[]' value='"+ n["item_group_name"] +"' /></td>"+
									"<td>"+ n["item_name"] +" <input type='hidden' name='item_name[]' value='"+ n["item_name"] +"' /></td>"+
								"</tr>";
												
					$('#table-updateable').append(add_tuple);		
					test++;
				});
		},
		error: function(data){	
		}
	});
}
function addList(listCount, val)
{
	
	//var test = 4;
	for(jj=0;jj<listCount;jj++)
	{
		var result = new Array;
		var result = val[jj].split(",");
		
		add_tuple = "<tr align='center' id='new_tuple"+test+"' class='wide'>"+
			"<td><input type='checkbox'/></td>"+
			"<td>"+ result[0] +"<input type='hidden' name='iccid[]' value='"+ result[0] +"'/></td>"+
			"<td>"+ result[1] +"<input type='hidden' name='item_code[]'  value='"+ result[1] +"'/></td>"+
			"<td>"+ result[2] +"<input type='hidden' name='item_group_name[]' value='"+ result[2] +"'/></td>"+
			"<td>"+ result[3] +"<input type='hidden' name='item_name[]'  value='"+ result[3] +"'/></td>"+
		"</tr>";
		$('#table-updateable').append(add_tuple);
		test++;
	}
}

function check_all(){
    $("INPUT[type='checkbox']").attr('checked', $('#select_all').is(':checked'));
}
function delete_checked2(){
        $('input:checkbox:checked').parent().parent().not('#tr_select_all').remove();   
		
}
function delete_checked(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		//alert(rowCount);
		
		for(var i=1; i<rowCount; i++) {
			var row = table.rows[i];
			if (row.cells[0] != null)
			{
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					table.deleteRow(i);
					rowCount--;
					i--;
				}
			}
		}
	}catch(e) {
		alert(e);
	}
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
	if (hasSalesId == false)
	{
		alert("Please choose sales Id first!")
		return false;
	}
	window.open(theURL,winName,features).focus();
}
</script>
	
<div class="panel-wrap" style="height: auto">
	<div class="panel-header-div">Order Information</div>
    <div class="panel-body-div">
        <div class="child-panel-body">
		
        <div class="left-panel-body">

            <table class="table-right-panel" width="60%" border="solid black 1px">
                <tr align="center" class="tr-colour2">
                    <th width="20%" align="center">Sales ID</th>
                    <th align="center">Sales Name</th>
                </tr>
               
                <tr align="center" class="gray">			
					<td width="50%" align="center">
						<!--<select name="sales_id" id="sales_id" onchange="updateText()" class="com" style="width:50%;">-->						
						<select name="sales_id" id="sales-id"  onchange="processSalesId()">
						<option value="">--Select Sales Id--</option>
                        <?php foreach($salesID as $item):?>
                            <option class="<?php echo $item->user_name?>" value="<?php echo $item->user_id?>"><?php echo $item->user_id?></option>
                        <?php endforeach?>
                        </select>		
						
					</td>                   
					
                    <td class="readonly" align="center"><input type="text" name="output" id="sales-name" disabled="true" class="input-readonly" /></td>
                    
                </tr>
            </table>
        </div>
    </div>
	

	
	
    <div class="child-panel-body">	
            <table id="table-updateable" class="table-right-panel" width="92%" style="margin-left: 19px;">
                <thead>
					<tr align="center" class="tr-colour3">
						<th><input id="select_all" onclick="check_all()" type="checkbox" /></th>
						<th>ICCID</th>
						<th>Item Code</th>
						<th>Item Group</th>
						<th>Description</th>
						<!--
						<th>Price (Rp.)</th>
						<th>Price(Custom) (Rp.)</th>
						-->
					</tr>
				</thead>

                
            </table>
				
            <div class="summary"> 
            </div>
            
			<div class="buttons">
					<!--<input type="button" id="itemAdd" onclick="tile()" value="Add"/> -->
					<input type="hidden" name="txtSel" id="txtSel">
					<input name="btnSelect" type="button" id="btnSelect" value="Add" 
					onClick="javascript:MM_openBrWindow('<?php echo base_url() . 'index.php/sales/newcheckbox'; ?>' ,'pop', 'scrollbars=no,width=800,height=310')">		
					<input type="button" onclick="delete_checked('table-updateable')" value="Remove" />
			</div>
        
    </div>
    
	
    <div class="child-panel-body-2">	
        <table class="table-right-panel" style="margin-left: 19px; border: none; ">		
            <tr style="height: 15px;">
				<td style="text-align: left; font-weight: bold; font-size: 1.3em;">Remark:</td>
				<td ><input style="text-align: left; border: none; border-bottom: 1px solid black;" size="141%" type="text" name="remark"/></td>
            </tr>
			
        </table>
	
	</div>
    
        <div class="child-panel-body-2">
        
            <div class="buttons-2" style="margin: 0 auto">
                <input type="submit" value="Submit"/>
                <input type="button" value="Revert" onclick="processSalesId()" />
            </div>
		</div>
		
    </div>
</div>
</form>