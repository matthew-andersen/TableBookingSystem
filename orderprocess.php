<?php

$q = $_GET['q'];

$con = mysqli_connect('localhost', 'root', '');

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con, "booking_system");

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