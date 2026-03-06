<?php
$conn = new mysqli('localhost', 'root', 'lamot', 'hms');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add branch_name
$sql = "SHOW COLUMNS FROM company_branch LIKE 'branch_name'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE company_branch ADD COLUMN branch_name VARCHAR(255) AFTER company_name";
    if ($conn->query($sql) === TRUE) {
        echo "Column branch_name added successfully\n";
        // Update branch_name with company_name initially
        $conn->query("UPDATE company_branch SET branch_name = company_name");
    } else {
        echo "Error adding branch_name: " . $conn->error . "\n";
    }
}

// Add branch_color
$sql = "SHOW COLUMNS FROM company_branch LIKE 'branch_color'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE company_branch ADD COLUMN branch_color VARCHAR(50) DEFAULT 'skin-blue' AFTER branch_name";
    if ($conn->query($sql) === TRUE) {
        echo "Column branch_color added successfully\n";
    } else {
        echo "Error adding branch_color: " . $conn->error . "\n";
    }
}

$conn->close();
?>