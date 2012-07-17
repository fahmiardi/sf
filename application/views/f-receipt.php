<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Receipt</h5>
                <ul class="links">
                        <li><a href="<?=base_url().'index.php/sales/newreceipt'?>">Create Receipt</a></li>
                        <li><a href="<?=base_url().'index.php/sales'?>">List Receipt</a></li>
                </ul>
        </div>
        <!-- end box / title -->
		
        <?php
			if (!isset($jenis))
			{
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
										<th>No</th>
                                        <th>Date</th>
                                        <th>Receipt No</th>
                                        <th>Sales Name</th>
                                        <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                
                <?=$this->load->view("grid-receipt");?>
                
        </div>
        <?php
			}
			else
			{
		?>
        <div class="table">
                
                <?php
                if($jenis == "create"){
                        $this->load->view('f-receipt-create');
                }
				// elseif($jenis == "chart"){
                        // echo'<iframe src="'.base_url().'index.php/territory/territory_iframe/chart" width=100% height=600px>';
                // }
                ?>
                
                
        </div>
		<?php
			}
		?>
</div>