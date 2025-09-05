<!DOCTYPE html>
<html lang="en">
  
<head>
	<meta charset="UTF-8">
        <title>HIMS :. Healthcare Information Management System</title>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>favicon.ico">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="Healthcare Information Management System (HIMS)" name="description">
        <meta content="Audemar E. Abarabar" name="author">

        <meta property="og:site_name" content="HIMS :. Healthcare Information Management System">
        <meta property="og:title" content="HIMS :. Healthcare Information Management System">
        <meta property="og:description" content="Healthcare Information Management System (HIMS)">
        <meta property="og:type" content="website">
    
	<link href="<?php echo base_url()?>public/login/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url()?>public/login/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>public/login/css/font-awesome.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	    
	<link href="<?php echo base_url()?>public/login/css/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url()?>public/login/css/pages/signin.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
	<script src="<?php echo base_url()?>public/login/js/jquery-1.7.2.min.js"></script>
	<script language="javascript">
    $(document).ready(function(){
		
	});
    </script>
    


<div style="background: #FFFFFF url('<?php echo base_url()?>public/img/new/hms_login_bg.png'); 
    background-position: center; background-size:cover; ">



	

<div class="row">
	<div class="col-md-12">
	<table width="100%" border="0">
		<tr>
			<td colspan="2" align="center"><div style="background: transparent url('<?php echo base_url()?>public/img/new/hms_logo.png') no-repeat center; height:111px; margin-bottom:-50px; padding-top:120px;"></div></td>
		</tr>
		<tr>
			<td width="50%" align="center">&nbsp;</td>
			<td width="50%">
				<div class="account-container">
					<div class="content clearfix" >
						<form action="<?php echo base_url()?>login/validate_login" method="post" id="frmLogin" name="frmLogin">
							<h1>Live Demo Login</h1>		
							<div class="login-fields">
								<p>Please provide your details</p>
				                <br>
				                <?php echo validation_errors(); ?>    
				                <?php 
				                if(isset($usernamelogin))
				                {
				                	$usernamelogin = $usernamelogin;
				                }else{
				                	$usernamelogin = "";
				                }

				                if(isset($passwordlogin))
				                {
				                	$passwordlogin = $passwordlogin;
				                }else{
				                	$passwordlogin = "";
				                }
				                ?>
								<div class="field">
									<label for="username">Username</label>
									<?php
										echo form_input("username",$usernamelogin,"class='login username-field' placeholder='Username' required");
										?>
				                </div> <!-- /field -->
								<div class="field">
									<label for="password">Password:</label>
				                    <input type="password" name="password" class="login password-field" placeholder="Password" required value="<?php echo $passwordlogin;?>" />
								</div> <!-- /password -->
							</div>
							<div class="login-actions">
								<button class="button btn btn-primary btn-large">Log In</button>
							</div> <!-- .actions -->
						</form>
						
					</div> <!-- /content -->
					
				</div> <!-- /account-container -->
			</td>
		</tr>
	</table>
	</div>
</div>



</div>

<script src="<?php echo base_url()?>public/login/js/bootstrap.js"></script>

<script src="<?php echo base_url()?>public/login/js/signin.js"></script>

</html>

</head>
