            <?php require_once(APPPATH.'views/include/head.php');?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Dashboard</h1>
                </section>
                <section class="content">
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                    
                        <!--Start of Patient Visited-->
                        <div class="box box-primary" id="loading-example">
                            <div class="box-header">
                                <div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                 </div>
                                 <i class="fa fa-male"></i>
                                <h3 class="box-title">Today's Patient Appointments</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Patient No.</th>
                                            <th>Patient Name</th>
                                            <th>Appointment Date</th>
                                            <th>Consultant Doctor</th>
                                            <th>Entry Date</th>
                                            <th>Rremarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($getTodayAppointment as $getTodayAppointment){?>
                                        <tr>
                                            <th><a href="patient/view/<?php echo $getTodayAppointment->patient_no?>"><?php echo $getTodayAppointment->patient_no?></a></th>
                                            <th><?php echo $getTodayAppointment->name?></th>
                                            <th><?php echo date("M d, Y", strtotime($getTodayAppointment->appointmentDate))." ".$getTodayAppointment->appHour.":".$getTodayAppointment->appMinutes." ".$getTodayAppointment->appAMPM;?></th>
                                            <th><?php echo $getTodayAppointment->consultantDoctor?></th>
                                            <th><?php echo date("M d, Y", strtotime($getTodayAppointment->dateEntry));?></th>
                                            <th><?php echo $getTodayAppointment->appointmentReason?></th>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                             <div class="box-footer">
                            </div>
                        </div>
                        <!--End of Patient Visited-->
                    </section>
                </div>
                </section>

                <!-- Main content -->
                 
                 <div class="row">
                 	<section class="col-lg-6 connectedSortable">
                    
                    	<!--Start of New Patient-->
                    	<div class="box box-primary" id="loading-example">
                        	<div class="box-header">
                            	<div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                 </div>
                                 <i class="fa fa-male"></i>
								<h3 class="box-title">New Patient</h3>
                            </div>
                            <div class="box-body no-padding">
                            	<div class="table-responsive">
                                	<table class="table table-hover">
                                    <thead>
                                    	<tr>
                                        	<th>Patient No.</th>
                                        	<th>Patient Name</th>
                                            <th>Date</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php foreach($latest_patient as $latest_patient){?>
                                        <tr>
                                        	<th><?php echo $latest_patient->patient_no?></th>
                                            <th><?php echo $latest_patient->patient?></th>
                                            <th><?php echo date("M d, Y h:i:s", strtotime($latest_patient->date_entry2));?></th>
                                            <th><?php echo $latest_patient->age?></th>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer">
                            </div>
                        </div>
                        <!--End of New Patient-->
                        
                    </section>
                    
                    <section class="col-lg-6 connectedSortable">
                    
                    	<!--Start of Patient Visited-->
                    	<div class="box box-primary" id="loading-example">
                        	<div class="box-header">
                            	<div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                 </div>
                                 <i class="fa fa-male"></i>
								<h3 class="box-title">Visited Patient</h3>
                            </div>
                            <div class="box-body no-padding">
                            	<div class="table-responsive">
                                	<table class="table table-hover">
                                    <thead>
                                    	<tr>
                                        	<th>OPD No.</th>
                                        	<th>Patient Name</th>
                                            <th>Date</th>
                                            <th>Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php foreach($latest_visited_patient as $latest_visited_patient){?>
                                        <tr>
                                        	<th><?php echo $latest_visited_patient->IO_ID?></th>
                                            <th><?php echo $latest_visited_patient->patient?></th>
                                            <th><?php echo date("M d, Y", strtotime($latest_visited_patient->date_visit))." ".$latest_visited_patient->time_visit;?></th>
                                            <th><?php echo $latest_visited_patient->dept_name?></th>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                             <div class="box-footer">
                            </div>
                        </div>
                        <!--End of Patient Visited-->
                    </section>
                 </div>
                                <!-- Main content -->
                 <?php if($hasAccesstoDoctorAvail){?>   
                 <div class="row">
                    <section class="col-lg-6 connectedSortable">
                    
                        <!--Start of New Patient-->
                        <div class="box box-primary" id="loading-example">
                            <div class="box-header">
                                <div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                 </div>
                                 <i class="fa fa-user-md"></i>
                                 
                                <h3 class="box-title">Doctor's IN</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive" style="height:350px; overflow-y:scroll;">
                                    <div id="doctorIN"></div>
                                </div>
                            </div>
                            <div class="box-footer">
                            </div>
                        </div>
                        <!--End of New Patient-->
                        
                    </section>
                    
                    <section class="col-lg-6 connectedSortable">
                    
                        <!--Start of Patient Visited-->
                        <div class="box box-primary" id="loading-example">
                            <div class="box-header">
                                <div class="pull-right box-tools">
                                        <button class="btn btn-primary btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                 </div>
                                 <i class="fa fa-user-md"></i>
                                <h3 class="box-title">Doctor's OUT</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive" style="height:350px; overflow-y:scroll;">
                                    <div id="doctorOUT"></div>
                                </div>
                            </div>
                             <div class="box-footer">
                            </div>
                        </div>
                        <!--End of Patient Visited-->
                        
                    </section>
                 </div>
                 <?php }?>

                 





            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
         <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>     
         

         <script type="text/javascript">
         $(document).ready(function(){
            
            doctorOUTF();
            doctorINF();

         });

         function doctorOUTF()
         {
            $.ajax({
                url: "<?php echo base_url()?>general/getDoctorOUT",
                type: "POST",
                success: function(result){
                    $('#doctorOUT').html(result);
                },beforeSend: function(){
                    $('#doctorOUT').html("<center><img src='../public/img/ajax-loader.gif'></center>");
                }
            });
         }

         function doctorINF()
         {
            $.ajax({
                url: "<?php echo base_url()?>general/getDoctorIN",
                type: "POST",
                success: function(result){
                    $('#doctorIN').html(result);
                },beforeSend: function(){
                    $('#doctorIN').html("<center><img src='../public/img/ajax-loader.gif'></center>");
                }
            });
         }

         function doctorProcess(id,status)
         {
            if(confirm('Are you sure you want the doctor ' + status + '?'))
            {
                $.ajax({
                    url: "<?php echo base_url()?>general/procDocAvail/" + id + "/" + status,
                    type: "POST",
                    success: function()
                    {
                        alert('Doctor is ' + status);
                        doctorINF()
                        doctorOUTF()
                    },
                    beforeSend: function(){
                        $('#doctor' + status).html("<center><img src='../public/img/ajax-loader.gif'></center>");
                    }
                });
                return true;
            }
            else
            {
                return false;
            }

         }
         </script>
         
    </body>
</html>