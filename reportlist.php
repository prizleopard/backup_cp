<?php
// Display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "list"; // Replace 'list' with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get filter inputs
$sy = isset($_POST['sy']) ? $_POST['sy'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$sports = isset($_POST['sports']) ? $_POST['sports'] : '';

// Initialize query and parameters array
$query = "SELECT * FROM students WHERE 1";
$params = [];
$types = "";

// Dynamically build query based on filters
if (!empty($sy)) {
    $query .= " AND sy = ?";
    $params[] = $sy;
    $types .= "s";
}
if (!empty($gender)) {
    $query .= " AND gender = ?";
    $params[] = $gender;
    $types .= "s";
}
if (!empty($sports)) {
    $query .= " AND sports = ?";
    $params[] = $sports;
    $types .= "s";
}

// Prepare the SQL statement
$stmt = $conn->prepare($query);

if ($params) {
    $stmt->bind_param($types, ...$params); // Bind the parameters
}

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Print the query to check (optional)
echo "Query: " . htmlspecialchars($query) . "<br>";
echo "Number of rows: " . $result->num_rows . "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Report Results</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Report Results</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>School Year</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Sports</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['fname']); ?></td>
                            <td><?= htmlspecialchars($row['lname']); ?></td>
                            <td><?= htmlspecialchars($row['sy']); ?></td>
                            <td><?= htmlspecialchars($row['gender']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['contact']); ?></td>
                            <td><?= htmlspecialchars($row['sports']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No results found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the connection
$stmt->close();
$conn->close();
?>
