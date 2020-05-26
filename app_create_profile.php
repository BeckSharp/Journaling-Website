<?php
//RETRIEVING POSTED DATA
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";
$confirmation = $_POST["passwordConfirmation"] ?? "";

//REDIRECT IF ACCOUNT REGISTERED 
//OR PAGE VISITED
if (appProfileRegisteredCheck()) {
    //REDIRECT TO logIn.php
} 

//REGISTERING ACCOUNT LOGIC
if (isDataValid($username, $password, $confirmation)) {
    //ENCRYPT USERNAME
    //HASH & SALT PASSWORD
    //WRITE DATA TO JSON
} else {
    //REDIRECT TO signUp.php WITH ERROR MESSAGES
}

//FUNCTIONS TO VALIDATE DATA
function isDataValid($username, $password, $confirmation) {
    if (!isDataNotEmpty($username, $password, $confirmation)) { return false; }
    if (!isPasswordConfirmed($password, $confirmation)) { return false; }
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

