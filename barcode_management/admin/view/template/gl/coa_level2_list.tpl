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
            <div class="row padding-left_right_15">
                <div class="col-xs-12">
                    <form action="#" method="post" enctype="multipart/form-data" id="form">
                        <table class="table table-striped table-bordered table-hover" id="dataTable" width="700">
                            <thead>
                            <tr class="text_color" style="background-color: #90a4ae;">
                                <td aligns="center"><?php echo $lang['action']; ?></td>
                                <td align="center"><?php echo $lang['level1']; ?></td>
                                <td align="center"><?php echo $lang['code']; ?></td>
                                <td align="center"><?php echo $lang['name']; ?></td>
                                <td align="center"><?php echo $lang['created_at']; ?></td>
                                <td align="center"><?php echo $lang['delete']; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
<!-- Current Document js -->
<script type="text/javascript" src="./assets/datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.colReorder.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.rowReorder.js"></script>
<script type="text/javascript" src="./assets/datatables/js/dataTables.scroller.js"></script>
<!-- end of Current Document js -->
<script type="text/javascript">
    var $lang = <?php echo json_encode($lang); ?>;
    jQuery(document).ready(function(){
        oTable = jQuery('#dataTable').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?php echo $action_ajax; ?>"
            ,"aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 0,5 ]
            }, {
                'bSearchable' : false,
                'aTargets' : [ 0,5 ]
            }, {
                'className' : 'text-center',
                'aTargets' : [ 0 ]
            } ]
            , "aaSorting": [[ 2, "desc" ]]
        });
    });
</script>
<?php echo $footer; ?>
</body>
</html>

