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
                <div class="col-6">
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
                <div class="col-6">
                    <div class="float-right">
                        <button class="btn btn-light shadow" onclick="window.location.replace('<?php echo $action_cancel; ?>')">
                            <i class="fas fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </button>
                        <button class="btn btn-primary shadow btnSave" onclick="$('#form').submit();">
                            <i class="fas fa-save"></i>
                            &nbsp;<?php echo $lang['save']; ?>
                        </button>
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

            <div class="card_box white_bg">
                <div class="box_body">
                     <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><span class="required">*</span>&nbsp;<?php echo $lang['name']; ?></label>
                                    <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['address']; ?></label>
                                    <input  type="text" name="address" value="<?php echo $address; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['phone']; ?></label>
                                    <input type="text" name="phone" value="<?php echo $phone; ?>" class="form-control fPhone" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['mobile']; ?></label>
                                    <input type="text" name="mobile" value="<?php echo $mobile; ?>" class="form-control fPhone" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $lang['email']; ?></label>
                                    <input type="text" name="email" value="<?php echo $email; ?>" class="form-control fEmail" />
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="card_footer border-top-0">
                    <div class="float-right">
                        <button class="btn btn-light shadow" onclick="window.location.replace('<?php echo $action_cancel; ?>')">
                            <i class="fas fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </button>
                        <button class="btn btn-primary shadow btnSave" onclick="$('#form').submit();">
                            <i class="fas fa-save"></i>
                            &nbsp;<?php echo $lang['save']; ?>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


<?php echo $page_footer; ?>
<?php echo $column_right; ?>

</section>
<!-- main content part end -->

<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="ti-angle-up"></i>
    </a>
</div>
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
</script>

<?php echo $footer; ?>
</body>
</html>