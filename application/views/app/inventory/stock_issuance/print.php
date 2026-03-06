<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stock Issuance - <?php echo $header->issuance_no;?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .details-table { width: 100%; border-collapse: collapse; }
        .details-table th, .details-table td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body onload="window.print();">

    <div class="header">
        <h2>Stock Issuance Slip</h2>
        <h3><?php echo $header->issuance_no;?></h3>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Issued To:</strong> <?php echo $header->issued_to_name;?></td>
            <td><strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($header->issue_date));?></td>
        </tr>
        <tr>
            <td><strong>Created By:</strong> <?php echo $header->created_by_name;?></td>
            <td><strong>Status:</strong> <?php echo $header->status;?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Remarks:</strong> <?php echo $header->remarks;?></td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Qty Issued</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details as $item): ?>
            <tr>
                <td><?php echo $item->drug_name;?></td>
                <td><?php echo $item->uom_name;?></td>
                <td><?php echo $item->qty;?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Printed Date: <?php echo date('M d, Y h:i A');?></p>
    </div>

</body>
</html>