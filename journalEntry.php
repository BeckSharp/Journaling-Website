<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorCodes = $_GET["errorCodes"] ?? "";
    $errorMessages = renderErrorMessageCodes($errorCodes);

    $form = renderFormJournalEntry();

    $content = <<<PAGE
{$errorMessages}
{$form}
PAGE;
    return $content;
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