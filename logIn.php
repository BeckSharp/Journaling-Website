<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $successCodes = $_GET["successCodes"] ?? "";
    $successMessages = renderSuccessMessageCodes($successCodes);

    $errorCodes = $_GET["errorCodes"] ?? "";
    $errorMessages = renderErrorMessageCodes($errorCodes);

    $form = renderFormLogIn();

    $content = <<<PAGE
{$successMessages}
{$errorMessages}
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
if (!appProfileRegisteredCheck()) { appRedirect("signUp.php"); }

session_start();
if (appSessionIsSet()) { appRedirect("index.php"); }

$pagetitle = "Log In";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();