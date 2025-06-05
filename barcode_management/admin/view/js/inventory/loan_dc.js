/**
 * Created by Muhammad Salman on 01/02/2022.
 */


function removeRow($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#row_id_'+$row_id).remove();
    calculateTotal();
}

function calculateRowTotal($obj){}

function calculateTotal() {
    var $total_qty = 0;
    var $total_amount = 0;
    $('#tblLoanDc tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $qty = $('#loan_dc_detail_qty_'+$row_id).val();
        var $amount = $('#loan_dc_detail_cog_amount_'+$row_id).val();

        $total_qty += parseFloat($qty);
        $total_amount += parseFloat($amount);
    })

    $('#total_qty').val(roundUpto($total_qty,2));
    $('#total_amount').val(roundUpto($total_amount,2));
}




function GetDocumentDetails()
{
    var $serialno = $('#serial_no').val();
    var $wid = $('#warehouse_id').val();
    var $wName = $('#warehouse_id').find('option:selected').text();

    $.ajax({
        url: $UrlGetProductBySerialNo,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $serialno+'&warehouse_id='+$wid,
        mimeType:"multipart/form-data",
        beforeSend: function() {},
        complete: function() {},
        success: function(json) {
            if(json.success)
            {
                var $res = 0;
                $html = '';
                $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
                $html += '<td>';
                $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" name="loan_dc_details['+$grid_row+'][serial_no]" id="loan_dc_detail_serial_no_'+$grid_row+'" value="'+$serialno+'" readonly/>';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" name="loan_dc_details['+$grid_row+'][product_name]" id="loan_dc_detail_product_name_'+$grid_row+'" value="'+json.product['product_code']+ '-'+ json.product['brand'] +'-'+json.product['model']+'-'+json.product['name']+'" readonly/>';
                $html += '<input type="hidden" class="required form-control" name="loan_dc_details['+$grid_row+'][product_code]" id="loan_dc_detail_product_code_'+$grid_row+'" value="'+json.product['product_code'] +'" />';
                $html += '<input type="hidden" name="loan_dc_details['+$grid_row+'][available_stock]" id="loan_dc_detail_available_stock_'+ $grid_row +'">';
                $html += '</td>';
                $html += '<td  style="min-width: 300px">';
                $html += '<textarea type="text"  class="form-control" rows="4" col="6" name="loan_dc_details['+$grid_row+'][description]" id="loan_dc_detail_description_'+$grid_row+'">'+json.product['name']+'</textarea>';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" name="loan_dc_details['+$grid_row+'][batch_no]" id="loan_dc_detail_batch_no_'+$grid_row+'" value="'+json.product['batch_no']+'" readonly/>';
                $html += '<input type="hidden" class="form-control" name="loan_dc_details['+$grid_row+'][product_master_id]" id="loan_dc_detail_product_master_id_'+$grid_row+'" value="'+json.product['product_master_id']+'" />';
                $html += '<input type="hidden" class="form-control" name="loan_dc_details['+$grid_row+'][product_id]" id="loan_dc_detail_product_id_'+$grid_row+'" value="'+json.product['product_id']+'" />';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="hidden" name="loan_dc_details['+$grid_row+'][warehouse_id]" id="loan_dc_detail_warehouse_id_'+ $grid_row +'" value="'+$wid+'" />';
                $html += '<input name="loan_dc_details['+$grid_row+'][warehouse_name]" id="loan_dc_detail_warehouse_name_'+ $grid_row +'" value="'+$wName+'" readonly class="form-control"/>';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" onchange="calculateRowTotal(this);" class="form-control fPDecimal" name="loan_dc_details['+$grid_row+'][qty]" id="loan_dc_detail_qty_'+$grid_row+'" value="1" readonly/>';
                $html += '<input type="hidden" class="form-control fPDecimal" name="loan_dc_details['+$grid_row+'][available_stock]" id="loan_dc_detail_available_stock_'+$grid_row+'" value="" />';
                $html += '</td>';
                $html += '<td>';
                $html += '<input type="text" class="form-control" name="loan_dc_details['+$grid_row+'][unit]" id="loan_dc_detail_unit_'+$grid_row+'" value="'+json.product['unit']+'" readonly>';
                $html += '<input type="hidden" class="form-control" name="loan_dc_details['+$grid_row+'][unit_id]" id="loan_dc_detail_unit_id_'+$grid_row+'" value="'+json.product['unit_id']+'">';
                $html += '<input type="hidden" onchange="calculateRowTotal(this);" class="form-control fPDecimal" name="loan_dc_details['+$grid_row+'][rate]" id="loan_dc_detail_rate_'+$grid_row+'" value="'+json.product['cost_price']+'" />';
                $html += '<input type="hidden" class="form-control fPDecimal" name="loan_dc_details['+$grid_row+'][cog_rate]" id="loan_dc_detail_cog_rate_'+$grid_row+'" value="0" />';
                $html += '<input type="hidden"  class="form-control fPDecimal" name="loan_dc_details['+$grid_row+'][cog_amount]" id="loan_dc_detail_cog_amount_'+$grid_row+'" value="" />';
                $html += '</td>';
                $html += '<td>';
                $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
                $html += '</tr>';

                var test =  CheckResult();
                if(test == 1)
                {
                    return;
                }

                $('#tblLoanDc tbody').prepend($html);

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


function CheckResult() {

    var $sr = $('#serial_no').val();
    var itemsCheckDuplicate = {};
    var res =0;

    $('#tblLoanDc tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        var $serialno = $('#loan_dc_detail_serial_no_' + $row_id).val();
        if($serialno == $sr){
            res = 1;
            alert("Serial No Duplicate");
        }
    })
    return  res;
}



function Save(){

    if($('#form').valid() == true){
        $('#form').submit();
        $('.btnSave').removeAttr('disabled');
    }
}