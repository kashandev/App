<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php echo $column_left; ?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <!--page level css -->

    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/colReorder.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/rowReorder.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/scroller.bootstrap.css" />

    <link href="./assets/jasny-bootstrap.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="./assets/iCheck/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/iCheck/css/line/line.css">
    <script type="text/javascript" src="./assets/iCheck/js/icheck.js"></script>
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


        <!-- Main content -->
        <section class="content">

            <div class="row padding-left_right_15">
                <div class="col-xs-12">
                    <form action="<?php echo $action_save; ?>" method="post" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" id="hidepanel1">
                                    <div class="panel-heading" style="background-color: #00bc8c;">
                                        <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?php if($this->user->getCompanyId() == 0): ?>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['company']; ?></label>
                                                        <select id="company_id" name="company_id" class="form-control select2" style="width: 100%;">
                                                            <option value="">&nbsp;</option>
                                                            <?php foreach($companies as $company): ?>
                                                            <option value="<?php echo $company['company_id']; ?>" <?php echo ($company_id == $company['company_id']?'selected="true"':'')?>><?php echo $company['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <?php else: ?>
                                                    <input type="hidden" name="company_id" value="<?php echo $this->user->getCompanyId(); ?>" />
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['user_name']; ?></label>
                                                        <input type="text" name="user_name" value="<?php echo $user_name; ?>" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['email']; ?></label>
                                                        <input type="text" name="email" value="<?php echo $email; ?>" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['user_permission']; ?></label>
                                                        <select id="user_permission_id" name="user_permission_id" class="form-control select2" style="width: 100%;">
                                                            <option value="">&nbsp;</option>
                                                            <?php foreach($user_permissions as $permission): ?>
                                                            <option value="<?php echo $permission['user_permission_id']; ?>" <?php echo ($user_permission_id == $permission['user_permission_id']?'selected="true"':'')?>><?php echo $permission['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['login_name']; ?></label>
                                                        <input type="text" name="login_name" value="<?php echo $login_name; ?>" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['password']; ?></label>
                                                        <input type="password" id="login_password" name="login_password" value="" autocomplete="off" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['confirm']; ?></label>
                                                        <input type="password" name="confirm" value="" autocomplete="off" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['status']; ?></label>
                                                        <select id="status" name="status" class="form-control select2" style="width: 100%;">
                                                            <option value="Inactive" <?php echo ($status == 'Inactive'?'selected="true"':'')?>><?php echo $lang['inactive']; ?></option>
                                                            <option value="Active" <?php echo ($status == 'Active'?'selected="true"':'')?>><?php echo $lang['active']; ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group hide">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['colour_theme']; ?></label>
                                                        <select id="colour_theme" name="colour_theme" class="form-control select2" style="width: 100%;" onchange="setColourTheme();">
                                                            <option value="skin-blue" <?php echo ($colour_theme == 'skin-blue'?'selected="true"':'')?>><?php echo $lang['skin_blue']; ?></option>
                                                            <option value="skin-blue-light" <?php echo ($colour_theme == 'skin-blue-light'?'selected="true"':'')?>><?php echo $lang['skin_blue_light']; ?></option>
                                                            <option value="skin-black" <?php echo ($colour_theme == 'skin-black'?'selected="true"':'')?>><?php echo $lang['skin_black']; ?></option>
                                                            <option value="skin-black-light" <?php echo ($colour_theme == 'skin-black-light'?'selected="true"':'')?>><?php echo $lang['skin_black_light']; ?></option>
                                                            <option value="skin-green" <?php echo ($colour_theme == 'skin-green'?'selected="true"':'')?>><?php echo $lang['skin_green']; ?></option>
                                                            <option value="skin-green-light" <?php echo ($colour_theme == 'skin-green-light'?'selected="true"':'')?>><?php echo $lang['skin_green_light']; ?></option>
                                                            <option value="skin-purple" <?php echo ($colour_theme == 'skin-purple'?'selected="true"':'')?>><?php echo $lang['skin_purple']; ?></option>
                                                            <option value="skin-purple-light" <?php echo ($colour_theme == 'skin-purple-light'?'selected="true"':'')?>><?php echo $lang['skin_purple_light']; ?></option>
                                                            <option value="skin-red" <?php echo ($colour_theme == 'skin-red'?'selected="true"':'')?>><?php echo $lang['skin_red']; ?></option>
                                                            <option value="skin-red-light" <?php echo ($colour_theme == 'skin-red-light'?'selected="true"':'')?>><?php echo $lang['skin_red_light']; ?></option>
                                                            <option value="skin-yellow" <?php echo ($colour_theme == 'skin-yellow'?'selected="true"':'')?>><?php echo $lang['skin_yellow']; ?></option>
                                                            <option value="skin-blue-yellow" <?php echo ($colour_theme == 'skin-yellow-light'?'selected="true"':'')?>><?php echo $lang['skin_yellow_light']; ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <a href="javascript:void(0);" id="a_user_image"  data-toggle="image" class="img-thumbnail" data-src_image="src_user_image" data-src_input="file_user_image">
                                                            <img alt="User profile picture" src="<?php echo $src_user_image; ?>"  id="src_user_image" alt="" title="" data-placeholder="<?php echo $no_image; ?>" class="profile-user-img img-responsive img-circle"/>
                                                        </a>
                                                        <input type="hidden" name="user_image" value="<?php echo $user_image; ?>" id="file_user_image" />
                                                        <br />
                                                        <a class="btn btn-primary btn-xs" onclick="jQuery('#src_user_image').attr('src', '<?php echo $no_image; ?>'); jQuery('#file_user_image').attr('value', '');"><?php echo $lang['clear']; ?></a>
                                                        <br />&nbsp;
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['branch_access']; ?></label>
                                                        <?php foreach($branches as $branch): ?>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" id="branch_<?php echo $branch['company_branch_id']?>" name="company_branches[][company_branch_id]" value="<?php echo $branch['company_branch_id']; ?>" <?php echo (in_array($branch['company_branch_id'], $arrBranchAccess)?'checked="true"':''); ?>>
                                                                <?php echo $branch['name']; ?>
                                                            </label>
                                                        </div>
                                                        <?php endforeach; ?>
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
        <?php echo $page_footer; ?>
    </aside>
    <!-- right-side -->
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
