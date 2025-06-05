/**
 * Created by Huzaifa on 9/18/15.
 */
$(document).on('change','#document_currency_id', function() {
    $currency_id = $(this).val();
    $.ajax({
        url: $UrlGetCurrency,
        dataType: 'json',
        type: 'post',
        data: 'currency_id=' + $currency_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#document_currency_id').before('<i id="loader" class="fa fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#conversion_rate').val(json.currency_value);
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
            $('#partner_id').before('<i id="loader" class="fa fa-spinner fa-spin"></i>');
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

    document_reset();

    $partner_id = $(this).val();
    if($partner_id != '') {
        $('#ref_document_type_id').select2('destroy');
        $options = '<option value="">&nbsp;</option>';
        $options += '<option value="4">'+$lang['purchase_order']+'</option>';
        $options += '<option value="17">'+$lang['goods_received']+'</option>';
        $('#ref_document_type_id').html($options);
        $('#ref_document_type_id').select2({width: '100%'});
    } else {
        $('#ref_document_type_id').select2('destroy');
        $('#ref_document_type_id').html('');
        $('#ref_document_type_id').select2({width: '100%'});
    }
    $('#ref_document_identity').select2('destroy');
    $('#ref_document_identity').html('<option value="">&nbsp;</option>');
    $('#ref_document_identity').select2({width: '100%'});

});

$(document).on('change','#ref_document_type_id', function() {

    document_reset();

    var $partner_type_id = $('#partner_type_id').val();
    var $partner_id = $('#partner_id').val();
    var $ref_document_type_id = $(this).val();

    $UrlGetOrders = '';

    if( $ref_document_type_id == '4' )
    {
        $UrlGetOrders = $UrlGetPuchaseOrder;
    }
    else if( $ref_document_type_id == '17' )
    {
        $UrlGetOrders = $UrlGetGoodsReceived;
    }


    $.ajax({
        url: $UrlGetOrders,
        dataType: 'json',
        type: 'post',
        data: 'ref_document_type_id=' + $ref_document_type_id + '&partner_type_id=' + $partner_type_id + '&partner_id=' + $partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#lbl_ref_document_identity').after('<i id="loader" class="fa fa-spinner fa-spin"></i>');

        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#ref_document_identity').select2('destroy');
                $('#ref_document_identity').html(json.html);
                $('#ref_document_identity').select2({width: '100%'});
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
    $('#addRefDocument').show();
});

$(document).on('click','#addRefDocument', function() {

    var $data = {
        partner_type_id : $('#partner_type_id').val(),
        partner_id : $('#partner_id').val(),
        ref_document_type_id : $('#ref_document_type_id').val(),
        ref_document_identity : $('#ref_document_identity').val()
    };

    var $details = [];
    $.ajax({
        url: $UrlGetRefDocument,
        dataType: 'json',
        type: 'post',
        data: $data,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#ref_document_id').before('<i id="loader" class="fa fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {

                $('[name="invoice_type"][value="'+json.data['invoice_type']+'"]').prop('checked', true).trigger('change');
                $('[name="invoice_type"]').attr('disabled', true);
                $('[name="invoice_type"][value="'+json.data['invoice_type']+'"]').parent().append('<input type="hidden" name="invoice_type" value="'+json.data['invoice_type']+'" />');


                $file_nos = json.file_nos;
                $.each(json.data['products'], function($i,$product) {
                    fillGrid($product, $file_nos);
                });
                console.log(json.po);
                $('#document_currency_name').val(json.po['document_currency_name']);
                $('#document_currency_id').val(json.po['document_currency_id']);
                $('#conversion_rate').val(json.po['conversion_rate']);
                $('#cost_center').val(json.po['cost_center']);
                $('#po_freight_master').val(json.po['freight_charges']);
                $('#remarks').val(json.po['manual_ref_no']);

                calculateTotal();
            }
            else {
                alert(json.error);
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
    // $('#addRefDocument').hide();
});

function fillGrid($obj) {

    // console.log( $obj )

    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';

    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][purchase_order_detail_id]" id="purchase_invoice_detail_purchase_order_detail_id_'+$grid_row+'" value="'+($obj['purchase_order_detail_id']||'')+'" />';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][goods_received_detail_id]" id="purchase_invoice_detail_goods_received_detail_id_'+$grid_row+'" value="'+($obj['goods_received_detail_id']||'')+'" />';

    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][ref_document_type_id]" id="purchase_invoice_detail_ref_document_type_id_'+$grid_row+'" value="'+$obj['ref_document_type_id']+'" />';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][ref_document_identity]" id="purchase_invoice_detail_ref_document_identity_'+$grid_row+'" value="'+$obj['ref_document_identity']+'" />';
    $html += '<a target="_blank" href="'+$obj['href']+'">'+$obj['ref_document_identity']+'</a>';
    $html += '</td>';


//    $html += '<td style="min-width: 150px;">';
//    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][project_id]" id="purchase_invoice_detail_project_id_'+$grid_row+'" value="'+$obj['project_id']+'" />';
//    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][sub_project_id]" id="purchase_invoice_detail_sub_project_id_'+$grid_row+'" value="'+$obj['sub_project_id']+'" />';
//    $html += '<input type="text" readonly class="form-control" value="'+$obj['project']+' - '+$obj['sub_project']+'" />';
//    $html += '</td>';


    $html += '    <td style="min-width: 250px;">';
    // Product Code
    $html += '<input type="hidden" style="min-width: 100px;" class="form-control" name="purchase_invoice_details['+$grid_row+'][product_code]" id="purchase_invoice_detail_product_code_'+$grid_row+'" value="'+$obj['product_code']+'" readonly/>';
    //Product Name
    $html += '<input type="hidden" id="purchase_invoice_detail_type_of_material_'+$grid_row+'" value="'+$obj['type_of_material']+'" />';
    $html += '<input type="hidden" class="form-control" name="purchase_invoice_details['+$grid_row+'][product_id]" id="purchase_invoice_detail_product_id_'+$grid_row+'" value="'+$obj['product_id']+'" readonly/>';
    $html += '<input style="width: 350px" type="text" class="form-control" name="purchase_invoice_details['+$grid_row+'][product_name]" id="purchase_invoice_detail_product_name_'+$grid_row+'" value="'+$obj['product_code']+' - '+$obj['product_name']+'" readonly/>';
    $html += '</td>';

    $html += '<td>';
    //Description
    $html += '<textarea style="width: 300px" rows="2" type="text" class="form-control" name="purchase_invoice_details['+$grid_row+'][description]" id="purchase_invoice_detail_description_'+$grid_row+'" >'+(!empty($obj['description'])?$obj['description']:$obj['product_name'])+'</textarea>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" name="purchase_invoice_details['+$grid_row+'][batch_no]" id="purchase_invoice_detail_batch_no_'+$grid_row+'" class="form-control">';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" name="purchase_invoice_details['+$grid_row+'][serial_no]" id="purchase_invoice_detail_serial_no_'+$grid_row+'" class="form-control fInteger" >';
    $html += '</td>';


    $html += '<td>';
    $html += '<input type="text" name="purchase_invoice_details['+$grid_row+'][unit] id="purchase_invoice_detail_unit_'+$grid_row+'" class="form-control" value="'+$obj['unit']+'" readonly>';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][unit_id]" id="purchase_invoice_detail_unit_id_'+$grid_row+'" class="form-control" value="'+$obj['unit_id']+'" readonly>';
    $html += '</td>';

    $html += '<td>';
    $html += '<select required class="form-control required" name="purchase_invoice_details['+$grid_row+'][warehouse_id]" id="purchase_invoice_detail_warehouse_id_'+$grid_row+'" >';
    $warehouses.forEach(function($warehouse){
        $html += '<option value="'+ $warehouse.warehouse_id +'">'+ $warehouse.name +'</option>';
    });
    $html += '</select>';
    $html += '<label for="purchase_invoice_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
    $html += '</td>';

    $html += '<td>';
    //Qty
    $html += '<input onchange="calculateCalcWeight(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][qty]" id="purchase_invoice_detail_qty_'+$grid_row+'" value="'+rDecimal($obj['balanced_qty'],4)+'" />';
    $html += '</td>';


    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px; ;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][unit_price]" id="purchase_invoice_detail_unit_price_'+$grid_row+'" value="'+$obj['rate']+'"  readonly />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][total_price]" id="purchase_invoice_detail_total_price_'+$grid_row+'" value="'+$obj['amount']+'" readonly />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][total_price_pkr]" id="purchase_invoice_detail_total_price_pkr_'+$grid_row+'" readonly />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][unit_price_pkr]" id="purchase_invoice_detail_unit_price_pkr_'+$grid_row+'" readonly />';
    $html += '</td>';

    $html += '<td class="hide">';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][freight_charges]" id="purchase_invoice_detail_freight_charges_'+$grid_row+'" value="0" readonly />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateTotalRow(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="purchase_invoice_details['+$grid_row+'][custom_duty]" id="purchase_invoice_detail_custom_duty_'+$grid_row+'" value="0"/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_additional_custom_duty_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][additional_custom_duty]" value="0" value="0"/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_regulatory_duty_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][regulatory_duty]" value="0" value="0"/>';
    $html += '</td>';

    $html += '<td hidden="hidden">';
    $html += '<input onchange="calculateSalesTaxAmount(this)" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][sales_tax_percent]" id="purchase_invoice_detail_sales_tax_percent_'+$grid_row+'" value="'+($obj['tax_percent']||0)+'" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateSalesTaxPercent(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="purchase_invoice_details['+$grid_row+'][sales_tax]" id="purchase_invoice_detail_sales_tax_'+$grid_row+'" value="'+($obj['tax_amount']||0)+'" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateTotalRow(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="purchase_invoice_details['+$grid_row+'][additional_sales_tax]" id="purchase_invoice_detail_additional_sales_tax_'+$grid_row+'" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateTotalRow(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="purchase_invoice_details['+$grid_row+'][income_tax]" id="purchase_invoice_detail_income_tax_'+$grid_row+'" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_duties_and_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_duties_and_charges]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_other_expense_and_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][other_expense_and_charges]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_other_duties_and_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_other_duties_and_charges]" value="0" readonly/>';
    $html += '</td>';


    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_landed_cost_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_landed_cost]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_net_unit_cost_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][net_unit_cost]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_additional_unit_cost_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][additional_unit_cost]" value="0" readonly/>';
    $html += '</td>';


    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';

    $('#tblPurchaseInvoice tbody').append($html);

    $grid_row++;

    // setFieldFormat();    
    calculateTotal();
}

