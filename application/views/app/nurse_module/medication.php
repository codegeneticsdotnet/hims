<?php require_once(APPPATH.'views/include/head.php');?>                
    <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Medication</h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Nurse Module</a></li>
                        <li><a href="#">In-Patient Information</a></li>
                        <li class="active">Medication</li>
                    </ol>
                 
                 
        
                 
                 
               
                 <div class="row">
                 	
                     <div class="col-md-3">
                    	 <div class="box">
                         	 <div class="box-header"></div>
                        	<div class="box-body table-responsive no-padding">
                            	<table width="100%" cellpadding="3" cellspacing="3">
                                <tr>
                                	<td width="15%" valign="top" align="center">
                                    <?php
									if(!$patientInfo->picture){
										$picture = "avatar.png";	
									}else{
										$picture = $patientInfo->picture;
									}
									?>
									<img src="<?php echo base_url();?>public/patient_picture/<?php echo $picture;?>" class="img-rounded" width="86" height="81">
                                    </td>
                                    <td>
                                    	<table width="100%">
                                        <tr>
                                        	<td><u>Patient No.</u></td>
                                        </tr>
                                        <tr>
                                			<td><?php echo $patientInfo->patient_no?></td>
                                		</tr>
                                        <tr>
                                        	<td><u>Patient Name</u></td>
                                        </tr>
                                        <tr>
                                			<td><?php echo $patientInfo->name?></td>
                                		</tr>
                                        </table>
                                    </td>
                                </tr>
                                </table>
                            </div>
                            <div class="box-footer clearfix">
                            	<table class="table">
                                <tr>
                                	<td><u>IOP No.</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->IO_ID;?></td>
                                </tr>
                                <tr>
                                	<td><u>Date Time Admit</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo date("M d, Y", strtotime($getOPDPatient->date_visit));?>&nbsp;<?php echo date("H:i:s A", strtotime($getOPDPatient->time_visit));?></td>
                                </tr>
                                <tr>
                                	<td><u>In-Charge Doctor</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->con_doctor;?></td>
                                </tr>
                                <tr>
                                	<td><u>Department</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->dept_name;?></td>
                                </tr>
                                <tr>
                                	<td><u>Room</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->room_name;?></td>
                                </tr>
                                <tr>
                                	<td><u>Bed No.</u></td>
                                </tr>
                                <tr>
                                	<td><?php echo $getOPDPatient->bed_name;?></td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                     
                     <div class="col-md-9"> 
                                <div class="nav-tabs-custom">
                                	<ul class="nav nav-tabs">
                                		<li class="active"><a href="#tab_1" data-toggle="tab">Medication</a></li>
                                        
                                	</ul>
                                    <div class="tab-content">
                                    	<div class="tab-pane active" id="tab_1">
                                        	
                                            <?php echo $message;?>
                                           <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Medication</a>
                                          
                                           <a href="<?php echo base_url()?>app/ipd_print/print_medication/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Print</a>
                                           <table class="table table-hover table-striped">
                                           <thead>
                                           		<tr>
                                                	<th>Medicine Name</th>
                                                    <th>Instruction</th>
                                                    <th>Advice</th>
                                                    <th>Days</th>
                                                    <th>Qty</th>
                                                    <th>Prepared by</th>
                                                    <th></th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                           <?php foreach($patientMedication as $rows){?>
                                           <tr>
                                           		<td><?php echo $rows->drug_name?></td>
                                                <td><?php echo $rows->instruction?></td>
                                                <td><?php echo $rows->advice?></td>
                                                <td><?php echo $rows->days?></td>
                                                <td><?php echo $rows->total_qty?></td>
                                                <td><?php echo $rows->name?></td>
                                                <td>
                                                <a href="<?php echo base_url()?>app/nurse_module/delete_medication/<?php echo $rows->iop_med_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $getOPDPatient->patient_no?>" onClick="return confirm('Are you sure you want to remove?');">Remove</a>
                                          		</td>
                                           </tr>
                                           <?php }?> 
                                           </tbody>
                                           </table>
                                            
                                            <br><br><br><br><br><br><br>
                                            <br><br><br><br><br><br><br>
                                            <br><br><br><br><br><br><br>
                                        </div>
                           			</div>
                            <div class="box-footer clearfix">
                                	
                            </div>
                        </div>
                    </div>
                 </div>
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
							<!-- Modal -->
