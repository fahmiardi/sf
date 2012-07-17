<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Handset</h5>
                <ul class="links">
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)."/".$this->uri->segment(2)?>/new">New Handset</a></li>
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)."/".$this->uri->segment(2)?>">List Data</a></li>
                </ul>
        </div>
        <!-- end box / title -->
        
        <?php if($this->uri->segment(3)=="new" || $this->uri->segment(3)=="update"){?>
        <?php
        #### tampilkan alert jika terdapat kesalahan dalam memasukkan data
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
        ?>
        
                <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="model">Model:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="model" name="model" value="<?=$data['model']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="man">Man:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="man" name="man" value="<?=$data['man']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="sales">Sales:</label>
                                        </div>
					<div class="input">
						<span id="sales"><?=$data['sales']?></span>&nbsp;[&nbsp;<a href="index.php/master/userList" target="selectUser">Select User</a>&nbsp;]
                                                <input type="hidden" id="salesId" name="salesId" value="<?=$data['salesId']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="">IMEI:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="imei" name="imei" value="<?=$data['imei']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="">IMSI:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="imsi" name="imsi" value="<?=$data['imsi']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="">MSISDN:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="msisdn" name="msisdn" value="<?=$data['msisdn']?>" class="medium" />
                                        </div>
				</div>
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Submit" />
                                        <input type="reset" name="reset" value="Reset" />
                                </div>
                        </div>
                </div>
                </form><br><br>&nbsp;
        <?php } ?>
        
        <?php
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
        ?>
        <div class="table">
                <base href="<?php echo base_url() ?>" />
                <div id="ajaxLoadAni">
                        <img src="file/smooth/images/ajax-loader.gif" alt="Ajax Loading Animation" />
                        <span>Loading...</span>
                </div>
                <table id="records">
                        <thead>
                                <tr>
                                        <th>No</th>
                                        <th>Model</th>
					<th>Man</th>
					<th>Sales</th>
					<th>IMEI</th>
					<th>IMSI</th>
					<th>MSISDN</th>
                                        <th>Actions</th>    
                                </tr>
                        </thead>
                        <tbody></tbody>
                </table>
                <?=$this->load->view("grid-handset");?>
        </div>
</div>
