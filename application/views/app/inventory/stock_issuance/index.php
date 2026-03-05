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
            <div class="box-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Issuance No</th>
                            <th>Date</th>
                            <th>Issued To</th>
                            <th>Remarks</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($issuances)): ?>
                            <?php foreach($issuances as $iss): ?>
                            <tr>
                                <td><?php echo $iss->issuance_no;?></td>
                                <td><?php echo date('M d, Y', strtotime($iss->issue_date));?></td>
                                <td><?php echo $iss->issued_to_name;?></td>
                                <td><?php echo $iss->remarks;?></td>
                                <td><span class="label label-success"><?php echo $iss->status;?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">No issuances found.</td></tr>
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
