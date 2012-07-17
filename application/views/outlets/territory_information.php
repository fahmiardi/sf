<script>
	$(function() {
		$( "#datepicker" ).datepick({yearRange: '1950:2050'});
	});
</script>
<div class="box-left">
	<div class="form">
		<div class="fields">
			<div class="label">
				<label id="title">Territory Information</label>
			</div><br/><br/>
			<div class="field">
				<table width="90%">
				<tr>
					<td valign="middle">
						<div style="margin: -35px 0 0 0" class="label">
							<label for="region">Territory Parent Path:</label>
						</div>
					</td>
					<td width="65%">
						<div class="input" style="background-color:LightGray">
							<input type="text" id="path" 
								style="background-color:LightGray"
								name="path" readonly="readonly" 
								class="small" value="<?=$data[ 'path' ]?>" />
							<input type="hidden" name="hidden_territory_id" value="<?=$data[ 'territory_id' ]?>" />
						</div>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						<div class="label">
							<label for="building">Building:</label>
						</div>
					</td>
					<td class="select" >
						<select class="select_in" id="building" name="building">
							<?php 
								foreach( $data[ 'building' ][ 'member_display' ] as $d )
								{
									if( $d == 'Bangunan Non Permanen' )
										echo '<option value="Non Permanen">'.$d.'</option>';
									else
										echo '<option value="Permanen">'.$d.'</option>';
								}
							?>
						</select>
					</td>
				</tr>
			</table><br/><br/><br/>
			</div>
			<div class="label">
				<label id="title">Branding Information</label>
			</div><br/><br/>
			<div class="field">
				<table width="90%">
				<tr>
					<td width="34%">
						<div class="label">
							<label>Status Brading Smart:</label>
						</div>
					</td>
					<td width="10%">
							<div class="radio">
								<input type="radio" name="status_branding" value="N/A"/>N/A
							</div>
					</td>
					<td width="10%">
						<div class="radio">
								<input type="radio" name="status_branding" value="Full"/>Full
							</div>
					</td>
					<td width="42%">
						<div class="radio">
								<input type="radio" name="status_branding" value="Partial"/>Partial
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div style="margin: -35px 0 0 0" class="label">
							<label for="branding">Full Branding by:</label>
						</div>
					</td>
					<td colspan="3" width="80%" class="select">
						<select class="select_in" id="branding" name="full_branding">
							<?php 
								foreach( $data[ 'full_branding' ][ 'member_display' ] as $d )
								{
									echo '<option value="'.$d.'">'.$d.'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<div style="margin: -35px 0 0 0" class="label">
							<label for="contract_end">Contract End:</label>
						</div>
					</td>
					<td colspan="3" width="80%">
						<div class="input">
							<input type="text" name="contract_end" id="datepicker" class="small" />
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="label">
							<label>Value:</label>
						</div>
					</td>
					<td colspan="3" width="80%">
						<div class="input">
							<input type="text" name="branding_value" class="small" />
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</div>
</div>
<div class="box-right">
	<div class="form">
		<div class="fields">
			<div class="label">
				<label id="title">Maintained By</label>
			</div><br/><br/>
			<div class="field">
				<table width="80%">
					<tr>
						<td>
							<div style="margin: -35px 0 0 0" class="label">
								<label for="name">Name:</label>
							</div>
						</td>
						<td width="80%" class="select">
							<select class="select_in" id="maintain_name" name="maintain_name" onchange="getPosition()">
								<?php 
									$i = 0;
									foreach( $data[ 'username' ] as $d )
									{
										$i++;
										echo '<option value="'.$d.'">'.$d.'</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<div class="label">
								<label for="position">Position:</label>
							</div>
						</td>
						<td>
							<div class="input" style="background-color:LightGray">
								<input type="text" id="position" 
								readonly="readonly" style="background-color:LightGray"/>
							</div>
						</td>
				</table>
			<br/><br/><br/>
			</div>
			<div class="field">
				<div class="label">
					<label id="title">Outbond Caller</label>
				</div>
			</div>
			<div class="field">
				<table width="80%">
				<tr>
					<td>
						<div class="label">
							<label for="name">Name:</label>
						</div>
					</td>
					<td width="80%" class="select">
						<select class="select_in" id="branding" name="outbond_caller">
							<?php 
								foreach( $data[ 'outbond' ][ 'member_display' ] as $d )
								{
									echo '<option value="'.$d.'">'.$d.'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
    function getPosition(){			
		//alert( "abc" );
		var str = "";
		var username_list = ["<?php echo join("\", \"", $data[ 'username' ]); ?>"];
		var position_list = ["<?php echo join("\", \"", $data[ 'pos' ]); ?>"];
		
		var maintain_name = document.getElementById("maintain_name").value;
		
			
		for( var i = 0 ; i < username_list.length ; i++ )
		{		
			//alert(  username_list[ i ] );	
			if( username_list[ i ] == maintain_name )
			{
				index = i;
				break;
			}
		}
		
		document.getElementById( 'position' ).value = position_list[ index ];
    }
</script>