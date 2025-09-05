<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HIMS :. Healthcare Information Management System</title>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>public/company_logo/favicon.ico">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url();?>public/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        
        
        <!-- scrollbar -->
        <link rel="stylesheet" href="<?php echo base_url()?>public/scrollbar/jquery.mCustomScrollbar.css">
        <!-- Google CDN jQuery with fallback to local -->
		<script src="<?php echo base_url()?>public/scrollbar/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo base_url()?>public/scrollbar/js/minified/jquery-1.11.0.min.js"><\/script>')</script>
	
		<!-- custom scrollbar plugin -->
        <link rel="stylesheet" href="<?php echo base_url()?>public/scrollbar/style.css">
		<script src="<?php echo base_url()?>public/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	
		<script>
		(function($){
			$(window).load(function(){
				
				$("#content-1").mCustomScrollbar({
					autoHideScrollbar:true,
					theme:"rounded"
				});
				
			});
		})(jQuery);
	</script>
        <!-- scrollbar -->
        
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
</div>
    <body class="skin-blue" onLoad="autoload();">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        		<form method="post" action="<?php echo base_url()?>app/billing/save_invoice" onSubmit="return validate_form();">
             	<input type="hidden" name="patient" id="patient" value="<?php echo (isset($direct)) ? $patient_rows->patient_no : "";?>">
        		
                <section class="content">
                 
                 <div class="row">
                 	<div class="col-md-3" style="float:right">
                    	<div class="box box-primary">
                            <div class="box-header">
                            </div>
                            
                            <div class="box-content"> 
                            	<div class="box-body table-responsive no-padding">
                                    <?php 
                                    if( isset($direct) )
                                    {
                                    ?>
                                        <table width="100%" cellpadding="3" cellspacing="3">
                                        <tr>
                                            <td>
                                                <table cellpadding="2" width="100%">
                                                <tr>
                                                    <td><strong>Patient No.</strong></td>
                                                    <td><?php echo $patient_rows->patient_no;?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Patient Name.</strong></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $patient_rows->name;?></td>
                                                </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        </table>
                                        <input type="hidden" name="opd_no" id="opd_no" value="0">
                                        <input type="hiddens" name="patient_no" id="patient_no" value="<?php echo $patient_rows->patient_no?>">
                                    <?php }else {?>
                                	 <span id="patientDetials">
                                     	<table width="100%" cellpadding="3" cellspacing="3">
                                        <tr>
                                        	<td>
                                    			<table cellpadding="2" width="100%">
                                                <tr>
                                                	<td><strong>Patient No.</strong></td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                	<td><strong>IOP No.</strong></td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                	<td><strong>Patient Name.</strong></td>
                                                </tr>
                                                <tr>
                                                	<td>-</td>
                                                </tr>
                                                </table>
                                    		</td>
                                        </tr>
                                        </table>
                                     </span>
                                     <?php }?>
                                </div>	
                            </div>
                            <div class="box-footer">
                            <script>
                                                function setTitle(val){
													if(val == "cash"){
														document.getElementById("credit").style.display = "none";
														document.getElementById("insurance").style.display = "none";
														document.getElementById("totalAmount").style.display = "inline";
														document.getElementById("amountPaid").style.display = "inline";
														document.getElementById("change").style.display = "inline";	
													}else if(val == "credit"){
														document.getElementById("credit").style.display = "inline";
														document.getElementById("insurance").style.display = "none";	
														document.getElementById("totalAmount").style.display = "none";
														document.getElementById("amountPaid").style.display = "none";
														document.getElementById("change").style.display = "none";	
													}else if(val == "insurance"){
														document.getElementById("credit").style.display = "none";
														document.getElementById("insurance").style.display = "inline";	
														document.getElementById("totalAmount").style.display = "none";
														document.getElementById("amountPaid").style.display = "none";
														document.getElementById("change").style.display = "none";	
													}
												}
                                                </script>
                                        
                                        		<?php
													$userID = $invoice_no->invoice_no;
													$userID2 = $invoice_no->invoice_no;
													if(strlen($userID) == 1){
														$userID = "00000".$userID;
													}else if(strlen($userID) == 2){
														$userID = "0000".$userID;
													}else if(strlen($userID) == 3){
														$userID = "000".$userID;
													}else if(strlen($userID) == 4){
														$userID = "00".$userID;
													}else if(strlen($userID) == 5){
														$userID = "0".$userID;
													}else if(strlen($userID) == 6){
														$userID = $userID;
													}
													
													$receipt_no = $receipt_no2->receipt_no;
													$receipt_no2 = $receipt_no2->receipt_no;
													if(strlen($receipt_no) == 1){
														$receipt_no = "00000".$receipt_no;
													}else if(strlen($receipt_no) == 2){
														$receipt_no= "0000".$receipt_no;
													}else if(strlen($receipt_no) == 3){
														$receipt_no = "000".$receipt_no;
													}else if(strlen($receipt_no) == 4){
														$receipt_no = "00".$receipt_no;
													}else if(strlen($receipt_no) == 5){
														$receipt_no = "0".$receipt_no;
													}else if(strlen($receipt_no) == 6){
														$receipt_no = $receipt_no;
													}
												?>
                                    <input type="hidden" name="invoiceno2" value="<?php echo $userID2;?>">
                                   
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="invoiceno">Invoice No.</label>
                                                <input type="text" value="SI-<?php echo $userID;?>" readonly name="invoiceno" id="invoiceno" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dDate22222">Date</label>
                                                <input type="text" value="<?php echo date("m/d/Y");?>" readonly name="dDate22222" id="dDate22222" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="form-group">
                                	<label for="exampleInputEmail1">Total Items</label>
                                     <input type="text" readonly name="hdnrowcnt" id="hdnrowcnt" value="0" class="form-control input-sm">
                                </div>
                                
                                
                                
                                
                                 
                                
                                <script>
                                function validate_discount(val){
									if(val == ""){
										alert('Invalid discount');
										document.getElementById("discount").value = "0";
									}
									getGross();	
								}
                                </script>
                                
                                <div class="form-group">
                                	<label for="exampleInputEmail1">Sub Total</label>
                                     <input type="text" readonly name="nGross" id="nGross" placeholder="0.00" class="form-control input-sm">
                                </div>
                                
                                <div class="form-group">
                                	<label for="exampleInputEmail1">Discount</label>
                                     <input type="text" name="discount" id="discount" value="0" onKeyUp="validate_discount(this.value)" class="form-control input-sm" onkeypress="return isNumberKey(event)" >
                                </div>
                                
                                <div class="form-group">
                                	<label for="exampleInputEmail1">TOTAL AMOUNT</label>
                                     <input type="text" placeholder="0.00" readonly name="total_amount" id="total_amount" class="form-control input-sm">
                                </div>
                                
                                <div class="form-group">
                                	<label for="exampleInputEmail1">Reason for Discount</label>
                                    <select name="reason_dicount" id="reason_dicount" class="form-control input-sm">
                                    	<option value="">- Reason for Discount -</option>
                                        <?php foreach($reason_dicount as $reason_dicount){?>
                                        <option value="<?php echo $reason_dicount->param_id?>"><?php echo $reason_dicount->cValue?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                                
                                <div class="form-group">
                                	<label for="exampleInputEmail1">Remarks</label>
                                	<textarea placeholder="Remarks" class="form-control input-sm" name="remarks" id="remarks" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-md-9">
                    	<div class="nav-tabs-custom">
                        	<ul class="nav nav-tabs">
                               	<li class="active"><a href="#tab_1" data-toggle="tab"><strong>Billing List</strong></a></li>
                            	<!--<li><a href="#tab_2" data-toggle="tab">Header Details</a></li>-->
                            </ul>
                            <div class="tab-content">
                            	<div class="tab-pane active" id="tab_1">
                                
                                 <div class="alt2" dir="ltr" style="
											margin: 0px;
											padding: 0px;
											border: 0px solid #919b9c;
											width: 100%;
											height: 390px;
											text-align: left;
											overflow: auto">
                               <table id="myTable" width="100%" cellpadding="2" cellspacing="2">
                                <thead>
                                	<tr style="border-bottom:1px #999 solid; border-collapse:collapse">
                                    	<th width="3%">No.</th>
                                        <th width="42%">Particular Name</th>
                                        <th width="7%">Qty</th>
                                        <th width="7%">Rate</th>
                                        <th width="10%">Discount</th>
                                        <th width="10%">Total</th>
                                        <th width="25%">Note</th>
                                        <th width="3%"></th>
                                    </tr>
                                </thead>
                                </table>
                                
                               
                                </div>
                                </div>
                               <!-- <div class="tab-pane" id="tab_2">
                                aaa
                                </div>-->
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                    	<div class="box box-primary">
                        	<div class="box-body">
                            	<a class="btn btn-app" href="<?php echo base_url()?>app/pos/"><i class="fa fa-refresh"></i> Refresh</a>

                                <a class="btn btn-app" data-toggle="modal" data-target="#doctorListModal" style="display: <?php echo ( isset($direct) ) ? "none" : "inline-block";?>"><i class="fa fa-user-md"></i> Doctor's Fee</a>
                            	<a class="btn btn-app" data-toggle="modal" data-target="#patientListModal" style="display: <?php echo ( isset($direct) ) ? "none" : "inline-block";?>"><i class="fa fa-user"></i> Patient</a>
                           
                                <a class="btn btn-app" data-toggle="modal" data-target="#myBills"><i class="fa fa-plus"></i> Add Bills</a>
                                <!--
                                <a class="btn btn-app" data-toggle="modal" data-target="#myMedicine"><i class="fa fa-plus"></i> Add Item</a>
                                        -->
                                <a href="#" class="btn btn-app" onClick="return getPatientMedication()" style="display: <?php echo ( isset($direct) ) ? "none" : "inline-block";?>"><i class="fa fa-hand-o-down"></i> 1-Click Billed</a>
                                <button type="submit" class="btn btn-app"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-app" onClick="alert('Please save current transaction to make Payment');"><i class="fa fa-credit-card"></i> Payment</a>
                                <!--<a class="btn btn-app" data-toggle="modal" data-target="#paymentModal"><i class="fa fa-credit-card"></i> Payment</a>-->
                                <a class="btn btn-app" onClick="alert('Please save current transaction to print Invoice');"><i class="fa fa-print"></i> Print Invoice</a>
                                <a class="btn btn-app" onClick="alert('Please save current transaction to print Receipt');"><i class="fa fa-print"></i> Print Receipt</a>
                                
                                
                            </div>
                        </div>
                    </div>
                 </div>
                 
                 
                </section><!-- /.content -->
         		</form>
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
      				<!-- / patientListModal modal -->   
        					<div class="modal fade" id="patientListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Search Patient</h4>
                                        </div>
                                        <div class="modal-body">
                                        			
                                                    
<script language="javascript">
function addPatient(patient,patient_no){
	//var patient;
	//patient = document.getElementById("patient").value;

if (window.XMLHttpRequest)
  {
  xmlhttp2=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp2.onreadystatechange=function()
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
	
    document.getElementById("patientDetials").innerHTML=xmlhttp2.responseText;
    }
  }
	document.getElementById("patient").value = patient_no;

xmlhttp2.open("GET","<?php echo base_url();?>app/pos/patientDetials/"+patient,true);
xmlhttp2.send();

$('#patientListModal').modal('hide');
						return true;	
}

