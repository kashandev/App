<?php

// conn //

$servername = "";

$username = "";

$password = "";

$conn = "";

$dbname = "";

// check connection for live server //

if ($_SERVER['SERVER_NAME'] != 'localhost') {

    // live connection variables //

    $servername = "localhost";

    $username = "kashankhalid_pressearn";

    $password = "8sY8LhcTZt9Ey5rbHBvk";

    $dbname = "kashankhalid_pressearn";

    // end of live connection variables //

    // create live connection //

    $conn = mysqli_connect($servername, $username, $password, $dbname);



    // check connection

    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    } else {

        return $conn;

    }

    mysqli_close($conn);

}

// end of check connection for live server //



// check connection for local server //

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    // local connection variables //

    $servername = "localhost";

    $username = "root";

    $password = "";

    $dbname = "pressearn";

    $conn = "";

    // end of local connection variables //

    // create local connection //

    $conn = mysqli_connect($servername, $username, $password, $dbname);



    // check connection

    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    } else {

        return $conn;

    }

    mysqli_close($conn);

}

// end of check connection for local server //

?>

