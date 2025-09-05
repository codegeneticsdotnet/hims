<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>HIMS :. Healthcare Information Management System</title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url()?>public/company_logo/favicon.ico">
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
	<body>
		<script src="<?php echo base_url()?>public/login/js/jquery-1.7.2.min.js"></script>
		<div style="background: #FFFFFF url('<?php echo base_url()?>public/img/new/hms_login_bg.png'); background-position: center; background-size:cover; height:100%">
		<br /><br /><br /><br /><br /><br /><br />
		<div class="row">
			<div class="col-md-12">
				<div class="account-container">
					<div class="content clearfix" >
						<form action="<?php echo base_url()?>login/validate_login" method="post" id="frmLogin" name="frmLogin">
							<div class="logo-pms" style="text-align:center;margin-top:-40px;"><img src="<?php echo base_url()?>public/company_logo/<?php echo $companyInfo->logo?>" width="128" height="128"></div>	
							<div class="login-fields">
								<p style="margin-top:5px;text-align:center;font-weight:bold;font-size:1.2em;color:darkgreen;">CHRIST BEARER INFIRMARY HOSPITAL</p>
								<p style="margin-top:5px;text-align:center;font-size:1.2em;">User Login</p>
				                <?php echo validation_errors(); ?>    
				                <?php 
				                if(isset($usernamelogin)){
				                	$usernamelogin = $usernamelogin;
				                }else{
				                	$usernamelogin = "";
				                }
				                if(isset($passwordlogin)){
				                	$passwordlogin = $passwordlogin;
				                }else{
				                	$passwordlogin = "";
				                } ?>
								<div class="form-group">
									<label for="branch">Hospital Branch:</label>
									<select name="branch" id="branch" style="width:100%" class="login branch-field" required>
										<option value="CBH">Christ Bearer Hospital - San Carlos</option>
										<option value="CPG">Christ Bearer Clinic - Pagal</option>
									</select>
								</div> <!-- /branch -->
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
			</div>
		</div>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	</body>
</html>

