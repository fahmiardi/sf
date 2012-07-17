
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/icon.css" />
<link type="text/css" href="<?=base_url()?>file/smooth/css/styles/smoothness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>file/js/jquery-ui-1.8.13.custom.min.js"></script>
<link rel="Stylesheet" type="text/css" href="<?=base_url()?>file/js/jpicker/css/jpicker-1.1.6.min.css" />
<link rel="Stylesheet" type="text/css" href="<?=base_url()?>file/js/jpicker/jPicker.css" />
 <script src="<?=base_url()?>file/js/jpicker/jpicker-1.1.6.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>file/js/map/maps" type="text/javascript"></script>
<script src="<?=base_url()?>file/js/map/main.js" type="text/javascript">  
</script><style type="text/css">@media print{.gmnoprint{display:none}}@media screen{.gmnoscreen{display:none}}</style>
<style type="text/css">

#hand_b {
  width:31px;
  height:31px;
  background-image: url(http://google.com/mapfiles/ms/t/Bsu.png);
}
#hand_b.selected {
  background-image: url(http://google.com/mapfiles/ms/t/Bsd.png);
}

#placemark_b {
  width:31px;
  height:31px;
  background-image: url(http://google.com/mapfiles/ms/t/Bmu.png);
}
#placemark_b.selected {
  background-image: url(http://google.com/mapfiles/ms/t/Bmd.png);
}

#line_b {
  width:31px;
  height:31px;
  background-image: url(http://google.com/mapfiles/ms/t/Blu.png);
}
#line_b.selected {
  background-image: url(http://google.com/mapfiles/ms/t/Bld.png);
}

#shape_b {
  width:31px;
  height:31px;
  background-image: url(http://google.com/mapfiles/ms/t/Bpu.png);
}
#shape_b.selected {
  background-image: url(http://google.com/mapfiles/ms/t/Bpd.png);
}
</style>
    <script type="text/javascript">
var COLORS = [["red", "#ff0000"], ["orange", "#ff8800"], ["green","#008000"],
              ["blue", "#000080"], ["purple", "#800080"]];
var options = {};
var lineCounter_ = 0;
var shapeCounter_ = 0;
var markerCounter_ = 0;
var colorIndex_ = 0;
var featureTable_;
var map;

function select(buttonId) {
  document.getElementById("hand_b").className="unselected";
  document.getElementById("shape_b").className="unselected";
  document.getElementById("line_b").className="unselected";
  document.getElementById("placemark_b").className="unselected";
  document.getElementById(buttonId).className="selected";
}

function stopEditing() {
  select("hand_b");
}

function getColor(named) {
  return COLORS[(colorIndex_++) % COLORS.length][named ? 0 : 1];
}

function getIcon(color) {
  var icon = new GIcon();
  icon.image = "http://google.com/mapfiles/ms/micons/" + color + ".png";
  icon.iconSize = new GSize(32, 32);
  icon.iconAnchor = new GPoint(15, 32);
  return icon;
}

function startShape() {
  select("shape_b");
  var color = getColor(false);
  var polygon = new GPolygon([], color, 2, 0.7, color, 0.2);
  startDrawing(polygon, "Shape " + (++shapeCounter_), function() {
    var cell = this;
    var area = polygon.getArea();
    cell.innerHTML = (Math.round(area / 10000) / 100) + "km<sup>2</sup>";
  }, color);
}

function startLine() {
  select("line_b");
  var color = getColor(false);
  var line = new GPolyline([], color);
  startDrawing(line, "Line " + (++lineCounter_), function() {
    var cell = this;
    var len = line.getLength();
    cell.innerHTML = (Math.round(len / 10) / 100) + "km";
  }, color);
}

function addFeatureEntry(name, color) {
  currentRow_ = document.createElement("tr");
  var colorCell = document.createElement("td");
  currentRow_.appendChild(colorCell);
  colorCell.style.backgroundColor = color;
  colorCell.style.width = "1em";
  var nameCell = document.createElement("td");
  currentRow_.appendChild(nameCell);
  nameCell.innerHTML = name;
  var descriptionCell = document.createElement("td");
  currentRow_.appendChild(descriptionCell);
  featureTable_.appendChild(currentRow_);
  return {desc: descriptionCell, color: colorCell};
}

function startDrawing(poly, name, onUpdate, color) {
  map.addOverlay(poly);
  poly.enableDrawing(options);
  poly.enableEditing({onEvent: "mouseover"});
  poly.disableEditing({onEvent: "mouseout"});
    
  var new_index = "";
  
  GEvent.addListener(map, "click", function (latlng,index) {
      var undef = index + "";      
      if(undef == "undefined") {
          new_index = "";
      }else {
          new_index = (undef.replace("(","")).replace(")",";");
      }
      document.getElementById("border").value += new_index;
  });
  GEvent.addListener(poly, "endline", function() {
    select("hand_b");
    var cells = addFeatureEntry(name, color);
    GEvent.bind(poly, "lineupdated", cells.desc, onUpdate);
    
    GEvent.addListener(poly, "click", function(latlng, index) {
      if (typeof index == "number") {
        poly.deleteVertex(index);     
      } else {
        var newColor = getColor(false);
        cells.color.style.backgroundColor = newColor
        poly.setStrokeStyle({color: newColor, weight: 4});           
      }
    });
  });
}

