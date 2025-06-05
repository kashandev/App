<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php echo $column_left; ?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <!--page level css -->
    <link href="../assets/jasny-bootstrap.css" rel="stylesheet" type="text/css" />
    <!--end of page level css-->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="action-button">
                        <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                            <i class="fa fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </a>
                        <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();" id="myWish">
                            <i class="fa fa-floppy-o"></i>
                            &nbsp;<?php echo $lang['save']; ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <?php if ($error_warning) { ?>
        <div class="col-md-12" id="danger-alert">
            <div class="alert alert-danger alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                <?php echo $error_warning; ?>
            </div>
        </div>
        <?php } ?>
        <?php  if ($success) { ?>
        <div class="col-md-12" id="success-alert">
            <div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                <?php echo $success; ?>
            </div>
        </div>
        <?php  } ?>
        <!-- Main content -->
        <section class="content">
            <form action="<?php echo $action_save; ?>" method="post" enctype="multipart/form-data" id="form">
            <div class="row padding-left_right_15">
                <div class="col-md-12">
                    <div class="panel panel-danger" >
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $breadcrumb['text']; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#general_tab" data-toggle="tab"> General</a>
                                    </li>
                                    <li>
                                        <a href="#mail_tab" data-toggle="tab"> Mail </a>
                                    </li>
                                    <li>
                                        <a href="#mail_template_tab" data-toggle="tab"> Mail Templates </a>
                                    </li>
                                </ul>

                            </div>
                            <div class="tab-content mar-top">
                                <div id="general_tab" class="tab-pane fade active in">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['portal_name']; ?></label>
                                                                <input type="text" id="portal_name" name="portal_name" value="<?php echo $portal_name; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['portal_owner']; ?></label>
                                                                <input type="text" id="portal_owner" name="portal_owner" value="<?php echo $portal_owner; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['address']; ?></label>

                                                                <textarea id="address" name="address" class="form-control" ><?php echo $address; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['email']; ?></label>
                                                                <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['telephone']; ?></label>
                                                                <input type="text" id="telephone" name="telephone" value="<?php echo $telephone; ?>" class="form-control fPhone"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['fax']; ?></label>
                                                                <input type="text" id="fax" name="fax" value="<?php echo $fax; ?>" class="form-control fPhone"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['trial_period']; ?></label>
                                                                <input type="text" id="trial_period" name="trial_period" value="<?php echo $trial_period; ?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group text-center">
                                                                <label><?php echo $lang['entry_company_logo']; ?></label><br />

                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail img-file">
                                                                        <img alt="Company Logo" src="<?php echo $src_company_image; ?>"  id="src_company_image" alt="" title="" data-placeholder="<?php echo $no_image; ?>"/>
                                                                        <input type="hidden" id="company_logo" name="company_logo" value="<?php echo $company_logo; ?>" />
                                                                    </div>
                                                                    <div class="fileinput-preview fileinput-exists thumbnail img-max">
                                                                    </div>
                                                                    <div>
                                                                                                <span class="btn btn-default btn-file ">
                                                                                                <span class="fileinput-new"><?php echo $lang['select_image']; ?></span>
                                                                                                <span class="fileinput-exists"><?php echo $lang['change']; ?></span>
                                                                                                <input type="file" name="company_image">
                                                                                                </span>
                                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><?php echo $lang['remove']; ?></a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label><h4><b>&nbsp;<?php echo $lang['privacy_policies']; ?></b></h4></label>
                                                                <textarea id="privacy_policy" name="privacy_policy" class="form-control"><?php echo $privacy_policy; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><h4><b>&nbsp;<?php echo $lang['term_conditions']; ?></b></h4></label>
                                                                <textarea id="terms_condition" name="terms_condition" class="form-control"><?php echo $terms_condition; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="mail_tab" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['mail_portal']; ?></label><br />
                                                                <span class="help"><?php echo $lang['mail_portal_text']; ?></span>
                                                                <select id="mail_portal" name="mail_portal" class="form-control select2" style="width: 100%;">
                                                                    <option value="Mail" <?php echo ($mail_portal == 'Mail'?'selected="true"':'')?>><?php echo $lang['mail']; ?></option>
                                                                    <option value="SMTP" <?php echo ($mail_portal == 'SMTP'?'selected="true"':'')?>><?php echo $lang['smtp']; ?></option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['smtp_parameter']; ?></label><br />
                                                                <span class="help"><?php echo $lang['smtp_parameter_text']; ?></span>
                                                                <input type="text" id="smtp_parameter" name="smtp_parameter" value="<?php echo $smtp_parameter; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['smtp_host']; ?></label>
                                                                <input type="text" id="smtp_host" name="smtp_host" value="<?php echo $smtp_host; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['smtp_username']; ?></label>
                                                                <input type="text" id="smtp_username" name="smtp_username" value="<?php echo $smtp_username; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['smtp_password']; ?></label>
                                                                <input type="text" id="smtp_password" name="smtp_password" value="<?php echo $smtp_password; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['smtp_port']; ?></label>
                                                                <input type="text" id="smtp_port" name="smtp_port" value="<?php echo $smtp_port; ?>" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>&nbsp;<?php echo $lang['smtp_timeout']; ?></label>
                                                                <input type="text" id="smtp_timeout" name="smtp_timeout" value="<?php echo $smtp_timeout; ?>" class="form-control"/>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="mail_template_tab" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <ul class="nav nav-stacked nav-pills">
                                                                <li class="active">
                                                                    <a href="#welcome_tab" data-toggle="tab">Welcome Mail</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#ticket_tab" data-toggle="tab">Ticket Mail</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#support_mail_tab" data-toggle="tab">Support Mail</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#close_ticket_mail_tab" data-toggle="tab">Close Ticket Mail</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#forgot_password" data-toggle="tab"><?php echo $lang['forgot_password'];?></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="tab-content">
                                                                <div id="welcome_tab" class="tab-pane fade active in">
                                                                    <div class="panel">
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['from']; ?></label>
                                                                                        <input type="text" id="mail_welcome_from" name="mail_welcome_from" value="<?php echo $mail_welcome_from; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['reply_to']; ?></label>
                                                                                        <input type="text" id="mail_welcome_reply_to" name="mail_welcome_reply_to" value="<?php echo $mail_welcome_reply_to; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['subject']; ?></label>
                                                                                        <input type="text" id="mail_welcome_subject" name="mail_welcome_subject" value="<?php echo $mail_welcome_subject; ?>" class="form-control"/>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="panel panel-primary" >
                                                                                        <div class="panel-heading">
                                                                                            <h3 class="panel-title"><?php echo $lang['legend']; ?></h3>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            <fieldset>
                                                                                                <div class="form-group">
                                                                                                    <ul>
                                                                                                        <li>[COMPANY]</li>
                                                                                                        <li>[EMAIL]</li>
                                                                                                        <li>[PASSWORD]</li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['body']; ?></label>
                                                                                        <textarea id="mail_welcome_body" name="mail_welcome_body" value="<?php echo $mail_welcome_body; ?>" class="form-control"><?php echo $mail_welcome_body; ?>
                                                                                        </textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="ticket_tab" class="tab-pane fade">
                                                                    <div class="panel">
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['from']; ?></label>
                                                                                        <input type="text" id="mail_new_ticket_from" name="mail_new_ticket_from" value="<?php echo $mail_new_ticket_from; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['reply_to']; ?></label>
                                                                                        <input type="text" id="mail_new_ticket_reply_to" name="mail_new_ticket_reply_to" value="<?php echo $mail_new_ticket_reply_to; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['subject']; ?></label>
                                                                                        <input type="text" id="mail_new_ticket_subject" name="mail_new_ticket_subject" value="<?php echo $mail_new_ticket_subject; ?>" class="form-control"/>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="panel panel-primary" >
                                                                                        <div class="panel-heading">
                                                                                            <h3 class="panel-title"><?php echo $lang['legend']; ?></h3>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            <fieldset>
                                                                                                <div class="form-group">
                                                                                                    <ul>
                                                                                                        <li>[TICKETNUMBER]</li>
                                                                                                        <li>[CONTACTFIRSTNAME]</li>
                                                                                                        <li>[SUBJECT]</li>
                                                                                                        <li>[DESCRIPTION]</li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['body']; ?></label>
                                                                                        <textarea id="mail_new_ticket_body" name="mail_new_ticket_body" value="<?php echo $mail_new_ticket_body; ?>" class="form-control"><?php echo $mail_new_ticket_body; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="support_mail_tab" class="tab-pane fade">
                                                                    <div class="panel">
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['from']; ?></label>
                                                                                        <input type="text" id="mail_support_ticket_from" name="mail_support_ticket_from" value="<?php echo $mail_support_ticket_from; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['reply_to']; ?></label>
                                                                                        <input type="text" id="mail_support_ticket_reply_to" name="mail_support_ticket_reply_to" value="<?php echo $mail_support_ticket_reply_to; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['subject']; ?></label>
                                                                                        <input type="text" id="mail_support_ticket_subject" name="mail_support_ticket_subject" value="<?php echo $mail_support_ticket_subject; ?>" class="form-control"/>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="panel panel-primary" >
                                                                                        <div class="panel-heading">
                                                                                            <h3 class="panel-title"><?php echo $lang['legend']; ?></h3>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            <fieldset>
                                                                                                <div class="form-group">
                                                                                                    <ul>
                                                                                                        <li>[TICKETNUMBER]</li>
                                                                                                        <li>[CONTACTFIRSTNAME]</li>
                                                                                                        <li>[SUBJECT]</li>
                                                                                                        <li>[COMMENTS]</li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['body']; ?></label>
                                                                                        <textarea id="mail_support_ticket_body" name="mail_support_ticket_body" value="<?php echo $mail_support_ticket_body; ?>" class="form-control"><?php echo $mail_support_ticket_body; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="close_ticket_mail_tab" class="tab-pane fade">
                                                                    <div class="panel">
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['from']; ?></label>
                                                                                        <input type="text" id="mail_close_ticket_from" name="mail_close_ticket_from" value="<?php echo $mail_close_ticket_from; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['reply_to']; ?></label>
                                                                                        <input type="text" id="mail_close_ticket_reply_to" name="mail_close_ticket_reply_to" value="<?php echo $mail_close_ticket_reply_to; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['subject']; ?></label>
                                                                                        <input type="text" id="mail_close_ticket_subject" name="mail_close_ticket_subject" value="<?php echo $mail_close_ticket_subject; ?>" class="form-control"/>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="panel panel-primary" >
                                                                                        <div class="panel-heading">
                                                                                            <h3 class="panel-title"><?php echo $lang['legend']; ?></h3>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            <fieldset>
                                                                                                <div class="form-group">
                                                                                                    <ul>
                                                                                                        <li>[TICKETNUMBER]</li>
                                                                                                        <li>[CONTACTFIRSTNAME]</li>
                                                                                                        <li>[SUBJECT]</li>
                                                                                                        <li>[COMMENTS]</li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['body']; ?></label>
                                                                                        <textarea id="mail_close_ticket_body" name="mail_close_ticket_body" value="<?php echo $mail_close_ticket_body; ?>" class="form-control"><?php echo $mail_close_ticket_body; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="forgot_password" class="tab-pane fade">
                                                                    <div class="panel">
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['from']; ?></label>
                                                                                        <input type="text" id="mail_forgot_password_from" name="mail_forgot_password_from" value="<?php echo $mail_forgot_password_from; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['reply_to']; ?></label>
                                                                                        <input type="text" id="mail_forgot_password_reply_to" name="mail_forgot_password_reply_to" value="<?php echo $mail_forgot_password_reply_to; ?>" class="form-control"/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['subject']; ?></label>
                                                                                        <input type="text" id="mail_forgot_password_subject" name="mail_forgot_password_subject" value="<?php echo $mail_forgot_password_subject; ?>" class="form-control"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="panel panel-primary" >
                                                                                        <div class="panel-heading">
                                                                                            <h3 class="panel-title"><?php echo $lang['legend']; ?></h3>
                                                                                        </div>
                                                                                        <div class="panel-body">
                                                                                            <fieldset>
                                                                                                <div class="form-group">
                                                                                                    <ul>
                                                                                                        <li>[LINK]</li>
                                                                                                        <li>[EMAIL]</li>
                                                                                                        <li>[USERNAME]</li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-10">
                                                                                    <div class="form-group">
                                                                                        <label>&nbsp;<?php echo $lang['body']; ?></label>
                                                                                        <textarea id="mail_forgot_password_body" name="mail_forgot_password_body" value="<?php echo $mail_forgot_password_body; ?>" class="form-control"><?php echo $mail_forgot_password_body; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </form> <!-- Form End -->
        </section><!-- /.content -->
        <?php echo $page_footer; ?>
    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<script type="text/javascript" src="../assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>
<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        CKEDITOR.replace('privacy_policy');
        CKEDITOR.replace('terms_condition');
        CKEDITOR.replace('mail_welcome_body');
        CKEDITOR.replace('mail_new_ticket_body');
        CKEDITOR.replace('mail_support_ticket_body');
        CKEDITOR.replace('mail_close_ticket_body');
        CKEDITOR.replace('mail_forgot_password_body');
    });
</script>

<script src="../assets/jasny-bootstrap.js" type="text/javascript"></script>
<?php echo $footer; ?>
</body>
</html>