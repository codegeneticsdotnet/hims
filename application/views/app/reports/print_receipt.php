<!DOCTYPE html>
<html>
<head>
<title>Official Receipt</title>
<style>
    body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #000; }
    .container { width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; background: #fff; }
    .header { text-align: center; margin-bottom: 40px; }
    .header h2 { margin: 0; text-transform: uppercase; letter-spacing: 1px; }
    .header p { margin: 5px 0; font-size: 10pt; }
    .receipt-title { text-align: center; font-weight: bold; font-size: 16pt; margin-bottom: 30px; text-decoration: underline; }
    
    .info-section { width: 100%; overflow: hidden; margin-bottom: 20px; }
    .info-left { float: left; width: 60%; }
    .info-right { float: right; width: 40%; text-align: right; }
    
    .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
    .table th { background-color: #f9f9f9; }
    .text-right { text-align: right; }
    
    .totals { width: 40%; float: right; margin-bottom: 40px; }
    .totals-row { overflow: hidden; margin-bottom: 5px; }
    .totals-label { float: left; width: 50%; font-weight: bold; }
    .totals-value { float: right; width: 50%; text-align: right; }
    
    .footer { clear: both; margin-top: 50px; }
    .signatures { overflow: hidden; margin-top: 50px; }
    .sig-box { float: left; width: 50%; text-align: center; }
    .sig-line { display: inline-block; width: 80%; border-top: 1px solid #000; margin-top: 40px; }
    
    @media print {
        body { background: none; }
        .no-print { display: none; }
        .container { border: none; max-width: 100%; margin: 0; padding: 0; }
    }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <?php if(file_exists('public/company_logo/logo.png')): ?>
                <img src="<?php echo base_url(); ?>public/company_logo/logo.png" alt="Logo" style="height: 80px; margin-bottom: 10px;">
            <?php endif; ?>
            <h2><?php echo $companyInfo->company_name; ?></h2>
            <p><?php echo $companyInfo->company_address; ?></p>
            <p>Contact: <?php echo $companyInfo->company_contactNo; ?></p>
        </div>
        
        <div class="receipt-title">OFFICIAL RECEIPT</div>
        
        <div class="info-section">
            <div class="info-left">
                <strong>Received From:</strong> <?php echo $patient->name; ?><br>
                <strong>Patient No:</strong> <?php echo $patient->patient_no; ?><br>
                <strong>Address:</strong> <?php echo $patient->address; ?>
            </div>
            <div class="info-right">
                <strong>Receipt No:</strong> <?php echo $header->invoice_no; ?><br>
                <strong>Date:</strong> <?php echo date('F d, Y', strtotime($header->dDate)); ?>
            </div>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 15%; text-align: right;">Unit Price</th>
                    <th style="width: 20%; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($details as $item): ?>
                <tr>
                    <td><?php echo $item->bill_name; ?></td>
                    <td style="text-align: center;"><?php echo $item->qty; ?></td>
                    <td class="text-right"><?php echo number_format($item->rate, 2); ?></td>
                    <td class="text-right"><?php echo number_format($item->amount, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="totals">
            <div class="totals-row">
                <div class="totals-label">Subtotal:</div>
                <div class="totals-value"><?php echo number_format($header->sub_total, 2); ?></div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Discount:</div>
                <div class="totals-value"><?php echo number_format($header->discount, 2); ?></div>
            </div>
            <div class="totals-row" style="border-top: 2px solid #000; padding-top: 5px; font-size: 14pt;">
                <div class="totals-label">TOTAL:</div>
                <div class="totals-value"><?php echo number_format($header->total_amount, 2); ?></div>
            </div>
        </div>
        
        <div class="footer">
            <div class="signatures">
                <div class="sig-box">
                    <span class="sig-line"></span><br>
                    <strong>Prepared By</strong><br>
                    <?php echo $this->session->userdata('username'); ?>
                </div>
                <div class="sig-box">
                    <span class="sig-line"></span><br>
                    <strong>Approved By</strong>
                </div>
            </div>
            
            <p style="text-align: center; margin-top: 30px; font-size: 9pt; font-style: italic;">
                This is a computer generated receipt.
            </p>
        </div>
        
        <div class="no-print" style="position: fixed; top: 20px; right: 20px;">
            <button onclick="window.print()" style="padding: 10px 20px; font-size: 12pt; cursor: pointer;">Print Receipt</button>
            <br><br>
            <a href="<?php echo base_url()?>app/billing_new" style="display: block; text-align: center; background: #eee; padding: 10px; text-decoration: none; color: #333; border: 1px solid #ccc;">Close</a>
        </div>
    </div>
</body>
</html>