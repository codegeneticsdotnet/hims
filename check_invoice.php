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

$sql = "SELECT * FROM system_option WHERE cCode LIKE 'invoice_no%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "cCode: " . $row["cCode"]. " - cValue: " . $row["cValue"]. "\n";
    }
} else {
    echo "0 results";
}
$conn->close();
?>