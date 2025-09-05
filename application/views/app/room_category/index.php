                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Room Category</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                 
                        <li><a href="#">Room Management</a></li>
                        <li class="active">Room Category</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		<form class="form-search" method="post" action="<?php echo base_url();?>app/room_category">
                         		<div class="box-header">
                                    <h3 class="box-title"><a href="<?php echo base_url();?>app/room_category/add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a></h3>
                                    
                                    <div class="box-tools">
                                        <div class="input-group">
                                            <input type="text" name="search" id="search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default" name="btnSearch" id="btnSearch" type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div><!-- /.box-header -->
								</form>
                        	<div class="box-body table-responsive no-padding">
                            	<?php echo $message;?>
                                
                            	<?php echo $table; ?>
                            </div>
                            	<div class="box-footer clearfix">
                                	<?php echo $pagination; ?>
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