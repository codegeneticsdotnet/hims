<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Create Stock Transfer</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/pharmacy">Pharmacy</a></li>
            <li><a href="<?php echo base_url()?>app/inventory/stock_transfer">Stock Transfer</a></li>
            <li class="active">Add Stock Transfer</li>
        </ol>
        
        <form action="<?php echo base_url()?>app/inventory/save_stock_transfer" method="post" onsubmit="return validateForm()">
        
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Transfer Details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Transfer No.</label>
                            <input type="text" name="transfer_no" value="<?php echo $transfer_no;?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Transfer Date</label>
                            <input type="text" name="transfer_date" value="<?php echo date('Y-m-d');?>" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>From Branch / Source</label>
                            <input type="text" id="from_branch_search" class="form-control" placeholder="Search Branch..." autocomplete="off" value="<?php echo $this->session->userdata('branch_name') ? $this->session->userdata('branch_name') : 'Main Inventory (Central Pharmacy)';?>" readonly>
                            <input type="hidden" name="from_branch" id="from_branch_id" value="<?php echo $this->session->userdata('branch_id') ? $this->session->userdata('branch_id') : 0;?>">
                            <div id="from_branch_suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>To Branch / Destination</label>
                            <input type="text" id="to_branch_search" class="form-control" placeholder="Search Branch..." autocomplete="off">
                            <input type="hidden" name="to_branch" id="to_branch_id" required>
                            <div id="to_branch_suggestions" class="list-group" style="position: absolute; z-index: 1000; display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Items to Transfer</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" onclick="addItemRow()"><i class="fa fa-plus"></i> Add Item</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered" id="transfer_table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Current Stock (Main)</th>
                            <th>Bin Location</th>
                            <th>Qty to Transfer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added here -->
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save Transfer</button>
                <a href="<?php echo base_url()?>app/inventory/stock_transfer" class="btn btn-default">Cancel</a>
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
    // Load items once
    $.ajax({
        url: '<?php echo base_url()?>app/inventory/get_items_json',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            allItems = data;
            addItemRow(); // Add first row
        }
    });
    
    // Branch Search Logic (From)
    $('#from_branch_search').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            $.ajax({
                url: '<?php echo base_url()?>app/inventory/search_branches/' + query,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var html = '';
                    // Add Main Inventory Option
                    html += '<a href="#" class="list-group-item from-branch-item" data-id="0" data-name="Main Inventory (Central Pharmacy)">Main Inventory (Central Pharmacy)</a>';
                    
                    if(data.length > 0){
                        for(var i=0; i<data.length; i++){
                            html += '<a href="#" class="list-group-item from-branch-item" data-id="'+data[i].id+'" data-name="'+data[i].name+'">'+data[i].name+'</a>';
                        }
                    }
                    $('#from_branch_suggestions').html(html).show();
                }
            });
        } else {
            $('#from_branch_suggestions').hide();
        }
    });
    
    $(document).on('click', '.from-branch-item', function(e){
        e.preventDefault();
        $('#from_branch_search').val($(this).data('name'));
        $('#from_branch_id').val($(this).data('id'));
        $('#from_branch_suggestions').hide();
    });
    
    // Branch Search Logic (To)
    $('#to_branch_search').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            $.ajax({
                url: '<?php echo base_url()?>app/inventory/search_branches/' + query,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var html = '';
                    if(data.length > 0){
                        for(var i=0; i<data.length; i++){
                            html += '<a href="#" class="list-group-item to-branch-item" data-id="'+data[i].id+'" data-name="'+data[i].name+'">'+data[i].name+'</a>';
                        }
                    } else {
                        html += '<a href="#" class="list-group-item disabled">No results found</a>';
                    }
                    $('#to_branch_suggestions').html(html).show();
                }
            });
        } else {
            $('#to_branch_suggestions').hide();
        }
    });
    
    $(document).on('click', '.to-branch-item', function(e){
        e.preventDefault();
        $('#to_branch_search').val($(this).data('name'));
        $('#to_branch_id').val($(this).data('id'));
        $('#to_branch_suggestions').hide();
    });
});

function addItemRow(){
    var tbody = document.getElementById('transfer_table').getElementsByTagName('tbody')[0];
    var row = tbody.insertRow(tbody.rows.length);
    var rowIndex = tbody.rows.length - 1;
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
    var rows = document.getElementById('transfer_table').getElementsByTagName('tbody')[0].rows;
    if(rows.length == 0){
        alert("Please add at least one item.");
        return false;
    }
    
    if($('#to_branch_id').val() == ''){
        alert("Please select a destination branch.");
        return false;
    }
    
    return true;
}
</script>

</body>
</html>
