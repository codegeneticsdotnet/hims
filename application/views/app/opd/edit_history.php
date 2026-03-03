<?php require_once(APPPATH.'views/include/header.php');?>
<?php require_once(APPPATH.'views/include/sidebar.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Patient Visit History</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">OPD</a></li>
            <li class="active">Edit History</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Patient: <?php echo $patientInfo->name;?> (<?php echo $patientInfo->patient_no;?>) | 
                            Visit: <?php echo $getOPDPatient->IO_ID;?> (<?php echo date('M d, Y', strtotime($getOPDPatient->date_visit));?>)
                        </h3>
                        <div class="box-tools pull-right">
                            <a href="javascript:history.back()" class="btn btn-default btn-sm">Back</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo $message;?>
                        
                        <!-- Complaints -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Medical Concerns / Complaints</h4>
                                <form action="<?php echo base_url()?>app/opd/save_complain" method="post" class="form-inline">
                                    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID;?>">
                                    <input type="hidden" name="patient_no" value="<?php echo $patientInfo->patient_no;?>">
                                    <input type="hidden" name="redirect_to" value="edit_history">
                                    
                                    <div class="form-group">
                                        <select name="complain" class="form-control" required>
                                            <option value="">- Select Complaint -</option>
                                            <?php foreach($ComplainList as $row){?>
                                            <option value="<?php echo $row->complain_id;?>"><?php echo $row->complain_name;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </form>
                                <table class="table table-bordered table-striped" style="margin-top:10px;">
                                    <thead><tr><th>Complaint</th><th>Remarks</th><th>Action</th></tr></thead>
                                    <tbody>
                                        <?php foreach($patientComplain as $row){?>
                                        <tr>
                                            <td><?php echo $row->complain_name;?></td>
                                            <td><?php echo $row->remarks;?></td>
                                            <td><a href="<?php echo base_url()?>app/opd/delete_complain/<?php echo $row->iop_comp_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $patientInfo->patient_no?>/edit_history" onClick="return confirm('Are you sure?');">Delete</a></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        
                        <!-- Diagnosis -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Diagnosis</h4>
                                <form action="<?php echo base_url()?>app/opd/save_diagnosis" method="post" class="form-inline">
                                    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID;?>">
                                    <input type="hidden" name="patient_no" value="<?php echo $patientInfo->patient_no;?>">
                                    <input type="hidden" name="redirect_to" value="edit_history">
                                    
                                    <div class="form-group">
                                        <input type="text" name="diagnosis" list="diagnosis_list" class="form-control" placeholder="Diagnosis" required>
                                        <datalist id="diagnosis_list">
                                            <?php foreach($diagnosisList as $row){?>
                                            <option value="<?php echo $row->diagnosis_name;?>">
                                            <?php }?>
                                        </datalist>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </form>
                                <table class="table table-bordered table-striped" style="margin-top:10px;">
                                    <thead><tr><th>Diagnosis</th><th>Remarks</th><th>Action</th></tr></thead>
                                    <tbody>
                                        <?php foreach($patientDiagnosis as $row){?>
                                        <tr>
                                            <td><?php echo $row->diagnosis_name;?></td>
                                            <td><?php echo $row->remarks;?></td>
                                            <td><a href="<?php echo base_url()?>app/opd/delete_diagnos/<?php echo $row->iop_diag_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $patientInfo->patient_no?>/edit_history" onClick="return confirm('Are you sure?');">Delete</a></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        
                        <!-- Medication -->
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Treatment / Medication</h4>
                                <form action="<?php echo base_url()?>app/opd/save_medication" method="post" class="form-inline">
                                    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID;?>">
                                    <input type="hidden" name="patient_no" value="<?php echo $patientInfo->patient_no;?>">
                                    <input type="hidden" name="redirect_to" value="edit_history">
                                    
                                    <div class="form-group">
                                        <select name="category" onChange="showDrugName(this.value);" id="category" class="form-control" style="width: 200px;" required>
                                            <option value="">- Category -</option>
                                            <?php foreach($medicineCategory as $row){?>
                                            <option value="<?php echo $row->cat_id;?>"><?php echo $row->med_category_name;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="drug_name" id="drug_name" class="form-control" style="width: 200px;" required>
                                            <option value="">- Drug -</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="text" name="instruction" class="form-control" placeholder="Instruction">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="qty" class="form-control" placeholder="Qty" size="5">
                                    </div>
                                    <input type="hidden" name="nDays" value="1">
                                    <input type="hidden" name="advice" value="">
                                    
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </form>
                                <table class="table table-bordered table-striped" style="margin-top:10px;">
                                    <thead><tr><th>Drug Name</th><th>Instruction</th><th>Qty</th><th>Action</th></tr></thead>
                                    <tbody>
                                        <?php foreach($patientMedication as $row){?>
                                        <tr>
                                            <td><?php echo $row->drug_name;?></td>
                                            <td><?php echo $row->instruction;?></td>
                                            <td><?php echo $row->total_qty;?></td>
                                            <td><a href="<?php echo base_url()?>app/opd/delete_medication/<?php echo $row->iop_med_id?>/<?php echo $getOPDPatient->IO_ID?>/<?php echo $patientInfo->patient_no?>/edit_history" onClick="return confirm('Are you sure?');">Delete</a></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script language="javascript">
function showDrugName(category_id) {
    if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }
    else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("drug_name").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/opd/getDrugName/"+category_id,true);
    xmlhttp.send();
}
</script>