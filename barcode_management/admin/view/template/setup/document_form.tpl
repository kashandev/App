<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php echo $column_left; ?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/colReorder.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/rowReorder.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../assets/datatables/css/scroller.bootstrap.css" />
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
        <div class="col-sm-12" id="danger-alert">
            <div class="alert alert-danger alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                <?php echo $error_warning; ?>
            </div>
        </div>
        <?php } ?>
        <?php  if ($success) { ?>
        <div class="col-sm-12" id="success-alert">
            <div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                <?php echo $success; ?>
            </div>
        </div>
        <?php  } ?>
        <!-- Main content -->
        <section class="content">
            <form action="<?php echo $action_save; ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="form">
                <div class="row padding-left_right_15">
                    <div class="col-md-12">
                        <div class="panel panel-primary" >
                            <div class="panel-heading" style="background-color: #00bc8c;">
                                <h3 class="panel-title"><i class="fa fa-credit-card" ></i><?php echo $breadcrumb['text']; ?></h3>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['document_from_date']; ?></label>
                                            <input type="text" class="form-control dtpDate" id="document_from_date" name="document_from_date" value="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['document_to_date']; ?></label>
                                            <input type="text" class="form-control dtpDate" id="document_to_date" name="document_to_date" value="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['post_from_date']; ?></label>
                                            <input type="text" class="form-control dtpDate" id="post_from_date" name="post_from_date" value="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['post_to_date']; ?></label>
                                            <input type="text" class="form-control dtpDate" id="post_to_date" name="post_to_date" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['partner_type']; ?></label>
                                            <select class="form-control" id="partner_type_id" name="partner_type_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($partner_types as $partner_type): ?>
                                                <option value="<?php echo $partner_type['partner_type_id']; ?>" ><?php echo $partner_type['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['partner_name']; ?></label>
                                            <select class="form-control" id="partner_id" name="partner_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($partners as $partner): ?>
                                                <option value="<?php echo $partner['partner_id']; ?>" ><?php echo $partner['name'] . ' [' . $partner['partner_type'] . ']'; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['document_type']; ?></label>
                                            <select class="form-control" id="document_type_id" name="document_type_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($document_types as $document_type): ?>
                                                <option value="<?php echo $document_type['document_type_id']; ?>" ><?php echo $document_type['document_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" id="btnFilter" name="btnFilter" class="btn btn-primary form-control" >
                                                <i class="fa fa-search"></i>
                                                <?php echo $lang['filter']; ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="tblDocuments" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th><?php echo $lang['document_type']; ?></th>
                                                    <th><?php echo $lang['document_date']; ?></th>
                                                    <th><?php echo $lang['document_no']; ?></th>
                                                    <th><?php echo $lang['partner_type']; ?></th>
                                                    <th><?php echo $lang['partner_name']; ?></th>
                                                    <th><?php echo $lang['post_date']; ?></th>
                                                    <th><?php echo $lang['post_by']; ?></th>
                                                    <th><?php echo $lang['created_at']; ?></th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
            </form>
        </section><!-- /.content -->
        <?php echo $page_footer; ?>
    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<script type="text/javascript" src="../assets/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>
<?php echo $footer; ?>
</body>
</html>