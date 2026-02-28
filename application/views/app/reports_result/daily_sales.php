<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Hospital Management System</title>   
</head>
<style>
body{
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
}
table {
    border-collapse: collapse;
}
@media print { .no-print { display: none; } }
</style>
<body>
<div class="no-print" style="margin-bottom: 20px;">
    <button onclick="window.print()" style="padding: 6px 12px; cursor: pointer;">Print</button>
    <button onclick="window.close()" style="padding: 6px 12px; cursor: pointer;">Close</button>
</div>
<center>
	<font size="+1"><?php echo $companyInfo->company_name;?></font></b><br>                   
    <?php echo $companyInfo->company_address;?><br>     
    <?php echo $companyInfo->company_contactNo;?><br><br>
    <?php echo $reports_title;?>
</center>   
<br /><br />

<table width="100%" cellpadding="5" cellspacing="0" border="0" style="border-collapse:collapse;">
<thead>
    <tr>
        <th width="40%"></th>
        <th width="60%" style="padding:0; border-bottom:1px solid #000;">
             <table width="100%" cellpadding="3" cellspacing="0" border="0">
                <tr style="font-weight:bold; background:#eee;">
                    <td width="40%" style="padding:3px;">Description</td>
                    <td width="10%" align="center" style="padding:3px;">Qty</td>
                    <td width="15%" align="right" style="padding:3px;">Unit Price</td>
                    <td width="15%" align="right" style="padding:3px;">Discount</td>
                    <td width="20%" align="right" style="padding:3px;">Amount</td>
                </tr>
             </table>
        </th>
    </tr>
</thead>
<tbody>
<?php 
$CI =& get_instance();
$CI->load->model('app/billing_model');
$CI->load->model('app/patient_model');

// Pre-fetch Particulars Map
$CI->db->select('A.particular_name, B.group_name');
$CI->db->join('bill_group_name B', 'B.group_id = A.group_id');
$query = $CI->db->get('bill_particular A');
$particularsMap = array();
foreach($query->result() as $row){
    $particularsMap[$row->particular_name] = $row->group_name;
}

foreach($daily_sales as $sale){ 
    // Get Details
    $details = $CI->billing_model->detailsInv2($sale->invoice_no);
    
    // Group Items
    $grouped = array();
    if($details){
        foreach($details as $item){
            $name = $item->bill_name;
            $cat = 'Others';
            
            // Check known patterns first
            if(stripos($name, 'Doctor Fee') !== false || stripos($name, 'Consultation') !== false){
                $cat = 'Consultation';
            }
            else if(stripos($name, 'Lab:') === 0 || stripos($name, 'Laboratory') !== false){
                $cat = 'Laboratory';
            }
            else if(stripos($name, 'X-Ray') !== false){
                $cat = 'X-Ray';
            }
            else if(stripos($name, 'Ultrasound') !== false){
                $cat = 'Ultrasound';
            }
            else if(isset($particularsMap[$name])){
                $group = $particularsMap[$name];
                if(stripos($group, 'Lab') !== false) $cat = 'Laboratory';
                else if(stripos($group, 'X-Ray') !== false) $cat = 'X-Ray';
                else if(stripos($group, 'Ultra') !== false) $cat = 'Ultrasound';
                else $cat = $group;
            }
            
            $grouped[$cat][] = $item;
        }
        $order = array('Consultation', 'Laboratory', 'X-Ray', 'Ultrasound', 'Others');
        $sortedGrouped = array();
        foreach($order as $key){
            if(isset($grouped[$key])){
                $sortedGrouped[$key] = $grouped[$key];
                unset($grouped[$key]);
            }
        }
        foreach($grouped as $key => $val){
            $sortedGrouped[$key] = $val;
        }
        $grouped = $sortedGrouped;
    }
    
    // Get Patient Address
    $patientInfo = $CI->patient_model->getPatientInfo($sale->patient_no);
    $address = $patientInfo ? $patientInfo->address : "";
?>
    <tr>
        <td valign="top" style="padding:10px; border-bottom:1px solid #000;" width="40%">
            <strong>Control No:</strong> <a href="<?php echo base_url();?>app/reports/receipt/<?php echo $sale->receipt_no?>" target="_blank" style="text-decoration:none; color:blue;"><?php echo $sale->receipt_no?></a><br>
            <strong>Date:</strong> <?php echo date("F d, Y", strtotime($sale->dDate));?><br><br>
            <strong>Patient:</strong> <?php echo $sale->patient;?> (<?php echo $sale->patient_no;?>)<br>
            <strong>Address:</strong> <?php echo $address;?>
        </td>
        <td valign="top" style="padding:0; border-bottom:1px solid #000;" width="60%">
            <table width="100%" cellpadding="3" cellspacing="0" border="0">
                <?php if($grouped): ?>
                    <?php foreach($grouped as $cat => $items): ?>
                        <tr><td colspan="5" style="background:#eee; font-weight:bold; font-size:11px; padding:2px 5px; border-bottom:1px solid #ddd;"><?php echo strtoupper($cat); ?></td></tr>
                        <?php foreach($items as $item){ 
                             $itemDiscount = ($item->rate * $item->qty) - $item->amount;
                             if($itemDiscount < 0) $itemDiscount = 0;
                        ?>
                        <tr>
                            <td style="padding:3px; border-bottom:1px solid #eee; padding-left:15px;"><?php echo $item->bill_name;?></td>
                            <td align="center" style="padding:3px; border-bottom:1px solid #eee;"><?php echo $item->qty;?></td>
                            <td align="right" style="padding:3px; border-bottom:1px solid #eee;"><?php echo number_format($item->rate, 2);?></td>
                            <td align="right" style="padding:3px; border-bottom:1px solid #eee;"><?php echo number_format($itemDiscount, 2);?></td>
                            <td align="right" style="padding:3px; border-bottom:1px solid #eee;"><?php echo number_format($item->amount, 2);?></td>
                        </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" align="center">No details available</td></tr>
                <?php endif; ?>
                
                <!-- Totals for this receipt -->
                <tr style="background:#eee;">
                    <td colspan="3" align="right" style="padding:3px;">
                        <strong>TOTAL</strong>
                        <?php if(!empty($sale->reason_discount)): ?>
                            <span style="font-weight:normal; font-style:italic; font-size:11px;">(<?php echo $sale->reason_discount; ?>)</span>
                        <?php endif; ?>
                    </td>
                    <td align="right" style="padding:3px;"><strong>(<?php echo number_format($sale->discount, 2);?>)</strong></td>
                    <td align="right" style="padding:3px;"><strong><?php echo number_format($sale->total_amount, 2);?></strong></td>
                </tr>
            </table>
        </td>
    </tr>
<?php } ?>

<!-- Grand Total -->
<tr style="border-top:2px solid #000;">
    <td align="right" style="padding:10px;"></td>
    <td style="padding:0;">
        <table width="100%" cellpadding="3" cellspacing="0">
            <tr>
                <td width="40%"></td>
                <td width="10%"></td>
                <td width="15%" align="right"><strong>Total Sales:</strong></td>
                <td width="15%" align="right"><strong>(<?php echo number_format($total_sales->discount, 2);?>)</strong></td>
                <td width="20%" align="right" style="padding:3px;"><strong><?php echo number_format($total_sales->total_amount, 2);?></strong></td>
            </tr>
        </table>
    </td>
</tr>


</tbody>
</table>

</body>
</html>