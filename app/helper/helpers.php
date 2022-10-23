<?php

// Date Formate
function ecPhFormat($value)
{
    $arrValue = explode("-", $value);
    $val1 = isset($arrValue[0]) ? $arrValue[0] : "0.0";
    $val2 = isset($arrValue[1]) ? $arrValue[1] : "0.0";
    return number_format($val1, 1, '.', '') . "-" . number_format($val2, 1, '.', '');
}
