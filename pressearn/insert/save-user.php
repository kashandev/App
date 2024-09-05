<?php
include_once ('../session/session.php');
include_once ('../conn/conn.php');
$data = array();
$msg = '';
$btn = '';
$timestamp = '';
$createdate = '';
$date = '';
$bnkregno = '';
$bnkfname = '';
$bnkfathername = '';
$bnkcnic = '';
$bnkaddress = '';
$bnkprovince = '';
$bnkoffaddress = '';
$bnkemail = '';
$bnkphone = '';
$bnkwhatsapp = '';
$bnkkin = '';
$nom = '';
$nomcnic = '';
$easyregno = '';
$easyfname = '';
$easyfathername = '';
$easycnic = '';
$easyaddress = '';
$easyprovince = '';
$easyoffaddress = '';
$easyemail = '';
$easyphone = '';
$easywhatsapp = '';
$easykin = '';
$jazzregno = '';
$jazzfname = '';
$jazzfathername = '';
$jazzcnic = '';
$jazzaddress = '';
$jazzprovince = '';
$jazzoffaddress = '';
$jazzemail = '';
$jazzphone = '';
$jazzwhatsapp = '';
$jazzkin = '';
$bid = '';
$eid = '';
$jid = '';
$fid = '';
$timestamp = time();
$createdate = date("Y-m-d h:i:s", $timestamp);
$date = date("d-m-Y");
if (isset($_POST['paymentmethod']))
{
    $paymentmethod = $_POST['paymentmethod'];

    if ($paymentmethod == 'bank')
    {
        $bnkregno = $_POST['bnkregno'];
        $bnkfname = $_POST['bnkfname'];
        $bnkfathername = $_POST['bnkfathername'];
        $bnkcnic = $_POST['bnkcnic'];
        $bnkaddress = $_POST['bnkaddress'];
        $bnkprovince = $_POST['bnkprovince'];
        // $bnkoffaddress = $_POST['bnkoffaddress'];
        $bnkemail = $_POST['bnkemail'];
        $bnkphone = $_POST['bnkphone'];
        $bnkwhatsapp = $_POST['bnkwhatsapp'];
        // $bnkkin        = $_POST['bnkkin'];
        $nom = $_POST['nom'];
        $nomcnic = $_POST['nomcnic'];
        $relation = $_POST['relation'];

        // $_SESSION['date'] = $date;
        // $_SESSION['paymentmethod'] = $paymentmethod;
        // $_SESSION['bnkregno'] = $bnkregno;
        // $_SESSION['bnkfname'] = $bnkfname;
        // $_SESSION['bnkfathername'] = $bnkfathername ;
        // $_SESSION['bnkcnic'] = $bnkcnic;
        // $_SESSION['bnkaddress'] = $bnkaddress;
        // $_SESSION['bnkprovince'] = $bnkprovince;
        // $_SESSION['bnkoffaddress'] = $bnkoffaddress;
        // $_SESSION['bnkemail'] = $bnkemail;
        // $_SESSION['bnkphone'] = $bnkphone;
        // $_SESSION['bnkwhatsapp'] = $bnkwhatsapp;
        // $_SESSION['bnkkin'] = $bnkkin;
        

        //         $sql = "INSERT INTO `bank`( `regid`, `pmethod`, `fullname`, `fathersname`, `cnic`, `resaddress`, `province`, `offaddress`, `email`, `phone`, `whatsappno`, `kin`, `createdate`)
        // VALUES ('$bnkregno','$paymentmethod','$bnkfname','$bnkfathername','$bnkcnic','$bnkaddress','$bnkprovince','$bnkoffaddress','$bnkemail','$bnkphone','$bnkwhatsapp','$bnkkin','$createdate')"
        $sql = "INSERT INTO `forms_master`(`regno`, `pmethod`, `fullname`, `fathersname`, `cnic`, `resaddress`, `province`, `offaddress`, `email`, `phone`, `whatsappno`, `kin`, `nom` ,`nomcnic`,`relation`,`createdate`) 
      VALUES ('$bnkregno','$paymentmethod','$bnkfname','$bnkfathername','$bnkcnic','$bnkaddress','$bnkprovince','$bnkoffaddress','$bnkemail','$bnkphone','$bnkwhatsapp','$bnkkin','$nom','$nomcnic','$relation','$createdate')";

        if (mysqli_query($conn, $sql))
        {
            // $sql = "SELECT LAST_INSERT_ID()";
            // $res = mysqli_query($conn, $sql);
            // $row = mysqli_fetch_array($res);
            // $bid = $row[0];
            $sql = "SELECT LAST_INSERT_ID()";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($res);
            $fid = $row[0];
            $sql = "INSERT INTO `regno`(`fid`,`regno`,`createdate`)
            VALUES ('$fid','$bnkregno','$createdate')";
            $res = mysqli_query($conn, $sql);
            $sql = "INSERT INTO `forms`( `fid`,`createdate`)
            VALUES ('$fid','$createdate')";
            $res = mysqli_query($conn, $sql);
            $msg = 'Form details successfully saved';
            $btn = ' <a type="button" href="" class="btn btn-primary submisson-btn btn-download" id="download">Download Pdf</a>';
        }
        else
        {
            $msg = 'Failed';
            $btn = '';
            $fid = '';
        }
    }
    //     if ($paymentmethod == 'easy') {
    //         $easyregno      = $_POST['easyregno'];
    //         $easyfname      = $_POST['easyfname'];
    //         $easyfathername = $_POST['easyfathername'];
    //         $easycnic       = $_POST['easycnic'];
    //         $easyaddress    = $_POST['easyaddress'];
    //         $easyprovince   = $_POST['easyprovince'];
    //         $easyoffaddress = $_POST['easyoffaddress'];
    //         $easyemail      = $_POST['easyemail'];
    //         $easyphone      = $_POST['easyphone'];
    //         $easywhatsapp   = $_POST['easywhatsapp'];
    //         $easykin        = $_POST['easykin'];
    //         $_SESSION['date'] = $date;
    //         $_SESSION['paymentmethod'] = $paymentmethod;
    //         $_SESSION['easyregno'] = $easyregno;
    //         $_SESSION['easyfname'] = $easyfname;
    //         $_SESSION['easyfathername'] = $easyfathername ;
    //         $_SESSION['easycnic'] = $easycnic;
    //         $_SESSION['easyaddress'] = $easyaddress;
    //         $_SESSION['easyprovince'] = $easyprovince;
    //         $_SESSION['easyoffaddress'] = $easyoffaddress;
    //         $_SESSION['easyemail'] = $easyemail;
    //         $_SESSION['easyphone'] = $easyphone;
    //         $_SESSION['easywhatsapp'] = $easywhatsapp;
    //         $_SESSION['easykin'] = $easykin;
    //         $sql = "INSERT INTO `easy`( `regid`, `pmethod`, `fullname`, `fathersname`, `cnic`, `resaddress`, `province`, `offaddress`, `email`, `phone`, `whatsappno`, `kin`, `createdate`)
    // VALUES ('$easyregno','$paymentmethod','$easyfname','$easyfathername','$easycnic','$easyaddress','$easyprovince','$easyoffaddress','$easyemail','$easyphone','$easywhatsapp','$easykin','$createdate')";
    //         if (mysqli_query($conn, $sql)) {
    //             $sql = "SELECT LAST_INSERT_ID()";
    //             $res = mysqli_query($conn, $sql);
    //             $row = mysqli_fetch_array($res);
    //             $eid = $row[0];
    //             $sql = "INSERT INTO `regno`( `eid`,`regno`,`createdate`)
    //             VALUES ('$eid','$easyregno','$createdate')";
    //             $res = mysqli_query($conn, $sql);
    //             $sql = "INSERT INTO `forms`( `eid`,`createdate`)
    //             VALUES ('$eid','$createdate')";
    //             $res = mysqli_query($conn, $sql);
    //            $sql = "INSERT INTO `forms_master`(`eid`, `regid`, `pmethod`, `fullname`, `fathersname`, `cnic`, `resaddress`, `province`, `offaddress`, `email`, `phone`, `whatsappno`, `kin`, `createdate`)
    // VALUES ('$eid','$easyregno','$paymentmethod','$easyfname','$easyfathername','$easycnic','$easyaddress','$easyprovince','$easyoffaddress','$easyemail','$easyphone','$easywhatsapp','$easykin','$createdate')";
    //     $res = mysqli_query($conn, $sql);
    //             $msg = 'Easypaisa details successfully saved';
    //             $btn = ' <a type="button" href="view.php" target="_blank" class="btn btn-primary submisson-btn btn-download" id="download">Download Pdf</a>';
    //         } else {
    //             $msg = 'Failed';
    //             $btn = '';
    //         }
    //     }
    //     if ($paymentmethod == 'jazz') {
    //         $jazzregno      = $_POST['jazzregno'];
    //         $jazzfname      = $_POST['jazzfname'];
    //         $jazzfathername = $_POST['jazzfathername'];
    //         $jazzcnic       = $_POST['jazzcnic'];
    //         $jazzaddress    = $_POST['jazzaddress'];
    //         $jazzprovince   = $_POST['jazzprovince'];
    //         $jazzoffaddress = $_POST['jazzoffaddress'];
    //         $jazzemail      = $_POST['jazzemail'];
    //         $jazzphone      = $_POST['jazzphone'];
    //         $jazzwhatsapp   = $_POST['jazzwhatsapp'];
    //         $jazzkin        = $_POST['jazzkin'];
    //         $_SESSION['date'] = $date;
    //         $_SESSION['paymentmethod'] = $paymentmethod;
    //         $_SESSION['jazzregno'] = $jazzregno;
    //         $_SESSION['jazzfname'] = $jazzfname;
    //         $_SESSION['jazzfathername'] = $jazzfathername ;
    //         $_SESSION['jazzcnic'] = $jazzcnic;
    //         $_SESSION['jazzaddress'] = $jazzaddress;
    //         $_SESSION['jazzprovince'] = $jazzprovince;
    //         $_SESSION['jazzoffaddress'] = $jazzoffaddress;
    //         $_SESSION['jazzemail'] = $jazzemail;
    //         $_SESSION['jazzphone'] = $jazzphone;
    //         $_SESSION['jazzwhatsapp'] = $jazzwhatsapp;
    //         $_SESSION['jazzkin'] = $jazzkin;
    //         $sql = "INSERT INTO `jazz`( `regid`, `pmethod`, `fullname`, `fathersname`, `cnic`, `resaddress`, `province`, `offaddress`, `email`, `phone`, `whatsappno`, `kin`, `createdate`)
    // VALUES ('$jazzregno','$paymentmethod','$jazzfname','$jazzfathername','$jazzcnic','$jazzaddress','$jazzprovince','$jazzoffaddress','$jazzemail','$jazzphone','$jazzwhatsapp','$jazzkin','$createdate')";
    //         if (mysqli_query($conn, $sql)) {
    //             $sql = "SELECT LAST_INSERT_ID()";
    //             $res = mysqli_query($conn, $sql);
    //             $row = mysqli_fetch_array($res);
    //             $jid = $row[0];
    //             $sql = "INSERT INTO `regno`( `jid`,`regno`,`createdate`)
    //             VALUES ('$jid','$jazzregno','$createdate')";
    //             $res = mysqli_query($conn, $sql);
    //             $sql = "INSERT INTO `forms`( `jid`,`createdate`)
    //             VALUES ('$jid','$createdate')";
    //             $res = mysqli_query($conn, $sql);
    //   $sql = "INSERT INTO `forms_master`(`jid`, `regid`, `pmethod`, `fullname`, `fathersname`, `cnic`, `resaddress`, `province`, `offaddress`, `email`, `phone`, `whatsappno`, `kin`, `createdate`)
    // VALUES ('$jid','$jazzregno','$paymentmethod','$jazzfname','$jazzfathername','$jazzcnic','$jazzaddress','$jazzprovince','$jazzoffaddress','$jazzemail','$jazzphone','$jazzwhatsapp','$jazzkin','$createdate')";
    //     $res = mysqli_query($conn, $sql);
    //             $msg = 'Jazzcash details successfully saved';
    //             $btn = ' <a type="button" href="view.php" target="_blank" class="btn btn-primary submisson-btn btn-download" id="download">Download Pdf</a>';
    //         } else {
    //             $msg = 'Failed';
    //             $btn = '';
    //         }
    //}
    $data = array(
        'msg' => $msg,
        'btn' => $btn,
        'id' => $fid,
    );
    echo json_encode($data);
}
?>
