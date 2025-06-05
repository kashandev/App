/**
 * Created by Huzaifa on 9/18/15.
 */
// $(document).on('change','#document_currency_id', function() {
//     $currency_id = $(this).val();
//     $.ajax({
//         url: $UrlGetCurrency,
//         dataType: 'json',
//         type: 'post',
//         data: 'currency_id=' + $currency_id,
//         mimeType:"multipart/form-data",
//         beforeSend: function() {
//             $('#document_currency_id').before('<i id="loader" class="fa fa-spinner fa-spin"></i>');
//         },
//         complete: function() {
//             $('#loader').remove();
//         },
//         success: function(json) {
//             if(json.success)
//             {
//                 $('#conversion_rate').val(json.currency_value);
//             }
//             else {
//                 alert(json.error);
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     })
// });

// $(document).on('change','#partner_type_id', function() {
//     $partner_type_id = $(this).val();
//     $.ajax({
//         url: $UrlGetPartner,
//         dataType: 'json',
//         type: 'post',
//         data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id,
//         mimeType:"multipart/form-data",
//         beforeSend: function() {
//             $('#partner_id').before('<i id="loader" class="fa fa-spinner fa-spin"></i>');
//         },
//         complete: function() {
//             $('#loader').remove();
//         },
//         success: function(json) {
//             if(json.success)
//             {
//                 $('#partner_id').select2('destroy');
//                 $('#partner_id').html(json.html);
//                 $('#partner_id').select2({width:'100%'});
//             }
//             else {
//                 alert(json.error);
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     })
// });

// $(document).on('change','#partner_id', function() {

//     document_reset();

//     $partner_id = $(this).val();
//     if($partner_id != '') {
//         $('#ref_document_type_id').select2('destroy');
//         $options = '<option value="">&nbsp;</option>';
//         $options += '<option value="4">'+$lang['purchase_order']+'</option>';
//         $options += '<option value="17">'+$lang['goods_received']+'</option>';
//         $('#ref_document_type_id').html($options);
//         $('#ref_document_type_id').select2({width: '100%'});
//     } else {
//         $('#ref_document_type_id').select2('destroy');
//         $('#ref_document_type_id').html('');
//         $('#ref_document_type_id').select2({width: '100%'});
//     }
//     $('#ref_document_identity').select2('destroy');
//     $('#ref_document_identity').html('<option value="">&nbsp;</option>');
//     $('#ref_document_identity').select2({width: '100%'});

// });

// $(document).on('change','#ref_document_type_id', function() {

//     document_reset();

//     var $partner_type_id = $('#partner_type_id').val();
//     var $partner_id = $('#partner_id').val();
//     var $ref_document_type_id = $(this).val();

//     $UrlGetOrders = '';

//     if( $ref_document_type_id == '4' )
//     {
//         $UrlGetOrders = $UrlGetPuchaseOrder;
//     }
//     else if( $ref_document_type_id == '17' )
//     {
//         $UrlGetOrders = $UrlGetGoodsReceived;
//     }


//     $.ajax({
//         url: $UrlGetOrders,
//         dataType: 'json',
//         type: 'post',
//         data: 'ref_document_type_id=' + $ref_document_type_id + '&partner_type_id=' + $partner_type_id + '&partner_id=' + $partner_id,
//         mimeType:"multipart/form-data",
//         beforeSend: function() {
//             $('#lbl_ref_document_identity').after('<i id="loader" class="fa fa-spinner fa-spin"></i>');

//         },
//         complete: function() {
//             $('#loader').remove();
//         },
//         success: function(json) {
//             if(json.success)
//             {
//                 $('#ref_document_identity').select2('destroy');
//                 $('#ref_document_identity').html(json.html);
//                 $('#ref_document_identity').select2({width: '100%'});
//             }
//             else {
//                 alert(json.error);
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     })
//     $('#addRefDocument').show();
// });

// $(document).on('click','#addRefDocument', function() {

//     var $data = {
//         partner_type_id : $('#partner_type_id').val(),
//         partner_id : $('#partner_id').val(),
//         ref_document_type_id : $('#ref_document_type_id').val(),
//         ref_document_identity : $('#ref_document_identity').val()
//     };

