<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    //RETRIEVING DATA FROM URL
    $errorPassword = $_GET["pwordInvalid"] ?? "";
    $errorConfirmation = $_GET["confirmationInvalid"] ?? "";
    $errorDate = $_GET["dateError"] ?? "";
    $passwordSuccess = $_GET["pwordChanged"] ?? "";
    $dateSuccess = $_GET["dateRemoved"] ?? "";

    //LOADING JOURNAL ENTRIES AND DECRYPTING THEIR DATE
    $key = appDecryptSessionData($_SESSION["username"]);
    $entries = jsonLoadAllJournalEntries();
    $entries = decryptJournalDateOnly($entries, $key);

    //SETTING PAGE CONTENT
    $successMessages = createSuccessMessages($passwordSuccess, $dateSuccess);
    $errorMessages = createErrorMessages($errorPassword, $errorConfirmation, $errorDate);
    $passwordForm = renderFormChangePassword();
    $deletionForm = renderFormDeleteJournalEntry($entries);

    $content = <<<PAGE
{$successMessages}
{$errorMessages}
{$passwordForm}
{$deletionForm}
PAGE;
    return $content;
}

//FUNCTION TO DECRYPT ONLY THE JOURNAL ENTRIES' DATE
function decryptJournalDateOnly($journalEntries, $decryptionKey) {
    foreach ($journalEntries as $entry) {
        $entry->date = appDecryptData($entry->date, $decryptionKey);
    }
    return $journalEntries;
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