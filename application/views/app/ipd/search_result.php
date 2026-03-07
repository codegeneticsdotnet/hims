                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Patient Master</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li><a href="#">IPD</a></li>
                        <li class="active">IPD Registration</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		<form class="form-search" method="post" action="<?php echo base_url();?>app/patient">
                         		<div class="box-header">
                                    <h3 class="box-title"><a href="<?php echo base_url();?>app/ipd/registration" class="btn btn-default"><i class="fa fa-search"></i> Back to Search form</a></h3>
                                    
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add New Patient</button>
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
        
    
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Add New Patient</h4>
                    </div>
                    <form action="<?php echo base_url()?>app/patient/save_quick" method="post">
                    <input type="hidden" name="redirect_to" value="ipd">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middlename" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Birthday <span class="text-danger">*</span></label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="">- Select -</option>
                                <option value="2">Female</option>
                                <option value="1">Male</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Civil Status</label>
                            <select name="civil_status" class="form-control">
                                <option value="">- Select -</option>
                                <option value="4">Married</option>
                                <option value="6">Separated</option>
                                <option value="3">Single</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Patient</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
    </body>
</html>