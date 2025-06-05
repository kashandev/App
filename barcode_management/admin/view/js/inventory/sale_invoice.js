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
            $('#partner_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
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

$(document).on('click','#addContainer', function() {
    var $data = {
        container_no : $('#container_no option:selected').val()
    };

    var $details = [];
    $.ajax({
        url: $UrlGetContainerProducts,
        dataType: 'json',
        type: 'post',
        data: $data,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#addContainer').html('<i id="loader" class="fa fa-refresh fa-spin"></i>');
        },
        complete: function() {
            $('#addContainer').html('<i class="fa fa-plus"></i>');
        },
        success: function(json) {
            if(json.success)
            {
                $details = json['details'];
                for($i=0;$i<$details.length;$i++) {
                    fillGrid($details[$i]);
                }
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

function fillGrid($obj) {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control" name="sale_invoice_details['+$grid_row+'][warehouse_id]" id="sale_invoice_detail_warehouse_id_'+$grid_row+'" value="'+$obj['warehouse_id']+'" />';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][warehouse_name]" id="sale_invoice_detail_warehouse_name_'+$grid_row+'" value="'+$obj['warehouse_name']+'" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][product_code]" id="sale_invoice_detail_product_code_'+$grid_row+'" value="'+$obj['product_code']+'" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control" name="sale_invoice_details['+$grid_row+'][product_id]" id="sale_invoice_detail_product_id_'+$grid_row+'" value="'+$obj['product_id']+'" />';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][product_name]" id="sale_invoice_detail_product_name_'+$grid_row+'" value="'+$obj['product_name']+'" readonly style="width: 300px;" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][cubic_meter]" id="sale_invoice_detail_cubic_meter_'+$grid_row+'" value="'+$obj['cubic_meter']+'" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][cubic_feet]" id="sale_invoice_detail_cubic_feet_'+$grid_row+'" value="'+$obj['cubic_feet']+'" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][container_no]" id="sale_invoice_detail_container_no_'+$grid_row+'" value="'+$obj['container_no']+'" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][batch_no]" id="sale_invoice_detail_batch_no_'+$grid_row+'" value="'+$obj['batch_no']+'" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" class="form-control" name="sale_invoice_details['+$grid_row+'][unit_id]" id="sale_invoice_detail_unit_id_'+$grid_row+'" value="'+$obj['base_unit_id']+'" />';
    $html += '<input onchange="calculateAmount(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][qty]" id="sale_invoice_detail_qty_'+$grid_row+'" value="'+$obj['balance_qty']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][total_cubic_meter]" id="sale_invoice_detail_total_cubic_meter_'+$grid_row+'" value="'+$obj['total_cubic_meter']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="sale_invoice_details['+$grid_row+'][total_cubic_feet]" id="sale_invoice_detail_total_cubic_feet_'+$grid_row+'" value="'+$obj['total_cubic_feet']+'" readonly/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateAmount(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][rate]" id="sale_invoice_detail_rate_'+$grid_row+'" value="'+$obj['sale_price']+'" />';
    $html += '<input type="hidden" class="form-control" name="sale_invoice_details['+$grid_row+'][cog_rate]" id="sale_invoice_detail_cog_rate_'+$grid_row+'" value="'+$obj['avg_cog_rate']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][amount]" id="sale_invoice_detail_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true" />';
    $html += '<input type="hidden" class="form-control" name="sale_invoice_details['+$grid_row+'][cog_amount]" id="sale_invoice_detail_cog_amount_'+$grid_row+'" value="'+$obj['balance_amount']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][discount_percent]" id="sale_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][discount_amount]" id="sale_invoice_detail_discount_amount_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][gross_amount]" id="sale_invoice_detail_gross_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true"/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][tax_percent]" id="sale_invoice_detail_tax_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][tax_amount]" id="sale_invoice_detail_tax_amount_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][total_amount]" id="sale_invoice_detail_total_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_invoice_details['+$grid_row+'][remarks]" id="sale_invoice_detail_remarks_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';

    $('#tblSaleInvoice tbody').prepend($html);
    $('#sale_invoice_detail_qty_'+$grid_row).trigger('change');
    $grid_row++;
}

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
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-refresh fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success) {
                $('#sale_invoice_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#sale_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#sale_invoice_detail_cubic_meter_'+$row_id).val(json.product['cubic_meter']);
                $('#sale_invoice_detail_cubic_feet_'+$row_id).val(json.product['cubic_feet']);
                $('#sale_invoice_detail_rate_'+$row_id).val(json.product['sale_price']);
                $('#sale_invoice_detail_cog_rate_'+$row_id).val(json.product['stock']['avg_stock_rate']);

                $('#sale_invoice_detail_rate_'+$row_id).trigger('change');
                $('#sale_invoice_detail_discount_percent_'+$row_id).trigger('change');
                $('#sale_invoice_detail_tax_percent_'+$row_id).trigger('change');
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
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-refresh fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                $('#sale_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#sale_invoice_detail_unit_'+$row_id).val(json.product['unit']);
                $('#sale_invoice_detail_product_id_'+$row_id).select2('destroy');
                $('#sale_invoice_detail_product_id_'+$row_id).val(json.product['product_id']);
                $('#sale_invoice_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#sale_invoice_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('#sale_invoice_detail_cubic_meter_'+$row_id).val(json.product['cubic_meter']);
                $('#sale_invoice_detail_cubic_feet_'+$row_id).val(json.product['cubic_feet']);

                $('#sale_invoice_detail_rate_'+$row_id).trigger('change');
                $('#sale_invoice_detail_discount_percent_'+$row_id).trigger('change');
                $('#sale_invoice_detail_tax_percent_'+$row_id).trigger('change');
            } else {
                alert(json.error);
                $('#sale_invoice_detail_unit_id_'+$row_id).val('');
                $('#sale_invoice_detail_unit_'+$row_id).val('');
                $('#sale_invoice_detail_product_id_'+$row_id).select2('destroy');
                $('#sale_invoice_detail_product_id_'+$row_id).val('');
                $('#sale_invoice_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#sale_invoice_detail_rate_'+$row_id).val('0.00');
            }
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
    $('#sale_invoice_detail_product_code_'+$row_id).val($data['product_code']);
    $('#sale_invoice_detail_unit_id_'+$row_id).val($data['unit_id']);
    $('#sale_invoice_detail_unit_'+$row_id).val($data['unit']);
    $('#sale_invoice_detail_rate_'+$row_id).val($data['cost_price']);
    $('#sale_invoice_detail_product_id_'+$row_id).select2('destroy');
    $('#sale_invoice_detail_product_id_'+$row_id).val($data['product_id']);
    $('#sale_invoice_detail_product_id_'+$row_id).select2({width: '100%'});
}

