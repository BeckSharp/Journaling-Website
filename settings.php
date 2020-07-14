<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    //RETRIEVING DATA FROM URL
    $errorPassword = $_GET["pwordInvalid"] ?? "";
    $errorConfirmation = $_GET["confirmationInvalid"] ?? "";
    $errorPasswordEmpty = $_GET["pwordEmpty"] ?? "";
    $errorDate = $_GET["dateError"] ?? "";
    $errorUnameInvalid = $_GET["usernameInvalid"] ?? "";
    $errorUnameConfirmation = $_GET["usernameConfirmationInvalid"] ?? "";
    $errorUnameEmpty = $_GET["usernameEmpty"] ?? "";

    $passwordSuccess = $_GET["pwordChanged"] ?? "";
    $dateSuccess = $_GET["dateRemoved"] ?? "";


    //LOADING JOURNAL ENTRIES AND DECRYPTING THEIR DATE
    $key = appDecryptSessionData($_SESSION["username"]);
    $entries = jsonLoadAllJournalEntries();
    $entries = appDecryptJournalDateOnly($entries, $key);

    //SETTING PAGE CONTENT
    $successMessages = createSuccessMessages($passwordSuccess, $dateSuccess);
    $errorMessages = createErrorMessages($errorPassword, $errorConfirmation, $errorDate, $errorPasswordEmpty, $errorUnameInvalid, $errorUnameConfirmation, $errorUnameEmpty);
    $usernameForm = renderFormChangeUsername();
    $passwordForm = renderFormChangePassword();
    $deletionForm = renderFormDeleteJournalEntry($entries);

    $content = <<<PAGE
{$successMessages}
{$errorMessages}
{$usernameForm}
{$passwordForm}
{$deletionForm}
PAGE;
    return $content;
}

//FUNCTION TO RETURN HTML ERROR MESSAGES IF REQUIRED
function createErrorMessages($errorPassword, $errorConfirmation, $errorDate, $errorPasswordEmpty, $errorUnameInvalid, $errorUnameConfirmation, $errorUnameEmpty) {
    $messages = "";
    if ($errorPassword == "true") { $messages .= file_get_contents("data\static\settings\password_invalid_error.html"); }
    if ($errorConfirmation == "true") { $messages .= file_get_contents("data\static\settings\password_confirmation_error.html"); }
    if ($errorPasswordEmpty == "true") { $messages .= file_get_contents("data\static\settings\password_empty_error.html"); }
    if ($errorDate == "true") { $messages .= file_get_contents("data\static\settings\date_invalid_error.html"); }
    if ($errorUnameInvalid == "true") { $messages .= file_get_contents("data\static\settings\username_invalid_error.html"); }
    if ($errorUnameConfirmation == "true") { $messages .= file_get_contents("data\static\settings\username_confirmation_error.html"); }
    if ($errorUnameEmpty == "true") { $messages .= file_get_contents("data\static\settings\username_empty_error.html"); }
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