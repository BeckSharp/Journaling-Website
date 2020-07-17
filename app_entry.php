<?php
//INCLUDING API
include("api/api.inc.php");

//RETRIEVING CURRENT SESSION
session_start();

//VALIDATING DATA HAS BEEN POSTED
if (appFormMethodIsPost() && !appSessionIsSet()) { 
    //RETRIEVING POSTED DATA
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    //REMOVING MALICIOUS TEXT
    $username = appReplaceEntityTags($username);
    $password = appReplaceEntityTags($password);

    //VALIDATING CREDENTIALS ENTERED ARE CORRECT
    if (isLogInValid($username, $password)) {
        //SETTING SESSION TOKENS & REDIRECTING USER
        appSetSessionLogInTokens($username);
        appRedirect("index.php");
    } else {
        //REDIRECT TO logIn.php WITH ERROR MESSAGE
        appRedirect("logIn.php?errorCodes=c");
    }
} else {
    //REDIRECT USER TO ERROR PAGE
    appRedirect("app_error.php");
}

//FUNCTIONS TO VALIDATE DATA
function isLogInValid($username, $password) {
    $profile = jsonLoadProfile();
    if (!isUsernameValid($username, $profile->username)) { return false; }
    if (!isPasswordValid($password, $profile->password)) { return false; }
    return true;
}

function isUsernameValid($username, $registeredUsername) {
    $encryptedUsername = appEncryptData($username, $username);
    if ($encryptedUsername != $registeredUsername) { return false; }
    return true;
}

function isPasswordValid($password, $registeredPassword) {
    if (!password_verify($password, $registeredPassword)) { return false; }
    return true;
}