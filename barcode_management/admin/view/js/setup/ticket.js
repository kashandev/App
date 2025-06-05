    /**
 * Created by Huzaifa on 9/18/15.
 */

$(document).on('change','#retailer_id', function() {
    $retailer_id = $(this).val();
    $.ajax({
        url: $UrlGetRetailerContact,
        dataType: 'json',
        type: 'post',
        data: 'retailer_id=' + $retailer_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#retailer_contact_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                //$('#retailer_contact_id').select2('destroy');
                $('#retailer_contact_id').html(json.retailer_contact);
                //$('#retailer_contact_id').select2({width:'100%'});

                //$('#retailer_contact_id').html(json.html).trigger('change');
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


$(document).on('click','.btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a title="Remove" class="btnRemoveGrid btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input onchange="getProductByCode(this);" type="text" class="form-control" name="purchase_order_details['+$grid_row+'][product_code]" id="purchase_order_detail_product_code_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<div class="input-group">';
    $html += '<select style="min-width: 100px;" onchange="getProductById(this);" class="form-control select2 product" id="purchase_order_detail_product_id_'+$grid_row+'" name="purchase_order_details['+$grid_row+'][product_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<span class="input-group-btn ">';
    $html += '<button class="btn btn-default btn-flat QSearchProduct" id="QSearchProduct" type="button" data-element="purchase_order_detail_product_id_'+$grid_row+'" data-field="product_id">';
    $html += '<i class="fa fa-search"></i>';
    $html += '</button>';
    $html += '</span>';
    $html += '</div>';
    $html += '</td>';
    $html += '<td>';
    $html += '<select style="min-width: 300px;" class="form-control select2 unit_id" id="purchase_order_detail_unit_id_'+$grid_row+'" name="purchase_order_details['+$grid_row+'][unit_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<input type="hidden" class="form-control" name="purchase_order_details['+$grid_row+'][conversion_qty]" id="purchase_order_detail_conversion_qty_'+$grid_row+'" value="0.00" />';
    $html += '<input type="hidden" class="form-control" name="purchase_order_details['+$grid_row+'][base_unit_id]" id="purchase_order_detail_base_unit_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="purchase_order_details['+$grid_row+'][base_qty]" id="purchase_order_detail_base_qty_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][qty]" id="purchase_order_detail_qty_'+$grid_row+'" value="1" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][rate]" id="purchase_order_detail_rate_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][wht_percent]" id="purchase_order_detail_wht_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][additional_rate]" id="purchase_order_detail_additional_rate_'+$grid_row+'" value="" readonly />';
    $html += '<input type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][net_rate]" id="purchase_order_detail_net_rate_'+$grid_row+'" value="" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][wht_amount]" id="purchase_order_detail_wht_amount_'+$grid_row+'" value="" readonly />';
    $html += '<input type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][amount]" id="purchase_order_detail_amount_'+$grid_row+'" value="" readonly="true" />';
    $html += '</td>';
    $html += '<td style="width: 3%;"><a class="btnAddGrid btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>';
    $html += '</tr>';


    if($(this).parent().parent().data('row_id')=='H') {
        $('#tblPurchaseOrder tbody').prepend($html);
    } else {
        $(this).parent().parent().after($html);
    }
    //$('#purchase_order_detail_product_id_'+$grid_row).select2({width: '100%'});
    $('#purchase_order_detail_product_id_'+$grid_row).select2({
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
        minimumInputLength: 5,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
    });

    $('#purchase_order_detail_unit_id_'+$grid_row).select2({width: '100%'});

    $('#purchase_order_detail_product_code_'+$grid_row).focus();
    $grid_row++;

});

