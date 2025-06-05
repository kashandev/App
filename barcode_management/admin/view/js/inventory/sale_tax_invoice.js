/**
 * Created by Huzaifa on 9/18/15.
 */

$(document).ready(function(){
    $("#loaderjs").addClass('hide');
});

$(document).ready(function() {
    if($sale_type == 'sale_invoice')
    {
        $('#sale_tax_invoice').prop( "checked", false);
        $('#sale_invoice').prop( "checked", true);
    }
    else
    {
        $('#sale_tax_invoice').prop( "checked", true);
        $('#sale_invoice').prop( "checked", false);
    }


    $('#sale_invoice').on('change', function() {
        if($(this).is(":checked"))
        {    $('#tblSaleInvoice tbody').empty();

            $('#sale_tax_invoice').prop( "checked", false);
            $('#tax_per').attr('readonly',true);
            // $('input[name="manual_ref_no"]').prop("readonly",false);   
        }
        else
        {

            $('#sale_tax_invoice').prop( "checked",true);
            $('#tax_per').removeAttr('readonly');
            // $('input[name="manual_ref_no"]').prop("readonly",true);
        }
    });
    $('#sale_tax_invoice').on('change', function() {
        if($(this).is(":checked"))
        { $('#tblSaleInvoice tbody').empty();
            $('#sale_invoice').prop( "checked", false);
            $('#tax_per').removeAttr('readonly');
            // $('input[name="manual_ref_no"]').prop("readonly",true);    
        }
        else
        {
            $('#sale_invoice').prop( "checked",true);
            $('#tax_per').attr('readonly',true);
            // $('input[name="manual_ref_no"]').prop("readonly",false);
        }
    });
});


