<?php
session_start();

// LOCAL WAMP HOST
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "inq_dashboard";

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

if (isset($_POST["username"], $_POST["password"])) {
    $name = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT `id`, `username`, `name`, `password` FROM `user` WHERE `username` = '$name'";
    $result1 = $connection->query($sql);

    $USER = "";
    $PASS = "";
    $user_id = "";

    while ($row = $result1->fetch_assoc()) {
        $USER = $row['username'];
        $PASS = $row['password'];
        $user_id = $row['id'];
        $user_name = $row['name'];
    }

    if ($name == $USER && $password == $PASS) {
        $_SESSION['current_userid']= $user_id;
        $_SESSION['current_username'] = $USER;
        $_SESSION['user_name'] = $user_name;
        echo "Welcome " . $_SESSION['user_name'] . "!";
    } else {
        echo "No match.";
    }
}
?>