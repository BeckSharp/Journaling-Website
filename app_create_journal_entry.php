<?php
//INCLUDING API
include("api/api.inc.php");

session_start();

if (appFormMethodIsPost() && appSessionIsSet()) {

} else {
    appRedirect("app_error.php");
}