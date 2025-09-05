				<?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Inventory</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">Inventory Management</a></li>
                        <li class="active">Inventory</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		
                         		<div class="box-header">
                                    <h3 class="box-title"></h3>
                                    
                                  
                                    
                                </div><!-- /.box-header -->
								
                        	<div class="box-body table-responsive">
                            	<form role="form" method="post" action="<?php echo base_url()?>app/parameters/save" onSubmit="return confirm('Are you sure you want to save?');">
                                <input type="hidden" name="module" value="<?php echo $module;?>">
                                		<?php echo validation_errors(); ?>   
                                
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">CODE</label>
                                            <input class="form-control input-sm" name="cCode" value="<?php echo $module;?>" readonly id="cCode" type="text" placeholder="CODE" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">VALUE</label>
                                            <input class="form-control input-sm" name="cValue" id="cValue" type="text" placeholder="VALUE" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">DESCRIPTION</label>
                                            <input class="form-control input-sm" name="cDesc" id="cDesc" type="text" placeholder="DESCRIPTION" style="width: 350px;">
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="<?php echo base_url();?>app/parameters/lists/<?php echo $module;?>" class="btn btn-default">Cancel</a>
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                        
                                </form>
                                
                            </div>
                            	<div class="box-footer clearfix">
                                	
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