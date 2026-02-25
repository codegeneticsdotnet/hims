<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratory Services
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Lab Services</li>
        </ol>
        
        <div class="row">
            <!-- Quick Action Buttons -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            View
                        </h3>
                        <p>
                            All Service Requests
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/lab_services/service_request" class="small-box-footer">
                        View List <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            New
                        </h3>
                        <p>
                            Create Request
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-plus-circled"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/lab_services/add_request" class="small-box-footer">
                        Create New <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            Pending
                        </h3>
                        <p>
                            Pending Requests
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                    <!-- Assuming filter logic exists or just linking to main list for now -->
                    <a href="<?php echo base_url()?>app/lab_services/service_request" class="small-box-footer">
                        View Details <i class="fa fa-arrow-circle-right"></i>
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
                            Lab Reports
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="<?php echo base_url()?>app/lab_services/service_request" class="small-box-footer">
                        View List / Generate Reports <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Recent Service Requests</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Request No</th>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($recent_requests) && !empty($recent_requests)):?>
                                        <?php foreach($recent_requests as $row):?>
                                        <tr>
                                            <td><a href="<?php echo base_url()?>app/lab_services/view/<?php echo $row->request_id;?>"><?php echo $row->request_no;?></a></td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($row->request_date));?></td>
                                            <td><?php echo $row->patient_name;?></td>
                                            <td><?php echo $row->request_type;?></td>
                                            <td>
                                                <?php 
                                                $label = 'default';
                                                if($row->status == 'Pending') $label = 'warning';
                                                elseif($row->status == 'Active') $label = 'success';
                                                elseif($row->status == 'Cancelled') $label = 'danger';
                                                ?>
                                                <span class="label label-<?php echo $label;?>"><?php echo $row->status;?></span>
                                            </td>
                                            <td><?php echo number_format($row->total_amount, 2);?></td>
                                            <td>
                                                <a href="<?php echo base_url()?>app/lab_services/view/<?php echo $row->request_id;?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td colspan="7" class="text-center">No recent requests found.</td>
                                        </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?php echo base_url()?>app/lab_services/add_request" class="btn btn-sm btn-info btn-flat pull-left">Place New Request</a>
                        <a href="<?php echo base_url()?>app/lab_services/service_request" class="btn btn-sm btn-default btn-flat pull-right">View All Requests</a>
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
