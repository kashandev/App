<?php
// generate captcha //
$capcode = '';
$digits = 4;
$capcode = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
echo $capcode;
