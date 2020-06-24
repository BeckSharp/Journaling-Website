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

    if (isJournalEntryValid($dateDay, $dateMonth, $dateYear, $weeding, $reflection, $planning, $notes, $question)) {
        //CREATE DATE USING POSTED DATA
        $date = createDate($dateDay, $dateMonth, $dateYear);

        //CREATING JOURNAL ENTRY OBJECT WITH ENCRYPTED DATA
        $key = appDecryptSessionData($_SESSION["username"]);
        $journalEntry = new BLLJournalEntry;
        $journalEntry->username = appEncryptData($key, $key);
        $journalEntry->date = appEncryptData($date, $key);
        $journalEntry->weeding = appEncryptData($weeding, $key);
        $journalEntry->reflection = appEncryptData($reflection, $key);
        $journalEntry->planning = appEncryptData($planning, $key);
        $journalEntry->noteTaking = appEncryptData($notes, $key);
        $journalEntry->questions = appEncryptData($question, $key);

        //WRITE DATA TO JSON
        $saveData = json_encode($journalEntry).PHP_EOL;
        $fileContent = file_get_contents("data/json/entries.json");
        $fileContent .= $saveData;
        file_put_contents("data/json/entries.json", $fileContent);

        //REDIRECT USER WITH SUCCESS MESSAGE
        appRedirect("index.php?entryAdded=true");
    }
    else {
        //REDIRECT USER WITH ERROR MESSAGE
        $url = "journalEntry.php";
        $errorCount = 0;
        if (!isDataNotEmpty($dateDay, $dateMonth, $dateYear, $weeding, $reflection, $planning, $notes, $question)) {
            $url .= "?empty=true"; 
            $errorCount++;
        }
        if (!isDateValid($dateDay, $dateMonth, $dateYear) || isDateTaken($dateDay, $dateMonth, $dateYear)) {
            if ($errorCount > 0) { $url .= "&date=true"; }
            if ($errorCount == 0) { $url .= "?date=true"; }
        }
        appRedirect($url);
    }
} else {
    appRedirect("app_error.php");
}

//FUNCTION TO CREATE A DATE
function createDate($day, $month, $year) {
    $date = $day."-".$month."-".$year;
    return $date;
}

//FUNCTIONS TO VALIDATE DATA
function isJournalEntryValid($day, $month, $year, $weeding, $reflection, $planning, $notes, $question) {
    if (!isDataNotEmpty($day, $month, $year, $weeding, $reflection, $planning, $notes, $question)) { return false; }
    if (!isDateValid($day, $month, $year)) { return false; }
    if (isDateTaken($day, $month, $year)) { return false; }
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
    $entries = jsonLoadAllJournalEntries();
    if (count($entries) == 0) { return false; }

    $date = createDate($day, $month, $year);
    $key = appDecryptSessionData($_SESSION["username"]);
    $encryptedDate = appEncryptData($date, $key);

    foreach ($entries as $entry) {
        if ($entry->date == $encryptedDate) { return true; }
    }

    return false;
}