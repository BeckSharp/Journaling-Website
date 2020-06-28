<?php
//INCLUDING API
include("api/api.inc.php");

//BUSINESS LOGIC
$pagetitle = "Error Page";
$pagecontent = file_get_contents("data\static\app\app_error_message.html");

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();
?>