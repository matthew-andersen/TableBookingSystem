<?php
/**
 * Created by PhpStorm.
 * User: Draga
 * Date: 9/12/2016
 * Time: 2:42 PM
 */

session_start();


$redirect = "/inqtablebookingsystem/homePage.html";
if (isset($_SESSION['loggedIn'])){
    session_destroy();
    session_unset();

}
header('Location: '.$redirect);
?>