<?php
//OBJECT CLASSES
class Profile {
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

class JournalEntry {
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