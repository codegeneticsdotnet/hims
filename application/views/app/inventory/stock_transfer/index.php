<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Stock Transfers</h1>
        <a href="<?php echo base_url()?>app/inventory/add_stock_transfer" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create New Transfer</a>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
            <li class="active">Stock Transfer</li>
        </ol>
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Transfer No</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($transfers)): ?>
                            <?php foreach($transfers as $trans): ?>
                            <tr>
                                <td><?php echo $trans->transfer_no;?></td>
                                <td><?php echo date('M d, Y', strtotime($trans->created_date));?></td>
                                <td><?php echo $trans->from_branch ? $trans->from_branch_name : 'Main Inventory (Central Pharmacy)';?></td>
                                <td><?php echo $trans->to_branch_name;?></td>
                                <td><?php echo $trans->remarks;?></td>
                                <td>
                                    <?php 
                                    $label = 'default';
                                    if($trans->status == 'Pending') $label = 'warning';
                                    elseif($trans->status == 'Received') $label = 'success';
                                    elseif($trans->status == 'Cancelled') $label = 'danger';
                                    ?>
                                    <span class="label label-<?php echo $label;?>"><?php echo $trans->status;?></span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url()?>app/inventory/view_transfer/<?php echo $trans->transfer_id;?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View</a>
                                    <a href="<?php echo base_url()?>app/inventory/print_transfer/<?php echo $trans->transfer_id;?>" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-print"></i> Print</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No transfers found.</td></tr>
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
