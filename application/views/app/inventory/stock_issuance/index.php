<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Stock Issuance to Employees</h1>
        <a href="<?php echo base_url()?>app/inventory/add_stock_issuance" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> New Issuance</a>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
            <li class="active">Stock Issuance</li>
        </ol>
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box">
            <div class="box-header">
                <form action="" method="post" class="form-inline" style="padding: 10px;">
                    <div class="form-group">
                        <label for="start_date">From:</label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo $start_date;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">To:</label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo $end_date;?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                </form>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Issuance No</th>
                            <th>Date</th>
                            <th>Issued To</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($issuances)): ?>
                            <?php foreach($issuances as $iss): ?>
                            <tr>
                                <td><a href="<?php echo base_url()?>app/inventory/view_issuance/<?php echo $iss->issuance_id;?>"><?php echo $iss->issuance_no;?></a></td>
                                <td><?php echo date('M d, Y h:i A', strtotime($iss->issue_date));?></td>
                                <td><?php echo $iss->issued_to_name;?></td>
                                <td><?php echo $iss->remarks;?></td>
                                <td><span class="label label-success"><?php echo $iss->status;?></span></td>
                                <td>
                                    <a href="<?php echo base_url()?>app/inventory/view_issuance/<?php echo $iss->issuance_id;?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View</a>
                                    <a href="<?php echo base_url()?>app/inventory/print_issuance/<?php echo $iss->issuance_id;?>" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-print"></i> Print</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No issuances found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
