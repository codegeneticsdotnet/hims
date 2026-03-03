<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Inventory Ledger
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url('app/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url('app/pharmacy');?>">Pharmacy</a></li>
                <li class="active">Inventory Ledger</li>
            </ol>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <br /><label>&nbsp;&nbsp;Search Item &nbsp; </label>
                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 350px; display: inline-table;">
                                    <input type="text" id="search_item" class="form-control pull-right" placeholder="Search Item..." autocomplete="off">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div id="search_result" style="position: absolute; z-index: 999; background: #fff; width: 350px; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="callout callout-info" id="item_info_box" style="display:none;">
                                <h4>Item Info</h4>
                                <p><strong>Item Name:</strong> <span id="info_name"></span></p>
                                <p><strong>Stock on Hand:</strong> <span id="info_stock"></span></p>
                                <div style="margin-top: 10px;">
                                    <button type="button" class="btn btn-default" onclick="printLedger()"><i class="fa fa-print"></i> Print</button>
                                    <button type="button" class="btn btn-success" onclick="exportLedger()"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered" id="ledger_table">
                                    <thead>
                                        <tr>
                                            <th>REF DATE</th>
                                            <th>REF NO</th>
                                            <th>TYPE</th>
                                            <th>EXPIRY</th>
                                            <th>AMOUNT</th>
                                            <th>IN</th>
                                            <th>OUT</th>
                                            <th>TOTAL</th>
                                            <th>REMARKS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="empty_row"><td colspan="9" class="text-center">Select an item to view ledger.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer clearfix">&nbsp;
                            </div>
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
                            html += '<li class="list-group-item" style="cursor: pointer;" onclick="loadLedger(' + item.item_id + ', \'' + item.item_name.replace(/'/g, "\\'") + '\', ' + item.stock_on_hand + ')">' + item.item_name + ' (Stock: ' + item.stock_on_hand + ')</li>';
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
    
    var current_item_id = 0;
    
    function loadLedger(id, name, stock){
        current_item_id = id;
        $('#search_result').hide();
        $('#search_item').val(name);
        $('#info_name').text(name);
        $('#item_info_box').show();
        
        $.ajax({
            url: "<?php echo base_url();?>app/pharmacy/get_item_ledger/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                    var data = response.ledger;
                    var current_stock = response.current_stock;
                    
                    $('#info_stock').text(current_stock);
                    
                    var html = '';
                    var running_total = 0;
                    
                    if(data.length > 0){
                    $.each(data, function(i, item){
                        var qty_in = parseFloat(item.qty_in) || 0;
                        var qty_out = parseFloat(item.qty_out) || 0;
                        running_total += qty_in - qty_out;
                        
                        var typeLabel = item.type;
                        if(typeLabel == 'Cash Sales') typeLabel = '<span class="label label-success">Cash Sales</span>';
                        else if(typeLabel == 'Charge Sales') typeLabel = '<span class="label label-warning">IPD Charge</span>';
                        else if(typeLabel == 'Inventory In') typeLabel = '<span class="label label-primary">Inventory In</span>';
                        else if(typeLabel == 'Return') typeLabel = '<span class="label label-danger">Return</span>';
                        else if(typeLabel == 'Void Transaction') typeLabel = '<span class="label label-danger">Void</span>';
                        
                        var expiry = item.expiry_date ? item.expiry_date : '-';
                        var unit_cost = 0;
                        if(qty_in > 0 && parseFloat(item.amount) > 0){
                             unit_cost = parseFloat(item.amount) / qty_in;
                        } else if(qty_out > 0 && parseFloat(item.amount) > 0){
                             unit_cost = parseFloat(item.amount) / qty_out; 
                        }
                        
                        // Fix for Adjustment OUT - Amount is 0, so show 0 cost or fetch last cost
                        if(item.type.indexOf('Adjustment (OUT)') !== -1 && unit_cost == 0){
                            // Optional: logic to show cost if needed, for now 0 is fine or N/A
                        }
                        
                        html += '<tr>';
                        html += '<td>' + item.ref_date + '</td>';
                        html += '<td>' + item.ref_no + '</td>';
                        html += '<td>' + typeLabel + '</td>';
                        html += '<td>' + expiry + '</td>';
                        html += '<td class="text-right">' + unit_cost.toFixed(2) + '</td>';
                        html += '<td class="text-center">' + (qty_in > 0 ? qty_in : '-') + '</td>';
                        html += '<td class="text-center">' + (qty_out > 0 ? qty_out : '-') + '</td>';
                        html += '<td class="text-center" style="font-weight:bold;">' + running_total + '</td>';
                        html += '<td>' + (item.remarks || '') + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="9" class="text-center">No transactions found.</td></tr>';
                }
                
                $('#ledger_table tbody').html(html);
            }
        });
    }
    
    function printLedger(){
        if(current_item_id > 0){
            window.open("<?php echo base_url();?>app/pharmacy/print_ledger/" + current_item_id, "_blank");
        } else {
            alert('Please select an item first.');
        }
    }
    
    function exportLedger(){
        if(current_item_id > 0){
             window.location.href = "<?php echo base_url();?>app/pharmacy/export_ledger/" + current_item_id;
        } else {
            alert('Please select an item first.');
        }
    }
    
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