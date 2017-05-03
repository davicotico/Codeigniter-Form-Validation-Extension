<?php
include 'BaseValidator.php';

class Validators extends BaseValidator
{
    public function __construct()
    {
        parent::__construct();
        
    }
    public function isCEP($value)
    {
        if (! ctype_digit($value))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
