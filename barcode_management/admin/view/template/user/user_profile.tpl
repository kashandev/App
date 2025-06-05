<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php echo $column_left; ?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/colReorder.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/rowReorder.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/scroller.bootstrap.css" />

    <link href="./assets/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
    <!--end of page level css-->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?php echo $lang['heading_title']; ?></h1>
                    <ol class="breadcrumb">
                        <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <li>
                            <a href="<?php echo $breadcrumb['href']; ?>">
                                <i class="<?php echo $breadcrumb['class']; ?>"></i>
                                <?php echo $breadcrumb['text']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <div class="action-button">
                        <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                            <i class="fa fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </a>
                        <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();">
                            <i class="fa fa-floppy-o"></i>
                            &nbsp;<?php echo $lang['save']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <?php if ($error_warning) { ?>
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                <?php echo $error_warning; ?>
            </div>
        </div>
        <?php } ?>
        <?php  if ($success) { ?>
        <div class="col-sm-12">
            <div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                <?php echo $success; ?>
            </div>
        </div>
        <?php  } ?>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form action="<?php echo $action_save; ?>" method="post" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" >
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php echo $breadcrumb['text']; ?></h3>
                                    </div>

                                    <div class="panel-body">
                                        <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="company_id" value="<?php echo $this->user->getCompanyId(); ?>" />
                                                <div class="form-group">
                                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['user_name']; ?></label>
                                                    <input type="text" name="user_name" value="<?php echo $user_name; ?>" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['email']; ?></label>
                                                    <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['login_id']; ?></label>
                                                    <input type="text" name="login_id" value="<?php echo $login_id; ?>" class="form-control" readonly="true"/>
                                                </div>

                                                <?php  if($password_info != '') { ?>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="password_info">
                                                            <?php echo $password_info; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php  } ?>

                                                <div class="form-group">
                                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['password']; ?></label>
                                                    <input type="password" id="password" name="login_password" value="" autocomplete="off" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['confirm']; ?></label>
                                                    <input type="password" id="confirm" name="confirm" value="" autocomplete="off" class="form-control"/>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-file">
                                                                <img alt="User profile picture" src="<?php echo $src_user_image; ?>"  id="src_user_image" alt="" title="" data-placeholder="<?php echo $no_image; ?>" />
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail img-max">
                                                            </div>
                                                            <div>
                                                                                <span class="btn btn-default btn-file ">
                                                                                <span class="fileinput-new"><?php echo $lang['select_image']; ?></span>
                                                                                <span class="fileinput-exists"><?php echo $lang['change']; ?></span>
                                                                                <input type="file" name="user_image" >
                                                                                </span>
                                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?php echo $lang['remove']; ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </aside>
    <!-- right-side -->
    <?php echo $page_footer; ?>
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>

<script src="./assets/jasny-bootstrap.js" type="text/javascript"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>
<?php echo $footer; ?>
</body>
</html>