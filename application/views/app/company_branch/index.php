<?php require_once(APPPATH.'views/include/head.php');?>

    <!-- Right side column. Contains the navbar and content of the page -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Company Branch Maintenance</h1>
        <a href="<?php echo base_url()?>app/company_branch/add" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Branch</a>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?php echo $this->session->flashdata('message');?>
        
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Branch Code</th>
                            <th>Address</th>
                            <th>Contact No</th>
                            <th>TIN No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($branches)): ?>
                            <?php foreach($branches as $branch): ?>
                            <tr>
                                <td><?php echo $branch->company_name;?></td>
                                <td><?php echo $branch->branch_code;?></td>
                                <td><?php echo $branch->address;?></td>
                                <td><?php echo $branch->contact_no;?></td>
                                <td><?php echo $branch->tin_no;?></td>
                                <td>
                                    <a href="<?php echo base_url()?>app/company_branch/edit/<?php echo $branch->branch_id;?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="<?php echo base_url()?>app/company_branch/delete/<?php echo $branch->branch_id;?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this branch?')"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No branches found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
