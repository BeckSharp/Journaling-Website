<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorPassword = $_GET["pwordInvalid"] ?? "";
    $errorConfirmation = $_GET["confirmationInvalid"] ?? "";
    $errorDate = $_GET["dateInvalid"] ?? "";
    $passwordSuccess = $_GET["pwordChanged"] ?? "";
    $dateSuccess = $_GET["dateRemoved"] ?? "";

    $successMessages = createSuccessMessages($passwordSuccess, $dateSuccess);
    $errorMessages = createErrorMessages($errorPassword, $errorConfirmation, $errorDate);
    $passwordForm = renderFormChangePassword();
    $deletionForm = renderFormDeleteJournalEntry();

    $content = <<<PAGE
{$successMessages}
{$errorMessages}
{$passwordForm}
{$deletionForm}
PAGE;
    return $content;
}

//FUNCTION TO RETURN HTML ERROR MESSAGES IF REQUIRED
function createErrorMessages($errorPassword, $errorConfirmation, $errorDate) {
    $messages = "";
    if ($errorPassword == "true") { $messages .= file_get_contents("data\static\settings\password_invalid_error.html"); }
    if ($errorConfirmation == "true") { $messages .= file_get_contents("data\static\settings\password_confirmation_error.html"); }
    if ($errorDate == "true") { $messages .= file_get_contents("data\static\settings\date_invalid_error.html"); }
    return $messages;
}

//FUNCTION TO RETURN HTML SUCCESS MESSAGES IF REQUIRED
function createSuccessMessages($passwordSuccess, $dateSuccess) {
    $messages = "";
    if ($passwordSuccess == "true") { $messages .= file_get_contents("data\static\settings\password_change_success.html"); }
    if ($dateSuccess == "true") { $messages .= file_get_contents("data\static\settings\date_removal_success.html"); }
    return $messages;
}

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) { appRedirect("logIn.php"); }

$pagetitle = "Settings";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();