//     var $details = [];
//     $.ajax({
//         url: $UrlGetRefDocument,
//         dataType: 'json',
//         type: 'post',
//         data: $data,
//         mimeType:"multipart/form-data",
//         beforeSend: function() {
//             $('#ref_document_id').before('<i id="loader" class="fa fa-spinner fa-spin"></i>');
//         },
//         complete: function() {
//             $('#loader').remove();
//         },
//         success: function(json) {
//             if(json.success)
//             {

//                 $('[name="invoice_type"][value="'+json.data['invoice_type']+'"]').prop('checked', true).trigger('change');
//                 $('[name="invoice_type"]').attr('disabled', true);
//                 $('[name="invoice_type"][value="'+json.data['invoice_type']+'"]').parent().append('<input type="hidden" name="invoice_type" value="'+json.data['invoice_type']+'" />');


//                 $file_nos = json.file_nos;
//                 $.each(json.data['products'], function($i,$product) {
//                     fillGrid($product, $file_nos);
//                 });
//                 console.log(json.po);
//                 $('#document_currency_name').val(json.po['document_currency_name']);
//                 $('#document_currency_id').val(json.po['document_currency_id']);
//                 $('#conversion_rate').val(json.po['conversion_rate']);
//                 $('#cost_center').val(json.po['cost_center']);
//                 $('#po_freight_master').val(json.po['freight_charges']);
//                 $('#remarks').val(json.po['manual_ref_no']);

//                 calculateTotal();
//             }
//             else {
//                 alert(json.error);
//             }

//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             console.log(xhr.responseText);
//         }
//     })
//     // $('#addRefDocument').hide();
// });

// function fillGrid($obj) {

//     // console.log( $obj )

//     $html = '';
//     $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';

//     $html += '<td>';
//     $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
//     $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][purchase_order_detail_id]" id="stock_in_detail_purchase_order_detail_id_'+$grid_row+'" value="'+($obj['purchase_order_detail_id']||'')+'" />';
//     $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][goods_received_detail_id]" id="stock_in_detail_goods_received_detail_id_'+$grid_row+'" value="'+($obj['goods_received_detail_id']||'')+'" />';

//     $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][ref_document_type_id]" id="stock_in_detail_ref_document_type_id_'+$grid_row+'" value="'+$obj['ref_document_type_id']+'" />';
//     $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][ref_document_identity]" id="stock_in_detail_ref_document_identity_'+$grid_row+'" value="'+$obj['ref_document_identity']+'" />';
//     $html += '<a target="_blank" href="'+$obj['href']+'">'+$obj['ref_document_identity']+'</a>';
//     $html += '</td>';


// //    $html += '<td style="min-width: 150px;">';
// //    $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][project_id]" id="stock_in_detail_project_id_'+$grid_row+'" value="'+$obj['project_id']+'" />';
// //    $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][sub_project_id]" id="stock_in_detail_sub_project_id_'+$grid_row+'" value="'+$obj['sub_project_id']+'" />';
// //    $html += '<input type="text" readonly class="form-control" value="'+$obj['project']+' - '+$obj['sub_project']+'" />';
// //    $html += '</td>';


//     $html += '    <td style="min-width: 250px;">';
//     // Product Code
//     $html += '<input type="hidden" style="min-width: 100px;" class="form-control" name="stock_in_details['+$grid_row+'][product_code]" id="stock_in_detail_product_code_'+$grid_row+'" value="'+$obj['product_code']+'" readonly/>';
//     //Product Name
//     $html += '<input type="hidden" id="stock_in_detail_type_of_material_'+$grid_row+'" value="'+$obj['type_of_material']+'" />';
//     $html += '<input type="hidden" class="form-control" name="stock_in_details['+$grid_row+'][product_id]" id="stock_in_detail_product_id_'+$grid_row+'" value="'+$obj['product_id']+'" readonly/>';
//     $html += '<input style="width: 350px" type="text" class="form-control" name="stock_in_details['+$grid_row+'][product_name]" id="stock_in_detail_product_name_'+$grid_row+'" value="'+$obj['product_code']+' - '+$obj['product_name']+'" readonly/>';
//     $html += '</td>';

