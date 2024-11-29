<?php

$servername1 = "localhost"; // or your server address
$username1 = "root"; // replace with your database username
$password1 = ""; // replace with your database password
$dbname1 = "game_sched"; // your database name

// Create connection
$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);
if(isset($_POST['result'])) {
    $gameid = $_POST['gameid'];
    $winner = $_POST['winner'];
    $score = $_POST['score'];

    $sql = "UPDATE schedules SET winner = '$winner',score='$score'  WHERE id ='$gameid'";
    $res = mysqli_query($conn1,$sql);
    ?>
    <script>
        alert('success');
        window.location.href = 'trylang.php';   
    </script>
    <?php

}
?>