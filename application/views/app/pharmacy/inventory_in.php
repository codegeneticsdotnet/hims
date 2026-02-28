<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Inventory In
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url('app/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url('app/pharmacy');?>">Pharmacy</a></li>
                <li class="active">Inventory In</li>
            </ol>
        
        <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <?php endif; ?>

        <form action="<?php echo base_url()?>app/pharmacy/save_inventory_in" method="post" onsubmit="return validateForm();">
            <input type="hidden" name="ref_no" value="<?php echo $ref_no;?>">
            
            <div class="row">
                 <!-- Header Info -->
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Reference No</label>
                                        <input type="text" class="form-control" value="<?php echo $ref_no;?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Received</label>
                                        <input type="text" class="form-control" value="<?php echo date('M d, Y');?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier Name</label>
                                        <input type="text" name="supplier_name" class="form-control" placeholder="Enter Supplier Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea name="remarks" class="form-control" rows="1" placeholder="Enter remarks..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-tools pull-left">
                                <div class="input-group input-group-sm" style="width: 250px; display: inline-table;">
                                    <input type="text" id="search_item" class="form-control pull-right" placeholder="Search Item...">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div id="search_result" style="position: absolute; z-index: 999; background: #fff; width: 250px; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addItemModal" onclick="clearForm()"><i class="fa fa-plus"></i> New Product</button>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover" id="inventory_table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Current Stock</th>
                                        <th>Batch No</th>
                                        <th>Expiry Date</th>
                                        <th>Qty Received</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="inventory_body">
                                    <tr id="empty_row"><td colspan="6" class="text-center">No items added.</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save Stock Entry</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <!-- Recent Inventory List -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Recent Stock Entries</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-default btn-sm" onclick="showSummary()"><i class="fa fa-list"></i> View Summary Report</button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Ref No</th>
                                    <th>Date Received</th>
                                    <th>Supplier</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($recent_inventory)): ?>
                                    <?php foreach($recent_inventory as $inv): ?>
                                    <tr>
                                        <td><?php echo $inv->ref_no;?></td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($inv->date_received));?></td>
                                        <td><?php echo $inv->supplier_name;?></td>
                                        <td><?php echo $inv->remarks;?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-xs" onclick="viewDetails(<?php echo $inv->inv_id;?>)"><i class="fa fa-eye"></i> View Items</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center">No recent entries.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Summary Modal -->