function placeMarker() {
  select("placemark_b");
  var listener = GEvent.addListener(map, "click", function(overlay, latlng) {
    if (latlng) {
      select("hand_b");
      GEvent.removeListener(listener);
      var color = getColor(true);
      var marker = new GMarker(latlng, {icon: getIcon(color), draggable: true});
      map.addOverlay(marker);
      var cells = addFeatureEntry("Placemark " + (++markerCounter_), color);
      updateMarker(marker, cells);
      GEvent.addListener(marker, "dragend", function() {
        updateMarker(marker, cells);
      });
      GEvent.addListener(marker, "click", function() {
        updateMarker(marker, cells, true);
      });
    }
  });
}

function updateMarker(marker, cells, opt_changeColor) {
  if (opt_changeColor) {
    var color = getColor(true);
    marker.setImage(getIcon(color).image);
    cells.color.style.backgroundColor = color;
  }
  var latlng = marker.getPoint();
  cells.desc.innerHTML = "(" + Math.round(latlng.y * 100) / 100 + ", " +
  Math.round(latlng.x * 100) / 100 + ")";
}


function initialize() {
  if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById("map"));
    map.setCenter(new GLatLng(-6.204043, 106.845474), 8);
    map.addControl(new GSmallMapControl());
    map.addControl(new GMapTypeControl());
    map.clearOverlays();
    featureTable_ = document.getElementById("featuretbody");
    select("hand_b");
  }
}

function save() {
    if(window.confirm("Are you sure want to make of this territory, This will delete old data?")) {
        
    }
}
     
  $(document).ready(
    function()
    {
      $('.Multiple').jPicker();
    });

