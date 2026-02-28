<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratory Services
            <small>Service Requests</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/lab_services">Lab Services</a></li>
            <li class="active">Service Requests</li>
        </ol>
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Filter Requests</h3>
            </div>
            <div class="box-body">
                <form method="post" action="" class="form-inline">
                    <div class="form-group">
                        <label>From: </label>
                        <input type="date" name="cFrom" class="form-control" value="<?php echo $cFrom;?>">
                    </div>
                    <div class="form-group">
                        <label>To: </label>
                        <input type="date" name="cTo" class="form-control" value="<?php echo $cTo;?>">
                    </div>
                    <div class="form-group">
                        <label>Search: </label>
                        <input type="text" name="search" class="form-control" placeholder="Req No / Patient Name" value="<?php echo $this->input->post('search');?>">
                    </div>
                    <button type="submit" name="btn_submit" value="filter" class="btn btn-primary">Filter</button>
                    <button type="submit" name="btn_submit" value="print" class="btn btn-default" formtarget="_blank"><i class="fa fa-print"></i> Print</button>
                    <button type="submit" name="btn_submit" value="excel" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                    <a href="<?php echo base_url()?>app/lab_services/add_request" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create New Request</a>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-body table-responsive">
                <?php echo $this->session->flashdata('message');?>
                
                <table width="100%" cellpadding="5" cellspacing="0" border="0" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th width="40%"></th>
                        <th width="60%" style="padding:0; border-bottom:1px solid #000;">
                             <table width="100%" cellpadding="3" cellspacing="0" border="0">
                                <tr style="font-weight:bold; background:#eee;">
                                    <td width="40%" style="padding:3px;">Description</td>
                                    <td width="20%" style="padding:3px;">Status</td>
                                    <td width="20%" style="padding:3px;">Remarks</td>
                                    <td width="20%" align="right" style="padding:3px;">Amount</td>
                                </tr>
                             </table>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($requests as $row): 
                    $details = $this->lab_services_model->getRequestDetails($row->request_id);
                ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td valign="top" style="padding:10px;" width="40%">
                            <strong>Request No:</strong> <a href="<?php echo base_url()?>app/lab_services/view/<?php echo $row->request_id;?>" style="text-decoration:none; color:blue;"><?php echo $row->request_no;?></a><br>
                            <strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($row->request_date));?><br><br>
                            <strong>Patient:</strong> <?php echo $row->patient_name;?> (<?php echo $row->patient_no;?>)<br>
                            <strong>Type:</strong> <?php echo $row->request_type;?><br>
                            <strong>Status:</strong> 
                            <?php 
                            $label = 'default';
                            if($row->status == 'Pending') $label = 'warning';
                            elseif($row->status == 'Active') $label = 'primary';
                            elseif($row->status == 'Cancelled') $label = 'danger';
                            elseif($row->status == 'Done') $label = 'success';
                            ?>
                            <span class="label label-<?php echo $label;?>"><?php echo $row->status;?></span>
                            <br><br>
                            <?php if($row->status == 'Pending'): ?>
                            <a href="#" onclick="updateStatus('<?php echo $row->request_id;?>', 'Cancelled')" class="btn btn-xs btn-danger">Cancel Request</a>
                            <?php endif; ?>
                            <a href="<?php echo base_url()?>app/lab_services/view/<?php echo $row->request_id;?>" class="btn btn-xs btn-info">View Details</a>
                        </td>
                        <td valign="top" style="padding:0;" width="60%">
                             <table width="100%" cellpadding="3" cellspacing="0" border="0">
                                <?php if($details): ?>
                                    <?php foreach($details as $item): ?>
                                    <tr>
                                        <td style="padding:3px; border-bottom:1px solid #eee; padding-left:15px;"><?php echo $item->particular_name;?></td>
                                        <td style="padding:3px; border-bottom:1px solid #eee;"><?php echo $item->status;?></td>
                                        <td style="padding:3px; border-bottom:1px solid #eee;"><?php echo $item->result_remarks;?></td>
                                        <td align="right" style="padding:3px; border-bottom:1px solid #eee;"><?php echo number_format($item->total_amount, 2);?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" align="center">No items found</td></tr>
                                <?php endif; ?>
                                
                                <!-- Totals -->
                                <tr style="background:#eee;">
                                    <td colspan="3" align="right" style="padding:3px;"><strong>TOTAL:</strong></td>
                                    <td align="right" style="padding:3px;"><strong><?php echo number_format($row->total_amount, 2);?></strong></td>
                                </tr>
                             </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
                
            </div>
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Core Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
function updateStatus(id, status){
    if(status == 'Cancelled'){
        if(confirm('Are you sure you want to CANCEL this transaction?')){
             $.post('<?php echo base_url()?>app/lab_services/change_status', {id: id, status: status}, function(data){
                location.reload();
            });
        }
    }
}
</script>

</body>
</html>
