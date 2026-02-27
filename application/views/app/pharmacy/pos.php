<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pharmacy Point of Sale
                <small>New Transaction</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url();?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url();?>app/pharmacy">Pharmacy</a></li>
                <li class="active">POS</li>
            </ol>

    <?php if($this->session->flashdata('message')): ?>
    <!-- Auto-open modal if success message exists -->
    <script>
        $(document).ready(function(){
            $('#printModal').modal('show');
        });
    </script>
    <?php endif; ?>

        <form action="<?php echo base_url()?>app/pharmacy/save_pos" method="post" onsubmit="return validateForm();">
            <input type="hidden" name="invoice_no" value="<?php echo $invoice_no;?>">
            
            <div class="row">
                <!-- Left Column: Patient Info & Items -->
                <div class="col-md-8">
                    <!-- Patient Info -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Transaction Details</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pharmacy No.</label>
                                        <input type="text" class="form-control" value="<?php echo $invoice_no;?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="text" class="form-control" value="<?php echo date('M d, Y');?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="position: relative;">
                                        <label>Patient Name (Optional)</label>
                                        <input type="text" name="patient_name" id="patient_name" class="form-control" placeholder="Walk-in Patient / Enter Name" autocomplete="off">
                                        <input type="hidden" name="patient_no" id="patient_no">
                                        <input type="hidden" name="iop_id" id="iop_id">
                                        <div id="patient_search_result" style="position: absolute; z-index: 999; background: #fff; width: 100%; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Items -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <!-- <h3 class="box-title">Itemname</h3> -->
                            <div class="box-tools pull-left">
                                <div class="input-group input-group-sm" style="width: 350px; display: inline-table;">
                                    <label>Itemname</label> 
                                    <input type="text" id="search_item" class="form-control pull-right" placeholder="Search Medicine...">
                                    <!-- 
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div> -->
                                </div>
                                <div id="search_result" style="position: absolute; z-index: 999; background: #fff; width: 350px; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover" id="pos_table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="pos_body">
                                    <!-- Items will be added here -->
                                    <tr id="empty_row"><td colspan="6" class="text-center">No items added.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Payment & Discount -->
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">Payment Summary</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Payment Type</label>
                                <select name="payment_type" id="payment_type" class="form-control" onchange="togglePaymentType()">
                                    <option value="Cash">Cash</option>
                                    <option value="Charge">Charge to IPD Bill</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Total Amount</label>
                                <input type="text" name="total_amount" id="total_amount" class="form-control input-lg text-right" value="0.00" readonly>
                            </div>
                            <div class="form-group">
                                <label>Discount Amount</label>
                                <input type="number" name="discount" id="discount" class="form-control text-right" value="0" step="0.01" onkeyup="calculateTotal()">
                            </div>
                            <div class="form-group" id="remarks_group" style="display: none;">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="2" placeholder="Enter remarks..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Net Total</label>
                                <input type="text" name="net_total" id="net_total" class="form-control input-lg text-right" style="font-weight: bold; color: green;" value="0.00" readonly>
                            </div>
                             <div class="form-group" id="cash_group">
                                <label>Cash Tendered</label>
                                <input type="number" name="cash_tendered" id="cash_tendered" class="form-control input-lg text-right" step="0.01" onkeyup="calculateChange()">
                            </div>
                            <div class="form-group" id="change_group">
                                <label>Change</label>
                                <input type="text" name="change" id="change" class="form-control input-lg text-right" style="font-weight: bold; color: blue;" readonly>
                            </div>
                            <button type="submit" class="btn btn-success btn-block btn-lg"><i class="fa fa-check"></i> Process Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

<!-- Print Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Transaction Complete</h4>
            </div>
            <div class="modal-body text-center">
                <h3>Transaction Successful!</h3>
                <p>Would you like to print the receipt?</p>
                <a href="" id="printLink" target="_blank" class="btn btn-primary btn-lg"><i class="fa fa-print"></i> Print Receipt</a>
                <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Item</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_row_index">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" id="edit_item_name" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="edit_qty" class="form-control" min="1">
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" id="edit_price" class="form-control" step="0.01">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="updateItemPrice()">Update</button>
            </div>
        </div>
    </div>
