
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $lang[from_date]; ?></label>
                                        <input type="text" id="date_from" name="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $lang[to_date]; ?></label>
                                        <input type="text" id="date_to" name="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 hide">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $lang['partner']; ?></label>
                                        <select class="form-control" id="partner_id" name="partner_id">
                                            <option value="">&nbsp;</option>
                                            <?php foreach($customers as $customer): ?>
                                            <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="partner_id" class="error" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $lang['warehouse']; ?></label>
                                        <select class="form-control" id="warehouse_id" name="warehouse_id">
                                            <option value="">&nbsp;</option>
                                            <?php foreach($warehouses as $warehouse): ?>
                                            <option value="<?php echo $warehouse['warehouse_id']; ?>"><?php echo $warehouse['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="warehouse_id" class="error" style="display: none;"></label>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $lang['product']; ?></label>
                                        <select class="form-control product" name="product_id[]" id="product_id" multiple="multiple">
                                            <option value="">&nbsp;</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $lang[group_by]; ?></label>
                                        <select class="form-control" name="group_by" id="group_by_id" >
                                            <option value="document"><?php echo $lang[text_document]; ?></option>
                                            <option value="partner"><?php echo $lang[text_partner]; ?></option>
                                            <option value="warehouse"><?php echo $lang[text_warehouse]; ?></option>
                                            <option value="product"><?php echo $lang[text_product]; ?></option>
                                            <!-- <option value="container"><?php echo $lang[text_container]; ?></option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button id="btnFilter" class="btn btn-info form-control" type="button" onclick="getDetailReport();"><?php echo $lang['button_filter']; ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 hide">
                                    <div class="form-group">
                                        <label><?php echo $lang['container_no']; ?></label>
                                        <input type="text" id="container_no" name="container_no" value="<?php echo $container_no; ?>" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row padding-left_right_15">
                            <div class="col-xs-12">
                                    
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tblReport" class="table table-striped table-bordered">
                                                <thead class="th-color">
                                                <tr>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['document_date']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['document_no']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['warehouse']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['partner']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['batch_no']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['serial_no']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['product']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['qty']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['rate']; ?></th>
                                                    <th style="widows: 100px !important;" class="center"><?php echo $lang['amount']; ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
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
                            </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>

<script type="text/javascript" src="./assets/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.colReorder.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.rowReorder.js"></script>
<script type="text/javascript" src="./admin/view/js/report/sale_invoice.js"></script>
<script type="text/javascript">
    var $UrlPrint = '<?php echo $href_print_report; ?>';
    var $UrlPrintExcel = '<?php echo $href_print_excel_report; ?>';
    var $UrlGetDetailReport = '<?php echo $href_get_detail_report; ?>';

    function select2ProductJson(obj) {
        var $Url = '<?php echo $href_get_product_json; ?>';
        select2OptionList(obj,$Url);
    }

    $(function(){
        select2ProductJson('#product_id');
        $('#product_id').on('select2:select', function (e) {
            var $data = e.params.data;
        });
    });

    $dataTable = $('#tblReport').DataTable();
</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>