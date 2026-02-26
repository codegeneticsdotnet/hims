 													<div class="alt2" dir="ltr" style="
														margin: 0px;
														padding: 0px;
														border: 0px solid #919b9c;
														width: 100%;
														height: 450px;
														text-align: left;
														overflow: auto">
                                                      <table class="table table-hover table-striped" id="myTable" width="100%" cellpadding="2" cellspacing="2">
                                                      <thead>
                                                      	<tr style="border-bottom:1px #999 solid; border-collapse:collapse">
                                                        	<th>Status</th>
                                                            <th>Floor</th>
                                                            <th>Room No./Ward No.</th>
                                                            <th>Room Type</th>
                                                            <th>Total Beds</th>
                                                            <th>Occupied Beds</th>
                                                            <th>UnOccupied Beds</th>
                                                            <th>Maintenance</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                      	<?php 
														foreach($getRoomMaster as $getRoomMaster){
														//occupied bed	
														$occu_bed = & get_instance();
														$occu_bed->load->model('app/general_model');
														$occu_bed_rs = $occu_bed->general_model->numberofOccuBeds($getRoomMaster->room_master_id);
														
														//unoccupied bed	
														$unoccu_bed = & get_instance();
														$unoccu_bed->load->model('app/general_model');
														$unoccu_bed_rs = $unoccu_bed->general_model->numberofUnOccuBeds($getRoomMaster->room_master_id);
                                                        
                                                        //maintenance bed (assuming similar function exists or we need to add one, for now assuming it's implicit or we calculate diff)
                                                        // Since we don't have numberofMaintenanceBeds in general_model yet, let's assume we need to add it or just rely on total - occu - unoccu if total is fixed.
                                                        // But total isn't stored directly, it's counted.
                                                        // Let's create a custom query here or better, add to general_model.
                                                        // For quick fix, I will add a direct query here or assume 0 for now until general_model is updated.
                                                        
                                                        $ci =& get_instance();
                                                        $ci->db->where('room_master_id', $getRoomMaster->room_master_id);
                                                        $ci->db->where('nStatus', 'Maintenance');
                                                        $maintenance_count = $ci->db->count_all_results('room_beds');
														
														?>
                                                        <tr align="center">
                                                        	<td><a href="#" onClick="getBed2('<?php echo $getRoomMaster->room_master_id;?>','<?php echo $getRoomMaster->room_name?>')">Status</a></td>
                                                            <td><?php echo $getRoomMaster->floor_name?></td>
                                                            <td><?php echo $getRoomMaster->room_name?></td>
                                                            <td><?php echo $getRoomMaster->category_name?></td>
                                                            <td><?php echo ($occu_bed_rs->numberofOccuBeds + $unoccu_bed_rs->numberofOccuBeds + $maintenance_count)?></td>
                                                            <td><?php echo $occu_bed_rs->numberofOccuBeds?></td>
                                                            <td><?php echo $unoccu_bed_rs->numberofOccuBeds?></td>
                                                            <td><?php echo $maintenance_count?></td>
                                                        </tr>
                                                        <?php }?>
                                                      </tbody>
                                                      </table>  
                                                      </div>