<style>
.t_judul{
        
        padding:12px;
        font-size:16px;
        font-weight:bold;
        margin-bottom: 10px;
        padding-bottom: 20px;
}

.t_header{
        background:#dddddd;
        vertical-align: middle;
        padding:3px;
        text-align: center;
        border: solid 1px;
        font-weight: bold;
}

.t_isi{
        vertical-align: middle;
        padding:3px;
        border: solid 1px;
        font-weight: bold;
}
</style>

<script>
$(document).ready(function() {
    
    $('.d_journey').click(function() {
        var sfa        = $(this).attr('sfa');
        var outlet     = $(this).attr('outlet');
        var tgl        = $(this).attr('tgl');
        var minggu      = $(this).attr('minggu');
        var nilai      = $(this).is(':checked');
        
        $.post(
            '<?=base_url()?>index.php/journey_cycle/saveJC_ds', 
            {sfa:sfa,outlet:outlet,tgl:tgl,minggu:minggu,nilai:nilai},
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
    
    $('.d_copy_journey').click(function() {
        var bulan        = $(this).attr('bulan');
        var tahun     = $(this).attr('tahun');
        var sfa        = $(this).attr('sfa');
        
        $.post(
            '<?=base_url()?>index.php/journey_cycle/copyJC', 
            {sfa:sfa,bulan:bulan,tahun:tahun},
            function(data) {
                if(data.status == 'OK') {
                    alert(data.pesan);
                }
            },
            "json"
        ).error(function() {
            alert("-");
        });
    });
    
});

function jump_url(targ,selObj,restore){ //v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}
</script>

<script>
		$(function(){
			$('#cc').combogrid({
				panelWidth:450,
				value:'006',

				idField:'id',
				textField:'name',
                                multiple:'true',
                                nowrap: false,
				striped: true,
                                frozenColumns:[[
	                {field:'ck',checkbox:true}
				]],
                                
				url:'<?=base_url()?>index.php/journey_cycle/agent_json',
				columns:[[
					{field:'id',title:'ID',width:60},
					{field:'name',title:'Agent',width:140},
					{field:'city',title:'City',width:120}
				]]
			});
		});
		function reload(){
			$('#cc').combogrid('grid').datagrid('reload');
		}
		function setValue(){
			$('#cc').combogrid('setValue', '002');
		}
		function getValue(){
			var val = $('#cc').combogrid('getValue');
			alert(val);
		}
		function disable(){
			$('#cc').combogrid('disable');
		}
		function enable(){
			$('#cc').combogrid('enable');
		}
	</script>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/gray/easyui.css">
                <link rel="stylesheet" type="text/css" href="<?=base_url()?>file/js/easyui/themes/icon.css">
                <script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery-1.7.1.min.js"></script>
                <script type="text/javascript" src="<?=base_url()?>file/js/easyui/jquery.easyui.min.js"></script>
                
<div class="box" style="min-height:700px;">
        <!-- box / title -->
        <div class="title">
                <h5>Journey Cycle :: Direct Sales</h5>
                <ul class="links">
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>/direct_sales">Direct Sales</a></li>
                        <li><a href="<?=base_url()."index.php/".$this->uri->segment(1)?>/smartfren_ambassador">SmartFren Ambassador</a></li>
                </ul>
        </div>
        <!-- end box / title -->
        
        <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                
                                <div class="field">
                                        <div class="label" style="padding-top:0;">
                                                <label for="region">Region:</label>
                                        </div>
                                        <div class="input">
                                                <label id="region"><b><?=$region?></b></label>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label" style="padding-top:0;">
                                                <label for="clus">Cluster:</label>
                                        </div>
                                        <div class="input">
                                                <label id="clus"><?=$cluster?></label>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Direct Sales :</label>
                                        </div>
                                        <div class="input">
                                                <select name="sfa" onchange="jump_url('parent',this,0)" >>
                                                <?php
                                                //echo $this->mglobal->showdata("user_name","t_mtr_user",array("user_id"=>$sfa),"dblokal");
                                                echo'<option value="'. base_url() .'"index.php/journey_cycle/">-Choice-</option>';
                                                foreach($getDS as $r){
                                                        $SELECTED = $r->user_id==$sfa?"SELECTED":"";
                                                        echo'<option value="'. base_url() ."index.php/journey_cycle/direct_sales/". $r->user_id .'/'. $minggu .'" '. $SELECTED .'>'. $r->user_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                                
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Week:</label>
                                        </div>
                                        <div class="input">
                                                
                                                <select name="month" onchange="jump_url('parent',this,0)" >>
                                                <?php
                                                echo'<option value="'. base_url() .'"index.php/journey_cycle/">-Choice-</option>';
                                                for($b=1;$b<=54;$b++){
                                                        $SELECTED = $b==$minggu?"SELECTED":"";
                                                        echo'<option value="'. base_url() ."index.php/journey_cycle/direct_sales/". $sfa ."/". $b .'" '. $SELECTED .'>Week '. $b ." :: ". $this->mglobal->getDays($b,$tahun-1) .'</option>';
                                                }
                                                ?>
                                                </select>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label" style="padding-top:0;">
                                                <label>Maintenance Agent:</label>
                                        </div>
                                        <div class="input">
                                                <label><?=count($getJourney)?></label>
                                        </div>
                                </div>
                                
                                <?php if($sfa=="" || $minggu=="" || $minggu >= date("W")){ ?>
                                <div class="field">
                                        <div class="label" style="padding-top:0;">
                                                <label>Choice Agent:</label>
                                        </div>
                                        <div class="input">
                                                <select name="c_agent[]" id="cc" style="width:250px;" readonly></select>
                                        </div>
                                </div>
                                
                                <div class="buttons">
                                        <input type="submit" name="submit" value="Insert Agent to Journey Cycle" />
                                </div>
                                <?php } ?>
                        </div>
                </div>
        </form><br><br>&nbsp;
        
<?php
$holiday = array();
if($sfa <> "" && $minggu <> "" ){
        
        $num = 7;
?> 
        
        <div class="table">
                
                <span class=t_judul><?=$this->mglobal->getDays($minggu,$tahun)?></span>
                <?php
                if($minggu < date("W")){?>
                        
                <?php } ?>
                <br>&nbsp;
                <table width=100% style="border:solid 1px #aaaaaa;" cellpadding==0 cellspacing==0>
                <thead>
                        <tr height="30px">
                                <th width=30 class="t_header" rowspan=2>No</th>
                                <th width=90 class="t_header" rowspan=2>Agent Code</th>
                                <th class="t_header" rowspan=2>Agent</th>
                                <th class="t_header" colspan=<?=$num?>>Date</th>
                        </tr>
                        <tr height="30px">
                                <?php
                                $sStartDate = $this->mglobal->week_start_date($minggu-1, $tahun); 
                                for($t=1;$t<=$num;$t++){
                                        $sDate   = date('D, M d', strtotime('+'. ($t-1) .' days', strtotime($sStartDate)));
                                        echo'<th class="t_header">'. $sDate .'</th>';
                                }
                                ?>
                        </tr>
                </thead>
                <tbody>
                        
                        <?php
                        $i=1;
                        foreach($getJourney as $r){
                        
                                echo'<tr height="30px">
                                        <td class="t_isi" align=center>'. $i++ .'</td>
                                        <td class="t_isi">'. $r->agent_id .'</td>
                                        <td class="t_header" style="text-align: left;">'. $r->agent_name .'</td>';
                                        
                                        for($t=1;$t<=$num;$t++){                                      
                                                $nmfield = "d".$t;
                                                $tgl   = date('d', strtotime('+'. ($t-1) .' days', strtotime($sStartDate)));
                                                $bln   = date('m', strtotime('+'. ($t-1) .' days', strtotime($sStartDate)));
                                                $nbln  = date('F', strtotime('+'. ($t-1) .' days', strtotime($sStartDate)));
                                                $thn   = date('Y', strtotime('+'. ($t-1) .' days', strtotime($sStartDate)));
                                                
                                                $libur = $this->mglobal->showdata('tanggal','t_mtr_holiday',array('tanggal'=>$thn.$bln.$tgl),'dblokal');
                                                $ket = $this->mglobal->showdata('keterangan','t_mtr_holiday',array('tanggal'=>$thn.$bln.$tgl),'dblokal');
                                                
                                                if($libur <> ""){
                                                        $holiday[] = array("tanggal"=>$nbln." ". $tgl.", ".$thn,"keterangan"=>$ket);
                                                }
                                                
                                                #rencana, hari libur mingguan diambil dr db
                                                $weekend   = date('N', strtotime('+'. ($t-1) .' days', strtotime($sStartDate)));
                                                $bgcolor = "";
                                                if($libur <> "" || $weekend == "1"){
                                                        $bgcolor=' style="background:#ffb8ad;" ';
                                                }
                                                
                                                if($minggu < date("W")){
                                                        $IMG = $r->{$nmfield} == 1? "<img src='". base_url() ."file/images/semi-ok.png'>":"";
                                                        echo'<td class="t_isi" width="90" align=center '. $bgcolor .'>'. $IMG .'</td>';
                                                }else{
                                                        $CHECK = $r->{$nmfield} == 1? "checked=checked":"";
                                                        echo'<td class="t_isi" width="90" align=center '. $bgcolor .'><input type="checkbox" name="tgl" class="d_journey" sfa="'. $sfa .'" tgl="'. $t .'" minggu="'. $tahun.$minggu .'" outlet="'. $r->agent_id .'" '. $CHECK .' ></td>';
                                                }
                                        }
                                echo'</tr>';
                        }
                        ?>
                </tbody>
                
                </table>
                
                <br><br>
                
                <?php if(count($holiday)>0){ ?>
                <h4>Information:</h4>
                <ul class="square">
                        <?php
                        
                        foreach($holiday as $r){
                                echo"<li><b>". $r['tanggal'] .":</b> ". $r['keterangan'] ."</li>";
                        }
                        ?>
                </ul>
                <?php } ?>
        </div>
<?php } ?>
</div>