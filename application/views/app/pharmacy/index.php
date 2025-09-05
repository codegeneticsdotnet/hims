                <?php require_once(APPPATH.'views/include/head.php');?>
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

                <style type="text/css">
                    .bigfont i{
                        font-size:3em;
                        margin-bottom:10px;
                    }
                    .bigfont .menuicon{
                        width:140px;
                        margin:15px 0px;
                        text-align:center;
                        font-size:1.1em;
                        border:0px;
                        float:left;
                        color:#0b9feb;
                    }
                </style>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Pharmacy</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><a href="#">Pharmacy</a></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="card" id="pharmacontainer">
                                    <div class="container">
                                        <h4 class="title">Pharmacy</h4>
                                        <div class="bigfont">
                                            <a class="menuicon" data-id="inventoryin" href="#"><i class="fa fa-truck"></i><br />Inventory In</a>
                                            <a class="menuicon" data-id="" href="#"><i class="fa fa-user"></i><br />Delivery Receipt</a>
                                            <a class="menuicon" data-id="" href="#"><i class="fa fa-user"></i><br />Return Material</a>
                                            <a class="menuicon" data-id="" href="#"><i class="fa fa-user"></i><br />Stock Transfer</a>
                                            <hr style="clear:both;" />
                                            <a class="menuicon" data-id="itemtagging" href="#"><i class="fa fa-ticket"></i><br />Item Tagging</a>
                                            <a class="menuicon" href="#"><i class="fa fa-junk"></i><br />Void Transaction</a>
                                            <a class="menuicon" href="#"><i class="fa fa-albums"></i><br />Inventory Summary</a>
                                            <a class="menuicon" href="#"><i class="fa fa-graph"></i><br />Reports</a>
                                            <hr style="clear:both;" />
                                            <a class="menuicon" href="#"><i class="fa fa-settings"></i><br />Settings</a>
                                            <a class="menuicon" href="users.php"><i class="fa fa-user"></i><br />Users</a>
                                            <a class="menuicon" href="index.php?logout=t" onclick="return confirm('Are you sure you want to Log Off?');"><i class="fa pe-7s-rocket"></i><br />Logout</a>
                                        </div>
                                        <br /><br /><br style="clear:both" />
                                    </div>
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
        <script src="<?php echo base_url();?>public/js/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>    
        <script>
            $(".menuicon").click(function(){
                var url=$(this).attr('data-id');
                if(url != ""){
                    url = "app/pharmacy/" + url;
                    page(url);
                }
                return false;
            });
            function page(curl){
                $.ajax({
                    url: "<?php echo base_url();?>" + curl,
                    method:'POST',
                    error:err=>{
                        console.log(err)
                    },
                    success:function(resp){
                        $("#pharmacontainer").html(resp);
                    }
                })
            }
        </script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    </body>
</html>