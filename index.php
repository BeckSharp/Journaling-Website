<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {

    $journalData = jsonLoadAllJournalEntries();
    $journalOutput = createJournalOutput($journalData);

    $entryAdded = $_GET["entryAdded"] ?? "";
    $successMessage = createSuccessMessage($entryAdded);

    $content = <<<PAGE
{$successMessage}
{$journalOutput}
PAGE;
    return $content;
}

//FUNCTION TO DECRYPT AND RETURN AN ARRAY OF OBJECTS
function decryptJournalEntries($journalData, $key) {
    foreach ($journalData as $entry) {
        $entry = appDecryptJournal($entry, $key);
    }
    return $journalData;
}

//FUNCTION TO RETURN HTML CODE BASED OFF OF THE INPUT OF AN ARRAY OF OBJECTS
function createJournalOutput($journalData) {
    if (count($journalData) == 0) { return file_get_contents("data/static/index/index_error_no_data.html"); }
    $key = appDecryptSessionData($_SESSION["username"]);
    $journalData = decryptJournalEntries($journalData, $key);
    return createJournalAccordian($journalData);
}

//FUNCTION TO CREATE HTML CODE FOR AN ARRAY OF OBJECTS
function createJournalAccordian($journalData) {
    $count = 0;
    $journalOutput = "<div class=\"panel-group\" id=\"accordian\">";
    foreach ($journalData as $entry) {
        $journalOutput .= renderJournalEntryData($entry, $count);
        $count++;
    }
    $journalOutput .= "</div>";
    return $journalOutput;
}

//FUNCTION TO RETURN A HTML SUCCESS MESSAGE IF REQUIRED
function createSuccessMessage($entryAdded) {
    if ($entryAdded != "true") { return "";}
    return file_get_contents("data/static/index/index_journal_entry_success.html");
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