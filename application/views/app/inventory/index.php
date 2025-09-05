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
                        	<div class="box-body table-responsive no-padding">
                            	<?php echo $message;?>
                                <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/onepharma/container/index.php" ); ?>
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
      
    </body>
</html>
<script>
	<?php $uid = $this->session->userdata('user_id'); ?>
	var surl = "http://localhost/onepharma/ajax/index.php?uid=<?php echo $uid ?>";
	loadDoc();
	function loadDoc() {
		const xhttp = new XMLHttpRequest();
		xhttp.onload = function() {
		}
		xhttp.open("GET", surl, true);
		xhttp.send();
	}
</script>