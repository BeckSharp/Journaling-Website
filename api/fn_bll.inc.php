<?php
//FUNCTION TO REDIRECT USER IF ACCOUNT NOT REGISTERED
function appProfileRegisteredCheck() {
    $profile = jsonLoadProfile();
    if (is_null($profile->username)) { return false; }
    if (is_null($profile->password)) { return false; }
    return true;
}

function appRedirect($address) {
    header("Location: {$address}");
}