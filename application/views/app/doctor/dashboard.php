<?php require_once(APPPATH.'views/include/head.php');?>                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Doctor Dashboard
        </h1>
    </section>
        <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 10px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Doctor Dashboard</li>
        </ol>
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
                            <form method="post" action="<?php echo base_url()?>app/doctor/opd" class="form-inline" style="display:inline-block;">
                                <div class="input-group input-group-sm" style="width: 300px; position:relative;">
                                    <input type="text" id="patient_search" name="search" class="form-control pull-right" placeholder="Search Patient (Name, ID, etc.)" autocomplete="off">
                                    <div id="search_results" style="position:absolute; top:30px; left:0; z-index:999; width:100%;"></div>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </h3>
                        <div class="box-tools pull-right">
                             <a href="<?php echo base_url()?>app/opd/registration" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add OPD Patient</a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        
                        <form method="post" action="" class="form-inline" style="margin-bottom:10px;">
                            <div class="form-group">
                                <label>From:</label>
                                <input type="date" name="cFrom" class="form-control input-sm" value="<?php echo $this->input->post('cFrom') ? $this->input->post('cFrom') : date('Y-m-d');?>">
                            </div>
                            <div class="form-group">
                                <label>To:</label>
                                <input type="date" name="cTo" class="form-control input-sm" value="<?php echo $this->input->post('cTo') ? $this->input->post('cTo') : date('Y-m-d');?>">
                            </div>
                            <button type="submit" class="btn btn-default btn-sm">Filter</button>
                        </form>
                        
                        <h4>Today's Patients</h4>
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
                                        <a href="<?php echo base_url()?>app/opd/view/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-xs btn-primary" title="View/Edit"><i class="fa fa-eye"></i> View</a>
                                        <a href="<?php echo base_url()?>app/opd/diagnosis/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-xs btn-info" title="Diagnosis"><i class="fa fa-stethoscope"></i> Diagnosis</a>
                                        <a href="<?php echo base_url()?>app/opd/patientHistory/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-xs btn-warning" title="History"><i class="fa fa-history"></i> History</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        
        // Autocomplete
        $('#patient_search').on('keyup', function(){
            var term = $(this).val();
            if(term.length >= 2){
                $.getJSON('<?php echo base_url()?>app/doctor/search_patient_json', {term: term}, function(data){
                    var html = '<ul class="dropdown-menu" style="display:block; position:relative; width:100%;">';
                    if(data.length > 0){
                        $.each(data, function(index, item){
                            html += '<li><a href="<?php echo base_url()?>app/opd/patient_history_print/' + item.value + '">' + item.label + '</a></li>';
                        });
                    } else {
                        html += '<li><a href="#">No results found</a></li>';
                    }
                    html += '</ul>';
                    $('#search_results').html(html);
                });
            } else {
                $('#search_results').html('');
            }
        });
        
        $(document).click(function(e) {
            if (!$(e.target).closest('#patient_search').length) {
                $('#search_results').html('');
            }
        });
    });
</script>
</body>
</html>