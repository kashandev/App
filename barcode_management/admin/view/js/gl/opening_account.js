/**
 * Created by Huzaifa on 9/18/15.
 */

$(document).on('click','.btnAddGrid', function($obj) {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '<td>';

    $html += '<select class="form-control" id="opening_account_detail_partner_type_id_'+$grid_row+'" name="opening_account_details['+$grid_row+'][partner_type_id]" onChange="getPartners('+$grid_row+');">';
    $html += '<option value="">&nbsp;</option>';
    $.each($partner_types, function($i, $partner_type) {
        $html += '<option value="'+$partner_type['partner_type_id']+'">'+$partner_type['name']+'</option>';
    })
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<select onChange="getCoas('+$grid_row+');" class="form-control select2" id="opening_account_detail_partner_id_'+$grid_row+'" name="opening_account_details['+$grid_row+'][partner_id]">';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<select class="form-control select2" id="opening_account_detail_project_id_'+$grid_row+'" name="opening_account_details['+$grid_row+'][project_id]" onChange="getSubProjects('+$grid_row+');">';
    $html += '<option value="">&nbsp;</option>';
    $projects.forEach(function($project) {
        $html += '<option value="'+$project['project_id']+'">'+$project['name']+'</option>';
    })
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<select class="form-control select2" id="opening_account_detail_sub_project_id_'+$grid_row+'" name="opening_account_details['+$grid_row+'][sub_project_id]">';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<select class="form-control select2" id="opening_account_detail_ref_document_type_id_'+$grid_row+'" name="opening_account_details['+$grid_row+'][ref_document_type_id]">';
    $html += '<option value="">&nbsp;</option>';
    $html += '<option value="1">'+$lang['purchase_invoice']+'</option>';
    $html += '<option value="2">'+$lang['sale_invoice']+'</option>';
    $html += '<option value="11">'+$lang['debit_invoice']+'</option>';
    $html += '<option value="24">'+$lang['credit_invoice']+'</option>';
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="opening_account_details['+$grid_row+'][ref_document_identity]" id="opening_account_detail_ref_document_identity_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control dtpDate" name="opening_account_details['+$grid_row+'][ref_document_date]" id="opening_account_detail_ref_document_date_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="opening_account_details['+$grid_row+'][ref_document_amount]" id="opening_account_detail_ref_document_amount_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<select class="form-control select2" id="opening_account_detail_coa_level3_id_'+$grid_row+'" name="opening_account_details['+$grid_row+'][coa_level3_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $.each($coas123, function($i, $coa) {

            $html += '<option value="'+$coa['coa_level3_id']+'"  >'+$coa['name']+'</option>';


   })
    $html += '</select>';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateTotal(this);" type="text" class="form-control fPDecimal" name="opening_account_details['+$grid_row+'][document_debit]" id="opening_account_detail_document_debit_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input onchange="calculateTotal(this);" type="text" class="form-control fPDecimal" name="opening_account_details['+$grid_row+'][document_credit]" id="opening_account_detail_document_credit_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';


    if($(this).parent().parent().data('row_id')=='H') {
        $('#tblOpeningAccountDetail tbody').prepend($html);
    } else {
        $(this).parent().parent().after($html);
    }

    setFieldFormat();
    $('#tblOpeningAccountDetail #grid_row_'+$grid_row+' select:first').select2('open');
    $grid_row++;
});

function getPartners($row_id) {
    var $partner_type_id = $('#opening_account_detail_partner_type_id_' + $row_id).val();

    var $html = '<option value="">&nbsp;</option>';
    console.log($partners);
    if($partner_type_id != '') {

        $.each( $partners, function( key, $partner ) {

            if($partner['partner_type_id']==$partner_type_id) {

                $html += '<option value="'+$partner['partner_id']+'">'+$partner['name'] +'  '+$partner['its_no']+'</option>';
            }
        });
    }
    console.log($html);
    $('#opening_account_detail_partner_id_' + $row_id).html($html).trigger('change');
}


function getCoas($row_id) {
    var $partner_id = $('#opening_account_detail_partner_id_' + $row_id).val();

    var $html = '<option value="">&nbsp;</option>';
    if($partner_id != '') {
        $.each( $partners, function( key, $partner ) {

            if($partner['partner_id']==$partner_id) {

                $html += '<option value="'+$partner['outstanding_account_id']+'" selected="true" >'+$partner['outstanding_account']+'</option>';
            }
        });
    }
    console.log($html);
 //   $('#opening_account_detail_coa_level3_id_' + $row_id).html($html).trigger('change');
}

function getSubProjects($row_id) {

    var $project_id = $('#opening_account_detail_project_id_' + $row_id).val();

    var $html = '<option value="">&nbsp;</option>';
    if($project_id != '') {

        $.each( $sub_projects, function( key, $sub_project ) {
            //console.log($sub_project);
            if($sub_project['project_id']==$project_id) {

                $html += '<option value="'+$sub_project['sub_project_id']+'">'+$sub_project['name']+'</option>';
            }
        });

    }

    $('#opening_account_detail_sub_project_id_' + $row_id).html($html).trigger('change');
}



function removeRow($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateTotal() {
    var $document_debit = 0;
    var $document_credit = 0;
    $('#tblOpeningAccountDetail tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        var $debit_amount = $('#opening_account_detail_document_debit_' + $row_id).val() || 0;
        var $credit_amount = $('#opening_account_detail_document_credit_' + $row_id).val() || 0;

        $document_debit += parseFloat($debit_amount);
        $document_credit += parseFloat($credit_amount);
    })

    $('#document_debit').val($document_debit.toFixed(4));
    $('#document_credit').val($document_credit.toFixed(4));
}
