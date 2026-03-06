<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>New Stock Issuance</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
            <li><a href="<?php echo base_url()?>app/inventory/stock_issuance">Stock Issuance</a></li>
            <li class="active">Add Stock Issuance</li>
        </ol>
        
        <form action="<?php echo base_url()?>app/inventory/save_stock_issuance" method="post" onsubmit="return validateForm()">
        
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Issuance Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Issuance No.</label>
                            <input type="text" name="issuance_no" value="<?php echo $issuance_no;?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Issuance Date</label>
                            <input type="text" name="issue_date" value="<?php echo date('Y-m-d');?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Issued To (Employee)</label>
                            <input type="text" id="issued_to_search" class="form-control" placeholder="Search Employee..." autocomplete="off">
                            <input type="hidden" name="issued_to_id" id="issued_to_id" required>
                            <div id="employee_suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="1"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Items to Issue</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" id="search_item" class="form-control" placeholder="Search Item..." autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <div id="search_result" style="position: absolute; z-index: 1000; background: #fff; width: 93%; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="issuance_table">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Current Stock</th>
                                            <th>Bin Location</th>
                                            <th>Qty to Issue</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="issuance_body">
                                        <tr id="empty_row"><td colspan="5" class="text-center">No items added.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Save Issuance</button>
                            <a href="<?php echo base_url()?>app/inventory/stock_issuance" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
        
        </form>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
    var allItems = [];
    
    $(document).ready(function(){
        // Employee Search Logic
        $('#issued_to_search').keyup(function(){
            var query = $(this).val();
            if(query.length > 1){
                $.ajax({
                    url: '<?php echo base_url()?>app/inventory/search_employees/' + query,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        var html = '';
                        if(data.length > 0){
                            for(var i=0; i<data.length; i++){
                                html += '<a href="#" class="list-group-item employee-item" data-id="'+data[i].id+'" data-name="'+data[i].name+'">'+data[i].name+'</a>';
                            }
                        } else {
                            html += '<a href="#" class="list-group-item disabled">No results found</a>';
                        }
                        $('#employee_suggestions').html(html).show();
                    }
                });
            } else {
                $('#employee_suggestions').hide();
            }
        });
        
        $(document).on('click', '.employee-item', function(e){
            e.preventDefault();
            $('#issued_to_search').val($(this).data('name'));
            $('#issued_to_id').val($(this).data('id'));
            $('#employee_suggestions').hide();
        });
        
        // Item Search Logic (New)
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
                                html += '<li class="list-group-item" style="cursor: pointer;" onclick="addItem(' + item.item_id + ', \'' + item.item_name.replace(/'/g, "\\'") + '\', ' + item.stock_on_hand + ', \'' + (item.bin_location ? item.bin_location : '') + '\')">' + item.item_name + ' (Stock: ' + item.stock_on_hand + ')</li>';
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
    });

    function addItem(id, name, stock, bin){
        $('#search_result').hide();
        $('#search_item').val('');
        $('#empty_row').remove();
        
        var html = '<tr>';
        html += '<td>' + name + '<input type="hidden" name="item_id[]" value="' + id + '"></td>';
        html += '<td>' + stock + '</td>';
        html += '<td>' + bin + '</td>';
        html += '<td><input type="number" name="qty[]" class="form-control input-sm" value="1" min="1" step="0.01" style="width: 100px;" required></td>';
        html += '<td><a href="#" class="text-danger" onclick="removeRow(this)"><i class="fa fa-times"></i></a></td>';
        html += '</tr>';
        
        $('#issuance_body').append(html);
    }
    
    function removeRow(btn){
        $(btn).closest('tr').remove();
        if($('#issuance_body tr').length == 0){
             $('#issuance_body').append('<tr id="empty_row"><td colspan="5" class="text-center">No items added.</td></tr>');
        }
    }
    
    function validateForm(){
        if($('#issuance_body tr').length == 0 || $('#issuance_body tr#empty_row').length > 0){
            alert('Please add items to issue.');
            return false;
        }
        
        // Check if employee selected
        if($('#issued_to_id').val() == ''){
            alert("Please select an employee.");
            return false;
        }
        return true;
    }
    
    // Close search results when clicking outside
    $(document).mouseup(function(e){
        var container = $("#search_result");
        if (!container.is(e.target) && container.has(e.target).length === 0){
            container.hide();
        }
        
        var employeeContainer = $("#employee_suggestions");
        if (!employeeContainer.is(e.target) && employeeContainer.has(e.target).length === 0){
            employeeContainer.hide();
        }
    });
</script>

</body>
</html>
