<!DOCTYPE html>
<html>
<head>
<title>Patient Information Sheet</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #000; padding: 5px; vertical-align: top; }
    .header { margin-bottom: 20px; }
    .no-border td { border: none; }
    .bold { font-weight: bold; }
    @media print { .no-print { display: none; } }
</style>
</head>
<body onload="">

<div class="no-print" style="margin-bottom: 10px; border-bottom:1px solid #ccc; padding-bottom:10px;">
    <form method="post" action="" style="display:inline;">
        <strong>Filter Date:</strong> 
        From <input type="date" name="cFrom" value="<?php echo $this->input->post('cFrom');?>">
        To <input type="date" name="cTo" value="<?php echo $this->input->post('cTo');?>">
        <button type="submit">Filter</button>
    </form>
    &nbsp;&nbsp;&nbsp;
    <button onclick="window.print()">Print</button>
    <button onclick="history.back()">Back</button>
    <button onclick="window.close()">Close</button>
</div>

<div class="header">
    <table class="no-border">
        <tr>
            <td width="50%">
                <strong>Patient:</strong> <?php echo strtoupper($patientInfo->firstname . ' ' . $patientInfo->middlename . ' ' . $patientInfo->lastname); ?> (<?php echo $patientInfo->patient_no; ?>)<br>
                <strong>Birthdate:</strong> <?php echo date('F d, Y', strtotime($patientInfo->birthday)); ?><br>
                <strong>Age:</strong> <?php echo $patientInfo->age; ?><br>
                <strong>Address:</strong> <?php echo $patientInfo->street . ' ' . $patientInfo->subd_brgy . ' ' . $patientInfo->province; ?>
            </td>
            <td width="50%">
                <strong>Allergies:</strong> <?php echo (!empty($latest_visit)) ? $latest_visit->allergies : ''; ?><br>
                <strong>Medical History:</strong> <?php echo (!empty($latest_visit)) ? $latest_visit->past_medical_history : ''; ?>
            </td>
        </tr>
    </table>
</div>

<h3>Patient History</h3>

<table>
    <thead>
        <tr>
            <th width="10%">OPD Date</th>
            <th width="20%">Medical Concerns</th>
            <th width="35%">Details</th>
            <th width="35%">Diagnosis & Treatment</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($history as $visit): ?>
        <tr>
            <td>
                <?php echo date('Y-m-d', strtotime($visit['visit_info']->date_visit)); ?>
                <div class="no-print" style="margin-top:5px;">
                    <a href="<?php echo base_url()?>app/opd/edit_history/<?php echo $visit['visit_info']->IO_ID;?>/<?php echo $patientInfo->patient_no;?>" class="btn btn-xs btn-primary">Edit</a>
                </div>
            </td>
            <td>
                <?php 
                if($visit['complaints']){
                    foreach($visit['complaints'] as $c){
                        echo "- " . $c->complain_name . "<br>";
                        if($c->remarks) echo "<small>(" . $c->remarks . ")</small><br>";
                    }
                }
                ?>
            </td>
            <td>
                <strong>VITAL SIGNS:</strong><br>
                <?php if($visit['vitals']): ?>
                    <?php foreach($visit['vitals'] as $v): ?>
                    BP: <?php echo $v->bp; ?><br>
                    Temp: <?php echo $v->temperature; ?><br>
                    Pulse: <?php echo $v->pulse_rate; ?><br>
                    Resp: <?php echo $v->respiration; ?><br>
                    Weight: <?php echo $v->weight; ?><br>
                    Height: <?php echo $v->height; ?><br>
                    <?php endforeach; ?>
                <?php endif; ?>
                <br>
                <strong>LABORATORY:</strong><br>
                <?php if($visit['labs']): ?>
                    <table style="font-size: 10px; border:none; width:100%;">
                    <?php foreach($visit['labs'] as $l): ?>
                        <tr>
                            <td style="border:none; padding:2px;"><?php echo $l->request_no; ?></td>
                            <td style="border:none; padding:2px;"><?php echo $l->particular_name; ?></td>
                            <td style="border:none; padding:2px;"><?php echo $l->status; ?></td>
                            <td style="border:none; padding:2px;"><?php echo $l->result_remarks; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    - No Lab Results
                <?php endif; ?>
            </td>
            <td>
                <strong>Diagnosis:</strong><br>
                <?php 
                if($visit['diagnosis']){
                    foreach($visit['diagnosis'] as $d){
                        echo "- " . $d->diagnosis_name . "<br>";
                        if($d->remarks) echo "<small>(" . $d->remarks . ")</small><br>";
                    }
                }
                ?>
                <br>
                <strong>Treatment:</strong><br>
                <?php 
                if($visit['medication']){
                    foreach($visit['medication'] as $m){
                        echo "- " . $m->drug_name . " (" . $m->total_qty . ")<br>";
                        echo "<small>" . $m->instruction . "</small><br>";
                    }
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>