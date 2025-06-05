/**
 * Created by Huzaifa on 9/18/15.
 */

$(document).on('change', '#project_id', function() {

    var $project_id = $(this).val();
    //var $sub_project_id = $('#sub_project_id').val();
    $.ajax({
        url: $UrlGetSubProject,
        dataType: 'json',
        type: 'post',
        data: 'project_id=' + $project_id +'&sub_project_id='+$sub_project_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#sub_project_id').before('<span id="loader"><i class="fa fa-refresh fa-spin">&nbsp;</i></span>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#sub_project_id').html(json.html).trigger('change');
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
                $partners = json.partners;
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
    /*
     $partner_id = $(this).val();
     var $documents = $partners[$partner_id]['documents'];
     $html = '<option data-document_amount="0" data-amount="0" data-document_type_id="0" value="">&nbsp;</option>';
     $.each($documents, function (index, $document) {
     if($document['credit_amount'] > 0) {
     $html += '<option data-document_amount="'+$document['document_amount']+'" data-amount="'+$document['outstanding_amount']+'" data-document_type_id="'+$document['ref_document_type_id']+'" value="'+$document['ref_document_identity']+'">'+$document['ref_document_identity']+'</option>';
     }
     })

     $('#ref_document_identity').select2('destroy');
     $('#ref_document_identity').html($html);
     $('#ref_document_identity').select2({width: '100%'});
     */
    var $partner_type_id = $('#partner_type_id').val();
    var $partner_id = $(this).val();
    $.ajax({
        url: $UrlGetDocuments,
        dataType: 'json',
        type: 'post',
        data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#lblRefDocumentNo').after('<i id="loader" class="fa fa-refresh fa-spin"></i>');
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
                //$partners = json.partners;
                $documents = json.documents;
                $partner_coas = json.partner_coas;
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

$(document).on('click','#addRefDocument', function() {
    var $partner_id = $('#partner_id').val();
    var $accounts = $partners[$partner_id]['coas'];
    var $document_identity = $('#ref_document_identity').val();
    if($document_identity != '') {
        var $document = $partners[$partner_id]['documents'][$document_identity];
        $html = '';
        $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
        $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
        $html += '<td>';
        $html += '<input type="hidden" name="bank_receipt_details['+$grid_row+'][ref_document_type_id]" id="bank_receipt_detail_ref_document_type_id_'+$grid_row+'" value="'+$partners[$partner_id]['documents'][$document_identity]['ref_document_type_id']+'" />';
        $html += '<input type="hidden" name="bank_receipt_details['+$grid_row+'][ref_document_identity]" id="bank_receipt_detail_ref_document_identity_'+$grid_row+'" value="'+$partners[$partner_id]['documents'][$document_identity]['ref_document_identity']+'" />';
        $html += '<a target="_blank" href="'+$partners[$partner_id]['documents'][$document_identity]['href']+'">'+$document_identity+'</a>';
        $html += '</td>';
        $html += '<td style="width: 200px;">';
        $html += '<select class="form-control select2" id="bank_receipt_detail_coa_id_'+$grid_row+'" name="bank_receipt_details['+$grid_row+'][coa_id]">';
        $.each($accounts, function (index, $account) {
            $html += '<option value="'+$account['coa_level3_id']+'">'+$account['level3_display_name']+'</option>';
        })
        $html += '</select>';
        $html += '</td>'
        $html += '<td>';
        $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][remarks]" id="bank_receipt_detail_remarks_'+$grid_row+'" value="" />';
        $html += '</td>'
        $html += '<td>';
        $html += '<input type="text" class="form-control dtpDate" name="bank_receipt_details['+$grid_row+'][cheque_date]" id="bank_receipt_detail_cheque_date_'+$grid_row+'" value="" />';
        $html += '</td>'
        $html += '<td>';
        $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][cheque_no]" id="bank_receipt_detail_cheque_no_'+$grid_row+'" value="" />';
        $html += '</td>'
        $html += '<td>';
        $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][document_amount]" id="bank_receipt_detail_document_amount_'+$grid_row+'" value="'+$document['document_amount']+'" readonly="true"/>';
        $html += '</td>'
        $html += '<td>';
        $html += '<input onchange="calculateTaxes(this);" type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][amount]" id="bank_receipt_detail_amount_'+$grid_row+'" value="'+$document['outstanding_amount']+'" />';
        $html += '</td>'
        $html += '<td>';
        $html += '<input onchange="calculateWHTAmount(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][wht_percent]" id="bank_receipt_detail_wht_percent_'+$grid_row+'" value="0"/>';
        $html += '</td>'
        $html += '<td>';
        $html += '<input onchange="calculateWHTPercent(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][wht_amount]" id="bank_receipt_detail_wht_amount_'+$grid_row+'" value="0.00"/>';
        $html += '</td>'
        $html += '<td>';
        $html += '<input onchange="calculateOtherTaxAmount(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][other_tax_percent]" id="bank_receipt_detail_other_tax_percent_'+$grid_row+'" value="0"/>';
        $html += '</td>'
        $html += '<td>';
        $html += '<input onchange="calculateOtherTaxPercent(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][other_tax_amount]" id="bank_receipt_detail_other_tax_amount_'+$grid_row+'" value="0.00"/>';
        $html += '</td>'
        $html += '<td>';
        $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][net_amount]" id="bank_receipt_detail_net_amount_'+$grid_row+'" value="'+$document['outstanding_amount']+'" readonly="true"/>';
        $html += '</td>'
        $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
        $html += '</tr>';


        $('#tblBankReceiptDetail tbody').append($html);
        //$('#bank_receipt_detail_ref_document_identity_'+$grid_row).select2({width: '100%'});
        //$('#bank_receipt_detail_coa_id_'+$grid_row).select2({width: '100%'});
        setFieldFormat();
        $grid_row++;

        calculateTotal();
    }

});

$(document).on('click','#btnAddGrid', function() {
    var $partner_type_id = $('#partner_type_id').val();
    var $partner_id = $('#partner_id').val();
    var $accounts = [];
    var $all_requests = [];
//    if($partner_type_id != '' && $partner_id != '') {
//        $accounts = $partner_coas;
//    } else {
    $accounts = $coas;
    $all_requests = $requests;
//    }

    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td style="white-space: nowrap; width: 3.5%"><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '<a id="btnAddGrid" class="btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '</td>';
    $html += '<td style="min-width: 200px;">';
    $html += '<input type="hidden" class="form-control" name="bank_receipt_details['+$grid_row+'][ref_document_type_id]" id="bank_receipt_detail_ref_document_type_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="bank_receipt_details['+$grid_row+'][ref_document_identity]" id="bank_receipt_detail_ref_document_identity_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td style="width: 200px;">';
    $html += '<select class="form-control select2" id="bank_receipt_detail_coa_id_'+$grid_row+'" name="bank_receipt_details['+$grid_row+'][coa_id]">';
    $.each($accounts, function (index, $account) {
        $html += '<option value="'+$account['coa_level3_id']+'">'+$account['level3_display_name']+'</option>';
    })
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][remarks]" id="bank_receipt_detail_remarks_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<select class="form-control select2" id="bank_receipt_detail_amaanat_no_'+$grid_row+'" name="bank_receipt_details['+$grid_row+'][amaanat_no]">';
    $html += '<option value="">&nbsp;</option>';
    $.each($all_requests, function (index, $request) {
        $html += '<option value="'+$request['amaanat_no']+'">'+$request['amaanat_no']+'</option>';
    })
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control dtpDate" name="bank_receipt_details['+$grid_row+'][cheque_date]" id="bank_receipt_detail_cheque_date_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][cheque_no]" id="bank_receipt_detail_cheque_no_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][document_amount]" id="bank_receipt_detail_document_amount_'+$grid_row+'" value="0.00" readonly="true"/>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateTaxes(this);" type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][amount]" id="bank_receipt_detail_amount_'+$grid_row+'" value="0.00" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateWHTAmount(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][wht_percent]" id="bank_receipt_detail_wht_percent_'+$grid_row+'" value="0"/>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateWHTPercent(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][wht_amount]" id="bank_receipt_detail_wht_amount_'+$grid_row+'" value="0.00"/>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateOtherTaxAmount(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][other_tax_percent]" id="bank_receipt_detail_other_tax_percent_'+$grid_row+'" value="0"/>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateOtherTaxPercent(this);" type="text" class="form-control fPDecimal" name="bank_receipt_details['+$grid_row+'][other_tax_amount]" id="bank_receipt_detail_other_tax_amount_'+$grid_row+'" value="0.00"/>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="bank_receipt_details['+$grid_row+'][net_amount]" id="bank_receipt_detail_net_amount_'+$grid_row+'" value="0.00" readonly="true"/>';
    $html += '</td>'
    $html += '<td style="white-space: nowrap; width: 3.5%">';
    $html += '<a id="btnAddGrid" class="btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';


    $('#tblBankReceiptDetail tbody').append($html);
    //$('#bank_receipt_detail_ref_document_identity_'+$grid_row).select2({width: '100%'});
    //$('#bank_receipt_detail_coa_id_'+$grid_row).select2({width: '100%'});
    setFieldFormat();
    $grid_row++;
});

