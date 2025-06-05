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
                    <div class="pull-right">
                        <a class="btn btn-primary" href="javascript:void(0);" onclick="printDetail();">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print_detail']; ?>
                        </a>
                        <a class="btn btn-primary" href="javascript:void(0);" onclick="printSummary();">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print_summary']; ?>
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
                <form action="#" target="_blank" method="post" enctype="multipart/form-data" id="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary" id="hidepanel1">
                                <div class="panel-heading" style="background-color: #26c6da">
                                    <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-3 hide">
                                                <div class="form-group">
                                                    <label><?php echo $lang['from_date']; ?></label>
                                                    <input type="text" id="date_from" name="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $lang['to_date']; ?></label>
                                                    <input type="text" id="date_to" name="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $lang['warehouse']; ?></label>
                                                    <select class="form-control" name="warehouse_id" id="warehouse_id">
                                                        <option value="">&nbsp;</option>
                                                        <?php foreach($warehouses as $warehouse): ?>
                                                        <option value="<?php echo $warehouse['warehouse_id']; ?>"><?php echo $warehouse['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 hide">
                                                <div class="form-group">
                                                    <label><?php echo $lang['container_no']; ?></label>
                                                    <input type="text" id="container_no" name="container_no" value="<?php echo $container_no; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $lang['product_category']; ?></label>
                                                    <select class="form-control" id="product_category_id" name="product_category_id">
                                                        <option value="">&nbsp;</option>
                                                        <?php foreach($product_categories as $product_category): ?>
                                                        <option value="<?php echo $product_category['product_category_id']; ?>"><?php echo $product_category['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label><?php echo $lang['product']; ?></label>
                                                <select class="form-control product" name="product_id" id="product_id">
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button class="btn btn-info form-control" type="button" onclick="getDetailReport();">Filter</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for=""><?= $lang['group_by'] ?></label>
                                                    <div class="radio">
                                                        <label>
                                                            <input name="report_type" id="report_type_warehouse" value="Warehouse" checked="" type="radio">
                                                            <?php echo $lang['warehouse']; ?>
                                                        </label>
                                                    </div>
                                                    <div class="radio hide">
                                                        <label>
                                                            <input name="report_type" id="report_type_container" value="Container" type="radio">
                                                            <?php echo $lang['container_no']; ?>
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input name="report_type" id="report_type_product_report" value="Product_report" type="radio">
                                                            Product Report
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for=""><?= $lang['output'] ?></label>
                                                    <div class="radio">
                                                        <label>
                                                            <input name="output" value="Pdf" checked type="radio">
                                                            <?php echo $lang['pdf']; ?>
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input name="output" value="Excel" type="radio">
                                                            <?php echo $lang['excel']; ?>
                                                        </label>
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

<link rel="stylesheet" href="plugins/dataTables/dataTables.bootstrap.css">
<script src="plugins/dataTables/jquery.dataTables.js"></script>
<script src="plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="./admin/view/js/report/stock_detail_report.js"></script>
<script type="text/javascript">
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>
<script type="text/javascript">
    var $UrlPrintExcel = '<?php echo $href_print_excel; ?>';
    var $UrlGetDetailReport = '<?php echo $href_get_detail_report; ?>';
    var $UrlGetSummaryReport = '<?php echo $href_get_summary_report; ?>';
    var $UrlPrintWarehouseDetail = '<?php echo $href_print_warehouse_detail; ?>';
    var $UrlPrintWarehouseSummary = '<?php echo $href_print_warehouse_summary; ?>';
    var $UrlPrintContainerDetail = '<?php echo $href_print_container_detail; ?>';
    var $UrlPrintContainerSummary = '<?php echo $href_print_container_summary; ?>';
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';
    var $UrlPrintProductDetail = '<?php echo $report_type_product_report; ?>';

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

    $(document).ready(function() {
        $('#partner_type_id').trigger('change');
        $('select.product').select2({
            allowClear: true,
            placeholder: "",
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
                        page: params.page,
                        product_category_id: function() {
                            return $('#product_category_id').val();
                        }
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

    function printExcel() {
        $('#form').attr('action', $UrlPrintExcel).submit();
    }

    $dataTable = $('#tblReport').DataTable();


    $('[name="output"]').on('change', function(){
        if( $(this).val() == 'Excel' )
        {
            $('#report_type_product_report').parents('label').addClass('hide');
        }
        else
        {
            $('#report_type_product_report').parents('label').removeClass('hide');
        }
    })


</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>