<?php
// Database connection details
$host = "localhost";
$dbname = "blood_bank";
$user = "root"; // Change to your MySQL username
$password = "omkar"; // Change to your MySQL password

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get recipient details from form
$name = $_POST['name'];
$age = (int) $_POST['age'];
$blood_group = $_POST['blood-group'];
$contact = $_POST['contact'];
$hospital = $_POST['hospital'];
$address = $_POST['address'];

// Validate age
if ($age < 18) {
    echo "<script>alert('You must be at least 18 years old to request blood!'); window.history.back();</script>";
    exit();
}

// Validate contact number (10-digit)
if (!preg_match('/^\d{10}$/', $contact)) {
    echo "<script>alert('Invalid contact number!'); window.history.back();</script>";
    exit();
}

// Check if blood is available in donors table
$check_stmt = $conn->prepare("SELECT id, name, contact FROM donors WHERE blood_group = ? LIMIT 1");
$check_stmt->bind_param("s", $blood_group);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $donor = $check_result->fetch_assoc();
    $donor_id = $donor['id'];
    $donor_name = $donor['name'];
    $donor_contact = $donor['contact'];

    // Insert recipient details into recipients table
    $insert_stmt = $conn->prepare("INSERT INTO recipients (name, age, blood_group, contact, hospital, address, assigned_donor_name, assigned_donor_contact) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("sissssss", $name, $age, $blood_group, $contact, $hospital, $address, $donor_name, $donor_contact);

    if ($insert_stmt->execute()) {
        // Delete assigned donor from donors table
        $delete_stmt = $conn->prepare("DELETE FROM donors WHERE id = ?");
        $delete_stmt->bind_param("i", $donor_id);
        $delete_stmt->execute();

        echo "<script>alert('Blood request successful! Donor assigned: $donor_name'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Failed to register recipient! Try again.'); window.history.back();</script>";
    }

    $insert_stmt->close();
    $delete_stmt->close();
} else {
    echo "<script>alert('Sorry! Blood group not available!'); window.location.href='index.html';</script>";
}

$check_stmt->close();
$conn->close();
?>
