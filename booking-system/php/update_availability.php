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

$connection = new mysqli($HOST, $USER, $PASS,$DB);

if ($connection -> connect_error){
    die("Connection failed");
}

//get room id and availability of each row from the room_table

$sqlQuery = "SELECT location_id, start_datetime, end_datetime FROM booking_record_table";

//query the database using the query defined above
$queryResult = $connection->query($sqlQuery);

$availString = "";
//while there are still rows in the table
while($row = $queryResult->fetch_assoc()){
    //echo "\nRoom_i,1,2016-12-03 14:00:00,2016-12-04 14:00:00"
    $availString = $availString . $row['location_id'] . ',' . $row['start_datetime'] . ',' . $row['end_datetime'] . '|';
}
echo json_encode($availString);
?>