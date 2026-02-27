<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "lamot";
$database_name = "hms";

$conn = new mysqli($host, $username, $password, $database_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patient_no = '26020001';
$sql = "SELECT * FROM patient_personal_info WHERE patient_no = '$patient_no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Found: " . $row["firstname"] . " " . $row["lastname"] . "\n";
    }
} else {
    echo "0 results for $patient_no\n";
    // Try LIKE
    $sql = "SELECT * FROM patient_personal_info WHERE patient_no LIKE '%26020001%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
             echo "Found with LIKE: " . $row["patient_no"] . " - " . $row["firstname"] . "\n";
        }
    }
}
$conn->close();
?>