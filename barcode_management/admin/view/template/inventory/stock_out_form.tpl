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
<!--                 <?php if($is_post == 0): ?>
                <a class="btn btn-info shadow" href="<?php echo $action_post; ?>" onclick="return  confirm('Are you sure you want to post this item?');">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp;<?php echo $lang['post']; ?>
                </a> -->
                <?php endif; ?>
<!--                 <button type="button" class="btn btn-info shadow" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa-balance-scale"></i>
                    &nbsp;<?php echo $lang['ledger']; ?>
                </button>
                <a class="btn btn-info shadow" target="_blank" href="<?php echo $action_print_bill; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Commercial Invoice
                </a> -->
                <a class="btn btn-info shadow" target="_blank" href="<?php echo $action_print_document; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Print
                </a>
                <?php endif; ?>

                <button class="btn btn-default shadow" onclick="window.location.replace('<?php echo $action_cancel; ?>')">
                    <i class="fa fa-undo"></i>
                    &nbsp;<?php echo $lang['cancel']; ?>
                </button>
                <button class="btn btn-primary shadow btnSave" onclick="Save()">
                    <i class="fa fa-save"></i>
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

    <style>
        .loaderjs{
            position:fixed;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background:rgb(0 0 0 / 29%);
            z-index:999999;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .loaderjs.hide{
            display:none;

        }
    </style>

    <div id="loaderjs" class="loaderjs">
        <div id="loadingGif"><img src="<?php echo $loader_image; ?>"></div>

    </div>

<div class="row padding-left_right_15">
<div class="col-xs-12">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
   <input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
   <input type="hidden" value="<?php echo $stock_out_id; ?>" name="document_id" id="document_id" />
   <input type="hidden" id="form_key" name="form_key" value="<?php echo $form_key ?>" />
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

                     <div class="col-sm-2">
                        <div class="form-group">
                         <label><?php echo $lang['total_quantity']; ?></label>
                        <input class="form-control fDecimal" type="text" id="total_qty_master" value="<?php echo round_decimal($qty_master,2); ?>" readonly="readonly" />
                     </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-3 hide">
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
                           <label><span class="required">*</span>&nbsp;<?php echo $lang['partner_name']; ?></label>
                           <select class="form-control" id="partner_id" name="partner_id">
                              <option value="">&nbsp;</option>
                           </select>
                           <label for="partner_id" class="error" style="display: none;">&nbsp;</label>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <label><?php echo $lang['serial_no']; ?></label>
                           <input class="form-control" type="text" id="master_serial_no" />
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label><?php echo $lang['remarks']; ?></label>
                           <input class="form-control" type="text" name="remarks" id="remarks" value="<?php echo $remarks; ?>" />
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="table-responsive QA_table">
                           <table id="tblStockOut" class="table table-striped table-bordered" style="width: 4000px !important;">
                              <thead>
                                 <tr align="center" data-row_id="H">
                                    <td style="width: 7px; !important;">
                                       <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                    <td style="width: 300px"><?php echo $lang['product_code']; ?></td>
                                    <td style="width: 350px"><?php echo $lang['product_name']; ?></td>
                                    <td style="width: 300px"><?php echo $lang['description']; ?></td>
                                    <td style="width: 300px"><?php echo $lang['warehouse']; ?></td>
                                    <td style="width: 300px"><?php echo $lang['stock_unit']; ?></td>
                                    <td style="width: 150px"><?php echo $lang['quantity']; ?></td>
                                    <td style="width: 150px"><?php echo $lang['unit_price']; ?></td>
                                    <td style="width: 150px;"><?php echo $lang['total_price']; ?></td>
                                    <td style="width: 7px; !important;">
                                       <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                 </tr>
                              </thead>
                              <tbody >
                                 <?php foreach($stock_out_details as $grid_row => $detail): ?>
                                 <tr id="grid_row_<?php echo $grid_row; ?>" data-row_id="<?php echo $grid_row; ?>">
                                    <td>
                                       <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                       <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                    <td>
                                       <input type="text" onchange="getProductBySerialNo(this);" class="form-control" name="stock_out_details[<?php echo $grid_row; ?>][serial_no]" id="stock_out_detail_serial_no_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['serial_no']); ?>" readonly>
                                       <input type="hidden" class="form-control" name="stock_out_details[<?php echo $grid_row; ?>][product_code]" id="stock_out_detail_product_code_<?php echo $grid_row; ?>" value="<?php echo htmlentities($detail['product_code']); ?>"
                                          />
                                    </td>
                                    <td style="min-width: 300px;">
                                       <!--         <select class="required form-control Select2Product required" id="stock_out_detail_product_master_id_<?= $grid_row ?>" name="stock_out_details[<?= $grid_row ?>][product_master_id]" required >
                                          <option value="<?= $detail['product_master_id'] ?>"><?= implode(' - ', array(
                                             $detail['product_code'],
                                             $detail['brand'],
                                             $detail['model'],
                                             $detail['product_name'],
                                             )) ?></option>
                                          </select>
                                          <label for="stock_out_detail_product_id_<?= $grid_row ?>" class="error" style="display: none"></label> -->
                                       <input type="hidden" id="stock_out_detail_product_master_id_<?= $grid_row ?>" name="stock_out_details[<?= $grid_row ?>][product_master_id]" value="<?= $detail['product_master_id'] ?>">
                                       <input type="hidden" id="stock_out_detail_product_id_<?= $grid_row ?>" name="stock_out_details[<?= $grid_row ?>][product_id]" value="<?= $detail['product_id'] ?>">
                                       <input type="text" class="form-control" id="stock_out_detail_product_name_<?php echo $grid_row; ?>" value="<?=  $detail['product_code'] . ' - ' . $detail['product_name'] ?>" readonly>
                                    </td>
                                    <td>
                                       <textarea  type="text" style="width: 200px" rows="2" class="form-control" name="stock_out_details[<?php echo $grid_row; ?>][description]" id="stock_out_detail_description_<?php echo $grid_row; ?>" readonly="readonly" ><?php echo $detail['description']; ?></textarea>
                                    </td>
                                    <td >
                                       <input type="hidden" id="stock_out_detail_warehouse_id_<?= $grid_row ?>" name="stock_out_details[<?= $grid_row ?>][warehouse_id]" value="<?= $detail['warehouse_id'] ?>">
                                       <input type="text" id="stock_out_detail_warehouse_<?php echo $grid_row; ?>" value="<?= $detail['warehouse'] ?>" class="form-control" readonly>
                                       <!--         <select style="width: 300px" required name="stock_out_details[<?php echo $grid_row; ?>][warehouse_id]" id="stock_out_detail_charge_warehouse_id_<?php echo $grid_row; ?>" class="form-control select2 required">
                                          <option value="">&nbsp;</option>
                                          <?php foreach($warehouses as $warehouse): ?>
                                          <option value="<?php echo $warehouse['warehouse_id']; ?>" <?php echo ($detail['warehouse_id'] == $warehouse['warehouse_id']?'selected="true"':''); ?>><?php echo $warehouse['name']; ?></option>
                                          <?php endforeach; ?>
                                          </select>
                                          <label for="stock_out_detail_warehouse_id_<?php echo $grid_row; ?>" class="error" style="display: none"></label> -->
                                    </td>
                                    <td>
                                       <input type="hidden" name="stock_out_details[<?php echo $grid_row; ?>][unit_id]" id="stock_out_detail_unit_id_<?php echo $grid_row; ?>" value="<?php echo $detail['unit_id']; ?>" />
                                       <input type="text" class="form-control" name="stock_out_details[<?php echo $grid_row; ?>][unit]" id="stock_out_detail_unit_<?php echo $grid_row; ?>" value="<?php echo $detail['unit']; ?>" readonly="readonly" />
                                    </td>
                                    <td>
                                       <input type="text" style="min-width: 100px; text-align: right" class="form-control fPDecimal" name="stock_out_details[<?= $grid_row ?>][qty]" id="stock_out_detail_qty_<?= $grid_row ?>" value="<?= $detail['qty'] ?>" readonly/>
                                    </td>
                                    <td>
                                       <input type="text" onchange="calculateRowTotal(this);" style="min-width: 100px; text-align: right" class="form-control fPDecimal" name="stock_out_details[<?= $grid_row ?>][unit_price]" id="stock_out_detail_unit_price_<?= $grid_row ?>" value="<?= $detail['unit_price'] ?>"/>
                                    </td>
                                    <td>
                                       <input type="text" style="min-width: 100px; text-align: right" class="form-control fPDecimal" id="stock_out_detail_total_price_<?= $grid_row ?>"  name="stock_out_details[<?= $grid_row ?>][total_price]" value="<?= $detail['total_price'] ?>" readonly />
                                    </td>
                                    <td>
                                       <a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                       &nbsp;
                                       <a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                    </td>
                                 </tr>
                                 <?php endforeach; ?>
                                 <?php $grid_row = count($stock_out_details); ?>
                              </tbody>
                              <tfoot>
                                 <tr align="center" data-row_id="H">
                                    <td colspan="6" style="text-align: right"><b>Total</b></td>
                                    <td>
                                       <input class="form-control fDecimal" type="text" id="qty_master" name="qty_master" value="<?php echo round_decimal($qty_master,2); ?>" readonly="readonly" />
                                    </td>
                                    <td></td>
                                    <td>
                                       <input class="form-control fDecimal" type="text" id="total_price_master" name="total_price_master" value="<?php echo round_decimal($total_price_master,2); ?>" readonly="readonly" />
                                    </td>
                                    <td></td>
                                    <td style="width: 1%; !important;"></td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="col-sm-6"></div>
                  <div class="row">
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label><?php echo $lang['discount_percent']; ?></label>
                           <input class="form-control fDecimal" onchange="calculateDiscountAmount()" type="text" id="discount_percent" name="discount_percent" value="<?php echo round_decimal($discount_percent,2); ?>" />
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label><?php echo $lang['discount_amount']; ?></label>
                           <input class="form-control fDecimal" onchange="calculateDiscountPercent()" type="text" id="discount_amount" name="discount_amount" value="<?php echo round_decimal($discount_amount,2); ?>" />
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div class="form-group">
                           <label><?php echo $lang['net_amount']; ?></label>
                           <input class="form-control fDecimal" type="text" id="net_amount" name="net_amount" value="<?php echo round_decimal($net_amount,2); ?>" readonly>
                        </div>
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

<script type="text/javascript" src="./admin/view/js/inventory/stock_out.js"></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $lang = <?php echo json_encode($lang) ?>;
    var $partner_id = '<?php echo $partner_id; ?>';
    var $UrlGetPartner = '<?php echo $href_get_partner; ?>';
    var $GetRefDocument = '<?php echo $get_ref_document; ?>';
    var $GetRefDocumentRecord = '<?php echo $get_ref_document_record; ?>';
    var $GetRefDocumentJson = '<?php echo $href_get_ref_document_json; ?>';
    var $UrlGetDocumentDetails = '<?php echo $href_get_document_detail; ?>';
    var $grid_row = '<?php echo $grid_row; ?>';
    var $UrlGetContainerProducts = '<?php echo $href_get_container_products; ?>';
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $UrlAddRecords = '<?php echo $href_add_record_session; ?>';
    var $products = <?php echo json_encode($products) ?>;
    var $warehouses = <?php echo json_encode($warehouses) ?>;

    var $UrlGetPartnerJSON = '<?php echo $href_get_partner_json; ?>';

    // $(document).ready(function() {
    //    $('#partner_type_id').val('2').trigger('change');
    //     calculateTotal();
    // });

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
        "</div></div>";

        return markup;
    }

    function formatReposit (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
//        if(repo.image_url) {
//            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
//        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.document_identity + "</div>";

//        if (repo.description) {
//            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
//        }
        "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name || repo.text;
    }

        <?php if($this->request->get['stock_out_id']): ?>
        $(document).ready(function() {
            $('#partner_type_id').trigger('change');
            calculateTotal();
        });
        <?php endif; ?>

        function Select2ProductJsonStockOut(obj) {
            var $Url = '<?php echo $href_get_product_json; ?>';
            select2OptionList(obj,$Url);
        }

        // $(function(){
        //     Select2SubProject('#sub_project_id');
        //     $('#sub_project_id').on('select2:select', function (e) {
        //         var $data = e.params.data;
        //         console.log($data)
        //         $('#project_id').val($data['project_id']);
        //     });

        //     $('.Select2Product').each(function(index, element){
        //         var $ele = $(element);
        //         var $row_id = $ele.parent().parent().data('row_id');
        //         Select2ProductJsonStockOut('#stock_out_detail_product_id_'+$row_id);
        //         $('#stock_out_detail_product_id_'+$row_id).on('select2:select', function (e) {
        //             var $row_id = $(this).parent().parent().data('row_id');
        //             var $data = e.params.data;
        //             $('#stock_out_detail_product_code_'+$row_id).val($data['product_code']);
        //             $('#stock_out_detail_unit_id_'+$row_id).val($data['unit_id']);
        //             $('#stock_out_detail_unit_'+$row_id).val($data['unit']);
        //             $('#stock_out_detail_description_'+$row_id).val($data['description']);
        //         });
        //     })

        // })

        $(document).ready(function(){
            $('#partner_id').select2({
                width: '100%',
                ajax: {
                    url: $UrlGetPartnerJSON + '&partner_type_id='+$('#partner_type_id').val(),
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
        });

</script>

</body>
</html>