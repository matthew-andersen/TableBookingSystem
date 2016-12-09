<?php
/**
 * Created by PhpStorm.
 * User: login_system_inq
 * Date: 25/11/2016
 * Time: 4:01 PM
 */

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "inq_dashboard";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// define variables and set to empty values
$nameErr = $emailErr = $usernameErr = $passwordErr = "";
$name = $email = $username = $password = "";
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $error = true;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
            $error = true;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $error = true;
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $error = true;
        }
    }

    if (empty($_POST["username"])) {
        $username = "";
        $error = true;
    } else {
        $username = test_input($_POST["username"]);
        }
    }

    if (empty($_POST["password"])) {
        $password = "";
        $error = true;
    } else {
        $password = test_input($_POST["password"]);

} if ($error){
    echo "Didn't create a user";
} else{
    $sql = "INSERT INTO user (`name`, `username`, `email`, `password`, `num_days`, `num_desk_hours`, `num_room_hours`) VALUES ('$name', '$username', '$email', '$password', 0, 10, 4)";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



