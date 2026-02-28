<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            OPD Dashboard
            <small>Out Patient Department</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">OPD Dashboard</li>
        </ol>
        
        <div class="row">
            <!-- Add New Patient 
            <div class="col-lg-3 col-xs-6">
                <!-- small box -- >
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            New
                        </h3>
                        <p>
                            Patient Registration
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/patient/addPatient" class="small-box-footer">
                        Register New Patient <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <!-- Doctor Patients -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            <?php echo $opd_counts['doctor_patients'];?>
                        </h3>
                        <p>
                            Doctor's Patients Today
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stethoscope"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/opd/registration" class="small-box-footer">
                        Add OPD Patient <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <!-- Lab/Xray -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?php echo $opd_counts['lab_requests'];?>
                        </h3>
                        <p>
                            Laboratory
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-flask"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/lab_services/add_request?request=L" class="small-box-footer">
                        Create Lab Request <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->

             <!-- X-Ray -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>
                            <?php echo $opd_counts['xray_requests'];?>
                        </h3>
                        <p>
                           X-Ray
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-nuclear"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/lab_services/add_request?request=X" class="small-box-footer">
                        Create X-Ray Request <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
             <!-- Ultrasound -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            <?php echo $opd_counts['ultrasound_requests'];?>
                        </h3>
                        <p>
                           Ultrasound
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-wifi"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/lab_services/add_request?request=U" class="small-box-footer">
                        Create Ultrasound Request <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Patients in Queue (Today)</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url()?>app/opd/registration" class="btn btn-success btn-flat pull-right"><i class="fa fa-plus"></i> Add OPD Patient</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>OPD No</th>
                                        <th>Patient No</th>
                                        <th>Patient Name</th>
                                        <th>Department</th>
                                        <th>Doctor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($opd_queue as $row):?>
                                    <tr>
                                        <td><?php echo date('h:i A', strtotime($row->time_visit));?></td>
                                        <td><?php echo $row->IO_ID;?></td>
                                        <td><?php echo $row->patient_no;?></td>
                                        <td><?php echo $row->name;?></td>
                                        <td><?php echo $row->dept_name;?></td>
                                        <td><?php echo $row->doctor;?></td>
                                        <td>
                                            <a href="<?php echo base_url()?>app/opd/view/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <!-- Add OPD Patient Button (Register existing to OPD) -->
                                            <!-- Usually this means adding another visit or checking them in -->
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">

                     </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Core Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>
