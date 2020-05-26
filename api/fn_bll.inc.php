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

//FUNCTION TO DETERMINE FORM METHOD
function appFormMethod($default = true) {
    return $default ? "POST" : "GET";
}

//FUNCTION TO REPLACE ENTITIES FOR TAGS IN STRING
function appReplaceEntities($data) {
    $data = str_replace("<", "&lt;", $data);
    $data = str_replace(">", "&gt;", $data);
    return $data;
}