<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>User List</h5>
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
                                                <label for="name">Name:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="user_name" name="user_name" value="<?=$data['user_name']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="distributor_add">Distributor Add:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="position" name="position" value="<?=$data['position']?>" class="medium" />
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
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Action</th>
                                </tr>
                        </thead>
                        <tbody></tbody>
                </table>
                <?=$this->load->view("grid-user-list");?>
        </div>
</div>
