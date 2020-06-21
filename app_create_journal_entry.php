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

    if (isJournalEntryValid($dateDay, $dateMonth, $dateYear, $weeding, $reflection, $planning, $notes, $question)){
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

//FUNCTION TO CREATE A DATE
function createDate($day, $month, $year) {
    $date = $day."-".$month."-".$year;
    return date_create($date);
}

//FUNCTIONS TO VALIDATE DATA
function isJournalEntryValid($day, $month, $year, $weeding, $reflection, $planning, $notes, $question) {
    if (!isDataNotEmpty($day, $month, $year, $weeding, $reflection, $planning, $notes, $question)) { return false; }
    if (!isDateValid($day, $month, $year)) { return false; }
    //VALIATE DATA'S DATE ISN'T TAKEN
    return true;
}

function isDataNotEmpty($day, $month, $year, $weeding, $reflection, $planning, $notes, $question) {
    if (empty($day)) { return false; }
    if (empty($month)) { return false; }
    if (empty($year)) { return false; }
    if (empty($weeding)) { return false; }
    if (empty($reflection)) { return false; }
    if (empty($planning)) { return false; }
    if (empty($notes)) { return false; }
    if (empty($question)) { return false; }
    return true;
}

function isDateValid($day, $month, $year) {
    if (!checkdate($month, $day, $year)) { return false; }
    return true;
}

function isDateTaken($day, $month, $year) {

}