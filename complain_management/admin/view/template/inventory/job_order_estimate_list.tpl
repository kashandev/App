<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php echo $page_header; ?>
    <?php echo $column_left; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><?php echo $lang['heading_title']; ?></h1>
            <div class="row">
                <div class="col-sm-6">
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
                        <a class="btn btn-primary" title="Add New" data-toggle="tooltip" href="<?php echo $action_insert; ?>"><i class="fa fa-plus"></i></a>
                        <button onclick="ConfirmDelete('<?php echo $action_delete; ?>',1);" class="btn btn-danger" title="Delete" data-toggle="tooltip" type="button"><i class="fa fa-trash-o"></i></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <?php if ($error_warning) { ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <?php echo $error_warning; ?></div>
                            <?php } ?>
                            <?php  if ($success) { ?>
                            <div class="alert alert-success alert-dismissable">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <?php echo $success; ?></div>
                            <?php  } ?>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form action="#" method="post" enctype="multipart/form-data" id="form">
                                <table id="dataTable" class="table table-striped table-bordered table-hover" align="center">
                                <!-- <table class="table table-striped table-bordered table-hover" align="center"> -->
    
                                <thead>
                                    <tr>
                                        <td align="center"><?php echo $lang['action']; ?></td>
                                        <td align="center"><?php echo $lang['document_date']; ?></td>
                                        <td align="center"><?php echo $lang['document_no']; ?></td>
                                        <td align="center"><?php echo $lang['job_order_no']; ?></td>
                                        <td align="center"><?php echo $lang['partner_name']; ?></td>
                                        <td align="center"><?php echo $lang['product_name']; ?></td>
                                        <td align="center"><?php echo $lang['issue_description']; ?></td>
                                        <td align="center"><?php echo $lang['created_at']; ?></td>
                                        <td align="center"><?php echo $lang['delete']; ?></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!-- <td align="center">
                                                <a class="btn btn-primary btn-xs" target="_blank" href="#" title="Edit"><span class="fa fa-pencil"></span></a>
                                                <a class="btn btn-info btn-xs" target="_blank" href="#" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
                                                <a class="btn btn-danger btn-xs" href="javascript:void(0);" data-toggle="tooltip" title="Delete" onclick="ConfirmDelete('#')"><span class="fa fa-times"></span></a>
                                            </td>
                                            <td align="center">19-05-2022</td>
                                            <td align="center">2021-KHI/JOE-0001</td>
                                            <td align="center">2021-KHI/JO-0001</td>
                                            <td align="center">Test Customer 1</td>
                                            <td align="center">Product 1</td>
                                            <td align="center">issue Description coloum </td>
                                            <td align="center">19-05-2022 10:18:29</td>
                                            <td align="center"><input type="checkbox" name="selected[]" value="{6C3E9FA0-32BA-91A2-8A88-64B32CDC002D}"></td> -->
                                          
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php echo $page_footer; ?>
    <?php echo $column_right; ?>
</div><!-- ./wrapper -->
<link rel="stylesheet" href="plugins/dataTables/dataTables.bootstrap.css">
<script src="plugins/dataTables/jquery.dataTables.js"></script>
<script src="plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        oTable = jQuery('#dataTable').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": true,
            "bAutoWidth": false,
            "pageLength": 50,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?php echo $action_ajax; ?>"
            ,"aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 0,8 ]
            }, {
                'bSearchable' : false,
                'aTargets' : [ 0,8 ]
            } ]
            , "aaSorting": [[ 7, "desc" ]]
        });
    });
</script>
<?php echo $footer; ?>
</body>
</html>