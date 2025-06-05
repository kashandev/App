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
    <div class="col-sm-3">
        <div class="form-group">
            <label><?php echo $lang['document_no']; ?></label>
            <input type="text" name="document_identity" value="<?php echo $document_identity; ?>" class="form-control" readonly="true" />
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label><span class="required">*</span>&nbsp;<?php echo $lang['document_date']; ?></label>
            <input class="form-control dtpDate" type="text" name="document_date" value="<?php echo $document_date; ?>" />
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label><?php echo $lang['remarks']; ?></label>
            <input type="text" class="form-control" name="remarks" value="<?php echo $remarks; ?>" />
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
<div class="row">

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive form-group">
            <table id="tblJournalVoucherDetail" class="table table-striped table-bordered" style="width: 100% !important">
                <thead>
                <tr align="center">
                    <td style="width: 3px;">
                        <button type="button" id="btnAddGrid" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
                    </td>
                    <td><?php echo $lang['partner_type']; ?></td>
                    <td><?php echo $lang['partner_name']; ?></td>
                    <td><?php echo $lang['document_no']; ?></td>
                    <td><?php echo $lang['coa']; ?></td>
                    <!--<td style="width: 250px"><?php echo $lang['project'] ?></td>
                    <td style="width: 250px"><?php echo $lang['sub_project'] ?></td>
                    <td style="width: 250px"><?php echo $lang['job_card_no'] ?></td>-->
                    <td><?php echo $lang['remarks']; ?></td>
                    <td><?php echo $lang['cheque_date']; ?></td>
                    <td><?php echo $lang['cheque_no']; ?></td>
                    <td><?php echo $lang['debit']; ?></td>
                    <td><?php echo $lang['credit']; ?></td>
                    <td style="width: 3px;">
                        <button type="button" id="btnAddGrid" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
                    </td>
                </tr>
                </thead>
                <?php $grid_row = 0; ?>
                <tbody>
                <?php foreach($journal_voucher_details as $detail): ?>
                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                    <td>
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                    </td>
                    <td>
                        <input type="hidden" class="form-control" id="journal_voucher_detail_partner_type_id_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][partner_type_id]" value="<?php echo $detail['partner_type_id']; ?>" />
                        <input type="text" class="form-control" id="journal_voucher_detail_partner_type_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][partner_type]" value="<?php echo $detail['partner_type']; ?>" readonly/>
                    </td>
                    <td style="min-width: 250px;">
                        <input type="hidden" class="form-control" id="journal_voucher_detail_partner_id_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][partner_id]" value="<?php echo $detail['partner_id']; ?>" />
                        <input type="text" class="form-control" id="journal_voucher_detail_partner_name_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][partner_name]" value="<?php echo $detail['partner_name']; ?>" readonly/>
                    </td>
                    <td>
                        <input type="hidden" class="form-control" id="journal_voucher_detail_ref_document_type_id_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][ref_document_type_id]" value="<?php echo $detail['ref_document_type_id']; ?>" />
                        <input type="text" class="form-control" id="journal_voucher_detail_ref_document_identity_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][ref_document_identity]" value="<?php echo $detail['ref_document_identity']; ?>" readonly/>
                    </td>
                    <td  style="min-width: 300px;">
                        <input type="hidden" class="form-control" id="journal_voucher_detail_coa_id_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][coa_id]" value="<?php echo $detail['coa_id']; ?>" />
                        <input type="text" class="form-control" id="journal_voucher_detail_account_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][account]" value="<?php echo $detail['account']; ?>" readonly/>
                    </td>

                    <!--<td style="width: 200px;">
                        <select onchange="getSubProjects('<?= $grid_row ?>')" name="journal_voucher_details[<?php echo $grid_row; ?>][project_id]" id="journal_voucher_detail_project_id_<?php echo $grid_row; ?>" class="form-control select2">
                            <option value="">&nbsp;</option>
                            <?php foreach ($projects as $project): ?>
                            <option value="<?= $project['project_id'] ?>" <?=  ($project['project_id']==$detail['project_id']?'selected="selected"':'') ?> ><?= $project['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="journal_voucher_detail_project_id_<?php echo $grid_row; ?>" class="error" style="display: none"></label>
                    </td>
                    <td style="width: 200px;">
                        <select onchange="getJobOrders('<?= $grid_row ?>')" name="journal_voucher_details[<?php echo $grid_row; ?>][sub_project_id]" id="journal_voucher_detail_sub_project_id_<?php echo $grid_row; ?>" class="form-control select2">
                            <option value="">&nbsp;</option>
                            <?php foreach($detail['sub_projects'] as $sub_project): ?>
                            <option value="<?= $sub_project['sub_project_id'] ?>" <?= ($sub_project['sub_project_id']==$detail['sub_project_id']?'selected="selected"':'') ?>><?= $sub_project['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="journal_voucher_detail_sub_project_id_<?php echo $grid_row; ?>" class="error" style="display: none"></label>
                    </td>
                    <td style="width: 200px;">
                        <select name="journal_voucher_details[<?php echo $grid_row; ?>][job_order_id]" id="journal_voucher_detail_job_order_id_<?php echo $grid_row; ?>" class="form-control select2">
                            <option value="">&nbsp;</option>
                            <?php foreach($detail['job_orders'] as $job_order): ?>
                            <option value="<?= $job_order['job_order_id'] ?>" <?= ($job_order['job_order_id']==$detail['job_order_id']?'selected="selected"':'') ?>><?= ($job_order['document_identity'] .' - '. $job_order['description']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="journal_voucher_detail_job_order_id_<?php echo $grid_row; ?>" class="error" style="display: none"></label>
                    </td>-->

                    <td><input type="text" class="form-control" id="journal_voucher_detail_remarks_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][remarks]" value="<?php echo $detail['remarks']; ?>" /></td>
                    <td><input type="text" class="form-control dtpDate" id="journal_voucher_detail_cheque_date_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][cheque_date]" value="<?php echo $detail['cheque_date']; ?>" /></td>
                    <td><input type="text" class="form-control fDecimal" id="journal_voucher_detail_cheque_no_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][cheque_no]" value="<?php echo $detail['cheque_no']; ?>" /></td>
                    <td><input onchange="calculateTotal();" type="text" class="form-control fDecimal" id="journal_voucher_detail_document_debit_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][document_debit]" value="<?php echo round_decimal($detail['document_debit'],2); ?>" /></td>
                    <td><input onchange="calculateTotal();" type="text" class="form-control fDecimal " id="journal_voucher_detail_document_credit_<?php echo $grid_row; ?>" name="journal_voucher_details[<?php echo $grid_row; ?>][document_credit]" value="<?php echo round_decimal($detail['document_credit'],2); ?>" /></td>
                    <td>
                        <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
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
<div class="row" style="margin-top:10px;">
    <div class="col-sm-offset-8 col-md-2">
        <div class="form-group">
            <label><?php echo $lang['debit']; ?></label>
            <input type="text" id="document_debit" name="document_debit" value="<?php echo round_decimal($document_debit,2); ?>" class="form-control text-right" readonly="readonly" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label><?php echo $lang['credit']; ?></label>
            <input type="text" id="document_credit" name="document_credit" value="<?php echo round_decimal($document_credit,2); ?>" class="form-control text-right" readonly="readonly" />
        </div>
    </div>
</div>
<div class="row hide">
    <div class="col-sm-offset-8 col-md-2">
        <div class="form-group">
            <input type="hidden" id="base_currency_id" name="base_currency_id"  value="<?php echo $base_currency_id; ?>" />
            <label><?php echo $lang['document_currency']; ?></label>
            <select class="form-control" id="document_currency_id" name="document_currency_id">
                <option value="">&nbsp;</option>
                <?php foreach($currencies as $currency): ?>
                <option value="<?php echo $currency['currency_id']; ?>" <?php echo ($document_currency_id == $currency['currency_id']?'selected="selected"':''); ?>><?php echo $currency['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label><?php echo $lang['conversion_rate']; ?></label>
            <input class="form-control fDecimal" id="conversion_rate" type="text" name="conversion_rate" value="<?php echo $conversion_rate; ?>" />
        </div>
    </div>
</div>
<div class="row hide">
    <div class="offset-sm-8 col-sm-2">
        <div class="form-group">
            <label><?php echo $lang['base_debit']; ?></label>
            <input class="form-control fDecimal" id="base_debit" type="text" name="base_debit" value="<?php echo $base_debit; ?>" readonly/>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label><?php echo $lang['base_credit']; ?></label>
            <input class="form-control fDecimal" id="base_credit" type="text" name="base_credit" value="<?php echo $base_credit; ?>" readonly />
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
<script type="text/javascript" src="./admin/view/js/gl/journal_voucher.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>

<script src="./assets/jasny-bootstrap.js" type="text/javascript"></script>

<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $UrlGetDocumentLedger = '<?php echo $href_get_document_ledger; ?>';
    var $UrlGetPendingDocument = '<?php echo $href_get_pending_document; ?>';
    var $UrlGetPartnerAccount = '<?php echo $href_get_partner_account; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $coas = <?php echo json_encode($coas) ?>;
    var $partner_types = <?php echo json_encode($partner_types) ?>;
    var $partners = <?php echo json_encode($partners) ?>;
    var $documents = [];
    var $partner_coas = [];

    var $projects = <?= json_encode($projects) ?>;
    var $job_orders = <?= json_encode($job_orders) ?>;
    var $sub_project_id = '<?php echo $sub_project_id; ?>';
    var $UrlGetSubProjects = '<?= $href_get_sub_projects; ?>';
    var $UrlGetJobOrders = '<?= $href_get_job_orders; ?>';

    <?php if($this->request->get['journal_voucher_id']): ?>
    <?php endif; ?>
</script>
<?php echo $page_footer; ?>
<?php echo $footer; ?>

</body>
</html>