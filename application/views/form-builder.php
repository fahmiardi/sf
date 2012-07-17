<style>
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
h1, h2, h3, h4, h5, h6 {
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
    background:rgb(236,115,0);
    padding:8px;
    color:white;
    text-decoration: none;
}

.column{
	width:49%;
	margin-right:.5%;
	min-height:300px;
	background:#eeeeee;
	float:left;
	
	min-width:310px;
	padding:5px;
	font-family: "Arial";
        font-size: 13px;
        background: #eeeeee;
        color: #111111;
        border: 0.1em solid RGB(197, 194, 194);
}
.column .dragbox{
	margin:5px 2px  20px;
	background:#f3eb7b;
	position:relative;
	border:1px solid #FFC278;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
}
.dragbox{

	background: #f0f0f0;
	border:1px dashed #ddd;
	min-height:50px; margin:5px;
	font-family:'Lucida Grande', Verdana; font-size:0.8em; line-height:1.5em;
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

<link rel="stylesheet" href="<?=base_url()?>file/js/thickbox/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>file/js/thickbox/thickbox.js"></script>


<script>
//showCommentBox
function addTF(getpID,IDform){
        var no_label=0;
    //getpID=1 -- textfield
    if (getpID == 1){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Text Field</b><br/>Label:<br/><input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><br /><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' />Maksimum Karakter Input:<br/><input type='text' name='elm_max")+no_label+("' id='elm_max")+no_label+("' /><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='text' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Simpan Komponen</button><br/></div>"));
    }

    //getpID=2 -- checkbox
    else if(getpID == 2){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Checkbox</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='checkbox' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'></div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Simpan Komponen</button><br/></div>"));
		tb_init('.form_component a.thickbox');
    }

    //getpID=3-- selection menu/drop down
    else if(getpID == 3){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Drop Down List</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='selectionmenu' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal' ><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'></div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Simpan Komponen</button><br/></div>"));
        tb_init('.form_component a.thickbox');
    }
        
    //getpID=5-- radio button
    else if(getpID == 5){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Radio Button</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("' /><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='radiobutton' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'></div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Simpan Komponen</button><br/></div>"));
		tb_init('.form_component a.thickbox');

    }
    
    //getpID=7 -- text label
    else if (getpID == 7){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Label/Text</b><br/><input type='hidden' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='label'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='label")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='label")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/>Value:<br/><textarea rows='2' cols='35' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("' wrap='virtual'></textarea><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='label' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Simpan Komponen</button><br/></div>"));
    }

    //getpID=8 -- camera
    else if (getpID == 8){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Camera Photo</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='uploadedfile' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='uploadedfile' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='img' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Simpan Komponen</button><br/></div>"));
    }

    //getpID=9 -- gps
    else if (getpID == 9){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>GPS Location</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='gps' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='gps' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='gps' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Simpan Komponen</button><br/></div>"));
    }

    //getpID=10 -- barcode
    else if (getpID == 10){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Barcode</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='barcode' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='barcode' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='barcode' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Simpan Komponen</button><br/></div>"));
    }
	
    no_label++;
}

var no_value=<?=$no_value;?>;
//alert(no_value);
var no_label=<?=$no_label;?>;
//alert(no_label);

//add value
function addVal(ID1,ID2){

        //getpID=2 -- checkbox
         if(ID1 == 2){
                        //alert("cb"+no_value);
            $("#Val"+ID2).append(("<div align='left' class='form_component_value' id='Nilai-")+no_value+("'>* Value: <input type='text' name='elm_value")+ID2+("-")+no_value+("' id='elm_value")+ID2+("-")+no_value+("' />&nbsp;<a href='javascript: val_delete("+no_value+");' class='val_delete'>Hapus Value</a></div><div id='novalue")+ID2+("'></div>"));
            $("div #novalue"+ID2).empty();
            $("div #novalue"+ID2).append(("<input type='hidden' name='no_value")+ID2+("' id='no_value")+ID2+("' value='")+no_value+("' />"));        } 
        
        //getpID=3--selection menu
        else if(ID1 == 3){
                        //alert("dropdown"+no_value);
            $("#Val"+ID2).append(("<div align='left' class='form_component_value' id='Nilai-")+no_value+("'>* Value: <input type='text' name='elm_value")+ID2+("-")+no_value+("' id='elm_value")+ID2+("-")+no_value+("' />&nbsp;<a href='javascript: val_delete("+no_value+");' class='val_delete'>Hapus Value</a></div><div id='novalue")+ID2+("'></div>"));
            $("div #novalue"+ID2).empty();
            $("div #novalue"+ID2).append(("<input type='hidden' name='no_value")+ID2+("' id='no_value")+ID2+("' value='")+no_value+("' />"));
            //$("#no_value").append(("<input type='hidden' name='no_value' id='no_value' value='")+no_value+("' />"));
        }
        
        //getpID=5--radio button
        else if(ID1 == 5){
                        //alert("radio"+no_value);
            $("#Val"+ID2).append(("<div align='left' class='form_component_value' id='Nilai-")+no_value+("'>* Value: <input type='text' name='elm_value")+ID2+("-")+no_value+("' id='elm_value")+ID2+("-")+no_value+("' />&nbsp;<a href='javascript: val_delete("+no_value+");' class='val_delete'>Hapus Value</a></div><div id='novalue")+ID2+("'></div>"));
                        $("div #novalue"+ID2).empty();
            $("div #novalue"+ID2).append(("<input type='hidden' name='no_value")+ID2+("' id='no_value")+ID2+("' value='")+no_value+("' />"));
        }
        
        no_value++;
}

