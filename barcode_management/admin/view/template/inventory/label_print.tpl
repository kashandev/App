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

<link href="./assets/jasny-bootstrap.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="./assets/iCheck/css/all.css">
<link rel="stylesheet" type="text/css" href="./assets/iCheck/css/line/line.css">
<script type="text/javascript" src="./assets/iCheck/js/icheck.js"></script>
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
<!--                 <?php if(isset($isEdit) && $isEdit==1): ?>
                <?php if($is_post == 0): ?>
                <a class="btn btn-info" href="<?php echo $action_post; ?>">
                    <i class="fa fa-thumbs-up"></i>
                    &nbsp;<?php echo $lang['post']; ?>
                </a>
                <?php endif; ?>

                <button type="button" class="btn btn-info" href="javascript:void(0);" onclick="getDocumentLedger();">
                    <i class="fa fa fa-balance-scale"></i>
                    &nbsp;<?php echo $lang['ledger']; ?>
                </button>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print']; ?>
                </a>
                <a class="btn btn-success" target="_blank" href="<?php echo $action_print_excel; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;Excel
                </a>
                <?php endif; ?>
                <a class="btn btn-default" href="<?php echo $action_cancel; ?>">
                    <i class="fa fa-undo"></i>
                    &nbsp;<?php echo $lang['cancel']; ?>
                </a>
                <?php if($is_post == 0): ?>
                <a class="btn btn-primary" href="javascript:void(0);" onclick="$('#form').submit();">
                    <i class="fa fa-floppy-o"></i>
                    &nbsp;<?php echo $lang['save']; ?>
                </a>
                <?php endif; ?> -->
<!--                 <?php if($is_post == 1): ?>
                <a class="btn btn-info" target="_blank" href="<?php echo $action_print_barcode; ?>">
                    <i class="fa fa-print"></i>
                    &nbsp;<?php echo $lang['print_barcode']; ?>
                </a>

                <?php endif; ?>
            </div> -->
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


<!-- Main content -->
<section class="content">

<div class="row padding-left_right_15">
<div class="col-xs-12">
<input type="hidden" value="<?php echo $document_type_id; ?>" name="document_type_id" id="document_type_id" />
<input type="hidden" value="<?php echo $document_id; ?>" name="document_id" id="document_id" />

 <form action="<?php echo $href_print_label; ?>" target="_blank" method="post" enctype="multipart/form-data" id="form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><?php echo $lang['product_name']; ?></label>
                                            <select class="form-control" name="product_master_id" id="product_master_id">
                                                <option value="">&nbsp;</option>
                                            </select>
                                        </div>
<!--                                         <div class="form-group">
                                            <label><?php echo $lang['serial_no']; ?></label>
                                            <select class="form-control" name="product_id" id="product_id">
                                                <option value="">&nbsp;</option>
                                            </select>
                                        </div> -->

<!--                                         <div class="form-group">
                                            <label><?php echo $lang['quantity']; ?></label>
                                            <input class="form-control fPDecimal" type="text" id="quantity" name="quantity" value="" />
                                        </div> -->
                                        <div class="form-group">
                                            <label><?php echo $lang['column']; ?></label>
                                            <select class="form-control" id="column" name="column">
                                                <option value="1"><?php echo $lang['column_1']; ?></option>
                                                <option value="2"><?php echo $lang['column_2']; ?></option>
                                               <!--  <option value="3"><?php echo $lang['column_3']; ?></option> -->
                                            </select>
                                        </div>
<!--                                         <div class="form-group">
                                            <label><?php echo $lang['output']; ?></label><br>
                                            <label class="radio-inline custom-radio" >
                                                <input type="radio" name="output" value="Dirham" \>Dirham
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="radio-inline custom-radio" >
                                                <input type="radio" name="output" value="PKR" checked \>PKR
                                            </label>
                                        </div> -->
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-info form-control">Print Label</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->

</aside>
<!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>

<script>
    var $UrlGetProductJSON = '<?php echo $href_get_product_json; ?>';

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
        "</div></div>";

        return markup;
    }

    function formatReposit (repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
//        if(repo.image_url) {
//            markup +="<div class='select2-result-repository__avatar'><img src='" + repo.image_url + "' /></div>";
//        }
        markup +="<div class='select2-result-repository__meta'>";
        markup +="  <div class='select2-result-repository__title'>" + repo.document_identity + "</div>";

//        if (repo.description) {
//            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
//        }
        "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name || repo.text;
    }




            $(document).ready(function(){
            $('#product_master_id').select2({
                width: '100%',
                ajax: {
                    url: $UrlGetProductJSON,
                    dataType: 'json',
                    type: 'post',
                    mimeType:"multipart/form-data",
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 2,
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
            });
        });


</script>
<?php echo $page_footer; ?>
<?php echo $footer; ?>

</body>
</html>