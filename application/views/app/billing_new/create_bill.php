<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            New Bill
            <small><?php echo $type;?> Invoice #<?php echo $invoice_no;?></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/billing_new">Billing</a></li>
            <li class="active">New Bill</li>
        </ol><br />
        
        <form action="<?php echo base_url()?>app/billing_new/save_bill" method="post" onsubmit="return confirm('Are you sure you want to process this payment?');">
            <input type="hidden" name="patient_no" value="<?php echo isset($patient->patient_no) ? $patient->patient_no : (isset($patient_no_param) ? $patient_no_param : '');?>">
            <input type="hidden" name="io_id" value="<?php echo $io_id;?>">
            <input type="hidden" name="invoice_no" value="<?php echo $invoice_no;?>">
            
            <div class="row">
                <!-- Patient Info -->
                 <div class="col-md-8">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Control No:</strong> <?php echo $invoice_no;?></p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Patient No:</strong> <?php echo isset($patient->patient_no) ? $patient->patient_no : (isset($patient_no_param) ? $patient_no_param : '');?></p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Date:</strong> <?php echo date('M d, Y');?></p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Patient Name:</strong> <?php echo (isset($patient) && is_object($patient)) ? $patient->firstname . ' ' . $patient->lastname : (isset($patient_name_param) ? $patient_name_param : '');?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Billing Items -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Billable Items</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addItemModal"><i class="fa fa-plus"></i> Add Item</button>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover" id="billing_table">
                                <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $grand_total = 0;
                                        if(!empty($items)):
                                            $i = 0;
                                            foreach($items as $item):
                                                $grand_total += $item->total;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $item->item_name;?>
                                                <input type="hidden" name="item_id[]" value="<?php echo $item->item_id;?>">
                                                <input type="hidden" name="item_name[]" value="<?php echo $item->item_name;?>">
                                            </td>
                                            <td><?php echo $item->category;?></td>
                                            <td>
                                                <?php echo number_format($item->price, 2);?>
                                                <input type="hidden" name="price[]" id="price_<?php echo $i;?>" value="<?php echo $item->price;?>">
                                            </td>
                                            <td>
                                                <input type="number" name="item_discount[]" id="discount_<?php echo $i;?>" value="0" step="0.01" class="form-control input-sm" style="width: 80px;" onkeyup="calculateRow(<?php echo $i;?>)">
                                            </td>
                                            <td>
                                                <?php echo $item->qty;?>
                                                <input type="hidden" name="qty[]" id="qty_<?php echo $i;?>" value="<?php echo $item->qty;?>">
                                            </td>
                                            <td>
                                                <span id="total_display_<?php echo $i;?>"><?php echo number_format($item->total, 2);?></span>
                                                <input type="hidden" name="item_total[]" id="total_<?php echo $i;?>" value="<?php echo $item->total;?>" class="item-total">
                                            </td>
                                            <td><a href="#" class="text-danger"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                        <?php 
                                            $i++;
                                            endforeach; 
                                        else: 
                                        ?>
                                        <tr><td colspan="7" class="text-center">No pending items found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                                        </div>
                <!-- Payment & Discount -->
                <div class="col-md-4">
                    <div class="box box-warning">
                        <!--
                        <div class="box-header">
                            <h3 class="box-title">Payment Summary</h3>
                        </div>
                                        -->
                        <div class="box-body">
                            <div class="form-group">
                                <label>Total Amount</label>
                                <input type="text" name="total_amount" id="total_amount" class="form-control input-lg text-right" value="<?php echo $grand_total;?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Discount Amount</label>
                                <input type="number" name="discount" id="discount" class="form-control text-right" value="0" step="0.01" onkeyup="calculateTotal()">
                            </div>
                            <div class="form-group">
                                <label>Net Total</label>
                                <input type="text" name="net_total" id="net_total" class="form-control input-lg text-right" style="font-weight: bold; color: green;" value="<?php echo $grand_total;?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Remarks / Discount Reason</label>
                                <textarea name="remarks" class="form-control" rows="2" placeholder="Enter remarks..."></textarea>
                            </div>
                             <div class="form-group">
                                <label>Cash Tendered</label>
                                <input type="number" name="cash_tendered" id="cash_tendered" class="form-control input-lg text-right" step="0.01" onkeyup="calculateChange()">
                            </div>
                            <div class="form-group">
                                <label>Change</label>
                                <input type="text" name="change" id="change" class="form-control input-lg text-right" style="font-weight: bold; color: blue;" readonly>
                            </div>
                            <button type="submit" class="btn btn-success btn-block btn-lg"><i class="fa fa-check"></i> Process Payment</button>
                        </div>
                    </div>
                </div>
        </form>
    </section>
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addItemModalLabel">Add Billable Item</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Category</label>
                    <select id="modal_category" class="form-control" onchange="loadItems(this.value)">
                        <option value="">Select Category</option>
                        <option value="Services">Services / Procedures</option>
                        <option value="Laboratory">Laboratory</option>
                        <option value="Pharmacy">Pharmacy / Medicine</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Item Name</label>
                    <select id="modal_item" class="form-control" onchange="updatePrice(this)">
                        <option value="">Select Item</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" id="modal_price" class="form-control" step="0.01" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" id="modal_qty" class="form-control" value="1" min="1" onkeyup="calculateModalTotal()" onchange="calculateModalTotal()">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Discount</label>
                            <input type="number" id="modal_discount" class="form-control" value="0" step="0.01" onkeyup="calculateModalTotal()" onchange="calculateModalTotal()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" id="modal_total" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addItemToTable()">Add Item</button>
            </div>
        </div>
    </div>
