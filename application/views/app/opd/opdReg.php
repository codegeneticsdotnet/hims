				<?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>OPD Registration</h1>
                </section>
                <!-- Main content -->
                <section class="content">
                   <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li><a href="<?php echo base_url()?>app/opd/index">OPD</a></li>
                        <li class="active">OPD Registration</li>
                    </ol>
                 
                 
                 <div class="row">
                    <div class="col-md-12">
                    	 <div class="box">
                         	 <div class="box-header"></div>
                        	<div class="box-body table-responsive no-padding">
                            	<table width="100%" cellpadding="3" cellspacing="3">
                                <tr>
                                	<td width="15%" valign="top" align="center">
                                    <?php
									if(!$patientInfo->picture){
										$picture = "avatar.png";	
									}else{
										$picture = $patientInfo->picture;
									}
									?>
									<img src="<?php echo base_url();?>public/patient_picture/<?php echo $picture;?>" class="img-rounded" width="110" height="110">
                                    </td>
                                    <td width="85%">
                                    	<table width="100%">
                                        <tr>
                                        	<td><u>Patient No.</u></td>
                                            <td width="13%"><u>Age</u></td>
                                            <td width="63%"><u>Address</u></td>
                                        </tr>
                                        <tr>
                                        	<td><?php echo $patientInfo->patient_no?></td>
                                            <td><?php echo $patientInfo->age?></td>
                                            <td><?php echo $patientInfo->address?></td>
                                        </tr>
                                        <tr>
                                			<td width="24%"><u>Patient Name</u></td>
                                            <td><u>Gender</u></td>
                                            <td><u>Civil Status</u></td>
                                		</tr>
                                        <tr>
                                        	<td width="24%"><?php echo $patientInfo->name?></td>
                                            <td><?php echo $patientInfo->gender?></td>
                                            <td><?php echo $patientInfo->civil_status?></td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                                	
                            </div>
                        </div>
                    </div>
                 </div>
                 
                 
                 <form method="post" action="<?php echo base_url();?>app/opd/save_opd" onSubmit="return confirm('Are you sure you want to save?');">
                 <input type="hidden" name="patient_no" value="<?php echo $patientInfo->patient_no?>">
                 <div class="row">
                 	
                     <div class="col-md-12">
                    	 <div class="box">
                         	 <div class="box-header">
                             	<div class="box-footer clearfix">
                            	
                                            <a href="<?php echo base_url();?>app/patient" class="btn btn-default">Cancel</a>
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                 
                            	</div>
                             </div>
                        	<div class="box-body table-responsive">
                            		
                                    
                            						<?php
													$userID = $lastOPDNo->opdNo;
													$userID2 = $lastOPDNo->opdNo;
                                                    
                                                    // Generate New Case No Format: S + Branch + YYMM + Seq
                                                    $branch = "01"; // Default Branch Code
                                                    $ym = date('ym');
                                                    $seq = str_pad($userID, 5, "0", STR_PAD_LEFT);
                                                    $newCaseNo = "S" . $branch . $ym . $seq;
													?>
                                 <?php echo validation_errors();?>                  
                                <div class="nav-tabs-custom">
                                	<ul class="nav nav-tabs">
                                		<li class="active"><a href="#tab_1" data-toggle="tab">General Information</a></li>
                                    	<!--
										<li><a href="#tab_3" data-toggle="tab">Vital Parameters</a></li>
                                        <li><a href="#tab_2" data-toggle="tab">Patient History</a></li>
                                        -->
                                	</ul>
                                    <input type="hidden" name="userID2" value="<?php echo $userID2?>">
                                    <div class="tab-content">
                                    	<div class="tab-pane active" id="tab_1">
                                        	<table width="100%" cellpadding="3" cellspacing="3">
                                <tr>
                                	<td width="21%">Case No.</td>
                                    <td width="79%"><input class="form-control input-sm" name="opdNo" id="opdNo" type="text" style="width: 150px;" required readonly value="<?php echo $newCaseNo;?>"></td>
                                </tr>
                                <!--
                                <tr>
                                	<td>Referal Doctor</td>
                                    <td>
                                    						<select name="refdoctor" id="refdoctor" class="form-control input-sm" style="width: 200px;">
                                                            	<option value="">- Referal Doctor -</option>
                                                            	<?php 
																foreach($doctorList as $doctorList){
																if($_POST['refdoctor'] == $doctorList->user_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $doctorList->user_id;?>" <?php echo $selected;?>><?php echo $doctorList->name;?></option>
                                                                <?php }?>
                                                            </select>
                                    </td>
                                </tr>
                                -->
                                <tr>
                                	<td>Department</td>
                                    <td>
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
                                	<td>Consultant Doctor</td>
                                    <td>
                          						<select name="doctor" id="doctor" class="form-control input-sm" style="width: 200px;" required onchange="updateReferralDoctor()">
                                      	<option value="">- Consultant Doctor -</option>
                                      	<?php 
        																foreach($doctorList2 as $doctorList2){
        																if($_POST['doctor'] == $doctorList2->user_id){
        																	$selected = "selected='selected'";
        																}else{
        																	$selected = "";
        																}
        																?>
                                      	<option value="<?php echo $doctorList2->user_id;?>" <?php echo $selected;?>><?php echo $doctorList2->name;?></option>
                                          <?php }?>
                                      </select>
                                      <!-- Hidden Referral Doctor Field (Same as Consultant) -->
                                      <input type="hidden" name="refdoctor" id="refdoctor_hidden" value="">
                                    </td>
                                </tr>
                                <tr>
                                	<td valign="top">Medical Concerns</td>
                                	<td><textarea name="complaints" id="complaints" class="form-control input-sm" style="width: 60%;" rows="3" placeholder="Enter patient's medical concerns, complaints, or reason for visit..."></textarea></td>
                                </tr>
                                
                                </table>
                                        </div>
                                        
                                        <!-- Hidden Inputs for Unused Fields -->
                                        <input type="hidden" name="diagnosis" value="">
                                        <input type="hidden" name="pulse_rate" value="">
                                        <input type="hidden" name="bp" value="">
                                        <input type="hidden" name="temperature" value="">
                                        <input type="hidden" name="respiration" value="">
                                        <input type="hidden" name="height" value="">
                                        <input type="hidden" name="weight" value="">
                                        <input type="hidden" name="allergies" value="">
                                        <input type="hidden" name="warnings" value="">
                                        <input type="hidden" name="social_history" value="">
                                        <input type="hidden" name="family_history" value="">
                                        <input type="hidden" name="personal_history" value="">
                                        <input type="hidden" name="past_medical_history" value="">
                                        
										
                                    </div>
                                </div>
                            	
                                 <input type="hidden" name="userID2" value="<?php echo $userID2;?>">
                                 
                                     
                                
                           </div>
                            <div class="box-footer clearfix">
                                	
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
        
         <!-- BDAY -->
         <script src="<?php echo base_url();?>public/datepicker/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#cFrom').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
				
				$('#cTo').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
            
            });
            
            function updateReferralDoctor() {
                var consultant = document.getElementById("doctor").value;
                document.getElementById("refdoctor_hidden").value = consultant;
            }
        </script>
        <!-- END BDAY -->
        
        
    </body>
</html>