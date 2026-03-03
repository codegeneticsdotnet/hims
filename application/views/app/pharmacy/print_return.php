<!DOCTYPE html>
<html>
<head>
    <title>Return Slip - <?php echo $header->return_no; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Pharmacy Return Slip</h2>
        <p><?php echo date('F d, Y h:i A', strtotime($header->date_return)); ?></p>
    </div>
    
    <div class="info">
        <strong>Return No:</strong> <?php echo $header->return_no; ?><br>
        <strong>Patient:</strong> <?php echo $header->patient_name ? $header->patient_name . ' (' . $header->patient_no . ')' : 'Walk-in / Unknown'; ?><br>
        <strong>Remarks:</strong> <?php echo $header->remarks; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Qty Returned</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details as $item): ?>
            <tr>
                <td><?php echo $item->drug_name; ?></td>
                <td class="text-center"><?php echo $item->qty; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 30px;">
        <p>Processed By: <?php echo $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname'); ?></p>
    </div>
</body>
</html>