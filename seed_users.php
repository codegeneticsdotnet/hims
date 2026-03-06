<?php
// Seed Script for Creating Users
// Run this via CLI or create a controller method

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'lamot';
$db_name = 'hms';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User Data to Seed
$users = [
    [
        'user_id' => 'NURSE001',
        'role_name' => 'Nurse Roles',
        'firstname' => 'Nurse',
        'lastname' => 'User',
        'username' => 'nurse',
        'dept_name' => '- IPD -', // Or OPD
        'designation' => 'Nurse'
    ],
    [
        'user_id' => 'LAB001',
        'role_name' => 'Laboratory',
        'firstname' => 'Lab',
        'lastname' => 'User',
        'username' => 'laboratory',
        'dept_name' => 'LABORATORY',
        'designation' => 'Pathologist'
    ],
    [
        'user_id' => 'DOC001',
        'role_name' => 'Doctor',
        'firstname' => 'Doctor',
        'lastname' => 'User',
        'username' => 'doctor',
        'dept_name' => '- OPD -',
        'designation' => 'Doctor'
    ],
    [
        'user_id' => 'CLINIC001',
        'role_name' => 'Clinic',
        'firstname' => 'Clinic',
        'lastname' => 'User',
        'username' => 'clinic',
        'dept_name' => '- OPD -',
        'designation' => 'Receptionist' // Assuming Clinic is like Reception/OPD
    ],
    [
        'user_id' => 'PHARM001',
        'role_name' => 'Pharmacy',
        'firstname' => 'Pharmacist',
        'lastname' => 'User',
        'username' => 'pharmacist',
        'dept_name' => 'BILLING', // Often pharmacy is linked to billing or separate dept if exists. Assuming Billing for now or create Pharmacy Dept
        'designation' => 'Pharmacist'
    ]
];

$password = md5('passw0rld');

foreach ($users as $user) {
    // 1. Get Role ID
    $role_sql = "SELECT role_id FROM user_roles WHERE role_name = '" . $user['role_name'] . "'";
    $role_result = $conn->query($role_sql);
    if ($role_result->num_rows > 0) {
        $role_id = $role_result->fetch_assoc()['role_id'];
    } else {
        echo "Role not found: " . $user['role_name'] . "\n";
        continue;
    }

    // 2. Get Department ID
    $dept_sql = "SELECT department_id FROM department WHERE dept_name = '" . $user['dept_name'] . "'";
    $dept_result = $conn->query($dept_sql);
    if ($dept_result->num_rows > 0) {
        $dept_id = $dept_result->fetch_assoc()['department_id'];
    } else {
        // Create Department if missing (e.g. Pharmacy)
        if($user['dept_name'] == 'PHARMACY'){ // Example
             // Insert logic here if needed
        }
        // Fallback to OPD or Billing
        $dept_id = 45; // OPD default
        echo "Department not found: " . $user['dept_name'] . ", using default.\n";
    }

    // 3. Get Designation ID
    $desig_sql = "SELECT designation_id FROM designation WHERE designation = '" . $user['designation'] . "'";
    $desig_result = $conn->query($desig_sql);
    if ($desig_result->num_rows > 0) {
        $desig_id = $desig_result->fetch_assoc()['designation_id'];
    } else {
        echo "Designation not found: " . $user['designation'] . "\n";
        continue;
    }

    // 4. Insert User
    // Check if user exists
    $check_sql = "SELECT username FROM users WHERE username = '" . $user['username'] . "'";
    if ($conn->query($check_sql)->num_rows == 0) {
        $sql = "INSERT INTO users (
            user_id, department, designation, user_role, 
            lastname, firstname, username, password, 
            email_address, InActive,
            cType, title, middlename, age, street, subd_brgy, province, phone_no, mobile_no, gender, civil_status, birthday, birthplace
        ) VALUES (
            '" . $user['user_id'] . "', 
            '$dept_id', 
            '$desig_id', 
            '$role_id', 
            '" . $user['lastname'] . "', 
            '" . $user['firstname'] . "', 
            '" . $user['username'] . "', 
            '$password', 
            '" . $user['username'] . "@hims.com', 
            0,
            'user', 1, '', 30, 'Street', 'Brgy', 'Province', '1234567', '09123456789', 1, 1, '1990-01-01', 'City'
        )";

        if ($conn->query($sql) === TRUE) {
            echo "Created user: " . $user['username'] . "\n";
        } else {
            echo "Error creating user " . $user['username'] . ": " . $conn->error . "\n";
        }
    } else {
        echo "User already exists: " . $user['username'] . "\n";
        // Optionally update password
        $update_sql = "UPDATE users SET password = '$password' WHERE username = '" . $user['username'] . "'";
        $conn->query($update_sql);
    }
}

$conn->close();
?>