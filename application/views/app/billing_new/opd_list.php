<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pending OPD Bills
            <small>Out Patient Department</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/billing_new">Billing</a></li>
            <li class="active">OPD List</li>
        </ol>
        

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Pending OPD Patients</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Patient No</th>
                                        <th>Patient Name</th>
                                        <th>Visit Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($patients as $row):?>
                                    <tr>
                                        <td><?php echo date('M d, Y h:i A', strtotime($row->date_visit));?></td>
                                        <td><?php echo $row->patient_no;?></td>
                                        <td><?php echo $row->patient_name;?></td>
                                        <td>
                                            <span class="label label-<?php echo ($row->type == 'OPD Consultation') ? 'primary' : 'warning';?>">
                                                <?php 
                                                    if($row->type == 'OPD Consultation') echo "OPD";
                                                    else echo "Lab Services";
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url()?>app/billing_new/create_bill/<?php echo $row->patient_no;?>/OPD/<?php echo $row->IO_ID;?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-money"></i> Bill
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm">
                                                <i class="fa fa-arrow-right"></i> Discharge
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <!-- Footer content if needed -->
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
