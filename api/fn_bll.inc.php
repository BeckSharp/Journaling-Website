<?php
//INCLUDING OBJECT CLASSES
require_once("oo_bll.inc.php");

//FUNCTION TO VALIDATE IF AN ACCOUNT IS REGISTERED
function appProfileRegisteredCheck() {
    $profile = jsonLoadProfile();
    if (is_null($profile->username)) { return false; }
    if (is_null($profile->password)) { return false; }
    return true;
}

//FUNCTION TO REDIRECT USER
function appRedirect($address) {
    header("Location: {$address}");
}

//FUNCTION TO SELF-SUMIT DATA TO PAGE
function appFormSelfSubmit() {
    return htmlspecialchars($_SERVER['PHP_SELF']);
}

//FUNCTION TO SET FORM METHOD
function appFormMethod($default = true) {
    return $default ? "POST" : "GET";
}

//FUNCTION TO RETRIEVE FORM METHOD
function appFormMethodIsPost() {
    return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
}

//FUNCTION TO REPLACE ENTITIES FOR TAGS IN STRING
function appReplaceEntityTags($data) {
    $data = str_replace("<", "&lt;", $data);
    $data = str_replace(">", "&gt;", $data);
    return $data;
}

//FUNCTION TO HASH DATA 
function appHashData($data) {
    return password_hash($data, PASSWORD_BCRYPT);
}

//FUNCTION TO ENCRYPT DATA FOR STORAGE IN SESSION
function appEncryptSessionData($data) {
    $key = "SessionData";
    return appEncryptData($data, $key);
}

//FUNCTION TO DECRYPT DATA FROM SESSION STORAGE
function appDecryptSessionData($data) {
    $key = "SessionData";
    return appDecryptData($data, $key);
}

//FUNCTION TO ENCRYPT DATA
function appEncryptData($data, $key) {
    $encryption = new BLLEncryption();
    return $encryption->encryptData($data, $key);
}


//FUNCTION TO DECRYPT DATA
function appDecryptData($data, $key) {
    $decryption = new BLLEncryption();
    return $decryption->decryptData($data, $key);
}

//FUNCTION TO DECRYPT JOURNAL DATA
function appDecryptJournal(BLLJournalEntry $journal, $key) {
    $journal->username = appDecryptData($journal->username, $key);
    $journal->date = appDecryptData($journal->date, $key);
    $journal->weeding = appDecryptData($journal->weeding, $key);
    $journal->reflection = appDecryptData($journal->reflection, $key);
    $journal->planning = appDecryptData($journal->planning, $key);
    $journal->noteTaking = appDecryptData($journal->noteTaking, $key);
    $journal->questions = appDecryptData($journal->questions, $key);
    return $journal;
}

//FUNCTION TO SET SESSSION LOG IN TOKENS
function appSetSessionLogInTokens($username) {
    $username = appEncryptSessionData($username);
    $_SESSION["username"] = $username;
    $_SESSION["entered"] = true;
}

//FUNCTION TO CHECK IF A SESSION IS ACTIVE
function appSessionIsSet() {
    if (!isset($_SESSION["entered"])) { return false; }
    return true;
}

//FUNCTION TO DESTROY USER SESSION
function appSessionDestroy() {
    session_unset();
    session_destroy();
}