</div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
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
                            html += '<li class="list-group-item" style="cursor: pointer;" onclick="addItem(' + item.item_id + ', \'' + item.item_name.replace(/'/g, "\\'") + '\', ' + item.price + ', ' + item.stock_on_hand + ')">' + item.item_name + ' (Stock: ' + item.stock_on_hand + ') - ' + item.price + '</li>';
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
    
    // Patient Search Logic
    $('#patient_name').keyup(function(){
        var keyword = $(this).val();
        var type = $('#payment_type').val();
        var url = "<?php echo base_url();?>app/pharmacy/search_patient/" + keyword;
        
        if(type == 'Charge'){
            url = "<?php echo base_url();?>app/pharmacy/search_ipd_patient/" + keyword;
        }
        
        if(keyword.length > 2){
            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    var html = '<ul class="list-group" style="margin-bottom: 0;">';
                    if(data.length > 0){
                        $.each(data, function(i, item){
                            if(type == 'Charge'){
                                // For IPD, we need IO_ID
                                html += '<li class="list-group-item" style="cursor: pointer;" onclick="selectIPDPatient(\'' + item.patient_name.replace(/'/g, "\\'") + '\', \'' + item.patient_no + '\', \'' + item.IO_ID + '\')">' + item.patient_name + ' (' + item.IO_ID + ')</li>';
                            } else {
                                html += '<li class="list-group-item" style="cursor: pointer;" onclick="selectPatient(\'' + item.patient_name.replace(/'/g, "\\'") + '\')">' + item.patient_name + '</li>';
                            }
                        });
                    } else {
                        html += '<li class="list-group-item">No patients found</li>';
                    }
                    html += '</ul>';
                    $('#patient_search_result').html(html).show();
                }
            });
        } else {
            $('#patient_search_result').hide();
        }
    });

    function selectPatient(name){
        $('#patient_name').val(name);
        $('#patient_no').val('');
        $('#iop_id').val('');
        $('#patient_search_result').hide();
    }
    
    function selectIPDPatient(name, patientNo, iopId){
        $('#patient_name').val(name);
        $('#patient_no').val(patientNo);
        $('#iop_id').val(iopId);
        $('#patient_search_result').hide();
    }
    
    function togglePaymentType(){
        var type = $('#payment_type').val();
        if(type == 'Charge'){
            $('#cash_group').hide();
            $('#change_group').hide();
            $('#patient_name').attr('placeholder', 'Search Admitted IPD Patient...');
            // Clear current patient info as it might be invalid for IPD
            $('#patient_name').val('');
            $('#patient_no').val('');
            $('#iop_id').val('');
        } else {
            $('#cash_group').show();
            $('#change_group').show();
            $('#patient_name').attr('placeholder', 'Walk-in Patient / Enter Name');
        }
    }
    
    var selectedRow = null;

    // Add Item to Table
    function addItem(id, name, price, stock){
        $('#search_result').hide();
        $('#search_item').val('');
        $('#empty_row').remove();
        
        // Check if item already exists
        var exists = false;
        $('input[name="item_id[]"]').each(function(){
            if($(this).val() == id){
                exists = true;
                // Increment Qty
                var row = $(this).closest('tr');
                var currentQty = parseFloat(row.find('.qty-input').val());
                if(currentQty < stock){
                    row.find('.qty-input').val(currentQty + 1);
                    calculateRow(row);
                } else {
                    alert('Insufficient Stock!');
                }
                return false;
            }
        });
        
        if(exists) return;
        
        var html = '<tr onclick="selectRow(this)" style="cursor: pointer;">';
        html += '<td>' + name + '<input type="hidden" name="item_id[]" value="' + id + '"><input type="hidden" name="item_name[]" value="' + name + '"></td>';
        html += '<td>' + stock + '<input type="hidden" class="stock-val" value="' + stock + '"></td>';
        html += '<td><a href="#" onclick="openEditModal(this); event.stopPropagation();">' + parseFloat(price).toFixed(2) + '</a><input type="hidden" name="price[]" class="price-val" value="' + price + '"></td>';
        html += '<td><input type="number" name="qty[]" class="form-control input-sm qty-input" value="1" min="1" max="' + stock + '" onchange="calculateRow(this)" onkeyup="calculateRow(this)" style="width: 70px;"></td>';
        html += '<td><span class="row-total">' + parseFloat(price).toFixed(2) + '</span></td>';
        html += '<td><a href="#" class="text-danger" onclick="removeRow(this); event.stopPropagation();"><i class="fa fa-times"></i></a></td>';
        html += '</tr>';
        
        $('#pos_body').append(html);
        calculateTotal();
    }
    
    function selectRow(row){
        $('#pos_body tr').removeClass('info');
        $(row).addClass('info');
        selectedRow = $(row);
        $('#edit_item_btn').show();
    }
    
    function openEditModal(element){
        var row = $(element).closest('tr');
        selectRow(row);
        editSelectedItem();
    }
    
    function editSelectedItem(){
        if(selectedRow){
            var name = selectedRow.find('input[name="item_name[]"]').val();
            var qty = selectedRow.find('.qty-input').val();
            var price = selectedRow.find('.price-val').val();
            
            $('#edit_item_name').val(name);
            $('#edit_qty').val(qty);
            $('#edit_price').val(price);
            
            $('#editItemModal').modal('show');
        } else {
            alert('Please select an item to edit.');
        }
    }
    
    function saveEditedItem(){
        var newQty = parseFloat($('#edit_qty').val());
        var newPrice = parseFloat($('#edit_price').val());
        var stock = parseFloat(selectedRow.find('.stock-val').val());
        
        if(isNaN(newQty) || newQty < 1){
            alert('Quantity must be at least 1');
            return;
        }

        if(newQty > stock){
             alert('Cannot exceed stock level: ' + stock);
             return;
        }
        
        if(isNaN(newPrice) || newPrice < 0){
             alert('Invalid Price');
             return;
        }
        
        selectedRow.find('.qty-input').val(newQty);
        selectedRow.find('.price-val').val(newPrice);
        
        // Update price display in table (3rd column, index 2)
        // Re-construct the cell content with new price and hidden input
        var priceCell = '<a href="#" onclick="openEditModal(this); event.stopPropagation();">' + newPrice.toFixed(2) + '</a><input type="hidden" name="price[]" class="price-val" value="' + newPrice + '">';
        selectedRow.find('td:eq(2)').html(priceCell);
        
        calculateRow(selectedRow);
        $('#editItemModal').modal('hide');
    }
    
    function updateItemPrice(){
        var newPrice = parseFloat($('#edit_price').val());
        var itemId = selectedRow.find('input[name="item_id[]"]').val();
        
        if(isNaN(newPrice) || newPrice < 0){
             alert('Invalid Price');
             return;
        }
            $.ajax({
                url: "<?php echo base_url();?>app/pharmacy/update_item_price",
                type: "POST",
                data: {
                    item_id: itemId,
                    price: newPrice
                },
                dataType: "JSON",
                success: function(response){
                    if(response.status){
                        alert('Price updated successfully!');
                        // Also update the current cart item
                        saveEditedItem();
                    } else {
                        alert('Failed to update price.');
                    }
                },
                error: function(){
                    alert('Error updating price.');
                }
            });
    }
    
    // Remove Row
    function removeRow(btn){
        $(btn).closest('tr').remove();
        if($('#pos_body tr').length == 0){
             $('#pos_body').append('<tr id="empty_row"><td colspan="6" class="text-center">No items added.</td></tr>');
             $('#edit_item_btn').hide();
             selectedRow = null;
        }
        calculateTotal();
    }
    
    // Calculate Row Total
    function calculateRow(element){
        var row;
        if(element instanceof jQuery){
            row = element;
        } else {
            row = $(element).closest('tr');
        }
        
        // Re-fetch price from hidden input (which we updated in saveEditedItem)
        var price = parseFloat(row.find('.price-val').val()) || 0;
        var qty = parseFloat(row.find('.qty-input').val()) || 0;
        var stock = parseFloat(row.find('.stock-val').val()) || 0;
        
        if(qty > stock){
            alert('Cannot exceed stock level: ' + stock);
            row.find('.qty-input').val(stock);
            qty = stock;
        }
        if(qty < 1){
            row.find('.qty-input').val(1);
            qty = 1;
        }
        
        var total = price * qty;
        row.find('.row-total').text(total.toFixed(2));
        calculateTotal();
    }
    
    // Calculate Grand Total
    function calculateTotal(){
        var grandTotal = 0;
        $('.row-total').each(function(){
            grandTotal += parseFloat($(this).text()) || 0;
        });
        
        $('#total_amount').val(grandTotal.toFixed(2));
        
        var discount = parseFloat($('#discount').val()) || 0;
        
        if(discount > 0){
            $('#remarks_group').show();
        } else {
            $('#remarks_group').hide();
        }
        
        var net = grandTotal - discount;
        if(net < 0) net = 0;
        
        $('#net_total').val(net.toFixed(2));
        calculateChange();
    }
    
    // Calculate Change
    function calculateChange(){
        var net = parseFloat($('#net_total').val()) || 0;
        var cash = parseFloat($('#cash_tendered').val()) || 0;
        var change = cash - net;
        
        if(change < 0) change = 0;
        $('#change').val(change.toFixed(2));
    }
    
    function validateForm(){
        var net = parseFloat($('#net_total').val()) || 0;
        var cash = parseFloat($('#cash_tendered').val()) || 0;
        var type = $('#payment_type').val();
        
        if($('#pos_body tr').length == 0 || $('#empty_row').length > 0){
            alert('Please add items to the bill.');
            return false;
        }
        
        if(type == 'Cash'){
            if(cash < net){
                alert('Cash tendered is less than the total amount.');
                return false;
            }
        } else {
            // Validate IPD patient selection
            if($('#iop_id').val() == ''){
                alert('Please select an admitted IPD patient for charging.');
                return false;
            }
        }
        
        return confirm('Are you sure you want to process this transaction?');
    }
    
    // Close search result on click outside
    $(document).mouseup(function(e) 
    {
        var container = $("#search_result");
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
        }
        
        var container2 = $("#patient_search_result");
        if (!container2.is(e.target) && container2.has(e.target).length === 0) 
        {
            container2.hide();
        }
    });
</script>

</body>
</html>
