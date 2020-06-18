<?php
//INCLUDING API
include("api/api.inc.php");

if (appFormMethodIsPost() && appSessionIsSet()) {

} else {
    appRedirect("app_error.php");
}