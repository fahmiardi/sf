<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Agents</h5>
                <ul class="links">
                        <li><a href="<?php echo base_url("index.php/master/agents/agent_status_new"); ?>/new">New Registered Agent</a></li>
                        <li><a href="<?php echo base_url("index.php/master/agents/agent_status_edited"); ?>/new">Edited Agent</a></li>
                        <li><a href="<?php echo base_url("index.php/master/agents/agent_status_registered"); ?>/new">Registered Agent</a></li>
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
                                                <label for="name">Name:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="name" name="name" value="<?=$data['name']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="address">Address:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="address" name="address" value="<?=$data['address']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="ter_id">Territory Id:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="ter_id" name="teritory_id" value="<?=$data['teritory_id']?>" class="medium" />
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
        if(empty($msg))
        {
            $msg = $this->session->userdata("message");
            $this->session->unset_userdata("message");
        }
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
            <?php 
           
            $this->load->view("ext-f-agents.php");
            ?>
        </div>
</div>