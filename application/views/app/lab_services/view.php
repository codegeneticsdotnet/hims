<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratory Request Details
            <small><?php echo $header->request_no;?></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/lab_services">Lab Services</a></li>
            <li><a href="<?php echo base_url()?>app/lab_services/service_request">Requests</a></li>
            <li class="active">View</li>
        </ol>
        
        <?php echo $this->session->flashdata('message');?>

        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Patient Information</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <th>Patient No</th>
                                <td><?php echo $header->patient_no;?></td>
                            </tr>
                            <tr>
                                <th>Patient Name</th>
                                <td><?php echo $header->patient_name;?></td>
                            </tr>
                            <tr>
                                <th>Age / Gender</th>
                                <td><?php echo $header->age;?> / <?php echo ($header->gender == 1 ? 'Male' : 'Female');?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Request Information</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <th>Request No</th>
                                <td><?php echo $header->request_no;?></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?php echo $header->request_type;?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td><?php echo date('M d, Y h:i A', strtotime($header->request_date));?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php 
                                    $label = 'default';
                                    if($header->status == 'Pending') $label = 'warning';
                                    elseif($header->status == 'Active') $label = 'success';
                                    elseif($header->status == 'Cancelled') $label = 'danger';
                                    ?>
                                    <span class="label label-<?php echo $label;?>"><?php echo $header->status;?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td><?php echo $header->remarks;?></td>
                            </tr>
                        </table>
                        <div class="text-center" style="margin-top: 20px;">
                            <a href="<?php echo base_url()?>app/lab_services/print_request/<?php echo $header->request_id;?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Request</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <form method="post" action="<?php echo base_url()?>app/lab_services/bulk_update_status" id="bulk_form">
                
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Service Details</h3>
                    </div>
                    <div class="box-body table-responsive">
                    <div class="box-tools">
                             <!-- Bulk Actions -->
                             <?php if($header->status == 'Paid' || $header->status == 'Active' || $header->status == 'Done'): ?>
                             <div class="input-group input-group-sm" style="width: 300px;">
                                <select name="bulk_status" class="form-control" required>
                                    <option value="">Select Action</option>
                                    <option value="Active">Active</option>
                                    <option value="Done">Done</option>
                                    <option value="Cancelled">Cancel</option>
                                </select>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#bulkRemarksModal">Update</button>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="alert alert-warning" style="padding: 5px; margin-bottom: 0;">
                                    <i class="fa fa-info-circle"></i> Payment required to process request.
                                </div>
                            <?php endif; ?>
                        </div><br />

                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th width="10"><input type="checkbox" id="check_all"></th>
                                    <th>Service Description</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($details as $row):?>
                                <tr>
                                    <td><input type="checkbox" name="detail_id[]" class="check_item" value="<?php echo $row->detail_id;?>"></td>
                                    <td>
                                        <?php echo $row->particular_name;?>
                                        <br><small class="text-muted"><?php echo $row->particular_desc;?></small>
                                    </td>
                                    <td><?php echo $row->qty;?></td>
                                    <td><?php echo number_format($row->total_amount, 2);?></td>
                                    <td>
                                        <?php 
                                        $label = 'default';
                                        $status = isset($row->status) ? $row->status : 'Pending';
                                        if($status == 'Pending') $label = 'warning';
                                        elseif($status == 'Paid') $label = 'info';
                                        elseif($status == 'Active') $label = 'primary';
                                        elseif($status == 'Done') $label = 'success';
                                        elseif($status == 'Cancelled') $label = 'danger';
                                        else $label = 'default';
                                        ?>
                                        <span class="label label-<?php echo $label;?>"><?php echo $status;?></span>
                                    </td>
                                    <td><?php echo isset($row->result_remarks) ? $row->result_remarks : '';?></td>
                                    <td>
                                        <?php if($header->status == 'Paid' || $header->status == 'Active' || $header->status == 'Done'): ?>
                                            <?php if($row->status != 'Done' && $row->status != 'Cancelled'): ?>
                                                <?php if($row->status != 'Active'): ?>
                                                <a href="#" onclick="updateDetailStatus('<?php echo $row->detail_id;?>', 'Active')" class="btn btn-xs btn-primary">Active</a>
                                                <?php endif; ?>
                                                <a href="#" onclick="updateDetailStatus('<?php echo $row->detail_id;?>', 'Done')" class="btn btn-xs btn-success">Done</a>
                                                <a href="#" onclick="updateDetailStatus('<?php echo $row->detail_id;?>', 'Cancelled')" class="btn btn-xs btn-danger">Cancel</a>
                                            <?php endif; ?>
                                        <?php elseif($header->status == 'Pending'): ?>
                                            <a href="#" onclick="updateDetailStatus('<?php echo $row->detail_id;?>', 'Cancelled')" class="btn btn-xs btn-danger">Cancel</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Bulk Remarks Modal -->
                <div class="modal fade" id="bulkRemarksModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Update Status</h4>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                            <label>Remarks (Optional)</label>
                            <textarea name="bulk_remarks" class="form-control" rows="3" placeholder="Enter remarks for this action..."></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </div>
                  </div>
                </div>

                </form>
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
$(document).ready(function(){
    // Check All
    $('#check_all').click(function(){
        $('.check_item').prop('checked', $(this).prop('checked'));
    });

    // If all checked manually, check the master checkbox
    $('.check_item').change(function(){
        if($('.check_item:checked').length == $('.check_item').length){
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    });

    $('#bulk_form').submit(function(e){
        if($('.check_item:checked').length == 0){
            alert('Please select at least one item.');
            e.preventDefault();
            $('#bulkRemarksModal').modal('hide');
        }
    });
});

function updateDetailStatus(id, status){
    if(confirm('Set status to ' + status + '?')){
        $.post('<?php echo base_url()?>app/lab_services/toggle_detail_status', {id: id, status: status}, function(data){
            location.reload();
        });
    }
}

function toggleStatus(id, currentStatus){
    var newStatus = '';
    
    // Only allow flow: Paid -> Active -> Done
    if(currentStatus == 'Paid'){
        newStatus = 'Active';
    } else if(currentStatus == 'Active'){
        newStatus = 'Done';
    } else {
        return; // Pending or Cancelled cannot be moved manually here (Pending needs payment)
    }
    
    if(newStatus != '' && confirm('Change status from ' + currentStatus + ' to ' + newStatus + '?')){
        $.post('<?php echo base_url()?>app/lab_services/toggle_detail_status', {id: id, status: newStatus}, function(data){
            location.reload();
        });
    }
}
</script>

</body>
</html>
