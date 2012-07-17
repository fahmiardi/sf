<?php

?>

<link rel="stylesheet" href="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/development-bundle/themes/base/jquery.ui.all.css"/>
<script src="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/development-bundle/jquery-1.7.1.js"/></script>
<script src="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.core.js"/></script>
<script src="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.widget.js"/></script>
<script src="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.mouse.js"/></script>
<script src="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/development-bundle/ui/jquery.ui.sortable.js"/></script>
<link rel="stylesheet" href="<?=base_url()?>file/js/jquery-ui-1.8.17.custom/css/demos.css"/>

<style>
        #sortable2671,#sortable2984 {
                list-style-type: none;
                margin: 0;
                padding: 0;
                float: left;
                margin-right: 10px;
                background: #eee;
                padding: 2px;
                width: 340px;
                
                margin:5px 2px  20px;
                background: #f0f0f0;
                position:relative;
                border:1px dashed #ddd;
        }
        #sortable2671 li ,#sortable2984 li  {
                margin: 4px;
                padding: 4px;
                font-size: 1.2em;
                width: 320px;
                
                background:#f3eb7b;
                border:1px solid #FFC278;
                min-height:50px; margin:5px;
                font-family:'Lucida Grande', Verdana; font-size:0.8em; line-height:1.5em;
                
                -moz-border-radius:5px;
                -webkit-border-radius:5px;
        }
        
        .submenu_header {
                font-family: "Verdana";
                font-size: 12px;
                background:#6f0d00;
                color:white;
                padding:8px;
                font-weight: bold;
        }
            
        .submenu_list {
                font-family: "Verdana";
                font-size: 13px;
                background: #eeeeee;
                color:white;
                border-bottom: 0.1em solid RGB(197, 194, 194);
        }
        h1, h2, h3, h4 {
                font-size: 100%;
                font-weight: normal;
        }
        .submenu_list a {
                font-family: "Verdana";
                font-size: 14px;
                color: #111111;
                display: block;
                padding:8px;
        }
            
        .submenu_list a:hover {
                font-family: "Verdana";
                font-size: 14px;
                color:green;
                display: block;
                background: #bd3220;
                padding:8px;
                color:white;
                text-decoration: none;
        }
            
        .form_component{
                    width:274px;
                    padding:5px;
                    font-family: "Arial";
                    font-size: 13px;
                    background: #eeeeee;
                    color: #111111;
                    border: 0.1em solid RGB(197, 194, 194);
        }
            
        .form_component_value{
                    width:262px;
                    padding:5px;
                    font-family: "Arial";
                    font-size: 11px;
                    background: #eeeeee;
                    color: #111111;
        }
</style>
<script>
$(function() {
        $( "ul.droptrue" ).sortable({
                connectWith: "ul",
                cursor: 'move',
                receive: function(event, ui) {
                        var nim = $(ui.item).attr('id'); 
                        var kelas_sebelumnya = $(ui.item).attr('sid');
                        var kelas_baru = $(this).closest('ul').attr('sid');
                        
                        $.post(
                                '<?=base_url()?>krs/savepindahkelas', 
                                {nim:nim, kelas_sebelumnya:kelas_sebelumnya,kelas_baru:kelas_baru},
                                function(data) {
                                        
                                },
                                "json"
                        ).error(function() {
                                alert("-");
                        })
                }
        });
        $( "#sortable2671,#sortable2984" ).disableSelection();
});
	
$(document).ready(function() {
    
    $('.d_add_komponen').click(function() {
        var jenis        = $(this).attr('val');
        $.post(
            '<?=base_url()?>index.php/services/load_component', 
            {jenis:jenis},
            function(data) {
                if(data.status == 'OK') {
                    document.getElementById("divkomponen").innerHTML = data.pesan;
                }
            },
            "json"
        ).error(function() {
            alert("-");
        });
    });
});
</script>

