<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">


<script type="text/javascript" src="<?= base_url() ?>file/js/add-item.js"></script>
	

		
<form id="form" action="<?=base_url() ?>returns/save" method="post">
	<div class="panel-wrap" style="height: auto">
		<div class="panel-header-div">Cluster Information</div>
		<div class="panel-body-div">
		
			<div class="left-panel-body">
				<?php foreach($cluster as $item):?>
					<h2><?php echo $item->territory_name?></h2>
					<p><?php echo ""?></p>
					<input type="hidden" value="<?php echo $item->territory_id?>" name="territory_id"/>
				<?php endforeach?>
			</div>
			<div class="right-panel-body">
				<table class="table-right-panel" width="100%" border="solid black 1px">
					<tr align="center" class="tr-colour">
						<th width="50%" align="center">Date</th>
						<th align="center">Return No</th>
					</tr>
					
					
					<tr align="center" class="gray">
						
						<td class="readonly" width="50%" align="center">
							<input type="text" name="return_date"  id="date" readonly="true"/>
									<script language="JavaScript">
										var date = new Date();
										var day = date.getDate();
										var mo = date.getMonth() + 1;
										var month = (mo < 10) ? "0"+mo : mo;
										var yy = date.getYear();
										var year = (yy < 1000) ? yy + 1900 : yy;

										
										document.getElementById("date").value = year + "-" + mo + "-" + day;
									</script>
								</td>
						
						<td class="readonly" width="50%" align="center">
							<input type="text" name="return_no"  id="return_no" disabled="true" value="Auto"/>
							
							
						</td>
						
					</tr>
				</table>
			</div>
			
		</div>
	</div>


	<div class="panel-wrap" style="height: auto">
		<div class="panel-header-div">Return Information</div>
		
		<div class="panel-body-div">
			<div class="child-panel-body">
				<div class="left-panel-body">
				
					<table class="table-right-panel" width="60%" border="solid black 1px">
						<tr align="center" class="tr-colour2">
							<th align="center">Sales Name</th>
							<th width="20%" align="center">Sales ID</th>
						</tr>
						
						
						<tr align="center" class="gray">
							<td>
								
								<select name="sales_id" id="sales-id" onChange="showsales();">
									<?php foreach($sales as $item):?>
										<option value="<?php echo $item->user_id?>"><?php echo $item->user_name?></option>
									<?php endforeach?>
								</select>
								
							</td>
							<td class="readonly" align="center">
								<input type="text" name="sales_name" id="sales-name" size="40" disabled="true" value="<?php echo $sales[0]->user_id?>"/>
							</td>
							
							
						</tr>
					</table>
				</div>
			</div>
			
			<br><br>
			<div class="child-panel-body-2">
				<div class="buttons">
						<input type="button" onclick="addNewRow()" value="Add" id="itemAdd" /> 
						<input type="button" onclick="deleteRow()" value="Delete" />
				</div>
			</div>
		
		
						
			<div class="child-panel-body">
				
					<table class="table-right-panel" id="table-updateable" width="92%" style="margin-left: 19px;">
						<tr align="center" class="tr-colour3" id="tr_select_all">
							<th><input type="checkbox" id="select_all" onclick="clickAll();"/></th>
							<th>ICCID</th>
							<th>Buying Date</th>
							<th>Description</th>
							<th>Price (Rp.)</th>							
						</tr>
						<tr>
							<td class="readonly"><input type="checkbox" id="check[1]" name="check[ ]"/></td>
							<td><input type="text" id="nomorBarang[1]" name="nomorBarang1" size="15" onChange="tes(1);"/></td>
							<td class="readonly"><input type="text" id="buying[1]" name="buying1" readonly="true"/></td>
							<td><input type="text" name="desc1" id="desc[1]" readonly="true"/></td>
							<td class="readonly"><input type="text" id="price[1]" name="price1" readonly="true"/></td>
						</tr>
					</table>
			</div>
		
			<div class="child-panel-body-2">
				<table class="table-right-panel" width="92%" style="margin-left: 19px; border: none; ">
					<tr style="height: 15px;">
						<td style="text-align: left; font-weight: bold; font-size: 1.3em;">Remark:</td>
						<td width="94%" style="border-bottom: solid #000 1px;">
							<textarea name="remark" rows="6" cols="130"></textarea>
						</td>
						<input type="hidden" value="1" name="jumlah_entry" id="jumlah_entry"/>
					</tr>
				</table>
			</div>
		
			<div class="child-panel-body-2">
				<div class="buttons-2" style="margin: 0 auto">
					<input type="submit" value="Submit"/>
				</div>
			</div>
		</div>
	</div>
