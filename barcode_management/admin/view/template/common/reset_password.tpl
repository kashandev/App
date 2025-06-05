<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['heading_title']; ?> | <?php echo CONFIG_APPLICATION_NAME; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php echo $base; ?>"/>
    <!-- global level css -->
    <link href="view/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="view/css/common/login.css" />
    <link href="../assets/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="view/css/common/fort.css" />
    <link href="view/css/common/lockscreen.css" rel="stylesheet" />

</head>

<body>
<div class="container">
    <div class="login-container">

        <div id="output"></div>

        <div class="form-box">
            <form action="<?php echo $action; ?>" autocomplete="on" id="form_password" method="post">
                <div class="form">
                    <p class="form-control-static"><?php echo $lang['heading']; ?></p>
                    <label><span class="required">*</span>&nbsp;<?php echo $lang['new_password']; ?></label>

                    <input type="text" id="login_password" name="login_password" class="form-control" value="<?php echo $login_password;?>">
                    <label><span class="required">*</span>&nbsp;<?php echo $lang['repeat_password']; ?></label>
                    <input type="text" id="repeat_password" name="repeat_password" class="form-control" placeholder="<?php echo $repeat_password; ?>">
                    <button class="btn btn-info btn-block" type="submit"><?php echo $lang['save_password']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- global js -->



<!-- global js -->
<script src="view/js/app.js" type="text/javascript"></script>

<script type="text/javascript" src="../assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form_password').validate(<?php echo $strValidation; ?>);
</script>
<!-- end of global js -->
<script src="../assets/iCheck/js/icheck.js" type="text/javascript"></script>
<script src="view/js/common/login.js" type="text/javascript"></script>
</body>
</html>
