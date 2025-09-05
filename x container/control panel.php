<?php 
function url($sitename){
    return "http://" . $_SERVER['HTTP_HOST']  . "/hims" .  $sitename;
  }  
?>

<?php $path = $_SERVER['DOCUMENT_ROOT'] . "/hims"; ?>
    <!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- AdminLTE App -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js" integrity="sha512-KBeR1NhClUySj9xBB0+KRqYLPkM6VvXiiWaSz/8LCQNdRpUm38SWUrj0ccNDNSkwCD9qPA4KobLliG26yPppJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="../container/controlpanel.css">
	<style type="text/css">
		/* control panel */
		.breadcrumb{padding:3px 10px 3px 0px;}
		.navbar-brand{margin:0px;padding:0px 10px;}
    	.bigfont i{
    		font-size:1.5em;
    		margin-bottom:10px;
    	}
		.bigfont {margin:0px 10px;}
    	.bigfont .menuicon{
    		width:100px;
    		margin:10px 0px;
    		text-align:center;
    		font-size:2em;
    		border:0px;
    		float:left;
    		color:#0b9feb;
    	}
        .menuicon a:hover{
            color:orange;
        }
        .menuicon p{
            font-size:0.4em;
        }
        .hicon{
            font-weight:bold;
            clear:both;
            margin-bottom:5px; 
            padding-bottom:5px; 
            width:100%;
            color:#777;
            border-bottom:1px #ccc solid;
			font-size:1em;
        }
    </style>

	<script type="text/javascript">
		function loadPage(page){
			if (page == "itemsearch"){
				$(".inventory_card").load('<?php echo base_url() . "container/manage_inventory.php"; ?>');
			}else{	
				$(".inventory_card").load('<?php echo base_url() . "container/control%20panel.php"; ?>');
			}
			console.log(page);
            alert ('<?php echo base_url() . "container/control%20panel.php"; ?>');
			return false;
		}
	</script>
	
    <div class="col-sm-12 inventory_card" style="padding:0px;">
    	<div class="card" >
			<script type="text/javascript">
				loadPage('control panel');

			</script>    	
		</div>
    </div>
