<?php
//INCLUDING API
include("api/api.inc.php");

session_start();

if (appFormMethodIsPost() && appSessionIsSet()) {
    //RETRIEVING POSTED DATA
    $dateDay = $_POST["dateDay"] ?? "";
    $dateMonth = $_POST["dateMonth"] ?? "";
    $dateYear = $_POST["dateYear"] ?? "";
    $weeding = $_POST["weeding"] ?? "";
    $reflection = $_POST["reflection"] ?? "";
    $planning = $_POST["planning"] ?? "";
    $notes = $_POST["notes"] ?? "";
    $question = $_POST["question"] ?? "";

    //REMOVING MALICIOUS TEXT
    $dateDay = appReplaceEntityTags($dateDay);
    $dateMonth = appReplaceEntityTags($dateMonth);
    $dateYear = appReplaceEntityTags($dateYear);
    $weeding = appReplaceEntityTags($weeding);
    $reflection = appReplaceEntityTags($reflection);
    $planning = appReplaceEntityTags($planning);
    $notes = appReplaceEntityTags($notes);
    $question = appReplaceEntityTags($question);

    if (isJournalEntryValid($dateDay, $dateMonth, $dateDay, $weeding, $reflection, $planning, $notes, $question)){
        //CREATE DATE USING POSTED DATA

        //ENCRYPTING DATA FOR STORAGE

        //CREATING JOURNAL ENTRY OBJECT
        $journalEntry = new BLLJournalEntry;

        //WRITE DATA TO JSON

        //REDIRECT USER WITH SUCCESS MESSAGE

    }
    else {
        //REDIRECT USER WITH ERROR MESSAGE
        
    }
} else {
    appRedirect("app_error.php");
}

//FUNCTIONS TO VALIDATE DATA
function isJournalEntryValid($day, $month, $year, $weeding, $reflection, $planning, $notes, $question) {
    //VALIDATE DATA ISN'T EMPTY
    //VALIDATE DATA'S DATE IS REAL
    //VALIATE DATA'S DATE ISN'T TAKEN
    return true;
}