function setDocumentInfo($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $data = $($obj).find(':selected').data();

    $('#bank_receipt_detail_ref_document_type_id_' + $row_id).val($data['ref_document_type_id']);
    $('#bank_receipt_detail_document_amount_' + $row_id).val($data['document_amount']);
    $('#bank_receipt_detail_amount_' + $row_id).val($data['amount']);
    $('#bank_receipt_detail_net_amount_' + $row_id).val($data['amount']);

    calculateTotal();
}

function removeRow($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateTaxes($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $amount = parseFloat($('#bank_receipt_detail_amount_' + $row_id).val()) || 0.00;
    var $wht_percent = parseFloat($('#bank_receipt_detail_wht_percent_' + $row_id).val()) || 0.00;
    var $other_tax_percent = parseFloat($('#bank_receipt_detail_other_tax_percent_' + $row_id).val()) || 0.00;

    var $wht_amount = ($amount * $wht_percent / 100);
    $('#bank_receipt_detail_wht_amount_' + $row_id).val($wht_amount.toFixed(2));

    var $other_tax_amount = ($amount * $other_tax_percent / 100);
    $('#bank_receipt_detail_other_tax_amount_' + $row_id).val($other_tax_amount.toFixed(2));

    calculateRowTotal($obj);
}

function calculateWHTAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $wht_percent = parseFloat($($obj).val()) || 0.00;
    var $amount = parseFloat($('#bank_receipt_detail_amount_' + $row_id).val()) || 0.00;

    var $wht_amount = ($amount * $wht_percent / 100);
    $('#bank_receipt_detail_wht_amount_' + $row_id).val($wht_amount.toFixed(2));

    calculateRowTotal($obj);
}

function calculateWHTPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $wht_amount = parseFloat($($obj).val()) || 0.00;
    var $amount = parseFloat($('#bank_receipt_detail_amount_' + $row_id).val()) || 0.00;

    var $wht_percent = ($wht_amount / $amount * 100);
    $('#bank_receipt_detail_wht_percent_' + $row_id).val($wht_percent.toFixed(2));

    calculateRowTotal($obj);
}

function calculateOtherTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $other_tax_percent = parseFloat($($obj).val()) || 0.00;
    var $amount = parseFloat($('#bank_receipt_detail_amount_' + $row_id).val()) || 0.00;

    var $other_tax_amount = ($amount * $other_tax_percent / 100);
    $('#bank_receipt_detail_other_tax_amount_' + $row_id).val($other_tax_amount.toFixed(2));

    calculateRowTotal($obj);
}

function calculateOtherTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $other_tax_amount = parseFloat($($obj).val()) || 0.00;
    var $amount = parseFloat($('#bank_receipt_detail_amount_' + $row_id).val()) || 0.00;

    var $other_tax_percent = ($other_tax_amount / $amount * 100);
    $('#bank_receipt_detail_other_tax_percent_' + $row_id).val($other_tax_percent.toFixed(2));

    calculateRowTotal($obj);
}

function calculateRowTotal($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $amount = parseFloat($('#bank_receipt_detail_amount_' + $row_id).val()) || 0.00;
    var $wht_amount = parseFloat($('#bank_receipt_detail_wht_amount_' + $row_id).val()) || 0.00;
    var $other_tax_amount = parseFloat($('#bank_receipt_detail_other_tax_amount_' + $row_id).val()) || 0.00;
    var $net_amount = $amount - $wht_amount - $other_tax_amount;

    $('#bank_receipt_detail_net_amount_' + $row_id).val($net_amount.toFixed(2));

    calculateTotal();
}

function calculateTotal() {
    var $amount_total = 0;
    var $wht_total = 0;
    var $other_tax_total = 0;
    var $net_total = 0;
    $('#tblBankReceiptDetail tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        var $amount = $('#bank_receipt_detail_amount_' + $row_id).val() || 0.00;
        var $wht_amount = $('#bank_receipt_detail_wht_amount_' + $row_id).val() || 0.00;
        var $other_tax_amount = $('#bank_receipt_detail_other_tax_amount_' + $row_id).val() || 0.00;
        var $net_amount = $('#bank_receipt_detail_net_amount_' + $row_id).val() || 0.00;

        $amount_total += parseFloat($amount);
        $wht_total += parseFloat($wht_amount);
        $other_tax_total += parseFloat($other_tax_amount);
        $net_total += parseFloat($net_amount);
    })

    $('#total_amount').val($amount_total.toFixed(2));
    $('#wht_amount').val($wht_total.toFixed(2));
    $('#other_tax_amount').val($other_tax_total.toFixed(2));
    $('#net_amount').val($net_total.toFixed(2));
}

