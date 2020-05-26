<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {

    $form = renderFormSignUp();

    $content = <<<PAGE
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
if(appProfileRegisteredCheck()) {
    appRedirect("logIn.php");
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