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

        <?php if ($error_warning){ ?>
        <div class="col-sm-12" id="danger-alert" >
            <div class="alert alert-danger alert-dismissable">

                <?php echo $error_warning; ?>
            </div>
        </div>
        <?php } ?>

        <div id="output"></div>
        <div>
            <img alt="User profile picture" src="<?php echo $user_image; ?>" data-placeholder="<?php echo $no_image; ?>" />

        </div>
        <div class="form-box">
            <form action="<?php echo $action; ?>" id="authentication" autocomplete="on" method="post">
                <div class="form">
                    <p class="form-control-static"><?php echo $user_name; ?></p>
                    <p><input type="hidden" id="login_id" name="login_id" class="form-control" value="<?php echo $login_id;?>"></p>
                    <input type="password" id="login_password" name="login_password" class="form-control" placeholder="<?php echo $lang['login_password']; ?>">
                    <button class="btn btn-info btn-block" type="submit"><?php echo $lang['lock']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- global js -->



<!-- global js -->
<script src="view/js/app.js" type="text/javascript"></script>
<script src="../assets/fort.js"></script>
<script src="../assets/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
<!-- end of global js -->
<script src="../assets/iCheck/js/icheck.js" type="text/javascript"></script>
</body>
</html>
