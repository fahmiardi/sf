<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Sales Order</h5>
                <ul class="links">
                        <li><a href="<?=base_url()?>index.php/sales_order">Create Sales Order</a></li>
                        <li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>">List Data</a></li>
                </ul>
                
        </div>
        <!-- end box / title -->
        <?php if($this->uri->segment(3)=="new"){?>
                <form id="form" action="" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Page Name:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="name" name="name" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="alias">Alias:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="alias" name="alias" class="medium" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="parent">Parent Menu:</label>
                                        </div>
                                        <div class="select">
                                                <select id="parent" name="parent">
                                                        <option value="1">Option #1</option>
                                                        <option value="2">Option #2</option>
                                                        <option value="3">Option #3</option>
                                                </select>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="date">Date Picker:</label>
                                        </div>
                                        <div class="input">
                                                <input type="text" id="date" name="input.date" class="date" />
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label label-checkbox">
                                                <label>Published:</label>
                                        </div>
                                        <div class="checkboxes">
                                                <div class="checkbox">
                                                        <input type="checkbox" id="checkbox-1" name="checkboxex" />
                                                        <label for="checkbox-1">Published Page</label>
                                                </div>
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
                                        <th>Order ID</th>
                                        <th>Territory ID</th>
                                        <th>Order Date</th>
                                        <th>Sales ID</th>
                                        <th>Payment Method</th>
                                        <th>Discount</th>
                                        <th>Cash Paid</th>
                                        
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
                
                <?=$this->load->view("grid-sales");?>
                
        </div>
        
</div>
