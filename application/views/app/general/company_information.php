                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Company Information</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Administrator</li>
                        <li class="active">Company Information</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                       
                    	 <div class="box">
                         		
                         		 <div class="box-footer clearfix">
                            	
                                          
                                 
                            	</div>
                            
                        	<div class="box-body table-responsive">
                            	
                              <?php 
							  echo $message;
							  echo validation_errors(); 
							  ?>    
                             
                             <form method="post" action="<?php echo base_url()?>app/company_information/save" onSubmit="return confirm('Are you sure you want to save?');" enctype="multipart/form-data">
                             <input type="hidden" name="old_logo" value="<?php echo $companyInfo->logo;?>">
                             <div class="form-group">
                             	<label for="exampleInputEmail1">Company Name</label>
                             	<input class="form-control input-sm" name="company_name" id="company_name" value="<?php echo $companyInfo->company_name?>" type="text" placeholder="Company Name" style="width: 350px;" required>
                             </div>
                             <div class="form-group">
                             	<label for="exampleInputEmail1">Company Address</label>
                             	<input class="form-control input-sm" name="company_address" id="company_address" value="<?php echo $companyInfo->company_address?>" type="text" placeholder="Company Address" style="width: 350px;" required>
                             </div>
                             <div class="form-group">
                             	<label for="exampleInputEmail1">Contact No.</label>
                             	<input class="form-control input-sm" name="contact" id="contact" value="<?php echo $companyInfo->company_contactNo?>" type="text" placeholder="Contact No." style="width: 350px;" required>
                             </div>
                             <div class="form-group">
                             	<label for="exampleInputEmail1">TIN No.</label>
                             	<input class="form-control input-sm" name="tin" id="tin" value="<?php echo $companyInfo->TIN?>" type="text" placeholder="TIN No." style="width: 350px;" required>
                             </div>
                             <div class="form-group">
                                <label for="exampleInputEmail1">Company Logo</label>
                                <input type="file" name="logo" value="<?php echo $companyInfo->logo;?>">
                                <span class="help-block">Allow file type: gif,png,jpg.<br>Maximum of 2MB.</span>
                             </div>
                             
                             <div class="form-group">
                                            <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
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
        
        <!-- BDAY -->
         <script src="<?php echo base_url();?>public/datepicker/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#birthday').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
            
            });
        </script>
        <!-- END BDAY -->
        
    </body>
</html>