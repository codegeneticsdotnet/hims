
<script language="javascript">
    $(document).ready(function() {
        // Single Select
        $("#tboxitemname").autocomplete({
            minLength:1,
            source: function( request, response ) {
            // Fetch data
            $.ajax({
                url: "<?php echo base_url();?>app/billing/itemsearch/" + request.term,
                type: 'get',
                dataType: "json",
                success: function( data ) {
                    response(data);
                }
            });
        },
        messages: {
                noResults: '',
                results: function() {}
        },
        select: function (event, ui) {
            // Set selection
            $('#tboxitemname').val(ui.item.label); // display the selected text
            $('#tboxitemcode').val(ui.item.value); // display the selected value
            //alert(ui.item.price); // save selected id to input
            $("#itemrate").val(ui.item.price);
            $("#itemqty").focus();
            //if(ui.item.value != ""){

            //}
            return false;
        },
        focus: function(event, ui){
            $( "#tboxitemname" ).val( ui.item.label );
            //$( "#selectuser_id" ).val( ui.item.value );
            return false;
        },
        });
    });
</script>
<style>
    .ui-autocomplete {
  z-index: 10000000;
}
.ui-helper-hidden-accessible {
            display: none;
        }
</style>
                            <div class="modal fade" id="myBills" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add Item</h4>
                                        </div>
                                        <div class="modal-body">
                                        <table class="table table-hover">
                                        <tbody>
                                        <tr id="parti" >
                                        	<td>
                                                <span id="particular">Particular Category</span>
                                            </td>
                                            <td>
                                                <select name="category" id="category" onChange="showCategory(this.value);" class="form-control input-sm" style="width: 100%;" required>
                                                	<option value="">- Particular Category -</option>
											    	<?php 
											    	foreach($particular_cat as $particular_cat){?>
                                                	<option value="<?php echo $particular_cat->group_id;?>"><?php echo $particular_cat->group_name;?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>
                                                <span id="particular_item">Particular Item</span>
                                                <span id="drug_name" style="display: none">Drug Name</span>
                                            </td>
                                            <td>
                                                <span id="showCategories">
                                                    <select name="item" id="item" class="form-control input-sm" style="width: 100%;" required>
                                                        <option value="">- Particular Item -</option>
                                                    </select>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>Amount</td>
                                            <td>
                                            <label id="showRateDetails">
                                            <input type="text" onkeypress="return isNumberKey(event)" name="rate" id="rate" placeholder="rate" class="form-control input-sm" style="width: 100%;" required>
                                            </label>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>Qty</td>
                                            <td><input type="text" onkeypress="return isNumberKey(event)" name="qty" id="qty" onkeyup="computeTotal()"  value="1" placeholder="Qty" class="form-control input-sm" style="width: 30%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Discount</td>
                                            <td><input type="text" onkeypress="return isNumberKey(event)" onkeyup="computeTotal()" name="discount" id="discounter" value="0" placeholder="Discount" class="form-control input-sm" style="width: 30%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Total</td>
                                            <td><input type="text" onkeypress="return isNumberKey(event)" name="total" id="total" value="0" placeholder="Total" class="form-control input-sm" style="width: 30%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Note</td>
                                            <td><textarea name="note" id="note" placeholder="note" class="form-control input-sm" style="width: 100%;"></textarea></td>
                                        </tr>
                                        <script language="javascript">
                                           function computeTotal() {
                                                var qty = parseFloat($('#qty').val());
                                                var rate = parseFloat($('#rate').val());
                                                var drugRate = parseFloat($('#drugrate').val());
                                                var discount = parseFloat($('#discounter').val());

                                                // Check if drugRate is defined, if not use rate
                                                var unitRate = isNaN(drugRate) ? rate : drugRate;
                                                var total = (qty * unitRate) - discount;
                                                // Update the total input field
                                                $('#total').val(total.toFixed(2)); // Display total up to 2 decimal places
                                            }

                                            function getPatientMedication(){
                  								if(!confirm('Are you sure you want to get the Bills?')){
                  									return false;
                  								}else{
                  									var patientNo,iopNo;
                  									patientNo = document.getElementById("patient_no").value;
                  									iopNo = document.getElementById("opd_no").value;
                  								
                  									var left = (screen.width/2)-(500/2);
                      								var top = (screen.height/2)-(400/2);
                  									var sFeatures="dialogHeight: 420px;  dialogWidth: 600px; dialogTop: " + top + "px; dialogLeft: " + left + "px;";
                  		
                  									window.open("<?php echo base_url()?>app/pos/getPatientMedication/"+patientNo+"/"+iopNo, sFeatures);
                  									return true;
                  								}
                  							}
                                        </script>
                                        <tr>
                                        	<td></td>
                                        	<td>
                                            <!--<span id="buttonMedication" style="display: none;">
                                            <a href="#" class="btn btn-danger" onClick="getPatientMedication()" style="width: 250px;">Get Patient Medication</a>
                                            </span>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onClick="return addItem('particular')">Add</button>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            <div class="modal fade" id="myMedicine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add Item</h4>
                                        </div>
                                        <div class="modal-body">
                                        <div>
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <td>Itemname</td>
                                                    <td>
                                                        <input type="text" name="tboxitemname" id="tboxitemname" class="form-control">
                                                        <input type="hidden" name="tboxitemcode" id="tboxitemcode" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div><br /> AMOXCICILLIN </div>
                                                        <div id="searchresults">&nbsp;
                                                            <table style="width:100%" class="table table-hover input-sm">
                                                            <tr>
                                                                    <th>Batch No. </th>
                                                                    <th>Date </th>
                                                                    <th>Unit Cost</th>
                                                                    <th>Stock    </th>
                                                                    <th>Qty      </th>
                                                                    <th>Total    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>IN24010001</td>
                                                                    <td>01-01-2024</td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:100px" value="1,350.22" /></td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:50px" value="100" /></td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:50px" /></td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:100px" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>IN24010003</td>
                                                                    <td>02-01-2024</td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:100px" value="1,320.22" /></td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:50px" value="100" /></td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:50px" /></td>
                                                                    <td><input type="text" class="form-control input-sm" style="width:100px" /></td>
                                                                </tr>
                                                            <table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--
                                        <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                        	<td>Amount</td>
                                            <td>
                                            <label id="showRate">
                                            <input type="text" onkeypress="return isNumberKey(event)" onkeyup="computeMedTotal()" name="itemrate" id="itemrate" placeholder="Amount" class="form-control input-sm" style="width: 70%;" required>
                                            </label>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td>Qty</td>
                                            <td><input type="text" onkeypress="return isNumberKey(event)" onkeyup="computeMedTotal()" name="itemqty" id="itemqty" value="1" placeholder="Qty" class="form-control input-sm" style="width: 30%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Discount</td>
                                            <td><input type="text" onkeypress="return isNumberKey(event)" onkeyup="computeMedTotal()" name="itemdiscount" id="itemdiscount" value="0" placeholder="Discount" class="form-control input-sm" style="width: 30%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Total</td>
                                            <td><input type="text" onkeypress="return isNumberKey(event)" name="itemtotalamount" id="itemtotalamount" value="0" placeholder="Total" class="form-control input-sm" style="width: 30%;" required></td>
                                        </tr>
                                        <tr>
                                        	<td>Note</td>
                                            <td><textarea name="note" id="note" placeholder="note" class="form-control input-sm" style="width: 100%;"></textarea></td>
                                        </tr>
                                        <script language="javascript">
                                           function computeMedTotal() {
                                                var qty = parseFloat($('#itemqty').val());
                                                var rate = parseFloat($('#itemrate').val());
                                                var disc = parseFloat($('#itemdiscount').val());
                                                
                                                qty = isNaN(qty) ? 0 : qty;
                                                rate = isNaN(rate) ? 0 : rate;
                                                disc = isNaN(disc) ? 0 : disc;
                                                var total = (qty * rate) - disc;
                                                // Update the total input field
                                                $('#itemtotalamount').val(total.toFixed(2)); // Display total up to 2 decimal places
                                            }

                                            function getPatientMedication(){
                  								if(!confirm('Are you sure you want to get the Bills?')){
                  									return false;
                  								}else{
                  									var patientNo,iopNo;
                  									patientNo = document.getElementById("patient_no").value;
                  									iopNo = document.getElementById("opd_no").value;
                  								
                  									var left = (screen.width/2)-(500/2);
                      								var top = (screen.height/2)-(400/2);
                  									var sFeatures="dialogHeight: 420px;  dialogWidth: 600px; dialogTop: " + top + "px; dialogLeft: " + left + "px;";
                  		
                  									window.open("<?php echo base_url()?>app/pos/getPatientMedication/"+patientNo+"/"+iopNo, sFeatures);
                  									return true;
                  								}
                  							}
                                        </script>
                                        <tr>
                                        	<td></td>
                                        	<td>
                                            <!--<span id="buttonMedication" style="display: none;">
                                            <a href="#" class="btn btn-danger" onClick="getPatientMedication()" style="width: 250px;">Get Patient Medication</a>
                                            </span>                                            </td>
                                        </tr>
                                        </tbody>
                                        </table>
                                        -->

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onClick="return addMedItem()">Add</button>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            <script type="text/javascript">
                                function addMedItem(){
                                    if(document.getElementById("tboxitemcode").value == ""){
                                        alert("Please enter valid item");
                                        return false;
                                    }else if(document.getElementById("tboxitemname").value == ""){
                                        alert("Please enter Drug Name");
                                        return false;
                                    }else if(document.getElementById("itemqty").value == ""){
                                        alert("Please enter a valid Qty");
                                        return false;
                                    }else if(document.getElementById("itemrate").value == ""){
                                        alert("Please enter a valid item rate");
                                        return false;
                                    }
                                    
                                    var tbl = document.getElementById('myTable').getElementsByTagName('tr');
                                    var lastRow = tbl.length;	
                                    
                                    var category,particular,qty,rate,discount,note,amount;
                                    
                                    qty = document.getElementById("itemqty").value;
                                    note = document.getElementById("note").value;
                                    discount = document.getElementById("itemdiscount").value;
                                    
                                    itemcode = document.getElementById("tboxitemcode").value;
                                    particular = document.getElementById("tboxitemname").value;
                                    rate = document.getElementById("itemrate").value;
                                    
                                    amount = (eval(qty) * eval(rate)) - eval(discount);
                                    amount = amount.toFixed(2); 
                                    
                                    
                                    var a=document.getElementById('myTable').insertRow(-1);
                                    var b=a.insertCell(0);
                                    var c=a.insertCell(1);
                                    var d=a.insertCell(2);
                                    var e=a.insertCell(3);
                                    var f=a.insertCell(4);
                                    var g=a.insertCell(5);
                                    var h=a.insertCell(6);
                                    var i=a.insertCell(7);

                                    
                                    b.innerHTML = "<input type=\"hidden\" name=\"isPackage" + lastRow + "\" id=\"isPackage" + lastRow + "\" value=\"0\"><input type=\"text\" size = \"7\" style=\"width:98%; background-color:#F9F9f9; border:1px solid #ccc; text-align:right\" name=\"id" + lastRow + "\" id=\"id" + lastRow + "\" value=\""+ lastRow + ". \" readonly=\"true\">";
                                    c.innerHTML = "<input type=\"text\" size = \"7\" style=\"width:98%; background-color:#F9F9f9; border:1px solid #ccc;\" name=\"bill_name" + lastRow + "\" id=\"bill_name" + lastRow + "\" value=\""+ particular + "\" readonly=\"true\">";
                                    d.innerHTML = "<input type=\"text\" size = \"7\" style=\"width:98%; text-align:right\" name=\"qty" + lastRow + "\" id=\"qty" + lastRow + "\" class=\"" + lastRow + "\" value=\""+ qty + "\" onBlur=\"return validate_input(this.className,'qty')\" onkeyup=\"validate_gross(this.className,'qty')\" onkeypress=\"return isNumberKey(event)\" >";
                                    e.innerHTML = "<input type=\"text\" size = \"7\" style=\"width:98%; text-align:right\" name=\"rate" + lastRow + "\" id=\"rate" + lastRow + "\" class=\"" + lastRow + "\" value=\""+ rate + "\" onBlur=\"return validate_input(this.className,'rate')\" onkeyup=\"validate_gross(this.className,'rate')\" onkeypress=\"return isNumberKey(event)\">";
                                    //discount
                                    f.innerHTML = "<input type=\"text\" size = \"7\" style=\"width:98%; text-align:right\" name=\"discount" + lastRow + "\" id=\"discount" + lastRow + "\" class=\"" + lastRow + "\" value=\""+ discount + "\" onBlur=\"return validate_input(this.className,'discount')\" onkeyup=\"validate_gross(this.className,'discount')\" onkeypress=\"return isNumberKey(event)\">";
                                    g.innerHTML = "<input type=\"text\" size = \"7\" style=\"width:98%; background-color:#F9F9f9; border:1px solid #ccc; text-align:right\" name=\"amount" + lastRow + "\" id=\"amount" + lastRow + "\" value=\""+ amount + "\" readonly=\"true\">";
                                    h.innerHTML = "<input type=\"text\" size = \"7\" style=\"width:98%;\" name=\"note" + lastRow + "\" id=\"note" + lastRow + "\" value=\""+ note + "\">";
                                    i.innerHTML = "<img src=\"<?php echo base_url()?>public/img/b_drop.png\" onclick=\"deleteRow(this)\" style=\"cursor:pointer;\">";
                                    
                                    document.getElementById("hdnrowcnt").value = lastRow;
                                    
                                    getGross();
                                    
                                    $('#myModal').modal('hide');
                                    return true;	
                                
                                }
                            </script>
