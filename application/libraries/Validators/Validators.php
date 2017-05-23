<?php

include 'BaseValidator.php';

class Validators extends BaseValidator
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Validation example
     */
    public function isCEP($value)
    {
        return preg_match("/[0-9]{5,5}([- ]?[0-9]{4})?$/", $value);
    }

}
