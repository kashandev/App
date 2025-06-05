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
<input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
<input type="hidden" value="<?php echo $document_id; ?>" name="document_id" id="document_id" />

<form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
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
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['manual_ref_no']; ?></label>
            <input class="form-control" type="text" name="manual_ref_no" value="<?php echo $manual_ref_no;?>" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="invoice_type"><?= $lang['invoice_type'] ?><span class="required">*</span></label>
            <div class="d-flex justify-content-start align-items-center mt-2">
                <label for="invoice_type_local" class="mr-5">
                    <strong class="mr-1">Local</strong>
                    <input type="radio" name="invoice_type" id="invoice_type_local" value="Local" <?= ((strtolower($invoice_type)=='local')?'checked="checked"':'') ?>>
                </label>
                <label for="invoice_type_import" class="mr-5">
                    <strong class="mr-1">Import</strong>
                    <input type="radio" name="invoice_type" id="invoice_type_import" value="Import" <?= ((strtolower($invoice_type)=='import')?'checked="checked"':'') ?>>
                </label>
            </div>
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

</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['partner_name']; ?></label>
            <select class="form-control" id="partner_id" name="partner_id">
                <option value="">&nbsp;</option>
                <?php foreach($suppliers as $supplier): ?>
                <option value="<?php echo $supplier['supplier_id']; ?>" <?php echo ($partner_id == $supplier['supplier_id']?'selected="true"':''); ?>><?php echo $supplier['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="partner_id" class="error" style="display: none;"></label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['terms']; ?></label>
            <input class="form-control" type="text" name="terms" value="<?php echo $terms; ?>" />
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['remarks']; ?></label>
            <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" />
        </div>
    </div>
</div>
<div class="row">
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
            <input class="form-control fDecimal" id="conversion_rate" type="text" name="conversion_rate" value="<?php echo $conversion_rate; ?>" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class=" table-responsive">
            <table id="tblPurchaseOrderDetail" class="table table-striped table-bordered" style="width: 180%">
                <thead>
                <tr align="center">
                    <td style="width: 7%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                    <!--<td style="width: 200px;"><?php echo $lang['project']; ?></td>-->
                    <td style="width: 200px;"><?php echo  "Serial No"; ?></td>
                    <td style="width: 200px;"><?php echo $lang['product']; ?></td>
                    <td style="width: 100px;"><?php echo $lang['unit']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['quantity']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['rate']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['amount']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['tax_percent']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['tax_amount']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['net_amount']; ?></td>
                    <td style="width: 7%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                </tr>
                </thead>
                <tbody id="tbody">
                <?php $grid_row = 0; ?>
                <?php foreach($purchase_order_details as $detail): ?>

                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                    <td>
                        <a  title="Remove" class="btn btn-xs btn-danger remove" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                    </td>
                    <!--<td style="min-width: 150px;">
                    <input type="hidden" id="purchase_order_detail_project_id_<?= $grid_row ?>" name="purchase_order_details[<?= $grid_row ?>][project_id]" value="<?= $detail['project_id'] ?>" />
                        <select class="form-control Select2SubProject " id="purchase_order_detail_sub_project_id_<?= $grid_row ?>" name="purchase_order_details[<?= $grid_row ?>][sub_project_id]" >
                            <option value="<?= $detail[sub_project_id] ?>"><?= $detail['project'] .' - '. $detail['sub_project'] ?></option>
                        </select>
                        <label for="purchase_order_detail_sub_project_id_<?= $grid_row ?>" class="error" style="display:none"></label>
                    </td>-->
                    <td class="row-index increment clearfix">
                    <p>  
                        <?php
                            echo $grid_row+1;
                        ?>
                  </p>
                    </td>
                    <td style="min-width: 250px;">
                        <input type="hidden" class="form-control" name="purchase_order_details[<?= $grid_row ?>][product_code]" id="purchase_order_detail_product_code_<?= $grid_row ?>" value="<?= $detail['product_code'] ?>" />
                        <input type="hidden" id="purchase_order_detail_type_of_material_<?= $grid_row ?>" value="<?= $detail['type_of_material'] ?>" />
                        <select class="required form-control Select2ProductMaster purchase_order_detail_product_id_<?= $grid_row ?> required" id="purchase_order_detail_product_id_<?= $grid_row ?>" name="purchase_order_details[<?= $grid_row ?>][product_id]" required>
                            <option value="<?= $detail['product_id'] ?>"><?= implode(' - ', array(
                                    $detail['product_code'],
                                    $detail['brand'],
                                    $detail['model'],
                                    $detail['product_name'],
                                    )) ?>
                        
                </option>
                        </select>
                        <label for="purchase_order_detail_product_id_<?= $grid_row ?>" class="error" style="display:none"></label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="purchase_order_details[<?php echo $grid_row; ?>][unit]" id="purchase_order_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" readonly="true" />
                        <input type="hidden" class="form-control purchase_order_detail_unit_id_<?php echo $grid_row; ?>" name="purchase_order_details[<?php echo $grid_row; ?>][unit_id]" id="" value="<?php echo $detail['unit_id']; ?>" />
                    </td>
                    <!--<td>
                        <input type="text" class="form-control" name="purchase_order_details[<?php echo $grid_row; ?>][charge_unit]" id="purchase_order_detail_charge_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['charge_unit']; ?>" readonly="true" />
                        <input type="hidden" class="form-control" name="purchase_order_details[<?php echo $grid_row; ?>][charge_unit_id]" id="purchase_order_detail_charge_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['charge_unit_id']; ?>" />
                    </td>-->
                    <td>
                        <input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal purchase_order_detail_qty_<?php echo $grid_row; ?>" name="purchase_order_details[<?php echo $grid_row; ?>][qty]" id="purchase_order_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],4); ?>" />
                    </td>
                   <!-- <td>
                        <input type="hidden" id="purchase_order_detail_base_calc_weight_<?php echo $grid_row; ?>" value="<?php echo $detail['base_calc_weight']; ?>" readonly/>
                        <input type="text" onchange="calculateRowTotal(this);" class="form-control fPDecimal" name="purchase_order_details[<?php echo $grid_row; ?>][calc_weight]" id="purchase_order_detail_calc_weight_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['calc_weight'],4); ?>" readonly/>
                    </td>-->
                    <td>
                        <input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="purchase_order_details[<?php echo $grid_row; ?>][rate]" id="purchase_order_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],4); ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control fPDecimal" name="purchase_order_details[<?php echo $grid_row; ?>][amount]" id="purchase_order_detail_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['amount'],2); ?>" readonly="true" />
                    </td>
                    <td>
                        <input type="text" onchange="calculateTaxAmount(this);" class="form-control fPDecimal" name="purchase_order_details[<?php echo $grid_row; ?>][tax_percent]" id="purchase_order_detail_tax_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_percent']; ?>" />
                    </td>
                    <td>
                        <input type="text" onchange="calculateTaxPercent(this);" class="form-control fPDecimal" name="purchase_order_details[<?php echo $grid_row; ?>][tax_amount]" id="purchase_order_detail_tax_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['tax_amount']; ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control fPDecimal" name="purchase_order_details[<?php echo $grid_row; ?>][net_amount]" id="purchase_order_detail_net_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['net_amount']; ?>" readonly="true" />
                    </td>
                    <td>
                        <a  title="Remove" class="btn btn-xs btn-danger remove" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
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
    <div class="col-md-3 col-md-offset-9">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?= $lang['total_amount'] ?></label>
            <input type="text" name="total_amount" id="total_amount" class="form-control fDecimal" value="<?= round_decimal($total_amount,2) ?>" readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-9">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['converted_total_amount']; ?>&nbsp;(<?php echo $base_currency; ?>)</label>
            <input type="text"  id="converted_total_amount" value="<?php echo round_decimal(($total_amount*$conversion_rate),2); ?>" class="form-control fDecimal" readonly="readonly" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-9">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?= $lang['total_tax_amount'] ?></label>
            <input type="text" name="total_tax_amount" id="total_tax_amount" class="form-control fDecimal" value="<?= round_decimal($total_tax_amount,2) ?>" readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-9">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['total_net_amount']; ?></label>
            <input type="text"  id="total_net_amount" name="total_net_amount" value="<?php echo round_decimal($total_net_amount,2); ?>" class="form-control fDecimal" readonly="readonly" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-md-offset-9">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['converted_net_amount']; ?>&nbsp;(<?php echo $base_currency; ?>)</label>
            <input type="text"  id="converted_amount" name="base_amount" value="<?php echo round_decimal($base_amount,2); ?>" class="form-control fDecimal" readonly="readonly" />
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


