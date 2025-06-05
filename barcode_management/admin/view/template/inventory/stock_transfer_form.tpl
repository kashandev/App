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
<input type="hidden" value="<?php echo $stock_transfer_id; ?>" name="document_id" id="document_id" />
<input type="hidden" value="<?= $allow_out_of_stock ?>" name="allow_out_of_stock" id="allow_out_of_stock">

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
            <label><span class="required">*</span>&nbsp;<?php echo $lang['from_warehouse']; ?></label>
            <select class="form-control" id="warehouse_id" name="warehouse_id">
                <option value="">&nbsp;</option>
                <?php foreach($FromWarehouses as $warehouse): ?>
                <option value="<?php echo $warehouse['warehouse_id']; ?>" <?php echo ($warehouse_id == $warehouse['warehouse_id']?'selected="selected"':''); ?>><?php echo $warehouse['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <!--<div class="col-sm-3">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['partner']; ?></label>
            <select class="form-control" id="partner_id" name="partner_id">
                <option value="">&nbsp;</option>
                <?php foreach($partners as $partner): ?>
                <option value="<?php echo $partner['customer_id']; ?>" <?php echo ($partner_id == $partner['customer_id']?'selected="selected"':''); ?>><?php echo $partner['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>-->
    <div class="col-sm-6 hide">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['to_branch']; ?></label>
            <select class="form-control" id="to_branch_id" name="to_branch_id" onchange="getWarehouseByBranchId();" >
                <option value="">&nbsp;</option>
                <?php foreach($company_branchs as $company_branch): ?>
                <option value="<?php echo $company_branch['company_branch_id']; ?>" <?php echo ($to_branch_id == $company_branch['company_branch_id']?'selected="selected"':''); ?>><?php echo $company_branch['name']; ?></option>
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
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['remarks']; ?></label>
            <textarea class="form-control" name="remarks" id="remarks" rows="5"><?php echo $remarks; ?></textarea>
        </div>
    </div>
    <div class="col-sm-3 hide">
        <div class="form-group">
            <label><?php echo $lang['last_rate']; ?></label>
            <input  style="color:red;font-weight: bolder; font-size: 18px" class="form-control" type="text" name="txt_last_rate" id="txt_last_rate" value="<?php echo $txt_last_rate; ?>" readonly/>
        </div>
    </div>

</div>
<div class="row hide">
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['billty_remarks']; ?></label>
            <input class="form-control" type="text" name="billty_remarks" value="<?php echo $billty_remarks; ?>" />
        </div>
    </div>
    <div class="col-sm-3">
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
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive form-group">
            <table id="tblStockTransferDetail" class="table table-striped table-bordered" style="width: 1500px !important">
                <thead>
                <tr align="center">
                    <td style="width: 3%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                    <!-- <td style="width: 120px;"><?php echo $lang['product_code']; ?></td> -->
                    <td style="width: 120px;"><?php echo $lang['serial_no']; ?></td>
                    <td style="width: 250px;"><?php echo $lang['product_name']; ?></td>
                    <td style="width: 250px;"><?php echo $lang['description']; ?></td>
                    <td style="width: 300px"><?php echo $lang['batch_no']; ?></td>
                    <td style="width: 150px;"><?php echo $lang['warehouse']; ?></td>
                    <td style="width: 150px;"><?php echo $lang['unit']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['stock_quantity']; ?></td>
                    <!--<td style="width: 120px;"><?php echo $lang['quantity']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['rate']; ?></td>
                    <td style="width: 120px;"><?php echo $lang['amount']; ?></td>-->
                    <td style="width: 3%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                </tr>
                </thead>
                <tbody >
                <?php $grid_row = 0; ?>
                <?php foreach($stock_transfer_details as $detail): ?>
                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                    <td>
                        <a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                    </td>
                    <td>
                        <input type="text" class="form-control " name="stock_transfer_details[<?php echo $grid_row; ?>][serial_no]" id="stock_transfer_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['serial_no']); ?>" readonly/>
                    </td>
                    <td style="min-width: 250px;">
                        <input type="hidden" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][product_code]" id="stock_transfer_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $detail['product_code']; ?>" />
                        <input type="hidden" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][product_id]" id="stock_transfer_detail_product_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_id']; ?>" />
                        <input type="hidden" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][product_master_id]" id="stock_transfer_detail_product_master_id_<?php echo $grid_row; ?>" value="<?php echo $detail['product_master_id']; ?>" />
                        <input type="text" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][product_name]" id="stock_transfer_detail_product_name_<?php echo $grid_row; ?>" value="<?php echo $detail['product_name']; ?>" readonly/>
                    </td>
                    <td>
                        <input style="min-width: 250px;" type="text" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][description]" id="stock_transfer_detail_description_<?php echo $grid_row; ?>" value="<?php echo $detail['description']; ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control " name="stock_transfer_details[<?php echo $grid_row; ?>][batch_no]" id="stock_transfer_detail_batch_no_<?php echo $grid_row; ?>" value="<?php echo $detail['batch_no']; ?>" readonly/>
                    </td>
                    <td>
                        <select onchange="getWarehouseStock(this)" class="form-control select2" id="stock_transfer_detail_warehouse_id_<?php echo $grid_row; ?>" name="stock_transfer_details[<?php echo $grid_row; ?>][warehouse_id]" required>
                            <option value="">&nbsp;</option>
                            <?php foreach($warehouses as $warehouse): ?>
                            <option value="<?php echo $warehouse['warehouse_id']; ?>" <?php echo ($warehouse['warehouse_id']==$detail['warehouse_id']?'selected="true"':'');?>><?php echo $warehouse['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][unit]" id="stock_transfer_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" readonly="true" />
                        <input type="hidden" class="form-control" name="stock_transfer_details[<?php echo $grid_row; ?>][unit_id]" id="stock_transfer_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                    </td>
                    <td>
                        <input type="text" class="form-control fPDecimal" name="stock_transfer_details[<?php echo $grid_row; ?>][stock_qty]" id="stock_transfer_detail_stock_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['stock_qty'],2); ?>" readonly="true" />
                    </td>
                    <td hidden="hidden">
                        <input onchange="calculateWeightTotal(this);" type="text" class="form-control fPDecimal" name="stock_transfer_details[<?php echo $grid_row; ?>][qty]" id="stock_transfer_detail_qty_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['qty'],2); ?>" />
                    </td>
                   <td hidden="hidden">
                        <input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="stock_transfer_details[<?php echo $grid_row; ?>][rate]" id="stock_transfer_detail_rate_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['rate'],2); ?>" readonly/>
                        <input type="hidden" class="form-control fPDecimal" name="stock_transfer_details[<?php echo $grid_row; ?>][cog_rate]" id="stock_transfer_detail_cog_rate_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_rate']; ?>" />
                    </td>
                    <td hidden="hidden">
                        <input type="text" class="form-control fPDecimal" name="stock_transfer_details[<?php echo $grid_row; ?>][amount]" id="stock_transfer_detail_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['amount'],2); ?>" readonly/>
                        <input type="hidden" class="form-control fPDecimal" name="stock_transfer_details[<?php echo $grid_row; ?>][cog_amount]" id="stock_transfer_detail_cog_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['cog_amount']; ?>" />
                    </td>
                    <td>
                        <a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
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
            <label><?php echo $lang['total_qty']; ?></label>
            <input type="text" id="total_qty" name="total_qty" value="<?php echo round_decimal($total_qty,2); ?>" class="form-control fDecimal" readonly="readonly" />
        </div>
    </div>
    <!--<div class="col-md-3">
        <div class="form-group">
            <label><?php echo $lang['total_amount']; ?></label>
            <input type="text" id="total_amount" name="total_amount" value="<?php echo round_decimal($total_amount,2); ?>" class="form-control fDecimal" readonly="readonly" />
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
<script type="text/javascript" src="./admin/view/js/inventory/stock_transfer.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $allow_out_of_stock = '<?= $allow_out_of_stock ?>';
    var $lang = <?php echo json_encode($lang); ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $UrlGetWarehouseByBranchId = '<?php echo $get_warehouse_by_branch; ?>';
    var $products = <?php echo json_encode($products); ?>;
    var $warehouses = <?php echo json_encode($warehouses); ?>;
    // var $warehouses = '';
    var $company_branchs = <?php echo json_encode($company_branchs); ?>;
    var $branch_id;

    function Select2ProductStockTransfer(obj) {
        var $Url = '<?php echo $href_get_json_products; ?>';
        select2OptionList(obj,$Url);
    }

    <?php if($this->request->get['stock_transfer_id']): ?>
    $(document).ready(function() {
        $('#partner_type_id').trigger('change');
        $('#to_branch_id').trigger('change');

        // $('.Select2Product').each(function(index, element){
        //     var $ele = $(element);
        //     var $row_id = $ele.parent().parent().data('row_id');
        //     Select2ProductStockTransfer('#stock_transfer_detail_product_id_'+$row_id);
        //     $('#stock_transfer_detail_product_id_'+$row_id).on('select2:select', function (e) {
        //         var $row_id = $(this).parent().parent().data('row_id');
        //         var $data = e.params.data;
        //         $('#stock_transfer_detail_product_code_'+$row_id).val($data['product_code']);
        //         $('#stock_transfer_detail_unit_'+$row_id).val($data['unit']);
        //         $('#stock_transfer_detail_unit_id_'+$row_id).val($data['unit_id']);

        //         setTimeout(function(){
        //             $('#stock_transfer_detail_warehouse_id_'+$row_id).trigger('change');
        //         },1);

        //     });
        // })


    });
    <?php endif; ?>
</script>

</body>
</html>