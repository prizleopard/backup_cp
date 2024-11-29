<?php
$servername = "localhost"; // or your server address
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "game_sched"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT * FROM schedules WHERE id ='$id'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $t1 = $row['team_a'];
    $t2 = $row['team_b'];
    $ven = $row['venue'];
    $sports = $row['sport'];
    $ms = $row['match_date'];
    $date = new DateTime($ms);
    $formattedDate = $date->format('M j, Y g:i A'); // Formats as "Nov 1, 2024 1:41 PM"

    $md =  $formattedDate;

    $c='';
    $servername1 = "localhost"; // or your server address
    $username1 = "root"; // replace with your database username
    $password1 = ""; // replace with your database password
    $dbname1 = "organizers"; // your database name
    $conn1 = new mysqli($servername1, $username1, $password1, $dbname1);

    $sql = "SELECT * FROM  organizers WHERE school_id  ='$t1'";
    $result = mysqli_query($conn1,$sql);
    $row = mysqli_fetch_assoc($result);
    $c1 = $row['contact'];

    $sql = "SELECT * FROM  organizers WHERE school_id  ='$t2'";
    $result = mysqli_query($conn1,$sql);
    $row = mysqli_fetch_assoc($result);
    $c2 =  $row['contact'];

    $servername11 = "localhost"; // or your server address
    $username11 = "root"; // replace with your database username
    $password11 = ""; // replace with your database password
    $dbname11 = "venues"; // your database name
    $conn11 = new mysqli($servername11, $username11, $password11, $dbname11);

    $t1sql = "SELECT * FROM venues WHERE id = '$t1'";
    $t1result = mysqli_query($conn11,$t1sql);
    $t1row = mysqli_fetch_assoc($t1result);
    $name1 = $t1row['name'];

    $t1sql = "SELECT * FROM venues WHERE id = '$t2'";
    $t1result = mysqli_query($conn11,$t1sql);
    $t1row = mysqli_fetch_assoc($t1result);
    $name2 = $t1row['name'];

    $t1sql = "SELECT * FROM venues WHERE id = '$ven'";
    $t1result = mysqli_query($conn11,$t1sql);
    $t1row = mysqli_fetch_assoc($t1result);
    $ven1 = $t1row['name'];

    $smsBody = "We want to inform you that your school has a " . $sports . " game schedule!\n" . 
    "$name1 vs $name2. The venue is $ven1. Match date is $md";






    $ch = curl_init();
    $parameters = array(
        'apikey' => '0f95574de5d22ac18e50ef1b38f0b539', //Your API KEY
        'number' => $c1,
        'message' => $smsBody,
        'sendername' => 'TRIPLEJ'
    );
    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/priority' );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    
    //Send the parameters set above with the request
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
    
    // Receive response from server
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);
    //Show the server response
    echo $output;
    
    $ch = curl_init();
    $parameters = array(
        'apikey' => '0f95574de5d22ac18e50ef1b38f0b539', //Your API KEY
        'number' => $c2,
        'message' => $smsBody,
        'sendername' => 'TRIPLEJ'
    );
    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/priority' );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    
    //Send the parameters set above with the request
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
    
    // Receive response from server
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);
    
    //Show the server response
    echo $output;

}
?>
