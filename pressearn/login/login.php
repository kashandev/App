<?php
// login //
// include session //
include_once '../session/session.php'; // this is used for include session //
// end of include session //
// include ip //
include_once '../ip/ip.php'; // this is used for include ip //
// end of include ip //
// include conn //
include_once '../conn/conn.php'; // this is used for include conn //
// end of include conn //

// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //

if (isset($_POST['uname'])) {
    $data = [];

    // initializing variables//
    $Email = $_POST['uname'];
    $Password = $_POST['upass'];
    $User_ID_PK = "";
    $User_Name = "";
    $Dec_Password = "";
    $Ref_Code = "";
    $My_Ref_Code = "";
    $Encrypted_Password = "";
    $Decrypted_Password = "";
    $Decrypted_Password = $Password;
    $User_Email = "";
    $User_Image_Name = "";
    $User_Image_Guid = "";
    $User_Inv_ID = "";
    $Team_ID = "";
    $check = false;
    $Remarks = "";
    $loginurl = "";
    $loginid = "";
    // end of initializing variables//

    // check empty feilds //
    if ($Email == "" && $Password == "") {
        $data = [
            'error_message' => "You must specify a username & password to login",
            'login' => '0',
        ];
    }
    // end of check empty feilds //
    // check row //
    else {
        // login query //
        $sql =
            "SELECT users.*,roles.*,(SELECT user_invitation_code.invcid from user_invitation_code WHERE user_invitation_code.uid=users.userid LIMIT 1) as uinvid,(SELECT user_invitation_code.invcode from user_invitation_code WHERE user_invitation_code.uid=users.userid LIMIT 1) as uinvcode,(SELECT teams.tmid from teams WHERE teams.uid=users.userid LIMIT 1) as tmid from users inner join roles on roles.roleid = users.roleid WHERE users.isdeleted = 0 and uname = '" .
            $Email .
            "' and roles.role in('user')";
        // end of login query //

        // get result //
        $res = mysqli_query($conn, $sql);

        // check num rows //
        if (mysqli_num_rows($res)) {
            // loop for get rows //
            foreach ($res as $key => $row) {
                // set rows in variables from db
                $User_ID_PK = $row['userid'];
                $User_Role_ID = $row['roleid'];
                $User_Role = $row['role'];
                $User_Name = $row['uname'];
                $Ref_Code = $row['refcode'];
                $My_Ref_Code = $row['uinvcode'];
                $User_Email = $row['email'];
                $Encrypted_Password = $row['encpass'];
                $Dec_Password = $row['decpass'];
                $User_Image_Name = $row['uimgname'];
                $User_Image_Guid = $row['uimgguid'];
                $User_Inv_ID = $row['uinvid'];
                $Team_ID = $row['tmid'];
                $Remarks = $User_Role . " " . "login";
                $loginid = 'loginid=' . base64_encode($User_ID_PK) . '';
                $loginurl = 'my-account.php?' . '' . $loginid . '&pageid=account';

                //end of set rows in variables from db //

                // check variables //
                if ($Email == $User_Name && md5($Decrypted_Password) == $Encrypted_Password) {
                    $_SESSION['u_id_pk'] = $User_ID_PK;
                    $_SESSION['u_name'] = $User_Name;
                    $_SESSION['ref_code'] = $Ref_Code;
                    $_SESSION['my_ref_code'] = $My_Ref_Code;
                    $_SESSION['u_email'] = $User_Email;
                    $_SESSION['u_image_name'] = $User_Image_Name;
                    $_SESSION['u_image_guid'] = $User_Image_Guid;
                    $_SESSION['u_role_id'] = $User_Role_ID;
                    $_SESSION['u_role'] = $User_Role;
                    $_SESSION['u_inv_id'] = $User_Inv_ID;
                    $_SESSION['u_tm_id'] = $Team_ID;
                    $_SESSION['login_id'] = $loginid;

                    $data = [
                        'success_message' => "Login SuccessFul. Redirecting....",
                        'login' => '1',
                        'loginurl' => $loginurl,
                    ];
                    $_SESSION['welcome_user_message'] = 'Welcome';

                    $sql =
                        "INSERT INTO `user_login`(`uid`,`remarks`,`loginid`,`logindate`,`device`,`ip`,`islogin`,`status`)
                 VALUES ('$User_ID_PK','$Remarks','$loginid','" .
                        $Login_Date .
                        "','$device','$ip',1,'login')";
                    $res = mysqli_query($conn, $sql);

                    $sql =
                        "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$User_ID_PK','$Remarks','" .
                        $Login_Date .
                        "','$device','$ip','login')";
                    $res = mysqli_query($conn, $sql);
                } elseif ($Email == $User_Name && md5($Decrypted_Password) != $Encrypted_Password) {
                    $data = [
                        'error_message' => "The password that you've entered is incorrect. Forgotten password?",
                        'login' => '2',
                    ];
                } // end of check variables //
            } // end of loop for get rows//
        }
        // end of check num rows//
        else {
            // check false result//

            if ($User_Name == "" && $Dec_Password == "") {
                $data = [
                    'error_message' => "The username & password that you've entered is incorrect",
                    'login' => '3',
                ];
            }
        } // end of check false result//
    } // end of check row //
    echo json_encode($data); // return json output //
}
?>
