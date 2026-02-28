<?php require_once(APPPATH.'views/include/head.php');?>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Backup & Restore Database</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Administrator</a></li>
                        <li class="active">Backup & Restore</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 <?php echo $this->session->flashdata('message');?>
                 
                 <div class="row">
                 	<div class="col-md-6">
                    	 <div class="box box-primary">
                         	<div class="box-header">
                                <h3 class="box-title">Backup Database</h3>
                            </div>
                        	<div class="box-body">
                             <form method="post" action="<?php echo base_url()?>app/backup/backup_database" onSubmit="return confirm('Are you sure you want to backup database?');">
                             <p class="text-muted">Click the button below to download a backup of your database.</p>
                             <div class="form-group">
                                <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-download"></i> Backup Database</button>
                            </div>
                             </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                    	 <div class="box box-danger">
                         	<div class="box-header">
                                <h3 class="box-title">Restore Database</h3>
                            </div>
                        	<div class="box-body">
                             <form method="post" action="<?php echo base_url()?>app/backup/restore_database" enctype="multipart/form-data" onSubmit="return confirm('WARNING: This will overwrite existing data. Are you sure you want to proceed?');">
                             <p class="text-muted">Upload a .sql or .zip backup file to restore the database.</p>
                             
                             <div class="form-group">
                                <label>Select Backup File</label>
                                <input type="file" name="backup_file" required class="form-control">
                             </div>
                             
                             <div class="form-group">
                                <button class="btn btn-danger" name="btnRestore" id="btnRestore" type="submit"><i class="fa fa-upload"></i> Restore Database</button>
                            </div>
                             </form>
                            </div>
                        </div>
                    </div>
                 </div>
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
    </body>
</html>