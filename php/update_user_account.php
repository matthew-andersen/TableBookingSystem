<?php
/**
 * Created by PhpStorm.
 * User: Draga
 * Date: 8/12/2016
 * Time: 11:56 AM
 */
// LOCAL WAMP HOST
$HOST = 'localhost';
$USER = 'root';
$PASS = '';
$DB = 'inq_dashboard';

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

$q = $_REQUEST['q'];
$q = json_decode($q);

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
//for($i = 0; $q.length)

$user_id = $q[0];
$num_days = $q[1];
$num_desk_hours = $q[2];
$num_room_hours = $q[3];

$sql = "UPDATE `user` SET `num_days`='$num_days',`num_desk_hours`='$num_desk_hours',`num_room_hours`='$num_room_hours' WHERE `id`='$user_id'";

//$sql = "INSERT INTO `booking_record_table`(`booking_id`, `date_created`, `user_id`, `num_days`, `num_desk_hours`, `num_room_hours`, `start_datetime`, `end_datetime`, `location_id`) VALUES ('5','1','1','1', '1', '1', '1', 'HERE','1')";
//$sql = "INSERT INTO `booking_record_table`(`booking_id`, `date_created`, `user_id`, `num_days`, `num_desk_hours`, `num_room_hours`, `start_datetime`, `end_datetime`, `location_id`) VALUES ('$booking_id','$date_created','$user_id','$num_days', '$num_desk_hours', '$num_room_hours', '$start_datetime', '$end_datetime','$location_id')";


// Actually querying the database
mysqli_query($con, $sql);

mysqli_close($con);
?>
?>