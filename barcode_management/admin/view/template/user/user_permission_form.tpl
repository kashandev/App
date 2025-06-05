<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php echo $column_left; ?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <!--page level css -->
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/buttons.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/colReorder.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="./assets/datatables/css/dataTables.bootstrap.css" />
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
                    <form action="<?php echo $action_save; ?>" method="post" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" >
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php echo $breadcrumb['text']; ?></h3>
                                    </div>

                                    <div class="panel-body">
                                        <fieldset>
                                            <table class="form table table-striped table-bordered table-hover">
                                                <tr>
                                                    <div class="form-group">
                                                        <label><span class="required">*</span>&nbsp;<?php echo $lang['name']; ?></label>
                                                        <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
                                                    </div>
                                                </tr>
                                            </table>
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <td><input type="checkbox" id="chk_all" name="chk_all" value="" />&nbsp;<?php echo $lang['all']; ?></td>
                                                    <td><input type="checkbox" id="chk_view" name="chk_view" value="" />&nbsp;<?php echo $lang['view']; ?></td>
                                                    <td><input type="checkbox" id="chk_insert" name="chk_insert" value="" />&nbsp;<?php echo $lang['add']; ?></td>
                                                    <td><input type="checkbox" id="chk_update" name="chk_update" value="" />&nbsp;<?php echo $lang['edit']; ?></td>
                                                    <td><input type="checkbox" id="chk_delete" name="chk_delete" value="" />&nbsp;<?php echo $lang['delete']; ?></td>
                                                    <td><input type="checkbox" id="chk_post" name="chk_post" value="" />&nbsp;<?php echo $lang['post']; ?></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $class = 'odd'; $row=0; ?>
                                                <?php foreach ($permissions as $key => $permission): ?>
                                                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                                <tr>
                                                    <td><input id="<?php echo $row; ?>" onclick="fn_chk_frm('<?php echo $row; ?>');" type="checkbox" name="chk_form" value="<?php echo $key; ?>" />&nbsp;<?php echo $key; ?></td>
                                                    <td><input attr_name="<?php echo $row; ?>" attr_permission="view" type="checkbox" name="permission[<?php echo $key; ?>][view]" value="1" <?php echo ($permission['view']==1?'checked="checked"':''); ?> /></td>
                                                    <td><input attr_name="<?php echo $row; ?>" attr_permission="insert" type="checkbox" name="permission[<?php echo $key; ?>][insert]" value="1" <?php echo ($permission['insert']==1?'checked="checked"':''); ?> /></td>
                                                    <td><input attr_name="<?php echo $row; ?>" attr_permission="update" type="checkbox" name="permission[<?php echo $key; ?>][update]" value="1" <?php echo ($permission['update']==1?'checked="checked"':''); ?> /></td>
                                                    <td><input attr_name="<?php echo $row; ?>" attr_permission="delete" type="checkbox" name="permission[<?php echo $key; ?>][delete]" value="1" <?php echo ($permission['delete']==1?'checked="checked"':''); ?> /></td>
                                                    <td><input attr_name="<?php echo $row; ?>" attr_permission="post" type="checkbox" name="permission[<?php echo $key; ?>][post]" value="1" <?php echo ($permission['post']==1?'checked="checked"':''); ?> /></td>
                                                </tr>
                                                <?php $row++; endforeach; ?>
                                                </tbody>
                                            </table>
                                            </fieldset></div></div></div></div>
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
<script type="text/javascript"><!--
    $(document).on('change', '#chk_all', function() {
        if($(this).is(':checked')) {
            $(':checkbox').prop('checked', true);
        } else {
            $(':checkbox').prop('checked', '');
        }
    });
    $(document).on('change', '#chk_view', function() {
        if($(this).is(':checked')) {
            $(':checkbox[attr_permission=view]').prop('checked', true);
        } else {
            $(':checkbox[attr_permission=view]').prop('checked', '');
        }
    });
    $(document).on('change', '#chk_insert', function() {
        if($(this).is(':checked')) {
            $(':checkbox[attr_permission=insert]').prop('checked', true);
        } else {
            $(':checkbox[attr_permission=insert]').prop('checked', '');
        }
    });
    $(document).on('change', '#chk_update', function() {
        if($(this).is(':checked')) {
            $(':checkbox[attr_permission=update]').prop('checked', true);
        } else {
            $(':checkbox[attr_permission=update]').prop('checked', '');
        }
    });
    $(document).on('change', '#chk_delete', function() {
        if($(this).is(':checked')) {
            $(':checkbox[attr_permission=delete]').prop('checked', true);
        } else {
            $(':checkbox[attr_permission=delete]').prop('checked', '');
        }
    });
    function fn_chk_frm(id) {
        if(jQuery('#'+id).is(':checked')) {
            jQuery(':checkbox[attr_name=' + id + ']').prop('checked', true);
        } else {
            jQuery(':checkbox[attr_name=' + id + ']').prop('checked', false);
        }
    }
    //--></script>
<script type="text/javascript" src="./assets/validate/jquery.validate.min.js"></script>
<script>

</script>
<?php echo $footer; ?>
</body>
</html>