<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Territory</h5>
                <ul class="links">
                        <li><a href="<?=base_url().'index.php/'.$this->uri->segment(1)."/".$this->uri->segment(2)?>">Territory Tree</a></li>
                        <li><a href="<?=base_url().'index.php/'.$this->uri->segment(1)."/".$this->uri->segment(2)?>/chart">Territory Chart</a></li>
                </ul>
        </div>
        <!-- end box / title -->
        
        
        <?php if($proses=="add" || $proses=="update"){?>
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
                                                <label for="parent_id">Parent:</label>
                                        </div>
                                        <div class="input">
                                                <select name="parent_id" id="parent_id">
                                                <?php
                                                $dt = $this->mservices->getValueFromTable("t_mtr_territory");
                                                foreach($dt as $row){
                                                        echo'<option value="'. $row->territory_id .'" '. ($data['parent_id'] == $row->territory_id ?"SELECTED":"") .'>'. $row->territory_name .'</option>';
                                                }
                                                ?>
                                                </select>
                                        </div>
                                </div>
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
                                                <label for="user">Maintenance By:</label>
                                        </div>
                                        <div class="input">
                                                <select name="user" id="user">
                                                <?php
                                                $dt = $this->mservices->getValueFromTable("t_mtr_user");
                                                foreach($dt as $row){
                                                        echo'<option value="'. $row->user_id .'" '. ($data['user'] == $row->user_id ?"SELECTED":"") .'>'. $row->user_name .'</option>';
                                                }
                                                ?>
                                                </select>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="territory_type">Territory Type:</label>
                                        </div>
                                        <div class="input">
                                                <select name="territory_type" id="territory_type">
                                                <?php
                                                $dt = $this->mservices->getValueFromTable("t_mtr_territory_type");
                                                foreach($dt as $row){
                                                        echo'<option value="'. $row->territory_type_id .'" '. ($data['territory_type'] == $row->territory_type_id ?"SELECTED":"") .'>'. $row->territory_type_name .'</option>';
                                                }
                                                ?>
                                                </select>
                                        </div>
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="territory_code">Territory Code:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="territory_code" name="code" value="<?=$data['name']?>" class="medium" />
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
                
                <?php
                if($jenis == "tree"){
                        $this->load->view('f-territory-tree');
                }elseif($jenis == "chart"){
                        echo'<iframe src="'.base_url().'index.php/territory/territory_iframe/chart" width=100% height=600px>';
                }
                ?>
                
                
        </div>
</div>