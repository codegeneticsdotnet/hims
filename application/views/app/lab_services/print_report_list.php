<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laboratory Services Report</title>
<style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .btn { padding: 6px 12px; margin-right: 5px; border: 1px solid transparent; border-radius: 4px; cursor: pointer; }
        .btn-primary { color: #fff; background-color: #337ab7; border-color: #2e6da4; }
        .btn-default { color: #333; background-color: #fff; border-color: #ccc; }
        @media print { .no-print { display: none; } }
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

    <table border="0" cellpadding="5" cellspacing="0" width="100%">
    <tbody>
    <?php 
    $grand_total = 0;
    if(isset($reports) && !empty($reports)):
        foreach($reports as $row):
            // Set amount to 0 if status is Cancelled
            $amount = ($row->status == 'Cancelled') ? 0 : $row->total_amount;
            if($row->status != 'Cancelled') $grand_total += $amount;
            
            // Get Details
            $details = $this->lab_services_model->getRequestDetails($row->request_id);
    ?>
        <tr style="border-bottom: 1px solid #000;">
            <td valign="top" style="padding:10px;" width="40%">
                <strong>Request No:</strong> <?php echo $row->request_no;?><br>
                <strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($row->request_date));?><br>
                <strong>Patient:</strong> <?php echo $row->patient_name;?> (<?php echo $row->patient_no;?>)<br>
                <strong>Type:</strong> <?php echo $row->request_type;?><br>
                <strong>Status:</strong> <?php echo $row->status;?>
            </td>
            <td valign="top" style="padding:0;" width="60%">
                 <table width="100%" cellpadding="3" cellspacing="0" border="0">
                    <tr style="border-bottom:1px solid #ccc; font-weight:bold; background:#f9f9f9;">
                        <td width="40%">Description</td>
                        <td width="20%">Status</td>
                        <td width="20%">Remarks</td>
                        <td width="20%" align="right">Amount</td>
                    </tr>
                    <?php if($details): ?>
                        <?php foreach($details as $item): ?>
                        <tr>
                            <td style="border-bottom:1px solid #eee;"><?php echo $item->particular_name;?></td>
                            <td style="border-bottom:1px solid #eee;"><?php echo $item->status;?></td>
                            <td style="border-bottom:1px solid #eee;"><?php echo $item->result_remarks;?></td>
                            <td align="right" style="border-bottom:1px solid #eee;"><?php echo number_format($item->total_amount, 2);?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <tr style="background:#eee;">
                        <td colspan="3" align="right"><strong>TOTAL:</strong></td>
                        <td align="right"><strong><?php echo number_format($amount, 2);?></strong></td>
                    </tr>
                 </table>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="2" align="center">No records found.</td></tr>
    <?php endif; ?>
    
    <!-- Grand Total -->
    <tr style="border-top:2px solid #000;">
        <td align="right" style="padding:10px;"></td>
        <td>
             <table width="100%" cellpadding="3" cellspacing="0">
                <tr>
                    <td width="40%"></td>
                    <td width="20%"></td>
                    <td width="20%" align="right"><strong>Total Sales:</strong></td>
                    <td width="20%" align="right"><strong><?php echo number_format($grand_total, 2);?></strong></td>
                </tr>
             </table>
        </td>
    </tr>
    </tbody>
    </table>

</body>
</html>