//delete value
function val_delete(no_value)
{	
        if(confirm('Apakah Anda yakin untuk menghapus value ini?')==true){
                //return false;        
                $('div #Nilai-'+no_value).fadeOut(200,function(){
                        $('#Nilai-'+no_value).empty();        
                });
        }
}

// u/drag drop
$(function(){
	$('.dragbox').each(function(){
		$(this).hover(function(){
			$(this).find('h2').addClass('collapse');
		}, function(){
		$(this).find('h2').removeClass('collapse');
		})
		.find('h2').hover(function(){
			$(this).find('.configure').css('visibility', 'visible');
		}, function(){
			$(this).find('.configure').css('visibility', 'hidden');
		})
		.click(function(){
			$(this).siblings('.dragbox-content').toggle();
			updateWidgetData();
		})
		.end()
		.find('.configure').css('visibility', 'hidden');
	});
    
	$('.column').sortable({
		connectWith: '.column',
		handle: 'h2',
		cursor: 'move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		opacity: 0.4,
		start: function(event, ui){
                        alert(ui.item);
			//Firefox, Safari/Chrome fire click event after drag is complete, fix for that 
			if($.browser.mozilla) {
				if (($.browser.version.substr(0,1) == 1) || ($.browser.version.substr(0,1) == 0)) {
					$(ui.item).find('.dragbox-content').toggle();
				}
			}
			if($.browser.safari) {
				$(ui.item).find('.dragbox-content').toggle();
			}
		},
		stop: function(event, ui){
			ui.item.css({'top':'0','left':'0'}); //Opera fix
			if($.browser.mozilla) {
				if (($.browser.version.substr(0,1) != 1) && ($.browser.version.substr(0,1) != 0)) {
					updateWidgetData();
				}
			}
			else {
				if(!$.browser.safari) {
					updateWidgetData();
				}
			}
		}
	});
});

//////
function updateWidgetData(){
	var items=[];
	$('.column').each(function(){
		var columnId=$(this).attr('id');
                $('.dragbox', this).each(function(i){
			var collapsed=0;
			if($(this).find('.dragbox-content').css('display')=="none")
				collapsed=1;
			var item={
				id: $(this).attr('id'),
				collapsed: collapsed,
				order : i,
				column: columnId
			};
			items.push(item);
		});
	});
	var sortorder={ items: items };
			
	//Pass sortorder variable to server using ajax to save state
        /*
	$.post('menus//fusion_proses.php',
               'action=9&data='+$.toJSON(sortorder),
               function(response){
                        if(response=="success")
                                $("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);
                        setTimeout(function(){
                                $('#console').fadeOut(1000);
                        }, 2000);
	});*/
}
</script>

<script type="text/javascript" src="<?=base_url()?>file/js/jquery-ui-1.7.3.custom.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>file/js/jquery-ui-1.7.3.custom.css" />

