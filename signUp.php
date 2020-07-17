<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorCodes = $_GET["errorCodes"] ?? "";
    $errorMessages = renderErrorMessageCodes($errorCodes);

    $form = renderFormSignUp();

    $content = <<<PAGE
{$errorMessages}
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
if(appProfileRegisteredCheck()) { appRedirect("logIn.php"); }

session_start();
if (appSessionIsSet()) { appRedirect("index.php"); }

$pagetitle = "Sign Up";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();