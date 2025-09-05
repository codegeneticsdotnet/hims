            <?php require_once(APPPATH.'views/include/head.php');?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <!-- Content Header (Page header) -->
                <section class="content" style=" background-image: url('/public/christbearer.jpg');opacity: 0.7;background-size: cover; background-repeat: no-repeat;">
                <div class="row" style="width:100%;height:100%">
                    <section class="col-lg-12 connectedSortable">
                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                    </section>
                </div>
                </section>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
         <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>     
         

         <script type="text/javascript">
         $(document).ready(function(){
            
            doctorOUTF();
            doctorINF();

         });

         function doctorOUTF()
         {
            $.ajax({
                url: "<?php echo base_url()?>general/getDoctorOUT",
                type: "POST",
                success: function(result){
                    $('#doctorOUT').html(result);
                },beforeSend: function(){
                    $('#doctorOUT').html("<center><img src='../public/img/ajax-loader.gif'></center>");
                }
            });
         }

         function doctorINF()
         {
            $.ajax({
                url: "<?php echo base_url()?>general/getDoctorIN",
                type: "POST",
                success: function(result){
                    $('#doctorIN').html(result);
                },beforeSend: function(){
                    $('#doctorIN').html("<center><img src='../public/img/ajax-loader.gif'></center>");
                }
            });
         }

         function doctorProcess(id,status)
         {
            if(confirm('Are you sure you want the doctor ' + status + '?'))
            {
                $.ajax({
                    url: "<?php echo base_url()?>general/procDocAvail/" + id + "/" + status,
                    type: "POST",
                    success: function()
                    {
                        alert('Doctor is ' + status);
                        doctorINF()
                        doctorOUTF()
                    },
                    beforeSend: function(){
                        $('#doctor' + status).html("<center><img src='../public/img/ajax-loader.gif'></center>");
                    }
                });
                return true;
            }
            else
            {
                return false;
            }

         }
         </script>
         
    </body>
</html>