function autoload(){
	getPatientList('');	
}

function getPatientList(val)
{
	
	
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
    document.getElementById("showPatients").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url();?>app/pos/showPatients/"+val,true);
xmlhttp.send();

}
</script>   
                                                    <input onKeyUp="getPatientList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                                        		<span id="showPatients">
                                                
                                                </span>
                                                
                                               
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           <!-- <button type="button" class="btn btn-primary" onClick="return addPatient()">Proceed</button>-->
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>














<!-- / patientListModal modal -->   
    <div class="modal fade" id="doctorListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Doctor's Fee</h4>
                </div>
                <div class="modal-body">

                    <div id="msgNotif"></div>
                            
                    <form name="frmDoctorFee" id="frmDoctorFee" method="post">
                    <table class="table table-striped">
                        <tr>
                            <td>Select Doctor <font color="#FF0000">*</font></td>
                            <td>
                                <select name="doctor" id="doctorC" class="form-control input-sm" style="width: 100%;" required onchange="clearFields()">
                                    <option value="">- Select Doctor -</option>
                                    <?php 
                                    foreach($doctorList as $doctorList){

                                    ?>
                                    <option value="<?php echo trim($doctorList->user_id);?>" ><?php echo $doctorList->name;?></option>
                                    <?php }?>
                                </select>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Fee Type <font color="#FF0000">*</font></td>
                            <td>
                                <select name="cType" id="cType" class="form-control input-sm" style="width: 100%;" required>
                                    <option value="">- Select Fee Type  -</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="actual">Actual Fee</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Value <font color="#FF0000">*</font></td>
                            <td>
                                <input type="text" class="form-control input-sm" style="width: 100%;" required placeholder="Value" onkeyup="compute(this.value)" name="valueFee" id="valueFee">
                            </td>
                        </tr>
                        <tr>
                            <td>Total Fee <font color="#FF0000">*</font></td>
                            <td>
                                <input type="text" style="font-size:26px; width:100%; background-color:rgba(243, 215, 16, 0.27);;" readonly="" name="totalFee" id="totalFee">
                            </td>
                        </tr>
                        <tr>
                            <td>Notes <font color="#FF0000">*</font></td>
                            <td>
                                <textarea style="width:100%;" name="notes" id="notes" rows="4"></textarea>
                            </td>
                        </tr>
                    </table>    
                    </form>
                        
                       
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onClick="saveDoctorFee()" name="btnSaveDoctorFee" id="btnSaveDoctorFee">Save</button>
                </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



