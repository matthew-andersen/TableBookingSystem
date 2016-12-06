<?php

// LOCAL WAMP HOST
$HOST = 'localhost';
$USER = 'root';
$PASS = '';
$DB = 'booking_system';

// WEBHOST000 REMOTE DATABASE
//$HOST = 'localhost';
//$USER = 'id241545_inqinterns';
//$PASS = 'goforth';
//$DB = 'id241545_booking_system';

// DODGY FREE REMOTE DATABASE
//$HOST = 'sql6.freesqldatabase.com';
//$USER = 'sql6147851';
//$PASS = 'JKPbi1FfB7';
//$DB = 'sql6147851';

// The item to be queried - which is the room id
$q = $_GET['q'];

// Used to initially connect to the database
$con = mysqli_connect($HOST, $USER, $PASS);

// If no connection can be found exit the current script and display an error message
// The error message never even shows, I think this line is pointless
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

// Actually querying the database
mysqli_select_db($con, $DB);

// The SQL query which updates the availability in the the database
$sql = "UPDATE workspace SET available=0 WHERE room_id='$q'";

// Actually querying the database
mysqli_query($con, $sql);

mysqli_close($con);