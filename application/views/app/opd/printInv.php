<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SALES INVOICE</title>
    </head>
    <style>
        body{
            font-family:Verdana, Geneva, sans-serif;
            font-size:13px;
        }
    </style>
<body>
<section class="content invoice">
                	<div class="row">
                        <div class="col-xs-12">
                            
                            			<center>
	<font size="+1"><?php echo $companyInfo->company_name;?></font></b><br>                   
    <?php echo $companyInfo->company_address;?><br>     
    <?php echo $companyInfo->company_contactNo;?><br><br>
    SALES INVOICE
</center>  
                                                       
                        </div><!-- /.col -->
                    </div>
                    
                    <br><br>
                    
                     <!-- info row -->
                    <div class="row invoice-info">
                    	
                        <table width="100%">
                        <tr>
                        	<td>
                            	<strong><?php echo $patientInfo->name?></strong> <strong><br><i>DOB</i> </strong><?php echo date("M d, Y", strtotime($patientInfo->birthday));?><Br>
                                <?php echo $patientInfo->street?><br>
                                <?php echo $patientInfo->subd_brgy?><br>
                                <?php echo $patientInfo->province?><br>
                                <?php echo $patientInfo->phone_no?><br>
                            </td>
                            <td valign="top">
                            	 Remit Payment To<br>
                               <address>
                                <strong> <?php echo $companyInfo->company_name;?></strong><br>
                                 <?php echo $companyInfo->company_address;?><br>
                                  <?php echo $companyInfo->company_contactNo;?>
                            </address>
                            </td>
                            <td valign="top">
                            	<b>Invoice:</b> <?php echo $headerInv->invoice_no?><br/>
                                <b>Date:</b> <?php echo date("M d, Y", strtotime($headerInv->dDate));?>
                                </td>
                        </tr>
                        </table>
                      
                            
                        </div><!-- /.col -->
                        
                    </div><!-- /.row -->
                    
                    <br>
                    
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table width="100%" cellpadding="2" cellspacing="2" border="1" style="border:1px; border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th width="34%">Particular Name</th>
                                        <th width="8%">Qty</th>
                                        <th width="8%">Rate</th>
                                        <th width="16%">Amount</th>
                                        <th width="34%">Note</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                <?php 
								foreach($detailsInv as $detailsInv){
								if($detailsInv->isPackage == "1"){ 
									
									//get surgical package item list
									$ci_obj = & get_instance();
									$ci_obj->load->model('app/general_model');
									$surgical_items = $ci_obj->general_model->getSurgeryItems2($detailsInv->iop_id);
								?>
								<tr>
                                	<td colspan="5">
                                    	<table cellpadding="3" cellspacing="3" width="100%">
                                        <tr>
                                        	<td>&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $detailsInv->bill_name?></b></td>
                                        </tr>
                                        <tr>
                                        	<td>
                                            	<table cellpadding="2" cellspacing="2" width="100%">
                                                <?php foreach($surgical_items as $surgical_items){?>
                                                <Tr>
                                                	<td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $surgical_items->particular_name?></td>
                                                    <td width="19%" align="right"><?php echo number_format($surgical_items->costs,2)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    <td width="31%"><?php echo $surgical_items->cDesc?></td>
                                                </Tr>
                                                <?php }?>
                                                </table>
                                            </td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>	
								<?php }else{?>
                                <tr>
                                	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $detailsInv->bill_name?></td>
                                	<td align="right"><?php echo number_format($detailsInv->qty,2);?>&nbsp;</td>
                                	<td align="right"><?php echo $detailsInv->rate?>&nbsp;</td>
                                	<td align="right"><?php echo $detailsInv->amount?>&nbsp;</td>
                                	<td><?php echo $detailsInv->note?></td>
                                </tr>
                                <?php }}?>
                                </tbody>
                            </table>                            
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                            <p class="lead">&nbsp;</p>
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <i>&nbsp;</i>
                            </p>
                        </div><!-- /.col -->
                        <div class="col-xs-6">
                            <p class="lead">Amount Details</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td><?php echo number_format($headerInv->sub_total,2)?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">Discount:</th>
                                        <td><?php echo number_format($headerInv->discount,2)?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount:</th>
                                        <td><?php echo number_format($headerInv->total_amount,2)?></td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                    
                    
                </section>
</body>
</html>