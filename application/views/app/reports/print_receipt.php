<!DOCTYPE html>
<html>
<head>
<title>Receipt</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .container { width: 300px; margin: 0 auto; padding: 10px; border: 1px solid #ccc; }
    .header { text-align: center; margin-bottom: 20px; }
    .info { margin-bottom: 15px; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .table th, .table td { text-align: left; padding: 5px; border-bottom: 1px solid #eee; }
    .total { text-align: right; font-weight: bold; margin-top: 10px; }
    .footer { text-align: center; margin-top: 20px; font-size: 10px; }
    @media print {
        .no-print { display: none; }
        .container { border: none; }
    }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3><?php echo $companyInfo->company_name; ?></h3>
            <p><?php echo $companyInfo->company_address; ?><br>
            <?php echo $companyInfo->company_contactNo; ?></p>
        </div>
        
        <div class="info">
            <p>
                <strong>Receipt No:</strong> <?php echo $header->invoice_no; ?><br>
                <strong>Date:</strong> <?php echo date('M d, Y h:i A', strtotime($header->dDate)); ?><br>
                <strong>Patient:</strong> <?php echo $patient->name; ?><br>
                <strong>Patient No:</strong> <?php echo $patient->patient_no; ?>
            </p>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: right;">Amt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($details as $item): ?>
                <tr>
                    <td>
                        <?php echo $item->bill_name; ?>
                        <br><small>Qty: <?php echo $item->qty; ?> x <?php echo number_format($item->rate, 2); ?></small>
                    </td>
                    <td style="text-align: right;"><?php echo number_format($item->amount, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="total">
            <p>Subtotal: <?php echo number_format($header->sub_total, 2); ?></p>
            <p>Discount: <?php echo number_format($header->discount, 2); ?></p>
            <p>Total: <?php echo number_format($header->total_amount, 2); ?></p>
        </div>
        
        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>Prepared by: <?php echo $this->session->userdata('username'); ?></p>
        </div>
        
        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()">Print</button>
            <a href="<?php echo base_url()?>app/billing_new" class="button" style="text-decoration: none; color: black; border: 1px solid #ccc; padding: 2px 6px; background-color: #f0f0f0; font-size: 11px;">Close</a>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            // window.print();
        }
    </script>
</body>
</html>