function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $cubic_meter = parseFloat($('#sale_invoice_detail_cubic_meter_' + $row_id).val()) || 0.00;
    var $cubic_feet = parseFloat($('#sale_invoice_detail_cubic_feet_' + $row_id).val()) || 0.00;
    var $qty = parseFloat($('#sale_invoice_detail_qty_' + $row_id).val()) || 0.00;
    var $rate = parseFloat($('#sale_invoice_detail_rate_' + $row_id).val()) || 0.00;
    var $cog_rate = parseFloat($('#sale_invoice_detail_cog_rate_' + $row_id).val()) || 0.00;

    var $total_cubic_meter = $cubic_meter * $qty;
    //var $total_cubic_feet = $cubic_feet * $qty;
    var $total_cubic_feet = roundUpto(parseFloat($total_cubic_meter) * parseFloat(35.3147),4);
    var $amount = $total_cubic_feet * $rate;
    var $cog_amount = $total_cubic_feet * $cog_rate;
    $amount = roundUpto($amount,2);
    $cog_amount = roundUpto($cog_amount,2);

    $('#sale_invoice_detail_total_cubic_meter_' + $row_id).val($total_cubic_meter);
    $('#sale_invoice_detail_total_cubic_feet_' + $row_id).val($total_cubic_feet);
    $('#sale_invoice_detail_amount_' + $row_id).val($amount);
    $('#sale_invoice_detail_cog_amount_' + $row_id).val($cog_amount);

    $('#sale_invoice_detail_discount_percent_' + $row_id).trigger('change');
    $('#sale_invoice_detail_tax_percent_' + $row_id).trigger('change');
}

function calculateDiscountAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $discount_percent = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $discount_amount = roundUpto($amount * $discount_percent / 100,2);
    //console.log($obj, $amount, $discount_percent, $discount_amount);
    $('#sale_invoice_detail_discount_amount_' + $row_id).val($discount_amount);
    calculateRowTotal($obj);
}

function calculateDiscountPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $discount_amount = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $discount_percent = roundUpto($discount_amount / $amount * 100,2);

    $('#sale_invoice_detail_discount_percent_' + $row_id).val($discount_percent);
    calculateRowTotal($obj);
}

function calculateTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_percent = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_amount = roundUpto($amount * $tax_percent / 100,2);

    $('#sale_invoice_detail_tax_amount_' + $row_id).val($tax_amount);
    calculateRowTotal($obj);
}

function calculateTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_amount = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_percent = roundUpto($tax_amount / $amount * 100,2);

    $('#sale_invoice_detail_tax_percent_' + $row_id).val($tax_percent);
    calculateRowTotal($obj);
}

function calculateRowTotal($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');

    var $amount = parseFloat($('#sale_invoice_detail_amount_' + $row_id).val());
    var $discount_amount = parseFloat($('#sale_invoice_detail_discount_amount_' + $row_id).val());
    var $gross_amount = roundUpto($amount - $discount_amount,2);

    var $tax_amount = parseFloat($('#sale_invoice_detail_tax_amount_' + $row_id).val());
    var $total_amount = roundUpto($gross_amount + $tax_amount,2);

    $('#sale_invoice_detail_gross_amount_' + $row_id).val($gross_amount);
    $('#sale_invoice_detail_total_amount_' + $row_id).val($total_amount);

    calculateTotal();
}

function calculateTotal() {
    var $item_amount = 0;
    var $item_discount = 0;
    var $item_tax = 0;
    var $item_total = 0;
    var $total_quantity = 0;
    var $total_cubic_meter = 0;
    var $total_cubic_feet = 0;
    $('#tblSaleInvoice tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $amount = $('#sale_invoice_detail_amount_' + $row_id).val();
        var $discount_amount = $('#sale_invoice_detail_discount_amount_' + $row_id).val();
        var $tax_amount = $('#sale_invoice_detail_tax_amount_' + $row_id).val();
        var $total_amount = $('#sale_invoice_detail_total_amount_' + $row_id).val();
        var $quantity = $('#sale_invoice_detail_qty_' + $row_id).val();
        var $cubic_meter = $('#sale_invoice_detail_total_cubic_meter_' + $row_id).val();
        var $cubic_feet = $('#sale_invoice_detail_total_cubic_feet_' + $row_id).val();

        $item_amount += parseFloat($amount);
        $item_discount += parseFloat($discount_amount);
        $item_tax += parseFloat($tax_amount);
        $item_total += parseFloat($total_amount);
        $total_quantity += parseFloat($quantity);
        $total_cubic_meter += parseFloat($cubic_meter);
        $total_cubic_feet += parseFloat($cubic_feet);
    })

    $('#total_quantity').val(roundUpto($total_quantity,0));
    $('#total_cubic_meter').val(roundUpto($total_cubic_meter,4));
    $('#total_cubic_feet').val(roundUpto($total_cubic_meter * 35.3147,4));
    var $discount_amount = $('#discount_amount').val() || 0.00;
    var $labour_charges = $('#labour_charges').val() || 0.00;
    var $misc_charges = $('#misc_charges').val() || 0.00;
    var $rent_charges = $('#rent_charges').val() || 0.00;
    var $net_amount = parseFloat($item_total) - parseFloat($discount_amount) + parseFloat($labour_charges) + parseFloat($misc_charges) + parseFloat($rent_charges);
    var $cash_received = $('#cash_received').val() || 0.00;
    var $balance_amount = $net_amount - $cash_received;
    //console.log($discount_amount, $labour_charges, $misc_charges, $net_amount, $cash_received, $balance_amount);
    $('#item_amount').val(roundUpto($item_amount,2));
    $('#item_discount').val(roundUpto($item_discount,2));
    $('#item_tax').val(roundUpto($item_tax,2));
    $('#item_total').val(roundUpto($item_total,2));
    $('#discount_amount').val(roundUpto($discount_amount,2));
    $('#labour_charges').val(roundUpto($labour_charges,2));
    $('#misc_charges').val(roundUpto($misc_charges,2));
    $('#rent_charges').val(roundUpto($rent_charges,2));
    $('#net_amount').val(roundUpto($net_amount,2));
    $('#cash_received').val(roundUpto($cash_received,2));
    $('#balance_amount').val(roundUpto($balance_amount,2));
}
