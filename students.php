<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="stdstyle.css">
</head>
<body>
    <div class="container">
        <h1>Student List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "student_list";

                $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }
            


                    // SQL query to fetch students
                    $sql = "SELECT id, name, email, phone, address, created_at FROM students";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No students found</td></tr>";
                    }


                ?>
            </tbody>
        </table>
    </div>

    <script src="std.js"></script>
</body>
</html>
