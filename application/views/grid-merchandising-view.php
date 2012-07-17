<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/gray/easyui.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>file/js/easyui/themes/icon.css">

<script type="text/javascript" src="<?= base_url() ?>file/js/add-item.js"></script>


<form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">


<script type="text/javascript">
        jQuery.fn.center = function () {
        this.css("position","absolute");
        this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
        this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
        return this;
    }
        
        $(function(){
            $("#region").change(function(){
                //$("#cluster").css("display", "inline-table");
                var regionID = $("#region").val();
                //alert(regionID);
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/merchandising/load_cluster/"+regionID,
                    dataType:"json",
                    success:function(data){
                        $('.clusterClass').remove();
                        $.each(data, function(i,n){
                            //document.write(n['iccid']);
                            add_tuple = "<option class='clusterClass' value='"+n["territory_id"]+"'> "+n["territory_name"]+" </option>";                
                            $('#cluster').append(add_tuple);
                            
                        });    
                    },
                    error: function(data){
                        
                    }
                });
            });
            
        });

function popUp(urlImg)
{
    var wrapperHeight = $('#content').height();
    $('#darkBack').css({'height': ($(document).height())+'px'});
    var urlBase = '<?php echo base_url()?>';
    $("#darkBack").css({"opacity" : "0.7"})
        .fadeIn("slow");
    
    $("#popUpItem").css({"opacity" : "1"})
        .fadeIn("slow");    
        
    $("#popUpItem").html("<img src='"+urlBase+"file/uploads/"+urlImg+"' width='400px'/>")
                   .center()
                   .fadeIn("slow");
    //alert(wrapperHeight);
}

function closeBack()
{
    $("#darkBack").fadeOut("slow");
    $("#popUpItem").fadeOut("slow");
}

function closeItem()
{
    $("#darkBack").fadeOut("slow");
    $("#popUpItem").fadeOut("slow");
}


$(document).keypress(function(e){
    if(e.keyCode==27){
        $("#darkBack").fadeOut("slow"); 
        $("#popUpItem").fadeOut("slow");   
    }
});

$(function(){
    $("#cluster").change(function(){
        var clusterID = $("#cluster").val();
        var baseUrl = '<?php echo base_url()?>';
        //alert('koha');        
        //alert(clusterID);
            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/merchandising/load_merchan/"+clusterID,
                    dataType:"json",
                    success:function(data){   
                            //alert(baseUrl);
                           $.each(data, function(i,n){
                            //document.write(n['iccid']);
                                add_tuple = "<tr id='thumbnail'  align='center' id='new_tuple"+test+"' class='wide'>"+
                                                "<td>"+ n["created_on"] +"</td>"+
                                                "<td>"+ n["outlet_name"] +"</td>"+
                                                "<td>"+ n["keyword"] +"</td>"+
                                                "<td> <img id='"+n["pic1"]+"' onclick='popUp(this.id)' style='margin: 10px' src="+baseUrl+"file/uploads/"+n["pic1"]+" width='80%'/></td>"+
                                                "<td> <img id='"+n["pic2"]+"' onclick='popUp(this.id)' style='margin: 10px' src="+baseUrl+"file/uploads/"+n["pic2"]+" width='80%'/></td>"+
                                                "<td> <img id='"+n["pic3"]+"' onclick='popUp(this.id)' style='margin: 10px' src="+baseUrl+"file/uploads/"+n["pic3"]+" width='80%'/></td>"+
                                            "</tr>";
                                $('#table-updateable').append(add_tuple);
                                //test++;
                            });
                    },
                    error: function(data){
                        
                    }
            });   
    });
});

$(function(){
            $("#itemAdd").click(function(){
                counterTR++;
                $.add_tuple = "<tr align='center' id='new_tuple"+counterTR+"' class='wide'>"+
                    "<td><input type='checkbox' id='checkbox"+counterTR+"'/></td>"+
                    "<td><input type='text'  id='iccid"+counterTR+"' name='iccid[]' class='width-270-2' onkeyup='autocompletex(this.value,"+counterTR+")' autocomplete='off'/><ul id='td_iccid"+counterTR+"' class='td_iccid'></ul></td>"+
                    "<td><input type='text'  id='itemgroup"+counterTR+"' readonly='true' class='input-readonly' name='item_group_name[]'/></td>"+
                    "<td><input type='text'  id='itemname"+counterTR+"' readonly='true' class='input-readonly' name='item_name[]'/></td>"+
                    "<td><input type='text' class='default_price' id='default_price"+counterTR+"' style='border:none' readonly='true' class='input-readonly' name='default_price[]'/></td>"+
                    "<td><input type='text' class='reseller' id='reseller_disc"+counterTR+"' name='reseller_disc[]' onchange='sumPrice("+counterTR+")'/></td>"+
                    "<td><input type='text' class='amount' readonly='true' style='border:none' id='amount"+counterTR+"' name='amount[]'/></td>"+
                "</tr>";
            
                $('#table-updateable').append($.add_tuple);
            
                var copyval = $('#reseller_price'+counterTR).attr('value');
                $("#default_price"+counterTR).val(copyval); 
            
            });
});

</script>
<div id="popUpItem" onclick="closeItem()"></div>
<div id="darkBack" onclick="closeBack()"></div>

<div class="panel-wrap" style="height: auto">
	<div class="panel-header-div">Merchan Information</div>
    
    <div class="panel-body-div">
        <div class="child-panel-body">
        <div class="left-panel-body">
            <table class="table-right-panel" width="60%" border="solid black 1px">
                <tr align="center" class="tr-colour2">
                    <th width="50%" align="center">Region</th>
                    <th align="center">Cluster</th>
                </tr>
                
                
                <tr align="center" class="gray">
                    <td>
                        
                        <select name="region" id="region">
                        <?php foreach($region as $item):?>
                            <option id="option1" value="<?php echo $item->territory_id?>"><?php echo $item->territory_name?></option>
                        <?php endforeach?>
                        </select>
                        
                    </td>
                    <td class="readonly" align="center">
                        <select name='cluster' id='cluster'>  
                        </select>
                    </td>
                    
                    
                </tr>
            </table>
        </div>
        
    </div>
    
    
    
                    
    <div class="child-panel-body">
        
            <table class="table-right-panel" id="table-updateable" width="97%" style="margin-left: 19px;">
                <tr align="center" class="tr-colour3" id="tr_select_all">
                    
                    <th>Date</th>
                    <th>Outlet Name</th>
                    <th>Keyword</th>
                    <th width="20%">Etalase (pic)</th>
                    <th width="20%">Outlet (pic)</th>
                    <th width="20%">BillBoard (pic)</th>
                    
                </tr>
                
                
            </table>
                       
        
            
            
            
    </div>
    
    
    
        
    </div>
    
</div>
</form>

<script type="text/javascript">
    $(document).ready(function() 
        {
            $("#select_all").click(function() 
            { 
                var checked_status = this.checked; 
                $("input[@name=checkbox]").each(function() 
                { 
                    this.checked = checked_status; 
                }); 
            });
        });            
</script>