//     $html += '<td>';
//     //Description
//     $html += '<textarea style="width: 300px" rows="2" type="text" class="form-control" name="stock_in_details['+$grid_row+'][description]" id="stock_in_detail_description_'+$grid_row+'" >'+(!empty($obj['description'])?$obj['description']:$obj['product_name'])+'</textarea>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" name="stock_in_details['+$grid_row+'][batch_no]" id="stock_in_detail_batch_no_'+$grid_row+'" class="form-control">';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" name="stock_in_details['+$grid_row+'][serial_no]" id="stock_in_detail_serial_no_'+$grid_row+'" class="form-control fInteger" >';
//     $html += '</td>';


//     $html += '<td>';
//     $html += '<input type="text" name="stock_in_details['+$grid_row+'][unit] id="stock_in_detail_unit_'+$grid_row+'" class="form-control" value="'+$obj['unit']+'" readonly>';
//     $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][unit_id]" id="stock_in_detail_unit_id_'+$grid_row+'" class="form-control" value="'+$obj['unit_id']+'" readonly>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<select required class="form-control required" name="stock_in_details['+$grid_row+'][warehouse_id]" id="stock_in_detail_warehouse_id_'+$grid_row+'" >';
//     $warehouses.forEach(function($warehouse){
//         $html += '<option value="'+ $warehouse.warehouse_id +'">'+ $warehouse.name +'</option>';
//     });
//     $html += '</select>';
//     $html += '<label for="stock_in_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
//     $html += '</td>';

//     $html += '<td>';
//     //Qty
//     $html += '<input onchange="calculateCalcWeight(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][qty]" id="stock_in_detail_qty_'+$grid_row+'" value="'+rDecimal($obj['balanced_qty'],4)+'" />';
//     $html += '</td>';


//     $html += '<td>';
//     $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px; ;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][unit_price]" id="stock_in_detail_unit_price_'+$grid_row+'" value="'+$obj['rate']+'"  readonly />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][total_price]" id="stock_in_detail_total_price_'+$grid_row+'" value="'+$obj['amount']+'" readonly />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][total_price_pkr]" id="stock_in_detail_total_price_pkr_'+$grid_row+'" readonly />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][unit_price_pkr]" id="stock_in_detail_unit_price_pkr_'+$grid_row+'" readonly />';
//     $html += '</td>';

//     $html += '<td class="hide">';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][freight_charges]" id="stock_in_detail_freight_charges_'+$grid_row+'" value="0" readonly />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input onchange="calculateTotalRow(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="stock_in_details['+$grid_row+'][custom_duty]" id="stock_in_detail_custom_duty_'+$grid_row+'" value="0"/>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="stock_in_detail_additional_custom_duty_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][additional_custom_duty]" value="0" value="0"/>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" onchange="calculateTotalRow(this)" style="min-width: 100px;" class="form-control fPInteger" id="stock_in_detail_regulatory_duty_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][regulatory_duty]" value="0" value="0"/>';
//     $html += '</td>';

//     $html += '<td hidden="hidden">';
//     $html += '<input onchange="calculateSalesTaxAmount(this)" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][sales_tax_percent]" id="stock_in_detail_sales_tax_percent_'+$grid_row+'" value="'+($obj['tax_percent']||0)+'" />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input onchange="calculateSalesTaxPercent(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="stock_in_details['+$grid_row+'][sales_tax]" id="stock_in_detail_sales_tax_'+$grid_row+'" value="'+($obj['tax_amount']||0)+'" />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input onchange="calculateTotalRow(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="stock_in_details['+$grid_row+'][additional_sales_tax]" id="stock_in_detail_additional_sales_tax_'+$grid_row+'" value="0" />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input onchange="calculateTotalRow(this)" type="text" style="min-width: 100px;" class="form-control fPInteger" name="stock_in_details['+$grid_row+'][income_tax]" id="stock_in_detail_income_tax_'+$grid_row+'" value="0" />';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_total_duties_and_charges_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][total_duties_and_charges]" value="0" readonly/>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_other_expense_and_charges_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][other_expense_and_charges]" value="0" readonly/>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_total_other_duties_and_charges_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][total_other_duties_and_charges]" value="0" readonly/>';
//     $html += '</td>';


//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_total_landed_cost_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][total_landed_cost]" value="0" readonly/>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_net_unit_cost_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][net_unit_cost]" value="0" readonly/>';
//     $html += '</td>';

