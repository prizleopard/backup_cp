<?php
// Check if edit form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_school'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location_link = $_POST['location_link'];

    // If a new image is uploaded, update the file path
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_update = "image = '$target_file',";
    } else {
        $image_update = "";  // No new image uploaded
    }

    // Update the school details
    $sql = "UPDATE sanluis_school 
            SET name = '$name', $image_update description = '$description', location_link = '$location_link' 
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "School updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
