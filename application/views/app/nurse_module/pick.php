<?php require_once(APPPATH.'views/include/head.php');?>
    <body class="skin-blue" onLoad="getPatientList('a')">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <!-- <?php require_once(APPPATH.'views/include/sidebar.php');?> -->

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side strech">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?php echo $module_title?></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 <ol class="breadcrumb" style="margin-bottom: 5px; background-color: transparent; padding-left: 0; padding-top: 0; padding-bottom: 0;">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Nurse Module</a></li>
                        <li class="active"><?php echo $module_title?></li>
                    </ol>
                 
                 <script language="javascript">
                    function validate(){
                        if(document.getElementById("patient_no").value == ""){
                            alert('Please select Patient.');
                            return false;
                        }else{
                            return true;
                        }
                    }
                 </script>
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	 <form method="post" action="<?php echo base_url()?>app/nurse_module/<?php echo $module;?>" onSubmit="return validate();">
                            <div class="box">
                                
                                <div class="box-body table-responsive">
                                    
                                    <table cellpadding="3" cellspacing="3" >
                                    <tr>
                                        <td width="10%">Select Patient</td>
                                        <td width="20%">
                                            <input type="hidden" name="patient_no" id="patient_no">
                                            <input type="hidden" name="iop_no" id="iop_no">
                                            <input type="text" readonly name="patient_name" id="patient_name" data-toggle="modal" data-target="#patientListModal" placeholder="Select Patient" class="form-control input-sm" style="width: 250px; cursor:pointer;" required>
                                        </td>
                                        <td width="20%"><div class="box-footer clearfix">
                                    <button class="btn btn-primary" name="btnSubmit" type="submit"><i class="fa fa-check"></i> Submit</button>
                                </div>
                                </td><td width="50%">&nbsp;
                                        </td>
                                    </tr>
                                    </table>
                                    
                                </div>
                            </div>
                        </form>
                        
                    </div>
                 </div>
                 
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
  
  
  
  
  		<!-- / patientListModal modal -->   
        					<div class="modal fade" id="patientListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Search Patient</h4>
                                        </div>
                                        <div class="modal-body">
                                        			
                                                    
<script language="javascript">
function addPatient(iop_no,patient_no,patient){

document.getElementById("patient_name").value = patient;
document.getElementById("iop_no").value = iop_no;
document.getElementById("patient_no").value = patient_no;

$('#patientListModal').modal('hide');
						return true;	
}

function getPatientList(val)
{
	var cType;
	cType = "OPD";
	
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
    document.getElementById("showPatients").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","<?php echo base_url();?>general/ipdLists/"+val,true);
  xmlhttp.send();

}
</script>   
                                                    <input onKeyUp="getPatientList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                                        		<span id="showPatients">
                                                
                                                </span>
                                                
                                               
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           <!-- <button type="button" class="btn btn-primary" onClick="return addPatient()">Proceed</button>-->
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
  
  
  
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
         <!-- BDAY -->
         <script src="<?php echo base_url();?>public/datepicker/js/jquery-1.9.1.min.js"></script>
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
                
                // Initialize patient list
                getPatientList('a');
            
            });
        </script>
        <!-- END BDAY -->
        
        
    </body>
</html>