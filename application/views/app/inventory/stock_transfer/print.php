<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Transfer Manifest</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details th, .details td { border: 1px solid #000; padding: 5px; text-align: left; }
        .footer { margin-top: 50px; }
        .footer td { width: 50%; vertical-align: top; }
        .signature { border-top: 1px solid #000; width: 80%; margin-top: 30px; }
    </style>
</head>
<body onload="window.print()">
    
    <div class="header">
        <h2>STOCK TRANSFER MANIFEST</h2>
        <h3>Transfer No: <?php echo $header->transfer_no;?></h3>
        <p>Date: <?php echo date('M d, Y', strtotime($header->created_date));?></p>
    </div>
    
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td><strong>From:</strong> <?php echo $header->from_branch_name ? $header->from_branch_name : 'Main Inventory (Central Pharmacy)';?></td>
            <td><strong>To:</strong> <?php echo $header->to_branch_name;?></td>
        </tr>
        <tr>
            <td><strong>Status:</strong> <?php echo $header->status;?></td>
            <td><strong>Remarks:</strong> <?php echo $header->remarks;?></td>
        </tr>
    </table>
    
    <table class="details">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Qty Requested</th>
                <th>Qty Issued</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($details as $item): ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $item->drug_name;?></td>
                <td><?php echo $item->uom_name;?></td>
                <td><?php echo $item->qty_requested;?></td>
                <td><?php echo $item->qty_issued;?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <table class="footer" style="width: 100%;">
        <tr>
            <td>
                <p>Prepared By:</p>
                <div class="signature"></div>
                <p><?php echo $header->created_by_name;?></p>
            </td>
            <td>
                <p>Received By:</p>
                <div class="signature"></div>
                <p><?php echo $header->received_by_name ? $header->received_by_name : '_______________________';?></p>
            </td>
        </tr>
    </table>

</body>
</html>