</form>

<!--<script language="JavaScript">-->
<script type="text/javascript">		
	function showsales() {
		var d = document.getElementById("sales-id").value;
		document.getElementById("sales-name").value = d;
		
	}
		
	function showoutlet() {
		var d = document.getElementById("outlet-id").value;
		
		document.getElementById("outlet-name").value = d;

	}
</script>
<script type="text/javascript">		
	var index = 2;
	
	function addNewRow() {
		var tbl = document.getElementById("table-updateable");
		var row = tbl.insertRow(tbl.rows.length);
		var td0 = document.createElement("td");
		var td1 = document.createElement("td");
		var td2 = document.createElement("td");
		var td3 = document.createElement("td");
		var td4 = document.createElement("td");
		
		td0.setAttribute("class", "readonly");
		td2.setAttribute("class", "readonly");
		td4.setAttribute("class", "readonly");
		
		td0.appendChild(generateCheckBox(index));
		td1.appendChild(generateNomorBarang(index));
		td2.appendChild(generateBuying(index));
		td3.appendChild(generateDesc(index));
		td4.appendChild(generatePrice(index));
		row.appendChild(td0);
		row.appendChild(td1);
		row.appendChild(td2);
		row.appendChild(td3);
		row.appendChild(td4);
		document.getElementById("jumlah_entry").value = index;
		index++;
	}
		
	function generateCheckBox(index) {
		var check = document.createElement("input");
		check.type = "checkbox";
		check.name = "check[ ]";
		check.id = "check["+index+"]";
		
		return check;
	}
	function generateNomorBarang(index) {
		var idx = document.createElement("input");
		idx.type = "text";
		idx.name = "nomorBarang"+index;
		idx.id = "nomorBarang["+index+"]";
		idx.size = "15";
		idx.setAttribute("onChange", "tes("+index+")");
		
		return idx;
	}
	function generateBuying(index) {
		var idx = document.createElement("input");
		idx.type = "text";
		idx.setAttribute("readonly", "true");
		idx.name = "buying"+index;
		idx.id = "buying["+index+"]";
		return idx;
	}
	function generatePrice(index) {
		var idx = document.createElement("input");
		idx.type = "text";
		idx.setAttribute("readonly", "true");
		idx.name = "price"+index;
		idx.id = "price["+index+"]";
		return idx;
	}
	function generateDesc(index) {
		var idx = document.createElement("input");
		idx.type = "text";
		idx.setAttribute("readonly", "true");
		idx.name = "desc"+index;
		idx.id = "desc["+index+"]";
		return idx;
	}
		
	
	function clickAll() {
		var checked = false;
		if (document.getElementById("select_all").checked == true)
			checked = true;
		var tbl = document.getElementById("table-updateable");
		var rowLen = tbl.rows.length;
		for (var idx=1;idx<rowLen;idx++) {
			var row = tbl.rows[idx];
			var cell = row.cells[0];
			var node = cell.lastChild;
			node.checked = checked;
		}
	}
	function deleteAll() {
		var tbl = document.getElementById("table-updateable");
		var rowLen = tbl.rows.length - 1;
		for (var idx=rowLen;idx > 0;idx--) {
			tbl.deleteRow(idx)
		}
	}
	function bufferRow(table) {
		var tbl = document.getElementById("table-updateable");
		var rowLen = tbl.rows.length;
		for (var idx=1;idx<rowLen;idx++) {
			var row = tbl.rows[idx];
			var cell = row.cells[0];
			var node = cell.lastChild;
			if (node.checked == false) {
				var rowNew = table.insertRow(table.rows.length);
				var td0 = document.createElement("td");
				var td1 = document.createElement("td");
				var td2 = document.createElement("td");
				var td3 = document.createElement("td");
				var td4 = document.createElement("td");
				
				td0.setAttribute("class", "readonly");
				td2.setAttribute("class", "readonly");
				td4.setAttribute("class", "readonly");
			
				td0.appendChild(row.cells[0].lastChild);
				td1.appendChild(row.cells[1].lastChild);
				td2.appendChild(row.cells[2].lastChild);
				//td3.appendChild(row.cells[3].firstChild);
				td3.appendChild(row.cells[3].lastChild);
				td4.appendChild(row.cells[4].lastChild);
				rowNew.appendChild(td0);
				rowNew.appendChild(td1);
				rowNew.appendChild(td2);
				rowNew.appendChild(td3);
				rowNew.appendChild(td4);
			}
		}
	}
	function reIndex(table) {
		var tbl = document.getElementById("table-updateable");
		var rowLen = table.rows.length;
		for (var idx=0;idx < rowLen;idx++) {
			var row = table.rows[idx];
			var rowTbl = tbl.insertRow(tbl.rows.length);
			var td0 = document.createElement("td");
			var td1 = document.createElement("td");
			var td2 = document.createElement("td");
			var td3 = document.createElement("td");
			var td4 = document.createElement("td");
			
			td0.setAttribute("class", "readonly");
			td2.setAttribute("class", "readonly");
			td4.setAttribute("class", "readonly");
			
			td0.appendChild(row.cells[0].lastChild);
			td1.appendChild(row.cells[1].lastChild);
			td2.appendChild(row.cells[2].lastChild);
			//td3.appendChild(row.cells[3].firstChild);
			td3.appendChild(row.cells[3].lastChild);
			td4.appendChild(row.cells[4].lastChild);
			rowTbl.appendChild(td0);
			rowTbl.appendChild(td1);
			rowTbl.appendChild(td2);
			rowTbl.appendChild(td3);
			rowTbl.appendChild(td4);
		}
	}
	function deleteRow() {
		var tbl = document.getElementById("table-updateable");
		var error = false;
		if (document.getElementById("select_all").checked == false)
			error = true;
		var tbl = document.getElementById("table-updateable");
		var rowLen = tbl.rows.length;
		for (var idx=1;idx<rowLen;idx++) {
			var row = tbl.rows[idx];
			var cell = row.cells[0];
			var node = cell.lastChild;
			if (node.checked == true) {
				error = false;
				break;
			}
		}
		if (error == true) {
			alert ("Checkbox tidak di cek, proses tidak dapat dilanjutkan");
			return;
		}
		if (document.getElementById("select_all").checked == true) {
			deleteAll();
			document.getElementById("select_all").checked = false;
		} else {
			var table = document.createElement("table");
			bufferRow(table);
			deleteAll();
			reIndex(table);
		}
	}
