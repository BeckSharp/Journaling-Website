<?php
//OBJECT CLASSES
class BLLProfile {
    //FIELDS
    public $username;
    public $password;

    //FUNCTIONS
    public function fromArray(stdClass $assoc) {
        foreach($assoc as $key => $value) {
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
    public function fromArray(stdClass $assoc) {
        foreach($assoc as $key => $value) {
            $this->{$key} = $value;
        }
    }
}

class BLLEncryption {
    //FIELDS
    private $ciphering = "AES-128-CTR";
    private $options = 0;
    private $initializationVector = '1234567891011121';

    //Functions
    public function encryptData($data, $key) {
        return openssl_encrypt($data, $this->ciphering, $key, $this->options, $this->initializationVector);
    }

    public function decryptData($data, $key) {
        return openssl_decrypt($data, $this->ciphering, $key, $this->options, $this->initializationVector);
    }
}
?>