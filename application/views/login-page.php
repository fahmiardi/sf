<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script type="text/javascript" src="<?=base_url()?>file/shell/login/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>file/shell/login/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>file/shell/login/login.js"></script>

<title>Sales Tracking System</title>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>file/shell/login/template.css">
<link type="text/css" rel="stylesheet" href="<?=base_url()?>file/shell/login/login.css">
<link type="text/css" rel="stylesheet" href="<?=base_url()?>file/shell/login/dm.fbconnect.css">

<!-- add IE specific css for the editor and analytics -->
<!--[if IE 7]>
			<link type="text/css" rel="stylesheet" href="css/Editor_IE7.css"/>
			<link type="text/css" rel="stylesheet" href="css/DudaAnalytics_IE7.css">
			<link type="text/css" rel="stylesheet" href="css/sharingStyles_IE7.css">
			
		<![endif]-->
<!--[if IE 8]>
			<link type="text/css" rel="stylesheet" href="css/Editor_IE.css"/>
			<link type="text/css" rel="stylesheet" href="css/DudaAnalytics_IE8.css">
		<![endif]-->
       
</head>
<body class="j15" style="text-align: center;">
  <div id="main" style="padding-top: 50px">
    <div class="dmSheet">
      <div class="dmSheet-body" style="min-height: 350px">
        <div class="content-layout">
          <div id="dm">
            <div id="content">

              <div id="login-left">
                <img id="logo" width="250px" src="<?=base_url()?>file/images/logo_smartfren.png">
                <img id="dudeImage" src="<?=base_url()?>file/shell/login/kwik-smartfren-i-hate-slow-219x300.png" style="height:319px;">
                Copyright &copy; 2012. PT Smartfren Telecom, Tbk. All right reserved.
              </div>
              <div id="login-right">
                <img src="<?=base_url()?>file/images/logo.png"><br />
                <div style="float:right">version 1.0</div>
                <div style="padding-bottom: 6px; padding-left: 3px; width: 100%;"></div>
                <div class="login_error">
			<?php
			#$msg = $this->session->flashdata('message');
			$msg = validation_errors();
			if($msg <> ""){
			      echo'<div style="top:5px; left:0px; width:100%; font-weight:bold; color:red; align:center; ">'. $msg .'</div>';
			}
			?>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"><br>
                  <div class="inputBox">
                    <div class="inputTitle">USERNAME:</div><input type="text" value="" name="username" id="j_username" style="border-top-width: 2px; border-right-width: 2px; border-bottom-width: 2px; border-left-width: 2px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(231, 233, 217); border-right-color: rgb(231, 233, 217); border-bottom-color: rgb(231, 233, 217); border-left-color: rgb(231, 233, 217); color:#7a2426; font-weight:bold;border-image: initial; "></div>
                  <div class="inputBox">
                    <div style="float: left" class="inputTitle">PASSWORD:</div>
                    <input type="password" value="" name="password" style=" color:#7a2426; font-weight:bold;">
                  </div>
                  <div class="inputBox">
                    <div style="float: left" class="inputTitle">SECURITY CODE:</div>
                    &nbsp;&nbsp;
                    <img src="<?=base_url()?>index.php/login/capcay" id="ratcha_image" alt="CAPTCHA">
                    <input type="text" value="" name="ractha" style=" color:#7a2426; font-weight:bold;" size="10">
                  </div>
                  <div style="padding-top: 15px">
                    <input type="image" src="<?=base_url()?>file/shell/login/login_button_r.png">
                  </div>
                </form>
              </div>
              <br style="clear: both">
            </div>
          </div>
        </div>
        <div class="cleared"></div>
      </div>
      <div class="nostyle"></div>
    </div>
  </div>

</body></html>