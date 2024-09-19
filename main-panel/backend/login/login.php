<?php include_once "../session/session.php";
include_once "../ip/ip.php";
include_once "../conn/config.php";
include_once "../date/date.php";
if (isset($_POST["email"])) {
    $data = [];
    $Email = $_POST["email"];
    $Password = $_POST["password"];
    $User_ID_PK = "";
    $User_Name = "";
    $Decrypted_Password = $Password;
    $Encrypted_Password = "";
    $User_Email = "";
    $User_Image_Name = "";
    $User_Image_Guid = "";
    $User_Company_ID = "";
    $checkemail = false;
    $checkpass = false;
    $Remarks = "";
    $sql = "SELECT uname,decpass from users where uname = '" . $Email . "' ";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $checkemail = $row["uname"];
        $checkpass = $row["decpass"];
    } else {
        $checkemail = "";
        $checkpass = "";
    }
    $sql =
        "SELECT decpass from users where decpass = '" .
        $Decrypted_Password .
        "' ";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $checkpass = $row["decpass"];
    } else {
        $checkpass = "";
    }
    if ($checkemail == "" && $checkpass != "") {
        $data = ["error_message" => "Username is incorrect.", "login" => "2"];
    } elseif ($checkemail == "" && $checkpass == "") {
        $data = [
            "error_message" => "Username and password is incorrect.",
            "login" => "3",
        ];
    } elseif ($checkpass == "") {
        $data = ["error_message" => "Password is incorrect.", "login" => "4"];
    } else {
        if ($checkemail == $Email && $checkpass == $Decrypted_Password) {
            $sql =
                "SELECT users.*,roles.*,(select user_company.cid from user_company WHERE user_company.uid = users.userid and user_company.isdeleted =0 LIMIT 1) as usercompanyid from users inner join roles on roles.roleid = users.roleid WHERE users.uname = '" .
                $Email .
                "' and users.isdeleted = 0";
            $res = mysqli_query($conn, $sql);
            foreach ($res as $key => $row) {
                $User_ID_PK = $row["userid"];
                $User_Role_ID = $row["roleid"];
                $User_Role = $row["role"];
                $User_Name = $row["uname"];
                $User_Email = $row["email"];
                $Encrypted_Password = $row["encpass"];
                $User_Image_Name = $row["uimgname"];
                $User_Image_Guid = $row["uimgguid"];
                $User_Company_ID = $row["usercompanyid"];
                $Remarks = $User_Role . " " . "login";
                if (
                    $Email == $User_Name &&
                    md5($Decrypted_Password) == $Encrypted_Password
                ) {
                    $_SESSION["user_id_pk"] = $User_ID_PK;
                    $_SESSION["user_name"] = $User_Name;
                    $_SESSION["user_email"] = $User_Email;
                    $_SESSION["user_image_name"] = $User_Image_Name;
                    $_SESSION["user_image_guid"] = $User_Image_Guid;
                    $_SESSION["user_role_id"] = $User_Role_ID;
                    $_SESSION["user_role"] = $User_Role;
                    $_SESSION["user_company_id"] = $User_Company_ID;
                    $data = [
                        "success_message" =>
                            "Login SuccessFul. Redirecting....",
                        "login" => "1",
                    ];
                    $_SESSION["welcome_message"] = "Welcome";
                    $sql =
                        "INSERT INTO `user_login`(`uid`,`remarks`,`logindate`,`device`,`ip`,`islogin`,`status`)
                 VALUES ('$User_ID_PK','$Remarks','" .
                        $Login_Date .
                        "','$device','$ip',1,'login')";
                    $res = mysqli_query($conn, $sql);
                    $sql =
                        "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$User_ID_PK','$Remarks','" .
                        $Login_Date .
                        "','$device','$ip','login')";
                    $res = mysqli_query($conn, $sql);
                }
            }
        }
    }
    echo json_encode($data);
} ?>