<script type="text/javascript">

$(document).ready(function(){
    var invoiceno = $('#invoiceno').val();
    // alert(invoiceno);
    $.ajax({
        url: "<?php echo base_url();?>app/pos/getDoctorFee/" + invoiceno,
        type: "POST",
        dataType: "json",
        success: function(result)
        {
            // alert(result.user_id);
            $('#doctorC').val(result.user_id);
            $('#cType').val(result.feeType);
            $('#valueFee').val(result.value);
            $('#totalFee').val(result.totalFee);
            $('#notes').val(result.notes);
        }
    });
});
    function compute(val)
    {
        var cType           =   $('#cType').val();
        var total_amount    =   $('#total_amount').val();
        
        
        if(cType == "percentage")
        {
            var percentageValue = 0;
            percentageValue = val/100;

            totalFee = total_amount * percentageValue;
        }
        else if(cType == "actual")
        {
            totalFee = val;
        }

        $('#totalFee').val(totalFee);

    }

    function saveDoctorFee()
    {
        var formdata = $('#frmDoctorFee').serialize();
        var invoiceno       =   $('#invoiceno').val();
        
        $.ajax({
            url: "<?php echo base_url();?>app/pos/saveDoctorFee/" + invoiceno,
            type: "POST",
            data: formdata,
            success: function(result)
            {
                // alert(result);
                $('#btnSaveDoctorFee').removeClass("disabled");
                $('#btnSaveDoctorFee').text('Save');

                alert("Doctor's Fee has been saved.");

            }, beforeSend: function()
            {
                $('#btnSaveDoctorFee').addClass("disabled");
                $('#btnSaveDoctorFee').text('Saving...');
            }
        });

        
    }

    function clearFields()
    {
        $('#valueFee').val("");
        $('#totalFee').val("");
    }
