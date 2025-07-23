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
                            <!-- <a class="btn btn-info" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');"> -->
                            <a class="btn btn-info">
                                <i class="fa fa-thumbs-up"></i>
                                &nbsp;<?php echo $lang['post']; ?>
                            </a>
                            <?php endif; ?>
                            <!--
                <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa-balance-scale"></i>
                    &nbsp;<?php echo $lang['ledger']; ?>
                </button>
                -->

                            <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                                <i class="fa fa-print"></i>
                                &nbsp;<?php echo $lang['print_job']; ?>
                            </a>

                            <!-- 
              <a class="btn btn-info" target="_blank" href="<?php echo $action_print_service_center_paper; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print_service_center_paper']; ?>
                </a> -->

                            <!-- <a class="btn btn-info" target="_blank" href="<?php echo $action_print_header_wise; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print_with_header']; ?>
                </a> -->
                            <!-- <a class="btn btn-info" target="_blank" href="<?php echo $action_get_excel_figures; ?>">
                    <i class="fa fa-download"></i>
                    &nbsp;Excel
                </a> -->

                            <?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                                <i class="fa fa-undo"></i>
                                &nbsp;<?php echo $lang['cancel']; ?>
                            </a>
                            <button type="button" class="btn btn-primary btnsave" href="javascript:void(0);"
                                onclick="Save();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
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
                                    <button class="close" aria-hidden="true" data-dismiss="alert"
                                        type="button">x</button>
                                    <?php echo $error_warning; ?>
                                </div>
                                <?php } ?>
                                <?php  if ($success) { ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button class="close" aria-hidden="true" data-dismiss="alert"
                                        type="button">x</button>
                                    <?php echo $success; ?>
                                </div>
                                <?php  } ?>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"
                                    id="form">
                                    <input type="hidden" value="<?php echo $document_type_id; ?>"
                                        name="document_type_id" id="document_type_id" />
                                    <input type="hidden" value="<?php echo $quotation_id; ?>" name="document_id"
                                        id="document_id" />
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['document_no']; ?></label>
                                                <input class="form-control" type="text" name="document_identity"
                                                    readonly="readonly" value="<?php echo $document_identity; ?>"
                                                    placeholder="Auto" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><span
                                                        class="required">*</span>&nbsp;<?php echo $lang['document_date']; ?></label>
                                                <input class="form-control dtpDate" type="text" name="document_date"
                                                    value="<?php echo $document_date; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['partner_name']; ?></label>
                                                <input class="form-control required" type="text" name="customer_name"
                                                    value="<?php echo $customer_name; ?>" />
                                                <label for="customer_name" class="error" style="display: none;"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hide">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['partner_type']; ?></label>
                                                <select class="form-control" id="partner_type_id"
                                                    name="partner_type_id">
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($partner_types as $partner_type): ?>
                                                    <option value="<?php echo $partner_type['partner_type_id']; ?>"
                                                        <?php echo ($partner_type_id == $partner_type['partner_type_id']?'selected="true"':''); ?>>
                                                        <?php echo $partner_type['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['base_currency']; ?></label>
                                                <input type="hidden" id="base_currency_id" name="base_currency_id"
                                                    value="<?php echo $base_currency_id; ?>" />
                                                <input type="text" class="form-control" id="base_currency"
                                                    name="base_currency" readonly="true"
                                                    value="<?php echo $base_currency; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['document_currency']; ?></label>
                                                <select class="form-control" id="document_currency_id"
                                                    name="document_currency_id">
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($currencys as $currency): ?>
                                                    <option value="<?php echo $currency['currency_id']; ?>"
                                                        <?php echo ($document_currency_id == $currency['currency_id']?'selected="selected"':''); ?>>
                                                        <?php echo $currency['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['conversion_rate']; ?></label>
                                                <input class="form-control fDecimal" id="conversion_rate" type="text"
                                                    name="conversion_rate" value="<?php echo $conversion_rate; ?>"
                                                    onchage="calcNetAmount()" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['customer_contact']; ?></label>
                                                <input class="form-control" type="text" id="customer_contact"
                                                    name="customer_contact" value="<?php echo $customer_contact; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['customer_address']; ?></label>
                                                <input class="form-control" type="text" id="customer_address"
                                                    name="customer_address" value="<?php echo $customer_address; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $lang['customer_email']; ?></label>
                                                <input class="form-control" type="text" name="customer_email"
                                                    value="<?php echo $customer_email; ?>" />
                                                <label for="customer_email" class="error"
                                                    style="display: none;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['repair_status']; ?></label>

                                                <select class="form-control" id="repair_status" name="repair_status">
                                                    <option value="P"
                                                        <?php echo $repair_status == 'P' ? 'selected' : ''; ?>>P-Pending
                                                    </option>
                                                    <option value="PFP"
                                                        <?php echo $repair_status == 'PFP' ? 'selected' : ''; ?>>
                                                        PFP-Pending for Parts</option>
                                                    <option value="UCS"
                                                        <?php echo $repair_status == 'UCS' ? 'selected' : ''; ?>>
                                                        UCS-Uncollected Sets</option>
                                                    <option value="OTP"
                                                        <?php echo $repair_status == 'OTP' ? 'selected' : ''; ?>>
                                                        OTP-Other Pending</option>
                                                    <option value="CLD"
                                                        <?php echo $repair_status == 'CLD' ? 'selected' : ''; ?>>
                                                        CLD-Incollected cash</option>
                                                    <option value="EST"
                                                        <?php echo $repair_status == 'EST' ? 'selected' : ''; ?>>
                                                        EST-Estimate</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['product_name']; ?></label>
                                                <select onchange="getserviceCharges(this)"
                                                    class="form-control product-id required" id="product_id"
                                                    name="product_id">
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($products as $product): ?>
                                                    <option value="<?php echo $product['product_id']; ?>"
                                                        <?php echo ($product_id == $product['product_id']?'selected="true"':''); ?>>
                                                        <?php echo $product['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="product_id" class="error" style="display: none;"></label>

                                            </div>

                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['model']; ?></label>
                                                <input class="form-control" type="text" id="product_model"
                                                    name="product_model" value="<?php echo $product_model; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['product_serial_no']; ?></label>
                                                <input class="form-control" type="text" name="product_serial_no"
                                                    id="product_serial_no" value="<?php echo $product_serial_no; ?>" />
                                                <label for="product_serial_no" class="error"
                                                    style="display: none;"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['job_order_type']; ?></label>
                                                <select class="form-control" id="job_order_type" name="job_order_type">
                                                    <option value=""
                                                        <?php echo ($job_order_type == '') ? 'selected' : ''; ?>>&nbsp;
                                                    </option>
                                                    <option value="normal"
                                                        <?php echo ($job_order_type == 'normal') ? 'selected' : ''; ?>>
                                                        Normal</option>
                                                    <option value="warranty"
                                                        <?php echo ($job_order_type == 'warranty') ? 'selected' : ''; ?>>
                                                        Warranty</option>
                                                    <option value="no_warranty"
                                                        <?php echo ($job_order_type == 'no_warranty') ? 'selected' : ''; ?>>
                                                        No Warranty</option>
                                                    <option value="home"
                                                        <?php echo ($job_order_type == 'home') ? 'selected' : ''; ?>>
                                                        Home</option>
                                                    <option value="repeat"
                                                        <?php echo ($job_order_type == 'repeat') ? 'selected' : ''; ?>>
                                                        Repeat</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['warranty_status']; ?></label>
                                                <select class="form-control" id="warranty_status"
                                                    name="warranty_status">
                                                    <?php if($warranty_status=="Y")
                                        {?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="Y" selected>Y-Yes</option>
                                                    <option value="N">N-No</option>
                                                    <?php }
                                          else if($warranty_status=="N")
                                        {?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="Y">Y-Yes</option>
                                                    <option value="N" selected>N-No</option>
                                                    <?php }
                                       
                                        else
                                        { ?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="Y">Y-Yes</option>
                                                    <option value="N">N-No</option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['warranty_type']; ?></label>
                                                <select class="form-control" id="warranty_type" name="warranty_type">

                                                    <?php if($warranty_type=="LOW")
                                        {?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="LOW" selected>LOW-Local Warranty</option>
                                                    <option value="CRW">CRW-Care Warranty</option>
                                                    <option value="ITW">ITW-International Warranty</option>
                                                    <option value="OOW">OOW-Out of Warranty</option>
                                                    <?php }
                                          else if($warranty_type=="CRW")
                                        {?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="LOW">LOW-Local Warranty</option>
                                                    <option value="CRW" selected>CRW-Care Warranty</option>
                                                    <option value="ITW">ITW-International Warranty</option>
                                                    <option value="OOW">OOW-Out of Warranty</option>
                                                    <?php }
                                        else if($warranty_type=="ITW")
                                        {?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="LOW">LOW-Local Warranty</option>
                                                    <option value="CRW">CRW-Care Warranty</option>
                                                    <option value="ITW" selected>ITW-International Warranty</option>
                                                    <option value="OOW">OOW-Out of Warranty</option>
                                                    <?php } 
                                        else if($warranty_type=="OOW")
                                        {?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="LOW">LOW-Local Warranty</option>
                                                    <option value="CRW">CRW-Care Warranty</option>
                                                    <option value="ITW">ITW-International Warranty</option>
                                                    <option value="OOW" selected>OOW-Out of Warranty</option>
                                                    <?php }
                                        else
                                        { ?>
                                                    <option value="">&nbsp;</option>
                                                    <option value="LOW">LOW-Local Warranty</option>
                                                    <option value="CRW">CRW-Care Warranty</option>
                                                    <option value="ITW">ITW-International Warranty</option>
                                                    <option value="OOW">OOW-Out of Warranty</option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['warranty_card_no']; ?></label>
                                                <input class="form-control" type="text" name="warranty_card_no"
                                                    id="warranty_card_no" value="<?php echo $warranty_card_no; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['service_charges']; ?></label>
                                                <input class="form-control fDecimal" type="text" name="service_charges"
                                                    id="service_charges" value="<?php echo $service_charges; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $lang['purchase_date']; ?></label>
                                                <input class="form-control dtpDate" type="text" name="purchase_date"
                                                    id="purchase_date" value="<?php echo $purchase_date; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label><?php echo $lang['repair_recieve_date']; ?></label>
                                                <input class="form-control dtpDate" type="text"
                                                    name="repair_receive_date" id="repair_receive_date"
                                                    value="<?php echo $repair_receive_date; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label><?php echo $lang['repair_complete_date']; ?></label>
                                                <input class="form-control dtpDate" type="text"
                                                    name="repair_complete_date" id="repair_complete_date"
                                                    value="<?php echo $repair_complete_date; ?>" />
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label><?php echo $lang['delivery_date']; ?></label>
                                                <input class="form-control dtpDate" type="text" name="delivery_date"
                                                    id="delivery_date" value="<?php echo $delivery_date; ?>" />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><span
                                                        class="required">*</span>&nbsp;<?php echo $lang['fault_description']; ?></label>
                                                <textarea rows="4" cols="50" class="form-control" type="text"
                                                    id="fault_description"
                                                    name="fault_description"><?php echo $fault_description ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><span
                                                        class="required">*</span>&nbsp;<?php echo $lang['symptom']; ?></label>
                                                <textarea rows="4" cols="50" class="form-control" type="text"
                                                    id="symptom" name="symptom"><?php echo $symptom ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span
                                                        class="required">*</span>&nbsp;<?php echo $lang['repair_remarks']; ?></label>
                                                <textarea rows="4" cols="50" class="form-control" type="text"
                                                    id="repair_remarks"
                                                    name="repair_remarks"><?php echo $repair_remarks ?></textarea>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div class="box-footer">
                                <div class="pull-right">
                                    <?php if(isset($isEdit) && $isEdit==1): ?>
                                    <?php if($is_post == 0): ?>
                                    <!-- <a class="btn btn-info" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');"> -->
                                    <a class="btn btn-info">
                                        <i class="fa fa-thumbs-up"></i>
                                        &nbsp;<?php echo $lang['post']; ?>
                                    </a>
                                    <?php endif; ?>
                                    <!--
                        <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                            <i class="fa fa-balance-scale"></i>
                            &nbsp;<?php echo $lang['ledger']; ?>
                        </button>
                        -->
                                    <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                                        <i class="fa fa-print"></i>
                                        &nbsp;<?php echo $lang['print_job']; ?>
                                    </a>

                                    <!--                   <a class="btn btn-info" target="_blank" href="<?php echo $action_print_service_center_paper; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print_service_center_paper']; ?>
                  </a> -->

                                    <?php endif; ?>
                                    <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                                        <i class="fa fa-undo"></i>
                                        &nbsp;<?php echo $lang['cancel']; ?>
                                    </a>
                                    <button type="button" class="btn btn-primary btnsave" href="javascript:void(0);"
                                        onclick="Save();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
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
        <script type="text/javascript" src="../admin/view/js/inventory/job_order.js"></script>
        <script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
        <script>
        jQuery('#form').validate(<?php echo $strValidation; ?>);
        var $restrict_out_of_stock = '<?php echo $restrict_out_of_stock; ?>';
        var $lang = <?php echo json_encode($lang) ?>;
        var $partner_id = '<?php echo $partner_id; ?>';
        var $product_id = '<?php echo $product_id; ?>';
        var $grid_row = '<?php echo $grid_row; ?>';
        var $products = <?php echo json_encode($products) ?>;
        var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
        var $UrlGetServiceCharges = '<?php echo $href_get_service_charges; ?>';
        var $units = <?php echo json_encode($units) ?>;
        var $isEdit = '<?php echo $isEdit ?>';
        //    var $URLGetExcel = '<?php echo $href_get_excel_figures; ?>';

        function formatRepo(repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-repository clearfix'>";
            if (repo.image_url) {
                markup += "<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
            }
            markup += "<div class='select2-result-repository__meta'>";
            markup += "  <div class='select2-result-repository__title'>" + repo.name + "</div>";

            if (repo.description) {
                markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
            }

            markup += "<div class='select2-result-repository__statistics'>" +
                "   <div class='help-block'>" + repo.length + " X " + repo.width + " X " + repo.thickness + "</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo) {
            return repo.name || repo.text;
        }

        <?php if($this->request->get['quotation_id']): ?>
        $(document).ready(function() {
            $('#partner_type_id').trigger('change');
            $('select.product').select2({
                width: '100%',
                ajax: {
                    url: $UrlGetProductJSON,
                    dataType: 'json',
                    type: 'post',
                    mimeType: "multipart/form-data",
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 2,
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
            });

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