<?php

//$HOST = 'localhost';
//$USER = 'root';
//$PASS = '';

$HOST = 'sql6.freesqldatabase.com';
$USER = 'sql6147851';
$PASS = 'JKPbi1FfB7';
$DB = 'sql6147851';

$q = $_GET['q'];

$con = mysqli_connect($HOST, $USER, $PASS);

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con, $DB);

$sql = "UPDATE workspace SET available=0 WHERE room_id='$q'";

if (mysqli_query($con, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($con);
}

//for ($i = 0; $i <= count($q)+1; $i++) {
//    $sql="UPDATE workspace SET available=0 WHERE room_id='$q[$i]'";
//    if (mysqli_query($con, $sql)) {
//        echo "Record updated successfully";
//    } else {
//        echo "Error updating record: " . mysqli_error($con);
//    }
//}

mysqli_close($con);

?>