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
                        <li class="active"><a href="#tab_1" data-toggle="tab">Laboratory</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <?php echo $message;?>
                            <?php if($getOPDPatient->nStatus == "Pending"){?>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Laboratory</a>
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
                    </div>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<form method="post" action="<?php echo base_url()?>app/nurse_module/save_laboratory" onSubmit="return confirm('Are you sure you want to save?');">
    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID?>">
    <input type="hidden" name="patient_no" value="<?php echo $getOPDPatient->patient_no?>">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Laboratory</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Category</td>
                                <td>
                                    <select name="category" onChange="showDrugName(this.value);" id="category" class="form-control input-sm" style="width: 100%;" required>
                                        <option value="">- Particular Category -</option>
                                        <?php foreach($particular_cat as $particular_cat){?>
                                        <option value="<?php echo $particular_cat->group_id;?>"><?php echo $particular_cat->group_name;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Laboratory</td>
                                <td>
                                    <span id="showCategories">
                                        <select name="item" id="item" class="form-control input-sm" style="width: 100%;" required>
                                            <option value="">- Particular Item -</option>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td><input type="text" name="dDate" id="dDate" value="<?php echo date("Y-m-d");?>" placeholder="Date" class="form-control input-sm" style="width: 100%;" required></td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">                                            
                                                <input type="text" class="form-control timepicker" name="cTime" id="cTime" value="<?php echo date('h:i A');?>"/>
                                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Doctor</td>
                                <td>
                                    <select name="doctor" id="doctor" class="form-control input-sm" style="width: 100%;" required>
                                        <option value="">- Consultant Doctor -</option>
                                        <?php foreach($doctorList2 as $doctorList2){ ?>
                                        <option value="<?php echo $doctorList2->user_id;?>"><?php echo $doctorList2->name;?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Findings</td>
                                <td><textarea name="findings" placeholder="Findings" class="form-control input-sm" style="width: 100%;" rows="3"></textarea></td>
                            </tr>
                            <tr>
                                <td>Results</td>
                                <td><textarea name="results" placeholder="Results" class="form-control input-sm" style="width: 100%;" rows="3"></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button name="btnSubmit" class="btn btn-primary" id="btnSubmit" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/timepicker/js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    $(function() {
        $(".timepicker").timepicker({ showInputs: false });
        $('#dDate').datepicker({ format: "yyyy-mm-dd" });  
    });
</script>

<script language="javascript">
function showDrugName(category_id){
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); }
    else{ xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("showCategories").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","<?php echo base_url();?>app/billing/getItem/"+category_id,true);
    xmlhttp.send();
}
</script>