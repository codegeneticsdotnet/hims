				<?php require_once(APPPATH.'views/include/head.php');?>
				<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>OPD Registration</h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li><a href="<?php echo base_url()?>app/opd/index">OPD</a></li>
                        <li class="active">OPD Registration</li>
                    </ol>
                 <div class="row">
                 	<div class="col-md-12">
                    	 <div class="box">
                         		<div class="box-header">
                                    <h3 class="box-title">Search Patient</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPatientModal"><i class="fa fa-plus"></i> New Patient</button>
                                    </div>
                                </div>
                        	<div class="box-body table-responsive">
                            	<form role="form" method="post" action="<?php echo base_url()?>app/opd/search_result">
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Patient Search</label>
                                            <input class="form-control input-sm" name="search" id="search" type="text" placeholder="Search by Patient Name or ID..." style="width: 100%;" autocomplete="off">
                                            <div id="patient-result" style="position: absolute; z-index: 999; width: 350px; background: #fff; border: 1px solid #ccc; display: none;"></div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-search"></i> Search Patient</button>
                                        </div>
                                        <br>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                 </div>
                </section><!-- /.content -->
                
                <!-- Add Patient Modal -->
                <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Add New Patient</h4>
                            </div>
                            <form action="<?php echo base_url()?>app/patient/save_quick" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firstname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="lastname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" name="middlename" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Birthday <span class="text-danger">*</span></label>
                                    <input type="date" name="birthday" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">- Select -</option>
                                        <?php foreach($gender as $g): ?>
                                        <option value="<?php echo $g->param_id; ?>"><?php echo $g->cValue; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Civil Status</label>
                                    <select name="civil_status" class="form-control">
                                        <option value="">- Select -</option>
                                        <?php foreach($civilStatus as $cs): ?>
                                        <option value="<?php echo $cs->param_id; ?>"><?php echo $cs->cValue; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Patient</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#search').keyup(function(){
                    var query = $(this).val();
                    if(query.length > 2){
                        $.ajax({
                            url: "<?php echo base_url();?>app/opd/search_patient_json",
                            method: "POST",
                            data: {query:query},
                            success: function(data){
                                $('#patient-result').fadeIn();
                                $('#patient-result').html(data);
                            }
                        });
                    }else{
                         $('#patient-result').fadeOut();
                    }
                });
                
                $(document).on('click', '.search-item', function(){
                    // When clicking an item, fill input and submit form
                    $('#search').val($(this).text());
                    $('#patient-result').fadeOut();
                    // Optionally submit form automatically
                    // $('form[role="form"]').submit();
                    // Or redirect to OPD registration for this patient
                    var patient_no = $(this).data('id');
                    window.location.href = "<?php echo base_url();?>app/opd/opd_reg/" + patient_no;
                });
            });
        </script>
    </body>
</html>