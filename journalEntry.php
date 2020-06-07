<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {

    $errorEmpty = $_GET["empty"] ?? "";
    $errorDate = $_GET["date"] ?? "";

    $form = renderFormJournalEntry($errorEmpty, $errorDate);

    $content = <<<PAGE
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) {
    appRedirect("logIn.php");
}

$pagetitle = "New Entry";
$pagecontent = createPage();
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic2($pagefooter);
$page->renderPage();