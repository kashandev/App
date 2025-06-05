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
                        <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print']; ?>
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
                    <form target="_blank" action="<?php echo $action_print; ?>" method="post" enctype="multipart/form-data" id="form">
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
                                                        <label><?php echo $lang['from_date']; ?></label>
                                                        <input type="text" id="date_from" name="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['to_date']; ?></label>
                                                        <input type="text" id="date_to" name="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label><?php echo $lang['budget_name'];?></label>
                                                    <select class="form-control" name="budget_transaction_id">
                                                        <option value="">&nbsp;</option>
                                                        <?php foreach($budgets as $budget):?>
                                                        <option value="<?php echo $budget['budget_transaction_id'];?>"><?php echo $budget['budget_name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['output']; ?></label><br>
                                                        <label class="radio-inline custom-radio" >
                                                            <input type="radio" name="output" value="Excel" \>Excel
                                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class="radio-inline custom-radio" >
                                                            <input type="radio" name="output" value="PDF" checked \>PDF
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['project']; ?></label>
                                                        <select class="form-control" id="project_id" name="project_id" >
                                                            <option value="">&nbsp;</option>
                                                            <?php foreach($projects as $project): ?>
                                                            <option value="<?php echo $project['project_id']; ?>"><?php echo $project['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $lang['sub_project']; ?></label>
                                                    <select class="form-control" id="sub_project_id" name="sub_project_id" >
                                                        <option value="">&nbsp;</option>
                                                    </select>
                                                </div>
                                            </div>
                                                </div>


                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $lang[entry_group_by]; ?></label>
                                                        <select class="form-control" name="group_by" id="group_by_id" >
                                                            <option value="">&nbsp;</option>
                                                            <option value="reg_date"><?php echo $lang[text_reg_date]; ?></option>
                                                            <option value="project"><?php echo $lang[project]; ?></option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            -->
                                            <div class="pull-right">
                                                <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();">
                                                    <i class="fa fa-print"></i>
                                                    &nbsp;<?php echo $lang['print']; ?>
                                                </a>
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
<script type="text/javascript" src="./admin/view/js/report/qarze_hassana_report.js"></script>
<script type="text/javascript">
    var $UrlGetCOALevel2 = '<?php echo $href_get_coa_level2; ?>';
    var $UrlGetCOALevel3 = '<?php echo $href_get_coa_level3; ?>';
    var $UrlGetReport = '<?php echo $href_get_report; ?>';
    var $UrlPrintReport = '<?php echo $href_print_report; ?>';
    var $UrlGetSubProject = '<?php echo $href_get_sub_project; ?>';


    $dataTable = $('#tblReport').DataTable();
</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>