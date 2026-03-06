<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pharmacy
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pharmacy</li>
        </ol>

        <div class="row">
            <div class="col-md-8">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Welcome to Pharmacy</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
						<p><strong>Sales</strong></p>
						<a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/pos">
                            <i class="fa fa-desktop"></i> POS
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/returns">
                            <i class="fa fa-reply"></i> Return
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/adjustments">
                            <i class="fa fa-tags"></i> Adjustments
                        </a>
						<p><strong>Inventory</strong></p>
						<a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/inventory_in">
                            <i class="fa fa-truck"></i> Receiving
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/stock_issuance">
                            <i class="fa fa-sign-out"></i> Issuance
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/inventory/stock_transfer">
                            <i class="fa fa-exchange"></i> Stock Transfer
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/ledger">
                            <i class="fa fa-book"></i> Ledger
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/items">
                            <i class="fa fa-list"></i> Item Master
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/void_transaction">
                            <i class="fa fa-ban"></i> Void Trans
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/medicine_category">
                            <i class="fa fa-list-alt"></i> Categories
                        </a>
                        <p><strong>Reports</strong></p>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy_reports/daily_sales">
                            <i class="fa fa-bar-chart-o"></i> Sales
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy_reports/daily_dispense">
                            <i class="fa fa-medkit"></i> Dispense
                        </a>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
     <!-- Low Stock Alert -->
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-warning"></i> Low Stock Alerts</h3>
                        <div class="box-tools pull-right">
                            <span class="badge bg-red"><?php echo isset($low_stock) ? count($low_stock) : 0;?></span>
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding" style="max-height: 200px; overflow-y: auto;">
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
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-clock-o"></i> Expiring Soon (30 Days)</h3>
                        <div class="box-tools pull-right">
                            <span class="badge bg-yellow"><?php echo isset($expiring) ? count($expiring) : 0;?></span>
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding" style="max-height: 200px; overflow-y: auto;">
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
        
        <!-- Alerts Row -->
        <div class="row">
       
        
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