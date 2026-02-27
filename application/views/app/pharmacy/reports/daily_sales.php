<?php require_once(APPPATH.'views/include/head.php');?>

        <section class="content-header">
            <h1>Pharmacy Sales Report</h1>
        </section>

        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
                <li class="active">Sales Report</li>
            </ol>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Filter Options</h3>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url()?>app/pharmacy_reports/daily_sales" method="post">
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

            <?php if(isset($sales)): ?>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Report Results</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="box-body table-responsive" id="printableArea">
                    <h4 class="text-center" style="display:none;" id="printHeader">
                        <?php echo $this->session->userdata('company_name');?> Pharmacy<br>
                        Sales Report<br>
                        <small>From: <?php echo date('M d, Y', strtotime($cFrom));?> To: <?php echo date('M d, Y', strtotime($cTo));?></small>
                    </h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Payment Type</th>
                                <th class="text-right">Sub Total</th>
                                <th class="text-right">Discount</th>
                                <th class="text-right">Net Total</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0;
                            if(count($sales) > 0): 
                                foreach($sales as $row): 
                                    $grand_total += $row->total_amount;
                            ?>
                            <tr>
                                <td><?php echo $row->invoice_no;?></td>
                                <td><?php echo date('M d, Y h:i A', strtotime($row->date_sale));?></td>
                                <td><?php echo $row->patient_name ? $row->patient_name : $row->patient_full_name;?></td>
                                <td>
                                    <?php 
                                    if($row->payment_type == 'Charge'){
                                        echo '<span class="label label-danger">Charge (IPD)</span>';
                                    } else {
                                        echo '<span class="label label-success">Cash</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-right"><?php echo number_format($row->sub_total, 2);?></td>
                                <td class="text-right"><?php echo number_format($row->discount, 2);?></td>
                                <td class="text-right"><?php echo number_format($row->total_amount, 2);?></td>
                                <td><?php echo $row->remarks;?></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No records found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">Grand Total</th>
                                <th class="text-right"><?php echo number_format($grand_total, 2);?></th>
                                <th></th>
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

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     
     // Show header for print
     document.getElementById('printHeader').style.display = 'block';

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
</body>
</html>
