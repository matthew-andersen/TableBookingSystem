<?php

$q = intval($_GET['q']);

$con = mysqli_connect('localhost', 'root', '');

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"booking_system");

$sql="SELECT * FROM workspace";

$result = mysqli_query($con,$sql);

$to_append = "";
while($row = mysqli_fetch_array($result)) {
    $to_append .= $row['room_id'] . "," . $row['available'] . ",";
//        array(['room_id'], 1);
}

$to_append = rtrim($to_append, ",");

echo $to_append;

//echo $to_append;

mysqli_close($con);
?>