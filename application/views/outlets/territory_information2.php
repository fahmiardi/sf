<form id="form" action="<?=$_SERVER[ 'PHP_SELF' ]?>" method="post">
				<div class="box-left">
					<div class="form">
						<div class="fields">
							<div class="label">
								<label id="title">Territory Information</label>
							</div><br/><br/>
							<div class="field">
								<div class="label">
									<label for="region">Territory Parent Path:</label>
								</div>
								<div class="input">
									<input type="text" id="path" name="path" readonly="readonly" class="small" value="<?=$data[ 'path' ]?>" />
                                </div>
							</div>
							<div class="field">
								<div class="label">
									<label for="building">Building:</label>
								</div>
								<div class="select">
									<select id="building" name="building">
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
								</div>
							</div>
							<div class="label">
								<label id="title">Branding Information</label>
							</div><br/><br/>
							<div class="field">
								<div class="label">
									<label>Status Brading Smart:</label>
								</div>
								<div class="radios">
									<div class="radio">
										<input type="radio" value="N/A"/>N/A
									</div>
									<div class="radio">
										<input type="radio" value="Full"/>Full
									</div>
									<div class="radio">
										<input type="radio" value="Partial"/>Partial
									</div>
								</div>
							</div>
							<div class="field">
								<div class="label">
									<label for="branding">Full Branding by:</label>
								</div>
								<div class="select">
									<select id="branding" name="branding">
										<?php 
											foreach( $data[ 'full_branding' ][ 'member_display' ] as $d )
											{
												echo '<option value="'.$d.'">'.$d.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="field">
								<div class="label">
									<label>Contract End:</label>
								</div>
								<div class="input">
									<input type="text" id="datepicker" class="small" />
								</div>
							</div>
							<div class="field">
								<div class="label">
									<label>Value:</label>
								</div>
								<div class="input">
									<input type="text" id="value" class="small" />
								</div>
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
								<div class="label">
									<label for="name">Name:</label>
								</div>
								<div class="select">
									<select id="maintain_name" name="name" onchange="getPosition()">
										<?php 
											$i = 0;
											foreach( $data[ 'username' ] as $d )
											{
												$i++;
												echo '<option value="'.$d.'">'.$d.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="field">
								<div class="label">
									<label for="position">Position:</label>
								</div>
								<div class="input">
									<input type="text" id="position" readonly="readonly" />
								</div>
							</div>
							<div class="field">
								<div class="label">
									<label id="title">Outbond Caller</label>
								</div>
							</div>
							<div class="field">
								<div class="label">
									<label for="name">Name:</label>
								</div>
								<div class="select">
										<select id="branding" name="branding">
											<?php 
												foreach( $data[ 'outbond' ][ 'member_display' ] as $d )
												{
													echo '<option value="'.$d.'">'.$d.'</option>';
												}
											?>
										</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			
<script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	
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