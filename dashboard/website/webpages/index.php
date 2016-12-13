<?php
session_start();


// LOCAL WAMP HOST
$HOST = "localhost";
$USER = "root";
$PASS = "";
$DB = "inq_dashboard";

// WEBHOST000 REMOTE DATABASE
//$HOST = 'localhost';
//$USER = 'id241545_inq_dashboard';
//$PASS = 'goforth';
//$DB = 'id241545_inq_dashboard';

$connection = new mysqli($HOST, $USER, $PASS);
$connection->select_db($DB);

//if (!isset($_REQUEST['name'])) {
//    include '../../website/register/register.html.php';
//}

if (isset($_POST["username"], $_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
    $name = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT `id`, `username`, `name`, `password`, `num_days`, `num_desk_hours`, `num_room_hours` FROM `user` WHERE `username` = '$name'";
    $result1 = $connection->query($sql);

    $db_username = "";
    $db_password = "";
    $db_user_id = "";
    $db_user_name = "";

    $db_num_days = "";
    $db_num_desk_hours = "";
    $db_num_room_hours = "";

    while ($row = $result1->fetch_assoc()) {
        $db_username = $row['username'];
        $db_password = $row['password'];
        $db_user_id = $row['id'];
        $db_user_name = $row['name'];

        $db_num_days = $row['num_days'];
        $db_num_desk_hours = $row['num_desk_hours'];
        $db_num_room_hours = $row['num_room_hours'];
    }

    if ($name == $db_username && $password == $db_password) {
        $_SESSION['current_userid']= $db_user_id;
        $_SESSION['current_username'] = $db_username;
        $_SESSION['user_name'] = $db_user_name;

        $_SESSION['num_days'] = $db_num_days;
        $_SESSION['num_desk_hours'] = $db_num_desk_hours;
        $_SESSION['num_room_hours'] = $db_num_room_hours;

        $userHome = "../../../";
        header('Location: '.$userHome);
    } else {
        header('Location: login_reattempt.html');
    }
}
else {
    header('Location: login_reattempt.html');
}
?>