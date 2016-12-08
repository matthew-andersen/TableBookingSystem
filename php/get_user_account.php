<?php

$HOST = 'localhost';
$USER = 'root';
$PASS = '';

$DB = 'booking_system';

$connection = new mysqli($HOST, $USER, $PASS,$DB);

if ($connection -> connect_error){
    die("Connection failed");
}

//get room id and availability of each row from the room_table
$sqlQuery = "SELECT user_id, num_days, num_desk_hours, num_room_hours FROM user_account_table WHERE user_id = 1";

//query the database using the query defined above
$queryResult = $connection->query($sqlQuery);

$userAccountString = "";
//while there are still rows in the table
while($row = $queryResult->fetch_assoc()){
    $userAccountString = $userAccountString . $row['user_id'] . ',' . $row['num_days'] . ',' . $row['num_desk_hours'] . ',' . $row['num_room_hours'];
}

echo $userAccountString;
?>