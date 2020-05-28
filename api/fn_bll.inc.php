<?php
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
    $encryption = new BLLEncryption($data, $key);
    return $encryption->encryptData();
}

//FUNCTION TO DECRYPT DATA FROM SESSION STORAGE
function appDecryptSessionData($data) {
    $key = "SessionData";
    $decryption = new BLLEncryption($data, $key);
    return $decryption->decryptData($data);
}

//FUNCTION TO SET SESSSION LOG IN TOKENS
function appSetSessionLogInTokens($username) {
    $username = appEncryptSessionData($data); 
    $_SESSION["username"] = $username;
    $_SESSION["entered"] = true;
}

//FUNCTION TO CHECK IF A SESSION IS ACTIVE
function appSessionIsSet() {
    if (!isset($_SESSION["entered"])) { return false; }
    return true;
}