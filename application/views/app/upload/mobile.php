<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mobile Upload</title>
<link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<style>
    body { padding: 20px; text-align: center; }
    .btn-upload { margin-top: 20px; width: 100%; font-size: 18px; padding: 15px; }
    .file-input { margin: 20px 0; }
</style>
</head>
<body>
    <h3>Upload Documents</h3>
    <p class="text-muted">Case No: <?php echo isset($case_no) ? $case_no : 'Unknown';?></p>
    
    <?php if(isset($error) && !empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error;?></div>
    <?php endif; ?>
    
    <?php echo form_open_multipart('app/upload/do_upload');?>
        <input type="hidden" name="token" value="<?php echo $token;?>">
        
        <div class="form-group file-input">
            <label>Select File or Take Photo</label>
            <input type="file" name="userfile" class="form-control" accept="image/*,application/pdf" capture="camera">
        </div>
        
        <button type="submit" class="btn btn-primary btn-upload">Upload Now</button>
    </form>
</body>
</html>