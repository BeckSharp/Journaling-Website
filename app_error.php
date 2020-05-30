<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {

    $errorMessage = file_get_contents("data\static\app_error_message.html");

    $content = <<<PAGE
{$errorMessage}
PAGE;
    return $content;
}

//BUSINESS LOGIC
$pagetitle = "Error Page";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
$page->renderPage();
?>