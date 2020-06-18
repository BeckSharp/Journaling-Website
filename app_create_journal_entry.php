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
    
} else {
    appRedirect("app_error.php");
}