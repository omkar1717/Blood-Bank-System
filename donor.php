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

// Get donor details from form
$name = $_POST['name'];
$age = (int) $_POST['age'];
$blood_group = $_POST['blood-group'];
$contact = $_POST['contact'];
$address = $_POST['address'];

// Validate age
if ($age <= 21) {
    echo "<script>alert('You must be older than 21 to register!'); window.history.back();</script>";
    exit();
}

// Validate contact number (10-digit)
if (!preg_match('/^\d{10}$/', $contact)) {
    echo "<script>alert('Invalid contact number!'); window.history.back();</script>";
    exit();
}

// Prepare and bind MySQL insert query
$stmt = $conn->prepare("INSERT INTO donors (name, age, blood_group, contact, address) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $name, $age, $blood_group, $contact, $address);

// Execute the query
if ($stmt->execute()) {
    echo "<script>alert('Donor registered successfully!'); window.location.href='index.html';</script>";
} else {
    echo "<script>alert('Registration failed!'); window.history.back();</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
