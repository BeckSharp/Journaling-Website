<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    //LOADING JOURNAL ENTRIES AND DECRYPTING THEIR DATE
    $key = appDecryptSessionData($_SESSION["username"]);
    $entries = jsonLoadAllJournalEntries();
    $entries = appDecryptJournalDateOnly($entries, $key);

    //SETTING PAGE CONTENT
    $successCodes = $_GET["successCodes"] ?? "";
    $successMessages = renderSuccessMessageCodes($successCodes);

    $errorCodes = $_GET["errorCodes"] ?? "";
    $errorMessages = renderErrorMessageCodes($errorCodes);

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

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) { appRedirect("logIn.php"); }

$pagetitle = "Settings";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();