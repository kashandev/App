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
        <div class="col-sm-4">
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
        <div class="col-sm-8">
            <div class="action-button">
                <?php if(isset($isEdit) && $isEdit==1): ?>
                <?php if($is_post == 0): ?>
                <a class="btn btn-info shadow" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp;<?php echo $lang['post']; ?>
                </a>
                <?php endif; ?>
                <button type="button" class="btn btn-info shadow" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa-balance-scale"></i>
                    &nbsp;<?php echo $lang['ledger']; ?>
                </button>
                <a class="btn btn-info shadow" target="_blank" href="<?php echo $action_print_bill; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Commercial Invoice
                </a>
                <a class="btn btn-info shadow" target="_blank" href="<?php echo $action_print_sales_tax_invoice; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print']; ?>
                </a>
                <?php endif; ?>

                <button class="btn btn-default shadow" onclick="window.location.replace('<?php echo $action_cancel; ?>')">
                    <i class="fa fa-undo"></i>
                    &nbsp;<?php echo $lang['cancel']; ?>
                </button>
                <button class="btn btn-primary shadow btnSave" onclick="Save()">
                    <i class="fa fa-save"></i>
                    &nbsp;<?php echo $lang['save']; ?>
                </button>
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
                    <input type="hidden" value="<?= $allow_out_of_stock ?>" name="allow_out_of_stock" id="allow_out_of_stock">
                    <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
                    <input type="hidden" value="<?php echo $sale_tax_invoice_id; ?>" name="document_id" id="document_id" />
                    <input type="hidden" id="form_key" name="form_key" value="<?php echo $form_key ?>" />
                    <div class="row">
                    <div class="col-md-12">
                    <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading" style="background-color: #90a4ae;">
                        <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
                    </div>
                    <div class="panel-body">
                    <fieldset>                    <div class="panel panel-default">
                        <div class="panel-heading" style="font-size: 24px;font-weight: bolder;" >
                            <div class="row">
                                <div class="col-sm-6 sale_button">
                                    <label class="switch">
                                        <input type="checkbox" checked id="sale_invoice" name="sale_type" value="sale_invoice">
                                        <span class="slider round"></span>
                                    </label>
                                    <label style="font-size: 20px;top: 11px;left: 10px;display: inline-block;position: relative;">Sale Invoice</label>
                                </div>
                                <div class="col-sm-6 sale_button">
                                    <label class="switch">
                                        <input type="checkbox" id="sale_tax_invoice" name="sale_type" value="sale_tax_invoice">
                                        <span class="slider round"></span>
                                    </label>
                                    <label style="font-size: 20px;top: 11px;left: 10px;display: inline-block;position: relative;">Sale Tax Invoice</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 hide">
                            <div class="form-group">
                                <label><?php echo $lang['invoice_type']; ?></label>
                                <div class="row">
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="radio">
                                            <label>
                                                <input name="invoice_type" id="invoice_type_credit" value="Credit" <?php echo ($invoice_type != 'Cash'?'checked':''); ?> type="radio">
                                                Credit
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="radio">
                                            <label>
                                                <input name="invoice_type" id="invoice_type_cash" value="Cash" <?php echo ($invoice_type == 'Cash'?'checked':''); ?> type="radio">
                                                Cash
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>&nbsp;<?php echo $lang['manual_ref_no']; ?></label>
                                <input class="form-control" type="text" name="manual_ref_no" value="<?php echo $manual_ref_no; ?>" <?php if(!empty($manual_ref_no)) { echo 'readonly';} ?> />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 hide">
                            <div class="form-group">
                                <label><?php echo $lang['partner_type']; ?></label>
                                <select class="form-control" id="partner_type_id" name="partner_type_id">
                                    <option value="">&nbsp;</option>
                                    <?php foreach($partner_types as $partner_type): ?>
                                    <option value="<?php echo $partner_type['partner_type_id']; ?>" <?php echo ($partner_type_id == $partner_type['partner_type_id']?'selected="selected"':''); ?>><?php echo $partner_type['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="partner_type_id" class="error" style="display: none;">&nbsp;</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><span class="required">*</span>&nbsp;<?php echo $lang['partner_name']; ?></label>
                                <select class="form-control" id="partner_id" name="partner_id">
                                    <option value="">&nbsp;</option>
                                </select>
                                <label for="partner_id" class="error" style="display: none;">&nbsp;</label>
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
                        <div class="col-sm-6" >
                            <div class="form-group">
                                <label>&nbsp;<?php echo $lang['dc_no']; ?></label>
                                <div class="input-group">
                                    <select class="form-control" id="ref_document_id" name="ref_document_id[]"multiple size="1">
                                        <option value="">&nbsp;</option>
                                        <?php foreach($ref_documents as $ref_document): ?>
                                        <option value="<?php echo $ref_document['delivery_challan_id']; ?>" <?php echo (in_array($ref_document['delivery_challan_id'],$ref_document_id) ? 'selected="selected"' : ''); ?>><?php echo $ref_document['document_identity']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-flat" onclick="GetDocumentDetails();">Add</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide">
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
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>&nbsp;<?php echo $lang['po_no']; ?></label>
                                <input class="form-control " type="text" name="po_no" id="po_no" value="<?php echo $po_no; ?>" />
                                <input class="form-control " type="hidden" name="dc_no" id="dc_no" value="<?php echo $dc_no; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label><?php echo $lang['po_date']; ?></label>
                                <input class="form-control dtpDate" type="text" id="po_date" name="po_date" value="<?php echo $po_date; ?>" />
                            </div>
                        </div>
                        <!--<div class="col-sm-3">
                            <div class="form-group">
                                <label>&nbsp;<?php echo $lang['bilty_no']; ?></label>
                                <input class="form-control " type="text" id="billty_no" name="billty_no" value="<?php echo $billty_no; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $lang['bilty_date']; ?></label>
                                <input class="form-control dtpDate" type="text" id="billty_date" name="billty_date" value="<?php echo $billty_date; ?>" />
                            </div>
                        </div>-->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?php echo $lang['customer_remarks']; ?></label>
                                <input class="form-control" type="text" name="customer_remarks" value="<?php echo $customer_remarks; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?php echo $lang['remarks']; ?></label>
                                <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" />
                            </div>
                        </div>
                        <div class="col-sm-2 hide">
                            <div class="form-group">
                                <label><?php echo $lang['last_rate']; ?></label>
                                <input style="color:red;font-weight: bolder; font-size: 18px" class="form-control" type="text" name="last_rate" id="last_rate" value="<?php echo $last_rate; ?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive QA_table">
                                <table id="tblSaleInvoice" class="table table-striped table-bordered" style="width: 3000px !important">
                                    <thead>
                                        <tr align="center">
                                            <td style="width: 3%;"><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                            <td style="width: 150px;"><?php echo $lang['document']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['serial_no']; ?></td>
                                            <td style="width: 300px;"><?php echo $lang['product_name']; ?></td>
                                            <td style="width: 300px;"><?php echo $lang['description']; ?></td>
                                            <td style="width: 300px"><?php echo $lang['batch_no']; ?></td>
                                            <td style="width: 200px;"><?php echo $lang['warehouse']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['quantity']; ?></td>
                                            <td style="width: 150px;"><?php echo $lang['unit']; ?></td>
                                            <td style="width: 150px;"><?php echo $lang['rate']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['amount']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['discount_percent']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['discount_amount']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['gross_amount']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['tax_percent']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['tax_amount']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['further_tax_percent']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['further_tax_amount']; ?></td>
                                            <td style="width: 120px;"><?php echo $lang['net_amount']; ?></td>
                                            <td style="width: 3%;"><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php foreach($sale_tax_invoice_details as $grid_row => $detail): ?>
                                        <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                            <td><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        </td>
                                        <td>
                                            <input type="hidden" id="sale_tax_invoice_detail_ref_document_type_id_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_type_id']; ?>" />
                                            <input type="hidden" id="sale_tax_invoice_detail_ref_document_identity_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_identity']; ?>" />
                                            <a target="_blank" href="<?php echo $detail['href']; ?>"><?php echo $detail['ref_document_identity']; ?></a>
                                        </td>
                                            <td>
                                                <input type="text" class="form-control " id="sale_tax_invoice_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['serial_no']); ?>" readonly/>
                                            </td>
                                            <td style="min-width: 200px;">
                                            <?php if(!empty($detail['ref_document_identity'])): ?>
                                            <input type="hidden" id="sale_tax_invoice_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" />
                                            <input type="hidden" id="sale_tax_invoice_detail_product_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_id']; ?>" />
                                            <input type="text" id="sale_tax_invoice_detail_product_name_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code'].' - '.$detail['product_name']; ?>" class="form-control" readonly>
                                            <?php else: ?>
                                            <input type="hidden" id="sale_tax_invoice_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" />
                                            <input class="form-control" type="hidden" id="sale_tax_invoice_detail_material_type_<?php echo $grid_row; ?>" value="<?php echo $detail['material_type']; ?>" />
                                            <select  class="form-control product" id="sale_tax_invoice_detail_product_id_<?php echo $grid_row; ?>" 
                                                <option value="<?= $detail['product_id'] ?>"><?= ($detail['product_code'].' - '.$detail['product_name']) ?></option>
                                            </select>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(!empty($detail['ref_document_identity'])): ?>
                                            <input   style="min-width: 300px;" type="text" class="form-control" id="sale_tax_invoice_detail_description_<?php echo $grid_row; ?>" value="<?php echo $detail['description']; ?>" readonly/>
                                            <?php else: ?>
                                            <input   style="min-width: 300px;" type="text" class="form-control" id="sale_tax_invoice_detail_description_<?php echo $grid_row; ?>" value="<?php echo $detail['description']; ?>" />
                                            <?php endif; ?>
                                        </td>
                                            <td>
                                                <input type="text" class="form-control " id="sale_tax_invoice_detail_batch_no_<?php echo $grid_row; ?>" value="<?php echo $detail['batch_no']; ?>" readonly/>
                                            </td>
                                            <td>
                                            <?php if(!empty($detail['ref_document_identity'])): ?>
                                            <input type="hidden" id="sale_tax_invoice_detail_warehouse_id_<?php echo $grid_row; ?>" value="<?php echo $detail['warehouse_id']; ?>" />
                                            <input type="text" class="form-control" id="sale_tax_invoice_detail_warehouse_<?php echo $grid_row; ?>" value="<?php echo $detail['warehouse']; ?>" readonly/>
                                            <?php else: ?>
                                            <select onchange="validateWarehouseStock(this);" class="form-control select2 warehouse_id" id="sale_tax_invoice_detail_warehouse_id_<?php echo $grid_row; ?>" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($warehouses as $warehouse): ?>
                                                <?php if($warehouse['warehouse_id']==$detail['warehouse_id']): ?>
                                                <option value="<?php echo $warehouse['warehouse_id']; ?>" selected="true"><?php echo $warehouse['name']; ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo $warehouse['warehouse_id']; ?>"><?php echo $warehouse['name']; ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="hidden" id="sale_tax_invoice_detail_available_stock_<?php echo $grid_row; ?>" readonly disabled class="form-control" value="<?= round_decimal($detail['stock_qty'],2) ?>">
                                            <input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],2); ?>" readonly/>
                                        </td>
                                        <td>
                                            <input type="text" style="min-width: 100px;" class="form-control" id="sale_tax_invoice_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" readonly />
                                            <input type="hidden" class="form-control" id="sale_tax_invoice_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                                        </td>
                                        <td>
                                            <?php if(!empty($detail['ref_document_identity'])): ?>
                                            <input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['rate']; ?>" readonly/>
                                            <input type="hidden" class="form-control fPDecimal" id="sale_tax_invoice_detail_cog_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['cog_rate'],2); ?>" />
                                            <?php else: ?>
                                            <input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['rate']; ?>" />
                                            <input type="hidden" class="form-control fPDecimal" id="sale_tax_invoice_detail_cog_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['cog_rate'],2); ?>" />
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['amount']; ?>" readonly="true" />
                                            <input type="hidden" class="form-control fPDecimal" id="sale_tax_invoice_detail_cog_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['cog_amount'],2); ?>" readonly="true" />
                                        </td>
                                        <td >
                                            <input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_discount_percent_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['discount_percent'],2); ?>" />
                                        </td>
                                        <td >
                                            <input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_discount_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['discount_amount'],2); ?>" />
                                        </td>
                                        <td >
                                            <input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_gross_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['gross_amount'],2); ?>" readonly="true"/>
                                        </td>
                                        <td>
                                            <input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal"  id="sale_tax_invoice_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['tax_percent'],2); ?>" <?php echo ($sale_type == 'sale_invoice'?'readonly="true"':''); ?> />
                                        </td>
                                        <td>
                                            <input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['tax_amount'],2); ?>" <?php echo ($sale_type == 'sale_invoice'?'readonly="true"':''); ?> />
                                        </td>
                                        <td>
                                            <input onchange="calculateFurtherTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal"  id="sale_tax_invoice_detail_further_tax_percent_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['further_tax_percent'],2); ?>" <?php echo ($sale_type == 'sale_invoice'?'readonly="true"':''); ?> />
                                        </td>
                                        <td>
                                            <input onchange="calculateFurtherTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_further_tax_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['further_tax_amount'],2); ?>" <?php echo ($sale_type == 'sale_invoice'?'readonly="true"':''); ?> />
                                        </td>
                                        <td>
                                            <input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_total_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['total_amount'],2); ?>" readonly="true" />
                                        </td>
                                        <td>
                                            <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php $grid_row = count($sale_tax_invoice_details); ?>
                                </tbody>
                                <tfoot>
                                <tr align="center" data-row_id="H">
                                    <td colspan="10" style="text-align: right"><b>Total</b></td>
                                    <td>
                                        <input class="form-control fDecimal" type="text" id="item_amount" name="item_amount" value="<?php echo round_decimal($item_amount,4); ?>" readonly="readonly" />
                                    </td>
                                    <td></td>
                                    <td>
                                        <input class="form-control fDecimal" type="text" id="item_discount" name="item_discount" value="<?php echo round_decimal($item_discount,4); ?>" readonly="readonly" />
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input class="form-control fDecimal" type="text" id="item_tax" name="item_tax" value="<?php echo round_decimal($item_tax,4); ?>" readonly="readonly" />
                                    </td>
                                    <td></td>
                                    <td>
                                        <input class="form-control fDecimal" type="text" id="further_tax_total" name="further_tax_total" value="<?php echo round_decimal($further_tax_total,4); ?>" readonly="readonly" />
                                    </td>
                                    <td>
                                        <input class="form-control fDecimal" type="text" id="item_total" name="item_total" value="<?php echo round_decimal($item_total,4); ?>" readonly="readonly" />
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <!--<div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['item_amount']; ?></label>
                            <input type="text" id="item_amount" name="item_amount" value="<?php echo round_decimal($item_amount,2); ?>" class="form-control fDecimal" readonly="true" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['item_discount']; ?></label>
                            <input class="form-control fDecimal" type="text" id="item_discount" name="item_discount" value="<?php echo round_decimal($item_discount,2); ?>" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['item_tax']; ?></label>
                            <input class="form-control fDecimal" type="text" id="item_tax" name="item_tax" value="<?php echo round_decimal($item_tax,2); ?>" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['item_total']; ?></label>
                            <input class="form-control fDecimal" type="text" id="item_total" name="item_total" value="<?php echo round_decimal($item_total,2); ?>" readonly="readonly" />
                        </div>
                    </div>-->
                    </div>
                    <div class="row">
                    <div class="col-sm-3 ">
                        <div class="form-group">
                            <label><?php echo $lang['tax_percent']; ?></label>
                            <input class="form-control fDecimal" type="text" id="tax_per" name="tax_per" value="<?php echo round_decimal($tax_per,2); ?>" onfocusout="AddTaxes();" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['discount_amount']; ?></label>
                            <input class="form-control fDecimal" type="text" id="discount_amount" name="discount_amount" value="<?php echo round_decimal($discount_amount,2); ?>" onchange="calculateTotal();" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['cartage']; ?></label>
                            <input class="form-control fDecimal" type="text" id="cartage" name="cartage" value="<?php echo round_decimal($cartage,2); ?>" onchange="calculateTotal();" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['net_amount']; ?></label>
                            <input type="text" id="net_amount" name="net_amount" value="<?php echo round_decimal($net_amount,2); ?>" class="form-control fDecimal" readonly="readonly" />
                        </div>
                    </div>
                    </div>
                    <div class="row hide">
                    <div class="col-sm-offset-6 col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['cash_received']; ?></label>
                            <input type="text" id="cash_received" name="cash_received" value="<?php echo round_decimal($cash_received,2); ?>" class="form-control fDecimal" placeholder="0.00" onchange="calculateTotal();" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label><?php echo $lang['balance_amount']; ?></label>
                            <input type="text" id="balance_amount" name="balance_amount" value="<?php echo round_decimal($balance_amount,2); ?>" class="form-control fDecimal"  readonly="readonly" />
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

