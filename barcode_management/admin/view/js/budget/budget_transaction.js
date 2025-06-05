

$(document).on('click','#btnAddGrid', function() {
    var $partner_type_id = $('#partner_type_id').val();
    var $partner_id = $('#partner_id').val();
    var $accounts = [];
    var $all_projects = [];

   //if($partner_type_id != '' && $partner_id != '') {
      //  $accounts = $partner_coas;

    //} else {
        $accounts = $coas;
        $all_projects = $projects;
 //  }


    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td style="white-space: nowrap; width: 3.5%"><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '<a id="btnAddGrid" class="btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '</td>';

    $html += '<td style="width: 200px;">';
    $html += '<select class="form-control select2" id="budget_detail_coa_id_'+$grid_row+'" name="budget_details['+$grid_row+'][coa_id]">';
    $html += '<option value=""></option>'
    $.each($accounts, function (index, $account) {
        $html += '<option value="'+$account['coa_level3_id']+'">'+$account['level3_display_name']+'</option>';
    })
   // $.each($coas, function($i, $coa) {

     //   $html += '<option value="'+$coa['coa_level3_id']+'"  >'+$coa['level3_display_name']+'</option>';


    //})
    $html += '</select>';
    $html += '</td>';
//    $html += '<td style="width: 100px;">';
//    $html += '<select class="form-control select2" id="budget_detail_project_id_'+$grid_row+'" name="budget_details['+$grid_row+'][project_id]">';
//    $html += '<option value=""></option>'
//    $.each($all_projects, function (index, $project) {
//        $html += '<option value="'+$project['project_id']+'">'+$project['name']+'</option>';
//    })
//
//    // $.each($coas, function($i, $coa) {
//
//    //   $html += '<option value="'+$coa['coa_level3_id']+'"  >'+$coa['level3_display_name']+'</option>';
//
//
//    //})
//    $html += '</select>';
//    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control"  name="budget_details['+$grid_row+'][last_year_amount]" id="budget_detail_last_year_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" name="budget_details['+$grid_row+'][current_year_amount]" id="budget_detail_current_year_'+$grid_row+'" value="" />';
    $html += '</td>'
    $html += '<td>';
    $html += '<input type="text" class="form-control" onchange="calculateTotal()" name="budget_details['+$grid_row+'][utilize_amount]" id="budget_detail_utilize_amount_'+$grid_row+'" value="" />'
    $html += '</td>'
    $html += '<td style="white-space: nowrap; width: 3.5%">';
    $html += '<a id="btnAddGrid" class="btn btn-xs btn-primary" title="Add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';

    $html += '</tr>';


    $('#tblBudgetDetail tbody').append($html);
    //$('#budget_detail_ref_document_identity_'+$grid_row).select2({width: '100%'});
    //$('#budget_detail_coa_id_'+$grid_row).select2({width: '100%'});
    setFieldFormat();
    $grid_row++;
});


function getCoas($row_id) {
    var $partner_id = $('#partner_id').val();

    var $html = '<option value="">&nbsp;</option>';
    if($partner_id != '') {
    console.log($partners);
        $.each( $partners, function( key, $partner ) {

            if($partner['partner_id']==$partner_id) {

                $html += '<option value="'+$partner['outstanding_account_id']+'" selected="true" >'+$partner['outstanding_account']+'</option>';
            }
        });
    }
    console.log($html);
    $('#budget_detail_coa_level3_id_' + $row_id).html($html).trigger('change');
}


function removeRow($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}


function calculateTotal() {

    var $amount_total = 0;

    $('#tblBudgetDetail tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        var $utilize_amount = $('#budget_detail_utilize_amount_' + $row_id).val() || 0.00;

        $amount_total += parseFloat($utilize_amount);

    })

    $('#total_amount').val($amount_total.toFixed(2));

}

