<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add New Branch</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/company_branch">Company Branch</a></li>
            <li class="active">Add Branch</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Branch Details</h3>
            </div>
            
            <form action="<?php echo base_url()?>app/company_branch/save" method="post" role="form">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="Company Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch Code</label>
                            <input type="text" name="branch_code" class="form-control" placeholder="e.g. CBH" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch Name</label>
                            <input type="text" name="branch_name" class="form-control" placeholder="Branch Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch Color</label>
                            <select name="branch_color" class="form-control">
                                <option value="skin-blue">Blue (Default)</option>
                                <option value="skin-black">Black</option>
                                <option value="skin-green">Green</option>
                                <option value="skin-purple">Purple</option>
                                <option value="skin-red">Red</option>
                                <option value="skin-yellow">Yellow</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Address"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" name="contact_no" class="form-control" placeholder="Contact No">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>TIN No</label>
                            <input type="text" name="tin_no" class="form-control" placeholder="TIN No">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Branch</button>
                <a href="<?php echo base_url()?>app/company_branch" class="btn btn-default">Cancel</a>
            </div>
            </form>
        </div>

    </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>
