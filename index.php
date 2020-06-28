<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {

    $journalData = jsonLoadAllJournalEntries();
    $journalOutput = "";

    $entryAdded = $_GET["entryAdded"] ?? "";
    $successMessage = "";

    if (count($journalData) == 0) {
        //PRODUCING ERROR MESSAGE
        $journalOutput = file_get_contents("data/static/index/index_error_no_data.html");
    } else {
        //DECRYPTING USER'S JOURNAL DATA
        $key = appDecryptSessionData($_SESSION["username"]);
        $journalData = decryptJournalEntries($journalData, $key);

        //RENDERING THE JOURNAL OUTPUT DATA
        $journalOutput = createJournalOutput($journalData);
    }

    if ($entryAdded == "true") { $successMessage = file_get_contents("data/static/index/index_journal_entry_success.html"); }

    $content = <<<PAGE
{$successMessage}
{$journalOutput}
PAGE;
    return $content;
}

function decryptJournalEntries($journalData, $key) {
    foreach ($journalData as $entry) {
        $entry = appDecryptJournal($entry, $key);
    }
    return $journalData;
}

function createJournalOutput($journalData) {
    $count = 0;
    $journalOutput = "<div class=\"panel-group\" id=\"accordian\">";
    foreach ($journalData as $entry) {
        $journalOutput .= renderJournalEntryData($entry, $count);
        $count++;
    }
    $journalOutput .= "</div>";
    return $journalOutput;
}

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) {
    appRedirect("logIn.php");
}

$pagetitle = "Home Page";
$pagecontent = createPage();
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic2($pagefooter);
$page->renderPage();