<?php

//Your functions to validate

/*This example is for Zip code Brazil*/
function zipcode($value)
{
    return ((preg_match('/^[0-9]{5,5}([-]?[0-9]{3,3})?$/', $value))===1);
}
// Contribute here with more validations
