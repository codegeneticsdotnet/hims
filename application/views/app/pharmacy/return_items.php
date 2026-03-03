<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pharmacy Returns
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url('app/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url('app/pharmacy');?>">Pharmacy</a></li>
                <li class="active">Returns</li>
            </ol>
            
            <?php echo $this->session->flashdata('message');?>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Return Items</h3>
                        </div>
                        <div class="box-body">
                            <form action="<?php echo base_url('app/pharmacy/save_return');?>" method="post" onsubmit="return validateReturn()">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Invoice No / OR No</label>
                                            <div class="input-group">
                                                <input type="text" id="invoice_no" class="form-control" placeholder="Enter Invoice No (e.g., PA26020001)">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" onclick="searchInvoice()">Search</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Return No</label>
                                            <input type="text" name="return_no" class="form-control" value="<?php echo $return_no;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" id="patient_info" style="display:none;">
                                    <div class="col-md-12">
                                        <div class="callout callout-info">
                                            <p><strong>Patient:</strong> <span id="patient_name"></span> (<span id="patient_no_display"></span>)</p>
                                            <input type="hidden" name="patient_no" id="patient_no_input">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Remarks / Reason for Return</label>
                                    <textarea name="remarks" class="form-control" required></textarea>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered" id="return_table">
                                        <thead>
                                            <tr>
                                                <th>Drug Name</th>
                                                <th>Price</th>
                                                <th>Qty Sold</th>
                                                <th>Total</th>
                                                <th>Qty to Return</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="empty_row"><td colspan="5" class="text-center">Search Invoice to load items.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">Save Return</button>
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
    $(document).ready(function(){
        <?php if($this->session->flashdata('print_return_id')): ?>
            window.open("<?php echo base_url();?>app/pharmacy/print_return/<?php echo $this->session->flashdata('print_return_id'); ?>", "_blank");
        <?php endif; ?>
    });

    function searchInvoice(){
        var invoice = $('#invoice_no').val();
        if(invoice == ''){
            alert('Please enter Invoice No.');
            return;
        }
        
        $.ajax({
            url: "<?php echo base_url();?>app/pharmacy/get_sale_items/" + invoice,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                if(data.status == 'success'){
                    var sale = data.sale;
                    var name = (sale.firstname || '') + ' ' + (sale.lastname || '');
                    if(sale.patient_no == null) name = "Walk-in / " + (sale.patient_name || 'Unknown');
                    
                    $('#patient_name').text(name);
                    $('#patient_no_display').text(sale.patient_no || '-');
                    $('#patient_no_input').val(sale.patient_no);
                    $('#patient_info').show();
                    
                    var html = '';
                    if(data.items.length > 0){
                        $.each(data.items, function(i, item){
                            html += '<tr>';
                            html += '<td>' + item.drug_name + '</td>';
                            html += '<td>' + item.price + '</td>';
                            html += '<td>' + item.qty + '</td>';
                            html += '<td>' + item.total + '</td>';
                            html += '<td>';
                            html += '<input type="number" name="qty_return[]" class="form-control input-sm qty-return" min="0" max="' + item.qty + '" value="0">';
                            html += '<input type="hidden" name="drug_id[]" value="' + item.drug_id + '">';
                            html += '</td>';
                            html += '</tr>';
                        });
                    }
                    $('#return_table tbody').html(html);
                } else {
                    alert(data.message);
                    $('#patient_info').hide();
                    $('#return_table tbody').html('<tr id="empty_row"><td colspan="5" class="text-center">Invoice not found.</td></tr>');
                }
            },
            error: function(){
                alert('Error fetching invoice.');
            }
        });
    }
    
    function validateReturn(){
        var hasQty = false;
        $('.qty-return').each(function(){
            if($(this).val() > 0) hasQty = true;
        });
        
        if(!hasQty){
            alert('Please enter at least one quantity to return.');
            return false;
        }
        return true;
    }
</script>

</body>
</html>