<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            IPD Dashboard
            <small>In-Patient Department</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">IPD Dashboard</li>
        </ol>
        
        <div class="row">
            <!-- Admitted Patients -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $counts['admitted'];?>
                        </h3>
                        <p>
                            Admitted Patients
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/ipd/index" class="small-box-footer">
                        View List <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <!-- Available Beds -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            <?php echo $counts['available_beds'];?>
                        </h3>
                        <p>
                            Available Beds
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios7-medkit"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/room_management/dashboard" class="small-box-footer">
                        View Room Status <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <!-- Discharged -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?php echo $counts['discharged'];?>
                        </h3>
                        <p>
                            Discharged
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-log-out"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/ipd/index" class="small-box-footer">
                        View List <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
             <!-- Quick Actions -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            Admit
                        </h3>
                        <p>
                           New Patient
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-plus-circled"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/ipd/admit_patient" class="small-box-footer">
                        Admit Patient <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Recent Admissions</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url()?>app/ipd/admit_patient" class="btn btn-success btn-flat pull-right"><i class="fa fa-plus"></i> Admit New Patient</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Admit Date</th>
                                        <th>IPD No</th>
                                        <th>Patient No</th>
                                        <th>Patient Name</th>
                                        <th>Room / Bed</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($recent_admitted) && !empty($recent_admitted)): ?>
                                    <?php foreach($recent_admitted as $row):?>
                                    <tr>
                                        <td><?php echo date('M d, Y h:i A', strtotime($row->date_visit));?></td>
                                        <td><?php echo $row->IO_ID;?></td>
                                        <td><?php echo $row->patient_no;?></td>
                                        <td><?php echo $row->patient_name;?></td>
                                        <td><?php echo $row->room_name . ' / ' . $row->bed_name;?></td>
                                        <td>
                                            <?php if($row->nStatus == 'Pending'): ?>
                                                <span class="label label-warning">Admitted</span>
                                            <?php elseif($row->nStatus == 'Discharged'): ?>
                                                <span class="label label-success">Discharged</span>
                                            <?php else: ?>
                                                <span class="label label-default"><?php echo $row->nStatus;?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?php echo base_url()?>app/ipd/view/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-primary btn-xs" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?php echo base_url()?>app/ipd/room_transfer/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-warning btn-xs" title="Transfer Room">
                                                    <i class="fa fa-exchange"></i>
                                                </a>
                                                <a href="<?php echo base_url()?>app/ipd/discharge/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-danger btn-xs" title="Discharge" onclick="return confirm('Are you sure you want to discharge this patient?');">
                                                    <i class="fa fa-sign-out"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No recent admissions found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?php echo base_url()?>app/ipd/index" class="btn btn-sm btn-default btn-flat pull-right">View All Admissions</a>
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