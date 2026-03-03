<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Void Transaction
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url('app/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url('app/pharmacy');?>">Pharmacy</a></li>
                <li class="active">Void Transaction</li>
            </ol>
            
            <?php echo $this->session->flashdata('message');?>
        
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-ban"></i> Void Entire Invoice</h3>
                        </div>
                        <div class="box-body">
                            <form action="<?php echo base_url('app/pharmacy/save_void');?>" method="post" onsubmit="return confirmVoid()">
                                <div class="form-group">
                                    <label>Invoice No / OR No</label>
                                    <div class="input-group">
                                        <input type="text" id="invoice_no" name="invoice_no" class="form-control input-lg" placeholder="Enter Invoice No (e.g., PA26020001)" required>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-lg btn-flat" onclick="searchInvoice()">Check</button>
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="invoice_details" style="display:none; margin-bottom: 20px; background: #f9f9f9; padding: 15px; border: 1px solid #ddd;">
                                    <h4 style="margin-top: 0;">Invoice Details</h4>
                                    <p><strong>Patient:</strong> <span id="patient_name"></span></p>
                                    <p><strong>Date:</strong> <span id="date_sale"></span></p>
                                    <p><strong>Total Amount:</strong> <span id="total_amount" style="font-weight:bold; font-size: 16px;"></span></p>
                                    <hr>
                                    <p><strong>Items:</strong></p>
                                    <ul id="item_list" style="padding-left: 20px;"></ul>
                                </div>
                                
                                <div class="form-group">
                                    <label>Reason for Voiding</label>
                                    <textarea name="reason" class="form-control" rows="3" placeholder="Explain why this transaction is being voided..." required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-block btn-lg">VOID TRANSACTION</button>
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
                    
                    if(sale.InActive == 1){
                        alert('This invoice is ALREADY VOIDED!');
                        $('#invoice_details').hide();
                        return;
                    }
                    
                    var name = (sale.firstname || '') + ' ' + (sale.lastname || '');
                    if(sale.patient_no == null) name = "Walk-in / " + (sale.patient_name || 'Unknown');
                    
                    $('#patient_name').text(name);
                    $('#date_sale').text(sale.date_sale);
                    $('#total_amount').text(sale.total_amount); // Ensure format is correct in controller or format here
                    
                    var html = '';
                    if(data.items.length > 0){
                        $.each(data.items, function(i, item){
                            html += '<li>' + item.drug_name + ' (Qty: ' + item.qty + ')</li>';
                        });
                    }
                    $('#item_list').html(html);
                    $('#invoice_details').show();
                } else {
                    alert(data.message);
                    $('#invoice_details').hide();
                }
            },
            error: function(){
                alert('Error fetching invoice.');
            }
        });
    }
    
    function confirmVoid(){
        if(!$('#invoice_details').is(':visible')){
            alert('Please verify the invoice first by clicking "Check".');
            return false;
        }
        return confirm('WARNING: This action cannot be undone.\n\nAre you sure you want to VOID this entire transaction?');
    }
</script>

</body>
</html>