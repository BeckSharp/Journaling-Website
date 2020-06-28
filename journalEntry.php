<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorEmpty = $_GET["empty"] ?? "";
    $errorDate = $_GET["date"] ?? "";

    $errorMessages = createErrorMessages($errorEmpty, $errorDate);
    $form = renderFormJournalEntry();

    $content = <<<PAGE
{$errorMessages}
{$form}
PAGE;
    return $content;
}

//FUNCTION TO RETURN HTML ERROR MESSAGES IF REQUIRED
function createErrorMessages($errorEmpty, $errorDate) {
    $messages = "";
    if ($errorEmpty == "true") {$messages .= file_get_contents("data\static\journal\journal_entry_error_empty.html"); }
    if ($errorDate == "true") {$messages .= file_get_contents("data\static\journal\journal_entry_error_date.html"); }
    return $messages;
}

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) { appRedirect("logIn.php"); }

$pagetitle = "New Entry";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();