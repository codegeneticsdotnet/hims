<?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Edit Role</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">User Management</a></li>
                        <li><a href="<?php echo base_url()?>app/roles">User Roles</a></li>
                        <li class="active">Edit Role</li>
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
                            	<form role="form" method="post" action="<?php echo base_url()?>app/roles/edit" onSubmit="return confirm('Are you sure you want to save?');">
                                <input type="hidden" name="id" id="id" value="<?php echo $roles->role_id?>">
                                		<?php echo validation_errors(); ?>   
                                        
                                        <!--<div class="form-group">
                                            <label for="exampleInputEmail1">Access Module</label>
                                            <select name="module" id="module" class="form-control input-sm" style="width: 350px;" required>
                                            	<option value=""> - Access Module - </option>
                                            	<option value="administrator" <?php if($roles->module == "administrator"){ echo "selected";}?>>Administrator Module</option>
                                                <option value="doctor" <?php if($roles->module == "doctor"){ echo "selected";}?>>Doctor Module</option>
                                                <option value="helpdesk" <?php if($roles->module == "helpdesk"){ echo "selected";}?>>Help Desk Module</option>
                                                <option value="nursing" <?php if($roles->module == "nursing"){ echo "selected";}?>>Nursing Module</option>
                                                <option value="billing" <?php if($roles->module == "billing"){ echo "selected";}?>>Billing Module</option>
                                            </select>
                                        </div>-->
                                
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Role Name</label>
                                            <input class="form-control input-sm" name="role_name" id="role_name" type="text" placeholder="Role Name" style="width: 350px;" required value="<?php echo $roles->role_name?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Role Description</label>
                                            <input class="form-control input-sm" name="role_description" id="role_description" type="text" placeholder="Role Description" style="width: 350px;" required value="<?php echo $roles->role_description?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="<?php echo base_url();?>app/roles" class="btn btn-default">Cancel</a>
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