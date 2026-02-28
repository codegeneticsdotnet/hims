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
                    <table width="100%" cellpadding="5" cellspacing="0" border="0" style="border-collapse:collapse;">
                    <thead>
                        <tr style="font-weight:bold; background:#eee; border-bottom:1px solid #000;">
                            <th width="50%" style="padding:5px;">Description</th>
                            <th width="10%" style="padding:5px; text-align:center;">Qty</th>
                            <th width="20%" style="padding:5px; text-align:right;">Unit Price</th>
                            <th width="20%" style="padding:5px; text-align:right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $grand_total = 0;
                    if(isset($sales) && !empty($sales)){
                        foreach($sales as $row){
                            $grand_total += $row->total_amount;
                            // Fetch Details
                            $details = $this->pharmacy_model->getPOSDetails($row->sale_id);
                    ?>
                        <tr style="background:#f9f9f9; border-top:1px solid #ccc;">
                            <td colspan="4" style="padding:8px 10px;">
                                <strong>Invoice No:</strong> <?php echo $row->invoice_no;?> &nbsp;|&nbsp;
                                <strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($row->date_sale));?> &nbsp;|&nbsp;
                                <strong>Patient:</strong> <?php echo $row->patient_name ? $row->patient_name : $row->patient_full_name;?> &nbsp;|&nbsp;
                                <strong>Payment Type:</strong> <?php echo $row->payment_type;?>
                                <?php if(!empty($row->remarks)): ?>
                                    <br><strong>Remarks:</strong> <?php echo $row->remarks;?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        
                        <?php if($details): ?>
                            <?php foreach($details as $item): ?>
                            <tr>
                                <td style="padding:3px 10px; border-bottom:1px solid #eee; padding-left:30px;"><?php echo $item->item_name;?></td>
                                <td align="center" style="padding:3px; border-bottom:1px solid #eee;"><?php echo $item->qty;?></td>
                                <td align="right" style="padding:3px; border-bottom:1px solid #eee;"><?php echo number_format($item->price, 2);?></td>
                                <td align="right" style="padding:3px; border-bottom:1px solid #eee;"><?php echo number_format($item->total, 2);?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" align="center">No details available</td></tr>
                        <?php endif; ?>
                        
                        <?php if($row->discount > 0): ?>
                        <tr>
                            <td colspan="3" align="right" style="padding:3px;">
                                <strong>Less Discount:</strong>
                            </td>
                            <td align="right" style="padding:3px;"><?php echo number_format($row->discount, 2);?></td>
                        </tr>
                        <?php endif; ?>
                        
                        <tr>
                            <td colspan="3" align="right" style="padding:3px; padding-bottom:10px;"><strong>TOTAL:</strong></td>
                            <td align="right" style="padding:3px; padding-bottom:10px;"><strong><?php echo number_format($row->total_amount, 2);?></strong></td>
                        </tr>

                    <?php }} else { ?>
                        <tr><td colspan="4" align="center">No records found.</td></tr>
                    <?php } ?>
                    
                    <!-- Grand Total -->
                    <tr style="border-top:2px solid #000;">
                        <td colspan="2"></td>
                        <td align="right" style="padding:10px;"><strong>Grand Total:</strong></td>
                        <td align="right" style="padding:10px;"><strong><?php echo number_format($grand_total, 2);?></strong></td>
                    </tr>
                    
                    </tbody>
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
