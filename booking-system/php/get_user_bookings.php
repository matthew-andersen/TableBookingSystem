<?php
/**
 * Created by PhpStorm.
 * User: Draga
 * Date: 9/12/2016
 * Time: 3:13 PM
 */
session_start();

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
$user_id = $_SESSION['current_userid'];

$connection = new mysqli($HOST, $USER, $PASS, $DB);

$sql = "SELECT * FROM `booking_record_table` WHERE `user_id`=$user_id";
$queryResult = $connection -> query($sql);

$bookingString = "";
//while there are still rows in the table
while($row = $queryResult->fetch_assoc()){
    //echo "\nRoom_i,1,2016-12-03 14:00:00,2016-12-04 14:00:00"
//    echo $row['location_id'];
    $bookingString = $bookingString . '|' . $row['location_id'] . ',' . $row['start_datetime'] . ',' . $row['end_datetime'];
}

echo $bookingString;

?>