<script type="text/javascript" src="./admin/view/js/inventory/sale_tax_invoice.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $allow_out_of_stock = '<?= $allow_out_of_stock ?>';
    var $sale_type = '<?php echo $sale_type; ?>';
    var $url_validate_stock = '<?php echo $url_validate_stock; ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $UrlGetPartner = '<?php echo $href_get_partner; ?>';
    var $GetRefDocument = '<?php echo $get_ref_document; ?>';
    var $GetRefDocumentRecord = '<?php echo $get_ref_document_record; ?>';
    var $GetRefDocumentJson = '<?php echo $href_get_ref_document_json; ?>';
    var $UrlGetDocumentDetails = '<?php echo $href_get_document_detail; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $UrlGetContainerProducts = '<?php echo $href_get_container_products; ?>';
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $UrlAddRecords = '<?php echo $href_add_record_session; ?>';
    var $products = <?php echo json_encode($products) ?>;
    var $warehouses = <?php echo json_encode($warehouses) ?>;

    var $UrlGetPartnerJSON = '<?php echo $href_get_partner_json; ?>';

    $(document).ready(function() {
//        $('#partner_type_id').val('2').trigger('change');
        calculateTotal();

        $('.iCheck').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });

    });

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


        <?php if($this->request->get['sale_tax_invoice_id']): ?>
        $(document).ready(function() {
            $('#partner_type_id').trigger('change');
            calculateTotal();
        });
        <?php endif; ?>

        function Select2ProductJsonSaleInvoice(obj) {
            var $Url = '<?php echo $href_get_product_json; ?>';
            select2OptionList(obj,$Url);
        }

        $(function(){
            Select2SubProject('#sub_project_id');
            $('#sub_project_id').on('select2:select', function (e) {
                var $data = e.params.data;
                console.log($data)
                $('#project_id').val($data['project_id']);
            });

            $('.Select2Product').each(function(index, element){
                var $ele = $(element);
                var $row_id = $ele.parent().parent().data('row_id');
                Select2ProductJsonDeliveryChallan('#sale_tax_invoice_detail_product_id_'+$row_id);
                $('#sale_tax_invoice_detail_product_id_'+$row_id).on('select2:select', function (e) {
                    var $row_id = $(this).parent().parent().data('row_id');
                    var $data = e.params.data;
                    $('#sale_tax_invoice_detail_product_code_'+$row_id).val($data['product_code']);
                    $('#sale_tax_invoice_detail_unit_id_'+$row_id).val($data['unit_id']);
                    $('#sale_tax_invoice_detail_unit_'+$row_id).val($data['unit']);
                    $('#sale_tax_invoice_detail_description_'+$row_id).val($data['description']);
                });
            })

        })


        $(document).ready(function(){
            $('#partner_id').select2({
                width: '100%',
                ajax: {
                    url: $UrlGetPartnerJSON + '&partner_type_id='+$('#partner_type_id').val(),
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