</script>
                            <!-- / payment modal -->   
        					<!-- / payment modal -->   
        					<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Payment</h4>
                                        </div>
                                        <div class="modal-body">
                                        
                                        		<div class="form-group">
                                            		<label for="exampleInputEmail1">Receipt No.</label>
                                            		 <input type="text" value="OR-<?php echo $receipt_no;?>" readonly name="receiptno" id="receiptno" class="form-control input-sm">
                                        		</div>
                                        
                                        		<div class="form-group">
                                            		<label for="exampleInputEmail1">Mode of Payment</label>
                                            		<select name="paymentType" id="paymentType" class="form-control input-sm" onChange="setTitle(this.value)" readonly>
                                     					<!--<option value="">- Mode of Payment -</option>-->
                                     					<option value="cash">Cash</option>
                                     					<option value="credit">Credit</option>
                                     					<option value="insurance">Insurance Company</option>
                                     				</select>
                                        		</div>
                                                
                                                <div class="form-group" id="totalAmount">
                                            		<label for="exampleInputEmail1">Total Amount</label>
                                            		 <input type="text" placeholder="Total Amount" readonly name="totalAmount" id="totalAmount" class="form-control input-sm">
                                        		</div>
                                                
                                                <div class="form-group" id="amountPaid">
                                            		<label for="exampleInputEmail1">Amount Paid</label>
                                            		 <input type="text" placeholder="Amount Paid" name="amountPaid" id="amountPaid" class="form-control input-sm">
                                        		</div>
                                                
                                                <div class="form-group" id="change">
                                            		<label for="exampleInputEmail1">Change</label>
                                            		 <input type="text" placeholder="Change" name="change" readonly id="change" class="form-control input-sm">
                                        		</div>
                                                
                               					<div class="form-group" id="credit" style=" display:none;">
                                            		<label for="exampleInputEmail1">Credit Card No.</label>
                                            		 <input type="text" placeholder="Credit Card No." name="creditCardNo" id="creditCardNo" class="form-control input-sm">
                                        		</div>
                                                
                                                <div class="form-group" id="insurance" style=" display:none;">
                                            		<label for="exampleInputEmail1">Insurance Company</label>
                                            		<select name="insurance_company" id="insurance_company" class="form-control input-sm">
                                                    	<option value="">- Insurance Company -</option>
                                                        <?php foreach($insurance_company as $insurance_company){?>
                                                        <option value="<?php echo $insurance_company->in_com_id;?>"><?php echo $insurance_company->company_name;?></option>
                                                        <?php }?>
                                                    </select>
                                        		</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onClick="return addItem('particular')">Save</button>
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                           
                            <!-- / payment modal -->   
         <!-- Modal -->

