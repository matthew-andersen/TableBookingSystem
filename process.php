<?php

//$HOST = 'localhost';
//$USER = 'root';
//$PASS = '';

$HOST = 'sql6.freesqldatabase.com';
$USER = 'sql6147851';
$PASS = 'JKPbi1FfB7';
$DB = 'sql6147851';

$con = mysqli_connect($HOST, $USER, $PASS);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con, $DB);

$sql="SELECT * FROM workspace";

$result = mysqli_query($con,$sql);

$to_append = "";
while($row = mysqli_fetch_array($result)) {
    $to_append .= $row['room_id'] . "," . $row['available'] . ",";
}

$to_append = rtrim($to_append, ",");

echo $to_append;

mysqli_close($con);
?>