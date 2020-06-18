<?php
//INCLUDING API
include("api/api.inc.php");

if (appFormMethodIsPost() && !appProfileRegisteredCheck()) {
    //RETRIEVING POSTED DATA
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmation = $_POST["passwordConfirmation"] ?? "";

    //REMOVING MALICIOUS TEXT
    $username = appReplaceEntityTags($username);
    $password = appReplaceEntityTags($password);
    $confirmation = appReplaceEntityTags($confirmation);

    if (isDataValid($username, $password, $confirmation)) {
        //ENCRYPT USERNAME
        $encryptedUsername = appEncryptData($username, $username);
        
        //HASH & SALT PASSWORD
        $hashedPassword = appHashData($password);

        //WRITE DATA TO JSON
        $profile = new BLLProfile();
        $profile->username = $encryptedUsername;
        $profile->password = $hashedPassword;
        $saveData = json_encode($profile).PHP_EOL;
        file_put_contents("data/json/profile.json", $saveData);

        //REDIRECT USER TO logIn.php
        appRedirect("logIn.php?registered=true");
    } else {
        //REDIRECT TO signUp.php WITH ERROR MESSAGES
        $url = "signUp.php?data=invalid";
        if (!isDataNotEmpty($username, $password, $confirmation)) { $url .= "&empty=true"; }
        if (!isPasswordConfirmed($password, $confirmation)) { $url .= "&unconfirmed=true"; }
        appRedirect($url);
    }
} else {
    appRedirect("app_error.php");
}

//FUNCTIONS TO VALIDATE DATA
function isDataValid($username, $password, $confirmation) {
    if (!isDataNotEmpty($username, $password, $confirmation)) { return false; }
    if (!isPasswordConfirmed($password, $confirmation)) { return false; }
    if (appProfileRegisteredCheck()) { return false; }
    return true;
}

function isDataNotEmpty($username, $password, $confirmation) {
    if (empty($username)) { return false; }
    if (empty($password)) { return false; }
    if (empty($confirmation)) { return false; }
    return true;
}

function isPasswordConfirmed($password, $confirmation) {
    if ($password != $confirmation) { return false; }
    return true;
}