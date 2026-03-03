<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Stock Adjustments
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url('app/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url('app/pharmacy');?>">Pharmacy</a></li>
                <li class="active">Adjustments</li>
            </ol>
            
            <?php echo $this->session->flashdata('message');?>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Create Adjustment</h3>
                        </div>
                        <div class="box-body">
                            <form action="<?php echo base_url('app/pharmacy/save_adjustment');?>" method="post" onsubmit="return validateForm()">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Adjustment No</label>
                                            <input type="text" name="reference_no" class="form-control" value="<?php echo $ref_no;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group" style="position: relative;">
                                    <label>Search Item</label>
                                    <input type="text" id="search_item" class="form-control" placeholder="Search Item to adjust..." autocomplete="off">
                                    <div id="search_result" style="position: absolute; z-index: 999; background: #fff; width: 100%; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered" id="adjustment_table">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Stock on Hand</th>
                                                <th>Amount</th>
                                                <th width="10%">Adjustment</th>
                                                <th width="10%">Type</th>
                                                <th>Total</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="adjustment_body">
                                            <tr id="empty_row"><td colspan="8" class="text-center">Add items to adjust.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">Save Adjustment</button>
                                </div>
                            </form>
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
                            html += '<li class="list-group-item" style="cursor: pointer;" onclick="addItem(' + item.item_id + ', \'' + item.item_name.replace(/'/g, "\\'") + '\', ' + item.stock_on_hand + ', ' + item.price + ')">' + item.item_name + ' (Stock: ' + item.stock_on_hand + ')</li>';
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
    
    function addItem(id, name, stock, price){
        $('#search_result').hide();
        $('#search_item').val('');
        $('#empty_row').remove();
        
        // Check if exists
        var exists = false;
        $('input[name="drug_id[]"]').each(function(){
            if($(this).val() == id){
                alert('Item already added!');
                exists = true;
                return false;
            }
        });
        if(exists) return;
        
        var html = '<tr>';
        html += '<td>' + name + '<input type="hidden" name="drug_id[]" value="' + id + '"></td>';
        html += '<td>' + stock + '<input type="hidden" name="stock_on_hand[]" class="stock-val" value="' + stock + '"></td>';
        html += '<td>' + parseFloat(price).toFixed(2) + '</td>';
        html += '<td><input type="number" name="adjust_qty[]" class="form-control input-sm qty-input" value="0" min="1" onchange="calculateRow(this)" onkeyup="calculateRow(this)"></td>';
        html += '<td><select name="type[]" class="form-control input-sm type-select" onchange="calculateRow(this)"><option value="IN">IN (+)</option><option value="OUT">OUT (-)</option></select></td>';
        html += '<td><span class="row-total">' + stock + '</span></td>';
        html += '<td><input type="text" name="reason[]" class="form-control input-sm" placeholder="Reason" required></td>';
        html += '<td><a href="#" class="text-danger" onclick="removeRow(this)"><i class="fa fa-times"></i></a></td>';
        html += '</tr>';
        
        $('#adjustment_body').append(html);
    }
    
    function calculateRow(element){
        var row = $(element).closest('tr');
        var stock = parseFloat(row.find('.stock-val').val()) || 0;
        var qty = parseFloat(row.find('.qty-input').val()) || 0;
        var type = row.find('.type-select').val();
        
        var total = stock;
        if(type == 'IN'){
            total = stock + qty;
        } else {
            total = stock - qty;
            if(total < 0){
                alert('Adjustment cannot result in negative stock!');
                row.find('.qty-input').val(0);
                total = stock;
            }
        }
        
        row.find('.row-total').text(total);
    }
    
    function removeRow(btn){
        $(btn).closest('tr').remove();
        if($('#adjustment_body tr').length == 0){
             $('#adjustment_body').append('<tr id="empty_row"><td colspan="8" class="text-center">Add items to adjust.</td></tr>');
        }
    }
    
    function validateForm(){
        if($('#adjustment_body tr').length == 0 || $('#empty_row').length > 0){
            alert('Please add items to adjust.');
            return false;
        }
        
        var valid = true;
        $('.qty-input').each(function(){
            if($(this).val() <= 0){
                alert('Adjustment quantity must be greater than 0.');
                valid = false;
                return false;
            }
        });
        
        return valid ? confirm('Are you sure you want to save this adjustment?') : false;
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