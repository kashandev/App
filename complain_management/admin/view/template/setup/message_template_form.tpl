<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <style>
        .msg {
            resize: none;
        }
    </style>
<div class="wrapper">
    <?php echo $page_header; ?>
    <?php echo $column_left; ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><?php echo $lang['heading_title']; ?></h1>
            <div class="row">
                <div class="col-sm-6">
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
                    <div class="pull-right">
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
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <?php if ($error_warning) { ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <?php echo $error_warning; ?></div>
                            <?php } ?>
                            <?php  if ($success) { ?>
                            <div class="alert alert-success alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <?php echo $success; ?></div>
                            <?php  } ?>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo $action_update; ?>" method="post" enctype="multipart/form-data" id="form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required"></span>&nbsp;<?php echo $lang['job_order_message_box']; ?></label>
                                            <textarea class="form-control msg" name="job_order_message_box" id="job_order_message_box" type="text" rows="6" cols="6"><?php echo $job_order_message_box ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required"></span>&nbsp;<?php echo $lang['job_order_message_tags']; ?></label>
                                            <ul><li><?php echo $CN ?></li>
                                            <li><?php echo $JN ?></li>
                                            <li><?php echo $JAMT ?></li>
                                            </ul>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required"></span>&nbsp;<?php echo $lang['estimate_message_box']; ?></label>
                                            <textarea class="form-control msg" name="estimate_message_box" id="estimate_message_box" type="text" rows="6" cols="6"><?php echo $estimate_message_box ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required"></span>&nbsp;<?php echo $lang['estimate_message_tags']; ?></label>
                                            <ul><li><?php echo $CN ?></li>
                                            <li><?php echo $ESTN ?></li>
                                            <li><?php echo $JN ?></li>
                                            <li><?php echo $ESTAMT ?></li>
                                            </ul>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required"></span>&nbsp;<?php echo $lang['sale_invoice_message_box']; ?></label>
                                            <textarea class="form-control msg" name="sale_invoice_message_box" id="sale_invoice_message_box" type="text" rows="6" cols="6"><?php echo $sale_invoice_message_box ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required"></span>&nbsp;<?php echo $lang['sale_invoice_message_tags']; ?></label>
                                            <ul><li><?php echo $CN ?></li>
                                            <li><?php echo $SIN ?></li>
                                            <li><?php echo $JN ?></li>
                                            <li><?php echo $SINAMT ?></li>
                                            </ul>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
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
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
    <script>
        jQuery('#form').validate(<?php echo $strValidation; ?>);
    </script>
    <?php echo $page_footer; ?>
    <?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>