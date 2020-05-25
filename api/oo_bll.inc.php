<?php
//OBJECT CLASSES
class BLLProfile {
    //FIELDS
    public $username;
    public $password;

    //FUNCTIONS
    public function fromArray(stdClass $assoc)
    {
        foreach($assoc as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
}

class BLLJournalEntry {
    //FIELDS
    public $username;
    public $date;
    public $weeding;
    public $reflection;
    public $planning;
    public $noteTaking;
    public $questions;

    //FUNCTIONS
    public function fromArray(stdClass $assoc)
    {
        foreach($assoc as $key => $value)
        {
            $this->{$key} = $value;
        }
    }
}
?>