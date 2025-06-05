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
                        <form action="<?php echo $action_update; ?>" method="post" enctype="multipart/form-data"
                            id="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary" id="hidepanel1">
                                        <div class="panel-heading" style="background-color: #90a4ae;">
                                            <h3 class="panel-title"><i
                                                    class="fa fa-credit-card"></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?>
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-sm-6 hide">
                                                        <div class="form-group">
                                                            <label><span
                                                                    class="required">*</span>&nbsp;<?php echo $lang['cash_account']; ?></label>
                                                            <select class="form-control" id="cash_account_id"
                                                                name="cash_account_id[]" multiple="multiple">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>"
                                                                    <?php echo (in_array($coa['coa_level3_id'],$cash_account_id) ? 'selected="selected"' : ''); ?>>
                                                                    <?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="cash_account_id" style="display: none;"
                                                                class="error">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><span
                                                                    class="required">*</span>&nbsp;<?php echo $lang['withholding_tax_account']; ?></label>
                                                            <select class="form-control" id="withholding_tax_account_id"
                                                                name="withholding_tax_account_id">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>"
                                                                    <?php echo ($coa['coa_level3_id']==$withholding_tax_account_id ? 'selected="selected"' : ''); ?>>
                                                                    <?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="withholding_tax_account_id"
                                                                style="display: none;" class="error">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><span
                                                                    class="required">*</span>&nbsp;<?php echo $lang['other_tax_account']; ?></label>
                                                            <select class="form-control" id="other_tax_account_id"
                                                                name="other_tax_account_id">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>"
                                                                    <?php echo ($coa['coa_level3_id']==$other_tax_account_id ? 'selected="selected"' : ''); ?>>
                                                                    <?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="other_tax_account_id" style="display: none;"
                                                                class="error">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><span
                                                                    class="required">*</span>&nbsp;<?php echo $lang['transaction_account']; ?></label>
                                                            <select class="form-control" multiple="multiple"
                                                                id="transaction_account_id"
                                                                name="transaction_account_id[]">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>"
                                                                    <?php echo (in_array($coa['coa_level3_id'],$transaction_account_id) ? 'selected="selected"' : ''); ?>>
                                                                    <?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="transaction_account_id" style="display: none;"
                                                                class="error">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><span
                                                                    class="required">*</span>&nbsp;<?php echo $lang['srb_tax']; ?></label>
                                                            <select class="form-control" multiple="multiple"
                                                                id="srb_tax_account_id" name="srb_tax_account_id[]">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>"
                                                                    <?php echo (in_array($coa['coa_level3_id'],$srb_tax_account_id) ? 'selected="selected"' : ''); ?>>
                                                                    <?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="srb_tax_account_id" style="display: none;"
                                                                class="error">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label><span
                                                                    class="required">*</span>&nbsp;<?php echo $lang['discount_account']; ?></label>
                                                            <select class="form-control" id="discount_account_id"
                                                                name="discount_account_id">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>"
                                                                    <?php echo ($coa['coa_level3_id']==$discount_account_id ? 'selected="selected"' : ''); ?>>
                                                                    <?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <label for="discount_account_id" style="display: none;"
                                                                class="error">&nbsp;</label>
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
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
        data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>

    <script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
    <script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);

    function getURLVar(key) {
        var value = [];

        var query = String(document.location).split('?');

        if (query[1]) {
            var part = query[1].split('&');

            for (i = 0; i < part.length; i++) {
                var data = part[i].split('=');

                if (data[0] && data[1]) {
                    value[data[0]] = data[1];
                }
            }

            if (value[key]) {
                return value[key];
            } else {
                return '';
            }
        }
    }
    </script>

</body>

</html>