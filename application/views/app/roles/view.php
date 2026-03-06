                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>User Roles</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">User Management</a></li>
                        <li><a href="<?php echo base_url()?>app/roles">User Roles</a></li>
                        <li class="active">View</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 <form role="form" method="post" action="<?php echo base_url()?>app/roles/updateRolePages" onSubmit="return confirm('Are you sure you want to save?');">
                 <input type="hidden" name="id" id="id" value="<?php echo $roles->role_id?>">
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div>
                         	
                            <div class="nav-tabs-custom">
                            	<ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_2" data-toggle="tab">Role Permission</a></li>
                                    <li><a href="#tab_3" data-toggle="tab">Assigned Users</a></li>
                                </ul>
                                <div class="tab-content">
                                    
                                    <div class="tab-pane active" id="tab_2">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Role Name: </label>
                                                <?php echo $roles->role_name?>
                                            </div>
                                            <div class="form-group">
                                                <label>Role Description: </label>
                                                <?php echo $roles->role_description?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php echo $message;?>
                                    	<p><button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Update User Role Pages</button></p>
                                    	
                                        <div class="row">
                                            <?php 
                                            $num = 0;
                                            foreach($links as $links){
                                            $num++;
                                            ?>
                                            <div class="col-md-4">
                                                <div class="panel panel-default" style="min-height: 200px;">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <?php echo $links->page_module;?>
                                                        </h4>
                                                    </div>
                                                    
                                                    <?php
                                                    $ci_obj = & get_instance();
                                                    $ci_obj->load->model('app/roles_model');
                                                    $pages = $ci_obj->roles_model->getPageByPageModule($links->page_module);
                                                    ?>
                                                    
                                                    <div class="panel-body">
                                                        <table width="100%" cellpadding="2" cellspacing="2">
                                                        <?php 
                                                        foreach($pages as $pages){
                                                        
                                                        //get the access level of user
                                                        $ci_obj2 = & get_instance();
                                                        $ci_obj2->load->model('app/roles_model');
                                                        $access_level = $ci_obj2->roles_model->getRole_AccessLevel($pages->page_id,$roles->role_id);
                                                        if(!empty($access_level)){
                                                            if($pages->page_id == $access_level->page_id){
                                                                $checked = "checked";
                                                            }else{
                                                                $checked = "";
                                                            }
                                                        }else{
                                                            $checked = "";	
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td width="10%"><input type="checkbox" name="page_id[]" id="page_id[]" value="<?php echo $pages->page_id;?>" <?php echo $checked;?>></td>
                                                            <td width="90%"><?php echo $pages->page_name;?></td>
                                                        </tr>
                                                        <?php }?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php 
                                            // Close row every 3 items to keep grid aligned, though col-md-4 wraps automatically, 
                                            // explicit clearing can be safer if heights vary significantly.
                                            // But standard bootstrap grid wrapping is usually fine.
                                            }?>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="tab_3">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Username</th>
                                                        <th>Department</th>
                                                        <th>Designation</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(!empty($users)): ?>
                                                        <?php foreach($users as $user): ?>
                                                        <tr>
                                                            <td><?php echo $user->firstname . ' ' . $user->lastname; ?></td>
                                                            <td><?php echo $user->username; ?></td>
                                                            <td><?php echo $user->dept_name; ?></td>
                                                            <td><?php echo $user->designation_name; ?></td>
                                                            <td>
                                                                <?php if($user->InActive == 0): ?>
                                                                    <span class="label label-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="label label-danger">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">No users assigned to this role.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                         
                        </div>
                    </div>
                 </div>
                 </form>
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
    </body>
</html>