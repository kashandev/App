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
                                                <label><?php echo $lang['document_date']; ?></label>
                                                <input  type="text" class="dtpDate form-control" name="document_date" id="document_date" value="<?php echo $document_date; ?>" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['manual_ref_no']; ?></label>
                                                <input type="text" class="form-control" name="manual_ref_no" id="manual_ref_no" value="<?php echo $manual_ref_no; ?>" autocomplete="off" />
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
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['remarks']; ?></label>
                                                <input type="text" name="remarks" value="<?php echo $remarks; ?>" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table id="tblDebitInvoiceDetail" class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr align="center" data-row_id="H">
                                                        <td style="width: 5%;"><a class="btnAddGrid btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                                        <td><?php echo $lang['account']; ?></td>
                                                        <td><?php echo $lang['remarks']; ?></td>
                                                        <td><?php echo $lang['amount']; ?></td>
                                                        <td style="width: 5%;"><a class="btnAddGrid btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $grid_row = 0;?>
                                                    <?php foreach($credit_invoice_details as $detail): ?>
                                                    <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                                        <td>
                                                            <a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Remove" onclick="removeRow(this);"><i class="fa fa-times"></i></a>
                                                            <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" id="credit_invoice_detail_coa_id_<?php echo $grid_row; ?>" name="credit_invoice_details[<?php echo $grid_row; ?>][coa_id]" >
                                                                <?php foreach($coas as $coa): ?>
                                                                <option value="<?php echo $coa['coa_level3_id']; ?>" <?php echo ($coa['coa_level3_id']==$detail['coa_id']?'selected="true"':''); ?> ><?php echo $coa['level3_display_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="credit_invoice_details[<?php echo $grid_row; ?>][remarks]" id="credit_invoice_detail_remarks_<?php echo $grid_row; ?>" value="<?php echo $detail[remarks]; ?>" />
                                                        </td>
                                                        <td>
                                                            <input onchange="calculateTotal();" type="text" class="form-control" name="credit_invoice_details[<?php echo $grid_row; ?>][amount]" id="credit_invoice_detail_amount_<?php echo $grid_row; ?>" value="<?php echo $detail[amount]; ?>" />
                                                        </td>
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
                                    <div class="row">
                                        <div class="col-sm-offset-9 col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['net_amount']; ?></label>
                                                <input type="text" id="net_amount" name="net_amount" value="<?php echo $net_amount; ?>" class="form-control text-right" readonly="readonly" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row <?php echo (count($currencies)==1?'hide':''); ?>">
                                        <div class="col-sm-offset-9 col-sm-3">
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
                                    </div>
                                    <div class="row <?php echo (count($currencies)==1?'hide':''); ?>">
                                        <div class="col-sm-offset-9 col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['conversion_rate']; ?></label>
                                                <input class="form-control fDecimal" id="conversion_rate" type="text" name="conversion_rate" value="<?php echo $conversion_rate; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row <?php echo (count($currencies)==1?'hide':''); ?>">
                                        <div class="col-sm-offset-9 col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['base_amount']; ?></label>
                                                <input class="form-control fDecimal" id="base_amount" type="text" name="base_amount" value="<?php echo $base_amount; ?>" readonly/>
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
<script type="text/javascript" src="./admin/view/js/gl/credit_invoice.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>

<script src="./assets/jasny-bootstrap.js" type="text/javascript"></script>

<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $partner_id = '<?php echo $partner_id; ?>';
    var $sub_project_id = '<?php echo $sub_project_id; ?>';
    var $UrlGetPartner = '<?php echo $href_get_partner; ?>';
    var $UrlGetDocuments = '<?php echo $href_get_documents; ?>';
    var $UrlGetDocumentData = '<?php echo $href_get_document_data; ?>';
    var $UrlGetDocumentLedger = '<?php echo $href_get_document_ledger; ?>';
    var $UrlGetSubProject = '<?php echo $href_get_sub_project; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $coas = <?php echo json_encode($coas) ?>;
    var $partners = [];
    var $documents = [];
    var $partner_coas = [];
    <?php if($this->request->get['bank_payment_id']): ?>
    $(document).ready(function() {
        $('#partner_type_id').trigger('change');
        $('#project_id').trigger('change');
    });
    <?php endif; ?>
</script>
<?php echo $page_footer; ?>
<?php echo $footer; ?>

</body>
</html>