                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Add Room Category</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                      
                        <li><a href="#">Room Management</a></li>
                        <li><a href="<?php echo base_url()?>app/room_category">Room Category</a></li>
                        <li class="active">Add Room Category</li>
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
                            	<form role="form" method="post" action="<?php echo base_url()?>app/room_category/save" onSubmit="return confirm('Are you sure you want to save?');">
                                
                                		<?php echo validation_errors(); ?>   
                                
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Room Category Name</label>
                                            <input class="form-control input-sm" name="category" id="category" type="text" placeholder="Room Category Name" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input class="form-control input-sm" name="description" id="description" type="text" placeholder="Description" style="width: 350px;">
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="<?php echo base_url();?>app/room_category" class="btn btn-default">Cancel</a>
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