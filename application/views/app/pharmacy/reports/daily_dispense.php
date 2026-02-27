<?php require_once(APPPATH.'views/include/head.php');?>
        <section class="content-header">
            <h1>Pharmacy Dispense Report</h1>
        </section>

        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
                <li class="active">Dispense Report</li>
            </ol>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Filter Options</h3>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url()?>app/pharmacy_reports/daily_dispense" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" name="cFrom" class="form-control" value="<?php echo isset($cFrom) ? $cFrom : date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" name="cTo" class="form-control" value="<?php echo isset($cTo) ? $cTo : date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" name="btnView" value="view" class="btn btn-primary btn-block"><i class="fa fa-eye"></i> View Report</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if(isset($dispense)): ?>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Dispense Results</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoice No</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0;
                            if(count($dispense) > 0): 
                                foreach($dispense as $row): 
                                    $grand_total += $row->total;
                            ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($row->date_sale));?></td>
                                <td><?php echo $row->invoice_no;?></td>
                                <td><?php echo $row->item_name;?></td>
                                <td><?php echo $row->category_name ? $row->category_name : '-';?></td>
                                <td><?php echo $row->qty;?></td>
                                <td><?php echo number_format($row->price, 2);?></td>
                                <td><?php echo number_format($row->total, 2);?></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No records found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">Grand Total</th>
                                <th><?php echo number_format($grand_total, 2);?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </section>
    </aside>
</div>

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>
