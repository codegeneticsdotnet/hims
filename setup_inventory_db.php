<?php
$mysqli = new mysqli("localhost", "root", "", "hms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql1 = "CREATE TABLE IF NOT EXISTS pharmacy_inventory_in (
    inv_id INT AUTO_INCREMENT PRIMARY KEY, 
    ref_no VARCHAR(50), 
    date_received DATETIME, 
    supplier_name VARCHAR(100) DEFAULT NULL, 
    remarks TEXT, 
    InActive INT DEFAULT 0
)";

$sql2 = "CREATE TABLE IF NOT EXISTS pharmacy_inventory_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY, 
    inv_id INT, 
    drug_id INT, 
    item_name VARCHAR(255), 
    qty INT, 
    batch_no VARCHAR(50), 
    expiry_date DATE, 
    InActive INT DEFAULT 0
)";

$sql3 = "INSERT IGNORE INTO system_option (cCode, cValue, cDesc) VALUES ('pharmacy_rr_no', '0', 'Pharmacy Receiving Report Number')";

if ($mysqli->query($sql1) === TRUE) {
    echo "Table pharmacy_inventory_in created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error . "\n";
}

if ($mysqli->query($sql2) === TRUE) {
    echo "Table pharmacy_inventory_details created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error . "\n";
}

if ($mysqli->query($sql3) === TRUE) {
    echo "System option inserted successfully\n";
} else {
    echo "Error inserting system option: " . $mysqli->error . "\n";
}

$mysqli->close();
?>