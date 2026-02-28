<?php require_once(APPPATH.'views/include/header.php');?>
<?php require_once(APPPATH.'views/include/sidebar.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>OPD Discharge Advice</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/opd">OPD</a></li>
            <li class="active">Discharge Advice</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Patient Information</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3"><strong>OPD No:</strong> <?php echo $getOPDPatient->IO_ID;?></div>
                            <div class="col-md-3"><strong>Patient No:</strong> <?php echo $patientInfo->patient_no;?></div>
                            <div class="col-md-3"><strong>Name:</strong> <?php echo $patientInfo->name;?></div>
                            <div class="col-md-3"><strong>Age:</strong> <?php echo $patientInfo->age;?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Discharge Advice & Billing</h3>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo base_url()?>app/opd/save_discharge_advice" method="post">
                            <input type="hidden" name="opd_no" value="<?php echo $getOPDPatient->IO_ID;?>">
                            <input type="hidden" name="patient_no" value="<?php echo $patientInfo->patient_no;?>">
                            
                            <div class="form-group">
                                <label>Control No</label>
                                <input type="text" name="control_no" class="form-control" required value="DA<?php echo date('ymdHis');?>">
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
                                <a href="<?php echo base_url()?>app/opd/index" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once(APPPATH.'views/include/footer.php');?>