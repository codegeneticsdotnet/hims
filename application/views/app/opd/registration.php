				<?php require_once(APPPATH.'views/include/head.php');?>
				<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>OPD Registration</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li><a href="<?php echo base_url()?>app/opd/index">OPD</a></li>
                        <li class="active">OPD Registration</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                 <div class="row">
                 	<div class="col-md-12">
                    	 <div class="box">
                         		<div class="box-header">
                                    <h3 class="box-title">Search Patient</h3>
                                </div>
                        	<div class="box-body table-responsive">
                            	<form role="form" method="post" action="<?php echo base_url()?>app/opd/search_result">
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Patient ID/LastName/FirstName</label>
                                            <input class="form-control input-sm" name="search" id="search" type="text" placeholder="Patient ID/LastName/FirstName" style="width: 350px;">
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
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>