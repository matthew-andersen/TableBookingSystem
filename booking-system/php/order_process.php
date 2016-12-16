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
$q = $_REQUEST['q'];
$q = json_decode($q);

//echo $q[0][1];

// Used to initially connect to the database
$con = mysqli_connect($HOST, $USER, $PASS);

// If no connection can be found exit the current script and display an error message
// The error message never even shows, I think this line is pointless
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con, $DB);


for ($i = 0; $i < count($q); $i++) {
    $date_created = $q[$i][0];
    $user_id = $q[$i][1];
    $num_days = $q[$i][2];
    $num_desk_hours = $q[$i][3];
    $num_room_hours = $q[$i][4];
    $start_datetime = $q[$i][5];
    $end_datetime = $q[$i][6];
    $location_id = $q[$i][7];

    $sql = "INSERT INTO `booking_record_table`(`date_created`, `user_id`, `num_days`, `num_desk_hours`, `num_room_hours`, `start_datetime`, `end_datetime`, `location_id`) VALUES ('$date_created','$user_id','$num_days', '$num_desk_hours', '$num_room_hours', '$start_datetime', '$end_datetime','$location_id')";

    // Actually querying the database
    mysqli_query($con, $sql);
}

mysqli_close($con);

?>