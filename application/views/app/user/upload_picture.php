<!DOCTYPE html>
<html lang="en"><head>
<head>
        <meta charset="UTF-8">
        <title>HIMS :. Healthcare Information Management System</title>
        <link rel="icon" type="image/x-icon" href="http://localhost/hims/public/company_logo/favicon.ico">
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
</head>

<body>
<table cellpadding="5" cellspacing="5">
<tr>
	<td>
    <?php
if(!$user->picture){
	$picture = "no_avatar.gif";	
}else{
	$picture = $user->picture;
}
?>

<img src="<?php echo base_url();?>public/user_picture/<?php echo $picture;?>" class="img-rounded" width="150" height="150">
    </td>
    <td valign="top">
    <?php echo $message;?>
    <?php echo form_open_multipart(base_url().'app/user/upload_na'); ?>
    <input type="hidden" name="user_id" value="<?php echo $user->user_id;?>">
    <fieldset>
    	<legend> CHANGE PICTURE </legend>
    	<input type="file" name="userfile" size="20" />
        <br />
        <input type="submit" value="upload" />
    </fieldset>
    <?php echo form_close();?>
    </td>
</tr>
</table>

</body>
</html>