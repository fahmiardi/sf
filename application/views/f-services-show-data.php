<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Show Service <?=$tabel?></h5>
                <ul class="links">
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)."/".$this->uri->segment(2)."/".$tabel?>/new">New Data</a></li>
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)."/".$this->uri->segment(2)."/".$tabel?>">List Data</a></li>
                </ul>
                
        </div>
        <!-- end box / title -->
        <?php if($this->uri->segment(4)=="new"){?>
                <form id="form" action="" method="post">
                <div class="form">
                        <div class="fields">
                                
                                <?php
                                foreach($getComponent as $r){
                                        
                                        echo'<div class="field">
                                                <div class="label">
                                                        <label for="name">'. $r->t_elm_label .':</label>
                                                </div>
                                                <div class="input">';
                                                        
                                                        
                                                        if($r->t_elm_type == "text"){
                                                                echo'<input type="text" value="" name="'. $r->t_services_column .'" style="width:400px">';
                                                        }elseif($r->t_elm_type == "textarea"){
                                                                echo'<textarea value="" name="'. $r->t_services_column .'" rows=4 cols=200 style="width:400px"></textarea>';
                                                        }elseif($r->t_elm_type == "date"){
                                                                echo'<input type="text" value="" id="date" class="date" name="'. $r->t_services_column .'">';
                                                        }elseif($r->t_elm_type == "dropdown"){
                                                                echo'<select name="'. $r->t_services_column .'">';
                                                                if($r->t_source_name <> ""){
                                                                        $data = $this->mservices->getValueFromTable($r->t_source_name);
                                                                        foreach($data as $row){
                                                                                echo'<option value="'. $row->{$r->t_source_column_value} .'">'. $row->{$r->t_source_column_display} .'</option>';
                                                                        }
                                                                }else{
                                                                        
                                                                }
                                                                echo'</select>';
                                                        }elseif($r->t_elm_type == "radio"){
                                                                if($r->t_source_name <> ""){
                                                                        $i=1;
                                                                        $data = $this->mservices->getValueFromTable($r->t_source_name);
                                                                        foreach($data as $row){
                                                                                echo'<div class="radio">
                                                                                        <input type="radio" id="radio-'. $i .'" name="'. $r->t_services_column .'" value="'. $row->{$r->t_source_column_value} .'"/>
                                                                                        <label for="radio-'. $i .'">'. $row->{$r->t_source_column_display} .'</label>
                                                                                </div>';
                                                                                $i++;
                                                                        }
                                                                }else{
                                                                        
                                                                }
                                                        }elseif($r->t_elm_type == "checkbox"){
                                                                if($r->t_source_name <> ""){
                                                                        $i=1;
                                                                        $data = $this->mservices->getValueFromTable($r->t_source_name);
                                                                        foreach($data as $row){
                                                                                echo'<div class="checkbox">
                                                                                        <input type="checkbox" id="checkbox-'. $i .'" name="'. $r->t_services_column .'" value="'. $row->{$r->t_source_column_value} .'"/> &nbsp; 
                                                                                        <label for="checkbox-'. $i .'">'. $row->{$r->t_source_column_display} .'</label>
                                                                                </div><br>';
                                                                                $i++;
                                                                        }
                                                                }else{
                                                                        
                                                                }
                                                        }elseif($r->t_elm_type == "photo"){
                                                                echo'<input type="file" value="" name="'. $r->t_services_column .'">';
                                                        }elseif($r->t_elm_type == "gps"){
                                                                echo'<input type="text" value="" name="'. $r->t_services_column .'" disabled="disabled" style="width:400px">';
                                                        }elseif($r->t_elm_type == "barcode"){
                                                                echo'<input type="text" value="" name="'. $r->t_services_column .'" disabled="disabled" style="width:400px">';
                                                        }
                                                        
                                                        
                                                echo'</div>
                                        </div>';
                                }
                        ?>
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Submit" />
                                        <input type="reset" name="reset" value="Reset" />
                                </div>
                        </div>
                </div>
                </form><br><br>&nbsp;
        <?php } ?>
        
        <div class="table">
               
                <base href="<?php echo base_url() ?>" />

                <!--<link type="text/css" rel="stylesheet" href="css/demo_table.css" />-->
                <div id="ajaxLoadAni">
                    <img src="file/smooth/images/ajax-loader.gif" alt="Ajax Loading Animation" />
                    <span>Loading...</span>
                </div>
                
                        <table id="records">
                            <thead>
                                <tr>
                                        <th>No</th>
                                <?php
                                
                                        foreach($getComponent as $r){
                                                echo'<th>'. $r->t_elm_label .'</th>';
                                        }
                                ?>
                                        <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                
                <?=$this->load->view("grid-services-show-data");?>
                
        </div>
        
</div>