//     $html += '<td>';
//     $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_additional_unit_cost_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][additional_unit_cost]" value="0" readonly/>';
//     $html += '</td>';


//     $html += '<td>';
//     $html += '<a title="Add" class="btn btn-xs btn-primary `btnAd`dGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
//     $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
//     $html += '</td>';
//     $html += '</tr>';

//     $('#tblStockIn tbody').append($html);

//     $grid_row++;

//     // setFieldFormat();    
//     calculateTotal();
// }

$(document).on('click','.btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="getProductByCode(this)" type="text" class="form-control Select2Product" name="stock_in_details['+$grid_row+'][product_code]" id="stock_in_detail_product_code_'+$grid_row+'" value="" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" style="min-width: 100px;" name="stock_in_details['+$grid_row+'][serial_no]" id="stock_in_detail_serial_no_'+$grid_row+'" class="form-control">';   
    $html += '<select style="width: 300px" class="required form-control Select2Product required" id="stock_in_detail_product_id_'+$grid_row+'" name="stock_in_details['+$grid_row+'][product_id]" required>';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<label for="stock_in_detail_product_id_'+$grid_row+'" class="error" style="display:none;"></label>';
    $html += '</td>';

    $html += '<td>';
    $html += '<textarea style="width: 200px" rows="2" type="text" class="form-control" name="stock_in_details['+$grid_row+'][description]" id="stock_in_detail_description_'+$grid_row+'"></textarea>';
    $html += '</td>';

    $html += '<td>';
    $html += '<select style="width: 300px" required class="form-control select2 required" name="stock_in_details['+$grid_row+'][warehouse_id]" id="stock_in_detail_warehouse_id_'+$grid_row+'" >';
    //$html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse){
        $html += '<option value="'+ $warehouse.warehouse_id +'">'+ $warehouse.name +'</option>';
    });
    $html += '</select>';
    $html += '<label for="stock_in_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" name="stock_in_details['+$grid_row+'][unit_id]" id="stock_in_detail_unit_id_'+$grid_row+'" class="form-control" readonly>';  
    $html += '<input type="text" name="stock_in_details['+$grid_row+'][unit]" id="stock_in_detail_unit_'+$grid_row+'" class="form-control" readonly>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input onchange="calculateQuantity(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][qty]" id="stock_in_detail_qty_'+$grid_row+'" value="0" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px;" class="form-control fPDecimal" name="stock_in_details['+$grid_row+'][unit_price]" id="stock_in_detail_unit_price_'+$grid_row+'" value="0" />';
    $html += '</td>';


    $html += '<td>';
    $html += '<input type="text" onchange="calculateTotalRow(this);" style="min-width: 100px;" class="form-control fPDecimal" id="stock_in_detail_total_price_'+$grid_row+'"  name="stock_in_details['+$grid_row+'][total_price]" value="0" readonly />';
    $html += '</td>';

    $html += '<td style="width:10px;">';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';



    if($(this).parent().parent().data('row_id')=='H') {
        $('#tblStockIn tbody').prepend($html);
    } else {
        $(this).parent().parent().after($html);
    }

    setFieldFormat();

    // Select2SubProject('#stock_in_detail_sub_project_id_'+$grid_row);
    // $('#stock_in_detail_sub_project_id_'+$grid_row).on('select2:select', function (e) {
    //     var $row_id = $(this).parent().parent().data('row_id');
    //     var $data = e.params.data;
    //     console.log( $data )
    //     $('#stock_in_detail_project_id_'+$row_id).val($data['project_id']);
    // });

    Select2StockIn('#stock_in_detail_product_id_'+$grid_row);
    $('#stock_in_detail_product_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        $('#stock_in_detail_product_code_'+$row_id).val($data['product_code']).trigger('change');
    });

    $('#stock_in_detail_warehouse_id_'+$grid_row).select2({'width':'100%'});

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
                $('#stock_in_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#stock_in_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#stock_in_detail_unit_'+$row_id).val(json.product['unit']);
                $('#stock_in_detail_description_'+$row_id).val(json.product['description']);
                $('#stock_in_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('#stock_in_detail_unit_price_'+$row_id).trigger('change');
            }
            else {
                alert(json.error);
                $('#stock_in_detail_product_code_'+$row_id).val('');
                $('#stock_in_detail_unit_id_'+$row_id).val('');
                $('#stock_in_detail_unit_'+$row_id).val('');
                $('#stock_in_detail_product_id_'+$row_id).select2('destroy');
                $('#stock_in_detail_product_id_'+$row_id).html('');
                $('#stock_in_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#stock_in_detail_description_'+$row_id).val('');
                $('#stock_in_detail_unit_price_'+$row_id).val(0);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    });
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
            //$('#stock_in_detail_product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#stock_in_detail_product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            if(json.success)
            {
            	console.log(json)
            	getProductSerialNo($row_id);
                $('#stock_in_detail_description_'+$row_id).val(json.product['name']);
                $('#stock_in_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#stock_in_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#stock_in_detail_unit_'+$row_id).val(json.product['unit']);
                $('#stock_in_detail_product_id_'+$row_id).select2('destroy');
                $('#stock_in_detail_product_id_'+$row_id).html('<option value="'+ json.product['product_master_id'] +'">'
                    + json.product['product_code'] + ' - ' + json.product['name'] + '</option>');
                $('#stock_in_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#stock_in_detail_unit_price_'+$row_id).val(json.product['cost_price']);
            }
            else {
                alert(json.error);
                $('#stock_in_detail_description_'+$row_id).val('');
                $('#stock_in_detail_product_code_'+$row_id).val('');
                $('#stock_in_detail_unit_id_'+$row_id).val('');
                $('#stock_in_detail_unit_'+$row_id).val('');
                $('#stock_in_detail_product_id_'+$row_id).select2('destroy');
                $('#stock_in_detail_product_id_'+$row_id).html('');
                $('#stock_in_detail_product_id_'+$row_id).select2({'width':'100%'});
                $('#stock_in_detail_unit_price_'+$row_id).val('0.00');
            }

         Select2StockIn('#stock_in_detail_product_id_'+$row_id);
         $('#stock_in_detail_warehouse_id_'+$row_id).select2({'width':'100%'});

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}


