<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
<?php echo $column_left; ?>
<!-- Right side column. Contains the navbar and content of the page -->
<!--page level css -->

<link rel="stylesheet" type="text/css" href=./assets/datatables/css/buttons.bootstrap.css" />
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
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php echo $lang['remarks']; ?></label>
                            <input type="text" class="form-control" name="remarks" value="<?php echo $remarks; ?>" />
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="tblOpeningAccountDetail" class="table table-striped table-bordered" style="width: 2500px !important; max-width: 2500px !important;">
                                <thead>
                                <tr align="center" data-row_id="H">
                                    <td style="width: 2.5%;"><a class="btnAddGrid btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                    <td style="width: 5%;"><?php echo $lang['partner_type']; ?></td>
                                    <td style="width: 15%;"><?php echo $lang['partner_name']; ?></td>
                                    <td style="width: 5%;"><?php echo $lang['project']; ?></td>
                                    <td style="width: 10%;"><?php echo $lang['sub_project']; ?></td>
                                    <td style="width: 8%;"><?php echo $lang['document_type']; ?></td>
                                    <td style="width: 7%;"><?php echo $lang['document_no']; ?></td>
                                    <td style="width: 5%;"><?php echo $lang['document_date']; ?></td>
                                    <td style="width: 7%;"><?php echo $lang['document_amount']; ?></td>
                                    <td style="width: 10%;"><?php echo $lang['coa']; ?></td>
                                    <td style="width: 7%;"><?php echo $lang['debit']; ?></td>
                                    <td style="width: 7%;"><?php echo $lang['credit']; ?></td>
                                    <td style="width: 2.5%;"><a class="btnAddGrid btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                </tr>
                                </thead>
                                <?php $grid_row = 0; ?>
                                <tbody>
                                <?php foreach($opening_account_details as $detail): ?>
                                <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Remove" onclick="removeRow(this);"><i class="fa fa-times"></i></a>
                                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                    <td>
                                        <select onchange="getPartners(<?php echo $grid_row; ?>);" class="form-control" id="opening_account_detail_partner_type_id_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][partner_type_id]">
                                            <option value="">&nbsp;</option>
                                            <?php foreach($partner_types as $partner_type): ?>
                                            <option value="<?php echo $partner_type['partner_type_id']; ?>" <?php echo ($partner_type['partner_type_id']==$detail['partner_type_id']?'selected="true"':''); ?>> <?php echo $partner_type['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>


                                    <td>
                                        <select class="form-control" id="opening_account_detail_partner_id_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][partner_id]">
                                            <option value="0">&nbsp;</option>
                                            <?php foreach($partners as $partner): ?>
                                            <?php if($partner['partner_type_id']==$detail['partner_type_id']): ?>
                                            <option value="<?php echo $partner['partner_id']; ?>" <?php echo ($partner['partner_id']==$detail['partner_id']?'selected="true"':''); ?>><?php echo $partner['name']; ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>


                                    <td>
                                        <select onchange="getSubProjects(<?php echo $grid_row; ?>);" class="form-control" id="opening_account_detail_project_id_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][project_id]">
                                            <option value="0">&nbsp;</option>
                                            <?php foreach($projects as $project): ?>
                                            <option value="<?php echo $project['project_id']; ?>" <?php echo ($project['project_id']==$detail['project_id']?'selected="true"':''); ?>><?php echo $project['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control" id="opening_account_detail_sub_project_id_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][sub_project_id]">
                                            <option value="0">&nbsp;</option>
                                            <?php foreach($sub_projects as $sub_project): ?>
                                            <?php if($sub_project['project_id'] == $detail['project_id']): ?>
                                            <option value="<?php echo $sub_project['sub_project_id']; ?>" <?php echo ($sub_project['sub_project_id']==$detail['sub_project_id']?'selected="true"':''); ?>><?php echo $sub_project['name']; ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control" id="opening_account_detail_ref_document_type_id_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][ref_document_type_id]">
                                            <option value="0">&nbsp;</option>
                                            <option value="1" <?php echo ($detail['ref_document_type_id']==1?'selected="true"':''); ?>><?php echo $lang['purchase_invoice']; ?></option>
                                            <option value="2" <?php echo ($detail['ref_document_type_id']==2?'selected="true"':''); ?>><?php echo $lang['sale_invoice']; ?></option>
                                            <option value="11" <?php echo ($detail['ref_document_type_id']==11?'selected="true"':''); ?>><?php echo $lang['debit_invoice']; ?></option>
                                            <option value="24" <?php echo ($detail['ref_document_type_id']==24?'selected="true"':''); ?>><?php echo $lang['credit_invoice']; ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="opening_account_detail_ref_document_identity_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][ref_document_identity]" value="<?php echo $detail['ref_document_identity']; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control dtpDate" id="opening_account_detail_ref_document_date_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][ref_document_date]" value="<?php echo $detail['ref_document_date']; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control fPDecimal" id="opening_account_detail_ref_document_amount_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][ref_document_amount]" value="<?php echo $detail['ref_document_amount']; ?>" />
                                    </td>
                                    <td>
                                        <select class="form-control" id="opening_account_detail_coa_level3_id_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][coa_level3_id]">
                                            <option value="0" >&nbsp;</option>
                                            <?php foreach($coas as $coa): ?>
                                            <option value="<?php echo $coa['coa_level3_id']; ?>" <?php echo ($coa['coa_level3_id'] == $detail['coa_level3_id']?'selected="true"':''); ?>><?php echo $coa['level3_display_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><input onchange="calculateTotal(this);" type="text" class="form-control fDecimal" id="opening_account_detail_document_debit_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][document_debit]" value="<?php echo $detail['document_debit']; ?>" /></td>
                                    <td><input onchange="calculateTotal(this);" type="text" class="form-control fDecimal " id="opening_account_detail_document_credit_<?php echo $grid_row; ?>" name="opening_account_details[<?php echo $grid_row; ?>][document_credit]" value="<?php echo $detail['document_credit']; ?>" /></td>
                                    <td>
                                        <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Remove" onclick="removeRow(this);"><i class="fa fa-times"></i></a>
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
                            <input type="text" id="document_debit" name="document_debit" value="<?php echo $document_debit; ?>" class="form-control" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo $lang['credit']; ?></label>
                            <input type="text" id="document_credit" name="document_credit" value="<?php echo $document_credit; ?>" class="form-control" readonly="readonly" />
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
<script type="text/javascript" src="./admin/view/js/gl/opening_account.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>


<script src="./assets/jasny-bootstrap.js" type="text/javascript"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>

<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);

    var $UrlGetPartner = '<?php echo $href_get_partner; ?>';
    var $UrlGetDocumentLedger = '<?php echo $href_get_document_ledger; ?>';
    //var $coas123 = '<?php echo $coas123; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $coas123 = <?php echo json_encode($coas123) ?>;
    var $partner_types = <?php echo json_encode($partner_types) ?>;
    var $partners = <?php echo json_encode($partners) ?>;
    var $projects  = <?php echo json_encode($projects) ?>;
    var $sub_projects = <?php echo json_encode($sub_projects) ?>;

    <?php if($this->request->get['opening_account_id']): ?>
    $(document).ready(function() {
        $('#partner_type_id').trigger('change');
        $('project_id').trigger('change');
    });
    <?php endif; ?>
</script>
<?php echo $page_footer; ?>
<?php echo $footer; ?>
</body>
</html>