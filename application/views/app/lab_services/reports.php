<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratory Reports
            <small>Generate Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/lab_services">Lab Services</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="box box-primary no-print">
            <div class="box-header">
                <h3 class="box-title">Filter Reports</h3>
            </div>
            <div class="box-body">
                <form method="post" action="" target="_blank">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="cFrom" class="form-control" value="<?php echo $cFrom;?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="cTo" class="form-control" value="<?php echo $cTo;?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="submit" name="btn_submit" value="html" class="btn btn-primary"><i class="fa fa-eye"></i> Generate Report</button>
                                <button type="submit" name="btn_submit" value="excel" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if(isset($reports)): ?>
        <div class="box box-success">
            <div class="box-header no-print">
                <h3 class="box-title">Report Result</h3>
            </div>
            <div class="box-body table-responsive">
                <div class="no-print" style="margin-bottom: 20px;">
                    <button onclick="window.print()" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                </div>
                
                <div class="text-center">
                    <h3>Laboratory Services Report</h3>
                    <p>From: <?php echo date('M d, Y', strtotime($cFrom));?> To: <?php echo date('M d, Y', strtotime($cTo));?></p>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date Request</th>
                            <th>Request No</th>
                            <th>Patient Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        if(!empty($reports)):
                            foreach($reports as $row):
                                $grand_total += $row->total_amount;
                        ?>
                        <tr>
                            <td><?php echo date('M d, Y', strtotime($row->request_date));?></td>
                            <td><?php echo $row->request_no;?></td>
                            <td><?php echo $row->patient_name;?></td>
                            <td><?php echo $row->request_type;?></td>
                            <td><?php echo $row->status;?></td>
                            <td class="text-right"><?php echo number_format($row->total_amount, 2);?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No records found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                            <td class="text-right"><strong><?php echo number_format($grand_total, 2);?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Core Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>
