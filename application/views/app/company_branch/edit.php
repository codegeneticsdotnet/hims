<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Branch</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()?>app/company_branch">Company Branch</a></li>
            <li class="active">Edit Branch</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Branch Details</h3>
            </div>
            
            <form action="<?php echo base_url()?>app/company_branch/edit_save" method="post" role="form">
            <input type="hidden" name="id" value="<?php echo $branch->branch_id;?>">
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company_name" value="<?php echo $branch->company_name;?>" class="form-control" placeholder="Company Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch Code</label>
                            <input type="text" name="branch_code" value="<?php echo $branch->branch_code;?>" class="form-control" placeholder="e.g. CBH" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Address"><?php echo $branch->address;?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" name="contact_no" value="<?php echo $branch->contact_no;?>" class="form-control" placeholder="Contact No">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>TIN No</label>
                            <input type="text" name="tin_no" value="<?php echo $branch->tin_no;?>" class="form-control" placeholder="TIN No">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Branch</button>
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
