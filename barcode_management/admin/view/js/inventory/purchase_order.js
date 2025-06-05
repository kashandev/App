/**
 * Created by Huzaifa on 9/18/15.
 */
$(document).on('change','#partner_type_id', function() {
    $partner_type_id = $(this).val();
    $.ajax({
        url: $UrlGetPartner,
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
            if(json.success)
            {
                $('#partner_id').select2('destroy');
                $('#partner_id').html(json.html);
                $('#partner_id').select2({width:'100%'});
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
$(document).on('click','#btnAddGrid', function() {
    $html = '';
   // var $size = $('#tblPurchaseOrderDetail >tbody >tr').length;
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'" class="removerows closerow">';
    $html += '<td><a  title="Remove" class="btn btn-xs btn-danger remove" data-remove="'+$grid_row+'"  data-row_id="'+$grid_row+'" href="javascript:void(0);"><i class="fa fa-times"></i></a><a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>';
    $html +='<td class="row-index increment clearfix">';
    $html += '<p>';
    $html +=  parseInt($grid_row)+1;
    $html += '</p>';
    $html += '</td>';
    $html += '<td style="min-width: 250px;">';
    $html += '<input type="hidden" class="form-control" name="purchase_order_details['+$grid_row+'][product_code]" id="purchase_order_detail_product_code_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" id="purchase_order_detail_type_of_material_'+$grid_row+'" value="" />';
    $html += '<select class="required form-control Select2ProductMasterPurchaseOrder required purchase_order_detail_product_id_'+$grid_row+'" id="purchase_order_detail_product_id_'+$grid_row+'" name="purchase_order_details['+$grid_row+'][product_id]" required>';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<label for="purchase_order_detail_product_id_'+$grid_row+'"  class="error" style="display:none"></label>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control required purchase_order_detail_unit_'+$grid_row+'" name="purchase_order_details['+$grid_row+'][unit]" id="purchase_order_detail_unit_'+$grid_row+'" value="" readonly="true" required/>';
    $html += '<input type="hidden" class="required purchase_order_detail_unit_id_'+$grid_row+'" name="purchase_order_details['+$grid_row+'][unit_id]" id="purchase_order_detail_unit_id_'+$grid_row+'" value="" required/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][qty]" id="purchase_order_detail_qty_'+$grid_row+'"  value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][rate]" id="purchase_order_detail_rate_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][amount]" id="purchase_order_detail_amount_'+$grid_row+'" value=""  readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" onchange="calculateTaxAmount(this);" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][tax_percent]" id="purchase_order_detail_tax_percent_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" onchange="calculateTaxPercent(this);" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][tax_amount]" id="purchase_order_detail_tax_amount_'+$grid_row+'"  readonly value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control fPDecimal" name="purchase_order_details['+$grid_row+'][net_amount]" id="purchase_order_detail_net_amount_'+$grid_row+'" value="" readonly/>';
    $html += '</td>';
    $html += '<td><a  title="Remove" data-remove="'+$grid_row+'" class="btn btn-xs btn-danger remove" href="javascript:void(0);"><i class="fa fa-times"></i></a><a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a></td>';
    $html += '</tr>';
    $('#tblPurchaseOrderDetail tbody:last').append($html);
    setLogics();
    $grid_row++;
});
function setLogics(){
  Setfiledformatnew();
    Select2SubProject('#purchase_order_detail_sub_project_id_'+$grid_row);
    $('#purchase_order_detail_sub_project_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        $('#purchase_order_detail_project_id_'+$row_id).val($data['project_id']);
    });
    Select2ProductMasterPurchaseOrder('.purchase_order_detail_product_id_'+$grid_row);
    // return false;
     $('.purchase_order_detail_product_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        console.log($data);
        $('#purchase_order_detail_product_code_'+$row_id).val($data['product_code']);
        $('#purchase_order_detail_unit_'+$row_id).val($data['unit']);
        $('#purchase_order_detail_unit_id_'+$row_id).val($data['unit_id']);
        var $qty = parseFloat($('#purchase_order_detail_qty_'+$row_id).val())||0;
    });
}


 $(document).on('click','.remove',function () {
     id  = $(this).attr('data-remove');
          $(this).parent().parent().remove().attr('data-remove', id);
          // console.log(a);
        $('#tblPurchaseOrderDetail tr').each(function(index) {
          $(this).find('td.increment p').html(index);
    });
 });

function getProductById($obj) {
    $product_id = $($obj).val();
    var $row_id = $($obj).parent().parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductById,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                $('#purchase_order_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#purchase_order_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#purchase_order_detail_unit_'+$row_id).val(json.product['unit']);
                $('#purchase_order_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('.purchase_order_detail_product_id_'+$row_id).html('<option selected="selected" value="'+json.product['product_id']+'">'+json.product['name']+'</option>');
            } else {
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
    var $row_id = $($obj).parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductByCode,
        dataType: 'json',
        type: 'post',
        data: 'product_code=' + $product_code,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                console.log($row_id);
                $('#purchase_order_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#purchase_order_detail_unit_'+$row_id).val(json.product['unit']);
                $('.purchase_order_detail_product_id_'+$row_id).select2('destroy');
                // $('#purchase_order_detail_product_id_'+$row_id).val(json.product['product_id']);
                $('.purchase_order_detail_product_id_'+$row_id).html('<option selected="selected" value="'+json.product['product_id']+'">'+json.product['name']+'</option>');
                $('.purchase_order_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#purchase_order_detail_rate_'+$row_id).val(json.product['cost_price']);
            }
            else {
                alert(json.error);
                $('#purchase_order_detail_unit_id_'+$row_id).val('');
                $('#purchase_order_detail_unit_'+$row_id).val('');
                $('.purchase_order_detail_product_id_'+$row_id).select2('destroy');
                $('.purchase_order_detail_product_id_'+$row_id).val('');
                $('.purchase_order_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#purchase_order_detail_rate_'+$row_id).val('0.00');
            }
            $('.purchase_order_detail_product_id_'+$row_id).select2({
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
    a =  $('#purchase_order_detail_product_code_'+$row_id).val($data['product_code']);
    // console.log(a)
    $('#purchase_order_detail_unit_id_'+$row_id).val($data['unit_id']);
    $('#purchase_order_detail_unit_'+$row_id).val($data['unit']);
    $('#purchase_order_detail_rate_'+$row_id).val($data['cost_price']);
    $('.purchase_order_detail_product_id_'+$row_id).select2('destroy');
    // $('#purchase_order_detail_product_id_'+$row_id).val($data['product_id']);
    // $('#purchase_order_detail_product_id_'+$row_id).select2({width: '100%'});
    $('.purchase_order_detail_product_id_'+$row_id).html('<option selected="selected" value="'+$data['product_id']+'">'+$data['name']+'</option>');
    $('.purchase_order_detail_product_id_'+$row_id).select2({
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


function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    alert($row_id);
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_percent = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#purchase_order_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_amount = rDecimal($amount * $tax_percent / 100,2);

    $('#purchase_order_detail_tax_amount_' + $row_id).val($tax_amount);
    calculateRowTotal($obj);
}

function calculateTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_amount = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#purchase_order_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_percent = rDecimal($tax_amount / $amount * 100,2);

    $('#purchase_order_detail_tax_percent_' + $row_id).val($tax_percent);
    calculateRowTotal($obj);
}


function calculateRowTotal($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    console.log($row_id);
    var $qty = parseFloat($('#purchase_order_detail_qty_' + $row_id).val())||0;
    var $base_calc_weight = parseFloat($('#purchase_order_detail_base_calc_weight_' + $row_id).val())||0;
    var $rate = parseFloat($('#purchase_order_detail_rate_' + $row_id).val())||0;
    var $tax_amount = parseFloat($('#purchase_order_detail_tax_amount_' + $row_id).val())||0;
    var $type_of_material = $('#purchase_order_detail_type_of_material_'+$row_id).val();
    var $calc_weight =  ($qty*$base_calc_weight);
    $('#purchase_order_detail_calc_weight_' + $row_id).val(rDecimal($calc_weight,4));

    // Qty * Rate
    var $amount = ($qty*$rate);

    if( $type_of_material.toLowerCase() == 'sheet' )
    {
        // Weight * Rate
        $amount = ($calc_weight*$rate);
    }

    var $tax_percent = parseFloat($('#purchase_order_detail_tax_percent_'+ $row_id).val() || 0);
    var $tax_amount = rDecimal($amount * $tax_percent / 100,2);

    $('#purchase_order_detail_tax_amount_'+ $row_id).val(rDecimal($tax_amount,2));

    var $net_amount = ($amount+(parseFloat($tax_amount)||0));

    $('#purchase_order_detail_amount_' + $row_id).val(rDecimal($amount,2));
    $('#purchase_order_detail_net_amount_' + $row_id).val(rDecimal($net_amount,2));
    calculateTotal();
}

function calculateTotal() {
    var $total_amount = 0;
    var $total_tax_amount = 0;
    var $total_net_amount = 0;
    $('#tblPurchaseOrderDetail tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $amount = parseFloat($('#purchase_order_detail_amount_' + $row_id).val())||0;
        $tax_amount = parseFloat($('#purchase_order_detail_tax_amount_' + $row_id).val())||0;
        $net_amount = parseFloat($('#purchase_order_detail_net_amount_' + $row_id).val())||0;

        $total_amount     += $amount;
        $total_tax_amount += $tax_amount;
        $total_net_amount += $net_amount;
    })

    $('#total_amount').val(rDecimal($total_amount,2));
    $('#total_tax_amount').val(rDecimal($total_tax_amount,2));
    $('#total_net_amount').val(rDecimal($total_net_amount,2));

    var $conversion_rate = parseFloat($('#conversion_rate').val())||0;
    var $converted_total_amount = ($total_amount*$conversion_rate);
    var $converted_amount = ($total_net_amount*$conversion_rate);
    $('#converted_total_amount').val(rDecimal($converted_total_amount,2))
    $('#converted_amount').val(rDecimal($converted_amount,2));
}


// Convertion
$('#conversion_rate').on('change', function(){
    calculateTotal();
});