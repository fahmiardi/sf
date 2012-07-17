$(function() {
	$(".klik").click(function()
	{
		var base  	= <?php echo base_url();?>;
		var nom 	= $("[name=nom]", 	$(this).parent().parent()).val();
		var kodemk 	= $("[name=kodemk]", 	$(this).parent().parent()).val();
		var namamk 	= $("[name=namamk]", 	$(this).parent().parent()).val();
		var bobot 	= $("[name=bobot]", 	$(this).parent().parent()).val();
		var dosen 	= $("[name=dosen]", 	$(this).parent().parent()).val();
		var hari 	= $("[name=hari]", 	$(this).parent().parent()).val();
		var jam 	= $("[name=jam]", 	$(this).parent().parent()).val();
		var kapasitas 	= $("[name=kapasitas]", $(this).parent().parent()).val();
		var semester 	= $("[name=semester]", 	$(this).parent().parent()).val();
		
		if(dosen == ''){
			alert("Dosen harus diisi" + nom);
		}else{
			$.ajax({
					type: "POST",
			  		url: base + "jadwal/saveData",
			   		data: $.param({
							nom		: nom,
							kodemk		: kodemk,
							namamk		: namamk,
							bobot		: bobot,
							dosen		: dosen,
							hari		: hari,
							jam		: jam,
							kapasitas	: kapasitas,
							semester	: semester
							}),
			   		dataType:'json',
			  		cache: false,
			  		success: function(out){
						
						$("tr#"+ nom).html('<td class="a-center" height=25>'+ out.nom +'<input type="hidden" name="nom" value="'+ out.nom +'" ></td>'+
									'<td><a href="#">'+ out.kodemk +'</a></td>'+
									'<td>'+    out.namamk    +'</td>'+
									'<td align=center>'+    out.bobot    +'</td>'+
									'<td>'+    out.dosen     +'</td>'+
									'<td>'+    out.hari      +'</td>'+
									'<td>'+    out.jam       +'</td>'+
									'<td>'+    out.kapasitas +'</td>'+
									'<td>'+    out.semester  +'</td>'+
									'<td align=center><img src="'+ base +'shell/admin_template/img/icons/page_white_edit.png"></a></td>'
								   );
			  			$("tr#"+ nom).fadeIn(2000);
					}
			 });
		}
	});
		
	$('.delete_update').live("click",function() 
	{
		var item = $(this);
		if(confirm("Are You Sure?"))
		{
			$.ajax({
				type: "POST",
			 	url: "delete_data.php",
			  	data: $.param({message_id:item.attr("del_id")}),
			 	cache: false,
			 	success: function(html){
			 		$("#row_"+item.attr("del_id")).slideUp('slow', function() {$(this).remove();});
			 	}
			});
		}
		return false;
	});
	
});