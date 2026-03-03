<?php require_once(APPPATH.'views/include/head.php');?>                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Nurse Station Dashboard</h1>
    </section>
                <section class="content">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Nurse Dashboard</li>
        </ol>






                <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Current In-Patients (Sorted by Room/Bed)</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Room/Bed</th>
                                    <th>IPD No</th>
                                    <th>Patient Name</th>
                                    <th>Doctor</th>
                                    <th>Date Admitted</th>
                                    <th>Doctor's Orders</th>
                                    <th>Nurse Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($patients as $row): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $row->room_name;?></strong><br>
                                        Bed: <?php echo $row->bed_name;?>
                                    </td>
                                    <td>
                                        <?php echo $row->IO_ID;?><br>
                                        <small><?php echo $row->patient_no;?></small>
                                    </td>
                                    <td><?php echo $row->patient_name;?></td>
                                    <td><?php echo $row->doctor;?></td>
                                    <td><?php echo date('M d, Y', strtotime($row->date_visit));?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                                                Orders <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?php echo base_url()?>app/nurse_module/medication/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" target="_blank">Medication Orders</a></li>
                                                <li><a href="<?php echo base_url()?>app/nurse_module/laboratory/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" target="_blank">Lab Orders</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="<?php echo base_url()?>app/nurse_module/medication/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-default btn-xs">Medication</a>
                                            <a href="<?php echo base_url()?>app/nurse_module/intake_output/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-default btn-xs">Intake/Output</a>
                                            <a href="<?php echo base_url()?>app/nurse_module/vitalSign/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-default btn-xs">Vital Signs</a>
                                            <a href="<?php echo base_url()?>app/nurse_module/nurse_progress_note/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-default btn-xs">Progress Note</a>
                                            <a href="<?php echo base_url()?>app/nurse_module/room_transfer/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-default btn-xs">Room Transfer</a>
                                            <a href="<?php echo base_url()?>app/nurse_module/bed_side_procedure/<?php echo $row->IO_ID;?>/<?php echo $row->patient_no;?>" class="btn btn-default btn-xs">Bed Side Proc</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $("#example1").dataTable({
            "aaSorting": [] 
        });
    });
</script>