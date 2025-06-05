/**
 * Created by Huzaifa on 9/18/15.
 */

$(document).ready(function(){
    $("#loaderjs").addClass('hide');
});

$(document).ready(function() {
    $('#challan_type_no').trigger('change');
});

$(document).on('change','#challan_type_no, #challan_type_yes',function() {

    var $challan_type = $(this).val();
    $.ajax({
        url: $UrlGetCustomer,
        dataType: 'json',
        type: 'post',
        data: 'challan_type=' + $challan_type+'&partner_id='+$partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#loader').remove();
            $('#partner_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#partner_id').select2('destroy');
                $('#partner_id').html(json.html);
                $('#partner_id').select2({width:'100%'});
                // $('#ref_document_type_id').trigger('change');
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


// $(document).on('change','#partner_type_id', function() {
//    $partner_type_id = $(this).val();
//    var $challan_type = $('#challan_type').val();

//    $.ajax({
//        url: $UrlGetPartner,
//        dataType: 'json',
//        type: 'post',
//        data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
//            $('#partner_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
//        },
//        complete: function() {
//            $('#loader').remove();
//        },
//        success: function(json) {
//            if(json.success)
//            {
//                $('#partner_id').select2('destroy');
//                $('#partner_id').html(json.html);
//                $('#partner_id').select2({width:'100%'});
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

// $(document).on('change','#partner_id', function() {
//    $partner_id = $(this).val();
//    $.ajax({
//        url: $UrlGetCustomerUnit,
//        dataType: 'json',
//        type: 'post',
//        data: 'partner_id=' + $partner_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
$('#loader').remove();
// //            $('#customer_unit_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
//        },
//        complete: function() {
// //            $('#loader').remove();
//        },
//        success: function(json) {
//            if(json.success)
//            {
// //                $('#customer_unit_id').select2('destroy');
// //                $('#customer_unit_id').html(json.html);
// //                $('#customer_unit_id').select2({width:'100%'});
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


$(document).on('change','#ref_document_type_id', function() {

    var $partner_type_id =2;
    $ref_document_type = $(this).val();
    if($partner_id != ''){

    }else{
        $partner_type_id= $('#partner_type_id').val();
        $partner_id = $('#partner_id').val();
    }

//    var     $ref_document_identity = $('#ref_document_identity').val();
    var $data = {
        //'document_currency_id': $document_currency_id,
        'partner_type_id': $partner_type_id,
        'partner_id': $partner_id,
        'ref_document_identity': $ref_document_identity
    };
    console.log($data);

    if($ref_document_type != "" )
    {
        $.ajax({
            url: $UrlGetReferenceDocumentNo,
            dataType: 'json',
            type: 'post',
            data: $data,
            mimeType:"multipart/form-data",
            beforeSend: function() {
                $('#loader').remove();
                $('#ref_document_identity').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
            },
            complete: function() {
                $('#loader').remove();
            },
            success: function(json) {
                if(json.success)
                {
                    $('#ref_document_identity').select2('destroy');
                    $('#ref_document_identity').html(json.html);
                    $('#ref_document_identity').select2({width:'100%'});
                }
                else {
                    alert(json.error);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.responseText);
            }
        })
    }
});


$(document).on('change', '#partner_id', function(){
    document.getElementById('ref_document_type_id').value = '5'
    $('#ref_document_type_id').trigger('change');
    if( $('#ref_document_type_id').val() != '' )
    {
        $('#ref_document_type_id').trigger('change')
    }

    setTimeout(function(){
        console.log($('#ref_document_identity').val())
        if( $('#ref_document_identity').val() != '' )
        {
            $('#ref_document_identity').trigger('change')
        }
    },5000);
})



//$(document).on('click','.btnAddGrid', function() {
function fillData($serial){
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td hidden>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';

    $html += '<td></td>';
    $html += '<td>';
    $html += '<input onchange="getProductBySerialNo(this);" type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][serial_no]" id="delivery_challan_detail_serial_no_'+$grid_row+'" value="'+$serial+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][product_name]" id="delivery_challan_detail_product_name_'+$grid_row+'" value="" readonly/>';
    $html += '<input type="hidden" class="required form-control" name="delivery_challan_details['+$grid_row+'][product_code]" id="delivery_challan_detail_product_code_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" name="delivery_challan_details['+ $grid_row +'][available_stock]"id="delivery_challan_detail_available_stock_'+ $grid_row +'">';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][description]" id="delivery_challan_detail_description_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="delivery_challan_details['+$grid_row+'][product_master_id]" id="delivery_challan_detail_product_master_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="delivery_challan_details['+$grid_row+'][product_id]" id="delivery_challan_detail_product_id_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][batch_no]" id="delivery_challan_detail_batch_no_'+$grid_row+'" value="" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<select onchange="getWarehouseStock(this);" class="required form-control select2" id="delivery_challan_detail_warehouse_id_'+$grid_row+'" name="delivery_challan_details['+$grid_row+'][warehouse_id]" required>';
    $html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse) {
        $html += '<option value="'+$warehouse.warehouse_id+'">'+$warehouse.name+'</option>';
    });
    $html += '</select>';
    $html += '<label for="delivery_challan_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" onchange="calculateRowTotal(this);" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][qty]" id="delivery_challan_detail_qty_'+$grid_row+'" value="1" readonly/>';
    $html += '<input type="hidden" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][available_stock]" id="delivery_challan_detail_available_stock_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" id="delivery_challan_detail_unit_'+$grid_row+'" name="delivery_challan_details['+$grid_row+'][unit]" value="" readonly>';
    $html += '<input type="hidden" class="form-control" id="delivery_challan_detail_unit_id_'+$grid_row+'" name="delivery_challan_details['+$grid_row+'][unit_id]" value="">';
    $html += '<input type="hidden" onchange="calculateRowTotal(this);" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][rate]" id="delivery_challan_detail_rate_'+$grid_row+'" value="0" />';
    $html += '<input type="hidden" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][cog_rate]" id="delivery_challan_detail_cog_rate_'+$grid_row+'" value="0" />';
    $html += '<input type="hidden"  class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][cog_amount]" id="delivery_challan_detail_cog_amount_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][tax_percent]" id="delivery_challan_detail_tax_percent_'+$grid_row+'" value="0" />';
    $html += '<input type="hidden"  class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][tax_amount]" id="delivery_challan_detail_tax_amount_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';

    $('#tblDeliveryChallan tbody').prepend($html);
    Select2ProductJsonDeliveryChallan('#delivery_challan_detail_product_id_'+$grid_row);
    $('#delivery_challan_detail_product_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        $('#delivery_challan_detail_product_code_'+$row_id).val($data['product_code']);
        $('#delivery_challan_detail_unit_id_'+$row_id).val($data['unit_id']);
        $('#delivery_challan_detail_unit_'+$row_id).val($data['unit']);
        $('#delivery_challan_detail_description_'+$row_id).val($data['description']);
    });
    $('#delivery_challan_detail_warehouse_id_'+$grid_row).select2({'width':'100%'});

    $grid_row++;
