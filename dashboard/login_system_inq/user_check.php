<?php
/**
 * Created by PhpStorm.
 * User: dashboard
 * Date: 5/12/2016
 * Time: 6:39 PM
 */

$fullnameErr = $usernameErr = $emailErr = $passwordErr = "";
$fullname = $username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['fullname'])){
        $fullnameErr = "Name cannot be empty";
    }
    else {
        $fullname = check_input($_POST['fullname']);
    }
    if (empty($_POST['username'])){
        $usernameErr = "Username cannot be empty";
    }
    else {
        $username = check_input($_POST['username']);
    }
    if (empty($_POST['email'])){
        $emailErr = "Email cannot be empty";
    }
    else{
        $email = check_input($_POST['email']);
    }
    if (empty($_POST['password'])){
        $passwordErr = "Password cannot be empty";
    }
    else {
        $password = check_input($_POST['password']);
    }

}

function check_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}