<?php
if (! function_exists('setValue'))
{
    function setValue($field, $default = '')
    {
        echo get_instance()->form_validation->getValue($field, $default);
    }
}
if (! function_exists('setChecked'))
{
    function setChecked($field, $value)
    {
        $val = get_instance()->form_validation->getValue($field, NULL);
        if (is_array($val))
        {
            echo (in_array($value, $val)) ? 'checked' : '';
        } else
        {
            echo ($val==$value) ? 'checked' : '';
        }
    }
}
if (! function_exists('setCheckbox'))
{
    function setSelected($field, $value)
    {
        $val = get_instance()->form_validation->getValue($field, NULL);
        if (is_array($val))
        {
            echo (in_array($value, $val)) ? 'selected' : '';
        } else
        {
            echo ($val==$value) ? 'selected' : '';
        }
    }
}