function getProductSerialNo($row_id) {
    var $product_code = $('#stock_in_detail_product_code_'+$row_id).val();
    var $sr_no = '';
    $.ajax({
        url: $UrlGetProductSerialNo,
        dataType: 'html',
        type: 'post',
        data: 'product_code=' + $product_code,
        mimeType:"multipart/form-data",
        success: function(result) {
         $sr_no = $product_code;
         $('#stock_in_detail_serial_no_'+$row_id).val($sr_no);
         }
        });	  
}

function setProductInformation($obj) {
    var $data = $($obj).data();
    console.log($data);
    var $row_id = $('#'+$data['element']).parent().parent().parent().data('row_id');
    $('#_modal').modal('hide');
    $('#stock_in_detail_product_code_'+$row_id).val($data['product_code']);
    $('#stock_in_detail_cubic_meter_'+$row_id).val($data['cubic_meter']);
    $('#stock_in_detail_cubic_feet_'+$row_id).val($data['cubic_feet']);
    $('#stock_in_detail_unit_id_'+$row_id).val($data['unit_id']);
    $('#stock_in_detail_unit_'+$row_id).val($data['unit']);
    $('#stock_in_detail_description_'+$row_id).val($data['name']);
    $('#stock_in_detail_unit_price_'+$row_id).val($data['cost_price']);
    $('#stock_in_detail_product_id_'+$row_id).select2('destroy');
    $('#stock_in_detail_product_id_'+$row_id).html('<option selected="selected" value="'+$data['product_id']+'">'+$data['name']+'</option>');
    $('#stock_in_detail_product_id_'+$row_id).select2({
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


// $(document).on('click','.btnAddExpense', function() {
//     $html = '';
//     $html += '<tr id="expense_row_'+$expense_row+'" data-expense_row="'+$expense_row+'">';
//     $html += '<td>';
//     $html += '<a onclick="removeExpense(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
//     $html += '</td>';
//     $html += '<td>';
// //    $html += '<select class="form-control select2" id="purchase_invoice_expense_'+$expense_row+'_coa_id" name="purchase_invoice_expenses['+$expense_row+'][coa_id]" >';
// //    $html += '<option value="">&nbsp;</option>';
// //    $coas.forEach(function($coa) {
// //        $html += '<option value="'+$coa.coa_level3_id+'">'+$coa.level3_display_name+'</option>';
// //    });
// //    $html += '</select>';
//     $html += '<input type="text" style="min-width: 100px;"" class="form-control" name="purchase_invoice_expenses['+$expense_row+'][description]" id="purchase_invoice_expense_'+$expense_row+'_description" value="" />';
//     $html += '</td>';
//     $html += '<td>';
//     $html += '<input onchange="calculateExpense(this);" type="text" style="min-width: 100px;"" class="form-control fPdecimal text-right" name="purchase_invoice_expenses['+$expense_row+'][expense_amount]" id="purchase_invoice_expense_'+$expense_row+'_expense_amount" value="" />';
//     $html += '</td>';
//     $html += '</tr>';


//     $('#tblExpense tbody').prepend($html);

//     $('#purchase_invoice_expense_'+$expense_row+'_coa_id').select2({width: '100%'});
//     $('#purchase_invoice_expense_'+$expense_row+'_coa_id').trigger('change');
//     $expense_row++;

// });

// function removeExpense($obj) {
//     var $row_id = $($obj).parent().parent().data('expense_row');
//     $('#expense_row_'+$row_id).remove();
//     calculateExpense($obj);
// }

// $(document).on('click','.btnAddSalesTax', function() {

//     $html = '';
//     $html += '<tr id="sales_tax_row_'+$sales_tax_row+'" data-sales_tax_row="'+$sales_tax_row+'">';
//     $html += '<td>';
//     $html += '<a onclick="removeSalesTax(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
//     $html += '</td>';
//     $html += '<td>';
//     $html += '<select class="form-control select2"  name="purchase_invoice_sales_tax['+$sales_tax_row+'][coa_id]" id="purchase_invoice_sales_tax_'+$sales_tax_row+'_coa_id"  >';
//     $html += '<option value="">&nbsp;</option>';
//     $coas.forEach(function($coa) {
//         $html += '<option value="'+$coa.coa_level3_id+'">'+$coa.name+'</option>';
//     });
//     $html += '</select>';
//     $html += '</td>';
//     $html += '<td>';
//     $html += '<input onchange="calculateSalesTax(this);" type="text" style="min-width: 100px;" class="form-control fPdecimal text-right" name="purchase_invoice_sales_tax['+$sales_tax_row+'][sales_tax_amount]" id="purchase_invoice_sales_tax_'+$sales_tax_row+'_sales_tax_amount" value="" />';
//     $html += '</td>';
//     $html += '</tr>';


//     $('#tblSalesTax tbody').prepend($html);

//     $sales_tax_row++;
//     setFieldFormat();
// });



// Calculations

// function calculateCalcWeight($obj)
// {
//     var $row_id = $($obj).parents('tr').data('row_id');
//     var $qty = parseFloat($('#stock_in_detail_qty_'+$row_id).val())||0;
//     var $base_calc_weight = parseFloat($('#stock_in_detail_base_calc_weight_'+$row_id).val())||0;

//     $('#stock_in_detail_calc_weight_'+$row_id).val(rDecimal(($qty*$base_calc_weight),4));

//     calculateTotal();
// }



function calculateTotalRow($obj)
{
    calculateTotal();
}


function calculateQuantity($obj)
{
    var $total_qty = 0;
    var $total_price_master = 0;

    $('#tblStockIn tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        // Qty
        var $qty = parseFloat($('#stock_in_detail_qty_'+$row_id).val()) || 0.00;

        // Total Price
        var $unit_price = parseFloat($('#stock_in_detail_unit_price_'+$row_id).val()) || 0.00;
        var $total_price = ($qty*$unit_price);
        $('#stock_in_detail_total_price_'+$row_id).val(rDecimal($total_price,2));
        $('#stock_in_detail_qty_'+$row_id).val($qty);

        calculateTotal();


    });
}

function calculateTotal($calcData)
{
    var $total_qty = 0;
    var $total_price_master = 0;
    $('#tblStockIn tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        // Qty
        var $qty = parseFloat($('#stock_in_detail_qty_'+$row_id).val()) ||0.00;

        // Total Price
        var $unit_price = parseFloat($('#stock_in_detail_unit_price_'+$row_id).val())||0.00;
        var $total_price = ($qty*$unit_price);
        $('#stock_in_detail_total_price_'+$row_id).val(rDecimal($total_price,2));
        $total_qty += $qty;
        $total_price_master += $total_price;

    });


    // Master TOtal
    $('#qty_master').val(rDecimal($total_qty,4));
    $('#total_price_master').val(rDecimal($total_price_master,2));

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

    $('#tblStockIn tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        var $calc_weight = parseFloat($('#stock_in_detail_calc_weight_'+$row_id).val())||0.00;
        var $freight_charges = (($calc_weight/$total_weight)*$total_freight);
        $('#stock_in_detail_freight_charges_'+$row_id).val(rDecimal($freight_charges,2));
    });

    var $total_other_expense_master = parseFloat($('#total_other_expense_master').val())||0.00;
    var $total_price_pkr_master = parseFloat($('#total_price_pkr_master').val())||0.00;

    $('#tblStockIn tbody tr').each(function(){
        $row_id = $(this).data('row_id');
        var $total_price_pkr = parseFloat($('#stock_in_detail_total_price_pkr_'+$row_id).val())||0.00;
        var $other_expense_and_charges = (($total_other_expense_master/$total_price_pkr_master)*$total_price_pkr);
        $('#stock_in_detail_other_expense_and_charges_'+$row_id).val(rDecimal($other_expense_and_charges,2));
    });

    calculateTotal(true);

}


