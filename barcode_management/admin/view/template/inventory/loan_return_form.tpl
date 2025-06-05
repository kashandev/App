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
                <?php else: ?>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print_barcode; ?>">
                    <i class="fa fa-barcode"></i>
                    &nbsp;Print Barcode
                </a>
                <?php endif; ?>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Print
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

<div class="row padding-left_right_15">
    <div class="col-xs-12">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
                <input type="hidden" value="<?php echo $loan_return_id; ?>" name="document_id" id="document_id" />
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
                            <label><span class="required">*</span>&nbsp;<?php echo $lang['customer']; ?></label>
                            <input type="hidden" name="partner_type_id" name="partner_type_id" value="<?= $partner_type_id ?>">
                            <select class="form-control" id="partner_id" name="partner_id">
                                <option value="">&nbsp;</option>
                                <?php foreach($partners as $partner): ?>
                                <option value="<?php echo $partner['partner_id']; ?>" <?php echo ($partner_id == $partner['partner_id']?'selected="selected"':''); ?>><?php echo $partner['name']; ?></option>
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
                            <input class="form-control" type="text" name="remarks" value="<?php echo $remarks; ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive form-group">
                            <table id="tblLoanReturn" class="table table-striped table-bordered" style="width: 1200px !important;">
                            <thead>
                                <tr align="center" data-row_id="H" id="grid_row_H">
                                    <td style="width: 3%;">
                                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                    <td style="width: 350px;"><?php echo $lang['product_name']; ?></td>
                                    <td style="width: 550px;"><?php echo $lang['description']; ?></td>
                                    <td style="width: 120px;"><?php echo $lang['serial_no']; ?></td>
                                    <td style="width: 300px"><?php echo $lang['batch_no']; ?></td>
                                    <td style="width: 250px;"><?php echo $lang['warehouse']; ?></td>
                                    <td style="width: 120px;"><?php echo $lang['quantity']; ?></td>
                                    <td style="width: 150px;"><?php echo $lang['unit']; ?></td>
                                    <td style="width: 150px;"><?php echo $lang['rate']; ?></td>
                                    <td style="width: 150px;"><?php echo $lang['amount']; ?></td>
                                    <td style="width: 3%;">
                                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody >
                                <?php $grid_row=0; foreach($loan_return_details as $detail): ?>
                                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                    <td>
                                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                    </td>
                                    <td>
                                        <input type="hidden" class="form-control" name="loan_return_details[<?= $grid_row ?>][product_code]" id="loan_return_detail_product_code_<?= $grid_row ?>" value="<?= $detail['product_code'] ?>" />
                                        <select class="required form-control Select2Product required" id="loan_return_detail_product_id_<?= $grid_row ?>" name="loan_return_details[<?= $grid_row ?>][product_id]" required>
                                            <option value="<?= $detail['product_id'] ?>"><?= implode(' - ', array(
                                            $detail['product_code'],
                                            $detail['brand'],
                                            $detail['model'],
                                            $detail['product_name'],
                                            )) ?></option>
                                        </select>
                                    </td>
                                    <td style="min-width: 300px">
                                        <textarea type="text" class="form-control" rows="4" cols="5" id="loan_return_detail_description_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][description]"><?php echo htmlentities($detail['description']); ?></textarea>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="loan_return_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['serial_no']); ?>" name="loan_return_details[<?= $grid_row ?>][serial_no]"/>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="loan_return_detail_batch_no_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][batch_no]" value="<?php echo htmlentities($detail['batch_no']); ?>"/>
                                    </td>
                                    <td>
                                        <select class="form-control" id="loan_return_detail_warehouse_id_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][warehouse_id]">
                                            <option value="">&nbsp;</option>
                                            <?php foreach ($warehouses as $warehouse): ?>
                                            <option value="<?= $warehouse['warehouse_id'] ?>" <?= ($detail['warehouse_id']==$warehouse['warehouse_id']?'selected="selected"':'') ?> ><?= $warehouse['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" id="loan_return_detail_qty_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][qty]" value="<?php echo round_decimal($detail['qty'],2); ?>"/>
                                        <input type="hidden" class="form-control fPDecimal" id="loan_return_detail_available_stock_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][available_stock]" value="<?php echo $detail['stock_qty']; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="loan_return_detail_unit_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][unit]" value="<?php echo $detail['unit']; ?>" readonly />
                                        <input type="hidden" class="form-control" id="loan_return_detail_unit_id_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][unit_id]" value="<?php echo $detail['unit_id']; ?>" /> 
                                    </td>
                                    <td>
                                        <input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" id="loan_return_detail_rate_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][rate]" value="<?php echo round_decimal($detail['rate'],2); ?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control fPDecimal" id="loan_return_detail_amount_<?php echo $grid_row; ?>" name="loan_return_details[<?= $grid_row ?>][amount]" value="<?php echo $detail['amount']; ?>" readonly/>
                                    </td>
                                    <td>
                                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <?php $grid_row++; endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-9">
                        <div class="form-group">
                            <label><span class="required">*</span>&nbsp;<?php echo $lang['total_amount']; ?></label>
                            <input type="text" id="total_amount" name="total_amount" value="<?php echo $total_amount; ?>" class="form-control fDecimal" readonly="readonly" />
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

    <script type="text/javascript" src="./admin/view/js/inventory/loan_return.js"></script>
    <script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
    <script>
        jQuery('#form').validate(<?php echo $strValidation; ?>);
        var $lang = <?php echo json_encode($lang) ?>;
        var $grid_row = '<?php echo $grid_row; ?>';
        var $products = <?php echo json_encode($products) ?>;
        var $warehouses = <?php echo json_encode($warehouses) ?>;
        var $UrlGetProductStock = '<?php echo $href_get_product_stock; ?>';
        var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';

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

        function Select2ProductJSON(obj) {
            var $Url = '<?php echo $href_get_json_products; ?>';
            select2OptionList(obj,$Url);
        }

        $(function(){

            $('.Select2Product').each(function(index, element) {
                var $ele = $(element);
                var $row_id = $ele.parent().parent().data('row_id');
                Select2ProductJSON('#loan_return_detail_product_id_'+$row_id);
                $('#loan_return_detail_product_id_'+$row_id).on('select2:select', function (e) {
                    var $row_id = $(this).parent().parent().data('row_id');
                    var $data = e.params.data;
                    console.log( $data )
                    $('#loan_return_detail_product_master_id_'+$row_id).val($data['product_master_id']);
                    $('#loan_return_detail_product_code_'+$row_id).val($data['product_code']);
                    $('#loan_return_detail_unit_id_'+$row_id).val($data['unit_id']);
                    $('#loan_return_detail_unit_'+$row_id).val($data['unit']);
                    $('#loan_return_detail_description_'+$row_id).val($data['text']);
                });
            });
        })
        <?php if(isset($this->request->get['loan_return_id'])): ?>
        <?php endif; ?>
    </script>
</body>
</html>