<?php
session_start();

/**
 * Created by PhpStorm.
 * User: login_system_inq
 * Date: 29/11/2016
 * Time: 2:55 PM
 */
//include "login.html.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inq_dashboard";


$connection = new mysqli($servername, $username, $password);
$connection->select_db($dbname);

//if (!isset($_REQUEST['name'])) {
//    include '../../website/register/register.html.php';
//}

if (isset($_POST["username"], $_POST["password"])) {
    $name = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT `id`, `username`, `name`, `password` FROM `user` WHERE `username` = '$name'";
    $result1 = $connection->query($sql);

    $db_username = "";
    $db_password = "";
    $user_id = "";

    while ($row = $result1->fetch_assoc()) {
        $db_username = $row['username'];
        $db_password = $row['password'];
        $user_id = $row['id'];
        $user_name = $row['name'];
    }

    if ($name == $db_username && $password == $db_password) {
        $_SESSION['current_userid']= $user_id;
        $_SESSION['current_username'] = $db_username;
        $_SESSION['user_name'] = $user_name;
        echo "Welcome " . $_SESSION['user_name'] . "!";
    } else {
        echo "No match.";
    }
}
?>