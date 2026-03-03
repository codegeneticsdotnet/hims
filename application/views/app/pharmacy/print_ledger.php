<!DOCTYPE html>
<html>
<head>
    <title>Inventory Ledger - <?php echo $item_info->drug_name; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Pharmacy Inventory Ledger</h2>
        <p><?php echo date('F d, Y'); ?></p>
    </div>
    
    <div class="info">
        <strong>Item Name:</strong> <?php echo $item_info->drug_name; ?><br>
        <strong>Current Stock:</strong> <?php echo $item_info->nStock; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>REF DATE</th>
                <th>REF NO</th>
                <th>TYPE</th>
                <th>EXPIRY</th>
                <th>AMOUNT</th>
                <th>IN</th>
                <th>OUT</th>
                <th>TOTAL</th>
                <th>REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $running_total = 0;
            if(!empty($ledger)):
                foreach($ledger as $item):
                    $qty_in = $item->qty_in;
                    $qty_out = $item->qty_out;
                    $running_total += $qty_in - $qty_out;
                    
                    $unit_cost = 0;
                    if($qty_in > 0 && $item->amount > 0) $unit_cost = $item->amount / $qty_in;
                    elseif($qty_out > 0 && $item->amount > 0) $unit_cost = $item->amount / $qty_out;
            ?>
            <tr>
                <td><?php echo $item->ref_date; ?></td>
                <td><?php echo $item->ref_no; ?></td>
                <td><?php echo $item->type; ?></td>
                <td><?php echo $item->expiry_date ? $item->expiry_date : '-'; ?></td>
                <td class="text-right"><?php echo number_format($unit_cost, 2); ?></td>
                <td class="text-center"><?php echo $qty_in > 0 ? $qty_in : '-'; ?></td>
                <td class="text-center"><?php echo $qty_out > 0 ? $qty_out : '-'; ?></td>
                <td class="text-center"><strong><?php echo $running_total; ?></strong></td>
                <td><?php echo $item->remarks; ?></td>
            </tr>
            <?php 
                endforeach;
            else:
            ?>
            <tr><td colspan="9" class="text-center">No transactions found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>