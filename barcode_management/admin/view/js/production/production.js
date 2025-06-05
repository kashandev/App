/**
 * Created by Huzaifa on 9/18/15.
 */

$(document).on('click','#btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<select class="form-control select2" id="production_detail_warehouse_id_'+$grid_row+'" name="production_details['+$grid_row+'][warehouse_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse) {
        $html += '<option value="'+$warehouse.warehouse_id+'">'+$warehouse.name+'</option>';
    });
    $html += '</select>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="getProductBySerialNoDetail(this);" type="text" class="form-control" name="production_details['+$grid_row+'][serial_no]" id="production_detail_serial_no_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="production_details['+$grid_row+'][batch_no]" id="production_detail_batch_no_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="production_details['+$grid_row+'][product_name]" id="production_detail_product_name_'+$grid_row+'" value="" readonly/>';
    $html += '<input type="hidden" class="form-control" name="production_details['+$grid_row+'][product_id]" id="production_detail_product_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="production_details['+$grid_row+'][product_code]" id="production_detail_product_code_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="production_details['+$grid_row+'][product_master_id]" id="production_detail_product_master_id_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="production_details['+$grid_row+'][unit]" id="production_detail_unit_'+$grid_row+'" value="" readonly="true" />';
    $html += '<input type="hidden" class="form-control" name="production_details['+$grid_row+'][unit_id]" id="production_detail_unit_id_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" type="text" class="form-control fPDecimal" name="production_details['+$grid_row+'][qty]" id="production_detail_qty_'+$grid_row+'" value="1" readonly/>';
    $html += '<input type="hidden" class="form-control text-right" name="production_details['+$grid_row+'][expected_quantity]" id="production_detail_expected_quantity_'+$grid_row+'"  value="1" readonly="true"/>';
    $html += '<input type="hidden" class="form-control text-right" name="production_details['+$grid_row+'][actual_quantity]" id="production_detail_actual_quantity_'+$grid_row+'"  value="1" />';
    $html += '<input type="hidden" class="form-control text-right"  name="production_details['+$grid_row+'][cog_rate]" id="production_detail_cog_rate_'+$grid_row+'" value="" readonly="true"/>';
    $html += '<input type="hidden" class="form-control text-right" name="production_details['+$grid_row+'][cog_amount]" id="production_detail_cog_amount_'+$grid_row+'"  value="" readonly="true" />';
    $html += '</td>'
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';

    $('#tblProductionDetail tbody').append($html);

    $('#production_detail_qty_'+$grid_row).trigger('Change');

    $grid_row++;
    calculateTotal();
});





function calculateQuantity($obj) {
    var $master_expected_quantity = $('#expected_quantity').val();
    $('#actual_quantity').val($master_expected_quantity);
    $('#tblProductionDetail tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $qty = $('#production_detail_qty_' + $row_id).val();
        var $expected_quantity = $qty * $master_expected_quantity;
        var $cog_rate = $('#production_detail_cog_rate_' + $row_id).val();
        var $actual_quantity = $expected_quantity;
        var $cog_amount = $actual_quantity * $cog_rate;

     //   $('#production_detail_expected_quantity_'+ $row_id).val($expected_quantity);
    //    $('#production_detail_actual_quantity_'+ $row_id).val($actual_quantity);
        $('#production_detail_cog_amount_'+ $row_id).val($cog_amount);
    })

    calculateTotal();
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
                console.log($row_id);
                $('#production_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#production_detail_unit_'+$row_id).val(json.product['unit']);
                $('#production_detail_product_id_'+$row_id).select2('destroy');
                $('#production_detail_product_id_'+$row_id).val(json.product['product_id']);
                $('#production_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#production_detail_rate_'+$row_id).val(json.product['cost_price']);
            }
            else {
                alert(json.error);
                $('#production_detail_unit_id_'+$row_id).val('');
                $('#production_detail_unit_'+$row_id).val('');
                $('#production_detail_product_id_'+$row_id).select2('destroy');
                $('#production_detail_product_id_'+$row_id).val('');
                $('#production_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#production_detail_rate_'+$row_id).val('0.00');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}


function removeRow($obj) {
    console.log($obj);
     $($obj).parents('tr').remove();
//    console.log($row_id);
//    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateRowTotal($obj) {
    var $row_id =$($obj).parent().parent().data('row_id');
    var $actual_quantity = parseFloat($('#production_detail_qty_' + $row_id).val());
    var $cog_rate = parseFloat($('#production_detail_cog_rate_' + $row_id).val());

    var $cog_amount = ($actual_quantity * $cog_rate) || 0.00;
    var $cog_amount = roundUpto($cog_amount,2);
    console.log("d ",$row_id,$actual_quantity,$cog_rate);
    $('#production_detail_cog_amount_' + $row_id).val($cog_amount);

    calculateTotal();
}

