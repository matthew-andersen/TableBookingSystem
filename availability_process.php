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

// Used to initially connect to the database
$con = mysqli_connect($HOST, $USER, $PASS);

// If no connection can be found exit the current script and display an error message
// The error message never even shows, I think this line is pointless
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

// Used to select the appropriate database from the server
mysqli_select_db($con, $DB);

// The SQL query which just selects everything from the database
$sql="SELECT * FROM workspace";

// Actually querying the database
$result = mysqli_query($con,$sql);

// An empty string which all info will be appended to
$to_append = "";

// While there are still rows append their columns to the string
while($row = mysqli_fetch_array($result)) {
    $to_append .= $row['room_id'] . "," . $row['available'] . ",";
}

// Simply removes the final comma from the string
$to_append = rtrim($to_append, ",");

// Returns the string back to the file that called it, ready to be turned into a list for displaying availability
echo $to_append;

mysqli_close($con);
