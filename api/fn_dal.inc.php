<?php
//Including the class definitions
require_once("oo_bll.inc.php");

//JSON HELPER FUNCTIONS
function jsonOne($file, $id) {
    $splfile = new SplFileObject($file);
    $splfile->seek($id-1);
    $data = json_decode($splfile->current());
    return $data;
}

function jsonAll($file) {
    $entries = file($file);
    $array = [];
    foreach($entries as $entry)
    {
        $array[] = json_decode($entry);
    }
    return $array;
}

function jsonNextID($file) {
    $splfile = new SplFileObject($file);
    $splfile->seek(PHP_INT_MAX);
    return $splfile->key() + 1;
}

function jsonRowCount($file) {
    $splfile = new SplFileObject($file);
    $splfile->seek(PHP_INT_MAX);
    return $splfile->key();
}

//PROFILES.JSON FUNCTIONS
function jsonLoadProfile($id = 1) {
    $user = new BLLProfile();
    $user->fromArray(jsonOne("data/json/profile.json", $id));
    return $user;
}

//ENTRIES.JSON FUNCTIONS
function jsonLoadOneJournalEntry($id) {
    $entry = new BLLJournalEntry();
    $entry->fromArray(jsonOne("data/json/entries.json", $id));
    return $entry;
}

function jsonLoadAllJournalEntries() {
    $array = jsonAll("data/json/entries.json");
    return array_map(function($data){ $entry = new BLLJournalEntry; $entry->fromArray($data); return $entry; }, $array);
}
?>