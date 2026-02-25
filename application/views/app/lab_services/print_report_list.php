<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laboratory Services Report</title>
    <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 5px 0;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        .report-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-default">Close</button>
    </div>

    <div class="header">
        <h3><?php echo $this->session->userdata('branch_name') ? $this->session->userdata('branch_name') : 'Christ Bearer Hospital'; ?></h3>
        <p>Laboratory Services Report</p>
        <p>From: <?php echo date('M d, Y', strtotime($cFrom));?> To: <?php echo date('M d, Y', strtotime($cTo));?></p>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Date Request</th>
                <th>Request No</th>
                <th>Patient Name</th>
                <th>Type</th>
                <th>Status</th>
                <th class="text-right">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $grand_total = 0;
            if(isset($reports) && !empty($reports)):
                foreach($reports as $row):
                    // Set amount to 0 if status is Cancelled
                    $amount = ($row->status == 'Cancelled') ? 0 : $row->total_amount;
                    $grand_total += $amount;
            ?>
            <tr>
                <td><?php echo date('M d, Y', strtotime($row->request_date));?></td>
                <td><?php echo $row->request_no;?></td>
                <td><?php echo $row->patient_name;?></td>
                <td><?php echo $row->request_type;?></td>
                <td><?php echo $row->status;?></td>
                <td class="text-right"><?php echo number_format($amount, 2);?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="6" class="text-center">No records found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                <td class="text-right"><strong><?php echo number_format($grand_total, 2);?></strong></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
