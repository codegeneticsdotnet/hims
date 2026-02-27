<?php require_once(APPPATH.'views/include/head.php');?>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <?php require_once(APPPATH.'views/include/sidebar.php');?>

            <!-- Right side column. Contains the navbar and content of the page -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Intake/Output Record</h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Nurse Module</a></li>
                        <li><a href="#">In-Patient Information</a></li>
                        <li class="active">Intake/Output Record</li>
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
                                		<li class="active"><a href="#tab_1" data-toggle="tab">Intake/Output Records</a></li>
                                        
                                	</ul>
                                    <div class="tab-content">
                                    	<div class="tab-pane active" id="tab_1">
                                        	
                                            <?php echo $message;?>
                                           <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Intake Record</a>
                                       
                                           <a href="<?php echo base_url()?>app/ipd_print/print_intake/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Print</a>
                                	<div class="alt2" dir="ltr" style="
									margin: 0px;
									padding: 0px;
									border: 0px solid #919b9c;
									width: 100%;
									height: 300px;
									text-align: left;
									overflow: auto">
                                           <table class="table table-hover table-striped">
                                           <thead>
                                           		<tr>
                                                	<th>Date & Time</th>
                                                    <th>Particulars</th>
                                                    <th>I/V Fluids(ml)</th>
                                                    <th>Oral(ml)</th>
                                                    <th>No. of Stool</th>
                                                    <th>No. of Urine</th>
                                                    <th>Prepared By</th>
                                                    <th></th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                           <?php foreach($getIntake as $getIntake){?>
                                           <tr>
                                           		<td><?php echo date("M d, Y h:i:s A",strtotime($getIntake->dDateTime));?></td>
                                                <td><?php echo $getIntake->particulars?></td>
                                                <td><?php echo $getIntake->IV_fluids?></td>
                                                <td><?php echo $getIntake->oral?></td>
                                                <td><?php echo $getIntake->no_stool?></td>
                                                <td><?php echo $getIntake->no_urine?></td>
                                                <td><?php 
                        												$ci_obj = & get_instance();
                        												$ci_obj->load->model('app/general_model');
                        												$pages = $ci_obj->general_model->getPreparedBy($getIntake->cPreparedBy);
                        												
                        												echo $pages->cPreparedBy?></td>
                                                <td>
                                                <a href="<?php echo base_url()?>app/nurse_module/delete_intake/<?php echo $getIntake->intake_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $getOPDPatient->patient_no?>" onClick="return confirm('Are you sure you want to remove?');">Remove</a>
                                           
                                                </td>
                                           </tr>
                                           <?php }?> 
                                           </tbody>
                                           </table>
                                           </div>
                                           
                                           <hr>
                                           <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus"></i> Add Output Record</a>
                                        
                                           <a href="<?php echo base_url()?>app/ipd_print/print_output/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Print</a>
                                	<div class="alt2" dir="ltr" style="
									margin: 0px;
									padding: 0px;
									border: 0px solid #919b9c;
									width: 100%;
									height: 300px;
									text-align: left;
									overflow: auto">
                                           <table class="table table-hover table-striped">
                                           <thead>
                                           		<tr>
                                                	<th>Date & Time</th>
                                                    <th>Urine(ml)</th>
                                                    <th>Feaces(ml)</th>
                                                    <th>Respitation(ml)</th>
                                                    <th>skin(ml)</th>
                                                    <th>Prepared By</th>
                                                    <th></th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                           <?php foreach($getOutput as $getOutput){?>
                                           <tr>
                                           		<td><?php echo date("M d, Y h:i:s A",strtotime($getOutput->dDateTime));?></td>
                                                <td><?php echo $getOutput->urine?></td>
                                                <td><?php echo $getOutput->feaces?></td>
                                                <td><?php echo $getOutput->respitation?></td>
                                                <td><?php echo $getOutput->skin?></td>
                                                <td><?php 
												$ci_obj = & get_instance();
												$ci_obj->load->model('app/general_model');
												$pages = $ci_obj->general_model->getPreparedBy($getOutput->cPreparedBy);
												
												echo $pages->cPreparedBy?></td>
                                                <td>
                                                <a href="<?php echo base_url()?>app/nurse_module/delete_output/<?php echo $getOutput->output_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $getOPDPatient->patient_no?>" onClick="return confirm('Are you sure you want to remove?');">Remove</a>
                                              
                                                </td>
                                           </tr>
                                           <?php }?> 
                                           </tbody>
                                           </table>
                                           </div>
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
        
         <!-- BDAY -->

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
        </script>
        <!-- END BDAY -->
        
							<!-- Modal -->
                            <form method="post" action="<?php echo base_url()?>app/nurse_module/save_intake" onSubmit="return confirm('Are you sure you want to save?');">
                            <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
                            <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Intake Record</h4>
                                        </div>
                                        <div class="modal-body">
                                        <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                        	<td>Date</td>
                                            <td><input type="text" name="dDate" id="dDate" value="<?php echo date("Y-m-d");?>" placeholder="Date" class="form-control input-sm" style="width: 100%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Time</td>
                                            <td>
                                             <div class="bootstrap-timepicker">
                                        	<div class="form-group">
                                            <div class="input-group">                                            
                                                <input type="text" class="form-control timepicker" name="cTime" id="cTime"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div><!-- /.input group -->
                                        	</div><!-- /.form group -->
                                    		</div>
                                            
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>Particular</td>
                                            <td><input type="text" name="particular" placeholder="Particular" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>I/V Fluids(ml)</td>
                                            <td><input type="text" name="fluids" placeholder="I/V Fluids(ml)" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Oral(ml)</td>
                                            <td><input type="text" name="oral" placeholder="Oral(ml)" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>No. of Stool</td>
                                            <td><input type="text" name="no_stool" placeholder="No. of Stool" value="0" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>No. of Urine</td>
                                            <td><input type="text" name="no_urine" placeholder="No. of Urine" value="0" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="btnSave">Save</button>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            </form>
                            <!-- /.modal -->     
                            
                            
                            
		
        
        
        
        
        <!-- Modal -->
                            <form method="post" action="<?php echo base_url()?>app/nurse_module/save_output" onSubmit="return confirm('Are you sure you want to save?');">
                            <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
                            <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
                            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Output Record</h4>
                                        </div>
                                        <div class="modal-body">
                                        <table class="table">
                                        <tbody>
                                        <tr>
                                        	<td>Date</td>
                                            <td><input type="text" name="dDate2" id="dDate2" value="<?php echo date("Y-m-d");?>" placeholder="Date" class="form-control input-sm" style="width: 100%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Time</td>
                                            <td>
                                             <div class="bootstrap-timepicker">
                                        	<div class="form-group">
                                            <div class="input-group">                                            
                                                <input type="text" class="form-control timepicker" name="cTime2" id="cTime2"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div><!-- /.input group -->
                                        	</div><!-- /.form group -->
                                    		</div>
                                            
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>Urine(ml)</td>
                                            <td><input type="text" name="urine" placeholder="Urine(ml)" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Feaces(ml)</td>
                                            <td><input type="text" name="feaces" placeholder="Feaces(ml)" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Respitation(ml)</td>
                                            <td><input type="text" name="respitation" placeholder="Respitation(ml)" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Skin(ml)</td>
                                            <td><input type="text" name="skin" placeholder="Skin(ml)" class="form-control input-sm" style="width: 250px;" required></td>
                                        </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="btnSave">Save</button>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            </form>
                            <!-- /.modal -->     
        
        
        
        
        
        
        
        
        <!-- bootstrap time picker -->
        <script src="<?php echo base_url();?>public/timepicker/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            $(function() {

                //Timepicker
                $(".timepicker").timepicker({
                    showInputs: false
                });
            });
        </script>
        
         <!-- DATE -->
        <script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#dDate').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                }); 
				$('#dDate2').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
            
            });
        </script>
        <!-- END DATE -->
        
        
        
    </body>
</html>