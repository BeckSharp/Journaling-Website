<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $passwordForm = renderFormChangePassword();

    $content = <<<PAGE
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
	        <h2 class="panel-title">Change your password here:</h2>
        </div>
        <div class="panel-body">
            {$passwordForm}
        </div>
    </div>
</div>
<div class="row details">
    <div class="panel panel-primary">
        <div class="panel-heading">
	        <h2 class="panel-title">Delete a journal entry here</h2>
        </div>
        <div class="panel-body">
            Render for entry deletion goes here
        </div>
    </div>
</div>
PAGE;
    return $content;
}

//BUSINESS LOGIC
session_start();
if (!appSessionIsSet()) {
    appRedirect("logIn.php");
}

$pagetitle = "Settings";
$pagecontent = createPage();
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic1($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic2($pagefooter);
$page->renderPage();