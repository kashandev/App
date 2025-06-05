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
                <?php endif; ?>
                <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                    <i class="fa fa-undo"></i>
                    &nbsp;<?php echo $lang['cancel']; ?>
                </a>
                <?php if($is_post == 0): ?>
                <a class="btn btn-primary btnSave" href="javascript:void(0);" onclick="Save()">
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

    <style>
        .loaderjs{
            position:fixed;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background:rgb(0 0 0 / 29%);
            z-index:999999;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .loaderjs.hide{
            display:none;

        }
    </style>

    <div id="loaderjs" class="loaderjs">
        <div id="loadingGif"><img src="<?php echo $loader_image; ?>"></div>

    </div>

<div class="row padding-left_right_15">
<div class="col-xs-12">
<form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
<input type="hidden" value="<?php echo $document_id; ?>" name="document_id" id="document_id" />
<input type="hidden" id="form_key" name="form_key" value="<?php echo $form_key ?>" />
<div class="row">
<div class="col-md-12">
<div class="panel panel-primary" id="hidepanel1">
<div class="panel-heading" style="background-color: #90a4ae;">
    <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
</div>
<div class="panel-body">
<fieldset>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['document_no']; ?></label>
            <input class="form-control" type="text" name="document_identity" readonly="readonly" value="<?php echo $document_identity; ?>" placeholder="Auto" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['document_date']; ?></label>
            <input class="form-control dtpDate" type="text" name="document_date" value="<?php echo $document_date; ?>" />
        </div>
    </div>
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['manual_ref_no']; ?></label>
            <input class="form-control" type="text" name="manual_ref_no" value="<?php echo $manual_ref_no;?>" onchange="autoSave();" />
        </div>
    </div>
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['salesman']; ?></label>
            <select class="form-control" id="salesman_id" name="salesman_id">
                <option value="">&nbsp;</option>
                <?php foreach($salesmans as $salesman): ?>
                <option value="<?php echo $salesman['salesman_id']; ?>" <?php echo ($salesman_id == $salesman['salesman_id']?'selected="true"':''); ?>><?php echo $salesman['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['customer_unit']; ?></label>
            <select class="form-control" name="customer_unit_id" id="customer_unit_id">
                <option value="">&nbsp;</option>
                <?php foreach($customer_units as $customer_unit): ?>
                <option value="<?php echo $customer_unit['customer_unit_id']; ?>" <?php echo ($customer_unit_id == $customer_unit['customer_unit_id']?'selected="selected"':''); ?>><?php echo $customer_unit['customer_unit']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['partner_category']; ?></label>
            <select class="form-control" id="partner_category_id" name="partner_category_id">
                <option value="">&nbsp;</option>
                <?php foreach($partner_categorys as $partner_category): ?>
                <option value="<?php echo $partner_category['partner_category_id']; ?>" <?php echo ($partner_category_id == $partner_category['partner_category_id']?'selected="true"':''); ?>><?php echo $partner_category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['partner_name']; ?></label>
            <select class="form-control select2" id="partner_id" name="partner_id">
            </select>
            <label for="partner_id" class="error" style="display: none;"></label>
        </div>
    </div>
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['ref_document_no']; ?></label>
            <select class="form-control" id="ref_document_id" name="ref_document_id" ">
            <option value="">&nbsp;</option>
            <?php foreach($ref_documents as $ref_document): ?>
            <option value="<?php echo $ref_document['document_id']; ?>" <?php echo ($ref_document['document_id'] == $ref_document_id?'selected="true"':''); ?>><?php echo $ref_document['document_identity'],' ','(',$ref_document['manual_ref_no'],')' ; ?></option>
            <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['terms']; ?></label>
            <input class="form-control" type="text" name="terms" value="<?php echo $terms; ?>" onchange="autoSave();" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['po_no']; ?></label>
            <input class="form-control" type="text" name="po_no"  value="<?php echo $po_no; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['po_date']; ?></label>
            <input class="form-control dtpDate" type="text" name="po_date" value="<?php echo $po_date; ?>" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['remarks']; ?></label>
            <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" onchange="autoSave();" />
        </div>
    </div>
</div>
<div class="row hide">
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['partner_type']; ?></label>
            <select class="form-control" id="partner_type_id" name="partner_type_id">
                <option value="">&nbsp;</option>
                <?php foreach($partner_types as $partner_type): ?>
                <option value="<?php echo $partner_type['partner_type_id']; ?>" <?php echo ($partner_type_id == $partner_type['partner_type_id']?'selected="true"':''); ?>><?php echo $partner_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['base_currency']; ?></label>
            <input type="hidden" id="base_currency_id" name="base_currency_id"  value="<?php echo $base_currency_id; ?>" />
            <input type="text" class="form-control" id="base_currency" name="base_currency" readonly="true" value="<?php echo $base_currency; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
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
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['conversion_rate']; ?></label>
            <input class="form-control fDecimal" id="conversion_rate" type="text" name="conversion_rate" value="<?php echo $conversion_rate; ?>" onchage="calcNetAmount()" />
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-12">
        <div class="table-responsive form-group">
            <table id="tblSaleOrder" class="table table-striped table-bordered" style="width: 250%!important;">
                <thead>
                <tr align="center" data-row_id="H">
                    <td style="width: 3%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                    <td style="width: 90px;" hidden><?php echo $lang['ref_document']; ?></td>
                    <td style="width: 120px;" hidden><?php echo $lang['serial_no']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['code']; ?></td>
                    <td style="width: 300px;"><?php echo $lang['name']; ?></td>
                    <td style="width: 200px;"><?php echo $lang['description']; ?></td>
                    <td style="width: 300px" hidden><?php echo $lang['batch_no']; ?></td>
                    <td style="width: 150px;"><?php echo $lang['unit']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['quantity']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['rate']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['amount']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['tax_percent']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['tax_amount']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['net_amount']; ?></td>
                    <td style="width: 3%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                </tr>
                </thead>
                <tbody >
                <?php $grid_row = 0; ?>
                <?php foreach($sale_order_details as $detail): ?>
                <?php if($detail['ref_document_identity']): ?>
                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                    <td class="text-center">
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                    </td>
                    <td hidden="hidden">
                        <a target="_blank" href="<?php echo $detail['href']; ?>" title="Ref. Document"><?php echo $detail['ref_document_identity']; ?></a>
                        <input type="hidden" class="form-control" name="sale_order_details[<?php echo $grid_row; ?>][ref_document_type_id]" id="sale_order_detail_ref_document_type_id_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_type_id']; ?>" readonly/>
                        <input type="hidden" class="form-control" name="sale_order_details[<?php echo $grid_row; ?>][ref_document_identity]" id="sale_order_detail_ref_document_identity_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_identity']; ?>" readonly/>
                    </td>
                    <td hidden="hidden">
                        <input type="text" class="form-control" name="sale_order_details[<?php echo $grid_row; ?>][serial_no]" id="sale_order_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo $detail['serial_no']; ?>" readonly/>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="sale_order_details[<?php echo $grid_row; ?>][product_code]" id="sale_order_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" readonly/>
                        <input type="hidden" class="form-control" name="sale_order_details[<?php echo $grid_row; ?>][product_master_id]" id="sale_order_detail_product_master_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_id']; ?>" readonly/>
                    </td>
                    <td style="min-width: 300px">
                        <select class="required form-control Select2ProductMaster required" id="sale_order_detail_product_id_<?= $grid_row ?>" name="sale_order_details[<?= $grid_row ?>][product_id]" required>
                            <option value="<?= $detail['product_id'] ?>"><?= implode(' - ', array(
                    $detail['product_code'],
                    $detail['brand'],
                    $detail['model'],
                    $detail['product_name'],
                )) ?></option>
                        </select>
                    </td>
                    <td style="min-width: 300px">
                        <input   type="text" class="form-control" id="sale_order_detail_description_<?php echo $grid_row; ?>" value="<?php echo $detail['description']; ?>"  />
                    </td>
                    <td style="min-width: 100px" hidden="hidden">
                        <input   type="text" class="form-control" id="sale_order_detail_batch_no_<?php echo $grid_row; ?>" value="<?php echo $detail['batch_no']; ?>"  />
                    </td>
                    <td>
                        <input type="hidden" class="form-control" id="sale_order_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>"/>
                        <input type="text" readonly class="form-control" id="sale_order_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" />
                    </td>
                    <td>
                        <input onchange="calculateAmount(this);" type="text" class="form-control fPDecimal" id="sale_order_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],2); ?>" />
                        <input  type="hidden" class="form-control fPDecimal" id="sale_order_detail_utilized_qty_<?php echo $grid_row; ?>" value="<?php echo $detail['utilized_qty']; ?>" readonly/>
                    </td>
                    <td>
                        <input onchange="calculateAmount(this);" type="text" class="form-control fPDecimal" id="sale_order_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],2); ?>"  />
                    </td>
                    <td>
                        <input type="text" class="form-control fPDecimal" id="sale_order_detail_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['amount'],2); ?>" readonly="true" />
                    </td>
                    <td>
                        <input onchange="calculateTaxAmount(this);" type="text" class="form-control fDecimal" id="sale_order_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['tax_percent'],2); ?>" />
                    </td>
                    <td>
                        <input onchange="calculateTaxAmount(this);" type="text" class="form-control fDecimal" id="sale_order_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['tax_amount'],2); ?>" />
                    </td>
                    <td>
                        <input  type="text" class="form-control fDecimal" id="sale_order_detail_net_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['net_amount'],2); ?>" />
                    </td>
                    <td style="width: 3%;" class="text-center">
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
                <?php else: ?>
                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                    <td class="text-center">
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>

                    </td>
                    <td hidden>
                        <a target="_blank" href="<?php echo $detail['href']; ?>" title="Ref. Document"><?php echo $detail['ref_document_identity']; ?></a>
                        <input type="hidden" class="form-control" id="sale_order_detail_ref_document_type_id_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_type_id']; ?>" readonly/>
                        <input type="hidden" class="form-control" id="sale_order_detail_ref_document_identity_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_identity']; ?>" readonly/>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="sale_order_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo $detail['serial_no']; ?>" readonly/>
                    </td>
                    <td>
                        <input onchange="getProductByCode(this);" type="text" class="form-control" id="sale_order_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" />
                    </td>
                    <td>
                        <select class="required form-control Select2ProductMaster required" id="sale_order_detail_product_id_<?= $grid_row ?>" name="sale_order_details[<?= $grid_row ?>][product_id]" required>
                            <option value="<?= $detail['product_id'] ?>"><?= $detail['product_code'].' - '.$detail['product_name'] ?></option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="sale_order_detail_description_<?php echo $grid_row; ?>" value="<?php echo $detail['description']; ?>"  />
                    </td>
                    <td style="min-width: 100px">
                        <input   type="text" class="form-control" id="sale_order_detail_batch_no_<?php echo $grid_row; ?>" value="<?php echo $detail['batch_no']; ?>"  />
                    </td>
                    <td>
                        <input type="text" class="form-control" id="sale_order_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" />
                        <input type="hidden" class="form-control" id="sale_order_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                        <input type="hidden" class="form-control" id="sale_order_detail_product_master_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_master_id']; ?>" readonly/>
                    </td>
                    <td>
                        <input onchange="calculateAmount(this);" type="text" class="form-control fPDecimal" id="sale_order_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],2); ?>" />
                    </td>
                    <td>
                        <input onchange="calculateAmount(this);" type="text" class="form-control fPDecimal" id="sale_order_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],2); ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control fPDecimal" id="sale_order_detail_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['amount'],2); ?>" readonly="true" />
                    </td>
                    <td>
                        <input onchange="calculateTaxAmount(this);" type="text" class="form-control fDecimal" id="sale_order_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['tax_percent'],2); ?>" />
                    </td>
                    <td>
                        <input onchange="calculateTaxPercent(this);" type="text" class="form-control fDecimal" id="sale_order_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['tax_amount'],2); ?>" />
                    </td>
                    <td>
                        <input  type="text" class="form-control fDecimal" id="sale_order_detail_net_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['net_amount'],2); ?>" />
                    </td>
                    <td class="text-center">
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                </tr>
                <?php endif; ?>
                <?php $grid_row++; ?>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-offset-4 col-md-2">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['total_quantity']; ?></label>
            <input type="text" id="total_quantity" name="total_quantity" value="<?php echo round_decimal($total_quantity,2); ?>" class="form-control fDecimal" readonly="true" />
        </div>
    </div>
    <div class=" col-sm-2">
        <div class="form-group">
            <label><?php echo $lang['total_amount']; ?></label>
            <input type="text" id="item_amount" name="item_amount" value="<?php echo round_decimal($item_amount,2); ?>" class="form-control fDecimal" readonly="true" />
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label><?php echo $lang['total_tax']; ?></label>
            <input class="form-control fDecimal" type="text" id="item_tax" name="item_tax" value="<?php echo round_decimal($item_tax,2); ?>" readonly="readonly" />
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['total_net']; ?></label>
            <input class="form-control fDecimal" type="text" id="item_total" name="item_total" value="<?php echo round_decimal($item_total,2); ?>" readonly="readonly" />
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

<?php echo $page_footer; ?>
<?php echo $footer; ?>

<script type="text/javascript" src="./admin/view/js/inventory/sale_order.js"></script>

<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $lang = <?php echo json_encode($lang) ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $UrlGetRefDocumentNo = '<?php echo $href_get_ref_document_no; ?>';
    var $UrlGetRefDocument = '<?php echo $href_get_ref_document; ?>';
    var $partner_id = '<?php echo $partner_id; ?>';
    var $UrlGetPartner = '<?php echo $href_get_partner; ?>';
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $UrlGetPartnerJSON = '<?php echo $href_get_partner_json; ?>';
    var $sub_project_id = '<?php echo $sub_project_id; ?>';
    var $UrlGetSubProjects = '<?= $href_get_sub_projects; ?>';

    var $UrlGetProductByCode = '<?php echo $href_get_product_by_code; ?>';
    var $UrlGetProductById = '<?php echo $href_get_product_by_id; ?>';
    var $UrlAddRecords = '<?php echo $href_add_record_session; ?>';

    var $products = <?php echo json_encode($products) ?>;
    var $warehouses = <?php echo json_encode($warehouses) ?>;
    var $operation_types = <?= json_encode($operation_types) ?>

    function Select2ProductMasterPurchaseOrder(obj) {
        var $Url = '<?php echo $href_get_json_products_for_sale_order; ?>';

        select2OptionList(obj,$Url);
    }

    function formatRepo (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
        if(repo.image_url) {
            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.name + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }
        "</div></div>";

        return markup;
    }

    function formatReposit (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
//        if(repo.image_url) {
//            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
//        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.document_identity + "</div>";

//        if (repo.description) {
//            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
//        }
        "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name || repo.text;
    }



    $(document).ready(function() {
        $('#partner_category_id').trigger('change');
        $('#partner_type_id').trigger('change');


        <?php if($this->request->get['sale_order_id']): ?>
        $('.Select2ProductMaster').each(function(index, element){
            var $ele = $(element);
            var $row_id = $ele.parent().parent().data('row_id');
            Select2ProductMasterPurchaseOrder('#sale_order_detail_product_id_'+$row_id);
            $('#sale_order_detail_product_id_'+$row_id).on('select2:select', function (e) {
                var $row_id = $(this).parent().parent().data('row_id');
                var $data = e.params.data;
                $('#sale_order_detail_product_code_'+$row_id).val($data['product_code']);
                $('#sale_order_detail_unit_'+$row_id).val($data['unit']);
                $('#sale_order_detail_unit_id_'+$row_id).val($data['unit_id']);
                $('#sale_order_detail_product_master_id_'+$row_id).val($data['id']);
                $('#sale_order_detail_description_'+$row_id).val($data['description']);
            });
        })

                <?php endif; ?>



        $('select.partner').select2({
            width: '100%',
            ajax: {
                url: $UrlGetPartnerJSON+'&partner_type_id=1',
                dataType: 'json',
                type: 'post',
                mimeType:"multipart/form-data",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 2,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
        });

    });
</script>

</body>
</html>