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
                <?php if(isset($isEdit) && $isEdit==1): ?>
                <?php if($is_post == 0): ?>
                <a class="btn btn-info" href="<?php echo $action_post; ?>">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp;<?php echo $lang['post']; ?>
                </a>
                <?php endif; ?>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print']; ?>
                </a>
                <button type="button" class="btn btn-info shadow" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa-balance-scale"></i>
                    &nbsp;<?php echo $lang['ledger']; ?>
                </button>
                <?php endif; ?>
                <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                    <i class="fa fa-undo"></i>
                    &nbsp;<?php echo $lang['cancel']; ?>
                </a>
                <?php if($is_post == 0): ?>
                <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();">
                    <i class="fa fa-floppy-o"></i>
                    &nbsp;<?php echo $lang['save']; ?>
                </a>
                <?php endif; ?>
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
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
        <input type="hidden" value="<?php echo $production_id; ?>" name="document_id" id="document_id" />
        <input type="hidden" value="<?php echo $restrict_out_of_stock; ?>" name="restrict_out_of_stock" id="restrict_out_of_stock" />
        <div class="row">
        <div class="col-md-12">
        <div class="panel panel-primary" id="hidepanel1">
        <div class="panel-heading" style="background-color: #90a4ae;">
            <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
        </div>
        <div class="panel-body">
        <fieldset>
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <div class="form-group">
                    <label><?php echo $lang['document_no']; ?></label>
                    <input class="form-control" type="text" name="document_identity" readonly="readonly" value="<?php echo $document_identity; ?>" placeholder="Auto" />
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="form-group">
                    <label><span class="required">*</span>&nbsp;<?php echo $lang['document_date']; ?></label>
                    <input class="form-control dtpDate" type="text" name="document_date" value="<?php echo $document_date; ?>" />
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="form-group">
                    <label><span class="required">*</span>&nbsp;<?php echo $lang['warehouse'].$warehouse_id; ?></label>
                    <select class="form-control" id="warehouse_id" name="warehouse_id" >
                        <option value="">&nbsp;</option>
                        <?php foreach($warehouses as $warehouse): ?>
                        <option value="<?php echo $warehouse['warehouse_id']; ?>" <?php echo ($warehouse['warehouse_id']==$warehouse_id?'selected="true"':'');?>><?php echo $warehouse['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="warehouse_id" class="error" style="display: none;"></label>
                </div>
            </div>
        </div>
        <div class="row hide">
            <div class="col-sm-3 col-xs-4">
                <div class="form-group">
                    <label><?php echo $lang['base_currency']; ?></label>
                    <input type="hidden" id="base_currency_id" name="base_currency_id"  value="<?php echo $base_currency_id; ?>" />
                    <input type="text" class="form-control" id="base_currency" name="base_currency" readonly="true" value="<?php echo $base_currency; ?>" />
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="form-group">
                    <label><?php echo $lang['document_currency']; ?></label>
                    <select class="form-control" id="document_currency_id" name="document_currency_id">
                        <option value="">&nbsp;</option>
                        <?php foreach($currencys as $currency): ?>
                        <option value="<?php echo $currency['currency_id']; ?>" <?php echo ($document_currency_id == $currency['currency_id']?'selected="selected"':''); ?>><?php echo $currency['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="form-group">
                    <label><?php echo $lang['conversion_rate']; ?></label>
                    <input class="form-control fDecimal" id="conversion_rate" type="text" name="conversion_rate" value="<?php echo $conversion_rate; ?>" onchage="calcNetAmount()" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-xs-4">
                <div class="form-group">
                    <label><?php echo $lang['serial_no']; ?></label>
                    <input onchange="getProductBySerialNo(this);" class="form-control" type="text" id="serial_no" name="serial_no" value="<?php echo $serial_no; ?>" />
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="form-group">
                    <label><?php echo $lang['product_name']; ?></label>
                    <input  class="form-control" type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>" readonly/>
                    <input  class="form-control" type="hidden" id="product_code" name="product_code" value="<?php echo $product_code; ?>" />
                    <input  class="form-control" type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>" />
                    <input  class="form-control" type="hidden" id="product_master_id" name="product_master_id" value="<?php echo $product_master_id; ?>" />
                </div>
            </div>
            <div class="col-sm-3 col-xs-4">
                <div class="form-group">
                    <label><?php echo $lang['unit']; ?></label>
                    <input class="form-control" type="text" id="unit" name="unit" value="<?php echo $unit; ?>" readonly/>
                    <input class="form-control" type="hidden" id="unit_id" name="unit_id" value="<?php echo $unit_id; ?>" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label><?php echo $lang['expected_quantity']; ?></label>
                    <input onchange="calculateQuantity(this);" class="form-control fPDecimal text-right" type="text" id="expected_quantity" name="expected_quantity" value="1" readonly />
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label><?php echo $lang['actual_quantity']; ?></label>
                    <input onchange="calculateRate();" class="form-control fPDecimal text-right" type="text" id="actual_quantity" name="actual_quantity"  value="1" readonly />
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label><?php echo $lang['total_amount']; ?></label>
                    <input class="form-control fPDecimal text-right" type="text" id="amount" name="amount" value="<?php echo $amount; ?>" readonly="true"/>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label><?php echo $lang['rate']; ?></label>
                    <input class="form-control fPDecimal text-right" type="text" id="rate" name="rate" value="<?php echo $rate; ?>" readonly="true"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang['remarks']; ?></label>
                    <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tblProductionDetail" class="table table-striped table-bordered">
                        <thead>
                        <tr align="center">
                            <td style="width: 3%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                            <td style="width: 120px;"><?php echo $lang['warehouse']; ?></td>
                            <td style="width: 120px;"><?php echo $lang['serial_no']; ?></td>
                            <td style="width: 200px;"><?php echo $lang['product_name']; ?></td>
                            <td style="width: 150px;"><?php echo $lang['unit']; ?></td>
                            <td style="width: 120px;"><?php echo $lang['unit_quantity']; ?></td>
                            <!--<td style="width: 120px;"><?php echo $lang['expected_quantity']; ?></td>
                            <td style="width: 120px;"><?php echo $lang['actual_quantity']; ?></td>
                            <td style="width: 120px;"><?php echo $lang['cog_rate']; ?></td>
                            <td style="width: 120px;"><?php echo $lang['cog_amount']; ?></td>-->
                            <td style="width: 3%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                        </tr>
                        </thead>
                        <tbody >
                        <?php $grid_row = 0; ?>
                        <?php foreach($production_details as $row): ?>
                        <tr id="grid_row_<?php echo $grid_row; ?>" data-grid_row="<?php echo $grid_row; ?>">
                            <td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                            <td>
                                <select class="form-control" id="production_detail_warehouse_id_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][warehouse_id]" >
                                    <option value="">&nbsp;</option>
                                    <?php foreach($warehouses as $warehouse): ?>
                                    <option value="<?php echo $warehouse['warehouse_id']; ?>"<?php echo ($warehouse['warehouse_id']==$row['warehouse_id']?'selected="true"':'')?>><?php echo $warehouse['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input  onchange="getProductBySerialNoDetail(this);" type="text" class="form-control" id="production_detail_serial_no_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][serial_no]" value="<?php echo $row['serial_no'];?>"/>
                                <input  type="hidden" class="form-control" id="production_detail_batch_no_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][batch_no]" value="<?php echo $row['batch_no'];?>" readonly="true"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="production_detail_product_name_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][product_name]" value="<?php echo $row['product_name'];?>" readonly="true"/>
                                <input type="hidden" class="form-control" id="production_detail_product_code_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][product_code]" value="<?php echo $row['product_code'];?>" readonly="true"/>
                                <input type="hidden" class="form-control" id="production_detail_product_id_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][product_id]" value="<?php echo $row['product_id'];?>"/>
                                <input type="hidden" class="form-control" id="production_detail_product_master_id_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][product_master_id]" value="<?php echo $row['product_master_id'];?>"/>
                            </td>
                            <td>
                                <input type="hidden" class="form-control" id="production_detail_unit_id_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][unit_id]" value="<?php echo $row['unit_id'];?>"/>
                                <input type="text" class="form-control" id="production_detail_unit_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][unit]" value="<?php echo $row['unit'];?>" readonly="true"/>
                            </td>
                            <td>
                                <input type="text" class="form-control text-right" id="production_detail_qty_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][qty]" value="<?php echo $row['qty'];?>" readonly="true"/>
                                <input type="hidden" class="form-control text-right" id="production_detail_expected_quantity_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][expected_quantity]" value="<?php echo $row['expected_quantity'];?>" readonly="true"/>
                                <input  type="hidden" class="form-control text-right" id="production_detail_actual_quantity_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][actual_quantity]" value="<?php echo $row['actual_quantity'];?>" />
                                <input type="hidden" class="form-control text-right" id="production_detail_cog_rate_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][cog_rate]" value="<?php echo $row['cog_rate'];?>" readonly="true"/>
                                <input type="hidden" class="form-control text-right" id="production_detail_cog_amount_<?php echo $grid_row; ?>" name="production_details[<?php echo $grid_row; ?>][cog_amount]" value="<?php echo $row['cog_amount'];?>" readonly="true" />
                            </td>
                            <td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                        </tr>
                        <?php $grid_row++; ?>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
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
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>

<script type="text/javascript" src="./admin/view/js/production/production.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $lang = <?php echo json_encode($lang); ?>;
    var $warehouses = <?php echo json_encode($warehouses); ?>;
    var $grid_row = '<?php echo $grid_row; ?>';
    var $UrlGetBOM = '<?php echo $href_get_bom; ?>';
</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>
