<div class="box" style="min-height:900px;">
        <!-- box / title -->
        <div class="title">
                <h5>Change Password</h5>
        </div>
        <!-- end box / title -->
        
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
                <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                        
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Name:</label>
                                        </div>
                                        <div class="input">
                                                <b><?=$this->mglobal->showdata("user_name","t_mtr_user",array("user_id"=>$this->session->userdata('username')),"dblokal")?></b>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="username">Username:</label>
                                        </div>
                                        <div class="input">
                                                <b><?=$this->session->userdata('username')?></b>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="old-password">Old Password:</label>
                                        </div>
                                        <div class="input">
                                                <input type="password" id="old-password" name="old-password"  class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="new-password">New Password:</label>
                                        </div>
                                        <div class="input">
                                                <input type="password" id="new-password" name="new-password"  class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="re-new-password">Retype New Password:</label>
                                        </div>
                                        <div class="input">
                                                <input type="password" id="re-new-password" name="re-new-password"  class="medium" />
                                        </div>
                                </div>
                                
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Submit" />
                                        <input type="reset" name="reset" value="Reset" />
                                </div>
                        </div>
                </div>
                </form><br><br>&nbsp;
        
        
</div>