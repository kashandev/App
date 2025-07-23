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
                    <a class="btn btn-success" href="javascript:void(0);" onclick="printExcel();">
                        <i class="fa fa-print"></i>
                        &nbsp;Excel
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
                        <form action="#" target="_blank" method="post" enctype="multipart/form-data" id="form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="required">*&nbsp;</span><?php echo $lang[from_date]; ?></label>
                                        <input type="text" id="date_from" name="date_from" value="<?php echo $date_from; ?>" class="form-control dtpDate" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><span class="required">*&nbsp;</span><?php echo $lang[to_date]; ?></label>
                                        <input type="text" id="date_to" name="date_to" value="<?php echo $date_to; ?>" class="form-control dtpDate" autocomplete="off"/>
                                    </div>
                                </div>
                             <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['job_order_type']; ?></label>
                                     <select class="form-control" id="job_order_type" name="job_order_type">
                                     <option value="">&nbsp;</option>
                                     <option value="normal">Normal</option>
                                     <option value="warranty">Warranty</option>
                                     <option value="no_warranty">No Warranty</option>
                                     <option value="home">Home</option>
                                     <option value="repeat">Repeat</option>
                                    </select>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['status']; ?></label>
                                    <select class="form-control" id="status" name="status">
                                     <option value="">&nbsp;</option>
                                     <option value="0">Pending</option>
                                     <option value="1">Cleared</option>
                                    </select>
                                </div>
                            </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['pending_duration']; ?></label>
                                    <select class="form-control" id="pending_duration" name="pending_duration">
                                     <option value="">&nbsp;</option>
                                     <option value="24 Hour">24 Hour</option>
                                     <option value="2 Day">2 Day</option>
                                     <option value="3 Day">3 Day</option>
                                     <option value="More Than 3 Days">More Than 3 Days</option>
                                    </select>
                                </div>
                             </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $lang['repair_status']; ?></label>
                                    <select class="form-control" id="repair_status" name="repair_status">
                                    <option value="P">P-Pending</option>
                                    <option value="PFP" >PFP-Pending fpr Parts</option>
                                    <option value="UCS" >UCS-Uncollected Sets</option>
                                    <option value="OTP">OTP-Other Pending</option>
                                    <option value="CLD">CLD-Incollected cash</option>
                                    <option value="EST" >EST-Estimate</option>
                                    </select>
                                </div>
                            </div>
                           </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <div class="pull-right">
                                <a class="btn btn-success" href="javascript:void(0);" onclick="printExcel();"><i class="fa fa-print"></i>&nbsp;Excel
                                </a>
                            </div>
                    

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" href="plugins/dataTables/dataTables.bootstrap.css">
<script src="plugins/dataTables/jquery.dataTables.js"></script>
<script src="plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="../admin/view/js/report/job_order_report.js"></script>
<script type="text/javascript" src="plugins/validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery('#form').validate(<?php echo $strValidation; ?>);
    </script>
<script type="text/javascript">
    var $UrlPrint = '<?php echo $href_print_report; ?>';
//    $(document).ready(function() {
//        $('#product_id').select2({
//            allowClear: true,
//            placeholder: "",
//            width: '100%',
//            ajax: {
//                url: $UrlGetProductJSON,
//                dataType: 'json',
//                type: 'post',
//                mimeType:"multipart/form-data",
//                delay: 250,
//                data: function (params) {
//                    return {
//                        q: params.term, // search term
//                        page: params.page
//                    };
//                },
//                processResults: function (data, params) {
//                    // parse the results into the format expected by Select2
//                    // since we are using custom formatting functions we do not need to
//                    // alter the remote JSON data, except to indicate that infinite
//                    // scrolling can be used
//                    params.page = params.page || 1;
//
//                    return {
//                        results: data.items,
//                        pagination: {
//                            more: (params.page * 30) < data.total_count
//                        }
//                    };
//                },
//                cache: true
//            },
//            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
//            minimumInputLength: 5,
//            templateResult: formatRepo, // omitted for brevity, see the source of this page
//            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
//        });
//    });

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

        markup += "<div class='select2-result-repository__statistics'>" +
                "   <div class='help-block'>" + repo.length + " X " + repo.width + " X " + repo.thickness + "</div>" +
                "</div>" +
                "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name || repo.text;
    }

    $dataTable = $('#tblReport').DataTable();
</script>
<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>