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
$pagecontent = createPage();
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic2($pagefooter);
$page->renderPage();