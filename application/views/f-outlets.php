<div class="box">
	<!-- box / title -->
	<div class="title">
		<h5>Outlets</h5>
		<ul class="links">
			<li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>">Main Data</a></li>
			<li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>/bank">Bank Account</a></li>
			<li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>/frontliners">FrontLiners Data</a></li>
		</ul>
	</div>
	<!-- end box / title -->
	
	<?php
		$salah = validation_errors();
		if($salah <> ""){
			echo'<div id="box-messages">
				<div class="messages">
					<div id="message-error" class="message message-error">
						<div class="image">
							<img src="'. base_url() .'file/shell/smooth/resources/images/icons/error.png" alt="Error" height="32" />
						</div>
						<div class="text">
							<h6>Terdapat kesalahan dalam memasukkan data:</h6>
							<span>'. validation_errors() .'</span>
						</div>
						<div class="dismiss">
							<a href="#message-error"></a>
						</div>
					</div>
				</div>
			</div>';
		}
		
		$msg = $this->session->flashdata('message');
		if($msg <> ""){
			echo'<div id="box-messages">
				<div class="messages">
					<div id="message-success" class="message message-success">
						<div class="image">
							<img src="'. base_url() .'file/shell/smooth/resources/images/icons/success.png" alt="Success" height="32" />
						</div>
						<div class="text">
							<h6>'. $msg .'</h6>
						</div>
						<div class="dismiss">
							<a href="#message-success"></a>
						</div>
					</div>
				</div>
			</div>';
		}
			
		if($this->uri->segment(3)=="")
		{
			$this->load->view('outlets/main_data');
		}
		
		if($this->uri->segment(3)=="bank")
		{
			$this->load->view('outlets/bank');
		}
		
		if($this->uri->segment(3)=="frontliners")
		{
			$this->load->view('outlets/frontliners_data');
		}	
	?>
</div>
<script>
	$( function(){
		$( '#tabs' ).tabs();
	} );
</script>