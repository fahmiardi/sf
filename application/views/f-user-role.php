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
    
    $('.d_menu').click(function() {
        var groupid        = $(this).attr('groupid');
        var menuid          = $(this).attr('menuid');
        var nilai      = $(this).is(':checked');
        
        $.post(
            '<?=base_url()?>index.php/userrole/saveUserRole', 
            {groupid:groupid,menuid:menuid,nilai:nilai},
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

function jump_url(targ,selObj,restore){ //v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}
</script>

<div class="box" style="min-height:900px;">
        <!-- box / title -->
        <div class="title">
                <h5>User Role Management</h5>
        </div>
        <!-- end box / title -->
        
        <form id="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form">
                        <div class="fields">
                                
                                
                                <div class="field">
                                        <div class="label">
                                                <label for="name">User Group:</label>
                                        </div>
                                        <div class="input">
                                                <select name="group" onchange="jump_url('parent',this,0)" >>
                                                <option value="<?= base_url()?>index.php/userrole/">Choice</option>
                                                <?php
                                                foreach($getUserGroup as $r){
                                                        $SELECTED = $r->user_group_id==$group?"SELECTED":"";
                                                        echo'<option value="'. base_url() .'index.php/userrole/index/'. $r->user_group_id .'" '. $SELECTED .'>'. $r->user_group_name .'</option>';
                                                }
                                                echo'</select>';
                                                ?>
                                                
                                        </div>
                                </div>
                        </div>
                </div>
        </form><br><br>&nbsp;
        
        <div class="table">
        <?php if($group <> "") { ?>
                
                <table width=100% style="border:solid 1px #aaaaaa;" cellpadding==0 cellspacing==0>
                <thead>
                        <tr height="30px">
                                <th width=30 class="t_header"></th>
                                <th width=30 class="t_header">No</th>
                                <th class="t_header">Page</th>
                                <th width=290 class="t_header">Process</th>
                        </tr>
                </thead>
                <tbody>
                        
                        <?php
                        $i=1;
                        $menus = $this->mmaster->getMenuSistem(0);
			foreach($menus->result() as $r){
                                $CEK = $this->mglobal->showdata("menu_id","t_mtr_user_role",array("user_group_id"=>$group,"menu_id"=>$r->id),"dblokal");
                                $CHECK = $CEK == ""?"":" CHECKED ";
                                echo'<tr height="30px">
                                        <td class="t_isi" align="center"><input type="checkbox" groupid="'.$group.'" menuid="'. $r->id .'" class="d_menu" '. $CHECK .'></td>
                                        <td class="t_isi" align=center>'. $i++ .'</td>
                                        <td class="t_isi">'. $r->name .'</td>
                                        <td class="t_isi"></td>
                                </tr>';
                                $smenu1 = $this->mmaster->getMenuSistem($r->id);
                                if($smenu1->num_rows()>0){
                                        foreach($smenu1->result() as $s){
                                                $CEK = $this->mglobal->showdata("menu_id","t_mtr_user_role",array("user_group_id"=>$group,"menu_id"=>$s->id),"dblokal");
                                                $CHECK = $CEK == ""?"":" CHECKED ";
                                                echo'<tr height="30px">
                                                        <td class="t_isi" align="center"><input type="checkbox" groupid="'.$group.'" menuid="'. $s->id .'" class="d_menu" '. $CHECK .'></td>
                                                        <td class="t_isi" align=center>'. $i++ .'</td>
                                                        <td class="t_isi">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $s->name .'</td>
                                                        <td class="t_isi"></td>
                                                </tr>';
                                                $smenu2 = $this->mmaster->getMenuSistem($s->id);
                                                if($smenu2->num_rows()>0){
                                                        foreach($smenu2->result() as $t){
                                                                $CEK = $this->mglobal->showdata("menu_id","t_mtr_user_role",array("user_group_id"=>$group,"menu_id"=>$t->id),"dblokal");
                                                                $CHECK = $CEK == ""?"":" CHECKED ";
                                                                echo'<tr height="30px">
                                                                        <td class="t_isi" align="center"><input type="checkbox" groupid="'.$group.'" menuid="'. $t->id .'" class="d_menu" '. $CHECK .'></td>
                                                                        <td class="t_isi" align=center>'. $i++ .'</td>
                                                                        <td class="t_isi">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $t->name .'</td>
                                                                        <td class="t_isi"></td>
                                                                </tr>';
                                                        }
                                                }
                                        }
                                }
                        }
                        ?>
                </tbody>
                </table>
        <?php } ?>
        </div>
</div>