<div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="summaryModalLabel">Inventory In Summary Report</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="summaryTable">
                        <thead>
                            <tr>
                                <th>Ref No</th>
                                <th>Date</th>
                                <th>Supplier</th>
                                <th>Total Items</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printInventory()"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Stock Entry Details</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="details_table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Batch No</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printInventory()"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addNewItemForm" action="<?php echo base_url('app/pharmacy/save_item');?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="addItemModalLabel">Add New Product</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="item_id">
                    <input type="hidden" name="redirect_to" value="inventory_in">
                    <div class="form-group">
                        <label>Item Name <span class="text-danger">*</span></label>
                        <input type="text" name="item_name" id="item_name" class="form-control" required placeholder="e.g. Paracetamol 500mg">
                    </div>
                    <div class="form-group">
                        <label>Generic Name</label>
                        <input type="text" name="generic_name" id="generic_name" class="form-control" placeholder="e.g. Acetaminophen">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->med_category_name;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit of Measure</label>
                                <select name="unit" id="unit" class="form-control">
                                    <option value="">Select Unit</option>
                                    <?php foreach($units as $unit): ?>
                                    <option value="<?php echo $unit->param_id;?>"><?php echo $unit->cValue;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selling Price</label>
                                <input type="number" name="price" id="price" class="form-control" step="0.01" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Re-order Level</label>
                                <input type="number" name="reorder_level" id="reorder_level" class="form-control" value="10">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
    function showSummary(){
        $.ajax({
            url: "<?php echo base_url();?>app/pharmacy/get_inventory_summary",
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var html = '';
                $.each(data, function(i, item){
                    html += '<tr>';
                    html += '<td>' + item.ref_no + '</td>';
                    html += '<td>' + item.date_received + '</td>';
                    html += '<td>' + item.supplier_name + '</td>';
                    html += '<td>' + item.total_items + '</td>';
                    html += '<td>' + item.remarks + '</td>';
                    html += '</tr>';
                });
                $('#summaryTable tbody').html(html);
                $('#summaryModal').modal('show');
            }
        });
    }

    function clearForm(){
        $('#addItemModalLabel').text('Add New Product');
        $('#item_id').val('');
        $('#item_name').val('');
        $('#generic_name').val('');
        $('#category').val('');
        $('#unit').val('');
        $('#price').val('0.00');
        $('#reorder_level').val('10');
    }

    // Item Search Logic
    $('#search_item').keyup(function(){
        var keyword = $(this).val();
        if(keyword.length > 2){
            $.ajax({
                url: "<?php echo base_url();?>app/pharmacy/get_items/" + keyword,
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    var html = '<ul class="list-group" style="margin-bottom: 0;">';
                    if(data.length > 0){
                        $.each(data, function(i, item){
                            html += '<li class="list-group-item" style="cursor: pointer;" onclick="addItem(' + item.item_id + ', \'' + item.item_name.replace(/'/g, "\\'") + '\', ' + item.stock_on_hand + ')">' + item.item_name + ' (Stock: ' + item.stock_on_hand + ')</li>';
                        });
                    } else {
                        html += '<li class="list-group-item">No items found</li>';
                    }
                    html += '</ul>';
                    $('#search_result').html(html).show();
                }
            });
        } else {
            $('#search_result').hide();
        }
    });
    
    // Add Item to Table
    function addItem(id, name, stock){
        $('#search_result').hide();
        $('#search_item').val('');
        $('#empty_row').remove();
        
        // Generate Batch No: BA + YY + MM + 6 random digits
        var date = new Date();
        var year = date.getFullYear().toString().substr(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var random = Math.floor(100000 + Math.random() * 900000);
        var batchNo = 'BA-' + year + month + random;
        
        var html = '<tr>';
        html += '<td>' + name + '<input type="hidden" name="item_id[]" value="' + id + '"><input type="hidden" name="item_name[]" value="' + name + '"></td>';
        html += '<td>' + stock + '</td>';
        html += '<td><input type="text" name="batch_no[]" class="form-control input-sm" value="' + batchNo + '"></td>';
        html += '<td><input type="date" name="expiry_date[]" class="form-control input-sm" required></td>';
        html += '<td><input type="number" name="qty[]" class="form-control input-sm" value="1" min="1" style="width: 100px;"></td>';
        html += '<td><a href="#" class="text-danger" onclick="removeRow(this)"><i class="fa fa-times"></i></a></td>';
        html += '</tr>';
        
        $('#inventory_body').append(html);
    }
    
    // Remove Row
    function removeRow(btn){
        $(btn).closest('tr').remove();
        if($('#inventory_body tr').length == 0){
             $('#inventory_body').append('<tr id="empty_row"><td colspan="6" class="text-center">No items added.</td></tr>');
        }
    }
    
    function validateForm(){
        if($('#inventory_body tr').length == 0 || $('#empty_row').length > 0){
            alert('Please add items to the inventory.');
            return false;
        }
        return confirm('Are you sure you want to save this stock entry?');
    }
    
    var current_inv_id = 0;
    
    function viewDetails(inv_id){
        current_inv_id = inv_id;
        $.ajax({
            url: "<?php echo base_url();?>app/pharmacy/get_inventory_details/" + inv_id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                var html = '';
                $.each(data, function(i, item){
                    html += '<tr>';
                    html += '<td>' + item.item_name + '</td>';
                    html += '<td>' + item.qty + '</td>';
                    html += '<td>' + item.batch_no + '</td>';
                    html += '<td>' + item.expiry_date + '</td>';
                    html += '</tr>';
                });
                $('#details_table tbody').html(html);
                $('#viewDetailsModal').modal('show');
            }
        });
    }
    
    function printInventory(){
        if(current_inv_id > 0){
             window.open("<?php echo base_url();?>app/pharmacy/print_inventory/" + current_inv_id, "_blank");
        }
    }
    
    $(document).ready(function(){
        <?php if($this->session->flashdata('print_inv_id')): ?>
            viewDetails(<?php echo $this->session->flashdata('print_inv_id'); ?>);
        <?php endif; ?>
    });
    
    // Close search result on click outside
    $(document).mouseup(function(e) 
    {
        var container = $("#search_result");
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
    });
</script>

</body>
</html>
