				<?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Inventory</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">Inventory Management</a></li>
                        <li class="active">Inventory</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		<form class="form-search" method="post" action="<?php echo base_url();?>app/user">
                         		<div class="box-header">
                                    <h3 class="box-title"><a href="<?php echo base_url();?>app/parameters/add/<?php echo $module;?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a></h3>
                                    
                                  
                                    
                                </div><!-- /.box-header -->
								</form>
                        	<div class="box-body table-responsive">
                            	
								<?php echo $message;?>
                                
                            	<table class="table table-hover table-striped">
                                <thead>
                                	<tr>
                                    	<th>CODE</th>
                                        <th>VALUE</th>
                                        <th>DESCRIPTION</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($lists as $lists){?>
                                	<tr>
                                    	<td><?php echo $lists->cCode?></td>
                                        <td><?php echo $lists->cValue?></td>
                                        <td><?php echo $lists->cDesc?></td>
                                        <td>
                                        <a href="<?php echo base_url()?>app/parameters/edit/<?php echo $lists->param_id?>">Edit</a>&nbsp;|&nbsp;
                                        <a href="<?php echo base_url()?>app/parameters/delete/<?php echo $lists->cCode?>/<?php echo $lists->param_id?>" onClick="return confirm('Are you sure you want to delete?');">Delete</a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                </table>
                            </div>
                            	<div class="box-footer clearfix">
                                	
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