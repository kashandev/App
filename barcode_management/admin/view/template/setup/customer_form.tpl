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
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['name']; ?></label>
                                                        <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['partner_category']; ?></label>
                                                        <select class="form-control" id="partner_category_id" name="partner_category_id" >
                                                            <option value="">&nbsp;</option>
                                                            <?php foreach($partner_categories as $partner_category): ?>
                                                            <option value="<?php echo $partner_category['partner_category_id']; ?>" <?php echo ($partner_category_id == $partner_category['partner_category_id']?'selected="selected"':''); ?>><?php echo $partner_category['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['region']; ?></label>
                                                        <input type="text" name="region" value="<?php echo $region; ?>" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['city']; ?></label>
                                                        <input type="text" name="city" value="<?php echo $city; ?>"  class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['address']; ?></label>
                                                        <input  type="text" name="address" value="<?php echo $address; ?>" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['phone']; ?></label>
                                                        <input type="tel" name="phone" value="<?php echo $phone; ?>" class="form-control fPhone" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['mobile']; ?></label>
                                                        <input type="tel" name="mobile" value="<?php echo $mobile; ?>" class="form-control fPhone" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['email']; ?></label>
                                                        <input type="text" name="email" value="<?php echo $email; ?>" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['credit_limit_days']; ?></label>
                                                        <input type="text" name="day_limit" value="<?php echo $day_limit; ?>" class="form-control fDecimal" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['credit_limit_amount']; ?></label>
                                                        <input type="text" name="amount_limit" value="<?php echo $amount_limit; ?>" class="form-control fDecimal" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['gst_no']; ?></label>
                                                        <input type="text" name="gst_no" value="<?php echo $gst_no; ?>" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['ntn_no']; ?></label>
                                                        <input type="text" name="ntn_no" value="<?php echo $ntn_no; ?>"  class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['default_currency']; ?></label>
                                                        <select class="form-control" id="document_currency_id" name="document_currency_id" >
                                                            <?php foreach($currencies as $currency): ?>
                                                            <option value="<?php echo $currency['currency_id']; ?>" <?php echo ($document_currency_id == $currency['currency_id']?'selected="selected"':''); ?>><?php echo $currency['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <!--</div>
                                            <div class="row">-->
                                                <!--<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['advance_account']; ?></label>
                                                        <select class="form-control" id="advance_account_id" name="advance_account_id" >
                                                            <?php if(count($coas)>1): ?>
                                                            <option value="">&nbsp;</option>
                                                            <?php endif; ?>
                                                            <?php foreach($coas as $coa): ?>
                                                            <option value="<?php echo $coa['coa_level3_id']; ?>" <?php echo ($advance_account_id == $coa['coa_level3_id']?'selected="selected"':''); ?>"><?php echo $coa['level3_display_name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <label for="advance_account_id" class="error" style="display: none;"<?php echo $error['advance_account']?></label>
                                                    </div>
                                                </div>-->
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