<?php
$servername1 = "localhost"; // or your server address
$username1 = "root"; // replace with your database username
$password1 = ""; // replace with your database password
$dbname1 = "game_sched"; // your database name

// Create connection
$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);
                
$gameid = $_GET['id'];
$sql = "SELECT * FROM schedules WHERE ID = '$gameid'";
$res = mysqli_query($conn1,$sql);
$row = mysqli_fetch_assoc($res);
$temA = $row['team_a'];
$temb = $row['team_b'];

$servername = "localhost"; // or your server address
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "venues"; // your database name

// Create connection
$conn = new mysqli($servername1, $username1, $password1, $dbname);

$school = "SELECT * FROM venues WHERE id = '$temA'";
$scres = mysqli_query($conn,$school);
$srow = mysqli_fetch_assoc($scres);
$cA = $srow['name'];

$school = "SELECT * FROM  venues WHERE id = '$temb'";
$scres = mysqli_query($conn,$school);
$srow = mysqli_fetch_assoc($scres);
$cb = $srow['name'];
                


?>
<form action="resssss.php" method="post">
<input type="hidden" name="gameid" value="<?=$gameid?>">
<label for="">Select Winner</label>
<select name="winner" id="winner">
<option value="">Please Select</option>
<option value="<?=$cA?>"><?=$cA?></option>
<option value="<?=$cb?>"><?=$cb?></option>
</select>
<label for="score">Enter a Score</label>
<input type="text" name="score">
<button type="submit" name="result">Update</button>
</form>