<?php require_once(APPPATH.'views/include/head.php');?>
<?php require_once(APPPATH.'views/include/header.php');?>
<?php require_once(APPPATH.'views/include/sidebar.php');?>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Clinic Dashboard </h1>
    </section>
                
    <section class="content">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Clinic Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- Doctor Patients -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo isset($opd_counts['doctor_patients']) ? $opd_counts['doctor_patients'] : 0;?></h3>
                        <p>Doctor's Patients Today</p>
                    </div>
                    <div class="icon"><i class="ion ion-stethoscope"></i></div>
                    <a href="<?php echo base_url()?>app/opd/registration" class="small-box-footer">Add Patient <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Lab -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo isset($opd_counts['lab_requests']) ? $opd_counts['lab_requests'] : 0;?></h3>
                        <p>Laboratory Requests</p>
                    </div>
                    <div class="icon"><i class="ion ion-flask"></i></div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- X-Ray -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?php echo isset($opd_counts['xray_requests']) ? $opd_counts['xray_requests'] : 0;?></h3>
                        <p>X-Ray Requests</p>
                    </div>
                    <div class="icon"><i class="ion ion-nuclear"></i></div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Ultrasound -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3><?php echo isset($opd_counts['ultrasound_requests']) ? $opd_counts['ultrasound_requests'] : 0;?></h3>
                        <p>Ultrasound Requests</p>
                    </div>
                    <div class="icon"><i class="ion ion-wifi"></i></div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">
                            <form method="post" action="<?php echo base_url()?>app/clinic/set_doctor" class="form-inline" style="display:inline-block;">
                                <select name="doctor_id" class="form-control input-sm" onchange="this.form.submit()">
                                    <option value="">- All Doctors -</option>
                                    <?php foreach($doctorList as $doc): ?>
                                    <option value="<?php echo $doc->user_id;?>" <?php echo ($selected_doctor == $doc->user_id) ? 'selected' : '';?>>
                                        <?php echo $doc->name;?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                            &nbsp;
                            <a href="<?php echo base_url()?>app/opd/registration" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add OPD Patient</a>
                        </h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Case No</th>
                                    <th>Patient No</th>
                                    <th>Patient Name</th>
                                    <th>Age</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($queue)): ?>
                                <?php foreach($queue as $row): ?>
                                <tr>
                                    <td><?php echo $row->IO_ID;?></td>
                                    <td><?php echo $row->patient_no;?></td>
                                    <td><?php echo $row->name;?></td>
                                    <td><?php echo $row->age;?></td>
                                    <td><span class="label label-warning"><?php echo $row->nStatus;?></span></td>
                                    <td>
                                        <a href="<?php echo base_url()?>app/clinic/call_patient/<?php echo $row->IO_ID;?>" class="btn btn-xs btn-default" title="Call Patient"><i class="fa fa-bullhorn"></i> Call</a>
                                        <a href="<?php echo base_url()?>app/opd/vitalSign/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-xs btn-info" title="Vital Signs"><i class="fa fa-heartbeat"></i> Vitals</a>
                                        <a href="<?php echo base_url()?>app/opd/diagnosis/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-xs btn-primary" title="Consultation"><i class="fa fa-stethoscope"></i> Consult</a>
                                        <button onclick="showQR('<?php echo $row->IO_ID;?>', '<?php echo $row->patient_no;?>')" class="btn btn-xs btn-warning" title="Upload Documents"><i class="fa fa-qrcode"></i> Upload</button>
                                        <a href="<?php echo base_url()?>app/opd/discharge_advice/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-xs btn-success" title="Discharge/Bill"><i class="fa fa-money"></i> Bill</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr><td colspan="6" class="text-center">No patients in queue</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- QR Modal -->
<div class="modal fade" id="qrModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mobile Upload</h4>
            </div>
            <div class="modal-body text-center">
                <p>Scan this QR Code to upload documents via smartphone:</p>
                <div id="qrCodeContainer" style="margin: 20px;"></div>
                <p class="text-muted"><small>Link expires in 5 minutes. No login required.</small></p>
                <div id="uploadStatus"></div>
            </div>
        </div>
    </div>
</div>

<script>
function showQR(io_id, patient_no){
    // Generate Token
    var data = {
        case_no: io_id,
        patient_no: patient_no,
        exp: Math.floor(Date.now() / 1000) + 300 // 5 mins from now
    };
    var token = btoa(JSON.stringify(data));
    
    // Construct URL (Replace localhost with IP if needed for phone access)
    // Using current hostname
    var hostname = window.location.hostname;
    var url = "http://" + hostname + "<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/app/upload/mobile/" + token;
    
    // Use Google Chart API for QR Code
    var qrUrl = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=" + encodeURIComponent(url);
    
    $('#qrCodeContainer').html('<img src="' + qrUrl + '" style="border: 1px solid #ccc; padding: 5px;">');
    $('#qrModal').modal('show');
}
</script>

<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->
<script src="<?php echo base_url();?>public/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
    });
</script>

</body>
</html>