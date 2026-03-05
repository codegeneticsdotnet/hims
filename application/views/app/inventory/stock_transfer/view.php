<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Transfer Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/inventory/stock_transfer">Stock Transfers</a></li>
            <li class="active">View Transfer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">Transfer No: <?php echo $header->transfer_no;?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-default btn-sm" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <p><strong>From:</strong> <?php echo $header->from_branch_name ? $header->from_branch_name : 'Main Inventory (Central Pharmacy)';?></p>
                        <p><strong>To:</strong> <?php echo $header->to_branch_name;?></p>
                        <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($header->created_date));?></p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Created By:</strong> <?php echo $header->created_by_name;?></p>
                        <p><strong>Status:</strong> 
                            <?php 
                            $label = 'default';
                            if($header->status == 'Pending') $label = 'warning';
                            elseif($header->status == 'Received') $label = 'success';
                            elseif($header->status == 'Cancelled') $label = 'danger';
                            ?>
                            <span class="label label-<?php echo $label;?>"><?php echo $header->status;?></span>
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Remarks:</strong> <?php echo $header->remarks;?></p>
                        <?php if($header->status == 'Received'): ?>
                            <p><strong>Received By:</strong> <?php echo $header->received_by_name;?></p>
                            <p><strong>Received Date:</strong> <?php echo date('M d, Y H:i:s', strtotime($header->received_date));?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Qty Requested</th>
                                <th>Qty Issued</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($details as $item): ?>
                            <tr>
                                <td><?php echo $item->drug_name;?></td>
                                <td><?php echo $item->uom_name;?></td>
                                <td><?php echo $item->qty_requested;?></td>
                                <td><?php echo $item->qty_issued;?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <?php if($header->status == 'Pending'): ?>
                    <a href="<?php echo base_url()?>app/inventory/receive_transfer/<?php echo $header->transfer_id;?>" class="btn btn-success" onclick="return confirm('Are you sure you want to receive this transfer? This will update your stock.')"><i class="fa fa-check"></i> Receive Transfer</a>
                    <a href="<?php echo base_url()?>app/inventory/cancel_transfer/<?php echo $header->transfer_id;?>" class="btn btn-danger pull-right" onclick="return confirm('Are you sure you want to cancel this transfer? Stock will be returned to source.')"><i class="fa fa-times"></i> Cancel Transfer</a>
                <?php endif; ?>
                <a href="<?php echo base_url()?>app/inventory/stock_transfer" class="btn btn-default">Back to List</a>
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