</div>

<script>
    var globalRowCount = <?php echo isset($items) ? count($items) : 0;?>;

    function calculateModalTotal(){
        var price = parseFloat(document.getElementById('modal_price').value) || 0;
        var qty = parseFloat(document.getElementById('modal_qty').value) || 0;
        var discount = parseFloat(document.getElementById('modal_discount').value) || 0;
        
        var total = (price * qty) - discount;
        if(total < 0) total = 0;
        
        document.getElementById('modal_total').value = total.toFixed(2);
    }
    
    function loadItems(category){
        if(category == "") {
            document.getElementById('modal_item').innerHTML = '<option value="">Select Item</option>';
            return;
        }
        
        $.ajax({
            url: '<?php echo base_url()?>app/billing_new/get_items/' + category,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                var html = '<option value="">Select Item</option>';
                for(var i=0; i<data.length; i++){
                    html += '<option value="'+data[i].id+'" data-price="'+data[i].price+'">'+data[i].name+'</option>';
                }
                document.getElementById('modal_item').innerHTML = html;
            }
        });
    }
    
    function updatePrice(select){
        var price = select.options[select.selectedIndex].getAttribute('data-price');
        document.getElementById('modal_price').value = price;
        calculateModalTotal();
    }
    
    function addItemToTable(){
        var category = document.getElementById('modal_category').value;
        var itemSelect = document.getElementById('modal_item');
        var itemId = itemSelect.value;
        var itemName = itemSelect.options[itemSelect.selectedIndex].text;
        var price = parseFloat(document.getElementById('modal_price').value) || 0;
        var qty = parseFloat(document.getElementById('modal_qty').value) || 0;
        var discount = parseFloat(document.getElementById('modal_discount').value) || 0;
        var total = parseFloat(document.getElementById('modal_total').value) || 0;
        
        if(itemId == ""){
            alert("Please select an item.");
            return;
        }
        
        var table = document.getElementById('billing_table').getElementsByTagName('tbody')[0];
        
        // Remove "No pending items" row if exists
        if(table.rows.length == 1 && table.rows[0].cells.length == 1){
             table.deleteRow(0);
        }
        
        var row = table.insertRow(table.rows.length);
        var i = globalRowCount; // Use global counter
        
        // Cell 0: Item Name (Hidden ID)
        var cell0 = row.insertCell(0);
        cell0.innerHTML = itemName + 
            '<input type="hidden" name="item_id[]" value="' + itemId + '">' +
            '<input type="hidden" name="item_name[]" value="' + itemName + '">';
            
        // Cell 1: Category
        var cell1 = row.insertCell(1);
        cell1.innerHTML = category;
        
        // Cell 2: Price
        var cell2 = row.insertCell(2);
        cell2.innerHTML = price.toFixed(2) + 
            '<input type="hidden" name="price[]" id="price_' + i + '" value="' + price + '">';
            
        // Cell 3: Discount
        var cell3 = row.insertCell(3);
        cell3.innerHTML = '<input type="number" name="item_discount[]" id="discount_' + i + '" value="' + discount + '" step="0.01" class="form-control input-sm" style="width: 80px;" onkeyup="calculateRow(' + i + ')">';
        
        // Cell 4: Qty
        var cell4 = row.insertCell(4);
        cell4.innerHTML = qty + 
            '<input type="hidden" name="qty[]" id="qty_' + i + '" value="' + qty + '">';
            
        // Cell 5: Total
        var cell5 = row.insertCell(5);
        cell5.innerHTML = '<span id="total_display_' + i + '">' + total.toFixed(2) + '</span>' + 
            '<input type="hidden" name="item_total[]" id="total_' + i + '" value="' + total.toFixed(2) + '" class="item-total">';
            
        // Cell 6: Action
        var cell6 = row.insertCell(6);
        cell6.innerHTML = '<a href="#" class="text-danger" onclick="deleteRow(this)"><i class="fa fa-times"></i></a>';
        
        globalRowCount++;
        calculateTotal();
        
        // Close modal and reset
        $('#addItemModal').modal('hide');
        document.getElementById('modal_category').value = "";
        document.getElementById('modal_item').innerHTML = '<option value="">Select Item</option>';
        document.getElementById('modal_price').value = "";
        document.getElementById('modal_qty').value = "1";
        document.getElementById('modal_discount').value = "0";
        document.getElementById('modal_total').value = "";
    }
    
    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        calculateTotal();
    }

    function calculateRow(index){
        var price = parseFloat(document.getElementById('price_' + index).value) || 0;
        var qty = parseFloat(document.getElementById('qty_' + index).value) || 0;
        var discount = parseFloat(document.getElementById('discount_' + index).value) || 0;
        
        var total = (price * qty) - discount;
        if(total < 0) total = 0;
        
        // Update display
        document.getElementById('total_display_' + index).innerText = total.toFixed(2);
        
        // Update hidden input
        document.getElementById('total_' + index).value = total.toFixed(2);
        
        // Recalculate Grand Total
        calculateTotal();
    }

    function calculateTotal(){
        var grandTotal = 0;
        var itemTotals = document.getElementsByClassName('item-total');
        
        for(var i = 0; i < itemTotals.length; i++){
            grandTotal += parseFloat(itemTotals[i].value) || 0;
        }
        
        document.getElementById('total_amount').value = grandTotal.toFixed(2);
        
        var globalDiscount = parseFloat(document.getElementById('discount').value) || 0;
        var net = grandTotal - globalDiscount;
        if(net < 0) net = 0;
        
        document.getElementById('net_total').value = net.toFixed(2);
        
        calculateChange();
    }
    
    function calculateChange(){
        var net = parseFloat(document.getElementById('net_total').value) || 0;
        var cash = parseFloat(document.getElementById('cash_tendered').value) || 0;
        var change = cash - net;
        
        if(change < 0) change = 0;
        document.getElementById('change').value = change.toFixed(2);
    }
</script>

<script src="<?php echo base_url()?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url()?>public/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>public/js/AdminLTE/app.js" type="text/javascript"></script>
</body>
</html>
