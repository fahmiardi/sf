
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">

<div id="popUpItem" onclick="closeItem()"></div>
<div id="darkBack" onclick="closeBack()"></div>
<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Gallery Management</h5>
                <ul class="links">
                        <li><a href="<?= base_url() . $this->uri->segment(1) .
"/" . $this->uri->segment(2) ?>/new">New Gallery</a></li>
                        <li><a href="<?= base_url() . $this->uri->segment(1) .
    "/" . $this->uri->segment(2) ?>">List Data</a></li>
                </ul>
                
        </div>
        <!-- end box / title -->
        <?php if ($this->uri->segment(3) == "new") { ?>
                <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Gallery Name:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="name" name="gallery_name" class="medium" />
                                        </div>
                                        
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Gallery Address:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="name" name="gallery_address" class="medium" />
                                        </div>
                                        
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Gallery's Cluster:</label>
                                        </div>
                                        <div class="input">
                                                <select name="territory_id" style="width: 57%;">
                                                    <?php foreach($cluster as $item):?>
                                                        <option value="<?php echo $item->territory_id?>"><?php echo $item->territory_name?></option>
                                                    <?php endforeach?>
                                                </select>
                                        </div>
                                        
                                </div>
                                
                                
                                
                                
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Submit" />
                                        <input type="reset" name="reset" value="Reset" />
                                        <div class="highlight">
                                                <input type="submit" name="submit.highlight" value="Submit Empathized" />
                                        </div>
                                </div>
                        </div>
                </div>
                </form><br><br>&nbsp;
        <?php } ?>
        
        <?php if ($this->uri->segment(3) == "update") { ?>
                <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Gallery Name:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="name" name="gallery_name" class="medium" />
                                        </div>
                                        
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Gallery Address:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="name" name="gallery_address" class="medium" />
                                        </div>
                                        
                                </div>
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Gallery's Cluster:</label>
                                        </div>
                                        <div class="input">
                                                <select name="territory_id" style="width: 57%;">
                                                    <?php foreach($cluster as $item):?>
                                                        <option value="<?php echo $item->territory_id?>"><?php echo $item->territory_name?></option>
                                                    <?php endforeach?>
                                                </select>
                                        </div>
                                        
                                </div>
                                
                                
                                
                                
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Submit" />
                                        <input type="reset" name="reset" value="Reset" />
                                        <div class="highlight">
                                                <input type="submit" name="submit.highlight" value="Submit Empathized" />
                                        </div>
                                </div>
                        </div>
                </div>
                </form><br><br>&nbsp;
        <?php } ?>
        
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
                                        <th>Gallery ID</th>
                                        <th>Gallery Name</th>
                                        <th>Gallery Address</th>
                                        <th>Gallery Image</th>                                                                                
                                        <th>Actions</th>
                                        
                                        <script>
                                             /**
 *  <td width="30px">${so_id}</td>
 *                 <td>${territory_id}</td>
 *                 <td>${so_date}</td>
 *                 <td>${sales_id}</td>
 *                 <td>${payment_method}</td>
 *                 <td>${discount}</td>
 *                 <td width=25>${cash_paid}</td>
 */
                                        </script>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                
                <?= $this->load->view("grid-gallery"); ?>
                
        </div>
        
</div>
