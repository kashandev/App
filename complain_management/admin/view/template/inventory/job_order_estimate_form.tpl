

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
                
                <a class="btn btn-info" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp; Product Issuance
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
                    &nbsp;<?php echo $lang['print']; ?>
                </a>
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
                <button type="button" class="btn btn-primary btnsave" href="javascript:void(0);" onclick="Save();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
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
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                        <?php echo $error_warning; ?>
                    </div>
                    <?php } ?>
                    <?php  if ($success) { ?>
                    <div class="alert alert-success alert-dismissable">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                        <?php echo $success; ?>
                    </div>
                    <?php  } ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                        <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
                        <input type="hidden" value="<?php echo $quotation_id; ?>" name="document_id" id="document_id" />
                        <input type="hidden" name="job_order_no" id="job_order_no">
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
                                    <input class="form-control dtpDate required" type="text" name="document_date" value="<?php echo $document_date; ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['ref_document_no']; ?></label>
                                    <?php if(isset($isEdit) && $isEdit==1): ?>
                                        <input readonly class="form-control" type="text" name="ref_document_identity" value="<?php echo $ref_document_identity; ?>" />
                                        <input readonly class="form-control" type="hidden" name="job_order_id" value="<?php echo $job_order_id; ?>" />

                                    <?php else: ?>
                                        <select onchange="getPartyByRefDoc(this)"  class="form-control required" id="job_order_id" name="job_order_id">
                                        <option value="">&nbsp;</option>
                                        <?php foreach($job_order as $job_orders): ?>
                                        <option value="<?php echo $job_orders['job_order_id']; ?>" <?php echo ($job_order_id == $job_orders['job_order_id']?'selected="true"':''); ?>><?php echo $job_orders['document_identity']; ?></option>
                                        <?php endforeach; ?>
                                    </select>    
                                    <label for="job_order_id" class="error" style="display: none;"></label>
    
                                    <?php endif; ?>                       
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
                                    <label><?php echo $lang['partner_name']; ?></label>
                                    <input class="form-control" readonly type="text" id="customer_name" name="customer_name" value="<?php echo $customer_name; ?>" />
                                     <input class="form-control" type="hidden" id="customer_contact" name="customer_contact"/>
                                </div>
                            </div>
                           
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['product_name']; ?></label>
                                    
                                    <select class="form-control required" disabled id="product_id" name="product_id">
                                         <option value="">&nbsp;</option>
                                        <?php foreach($products as $product): ?>
                                            <option value="<?php echo $product['product_id']; ?>" <?php echo ($product_id == $product['product_id']?'selected="true"':''); ?>><?php echo $product['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['model']; ?></label>
                                    <input readonly class="form-control" type="text" id="model" name="model" value="<?php echo $model; ?>" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['product_serial_no']; ?></label>
                                    <input readonly class="form-control" type="text" name="product_serial_no" id="product_serial_no" value="<?php echo $product_serial_no; ?>" />
                                    <label for="product_serial_no" class="error" style="display: none;"></label>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['fault_description']; ?></label>
                                    <textarea readonly rows="4" cols="50" class="form-control" type="text" id="fault_description" name="fault_description"><?php echo $fault_description ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['symptom']; ?></label>
                                    <textarea readonly rows="4" cols="50" class="form-control" type="text" id="symptom" name="symptom"><?php echo $symptom ?></textarea>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="table-responsive form-group">
                                <table id="tblParts" class="table table-striped table-bordered" style="max-width: 2000px !important;">
                                    <thead>
                                    <tr align="center">
                                        <td><a id="btnAddGridParts" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                        <td><?php echo $lang['part_code']; ?></td>
                                        <td><?php echo $lang['part_name']; ?></td>
                                        <td><?php echo $lang['quantity']; ?></td>
                                        <td><?php echo $lang['rate']; ?></td>
                                        <td><?php echo $lang['amount']; ?></td>

                                        <td><a id="btnAddGridParts" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                    </tr>
                                    </thead>
                                    <tbody >
                                    <?php $grid_row = 0; ?>
                                    <?php foreach($job_order_estimate_part as $parts): ?>
                                    <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                        <td>
                                            <a onclick="removePartsRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <a title="Add" class="btn btn-xs btn-primary btnAddGridParts" id="btnAddGridParts" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="part_details[<?php echo $grid_row; ?>][product_code]" id="part_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo $parts['product_code']; ?>" />
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="part_details[<?php echo $grid_row; ?>][part_name]" id="part_detail_part_name_<?php echo $grid_row; ?>" value="<?php echo $parts['part_name']; ?>">
                                                <input type="hidden" class="form-control" name="part_details[<?php echo $grid_row; ?>][product_type]" id="part_detail_product_type_<?php echo $grid_row; ?>" value="part" />
                                            </div>
                                        </td>
                                        <td>
                                            <input onchange="calculatPartTotalAmount(this)" type="text" class="form-control fDecimal" name="part_details[<?php echo $grid_row; ?>][quantity]" id="part_detail_qty_<?php echo $grid_row; ?>" value="<?php echo $parts['quantity']; ?>" />
                                        </td>
                                        <td>
                                            <input onchange="calculatPartTotalAmount(this)" type="text" class="form-control fDecimal" name="part_details[<?php echo $grid_row; ?>][rate]" id="part_detail_rate_<?php echo $grid_row; ?>" value="<?php echo $parts['rate']; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="part_details[<?php echo $grid_row; ?>][amount]" id="part_detail_amount_<?php echo $grid_row; ?>" value="<?php echo $parts['amount']; ?>" readonly />
                                        </td>
                                        <td>
                                            <a onclick="removePartsRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGridParts" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
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

                            <div class="col-lg-6">
                                <div class="table-responsive form-group">
                                <table id="tblServices" class="table table-striped table-bordered" style="max-width: 2000px !important;">
                                    <thead>
                                    <tr align="center">
                                        <td><a id="btnAddGridServices" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                        <td><?php echo $lang['service_code']; ?></td>
                                        <td><?php echo $lang['service_name']; ?></td>
                                        <td><?php echo $lang['rate']; ?></td>
                                        <td><a id="btnAddGridServices" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>
                                    </tr>
                                    </thead>
                                    <tbody >
                                    <?php $service_grid_row = 0; ?>
                                    <?php foreach($job_order_estimate_service as $service): ?>
                                    <tr id="service_grid_row<?php echo $service_grid_row; ?>" data-row_id="<?php echo $service_grid_row; ?>">
                                        <td>
                                            <a onclick="removeServiceRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <a title="Add" class="btn btn-xs btn-primary btnAddGridServices" id="btnAddGridServices" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        </td>
                                        <td>
                                            <input onchange="getProductByCode(this);" type="text" class="form-control" name="service_details[<?php echo $service_grid_row; ?>][product_code]" id="service_detail_product_code_<?php echo $service_grid_row; ?>" value="<?php echo $service['product_code']; ?>" />
                                            <input type="hidden" class="form-control" name="service_details[<?php echo $service_grid_row; ?>][product_type]" id="part_detail_product_type_<?php echo $grid_row; ?>" value="service" />

                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <select onchange="getProductById(this);" class="form-control select2 product code1" id="service_detail_product_id_<?php echo $service_grid_row; ?>" name="service_details[<?php echo $service_grid_row; ?>][product_id]" >
                                                    <option value="">&nbsp;</option>
                                                    <?php foreach($products as $product): ?>
                                                    <option value="<?php echo $product['product_id']; ?>" <?php echo ($product['product_id']==$service['product_id']?'selected="true"':'');?>><?php echo $product['name']; ?></option>
                                                    <?php endforeach; ?>
                                                    
                                                </select>
                                                <!-- <span class="input-group-btn ">
                                                    <button class="btn btn-default btn-flat QSearchProduct" id="QSearchProduct" type="button" data-element="service_detail_product_id_<?php echo $service_grid_row; ?>" data-field="product_id">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span> -->
                                            </div>
                                        </td>
                                        <td>
                                            <input  type="text" class="form-control" name="service_details[<?php echo $service_grid_row; ?>][amount]" id="service_detail_amount_<?php echo $service_grid_row; ?>" value="<?php echo $service['amount']; ?>" />
                                        </td>
                                       
                                        <td>
                                            <a onclick="removeServiceRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGridServices" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                    <?php $service_grid_row++; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-offset-4 col-sm-2">
                                <div class="form-group">
                                    <label><?php echo $lang['total_quantity']; ?></label>
                                    <input type="text" id="total_quantity" name="total_quantity" value="<?php echo $total_quantity; ?>" class="form-control fDecimal" readonly="true" />
                                </div>
                            </div>
                            <div class=" col-sm-2">
                                <div class="form-group">
                                    <label><?php echo $lang['total_amount']; ?></label>
                                    <input type="text" id="item_amount" name="item_amount" value="<?php echo $item_amount; ?>" class="form-control fDecimal" readonly="true" />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label><?php echo $lang['total_tax']; ?></label>
                                    <input class="form-control fDecimal" type="text" id="item_tax" name="item_tax" value="<?php echo $item_tax; ?>" readonly="readonly" />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label><?php echo $lang['total_net']; ?></label>
                                    <input class="form-control fDecimal" type="text" id="item_total" name="item_total" value="<?php echo $item_total; ?>" readonly="readonly" />
                                </div>
                            </div>
                        </div> -->
                    </form>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <?php if(isset($isEdit) && $isEdit==1): ?>
                        <?php if($is_post == 0): ?>
                        <!-- <a class="btn btn-info" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');"> -->
                        <a class="btn btn-info" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');"> 
   
                        <i class="fa fa-thumbs-up"></i>
                            &nbsp;Product Issuance
                        </a>
                        <?php endif; ?>
                        <!--
                        <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                            <i class="fa fa-balance-scale"></i>
                            &nbsp;<?php echo $lang['ledger']; ?>
                        </button>
                        -->
                        <!-- <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>"> -->
                      <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                        <i class="fa fa-print"></i>
                       &nbsp;<?php echo $lang['print']; ?>
                      </a>
                        <?php endif; ?>
                        <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                            <i class="fa fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </a>
                        <button type="button" class="btn btn-primary btnsave" href="javascript:void(0);" onclick="Save();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
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
<script type="text/javascript" src="../admin/view/js/inventory/job_order_estimate.js"></script>
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $restrict_out_of_stock = '<?php echo $restrict_out_of_stock; ?>';
    var $lang = <?php echo json_encode($lang) ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $service_grid_row = '<?php echo $service_grid_row; ?>';
    var UrlGetProductById = '<?php echo $href_get_product_By_ID; ?>';
    var UrlGetProductByCode = '<?php echo $href_get_product_By_Code; ?>';

    var $products = <?php echo json_encode($products) ?>;
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $units = <?php echo json_encode($units) ?>;
    var $UrlGetRefDocDetail = '<?php echo $href_get_ref_doc_detail; ?>';

    
//    var $URLGetExcel = '<?php echo $href_get_excel_figures; ?>';

    function formatRepo (repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-repository clearfix'>";
            if(repo.image_url) {
                markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
            }
            markup +="<div class='select2-result-repository__meta'>";
            markup +="  <div class='select2-result-repository__title'>" + repo.name + "</div>";

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
                    mimeType:"multipart/form-data",
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
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
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
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
