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
        
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Items to Issue</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" onclick="addItemRow()"><i class="fa fa-plus"></i> Add Item</button>
                </div>
            </div>
            <div class="box-body table-responsive">
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
                    <tbody>
                        <!-- Rows will be added here -->
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save Issuance</button>
                <a href="<?php echo base_url()?>app/inventory/stock_issuance" class="btn btn-default">Cancel</a>
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
    // Load items once for simple autocomplete or use select2 if preferred
    // Here we implement simple autocomplete for item name like POS
    $.ajax({
        url: '<?php echo base_url()?>app/inventory/get_items_json',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            allItems = data;
            addItemRow(); // Add first row
        }
    });
    
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
});

function addItemRow(){
    var tbody = document.getElementById('issuance_table').getElementsByTagName('tbody')[0];
    var row = tbody.insertRow(tbody.rows.length);
    var rowIndex = tbody.rows.length - 1;
    
    // Create Datalist ID unique to row
    var datalistId = 'item_list_' + rowIndex;
    
    var options = '';
    for(var i=0; i<allItems.length; i++){
        options += '<option value="'+allItems[i].drug_name+'" data-id="'+allItems[i].drug_id+'">';
    }
    
    row.innerHTML = `
        <td style="position: relative;">
            <input type="text" class="form-control item-search" onkeyup="searchItem(this)" placeholder="Type item name..." autocomplete="off">
            <div class="search-results" style="position: absolute; z-index: 1000; background: #fff; width: 100%; border: 1px solid #ccc; display: none; max-height: 200px; overflow-y: auto;"></div>
            <input type="hidden" name="item_id[]" class="item-id" required>
        </td>
        <td><input type="text" class="form-control stock-display" readonly></td>
        <td><input type="text" class="form-control bin-display" readonly></td>
        <td><input type="number" name="qty[]" class="form-control" min="1" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-xs" onclick="removeRow(this)"><i class="fa fa-times"></i></button></td>
    `;
}

function searchItem(input){
    var keyword = $(input).val();
    var resultsDiv = $(input).siblings('.search-results');
    
    if(keyword.length > 1){
        var html = '<ul class="list-group" style="margin-bottom: 0;">';
        var found = false;
        
        for(var i=0; i<allItems.length; i++){
            if(allItems[i].drug_name.toLowerCase().indexOf(keyword.toLowerCase()) !== -1){
                html += '<li class="list-group-item" style="cursor: pointer;" onclick="selectItem(this, ' + allItems[i].drug_id + ')">' + allItems[i].drug_name + ' (Stock: ' + allItems[i].nStock + ')</li>';
                found = true;
            }
        }
        
        if(!found){
            html += '<li class="list-group-item">No items found</li>';
        }
        
        html += '</ul>';
        resultsDiv.html(html).show();
    } else {
        resultsDiv.hide();
    }
    
    // Clear ID if text is cleared
    if(keyword == ''){
        $(input).siblings('.item-id').val('');
        var row = $(input).closest('tr');
        row.find('.stock-display').val('');
        row.find('.bin-display').val('');
    }
}

function selectItem(element, itemId){
    var item = allItems.find(x => x.drug_id == itemId);
    var container = $(element).closest('td');
    var input = container.find('.item-search');
    var idInput = container.find('.item-id');
    var resultsDiv = container.find('.search-results');
    var row = container.closest('tr');
    
    if(item){
        input.val(item.drug_name);
        idInput.val(item.drug_id);
        row.find('.stock-display').val(item.nStock);
        row.find('.bin-display').val(item.bin_location ? item.bin_location : '');
        resultsDiv.hide();
    }
}

// Close search results when clicking outside
$(document).mouseup(function(e){
    var container = $(".search-results");
    if (!container.is(e.target) && container.has(e.target).length === 0){
        container.hide();
    }
});

function removeRow(btn){
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function validateForm(){
    var rows = document.getElementById('issuance_table').getElementsByTagName('tbody')[0].rows;
    if(rows.length == 0){
        alert("Please add at least one item.");
        return false;
    }
    // Check if employee selected
    if($('#issued_to_id').val() == ''){
        alert("Please select an employee.");
        return false;
    }
    return true;
}
</script>

</body>
</html>