<!-- for Autocomplete --> 
<script src="<?php echo base_url();?>public/js/bloodhound.min.js"></script>
<script src="<?php echo base_url();?>public/js/typeahead.jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<script language="javascript">
    function showCategory(category_id){
        //change to ajax
        if (window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }else{// code for IE6,
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("showCategories").innerHTML=xmlhttp.responseText;
            }
        }
        var supp;
        xmlhttp.open("GET","<?php echo base_url();?>app/billing/getItem/"+category_id,true);
        xmlhttp.send();
    }

    function getItemRate(category_id){
        /*
        if (window.XMLHttpRequest){
            xmlhttp2=new XMLHttpRequest();
        }else{// code for IE6, IE5
            xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp2.onreadystatechange=function(){
            if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
                alert(xmlhttp2.responseText);
                document.getElementById("showRate").innerHTML=xmlhttp2.responseText;
            }
        }
        xmlhttp2.open("GET","<?php echo base_url();?>app/billing/getRate/"+category_id,true);
        xmlhttp2.send();
        */
        $.ajax({
            url: "<?php echo base_url();?>app/billing/getRate/" + category_id,
            type: "GET",
            success: function(result)
            {
                $("#showRateDetails").html(result);
                computeTotal();
            }
        });
    }

</script>
                    <?php require APPPATH.'views/app/pos/inc_items.php'; ?>   
        			<script language="javascript">
					function isNumberKey(evt)
       				{
          				var charCode = (evt.which) ? evt.which : event.keyCode;
         				 if (charCode != 46 && charCode > 31 
            				&& (charCode < 48 || charCode > 57))
             				return false;

          				return true;
       				}
	   
                    function addItem(s){
						if(s == "particular"){
							if(document.getElementById("particular_name").value == ""){
								alert("Please select Particular Category");
								return false;
							}else if(document.getElementById("bill_name").value == ""){
								alert("Please select Particular Item");
								return false;
							}else if(document.getElementById("qty").value == ""){
								alert("Please enter a valid Qty");
								return false;
							}else if(document.getElementById("discount").value == ""){
								alert("Please enter a valid Discount");
								return false;
							}else if(document.getElementById("rate").value == ""){
								alert("Please enter a valid Rate");
								return false;
							}
						}else{
							if(document.getElementById("medicine_name").value == ""){
								alert("Please select Medicine Category");
								return false;
							}else if(document.getElementById("drug_name_a").value == ""){
								alert("Please select Drug Name");
								return false;
							}else if(document.getElementById("qty").value == ""){
								alert("Please enter a valid Qty");
								return false;
							}else if(document.getElementById("drug_rate").value == ""){
								alert("Please enter a valid Rate");
								return false;
							}
						}

                        var tbl = document.getElementById('myTable').getElementsByTagName('tr');
						var lastRow = tbl.length;	
						
						var category,particular,qty,rate,discount,note,amount;
						
						qty = document.getElementById("qty").value;
						note = document.getElementById("note").value;
                        discount = document.getElementById("discounter").value;
                        
						
						if(s == "particular"){
							category = document.getElementById("particular_name").value;
							particular = document.getElementById("bill_name").value;
							rate = document.getElementById("rate").value;
						}else{
							category = document.getElementById("medicine_name").value;
							particular = document.getElementById("drug_name_a").value;
							rate = document.getElementById("drug_rate").value;
						}
						
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
					
					function closeModal(){
						$('#myModal').modal('hide');	
					}
					
					function deleteRow(r){
						var tbl = document.getElementById('myTable').getElementsByTagName('tr');
						var lastRow = tbl.length;	
						
						var i=r.parentNode.parentNode.rowIndex;
						if (lastRow > 2) {
							document.getElementById('myTable').deleteRow(i);
 							document.getElementById('hdnrowcnt').value = lastRow - 2;
 							var lastRow = tbl.length;
							var z;
							for (z=i+1; z<=lastRow; z++){
								
								var id = document.getElementById('id' + z);
								var isPackage = document.getElementById('isPackage' + z);
								var bill_name = document.getElementById('bill_name' + z);
								var qty = document.getElementById('qty' + z);
								var rate = document.getElementById('rate' + z);
								var amount = document.getElementById('amount' + z);
								var note = document.getElementById('note' + z);
								
								var x = z-1;
								
								id.value = x;
								id.id = "id" + x;
								id.name = "id" + x;	
								
								isPackage.id = "isPackage" + x;
								isPackage.name = "isPackage" + x;	
								
								bill_name.id = "bill_name" + x;
								bill_name.name = "bill_name" + x;	
								
								qty.id = "qty" + x;
								qty.name = "qty" + x;	
								qty.className = x;
								
								rate.id = "rate" + x;
								rate.name = "rate" + x;	
								rate.className = x;
								
								amount.id = "amount" + x;
								amount.name = "amount" + x;	
								
								note.id = "note" + x;
								note.name = "note" + x;	
								
								//alert(bill_name.name + " - " + rate.value);
							}
							getGross();
						}else{
 							alert("Minimum of one row per transaction.");
 						}
					}
					
					function getGross()
					{
						var len;
						var nGross = 0;
						var nTotal = 0;
                        var nDiscount = 0;
						len = document.getElementById("hdnrowcnt").value;
							for (i=1; i<=len; i++) {
								nGross += parseFloat(document.getElementById("amount" + i).value-0);
                                nDiscount += parseFloat(document.getElementById("discount" + i).value-0);
                            }
						nGross = nGross.toFixed(2); 
						document.getElementById("nGross").value = nGross;
                        document.getElementById("discount").value = nDiscount;
						nTotal = eval(nGross) - eval(nDiscount);
						nTotal = nTotal.toFixed(2); 
						document.getElementById("total_amount").value = nTotal;
					}
					
					function validate_gross(id,nName){
						var qty,rate,discount,amount;
						qty = document.getElementById("qty"+id).value;	
						rate = document.getElementById("rate"+id).value;
						discount = document.getElementById("discount"+id).value;
						
						amount = (eval(qty) * eval(rate))-eval(discount);
						amount = amount.toFixed(2); 
						
						document.getElementById("amount"+id).value = amount;
						
						getGross();			
					}
					
					function validate_input(id,name){
						//alert(document.getElementById(name+""+id).value);
						if(document.getElementById(name+""+id).value == "" || eval(document.getElementById(name+""+id).value) <= 0){
							alert("Please enter a valid "+name+".");
							document.getElementById(name+""+id).value = "0";
							validate_gross(id,name)
							getGross();	
							return false;		
						}else{
							validate_gross(id,name)
							getGross();	
						}
					}
					
					function validate_form(){
						
						
						if(document.getElementById("hdnrowcnt").value == "0"){
							alert('Minimum of one row per transaction.');
							return false;
						}else if(document.getElementById("patient").value == ""){
							alert('Please select Patient.');
							return false;
						}else{
							var len;
							len = document.getElementById("hdnrowcnt").value;	
							for (i=1; i<=len; i++) {
							if(eval(document.getElementById("amount"+i).value) <= 0){
								alert("Transaction cannot be saved. There are still some items without amount.");
								return false;
							}else{
								if(confirm('Are you sure you want to save?')){
									return true;
								}else{
									return false;	
								}
							}
						}
						}
						
						
					}
					
					function stopEnterKey(evt) {
        				var evt = (evt) ? evt : ((event) ? event : null);
        				var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        				if ((evt.keyCode == 13) && (node.type == "text")) { return false; }
    				}
    				document.onkeypress = stopEnterKey;
					 </script>
    </body>
</html>