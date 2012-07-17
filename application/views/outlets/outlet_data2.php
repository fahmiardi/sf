<form id="form" action="<?=$_SERVER[ 'PHP_SELF' ]?>" method="post">
	<div class="box-left">
		<div class="form">
			<div class="fields">
				<div class="label">
					<label id="title">Outlet Data</label>
				</div><br/><br/>
				<div class="field">
					<div class="label">
						<label for="form">Outlet ID:</label>
					</div>
					<div class="input">
						<input type="text" readonly="readonly" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Outlet Name:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="district">Active Status:</label>
					</div>
					<div class="input">
						<input type="checkbox" value="Is Active" />Is Active
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="building">Address:</label>
					</div>
					<div class="input">
						<textarea rows="20" cols="20" ></textarea>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">City:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Province:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Post Code:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Outlet Phone:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="region">Bussiness Structure:</label>
					</div>
					<div class="select">
						<select id="region" name="region">
							<?php 
								foreach( $data[ 'b_structure' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="input">
						<input type="checkbox" value="Is Active" />Smart E-Topup
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Smart Topup No:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
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
					<div class="label">
						<label for="position">Outlet Status:</label>
					</div>
					<div class="select">
						<select id="position" name="position">
							<?php 
								foreach( $data[ 'o_status' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
									$i++;
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Outlet Type:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'o_type' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
									$i++;
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Outlet Size:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'o_size' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Outlet Location:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'o_location' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Employee Number:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Outlet Lifetime:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Outlet Ownership:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'o_ownership' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="area">Smart No:</label>
					</div>
					<div class="input">
						<input type="text" class="small" />
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Business Focus:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'b_focus' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Customer Type:</label>
					</div>
					<div class="select">
						<select id="name" name="name">							
							<?php 
								foreach( $data[ 'c_type' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Size of Business:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'b_size' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Is Expansion:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<option value="1">Not Maintained</option>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Expansion Package:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'e_package' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Join Lajang:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<option value="1">Not Maintained</option>
						</select>
					</div>
				</div>
				<div class="field">
					<div class="label">
						<label for="name">Lajang Package:</label>
					</div>
					<div class="select">
						<select id="name" name="name">
							<?php 
								foreach( $data[ 'l_package' ][ 'member_display' ] as $d )
								{
									echo '<option>'.$d.'</option>';
								}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>