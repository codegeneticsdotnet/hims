<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hospital Management System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="<?php echo base_url()?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="<?php echo base_url()?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url()?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <link href="<?php echo base_url()?>public/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    
</head>
<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH.'views/include/header.php');?>
    
    <div class="wrapper row-offcanvas row-offcanvas-left">
        
        <?php require_once(APPPATH.'views/include/sidebar.php');?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">                
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Sales Return Report</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Pharmacy Reports</a></li>
                    <li class="active">Sales Return Report</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                            </div>
                            <div class="box-body">
                                <form action="<?php echo base_url()?>app/pharmacy_reports/sales_return" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date From</label>
                                                <input type="date" name="cFrom" class="form-control" value="<?php echo $cFrom;?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date To</label>
                                                <input type="date" name="cTo" class="form-control" value="<?php echo $cTo;?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <br>
                                                <button type="submit" name="btnView" value="view" class="btn btn-primary"><i class="fa fa-eye"></i> View Report</button>
                                                <button type="submit" name="print" value="print" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if(isset($returns)):?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body table-responsive">
                                <div class="text-center">
                                    <h3>Sales Return Report</h3>
                                    <p>From: <?php echo date('M d, Y', strtotime($cFrom));?> To: <?php echo date('M d, Y', strtotime($cTo));?></p>
                                </div>
                                
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Return No</th>
                                            <th>Date</th>
                                            <th>Patient</th>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total Refund</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $grand_total = 0;
                                        if(!empty($returns)):
                                            foreach($returns as $ret){
                                                $details = $this->pharmacy_reports_model->getReturnDetails($ret->return_id);
                                                foreach($details as $item){
                                                    $total = $item->qty * $item->price;
                                                    $grand_total += $total;
                                        ?>
                                        <tr>
                                            <td><?php echo $ret->return_no;?></td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($ret->date_return));?></td>
                                            <td><?php echo $ret->patient_name ? $ret->patient_name : 'Walk-in / Unknown';?></td>
                                            <td><?php echo $item->drug_name;?></td>
                                            <td class="text-center"><?php echo $item->qty;?></td>
                                            <td class="text-right"><?php echo number_format($item->price, 2);?></td>
                                            <td class="text-right"><?php echo number_format($total, 2);?></td>
                                            <td><?php echo $ret->remarks;?></td>
                                        </tr>
                                        <?php 
                                                }
                                            }
                                        else:
                                        ?>
                                        <tr><td colspan="8" class="text-center">No returns found.</td></tr>
                                        <?php endif;?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight:bold; font-size:14px;">
                                            <td colspan="6" class="text-right">Total Returns:</td>
                                            <td class="text-right"><?php echo number_format($grand_total, 2);?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.0.2 -->
    <script src="<?php echo base_url()?>public/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url()?>public/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url()?>public/js/AdminLTE/app.js" type="text/javascript"></script>

</body>
</html>