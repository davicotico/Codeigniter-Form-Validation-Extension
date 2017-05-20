<?php


function test1($p1, $p2)
{
    echo "Test 1 {$p1}, {$p2}";
}

function isCNPJ($value)
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