            <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Patient Registration</h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li class="active">Patient Registration</li>
                    </ol>
                 
                 <script language="javascript">
                 function validate(){
						//if(document.getElementById("email").value == ""){
						//	alert('You did not enter a valid Email Address');
						//	return false;
						//}else{
						//	if(confirm('Are you sure you want to save?')){
						//		return true;
						//	}else{
						//		return false;
						//	}
						//}
                        
                            if(confirm('Are you sure you want to save?')){
                                return true;
                            }else{
                                return false;
                            }
				 }
                 </script>
                 <div class="row">
                 	<div class="col-md-12">
                    <form role="form" method="post" action="<?php echo base_url()?>app/patient/save" onSubmit="return validate()">    
                    	 <div class="box">
                        	    <div class="box-body table-responsive">
                                		<div class="nav-tabs-custom">
                                        	<ul class="nav nav-tabs">
                                				<li class="active"><a href="#tab_1" data-toggle="tab">Personal Information</a></li>
                                    		    <li><a href="#tab_2" data-toggle="tab">Other Information</a></li>
                                			</ul>
                                            <div class="tab-content">
                                            	<div class="tab-pane active" id="tab_1">
                                                	<table cellpadding="3" cellspacing="3" width="80%" >
                                                    <tr>
                                                    	<td colspan="5">Required fields = <font color="#FF0000">*</font></td>
                                                    </tr>
                                                    <tr>
                                                    	<td colspan="5">
                                                        <?php echo validation_errors(); ?>    
                                                        </td>
                                                    </tr>
                                                    <?php
                          													$userID = $lastPatientID->patient_no;
                          													$userID2 = $lastPatientID->patient_no;
                          													if(strlen($userID) == 1){
                          														$userID = "000".$userID;
                          													}else if(strlen($userID) == 2){
                          														$userID = "00".$userID;
                          													}else if(strlen($userID) == 3){
                          														$userID = "0".$userID;
                          													}else{
                          														$userID = $userID;
                          													}
                                                                            $userID = date('ym') . $userID;
                          													?>
                                                    <input type="hidden" name="userID2" value="<?php echo $userID2;?>">
                                                    <tr>
                                                    	<td width="12%">Patient ID</td>
                                                        <td width="88%" colspan="3"><input class="form-control input-sm" name="patientID" id="patientID" type="text" style="width: 100px;" required readonly value="<?php echo $userID;?>"></td>
                                                    </tr>
													<!--
                                                    <tr>
                                                    	<td width="12%">Title <font color="#FF0000">*</font></td>
                                                        <td width="88%"  colspan="3">
                                                        	<select name="title" id="title" class="form-control input-sm" style="width: 100px;">
                                                            	<option value="">- Title -</option>
																<?php 
																foreach($UserTitles as $UserTitles){
																if($_POST['title'] == $UserTitles->param_id || $patientInfo->title == $UserTitles->param_id){
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
                                                    -->
                                                    <input type="hidden" name="title" value="">

                                                    <tr>
                                                    	<td width="12%"><?php echo $this->lang->line("lastname")?>Full Name <font color="#FF0000">*</font></td>
                                                        <td width="30%">
                                                            <?php echo form_input('firstname',set_value('firstname'),'id="firstname" class="form-control input-sm" placeholder="First Name" style="width: 330px;" required');?>
                                                        </td>
                                                        <td width="10%">
                                                            <?php echo form_input('middlename',set_value('middlename'),'id="middlename" class="form-control input-sm" placeholder="Middle Name" style="width: 100px;"');?>
                                                        </td>
                                                        <td width="30%">
                                                            <?php echo form_input('lastname',set_value('lastname'),'id="lastname" class="form-control input-sm" placeholder="Last Name" style="width: 300px;" required');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="10%">&nbsp;</td>
                                                        <td width="30%">Firstname</td>
                                                        <td width="10%">MI.</td>
                                                        <td width="30%">Lastname</td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Address <font color="#FF0000">*</font></td>
                                                        <td width="86%" colspan="3">
                                                        <?php echo form_input('noofhouse',set_value('noofhouse'),'id="noofhouse" class="form-control input-sm" placeholder="Present Address" style="width: 610px;"');?>
                                                        <?php echo form_hidden('brgy',set_value('brgy'),'id="brgy" class="form-control input-sm" placeholder="Brgy./Subd." style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Birthday <font color="#FF0000">*</font></td>
                                                        <td colspan="3">
                                                        <?php echo form_input('birthday',set_value('birthday'),'id="birthday" class="form-control input-sm" placeholder="MM-DD-YYYY" style="width: 150px;" required');?> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Gender  <font color="#FF0000">*</font></td>
                                                        <td width="88%" colspan="3">
                                                        	<select name="gender" id="gender" class="form-control input-sm" required style="width: 150px;">
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
                                                    	<td width="14%">Phone No (Mobile) </td>
                                                        <td width="86%" colspan="3"> 
                                                        <?php echo form_input('mobile',set_value('mobile'),'id="mobile" class="form-control input-sm" placeholder="Phone No (Mobile)" style="width: 150px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Birth Place </td>
                                                        <td colspan="3">
                                                        <?php echo form_input('birthplace',set_value('birthplace'),'id="birthplace" class="form-control input-sm" placeholder="Birth Place" style="width: 150px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Civil Status </td>
                                                        <td width="88%" colspan="3">
                                                        	<select name="civil_status" id="civil_status" class="form-control input-sm" style="width: 150px;">
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
                                                    	<td width="12%">Religion </td>
                                                        <td width="88%" colspan="3">
                                                        	<select name="religion" id="religion" class="form-control input-sm" style="width: 150px;">
                                                            	<option value="">- Religion -</option>
                                                                <?php 
                                                                foreach($religionList as $religion){
                                                                if($_POST['religion'] == $religion->param_id){
                                                                    $selected = "selected='selected'";
                                                                }else{
                                                                    $selected = "";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $religion->param_id;?>" <?php echo $selected;?>><?php echo $religion->cValue;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Blood Group </td>
                                                        <td width="88%" colspan="3">
                                                        	<select name="bloodGroup" id="bloodGroup" class="form-control input-sm" style="width: 150px;">
                                                            	<option value="">- Blood Group -</option>
                                                            	<?php 
                                                                foreach($bloodGroup as $bloodGroup){
                                                                if($_POST['bloodGroup'] == $bloodGroup->param_id){
                                                                    $selected = "selected='selected'";
                                                                }else{
                                                                    $selected = "";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $bloodGroup->param_id;?>" <?php echo $selected;?>><?php echo $bloodGroup->cValue;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </td>
                                                    </tr>
													<tr>
                                                    	<td>Insurance Company </td>
                                                        <td>
                                                        <select name="insurance_comp" id="insurance_comp" class="form-control input-sm" style="width: 250px;">
                                                            	<option value="">- None -</option>
                                                            	<?php 
																foreach($insuranceCompList as $insuranceCompList){
																if($_POST['insurance_comp'] == $insuranceCompList->in_com_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $insuranceCompList->in_com_id;?>" <?php echo $selected;?>><?php echo $insuranceCompList->company_name;?></option>
                                                                <?php }?>
                                                            </select>
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Insurance ID Number</td>
                                                        <td>
                                                        <?php echo form_input('insurance_id',set_value('insurance_id'),'id="insurance_id" class="form-control input-sm" placeholder="Insurance ID Number" style="width: 250px;" ');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td valign="top">Patient's Identifiers</td>
                                                        <td>
                                                        <textarea class="form-control input-sm" style="width: 250px;" name="patient_iden" id="patient_iden"></textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td width="12%">&nbsp;</td>
                                                        <td width="88%" colspan="3">
                                                            <div class="box-footer clearfix">
                                                                <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                                                <a href="<?php echo base_url();?>app/patient" class="btn btn-default">Cancel</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </table>                                                    
                                                </div>
                                                <div class="tab-pane" id="tab_2">
                                                	<table cellpadding="3" cellspacing="3" width="100%">
                                                    <tr>
                                                    	<td colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Permanent Address</td>
                                                        <td width="86%">
                                                        <?php echo form_input('address2',set_value('address2'),'id="address2" class="form-control input-sm" placeholder="Address2" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">City</td>
                                                        <td width="86%"> 
                                                        <?php echo form_input('province',set_value('province'),'id="province" class="form-control input-sm" placeholder="City" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Guardians's Name </td>
                                                        <td colspan="3">
                                                        <?php echo form_input('fathers_name',set_value('fathers_name'),'id="fathers_name" class="form-control input-sm" placeholder="Fathers Name" style="width: 250px;"');?> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Phone No (Office)</td>
                                                        <td width="86%">
                                                        <?php echo form_input('phone_office',set_value('phone_office'),'id="phone_office" class="form-control input-sm" placeholder="Phone No (Office)" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Phone No (Home)</td>
                                                        <td width="86%">
                                                        <?php echo form_input('phone',set_value('phone'),'id="phone" class="form-control input-sm" placeholder="Phone No (Work)" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">Email Address</td>
                                                        <td width="86%"> 
                                                        <?php echo form_input('email',set_value('email'),'id="email" class="form-control input-sm" placeholder="Email Address" style="width: 250px;"');?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="14%">&nbsp;</td>
                                                        <td width="86%"> 
                                                            <div class="box-footer clearfix">
                                                                <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                                                <a href="<?php echo base_url();?>app/patient" class="btn btn-default">Cancel</a>
                                                            </div>
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
        <!-- BDAY -->
        <script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                $('#birthday').datepicker({
                    //format: "dd/mm/yyyy"
                    format: "mm-dd-yyyy"
                });  
            });
        </script>
        <!-- END BDAY -->
        
    </body>
</html>