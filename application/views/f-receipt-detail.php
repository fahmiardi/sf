<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">

<script type="text/javascript" src="<?= base_url() ?>file/js/easyui/jquery.easyui.min.js"></script>


<div class="box">
	
	 <!-- box / title -->
	<div class="title">
			<h5>Receipt</h5>
			<ul class="links">
					<li><a href="<?=base_url().'index.php/sales/newreceipt'?>">Create Receipt</a></li>
					<li><a href="<?=base_url().'index.php/sales'?>">List Receipt</a></li>
			</ul>
	</div>

	<div class="table">
       

		<div class="panel-wrap" style="height: auto">
			
			<div class="panel-header-div">Cluster Information</div>
			<div class="panel-body-div">
				<div class="left-panel-body">
					<h2><?=$dist[0]['territory_name']?></h2>
					<p><?=''?></p>
				
				
				</div>
				<div class="right-panel-body">
					<table class="table-right-panel" width="100%" border="solid black 1px">
						<tr align="center" class="tr-colour">
							<th width="50%" align="center">Date</th>
							<th align="center">Receipt No</th>
						</tr>
						<tr align="center" class="gray">
							<td width="50%" align="center">
								<?=date("d-m-Y", strtotime($receipt->receipt_date))?>
							</td>                    
							<td class="readonly" align="center" >
								<span style="font-size: 16pt"><b><?=$strId?></b></span>
							</td>
							
						</tr>
					</table>
				
				</div>
				
			</div>
		</div>


	
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
										<?=$receipt->sales_id?>
								</td>                   
								
								<td width="50%" align="center">
									<?=$sales_name[0]['user_name']?>
								</td>
								
							</tr>
						</table>
					</div>
				</div>
			

				<div class="child-panel-body">	
					<table id="table-updateable" class="table-right-panel" width="92%" style="margin-left: 19px;">
						<thead>
							<tr align="center" class="tr-colour3">
								<th>ICCID</th>
								<th>Item Code</th>
								<th>Item Group</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						<?php
						
							for($ii=0; $ii<count($receipt_detail); $ii++)
							{
								echo "<tr align='center' class='wide'>";
								echo "<td>" . $receipt_detail[$ii]['iccid'] . "</td>" ;
								echo "<td>" . $itemDetail[$ii][0]['item_code'] . "</td>" ;
								echo "<td>" . $itemDetail[$ii][0]['item_group_name'] . "</td>" ;
								echo "<td>" . $itemDetail[$ii][0]['item_name'] . "</td>" ;
								echo "</tr>";
							}
						?>
						</tbody>
						
					</table>
						
					<div class="summary"> 
					</div>
					
					
				
				</div>
			
			
				<div class="child-panel-body-2">	
					<table class="table-right-panel" style="margin-left: 19px; border: none; ">		
						<tr style="height: 15px;">
							<td style="text-align: left; font-weight: bold; font-size: 1.3em;">Remark:</td>
							<td ><?= '&nbsp;'.$receipt->remark?></td>
						</tr>
						
					</table>
				
				</div>
			
				<div class="child-panel-body-2">
				
					<div class="buttons-2" style="margin: 0 auto">
						<input type="button" value="Back" onclick="location.href='<?=base_url().'index.php/sales'?>'" />
					</div>
				</div>
				
			</div>
		</div>

	</div>
</div>