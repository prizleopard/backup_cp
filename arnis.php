<?php
// Connect to the database
$servername = "localhost"; // Change if necessary
$username = "root"; // Change to your DB username
$password = ""; // Change to your DB password
$dbname = "list";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get sport data
$sport = "Arnis";
$sql = "SELECT * FROM tbl_sports WHERE sport_name = '$sport' ORDER BY round";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sport; ?> Bracket</title>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    color: #007BFF;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.table th {
    background-color: #007BFF;
    color: white;
}

.table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #ddd;
}

</style>
<body>
    <h1><?php echo $sport; ?> Bracket</h1>

    <div class="bracket">
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        Round <?php echo $row['round']; ?>: <?php echo $row['team1']; ?> vs <?php echo $row['team2']; ?>
                        <?php if ($row['winner']): ?>
                            <strong>Winner: <?php echo $row['winner']; ?></strong>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No matches found for this sport.</p>
        <?php endif; ?>
    </div>

    <a href="index.php">Go Back</a>
</body>
</html>

<?php
$conn->close();
?>