</script>
<script type="text/javascript">	
	var iccid1 = new Array("iccid1");
	var iccid2 = new Array("iccid2");
	var iccid3 = new Array("iccid3");
	var nama = new Array("name");
	var price = new Array("price");
	var buying = new Array("buying date");
	var x = 1;
	var y = 1;
	var z = 1;
	
	<?php foreach($itemname as $item):?>
		iccid1[x] = "<?php echo $item->iccid?>";
		nama[x] = "<?php echo $item->item_name?>";
		x++;
	<?php endforeach?>
	
	<?php foreach($buyingdate as $item):?>
		iccid2[y] = "<?php echo $item->iccid?>";
		buying[y] = "<?php echo $item->created_on?>";
		y++;
	<?php endforeach?> 
	
	var harga = 0;
	var discount = 0;
	
	<?php foreach($itemprice as $item):?>
		iccid3[z] = "<?php echo $item->iccid?>";
		harga = <?php echo $item->price?>;
		discount = <?php echo $item->discount?>;
		price[z] = harga - ((discount * harga) / 100);
		z++;
	<?php endforeach?> 
		
	function tes(index) {
		var tampil = 0;
		var x = iccid1.length;
		var tampil1 = 0;
		var y = iccid2.length;
		var tampil2 = 0;
		var z = iccid3.length;
		
		var check = document.getElementById("nomorBarang["+index+"]").value;
		
		for(var i=1; i<=x; i++){
			if(iccid1[i] == check){
				tampil = i;
				i=x+1;
			}
		}
		
		for(var i=1; i<=y; i++){
			if(iccid2[i] == check){
				tampil1 = i;
				i=y+1;
			}
		}
		
		for(var i=1; i<=z; i++){
			if(iccid3[i] == check){
				tampil2 = i;
				i=z+1;
			}
		}
		
		if(tampil1==0){
			alert("Barang Sudah Di Return atau Barang Belum Terjual");
			document.getElementById("nomorBarang["+index+"]").value = "";
		}
		else{
			document.getElementById("buying["+index+"]").value = buying[tampil1];
			document.getElementById("desc["+index+"]").value = nama[tampil];
			document.getElementById("price["+index+"]").value = price[tampil2];
		}
	}
</script>