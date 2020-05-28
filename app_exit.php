<?php
//INCLUDING API
include("api/api.inc.php");

//RETRIEVING DATA FROM URL
$action = $_GET["action"] ?? "";

//RETRIEVING CURRENT SESSION
session_start();

if (appSessionIsSet() && $action == "exit") {
    //DESTROYING THE CURRENT SESSION
    appSessionDestroy();
    //REDIRECTING USER AFTER LOGGING OUT
    appRedirect("logIn.php");
} else {
    //REDIRECTING USER TO ERROR PAGE
    appRedirect("app_error.php");
}
?>