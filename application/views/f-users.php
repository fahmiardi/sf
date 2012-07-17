<div class="box" style="min-height:900px;">
        <!-- box / title -->
        <div class="title">
                <h5>Users Management</h5>
                <ul class="links">
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>/index/add">New User</a></li>
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>">List Data</a></li>
                </ul>
        </div>
        <!-- end box / title -->
        
        <?php if($this->uri->segment(3)=="add" || $this->uri->segment(3)=="update"){?>
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
                        <?php   if($proses == "add"){   ?>
                        
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
                                                <label for="username">Username:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="username" name="username" value="<?=$data['username']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="nik">NIK:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="nik" name="nik" value="<?=$data['nik']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="usergroup">User Group:</label>
                                        </div>
                                        <div class="input">
                                                <?php
                                                $getUserGroup	= $this->muserrole->getUserGroup();
                                                echo'<select name="usergroup">';
                                                foreach($getUserGroup as $r){
                                                        $SELECTED = $r->user_group_id==$data['usergroup']?"SELECTED":"";
                                                        echo'<option value="'. $r->user_group_id .'" '. $SELECTED .'>'. $r->user_group_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="reportingto">Reporting To:</label>
                                        </div>
                                        <div class="input">
                                                <?php
                                                $getUser	= $this->musers->getUser();
                                                echo'<select name="reportingto" id="reportingto">';
                                                foreach($getUser as $r){
                                                        $SELECTED = $r->user_id==$data['reportingto']?"SELECTED":"";
                                                        echo'<option value="'. $r->user_id .'" '. $SELECTED .'>'. $r->user_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="hape">Mobile Number:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="hape" name="hape" value="<?=$data['hape']?>" class="medium" />
                                        </div>
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="email">E-Mail:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="email" name="email" value="<?=$data['email']?>" class="medium" />
                                        </div>
                                </div>
                        
                        
                        <?php }elseif($proses == "update"){ ?>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Name:</label>
                                        </div>
                                        <div class="input">
                                                <label><b><?=$data['name']?></b></label>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="username">Username:</label>
                                        </div>
                                        <div class="input">
                                                <label><b><?=$data['username']?></b></label>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="nik">NIK:</label>
                                        </div>
                                        <div class="input">
                                                <label><b><?=$data['nik']?></b></label>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="usergroup">User Group:</label>
                                        </div>
                                        <div class="input">
                                                <?php
                                                $getUserGroup	= $this->muserrole->getUserGroup();
                                                echo'<select name="usergroup">';
                                                foreach($getUserGroup as $r){
                                                        $SELECTED = $r->user_group_id==$data['usergroup']?"SELECTED":"";
                                                        echo'<option value="'. $r->user_group_id .'" '. $SELECTED .'>'. $r->user_group_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="reportingto">Reporting To:</label>
                                        </div>
                                        <div class="input">
                                                <?php
                                                $getUser	= $this->musers->getUser();
                                                echo'<select name="reportingto" id="reportingto">';
                                                foreach($getUser as $r){
                                                        $SELECTED = $r->user_id==$data['reportingto']?"SELECTED":"";
                                                        echo'<option value="'. $r->user_id .'" '. $SELECTED .'>'. $r->user_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="hape">Mobile Number:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="hape" name="hape" value="<?=$data['hape']?>" class="medium" />
                                        </div>
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="email">E-Mail:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="email" name="email" value="<?=$data['email']?>" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="password">Password:</label>
                                        </div>
                                        <div class="input">
                                                <input type="password" id="password" name="password" class="medium" /><br>
                                                * Password is not required. If password is not empty, password will change.
                                        </div>
                                </div>
                        
                        <?php } ?>
                                
                                
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
                <link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/gray/easyui.css">
                <link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/icon.css">
                <script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
                <script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery.easyui.min.js"></script>
                
                <table id="test" width=100% title="User Management" class="easyui-treegrid" style="height:600px"
                                url="<?=base_url()?>index.php/user_management/user_json"
                                rownumbers="true" animate="true"
                                idField="size" treeField="name">
                        <thead>
                                <tr>
                                        <th field="name" width="250">Name</th>
                                        <th field="size" width="90">Username</th>
                                        <th field="nik" width="90">NIK</th>
                                        <th field="emails" width="120">Email</th>
                                        <th field="hapes" width="90">Mobile Phone</th>
                                        <th field="date" width="140">Process</th>
                                </tr>
                        </thead>
                </table>


        </div>
</div>