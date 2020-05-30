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
$pagecontent = createPage();
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic2($pagefooter);
$page->renderPage();