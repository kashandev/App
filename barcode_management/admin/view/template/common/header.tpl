<head>
    <meta charset="UTF-8">
    <title><?php echo $heading_title; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link href="admin/view/css/app.css" rel="stylesheet" type="text/css" />
    <link href="admin/view/css/common/custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="admin/view/css/styles.css" />

    <script src="./assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="admin/view/js/bootstrap.min.js"></script>

    <script src="admin/view/js/app.js" type="text/javascript"></script>
    <script src="admin/view/js/Addition.js" type="text/javascript"></script>
    <!-- end of global css -->
    <script type="text/javascript" src="./assets/jquery.format.1.05.js"></script>
    <script type="text/javascript" src="./assets/jquery.maskedinput.js"></script>

    <link rel="stylesheet" href="./assets/select2/css/select2.min.css">
    <script type="text/javascript" src="./assets/select2/js/select2.js"></script>

    <script src="./assets/moment/js/moment.min.js" type="text/javascript"></script>
    <link href="./assets/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <script src="./assets/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


    <script src="./assets/bootbox.min.js" type="text/javascript"></script>

    <link rel="stylesheet"  href="./assets/iCheck/css/all.css">
    <link rel="stylesheet"  href="./assets/iCheck/css/line/line.css">
    <script type="text/javascript" src="./assets/iCheck/js/icheck.js"></script>

    <script type="text/javascript">

        var $URLOpenFileManager = '<?php echo $action_open_file_manager; ?>';
        var $URLUploadFile = '<?php echo $action_upload_file; ?>';
        var $UrlGetPartner = '<?php echo $href_get_partner; ?>';

        var $UrlGetDocumentLedger = '<?php echo $href_get_document_ledger; ?>';
        var $UrlGetProductByCode = '<?php echo $href_get_product_by_code; ?>';
        var $UrlGetProductBySerialNo = '<?php echo $href_get_product_by_serial_no; ?>';
        var $UrlGetProductBySerialNoWarehouse = '<?php echo $href_get_product_by_serial_no_warehouse; ?>';
        var $UrlGetProductById = '<?php echo $href_get_product_by_id; ?>';
        var $UrlGetWarehouseStock = '<?php echo $href_get_warehouse_stock; ?>';
        var $UrlGetCustomerUnit = '<?php echo $href_get_customer_unit; ?>';
        var $UrlGetPartnerById = '<?php echo $href_get_partner_by_id; ?>';

        $(document).ready(function () {
            setFieldFormat();
        });
        function rDecimal(number, upto)
        {
            var n = parseFloat( number ) || 0.00;
            return n.toFixed( upto );
        }
        var roundUpto = function(number, upto){
            var $number = parseFloat(number);
            return Number($number.toFixed(upto));
        };

        function setFieldFormat() {
             Setfiledformatnew();
             setSelect2Format();
        }
        function Setfiledformatnew(){
            
            $('.dtpDate').datetimepicker({
                format: '<?php echo PICKER_DATE; ?>'
            }).parent().css("position :relative");

            $('.dtpDateTime').datetimepicker({
                format: "<?php echo PICKER_DATE_TIME; ?>"
            }).parent().css("position :relative");

            $('.dtpTime').datetimepicker({
                format: "<?php echo PICKER_TIME; ?>"
            }).parent().css("position :relative");

            $('.fInteger').on('focus', function () {
                $(this).format({precision: 0,autofix:true});
            });
            $('.fPInteger').on('focus', function () {
                $(this).format({precision: 0,allow_negative:false,autofix:true});
            });
            $('.fDecimal').on('focus', function () {
                $(this).format({precision: 4,autofix:true});
            });
            $('.fPDecimal').on('focus', function () {
                $(this).format({precision: 4,allow_negative:false,autofix:true});
            });
            $('.fFloat').on('focus', function () {
                $(this).format({precision: 6,autofix:true});
            });
            $('.fPFloat').on('focus', function () {
                $(this).format({precision: 6,allow_negative:false,autofix:true});
            });
            $('.fEmail').on('focus', function () {
                $(this).format({type:"email"}, function () {
                    if ($(this).val() != "") alert("Wrong Email format!");
                });
            });
            $('.fString').on('focus', function () {
                $(this).format({type:"alphabet",autofix:true});
            });
            $('.fPhone').on('focus', function () {
                $(this).format({type:"phone-number"});

            });

            $('.fPhone').bind("cut copy paste",function(e) {
                e.preventDefault();
            });

            //$(".fPhone").mask("+99 (999) 9999999");
            $(".fCNIC").mask("99999-9999999-9");
        }
        function setSelect2Format()
        {
            $('select').select2({ width: '100%' });
        }

        function ConfirmDelete(url, $post=0) {
            bootbox.dialog({
                message: $lang['delete_text'],
                title: $lang['delete_title'],
                buttons: {
                    success: {
                        label: $lang['yes'],
                        className: "btn-success",
                        callback: function() {
                            if($post==1) {
                                $('#form').attr('action', url);
                                $('#form').submit();
                            } else {
                                location.href=url;
                            }
                        }
                    },
                    danger: {
                        label: $lang['no'],
                        className: "btn-danger"
                    }
                }
            });
        }
        function ConfirmPost(url, $post=0) {
            bootbox.dialog({
                message: $lang['post_text'],
                title: $lang['post_title'],
                buttons: {
                    success: {
                        label: $lang['yes'],
                        className: "btn-success",
                        callback: function() {
                            if($post==1) {
                                $('#form').attr('action', url);
                                $('#form').submit();
                            } else {
                                location.href=url;
                            }
                        }
                    },
                    danger: {
                        label: $lang['no'],
                        className: "btn-danger"
                    }
                }
            });
        }
    </script>
    <script type="text/javascript">
        function select2OptionList($OBJ,$URL) {
            $($OBJ).select2({
                width: '100%',
                ajax: {
                    url: $URL,
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
                //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
                //templateResult: formatRepo, // omitted for brevity, see the source of this page
                //templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
            });
        }

        function Select2SubProject(obj) {
            var $Url = '<?php echo $href_get_option_sub_project; ?>';

            select2OptionList(obj,$Url);
        }

        function Select2Product(obj) {
            var $Url = '<?php echo $href_get_option_product; ?>';
            select2OptionList(obj,$Url);
        }

        function Select2ProductMaster(obj) {
            var $Url = '<?php echo $href_get_option_product_master; ?>';
            select2OptionList(obj,$Url);
        }


        function Select2Employee(obj) {
            var $Url = '<?php echo $href_get_option_employee; ?>';

            select2OptionList(obj,$Url);
        }
        </script>
</head>
