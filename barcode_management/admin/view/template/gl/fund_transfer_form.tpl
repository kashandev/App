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
                <a class="btn btn-info shadow" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp;<?php echo $lang['post']; ?>
                </a>
                <?php endif; ?>
                <button type="button" class="btn btn-info shadow" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa-balance-scale"></i>
                    &nbsp;<?php echo $lang['ledger']; ?>
                </button>
                <a class="btn btn-info shadow" target="_blank" href="<?php echo $action_print; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print']; ?>
                </a>
                <?php endif; ?>

                <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                    <i class="fa fa-undo"></i>
                    &nbsp;<?php echo $lang['cancel']; ?>
                </a>
                <button class="btn btn-primary shadow btnSave" onclick="$('#form').submit();">
                    <i class="fas fa-save"></i>
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

<div class="row padding-left_right_15">
<div class="col-xs-12">
<input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
<input type="hidden" value="<?php echo $document_id; ?>" name="document_id" id="document_id" />


<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<div class="row">
<div class="col-md-12">
<div class="panel panel-primary" id="hidepanel1">
<div class="panel-heading" style="background-color: #90a4ae;">
    <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
</div>
<div class="panel-body">
<fieldset>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?php echo $lang['document_no']; ?></label>
                        <input type="text" name="document_identity" value="<?php echo $document_identity; ?>" class="form-control" readonly="true" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><span class="required">*&nbsp;</span><?php echo $lang['document_date']; ?></label>
                        <input  type="text" class="dtpDate form-control" name="document_date" id="document_date" value="<?php echo $document_date; ?>" autocomplete="off" />
                    </div>
                </div>
                <div class="col-sm-3 hide">
                    <div class="form-group">
                        <label><?php echo $lang['manual_ref_no']; ?></label>
                        <input  type="text" class="form-control" name="manual_ref_no" id="manual_ref_no" value="<?php echo $manual_ref_no; ?>" autocomplete="off" />
                    </div>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?php echo $lang['instrument_date']; ?></label>
                        <input  type="text" class="dtpDate form-control" name="instrument_date" id="instrument_date" value="<?php echo $instrument_date; ?>" autocomplete="off" />
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?php echo $lang['instrument_no']; ?></label>
                        <input  type="text" class="form-control" name="instrument_no" id="instrument_no" value="<?php echo $instrument_no; ?>" autocomplete="off" />
                    </div>
                </div>
                <div class="col-sm-4">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><span class="required">*&nbsp;</span><?php echo $lang['from_account']; ?></label>
                        <select class="form-control" id="transaction_account_id" name="transaction_account_id" >
                            <option value="">&nbsp;</option>
                            <?php foreach($transaction_accounts as $transaction_account): ?>
                            <option value="<?php echo $transaction_account['coa_level3_id']; ?>" <?php echo ($transaction_account_id == $transaction_account['coa_level3_id']?'selected="selected"':''); ?>><?php echo $transaction_account['level3_display_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="transaction_account_id" class="error" style="display: none;">&nbsp;</label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?php echo $lang['remarks']; ?></label>
                        <input type="text" name="remarks" value="<?php echo $remarks; ?>" class="form-control" autocomplete="off" />
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive form-group">
                        <table id="tblFundTransferDetail" class="table table-striped table-bordered" style="width: 100% !important">
                            <thead>
                            <tr align="center">
                                <td style="width: 7%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                <!-- <td hidden><?php echo $lang['document_no']; ?></td> -->
                                <td style="width: 250px"><?php echo $lang['to_account']; ?></td>
                                <td style="width: 250px"><?php echo $lang['remarks']; ?></td>
                                <!-- <td><?php echo $lang['document_amount']; ?></td> -->
                                <!-- <td><?php echo $lang['balance_amount']; ?></td> -->
                                <td style="width: 150px"><?php echo $lang['total_amount']; ?></td>
                                <!-- <td><?php echo $lang['wht_percent']; ?></td>
                                <td><?php echo $lang['wht_amount']; ?></td>
                                <td><?php echo $lang['ot_percent']; ?></td>
                                <td><?php echo $lang['ot_amount']; ?></td>
                                <td><?php echo $lang['net_amount']; ?></td> -->
                                <td style="width: 7%;"><a class="btn btn-primary btn-sm" id="btnAddGrid" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $grid_row = 0; ?>
                            <?php foreach($fund_transfer_details as $detail): ?>
                            <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                <td>
                                    <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                    <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </td>
                                <td hidden>
                                    <input type="hidden" name="fund_transfer_details[<?php echo $grid_row; ?>][ref_document_type_id]" id="fund_transfer_detail_ref_document_type_id_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_type_id']; ?>" />
                                    <input type="hidden" name="fund_transfer_details[<?php echo $grid_row; ?>][ref_document_identity]" id="fund_transfer_detail_ref_document_identity_<?php echo $grid_row; ?>" value="<?php echo $detail['ref_document_identity']; ?>" />
                                    <a target="_blank" href="<?php echo $detail['href']; ?>"><?php echo $detail['ref_document_identity']; ?></a>
                                </td>
                                <td style="width: 200px;">
                                    <select class="form-control select2" id="fund_transfer_detail_coa_id_<?php echo $grid_row; ?>" name="fund_transfer_details[<?php echo $grid_row; ?>][coa_id]">
                                        <?php foreach($coas as $account): ?>
                                        <option value="<?php echo $account['coa_level3_id']; ?>" <?php echo ($account['coa_level3_id']==$detail['coa_id']?'selected=="true"':'');?>><?php echo $account['level3_display_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="fund_transfer_details[<?php echo $grid_row; ?>][remarks]" id="fund_transfer_detail_remarks_<?php echo $grid_row; ?>" value="<?php echo $detail['remarks']; ?>" />
                                </td>
                                <td hidden>
                                    <input type="text" class="form-control" name="fund_transfer_details[<?php echo $grid_row; ?>][document_amount]" id="fund_transfer_detail_document_amount_<?php echo $grid_row; ?>" value="<?php echo $detail['document_amount']; ?>" readonly="true"/>
                                </td>
                                <td hidden>
                                    <input type="text" class="form-control" id="fund_transfer_detail_balance_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal(($detail['document_amount']-$detail['amount']),2); ?>" readonly="true"/>
                                </td>
                                <td>
                                    <input onchange="calculateTaxes(this);" type="text" class="form-control fDecimal" name="fund_transfer_details[<?php echo $grid_row; ?>][amount]" id="fund_transfer_detail_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['amount'],2); ?>" />
                                </td>
                                <td hidden>
                                    <input onchange="calculateWHTAmount(this);" type="text" class="form-control fPDecimal" name="fund_transfer_details[<?php echo $grid_row; ?>][wht_percent]" id="fund_transfer_detail_wht_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['wht_percent']; ?>"/>
                                </td>
                                <td hidden>
                                    <input onchange="calculateWHTPercent(this);" type="text" class="form-control fPDecimal" name="fund_transfer_details[<?php echo $grid_row; ?>][wht_amount]" id="fund_transfer_detail_wht_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['wht_amount'],2); ?>"/>
                                </td>
                                <td hidden>
                                    <input onchange="calculateOtherTaxAmount(this);" type="text" class="form-control fPDecimal" name="fund_transfer_details[<?php echo $grid_row; ?>][other_tax_percent]" id="fund_transfer_detail_other_tax_percent_<?php echo $grid_row; ?>" value="<?php echo $detail['other_tax_percent']; ?>"/>
                                </td>
                                <td hidden>
                                    <input onchange="calculateOtherTaxPercent(this);" type="text" class="form-control fPDecimal" name="fund_transfer_details[<?php echo $grid_row; ?>][other_tax_amount]" id="fund_transfer_detail_other_tax_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['other_tax_amount'],2); ?>"/>
                                </td>
                                <td hidden>
                                    <input type="text" class="form-control" name="fund_transfer_details[<?php echo $grid_row; ?>][net_amount]" id="fund_transfer_detail_net_amount_<?php echo $grid_row; ?>" value="<?php echo round_decimal($detail['net_amount'],2); ?>" readonly="true"/>
                                </td>
                                <td>
                                    <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                    <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                </td>
                            </tr>
                            <?php $grid_row++; ?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-end font-weight-bold"><?php echo $lang['total_amount']; ?></td>
                                <td>
                                    <input type="text" id="total_amount" name="total_amount" value="<?php echo round_decimal($total_amount,2); ?>" class="form-control fPDecimal" readonly="readonly" />
                                </td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
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
                    <option value="<?php echo $partner_type['partner_type_id']; ?>" <?php echo ($partner_type_id == $partner_type['partner_type_id']?'selected="selected"':''); ?>><?php echo $partner_type['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="partner_type_id" class="error" style="display: none;">&nbsp;</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo $lang['partner']; ?></label>
                <select class="form-control" id="partner_id" name="partner_id">
                    <option value="">&nbsp;</option>
                </select>
                <label for="partner_id" class="error" style="display: none;">&nbsp;</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label><?php echo $lang['ref_document_no']; ?></label>
                <div class="input-group">
                    <select class="form-control" id="ref_document_identity" name="ref_document_identity">
                        <option value="">&nbsp;</option>
                    </select>
                                    <span class="input-group-btn">
                                        <button id="addRefDocument" type="button" class="btn btn-info btn-flat"><i class="fa fa-plus"></i></button>
                                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row hide">
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><span class="required">*&nbsp;</span><?= $lang['project'] ?></label>
                <select name="project_id" id="project_id" class="form-control">
                    <option value="">&nbsp;</option>
                    <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['project_id'] ?>" <?= ($project['project_id']==$project_id?'selected="selected"':'') ?>><?= $project['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for=""><span class="required">*&nbsp;</span><?= $lang['sub_project'] ?></label>
                <select name="sub_project_id" id="sub_project_id" class="form-control">
                    <option value="">&nbsp;</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 hide">
            <div class="form-group">
                <label for=""><span class="required">*&nbsp;</span><?= $lang['job_cart_no'] ?></label>
                <select name="job_cart_id" id="job_cart_id" class="form-control">
                    <option value="">&nbsp;</option>
                    <?php foreach ($job_carts as $job_cart): ?>
                    <option value="<?= $job_cart['job_cart_id'] ?>" <?= ($job_cart['job_cart_id']==$job_cart_id?'selected="selected"':'') ?>><?= $job_cart['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row hide">
        <div class="col-sm-4">
            <div class="form-group">
                <label><?php echo $lang['base_currency']; ?></label>
                <input type="hidden" id="base_currency_id" name="base_currency_id"  value="<?php echo $base_currency_id; ?>" />
                <input type="text" class="form-control" id="base_currency" name="base_currency" readonly="true" value="<?php echo $base_currency; ?>" />
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label><?php echo $lang['document_currency']; ?></label>
                <select class="form-control" id="document_currency_id" name="document_currency_id" onchange="getConversionRate();">
                    <option value="">&nbsp;</option>
                    <?php foreach($currencies as $currency): ?>
                    <option value="<?php echo $currency['currency_id']; ?>" <?php echo ($document_currency_id == $currency['currency_id']?'selected="selected"':''); ?>><?php echo $currency['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label><?php echo $lang['conversion_rate']; ?></label>
                <input class="form-control fDecimal" id="conversion_rate" type="text" name="conversion_rate" value="<?php echo $conversion_rate; ?>" />
            </div>
        </div>
    </div>

    <div class="row hide">
        <div class="offset-sm-9 col-md-3">
            <div class="form-group">

            </div>
        </div>
        <div class="col-md-2 hide">
            <div class="form-group">
                <label><?php echo $lang['wht_amount']; ?></label>
                <input type="text" id="wht_amount" name="total_wht_amount" value="<?php echo $total_wht_amount; ?>" class="form-control" readonly="readonly" />
            </div>
        </div>
        <div class="col-md-2 hide">
            <div class="form-group">
                <label><?php echo $lang['ot_amount']; ?></label>
                <input type="text" id="other_tax_amount" name="total_other_tax_amount" value="<?php echo $total_other_tax_amount; ?>" class="form-control" readonly="readonly" />
            </div>
        </div>
        <div class="col-md-2 hide">
            <div class="form-group">
                <label><?php echo $lang['net_amount']; ?></label>
                <input type="text" id="net_amount" name="total_net_amount" value="<?php echo $total_net_amount; ?>" class="form-control" readonly="readonly" />
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
<script type="text/javascript" src="./admin/view/js/gl/fund_transfer.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>

<script src="./assets/jasny-bootstrap.js" type="text/javascript"></script>

<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $isEdit = '<?php echo $isEdit; ?>';
    var $partner_id = '<?php echo $partner_id; ?>';
    // var $UrlGetPartner = '<?php echo $href_get_partner; ?>';
    var $UrlGetDocuments = '<?php echo $href_get_documents; ?>';
    var $UrlGetDocumentData = '<?php echo $href_get_document_data; ?>';
    var $UrlGetDocumentLedger = '<?php echo $href_get_document_ledger; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $coas = <?php echo json_encode($coas) ?>;
    var $partners = [];
    var $UrlGetPartnerJSON = '<?php echo $href_get_partner_json; ?>';

    var $sub_project_id = '<?php echo $sub_project_id; ?>';
    var $UrlGetSubProjects = '<?= $href_get_sub_projects; ?>';

    <?php if($this->request->get['fund_transfer_id']): ?>
    $(document).ready(function() {
        $('#partner_type_id').trigger('change');
        $('#project_id').trigger('change');
    });
    <?php endif; ?>

</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
<?php echo $footer; ?>
</body>
</html>