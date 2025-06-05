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
                            &nbsp;<?php echo $lang['print']; ?>
                        </a>
                        <a class="btn btn-success" href="javascript:void(0);" onclick="printExcel();">
                            <i class="fa fa-print"></i>
                            &nbsp;Excel
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $lang[entry_from_date]; ?></label>
                                    <input type="text" name="date_from" id="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $lang[entry_to_date]; ?></label>
                                    <input type="text" name="date_to" id="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['partner_type']; ?></label>
                                    <select class="form-control" id="partner_type_id" name="partner_type_id">
                                        <option value="">&nbsp;</option>
                                        <?php foreach($partner_types as $partner_type): ?>
                                        <option value="<?php echo $partner_type['partner_type_id']; ?>" <?php echo ($partner_type_id == $partner_type['partner_type_id']?'selected="true"':''); ?>><?php echo $partner_type['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['column_supplier']; ?></label>
                                    <select class="form-control" id="partner_id" name="partner_id">
                                        <option value="">&nbsp;</option>
                                        <?php foreach($suppliers as $partner): ?>
                                        <option value="<?php echo $partner['partner_id']; ?>" ><?php echo $partner['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="partner_id" class="error" style="display: none;"></label>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control select2">
                                        <option value="All">All</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cleared">Cleared</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $lang[entry_product]; ?></label>
                                    <select class="form-control" name="product_id" id="product_id"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $lang[entry_group_by]; ?></label>
        <select class="form-control" name="group_by" id="group_by_id" >
        <option value="document_date"><?php echo $lang[text_document_date]; ?></option>
        <option value="partner"><?php echo $lang[text_partner]; ?></option>
        <option value="product"><?php echo $lang[text_product]; ?></option>
        </select>
                                </div>
                            </div>
                        </div>

                                        <div class="card_footer border-top-0">
                                            <div class="pull-right">
                                                <a class="btn btn-primary" href="javascript:void(0);" onclick="printDetail();">
                                                    <i class="fa fa-print"></i>
                                                    &nbsp;<?php echo $lang['print']; ?>
                                                </a>
                                                <a class="btn btn-success" href="javascript:void(0);" onclick="printExcel();">
                                                    <i class="fa fa-print"></i>
                                                    &nbsp;Excel
                                                </a>
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

<script type="text/javascript" src="./admin/view/js/report/purchase_order.js"></script>
<script type="text/javascript">
    var $UrlPrint = '<?php echo $href_print_report; ?>';
    var $UrlPrintExcel = '<?php echo $href_print_excel; ?>';
    var $partner_id = '<?php echo $partner_id; ?>';
    var $UrlGetProductById = '<?php echo $href_product; ?>';
    var $product_id = '<?php echo $product_id; ?>';

    var $UrlGetProductJson = '<?= $href_get_product_json ?>';

    function Select2ProductJsonPurchaseOrder(obj) {
        var $Url = '<?php echo $href_get_product_json; ?>';
        select2OptionList(obj,$Url);
    }

    $(function(){
        Select2ProductJsonPurchaseOrder('#product_id');
        $('#product_id').on('select2:select', function (e) {
            var $data = e.params.data;
        });
    });

</script>




</body>
</html>