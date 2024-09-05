<?php
// generate refcode //
$newrefcode = '';
$length_of_string = 6;
$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
$newrefcode = substr(str_shuffle($str_result), 0, $length_of_string);
return $newrefcode;
