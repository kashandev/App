<?php
function uuid(&$param) {
    // Generate a 128-bit random number
    $data = random_bytes(16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    
    // Set variant to 10xx
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Convert binary data to hexadecimal representation
    $param = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    return $param;
}


?>