$(document).ready(function() {
    $('#ref_document_id').select2({
        width: '100%',
        ajax: {
            url: $GetRefDocumentJson+'&partner_id='+$('#partner_id').val(),
            dataType: 'json',
            type: 'post',
            mimeType:"multipart/form-data",
            delay: 100,
            data: function (params) {
                return {
                    q: params.term, // search term
                    partner_id: $('#partner_id').val(),
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
        minimumInputLength: 3,
        templateResult: formatReposit, // omitted for brevity, see the source of this page
        templateSelection: function(repo) {
            // $('#product_code').val(repo['product_code']);
            return (repo.document_identity) || repo.text;
        } // omitted for brevity, see the source of this page                }
    });
});

// $(document).on('change','#ref_document_id',function() {
//    var $ref_document_id = $(this).val();
//    // console.log( $ref_document_id )
//    $.ajax({
//        url: $GetRefDocumentRecord,
//        dataType: 'json',
//        type: 'post',
//        data: 'ref_document_id='+$ref_document_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
// //            $('#unit_id').parent().before('<i id="loader" class="fas fa-spinner fa-spin pull-right"></i>');
//        },
//        complete: function() {
// //            $('#loader').remove();
//        },
//        success: function(json) {

//            // $('#partner_id').val(json.data['partner_id']).trigger('change');
//            // $('#po_no').val(json.data['po_no']);

//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
// })


$(document).on('change','#partner_type_id', function() {
    $partner_type_id = $(this).val();
    $.ajax({
        url: $UrlGetPartnerById,
        dataType: 'json',
        type: 'post',
        data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#partner_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            console.log(  )
            if(json.success)
            {
                $('#partner_id').select2('destroy');
                $('#partner_id').select2({width:'100%'});
                $('#partner_id').html('<option selected="selected" value="'+(json.partner['partner_id']??'')+'">'+(json.partner['name']??'')+'</option>');
                $('#partner_id').select2({
                    width: '100%',
                    ajax: {
                        url: $UrlGetPartnerJSON + '&partner_type_id='+$('#partner_type_id').val(),
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
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
});

$('#partner_id').on('change', function(){
    $('#tblSaleInvoice tbody').empty();
    $('#po_no').val('');
    $('#po_date').val('');
    $('#dc_no').val('');
    $('#project_id').val('');
    $('#sub_project_id').html('').trigger('change');
})

//$(document).on('change','#partner_id', function() {
//    $partner_id = $(this).val();
//    $.ajax({
//        url: $UrlGetCustomerUnit,
//        dataType: 'json',
//        type: 'post',
//        data: 'partner_id=' + $partner_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
//            $('#customer_unit_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
//        },
//        complete: function() {
//            $('#loader').remove();
//        },
//        success: function(json) {
//            if(json.success)
//            {
//                $('#customer_unit_id').select2('destroy');
//                $('#customer_unit_id').html(json.html);
//                $('#customer_unit_id').select2({width:'100%'});
//            }
//            else {
//                alert(json.error);
//            }
//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
//});


// $(document).on('change','#partner_id', function() {
//    $partner_id = $(this).val();
//    $.ajax({
//        url: $GetRefDocument,
//        dataType: 'json',
//        type: 'post',
//        data: 'partner_id='+$partner_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
//            $('#ref_document_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
//        },
//        complete: function() {
//            $('#loader').remove();
//        },
//        success: function(json) {
//            if(json.success)
//            {
//                $('#tblSaleInvoice tbody tr').remove();

//                $('#ref_document_id').select2('destroy');
//                $('#ref_document_id').html(json.html);
//                $('#ref_document_id').select2({width:'100%'});
//            }
//            else {
//                alert(json.error);
//            }
//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
// });




function GetDocumentDetails() {

    var $data = {
        ref_document_id : $('#ref_document_id').val()
    };

    var $details = [];
    $.ajax({
        url: $UrlGetDocumentDetails,
        dataType: 'json',
        type: 'post',
        data: $data,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            //    $('#ref_document_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            //    $('#loader').remove();
            $('#ref_document_id').html('');
            $('#ref_document_id').val(null);
            $('#ref_document_id').trigger('change');
        },

        success: function(json) {
            if(json.success)
            {
                console.log( json )

                // $('#tblSaleInvoice tbody tr').remove();
                $('#po_no').val(json.po_no);
                $('#po_date').val(json['po_date']);
                // $('#partner_id').val(json['partner_id']).trigger('change');
                // $('#customer_unit_id').val(json['customer_unit_id']).trigger('change');
                $('#dc_no').val(json['dc_no']);

                $('#project_id').val(json.data['project_id']);
                $('#sub_project_id').html('<option value="'+ json.data['sub_project_id'] +'">'+json.data['project']+' - '+json.data['sub_project']+'</option>').trigger('change');


                $.each(json.data['products'], function($i,$product) {
                    fillGrid($product);
                });

                //  $details = json['details'];
                //  for($i=0;$i<$details.length;$i++) {
                //  fillGrid($details[$i]);
                //   }
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
};


function fillGrid($obj) {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_ref_document_type_id_'+$grid_row+'" value="'+$obj['ref_document_type_id']+'" />';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_ref_document_identity_'+$grid_row+'" value="'+$obj['ref_document_identity']+'" />';
    $html += '<a target="_blank" href="'+$obj['href']+'">'+$obj['ref_document_identity']+'</a>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="getProductBySerialNo(this);" type="text" class="form-control" id="sale_tax_invoice_detail_serial_no_'+$grid_row+'" value="'+$obj['serial_no']+'" readonly/>';
    $html += '</td>';
    $html += '<td style="min-width: 200px">';
    $html += '<input type="hidden" class="form-control" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="'+$obj['product_code']+'"  />';
    $html += '<input type="hidden" class="form-control" id="sale_tax_invoice_detail_product_id_'+$grid_row+'" value="'+$obj['product_id']+'">';
    $html += '<input type="text" class="form-control" id="sale_tax_invoice_detail_product_name_'+$grid_row+'" value="'+$obj['product_code']+' - '+$obj['brand']+' - '+ $obj['model']+' - '+$obj['product_name']+'" readonly>';
    $html += '</td>';
    $html += '<td style="min-width: 200px">';
    $html += '<input style="min-width: 100px;" type="text" class="form-control" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="'+$obj['description']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input style="min-width: 100px;" type="text" class="form-control" id="sale_tax_invoice_detail_batch_no_'+$grid_row+'" value="'+$obj['batch_no']+'" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_warehouse_id_'+$grid_row+'" value="'+$obj['warehouse_id']+'" >';
    $html += '<input type="text" class="form-control" id="sale_tax_invoice_detail_warehouse_'+$grid_row+'" value="'+$obj['warehouse']+'" readonly >';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_available_stock_'+$grid_row+'" value="'+$obj['balanced_qty']+'" />';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_qty_'+$grid_row+'" value="'+$obj['balanced_qty']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" readonly style="min-width: 100px;" class="form-control" id="sale_tax_invoice_detail_unit_'+$grid_row+'" value="'+$obj['unit']+'" readonly/>';
    $html += '<input type="hidden" class="form-control" id="sale_tax_invoice_detail_unit_id_'+$grid_row+'" value="'+$obj['unit_id']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_rate_'+$grid_row+'" value="'+$obj['rate']+'" />';
    $html += '<input type="hidden" class="form-control fPDecimal" id="sale_tax_invoice_detail_cog_rate_'+$grid_row+'" value="'+$obj['cog_rate']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true" />';
    $html += '<input type="hidden" class="form-control" id="sale_tax_invoice_detail_cog_amount_'+$grid_row+'" value="'+$obj['cog_amount']+'" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_discount_amount_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_gross_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true"/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_tax_percent_'+$grid_row+'" value="'+$obj['tax_percent']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="'+$obj['tax_amount']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateFurtherTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_further_tax_percent_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateFurtherTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_further_tax_amount_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_total_amount_'+$grid_row+'" value="'+$obj['net_amount']+'" readonly="true" />';
    $html += '</td>';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';


    $('#tblSaleInvoice tbody').prepend($html);
    if($('#sale_invoice').is(":checked"))
    {
        $('#sale_tax_invoice_detail_tax_percent_'+$grid_row).attr('readonly',true);
        $('#sale_tax_invoice_detail_tax_amount_'+$grid_row).attr('readonly',true);

        $('#sale_tax_invoice_detail_further_tax_percent_'+$grid_row).attr('readonly',true);
        $('#sale_tax_invoice_detail_further_tax_amount_'+$grid_row).attr('readonly',true);
    }

    $('#sale_tax_invoice_detail_qty_'+$grid_row).trigger('change');

    calculateTotal();
    $grid_row++;

}

$(document).on('click','#btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_ref_document_type_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_ref_document_identity_'+$grid_row+'" value="" />';
    $html += '&nbsp;';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="getProductBySerialNo(this);" type="text" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][serial_no]" id="sale_tax_invoice_detail_serial_no_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td style="min-width: 200px">';
    $html += '<input type="hidden" class="required form-control" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="" />';
    $html += '<select class="form-control select2" id="sale_tax_invoice_detail_product_id_'+$grid_row+'">';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '</td>';
    $html += '<td style="min-width: 300px;">';
    $html += '<input  type="text" style="min-width: 100px;" class="form-control" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input style="min-width: 100px;" type="text" class="form-control" id="sale_tax_invoice_detail_batch_no_'+$grid_row+'" value="" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<select onchange="validateWarehouseStock(this);" class="form-control select2 warehouse_id" id="sale_tax_invoice_detail_warehouse_id_'+$grid_row+'" >';
    $html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse) {
        $html += '<option value="'+$warehouse.warehouse_id+'">'+$warehouse.name+'</option>';
    });
    $html += '</select>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" id="sale_tax_invoice_detail_available_stock_'+ $grid_row +'">';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_qty_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" readonly class="form-control" id="sale_tax_invoice_detail_unit_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" id="sale_tax_invoice_detail_unit_id_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" id="sale_tax_invoice_detail_rate_'+$grid_row+'" value="0.00" />';
    $html += '<input type="hidden" class="form-control" id="sale_tax_invoice_detail_cog_rate_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_amount_'+$grid_row+'" value="0.00" readonly="true" />';
    $html += '<input type="hidden"class="form-control fPDecimal" id="sale_tax_invoice_detail_cog_amount_'+$grid_row+'" value="0.00" readonly="true" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_discount_amount_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_gross_amount_'+$grid_row+'" value="" readonly="true"/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_tax_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateFurtherTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_further_tax_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateFurtherTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="sale_tax_invoice_detail_total_amount_'+$grid_row+'" value="" readonly="true" />';
    $html += '</td>';
    $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';


    $('#tblSaleInvoice tbody').append($html);
    //setFieldFormat();
    Select2ProductJsonSaleInvoice('#sale_tax_invoice_detail_product_id_'+$grid_row);
    $('#sale_tax_invoice_detail_product_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        $('#sale_tax_invoice_detail_product_code_'+$row_id).val($data['product_code']);
        $('#sale_tax_invoice_detail_unit_id_'+$row_id).val($data['unit_id']);
        $('#sale_tax_invoice_detail_unit_'+$row_id).val($data['unit']);
        $('#sale_tax_invoice_detail_description_'+$row_id).val($data['description']);
    });

    $('#sale_tax_invoice_detail_warehouse_id_'+$grid_row).select2({'width':'100%'});

    if($('#sale_invoice').is(":checked"))
    {

        $('#sale_tax_invoice_detail_tax_percent_'+$grid_row).attr('readonly',true);
        $('#sale_tax_invoice_detail_tax_amount_'+$grid_row).attr('readonly',true);

        $('#sale_tax_invoice_detail_further_tax_percent_'+$grid_row).attr('readonly',true);
        $('#sale_tax_invoice_detail_further_tax_amount_'+$grid_row).attr('readonly',true);
    }

    $grid_row++;
});


function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateRowTotal($obj) {


    var $row_id = $($obj).parent().parent().data('row_id');
    var $available_stock = parseFloat($('#sale_tax_invoice_detail_available_stock_'+$row_id).val()) || 0.00;

    var $qty = parseFloat($('#sale_tax_invoice_detail_qty_' + $row_id).val());
        var $rate = parseFloat($('#sale_tax_invoice_detail_rate_' + $row_id).val());
        var $cog_rate = parseFloat($('#sale_tax_invoice_detail_cog_rate_' + $row_id).val());

        var $amount = $qty * $rate;
        var $cog_amount = $qty * $cog_rate;
        $amount = roundUpto($amount,2);
        $cog_amount = roundUpto($cog_amount,2);

        var $dis_percent = parseFloat($('#sale_tax_invoice_detail_discount_percent_'+ $row_id).val()) || 0.0000;
        var $discount_amount = roundUpto($amount * $dis_percent / 100,2);

        var $gross_amount = roundUpto($amount - $discount_amount,2);

        var $tax_percent = parseFloat($('#sale_tax_invoice_detail_tax_percent_'+ $row_id).val()) || 0.0000;
        var $tax_amount = roundUpto($gross_amount * $tax_percent / 100,2);

        var $further_tax_percent = parseFloat($('#sale_tax_invoice_detail_further_tax_percent_'+ $row_id).val()) || 0.0000;
        var $further_tax_amount = roundUpto($gross_amount * $further_tax_percent / 100,2);

        // var $tax_amount = parseFloat($('#sale_tax_invoice_detail_tax_amount_' + $row_id).val());
        var $total_amount = roundUpto($gross_amount + $tax_amount + $further_tax_amount,2);

        $('#sale_tax_invoice_detail_cog_amount_' + $row_id).val($cog_amount);
        $('#sale_tax_invoice_detail_amount_' + $row_id).val($amount);
        $('#sale_tax_invoice_detail_discount_amount_' + $row_id).val($discount_amount);
        $('#sale_tax_invoice_detail_gross_amount_' + $row_id).val($gross_amount);
        $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val($tax_amount);
        $('#sale_tax_invoice_detail_further_tax_amount_' + $row_id).val($further_tax_amount);
        $('#sale_tax_invoice_detail_total_amount_' + $row_id).val($total_amount);

        calculateTotal();
}

function calculateTotal() {
    var $item_amount = 0;
    var $item_discount = 0;
    var $item_tax = 0;
    var $further_tax_total = 0;
    var $item_total = 0;
    $('#tblSaleInvoice tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $amount = $('#sale_tax_invoice_detail_amount_' + $row_id).val();
        $discount_amount = $('#sale_tax_invoice_detail_discount_amount_' + $row_id).val();
        $tax_amount = $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val();
        $further_tax_amount = $('#sale_tax_invoice_detail_further_tax_amount_' + $row_id).val();
        $total_amount = $('#sale_tax_invoice_detail_total_amount_' + $row_id).val();

        $item_amount += parseFloat($amount);
        $item_discount += parseFloat($discount_amount);
        $item_tax += parseFloat($tax_amount);
        $further_tax_total += parseFloat($further_tax_amount);
        $item_total += parseFloat($total_amount);
    })

    var $discount = $('#discount_amount').val() || 0.00;
    var $cartage = $('#cartage').val() || 0.00;

    var $net_amount = parseFloat($item_total) - parseFloat($discount) + parseFloat($cartage);

    $('#item_amount').val(roundUpto($item_amount,2));
    $('#item_discount').val(roundUpto($item_discount,2));
    $('#item_tax').val(roundUpto($item_tax,2));
    $('#further_tax_total').val(roundUpto($further_tax_total,2));
    $('#item_total').val(roundUpto($item_total,2));
    $('#discount_amount').val(roundUpto($discount,2));
    $('#cartage').val(roundUpto($cartage,2));
    $('#net_amount').val(roundUpto($net_amount,2));

}

function calculateDiscountAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $discount_percent = parseFloat($($obj).val()) || 0.0000;
    var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val()) || 0.0000;
    var $discount_amount = roundUpto($amount * $discount_percent / 100,2);
    $('#sale_tax_invoice_detail_discount_amount_' + $row_id).val($discount_amount);
    calculateRowTotal($obj);
}

function calculateDiscountPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $discount_amount = parseFloat($($obj).val()) || 0.0000;
    var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val()) || 0.0000;
    var $discount_percent = roundUpto($discount_amount / $amount * 100,2);

    $('#sale_tax_invoice_detail_discount_percent_' + $row_id).val($discount_percent);
    calculateRowTotal($obj);
}

function calculateTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_percent = parseFloat($($obj).val()) || 0.0000;
    var $gross_amount = parseFloat($('#sale_tax_invoice_detail_gross_amount_' + $row_id).val()) || 0.0000;
    var $tax_amount = roundUpto($gross_amount * $tax_percent / 100,2);
    $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val($tax_amount);
    calculateRowTotal($obj);
}

function calculateTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_amount = parseFloat($($obj).val()) || 0.0000;
    var $gross_amount = parseFloat($('#sale_tax_invoice_detail_gross_amount_' + $row_id).val()) || 0.0000;
    var $tax_percent = roundUpto($tax_amount / $gross_amount * 100,2);

    $('#sale_tax_invoice_detail_tax_percent_' + $row_id).val($tax_percent);
    calculateRowTotal($obj);
}


function calculateFurtherTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $further_tax_percent = parseFloat($($obj).val()) || 0.0000;
    var $gross_amount = parseFloat($('#sale_tax_invoice_detail_gross_amount_' + $row_id).val()) || 0.0000;
    var $further_tax_amount = roundUpto($gross_amount * $further_tax_percent / 100,2);
    $('#sale_tax_invoice_detail_further_tax_amount_' + $row_id).val($further_tax_amount);
    calculateRowTotal($obj);
}

function calculateFurtherTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $further_tax_amount = parseFloat($($obj).val()) || 0.0000;
    var $gross_amount = parseFloat($('#sale_tax_invoice_detail_gross_amount_' + $row_id).val()) || 0.0000;
    var $further_tax_percent = roundUpto($further_tax_amount / $gross_amount * 100,2);

    $('#sale_tax_invoice_detail_further_tax_percent_' + $row_id).val($further_tax_percent);
    calculateRowTotal($obj);
}


function AddTaxes() {
    var $tax_per = $('#tax_per').val();

    $('#tblSaleInvoice tbody tr').each(function() {

        $row_id = $(this).data('row_id');

        // var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val()) || 0.00;
        var $gross_amount = parseFloat($('#sale_tax_invoice_detail_gross_amount_' + $row_id).val()) || 0.00;
        var $tax_percent = parseFloat($('#sale_tax_invoice_detail_tax_percent_' + $row_id).val($tax_per)) || 0.00;
        var $tax_amount = roundUpto(($gross_amount * $tax_per / 100),2);
        $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val($tax_amount);

        var $further_tax_amount = parseFloat($('#sale_tax_invoice_detail_further_tax_amount_' + $row_id).val());


        var $net_amount = $gross_amount + $tax_amount + $further_tax_amount;
        $('#sale_tax_invoice_detail_total_amount_' + $row_id).val(roundUpto($net_amount,2));

    })

    calculateTotal();
}

