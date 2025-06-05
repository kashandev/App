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
                        <a class="btn btn-primary" title="Add New" data-toggle="tooltip" href="<?php echo $action_insert; ?>"><i class="fa fa-plus"></i></a>
                        <button onclick="ConfirmDelete('<?php echo $action_delete; ?>',1)" class="btn btn-danger" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash-o"></i></button>
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
        <section class="content">
            <div class="error-page text-center">
                <h1><i class="fa fa-warning" style="color:#EF6F6C;"></i>&nbsp;<?php echo $lang['permission_error']; ?></h1>
                <p><?php echo $lang['contents']; ?></p>
            </div>
        </section><!-- /.content -->
        <?php echo $page_footer; ?>
    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<?php echo $footer; ?>
</body>
</html>
