<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
    <?php echo $page_header; ?>
    <?php echo $column_left; ?>
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
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header box-default">
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
                            <form action="<?php echo $href_print_label; ?>" target="_blank" method="post" enctype="multipart/form-data" id="form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $lang['product_name']; ?></label>
                                                    <select class="form-control" name="product_id" id="product_id">
                                                        <option value="">&nbsp;</option>
                                                        <?php foreach($products as $product): ?>
                                                        <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name'] . ' (' . $product['product_code'] . ')'; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $lang['quantity']; ?></label>
                                                    <input class="form-control fPDecimal" type="text" id="quantity" name="quantity" value="" />
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $lang['column']; ?></label>
                                                    <select class="form-control" id="column" name="column">
                                                        <option value="1"><?php echo $lang['column_1']; ?></option>
                                                        <option value="2"><?php echo $lang['column_2']; ?></option>
                                                        <option value="3"><?php echo $lang['column_3']; ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label><?php echo $lang['output']; ?></label><br>
                                            <label class="radio-inline custom-radio" >
                                                <input type="radio" name="output" value="Dirham" \>Dirham
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="radio-inline custom-radio" >
                                                <input type="radio" name="output" value="PKR" checked \>PKR
                                            </label>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Sell Price</label>
                                                    <input type="text" class="form-control fPDecimal" name="sale_price" id="sale_price" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Percentage</label>
                                                    <input type="text" class="form-control fPDecimal" name="percent" id="percent">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Total Price</label>
                                                    <input type="text" class="form-control fPDecimal" name="total_price" id="total_price">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-info form-control">Print Label</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.box-header -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php echo $page_footer; ?>
    <?php echo $column_right; ?>
</div><!-- ./wrapper -->
    <script type="text/javascript" src="../admin/view/js/inventory/label_print.js"></script>
    <script>
    var $urlgetProductInfo = '<?php echo $url_get_Product_Info  ?>';
    </script>
<?php echo $footer; ?>
</body>
</html>