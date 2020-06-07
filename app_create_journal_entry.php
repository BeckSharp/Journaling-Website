<?php
//INCLUDING API
include("api/api.inc.php");

if (appFormMethodIsPost()) {

} else {
    appRedirect("app_error.php");
}