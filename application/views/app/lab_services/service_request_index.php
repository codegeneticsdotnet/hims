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
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Request No</th>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($requests as $row):?>
                        <tr>
                            <td><a href="<?php echo base_url()?>app/lab_services/view/<?php echo $row->request_id;?>"><?php echo $row->request_no;?></a></td>
                            <td><?php echo date('M d, Y h:i A', strtotime($row->request_date));?></td>
                            <td><?php echo $row->patient_name;?></td>
                            <td><?php echo $row->request_type;?></td>
                            <td>
                                <?php 
                                $label = 'default';
                                if($row->status == 'Pending') $label = 'warning';
                                elseif($row->status == 'Active') $label = 'success';
                                elseif($row->status == 'Cancelled') $label = 'danger';
                                ?>
                                <span class="label label-<?php echo $label;?>"><?php echo $row->status;?></span>
                            </td>
                            <td><?php echo $row->item_count;?></td>
                            <td><?php echo number_format($row->total_amount, 2);?></td>
                            <td>
                                <?php if($row->status == 'Pending'): ?>
                                <a href="#" onclick="updateStatus('<?php echo $row->request_id;?>', 'Cancelled')" class="btn btn-xs btn-danger">Cancel</a>
                                <?php endif; ?>
                                <a href="<?php echo base_url()?>app/lab_services/view/<?php echo $row->request_id;?>" class="btn btn-xs btn-info">View</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
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
