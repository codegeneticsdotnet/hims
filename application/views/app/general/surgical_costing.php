                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Surgical Quotation Costing</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Billing</a></li>
                        <li class="active">Surgical Quotation Costing</li>
                    </ol>
                </section>
				
                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		
                         		<div class="box-header">
                                    <h3 class="box-title"></h3>
                                    
                                </div>
                        	<div class="box-body table-responsive">
                            	<form role="form" method="post" action="<?php echo base_url()?>app/surgical_costing/print_preview" target="_blank">
                                 
                                
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Requested By</label>
                                            <input class="form-control input-sm" name="requestby" id="requestby" type="text" placeholder="Requested By" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Subject</label>
                                            <input class="form-control input-sm" name="subjects" id="subjects" type="text" placeholder="Subject" style="width: 350px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Surgery Name</label>
                                            <select name="surgery_name" id="surgery_name" class="form-control input-sm" style="width: 350px;" required>
                                            	<option value="">- Surgery Name -</option>
                                            	<?php foreach($surgery_list as $surgery_list){?>
                                                <option value="<?php echo $surgery_list->surgery_id?>"><?php echo $surgery_list->surgery_name?></option>
                                                <?php }?>
                                            </select>
                                            
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Proceed</button>
                                        </div>
                                        
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