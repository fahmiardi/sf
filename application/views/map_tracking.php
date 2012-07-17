<?php 
//Rafi Here

$content_places = "";
$content_route = "";
$timetrack = "";

if($hasil != null) {
    $x = 0;
    foreach($hasil as $v) {
        if($x <> 0) {
            $content_route .= ",";
            $timetrack .= ",";
        }
        $content_places .= "places.push(new google.maps.LatLng(".$v->lat.",".$v->lon."));";
        $content_route .= "new google.maps.LatLng(".$v->lat.",".$v->lon.")";
        $timetrack .= "\"$v->created_on\"";
        $x++;
    }
    
    $route = "var route = [".$content_route."];";
    $places = $content_places;
    
}
?>
<script type="text/javascript">                    
    $(document).ready(function() {
        $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
      });                 
</script>
<div class="box">
     <!-- box / title -->
        <div class="title">
                <h5>GIS > Sales Tracking</h5>
                
        </div>
        <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                <div class="field">
                                        <div class="label">
                                                <label for="user">User:</label>
                                        </div>
                                        <div class="input">
                                                <select name="user" id="user">
                                                <?php
                                                $dt = $this->mgis->getUser89();
                                                $i = 0;
                                                foreach($dt as $row){
                                                    if($row->user_id == $this->input->post("user")) {
                                                        $sel[$i] = "selected";
                                                    }else {
                                                        $sel[$i] = "";
                                                    }
                                                        echo'<option value="'. $row->user_id .'" '.$sel[$i].'>'.$row->user_name.' ('. $row->user_id .')</option>';
                                                        $i++;
                                                }
                                                ?>
                                                </select>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="tanggal">Visit Date (YYYY-MM-DD):</label>
                                        </div>
                                        <div class="input">
                                               <input type="text" id="datepicker" name="tanggal" value="<?= $this->input->post("tanggal") ? $this->input->post("tanggal") : date('Y-m-d') ?>" size="30" />
                                        </div>
                                </div>
                            <div class="buttons">
                                        <input type="submit" name="submit" value="Tracking Search" />                                     
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
                var places = [];
                // Adding a LatLng object for each city
                <?= $places ?>
                        
                var track = [<?= $timetrack ?>]
                var st = "";
                var icons;
                for (var i = 1; i <= places.length; i++) {
                    // Adding the marker as usual
                    if(i == 1) {
                        st = "1 (start)"+" <br/>"+ track[i-1];
                        icons = '<?=base_url()?>file/images/icongis/start.png';
                    }else if(i == places.length) {
                        st = places.length + " (end)"+" <br/>"+ track[i-1];
                        icons = '<?=base_url()?>file/images/icongis/end.png';

                    }else {
                        st = i +" <br/>"+ track[i-1];;
                        icons = '<?=base_url()?>file/images/icongis/dot.png';
                    }
                    var marker = new google.maps.Marker({
                        position: places[i-1],
                        map: map,
                        title: 'Tracking ke-' + st, 
                        icon: icons
                    });
                        // Wrapping the event listener inside an anonymous function
                        // that we immediately invoke and passes the variable i to.
                    (function(st, marker) {
                        // Creating the event listener. It now has access to the values of
                        // i and marker as they were during its creation
                        google.maps.event.addListener(marker, 'click', function() {
                        var infowindow = new google.maps.InfoWindow({
                        content: 'Tracking ke-' + st
                        });
                        infowindow.open(map, marker);
                        });
                    })(st, marker);
                }

                
                // Creating an array that will contain the points for the polyline
                <?= $route ?>
                
                // Creating the polyline object
                var polyline = new google.maps.Polyline({
                path: route,strokeColor: "#ff0000",
                strokeOpacity: 0.6,
                strokeWeight: 5
                });
                // Adding the polyline to the map
                polyline.setMap(map);
                };
                })();
        </script>
        
<div id="map" style="width:98%;height:700px;margin:10px;"></div>
</div>