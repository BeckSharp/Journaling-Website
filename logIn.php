<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $errorData = $_GET["invalid"] ?? "";

    $form = renderFormLogIn($errorData);

    $content = <<<PAGE
{$form}
PAGE;
    return $content;
}

//BUSINESS LOGIC
if(!appProfileRegisteredCheck()) {
    appRedirect("signUp.php");
}

if (appFormMethodIsPost()) {
    //RETRIEVING POSTED DATA
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    //REMOVING MALICIOUS TEXT
    $username = appReplaceEntityTags($username);
    $password = appReplaceEntityTags($password);

    if (isLogInValid($username, $password)) {
        //SET SESSION TOKENS
        //REDIRECT USER TO index.php
        appRedirect("index.php");
    } else {
        //REDIRECT TO logIn.php WITH ERROR MESSAGE
        appRedirect("logIn.php?invalid=true");
    }
} else {
    $pagecontent = createPage();
}

$pagetitle = "Log In";
$pagelead  = "";
$pagefooter = "";

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
if(!empty($pagelead))
    $page->setDynamic1($pagelead);
$page->setDynamic2($pagecontent);
if(!empty($pagefooter))
    $page->setDynamic3($pagefooter);
$page->renderPage();

//FUNCTIONS TO VALIDATE DATA
function isLogInValid($username, $password) {
    $profile = jsonLoadProfile();
    if (!isUsernameValid($username, $profile->username)) { return false; }
    if (!isPasswordValid($password, $profile->password)) { return false; }
    return true;
}

function isUsernameValid($username, $registeredUsername) {
    $encryption = new BLLEncryption($username, $username);
    $encryptedUsername = $encryption->encryptData();
    if ($encryptedUsername != $registeredUsername) { return false; }
    return true;
}

function isPasswordValid($password, $registeredPassword) {
    if (!password_verify($password, $registeredPassword)) { return false; }
    return true;
}