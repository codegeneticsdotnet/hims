<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <!-- Page Title Goes Here -->
            Control Panel Template
            <small>Start creating your module here</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Template</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <!-- Your Page Content Here -->
        <div class="row">
            <div class="col-md-12">
                <!-- Example Box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Main Content Area</h3>
                        <div class="box-tools">
                            <!-- Optional box tools -->
                        </div>
                    </div>
                    <div class="box-body">
                        <p>Start building your application here.</p>
                    </div>
                    <div class="box-footer clearfix">
                        <!-- Footer content -->
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Core Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

<!-- Optional: Add other scripts here -->
<script type="text/javascript">
    $(document).ready(function(){
        // Custom JS here
    });
</script>

</body>
</html>
