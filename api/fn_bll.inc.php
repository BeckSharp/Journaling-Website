<?php
//FUNCTION TO REDIRECT USER IF ACCOUNT NOT REGISTERED
function appProfileRegisteredCheck() {
    $profile = jsonLoadProfile();
    if (is_null($profile->username)) { header('Location: signUp.php'); }
}

function appRedirect($address) {
    header("Location: {$address}");
}