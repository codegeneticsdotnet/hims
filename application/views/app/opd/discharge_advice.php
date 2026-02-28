<?php require_once(APPPATH.'views/include/head.php');?>                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            OPD Patient Discharge Advice
        </h1>
    </section>
                <section class="content">
            <?php if($this->session->userdata('emr_viewing') == "opd_emr_viewing"){?>	
           <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">EMR sheet</a></li>
                <li><a href="<?php echo base_url()?>app/emr/opd">Out-Patient Master</a></li>
                <li class="active">Discharge Advice</li>
            </ol>
            <?php }else{?>
           <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Doctor Module</a></li>
                <li><a href="<?php echo base_url()?>app/doctor/opd">Out-Patient Master</a></li>
                <li class="active">Discharge Advice</li>
            </ol>
            <?php }?>
            <br>
         
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
                        <div style="margin-top: 15px;">
                         <ul class="nav nav-pills nav-stacked">
                            <li><a href="<?php echo base_url()?>app/opd/view/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> General Information</a></li>
                            <li><a href="<?php echo base_url()?>app/opd/diagnosis/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Diagnosis</a></li>
                            <li><a href="<?php echo base_url()?>app/opd/medication/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Medication</a></li>
                            <li><a href="<?php echo base_url()?>app/opd/complain/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Complain</a></li>
                            <li><a href="<?php echo base_url()?>app/opd/vitalSign/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Vital Sign</a></li>
                            <li><a href="<?php echo base_url()?>app/opd/patientHistory/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Patient History</a></li>
                            <li><a href="<?php echo base_url()?>app/opd/laboratory/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Laboratory</a></li>
                            <li class="active"><a href="<?php echo base_url()?>app/opd/discharge_summary/<?php echo $getOPDPatient->IO_ID;?>/<?php echo $getOPDPatient->patient_no;?>"> Discharge Summary</a></li>
                         </ul>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-9"> 
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Discharge Advice & Billing</h3>
                            </div>
                            <div class="box-body">
                                <form action="<?php echo base_url()?>app/opd/save_discharge_advice" method="post">
                                    <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID;?>">
                                    <input type="hidden" name="patient_no" value="<?php echo $patientInfo->patient_no;?>">
                                    
                                    <div class="form-group">
                                        <label>Control No</label>
                                        <input type="text" name="control_no" class="form-control" required value="DA<?php echo date('ymdHis');?>" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Reference Date</label>
                                        <input type="date" name="advice_date" class="form-control" required value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Doctor's Fee Rate</label>
                                        <input type="number" step="0.01" name="doctor_fee" class="form-control" required placeholder="0.00">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Discount Amount</label>
                                        <input type="number" step="0.01" name="discount" class="form-control" placeholder="0.00">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Remarks for Discount</label>
                                        <textarea name="remarks" class="form-control" rows="3" placeholder="Enter reason..."></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Discharge & Send to Billing</button>
                                        <a href="<?php echo base_url()?>app/clinic/dashboard" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
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

</body>
</html>