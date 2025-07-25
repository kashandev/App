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
                <div class="col-sm-6">
                    <div class="pull-right">
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
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
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
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['product_type']; ?></label>
                                            <select class="form-control" id="product_type" name="product_type" >
                                                <?php if(isset($isEdit) && $isEdit==1){ ?> 
                                                    <?php if($product_type=="Product"){ ?> 
                                                        <option value="">&nbsp;</option>
                                                        <option value="Product" selected>Product</option>
                                                        <option value="Service">Service</option>
                                                        <option value="Part">Part</option>

                                                    <?php } elseif($product_type=="Service") { ?> 

                                                        <option value="">&nbsp;</option>
                                                        <option value="Product">Product</option>
                                                        <option value="Service" selected>Service</option>
                                                        <option value="Part">Part</option>

                                                    <?php } elseif($product_type=="Part") { ?>
                                                        <option value="">&nbsp;</option>
                                                        <option value="Product">Product</option>
                                                        <option value="Service">Service</option>
                                                        <option value="Part" selected>Part</option>

                                                    <?php } ?>
                                                    
                                                <?php } else { ?> 
                                                    <option value="">&nbsp;</option>
                                                    <option value="Product">Product</option>
                                                    <option value="Service">Service</option>
                                                    <option value="Part">Part</option>
                                                <?php } ?>
                                              
                                            </select>
                                            <label for="product_type" style="display: none;" class="error">&nbsp;</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['product_category']; ?></label>
                                            <select class="form-control" id="product_category_id" name="product_category_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($product_categories as $product_category): ?>
                                                <option value="<?php echo $product_category['product_category_id']; ?>" <?php echo ($product_category['product_category_id'] == $product_category_id ? 'selected="selected"': ''); ?>><?php echo $product_category['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="product_category_id" style="display: none;" class="error">&nbsp;</label>
                                        </div>
                                        <label style="visibility: hidden;">Add Produ Category</label>
                                        <a href="#" class="btn btn-primary btn-xs pull-left" onClick="AddBrand=window.open('<?php echo $href_product_category_form ?>','AddBrand','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                        <!-- <div class="form-group col-sm-2 pull-left">
                                            <label style="visibility: hidden;">Add Category</label>
                                            <a href="#" class="btn btn-primary btn-xs" onClick="AddBrand=window.open('<?php echo $href_product_category_form ?>','AddBrand','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                        </div> -->
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><?php echo $lang['product_sub_category']; ?></label>
                                            <select class="form-control" id="product_sub_category_id" name="product_sub_category_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($product_sub_categories as $product_category): ?>
                                                <option value="<?php echo $product_category['product_sub_category_id']; ?>" <?php echo ($product_category['product_sub_category_id'] == $product_sub_category_id ? 'selected="selected"': ''); ?>><?php echo $product_category['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <label style="visibility: hidden;">Add Produ Category</label>
                                            <a href="#" class="btn btn-primary btn-xs pull-left" onClick="AddBrand=window.open('<?php echo $href_product_sub_category_form ?>','AddBrand','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                        <!-- <div class="form-group col-sm-3">
                                            <label style="visibility: hidden;">Add Category</label>
                                            <a href="#" class="btn btn-primary btn-xs" onClick="AddBrand=window.open('<?php echo $href_product_sub_category_form ?>','AddBrand','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                        </div> -->
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['code']; ?></label>
                                            <input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $product_code ?>" <?php echo ($auto_generate_product_code==1?'readonly':'')?> />
                                        </div>
                                    </div>
                                     <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><?php echo $lang['brand']; ?>
                                            </label><select class="form-control" id="brand_id" name="brand_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($brands as $brand): ?>
                                                <option value="<?php echo $brand['brand_id']; ?>" <?php echo ($brand['brand_id'] == $brand_id ? 'selected="selected"': ''); ?>><?php echo $brand['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <!-- <label style="visibility: hidden;">Add Produ Category</label>
                                            <a href="#" class="btn btn-primary btn-xs pull-left" onClick="AddBrand=window.open('<?php echo $href_brand_form ?>','AddBrand','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                         <div class="col-sm-3">
                                            <label style="visibility: hidden;">Add Category</label>
                                            <a href="#" class="btn btn-primary btn-xs" onClick="AddBrand=window.open('<?php echo $href_brand_form ?>','AddBrand','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                        </div>  -->
                                    </div> 
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['name']; ?></label>
                                            <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" />
                                        </div>
                                    </div>
                                    <!-- <button class="hide add_brand" id="add_brand" onclick="getBrands()">
                                        <i class="fa fa-plus"></i>
                                    </button> -->
                                    <!--<div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $lang['make']; ?></label>
                                            <select class="form-control" id="make_id" name="make_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($makes as $make): ?>
                                                <option value="<?php echo $make['make_id']; ?>" <?php echo ($make['make_id'] == $make_id ? 'selected="selected"': ''); ?>><?php echo $make['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>-->
                                    
                                </div>
                                
                                <div class="row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><?php echo $lang['model']; ?>
                                                <button class="add_model hide" id="add_model" onclick="getmodels()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </label>
                                            <select class="form-control" id="model_id" name="model_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($models as $model): ?>
                                                <option value="<?php echo $model['model_id']; ?>" <?php echo ($model['model_id'] == $model_id ? 'selected="selected"': ''); ?>><?php echo $model['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <label style="visibility: hidden;">Add Produ Category</label>
                                            <a href="#" class="btn btn-primary btn-xs pull-left" onClick="Addmodel=window.open('<?php echo $href_model_form ?>','Addmodel','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                         <div class="col-sm-3">
                                            <label style="visibility: hidden;">Add Category</label>
                                            <a href="#" class="btn btn-primary btn-xs" onClick="Addmodel=window.open('<?php echo $href_model_form ?>','Addmodel','width=600,height=600,top=50,left=200'); return false;"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['code']; ?></label>
                                            <input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $product_code ?>" <?php echo ($auto_generate_product_code==1?'readonly':'')?> />
                                        </div>
                                    </div> -->
                                    
                                    
                                </div>
                                <div class="row">
                                    
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['serial_no']; ?></label>
                                            <input class="form-control" type="text" name="serial_no" value="<?php echo $serial_no; ?>" />
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['unit']; ?></label>
                                            <select class="form-control" id="unit_id" name="unit_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($units as $unit): ?>
                                                <option value="<?php echo $unit['unit_id']; ?>" <?php echo ($unit['unit_id'] == $unit_id ? 'selected="selected"': ''); ?>><?php echo $unit['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="unit_id" class="error" style="display: none;"><?php echo $error['unit_id']; ?></label>
                                        </div>
                                    </div>
                                
                                    <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><?php echo $lang['cost_price']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="cost_price" value="<?php echo $cost_price; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><span class="required">*</span>&nbsp;<?php echo $lang['unit']; ?></label>
                                            <select class="form-control" id="unit_id" name="unit_id" >
                                                <option value="">&nbsp;</option>
                                                <?php foreach($units as $unit): ?>
                                                <option value="<?php echo $unit['unit_id']; ?>" <?php echo ($unit['unit_id'] == $unit_id ? 'selected="selected"': ''); ?>><?php echo $unit['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="unit_id" class="error" style="display: none;"><?php echo $error['unit_id']; ?></label>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group col-sm-9">
                                            <label><?php echo $lang['cost_price']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="cost_price" value="<?php echo $cost_price; ?>" />
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $lang['sale_price']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="sale_price" value="<?php echo $sale_price; ?>" />
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $lang['sale_price']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="sale_price" value="<?php echo $sale_price; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $lang['wholesale_price']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="wholesale_price" value="<?php echo $wholesale_price; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $lang['minimum_price']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="minimum_price" value="<?php echo $minimum_price; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $lang['reorder_quantity']; ?></label>
                                            <input class="form-control fDecimal" type="text" name="reorder_quantity" value="<?php echo $reorder_quantity; ?>" />
                                        </div>
                                      
                                        
                                       
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" id="a_product_image"  data-toggle="image" class="img-thumbnail" data-src_image="src_product_image" data-src_input="file_product_image" data-width="100" data-height="100">
                                                <img alt="Product Image" src="<?php echo $src_product_image; ?>"  id="src_product_image" alt="" title="" data-placeholder="<?php echo $no_image; ?>" class="img-responsive"/>
                                            </a>
                                            <input type="hidden" name="product_image" value="<?php echo $product_image; ?>" id="file_product_image" />
                                            <br />
                                            <a class="btn btn-primary btn-xs" onclick="jQuery('#src_product_image').attr('src', '<?php echo $no_image; ?>'); jQuery('#file_product_image').attr('value', '');"><?php echo $lang['clear']; ?></a>
                                            <br />&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
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
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript" src="../admin/view/js/inventory/product.js"></script>
    <script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
    <script>

        var $UrlGetProductSubCategory = '<?php echo $href_product_sub_category; ?>';
        var $product_sub_category_id = '<?php echo $product_sub_category_id; ?>';
        var $UrlAddBrand="<?php echo $url_add_brand ?>";
        var $UrlAddProductCategory="<?php echo $url_add_product_category ?>";
        var $UrlAddProductSubCategory="<?php echo $url_add_product_sub_category ?>";
        var $UrlAddModel="<?php echo $url_add_model ?>";
        var $UrlAddMake="<?php echo $url_add_make ?>";

        jQuery('#form').validate(<?php echo $strValidation; ?>);

        var $UrlAddBrand="<?php echo $url_add_brand ?>";
        var $UrlAddModel="<?php echo $url_add_model ?>";
        var $UrlAddMake="<?php echo $url_add_make ?>";


        function getBrands(){
            $.ajax({
                url: $UrlAddBrand,
                success: function(data) {
                    $("#brand_id").html(data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }
            });
        }

        function getProductCategory(){
            $.ajax({
                url: $UrlAddProductCategory,
                success: function(data) {
                    $("#product_category_id").html(data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }
            });
        }

        function getProductSubCategory(){
            $.ajax({
                url: $UrlAddProductSubCategory,
                success: function(data) {
                    $("#product_sub_category_id").html(data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }
            });
        }




    function getmodels(){
        $.ajax({
            url: $UrlAddModel,
            success: function(data) {
                $("#model_id").html(data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.responseText);
            }
        });
    }
    
        function getmakes(){
            $.ajax({
                url: $UrlAddMake,
                success: function(data) {
                    $("#make_id").html(data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }
            });
        }
        <?php if($this->request->get['product_id']): ?>
        $(document).ready(function() {
            $('#product_category_id').trigger('change');
        });
        <?php endif; ?>


    </script>
    <?php echo $page_footer; ?>
    <?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>
