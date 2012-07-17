<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/icon.css">
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery.easyui.min.js"></script>

<table id="test" width=100% title="Territory Tree" class="easyui-treegrid" style="height:600px"
		url="<?=base_url()?>index.php/territory/territory_json"
		rownumbers="true"
		idField="id" treeField="name">
	<thead>
		<tr>
			<th field="name" width="550">Territory</th>
			<th field="size" width="250">Maintained By</th>
			<th field="date" width="140">Process</th>
		</tr>
	</thead>
</table>