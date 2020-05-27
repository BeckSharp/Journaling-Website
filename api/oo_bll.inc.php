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
    public $data;
    public $ciphering;
    public $key;
    public $options;
    public $initializationVector;

    //Functions
    public function __construct($data, $key) {
        $this->data = $data;
        $this->ciphering = "AES-128-CTR";
        $this->key = $key;
        $this->options = 0;
        $this->initializationVector = '1234567891011121';
    }

    public function encryptData() {
        return openssl_encrypt($this->data, $this->ciphering, $this->key, 
                                $this->options, $this->initializationVector);
    }

    public function decryptData($decryptionData) {
        return openssl_decrypt($decryptionData, $this->ciphering, $this->key, 
                                $this->options, $this->initializationVector);
    }
}
?>