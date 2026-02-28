<?php
$conn = new mysqli("localhost", "root", "", "hims");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$sql = "ALTER TABLE iop_diagnosis MODIFY COLUMN iop_id VARCHAR(50)";
if ($conn->query($sql) === TRUE) { echo "Table iop_diagnosis updated successfully"; } else { echo "Error updating table: " . $conn->error; }

$conn->close();
?>