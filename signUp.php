<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorEmpty = $_GET["empty"] ?? "";
    $errorUnconfirmed = $_GET["unconfirmed"] ?? "";

    $form = renderFormSignUp($errorEmpty, $errorUnconfirmed);

    $content = <<<PAGE
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
if(appProfileRegisteredCheck()) {
    appRedirect("logIn.php");
}

session_start();
if (appSessionIsSet()) {
    appRedirect("index.php");
}

$pagetitle = "Sign Up";
$pagelead  = "";
$pagecontent = createPage();
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
if(!empty($pagelead))
    $page->setDynamic1($pagelead);
$page->setDynamic2($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic3($pagefooter);
$page->renderPage();