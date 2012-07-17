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
        var bulan      = $(this).attr('bulan');
        var nilai      = $(this).is(':checked');
        
        $.post(
            '<?=base_url()?>index.php/journey_cycle/saveJC', 
            {sfa:sfa,outlet:outlet,tgl:tgl,bulan:bulan,nilai:nilai},
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

<div class="box" style="min-height:700px;">
        <!-- box / title -->
        <div class="title">
                <h5>Journey Cycle :: SmartFren Ambassador</h5>
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
                                                <label for="name">SFA:</label>
                                        </div>
                                        <div class="input">
                                                <select name="sfa" onchange="jump_url('parent',this,0)" >>
                                                <?php
                                                //echo $this->mglobal->showdata("user_name","t_mtr_user",array("user_id"=>$sfa),"dblokal");
                                                echo'<option value="'. base_url() .'"index.php/journey_cycle/">-Choice-</option>';
                                                foreach($getSFA as $r){
                                                        $SELECTED = $r->user_id==$sfa?"SELECTED":"";
                                                        echo'<option value="'. base_url() ."index.php/journey_cycle/index/". $r->user_id .'/'. $bulan .'" '. $SELECTED .'>'. $r->user_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                                
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label">
                                                <label for="name">Month:</label>
                                        </div>
                                        <div class="input">
                                                <select name="month" onchange="jump_url('parent',this,0)" >>
                                                <?php
                                                echo'<option value="'. base_url() .'"index.php/journey_cycle/">-Choice-</option>';
                                                for($b=1;$b<=12;$b++){
                                                        $SELECTED = $b==$bulan?"SELECTED":"";
                                                        echo'<option value="'. base_url() ."index.php/journey_cycle/index/". $sfa ."/". date("m", mktime(0,0,0,$b,1,2012)) .'" '. $SELECTED .'>'. date("F", mktime(0,0,0,$b,1,2012)) .' '. date('Y') .'</option>';
                                                }
                                                ?>
                                                </select>
                                        </div>
                                </div>
                                <div class="field">
                                        <div class="label" style="padding-top:0;">
                                                <label>Outlet Maintened:</label>
                                        </div>
                                        <div class="input">
                                                <label><?=count($getJourney)?></label>
                                        </div>
                                </div>
                        </div>
                </div>
        </form><br><br>&nbsp;
        
<?php
if($sfa <> "" && $bulan <> "" ){
        
        $num = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
?> 
        
        <div class="table">
                
                <span class=t_judul><?=date("F", mktime(0,0,0,$bulan,1,$tahun)) .' '. $tahun?></span>
                <?php if($bulan < date("n")){?>
                        <input type="button" class="d_copy_journey" bulan="<?=$bulan?>" tahun="<?=$tahun?>" sfa="<?=$sfa?>" value="Copy Journey Cycle To <?=date("F", mktime(0,0,0,date('n'),1,$tahun)) .' '. $tahun?>">
                <?php } ?>
                <br>&nbsp;
                <table width=100% style="border:solid 1px #aaaaaa;" cellpadding==0 cellspacing==0>
                <thead>
                        <tr height="30px">
                                <th width=30 class="t_header" rowspan=2>No</th>
                                <th width=90 class="t_header" rowspan=2>Outlet Code</th>
                                <th class="t_header" rowspan=2>Outlet</th>
                                <th width=40 class="t_header" rowspan=2>Outlet Class</th>
                                <th class="t_header" colspan=<?=$num?>>Date</th>
                        </tr>
                        <tr height="30px">
                                <?php
                                for($t=1;$t<=$num;$t++){
                                        echo'<th class="t_header">'. $t .'</th>';
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
                                        <td class="t_isi">'. $r->outlet_id .'</td>
                                        <td class="t_header">'. $r->outlet_name .'</td>
                                        <td class="t_header">A</td>';
                                        
                                        for($t=1;$t<=$num;$t++){                                      
                                                $nmfield = "d".$t;
                                                $libur = $this->mglobal->showdata('tanggal','t_mtr_holiday',array('tanggal'=>$tahun.$bulan.str_pad($t,2,"0",STR_PAD_LEFT)),'dblokal');
                                                
                                                $weekend = date("N", mktime(0,0,0,$bulan,$t,$tahun));
                                                $bgcolor = "";
                                                if($libur <> "" || $weekend == "6" || $weekend == "7"){
                                                        $bgcolor=' style="background:#ffb8ad;" ';
                                                }
                                                
                                                if($bulan < date("n")){
                                                        $IMG = $r->{$nmfield} == 1? "<img src='". base_url() ."file/images/semi-ok.png'>":"";
                                                        echo'<td class="t_isi" align=center '. $bgcolor .'>'. $IMG .'</td>';
                                                }else{
                                                        $CHECK = $r->{$nmfield} == 1? "checked=checked":"";
                                                        echo'<td class="t_isi" align=center '. $bgcolor .'><input type="checkbox" name="tgl" class="d_journey" sfa="'. $sfa .'" tgl="'. $t .'" bulan="'. $tahun.$bulan .'" outlet="'. $r->outlet_id .'" '. $CHECK .' ></td>';
                                                }
                                        }
                                echo'</tr>';
                        }
                        ?>
                </tbody>
                
                </table>
                
                <br><br>
                
                <?php if(count($getHoliday)>0){ ?>
                <h4>Information:</h4>
                <ul class="square">
                        <?php
                        foreach($getHoliday as $r){
                                echo"<li><b>". date("M, d Y",mktime(0,0,0,$bulan,substr($r->tanggal,5,2),$tahun)) .":</b> ". $r->keterangan ."</li>";
                        }
                        ?>
                </ul>
                <?php } ?>
        </div>
<?php } ?>
</div>