<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laboratory Request</title>
    <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .items-table th {
            background-color: #f5f5f5;
            text-align: left;
        }
        .footer {
            margin-top: 50px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 40px;
            text-align: center;
            padding-top: 5px;
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
        <h2><?php echo $this->session->userdata('branch_name') ? $this->session->userdata('branch_name') : 'Christ Bearer Hospital'; ?></h2>
        <p>Laboratory Request</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Request No:</strong></td>
            <td width="35%"><?php echo $header->request_no;?></td>
            <td width="15%"><strong>Date:</strong></td>
            <td width="35%"><?php echo date('M d, Y h:i A', strtotime($header->request_date));?></td>
        </tr>
        <tr>
            <td><strong>Patient Name:</strong></td>
            <td><?php echo $header->patient_name;?></td>
            <td><strong>Patient No:</strong></td>
            <td><?php echo $header->patient_no;?></td>
        </tr>
        <tr>
            <td><strong>Age/Gender:</strong></td>
            <td><?php echo $header->age;?> / <?php echo ($header->gender == 1 ? 'Male' : 'Female');?></td>
            <td><strong>Type:</strong></td>
            <td><?php echo $header->request_type;?></td>
        </tr>
        <?php if(!empty($header->remarks)): ?>
        <tr>
            <td><strong>Remarks:</strong></td>
            <td colspan="3"><?php echo $header->remarks;?></td>
        </tr>
        <?php endif; ?>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Service Description</th>
                <th width="10%">Qty</th>
                <th width="15%">Unit Price</th>
                <th width="15%">Discount</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $grand_total = 0;
            foreach($details as $row):
                $grand_total += $row->total_amount;
            ?>
            <tr>
                <td>
                    <?php echo $row->particular_name;?>
                    <?php if(!empty($row->particular_desc)): ?>
                        <br><small><?php echo $row->particular_desc;?></small>
                    <?php endif; ?>
                    <?php if(!empty($row->result_remarks)): ?>
                        <br><small><em>Note: <?php echo $row->result_remarks;?></em></small>
                    <?php endif; ?>
                </td>
                <td style="text-align: center;"><?php echo $row->qty;?></td>
                <td style="text-align: right;"><?php echo number_format($row->amount, 2);?></td>
                <td style="text-align: right;"><?php echo number_format($row->discount, 2);?></td>
                <td style="text-align: right;"><?php echo number_format($row->total_amount, 2);?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                <td style="text-align: right;"><strong><?php echo number_format($grand_total, 2);?></strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="row">
            <div class="col-xs-6">
                <div class="signature-line">
                    Prepared By
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <div class="signature-line pull-right">
                    Approved By
                </div>
            </div>
        </div>
    </div>

</body>
</html>
