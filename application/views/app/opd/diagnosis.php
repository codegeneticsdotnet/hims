<?php require_once(APPPATH.'views/include/head.php');?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Patient Diagnosis
        </h1>
    </section>

            <!-- Right side column. Contains the navbar and content of the page 
            <aside class="right-side">                -->
                <!-- Main content -->
                <section class="content">
                    <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url()?>app/clinic/dashboard">Clinic Dashboard</a></li>
                        <li class="active">Patient Diagnosis</li>
                    </ol>
                    <br>
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
                            	<div style="margin-top: 15px;">
                                 <ul class="nav nav-pills nav-stacked">
                                 	<li><a href="<?php echo base_url()?>app/opd/view/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> General Information</a></li>
                                 	<li class="active"><a href="<?php echo base_url()?>app/opd/diagnosis/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Diagnosis</a></li>
                                 	<li><a href="<?php echo base_url()?>app/opd/medication/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Medication</a></li>
                                    <li><a href="<?php echo base_url()?>app/opd/complain/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Complain</a></li>
                                    <li><a href="<?php echo base_url()?>app/opd/vitalSign/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Vital Sign</a></li>
                                    <li><a href="<?php echo base_url()?>app/opd/patientHistory/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Patient History</a></li>
                                    <li><a href="<?php echo base_url()?>app/opd/laboratory/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Laboratory</a></li>
                                    <li><a href="<?php echo base_url()?>app/opd/discharge_summary/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Discharge Summary</a></li>
                                 </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-9"> 
                                <div class="box">
                                	<div class="box-header">
                                        <h3 class="box-title">Diagnosis History</h3>
                                        <div class="box-tools pull-right">
                                            <?php if($this->session->userdata('emr_viewing') == ""){?>	
                                                <?php if($getOPDPatient->nStatus == "Pending"){?>
                                                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Diagnosis</a>
                                                <?php }}?>
                                                <a href="<?php echo base_url()?>app/ipd_print/print_diagnosis/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                    
                                    <div class="box-body table-responsive no-padding">
                                        
                                        	<?php echo $this->session->flashdata('message');?>
                                            
                                           <table class="table table-hover table-striped">
                                           <thead>
                                           <tr>
                                                <th>Date</th>
                                           		<th>Diagnosis</th>
                                                <th>Remarks</th>
                                                <th></th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <?php foreach($patientDiagnosis as $diagnosisList2){?>
                                           <tr>
                                                <td><?php echo date('M d, Y h:i A', strtotime($diagnosisList2->dDate));?></td>
                                           		<td><?php echo $diagnosisList2->diagnosis_name?></td>
                                                <td><?php echo $diagnosisList2->remarks?></td>
                                                <td>
                                                <?php if($this->session->userdata('emr_viewing') == ""){?>	
                                                <?php if($getOPDPatient->nStatus == "Pending"){?>
                                                <a href="#" onclick="editDiagnosis('<?php echo $diagnosisList2->iop_diag_id?>', '<?php echo $diagnosisList2->diagnosis_name?>', '<?php echo $diagnosisList2->remarks?>')">Edit</a> |
                                                <a href="<?php echo base_url()?>app/opd/delete_diagnos/<?php echo $diagnosisList2->iop_diag_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $getOPDPatient->patient_no?>" onClick="return confirm('Are you sure you want to remove?');">Remove</a>
                                                <?php }}?>
                                                </td>
                                           </tr>
                                           <?php }?>
                                           </tbody>
                                           </table>
                                            
                                            <br><br><br><br><br><br><br>
                                            <br><br><br><br><br><br><br>
                                            <br><br><br><br><br><br><br>
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
        
        <script>
        function editDiagnosis(id, name, remarks){
            $('#iop_diag_id').val(id);
            $('#diagnosis').val(name);
            $('textarea[name="remarks"]').val(remarks);
            $('#myModal').modal('show');
        }
        </script>
        
    </body>     <!-- BDAY -->
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
        </script>
        <!-- END BDAY -->
        
        <!-- Modal -->
                            <form method="post" action="<?php echo base_url()?>app/opd/save_diagnosis" onSubmit="return confirm('Are you sure you want to save?');">
                                            <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
                                            <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
                                            <input type="hidden" name="iop_diag_id" id="iop_diag_id">
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Diagnosis</h4>
                                        </div>
                                        <div class="modal-body">
                                        <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                        	<td>Diagnosis</td>
                                            <td>
                                            <input list="diagnosis_list" name="diagnosis" id="diagnosis" class="form-control input-sm" style="width: 100%; text-transform: uppercase;" required autocomplete="off" placeholder="Type to search or enter new...">
                                            <datalist id="diagnosis_list">
                                                <?php foreach($diagnosisList as $diagnosisList2){?>
                                                <option value="<?php echo $diagnosisList2->diagnosis_name;?>">
                                                <?php }?>
                                            </datalist>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>Remarks</td>
                                            <td><textarea name="remarks" placeholder="Remarks" class="form-control input-sm" style="width: 100%; text-transform: uppercase;" rows="3"></textarea></td>
                                        </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button name="btnSubmit" class="btn btn-primary" id="btnSubmit" type="submit" style="font-size:12px;">Save</button>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            </form>
                            <!-- /.modal -->        
        
        
    </body>
</html>