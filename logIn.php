<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorData = $_GET["invalid"] ?? "";
    $signUpSuccess = $_GET["registered"] ?? "";

    $form = renderFormLogIn($errorData, $signUpSuccess);

    $content = <<<PAGE
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
if (!appProfileRegisteredCheck()) { 
    appRedirect("signUp.php"); 
}

session_start();
if (appSessionIsSet()) { 
    appRedirect("index.php"); 
}

$pagetitle = "Log In";
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