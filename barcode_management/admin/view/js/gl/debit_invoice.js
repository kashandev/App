/**
 * Created by Huzaifa on 9/18/15.
 */

 $(window).load(function(){
        switchStatus();

        if( $isEdit )
        { 
            setTimeout(function(){
                $('#partner_id').trigger('change');
            },2700);
        }

 });

 function switchStatus(){
    if( $('#sale_tax_invoice').prop('checked') == false ) {
       $('#tax_percent').prop('disabled', 'disabled').val('');
        $('#tblDebitInvoiceDetail tbody tr').each(function() {
            var $row_id = $(this).data('row_id');
            $('#debit_invoice_detail_tax_percent_' + $row_id).prop('disabled', 'disabled').val('');
            $('#debit_invoice_detail_tax_amount_' + $row_id).prop('disabled', 'disabled').val('');
        }); 
    }
 }

$('#sale_tax_invoice').on('switchChange.bootstrapSwitch', function(obj, status) {
    if(status==false) {
        $(this).val('No');
        $('#manual_ref_no').prop('disabled','').val('');
        $('#tax_percent').prop('disabled', 'disabled').val('');
        $('#tblDebitInvoiceDetail tbody tr').each(function() {
            var $row_id = $(this).data('row_id');
            $('#debit_invoice_detail_tax_percent_' + $row_id).prop('disabled', 'disabled').val('').trigger('change');
            $('#debit_invoice_detail_tax_amount_' + $row_id).prop('disabled', 'disabled').val('');
        });
    } else {
        $('#manual_ref_no').prop('disabled','disabled').val('AUTO');
        $('#tax_percent').prop('disabled', '').val('');
        $('#tblDebitInvoiceDetail tbody tr').each(function() {
            var $row_id = $(this).data('row_id');
            $('#debit_invoice_detail_tax_percent_' + $row_id).prop('disabled', '').val('').trigger('change');
            $('#debit_invoice_detail_tax_amount_' + $row_id).prop('disabled', '').val('');
        });
        $(this).val('Yes');
    }
});

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

$(document).on('change','#partner_id', function() {
    $partner_type_id = $('#partner_type_id').val();
    $partner_id = $('#partner_id').val();
    $document_date = $('[name="document_date"]').val();
    $document_identity = $('[name="document_identity"]').val();

    $.ajax({
        url: $UrlGetPreviousBalance,
        dataType: 'json',
        type: 'post',
        data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id+'&document_date='+$document_date+'&document_identity='+$document_identity,
        mimeType:"multipart/form-data",
        beforeSend: function() {
           $('#previous_balance').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#previous_balance').val(json.previous_balance).css({
                    'color':'red',
                    'font-weight':'bold',
                    'font-size':'22px'
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

$(document).on('click','.btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '&nbsp;<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '</td>';
    $html += '<td>';
    $html += '<select class="form-control select2" required id="debit_invoice_detail_coa_id_'+$grid_row+'" name="debit_invoice_details['+$grid_row+'][coa_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $coas.forEach(function($coa) {
        $html += '<option value="'+$coa['coa_level3_id']+'">'+$coa['level3_display_name']+'</option>';
    })
    $html += '</select>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="debit_invoice_details['+$grid_row+'][remarks]" id="debit_invoice_detail_remarks_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateAmount(this);" type="text" class="form-control" name="debit_invoice_details['+$grid_row+'][quantity]" id="debit_invoice_detail_quantity_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateAmount(this);" type="text" class="form-control" name="debit_invoice_details['+$grid_row+'][rate]" id="debit_invoice_detail_rate_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxPercent(this);" type="text" class="form-control fPDecimal text-right" name="debit_invoice_details['+$grid_row+'][tax_percent]" id="debit_invoice_detail_tax_percent_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxAmount(this);" type="text" class="form-control fPDecimal text-right" name="debit_invoice_details['+$grid_row+'][tax_amount]" id="debit_invoice_detail_tax_amount_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateAmount(this);" type="text" class="form-control" name="debit_invoice_details['+$grid_row+'][discount]" id="debit_invoice_detail_discount_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTotal(this);" type="text" class="form-control fPDecimal text-right" name="debit_invoice_details['+$grid_row+'][amount]" id="debit_invoice_detail_amount_'+$grid_row+'" value="" readonly />';
    $html += '</td>';
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '&nbsp;<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';

    if($(this).parent().parent().data('row_id')=='H') {
        $('#tblDebitInvoiceDetail tbody').append($html);
    } else {
        $(this).parent().parent().after($html);
    }

    setFieldFormat();
    switchStatus();
    $('#debit_invoice_detail_coa_id_'+$grid_row).select2({width: '100%'}).select2('open');
    $grid_row++;
});

function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotalAmount();
}

function calculateTaxPercent($obj) {
    $('#tax_percent').val('');
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_amount = parseFloat($($obj).val() || 0.0000);
    var $qty = parseFloat($('#debit_invoice_detail_quantity_' + $row_id).val()) || 0;
    var $rate = parseFloat($('#debit_invoice_detail_rate_' + $row_id).val()) || 0;
    var $amount = parseFloat(parseFloat(($qty*$rate)).toFixed(2));
    $amount = Math.round( $amount );
    var $tax_percent = roundUpto((($amount*$tax_amount)/100),2);

    // console.log( $tax_percent, Math.round( $tax_percent ) )

    $('#debit_invoice_detail_tax_amount_' + $row_id).val( Math.round( $tax_percent ) );
    calculateAmount($obj);
}

function calculateTaxAmount($obj) {
    $('#tax_percent').val('');
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_percent = parseFloat($($obj).val() || 0.0000);
    $tax_percent = Math.round( $tax_percent );
    var $qty = parseFloat($('#debit_invoice_detail_quantity_' + $row_id).val()) || 0;
    var $rate = parseFloat($('#debit_invoice_detail_rate_' + $row_id).val()) || 0;
    var $amount = parseFloat(parseFloat(($qty*$rate)).toFixed(2));
    $amount = Math.round( $amount );
    var $tax_amount = roundUpto((($tax_percent/$amount)*100),2);

    // console.log( $tax_amount, Math.round( $tax_amount ) )

    $('#debit_invoice_detail_tax_percent_' + $row_id).val( Math.round( $tax_amount ) );
    calculateAmount($obj);
}

function calculateAmount(obj) {

    var $row_id = $(obj).parent().parent().data('row_id');
    var $qty = parseFloat($('#debit_invoice_detail_quantity_'+$row_id).val()) || 0;
    var $rate = parseFloat($('#debit_invoice_detail_rate_'+$row_id).val()) || 0;
    var $discount = parseFloat($('#debit_invoice_detail_discount_'+$row_id).val()) || 0;
    $discount = Math.round( $discount );
    var $tax_percent = parseFloat($('#debit_invoice_detail_tax_percent_'+ $row_id).val()) || 0;
    $tax_percent = Math.round( $tax_percent );
    var $amount = parseFloat(parseFloat(($qty*$rate)).toFixed(2));
    $amount = Math.round( $amount );
    var $tax_amount = roundUpto((($amount*$tax_percent)/100),2);
    $tax_amount = Math.round( $tax_amount );
    $('#debit_invoice_detail_tax_amount_'+ $row_id).val($tax_amount);
    $gross_amount = parseFloat((parseFloat($amount)+parseFloat($tax_amount)).toFixed(2));
    $gross_amount = Math.round( $gross_amount );
    $amount_after_discount = parseFloat($gross_amount-$discount);
    $amount_after_discount = Math.round( $amount_after_discount );
    
    $('#debit_invoice_detail_amount_'+ $row_id).val($amount_after_discount);
    calculateTotalAmount();
}

function calculateTotalAmount() {
    var $total_amount = 0;
    $('#tblDebitInvoiceDetail tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $amount = $('#debit_invoice_detail_amount_' + $row_id).val();
        $total_amount += parseFloat($amount);
    });
    $total_amount = Math.round( $total_amount );
    $('#total_amount').val(parseFloat($total_amount).toFixed(2));
    $('#tax_percent').trigger('change');
}

