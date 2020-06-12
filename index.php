<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {

    $journalData = jsonLoadAllJournalEntries();
    $journalOutput = "";

    if (count($journalData) == 0) {
        $journalOutput = file_get_contents("data/static/index/index_error_no_data.html");
    } else {
        //RENDER JOURNAL DATA PRESENTATION
    }

    $content = <<<PAGE
{$journalOutput}
PAGE;
    return $content;
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