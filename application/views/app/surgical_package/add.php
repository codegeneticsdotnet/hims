                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Add Surgical Package</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url()?>app/roles">Admin</a></li>
                         <li><a href="<?php echo base_url()?>app/surgical_package">Surgical Package</a></li>
                        <li class="active">Add Surgical Package</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		
                         		<div class="box-header">
                                    <h3 class="box-title"></h3>
                                    
                                </div>
                        	<div class="box-body table-responsive">
                            	<form role="form" method="post" action="<?php echo base_url()?>app/surgical_package/save" onSubmit="return confirm('Are you sure you want to save?');">
                                
                                		<?php echo validation_errors(); ?>   
                                
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Surgery Name</label>
                                            <input class="form-control input-sm" name="surgery_name" id="surgery_name" type="text" placeholder="Surgery Name" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input class="form-control input-sm" name="description" id="description" type="text" placeholder="Department Name" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="<?php echo base_url();?>app/surgical_package" class="btn btn-default">Cancel</a>
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
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