<?php

   
?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/icon.css" />
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery.easyui.min.js"></script>
<div class="box">
     <!-- box / title -->
        <div class="title">
                <h5>GIS > Outlet Mapping</h5>                
        </div>
        <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="user">Territory:</label>
                                        </div>
                                        <div class="input">
                                                <input id="cc" name="territory" class="easyui-combotree" url="<?= base_url()?>index.php/gis/territory_json" value="<?= $this->input->post('territory') ? $this->input->post('territory') : 1 ?>" required="true" style="width:200px;">                                                
                                        </div>
                                </div>                                
                            <div class="buttons">
                                        <input type="submit" name="submit" value="Outlet Search" />                                     
                                </div>
                        </div>
                </div>
        </form>
<script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC0JhNTyjMpdmUPMDYWIVuE57dUIHZH1SU&sensor=true">
        </script>
        <script type="text/javascript">
            (function() {
                window.onload = function() {
                // Creating a map
                var options = {
                zoom: 6,
                center: new google.maps.LatLng(-6.204043, 106.845474),
                mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                
                var map = new google.maps.Map(document.getElementById('map'), options);
                // Creating an array that will contain the coordinates
                // for New York, San Francisco, and Seattle
                //adding info windows
                var info = [];
                                        
                var places = [];
                // Adding a LatLng object for each city
                <?php
                if($hasil != null) {
                    $x = 0;
                    foreach($hasil as $v) {
                        if($v->lat <> "" || $v->lon) {
                            echo "places.push(new google.maps.LatLng(".$v->lat.",".$v->lon."));";
                        echo "info[$x] = \"<b>$v->outlet_name</b><br />$v->address<br />$v->city<br />$v->post_code<br />$v->phone<br />\";";
                        $x++;
                        }
                        
                        
                    }        

                }
                ?>
                                        
                var st = "";
                for (var i = 1; i <= places.length; i++) {
                    // Adding the marker as usual
                    if(i == 1) {
                        st = "1";
                    }else if(i == places.length) {
                        st = places.length;
                    }else {
                        st = i;
                    }
                    var marker = new google.maps.Marker({
                        position: places[i-1],
                        map: map,
                        title: 'Outlet ke-' + st,
                        icon: '<?=base_url()?>file/images/icongis/smartfren.png'
                    });
                        // Wrapping the event listener inside an anonymous function
                        // that we immediately invoke and passes the variable i to.
                    (function(i,st, marker) {
                        // Creating the event listener. It now has access to the values of
                        // i and marker as they were during its creation
                        google.maps.event.addListener(marker, 'click', function() {
                        var infowindow = new google.maps.InfoWindow({
                        content: info[i-1] + ""
                        });
                        infowindow.open(map, marker);
                        });
                    })(i,st, marker);
                }

                
               
                };
                })();
        </script>
        
<div id="map" style="width:98%;height:700px;margin:10px;"></div>
</div>