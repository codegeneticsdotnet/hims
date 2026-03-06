<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Issuance Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/inventory/stock_issuance">Stock Issuance</a></li>
            <li class="active">View Issuance</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">Issuance No: <?php echo $header->issuance_no;?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-default btn-sm" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Issued To:</strong> <?php echo $header->issued_to_name;?></p>
                        <p><strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($header->issue_date));?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Created By:</strong> <?php echo $header->created_by_name;?></p>
                        <p><strong>Status:</strong> <span class="label label-success"><?php echo $header->status;?></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                         <p><strong>Remarks:</strong> <?php echo $header->remarks;?></p>
                    </div>
                </div>
                
                <div class="table-responsive" style="margin-top: 20px;">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Qty Issued</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($details as $item): ?>
                            <tr>
                                <td><?php echo $item->drug_name;?></td>
                                <td><?php echo $item->uom_name;?></td>
                                <td><?php echo $item->qty;?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <a href="<?php echo base_url()?>app/inventory/stock_issuance" class="btn btn-default">Back to List</a>
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