<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Inventory Dashboard</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-md-12" style="margin-bottom: 20px;">
                <a class="btn btn-app" href="<?php echo base_url()?>app/inventory/stock_transfer">
                    <i class="fa fa-exchange"></i> Stock Transfers
                </a>
                <a class="btn btn-app" href="<?php echo base_url()?>app/inventory/stock_issuance">
                    <i class="fa fa-sign-out"></i> Stock Issuance
                </a>
                <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/inventory_in">
                    <i class="fa fa-truck"></i> Receiving
                </a>
            </div>
            
            <!-- Low Stock Alert -->
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-warning"></i> Low Stock Alerts</h3>
                        <div class="box-tools pull-right">
                            <span class="badge bg-red"><?php echo count($low_stock);?></span>
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($low_stock)): ?>
                                    <?php foreach($low_stock as $item): ?>
                                    <tr>
                                        <td><?php echo $item->drug_name;?></td>
                                        <td><span class="badge bg-red"><?php echo $item->nStock;?></span></td>
                                        <td><?php echo $item->re_order_level;?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center">No low stock items.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Expiry Alert -->
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-clock-o"></i> Expiring Soon (30 Days)</h3>
                        <div class="box-tools pull-right">
                            <span class="badge bg-yellow"><?php echo count($expiring);?></span>
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Batch No</th>
                                    <th>Expiry Date</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($expiring)): ?>
                                    <?php foreach($expiring as $item): ?>
                                    <tr>
                                        <td><?php echo $item->item_name;?></td>
                                        <td><?php echo $item->batch_no;?></td>
                                        <td><?php echo date('M d, Y', strtotime($item->expiry_date));?></td>
                                        <td><?php echo $item->qty;?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">No expiring items found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Recent Transfers -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Recent Stock Transfers</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Transfer No</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($recent_transfers)): ?>
                                    <?php foreach($recent_transfers as $trans): ?>
                                    <tr>
                                        <td><?php echo $trans->transfer_no;?></td>
                                        <td><?php echo $trans->from_dept_name ? $trans->from_dept_name : 'Main Inventory';?></td>
                                        <td><?php echo $trans->to_dept_name;?></td>
                                        <td><?php echo date('M d, Y', strtotime($trans->created_date));?></td>
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
                                            <a href="<?php echo base_url()?>app/inventory/view_transfer/<?php echo $trans->transfer_id;?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center">No recent transfers.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer text-center">
                        <a href="<?php echo base_url()?>app/inventory/stock_transfer" class="uppercase">View All Transfers</a>
                    </div>
                </div>
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