// Freight Master
function calculateTotalFreight()
{
    var $total_freight = parseFloat($('#freight_master').val())||0.00;
    var $total_weight = parseFloat($('#total_calc_weight_master').val())||0.00;

    $('#tblStockIn tbody tr').each(function(){
        $row_id = $(this).data('row_id');

        var $calc_weight = parseFloat($('#stock_in_detail_calc_weight_'+$row_id).val())||0.00;
        var $freight_charges = (($calc_weight/$total_weight)*$total_freight);
        $('#stock_in_detail_freight_charges_'+$row_id).val(rDecimal($freight_charges,2));
    });

    calculateTotal();

}

// Other Expense
function calculateOtherExpense()
{
    var $total_other_expense_master = parseFloat($('#total_other_expense_master').val())||0.00;
    var $total_price_pkr_master = parseFloat($('#total_price_pkr_master').val())||0.00;

    $('#tblStockIn tbody tr').each(function(){
        $row_id = $(this).data('row_id');
        var $total_price_pkr = parseFloat($('#stock_in_detail_total_price_pkr_'+$row_id).val())||0.00;
        var $other_expense_and_charges = (($total_other_expense_master/$total_price_pkr_master)*$total_price_pkr);
        $('#stock_in_detail_other_expense_and_charges_'+$row_id).val(rDecimal($other_expense_and_charges,2));
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

    var $tax_percent = parseInt($('#stock_in_detail_sales_tax_percent_'+$row_id).val())||0;
    var $total_price_pkr = parseInt($('#stock_in_detail_total_price_pkr_'+$row_id).val())||0;

    var $tax_amount = (($total_price_pkr*$tax_percent)/100);
    $('#stock_in_detail_sales_tax_'+$row_id).val( $tax_amount );

    calculateTotal();

}

// Tax Amount
function calculateSalesTaxPercent($obj) {

    var $row_id = $($obj).parents('tr').data('row_id');

    var $tax_amount = parseFloat($('#stock_in_detail_sales_tax_'+$row_id).val())||0;
    var $total_price_pkr = parseFloat($('#stock_in_detail_total_price_pkr_'+$row_id).val())||0;
    var $tax_percent = roundUpto($tax_amount / $total_price_pkr * 100,2);

    $('#stock_in_detail_sales_tax_percent_' + $row_id).val($tax_percent);
    calculateTotal();
}


function document_reset()
{
    $('#tblStockIn tbody').empty();
    $('#tblExpense tbody').empty();
    $('#tblSalesTax tbody').empty();

    $('#freight_master').val(0.00);
    $('#total_other_expense_master').val(0.00);
    $('#expense_total').val(0.00);
    $('#sales_tax_total').val(0.00);

    calculateTotal();
}