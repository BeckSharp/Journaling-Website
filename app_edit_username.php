<?php
//INCLUDING API
include("api/api.inc.php");

session_start();

if (appFormMethodIsPost() && appSessionIsSet()) {
    //RETRIEVING POSTED DATA
    $current = $_POST["username"] ?? "";
    $new = $_POST["newUsername"] ?? "";
    $confirmation = $_POST["confirmationUsername"] ?? "";

    //REMOVING MALICIOUS TEXT
    $current = appReplaceEntityTags($current);
    $new = appReplaceEntityTags($new);
    $confirmation = appReplaceEntityTags($confirmation);

    if (isDataValid($current, $new, $confirmation)) {
        //CHANGING PROFILE'S USERNAME
        $profile = jsonLoadProfile();
        $profile->username = appEncryptData($new, $new);

        //CHANGING JOURNAL'S USERNAME & DATA'S ENCRYPTION KEY
        $journal = jsonLoadAllJournalEntries();
        $journal = appDecryptJournalEntries($journal, $current);

        foreach ($journal as $entry) {
            $entry->username = $new;
        }

        $journal = appEncryptJournalEntries($journal, $new);

        //WRITING DATA TO JSON & REDIRECTING USER
        $journalSaveData = appWriteJsonData($journal);
        $profileSaveData = json_encode($profile).PHP_EOL;
        file_put_contents("data/json/profile.json", $profileSaveData);
        file_put_contents("data/json/entries.json", $journalSaveData);

        //REDIRECTING USER
        appRedirect("logIn.php?unameChanged=true");
    } else {
        //REDIRECT TO settings.php WITH ERROR MESSAGES
        $url = createErrorMessageURL($current, $new, $confirmation);
        appRedirect($url);
    }
} else {
    appRedirect("app_error.php");
}

//FUNCTIONS TO VALIDATE DATA
function isDataValid($oldUsername, $newUsername, $confirmation) {
    if (!isUsernameValid($oldUsername)) { return false; }
    if (!isNewUsernameConfirmed($newUsername, $confirmation)) { return false; }
    if (!isDataNotEmpty($oldUsername, $newUsername, $confirmation)) { return false; }
    return true;
}

function isUsernameValid($username) {
    $profile = jsonLoadProfile();
    $username = appEncryptData($username, $username);
    if ($profile->username != $username) { return false; }
    return true;
}

function isNewUsernameConfirmed($username, $confirmation) {
    return appStringsMatch($username, $confirmation);
}

function isDataNotEmpty($oldUsername, $newUsername, $confirmation) {
    if (empty($oldUsername)) { return false; }
    if (empty($newUsername)) { return false; }
    if (empty($confirmation)) { return false; }
    return true;
}

//FUNCTION TO CREATE URL WITH ERROR MESSAGES
function createErrorMessageURL($oldUsername, $newUsername, $confirmation) {
    $url = "settings.php";
    $errorCount = 0;
    if (!isUsernameValid($oldUsername)) { 
        $url .= "?usernameInvalid=true"; 
        $errorCount++;
    }
    if (!isNewUsernameConfirmed($newUsername, $confirmation)) { 
        if ($errorCount > 0) { $url .= "&usernameConfirmationInvalid=true"; }
        if ($errorCount == 0) { $url .= "?usernameConfirmationInvalid=true"; $errorCount++; }
    }
    if (!isDataNotEmpty($oldUsername, $newUsername, $confirmation)) {
        if ($errorCount > 0) { $url .= "&usernameEmpty=true"; }
        if ($errorCount == 0) { $url .= "?usernameEmpty=true"; }
    }
    return $url;
}