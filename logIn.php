<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorData = $_GET["invalid"] ?? "";
    $signUpSuccess = $_GET["registered"] ?? "";
    $usernameChangedSuccess = $_GET["unameChanged"] ?? "";

    $errorMessages = createErrorMessages($errorData);
    $successMessages = createSuccessMessages($signUpSuccess, $usernameChangedSuccess);
    $form = renderFormLogIn($errorData, $signUpSuccess);

    $content = <<<PAGE
{$successMessages}
{$errorMessages}
{$form}
PAGE;
    return $content;
}

//FUNCTION TO RETURN HTML ERROR MESSAGES IF REQUIRED
function createErrorMessages($errorData) {
    if ($errorData != "true") { return ""; }
    return file_get_contents("data\static\logIn\log_in_error_data.html");
}

//FUNCTION TO RETURN HTML SUCCESS MESSAGES IF REQUIRED
function createSuccessMessages($signUpSuccess, $usernameChangedSuccess) {
    $messages = "";
    if ($signUpSuccess == "true") { $messages .= file_get_contents("data\static\signUp\sign_up_success.html"); }
    if ($usernameChangedSuccess == "true") { $messages .= file_get_contents("data\static\logIn\username_change_success.html"); }
    return $messages;
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