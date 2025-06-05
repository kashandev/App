<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang['heading_title']; ?> | <?php echo CONFIG_APPLICATION_NAME; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php echo $base; ?>"/>
    <!-- global level css -->
    <link href="../admin/view/css/bootstrap.min.css" rel="stylesheet" />
    <!-- end of global level css -->
    <link href="../assets/iCheck/css/square/blue.css" rel="stylesheet" type="text/css" />
    <link href="../assets/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" />
    <!-- page level css -->
    <link rel="stylesheet" type="text/css" href="../admin/view/css/common/login.css" />
    <link rel="stylesheet" type="text/css" href="../admin/view/css/styles.css" />
    <!-- end of page level css -->
</head>

<body>
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-sm-6 col-sm-offset-3 col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
            <div id="container_demo">
                <a class="hiddenanchor" id="toregister"></a>
                <a class="hiddenanchor" id="tologin"></a>
                <a class="hiddenanchor" id="toforgot"></a>
                <div id="wrapper">
                    <div id="login" class="animate form">
                        <form action="<?php echo $action; ?>" id="authentication" autocomplete="on" method="post">
                            <h3 class="black_bg">
                                <label class="text-center"><span style="color: #26a69a">F</span><span style="color: #5c6bc0">A</span><span style="color: #ff7043">S</span></label>
                                <br><?php echo $lang['login']; ?>
                            </h3>
                            <?php if ($error_warning) { ?>
                            <div class="col-sm-12" id="danger-alert" >
                                <div class="alert alert-danger alert-dismissable">
                                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                    <?php echo $error_warning; ?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group ">
                                <label style="margin-bottom:0;" for="login_id" class="uname control-label">
                                    <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                    <?php echo $lang['login_id']; ?>
                                </label>
                                <input id="login_name" name="login_name" placeholder="<?php echo $lang['login_id']; ?>" value="" />
                                <div class="col-sm-12">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label style="margin-bottom:0;" for="login_password" class="youpasswd">
                                    <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                    <?php echo $lang['login_password']; ?>
                                </label>
                                <input type="password" id="login_password" name="login_password" placeholder="<?php echo $lang['login_password']; ?>" />
                                <div class="col-sm-12">
                                </div>
                            </div>
                            <p class="login button">
                                <input type="submit" value="<?php echo $lang['login']; ?>" class="btn btn-success" />
                            </p>

                        </form>
                    </div>

                    <div id="forgot" class="animate form">
                        <form action="<?php echo $password_action; ?>"  autocomplete="on" method="post" id="form_password">
                            <h3 class="black_bg">
                                <label id="logo" class="text-center"><?php echo $company_logo; ?></label>
                                <br><?php echo $lang['forgot_password']; ?>
                            </h3>
                            <div class="form-group">
                                <label style="margin-bottom:0;" for="username2" class="youmai">
                                    <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                    <?php echo $lang['email'];?>
                                </label>
                                <input id="forgot_email" name="forgot_email" placeholder="your@mail.com" />
                            </div>
                            <h5>
                                <p><?php echo $lang['password_text']; ?></p>
                            </h5>
                            <p class="login button">
                                <input type="submit" value="<?php echo $lang['reset_password']; ?>" class="btn btn-success" />
                            </p>
                            <p class="change_link">
                                <a href="#tologin" class="btn btn-raised btn-responsive botton-alignment btn-warning btn-sm to_register">
                                    <?php echo $lang['back']; ?>
                                </a>
                            </p>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="../admin/view/js/app.js" type="text/javascript"></script>
<!-- end of global js -->
<script type="text/javascript" src="../assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form_password').validate(<?php echo $strValidation; ?>);
</script>
</body>
</html>
