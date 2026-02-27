<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pharmacy
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pharmacy</li>
        </ol>
        

        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Inventory Management</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p><strong>Inventory Operations</strong></p>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/inventory_in">
                            <i class="fa fa-truck"></i> Receiving
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-upload"></i> Issuance
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-exchange"></i> BIN Transfer
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-sign-out"></i> Transfer Out
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-sign-in"></i> Transfer In
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/items">
                            <i class="fa fa-tag"></i> Product List
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/medicine_category">
                            <i class="fa fa-list-alt"></i> Categories
                        </a>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Sales & Reports</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p><strong>Point of Sales</strong></p>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy/pos">
                            <i class="fa fa-desktop"></i> Point Of Sales
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-reply"></i> Return
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-sliders"></i> Adjustments
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-cubes"></i> Stock on hand
                        </a>
                        <a class="btn btn-app" href="#">
                            <i class="fa fa-book"></i> Ledger
                        </a>
                        
                        <hr>
                        <p><strong>Reports</strong></p>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy_reports/daily_sales">
                            <i class="fa fa-bar-chart-o"></i> Daily Sales
                        </a>
                        <a class="btn btn-app" href="<?php echo base_url()?>app/pharmacy_reports/daily_dispense">
                            <i class="fa fa-medkit"></i> Daily Dispense
                        </a>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- Core Scripts -->
<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>