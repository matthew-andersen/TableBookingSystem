<?php
session_start();

if (isset($_SESSION['current_userid'])) {
    // This session already exists, should already contain data
    echo "User ID:", $_SESSION['current_userid'], "<br />";
}
//    } else {
//    // New PHP Session / Should Only Be Run Once/Rarely/Login/Logout
//    $_SESSION['username'] = "yourloginprocesshere";
//    $_SESSION['id'] = 444;
//}
?>