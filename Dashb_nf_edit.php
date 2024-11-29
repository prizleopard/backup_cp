<?php
$servername = "localhost"; // Change this if necessary
$username = "root"; // Change this if necessary
$password = ""; // Change this if necessary
$dbname = "news_feed"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $media = $_FILES['media']['name'];

    // If a new file is uploaded, move it to the uploads directory
    if (!empty($media)) {
        move_uploaded_file($_FILES['media']['tmp_name'], "C:\\mine\\htdocs\\system\\uploads\\" . $media);
        $sql = "UPDATE news_feed SET title='$title', content='$content', media='$media' WHERE id=$id";
    } else {
        $sql = "UPDATE news_feed SET title='$title', content='$content' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully'); window.location.href='Dashb_news_feed.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch the record to edit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM news_feed WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the form */
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type="text"],
        textarea,
        input[type="file"],
        button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="text"],
        textarea {
            width: 100%;
        }

        textarea {
            resize: vertical;
            height: 150px;
        }

        button {
            background-color: #3a506b;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #728197;
        }

        a {
            text-align: center;
            display: block;
            text-decoration: none;
            color: #3a506b;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Edit Post</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required placeholder="Enter Title">
            <textarea name="content" required placeholder="Enter Content"><?php echo htmlspecialchars($row['content']); ?></textarea>
            <input type="file" name="media">
            <button type="submit">Update</button>
        </form>
        <a href="Dashb_news_feed.php">Cancel</a>
    </div>

    <?php $conn->close(); ?>

</body>
</html>
