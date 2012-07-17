<link rel="stylesheet" href="<?=base_url()?>file/js/jorgchart/css/bootstrap.min.css"/>
<link rel="stylesheet" href="<?=base_url()?>file/js/jorgchart/css/jquery.jOrgChart.css"/>
<link rel="stylesheet" href="<?=base_url()?>file/js/jorgchart/css/custom.css"/>
<link href="<?=base_url()?>file/js/jorgchart/css/prettify.css" type="text/css" rel="stylesheet" />

	<script type="text/javascript" src="<?=base_url()?>file/js/jorgchart/prettify.js"></script>
		
        <!-- jQuery includes -->
        <script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    
        <script src="<?=base_url()?>file/js/jorgchart/jquery.jOrgChart.js"></script>

        <script>
        jQuery(document).ready(function() {
            $("#org").jOrgChart({
                            chartElement : '#chart',
                            dragAndDrop  : true
                    });
        });
        </script>
    

<div class="box">
        <!-- box / title -->
        
        <!-- end box / title -->
        <ul id="org" style="display:none">
        <li>
                Smartfren
                <?=$this->mterritory->getTerritoryChart();?>
        </li>
   </ul>			
	
	<div id="chart" class="orgChart"></div>
    
    <script>
        jQuery(document).ready(function() {
    		
    		/* Custom jQuery for the example */
    		$("#show-list").click(function(e){
    			e.preventDefault();
    			
    			$('#list-html').toggle('fast', function(){
    				if($(this).is(':visible')){
    					$('#show-list').text('Hide underlying list.');
    					$(".topbar").fadeTo('fast',0.9);
    				}else{
    					$('#show-list').text('Show underlying list.');
    					$(".topbar").fadeTo('fast',1);					
    				}
    			});
    		});
            
            $('#list-html').text($('#org').html());
            
            $("#org").bind("DOMSubtreeModified", function() {
                $('#list-html').text('');
                
                $('#list-html').text($('#org').html());
                
                prettyPrint();                
            });
        });
    </script>
        <!-- pagination -->
        <!-- end pagination -->
        <!-- table action -->
        <!-- end table action -->
</div>