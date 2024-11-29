<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_result'])) {
    $match_id = $_POST['match_id'];
    $team_a_score = $_POST['team_a_score'];
    $team_b_score = $_POST['team_b_score'];

    // Update match results in the database
    $stmt = $conn->prepare("UPDATE tbl_matches SET team_a_score = ?, team_b_score = ?, status = 'completed' WHERE id = ?");
    $stmt->bind_param("iii", $team_a_score, $team_b_score, $match_id);

    if ($stmt->execute()) {
        echo "<p>Results have been successfully updated!</p>";
    } else {
        echo "<p>Error updating the results: " . $conn->error . "</p>";
    }
}
// Determine the winner
$winner = ($team_a_score > $team_b_score) ? $row['team_a'] : $row['team_b'];

// Update the winner
$stmt = $conn->prepare("UPDATE tbl_matches SET team_a_score = ?, team_b_score = ?, winner = ?, status = 'completed' WHERE id = ?");
$stmt->bind_param("sssi", $team_a_score, $team_b_score, $winner, $match_id);

?>
