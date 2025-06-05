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
                <a class="btn btn-info" href="<?php echo $action_post; ?>">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp;<?php echo $lang['post']; ?>
                </a>
                <?php endif; ?>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Print With Header
                </a>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print_without_header; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Print Without Header
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
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<input type="hidden" value="<?= $allow_out_of_stock ?>" name="allow_out_of_stock" id="allow_out_of_stock">
<input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
<input type="hidden" value="<?php echo $delivery_challan_id; ?>" name="document_id" id="document_id" />
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
    <div class="col-sm-3 hide">
        <div class="form-group">
            <div class="radio">
                <label style="font-size: 22px;font-weight: bolder;color:Red "><input name="challan_type" id="challan_type_no" value="GST" type="radio" <?php echo ($challan_type != 'Non GST'?'checked':''); ?>> GST</label>
                &nbsp;&nbsp;
                <label style="font-size: 22px;font-weight: bolder;color: Red"><input name="challan_type" id="challan_type_yes" value="Non GST" type="radio" <?php echo ($challan_type == 'Non GST'?'checked':''); ?>> Non GST</label>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['challan_type']; ?></label>
            <select class="form-control" id="status" name="status">
                <option value="Normal"<?php echo ($status == 'Normal'?'selected="true"':'') ?>>Normal</option>>
                <option value="Sample"<?php echo ($status == 'Sample'?'selected="true"':'') ?>>Sample</option>>
            </select>
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
    <div class="col-sm-3 hide">
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
            <label><span class="required">*</span> <?php echo $lang['partner_name']; ?></label>
            <select class="form-control" id="partner_id" name="partner_id">
                <option value="">&nbsp;</option>
            </select>
            <label for="partner_id" class="error" style="display: none;"></label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['ref_document_type']; ?></label>
            <select class="form-control" name="ref_document_type_id" id="ref_document_type_id">
                <option value="">&nbsp;</option>
                <option value="5" ><?php echo $lang['sale_order']; ?></option>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['ref_document_no']; ?></label>
            <select class="form-control" id="ref_document_identity" name="ref_document_identity" >
                <option value="">&nbsp;</option>
                <?php foreach($ref_documents as $ref_document): ?>
                <option value="<?php echo $ref_document['document_identity']; ?>" <?php echo ($ref_document['document_identity'] == $ref_document_identity?'selected="true"':''); ?>><?php echo $ref_document['document_identity']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['po_no']; ?></label>
            <input class="form-control" type="text" name="po_no" id="po_no" value="<?php echo $po_no; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['po_date']; ?></label>
            <input class="form-control dtpDate" type="text" name="po_date" id="po_date" value="<?php echo $po_date; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['driver_name']; ?></label>
            <input class="form-control" type="text" name="driver_name" id="driver_name" value="<?php echo $driver_name; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['order_by']; ?></label>
            <input class="form-control" type="text" name="order_by" id="order_by" value="<?php echo $order_by; ?>" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['vehicle_no']; ?></label>
            <input class="form-control" type="text" name="vehicle_no" id="vehicle_no" value="<?php echo $vehicle_no; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['cargo_name']; ?></label>
            <input class="form-control" type="text" name="cargo_name" id="cargo_name" value="<?php echo $cargo_name; ?>" />
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['terms_of_delivery']; ?></label>
            <input class="form-control" type="text" name="terms_of_delivery" id="terms_of_delivery" value="<?php echo $terms_of_delivery; ?>" />
        </div>
    </div>
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['last_rate']; ?></label>
            <input style="color:red;font-weight: bolder; font-size: 18px" class="form-control" type="text" name="last_rate" id="last_rate" value="<?php echo $last_rate; ?>" readonly/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang['delivery_time']; ?></label>
                    <input class="form-control" type="time" name="delivery_time" id="delivery_time" value="<?php echo $delivery_time; ?>" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang['delivery_address']; ?></label>
                    <input class="form-control" type="text" name="delivery_address" id="delivery_address" value="<?php echo $delivery_address; ?>" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang['warehouse']; ?></label>
                    <select class="form-control" id="warehouse_id" name="warehouse_id" >
                        <option value="">&nbsp;</option>
                        <?php foreach($warehouses as $warehouse): ?>
                        <option value="<?php echo $warehouse['warehouse_id']; ?>"><?php echo $warehouse['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><?php echo $lang['serial_no']; ?></label>
                    <div class="input-group">
                    <input class="form-control" type="text" name="serial_no" id="serial_no" value="<?php echo $serial_no; ?>" />
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" onclick="GetDocumentDetails();">Add</button>
                      </span>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['remarks']; ?></label>
            <textarea class="form-control" type="text" name="remarks" id="remarks" rows="5"><?php echo $remarks; ?></textarea>
        </div>
    </div>
</div>
<div class="row">
    
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive form-group">
            <table id="tblDeliveryChallan" class="table table-striped table-bordered" style="width: 2000px !important;">
                <thead>
                <tr align="center">
                    <!--<td style="width: 3%;"><a class="btn btn-xs btn-primary btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>-->
                    <td style="width: 3%;"></td>
                    <td style="width: 200px;" hidden><?= $lang['ref_document_no'] ?></td>
                    <td style="width: 120px;"><?php echo $lang['serial_no']; ?></td>
                    <td style="width: 350px;"><?php echo $lang['product_name']; ?></td>
                    <td style="width: 550px;"><?php echo $lang['description']; ?></td>
                    <td style="width: 300px"><?php echo $lang['batch_no']; ?></td>
                    <td style="width: 200px;"><?php echo $lang['warehouse']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['quantity']; ?></td>
                    <td style="width: 150px;"><?php echo $lang['unit']; ?></td>
                    <td style="width: 3%;"></td>
                    <!--<td style="width: 150px;"><?php echo $lang['rate']; ?></td>
                    <td style="width: 3%;"><a class="btn btn-xs btn-primary btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>-->
                </tr>
                </thead>
                <tbody >
                <?php $grid_row = 0; ?>
                <?php foreach($delivery_challan_details as $detail): ?>
                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                    <td>
                        <!--<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>-->
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                    </td>
                    <td hidden>
                        <a target="_blank" href="<?php echo $detail['href']; ?>" title="Ref. Document"><?php echo $detail['ref_document_identity']; ?></a>
                        <input type="hidden" class="form-control" id="delivery_challan_detail_ref_document_type_id_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_type_id']; ?>" readonly/>
                        <input type="hidden" class="form-control" id="delivery_challan_detail_ref_document_identity_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_identity']; ?>" readonly/>
                        <input type="hidden" class="form-control" id="delivery_challan_detail_ref_document_id_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_id']; ?>" readonly/>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="delivery_challan_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['serial_no']); ?>" readonly/>
                    </td>
                    <td>
                        <input type="hidden" id="delivery_challan_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" />
                        <input type="hidden" id="delivery_challan_detail_product_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_id']; ?>" />
                        <input type="text" id="delivery_challan_detail_product_name_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code'].' - '.$detail['product_name']; ?>" class="form-control" readonly>
                        <input type="hidden" id="delivery_challan_detail_product_master_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_master_id']; ?>" />
                    </td>
                    <td style="min-width: 300px">
                        <textarea type="text" class="form-control" rows="4" cols="5" id="delivery_challan_detail_description_<?php echo $grid_row; ?>"><?php echo htmlentities($detail['description']); ?></textarea>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="delivery_challan_detail_batch_no_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['batch_no']); ?>" readonly/>
                    </td>
                    <td>
                        <?php foreach($warehouses as $warehouse): ?>
                            <?php if($warehouse['warehouse_id']==$detail['warehouse_id']): ?>
                                <input type="hidden" id="delivery_challan_detail_warehouse_id_<?php echo $grid_row; ?>" value="<?php echo $warehouse['warehouse_id']; ?>">
                                <input type="text" id="delivery_challan_detail_warehouse_name_<?php echo $grid_row; ?>" readonly value="<?php echo $warehouse['name']; ?>" class="form-control">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" id="delivery_challan_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],2); ?>" readonly/>
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_available_stock_<?php echo $grid_row; ?>" value="<?php echo $detail['stock_qty']; ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control" id="delivery_challan_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" readonly />
                        <input type="hidden" class="form-control" id="delivery_challan_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                        <?php if(!empty($detail['ref_document_identity'])): ?>
                        <input onchange="calculateTotal(this);" type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],2); ?>" readonly />
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_cog_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_rate']; ?>" />
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_cog_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_amount']; ?>" />

                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_percent']; ?>" />
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_amount']; ?>" />

                        <?php else: ?>
                        <input onchange="calculateTotal(this);" type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],2); ?>" />
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_cog_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_rate']; ?>" />
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_cog_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_amount']; ?>" />

                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_percent']; ?>" />
                        <input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_amount']; ?>" />
                        <?php endif ?>
                    </td>
                    <td hidden="hidden">
                    </td>
                    <td>
                        <!--<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>-->
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                    </td>
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
<div class="row">
    <div class="col-md-offset-9 col-md-3">
        <div class="form-group">
            <label><span class="required">*</span> <?php echo $lang['total_qty']; ?></label>
            <input type="text"  id="total_qty" name="total_qty" value="<?php echo round_decimal($total_qty,2); ?>" class="form-control fDecimal" readonly="readonly" />
            <input type="hidden"  id="total_amount" name="total_amount" value="<?php echo $total_amount; ?>" class="form-control fDecimal" readonly="readonly" />
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

