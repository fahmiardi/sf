<form id="form" action="<?=$_SERVER[ 'PHP_SELF' ]?>" method="post">
	<div style="font-size:12px; width:98%" id="tabs">
		<ul>
			<li><a href="#tabs-1">Territory Information</a></li>
			<li><a href="#tabs-2">Outlet Data</a></li>
			<li><a href="#tabs-3">Owner Data</a></li>
		</ul>
		<div id="tabs-1">
			<table width="100%">
				<tr>
					<td>
					<?php 
						$this->load->view( 'outlets/territory_information' );
					?>
					</td>
				</tr>
			</table>
		</div>
		<div id="tabs-2">
			<table width="100%">
				<tr>
					<td>
					<?php 
						$this->load->view( 'outlets/outlet_data' );
					?>
					</td>
				</tr>
			</table>
		</div>
		<div id="tabs-3">
			<table width="100%">
				<tr>
					<td>
					<?php 
						$this->load->view( 'outlets/owner_data' );
					?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>