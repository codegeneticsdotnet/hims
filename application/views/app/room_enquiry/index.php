                <?php require_once(APPPATH.'views/include/head.php');?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Room Inquiry</h1>
                   <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Patient Management</a></li>
                        <li class="active">Room Inquiry</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <?php echo validation_errors();?>
                     <div class="col-md-12"> 
                                <div class="nav-tabs-custom">
                                	<ul class="nav nav-tabs">
                                		<li class="active"><a href="#tab_1" data-toggle="tab">Admission Master</a></li>
                                	</ul>
                                    <div class="tab-content">
                                    	<div class="tab-pane active" id="tab_1">
                                        	<script language="javascript">
                                            function getData(){
                                                var roomType, occupied, maintenance;
                                                roomType = document.getElementById("roomType").value;
                                                occupied = document.getElementById("occupied").value;
                                                
                                                if (window.XMLHttpRequest) {
                                                    xmlhttp3 = new XMLHttpRequest();
                                                } else {
                                                    xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
                                                }
                                                
                                                xmlhttp3.onreadystatechange = function() {
                                                    if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
                                                        document.getElementById("master_room").innerHTML = xmlhttp3.responseText;
                                                    }
                                                }
                                                
                                                xmlhttp3.open("GET", "<?php echo base_url();?>app/ipd/getRoomMaster2/" + roomType + "/" + occupied, true);
                                                xmlhttp3.send();
                                            }
											
											function getBed2(room_id,room_name){
												
												if (window.XMLHttpRequest)
  												{
 						 							xmlhttp4=new XMLHttpRequest();
  												}
												else
  												{// code for IE6, IE5
  													xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
  												}
													xmlhttp4.onreadystatechange=function()
  												{
  												if (xmlhttp4.readyState==4 && xmlhttp4.status==200)
    											{
													document.getElementById("master_bed").innerHTML=xmlhttp4.responseText;
   									 			}
  												}
  													var supp;
													xmlhttp4.open("GET","<?php echo base_url();?>app/ipd/getBeds2/"+room_id,true);
													xmlhttp4.send();
													
													if(document.getElementById("room_name"))
                                                        document.getElementById("room_name").value = room_name;
                                                    if(document.getElementById("room_idfor"))
													    document.getElementById("room_idfor").value = room_id;
											}		
											
											function getBedID(room_bed_id,bed_name){
                                                if(document.getElementById("bed_no"))
												    document.getElementById("bed_no").value = room_bed_id;
                                                if(document.getElementById("bed_name"))
												    document.getElementById("bed_name").value = bed_name;
											}
                                            </script>
                                            <table cellpadding="4" width="100%">
                                            <tr>
                                            	<td>
                                                	<select name="roomType" id="roomType" class="form-control input-sm" onChange="getData()">
                                                    	<option value="">Select Room Type</option>
                                                        <?php foreach($room_category as $room_category){?>
                                                        <option value="<?php echo $room_category->category_id?>"><?php echo $room_category->category_name?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>
                                                <td align="center">
                                                	<select name="occupied" id="occupied" class="form-control input-sm" onChange="getData()">
                                                    	<option value="all">All Status</option>
                                                        <option value="occupied">Occupied Bed</option>
                                                        <option value="unoccupied">Unoccupied Bed</option>
                                                        <option value="maintenance">Under Maintenance</option>
                                                    </select>
                                                </td>	
                                            </tr>
                                            <tr>
                                            	<td colspan="2">
                                                <span id="master_room">
                                                	 <div class="alt2" dir="ltr" style="
														margin: 0px;
														padding: 0px;
														border: 0px solid #919b9c;
														width: 100%;
														height: 550px;
														text-align: left;
														overflow: auto">
                                                      <table class="table" id="myTable" width="100%" cellpadding="2" cellspacing="2">
                                                      <thead>
                                                      	<tr style="border-bottom:1px #999 solid; border-collapse:collapse">
                                                        	<th>Status</th>
                                                            <th>Floor</th>
                                                            <th>Room No./Ward No.</th>
                                                            <th>Room Type</th>
                                                            <th>Total Beds</th>
                                                            <th>Occupied Beds</th>
                                                            <th>UnOccupied Beds</th>
                                                        </tr>
                                                      </thead>
                                                      </table>  
                                                      </div>
                                                </span>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2">
                                                <hr>
                                                <span id="master_bed">
                                                	 <div class="alt2" dir="ltr" style="
														margin: 0px;
														padding: 0px;
														border: 0px solid #919b9c;
														width: 100%;
														height: 500px;
														text-align: left;
														overflow: auto">
                                                        <table class="table" id="myTable" width="100%" cellpadding="2" cellspacing="2">
                                                      <thead>
                                                      	<tr style="border-bottom:1px #999 solid; border-collapse:collapse">
                                                        	<th>Status</th>
                                                            <th>Bed No.</th>
                                                            <th>Patient No.</th>
                                                            <th>IOP No.</th>
                                                            <th>Patient Name</th>
                                                            <th>Date Admit</th>
                                                        </tr>
                                                      </thead>
                                                      </table>  
                                                      </div>
                                                </span>
                                                </td>
                                            </tr>
                                            </table>
                                            
                                            
                                        </div>
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