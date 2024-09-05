<?php
// upload //
    // upload function //
        $file = "";
        $temp = "";
        $file_path = "";
        $this_file_path = "";
        $output = [];
        if ($_FILES["file"]["name"] != "")
        {
            $file = $_FILES["file"]["name"];
            $temp = $_FILES["file"]["tmp_name"];

            if (!empty($file))
            {
                $file_path = "../backend/public/images/deposit/" . $file;
                if (file_exists($file_path))
                {
                    $this_file_path = "this image already exists";
                    $output = ["imageurl" => "", "image" => "", "msg" => $this_file_path, ];
                }
                else
                {
                    $this_file_path = $file_path;
                    move_uploaded_file($temp, $file_path);
                    $output = ["imageurl" => $this_file_path, "image" => $file ];
                }
                echo json_encode($output);
            }
        }
    // end of upload function //
    

?>