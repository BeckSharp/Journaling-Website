<?php
//INCLUDING API
include("api/api.inc.php");

session_start();

if (appFormMethodIsPost() && appSessionIsSet()) {
    //RETRIEVING POSTED DATA & ADDING IT TO OBJECT
    $journalEntry = new BLLJournalEntry();
    $journalEntry->username = "username";
    $journalEntry->date = createDate($_POST["dateDay"] ?? "", $_POST["dateMonth"] ?? "", $_POST["dateYear"] ?? "");
    $journalEntry->weeding = $_POST["weeding"] ?? "";
    $journalEntry->reflection = $_POST["reflection"] ?? "";
    $journalEntry->planning = $_POST["planning"] ?? "";
    $journalEntry->noteTaking = $_POST["notes"] ?? "";
    $journalEntry->questions = $_POST["question"] ?? "";

    //REMOVING MALICIOUS TEXT
    $journalEntry = appCleanJournalData($journalEntry);

    if (isJournalEntryValid($journalEntry)) {

        //RETRIEVING USERNAME FROM SESSION AND ADDING TO JOURNAL
        $key = appDecryptSessionData($_SESSION["username"]);
        $journalEntry->username = $key;
        
        //ENCRYPTING JOURNAL & WRITING DATA TO JSON
        $journalEntry = appEncryptJournal($journalEntry, $key);
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
        if (!isDataNotEmpty($journalEntry)) {
            $url .= "?empty=true"; 
            $errorCount++;
        }
        if (!isDateValid($journalEntry->date) || isDateTaken($journalEntry->date)) {
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
function isJournalEntryValid(BLLJournalEntry $journal) {
    if (!isDataNotEmpty($journal)) { return false; }
    if (!isDateValid($journal->date)) { return false; }
    if (isDateTaken($journal->date)) { return false; }
    return true;
}

function isDataNotEmpty(BLLJournalEntry $journal) {
    if (empty($journal->date)) { return false; }
    if (empty($journal->weeding)) { return false; }
    if (empty($journal->reflection)) { return false; }
    if (empty($journal->planning)) { return false; }
    if (empty($journal->noteTaking)) { return false; }
    if (empty($journal->questions)) { return false; }
    return true;
}

function isDateValid($date, $format = 'd-m-Y') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function isDateTaken($date) {
    $entries = jsonLoadAllJournalEntries();
    if (count($entries) == 0) { return false; }

    $key = appDecryptSessionData($_SESSION["username"]);
    $encryptedDate = appEncryptData($date, $key);

    foreach ($entries as $entry) {
        if ($entry->date == $encryptedDate) { return true; }
    }

    return false;
}