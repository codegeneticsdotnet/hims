<?php
$conn = new mysqli('localhost', 'root', 'lamot', 'hms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$io_id = 'IOM26030001';
$sql = "SELECT * FROM patient_details_iop WHERE IO_ID = '$io_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "IO_ID: " . $row["IO_ID"] . "\n";
    echo "Patient No: " . $row["patient_no"] . "\n";
    echo "Status: " . $row["nStatus"] . "\n";
    echo "InActive: " . $row["InActive"] . "\n";
    echo "Branch ID: " . $row["branch_id"] . "\n";
} else {
    echo "Record not found";
}
$conn->close();
?>