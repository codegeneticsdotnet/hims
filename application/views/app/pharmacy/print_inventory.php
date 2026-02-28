<!DOCTYPE html>
<html>
<head>
<title>Inventory In Report</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #000; padding: 5px; }
    @media print { .no-print { display: none; } }
</style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Print</button>
        <button onclick="window.close()">Close</button>
    </div>

    <div class="header">
        <h3>Inventory Stock In Receipt</h3>
    </div>

    <table style="border: none;">
        <tr style="border: none;">
            <td style="border: none; width: 50%;">
                <strong>Ref No:</strong> <?php echo $header->ref_no;?><br>
                <strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($header->date_received));?>
            </td>
            <td style="border: none; width: 50%;">
                <strong>Supplier:</strong> <?php echo $header->supplier_name;?><br>
                <strong>Remarks:</strong> <?php echo $header->remarks;?>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Batch No</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($details as $row): ?>
            <tr>
                <td><?php echo $row->item_name;?></td>
                <td><?php echo $row->qty;?></td>
                <td><?php echo $row->batch_no;?></td>
                <td><?php echo $row->expiry_date;?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>