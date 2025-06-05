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

                <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa fa-balance-scale"></i>
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
                <?php if($is_post == 0): ?>
                <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();">
                    <i class="fa fa-floppy-o"></i>
                    &nbsp;<?php echo $lang['save']; ?>
                </a>
                <?php endif; ?>
                <?php if($is_post == 1): ?>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print_barcode; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print_barcode']; ?>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary" id="hidepanel1">
                        <div class="panel-heading" style="background-color: #90a4ae;">
                            <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
                        </div>
                        <div class="panel-body">
                            <fieldset>
                            <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
            <input type="hidden" value="<?php echo $stock_adjustment_id; ?>" name="document_id" id="document_id" />
            <input type="hidden" id="form_key" name="form_key" value="<?php echo $form_key ?>" />
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label><span class="required">*</span>&nbsp;<?php echo $lang['warehouse']; ?></label>
                        <select class="form-control" id="warehouse_id" name="warehouse_id">
                            <option value="">&nbsp;</option>
                            <?php foreach($warehouses as $warehouse): ?>
                            <option value="<?php echo $warehouse['warehouse_id']; ?>" <?php echo ($warehouse_id == $warehouse['warehouse_id']?'selected="selected"':''); ?>><?php echo $warehouse['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="warehouse_id" class="error" style="display: none;">&nbsp;</label>
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?php echo $lang['remarks']; ?></label>
                        <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive QA_table">
                        <table id="tblStockAdjustmentDetail" class="table table-striped table-bordered" style="width: 1500px !important">
                            <thead>
                            <tr align="center">
                                <td style="width:3% !important;">
                                    <a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </td>
                                <td style="width: 350px"><?php echo $lang['product_name']; ?></td>
                                <td><?php echo $lang['unit']; ?></td>
                                <td><?php echo $lang['stock_quantity']; ?></td>
                                <td><?php echo $lang['quantity']; ?></td>
                                <td><?php echo $lang['charge_unit']; ?></td>
                                <td><?php echo $lang['calc_weight']; ?></td>
                                <td><?php echo $lang['rate']; ?></td>
                                <td><?php echo $lang['amount']; ?></td>
                                <td style="width:3% !important;"><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                            </tr>
                            </thead>
                            <tbody >
                            <?php $grid_row = 0; ?>
                            <?php foreach($stock_adjustment_details as $detail): ?>
                            <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                <td>
                                    <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" />
                                    <input type="hidden" id="stock_adjustment_detail_product_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_id']; ?>"/>
                                    <input type="text" id="stock_adjustment_detail_product_name_<?php echo $grid_row; ?>" value="<?php echo $detail['product_name']; ?>" class="form-control" readonly>
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                                    <input type="text" id="stock_adjustment_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" class="form-control" readonly/>
                                </td>
                                <td>
                                    <input type="text" id="stock_adjustment_detail_stock_qty_<?php echo $grid_row; ?>" value="<?php echo $detail['stock_qty']; ?>" class="form-control fDecimal" readonly/>
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_hidden_qty_<?php echo $grid_row; ?>" value="<?php echo $detail['qty']; ?>">
                                    <input onchange="calculateWeightTotal(this);" type="text" class="form-control fDecimal" id="stock_adjustment_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],2); ?>" />
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_hidden_charge_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['charge_unit_id']; ?>">
                                    <input type="text" class="form-control" id="stock_adjustment_detail_charge_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['charge_unit']; ?>" readonly/>
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_hidden_calc_weight_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['hidden_calc_weight'],2); ?>"/>
                                    <input onchange="calculateRowTotal(this);" type="text" class="form-control fDecimal" id="stock_adjustment_detail_calc_weight_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['calc_weight'],2); ?>"/>
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_hidden_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['rate']; ?>">
                                    <input onchange="calculateRowTotal(this);" type="text" class="form-control fDecimal" id="stock_adjustment_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],2); ?>" />
                                </td>
                                <td>
                                    <input type="hidden" id="stock_adjustment_detail_hidden_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['amount']; ?>">
                                    <input onchange="calculateTotal();" type="text" class="form-control fDecimal" id="stock_adjustment_detail_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['amount'],2); ?>" />
                                </td>
                                <td>
                                    <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
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
            <div class="row mt-5">
                <div class="offset-sm-6 col-md-3">
                    <div class="form-group">
                        <label><span class="required">*</span>&nbsp;<?php echo $lang['total_qty']; ?></label>
                        <input type="text" id="total_qty" name="total_qty" value="<?php echo round_decimal($total_qty,2); ?>" class="form-control fDecimal" readonly="readonly" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><span class="required">*</span>&nbsp;<?php echo $lang['total_amount']; ?></label>
                        <input type="text" id="total_amount" name="total_amount" value="<?php echo round_decimal($total_amount,2); ?>" class="form-control fDecimal" readonly="readonly" />
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

<link rel="stylesheet" href="./assets/plugins/dataTables/dataTables.bootstrap.css">
<script src="./assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="./assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="./admin/view/js/inventory/stock_adjustment.js"></script>
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $lang = <?php echo json_encode($lang) ?>;
    var $grid_row = '<?php echo $grid_row; ?>';
    var $UrlGetWarehouseStocks = '<?php echo $href_get_warehouse_stocks; ?>';
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $UrlAddRecords = '<?php echo $href_add_record_session; ?>';
    var $UrlGetLedger = '<?php echo $href_get_ledger; ?>';

    function formatRepo (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
        if(repo.image_url) {
            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.product_code+' - '+repo.name + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        if(repo.statistics) {
            markup += "<div class='select2-result-repository__statistics'>" +
                    "   <div class='help-block'>" + repo.length + " X " + repo.width + " X " + repo.thickness + "</div>" +
                    "</div>";
        }
        markup += "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return (repo.product_code+'-'+repo.name) || repo.text;
    }

    function Select2ProductStockAdjustment(obj) {
        var $Url = '<?php echo $href_get_json_products; ?>';
        select2OptionList(obj,$Url);
    }

    $('.Select2Product').each(function(index, element){
        var $ele = $(element);
        var $row_id = $ele.parent().parent().data('row_id');
        Select2ProductStockAdjustment('#stock_adjustment_detail_product_id_'+$row_id);
        $('#stock_adjustment_detail_product_id_'+$row_id).on('select2:select', function (e) {
            var $row_id = $(this).parent().parent().data('row_id');
            var $data = e.params.data;
            $('#stock_adjustment_detail_product_code_'+$row_id).val($data['product_code']);
            $('#stock_adjustment_detail_unit_'+$row_id).val($data['unit']);
            $('#stock_adjustment_detail_unit_id_'+$row_id).val($data['unit_id']);
            $('#stock_adjustment_detail_charge_unit_'+$row_id).val($data['charge_unit']);
            $('#stock_adjustment_detail_charge_unit_id_'+$row_id).val($data['charge_unit_id']);
            $('#stock_adjustment_detail_type_of_material_'+$row_id).val($data['type_of_material']);
            getWarehouseStock('#stock_adjustment_detail_product_id_'+$row_id);

        });
    })
    ;

</script>

</body>
</html>