<div class="box" style="min-height:800px">
        <!-- box / title -->
        <div class="title">
                <h5>Service Management</h5>
                <ul class="links">
                        <li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>/new">Back</a></li>
                </ul>
                
        </div>
        
        <table cellspacing=0 cellpadding=0 width=100%>
        <tr>
                <td width=200px><h5>Service Name</h5></td>
                <td><h5>: <?=$this->mglobal->showdata("services_name","t_trx_service",array("services_id"=>$id),"dblokal")?></h5></td>
        </tr>
        <tr>
                <td><h5>Table Name</h5></td>
                <td><h5>: <?=$this->mglobal->showdata("services_tabel","t_trx_service",array("services_id"=>$id),"dblokal")?></h5></td>
        </tr>
        </table>
        
        <div class="report_setting2" id="input_form">
                <table width="900" border="1">
                <tbody>
                        <tr>
                                <td style="float:left;width:30px">&nbsp;</td>
                                <td style="float:left;width:200px">
                                        <div class="submenu_header">Form Component</div>
                                        
                                        <?php
                                        $nm  = array("text","textarea","date","dropdown","radio","checkbox","photo","gps","barcode");
                                        $nmn = array("Input Text","Textarea","Date","Dropdown List","Radio Button","Checkbox","Camera Photo","GPS Location","Barcode");
                                        for($i=0;$i<=count($nm)-1;$i++){
                                                echo'<div class="submenu_list" val="'. $nm[$i] .'">
                                                        <a class="d_add_komponen" id="komponen" val="'. $nm[$i] .'">
                                                                <b style="font-family:Arial;font-size:10px;">'. $nmn[$i] .'</b>
                                                        </a>
                                                </div>';
                                        }
                                        ?>
                                        </div>
                                </td>
                                
				<td style="float:left;width:360px;padding:5px;padding-top:0;">
                                        <div class="submenu_header">Form Preview</div>
                                        <div style="float: left; margin-top: 5px; margin-right: 5px; margin-bottom: 5px; margin-left: 5px; width: 210px; ">
                                                <ul id="sortable2671" sid="2671" class="droptrue ui-sortable">
                                                <?php
                                                        foreach($getComponent as $r){
                                                        echo'<li class="ui-state-highlight" sid="2671">
                                                                <h2>
                                                                        <a href="'. base_url() .'index.php/services/delete_component/'. $id .'/'. $r->property_id .'" id="dialog-confirm-open" class="delete_form"><img src="'.base_url().'file/images/cross.png"></a>
                                                                        <a href="javascript: edit_form(0,1,45,8,\'Name\',0,0);" id="edit_label-0" class="edit_form"><img src="'.base_url().'file/images/form_edit.png"></a>
                                                                        &nbsp;&nbsp;'. $r->t_elm_label .' : <br>';
                                                                        
                                                                        if($r->t_elm_type == "text"){
                                                                                echo'<input type="text" value="" name="'. $r->t_services_column .'">';
                                                                        }elseif($r->t_elm_type == "textarea"){
                                                                                echo'<textarea value="" name="'. $r->t_services_column .'" rows=4 cols=200></textarea>';
                                                                        }elseif($r->t_elm_type == "date"){
                                                                                echo'<input type="text" value="" id="date" class="date" name="'. $r->t_services_column .'">';
                                                                        }elseif($r->t_elm_type == "dropdown"){
                                                                                echo'<select name="'. $r->t_services_column .'">';
                                                                                if($r->t_source_name <> ""){
                                                                                        $data = $this->mservices->getValueFromTable($r->t_source_name);
                                                                                        foreach($data as $row){
                                                                                                echo'<option value="'. $row->{$r->t_source_column_value} .'">'. $row->{$r->t_source_column_display} .'</option>';
                                                                                        }
                                                                                }else{
                                                                                        
                                                                                }
                                                                                echo'</select>';
                                                                        }elseif($r->t_elm_type == "radio"){
                                                                                if($r->t_source_name <> ""){
                                                                                        $i=1;
                                                                                        $data = $this->mservices->getValueFromTable($r->t_source_name);
                                                                                        foreach($data as $row){
                                                                                                echo'<div class="radio">
                                                                                                        <input type="radio" id="radio-'. $i .'" name="'. $r->t_services_column .'" value="'. $row->{$r->t_source_column_value} .'"/>
                                                                                                        <label for="radio-'. $i .'">'. $row->{$r->t_source_column_display} .'</label>
                                                                                                </div>';
                                                                                                $i++;
                                                                                        }
                                                                                }else{
                                                                                        
                                                                                }
                                                                        }elseif($r->t_elm_type == "checkbox"){
                                                                                if($r->t_source_name <> ""){
                                                                                        $i=1;
                                                                                        $data = $this->mservices->getValueFromTable($r->t_source_name);
                                                                                        foreach($data as $row){
                                                                                                echo'<div class="checkbox">
                                                                                                        <input type="checkbox" id="checkbox-'. $i .'" name="'. $r->t_services_column .'" value="'. $row->{$r->t_source_column_value} .'"/>
                                                                                                        <label for="checkbox-'. $i .'">'. $row->{$r->t_source_column_display} .'</label>
                                                                                                </div>';
                                                                                                $i++;
                                                                                        }
                                                                                }else{
                                                                                        
                                                                                }
                                                                        }elseif($r->t_elm_type == "photo"){
                                                                                echo'<input type="file" value="" name="'. $r->t_services_column .'">';
                                                                        }elseif($r->t_elm_type == "gps"){
                                                                                echo'<input type="text" value="" name="'. $r->t_services_column .'" disabled="disabled">';
                                                                        }elseif($r->t_elm_type == "barcode"){
                                                                                echo'<input type="text" value="" name="'. $r->t_services_column .'" disabled="disabled">';
                                                                        }
                                                                        
                                                                        
                                                                        echo'
                                                                </h2>
                                                        </li>';
                                                        }
                                                ?>
                                                </ul>
                                        </div>
                                        
                                </td>
                                <td style="float:left;width:280px;padding:5px;">
                                        <div id="divkomponen">
                                        </div>
                                </td></tr></tbody></table>
	</div>

</div>