/**
 * Created by Muhammad Salman on 01/02/2022.
 */

 $(document).on('click','.btnAddGrid', function() {

    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';

    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';

    $html += '<td style="min-width: 250px;">';
    $html += '<input type="hidden" class="form-control" name="loan_return_details['+$grid_row+'][product_code]" id="loan_return_detail_product_code_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" id="loan_return_detail_type_of_material_'+$grid_row+'" value="" />';
    $html += '<select style="width: 550px" class="required form-control Select2Product required" id="loan_return_detail_product_id_'+$grid_row+'" name="loan_return_details['+$grid_row+'][product_id]" required>';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<label for="loan_return_detail_product_id_'+$grid_row+'" class="error" style="display:none;"></label>';
    $html += '</td>';

    $html += '<td>';
    $html += '<textarea style="width: 300px" rows="2" type="text" class="form-control" name="loan_return_details['+$grid_row+'][description]" id="loan_return_detail_description_'+$grid_row+'"></textarea>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" name="loan_return_details['+$grid_row+'][serial_no]" id="loan_return_detail_serial_no_'+$grid_row+'" class="form-control fInteger">';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" name="loan_return_details['+$grid_row+'][batch_no]" id="loan_return_detail_batch_no_'+$grid_row+'" class="form-control">';
    $html += '</td>';

    $html += '<td style="min-width: 250px !important;">';
    $html += '<select required class="form-control select2 required" name="loan_return_details['+$grid_row+'][warehouse_id]" id="loan_return_detail_warehouse_id_'+$grid_row+'" >';
    $html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse){
        $html += '<option value="'+ $warehouse.warehouse_id +'">'+ $warehouse.name +'</option>';
    });
    $html += '</select>';
    $html += '<label for="loan_return_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="loan_return_details['+$grid_row+'][qty]" id="loan_return_detail_qty_'+$grid_row+'" value="1" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" name="loan_return_details['+$grid_row+'][unit]" id="loan_return_detail_unit_'+$grid_row+'" class="form-control" readonly>';
    $html += '<input type="hidden" name="loan_return_details['+$grid_row+'][unit_id]" id="loan_return_detail_unit_id_'+$grid_row+'" class="form-control" readonly>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateRowTotal(this);" style="min-width: 100px;" class="form-control fPDecimal" name="loan_return_details['+$grid_row+'][rate]" id="loan_return_detail_rate_'+$grid_row+'" value="0"/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateRowTotal(this);" style="min-width: 100px;" class="form-control fPDecimal" id="loan_return_detail_amount_'+$grid_row+'"  name="loan_return_details['+$grid_row+'][amount]" value="0" readonly />';
    $html += '</td>';


    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';


    if($(this).parent().parent().data('row_id')=='H') {
        $('#tblLoanReturn tbody').prepend($html);
    } else {
        $(this).parent().parent().after($html);
    }

    setFieldFormat();

    Select2ProductJSON('#loan_return_detail_product_id_'+$grid_row);
    $('#loan_return_detail_product_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        $('#loan_return_detail_product_master_id_'+$row_id).val($data['product_master_id']);
        $('#loan_return_detail_product_code_'+$row_id).val($data['product_code']);
        $('#loan_return_detail_unit_id_'+$row_id).val($data['unit_id']);
        $('#loan_return_detail_unit_'+$row_id).val($data['unit']);
        $('#loan_return_detail_description_'+$row_id).val($data['text']);
    });

    $('#loan_return_detail_warehouse_id_'+$grid_row).select2({'width':'100%'});

    $grid_row++;
    calculateTotal();
});


function removeRow($obj) {
    $($obj).parents('tr').remove();
    calculateTotal();
}

function calculateRowTotal($obj){
    var $row_id = $($obj).parents('tr').data('row_id');
    var $qty = parseFloat($('#loan_return_detail_qty_'+$row_id).val())||0.00;
    var $rate = parseFloat($('#loan_return_detail_rate_'+$row_id).val())||0.00;

    var $amount = $qty*$rate;
    $('#loan_return_detail_amount_'+$row_id).val(roundUpto($amount,2));

    calculateTotal();
}

function calculateTotal() {
    var $total_amount = 0;
    $('#tblLoanReturn tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $amount = $('#loan_return_detail_amount_'+$row_id).val();
        $total_amount += parseFloat($amount);
    })

    $('#total_amount').val(roundUpto($total_amount,2));
}

function Save(){

    if($('#form').valid() == true){
        $('#form').submit();
        $('.btnSave').removeAttr('disabled');
    }
}