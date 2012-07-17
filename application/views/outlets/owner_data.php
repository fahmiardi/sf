<script>
	$(function() {
		$( "#datepick" ).datepick({yearRange: '1950:2050'});
	});
</script>
	<div class="form">
		<div class="fields">
			<div class="label">
				<label id="title">Owner</label>
			</div><br/><br/>
			<div class="field">
				<div class="label">
					<label for="name_owner">Name:</label>
				</div>
				<div class="input">
					<input type="text" name="name_owner" class="small" />
				</div>
			</div>	
			<div class="field">
				<div class="label">
					<label for="gender">Gender:</label>
				</div>
				<div class="select">
					<select class="select_in" id="gender" name="gender">
						<?php 
							$i = 1;
							foreach( $data[ 'gender' ][ 'member_value' ] as $d )
							{
								echo '<option value='.$i.'>'.$d.'</option>';
								$i++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="field">
				<div class="label">
					<label for="birth_owner">Birth Place / Date:</label>
				</div>
				<div class="input">
					<input type="text"  name="birth_place" class="small" />
				</div>
				<div >
					<label style="font-size:23px;margin: 0 0 0 10px;" for="slash"> / </label>
				</div>
				<div class="input">
					<input style="margin: -22px 0 0 30px" type="text" id='datepick' name="birth_date" class="small" />
				</div>
				<!--<div class="input">
					<input type="image" src="../../../file/shell/smooth/resources/images/ui/calendar.png" alt="calendar.png"/>
				</div>-->
			</div>	
			<div class="field">
				<div class="label">
					<label for="religion">Religion:</label>
				</div>
				<div class="select">
					<select class="select_in" id="district" name="religion">
						<?php 
							$i = 1;
							foreach( $data[ 'religion' ][ 'member_value' ] as $d )
							{
								echo '<option value='.$i.'>'.$d.'</option>';
								$i++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="field">
				<div class="label">
					<label for="email">Email:</label>
				</div>
				<div class="input">
					<input type="text" name="email" class="small" />
				</div>
			</div>	
			<div class="field">
				<div class="label">
					<label for="phone">Phone:</label>
				</div>
				<div class="input">
					<input type="text" name="phone" class="small" />
				</div>
			</div>	
			
			<div class="field">
				<div class="label">
					<label for="identity_type">Identity Type:</label>
				</div>
				<div class="select">
					<select class="select_in" id="building" name="identity_type">
						<?php 
							$i = 0;
							foreach( $data[ 'identity' ][ 'member_display' ] as $d )
							{
								echo '<option value='.$i.'>'.$d.'</option>';
								$i++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="field">
				<div class="label">
					<label for="identity_number">Identity Number:</label>
				</div>
				<div class="input">
					<input type="text" name="identity_number" class="small" />
				</div>
			</div>	
			<div class="field">
				<div style="margin: 0 10px 0 35px" class="button">
					<input type="submit" value="Submit" />
				</div>
				
				<div class="button">
					<input type="reset" value="Reset" />
				</div>
			</div>
		</div>
	</div>