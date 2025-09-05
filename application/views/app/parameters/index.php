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
                                    <h3 class="box-title"></h3>
                                    
                                  
                                    
                                </div><!-- /.box-header -->
								</form>
                        	<div class="box-body table-responsive">
                            	<table width="100%" align="center" cellpadding="4" cellspacing="4">
                                <?php foreach($param_list as $param_list){?>
                                <tr align="left">
                                    <td>
									<a href="<?php echo base_url()?>app/parameters/lists/<?php echo $param_list->cCode?>" style="width:150px; text-align:left"><i class="fa fa-hand-o-right"></i> <?php echo strtoupper($param_list->cCode)?></a>
									</td>
                                </tr>
                                <?php }?>
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