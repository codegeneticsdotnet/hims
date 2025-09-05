                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>In-Patient Master</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li><a href="#">IPD</a></li>
                        <li class="active">In-Patient Master</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <div class="box">
                         		
                         		<div class="box-body table-responsive no-padding">
                                    <h4 class="box-title">Search IPD Patient</h4>
                                    
                                    <div class="box-tools">
                                        <div class="input-group">
                                            <form method="post" action="">
                                            <table cellpadding="3" cellspacing="3" width="100%">
                                            <tr>
                                            	<td>From Date</td>
                                                <td>To Date</td>
                                                <td>Department</td>
                                                <td>Incharge Doctor</td>
                                                <td>IPD/LastName/FirstName</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                            	<td><input class="form-control input-sm" name="cFrom" id="cFrom" type="text" value="<?php echo date("Y-m-d");?>" placeholder="From Date Registration" style="width: 130px;" required></td>
                                                <td><input class="form-control input-sm" name="cTo" id="cTo" type="text" value="<?php echo date("Y-m-d");?>" placeholder="to Date Registration" style="width: 130px;" required></td>
                                            	<td>
                                                <select name="department" id="department" class="form-control input-sm" style="width: 200px;">
                                                            	<option value="">All Department</option>
                                                            	<?php 
																foreach($departmentList as $departmentList){
																if($_POST['department'] == $departmentList->department_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $departmentList->department_id;?>" <?php echo $selected;?>><?php echo $departmentList->dept_name;?></option>
                                                                <?php }?>
                                                            </select>
                                                </td>
                                                <td>
                                                <select name="doctor" id="doctor" class="form-control input-sm" style="width: 200px;">
                                                            	<option value="">All Doctors</option>
                                                            	<?php 
																foreach($doctorList as $doctorList){
																if($_POST['doctor'] == $doctorList->user_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $doctorList->user_id;?>" <?php echo $selected;?>><?php echo $doctorList->name;?></option>
                                                                <?php }?>
                                                            </select>
                                                </td>
                                                <td>
                                                <input type="text" class="form-control input-sm" name="search" id="search" placeholder="IPD/LastName/FirstName" style="width: 180px;">
                                                </td>
                                                <td>
                                                <button class="btn btn-sm btn-primary" name="btnSearch" id="btnSearch" type="submit"><i class="fa fa-search"></i> Search </button>
                                                </td>
                                            </tr>
                                            </table>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div><!-- /.box-header -->
                                
								
                            
                            <div class="box-footer clearfix">
                                	
                                </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                    
                    	 <div class="box">
                        	<div class="box-body table-responsive no-padding">
                            	<?php echo $message;?>
                                
                            	<?php echo $table; ?>
                                
                            </div>
                            	<div class="box-footer clearfix">
                                	<?php echo $pagination; ?>
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
        
        <script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#cFrom').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
				
				$('#cTo').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
            
            });
        </script>
        <!-- END BDAY -->
        
        
    </body>
</html>