<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<?php echo $header; ?>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div id="fadeLoader" style="display: none;"><div id="fadeSpinner"></div></div>
<div class="wrapper">
    <?php echo $page_header; ?>
    <?php echo $column_left; ?>
    <div class="content-wrapper">
        <style type="text/css">
            #fadeSpinner {
                border: 16px solid #f3f3f3; /* Light grey */
                border-top: 16px solid #3498db; /* Blue */
                border-radius: 50%;
                animation: spin 2s linear infinite;
                width: 150px;
                height: 150px;
                margin: auto;
                top:        0;
                left:       0;
                right:        0;
                bottom:       0;
                position: absolute;
            }

            #fadeLoader {
                opacity:    0.5;
                background: #000;
                z-index:    10;
                top:        0;
                left:       0;
                width: 100%;
                height: 100%;
                position:   fixed;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .lslide{
                position: relative;
            }
            .lslide label {
                top: 30px;
                left: 10px;
                color: white;
                position: absolute;
                font-size: 16px;
            }
            #divProducts .product {
                padding: 15px;
                text-align: center;
            }
        </style>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><?php echo $lang['heading_title']; ?></h1>
            <div class="row">
                <div class="col-sm-4">
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
                <div class="col-sm-8">
                    <div class="pull-right">
                        <?php if(isset($isEdit) && $isEdit==1): ?>
                        <?php if($is_post == 0): ?>
                        <a class="btn btn-info" href="<?php echo $action_post; ?>">
                            <i class="fa fa-thumbs-up"></i>
                            &nbsp;<?php echo $lang['post']; ?>
                        </a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                            <i class="fa fa-balance-scale"></i>
                            &nbsp;<?php echo $lang['ledger']; ?>
                        </button>
                        <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print']; ?>
                        </a>
                        <a class="btn btn-info" target="_blank" href="<?php echo $action_print_with_balance; ?>">
                            <i class="fa fa-print"></i>
                            &nbsp;<?php echo $lang['print_with_balance']; ?>
                        </a>
                        <?php endif; ?>
                        <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                            <i class="fa fa-undo"></i>
                            &nbsp;<?php echo $lang['cancel']; ?>
                        </a>
                        <button type="button" class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();" <?php echo ($is_post==1?'disabled="true"':''); ?>>
                        <i class="fa fa-floppy-o"></i>
                        &nbsp;<?php echo $lang['save']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-8">
                    <div class="box">
                        <div id="divProductCategory" class="box-body" style="background-color: #CDCDCD;">
                            <ul id="slider_product_category">
                                <?php foreach($product_categories as $product_category): ?>
                                <li class="lslide">
                                    <a href="javascript:void(0);" data-toggle="tooltip" title="<?php echo $product_category['name']; ?>" onclick="getProducts(<?php echo $product_category['product_category_id']; ?>);">
                                        <img alt="<?php echo $product_category['name']; ?>" src="<?php echo $product_category['image']; ?>" />
                                        <label><?php echo $product_category['name']; ?></label>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="box">
                        <div id="divProducts" class="box-body" style="height: 300px; overflow-y: auto; overflow-x: hidden;">
                            <?php $row_no=1; ?>
                            <?php foreach($products as $product_no => $product): ?>
                            <?php if($row_no==1): ?>
                            <div class="row">
                                <?php endif;?>
                                <a href="javascript:void(0);" data-toggle="tooltip" title="<?php echo $product['name']; ?>" onclick="addProduct('<?php echo $product['product_id']; ?>');">
                                    <div class="col-sm-2 product">
                                        <img alt="<?php echo $product['name']; ?>" src="<?php echo $product['image']; ?>" />
                                        <label><?php echo $product['name']; ?></label>
                                    </div>
                                </a>
                                <?php if($row_no==6 || $product_no==count($products)-1): $row_no=0;?>
                            </div>
                            <?php endif;?>
                            <?php $row_no++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label style="float: left; font-size: 16px;">Total Amount:</label>
                                    <label style="float: right; font-size: 16px;" id="lblTotalAmount" class="text-right">0</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" id="product_id" name="product_id" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12 table-responsive">
                                    <table id="tblCart" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 40%;"><?php echo $lang['product_name']; ?></th>
                                            <th style="width: 20%;"><?php echo $lang['rate']; ?></th>
                                            <th style="width: 20%;"><?php echo $lang['quantity']; ?></th>
                                            <th style="width: 20%;"><?php echo $lang['amount']; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $row_no=0; ?>
                                        <?php foreach($pos_invoice_detail as $detail): ?>
                                        <tr id="<?php echo $row_no; ?>" data-product_id="<?php echo $detail['product_id']; ?>">
                                            <td>
                                                <input type="hidden" id="pos_detail_<?php echo $row_no; ?>_product_id" name="pos_details[<?php echo $row_no; ?>][product_id]" value="<?php echo $detail['product_id']; ?>" />
                                                <?php echo $detail['name'];?>
                                            </td>
                                            <td>
                                                <input type="hidden" id="pos_detail_<?php echo $row_no; ?>_rate" name="pos_details[<?php echo $row_no; ?>][rate]" value="<?php echo $detail['rate']; ?>" />
                                                <?php echo $detail['rate'];?>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-btn">
                                                      <button class="btn btn-info btn-flat" type="button">+</button>
                                                    </span>
                                                    <input class="form-control" type="text" id="pos_detail__qty" value="1">
                                                    <span class="input-group-btn">
                                                      <button class="btn btn-info btn-flat" type="button">-</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="hidden" id="pos_detail_<?php echo $row_no; ?>_amount" name="pos_details[<?php echo $row_no; ?>][amount]" value="<?php echo $detail['amount']; ?>" />
                                                <?php echo $detail['amount'];?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<link rel="stylesheet" href="plugins/light_slider/css/lightslider.min.css">
<script type="text/javascript" src="plugins/light_slider/js/lightslider.min.js"></script>
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="../admin/view/js/inventory/pos_invoice.js"></script>
<script>
    jQuery('#form').validate(<?php echo $strValidation; ?>);
    var $row_no = <?php echo $row_no; ?>;
    var $lang = <?php echo json_encode($lang); ?>;
    var $UrlGetProducts = '<?php echo $href_get_products; ?>';
    var $UrlGetProductsJSON = '<?php echo $href_get_products_json; ?>';


    function formatRepo (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
        if(repo.image_url) {
            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.name + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        /*
        markup += "<div class='select2-result-repository__statistics'>" +
                "   <div class='help-block'>" + repo.length + " X " + repo.width + " X " + repo.thickness + "</div>" +
                "</div>";
        */
        markup +="</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name || repo.text;
    }
</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>