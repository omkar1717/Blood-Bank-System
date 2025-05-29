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

// Fetch donor data
$donor_query = "SELECT * FROM donors ORDER BY id DESC";
$donor_result = $conn->query($donor_query);

// Fetch recipient data
$recipient_query = "SELECT * FROM recipients ORDER BY id DESC";
$recipient_result = $conn->query($recipient_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Report</title>
    <style>
        /* [Same CSS as you provided] */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #d50000;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .container {
            max-width: 90%;
            margin: 80px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 18px;
            text-align: left;
        }
        th {
            background-color: #d50000;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-data {
            font-size: 20px;
            color: #555;
            margin-top: 20px;
            text-align: center;
        }
        .home-button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px;
            background: #d50000;
            color: white;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .home-button:hover {
            background: #b00000;
        }
    </style>
</head>
<body>

<div class="navbar">Blood Bank Report</div>

<div class="container">
    <!-- Donor Report -->
    <h2>Donor Report</h2>
    <div class="table-container">
        <?php if ($donor_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Contact</th>
                    <th>Address</th>
                </tr>
                <?php while ($row = $donor_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No donors available.</p>
        <?php endif; ?>
    </div>

    <!-- Recipient Report -->
    <h2>Recipient Report</h2>
    <div class="table-container">
        <?php if ($recipient_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Contact</th>
                    <th>Hospital</th>
                    <th>Address</th>
                    <th>Assigned Donor</th>
                    <th>Donor Contact</th>
                    <th>Request Date</th>
                </tr>
                <?php while ($row = $recipient_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        <td><?php echo htmlspecialchars($row['hospital']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['assigned_donor_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['assigned_donor_contact']); ?></td>
                        <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No recipients available.</p>
        <?php endif; ?>
    </div>

    <!-- Home Button -->
    <a href="index.html" class="home-button">🏠 Home</a>
</div>

<?php $conn->close(); ?>

</body>
</html>
