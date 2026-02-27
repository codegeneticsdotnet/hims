<?php
$mysqli = new mysqli("localhost", "root", "", "hms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "DESCRIBE system_option";
$result = $mysqli->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . "\n";
    }
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>