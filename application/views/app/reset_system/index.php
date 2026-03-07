<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
            <h1>
                System Reset
            </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Admin</a></li>
                <li class="active">Reset System</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <?php echo $message;?>
                    
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-warning"></i> Danger Zone</h3>
                        </div>
                        <div class="box-body text-center">
                            <p class="text-danger lead">
                                <strong>WARNING: This action is irreversible!</strong>
                            </p>
                            <p>
                                You are about to delete <strong>ALL</strong> patient records, OPD visits, IPD admissions, laboratory requests, pharmacy sales, inventory, and billing records.
                            </p>
                            <p>
                                The system increments (Patient ID, Invoice No, etc.) will also be reset to 0.
                            </p>
                            
                            <hr>
                            
                            <?php echo form_open('app/reset_system/process', array('onsubmit' => "return confirm('Are you absolutely sure you want to reset the system? This cannot be undone.');")); ?>
                                <div class="form-group">
                                    <label>Enter Admin Password to Confirm</label>
                                    <input type="password" name="password" class="form-control input-lg text-center" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-danger btn-lg btn-block"><i class="fa fa-trash-o"></i> RESET SYSTEM NOW</button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </aside>
</div>

<!-- Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>