<form method="post" action="<?php echo base_url()?>app/nurse_module/save_medication_pos" onSubmit="if(confirm('Are you sure you want to save?')){ document.getElementById('btnSubmitPOS').disabled=true; return true; } else { return false; }">
    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
    <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
    <input type="hidden" name="patient_name" value="<?php echo $patientInfo->name?>">
    <input type="hidden" name="payment_type" value="Charge">
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Medication (Pharmacy Charge)</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                         <div class="col-md-6">
                            <label>Search Medicine</label>
                            <input type="text" id="search_item" class="form-control" placeholder="Search Item..." autocomplete="off">
                            <div id="search_result" class="list-group" style="position: absolute; z-index: 999; display: none; width: 95%; max-height: 200px; overflow-y: auto;"></div>
                        </div>
                    </div>
                    <br>
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
                    
                    <div class="row">
                        <div class="col-md-4 col-md-offset-8">
                             <table class="table">
                                <tr>
                                    <td><strong>Total Amount:</strong></td>
                                    <td><input type="text" name="total_amount" id="total_amount" class="form-control text-right" value="0.00" readonly></td>
                                </tr>
                                <tr>
                                    <td><strong>Discount:</strong></td>
                                    <td><input type="number" name="discount" id="discount" class="form-control text-right" value="0.00" onkeyup="calculateTotal()"></td>
                                </tr>
                                <tr>
                                    <td><strong>Net Total:</strong></td>
                                    <td><input type="text" name="net_total" id="net_total" class="form-control text-right" value="0.00" readonly style="font-weight:bold; color:green;"></td>
                                </tr>
                             </table>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitPOS">Save & Charge</button>
                </div>
            </div>
        </div>
    </div>
</form>

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
                    var html = '';
                    if(data.length > 0){
                        $.each(data, function(i, item){
                            html += '<a href="#" class="list-group-item" onclick="addItem(' + item.item_id + ', \'' + item.item_name.replace(/'/g, "\\'") + '\', ' + item.price + ', ' + item.stock_on_hand + '); return false;">' + item.item_name + ' (Stock: ' + item.stock_on_hand + ') - ' + item.price + '</a>';
                        });
                    } else {
                        html += '<a href="#" class="list-group-item disabled">No items found</a>';
                    }
                    $('#search_result').html(html).show();
                }
            });
        } else {
            $('#search_result').hide();
        }
    });

    // Close search result on click outside
    $(document).mouseup(function(e) {
        var container = $("#search_result");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

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
                alert('Item already added.');
                return false;
            }
        });
        
        if(exists) return;
        
        var qty = 1;
        if(stock < 1){
            alert('Item is out of stock!');
            return;
        }

        var html = '<tr>';
        html += '<td>' + name + '<input type="hidden" name="item_id[]" value="' + id + '"><input type="hidden" name="item_name[]" value="' + name + '"></td>';
        html += '<td>' + stock + '<input type="hidden" class="stock-val" value="' + stock + '"></td>';
        html += '<td>' + parseFloat(price).toFixed(2) + '<input type="hidden" name="price[]" class="price-val" value="' + price + '"></td>';
        html += '<td><input type="number" name="qty[]" class="form-control input-sm qty-input" value="' + qty + '" min="1" max="' + stock + '" onchange="calculateRow(this)" onkeyup="calculateRow(this)" style="width: 70px;"></td>';
        html += '<td><span class="row-total">' + (parseFloat(price) * qty).toFixed(2) + '</span></td>';
        html += '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        
        $('#pos_body').append(html);
        calculateTotal();
    }
    
    function removeRow(btn){
        $(btn).closest('tr').remove();
        if($('#pos_body tr').length == 0){
             $('#pos_body').append('<tr id="empty_row"><td colspan="6" class="text-center">No items added.</td></tr>');
        }
        calculateTotal();
    }
    
    function calculateRow(element){
        var row = $(element).closest('tr');
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
    
    function calculateTotal(){
        var grandTotal = 0;
        $('.row-total').each(function(){
            grandTotal += parseFloat($(this).text()) || 0;
        });
        
        $('#total_amount').val(grandTotal.toFixed(2));
        
        var discount = parseFloat($('#discount').val()) || 0;
        var net = grandTotal - discount;
        if(net < 0) net = 0;
        
        $('#net_total').val(net.toFixed(2));
    }
</script>