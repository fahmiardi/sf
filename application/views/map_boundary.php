<?php 

?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/icon.css" />
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery.easyui.min.js"></script>
<div class="box">
     <!-- box / title -->
        <div class="title">
                <h5>Territory > Territory Boundary</h5>
                <ul class="links">
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>/manage">Manage Boundary</a></li>                        
                </ul>
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
                                        <input type="submit" name="submit" value="Search" />                                     
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
                var myInfowindow = new google.maps.InfoWindow();
                // Adding a LatLng object for each city
                <?php
                $bound = "";
                if($hasil != null) {
                    
                    
                    $ter = $this->mgis->getTerritoryMember($this->input->post("territory"));
                    
                    if($ter != null) {
                        $i = 0;
                        foreach($ter as $r) {
                            
                            $hal = $this->mgis->getBoundaryTerritory($r);
                            $bound = "";
                            $x = 0;
                            foreach($hal as $v) {
                                if($x <> 0) {
                                    $bound .= ",";
                                }                       
                                $bound .= "new google.maps.LatLng(".$v->lat.",".$v->lon.")";

                                $x++;
                            }   
                            $ret = $this->mgis->getTerritoryById($r);
                            $territory_name = $ret['territory_name'];
                            $fill_color = $ret['fill_color'];
                            if($fill_color == "") {
                                $fill_color = "000000";
                            }else {
                                $fill_color = $ret['fill_color'];
                            }
                            
                            $border_color = $ret['border_color'];
                            if($border_color == "") {
                                $border_color = "000000";
                            }else {
                                $border_color = $ret['border_color'];
                            }
                            
                            ?>
                             var bound<?=$i?> = [<?= $bound ?>];               
                            // Creating the polyline object
                            var polygon<?=$i?> = new google.maps.Polygon({
                                path: bound<?=$i?>,
                                strokeColor: "#ff0000",
                                strokeOpacity: 0.7,
                                strokeWeight: 1,
                                fillColor: '#<?=$fill_color?>',
                                strokeColor: '#<?=$border_color?>'
                            });
                            // Adding the polyline to the map
                            polygon<?=$i?>.setMap(map);    
                            
                            // Add a listener for the click event
                            google.maps.event.addListener(polygon<?=$i?>, 'click', function(e) {
                                var vertices = this.getPath();
                                var contentString = "<b><?=$territory_name?></b><br />";

                                // Iterate over the vertices.
                                for (var i =0; i < vertices.length; i++) {
                                  var xy = vertices.getAt(i);
                                }

                                // Replace our Info Window's position
                                myInfowindow.setContent(contentString);
                                myInfowindow.setPosition(e.latLng);
                                myInfowindow.open(map);
                            });


                           // Adding mouseover event to the polygon
                            google.maps.event.addListener(polygon<?=$i?>, 'mouseover', function(e) {
                            // Setting the color of the polygon to blue
                            polygon<?=$i?>.setOptions({
                                fillColor: '#0000ff',
                                strokeColor: '#0000ff'
                            });
                            });

                            // Adding mouseover event to the polygon
                            google.maps.event.addListener(polygon<?=$i?>, 'mouseout', function(e) {
                            // Setting the color of the polygon to blue
                            polygon<?=$i?>.setOptions({
                                fillColor: '#<?=$fill_color?>',
                                strokeColor: '#<?=$border_color?>'
                            });
                            });
                                        
                            <?php     
                            $i++;
                        }
                        
                    }
                                                                
                }
                ?>       
                   
                   
                };
                })();
                               
        </script>
        
<div id="map" style="width:98%;height:700px;margin:10px;"></div>
</div>