<?php
$error = false;
$errMSG = "";
$passError = "";
if (isset($_POST['submit'])){
    // prevent sql injections/ clear user invalid inputs
    $username = trim($_POST['username']);
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $password = trim($_POST['password']);
    $password = strip_tags($password);
    $password = htmlspecialchars($password);
}
if(empty($password)){
    $error = true;
    $passError = "Please enter your password.";
}

if (!$error){
    $password = md5($_POST['password']);
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


    $res=mysqli_query($conn,"SELECT id, username, password FROM user WHERE username='$username'");
    $row=mysqli_fetch_array($res);
    $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

    if( $count == 1 && $row['password']==$password ) {
//        $_SESSION['user'] = $row['userId'];
        header("Location: index.php");
    } else {
        $errMSG = "Incorrect Credentials, Try again...";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    <label for="username">User name:</label>
    <input id="username" type="text" name="username"><br>
    <label for="password">Password:</label>
    <input id="password" type="password" name="password"><span><?php echo $passError ?></span><br>
    <input type="submit" name="submit"><span><?php echo $errMSG ?></span><br>
</form>

</body>
</html>