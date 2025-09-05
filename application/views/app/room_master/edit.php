                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Edit Room Master</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                       
                        <li><a href="#">Room Management</a></li>
                        <li><a href="<?php echo base_url()?>app/room_master">Room Master</a></li>
                        <li class="active">Edit Room Master</li>
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
                            	<form role="form" method="post" action="<?php echo base_url()?>app/room_master/edit" onSubmit="return confirm('Are you sure you want to save?');">
                                <input type="hidden" name="id" value="<?php echo $room_category->room_master_id?>">
                                <input type="hidden" name="old_room_rates" value="<?php echo $room_category->room_rates?>">
                                		<?php echo validation_errors(); ?>   
                                
                                		<div class="form-group">
                                            <label for="exampleInputEmail1">Room No/Name</label>
                                            <input class="form-control input-sm" value="<?php echo $room_category->room_name;?>" name="room_name" id="room_name" type="text" placeholder="Room No/Name" style="width: 250px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Room Type</label>
                                            				<select name="roomType" id="roomType" class="form-control input-sm" style="width: 250px;" required>
                                                            	<option value="">- Room Type -</option>
																<?php 
																foreach($roomTypeList as $roomTypeList){
																if($_POST['room_type'] == $roomTypeList->category_id || $room_category->category_id == $roomTypeList->category_id){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $roomTypeList->category_id;?>" <?php echo $selected;?>><?php echo $roomTypeList->category_name;?></option>
                                                                <?php }?>
                                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Floor</label>
                                            				<select name="floor" id="floor" class="form-control input-sm" style="width: 250px;" required>
                                                            	<option value="">- Floor -</option>
																<?php 
																foreach($floorList as $floorList){
																if($_POST['floor'] == $floorList->floor_id || $room_category->floor == $floorList->floor_id ){
																	$selected = "selected='selected'";
																}else{
																	$selected = "";
																}
																?>
                                                            	<option value="<?php echo $floorList->floor_id;?>" <?php echo $selected;?>><?php echo $floorList->floor_name;?></option>
                                                                <?php }?>
                                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Room Rate</label>
                                            <input class="form-control input-sm" value="<?php echo $room_category->room_rates;?>" name="room_rates" id="room_rates" type="text" placeholder="Room Rate" style="width: 250px;" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <a href="<?php echo base_url();?>app/room_master" class="btn btn-default">Cancel</a>
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
        
    </body>
</html>