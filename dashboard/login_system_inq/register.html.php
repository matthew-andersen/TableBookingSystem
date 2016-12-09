<?php

$valid = true;
//set the error messages to nothing til set
$fullnameErr = $usernameErr = $emailErr = $passwordErr = "";
$fullname = $username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//check the user inputs if empty or invalid
    if (empty($_POST['fullname'])) {
        $fullnameErr = "Name cannot be empty";
        $valid = false;
    }
    else {
        $fullname = check_input($_POST['fullname']);
        if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
            $nameErr = "Only letters and white space allowed";
            $valid = false;
        }
        if (empty($_POST['username'])) {
            $usernameErr = "Username cannot be empty";
            $valid = false;
        } else {
            $username = check_input($_POST['username']);
        }
        if (empty($_POST['email'])) {
            $emailErr = "Email cannot be empty";
            $valid = false;
        } else {
            $email = check_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $valid = false;
            }
            if (empty($_POST['password'])) {
                $passwordErr = "Password cannot be empty";
                $valid = false;
            } else {
                $password = check_input($_POST['password']);
            }

        }
    }
    $servername = "localhost";
    $db_username = "root";
    $db_password = "newpassword";
    $dbname = "inq_dashboard";

// Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($valid){
        $password = md5($_POST['password']);
        $sql = "INSERT INTO user (`name`, `username`, `email`, `password`) VALUES ('$fullname', '$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        header('Location: login.html.php');
        exit();
    }
}



function check_input($data){
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<?php
date_default_timezone_set("Australia/Brisbane");
echo "The time is " . date("h:i:sa");
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <label for="fullname">Full name:</label>
    <input id="fullname" type="text" name="fullname" value="<?php echo $fullname ?>"><span class="errorMsg">* <?php echo $fullnameErr;?></span><br>

    <label for="username">User name:</label>
    <input id="username" type="text" value="<?php echo $username ?>" name="username"><span class="errorMsg">* <?php echo $usernameErr;?></span><br>

    <label for="email">Email:</label>
    <input id="email" type="email" value="<?php echo $email ?>" name="email"><span class="errorMsg">* <?php echo $emailErr;?></span><br>

    <label for="password">Password:</label>
    <input id="password" type="password" name="password"><span class="errorMsg">* <?php echo $passwordErr;?></span><br>

    <input type="submit" name="submit">
</form>

</body>
</html>