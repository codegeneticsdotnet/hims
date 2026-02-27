<?php
$mysqli = new mysqli("localhost", "root", "", "hms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql1 = "CREATE TABLE IF NOT EXISTS pharmacy_sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY, 
    invoice_no VARCHAR(50), 
    date_sale DATETIME, 
    patient_no VARCHAR(50) DEFAULT NULL, 
    patient_name VARCHAR(100) DEFAULT NULL, 
    sub_total DECIMAL(10,2), 
    discount DECIMAL(10,2), 
    total_amount DECIMAL(10,2), 
    remarks TEXT, 
    payment_type VARCHAR(20) DEFAULT 'Cash',
    InActive INT DEFAULT 0
)";

$sql2 = "CREATE TABLE IF NOT EXISTS pharmacy_sales_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY, 
    sale_id INT, 
    drug_id INT, 
    item_name VARCHAR(255), 
    qty INT, 
    price DECIMAL(10,2), 
    total DECIMAL(10,2), 
    InActive INT DEFAULT 0
)";

$sql3 = "INSERT IGNORE INTO system_option (cCode, cValue, cDesc) VALUES ('pharmacy_invoice_no', '0', 'Pharmacy Invoice Number')";

if ($mysqli->query($sql1) === TRUE) {
    echo "Table pharmacy_sales created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error . "\n";
}

if ($mysqli->query($sql2) === TRUE) {
    echo "Table pharmacy_sales_details created successfully\n";
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