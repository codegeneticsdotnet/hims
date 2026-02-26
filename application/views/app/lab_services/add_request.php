<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php 
            if(isset($request_type) && $request_type != ""){
                if($request_type == 'X') echo "X-ray Request Information";
                else if($request_type == 'L') echo "Laboratory Request Information";
                else if($request_type == 'U') echo "Ultrasound Request Information";
                else echo "Create Laboratory Request";
            } else {
                echo "Create Laboratory Request";
            }
            ?>
            <small>Laboratory Services</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/lab_services">Lab Services</a></li>
            <li class="active">Create Request</li>
        </ol>
        
        <form method="post" action="<?php echo base_url()?>app/lab_services/save_request" onsubmit="return validateForm()">
        
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Request Information</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Service Category</label>
                                <select name="service_category" id="service_category" class="form-control" onchange="updateRequestNo()" required>
                                    <option value="">Select Category</option>
                                    <option value="Laboratory" <?php if(isset($request_type) && $request_type == 'L') echo "selected";?>>Laboratory</option>
                                    <option value="X-ray" <?php if(isset($request_type) && $request_type == 'X') echo "selected";?>>X-ray</option>
                                    <option value="Ultrasound" <?php if(isset($request_type) && $request_type == 'U') echo "selected";?>>Ultrasound</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Patient Name (Search by Name or ID)</label>
                                <input type="text" id="patient_search" class="form-control" placeholder="Type to search..." autocomplete="off">
                                <input type="hidden" name="patient_no" id="patient_no" required>
                                <div id="patient_results" class="list-group" style="position:absolute; z-index:999; display:none; width:95%;"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="1"></textarea>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Request No</label>
                                    <input type="text" name="request_no" id="request_no" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Request Date</label>
                                    <input type="text" name="request_date" class="form-control" value="<?php echo date('Y-m-d H:i:s');?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Service Details</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered" id="details_table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Service Description</th>
                            <th>Qty</th>
                            <th>Unit Cost</th>
                            <th>Discount</th>
                            <th>Discount Remarks</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <button type="button" class="btn btn-sm btn-primary" onclick="addRow()"><i class="fa fa-plus"></i> Add Service</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                            <td><input type="text" id="grand_total" class="form-control" readonly></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg pull-right">Save Request</button>
                <a href="<?php echo base_url()?>app/lab_services/service_request" class="btn btn-default btn-lg">Cancel</a>
            </div>
        </div>
        
        </form>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Core Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
var rowCounter = 0;

$(document).ready(function(){
    addRow(); // Add one row by default
    
    // Auto-populate request no if category is pre-selected
    updateRequestNo();

    // Patient Search
    $('#patient_search').keyup(function(){
        var search = $(this).val();
        if(search.length > 2){
            $.post('<?php echo base_url()?>app/lab_services/patient_autocomplete_active', {search: search}, function(data){
                var results = JSON.parse(data);
                var html = '';
                if(results.length > 0){
                    $.each(results, function(index, item){
                        html += '<a href="#" class="list-group-item" onclick="selectPatient(\''+item.id+'\', \''+item.label+'\')">'+item.label+'</a>';
                    });
                    $('#patient_results').html(html).show();
                } else {
                    $('#patient_results').hide();
                }
            });
        } else {
            $('#patient_results').hide();
        }
    });
});

function selectPatient(id, label){
    $('#patient_no').val(id);
    $('#patient_search').val(label);
    $('#patient_results').hide();
}

function updateRequestNo(){
    var type = $('#service_category').val();
    if(type){
        $.post('<?php echo base_url()?>app/lab_services/get_next_id', {type: type}, function(data){
            $('#request_no').val(data);
        });
    } else {
        $('#request_no').val('');
    }
}

function addRow(){
    var rowId = rowCounter++;
    var row = `
        <tr id="row_${rowId}">
            <td>
                <input type="text" class="form-control service-search" placeholder="Search Service..." onkeyup="searchService(this, ${rowId})" onfocus="searchService(this, ${rowId})" autocomplete="off">
                <input type="hidden" name="particular_id[]" id="particular_id_${rowId}">
                <div id="service_results_${rowId}" class="list-group" style="position:absolute; z-index:999; display:none; width:300px; max-height: 200px; overflow-y: auto;"></div>
            </td>
            <td><input type="number" name="qty[]" id="qty_${rowId}" class="form-control" value="1" onchange="calculateRow(${rowId})" min="1"></td>
            <td><input type="number" name="amount[]" id="amount_${rowId}" class="form-control" value="0.00" readonly></td>
            <td><input type="number" name="discount[]" id="discount_${rowId}" class="form-control" value="0.00" onchange="calculateRow(${rowId})" min="0"></td>
            <td><input type="text" name="discount_remarks[]" class="form-control"></td>
            <td><input type="number" name="total_amount[]" id="total_${rowId}" class="form-control" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(${rowId})"><i class="fa fa-trash"></i></button></td>
        </tr>
    `;
    $('#details_table tbody').append(row);
}

function removeRow(id){
    $('#row_'+id).remove();
    calculateGrandTotal();
}

function searchService(element, rowId){
    var search = $(element).val();
    var category = $('#service_category').val();
    
    // Check category but only alert if user is typing
    if(!category){
        if(search.length > 0) {
            alert('Please select a Service Category first.');
            $(element).val('');
        }
        return;
    }

    // Always fetch if category is selected, even if search is empty (to show all/top results)
    $.post('<?php echo base_url()?>app/lab_services/service_autocomplete', {search: search, category: category}, function(data){
        var results = JSON.parse(data);
        var html = '';
        if(results.length > 0){
            $.each(results, function(index, item){
                html += '<a href="#" class="list-group-item" onclick="selectService('+rowId+', \''+item.id+'\', \''+item.value+'\', '+item.price+'); return false;">'+item.label+'</a>';
            });
            $('#service_results_'+rowId).html(html).show();
        } else {
            $('#service_results_'+rowId).hide();
        }
    });
}

// Close results when clicking outside
$(document).click(function(e) {
    if (!$(e.target).hasClass('service-search')) {
        $('.list-group').hide();
    }
});

function selectService(rowId, id, name, price){
    $('#particular_id_'+rowId).val(id);
    $('#row_'+rowId).find('.service-search').val(name);
    $('#amount_'+rowId).val(price);
    $('#service_results_'+rowId).hide();
    calculateRow(rowId);
}

function calculateRow(rowId){
    var qty = parseFloat($('#qty_'+rowId).val()) || 0;
    var price = parseFloat($('#amount_'+rowId).val()) || 0;
    var discount = parseFloat($('#discount_'+rowId).val()) || 0;
    
    var total = (qty * price) - discount;
    $('#total_'+rowId).val(total.toFixed(2));
    
    calculateGrandTotal();
}

function calculateGrandTotal(){
    var grandTotal = 0;
    $('input[name="total_amount[]"]').each(function(){
        grandTotal += parseFloat($(this).val()) || 0;
    });
    $('#grand_total').val(grandTotal.toFixed(2));
}

function validateForm(){
    if($('#patient_no').val() == ''){
        alert('Please select a patient.');
        return false;
    }
    return true;
}
</script>

</body>
</html>
