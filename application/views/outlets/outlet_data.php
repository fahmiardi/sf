	<div class="box-left">
		<div class="form">
			<div class="fields">
				<div class="label">
					<label id="title">Outlet Data</label>
				</div><br/><br/>
				<div class="field">
					<table width="90%">
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="form">Outlet ID:</label>
							</div>
						</td>
						<td>
							<div class="input" style="background-color:LightGray">
								<input type="text" value="<?='CJC0'.$this->load->mmaster->generateID()?>" name="outlet_id" readonly="readonly" style="background-color:LightGray"  class="small" />
							</div>
						</td>
					</tr>
					<tr>	
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="area">Outlet Name:</label>
							</div>
						</td>
						<td>
							<div class="input">
								<input type="text" name="outlet_name" class="small" />
							</div>
						</td>
					</tr>
					<tr>	
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="district">Active Status:</label>
							</div>
						</td>
						<td>
							<div class="label">
								<input type="checkbox" name="active_status" checked="checked" value="1"/>Is Active
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div style="margin: -35px 0 0 0" class="label">
								<label for="building">Address:</label>
							</div>
						</td>
						<td>
							<div class="textarea">
								<textarea style="resize: none;" rows="3" name="address" cols="40"></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="area">City:</label>
							</div>
						</td>
						<td>
							<div class="input">
								<input type="text" name="city" class="small" />
							</div>
						</td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="area">Province:</label>
							</div>
						</td>
						<td class="select">
							<select class="select_in" id="name" name="province">
								<?php 
									sort( $data[ 'province' ] );
									foreach( $data[ 'province' ] as $d )
									{
										echo '<option value="'.$d.'">'.$d.'</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="area">Post Code:</label>
							</div>
						</td>
						<td>
							<div class="input">
								<input type="text" name="post_code" class="small" />
							</div>
						</td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="area">Outlet Phone:</label>
						</td>
						<td>
							<div class="input">
								<input type="text" name="outlet_phone" class="small" />
							</div>
						</td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="region">Business Structure:</label>
							</div>
						</td>
						<td class="select">
							<select class="select_in" id="region" name="b_structure">
								<?php 
									foreach( $data[ 'b_structure' ][ 'member_display' ] as $d )
									{
										echo '<option value="'.$d.'">'.$d.'</option>';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" style="height:15px">
								<input type="checkbox" name="smart_etopup" id="smart_check" value="1" onchange="getValue()" />Smart E-Topup
							</div>
						</td>
						<td><div style="height:15px"></div></td>
					</tr>
					<tr>
						<td valign="middle">
							<div style="margin: -35px 0 0 0" class="label">
								<label for="area">Smart Topup No:</label>
							</div>
						</td>
						<td>
							<div class="input" id="smart_div" style="background-color:LightGray">
								<input type="text" id="smart_text" name="smart_topup_no" style="background-color:LightGray" readonly="readonly" class="small" />
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
					<label id="title">Additional Information</label>
				</div><br/><br/>
				<div class="field">
					<table width="90%">
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="position">Outlet Status:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="position" name="outlet_status">
									<?php 
										foreach( $data[ 'o_status' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
											$i++;
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div  style="margin: -35px 0 0 0" class="label">
									<label for="name">Outlet Type:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="outlet_type">
									<?php 
										foreach( $data[ 'o_type' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
											$i++;
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div  style="margin: -35px 0 0 0" class="label">
									<label style="margin: -35px 0 0 0" for="name">Outlet Size:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="outlet_size">
									<?php 
										foreach( $data[ 'o_size' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Outlet Location:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="outlet_location">
									<?php 
										foreach( $data[ 'o_location' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="area">Employee Number:</label>
								</div>
							</td>
							<td>
								<div class="input">
									<input type="text" name="employee_num" class="small" />
								</div>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="area">Outlet Lifetime:</label>
								</div>
							</td>
							<td>
								<div class="input">
									<input type="text" name="outlet_lifetime" class="small" />
								</div>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Outlet Ownership:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="outlet_ownership">
									<?php 
										foreach( $data[ 'o_ownership' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="area">Smart No:</label>
								</div>
							</td>
							<td>
								<div class="input">
									<input type="text" name="smart_no" class="small" />
								</div>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Business Focus:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="b_focus">
									<?php 
										foreach( $data[ 'b_focus' ][ 'member_display' ] as $d )
										{
												echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Customer Type:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="c_type">							
									<?php 
										foreach( $data[ 'c_type' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Size of Business:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="name" name="sob">
									<?php 
										foreach( $data[ 'b_size' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div class="label">
									<label for="name">Is Expansion:</label>
								</div>
							</td>
							<td class="input">
								<div class="label">
									<input type="checkbox" id="is_expansion" name="is_expansion" value="1" onchange="isExpansionChange()"/>
								</div>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Expansion Package:</label>
								</div>
							</td>
							<td class="select">
								<select class="select_in" id="expansion_pack" name="expansion_pack" disabled="disabled">
									<?php 
										foreach( $data[ 'e_package' ][ 'member_display' ] as $d )
										{
											echo '<option value="'.$d.'">'.$d.'</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div class="label">
									<label for="name">Join Lajang:</label>
								</div>
							</td>
							<td class="input">
								<div class="label">
									<input type="checkbox" id="join_lajang" name="join_lajang" value="1" onchange="joinLajangChange()"/>
								</div>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div class="label">
									<label for="name">Lajang Is Reorder:</label>
								</div>
							</td>
							<td class="input">
								<div class="label">
									<input type="checkbox" id="is_reorder" name="is_reorder" value="1" disabled="disabled" onchange="isReorderChange()"/>
								</div>
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<div style="margin: -35px 0 0 0" class="label">
									<label for="name">Lajang Package:</label>
								</div>
							</td>
							<td class="select">
								<select disabled="disabled" class="select_in" id="lajang_pack" name="lajang_pack">
									<?php 
										foreach( $data[ 'l_package' ][ 'member_display' ] as $d )
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
	function getValue()
	{
		var etopup = document.getElementById( 'smart_check' ).checked;
		var smart_text = document.getElementById( 'smart_text' );
		var smart_div = document.getElementById( 'smart_div' );
		
		if( etopup == true )
		{
			smart_text.removeAttribute( "readonly", 0 );
			smart_text.removeAttribute( "style", 0 );
			smart_div.removeAttribute( "style", 0 );
		}
		else
		{
			smart_text.setAttribute( "readonly", "readonly" );
			smart_text.setAttribute( "style", "background-color:LightGray" );
			smart_div.setAttribute( "style", "background-color:LightGray" );
		}	
	}
	
	function isExpansionChange()
	{
		var is_expansion = document.getElementById( 'is_expansion' ).checked;
		var expansion_pack = document.getElementById( 'expansion_pack' );
		
		if( is_expansion == true )
			expansion_pack.removeAttribute( "disabled", 0 );
		else
			expansion_pack.setAttribute( "disabled", "disabled" );
	}
	
	function joinLajangChange()
	{
		var join_lajang = document.getElementById( 'join_lajang' ).checked;
		var is_reorder = document.getElementById( 'is_reorder' );
		
		if( join_lajang == true )
			is_reorder.removeAttribute( "disabled", 0 );
		else
			is_reorder.setAttribute( "disabled", "disabled" );
	}
	
	function isReorderChange()
	{
		var is_reorder = document.getElementById( 'is_reorder' ).checked;
		var lajang_pack = document.getElementById( 'lajang_pack' );
		
		if( is_reorder == true )
			lajang_pack.removeAttribute( "disabled", 0 );
		else
			lajang_pack.setAttribute( "disabled", "disabled" );
	}
</script>