// function Save() {
//     $('.warehouse_id').each(function() {
//         $(this).rules("add",
//             {
//                 required: true,
//                 // remote: {url: $url_validate_stock, type: 'post'},
//                 messages: {
//                     required: "Warehouse is required",
//                 }
//             });
//     });
//     $('.btnSave').attr('disabled','disabled');
//     if($('#form').valid() == true){
//         $('#form').submit();
//     }
//     else{
//         $('.btnSave').removeAttr('disabled');
//     }
// }

$('[name="document_date"]').change(function(){

    $('#tblSaleInvoice tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).trigger('change');
    });


});

function validateWarehouseStock($obj)
{
    var $row_id = $($obj).parent().parent().data('row_id');
    var $data = {
        warehouse_id: $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val(),
        product_id: $('#sale_tax_invoice_detail_product_id_'+$row_id).val(),
        document_date : $('[name="document_date"]').val(),
        document_identity : $('[name="document_identity"]').val()
    };

    var $change_qty = parseFloat($('#sale_tax_invoice_detail_qty_'+$row_id).val()) || 0;

    $.ajax({
        url: $url_validate_stock,
        dataType: 'json',
        type: 'post',
        data: $data,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#partner_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();3
        },
        success: function(json) {
            if(json.success)
            {
                // $available_stock = parseFloat(json.stock['stock_qty']) || 0;

                // if(($change_qty > $available_stock) && $allow_out_of_stock == 0)
                // {
                //     alert('Stock Not Available');
                //     $('#sale_tax_invoice_detail_qty_'+$row_id).val(0);
                // }
                $('#sale_tax_invoice_detail_available_stock_'+$row_id).val(parseFloat(json.stock['stock_qty']));
                $('#sale_tax_invoice_detail_cog_rate_'+$row_id).val(rDecimal((parseFloat(json.stock['avg_stock_rate'])||0),2));
                var $cog_amount = ((parseFloat($change_qty)||0)*(parseFloat(json.stock['avg_stock_rate'])||0));
                $('#sale_tax_invoice_detail_cog_amount_'+$row_id).val(rDecimal($cog_amount,2));
                $('#sale_tax_invoice_detail_qty_'+$row_id).trigger('change');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}
function getProductBySerialNo($obj) {
    $serial_no = $($obj).val();
    var $row_id = $($obj).parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductBySerialNo,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $serial_no,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            //$('#sale_tax_invoice_detail_product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#sale_tax_invoice_detail_product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                console.log($row_id);
                $('#sale_tax_invoice_detail_description_'+$row_id).val(json.product['name']);
                $('#sale_tax_invoice_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#sale_tax_invoice_detail_batch_no_'+$row_id).val(json.product['batch_no']);
                $('#sale_tax_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#sale_tax_invoice_detail_unit_'+$row_id).val(json.product['unit']);
                $('#sale_tax_invoice_detail_product_id_'+$row_id).select2('destroy');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).html('<option value="'+ json.product['product_id'] +'">'
                    + json.product['product_code'] +
                    '-' + json.product['brand'] +
                    '-' + json.product['model'] +
                    '-' + json.product['name'] +
                '</option>');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#sale_tax_invoice_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('#sale_tax_invoice_detail_product_master_id_'+$row_id).val(json.product['product_master_id']);
            }
            else {
                alert(json.error);
                $('#sale_tax_invoice_detail_description_'+$row_id).val('');
                $('#sale_tax_invoice_detail_product_code_'+$row_id).val('');
                $('#sale_tax_invoice_detail_batch_no_'+$row_id).val('');
                $('#sale_tax_invoice_detail_unit_id_'+$row_id).val('');
                $('#sale_tax_invoice_detail_unit_'+$row_id).val('');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).select2('destroy');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).html('');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#sale_tax_invoice_detail_rate_'+$row_id).val('0.00');
                $('#sale_tax_invoice_detail_product_master_id_'+$row_id).val('');
            }

            $('#sale_tax_invoice_detail_product_id_'+$grid_row).select2({
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

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}


    function Save(){
        if($('#form').valid() == true){
            
            $('.btnSave').attr('disabled','disabled');
            $("#loaderjs").removeClass('hide');
            
            setTimeout(function(){
               
               $('#tblSaleInvoice tbody tr').each(function(sort_order) {
                    var $row_id = $(this).data('row_id');
                    $data = [];
                    $data['row_id'] = $row_id;
                    $data['sort_order'] = sort_order;
                    $data['form_key'] = $('#form_key').val();

                    $(this).children('td').find('input, select, textarea').each(function(){
                        $name = $(this).attr('id').replace('sale_tax_invoice_detail_', '');
                        $name = $name.replace(/_[0-9]+/, '');
                        $data[$name] = $(this).val();
                    });

                    $.ajax({
                        url: $UrlAddRecords,
                        dataType: 'json',
                        type: 'post',
                        async: false,
                        data: $.extend({}, $data), // Convert data array into object
                        mimeType:"multipart/form-data",
                        beforeSend: function() {},
                        complete: function() {},
                        success: function(json) {
                            if(json.success) {
                                console.log( json )
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr.responseText);
                        }
                    });                

                });

                $('#form').submit();
            
            },1000);

        } else {
            $('.btnSave').removeAttr('disabled');
            $("#loaderjs").addClass('hide');
        }
    }