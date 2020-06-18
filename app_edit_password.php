<?php
//INCLUDING API
include("api/api.inc.php");

session_start();

if (appFormMethodIsPost() && appSessionIsSet()) {
    //RETRIEVING POSTED DATA
    $oldPassword = $_POST["password"] ?? "";
    $newPassword = $_POST["newPassword"] ?? "";
    $confirmationPassword = $_POST["confirmationPassword"] ?? "";

    //REMOVING MALICIOUS TEXT
    $oldPassword = appReplaceEntityTags($oldPassword);
    $newPassword = appReplaceEntityTags($newPassword);
    $confirmationPassword = appReplaceEntityTags($confirmationPassword);

    if (isDataValid($oldPassword, $newPassword, $confirmationPassword)) {
        //HASH & SALT PASSWORD
        $hashedPassword = appHashData($newPassword);

        //WRITE DATA TO JSON
        $profile = jsonLoadProfile();
        $profile->password = $hashedPassword;
        $saveData = json_encode($profile).PHP_EOL;
        file_put_contents("data/json/profile.json", $saveData);

        //REDIRECT USER TO settings.php WITH SUCCESS MESSAGE
        appRedirect("settings.php?pwordChanged=true");
    } else {
        //REDIRECT TO settings.php WITH ERROR MESSAGES
        $url = "settings.php";
        $errorCount = 0;
        if (!isPasswordValid($oldPassword)) { 
            $url .= "?pwordInvalid=true"; 
            $errorCount++;
        }
        if (!isNewPasswordConfirmed($newPassword, $confirmationPassword)) { 
            if ($errorCount > 0) { $url .= "&confirmationInvalid=true"; }
            if ($errorCount == 0) { $url .= "?confirmationInvalid=true"; }
        }
        appRedirect($url);
    }
} else {
    appRedirect("app_error.php");
}

//FUNCTIONS TO VALIDATE DATA
function isDataValid($oldPassword, $newPassword, $confirmationPassword) {
    if (!isPasswordValid($oldPassword)) { return false; }
    if (!isNewPasswordConfirmed($newPassword, $confirmationPassword)) { return false; }
    return true;
}

function isPasswordValid($password) {
    $profile = jsonLoadProfile();
    if (!password_verify($password, $profile->password)) { return false; }
    return true;
}

function isNewPasswordConfirmed($password, $confirmation) {
    if ($password != $confirmation) { return false; }
    return true;
}