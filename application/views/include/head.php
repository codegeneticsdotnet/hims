<!DOCTYPE html>
<html>
    <!-- Hospital Management Information System - (c) Audemar E. Abarabar, MIT. <?php echo "2023 - " . date('Y'); ?> All Rights Reserved. Email: audemar.abarabar@gmail.com -->
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
        <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/timepicker/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/datepicker/css/datepicker.css" rel="stylesheet" >
        <link href="<?php echo base_url();?>public/css/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" >
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <?php require_once(APPPATH.'views/include/sidebar.php');?>      
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
