<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Smartfren</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/shell/smooth/resources/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/shell/smooth/resources/css/style.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>file/shell/smooth/resources/css/style.css" />
		<link id="color" rel="stylesheet" type="text/css" href="<?=base_url()?>file/shell/smooth/resources/css/colors/red.css" />
		
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>file/smooth/css/smoothness/jquery-ui-1.8.2.custom.css" />
                <link type="text/css" rel="stylesheet" href="<?=base_url()?>file/smooth/css/styles.css" />
		
		<!-- scripts (jquery) -->
		
		<script type="text/javascript" src="<?=base_url()?>file/smooth/js/jquery-1.4.2.min.js"></script>

		<!--[if IE]><script language="javascript" type="text/javascript" src="<?=base_url()?>file/shell/smooth/resources/scripts/excanvas.min.js"></script><![endif]-->
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/jquery.ui.selectmenu.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/jquery.flot.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/tiny_mce/jquery.tinymce.js" type="text/javascript"></script>
		<!-- scripts (custom) -->
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.menu.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.chart.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.table.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.form.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.dialog.js" type="text/javascript"></script>
		<script src="<?=base_url()?>file/shell/smooth/resources/scripts/smooth.autocomplete.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				style_path = "<?=base_url()?>file/shell/smooth/resources/css/colors";
				$("#date-picker").datepicker();
				$("#box-tabs, #box-left-tabs").tabs();
			});
		</script>
		
		<script type="text/javascript" src="<?=base_url()?>file/smooth/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>file/smooth/js/jquery-ui-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>file/smooth/js/jquery-templ.js"></script>
		<script type="text/javascript" src="<?=base_url()?>file/smooth/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>file/smooth/js/jquery.dataTables.min.js"></script>
		
		
	</head>
	<body>
		<!-- header -->
		<div id="header">
			<!-- logo -->
			<div id="logo">
				<h1><a href="" title="Smooth Admin"><img src="<?=base_url()?>file/images/logo_smartfren.png" alt="Smooth Admin" /></a></h1>
			</div>
			<!-- end logo -->
			<!-- user -->
			<ul id="user">
				<li class="first"><a href="">Welcome <?=$this->session->userdata('username')?></a></li>
                                <li><a href="<?=base_url()?>index.php/user_management/change_password">Change Password</a></li>
				<li><a href="<?=base_url()?>index.php/login/logout">Logout</a></li>
			</ul>
			<!-- end user -->
			<div id="header-inner">
				<div id="home">
					<a href="<?=base_url()?>" title="Home"></a>
				</div>
				<!-- quick -->
				<ul id="quick">
					<?php
					$id = 0;
					$group = $this->session->userdata("group");
					$menus = $this->mmaster->getMenuSistem(0,$group);
					foreach($menus->result() as $r){
                                                $link = $r->alias == "" ? $this->uri->uri_string()."#" : $r->alias;
						echo'<li>
							<a href="'.base_url().'index.php/'.$link.'" title="'. $r->name .'"><span class="normal">'. $r->name .'</span></a>';
								$smenu1 = $this->mmaster->getMenuSistem($r->id,$group);
								if($smenu1->num_rows()>0){
									echo'<ul>';
									foreach($smenu1->result() as $s){
										$smenu2 = $this->mmaster->getMenuSistem($s->id,$group);
										if($smenu2->num_rows()>0){
											echo'<li><a href="'.base_url(). 'index.php/'.$s->alias .'" class="childs">'. $s->name .'</a>';
											echo'<ul>';
											foreach($smenu2->result() as $t){
												echo'<li><a href="'.base_url().'index.php/'.$t->alias .'">'. $t->name .'</a></li>';
												$smenu3 = $this->mmaster->getMenuSistem($t->id);
											}
											echo'</ul>';
										}else{
											echo'<li><a href="'.base_url(). 'index.php/'.$s->alias .'">'. $s->name .'</a>';
										}
										echo'</li>';
									}
									echo'</ul>';
								}
						echo'</li>';
					}
					?>
				</ul>
				<!-- end quick -->
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
		</div>
		<!-- end header -->
		<!-- content -->
		<div id="content">
			<!-- content / right -->
			<!-- table -->
                        
                        <div id="left">
				<div id="menu">
					<h6 id="h-menu-products" class="selected"><span>Reference Table</span></h6>
					<ul id="menu-Miscellaneous" class="opened">
						<?php
                                                $menus = $this->mmaster->getMenuSistem(68,$group);
                                                foreach($menus->result() as $r){
                                                        echo'<li><a href="'. base_url() .'index.php/'. $r->alias .'">'. $r->name .'</a></li>';
                                                }
						?>
					</ul>
				</div>
				<div id="date-picker"></div>
			</div>
                        
                        <div id="right">
                                <?=$this->load->view($main_view);?>
                        </div>
			<!-- end table -->
			<!-- end content / right -->
		</div>
		<!-- end content -->
		<!-- footer -->
		<div id="footer">
			<p>Copyright &copy; 2012 Nutech Integrasi. All Rights Reserved.</p>
		</div>
		<!-- end footert -->
	</body>
</html>