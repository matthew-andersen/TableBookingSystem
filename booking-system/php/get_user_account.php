<?php

// LOCAL WAMP HOST
$HOST = 'localhost';
$USER = 'root';
$PASS = '';
$DB = 'inq_dashboard';

// WEBHOST000 REMOTE DATABASE
//$HOST = 'localhost';
//$USER = 'id241545_inq_dashboard';
//$PASS = 'goforth';
//$DB = 'id241545_inq_dashboard';

$connection = new mysqli($HOST, $USER, $PASS,$DB);

if ($connection -> connect_error){
    die("Connection failed");
}

//get room id and availability of each row from the room_table
$sqlQuery = "SELECT `id`, `num_days`, `num_desk_hours`, `num_room_hours` FROM `user` WHERE `id` = 1";

//query the database using the query defined above
$queryResult = $connection->query($sqlQuery);

$userAccountString = "";
//while there are still rows in the table
while($row = $queryResult->fetch_assoc()){
    $userAccountString = $userAccountString . $row['id'] . ',' . $row['num_days'] . ',' . $row['num_desk_hours'] . ',' . $row['num_room_hours'];
}

echo $userAccountString;
?>