<?php

class BaseValidator
{
    public function __construct()
    {
        $this->loadFunctions();
    }
    protected function loadFunctions()
    {
        include 'functions.php';
    }
    public function __call($name, $arguments)
    {
        if (is_callable($name))
        {
            return call_user_func_array($name, $arguments);
        }
    }
}

