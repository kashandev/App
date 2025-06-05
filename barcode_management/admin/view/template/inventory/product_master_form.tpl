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
            <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary" id="hidepanel1">
                            <div class="panel-heading" style="background-color: #ef5350;">
                                <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
                            </div>
                            <div class="panel-body">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['product_category']; ?></label>
                                                <select class="form-control" id="product_category_id" name="product_category_id" >
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($product_categories as $product_category): ?>
                                                    <option value="<?php echo $product_category['product_category_id']; ?>" <?php echo ($product_category['product_category_id'] == $product_category_id ? 'selected="selected"': ''); ?>><?php echo $product_category['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['brand']; ?></label>
                                                <select class="form-control" id="brand_id" name="brand_id" >
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($brands as $brand): ?>
                                                    <option value="<?php echo $brand['brand_id']; ?>" <?php echo ($brand['brand_id'] == $brand_id ? 'selected="selected"': ''); ?>><?php echo $brand['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['make']; ?></label>
                                                <select class="form-control" id="make_id" name="make_id" >
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($makes as $make): ?>
                                                    <option value="<?php echo $make['make_id']; ?>" <?php echo ($make['make_id'] == $make_id ? 'selected="selected"': ''); ?>><?php echo $make['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['model']; ?></label>
                                                <select class="form-control" id="model_id" name="model_id" >
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($models as $model): ?>
                                                    <option value="<?php echo $model['model_id']; ?>" <?php echo ($model['model_id'] == $model_id ? 'selected="selected"': ''); ?>><?php echo $model['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span class="required">*</span>&nbsp;<?php echo $lang['code']; ?></label>
                                                <input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $product_code ?>" <?php echo ($auto_generate_product_code==1?'readonly':'')?> />
                                            </div>
                                        </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['hs_code']; ?></label>
                                            <input type="text" class="form-control" name="hs_code" id="hs_code" value="<?php echo $hs_code ?>" maxlength="8" required/>
                                        </div>
                                    </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span class="required">*</span>&nbsp;<?php echo $lang['name']; ?></label>
                                                <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span class="required">*</span>&nbsp;<?php echo $lang['unit']; ?></label>
                                                <select class="form-control" id="unit_id" name="unit_id" >
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($units as $unit): ?>
                                                    <option value="<?php echo $unit['unit_id']; ?>" <?php echo ($unit['unit_id'] == $unit_id ? 'selected="selected"': ''); ?>><?php echo $unit['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="unit_id" class="error" style="display: none;"><?php echo $error['unit_id']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['cost_price']; ?></label>
                                                <input class="form-control" type="text" name="cost_price" value="<?php echo $cost_price; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['sale_price']; ?></label>
                                                <input class="form-control" type="text" name="sale_price" value="<?php echo $sale_price; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['reorder_quantity']; ?></label>
                                                <input class="form-control" type="text" name="reorder_quantity" value="<?php echo $reorder_quantity; ?>" />
                                            </div>
                                        </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $lang['dirham_sale_rate']; ?></label>
                                            <input class="form-control" type="text" name="dirham_sale_rate" value="<?php echo $dirham_sale_rate; ?>" />
                                        </div>
                                    </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['cogs_account']; ?></label>
                                                <select class="form-control" id="cogs_account_id" name="cogs_account_id" >
                                                    <!-- <option value="">&nbsp;</option> -->
                                                    <?php foreach($cogs_accounts as $coa): ?>
                                                    <option value="<?php echo $coa['coa_level3_id']; ?>" <?php echo ($coa['coa_level3_id'] == $cogs_account_id ? 'selected="selected"': ''); ?>><?php echo $coa['level3_display_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="cogs_account_id" class="error" style="display: none;">&nbsp;</label>
                                            </div>
                                            <div class="form-group">
                                                <label><span class="required">*</span>&nbsp;<?php echo $lang['inventory_account']; ?></label>
                                                <select class="form-control" id="inventory_account_id" name="inventory_account_id" >
                                                    <!-- <option value="">&nbsp;</option> -->
                                                    <?php foreach($inventory_accounts as $coa): ?>
                                                    <option value="<?php echo $coa['coa_level3_id']; ?>" <?php echo ($coa['coa_level3_id'] == $inventory_account_id ? 'selected="selected"': ''); ?>><?php echo $coa['level3_display_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="inventory_account_id" class="error" style="display: none;">&nbsp;</label>
                                            </div>
                                            <div class="form-group">
                                                <label><span class="required">*</span>&nbsp;<?php echo $lang['revenue_account']; ?></label>
                                                <select class="form-control" id="revenue_account_id" name="revenue_account_id" >
                                                    <!-- <option value="">&nbsp;</option> -->
                                                    <?php foreach($revenue_accounts as $coa): ?>
                                                    <option value="<?php echo $coa['coa_level3_id']; ?>" <?php echo ($revenue_account_id == $coa['coa_level3_id']?'selected="selected"':''); ?>"><?php echo $coa['level3_display_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="revenue_account_id" class="error" style="display: none;">&nbsp;</label>
                                            </div>
                                            <div class="form-group">
                                                <label><span class="required">*</span>&nbsp;<?php echo $lang['adjustment_account']; ?></label>
                                                <select class="form-control" id="adjustment_account_id" name="adjustment_account_id" >
                                                    <!-- <option value="">&nbsp;</option> -->
                                                    <?php foreach($adjustment_accounts as $adjustment): ?>
                                                    <option value="<?php echo $adjustment['coa_level3_id']; ?>" <?php echo ($adjustment_account_id == $adjustment['coa_level3_id']?'selected="selected"':''); ?>><?php echo $adjustment['level3_display_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="adjustment_account_id" class="error" style="display: none;">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <a href="javascript:void(0);" id="a_product_image"  data-toggle="image" class="img-thumbnail" data-src_image="src_product_image" data-src_input="file_product_image" data-width="100" data-height="100">
                                                    <img alt="Product Image" src="<?php echo $src_product_image; ?>"  id="src_product_image" alt="" title="" data-placeholder="<?php echo $no_image; ?>" class="img-responsive"/>
                                                </a>
                                                <input type="hidden" name="product_image" value="<?php echo $product_image; ?>" id="file_product_image" />
                                                <br />
                                                <a class="btn btn-primary btn-xs" onclick="jQuery('#src_product_image').attr('src', '<?php echo $no_image; ?>'); jQuery('#file_product_image').attr('value', '');"><?php echo $lang['clear']; ?></a>
                                                <br />&nbsp;
                                            </div>
                                        </div>
                                    </div>
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