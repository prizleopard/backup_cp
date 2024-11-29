<?php
// Database connection
$servername = "localhost"; // Change if needed
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "result"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch sports results
$sql = "SELECT * FROM sports_results";
$result = $conn->query($sql);

// HTML and CSS styling
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            color: #007BFF; /* University of Batangas Blue */
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007BFF; /* University of Batangas Blue */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd; /* Light gray on hover */
        }

        .edit-button {
            background-color: #28a745; /* Green for Edit */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .delete-button {
            background-color: #dc3545; /* Red for Delete */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .edit-button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .delete-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>';

echo '<div class="container">'; // Main container

if ($result->num_rows > 0) {
    echo "<h2>Sports Results</h2>";
    echo "<table><tr><th>Date</th><th>Sport</th><th>Team A</th><th>Score A</th><th>Team B</th><th>Score B</th><th>Status</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['game_date']}</td>
                <td>{$row['sport']}</td>
                <td>{$row['team_a']}</td>
                <td>{$row['score_a']}</td>
                <td>{$row['team_b']}</td>
                <td>{$row['score_b']}</td>
                <td>{$row['status']}</td>
                <td>
                    <form method='POST' action='editresult.php' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' name='edit_result' class='edit-button'>Edit</button>
                    </form>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' name='delete_result' class='delete-button' onclick=\"return confirm('Are you sure you want to delete this result?');\">Delete</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>No results found.</p>";
}

$conn->close();

echo '</div>'; // Close main container
echo '</body>
</html>';
?>
