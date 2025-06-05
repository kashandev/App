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
                                                <div class="col-sm-6">
                                                    <div class="tab-pane fade in active" id="general">
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['company_name']; ?></label>
                                                            <input type="text" name="company_name" value="<?php echo $company_name; ?>" class="form-control"/>
                                                        </div>
                                                        <hr />
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['branch_code']; ?></label>
                                                            <input type="text" name="branch_code" value="<?php echo $branch_code; ?>" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['branch_name']; ?></label>
                                                            <input type="text" name="branch_name" value="<?php echo $branch_name; ?>" class="form-control"/>
                                                        </div>
                                                        <hr />
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['default_currency']; ?></label>
                                                            <input type="text" name="default_currency" value="<?php echo $default_currency; ?>" class="form-control"/>
                                                        </div>
                                                        <hr />
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['fiscal_year_code']; ?></label>
                                                            <input type="text" name="fiscal_year_code" value="<?php echo $fiscal_year_code; ?>" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['fiscal_year_title']; ?></label>
                                                            <input type="text" name="fiscal_year_title" value="<?php echo $fiscal_year_title; ?>" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['date_from']; ?></label>
                                                            <input type="text" name="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['date_to']; ?></label>
                                                            <input type="text" name="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate"/>
                                                        </div>
                                                        <hr />
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['user_name']; ?></label>
                                                            <input type="text" name="user_name" value="<?php echo $user_name; ?>" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['user_password']; ?></label>
                                                            <input type="text" name="user_password" value="<?php echo $user_password; ?>" class="form-control"/>
                                                        </div>
                                                        <hr />
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['partner_type']; ?></label>
                                                        <?php foreach($partner_types as $row_no => $partner_type): ?>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="partner_types[<?php echo $row_no; ?>][selected]" value="1" <?php echo $partner_type['selected']==1?'checked="checked"':'' ?>>&nbsp;<?php echo $partner_type['name']; ?>
                                                                <input type="hidden" name="partner_types[<?php echo $row_no; ?>][partner_type_id]" value="<?php echo $partner_type['partner_type_id']; ?>" />
                                                                <input type="hidden" name="partner_types[<?php echo $row_no; ?>][name]" value="<?php echo $partner_type['name']; ?>" />
                                                            </label>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <?php foreach($forms as $form => $permission): ?>
                                                        <div class="col-xs-6">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="form_access[<?php echo $form; ?>]" value="1" <?php echo $permission==1?'checked="checked"':'' ?>>&nbsp;<?php echo $form; ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
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
