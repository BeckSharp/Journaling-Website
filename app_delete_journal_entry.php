<?php
//INCLUDING API
include("api/api.inc.php");

session_start();

if (appFormMethodIsPost() && appSessionIsSet()) {
    //RETRIEVING POSTED DATA & CLEANING IT
    $option = $_POST["date"] ?? "";
    $option = appReplaceEntityTags($option);

    if (isDataValid($option)) {
        //REMOVING JOURNAL FROM JSON DATA
        $journalData = jsonLoadAllJournalEntries();
        unset($journalData[$option - 1]);

        //WRITE DATA TO JSON & REDIRECT USER WITH SUCCESS MESSAGE
        $saveData = appWriteJsonData($journalData);
        file_put_contents("data/json/entries.json", $saveData);
        appRedirect("settings.php?dateRemoved=true");
    } else {
         //REDIRECT TO settings.php WITH ERROR MESSAGE
        appRedirect("settings.php?dateError=true");
    }
} else {
    appRedirect("app_error.php");
}

//VALIDATES WHETHER DATA ENTERED IS A STRING AS ALL 
//STRINGS RETURN 0 ON intval() WHEN CASTED AS AN int
//(The number 0 is never used as a form option)
function isDataValid($data) {
    if (intval((int) $data) == 0) { return false; }
    return true;
}