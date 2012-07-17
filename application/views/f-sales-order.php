<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Sales Order</h5>
                <ul class="links">
                        <li><a href="<?=base_url().'index.php/'.$this->uri->segment(1)."/".$this->uri->segment(2)?>">Create Sales Order</a></li>
                        <li><a href="<?=base_url()?>master/salesOrder">List Data</a></li>
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
                if($jenis == "create"){
                        $this->load->view('f-sales-order-create');
                }elseif($jenis == "chart"){
                        echo'<iframe src="'.base_url().'index.php/territory/territory_iframe/chart" width=100% height=600px>';
                }
                ?>
                
                
        </div>
</div>