function calculateTotal() {
    var $total_amount = 0;
    $('#tblProductionDetail tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        var $amount = $('#production_detail_cog_amount_' + $row_id).val();

        $total_amount += parseFloat($amount);
    })
    var $actual_quantity = $('#actual_quantity').val();
    var $rate = parseFloat($total_amount) / parseFloat($actual_quantity);

    $('#amount').val($total_amount);
    $('#rate').val(roundUpto($rate,2));
}

function calculateRate() {
    var $amount = $('#amount').val();
    var $actual_quantity = $('#actual_quantity').val();

    var $rate = roundUpto(parseFloat($amount)/parseFloat($actual_quantity),2);
    $('#rate').val($rate);
}

function validateForm() {
    var $bolError = true;
    $('#tblProductionDetail tbody tr').each(function() {
        var $id = $(this).data('row_id');

        var $warehouse_id = $('#production_detail_warehouse_id_' + $id).val();
        var $restrict_out_of_stock = $('#restrict_out_of_stock').val();

        $('#production_detail_warehouse_id_' + $id).parent().children('label').remove();
        if($warehouse_id == '') {
            $bolError = true;
            $('#production_detail_warehouse_id_' + $id).parent().append('<label for="production_detail_warehouse_id_' + $id + '" class="error">This Field is required.</label>')
        }

        $('#production_detail_actual_quantity_' + $id).parent().children('label').remove();
        console.log($restrict_out_of_stock);
        if($restrict_out_of_stock == 1) {
            var $actual_quantity = parseFloat($('#production_detail_actual_quantity_' + $id).val());
            var $stock_quantity = parseFloat($('#production_detail_stock_quantity_' + $id).val());
            console.log($actual_quantity, $stock_quantity);
            if($actual_quantity > $stock_quantity) {
                $bolError = true;

                $('#production_detail_actual_quantity_' + $id).parent().append('<label for="production_detail_actual_quantity_' + $id + '" class="error">Available Stock is '+$stock_quantity+'</label>');
            }
        }
    })
    if($bolError == false) {
        $('#form').submit();
    }
}


function getProductBySerialNo($obj) {
    $serial_no = $($obj).val();
    $warehouse_id = $('#warehouse_id').val() ;
    $.ajax({
        url: $UrlGetProductBySerialNoWarehouse,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $serial_no +'&warehouse_id='+$warehouse_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            //$('#product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                console.log(json);
                $('#product_code').val(json.product['product_code']);
                $('#batch_no').val(json.product['batch_no']);
                $('#unit_id').val(json.product['unit_id']);
                $('#unit').val(json.product['unit']);
                $('#product_id').val(json.product['product_id']);
                $('#product_name').val(json.product['name']);
                $('#rate').val(json.product['stock']['avg_stock_rate']);
                $('#stock_qty').val(json.product['stock']['stock_qty']);
                $('#product_master_id').val(json.product['product_master_id']);
            }
            else {
                alert(json.error);
                $('#product_code_').val('');
                $('#batch_no_').val('');
                $('#unit_id_').val('');
                $('#unit_').val('');
                $('#rate').val('0.00');
                $('#product_id').val('');
                $('#product_master_id').val('');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

function getProductBySerialNoDetail($obj) {
    $serial_no = $($obj).val();
    var $row_id = $($obj).parent().parent().data('row_id');
    $warehouse_id = $('#production_detail_warehouse_id_'+$row_id).val() ;

    $.ajax({
        url: $UrlGetProductBySerialNoWarehouse,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $serial_no +'&warehouse_id='+$warehouse_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            //$('#production_detail_product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#production_detail_product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
                console.log($row_id);
                $('#production_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#production_detail_batch_no_'+$row_id).val(json.product['batch_no']);
                $('#production_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#production_detail_unit_'+$row_id).val(json.product['unit']);
                $('#production_detail_product_id_'+$row_id).val(json.product['product_id']);
                $('#production_detail_product_name_'+$row_id).val(json.product['name']);
                $('#production_detail_cog_rate_'+$row_id).val(json.product['stock']['avg_stock_rate']);
//                $('#production_detail_stock_qty_'+$row_id).val(json.product['stock']['stock_qty']);
                $('#production_detail_product_master_id_'+$row_id).val(json.product['product_master_id']);
                $('#production_detail_qty_'+$row_id).trigger('change');

            }
            else {
                alert(json.error);
                $('#production_detail_product_code_'+$row_id).val('');
                $('#production_detail_batch_no_'+$row_id).val('');
                $('#production_detail_unit_id_'+$row_id).val('');
                $('#production_detail_unit_'+$row_id).val('');
                $('#production_detail_product_id_'+$row_id).val('');
                $('#production_detail_rate_'+$row_id).val('0.00');
                $('#production_detail_product_master_id_'+$row_id).val('');
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}
