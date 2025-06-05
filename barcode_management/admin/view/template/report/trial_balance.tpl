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
                <form action="<?php echo $action_print; ?>" target="_blank" method="post" enctype="multipart/form-data" id="form">
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
                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['from_date']; ?></label>
                                    <input required="true"  type="text" name="date_from" id="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['to_date']; ?></label>
                                    <input required="true" type="text" name="date_to" id="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $lang['group_by']; ?></label>
                                    <select class="form-control" name="display_level" id="level" >
                                        <option value="3"><?php echo $lang['level3']; ?></option>
                                        <option value="2"><?php echo $lang['level2']; ?></option>
                                        <option value="1"><?php echo $lang['level1']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $lang['branch']; ?></label>
                                    <select class="form-control" id="company_branch_id" name="company_branch_id" >
                                        <option value="">&nbsp;</option>
                                        <?php foreach($branchs as $branch): ?>
                                        <option value="<?php echo $branch['company_branch_id']; ?>"><?php echo $branch['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> Columns </label><br>
                                                    <input type="radio" name="col" value="2"> 2 Cols
                                                    &nbsp;<input checked="checked" type="radio" name="col" value="6"> 6 Cols
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
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
<script type="text/javascript">
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>
<script type="text/javascript">
    var $UrlPrintExcel = '<?php echo $href_print_excel; ?>';
    var $UrlPrintDetail = '<?php echo $action_print; ?>';
    function printExcel() {
        // if($('#date_from').val() == '' || $('#date_to').val() == '')
        // {
        //     alert('Please select From and To date');
        // }
        // else
        // {
        // console.log( $UrlPrintExcel )
        $('#form').attr('action', $UrlPrintExcel).submit();
        // }

    }
    function printDetail() {
        // if($('#date_from').val() == '' || $('#date_to').val() == '')
        // {
        //     alert('Please select From and To date');
        // }
        // else
        // {
        // console.log( $UrlPrintDetail )
        $('#form').attr('action', $UrlPrintDetail).submit();
        // }
    }
</script>
</body>
</html>