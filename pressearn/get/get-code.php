<?php
// get code //
// initializing variables//
$invcode = "";
$thiscode = "";
$sql = "";
$res = "";
$row = "";
$link = "";
$thislink = "";
$data = "";
$uri = "";
$host = "";
$thishost = "";
$thisuri = "";
$qrimg = "";

// end of initializing variables//
if (isset($_POST["uid"]) == "")
{
    $_POST["uid"] = "";
}

if (isset($_POST["uid"]))
{
    $uid = $_POST["uid"];
}

if ($uid != '')
{
    include_once '../conn/conn.php';
    $sql = "SELECT invcode as invc from user_invitation_code where status = 'new' and user_invitation_code.uid = '" . $uid . "' order by invcid desc limit 1 ";
}

if ($uid == '')
{
    $sql = "SELECT invcode as invc from user_invitation_code where status = 'default' order by invcid desc limit 1 ";
}
$res = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_array($res))
{
    $invcode = $row['invc'];
    $thiscode = $invcode;
    $thislink = 'signup.php?referCode=' . $thiscode . '';
}
else
{
    $thiscode = '';
    $thislink = 'signup.php';
}
if ($uid != '')
{
    if (!empty($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS'])
    {
        $uri = 'https://';
    }
    else
    {
        $uri = 'http://';
    }
    $host = $_SERVER["SERVER_NAME"];
    $thishost = $host;
    $thisuri = $uri;

    if ($host == 'localhost')
    {
        if (file_exists('../signup.php'))
        {
            $thislink = $thisuri . '' . $thishost . '/' . 'pressearn-final/signup.php?referCode=' . $thiscode . '';
        }
    }
    else
    {
        $thislink = $thisuri . '' . $thishost . '/' . 'signup.php?referCode=' . $thiscode . '';
    }

    $qrimg = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $thislink;
    $file = $qrimg;
    $data = ['code' => $thiscode, 'link' => $thislink, 'img' => $file];
    echo json_encode($data);
}