<div class="box">
        <!-- box / title -->
        <div class="title">
                <h5>Form Builder</h5>
                <ul class="links">
                        <li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>/new">New Page</a></li>
                        <li><a href="<?=base_url().$this->uri->segment(1)."/".$this->uri->segment(2)?>">List Data</a></li>
                </ul>
                
        </div>

        <div class="report_setting2" id="input_form">
                <table width="900" border="1">
                <tbody>
                        <tr>
                                <td style="float:left;width:30px">&nbsp;</td>
                                <td style="float:left;width:200px">
                                        <div class="submenu_header">Form Component</div>
                                        <div class="submenu_list">
                                                <a class="addTF" id="post_id1" href="javascript: addTF(1,&quot;8&quot;);">
                                                        <b style="font-family:Arial;font-size:10px;">Text Field</b>
                                                </a>
                                        </div>
                                        <div class="submenu_list"><a class="addTF" id="post_id3" href="javascript: addTF(3,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Drop Down List</b></a></div><div class="submenu_list"><a class="addTF" id="post_id5" href="javascript: addTF(5,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Radio Button</b></a></div><div class="submenu_list"><a class="addTF" id="post_id5" href="javascript: addTF(2,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Checkbox</b></a></div><div class="submenu_list"><a class="addTF" id="post_id7" href="javascript: addTF(7,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Label/Text</b></a></div><div style="" id="img" class="submenu_list"><a class="addTF" id="post_id8" href="javascript: addTF(8,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Camera Photo</b></a></div><div style="" id="gps" class="submenu_list"><a class="addTF" id="post_id9" href="javascript: addTF(9,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">GPS Location</b></a></div><div style="" id="barcode" class="submenu_list"><a class="addTF" id="post_id10" href="javascript: addTF(10,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Barcode</b></a></div><div id="date" class="submenu_list"><a class="addTF" id="post_id11" href="javascript: addTF(11,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Date</b></a></div><div style="display:none;" id="luas_area" class="submenu_list"><a class="addTF" id="post_id12" href="javascript: addTF(12,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Area Measurement</b></a></div><div style="display:none;" id="Dspeed" class="submenu_list"><a class="addTF" id="post_id13" href="javascript: addTF(13,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Download Speed</b></a></div><div style="display:none;" id="Uspeed" class="submenu_list"><a class="addTF" id="post_id14" href="javascript: addTF(14,&quot;8&quot;);"><b style="font-family:Arial;font-size:10px;">Upload Speed</b></a></div>
                                </td>
									
													
				<td style="float:left;width:320px;padding:5px;">
                                        
                                        <div id='column' class='column ui-sortable' unselectable='on' style='-moz-user-select: none;'>
                                                <center><b>------------------ PREVIEW FORM ------------------</b>
                                                        <br>Test aja</center><br style="">
                                                
                                                <div class="dragbox" id="item45">
                                                        <div id="message0">
                                                                <h2>
                                                                        <a href="javascript: delete_form(0,45);" id="no_label-0" class="delete_form">X</a>&nbsp;
                                                                        <a href="javascript: edit_form(0,1,45,8,'Name',0,0);" id="edit_label-0" class="edit_form">Edit</a>&nbsp;Name : <br>
                                                                        <input type="text" value="" id="elm1" name="elm1">
                                                                        <input type="hidden" name="IDelm" id="IDelm0" value="45"><br>
                                                                </h2>
                                                        </div>
                                                </div>
                                                <div class="dragbox" id="item46" style="position: relative; opacity: 1; left: 0pt; top: 0pt;">
                                                        <div id="message1">
                                                                <h2 class="">
                                                                        <a href="javascript: delete_form(1,46);" id="no_label-1" class="delete_form">X</a>
                                                                                &nbsp;<a href="javascript: edit_form(1,3,46,8,'Hobby',0,0);" id="edit_label-1" class="edit_form">Edit</a>&nbsp;Hobby : <br><select id="elm2" name="elm2"><option value="Jalan jalan">Jalan jalan</option><option value="Traveling">Traveling</option></select><input type="hidden" name="IDelm" id="IDelm1" value="46"><br>
                                                                </h2>
                                                        </div>
                                                </div>
                                                <div class="dragbox" id="item48">
                                                        <div id="message2">
                                                                <h2 class="">
                                                                        <a href="javascript: delete_form(2,48);" id="no_label-2" class="delete_form">X</a>
                                                                                &nbsp;<a href="javascript: edit_form(2,3,48,8,'erew',0,0);" id="edit_label-2" class="edit_form">Edit</a>&nbsp;erew : <br><select id="elm3" name="elm3"></select><input type="hidden" name="IDelm" id="IDelm2" value="48"><br>
                                                                </h2>
                                                        </div>
                                                </div>
                                        </div>
                                        <div style="float:right;"></div>
                                </td>
                                <td style="float:left;width:280px;padding:5px;">
                                        <div id="input_komponen_form">
                                                <div align="left" id="label-13" class="form_component">
                                                        <form method="post" onsubmit="return button_form(13)">
                                                        <input type="hidden" value="8" id="form_id" name="form_id"><b>Date</b><br>Label: <input type="text" id="elm_label13" name="elm_label13"><input type="hidden" value="date" id="elm_name13" name="elm_name13"><input type="hidden" value="date" id="elm_id13" name="elm_id13"><input type="hidden" id="elm_max13" name="elm_max13"><input type="hidden" id="elm_size13" name="elm_size13"><input type="hidden" id="elm_value13-0" name="elm_value13-0"><input type="hidden" value="date" id="elm_type13" name="elm_type13"><input type="hidden" value="11" name="getpID" id="getpID"><input type="hidden" value="0" id="no_value13" name="no_value13"><input type="hidden" value="13" id="no_label" name="no_label"><br><button type="submit" class="button_form13" id="button_form13">Save Component</button><br></form></div></div>
                                </td></tr></tbody></table>
	</div>

</div>