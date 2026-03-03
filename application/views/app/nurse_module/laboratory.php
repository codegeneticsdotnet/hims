<?php require_once(APPPATH.'views/include/head.php');?>                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laboratory Requests</h1>
    </section>
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Nurse Module</a></li>
            <li><a href="#">In-Patient Information</a></li>
            <li class="active">Laboratory</li>
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
                                        <tr><td><u>Patient No.</u></td></tr>
                                        <tr><td><?php echo $patientInfo->patient_no?></td></tr>
                                        <tr><td><u>Patient Name</u></td></tr>
                                        <tr><td><?php echo $patientInfo->name?></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <table class="table">
                            <tr><td><u>IOP No.</u></td></tr>
                            <tr><td><?php echo $getOPDPatient->IO_ID;?></td></tr>
                            <tr><td><u>Date Time Admit</u></td></tr>
                            <tr><td><?php echo date("M d, Y", strtotime($getOPDPatient->date_visit));?>&nbsp;<?php echo date("H:i:s A", strtotime($getOPDPatient->time_visit));?></td></tr>
                            <tr><td><u>In-Charge Doctor</u></td></tr>
                            <tr><td><?php echo $getOPDPatient->con_doctor;?></td></tr>
                            <tr><td><u>Department</u></td></tr>
                            <tr><td><?php echo $getOPDPatient->dept_name;?></td></tr>
                            <tr><td><u>Room</u></td></tr>
                            <tr><td><?php echo $getOPDPatient->room_name;?></td></tr>
                            <tr><td><u>Bed No.</u></td></tr>
                            <tr><td><?php echo $getOPDPatient->bed_name;?></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9"> 
                <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Laboratory Results</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Lab Requests</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <?php echo $message;?>
                                <?php if($getOPDPatient->nStatus == "Pending"){?>
                                <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Laboratory</a> -->
                                <?php }?>
                                <a href="<?php echo base_url()?>app/ipd_print/print_laboratory/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Print</a>
                                
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Laboratory</th>
                                            <th>Doctor In-Charge</th>
                                            <th>Findings</th>
                                            <th>Results</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($patient_lab as $patient_lab){?>
                                        <tr>
                                            <td><?php echo date("M d, Y h:i:s A",strtotime($patient_lab->dDateTime));?></td>
                                            <td><?php echo $patient_lab->particular_name?></td>
                                            <td><?php echo $patient_lab->doctor?></td>
                                            <td><?php echo $patient_lab->findings?></td>
                                            <td><?php echo $patient_lab->result?></td>
                                            <td>
                                                <?php if($getOPDPatient->nStatus == "Pending"){?>
                                                <a href="<?php echo base_url()?>app/nurse_module/delete_lab/<?php echo $patient_lab->io_lab_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $getOPDPatient->patient_no?>" onClick="return confirm('Are you sure you want to remove?');">Remove</a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Create Request</a>
                                <br><br>
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Request No</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($lab_requests)){ foreach($lab_requests as $req){?>
                                        <tr>
                                            <td><?php echo date("M d, Y h:i:s A",strtotime($req->request_date));?></td>
                                            <td><?php echo $req->request_no?></td>
                                            <td><?php echo $req->particular_name?></td>
                                            <td><?php if($req->status == "Pending"){ echo "<label class='label label-danger'>Pending</label>"; }else{ echo "<label class='label label-success'>".$req->status."</label>"; }?></td>
                                            <td><?php echo $req->result_remarks?></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<form method="post" action="<?php echo base_url()?>app/nurse_module/save_lab_request" onSubmit="if(confirm('Are you sure you want to save?')){ document.getElementById('btnSubmit').disabled=true; return true; } else { return false; }">
    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
    <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Create Laboratory Request</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Service Category</label>
                            <select name="service_category" id="service_category" class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="X-ray">X-ray</option>
                                <option value="Ultrasound">Ultrasound</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered" id="details_table">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Service Description</th>
                                <th>Qty</th>
                                <th>Unit Cost</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addRow()"><i class="fa fa-plus"></i> Add Service</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button name="btnSubmit" class="btn btn-primary" id="btnSubmit" type="submit">Save Request</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<script>
var rowCounter = 0;

$(document).ready(function(){
    addRow(); // Add one row by default
});

function addRow(){
    var rowId = rowCounter++;
    var row = `
        <tr id="row_${rowId}">
            <td>
                <input type="text" class="form-control service-search" placeholder="Search Service..." onkeyup="searchService(this, ${rowId})" onfocus="searchService(this, ${rowId})" autocomplete="off">
                <input type="hidden" name="particular_id[]" id="particular_id_${rowId}" required>
                <div id="service_results_${rowId}" class="list-group" style="position:absolute; z-index:999; display:none; width:300px; max-height: 200px; overflow-y: auto;"></div>
            </td>
            <td><input type="number" name="qty[]" id="qty_${rowId}" class="form-control" value="1" onchange="calculateRow(${rowId})" min="1"></td>
            <td><input type="number" name="amount[]" id="amount_${rowId}" class="form-control" value="0.00" readonly></td>
            <td><input type="number" name="total_amount[]" id="total_${rowId}" class="form-control" value="0.00" readonly></td>
            <input type="hidden" name="discount[]" value="0">
            <input type="hidden" name="discount_remarks[]" value="">
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(${rowId})"><i class="fa fa-trash"></i></button></td>
        </tr>
    `;
    $('#details_table tbody').append(row);
}

function removeRow(id){
    $('#row_'+id).remove();
}

function searchService(element, rowId){
    var search = $(element).val();
    var category = $('#service_category').val();
    
    if(!category){
        if(search.length > 0) {
            alert('Please select a Service Category first.');
            $(element).val('');
        }
        return;
    }

    $.post('<?php echo base_url()?>app/lab_services/service_autocomplete', {search: search, category: category}, function(data){
        var results = JSON.parse(data);
        var html = '';
        if(results.length > 0){
            $.each(results, function(index, item){
                html += '<a href="#" class="list-group-item" onclick="selectService('+rowId+', \''+item.id+'\', \''+item.value+'\', '+item.price+'); return false;">'+item.label+'</a>';
            });
            $('#service_results_'+rowId).html(html).show();
        } else {
            $('#service_results_'+rowId).hide();
        }
    });
}

// Close results when clicking outside
$(document).click(function(e) {
    if (!$(e.target).hasClass('service-search')) {
        $('.list-group').hide();
    }
});

function selectService(rowId, id, name, price){
    $('#particular_id_'+rowId).val(id);
    $('#row_'+rowId).find('.service-search').val(name);
    $('#amount_'+rowId).val(price);
    $('#service_results_'+rowId).hide();
    calculateRow(rowId);
}

function calculateRow(rowId){
    var qty = parseFloat($('#qty_'+rowId).val()) || 0;
    var price = parseFloat($('#amount_'+rowId).val()) || 0;
    
    var total = qty * price;
    $('#total_'+rowId).val(total.toFixed(2));
}
</script>