<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $passwordSuccess = $_GET["pwordChanged"] ?? "";
    $errorPassword = $_GET["pwordInvalid"] ?? "";
    $errorConfirmation = $_GET["confirmationInvalid"] ?? "";

    $errorMessages = "";
    if ($errorPassword == "true") { $errorMessages .= file_get_contents("data\static\settings\password_invalid_error.html"); }
    if ($errorConfirmation == "true") { $errorMessages .= file_get_contents("data\static\settings\password_confirmation_error.html"); }

    $successMessages = "";
    if ($passwordSuccess == "true") { $successMessages .= file_get_contents("data\static\settings\password_change_success.html");}

    $passwordForm = renderFormChangePassword();

    $content = <<<PAGE
{$successMessages}
{$errorMessages}
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