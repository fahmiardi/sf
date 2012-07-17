ha;ppp

<script type="text/javascript">
        function edit_fit_cl(ID){ // ID dikirimkan sebagai parameter
            $('#divResult').text('loading...').fadeIn();
            $.post(
                  'menus//fusion_proses.php',
                      {id: ID,action: 10},
                      function(response){
/* 						var KonF=response.Konfirmasi;
						alert(KonF); */
						//alert(response);
                            if(response == 1){  // jika respon dari delete.php adalah 'ok'
                                 alert('Successfully Edited');
                                /*  $('#divResult').text('Successfully Edited').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn(); */
							}
                            else{
                                 alert('Failed Editing');
							}
                        }
                      );
               }
			   
$(function(){
	$('.dragbox')
	.each(function(){
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
	})
	.disableSelection();
});

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
	$.post('menus//fusion_proses.php', 'action=9&data='+$.toJSON(sortorder), function(response){
		if(response=="success")
			$("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);
		setTimeout(function(){
			$('#console').fadeOut(1000);
		}, 2000);
	});
}
		function ucwords (str) {
		
    // Uppercase the first character of every word in a string  
    // 
    // version: 1103.1210
    // discuss at: http://phpjs.org/functions/ucwords    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Waldo Malqui Silva
    // +   bugfixed by: Onno Marsman
    // +   improved by: Robin
    // +      input by: James (http://www.james-bell.co.uk/)    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: ucwords('kevin van  zonneveld');
    // *     returns 1: 'Kevin Van  Zonneveld'
    // *     example 2: ucwords('HELLO WORLD');
    // *     returns 2: 'HELLO WORLD'    
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

//submit form drop down
    function submitForm_DD(){
        // beri tanda bahwa data sedang di proses dengan efek loading fade in
        $('#divResult').text('loading...').fadeIn();
		if(confirm('Are you sure to replace with this source? Source replacement might delete all related records.')==true){

        $('#formData').ajaxSubmit({
            success: function(response){
				//alert(response.IDElemen);
				//alert($('select[name=ID_Form_Elemen] option:selected').text());
				//alert($('select[name=ID_Elemen] option:selected').text());
				var form_elemen=$('select[name=ID_Form_Elemen] option:selected').text();
				var nama_elemen=$('select[name=ID_Elemen] option:selected').text();
				var no_label_aktif=response.no_label;
				//alert(no_label_aktif);
				//alert(nama_elemen);
				//alert(form_elemen);
				tb_remove();
				$('#Val'+no_label_aktif).empty();
				$('#addValSource1').hide();
				$('#addValSource2').append(("<a href='javascript: delete_source();' class='delete_source'>X</a>&nbsp;<input type='hidden' name='ID_Elemen' id='ID_Elemen' value='")+response.IDElemen+("'/><input type='hidden' name='Nama_Elemen' id='Nama_Elemen' value='")+nama_elemen+("'/><input type='hidden' name='Form_Elemen' id='Form_Elemen' value='")+form_elemen+("'/>Source Form :<br/>")+form_elemen+(" => ")+nama_elemen);
            },
            dataType: 'json' // menandakan bahwa ajax menginginkan respon berupa json
        });
		}
        return false;
    }
    function delete_source(){
		if(confirm('Are you sure to delete this source? Source deletion will delete all related records.')==true){

			$('#addValSource1').show();
			$('#addValSource2').empty();
		}
    }

        //delete form
		function delete_form_semua(IDform){
            if(confirm('Are you sure to delete this form?')==true){

					//return false;     
					
					

        var dataString = 'form_id='+IDform+'&action=4'; //action=4 delete form dan segala atributnya

        $.ajax({
            type: 'post',
            url: 'menus//fusion_proses.php',
            data: dataString,
            beforeSend: function(){},
            success: function(){
                $("div #column").fadeOut(200,function(){
                    //$('#label-'+temp).remove();
                    //$('#main_content').empty;
                    //Location:'menus//form_add.php';
					$("div #judul_form").empty();
					$("div #judul_form").append(("<div style='float:left;'>Step 1: Nama Form</div><div style='float:right;'></div><div class='clear'></div>"));
					$("div #keterangan_form").empty();
					$("div #keterangan_form").append(("Masukkan nama form yang akan dibuat."));
                    $('#input_form').html("Nama Form:<br/><form id='inputForm' action='menus//fusion_proses.php' method='POST' onSubmit='return submitForm();' style='width:250px'><input type='hidden' name='action' id='action' value='3'/><input type='text' name='form_name' id='form_name'/><br/><button id='button_aja' class='button_aja' type='submit'>Save</button></form>");
                    $('#report_set').hide();
                });
            }
        });
		}
		}
		
	//SIMPAN FORM BARU GAYA TOPSINDO OK...
function submitForm(){

        $('#inputForm').ajaxSubmit({
           
            success: function(response) {
                var IDform = response.IDform;
                var NAMAform = response.NAMAform;

				$("div #judul_form").empty();
				$("div #judul_form").append(("<div style='float:left;'>Step 2: Form Component</div><div style='float:right;'></div><div class='clear'></div>"));
				$("div #keterangan_form").empty();
				$("div #keterangan_form").append(("Please add form component that you want. <br/><font color='red'>Warning: All deletion will delete all related records.<font>"));
                $('#input_form').html("<table width='800' border='0'><tr><td style='float:left;width:200px'><div class='submenu_header'>Form Component</div><div class='submenu_list'><a href='javascript: addTF(1,"+IDform+");' id='post_id1' class='addTF'><b style='font-family:Arial;font-size:10px;'>Text Field</b></a></div><div class='submenu_list'><a href='javascript: addTF(3,"+IDform+");' id='post_id3' class='addTF'><b style='font-family:Arial;font-size:10px;'>Drop Down List</b></a></div><div class='submenu_list'><a href='javascript: addTF(5,"+IDform+");' id='post_id5' class='addTF'><b style='font-family:Arial;font-size:10px;'>Radio Button</b></a></div><div class='submenu_list'><a href='javascript: addTF(2,"+IDform+");' id='post_id5' class='addTF'><b style='font-family:Arial;font-size:10px;'>Checkbox</b></a></div><div class='submenu_list'><a href='javascript: addTF(7,"+IDform+");' id='post_id7' class='addTF'><b style='font-family:Arial;font-size:10px;'>Label/Text</b></a></div><div class='submenu_list' id='img' style='display:none;'><a href='javascript: addTF(8,"+IDform+");' id='post_id8' class='addTF'><b style='font-family:Arial;font-size:10px;'>Camera Photo</b></a></div><div class='submenu_list' id='gps' style='display:none;'><a href='javascript: addTF(9,"+IDform+");' id='post_id9' class='addTF'><b style='font-family:Arial;font-size:10px;'>GPS Location</b></a></div><div class='submenu_list' id='barcode' style='display:none;'><a href='javascript: addTF(10,"+IDform+");' id='post_id10' class='addTF'><b style='font-family:Arial;font-size:10px;'>Barcode</b></a></div><div class='submenu_list' id='date' ><a href='javascript: addTF(11,"+IDform+");' id='post_id11' class='addTF'><b style='font-family:Arial;font-size:10px;'>Date</b></a></div><div class='submenu_list' id='luas_area' style='display:none;'><a href='javascript: addTF(12,"+IDform+");' id='post_id12' class='addTF'><b style='font-family:Arial;font-size:10px;'>Area Measurement</b></a></div><div class='submenu_list' id='Dspeed' style='display:none;'><a href='javascript: addTF(13,"+IDform+");' id='post_id13' class='addTF'><b style='font-family:Arial;font-size:10px;'>Download Speed</b></a></div><div class='submenu_list' id='Uspeed' style='display:none;'><a href='javascript: addTF(14,"+IDform+");' id='post_id14' class='addTF'><b style='font-family:Arial;font-size:10px;'>Upload Speed</b></a></div></td><td style='float:left;width:280px;padding:5px;'><div id='column' class='column ui-sortable' unselectable='on' style='-moz-user-select: none;'></div><div style='float:right;'></div></td><td style='float:left;width:280px;padding:5px;'><div id='input_komponen_form'></div></td></tr></table>");
				
				//<div class='submenu_list'><a href='javascript: addTF(10,"+IDform+");' id='post_id10' class='addTF'><b style='font-family:Arial;font-size:10px;'>Barcode</b></a></div>
				
				<? //cek fiturnya pake elm_type img ga
					$et_img=$db->Query("select id from fit_client where client_id IN (select client_id from users where id='$user_id') and fitur_id IN (select id from fitur where elm_type='img' and status='1') and pending='0'");
					 if(count($et_img)>0){
				?>
					$('#img').show();
				<?	}?>
				<? //cek fiturnya pake elm_type gps ga
					$et_gps=$db->Query("select id from fit_client where client_id IN (select client_id from users where id='$user_id') and fitur_id IN (select id from fitur where elm_type='gps' and status='1') and pending='0'");
					 if(count($et_gps)>0){
				?>
					$('#gps').show();
				<?	}?>
				<? //cek fiturnya pake elm_type barcode ga
					$et_bc=$db->Query("select id from fit_client where client_id IN (select client_id from users where id='$user_id') and fitur_id IN (select id from fitur where elm_type='barcode' and status='1') and pending='0'");
					 if(count($et_bc)>0){
				?>
					$('#barcode').show();
				<?	}?>
				<? //cek fiturnya pake elm_type luas ga
					$et_area=$db->Query("select id from fit_client where client_id IN (select client_id from users where id='$user_id') and fitur_id IN (select id from fitur where elm_type='luas' and status='1') and pending='0'");
					 if(count($et_area)>0){
				?>
					$('#luas_area').show();
				<?	}?>
				<? //cek fiturnya pake elm_type speed ga
					$et_area=$db->Query("select id from fit_client where client_id IN (select client_id from users where id='$user_id') and fitur_id IN (select id from fitur where elm_type='speed' and status='1') and pending='0'");
					 if(count($et_area)>0){
				?>
					$('#Dspeed').show();
					$('#Uspeed').show();
				<?	}?>		
                $('#report_set').show();
                $('#column').append("<center><b>------------------ PREVIEW FORM ------------------</b><br/><a href='javascript: delete_form_semua("+IDform+");' id='IDform-"+IDform+"' class='delete_form_semua'>X</a>&nbsp;"+NAMAform+"</center><br/>");

            }
            ,
            dataType: 'json'
        });
        return false;
    //});
	}

    var no_value=<?=$no_value;?>;
	//alert(no_value);
    var no_label=<?=$no_label;?>;
	//alert(no_label);

//add value,ID1=getpid,ID2=no_label
function addVal(ID1,ID2){
    //getpID=2 -- checkbox
    if(ID1 == 2){
        $("#Val"+ID2).append(("<div align='left' class='form_component_value' id='Nilai-")+no_value+("'>* Value: <input type='text' name='elm_value")+ID2+("-")+no_value+("' id='elm_value")+ID2+("-")+no_value+("' />&nbsp;<a href='javascript: val_delete("+no_value+");' class='val_delete'>Delete Value</a></div><div id='novalue")+ID2+("'></div>"));
        $("div #novalue"+ID2).empty();
        $("div #novalue"+ID2).append(("<input type='hidden' name='no_value")+ID2+("' id='no_value")+ID2+("' value='")+no_value+("' />"));        
    }

    //getpID=3--selection menu
    else if(ID1 == 3){
        $("#Val"+ID2).append(("<div align='left' class='form_component_value' id='Nilai-")+no_value+("'>* Value: <input type='text' name='elm_value")+ID2+("-")+no_value+("' id='elm_value")+ID2+("-")+no_value+("' />&nbsp;<a href='javascript: val_delete("+no_value+");' class='val_delete'>Delete Value</a></div><div id='novalue")+ID2+("'></div>"));
        $("div #novalue"+ID2).empty();
        $("div #novalue"+ID2).append(("<input type='hidden' name='no_value")+ID2+("' id='no_value")+ID2+("' value='")+no_value+("' />"));
    }

    //getpID=5--radio button
    else if(ID1 == 5){
        $("#Val"+ID2).append(("<div align='left' class='form_component_value' id='Nilai-")+no_value+("'>* Value: <input type='text' name='elm_value")+ID2+("-")+no_value+("' id='elm_value")+ID2+("-")+no_value+("' />&nbsp;<a href='javascript: val_delete("+no_value+");' class='val_delete'>Delete Value</a></div><div id='novalue")+ID2+("'></div>"));
        $("div #novalue"+ID2).empty();
        $("div #novalue"+ID2).append(("<input type='hidden' name='no_value")+ID2+("' id='no_value")+ID2+("' value='")+no_value+("' />"));
    }

    no_value++;
}


//showCommentBox
function addTF(getpID,IDform){
    //getpID=1 -- textfield
    if (getpID == 1){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Text Field</b><br/>Label:<br/><input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><br /><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("' /><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='text' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }

    //getpID=2 -- checkbox
    else if(getpID == 2){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Checkbox</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='checkbox' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'></div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
		tb_init('.form_component a.thickbox');
    }

    //getpID=3-- selection menu/drop down
    else if(getpID == 3){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Drop Down List</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='selectionmenu' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal' ><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'></div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Save Component</button><br/></div>"));
        tb_init('.form_component a.thickbox');
    }
        
    //getpID=5-- radio button
    else if(getpID == 5){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Radio Button</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("' /><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='radiobutton' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'></div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Save Component</button><br/></div>"));
		tb_init('.form_component a.thickbox');

    }
    
    //getpID=7 -- text label
    else if (getpID == 7){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Label/Text</b><br/><input type='hidden' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='label'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='label")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='label")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/>Value:<br/><textarea rows='2' cols='35' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("' wrap='virtual'></textarea><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='label' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }

    //getpID=8 -- camera
    else if (getpID == 8){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Camera Photo</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='uploadedfile' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='uploadedfile' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='img' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }

    //getpID=9 -- gps
    else if (getpID == 9){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>GPS Location</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='gps' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='gps' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='gps' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }

    //getpID=10 -- barcode
    else if (getpID == 10){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Barcode</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='barcode' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='barcode' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='barcode' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }
	//getpID=11 -- date
    else if (getpID == 11){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Date</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='date' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='date' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='date' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }
    //getpID=12 -- luas
    else if (getpID == 12){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Area Measurement</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='luas' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='luas' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='luas' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }
//getpID=13-- Dspeed
    else if (getpID == 13){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Download Speed</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='Download Speed'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='downspeed' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='downspeed' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='downspeed' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }
    //getpID=14-- Uspeed
    else if (getpID == 14){
        $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Upload Speed</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='Upload Speed'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='upspeed' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='upspeed' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='upspeed' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
    }
    no_label++;
}	
	    //showCommentBox
    function edit_form(no_label,getpID,IDelm_edit,IDform,elm_label_edit,elm_max_edit,IDsource_edit){
		//alert(no_label);								
        //getpID=1 -- textfield
        if (getpID == 1){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Text Field</b><br/>Label:<br/><input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><br /><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("' value='"+elm_max_edit+"'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='text' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));

        }
        //getpID=2 -- checkbox
        else if(getpID == 2){
			$.getJSON(
				'menus/content/get_value.php',
				{id_elm_edit: IDelm_edit, id_source_edit: IDsource_edit, no_label_edit: no_label},
				function(response){
					//$('#data').text("..loadong..");
					//$("#Val"+no_label).html(response);
					//alert(response);

					var getRespon=response.kode;
					var no_label=response.no_label;
								//alert(no_label);
					//alert(getRespon);
					if((IDsource_edit == 0)||(IDsource_edit == -1)){
					$("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Checkbox</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='")+elm_label_edit+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='checkbox' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'>")+getRespon+("</div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));	
					
					}
					else{
					$("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Checkbox</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='")+elm_label_edit+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='checkbox' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1' style='display:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'>")+("</div><div id='addValSource2'>")+getRespon+("</div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Save Component</button><br/></div>"));
					}
					        tb_init('.form_component a.thickbox');

							

				}

			);

        }

        //getpID=3-- selection menu/drop down
        else if(getpID == 3){
			//alert(no_label);
			$.getJSON(
				'menus/content/get_value.php',
				{id_elm_edit: IDelm_edit, id_source_edit: IDsource_edit, no_label_edit: no_label},
				function(response){
					//$('#data').text("..loadong..");
					//$("#Val"+no_label).html(response);
					//alert(response);

					var getRespon=response.kode;
					var no_label=response.no_label;
								//alert(no_label);
					//alert(getRespon);
					if((IDsource_edit == 0)||(IDsource_edit == -1)){			
					$("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Drop Down List</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='")+elm_label_edit+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='selectionmenu' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'>")+getRespon+("</div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Save Component</button><br/></div>"));
					}
					else{
					$("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Drop Down List</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='")+elm_label_edit+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='selectionmenu' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1' style='display:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'>")+("</div><div id='addValSource2'>")+getRespon+("</div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Save Component</button><br/></div>"));
					}
					        tb_init('.form_component a.thickbox');

							

				}

			);


			
        }
        //getpID=5-- radio button
        else if(getpID == 5){
/*             $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Radio Button</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("' /><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='radiobutton' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' />&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a><div id='Val")+no_label+("'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Simpan Komponen</button><br/></div>")); */
			
			$.getJSON(
				'menus/content/get_value.php',
				{id_elm_edit: IDelm_edit, id_source_edit: IDsource_edit, no_label_edit: no_label},
				function(response){
					//$('#data').text("..loadong..");
					//$("#Val"+no_label).html(response);
					//alert(response);

					var getRespon=response.kode;
					var no_label=response.no_label;
								//alert(no_label);
					//alert(getRespon);
					if((IDsource_edit == 0)||(IDsource_edit == -1)){
					$("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Radio Button</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='")+elm_label_edit+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='radiobutton' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'>")+getRespon+("</div><div id='addValSource2'></div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));	
					
					}
					else{
					$("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Radio Button</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='")+elm_label_edit+("'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='elm")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("' /><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='radiobutton' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><div id='addValSource1' style='display:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript: addVal(")+getpID+(",")+no_label+(");' id='post_idv")+getpID+("-")+no_label+("' class='addVal'><b style='font-family:Arial;font-size:10px;'>Add Value</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='menus/content/tes.php?form_id=")+IDform+("&no_label=")+no_label+("&width=230&height=185' id='post_idv")+getpID+("-")+no_label+("' class='addSource thickbox'><b style='font-family:Arial;font-size:10px;'>Add Source</b></a></div><div id='Val")+no_label+("'>")+("</div><div id='addValSource2'>")+getRespon+("</div><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit'  >Save Component</button><br/></div>"));
					}
					        tb_init('.form_component a.thickbox');

							

				}

			);
       } 
        //getpID=7 -- text label
        else if (getpID == 7){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Label/Text</b><br/><input type='hidden' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='label'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='label")+no_label+("' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='label")+no_label+("' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/>Value:<br/><textarea rows='2' cols='35' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("' wrap='virtual'>"+elm_label_edit+"</textarea><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='label' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }

        //getpID=8 -- camera
        else if (getpID == 8){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Camera Photo</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><br /><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='uploadedfile' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='uploadedfile' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='img' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }

        //getpID=9 -- gps
        else if (getpID == 9){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>GPS Location</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='gps' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='gps' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='gps' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }
		
        //getpID=10 -- barcode
        else if (getpID == 10){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Barcode</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='barcode' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='barcode' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='barcode' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }
		
        //getpID=11 -- date
        else if (getpID == 11){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Date</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='date' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='date' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='date' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }	
        //getpID=12 -- luas
        else if (getpID == 12){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Area Measurement</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='luas' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='luas' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='luas' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }
		//getpID=13 -- Dspeed
        else if (getpID == 13){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Download Speed</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='downspeed' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='downspeed' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='downspeed' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }
        //getpID=14 -- Uspeed
        else if (getpID == 14){
            $("div#input_komponen_form").html(("<div align='left' class='form_component' id='label-")+no_label+("'><form onSubmit='return button_form_edit("+no_label+")' method='post'><input type='hidden' name='form_id' id='form_id' value='"+IDform+"' /><b>Upload Speed</b><br/>Label: <input type='text' name='elm_label")+no_label+("' id='elm_label")+no_label+("' value='"+elm_label_edit+"'/><input type='hidden' name='elm_name")+no_label+("' id='elm_name")+no_label+("' value='upspeed' /><input type='hidden' name='elm_id")+no_label+("' id='elm_id")+no_label+("' value='upspeed' /><input type='hidden' name='elm_max")+no_label+("' id='elm_max")+no_label+("'/><input type='hidden' name='elm_size")+no_label+("' id='elm_size")+no_label+("'/><input type='hidden' name='elm_value")+no_label+("-")+0+("' id='elm_value")+no_label+("-")+0+("'/><input type='hidden' name='elm_type")+no_label+("' id='elm_type")+no_label+("' value='upspeed' /><input type='hidden' id='getpID' name='getpID' value='")+getpID+("' /><input type='hidden' name='no_value")+no_label+("' id='no_value")+no_label+("' value='0' /><input type='hidden' name='no_label' id='no_label' value='")+no_label+("' /><input type='hidden' id='IDelm_edit' name='IDelm_edit' value='")+IDelm_edit+("' /><input type='hidden' id='IDsource_edit' name='IDsource_edit' value='")+IDsource_edit+("' /><br/><button id='button_form"+no_label+"' class='button_form"+no_label+"' type='submit' >Save Component</button><br/></div>"));
        }		
        no_label++;

    }

	function button_form_edit(no_label){    
            // validate and process form here
			var IDelm_edit=$("input#IDelm_edit").val();
			var IDsource_edit=$("input#IDsource_edit").val();

            var form_id=$("input#form_id").val();
            //alert('form_id='+form_id);

            var getpID=$("input#getpID").val();
			//var getpID=getpID;
            //alert('getpID='+getpID);

            var no_label=$("input#no_label").val();
			//var no_label=no_label;
            //alert('no_label='+no_label);
			
			
            var no_value=$("input#no_value"+no_label).val();
			//alert('no_value='+no_value);

            var elm_label=$("input#elm_label"+no_label).val();
            //alert('elm_label='+elm_label);
            //var elm_label = $("input#elm_label"+no_label).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');

            var elm_name=$("input#elm_name"+no_label).val();
            //alert('elm_name='+elm_name);

            var elm_id=$("input#elm_id"+no_label).val();
            //alert('elm_id='+elm_id);
			var id_elemen=$("input#ID_Elemen").val();
			var nama_elemen=$("input#Nama_Elemen").val();
			var form_elemen=$("input#Form_Elemen").val();
			
            var elm_max=$("input#elm_max"+no_label).val();
            if(elm_max==""){ $elm_max=0;}
            //alert('elm_max='+elm_max);

            var elm_size=$("input#elm_size"+no_label).val();
            if(elm_size==""){ $elm_size=0;}
            //alert('elm_size='+elm_size);

            var elm_type=$("input#elm_type"+no_label).val();
            //alert('elm_type='+elm_type);

            /*if(elm_type=='text'){
                        var elm_value=$("input#elm_value"+no_label+"-"+no_value).val();
                }
                else if(elm_type=='selectionmenu'){
                        for(j=0;j<=no_value;j++) {
                                var elm_value=$("input#elm_value"+no_label+"-"+no_value).val();
                //alert('elm_value='+elm_value);
                        }
                }*/


			//1:TF,8:CAM,9:GPS,10:barcode,11:date,12:luas
            if(getpID==1||getpID==8||getpID==9||getpID==10||getpID==11||getpID==12||getpID==13||getpID==14){  //getpID==6||
                var elm_value=$("input#elm_value"+no_label+"-"+no_value).val();
                //var elm_value = $("input#elm_value"+no_label+"-"+no_value).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                //var elm_value = $("input#elm_value"+no_label+"-"+no_value).val().replace(/<|>/g,' ').replace(/\n/g,'[br]').replace(/&/g,"&amp;").replace(/'/g,"&acute;").replace(/"/g,"&quot;");
                var x = "elm_value"+no_label+"-"+no_value;
                var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&'+x+'='+elm_value+'&elm_type='+elm_type+'&IDelm_edit='+IDelm_edit+'&IDsource_edit='+IDsource_edit+'&action=7'; //action=1 tambah ke DB
            }
			//7:LBL
            else if(getpID==7){
				var elm_value=$("textarea#elm_value"+no_label+"-"+no_value).val();
                //var elm_value=$("textarea#elm_value"+no_label+"-"+no_value).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                var x = "elm_value"+no_label+"-"+no_value;
                var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&'+x+'='+elm_value+'&elm_type='+elm_type+'&IDelm_edit='+IDelm_edit+'&IDsource_edit='+IDsource_edit+'&action=7'; //action=1 tambah ke DB
            }
			//2:CB
			else if(getpID==2){

                var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&elm_type='+elm_type+'&IDelm_edit='+IDelm_edit+'&IDsource_edit='+IDsource_edit+'&action=7&id_elemen='+id_elemen+'&nama_elemen='+nama_elemen+'&form_elemen='+form_elemen;
				//alert('cantik1');
				//action=1 tambah ke DB
                var elmv = '';
				//alert(no_value);
				//alert('cantik_val1');
				//alert(no_label);

                for(k=0;k<=no_value;k++) {
					var elm_value=$("input#elm_value"+no_label+"-"+k).val();
					var id_val=$("input#id_val"+no_label+"-"+k).val();
					//alert('elmval'+elm_value);
					//var elm_value=elm_value2.replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                    //var elm_value=$("input#elm_value"+no_label+"-"+j).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                    elmv += elm_value+'&nbsp;';
                    dataString += "&elm_value"+no_label+"-"+k+"="+elm_value+"&id_val"+no_label+"-"+k+"="+id_val;
                }
				//alert('cantik2');
            }
			//3:DD
            else if(getpID==3){

                var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&elm_type='+elm_type+'&IDelm_edit='+IDelm_edit+'&IDsource_edit='+IDsource_edit+'&action=7&id_elemen='+id_elemen+'&nama_elemen='+nama_elemen+'&form_elemen='+form_elemen;
				//alert('cantik1');
				//action=1 tambah ke DB
                var elmv = '';
				//alert(no_value);
				//alert('cantik_val1');
				//alert(no_label);

                for(j=0;j<=no_value;j++) {
					var elm_value=$("input#elm_value"+no_label+"-"+j).val();
					var id_val=$("input#id_val"+no_label+"-"+j).val();

					//alert('elmval'+elm_value);
					//var elm_value=elm_value2.replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                    //var elm_value=$("input#elm_value"+no_label+"-"+j).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                    elmv += elm_value+'&nbsp;';
                    dataString += "&elm_value"+no_label+"-"+j+"="+elm_value+"&id_val"+no_label+"-"+j+"="+id_val;

                }
				//alert('cantik2');
            }
			//5:RB
			else if(getpID==5){

                var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&elm_type='+elm_type+'&IDelm_edit='+IDelm_edit+'&IDsource_edit='+IDsource_edit+'&action=7&id_elemen='+id_elemen+'&nama_elemen='+nama_elemen+'&form_elemen='+form_elemen; 
				//alert('cantik1');
				//action=1 tambah ke DB
				
                var elmv = '';
				//alert(no_value);
				//alert('cantik_val1');
				//alert(no_label);

                for(r=0;r<=no_value;r++) {
					var elm_value=$("input#elm_value"+no_label+"-"+r).val();
					var id_val=$("input#id_val"+no_label+"-"+r).val();

					//alert('elmval'+elm_value);
					//var elm_value=elm_value2.replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                    //var elm_value=$("input#elm_value"+no_label+"-"+j).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
                    elmv += elm_value+'&nbsp;';
                    dataString += "&elm_value"+no_label+"-"+r+"="+elm_value+"&id_val"+no_label+"-"+r+"="+id_val;
                }
				//alert('cantik2');
            }
            //alert(dataString);
            if(elm_max>0){
                var max = " maxLength='"+elm_max+"'";
            }
			else{
				var max = "";
			}
			
			if(elm_size>0){
                var size = " size='"+elm_size+"'";
            }
			else{
				var size = "";
			}

            //alert(dataString);
            $.ajax({
                type: "POST",
                url: "menus//fusion_proses.php",
                data: dataString,
                success: function(response) {
                    var IDelm = response.IDelm;
					var IDsource = response.IDsource;
					if(IDsource!=0){
						IDsource_edit=IDsource;
					}
                    var Tipe = response.Tipe;
					var NamaElemen = response.NamaElemen;
					var FormElemen = response.FormElemen;
                    //alert(Tipe);
                    //alert("nolab"+no_label);
                    //alert("noval"+no_value);
                    if(IDelm==0 && Tipe=='img'){
                        alert('Only one input with type camera is allowed in the form. To replace with the new camera input, delete the old camera input first in the form.');
                        //alert('img');
                    }
                    else if(IDelm==0 && Tipe=='gps'){
                        alert('Only one input with type GPS-location is allowed in the form. If you already using input with type Area Measurement, you can not add input with type GPS-location. To replace with the new GPS-location input, delete the old GPS-location input or Area Measurement input first in the form.');
                        //alert('gps');
                    }
                    else if(IDelm==0 && Tipe=='barcode'){
                        alert('Only one input with type barcode is allowed in the form. To replace with the new barcode input, delete the old barcode input first in the form.');
                        //alert('gps');
                    }
                    else if(IDelm==0 && Tipe=='luas'){
                        alert('Only one input with type Area Measurement is allowed in the form. If you already using input with type GPS-location, you can not add input with type Area Measurement. To replace with the new Area Measurement input, delete the old Area Measurement input or GPS-location input first in the form.');
                        //alert('gps');
                    }
					else if(IDelm==0 && Tipe=='upspeed'){
						alert('Only one input with type Upload Speed is allowed in the form. To replace with the new Upload Speed input, delete the old Upload Speed input first in the form.');
					}
					else if(IDelm==0 && Tipe=='downspeed'){
						alert('Only one input with type Download Speed is allowed in the form. To replace with the new Download Speed input, delete the old Download Speed input first in the form.');
					}					
                    else if(IDelm!=0){
                        $('#label-'+no_label).remove();
                        //$('#preview_form').append('<div id="message'+no_label+'"></div>');
						
						//1:TF
                        if(getpID==1){
                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",1,"+IDelm+","+form_id+",\""+elm_label+"\","+elm_max+",0);'>Edit</a>&nbsp;"+elm_label+" : <br/><input type='text' name='"+elm_name+"' id='"+elm_id+"'"+max+size+" value='"+elm_value+"'/><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//2:CB
						else if(getpID==2){
                            //alert("oke deh"+no_label);
							//alert('cantik3');

                            var skrip = "<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",2,"+IDelm+","+form_id+",\""+elm_label+"\",0,"+IDsource+");'>Edit</a>&nbsp;"+elm_label+" : <br/>";
							if(IDsource==0){
								var longstring=elmv;
							//alert(longstring);
							//alert(no_value);
                            //alert(longstring);
                            var brokenstring=longstring.split("&nbsp;");
                            for(k=0;k<=no_value;k++) {
                                //var elm_value=$("input#elm_value"+no_label+"-"+k).val();

                                var elmval=brokenstring[k]; //id jenis input
                                //var ID2=brokenstring[1]; //id label input
                                if(elmval=='undefined'){
                                    continue;
                                }
								
                                skrip += "<input type='checkbox' name="+elm_name+" id="+elm_id+" value="+elmval+">"+elmval+"<br/>";
                            }
							}
							else{
								skrip += "<input type='checkbox' name='"+elm_name+"' id='"+elm_id+"' value='source'>Source<br/>";
						skrip += "Source:"+NamaElemen+" from "+FormElemen;
							}
                            skrip += "<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/></h2>";
                            //alert(skrip);
                            $('#message'+no_label).html(skrip);
											//alert('cantik4');

                        }
						//3:DD
                        else if(getpID==3){
                            //alert("oke deh"+no_label);
							//alert('cantik3');

                            var skrip = "<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",3,"+IDelm+","+form_id+",\""+elm_label+"\",0,"+IDsource+");'>Edit</a>&nbsp;"+elm_label+" : <br/><select name="+elm_name+" id="+elm_id+">";
							if(IDsource==0){
								var longstring=elmv;
								//alert(longstring);
								//alert(no_value);

								var brokenstring=longstring.split("&nbsp;");
								for(k=0;k<=no_value;k++) {
									//var elm_value=$("input#elm_value"+no_label+"-"+k).val();

									var elmval=brokenstring[k]; //id jenis input
									//var ID2=brokenstring[1]; //id label input
									if(elmval=='undefined'){
										continue;
									}
									skrip += "<option value="+elmval+">"+elmval+"</option>";
								}
							}
							else{
								skrip += "<option></option>";
							}
                            skrip += "</select>";
							//alert(IDsource);
							if(IDsource!=0){
								skrip += "<br/>Source:"+NamaElemen+" from "+FormElemen;
							}
							skrip += "<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>";
                            //alert(skrip);
                            $('#message'+no_label).html(skrip);
											//alert('cantik4');

                        }
						//5:RB
						else if(getpID==5){
                            //alert("oke deh"+no_label);
							//alert('cantik3');

                            var skrip = "<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",5,"+IDelm+","+form_id+",\""+elm_label+"\",0,"+IDsource+");'>Edit</a>&nbsp;"+elm_label+" : <br/>";
							if(IDsource==0){
                            var longstring=elmv;
							//alert(longstring);
							//alert(no_value);
                            //alert(longstring);
                            var brokenstring=longstring.split("&nbsp;");
                            for(k=0;k<=no_value;k++) {
                                //var elm_value=$("input#elm_value"+no_label+"-"+k).val();

                                var elmval=brokenstring[k]; //id jenis input
                                //var ID2=brokenstring[1]; //id label input
                                if(elmval=='undefined'){
                                    continue;
                                }
								
                                skrip += "<input type='radio' name="+elm_name+" id="+elm_id+" value="+elmval+">"+elmval+"<br/>";
                            }
							}
							else{
								skrip += "<input type='radio' name='"+elm_name+"' id='"+elm_id+"' value='source'>Source<br/>";
								skrip += "Source:"+NamaElemen+" from "+FormElemen;
							}
                            skrip += "<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/></h2>";
                            //alert(skrip);
                            $('#message'+no_label).html(skrip);
											//alert('cantik4');

                        }
						//6:
/*                         else if(getpID==6){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;"+elm_label+" : <br/><input type='file' name='"+elm_name+"' id='"+elm_id+"'"+max+size+" value='"+elm_value+"'/><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/>");
                        } */
						//7:LBL
                        else if(getpID==7){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",7,"+IDelm+","+form_id+",\""+elm_value+"\",0,0);'>Edit</a>&nbsp;"+elm_value+"<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//8:CAM
                        else if(getpID==8){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",8,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='media://cam' onclick='return false'>"+elm_label+"</a><input type='hidden' name='"+elm_name+"' id='"+elm_id+"'/><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//9:GPS
                        else if(getpID==9){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",9,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='loc://gps' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//10:Barcode
                        else if(getpID==10){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",10,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='barcode://' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//11:Date
                        else if(getpID==11){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",11,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='date://' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//12:Luas
                        else if(getpID==12){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",12,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='luas://' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//13:Dspeed
                        else if(getpID==13){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",13,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;"+elm_label+"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Start' onClick='return false' class='submit_ct'><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }
						//14:Dspeed
                        else if(getpID==14){
                            //alert("oke deh"+no_label);

                            $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",14,"+IDelm+","+form_id+",\""+elm_label+"\",0,0);'>Edit</a>&nbsp;"+elm_label+"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Start' onClick='return false' class='submit_ct'><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                        }						
					}
                }
                ,
                dataType: 'json'
            });
            return false;


        //});
		}
		
function button_form(no_label){
    var form_id=$("input#form_id").val();
    var getpID=$("input#getpID").val();
    var no_label=$("input#no_label").val();
    var no_value=$("input#no_value"+no_label).val();
    var elm_label=$("input#elm_label"+no_label).val();
    var elm_name=$("input#elm_name"+no_label).val();
    var elm_id=$("input#elm_id"+no_label).val();
    var elm_max=$("input#elm_max"+no_label).val();
	var id_elemen=$("input#ID_Elemen").val();
	var nama_elemen=$("input#Nama_Elemen").val();
	var form_elemen=$("input#Form_Elemen").val();	
    if(elm_max==""){
        $elm_max=0;
    }

    var elm_size=$("input#elm_size"+no_label).val();

    if(elm_size==""){
        $elm_size=0;
    }

    var elm_type=$("input#elm_type"+no_label).val();

    //1:input text, 8:camera, 9:gps,10:barcode,11:date,12:luas
    if(getpID==1||getpID==8||getpID==9||getpID==10||getpID==11||getpID==12||getpID==13||getpID==14){
        var elm_value=$("input#elm_value"+no_label+"-"+no_value).val();
        //var elm_value = $("input#elm_value"+no_label+"-"+no_value).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
        //var elm_value = $("input#elm_value"+no_label+"-"+no_value).val().replace(/<|>/g,' ').replace(/\n/g,'[br]').replace(/&/g,"&amp;").replace(/'/g,"&acute;").replace(/"/g,"&quot;");
        var x = "elm_value"+no_label+"-"+no_value;
        var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&'+x+'='+elm_value+'&elm_type='+elm_type+'&action=1'; //action=1 tambah ke DB
    }

    //label teks
    else if(getpID==7){
        var elm_value=$("textarea#elm_value"+no_label+"-"+no_value).val();
        //var elm_value=$("textarea#elm_value"+no_label+"-"+no_value).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
        var x = "elm_value"+no_label+"-"+no_value;
        var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&'+x+'='+elm_value+'&elm_type='+elm_type+'&action=1'; //action=1 tambah ke DB
    }

    //checkbox
    else if(getpID==2){
        var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&elm_type='+elm_type+'&action=1&id_elemen='+id_elemen+'&nama_elemen='+nama_elemen+'&form_elemen='+form_elemen;
        //action=1 tambah ke DB
        var elmv = '';

        for(k=0;k<=no_value;k++) {
            var elm_value=$("input#elm_value"+no_label+"-"+k).val();
            //var elm_value=elm_value2.replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
            //var elm_value=$("input#elm_value"+no_label+"-"+j).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
            elmv += elm_value+'&nbsp;';
            dataString += "&elm_value"+no_label+"-"+k+"="+elm_value;
        }
    }

    //dropdown
    else if(getpID==3){
        var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&elm_type='+elm_type+'&action=1&id_elemen='+id_elemen+'&nama_elemen='+nama_elemen+'&form_elemen='+form_elemen;

        //action=1 tambah ke DB
        var elmv = '';

        for(j=0;j<=no_value;j++) {
            var elm_value=$("input#elm_value"+no_label+"-"+j).val();
            //var elm_value=elm_value2.replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
            //var elm_value=$("input#elm_value"+no_label+"-"+j).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
            elmv += elm_value+'&nbsp;';
            dataString += "&elm_value"+no_label+"-"+j+"="+elm_value;
        }
    }

    //radio button
    else if(getpID==5){
        var dataString = 'form_id='+form_id+'&no_label='+no_label+'&no_value='+no_value+'&elm_label='+elm_label+'&elm_name='+elm_name+'&elm_id='+elm_id+'&elm_max='+elm_max+'&elm_size='+elm_size+'&elm_type='+elm_type+'&action=1&id_elemen='+id_elemen+'&nama_elemen='+nama_elemen+'&form_elemen='+form_elemen;

        //action=1 tambah ke DB

        var elmv = '';

        for(r=0;r<=no_value;r++) {
            var elm_value=$("input#elm_value"+no_label+"-"+r).val();
            //var elm_value=elm_value2.replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
            //var elm_value=$("input#elm_value"+no_label+"-"+j).val().replace(/</g,'').replace(/>/g,'').replace(/\n/g,'').replace(/\r/g,'').replace(/\t/g,'').replace(/\b/g,'').replace(/\f/g,'').replace(/&/g,'').replace(/'/g,'').replace(/"/g,'');
            elmv += elm_value+'&nbsp;';
            dataString += "&elm_value"+no_label+"-"+r+"="+elm_value;
        }
    }

    if(elm_max>0){
        var max = " maxLength='"+elm_max+"'";
    }
    else{
        var max = "";
    }

    if(elm_size>0){
        var size = " size='"+elm_size+"'";
    }
    else{
        var size = "";
    }

    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "menus//fusion_proses.php",
        data: dataString,
        success: function(response) {
            var IDelm = response.IDelm;
			var IDsource = response.IDsource;
            var Tipe = response.Tipe;
			var NamaElemen = response.NamaElemen;
            var FormElemen = response.FormElemen;

            if(IDelm==0 && Tipe=='img'){
                alert('Only one input with type camera is allowed in the form. To replace with the new camera input, delete the old camera input first in the form.');
            }
            else if(IDelm==0 && Tipe=='gps'){
                alert('Only one input with type GPS-location is allowed in the form. If you already using input with type Area Measurement, you can not add input with type GPS-location. To replace with the new GPS-location input, delete the old GPS-location input or Area Measurement input first in the form.');
            }
            else if(IDelm==0 && Tipe=='barcode'){
                alert('Only one input with type barcode is allowed in the form. To replace with the new barcode input, delete the old barcode input first in the form.');
            }
            else if(IDelm==0 && Tipe=='luas'){
                alert('Only one input with type Area Measurement is allowed in the form. If you already using input with type GPS-location, you can not add input with type Area Measurement. To replace with the new Area Measurement input, delete the old Area Measurement input or GPS-location input first in the form.');
            }
            else if(IDelm==0 && Tipe=='upspeed'){
                alert('Only one input with type Upload Speed is allowed in the form. To replace with the new Upload Speed input, delete the old Upload Speed input first in the form.');
            }
            else if(IDelm==0 && Tipe=='downspeed'){
                alert('Only one input with type Download Speed is allowed in the form. To replace with the new Download Speed input, delete the old Download Speed input first in the form.');
            }			
            else if(IDelm!=0){
                $('#label-'+no_label).remove();
                $('#column').append('<div id="item'+IDelm+'" class="dragbox" ><div id="message'+no_label+'"></div></div>');
                if(getpID==1){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",1,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",\""+elm_max+"\",0);'>Edit</a>&nbsp;"+elm_label+" : <br/><input type='text' name='"+elm_name+"' id='"+elm_id+"' "+max+" "+size+" value='"+elm_value+"'/><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
                else if(getpID==2){
					//alert('checkbox');
                    var skrip = "<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",2,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,"+IDsource+");'>Edit</a>&nbsp;"+elm_label+" : <br/>";
					
					if(IDsource==0){

                    var longstring=elmv;
                    var brokenstring=longstring.split("&nbsp;");

                    for(k=0;k<=no_value;k++) {
                        var elmval=brokenstring[k]; //id jenis input
                        //var ID2=brokenstring[1]; //id label input
                        if(elmval=='undefined'){
                            continue;
                        }

                        skrip += "<input type='checkbox' name="+elm_name+" id="+elm_id+" value="+elmval+">"+elmval+"<br/>";
                    }
					}
					else{
						skrip += "<input type='checkbox' name='"+elm_name+"' id='"+elm_id+"' value='source'>Source<br/>";
						skrip += "Source:"+NamaElemen+" from "+FormElemen;
					}
/* 					if(IDsource!=0){
						skrip += "<br/>Source:"+NamaElemen+" from "+FormElemen;
					}   */                  
					skrip += "<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/></h2>";
                    $('#message'+no_label).html(skrip);
                }
                else if(getpID==3){
                    var skrip = "<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",3,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,"+IDsource+");'>Edit</a>&nbsp;"+elm_label+" : <br/><select name="+elm_name+" id="+elm_id+">";
                    if(IDsource==0){
						var longstring=elmv;

						var brokenstring=longstring.split("&nbsp;");
						for(k=0;k<=no_value;k++) {
							var elmval=brokenstring[k]; //id jenis input
							if(elmval=='undefined'){
								continue;
							}
							skrip += "<option value="+elmval+">"+elmval+"</option>";
						}
					}
					else{
						skrip += "<option></option>";
					}
                    skrip += "</select>";
					if(IDsource!=0){
						skrip += "<br/>Source:"+NamaElemen+" from "+FormElemen;
					}
					skrip += "<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>";
                    $('#message'+no_label).html(skrip);
                }
                else if(getpID==5){
                    var skrip = "<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",2,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,"+IDsource+");'>Edit</a>&nbsp;"+elm_label+" : <br/>";
					
					if(IDsource==0){
                    var longstring=elmv;
                    var brokenstring=longstring.split("&nbsp;");

                    for(k=0;k<=no_value;k++) {
                        var elmval=brokenstring[k]; //id jenis input

                        if(elmval=='undefined'){
                            continue;
                        }

                        skrip += "<input type='radio' name='"+elm_name+"' id='"+elm_id+"' value='"+elmval+"'>"+elmval+"<br/>";
                    }
					}
					else{
						skrip += "<input type='radio' name='"+elm_name+"' id='"+elm_id+"' value='source'>Source";
						skrip += "<br/>Source:"+NamaElemen+" from "+FormElemen;
					}
                    skrip += "<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/></h2>";

                    $('#message'+no_label).html(skrip);
                }
/*                 else if(getpID==6){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;"+elm_label+" : <br/><input type='file' name='"+elm_name+"' id='"+elm_id+"'"+max+size+" value='"+elm_value+"'/><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                } */
                else if(getpID==7){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",7,"+IDelm+",<?=$form_id;?>,\""+elm_value+"\",0,0);'>Edit</a>&nbsp;"+elm_value+"<input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
                else if(getpID==8){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",8,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='media://cam' onclick='return false'>"+elm_label+"</a><input type='hidden' name='"+elm_name+"' id='"+elm_id+"'/><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
                else if(getpID==9){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",9,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='loc://gps' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
                else if(getpID==10){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",10,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='barcode://' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
				else if(getpID==11){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+","+form_id+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",11,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='date://' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
                else if(getpID==12){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",12,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;<a href='luas://' onclick='return false'>"+elm_label+"</a><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }
                else if(getpID==13){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",13,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;"+elm_label+"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Start' onClick='return false' class='submit_ct'><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }	
                else if(getpID==14){
                    $('#message'+no_label).html("<h2><a href='javascript: delete_form("+no_label+","+IDelm+");' id='no_label-"+no_label+"' class='delete_form'>X</a>&nbsp;<a class='edit_form' id='edit_label-"+no_label+"' href='javascript: edit_form("+no_label+",14,"+IDelm+",<?=$form_id;?>,\""+elm_label+"\",0,0);'>Edit</a>&nbsp;"+elm_label+"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' value='Start' onClick='return false' class='submit_ct'><input type='hidden' name='IDelm' id='IDelm"+no_label+"' value='"+IDelm+"'/><br/></h2>");
                }					
			}
        }
        ,
        dataType: 'json'
    });
    return false;
}

//delete label
function delete_form(no_label,IDelm){
//alert(<?=$form_id;?>);
    if(confirm('Are you sure to delete this component? Component deletion will delete all related records.')==true){
        var dataString = 'IDelm='+IDelm+'&form_id='+<?=$form_id;?>+'&action=2'; //action=2 delete

        $.ajax({
            type: 'post',
            url: 'menus//fusion_proses.php',
            data: dataString,
            beforeSend: function(){},
            success: function(){
				$('div #item'+IDelm).remove();
/* 				$('div #item'+IDelm).fadeOut(200,function(){
                //$('div #message'+no_label).fadeOut(200,function(){
                    $('#label-'+no_label).remove();
                }); */
            }
        });
    } 
}

//delete value
function val_delete(no_value){
    if(confirm('Are you sure to delete this value?')==true){
        $('div #Nilai-'+no_value).fadeOut(200,function(){
                $('#Nilai-'+no_value).empty();
        });
    }
}

//delete value
function val_delete_edit(no_value,id_val_val,IDelm_edit){
    if(confirm('Are you sure to delete this value? Value deletion will delete all related records.')==true){
		    $.ajax({
            type: 'post',
            url: 'menus//fusion_proses.php',
            data: 'action=8&id_val_val='+id_val_val+'&IDelm_edit='+IDelm_edit,
            beforeSend: function(){},
            success: function(){
				$('div #Nilai-'+no_value).fadeOut(200,function(){
						$('#Nilai-'+no_value).empty();
				});
            }
        });

    }
}

</script>