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
                    <form action="<?php echo $action_save; ?>" method="post" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" id="hidepanel1">
                                    <div class="panel-heading" style="background-color: #26c6da">
                                        <h3 class="panel-title"><i class="fa fa-credit-card" ></i>&nbsp;&nbsp;<?php echo $breadcrumb['text']; ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-3">
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
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['partner_type']; ?></label>
                                                        <select class="form-control" id="partner_type_id" name="partner_type_id">
                                                            <option value="">&nbsp;</option>
                                                            <?php foreach($partner_types as $partner_type): ?>
                                                            <option value="<?php echo $partner_type['partner_type_id']; ?>"><?php echo $partner_type['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label><?php echo $lang['partner_name']; ?></label>
                                                    <select class="form-control" name="partner_id" id="partner_id">
                                                        <option value="">&nbsp;</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <button class="btn btn-info form-control" type="button" onclick="getDetailReport();">Filter</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="tblReport" class="table table-striped table-bordered">
                                                            <thead class="th-color">
                                                            <tr>
                                                                <th class="center"><?php echo $lang['partner_type']; ?></th>
                                                                <th class="center"><?php echo $lang['partner_name']; ?></th>
                                                                <th class="center"><?php echo $lang['document_date']; ?></th>
                                                                <th class="center"><?php echo $lang['document_no']; ?></th>
                                                                <th class="center"><?php echo $lang['adjusted_document']; ?></th>
                                                                <th class="center"><?php echo $lang['remarks']; ?></th>
                                                                <th class="center"><?php echo $lang['account']; ?></th>
                                                                <th class="center"><?php echo $lang['debit']; ?></th>
                                                                <th class="center"><?php echo $lang['credit']; ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

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
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div><!-- /.col -->

            </div><!-- /.row -->

        </section><!-- /.content -->
        <?php echo $page_footer; ?>
    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<link rel="stylesheet" href="./assets/plugins/dataTables/dataTables.bootstrap.css">
<script src="./assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="./assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="./admin/view/js/report/document_ledger.js"></script>
    <script type="text/javascript">
        var $UrlGetDetailReport = '<?php echo $href_get_detail_report; ?>';
        var $UrlGetSummaryReport = '<?php echo $href_get_summary_report; ?>';
        var $UrlPrintDetail = '<?php echo $href_print_detail_report; ?>';
        var $UrlPrintSummary = '<?php echo $href_print_summary_report; ?>';

        $dataTable = $('#tblReport').DataTable();
    </script>
    <?php echo $page_footer; ?>
    <?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>