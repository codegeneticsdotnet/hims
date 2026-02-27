<?php require_once(APPPATH.'views/include/head.php');?>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <?php require_once(APPPATH.'views/include/sidebar.php');?>

            <!-- Right side column. Contains the navbar and content of the page -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Patient History</h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Nurse Module</a></li>
                        <li><a href="#">In-Patient Information</a></li>
                        <li class="active">Patient History</li>
                    </ol>
                 
        
                 
                 
               
                 <div class="row">
                 	
                     <div class="col-md-3">
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
									<img src="<?php echo base_url();?>public/patient_picture/<?php echo $picture;?>" class="img-rounded" width="86" height="81">
                                    </td>
                                    <td>
                                    	<table width="100%">
                                        <tr>
                                        	<td><u>Patient No.</u></td>
                                        </tr>
                                        <tr>
                                			<td><?php echo $patientInfo->patient_no?></td>
                                		</tr>
                                        <tr>
                                        	<td><u>Patient Name</u></td>
                                        </tr>
                                        <tr>
                                			<td><?php echo $patientInfo->name?></td>
                                		</tr>
                                        </table>
                                    </td>
                                </tr>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            	<table class="table">
                                <tr>
                                	<td><u>IOP No.</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->IO_ID;?></td>
                                </tr>
                                <tr>
                                	<td><u>Date Time Admit</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo date("M d, Y", strtotime($getOPDPatient->date_visit));?>&nbsp;<?php echo date("H:i:s A", strtotime($getOPDPatient->time_visit));?></td>
                                </tr>
                                <tr>
                                	<td><u>In-Charge Doctor</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->con_doctor;?></td>
                                </tr>
                                <tr>
                                	<td><u>Department</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->dept_name;?></td>
                                </tr>
                                <tr>
                                	<td><u>Room</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->room_name;?></td>
                                </tr>
                                <tr>
                                	<td><u>Bed No.</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->bed_name;?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                     
                     <div class="col-md-9"> 
                                <div class="nav-tabs-custom">
                                	<ul class="nav nav-tabs">
                                		<li class="active"><a href="#tab_1" data-toggle="tab">Patient History</a></li>
                                        
                                	</ul>
                                    <div class="tab-content">
                                    	<div class="tab-pane active" id="tab_1">
                                        	
                                            <form method="post" action="<?php echo base_url()?>app/nurse_module/save_patientHistory" onSubmit="return confirm('Are you sure you want to save?');">
                                            <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
                                            <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
                                           
                                           
                                            
                                            
                                            <?php echo $message;?>
                                           <table class="table table-hover">
                                           <tbody>
                                            <tr>
                                	<td width="21%" valign="top">Allergies</td>
                                	<td width="79%"><textarea name="allergies" id="allergies" class="form-control input-sm" style="width: 60%;" rows="3"><?php echo $getOPDPatient->allergies?></textarea></td>
                                </tr>
                                <tr>
                                	<td valign="top">Warnings</td>
                                	<td><textarea name="warnings" id="warnings" class="form-control input-sm" style="width: 60%;" rows="3"><?php echo $getOPDPatient->warnings?></textarea></td>
                                </tr>
                                <tr>
                                	<td valign="top">Social History</td>
                                	<td><textarea name="social_history" id="social_history" class="form-control input-sm" style="width: 60%;" rows="3"><?php echo $getOPDPatient->social_history?></textarea></td>
                                </tr>
                                <tr>
                                	<td valign="top">Family History</td>
                                	<td><textarea name="family_history" id="family_history" class="form-control input-sm" style="width: 60%;" rows="3"><?php echo $getOPDPatient->family_history?></textarea></td>
                                </tr>
                                <tr>
                                	<td valign="top">Personal History</td>
                                	<td><textarea name="personal_history" id="personal_history" class="form-control input-sm" style="width: 60%;" rows="3"><?php echo $getOPDPatient->personal_history?></textarea></td>
                                </tr>
                                <tr>
                                	<td valign="top">Past Medical History</td>
                                	<td><textarea name="past_medical_history" id="past_medical_history" class="form-control input-sm" style="width: 60%;" rows="3"><?php echo $getOPDPatient->past_medical_history?></textarea></td>
                                </tr>
                                <tr>
                                           		<td colspan="2">
                                                <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                           
                                                <a href="<?php echo base_url()?>app/ipd_print/print_patient_history/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Print</a>
                                                </td>
                                           </tr>
                                           </tbody>
                                           </table>
                                           </form>
                                            
                                            <br><br><br><br><br><br><br>
                                            <br><br><br><br><br><br><br>
                                            <br><br><br><br><br><br><br>
                                        </div>
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