<link rel="stylesheet" href="./assets/plugins/dataTables/dataTables.bootstrap.css">
<script src="./assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="./assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="./admin/view/js/inventory/purchase_order.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script src="./assets/jasny-bootstrap.js" type="text/javascript"></script>

<script>

    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $lang = <?php echo json_encode($lang) ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $products = <?php echo json_encode($products) ?>;
    var $warehouses = <?php echo json_encode($warehouses) ?>;
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';

    function Select2ProductMasterPurchaseOrder(obj) {
        var $Url = '<?php echo $href_get_json_products_for_purchase_order; ?>';

        select2OptionList(obj,$Url);
    }

    function formatRepo (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
        if(repo.image_url) {
            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + (repo.name || repo.text) + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
                "   <div class='help-block'>" + repo.length + " X " + repo.width + " X " + repo.thickness + "</div>" +
                "</div>" +
                "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        // console.log( repo )
        return (repo.name || repo.text);
    }




    <?php if($this->request->get['purchase_order_id']): ?>
    $(document).ready(function() {
        $('#partner_type_id').trigger('change');

        $('#Select2SubProject').each(function(index, element){
            var $ele = $(element);
            var $row_id = $ele.parent().parent().data('row_id');
            Select2SubProject('#purchase_order_detail_sub_project_id_'+$row_id);
            $('#purchase_order_detail_sub_project_id_'+$row_id).on('select2:select', function (e) {
                var $row_id = $(this).parent().parent().data('row_id');
                var $data = e.params.data;
                $('#purchase_order_detail_project_id_'+$row_id).val($data['project_id']);
            });
        })
        $('#Select2ProductMaster').each(function(index, element){
            var $ele = $(element);
            var $row_id = $ele.parent().parent().data('row_id');
            Select2ProductMasterPurchaseOrder('.purchase_order_detail_product_id_'+$row_id);
            $('.purchase_order_detail_product_id_'+$row_id).on('select2:select', function (e) {
                var $row_id = $(this).parent().parent().data('row_id');
                var $data = e.params.data;
                $('#purchase_order_detail_product_code_'+$row_id).val($data['product_code']);
                $('#purchase_order_detail_unit_'+$row_id).val($data['unit']);
                $('#purchase_order_detail_unit_id_'+$row_id).val($data['unit_id']);
            });
        })

    });
    <?php endif; ?>

    function Save(){
        $('#form').submit();
    }
</script>
<?php echo $page_footer; ?>
<?php echo $footer; ?>

</body>
</html>