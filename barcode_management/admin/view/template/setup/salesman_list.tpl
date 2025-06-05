<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="crm_body_bg">
<!-- main content part here -->

<!-- sidebar  -->
<!-- sidebar part here -->
<?php echo $column_left; ?>
<section class="main_content dashboard_part default_content">
<?php echo $page_header; ?>

        <div class="main_content_iner ">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-4">
                    <nav>
                        <h3><?php echo $lang['heading_title']; ?></h3>
                        <ul class="breadcrumb p-0" style="background: transparent;">
                            <?php foreach($breadcrumbs as $breadcrumb): ?>
                            <?php $active = (($lang['heading_title']==$breadcrumb['text'])?true:false); ?>
                            <?php if( $active ): ?>
                            <li class="breadcrumb-item active">
                                <?php echo $breadcrumb['text']; ?>
                            </li>
                            <?php else: ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo $breadcrumb['href']; ?>">
                                    <i class="<?php echo $breadcrumb['class']; ?>"></i>
                                    <?php echo $breadcrumb['text']; ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-8">
                    <div class="float-right">

                        <div class="btn-group btn__group">

                            <button class="btn btn-primary shadow" title="Add New" data-toggle="tooltip" onclick="window.location.replace('<?php echo $action_insert; ?>')">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button onclick="ConfirmDelete('<?php echo $action_delete; ?>',1)" class="btn btn-danger shadow" title="Delete" data-toggle="tooltip" type="button"><i class="fas fa-trash"></i></button>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php if ($error_warning) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                            <?php echo $error_warning; ?>
                        </div>
                    <?php } ?>
                    <?php  if ($success) { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                            <?php echo $success; ?>
                        </div>
                    <?php  } ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card_box white_bg">
                        <div class="box_body">
                            <div class="box-body">
                                <form action="#" method="post" enctype="multipart/form-data">
                                    <div class="QA_table">                                        
                                        <table id="dataTable" class="table table-striped table-bordered" style="width: 100% !important">
                                            <thead>
                                                <tr>
                                                    <td aligns="center"><?php echo $lang['action']; ?></td>
                                                    <td align="center"><?php echo $lang['name']; ?></td>
                                                    <td align="center"><?php echo $lang['address']; ?></td>
                                                    <td align="center"><?php echo $lang['email']; ?></td>
                                                    <td align="center"><?php echo $lang['mobile']; ?></td>
                                                    <td align="center"><?php echo $lang['phone']; ?></td>
                                                    <td align="center"><?php echo $lang['created_at']; ?></td>
                                                    <td align="center"><?php echo $lang['delete']; ?></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>




<?php echo $page_footer; ?>
<?php echo $column_right; ?>

</section>
<!-- main content part end -->
<script type="text/javascript">

    var adelete = '<?php echo html_entity_decode($action_delete); ?>';
    var afilter = '<?php echo html_entity_decode($action_filter); ?>';

    $('#btnDelete').click(function() {
        $('#form').attr('action', adelete);
        $('#form').submit();
    });

    $('#btnFilter').click(function() {
        $('#form').attr('action', afilter);
        $('#form').submit();
    });

</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        oTable = jQuery('#dataTable').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": true,
            "bAutoWidth": false,
                "language": {
                "search": "<i class='ti-search'></i>",
                "searchPlaceholder": 'Search Here...',
                "paginate": {
                    "next": "<i class='ti-arrow-right'></i>",
                    "previous": "<i class='ti-arrow-left'></i>"
                }
            },
            "dom":"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'<'table-responsive'tr>>><'row'<'col-sm-5'i><'col-sm-7'p>>",
            "bDestroy": true,
            "sAjaxSource": "<?php echo $action_ajax; ?>"
            ,"aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 0, 7 ]
            }, {
                'bSearchable' : false,
                'aTargets' : [ 0, 7 ]
            } ]
            , "aaSorting": [[ 6, "desc" ]]
        });

        // Basic Styling
        $('.dataTables_filter label, .dataTables_length label').addClass('d-flex align-items-center justify-content-between m-0');
        $('.dataTables_filter input').addClass('form-control mx-1');
        $('.dataTables_length select').addClass('form-control mx-1');
        $('.dataTables_info').addClass('pt-0 mt-0');
        $('.dataTables_paginate').addClass('pt-0 mt-0');

    });

</script>

<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="ti-angle-up"></i>
    </a>
</div>


<?php echo $footer; ?>
</body>
</html>