<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<?php echo $header; ?>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
    <?php echo $page_header; ?>
    <?php echo $column_left; ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><?php echo $lang['heading_title']; ?></h1>
            <div class="row">
                <div class="col-sm-4">
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
                    <div class="pull-right">
                        <?php if(isset($isEdit) && $isEdit==1): ?>
                        <?php if($is_post == 0): ?>
                        <a class="btn btn-info" href="<?php echo $action_post; ?>">
                            <i class="fa fa-thumbs-up"></i>
                            &nbsp;<?php echo $lang['post']; ?>
                        </a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                            <i class="fa fa-balance-scale"></i>
                            &nbsp;<?php echo $lang['ledger']; ?>
                        </button>
                        <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print']; ?>
                        </a>
                        <a class="btn btn-info" target="_blank" href="<?php echo $action_print_with_balance; ?>">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print_with_balance']; ?>
                        </a>
                        <?php endif; ?>
                        <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                            <i class="fa fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </a>
                        <button type="button" class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
                        <i class="fa fa-floppy-o"></i>
                        &nbsp;<?php echo $lang['save']; ?>
                        </button>
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
                                <?php echo $error_warning; ?>
                            </div>
                            <?php } ?>
                            <?php  if ($success) { ?>
                            <div class="alert alert-success alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <?php echo $success; ?>
                            </div>
                            <?php  } ?>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                                <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
                                <input type="hidden" value="<?php echo $sale_invoice_id; ?>" name="document_id" id="document_id" />
                                <div class="row">
                                    <div class="col-sm-3">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['partner_type']; ?></label>
                                            <select class="form-control" id="partner_type_id" name="partner_type_id">
                                                <option value="">&nbsp;</option>
                                                <?php foreach($partner_types as $partner_type): ?>
                                                <option value="<?php echo $partner_type['partner_type_id']; ?>" <?php echo ($partner_type_id == $partner_type['partner_type_id']?'selected="true"':''); ?>><?php echo $partner_type['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="partner_type_id" class="error" style="display: none;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['partner_name']; ?></label>
                                            <select class="form-control" id="partner_id" name="partner_id">
                                                <option value="">&nbsp;</option>
                                            </select>
                                            <label for="partner_id" class="error" style="display: none;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['container_no']; ?></label>
                                            <div class="input-group">
                                                <select class="form-control" id="container_no" name="container_no">
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($containers as $container): ?>
                                                    <option value="<?php echo $container['container_no']; ?>"><?php echo $container['container_no']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button id="addContainer" type="button" class="btn btn-info btn-flat"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
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
                                    <div class="col-sm-12">
                                        <div class="table-responsive form-group">
                                            <table id="tblSaleInvoice" class="table table-striped table-bordered">
                                                <thead>
                                                <tr align="center">
                                                    <td style="width: 15px;">&nbsp;</td>
                                                    <td style="width: 5%;"><?php echo $lang['warehouse']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['product_code']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['product_name']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['cubic_meter']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['cubic_feet']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['container_no']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['batch_no']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['quantity']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['total_cubic_meter']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['total_cubic_feet']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['rate']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['amount']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['discount_percent']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['discount_amount']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['gross_amount']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['tax_percent']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['tax_amount']; ?></td>
                                                    <td style="width: 5%;"><?php echo $lang['net_amount']; ?></td>
                                                    <td style="width: 5%";><?php echo $lang['remarks']; ?></td>
                                                    <td style="width: 30px;">&nbsp;</td>
                                                </tr>
                                                </thead>
                                                <tbody >
                                                <?php foreach($sale_invoice_details as $grid_row => $detail): ?>
                                                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                                    <td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                                                    <td>
                                                        <input type="hidden" id="sale_invoice_detail_warehouse_id_<?php echo $grid_row; ?>" name="sale_invoice_details[<?php echo $grid_row; ?>][warehouse_id]" value="<?php echo $detail['warehouse_id'];?>" />
                                                        <input type="text" class="form-control" id="sale_invoice_detail_warehouse_<?php echo $grid_row; ?>" name="sale_invoice_details[<?php echo $grid_row; ?>][warehouse]" value="<?php echo $detail['warehouse'];?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="sale_invoice_detail_product_code_<?php echo $grid_row; ?>" name="sale_invoice_details[<?php echo $grid_row; ?>][product_code]" value="<?php echo $detail['product_code'];?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="form-control" id="sale_invoice_detail_product_id_<?php echo $grid_row; ?>" name="sale_invoice_details[<?php echo $grid_row; ?>][product_id]" value="<?php echo $detail['product_id'];?>" readonly />
                                                        <input type="text" class="form-control" id="sale_invoice_detail_product_name_<?php echo $grid_row; ?>" name="sale_invoice_details[<?php echo $grid_row; ?>][product_name]" value="<?php echo $detail['product_name'];?>" style="width: 300px;" readonly />
                                                    </td>
                                                    <td>
                                                        <input style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][cubic_meter]" id="sale_invoice_detail_cubic_meter_<?php echo $grid_row; ?>" value="<?php echo $detail['cubic_meter']; ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][cubic_feet]" id="sale_invoice_detail_cubic_feet_<?php echo $grid_row; ?>" value="<?php echo $detail['cubic_feet']; ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input style="min-width: 100px;" type="text" class="form-control" name="sale_invoice_details[<?php echo $grid_row; ?>][container_no]" id="sale_invoice_detail_container_no_<?php echo $grid_row; ?>" value="<?php echo $detail['container_no']; ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input style="min-width: 100px;" type="text" class="form-control" name="sale_invoice_details[<?php echo $grid_row; ?>][batch_no]" id="sale_invoice_detail_batch_no_<?php echo $grid_row; ?>" value="<?php echo $detail['batch_no']; ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="sale_invoice_details[<?php echo $grid_row; ?>][unit_id]" id="sale_invoice_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                                                        <input onchange="calculateAmount(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][qty]" id="sale_invoice_detail_qty_<?php echo $grid_row; ?>" value="<?php echo $detail['qty']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][total_cubic_meter]" id="sale_invoice_detail_total_cubic_meter_<?php echo $grid_row; ?>" value="<?php echo $detail['total_cubic_meter']; ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][total_cubic_feet]" id="sale_invoice_detail_total_cubic_feet_<?php echo $grid_row; ?>" value="<?php echo $detail['total_cubic_feet']; ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input onchange="calculateAmount(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][rate]" id="sale_invoice_detail_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['rate']; ?>" />
                                                        <input type="hidden" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][cog_rate]" id="sale_invoice_detail_cog_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_rate']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][amount]" id="sale_invoice_detail_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['amount']; ?>" readonly="true" />
                                                        <input type="hidden" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][cog_amount]" id="sale_invoice_detail_cog_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_amount']; ?>" readonly="true" />
                                                    </td>
                                                    <td>
                                                        <input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][discount_percent]" id="sale_invoice_detail_discount_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['discount_percent']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][discount_amount]" id="sale_invoice_detail_discount_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['discount_amount']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][gross_amount]" id="sale_invoice_detail_gross_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['gross_amount']; ?>" readonly="true"/>
                                                    </td>
                                                    <td>
                                                        <input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][tax_percent]" id="sale_invoice_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_percent']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][tax_amount]" id="sale_invoice_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_amount']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details[<?php echo $grid_row; ?>][total_amount]" id="sale_invoice_detail_total_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['total_amount']; ?>" readonly="true" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="min-width: 100px;" class="form-control" name="sale_invoice_details[<?php echo $grid_row; ?>][remarks]" id="sale_invoice_detail_remarks_<?php echo $grid_row; ?>" value="<?php echo $detail['remarks']; ?>" />
                                                    </td>
                                                    <td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <?php $grid_row = count($sale_invoice_details); ?>
                                                </tbody>
                                                <tfoot>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-offset-6 col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['total_quantity']; ?></label>
                                            <input type="text" id="total_quantity" name="total_quantity" value="<?php echo $total_quantity; ?>" class="form-control fDecimal" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['total_cubic_meter']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="total_cubic_meter" name="total_cubic_meter" value="<?php echo $total_cubic_meter; ?>" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['total_cubic_feet']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="total_cubic_feet" name="total_cubic_feet" value="<?php echo $total_cubic_feet; ?>" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['item_amount']; ?></label>
                                            <input type="text" id="item_amount" name="item_amount" value="<?php echo $item_amount; ?>" class="form-control fDecimal" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['item_discount']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="item_discount" name="item_discount" value="<?php echo $item_discount; ?>" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['item_tax']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="item_tax" name="item_tax" value="<?php echo $item_tax; ?>" readonly="readonly" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['item_total']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="item_total" name="item_total" value="<?php echo $item_total; ?>" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['discount_amount']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="discount_amount" name="discount_amount" value="<?php echo $discount_amount; ?>" onchange="calculateTotal();" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['labour_charges']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="labour_charges" name="labour_charges" value="<?php echo $labour_charges; ?>" onchange="calculateTotal();" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['misc_charges']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="misc_charges" name="misc_charges" value="<?php echo $misc_charges; ?>" onchange="calculateTotal();" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $lang['rent_charges']; ?></label>
                                            <input class="form-control fDecimal" type="text" id="rent_charges" name="rent_charges" value="<?php echo $rent_charges; ?>" onchange="calculateTotal();" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['net_amount']; ?></label>
                                            <input type="text" id="net_amount" name="net_amount" value="<?php echo $net_amount; ?>" class="form-control fDecimal" readonly="readonly" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row hide">
                                    <div class="col-sm-offset-6 col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['cash_received']; ?></label>
                                            <input type="text" id="cash_received" name="cash_received" value="<?php echo $cash_received; ?>" class="form-control fDecimal" placeholder="0.00" onchange="calculateTotal();" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['balance_amount']; ?></label>
                                            <input type="text" id="balance_amount" name="balance_amount" value="<?php echo $balance_amount; ?>" class="form-control fDecimal"  readonly="readonly" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <?php if(isset($isEdit) && $isEdit==1): ?>
                                <?php if($is_post == 0): ?>
                                <a class="btn btn-info" href="<?php echo $action_post; ?>">
                                    <i class="fa fa-thumbs-up"></i>
                                    &nbsp;<?php echo $lang['post']; ?>
                                </a>
                                <?php endif; ?>
                                <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                                    <i class="fa fa-balance-scale"></i>
                                    &nbsp;<?php echo $lang['ledger']; ?>
                                </button>
                                <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                                    <i class="fa fa-print"></i>
                                    &nbsp;<?php echo $lang['print']; ?>
                                </a>
                                <?php endif; ?>
                                <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                                    <i class="fa fa-undo"></i>
                                    &nbsp;<?php echo $lang['cancel']; ?>
                                </a>
                                <button type="button" class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
                                <i class="fa fa-floppy-o"></i>
                                &nbsp;<?php echo $lang['save']; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <link rel="stylesheet" href="plugins/dataTables/dataTables.bootstrap.css">
    <script src="plugins/dataTables/jquery.dataTables.js"></script>
    <script src="plugins/dataTables/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="../admin/view/js/inventory/sale_invoice.js"></script>
    <script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
    <script>
        jQuery('#form').validate(<?php echo $strValidation; ?>);
        var $lang = <?php echo json_encode($lang) ?>;
        var $partner_id = '<?php echo $partner_id; ?>';
        var $grid_row = '<?php echo $grid_row; ?>';
        var $UrlGetContainerProducts = '<?php echo $href_get_container_products; ?>';
        //var $products = <?php echo json_encode($products) ?>;
        var $warehouses = <?php echo json_encode($warehouses) ?>;
        <?php if($this->request->get['sale_invoice_id']): ?>
        $(document).ready(function() {
            $('#partner_type_id').trigger('change');
            calculateTotal();
        });
        <?php endif; ?>
    </script>
    <?php echo $page_footer; ?>
    <?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>