//});
}
$(document).on('change','#ref_document_identity', function() {
    var $ref_document_identity = $('#ref_document_identity').val();
    var $partner_id = $('#partner_id').val();


    $.ajax({
        url: $UrlGetSaleOrder,
        dataType: 'json',
        type: 'post',
        data: 'ref_document_identity='+$ref_document_identity+'&partner_id='+$partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#loader').remove();
            $('#tblDeliveryChallan').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                //  $('#tblDeliveryChallan tbody').html(json.html);
                $sale_orders = json.sale_orders;
                $arrProducts = json.products;
                console.log(json)
                $('#total_qty').val(json.qty_total);
                $('#po_date').val(json.po_date);
                $('#po_no').val(json.po_no);

                $('#salesman_id').val(json.salesman_id);
                $('#salesman_id').select2({width:'100%'});

                //$('#project_id').val(json.data['project_id']);
                //$('#sub_project_id').html('<option value="'+ json.data['sub_project_id'] +'">'+json.data['project']+' - '+json.data['sub_project']+'</option>').trigger('change');

                $('#customer_unit_id').val(json.customer_unit_id).trigger('change');
                $('.warehouse').each(function(){
                    $(this).select2({'width':'100%'})
                });
            } else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })

    // calculateTotal();

})


function getProductById($obj) {
    $product_id = $($obj).val();
    $partner_id = $('#partner_id').val();
    var $row_id = $($obj).parent().parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductById,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id+'&partner_id=' + $partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#loader').remove();
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-refresh fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                $('#delivery_challan_detail_description_'+$row_id).val(json.product['name']);
                $('#delivery_challan_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#delivery_challan_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#delivery_challan_detail_unit_'+$row_id).val(json.product['unit']);
//                $('#delivery_challan_detail_stock_qty_'+$row_id).val(json.product['stock']['stock_qty']);
//                $('#delivery_challan_detail_cog_rate_'+$row_id).val(json.product['stock']['avg_stock_rate']);
                $('#last_rate').val(json.customer_rate);
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

function getProductByCode($obj) {
    $product_code = $($obj).val();
    $partner_id = $('#partner_id').val();
    var $row_id = $($obj).parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductByCode,
        dataType: 'json',
        type: 'post',
        data: 'product_code=' + $product_code+'&partner_id=' + $partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#loader').remove();
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-refresh fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                console.log(json)
                $('#delivery_challan_detail_description_'+$row_id).val(json.product['name']);
                $('#delivery_challan_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#delivery_challan_detail_unit_'+$row_id).val(json.product['unit']);
                $('#delivery_challan_detail_product_id_'+$row_id).select2('destroy');
//                $('#delivery_challan_detail_product_id_'+$row_id).val(json.product['product_id']);
                $('#delivery_challan_detail_product_id_'+$row_id).html('<option selected="selected" value="'+json.product['product_id']+'">'+json.product['product_code']+ ' -( '+json.product['name']+ ' )' +'</option>');
                $('#delivery_challan_detail_product_id_'+$row_id).select2({width:'100%'});
//                $('#delivery_challan_detail_stock_qty_'+$row_id).val(json.product['stock']['stock_qty']);
//                $('#delivery_challan_detail_cog_rate_'+$row_id).val(json.product['stock']['avg_stock_rate']);
                $('#last_rate').val(json.customer_rate);
            }
            else {
                alert(json.error);
                $('#delivery_challan_detail_description_'+$row_id).val('');
                $('#delivery_challan_detail_unit_id_'+$row_id).val('');
                $('#delivery_challan_detail_unit_'+$row_id).val('');
                $('#delivery_challan_detail_product_id_'+$row_id).select2('destroy');
                $('#delivery_challan_detail_product_id_'+$row_id).val('');
                $('#delivery_challan_detail_product_id_'+$row_id).select2({width:'100%'});
//                $('#delivery_challan_detail_stock_qty_'+$row_id).val('0');
//                $('#delivery_challan_detail_cog_rate_'+$row_id).val('0.00');
            }

            $('#delivery_challan_detail_product_id_'+$row_id).select2({
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
            //$('#delivery_challan_detail_product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#delivery_challan_detail_product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                console.log($row_id);
                $('#delivery_challan_detail_description_'+$row_id).val(json.product['name']);
                $('#delivery_challan_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#delivery_challan_detail_batch_no_'+$row_id).val(json.product['batch_no']);
                $('#delivery_challan_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#delivery_challan_detail_unit_'+$row_id).val(json.product['unit']);
                $('#delivery_challan_detail_product_id_'+$row_id).select2('destroy');
                $('#delivery_challan_detail_product_id_'+$row_id).html('<option value="'+ json.product['product_id'] +'">'+ json.product['name'] +'</option>');
                $('#delivery_challan_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#delivery_challan_detail_product_master_id_'+$row_id).val(json.product['product_master_id']);
                $('#delivery_challan_detail_rate_'+$row_id).val(json.product['cost_price']);

                RecordCheck();
            }
            else {
                alert(json.error);
                $('#delivery_challan_detail_description_'+$row_id).val('');
                $('#delivery_challan_detail_product_code_'+$row_id).val('');
                $('#delivery_challan_detail_batch_no_'+$row_id).val('');
                $('#delivery_challan_detail_unit_id_'+$row_id).val('');
                $('#delivery_challan_detail_unit_'+$row_id).val('');
                $('#delivery_challan_detail_product_id_'+$row_id).select2('destroy');
                $('#delivery_challan_detail_product_id_'+$row_id).html('');
                $('#delivery_challan_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#delivery_challan_detail_product_master_id_'+$row_id).val('');
                $('#delivery_challan_detail_rate_'+$row_id).val('0.00');
            }

            $('#delivery_challan_detail_product_id_'+$grid_row).select2({
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


function setProductInformation($obj) {
    var $data = $($obj).data();
    var $row_id = $('#'+$data['element']).parent().parent().parent().data('row_id');
    $('#_modal').modal('hide');
    $('#delivery_challan_detail_product_code_'+$row_id).val($data['product_code']);
    $('#delivery_challan_detail_unit_id_'+$row_id).val($data['unit_id']);
    $('#delivery_challan_detail_unit_'+$row_id).val($data['unit']);
//    $('#delivery_challan_detail_stock_qty_'+$row_id).val($data['stock_qty']);
//    $('#delivery_challan_detail_cog_rate_'+$row_id).val($data['avg_stock_rate']);
    $('#delivery_challan_detail_description_'+$row_id).val($data['name']);
    $('#delivery_challan_detail_product_id_'+$row_id).select2('destroy');
    //$('#delivery_challan_detail_product_id_'+$row_id).val($data['product_id']);
    $('#delivery_challan_detail_product_id_'+$row_id).html('<option selected="selected" value="'+$data['product_id']+'">'+$data['product_code']+ ' -( '+$data['name']+ ' )' +'</option>');
    $('#delivery_challan_detail_product_id_'+$row_id).select2({width: '100%'});

    $('#delivery_challan_detail_product_id_'+$row_id).select2({
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

}

$('[name="document_date"]').change(function(){
    $('#tblDeliveryChallan tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $('#delivery_challan_detail_warehouse_id_'+$row_id).trigger('change');
    })
});

function getWarehouseStock($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $data = {
        warehouse_id: $($obj).val(),
        product_id: $('#delivery_challan_detail_product_id_'+$row_id).val(),
        document_date : $('[name="document_date"]').val(),
        document_identity : $('[name="document_identity"]').val()
    };

    var $change_qty = parseFloat($('#delivery_challan_detail_qty_'+$row_id).val()) || 0;

    $.ajax({
        url: $UrlGetWarehouseStock,
        dataType: 'json',
        type: 'post',
        data: $data,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#loader').remove();
            $('#partner_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {

                $available_stock = parseFloat(json.stock['stock_qty']) || 0;

                if(($change_qty > $available_stock) && $allow_out_of_stock == 0)
                {
                    alert('Stock Not Available');
                    $('#delivery_challan_detail_qty_'+$row_id).val(0);
                }
                $('#delivery_challan_detail_available_stock_'+$row_id).val(parseFloat(json.stock['stock_qty']));
                $('#delivery_challan_detail_cog_rate_'+$row_id).val(rDecimal((parseFloat(json.stock['avg_stock_rate'])||0),2));
                var $cog_amount = ((parseFloat($change_qty)||0)*(parseFloat(json.stock['avg_stock_rate'])||0));
                $('#delivery_challan_detail_cog_amount_'+$row_id).val(rDecimal($cog_amount,2));
                $('#delivery_challan_detail_qty_'+$row_id).trigger('change');
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    });
};

function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}


$(document).on('click','.btnRemoveGrid', function() {


//    var $row_id = $('#tblDeliveryChallan tbody tr').data('row_id');
//    alert($row_id,true);
//    $('#grid_row_'+$row_id).remove();
    $(this).parent().parent().remove();
    calculateTotal();
});


function calculateRowTotal($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $available_stock = parseFloat($('#delivery_challan_detail_available_stock_' + $row_id).val());
    var $qty = parseFloat($('#delivery_challan_detail_qty_' + $row_id).val());
    if( ($qty > $available_stock) && $allow_out_of_stock == 0 ) {
        alert('Stock Not Available');
        $('#delivery_challan_detail_qty_' + $row_id).val(0);
    } else {
        var $rate = parseFloat($('#delivery_challan_detail_rate_' + $row_id).val());
        var $cog_rate = parseFloat($('#delivery_challan_detail_cog_rate_' + $row_id).val());
        var $cogs_amount = roundUpto($qty * $cog_rate,2);
        var $amount = roundUpto($qty * $rate,2);

        $amount = $amount || 0.00;

        $('#delivery_challan_detail_cog_amount_' + $row_id).val($cogs_amount);

        calculateTotal();
    }

}

function fillGrid($obj) {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a title="Remove" class="btnRemoveGrid btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td hidden>';
    $html += '<input type="text" name="delivery_challan_details['+$grid_row+'][ref_document_type_id]" id="delivery_challan_detail_ref_document_type_id_'+$grid_row+'" value="'+$obj['ref_document_type_id']+'"/>';
    $html += '<input type="hidden" class="form-control" name="delivery_challan_details['+$grid_row+'][ref_document_type_id]" id="delivery_challan_detail_ref_document_type_id_'+$grid_row+'" value="'+$obj['ref_document_type_id']+'" readonly/>';
    $html += '<input type="hidden" class="form-control" name="delivery_challan_details['+$grid_row+'][ref_document_identity]" id="delivery_challan_detail_document_identity_'+$grid_row+'" value="'+$obj['ref_document_identity']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][product_code]" id="delivery_challan_detail_product_code_'+$grid_row+'" value="'+$obj['product_code']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control" name="delivery_challan_details['+$grid_row+'][product_id]" id="delivery_challan_detail_product_id_'+$grid_row+'" value="'+$obj['product_id']+'" readonly/>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][product_name]" id="delivery_challan_detail_product_name_'+$grid_row+'" value="'+$obj['product_name']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][description]" id="delivery_challan_detail_description_'+$grid_row+'" value="'+$obj['description']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control" name="delivery_challan_details['+$grid_row+'][unit_id]" id="delivery_challan_detail_unit_id_'+$grid_row+'" value="'+$obj['unit_id']+'" readonly/>';
    $html += '<input type="text" class="form-control" name="delivery_challan_details['+$grid_row+'][unit]" id="delivery_challan_detail_unit_'+$grid_row+'" value="'+$obj['unit']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][qty]" id="delivery_challan_detail_qty_'+$grid_row+'" value="0" />';
    $html += '<input type="hidden" class="form-control " name="delivery_challan_details['+$grid_row+'][utilized_qty]" id="delivery_challan_detail_utilized_qty_'+$grid_row+'" value="'+$obj['balanced_qty']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][rate]" id="delivery_challan_detail_rate_'+$grid_row+'" value="'+$obj['rate']+'" readonly />';
    $html += '<input type="hidden" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][rate]" id="delivery_challan_detail_cog_rate_'+$grid_row+'" value="'+$obj['cog_rate']+'" readonly />';
    $html += '<input type="text" class="form-control fPDecimal" name="delivery_challan_details['+$grid_row+'][cog_amount]" id="delivery_challan_detail_cog_amount_'+$grid_row+'" value="'+$obj['cog_amount']+'" readonly="true" />';
    $html += '</td>';
    $html += '<td style="width: 3%;"></td>';
    $html += '</tr>';

    $('#tblDeliveryChallan tbody').prepend($html);
    $grid_row++;

}

function calculateTotal() {
    var $total_qty = 0;
    var $total_amount = 0;

    $('#tblDeliveryChallan tbody tr').each(function() {

        var $row_id = $(this).data('row_id');
        var $qty = parseFloat($('#delivery_challan_detail_qty_' + $row_id).val())||0;
        var $amount = parseFloat($('#delivery_challan_detail_cog_amount_' + $row_id).val())||0;

        $total_qty += parseFloat($qty);
        $total_amount += parseFloat($amount);
    })

    console.log($total_qty, $total_amount);
    $('#total_qty').val($total_qty);
    $('#total_amount').val($total_amount);
}

$('#serial_no').on('keypress', function(e){

    if(e.keyCode==13){
        GetDocumentDetails();
        $(this).val('');
    }

});


function GetDocumentDetails(){

    if( $('#ref_document_identity').val() == '' )
    {
        alert('Select Ref Document first.')
        $('#ref_document_identity').select2('open')
        return;
    }

    var $serialno = $('#serial_no').val();
    var $wid = $('#warehouse_id').val();

    $.ajax({
        url: $UrlGetProductBySerialNo,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $serialno+'&warehouse_id='+$wid,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            //$('#delivery_challan_detail_product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#delivery_challan_detail_product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {

                if(typeof $arrProducts[json.product.product_master_id] == 'undefined'){
                    alert('Product not in Sale Order');
                    return;
                }


                var $res = 0;
                $html = '';
                $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
                $html += '<td>';
                //$html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
                $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';

                $html += '<td hidden></td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" id="delivery_challan_detail_serial_no_'+$grid_row+'" value="'+$serialno+'" readonly/>';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" id="delivery_challan_detail_product_name_'+$grid_row+'" value="'+json.product['product_code']+ '-'+ json.product['brand'] +'-'+json.product['model']+'-'+json.product['name']+'" readonly/>';
                $html += '<input type="hidden" class="required form-control" id="delivery_challan_detail_product_code_'+$grid_row+'" value="'+json.product['product_code'] +'" />';
                $html += '<input type="hidden" id="delivery_challan_detail_available_stock_'+ $grid_row +'">';
                $html += '</td>';
                $html += '<td  style="min-width: 300px">';
                $html += '<textarea type="text"  class="form-control" rows="4" col="6" id="delivery_challan_detail_description_'+$grid_row+'">'+json.product['product_code']+ '-'+ json.product['brand'] +'-'+json.product['model']+'-'+json.product['name']+'</textarea>';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" id="delivery_challan_detail_batch_no_'+$grid_row+'" value="'+json.product['batch_no']+'" readonly/>';
                $html += '<input type="hidden" class="form-control" id="delivery_challan_detail_product_master_id_'+$grid_row+'" value="'+json.product['product_master_id']+'" />';
                $html += '<input type="hidden" class="form-control" id="delivery_challan_detail_product_id_'+$grid_row+'" value="'+json.product['product_id']+'" />';
                $html += '</td>';
                $html += '<td>';
                $warehouses.forEach(function($warehouse) {
                    if($warehouse.warehouse_id == $wid){
                        $html += '<input type="hidden" id="delivery_challan_detail_warehouse_id_'+ $grid_row +'" value="'+$warehouse.warehouse_id+'" />';
                        $html += '<input id="delivery_challan_detail_warehouse_name_'+ $grid_row +'" value="'+$warehouse.name+'" readonly class="form-control"/>';
                    }
                });
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" onchange="calculateRowTotal(this);" class="form-control fPDecimal" id="delivery_challan_detail_qty_'+$grid_row+'" value="1" readonly/>';
                $html += '<input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_available_stock_'+$grid_row+'" value="" />';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" id="delivery_challan_detail_unit_'+$grid_row+'" value="'+json.product['unit']+'" readonly>';
                $html += '<input type="hidden" class="form-control" id="delivery_challan_detail_unit_id_'+$grid_row+'" value="'+json.product['unit_id']+'">';
                $html += '<input type="hidden" onchange="calculateRowTotal(this);" class="form-control fPDecimal" id="delivery_challan_detail_rate_'+$grid_row+'" value="'+json.product['cost_price']+'" />';
                $html += '<input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_cog_rate_'+$grid_row+'" value="0" />';
                $html += '<input type="hidden"  class="form-control fPDecimal" id="delivery_challan_detail_cog_amount_'+$grid_row+'" value="" />';
                $html += '<input type="hidden" class="form-control fPDecimal" id="delivery_challan_detail_tax_percent_'+$grid_row+'" value="0" />';
                $html += '<input type="hidden"  class="form-control fPDecimal" id="delivery_challan_detail_tax_amount_'+$grid_row+'" value="" />';
                $html += '</td>';
                $html += '<td>';
                //$html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
                $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
                $html += '</tr>';

//                //Check Work //
//                if (typeof itemsCheckWithExpiry[json.product['product_master_id']] === 'undefined') {
//                    itemsCheckWithExpiry[json.product['product_master_id']] = {
//                        qty: 1
//                    }
//                } else {
//                    var $quantity = itemsCheckWithExpiry[json.product['product_master_id']]['qty'];
//                    $quantity = parseFloat($quantity) + parseFloat(1);
//                    itemsCheckWithExpiry[json.product['product_master_id']]['qty'] = $quantity;
//                }
//
//                $.each(itemsCheckWithExpiry, function (index, value) {
//                    console.log('in',index, value);
//                    var p_qty = $arrProducts[json.product['product_master_id']];
//                    if(index == json.product['product_master_id']){
//                    if (parseFloat(value.qty) > parseFloat(p_qty)) {
//                        alert("Qty exceed ");
//                        $res = 1;
//                    }}
//                });

                var test =  CheckResult(json.product['product_master_id']);
                if(test == 1)
                {
                    return;
                }
                                //End Work //
                $('#tblDeliveryChallan tbody').prepend($html);

                $grid_row++;

                calculateTotal();
            } else {
                alert('Stock Not Available');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

function CheckResult($Pid) {

    var $sr = $('#serial_no').val();
    var itemsCheckWithExpiry = {};
    var res =0;
    var $id = 0;

    console.log( $arrProducts )

    $('#tblDeliveryChallan tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        var $product_master_id = $('#delivery_challan_detail_product_master_id_' + $row_id).val();
        var $serialno = $('#delivery_challan_detail_serial_no_' + $row_id).val();

        console.log('sR',$sr,' ser',$serialno);
        if($serialno == $sr){
            res = 1;
            alert("Serial No Duplicate");
        }
        // for budget //
        if (typeof itemsCheckWithExpiry[$product_master_id] === 'undefined') {
            itemsCheckWithExpiry[$product_master_id] = {
                row_id : $row_id,
                qty: 1
            }
        } else {
            var $quantity = itemsCheckWithExpiry[$product_master_id]['qty'];
            $quantity = parseFloat($quantity) + parseFloat(1);
            itemsCheckWithExpiry[$product_master_id]['qty'] = $quantity;
        }
        // end
    })
    console.log('items',itemsCheckWithExpiry);
    $.each(itemsCheckWithExpiry, function (index, value) {
        console.log('in',index, value);
        var p_qty = $arrProducts[$Pid];
        if(index == $Pid){
            if (parseFloat(value.qty) >= parseFloat(p_qty)) {
                alert("Qty exceed");
                res = 1;
            }
        }
    });
    return  res;
}


    function Save(){
        if($('#form').valid() == true){
            
            $('.btnSave').attr('disabled','disabled');
            $("#loaderjs").removeClass('hide');
            
            setTimeout(function(){
                $('#tblDeliveryChallan tbody tr').each(function(sort_order) {
                    var $row_id = $(this).data('row_id');
                    $data = [];
                    $data['row_id'] = $row_id;
                    $data['sort_order'] = sort_order;
                    $data['form_key'] = $('#form_key').val();

                    $(this).children('td').find('input, select, textarea').each(function(){
                        $name = $(this).attr('id').replace('delivery_challan_detail_', '');
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