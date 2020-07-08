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
        
        //ENCRYPTING ENTRY & ADDING IT TO JOURNAL
        $journalEntry = appEncryptJournal($journalEntry, $key);
        $journalData = jsonLoadAllJournalEntries();
        $journalData[] = $journalEntry;

        //DECRYPTING DATE OF ALL ENTRIES FOR SORTING
        $journalData = appDecryptJournalDateOnly($journalData, $key);
        appQuickSortJournalEntries($journalData, 0, count($journalData) - 1);

        //RE-ENCRYPTING DATA & WRITING TO JSON
        $journalData = appEncryptJournalDateOnly($journalData, $key);
        $saveData = appWriteJsonData($journalData);
        file_put_contents("data/json/entries.json", $saveData);

        //REDIRECT USER WITH SUCCESS MESSAGE
        appRedirect("index.php?entryAdded=true");
    }
    else {
        //REDIRECT USER WITH ERROR MESSAGE
        $url = createErrorMessageURL($journalEntry);
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

//FUNCTION TO CREATE URL WITH ERROR MESSAGES
function createErrorMessageURL(BLLJournalEntry $entry) {
    $url = "journalEntry.php";
    $errorCount = 0;
    if (!isDataNotEmpty($entry)) {
        $url .= "?empty=true"; 
        $errorCount++;
    }
    if (!isDateValid($entry->date) || isDateTaken($entry->date)) {
        if ($errorCount > 0) { $url .= "&date=true"; }
        if ($errorCount == 0) { $url .= "?date=true"; }
    }
    return $url;
}