<script type="text/javascript" src="./admin/view/js/inventory/delivery_challan.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $allow_out_of_stock = '<?= $allow_out_of_stock ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    //var $products = <?php echo json_encode($products) ?>;
    var $warehouses = <?php echo json_encode($warehouses) ?>;
    var $units = <?php echo json_encode($units) ?>;
    var $UrlGetReferenceDocumentNo = '<?php echo $href_get_ref_document_no; ?>';
    var $ref_document_id = '<?php echo $ref_document_id; ?>';
    var $UrlGetSaleOrder = '<?php echo $href_get_sale_order; ?>';
    var $UrlGetRefDocument = '<?php echo $href_get_ref_document; ?>';
    var $partner_id  =    '<?php echo $partner_id; ?>';
    var $ref_document_identity  =    '<?php echo $ref_document_identity; ?>';
    var $UrlGetCustomer = '<?php echo $href_get_customer; ?>';
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $UrlAddRecords = '<?php echo $href_add_record_session; ?>';
    var $arrProducts=[];
    function formatRepo (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
        if(repo.image_url) {
            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.product_code + '- ( ' + repo.name + ' )' + "</div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name || repo.text;
    }



    <?php if($this->request->get['delivery_challan_id']): ?>
    $(document).ready(function() {
        $('#partner_id').trigger('change');
    });

    <?php endif; ?>

    function Select2ProductJsonDeliveryChallan(obj) {
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
            Select2ProductJsonDeliveryChallan('#delivery_challan_detail_product_id_'+$row_id);
            $('#delivery_challan_detail_product_id_'+$row_id).on('select2:select', function (e) {
                var $row_id = $(this).parent().parent().data('row_id');
                var $data = e.params.data;
                $('#delivery_challan_detail_product_code_'+$row_id).val($data['product_code']);
                $('#delivery_challan_detail_unit_id_'+$row_id).val($data['unit_id']);
                $('#delivery_challan_detail_unit_'+$row_id).val($data['unit']);
                $('#delivery_challan_detail_description_'+$row_id).val($data['text']);
            });
        })

    })


</script>


</body>
</html>