$(document).on('change','#tax_percent',function() {
    var $total_tax_amount = 0;
    $('#tblDebitInvoiceDetail tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $tax_amount = parseFloat($('#debit_invoice_detail_tax_amount_' + $row_id).val()) || 0;
        $total_tax_amount += parseFloat($tax_amount);
    });

    $total_tax_amount = Math.round( $total_tax_amount );
    var $total_amount = parseFloat($('#total_amount').val() || 0);
    $total_amount = Math.round( $total_amount );
    // var $tax_percent = parseFloat($('#tax_percent').val()) || 0;
    // var $tax_amount  = ((($total_amount*$tax_percent)/100)).toFixed(2);
    var $net_amount = parseFloat($total_amount);
    $net_amount = Math.round( $net_amount );
    $('#tax_amount').val( Math.round( $total_tax_amount ) );
    $('#net_amount').val($net_amount);

    calculateBaseAmount();
});

$(document).on('change','#conversion_rate', function() {
    calculateBaseAmount();
})

function calculateBaseAmount() {
    var $net_amount = parseFloat($('#net_amount').val()) || 0.00;
    $net_amount = Math.round( $net_amount );
    var $conversion_rate = parseFloat($('#conversion_rate').val()) || 0.00;
    $conversion_rate = Math.round( $conversion_rate );
    var $base_amount = $net_amount * $conversion_rate;
    $base_amount = Math.round( $base_amount );
    // console.log($net_amount, $conversion_rate, $base_amount);
    $('#base_amount').val($base_amount);
}


$(document).on('blur','#tax_percent',function() {
    AddTaxes($(this));    
});

function AddTaxes(obj) {
    $tax_percent = parseFloat(obj.val()) || 0;
    $('#tblDebitInvoiceDetail tbody tr').each(function(){
        $row_id = $(this).data('row_id');
        var $qty = parseFloat($('#debit_invoice_detail_quantity_'+$row_id).val()) || 0;
        var $rate = parseFloat($('#debit_invoice_detail_rate_'+$row_id).val()) || 0;
        var $discount = parseFloat($('#debit_invoice_detail_discount_'+$row_id).val()) || 0;
        $discount = Math.round( $discount );
        var $amount = parseFloat(parseFloat(($qty*$rate)).toFixed(2));
        $amount = Math.round( $amount )
        var $wht_percent = parseFloat($('#debit_invoice_detail_tax_percent_' + $row_id).val($tax_percent)) || 0;
        $wht_percent = Math.round( $wht_percent );  

        var $wht_amount = (parseFloat(($amount*$tax_percent))/100);
        $wht_amount = Math.round( $wht_amount );  
        // console.log( $wht_amount, Math.round( $wht_amount ) )
        $('#debit_invoice_detail_tax_amount_' + $row_id).val( $wht_amount )
        $('#debit_invoice_detail_amount_' + $row_id).val(roundUpto((($amount + $wht_amount)-$discount),2));
    });
    calculateTotalAmount();
}