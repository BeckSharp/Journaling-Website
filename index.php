<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $journalData = jsonLoadAllJournalEntries();
    $journalOutput = createJournalOutput($journalData);

    $successCodes = $_GET["successCodes"] ?? "";
    $successMessage = renderSuccessMessageCodes($successCodes);

    $content = <<<PAGE
{$successMessage}
{$journalOutput}
PAGE;
    return $content;
}

//FUNCTION TO RETURN HTML CODE BASED OFF OF THE INPUT OF AN ARRAY OF OBJECTS
function createJournalOutput($journalData) {
    if (count($journalData) == 0) { return file_get_contents("data/static/index/index_error_no_data.html"); }
    $key = appDecryptSessionData($_SESSION["username"]);
    $journalData = appDecryptJournalEntries($journalData, $key);
    return renderJournalAccordian($journalData);
}

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) { appRedirect("logIn.php"); }

$pagetitle = "Home Page";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();