$(document).on('click','.btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';

    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][ref_document_type_id]" id="purchase_invoice_detail_ref_document_type_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][ref_document_identity]" id="purchase_invoice_detail_ref_document_identity_'+$grid_row+'" value="" />';
    $html += '&nbsp;';
    $html += '</td>';

//    $html += '<td style="min-width: 150px;">';
//    $html += '<input type="hidden" id="purchase_invoice_detail_project_id_'+$grid_row+'" name="purchase_invoice_details['+$grid_row+'][project_id]" value="" />';
//    $html += '<select class="form-control Select2SubProject" id="purchase_invoice_detail_sub_project_id_'+$grid_row+'" name="purchase_invoice_details['+$grid_row+'][sub_project_id]"  style="width: 350px">';
//    $html += '</select>';
//   // $html += '<label for="purchase_invoice_detail_sub_project_id_'+$grid_row+'" class="error" style="display:none"></label>';
//    $html += '</td>';

    $html += '<td style="min-width: 250px;">';
    $html += '<input type="hidden" class="form-control" name="purchase_invoice_details['+$grid_row+'][product_code]" id="purchase_invoice_detail_product_code_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" id="purchase_invoice_detail_type_of_material_'+$grid_row+'" value="" />';
    $html += '<select style="width: 550px" class="required form-control Select2Product required" id="purchase_invoice_detail_product_id_'+$grid_row+'" name="purchase_invoice_details['+$grid_row+'][product_id]" required>';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<label for="purchase_invoice_detail_product_id_'+$grid_row+'" class="error" style="display:none;"></label>';
    $html += '</td>';


    $html += '<td>';
    $html += '<textarea style="width: 300px" rows="2" type="text" class="form-control" name="purchase_invoice_details['+$grid_row+'][description]" id="purchase_invoice_detail_description_'+$grid_row+'"></textarea>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" name="purchase_invoice_details['+$grid_row+'][batch_no]" id="purchase_invoice_detail_batch_no_'+$grid_row+'" class="form-control">';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" name="purchase_invoice_details['+$grid_row+'][serial_no]" id="purchase_invoice_detail_serial_no_'+$grid_row+'" class="form-control fInteger">';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" name="purchase_invoice_details['+$grid_row+'][unit]" id="purchase_invoice_detail_unit_'+$grid_row+'" class="form-control" readonly>';
    $html += '<input type="hidden" name="purchase_invoice_details['+$grid_row+'][unit_id]" id="purchase_invoice_detail_unit_id_'+$grid_row+'" class="form-control" readonly>';
    $html += '</td>';


    $html += '<td>';
    $html += '<select required class="form-control select2 required" name="purchase_invoice_details['+$grid_row+'][warehouse_id]" id="purchase_invoice_detail_warehouse_id_'+$grid_row+'" >';
    $html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse){
        $html += '<option value="'+ $warehouse.warehouse_id +'">'+ $warehouse.name +'</option>';
    });
    $html += '</select>';
    $html += '<label for="purchase_invoice_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateCalcWeight(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][qty]" id="purchase_invoice_detail_qty_'+$grid_row+'" value="1" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][unit_price]" id="purchase_invoice_detail_unit_price_'+$grid_row+'" value="0"/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_price_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_price]" value="0" readonly />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_price_pkr_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_price_pkr]" value="0" readonly />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px ;" class="form-control fPDecimal" id="purchase_invoice_detail_unit_price_pkr_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][unit_price_pkr]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td class="hide">';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_freight_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][freight_charges]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_custom_duty_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][custom_duty]" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_additional_custom_duty_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][additional_custom_duty]" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_regulatory_duty_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][regulatory_duty]" value="0" />';
    $html += '</td>';

    $html += '<td hidden="hidden">';
    $html += '<input onchange="calculateSalesTaxAmount(this)" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="purchase_invoice_details['+$grid_row+'][sales_tax_percent]" id="purchase_invoice_detail_sales_tax_percent_'+$grid_row+'" value="" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateSalesTaxPercent(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_sales_tax_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][sales_tax]" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_additional_sales_tax_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][additional_sales_tax]" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="purchase_invoice_detail_income_tax_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][income_tax]" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_duties_and_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_duties_and_charges]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_other_expense_and_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][other_expense_and_charges]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_other_duties_and_charges_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_other_duties_and_charges]" value="0" readonly/>';
    $html += '</td>';


    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_total_landed_cost_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][total_landed_cost]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_net_unit_cost_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][net_unit_cost]" value="0" readonly/>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="purchase_invoice_detail_additional_unit_cost_'+$grid_row+'"  name="purchase_invoice_details['+$grid_row+'][additional_unit_cost]" value="0" readonly/>';
    $html += '</td>';


    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';



    if($(this).parent().parent().data('row_id')=='H') {
        $('#tblPurchaseInvoice tbody').prepend($html);
    } else {
        $(this).parent().parent().after($html);
    }

    setFieldFormat();

    Select2SubProject('#purchase_invoice_detail_sub_project_id_'+$grid_row);
    $('#purchase_invoice_detail_sub_project_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        console.log( $data )
        $('#purchase_invoice_detail_project_id_'+$row_id).val($data['project_id']);
    });

    Select2ProductPurchaseInvoice('#purchase_invoice_detail_product_id_'+$grid_row);
    $('#purchase_invoice_detail_product_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        $('#purchase_invoice_detail_product_code_'+$row_id).val($data['product_code']);
        $('#purchase_invoice_detail_unit_id_'+$row_id).val($data['unit_id']);
        $('#purchase_invoice_detail_unit_'+$row_id).val($data['unit']);
        $('#purchase_invoice_detail_description_'+$row_id).val($data['description']);
    });

    $('#purchase_invoice_detail_warehouse_id_'+$grid_row).select2({'width':'100%'});

    $grid_row++;
    calculateTotal();
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
                //console.log(json.file_no);
                $('#purchase_invoice_detail_product_code_'+$row_id).val(json.product['product_code']);
                // $('#purchase_invoice_detail_unit_id_'+$row_id).html(json.unit).trigger('change');
                $('#purchase_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#purchase_invoice_detail_unit_'+$row_id).val(json.product['unit']);
                $('#purchase_invoice_detail_description_'+$row_id).val(json.product['description']);

                var $html = '<option value="">&nbsp;</option>';
                $.each(json.file_no, function(key, $file) {
                    console.log($file);
                    $html += '<option value="'+$file['manual_ref_no']+'">'+$file['manual_ref_no']+'</option>';
                });

                // $('#purchase_invoice_detail_file_no_' + $row_id).html($html).trigger('change');
                $('#purchase_invoice_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('#purchase_invoice_detail_rate_'+$row_id).trigger('change');
                $('#purchase_invoice_detail_discount_percent_'+$row_id).trigger('change');
                $('#purchase_invoice_detail_tax_percent_'+$row_id).trigger('change');
            }
            else {
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
            $('#purchase_invoice_detail_product_id_'+$row_id).select2('destroy');
            if(json.success)
            {

                //console.log(json.product);
                $('#purchase_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#purchase_invoice_detail_unit_'+$row_id).val(json.product['unit']);
                $('#purchase_invoice_detail_product_id_'+$row_id).html('<option selected="selected" value="'+json.product['product_id']+'">'+json.product['name']+'</option>');
                $('#purchase_invoice_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('#purchase_invoice_detail_description_'+$row_id).val(json.product['description']);
//                $('#purchase_invoice_detail_file_no_'+$row_id).val(json.file_no['manual_ref_no']);
                //json.product['description'].replace(/[^a-zA-Z0-9]/g, '');

                $('#purchase_invoice_detail_rate_'+$row_id).trigger('change');
                $('#purchase_invoice_detail_discount_percent_'+$row_id).trigger('change');
                $('#purchase_invoice_detail_tax_percent_'+$row_id).trigger('change');
                $('#purchase_invoice_detail_product_id_'+$row_id).trigger('change');
            } else {
                alert(json.error);
                $('#purchase_invoice_detail_unit_id_'+$row_id).val('');
                $('#purchase_invoice_detail_unit_'+$row_id).val('');
                $('#purchase_invoice_detail_product_id_'+$row_id).html('');
                $('#purchase_invoice_detail_rate_'+$row_id).val('0.00');
                $('#purchase_invoice_detail_description_'+$row_id).val('');
            }
            $('#purchase_invoice_detail_product_id_'+$row_id).select2({
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
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

function setProductInformation($obj) {
    var $data = $($obj).data();
    console.log($data);
    var $row_id = $('#'+$data['element']).parent().parent().parent().data('row_id');
    $('#_modal').modal('hide');
    $('#purchase_invoice_detail_product_code_'+$row_id).val($data['product_code']);
    $('#purchase_invoice_detail_cubic_meter_'+$row_id).val($data['cubic_meter']);
    $('#purchase_invoice_detail_cubic_feet_'+$row_id).val($data['cubic_feet']);
    $('#purchase_invoice_detail_unit_id_'+$row_id).val($data['unit_id']);
    $('#purchase_invoice_detail_unit_'+$row_id).val($data['unit']);
    $('#purchase_invoice_detail_description_'+$row_id).val($data['name']);
    $('#purchase_invoice_detail_rate_'+$row_id).val($data['cost_price']);
    $('#purchase_invoice_detail_product_id_'+$row_id).select2('destroy');
    $('#purchase_invoice_detail_product_id_'+$row_id).html('<option selected="selected" value="'+$data['product_id']+'">'+$data['name']+'</option>');
    $('#purchase_invoice_detail_product_id_'+$row_id).select2({
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
}



function removeRow($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}


$(document).on('click','.btnAddExpense', function() {
    $html = '';
    $html += '<tr id="expense_row_'+$expense_row+'" data-expense_row="'+$expense_row+'">';
    $html += '<td>';
    $html += '<a onclick="removeExpense(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '<td>';
//    $html += '<select class="form-control select2" id="purchase_invoice_expense_'+$expense_row+'_coa_id" name="purchase_invoice_expenses['+$expense_row+'][coa_id]" >';
//    $html += '<option value="">&nbsp;</option>';
//    $coas.forEach(function($coa) {
//        $html += '<option value="'+$coa.coa_level3_id+'">'+$coa.level3_display_name+'</option>';
//    });
//    $html += '</select>';
    $html += '<input type="text" style="min-width: 100px;"" class="form-control" name="purchase_invoice_expenses['+$expense_row+'][description]" id="purchase_invoice_expense_'+$expense_row+'_description" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateExpense(this);" type="text" style="min-width: 100px;"" class="form-control fPdecimal text-right" name="purchase_invoice_expenses['+$expense_row+'][expense_amount]" id="purchase_invoice_expense_'+$expense_row+'_expense_amount" value="" />';
    $html += '</td>';
    $html += '</tr>';


    $('#tblExpense tbody').prepend($html);

    $('#purchase_invoice_expense_'+$expense_row+'_coa_id').select2({width: '100%'});
    $('#purchase_invoice_expense_'+$expense_row+'_coa_id').trigger('change');
    $expense_row++;

});

function removeExpense($obj) {
    var $row_id = $($obj).parent().parent().data('expense_row');
    $('#expense_row_'+$row_id).remove();
    calculateExpense($obj);
}

$(document).on('click','.btnAddSalesTax', function() {

    $html = '';
    $html += '<tr id="sales_tax_row_'+$sales_tax_row+'" data-sales_tax_row="'+$sales_tax_row+'">';
    $html += '<td>';
    $html += '<a onclick="removeSalesTax(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '<td>';
    $html += '<select class="form-control select2"  name="purchase_invoice_sales_tax['+$sales_tax_row+'][coa_id]" id="purchase_invoice_sales_tax_'+$sales_tax_row+'_coa_id"  >';
    $html += '<option value="">&nbsp;</option>';
    $coas.forEach(function($coa) {
        $html += '<option value="'+$coa.coa_level3_id+'">'+$coa.name+'</option>';
    });
    $html += '</select>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateSalesTax(this);" type="text" style="min-width: 100px;" class="form-control fPdecimal text-right" name="purchase_invoice_sales_tax['+$sales_tax_row+'][sales_tax_amount]" id="purchase_invoice_sales_tax_'+$sales_tax_row+'_sales_tax_amount" value="" />';
    $html += '</td>';
    $html += '</tr>';


    $('#tblSalesTax tbody').prepend($html);

    $sales_tax_row++;
    setFieldFormat();
});



// Calculations

function calculateCalcWeight($obj)
{
    var $row_id = $($obj).parents('tr').data('row_id');
    var $qty = parseFloat($('#purchase_invoice_detail_qty_'+$row_id).val())||0;
    var $base_calc_weight = parseFloat($('#purchase_invoice_detail_base_calc_weight_'+$row_id).val())||0;

    $('#purchase_invoice_detail_calc_weight_'+$row_id).val(rDecimal(($qty*$base_calc_weight),4));

    calculateTotal();
}



function calculateTotalRow($obj)
{
    calculateTotal();
}

// Conversion
$('#conversion_rate').on('change', function(){
    calculateTotal();
});

function calculateTotal($calcData)
{
    var $total_qty = 0;
    var $total_actual_weight = 0;
    var $total_price_master = 0;
    var $total_price_pkr_master = 0;
    var $total_custom_duty = 0;
    var $total_additional_custom_duty = 0;
    var $total_regulatory_duty = 0;
    var $total_sales_tax = 0;
    var $total_additional_sales_tax = 0;
    var $total_income_tax = 0;
    var $total_duties_and_charges = 0;
    var $total_other_duties_master = 0;
    var $total_landed_cost_master = 0;
    var $net_unit_cost_master = 0;
    $('#tblPurchaseInvoice tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        // Qty
        var $qty = parseFloat($('#purchase_invoice_detail_qty_'+$row_id).val())||0.00;

        // Total Price
        var $unit_price = parseFloat($('#purchase_invoice_detail_unit_price_'+$row_id).val())||0.00;
        var $calc_weight = parseFloat($('#purchase_invoice_detail_calc_weight_'+$row_id).val())||0.00;
        var $type_of_material = $('#purchase_invoice_detail_type_of_material_' + $row_id).val();

        // Qty * Unit Price (Rate)
        var $total_price = ($qty*$unit_price);

        if( $type_of_material.toLowerCase() == 'sheet' )
        {
            // Weight * Unit Price (Rate)
            $total_price = ($calc_weight*$unit_price);
        }

        $('#purchase_invoice_detail_total_price_'+$row_id).val(rDecimal($total_price,2));

        // Total Price (PKR)
        var $conversion_rate = parseFloat($('#conversion_rate').val())||1;
        var $total_price_pkr = ($conversion_rate*$total_price);
        $('#purchase_invoice_detail_total_price_pkr_'+$row_id).val(rDecimal($total_price_pkr,2));

        // Unit Price (PKR) (Total Price PKR / Qty)
        $unit_price_pkr = ($total_price_pkr/$qty);

        if( $type_of_material.toLowerCase() == 'sheet' )
        {
            // Unit Price (PKR) (Total Price PKR / Calc Weight)
            $unit_price_pkr = ($total_price_pkr/$calc_weight);
        }

        $('#purchase_invoice_detail_unit_price_pkr_'+$row_id).val(rDecimal($unit_price_pkr,2));


        var $custom_duty = parseFloat($('#purchase_invoice_detail_custom_duty_'+$row_id).val())||0.00;
        var $additional_custom_duty = parseFloat($('#purchase_invoice_detail_additional_custom_duty_'+$row_id).val())||0.00;
        var $regulatory_duty = parseFloat($('#purchase_invoice_detail_regulatory_duty_'+$row_id).val())||0.00;
        var $sales_tax = parseFloat($('#purchase_invoice_detail_sales_tax_'+$row_id).val())||0.00;
        var $additional_sales_tax = parseFloat($('#purchase_invoice_detail_additional_sales_tax_'+$row_id).val())||0.00;
        var $income_tax = parseFloat($('#purchase_invoice_detail_income_tax_'+$row_id).val())||0.00;

        // Total Duties
        var $total_duties = ($custom_duty+$additional_custom_duty+$regulatory_duty+$sales_tax+$additional_sales_tax+$income_tax);
        $('#purchase_invoice_detail_total_duties_and_charges_'+$row_id).val(rDecimal($total_duties,0));

        // Total Other Duties & Charges
        var $total_freight = parseFloat($('#purchase_invoice_detail_freight_charges_'+$row_id).val())||0.00;
        var $other_expense_and_charges = parseFloat($('#purchase_invoice_detail_other_expense_and_charges_'+$row_id).val())||0.00;
        var $other_duties_and_charges = ($total_duties+$total_freight+$other_expense_and_charges);
        $('#purchase_invoice_detail_total_other_duties_and_charges_'+$row_id).val(rDecimal($other_duties_and_charges, 2));

        // Total Landed Cost
        var $total_landed_cost = ($other_duties_and_charges+$total_price_pkr);
        $('#purchase_invoice_detail_total_landed_cost_'+$row_id).val(rDecimal($total_landed_cost,2));

        // Total Landed Cost / Qty)
        var $net_unit_cost = ($total_landed_cost/$qty);

        if( $type_of_material.toLowerCase() == 'sheet' )
        {
            // Total Landed Cost / Calc Weight)
            $net_unit_cost = ($total_landed_cost/$calc_weight);
        }

        $('#purchase_invoice_detail_net_unit_cost_'+$row_id).val(rDecimal($net_unit_cost,2));

        // Add. Unit Cost
        var $additional_unit_cost = ($net_unit_cost-$unit_price_pkr);
        $('#purchase_invoice_detail_additional_unit_cost_'+$row_id).val(rDecimal($additional_unit_cost,2));


        // Grid Line wise Total
        $total_qty += $qty;
        $total_actual_weight += $calc_weight;
        $total_price_master += $total_price;
        $total_price_pkr_master += $total_price_pkr;
        $total_custom_duty += $custom_duty;
        $total_additional_custom_duty += $additional_custom_duty;
        $total_regulatory_duty += $regulatory_duty;
        $total_sales_tax += $sales_tax;
        $total_additional_sales_tax += $additional_sales_tax;
        $total_income_tax += $income_tax;
        $total_duties_and_charges += $total_duties;
        $total_other_duties_master += $other_duties_and_charges;
        $total_landed_cost_master += $total_landed_cost;
        net_unit_cost_master += $net_unit_cost;

    });


    // Master TOtal
    $('#qty_master').val(rDecimal($total_qty,4));
    $('#total_calc_weight_master').val(rDecimal($total_actual_weight,4));
    $('#total_price_master').val(rDecimal($total_price_master,2));
    $('#total_price_pkr_master').val(rDecimal($total_price_pkr_master,2));
    $('#custom_duty_master').val(rDecimal($total_custom_duty,0));
    $('#additional_custom_duty_master').val(rDecimal($total_additional_custom_duty,0));
    $('#regulatory_duty_master').val(rDecimal($total_regulatory_duty,0));
    $('#sales_tax_master').val(rDecimal($total_sales_tax,0));
    $('#additional_sales_tax_master').val(rDecimal($total_additional_sales_tax,0));
    $('#income_tax_master').val(rDecimal($total_income_tax,0));
    $('#total_duties_master').val(rDecimal($total_duties_and_charges,0));
    $('#total_other_duties_master').val(rDecimal($total_other_duties_master,2));
    $('#total_landed_cost_master').val(rDecimal($total_landed_cost_master,2));
    $('#net_unit_cost_master').val(rDecimal($net_unit_cost_master,2));

    if( !$calcData )
    {
        calculateData();
    }

}


// Calc Data
function calculateData()
{
    var $total_freight = parseFloat($('#freight_master').val())||0.00;
    var $total_weight = parseFloat($('#total_calc_weight_master').val())||0.00;

    $('#tblPurchaseInvoice tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        var $calc_weight = parseFloat($('#purchase_invoice_detail_calc_weight_'+$row_id).val())||0.00;
        var $freight_charges = (($calc_weight/$total_weight)*$total_freight);
        $('#purchase_invoice_detail_freight_charges_'+$row_id).val(rDecimal($freight_charges,2));
    });

    var $total_other_expense_master = parseFloat($('#total_other_expense_master').val())||0.00;
    var $total_price_pkr_master = parseFloat($('#total_price_pkr_master').val())||0.00;

    $('#tblPurchaseInvoice tbody tr').each(function(){
        $row_id = $(this).data('row_id');
        var $total_price_pkr = parseFloat($('#purchase_invoice_detail_total_price_pkr_'+$row_id).val())||0.00;
        var $other_expense_and_charges = (($total_other_expense_master/$total_price_pkr_master)*$total_price_pkr);
        $('#purchase_invoice_detail_other_expense_and_charges_'+$row_id).val(rDecimal($other_expense_and_charges,2));
    });

    calculateTotal(true);

}


// Freight Master
function calculateTotalFreight()
{
    var $total_freight = parseFloat($('#freight_master').val())||0.00;
    var $total_weight = parseFloat($('#total_calc_weight_master').val())||0.00;

    $('#tblPurchaseInvoice tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        var $calc_weight = parseFloat($('#purchase_invoice_detail_calc_weight_'+$row_id).val())||0.00;
        var $freight_charges = (($calc_weight/$total_weight)*$total_freight);
        $('#purchase_invoice_detail_freight_charges_'+$row_id).val(rDecimal($freight_charges,2));
    });

    calculateTotal();

}

// Other Expense
function calculateOtherExpense()
{
    var $total_other_expense_master = parseFloat($('#total_other_expense_master').val())||0.00;
    var $total_price_pkr_master = parseFloat($('#total_price_pkr_master').val())||0.00;

    $('#tblPurchaseInvoice tbody tr').each(function(){
        $row_id = $(this).data('row_id');
        var $total_price_pkr = parseFloat($('#purchase_invoice_detail_total_price_pkr_'+$row_id).val())||0.00;
        var $other_expense_and_charges = (($total_other_expense_master/$total_price_pkr_master)*$total_price_pkr);
        $('#purchase_invoice_detail_other_expense_and_charges_'+$row_id).val(rDecimal($other_expense_and_charges,2));
    });

    calculateTotalFreight();

}

// Sales Tax (remove)
function removeSalesTax($obj) {
    var $row_id = $($obj).parent().parent().data('sales_tax_row');
    $('#sales_tax_row_'+$row_id).remove();
    calculateSalesTax($obj);
}


// Expense
function calculateExpense(obj) {
    var $total_expense = 0;
    $('#tblExpense tbody tr').each(function() {
        var $row_id = $(this).data('expense_row');
        var $expense_amount = parseFloat($('#purchase_invoice_expense_' + $row_id+'_expense_amount').val())||0.00;

        $total_expense += $expense_amount;
    })
    $('#expense_total').val(rDecimal($total_expense,2));
    $('#total_other_expense_master').val(rDecimal($total_expense,2));

    calculateOtherExpense();

}

// Sales Tax
function calculateSalesTax(obj) {
    var $total_sales_tax = 0;
    $('#tblSalesTax tbody tr').each(function() {
        var $row_id = $(this).data('sales_tax_row');
        var $sales_tax_amount = parseFloat($('#purchase_invoice_sales_tax_' + $row_id+'_sales_tax_amount').val())||0.00;

        $total_sales_tax += $sales_tax_amount;
    })
    $('#sales_tax_total').val(rDecimal($total_sales_tax,2));
    calculateTotal();
}


// Tax Percentage
function calculateSalesTaxAmount($obj)
{
    var $row_id = $($obj).parents('tr').data('row_id');

    var $tax_percent = parseInt($('#purchase_invoice_detail_sales_tax_percent_'+$row_id).val())||0;
    var $total_price_pkr = parseInt($('#purchase_invoice_detail_total_price_pkr_'+$row_id).val())||0;

    var $tax_amount = (($total_price_pkr*$tax_percent)/100);
    $('#purchase_invoice_detail_sales_tax_'+$row_id).val( $tax_amount );

    calculateTotal();

}

// Tax Amount
function calculateSalesTaxPercent($obj) {

    var $row_id = $($obj).parents('tr').data('row_id');

    var $tax_amount = parseFloat($('#purchase_invoice_detail_sales_tax_'+$row_id).val())||0;
    var $total_price_pkr = parseFloat($('#purchase_invoice_detail_total_price_pkr_'+$row_id).val())||0;
    var $tax_percent = roundUpto($tax_amount / $total_price_pkr * 100,2);

    $('#purchase_invoice_detail_sales_tax_percent_' + $row_id).val($tax_percent);
    calculateTotal();
}


function document_reset()
{
    $('#tblPurchaseInvoice tbody').empty();
    $('#tblExpense tbody').empty();
    $('#tblSalesTax tbody').empty();

    $('#freight_master').val(0.00);
    $('#total_other_expense_master').val(0.00);
    $('#expense_total').val(0.00);
    $('#sales_tax_total').val(0.00);

    calculateTotal();
}