</script>
<script src="<?=base_url()?>file/js/map/vp" charset="UTF-8" type="text/javascript"></script>
<script src="<?=base_url()?>file/js/map/mod_dragmod_ctrapi.js" charset="UTF-8" type="text/javascript"></script>  
<div class="box">
     <!-- box / title -->
        <div class="title">
            <h5>GIS > Territory Boundary > Manage</h5>                
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
                    <div class="field">
                        <div class="label">
                            <label for="border">Geo Position</label>
                        </div>
                        <div class="input">
                            <textarea type="text" id="border" name="border" cols="50" rows="3"></textarea>              
                        </div>
                    </div>
                    <div class="field">
                        <div class="label">
                            <label for="user">Fill Color:</label>
                        </div>
                        <div class="input">
                            <input type="text" name="fillcolor" class="Multiple" name="color" value="000000"  />                                             
                        </div>
                    </div>  
                    <div class="field">
                        <div class="label">
                            <label for="user">Border Color:</label>
                        </div>
                        <div class="input">
                            <input type="text" name="bordercolor" class="Multiple" name="color" value="ff0000"  />                                             
                        </div>
                    </div>  
                    <div class="field">
                        <div class="label">
                            <label for="drawtools">Draw Tools</label>
                        </div>
                        <div class="input">
                            <table>
                            <tbody>
                            <tr>
                                <td><div class="selected" id="hand_b" onclick="stopEditing()"></div></td>
                                <td><div class="unselected" id="placemark_b" onclick="placeMarker()"></div></td>
                                <td><div class="unselected" id="line_b" onclick="startLine()"></div></td>
                                <td><div class="unselected" id="shape_b" onclick="startShape()"></div></td>
                            </tr>
                            </tbody>
                        </table>        
                        </div>
                    </div>
                    <div class="buttons">
                        <input type="submit" name="submit" value="Save" onclick="return save();"/>                                                         
                        <input type="button" name="cancel" value="Cancel" />                                     
                    </div>
                </div>
            </div>
        <table style="border: 1px solid #000000;" width="100%">
          <tbody><tr style="vertical-align: top;">
          <td style="width: 15em;padding: 10px;" valign="top">
                              
                
                <input id="featuredetails" rows="2" type="hidden">
              
                <p>To draw on the map, click on one of the buttons and then click on the
                 map.  Double-click to stop drawing a line or shape. Click on an element
                 to change color. To edit a line or shape, mouse over it and drag the 
                points.  Click on a point to delete it.
                </p>
                    
                <table id="featuretable">
                    <tbody id="featuretbody"></tbody>
                </table>
          </td></tr>
              <tr>
          <td valign="top">            
            <div id="map" style="width: 100%; height: 500px; position: relative; background-color: rgb(229, 227, 223);"><div style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0; cursor: url(&quot;http://maps.gstatic.com/intl/en_ALL/mapfiles/openhand_8_8.cur&quot;), default;"><div style="position: absolute; left: 0px; top: 0px; display: none;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/transparent.png" style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"></div></div><div style="position: absolute; left: 0px; top: 0px;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1315y3175z13s.png" style="position: absolute; left: -258px; top: -92px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1315y3176z13sG.png" style="position: absolute; left: -258px; top: 164px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1315y3177z13sGa.png" style="position: absolute; left: -258px; top: 420px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1316y3175z13sGal.png" style="position: absolute; left: -2px; top: -92px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1316y3176z13sGali.png" style="position: absolute; left: -2px; top: 164px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1316y3177z13sGalil.png" style="position: absolute; left: -2px; top: 420px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1317y3175z13sGalile.png" style="position: absolute; left: 254px; top: -92px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1317y3176z13sGalileo.png" style="position: absolute; left: 254px; top: 164px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><img src="mymapstoolbar_files/lyrsm171000000hlensrcapix1317y3177z13s.png" style="position: absolute; left: 254px; top: 420px; width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 100;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 101;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 102;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 103;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 104; cursor: default;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 105;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 106;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 107; cursor: default;"></div></div></div><div style="-moz-user-select: none; z-index: 0; position: absolute; left: 2px; bottom: 2px;" class="gmnoprint"><a href="http://maps.google.com/maps?ll=37.4419,-122.1419&amp;spn=0.040888,0.051498&amp;z=13&amp;key=ABQIAAAA-O3c-Om9OcvXMOJXreXHAxQGj0PqsCtxKvarsoS-iqLdqZSKfxS27kJqGZajBjvuzOBLizi931BUow&amp;mapclient=jsapi&amp;oi=map_misc&amp;ct=api_logo" target="_blank" title="Click to see this area on Google Maps"><img src="mymapstoolbar_files/poweredby.png" style="width: 62px; height: 30px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; cursor: pointer;"></a></div><div dir="ltr" style="-moz-user-select: none; z-index: 0; position: absolute; right: 3px; bottom: 2px; color: black; font-family: Arial,sans-serif; font-size: 11px; white-space: nowrap; text-align: right;"><span>Map data ©2012  Google - </span><a style="color: rgb(119, 119, 204);" class="gmnoprint terms-of-use-link" target="_blank" href="http://www.google.com/intl/en_ALL/help/terms_maps.html">Terms of Use</a></div><div class="gmnoprint" style="width: 37px; height: 94px; -moz-user-select: none; z-index: 0; position: absolute; left: 7px; top: 7px;"><img src="mymapstoolbar_files/smc.png" style="position: absolute; left: 0px; top: 0px; width: 37px; height: 94px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"><div title="Pan up" style="position: absolute; left: 9px; top: 0px; width: 18px; height: 18px; cursor: pointer;"></div><div title="Pan left" style="position: absolute; left: 0px; top: 18px; width: 18px; height: 18px; cursor: pointer;"></div><div title="Pan right" style="position: absolute; left: 18px; top: 18px; width: 18px; height: 18px; cursor: pointer;"></div><div title="Pan down" style="position: absolute; left: 9px; top: 36px; width: 18px; height: 18px; cursor: pointer;"></div><div title="Zoom In" style="position: absolute; left: 9px; top: 57px; width: 18px; height: 18px; cursor: pointer;"></div><div title="Zoom Out" style="position: absolute; left: 9px; top: 75px; width: 18px; height: 18px; cursor: pointer;"></div></div><div style="-moz-user-select: none; z-index: 0; position: absolute; right: 7px; top: 7px; color: black; font-family: Arial,sans-serif; font-size: small; width: 200px; height: 19px;" class="gmnoprint"><div title="Show street map" style="position: absolute; background-color: white; border: 1px solid black; text-align: center; width: 5em; right: 10.2em; cursor: pointer;"><div style="font-size: 12px; font-weight: bold; border-width: 1px; border-style: solid; border-color: rgb(52, 86, 132) rgb(108, 157, 223) rgb(108, 157, 223) rgb(52, 86, 132); -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; -moz-border-image: none;">Map</div></div><div title="Show satellite imagery" style="position: absolute; background-color: white; border: 1px solid black; text-align: center; width: 5em; right: 5.1em; cursor: pointer;"><div style="font-size: 12px; border-width: 1px; border-style: solid; border-color: white rgb(176, 176, 176) rgb(176, 176, 176) white; -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; -moz-border-image: none;">Satellite</div></div><div title="Show imagery with street names" style="position: absolute; background-color: white; border: 1px solid black; text-align: center; width: 5em; right: 0em; cursor: pointer;"><div style="font-size: 12px; border-width: 1px; border-style: solid; border-color: white rgb(176, 176, 176) rgb(176, 176, 176) white; -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; -moz-border-image: none;">Hybrid</div></div></div></div>
          </td>
        </tr></tbody></table>
        <script type="text/javascript">
                initialize();
        </script>
        </form>
</div>