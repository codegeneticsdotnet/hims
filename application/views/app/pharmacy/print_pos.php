<?php require_once(APPPATH.'views/include/head.php');?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaction Receipt
                <small>Preview</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
                <li class="active">Print Receipt</li>
            </ol>

            <div class="pad margin no-print">
                <div class="alert alert-info" style="margin-bottom: 0!important;">
                    <i class="fa fa-info"></i>
                    <b>Note:</b> This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                </div>
            </div>
        
            <section class="invoice">
            <!-- title row 
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> <?php echo $this->session->userdata('company_name');?>
                        <small class="pull-right">Date: <?php echo date('m/d/Y', strtotime($header->date_sale));?></small>
                    </h2>
                </div><!-- /.col ->
            </div>
            -->
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong><?php echo $this->session->userdata('company_name');?></strong><br>
                        <?php echo $this->session->userdata('company_address');?><br>
                        Phone: <?php echo $this->session->userdata('company_contact');?><br>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong><?php echo $header->patient_name ? $header->patient_name : 'Walk-in Patient';?></strong><br>
                        <?php if($header->patient_no): ?>
                        Patient ID: <?php echo $header->patient_no;?><br>
                        <?php endif; ?>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Pharmacy No. #<?php echo $header->invoice_no;?></b><br/>
                    <b>Trans Date:</b> <?php echo date('m/d/Y H:i:s', strtotime($header->date_sale));?><br/>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($details as $item): ?>
                            <tr>
                                <td><?php echo $item->qty;?></td>
                                <td><?php echo $item->item_name;?></td>
                                <td><?php echo number_format($item->total, 2);?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                   &nbsp;
                </div><!-- /.col -->
                <div class="col-xs-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td><?php echo number_format($header->sub_total, 2);?></td>
                            </tr>
                            <tr>
                                <th>Discount:</th>
                                <td><?php echo number_format($header->discount, 2);?></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td><?php echo number_format($header->total_amount, 2);?></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                    <a href="<?php echo base_url();?>app/pharmacy/pos" class="btn btn-primary pull-right"><i class="fa fa-credit-card"></i> Back to POS</a>
                </div>
            </div>
        </section>
    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>
