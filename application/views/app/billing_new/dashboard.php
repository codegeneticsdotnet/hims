<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Billing Dashboard
            <small>Overview</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Billing Dashboard</li>
        </ol>
        
        <div class="row">
            <!-- Quick Action Buttons -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo count($opd_patients);?>
                        </h3>
                        <p>
                            Pending OPD Bills
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/billing_new/opd" class="small-box-footer">
                        View List <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo count($ipd_patients);?>
                        </h3>
                        <p>
                            Admitted IPD
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/billing_new/ipd" class="small-box-footer">
                        View List <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            New
                        </h3>
                        <p>
                            OPD Registration
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-plus-circled"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/opd/registration" class="small-box-footer">
                        Register New <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
             <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            Reports
                        </h3>
                        <p>
                            Billing Reports
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/reports/daily_sales" class="small-box-footer">
                        View Reports <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Recent Pending OPD</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Patient No</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $count = 0;
                                    foreach($opd_patients as $row):
                                        if($count >= 5) break; // Show only recent 5
                                        $count++;
                                    ?>
                                    <tr>
                                        <td><?php echo $row->patient_no;?></td>
                                        <td><?php echo $row->patient_name;?></td>
                                        <td><?php echo date('M d', strtotime($row->date_visit));?></td>
                                        <td>
                                            <a href="<?php echo base_url()?>app/billing_new/create_bill/<?php echo $row->patient_no;?>/OPD/<?php echo $row->IO_ID;?>" class="btn btn-primary btn-xs">
                                                Bill
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?php echo base_url()?>app/billing_new/opd" class="btn btn-sm btn-info btn-flat pull-right">View All OPD</a>
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Recent Admitted IPD</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Patient No</th>
                                        <th>Name</th>
                                        <th>Admitted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $count = 0;
                                    foreach($ipd_patients as $row):
                                        if($count >= 5) break; // Show only recent 5
                                        $count++;
                                    ?>
                                    <tr>
                                        <td><?php echo $row->patient_no;?></td>
                                        <td><?php echo $row->patient_name;?></td>
                                        <td><?php echo date('M d', strtotime($row->date_visit));?></td>
                                        <td>
                                            <a href="<?php echo base_url()?>app/billing_new/create_bill/<?php echo $row->patient_no;?>/IPD/<?php echo $row->IO_ID;?>" class="btn btn-primary btn-xs">
                                                Bill
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?php echo base_url()?>app/billing_new/ipd" class="btn btn-sm btn-success btn-flat pull-right">View All IPD</a>
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
