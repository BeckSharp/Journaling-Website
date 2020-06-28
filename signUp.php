<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorEmpty = $_GET["empty"] ?? "";
    $errorUnconfirmed = $_GET["unconfirmed"] ?? "";

    $errorMessages = createErrorMessages($errorEmpty, $errorUnconfirmed);
    $form = renderFormSignUp();

    $content = <<<PAGE
{$errorMessages}
{$form}
PAGE;
    return $content;
}

//FUNCTION TO RETURN HTML ERROR MESSAGES IF REQUIRED
function createErrorMessages($errorEmpty, $errorUnconfirmed) {
    $messages = "";
    if ($errorEmpty == "true") { $messages .= file_get_contents("data\static\signUp\sign_up_error_empty.html"); }
    if ($errorUnconfirmed == "true") { $messages .= file_get_contents("data\static\signUp\sign_up_error_unconfirmed.html"); }
    return $messages;
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