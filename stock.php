<?php
// Database connection details
$host = "localhost"; 
$dbname = "blood_bank";
$user = "root"; 
$password = "omkar"; // Adjust your password if needed

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get available blood groups and their count
$query = "SELECT blood_group, COUNT(*) AS count FROM donors GROUP BY blood_group ORDER BY blood_group";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Availability</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background: url('sstock.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            padding: 30px;
            background: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            color: #d50000;
            font-size: 32px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        th {
            background-color: #d50000;
            color: white;
        }

        .no-data {
            font-size: 20px;
            color: #555;
            margin-top: 20px;
        }

        .home-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #d50000;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .home-button:hover {
            background: #b00000;
        }
    </style>
</head>
<body>

    <div class="overlay">
        <div class="container">
            <h2>Available Blood Groups</h2>

            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Blood Group</th>
                        <th>Available Units</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($row['count']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p class="no-data">No blood available at the moment.</p>
            <?php endif; ?>

            <a href="index.html" class="home-button">🏠 Home</a>

            <?php $conn->close(); ?>
        </div>
    </div>

</body>
</html>
