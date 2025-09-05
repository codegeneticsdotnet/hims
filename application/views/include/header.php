 <script language="javascript">
    setTimeout(function timeru(){$('.alert').fadeOut(1000)}, 3000);
</script> 
<header class="header" style="background:green;border-bottom:2px solid #CCC">
    <a href="<?php echo base_url()?>app/dashboard" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <div class="logo-pms"><img src="<?php echo base_url()?>public/company_logo/<?php echo $companyInfo->logo?>" height="42"></div>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation" style="background: url('<?php echo base_url()?>public/img/new/header_bar_bg_02.jpg') repeat-x; background-size: 100% 100%; border-bottom:1px solid #CCC; background:darkgreen;">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="logo2"> 
                <?php echo $companyInfo->company_name?>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><?php echo $userInfo->firstname." ".$userInfo->lastname;?><i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <?php if($userInfo->picture == ""){?>
                    	<img src="<?php echo base_url()?>public/user_picture/no_avatar.gif" class="img-circle" alt="User Image" />
                    <?php }else{?>
                    	<img src="<?php echo base_url()?>public/user_picture/<?php echo $userInfo->picture;?>" class="img-circle" alt="User Image" />
                    <?php }?>
                            <p>
                                <?php echo $userInfo->firstname." ".$userInfo->lastname;?> <br /> <?php echo $userInfo->designation;?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url()?>myprofile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url()?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
