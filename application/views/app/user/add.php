                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Add User</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">User Management</a></li>
                        <li class="active">Add User</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    <form role="form" method="post" action="<?php echo base_url()?>app/user/save" onSubmit="return confirm('Are you sure you want to save?');">    
                    	 <div class="box">
                         		
                         		 <div class="box-footer clearfix">
                            	
                                            <a href="<?php echo base_url();?>app/user" class="btn btn-default">Cancel</a>
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                 
                            </div>
                            
                        	<div class="box-body table-responsive">
                            	
                                
                                		<div class="nav-tabs-custom">
                                        	<ul class="nav nav-tabs">
                                				<li class="active"><a href="#tab_1" data-toggle="tab">Personal Information</a></li>
                                    			<li><a href="#tab_2" data-toggle="tab">Contact Information</a></li>
                                			</ul>
                                            <div class="tab-content">
                                            	<div class="tab-pane active" id="tab_1">
                                                	<table cellpadding="3" cellspacing="3" width="100%">
                                                    <tr>
                                                    	<td colspan="2">Required fields = <font color="#FF0000">*</font></td>
                                                    </tr>
                                                    <tR>
                                                    	<td colspan="2">
                                                        <?php echo validation_errors(); ?>    
                                                        </td>
                                                    </tR>
                                                    <?php
													$userID = $lastUserID->cValue;
													$userID2 = $lastUserID->cValue;
													if(strlen($userID) == 1){
														$userID = "0000".$userID;
													}else if(strlen($userID) == 2){
														$userID = "000".$userID;
													}else if(strlen($userID) == 3){
														$userID = "00".$userID;
													}else if(strlen($userID) == 4){
														$userID = "0".$userID;
													}else if(strlen($userID) == 5){
														$userID = $userID;
													}
													?>
                                                    <input type="hidden" name="userID2" value="<?php echo $userID2;?>">
                                                    <tr>
                                                    	<td width="12%">User ID</td>
                                                        <td width="88%"><input class="form-control input-sm" name="userid" id="userid" type="text" style="width: 100px;" required readonly value="<?php echo $userID;?>"></td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Username <font color="#FF0000">*</font></td>
                                                        <td width="86%"> 
                                                       
                                                    	<input type="text" name="username" id="username" value="<?php echo $userID?>" class="form-control input-sm" placeholder="Username" style="width: 250px;" required>
                                                        
                                                    	</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%" valign="top">Password <font color="#FF0000">*</font></td>
                                                        <td width="86%"> 
                                                        <input type="password" name="password" id="password" value="<?php echo $userID?>" class="form-control input-sm" placeholder="Password" style="width: 250px;" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Title <font color="#FF0000">*</font></td>
                                                        <td width="88%">
                                                        	<select name="title" id="title" class="form-control input-sm" style="width: 100px;" required>
                                                            	<option value="">- Title -</option>
																<?php 
																foreach($UserTitles as $UserTitles){
																if($_POST['title'] == $UserTitles->param_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $UserTitles->param_id;?>" <?php echo $selected;?>><?php echo $UserTitles->cValue;?></option>
                                                                <?php }?>
                                                            </select>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Last Name <font color="#FF0000">*</font></td>
                                                        <td width="88%">
                                                        <?php echo form_input('lastname',set_value('lastname'),'id="lastname" class="form-control input-sm" placeholder="Last Name" style="width: 250px;" required');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>First Name <font color="#FF0000">*</font></td>
                                                        <td>
                                                        <?php echo form_input('firstname',set_value('firstname'),'id="firstname" class="form-control input-sm" placeholder="First Name" style="width: 250px;" required');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Middle Name <font color="#FF0000">*</font></td>
                                                        <td>
                                                        <?php echo form_input('middlename',set_value('middlename'),'id="middlename" class="form-control input-sm" placeholder="Middle Name" style="width: 250px;" required');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Birthday <font color="#FF0000">*</font></td>
                                                        <td>
                                                        <?php echo form_input('birthday',set_value('birthday'),'id="birthday" class="form-control input-sm" placeholder="Birthday" style="width: 150px;" required');?> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Birth Place</td>
                                                        <td>
                                                        <?php echo form_input('birthplace',set_value('birthplace'),'id="birthplace" class="form-control input-sm" placeholder="Birth Place" style="width: 380px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Gender</td>
                                                        <td width="88%">
                                                        	<select name="gender" id="gender" class="form-control input-sm" style="width: 100px;">
                                                            	<option value="">- Gender -</option>
                                                                <?php 
																foreach($gender as $gender){
																if($_POST['gender'] == $gender->param_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $gender->param_id;?>" <?php echo $selected;?>><?php echo $gender->cValue;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Civil Status</td>
                                                        <td width="88%">
                                                        	<select name="civil_status" id="civil_status" class="form-control input-sm" style="width: 140px;">
                                                            	<option value="">- Civil Status -</option>
                                                                <?php 
																foreach($civilStatus as $civilStatus){
																if($_POST['civil_status'] == $civilStatus->param_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $civilStatus->param_id;?>" <?php echo $selected;?>><?php echo $civilStatus->cValue;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Department <font color="#FF0000">*</font></td>
                                                        <td width="88%">
                                                        	<select name="department" id="department" class="form-control input-sm" style="width: 200px;" required>
                                                            	<option value="">- Department -</option>
                                                            	<?php 
																foreach($departmentList as $departmentList){
																if($_POST['department'] == $departmentList->department_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $departmentList->department_id;?>" <?php echo $selected;?>><?php echo $departmentList->dept_name;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Designation <font color="#FF0000">*</font></td>
                                                        <td width="88%">
                                                        	<select name="designation" id="designation" class="form-control input-sm" style="width: 200px;" required>
                                                            	<option value="">- Designation -</option>
                                                                <?php 
																foreach($designationList as $designationList){
																if($_POST['designation'] == $designationList->designation_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $designationList->designation_id;?>" <?php echo $selected;?>><?php echo $designationList->designation;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">User Role <font color="#FF0000">*</font></td>
                                                        <td width="88%">
                                                        	<select name="user_role" id="user_role" class="form-control input-sm" style="width: 200px;" required>
                                                            	<option value="">- User Role -</option>
                                                                <?php 
																foreach($userRoleList as $userRoleList){
																if($_POST['user_role'] == $userRoleList->role_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $userRoleList->role_id;?>" <?php echo $selected;?>><?php echo $userRoleList->role_name;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <input type="hidden" name="cType">
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tab_2">
                                                	<table cellpadding="3" cellspacing="3" width="100%">
                                                    <tr>
                                                    	<td colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">No. of House</td>
                                                        <td width="86%">
                                                        <?php echo form_input('noofhouse',set_value('noofhouse'),'id="noofhouse" class="form-control input-sm" placeholder="No. of House" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Brgy./Subd.</td>
                                                        <td width="86%"> 
                                                        <?php echo form_input('brgy',set_value('brgy'),'id="brgy" class="form-control input-sm" placeholder="Brgy./Subd." style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">City/Province</td>
                                                        <td width="86%"> 
                                                        <?php echo form_input('province',set_value('province'),'id="province" class="form-control input-sm" placeholder="City/Province" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Mobile No.</td>
                                                        <td width="86%"> 
                                                        <?php echo form_input('mobile',set_value('mobile'),'id="mobile" class="form-control input-sm" placeholder="Mobile No" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Phone No.</td>
                                                        <td width="86%">
                                                        <?php echo form_input('phone',set_value('phone'),'id="phone" class="form-control input-sm" placeholder="Phone No." style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Email Address <font color="#FF0000">*</font></td>
                                                        <td width="86%"> 
                                                        <?php echo form_input('email',set_value('email'),'id="email" class="form-control input-sm" placeholder="Email Address" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                               
                                
                            </div>
                            
                        </div>
                    </div>
                     </form>
                 </div>
                 
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
    </body>
</html>