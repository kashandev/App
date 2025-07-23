/**
 * Created by Huzaifa on 9/18/15.
 */


$(window).on('load',function(){

    if($isEdit)
    {
     
     if($document_type == 'with_reference')
     {
     $('#customer_name').attr('readonly',true);
     $('#mobile').attr('readonly',true);
    }
    else
    {
      $('#customer_name').attr('readonly',false);
      $('#mobile').attr('readonly',false);
    }
}
});

function getJobOrderNo($job_order_id)
{
    var $data = {
            document_type : $('#document_type').val(),
            job_order_id : $job_order_id
    };
   $.ajax({
       url: $UrlGetJobOrderNo,
       dataType: 'json',
       type: 'post',
       data: $data,
       beforeSend: function() {
           $('#job_order_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
       },
       complete: function() {
           $('#loader').remove();
       },
       success: function(json) {

               $('#job_order_id').select2('destroy');
               $('#job_order_id').html(json.html);
               $('#job_order_id').select2({width:'100%'});

       },
       error: function(xhr, ajaxOptions, thrownError) {
           console.log(xhr.responseText);
       }
   })
}



$(document).ready(function() {
    if($sale_type == 'sale_invoice')
    {
        $('#sale_tax_invoice').prop( "checked", false);
        $('#sale_invoice').prop( "checked", true);
    }
    else
    {
        $('#sale_tax_invoice').prop( "checked", true);
        $('#sale_invoice').prop( "checked", false);
    }


    $('#sale_invoice').on('change', function() {
        if($(this).is(":checked"))
        {
            $('#sale_tax_invoice').prop( "checked", false);
            $('#tax_per').attr('readonly',true); 
            // $('input[name="manual_ref_no"]').prop("readonly",false);   
        }
        else
        {
            $('#sale_tax_invoice').prop( "checked",true);
            $('#tax_per').removeAttr('readonly');
            // $('input[name="manual_ref_no"]').prop("readonly",true);
        }
    });
    $('#sale_tax_invoice').on('change', function() {
        if($(this).is(":checked"))
        {
            $('#sale_invoice').prop( "checked", false);
            $('#tax_per').removeAttr('readonly');
            // $('input[name="manual_ref_no"]').prop("readonly",true);    
        }
        else
        {
            $('#sale_invoice').prop( "checked",true);
            $('#tax_per').attr('readonly',true); 
            // $('input[name="manual_ref_no"]').prop("readonly",false);
        }
    });
});


$(document).ready(function() {
    $('#ref_document_id').select2({
        width: '100%',
        ajax: {
            url: $GetRefDocumentJson,
            dataType: 'json',
            type: 'post',
            mimeType:"multipart/form-data",
            delay: 100,
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
        minimumInputLength: 3,
        templateResult: formatReposit, // omitted for brevity, see the source of this page
        templateSelection: function(repo) {
        // $('#product_code').val(repo['product_code']);
            return (repo.document_identity) || repo.text;
        } // omitted for brevity, see the source of this page                }
    });
});

//$(document).on('change','#ref_document_id',function() {
//    var $ref_document_id = $(this).val();
//    $.ajax({
//        url: $GetRefDocumentRecord,
//        dataType: 'json',
//        type: 'post',
//        data: 'ref_document_id='+$ref_document_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
////            $('#unit_id').parent().before('<i id="loader" class="fa fa-refresh fa-spin pull-right"></i>');
//        },
//        complete: function() {
////            $('#loader').remove();
//        },
//        success: function(json) {
//
//            $('#partner_id').val(json.data['partner_id']).trigger('change');
//            $('#po_no').val(json.data['po_no']);
//
//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
//})


// $(document).on('change','#partner_type_id', function() {
//     $partner_type_id = $(this).val();
//     $.ajax({
//         url: $UrlGetPartnerById,
//         dataType: 'json',
//         type: 'post',
//         data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id,
//         mimeType:"multipart/form-data",
//         beforeSend: function() {
//             $('#partner_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
//         },
//         complete: function() {
//             $('#loader').remove();
//         },
//         success: function(json) {
//             console.log(  )
//             if(json.success)
//             {
//                 $('#partner_id').select2('destroy');
//                 $('#partner_id').select2({width:'100%'});
//                 $('#partner_id').html('<option selected="selected" value="'+(json.partner['partner_id']??'')+'">'+(json.partner['name']??'')+'</option>');
//                 $('#partner_id').select2({
//                 width: '100%',
//                 ajax: {
//                     url: $UrlGetPartnerJSON,
//                     dataType: 'json',
//                     type: 'post',
//                     mimeType:"multipart/form-data",
//                     delay: 250,
//                     data: function (params) {
//                         return {
//                             q: params.term, // search term
//                             page: params.page
//                         };
//                     },
//                     processResults: function (data, params) {
//                         // parse the results into the format expected by Select2
//                         // since we are using custom formatting functions we do not need to
//                         // alter the remote JSON data, except to indicate that infinite
//                         // scrolling can be used
//                         params.page = params.page || 1;

//                         return {
//                             results: data.items,
//                             pagination: {
//                                 more: (params.page * 30) < data.total_count
//                             }
//                         };
//                     },
//                     cache: true
//                 },
//                 escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
//                 minimumInputLength: 2,
//                 templateResult: formatRepo, // omitted for brevity, see the source of this page
//                 templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
//             });
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

//$(document).on('change','#partner_id', function() {
//    $partner_id = $(this).val();
//    $.ajax({
//        url: $UrlGetCustomerUnit,
//        dataType: 'json',
//        type: 'post',
//        data: 'partner_id=' + $partner_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
//            $('#customer_unit_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
//        },
//        complete: function() {
//            $('#loader').remove();
//        },
//        success: function(json) {
//            if(json.success)
//            {
//                $('#customer_unit_id').select2('destroy');
//                $('#customer_unit_id').html(json.html);
//                $('#customer_unit_id').select2({width:'100%'});
//            }
//            else {
//                alert(json.error);
//            }
//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
//});


//$(document).on('change','#partner_id', function() {
//    $partner_id = $(this).val();
//    $.ajax({
//        url: $GetRefDocument,
//        dataType: 'json',
//        type: 'post',
//        data: 'partner_id='+$partner_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
//            $('#ref_document_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
//        },
//        complete: function() {
//            $('#loader').remove();
//        },
//        success: function(json) {
//            if(json.success)
//            {
//                $('#tblSaleInvoice tbody tr').remove();
//
//                $('#ref_document_id').select2('destroy');
//                $('#ref_document_id').html(json.html);
//                $('#ref_document_id').select2({width:'100%'});
//            }
//            else {
//                alert(json.error);
//            }
//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
//});



$(document).on('change','#document_type', function() {
   getJobOrderNo($job_order_id);

   if($(this).val() == 'with_reference')
   {

      $('#customer_name').attr('readonly',true);
      $('#mobile').attr('readonly',true);
   }
   else
   {
      $('#customer_name').attr('readonly',false);
      $('#mobile').attr('readonly',false);
   }

});

function setFormat()
{
            $('.fDecimal').on('focus', function () {
                $(this).format({precision: 4,autofix:true});
            });
            $('.fPDecimal').on('focus', function () {
                $(this).format({precision: 4,allow_negative:false,autofix:true});
            });
}



function GetDocumentDetails() {
        
        var $data = {
            ref_document_id : $('#ref_document_id').val()
        };

        var $details = [];
        $.ajax({
            url: $UrlGetDocumentDetails,
            dataType: 'json',
            type: 'post',
            data: $data,
            mimeType:"multipart/form-data",
            beforeSend: function() {
                //    $('#ref_document_id').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
            },
            complete: function() {
                //    $('#loader').remove();
                $('#ref_document_id').html('');
                $('#ref_document_id').val(null);
                $('#ref_document_id').trigger('change');
            },

            success: function(json) {
                if(json.success)
                {
                    $('#tblSaleInvoice tbody tr').remove();
                    $('#po_no').val(json.po_no);
                    $('#po_date').val(json['po_date']);
                    $('#partner_id').val(json['partner_id']).trigger('change');
                    $('#customer_unit_id').val(json['customer_unit_id']).trigger('change');
                    $('#dc_no').val(json['dc_no']);

                    $.each(json.data['products'], function($i,$product) {
                        fillGrid($product);
                    });

                    //  $details = json['details'];
                    //  for($i=0;$i<$details.length;$i++) {
                    //  fillGrid($details[$i]);
                    //   }
                }
                else {
                    alert(json.error);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.responseText);
            }
        })
};


function fillGrid($obj) {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_type_id]" id="sale_tax_invoice_detail_ref_document_type_id_'+$grid_row+'" value="'+$obj['ref_document_type_id']+'" />';
    $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_identity]" id="sale_tax_invoice_detail_ref_document_identity_'+$grid_row+'" value="'+$obj['ref_document_identity']+'" />';
    $html += '<a target="_blank" href="'+$obj['href']+'">'+$obj['ref_document_identity']+'</a>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="'+$obj['product_code']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<div class="input-group">';
    $html += '<select style="min-width: 100px;" onchange="getProductById(this);" class="form-control select2" id="sale_tax_invoice_detail_product_id_'+$grid_row+'" name="sale_tax_invoice_details['+$grid_row+'][product_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $products.forEach(function($product) {
        if($product['product_id'] == $obj['product_id']) {
            $html += '<option value="'+$product.product_id+'" selected="true">'+$product.name+'</option>';
        } else {
            $html += '<option value="'+$product.product_id+'">'+$product.name+'</option>';
        }
    });
    $html += '</select>';
    $html += '<span class="input-group-btn ">';
    $html += '<button class="btn btn-default btn-flat QSearchProduct" id="QSearchProduct" type="button" data-element="sale_tax_invoice_detail_product_id_'+$grid_row+'" data-field="product_id">';
    $html += '<i class="fa fa-search"></i>';
    $html += '</button>';
    $html += '</span>';
    $html += '</div>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input style="min-width: 100px;" type="text" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][description]" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="'+$obj['description']+'" />';
    $html += '</td>';
    // $html += '<td>';
    // $html += '<select onchange="validateWarehouseStock(this);" class="form-control select2 warehouse_id" id="sale_tax_invoice_detail_warehouse_id_'+$grid_row+'" name="sale_tax_invoice_details['+$grid_row+'][warehouse_id]" >';
    // $html += '<option value="">&nbsp;</option>';
    // $warehouses.forEach(function($warehouse) {
    //     if($warehouse['warehouse_id'] == $obj['warehouse_id']) {
    //         $html += '<option value="'+$warehouse.warehouse_id+'" selected="true">'+$warehouse.name+'</option>';
    //     } else {
    //         $html += '<option value="'+$warehouse.warehouse_id+'">'+$warehouse.name+'</option>';
    //     }
    // });
    // $html += '</select>';
    // $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][qty]" id="sale_tax_invoice_detail_qty_'+$grid_row+'" value="'+$obj['balanced_qty']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" readonly style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit]" id="sale_tax_invoice_detail_unit_'+$grid_row+'" value="'+$obj['unit']+'" />';
    $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit_id]" id="sale_tax_invoice_detail_unit_id_'+$grid_row+'" value="'+$obj['unit_id']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][rate]" id="sale_tax_invoice_detail_rate_'+$grid_row+'" value="'+$obj['rate']+'" />';
    //    $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][cog_rate]" id="sale_tax_invoice_detail_cog_rate_'+$grid_row+'" value="'+$obj['cog_rate']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][amount]" id="sale_tax_invoice_detail_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true" />';
    $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][cog_amount]" id="sale_tax_invoice_detail_cog_amount_'+$grid_row+'" value="'+$obj['cog_amount']+'" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_percent]" id="sale_tax_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_amount]" id="sale_tax_invoice_detail_discount_amount_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][gross_amount]" id="sale_tax_invoice_detail_gross_amount_'+$grid_row+'" value="'+$obj['amount']+'" readonly="true"/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_percent]" id="sale_tax_invoice_detail_tax_percent_'+$grid_row+'" value="'+$obj['tax_percent']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_amount]" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="'+$obj['tax_amount']+'" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][total_amount]" id="sale_tax_invoice_detail_total_amount_'+$grid_row+'" value="'+$obj['net_amount']+'" readonly="true" />';
    $html += '</td>';
    $html += '<td><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';


    $('#tblSaleInvoice tbody').prepend($html);
    // setFormat();
    $('#sale_tax_invoice_detail_product_id_'+$grid_row).select2({width: '100%'});
    $('#sale_tax_invoice_detail_warehouse_id_'+$grid_row).select2({width: '100%'});

    $('#ref_document_id').select2({
        width: '100%',
        ajax: {
            url: $GetRefDocumentJson,
            dataType: 'json',
            type: 'post',
            mimeType:"multipart/form-data",
            delay: 100,
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
        minimumInputLength: 3,
        templateResult: formatReposit, // omitted for brevity, see the source of this page
        templateSelection: function(repo) {
        // $('#product_code').val(repo['product_code']);
            return (repo.document_identity) || repo.text;
        } // omitted for brevity, see the source of this page                }
    });

    $('#sale_tax_invoice_detail_product_id_'+$grid_row).select2({
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
        minimumInputLength: 2,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
    });

    if($('#sale_invoice').is(":checked"))
    {
        
        $('#sale_tax_invoice_detail_tax_percent_'+$grid_row).attr('readonly',true);
        $('#sale_tax_invoice_detail_tax_amount_'+$grid_row).attr('readonly',true);
    }



    $grid_row++;

    calculateTotal();
}

$(document).on('click','#btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_type_id]" id="sale_tax_invoice_detail_ref_document_type_id_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_identity]" id="sale_tax_invoice_detail_ref_document_identity_'+$grid_row+'" value="" />';
    $html += '&nbsp;';
    $html += '</td>';
    $html += '<td>';
    $html += '<select onchange="setProductIDField(this);"  class="form-control select2 product-type" id="sale_tax_invoice_detail_product_type_'+$grid_row+'"  name="sale_tax_invoice_details['+$grid_row+'][product_type]" >';
    $html += '<option value="product">Product</option>';
    $html += '<option value="service">Service</option>';
    $html += '<option value="part">Part</option>';
    $html += '</select>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="hidden" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][data_product_type]" id="sale_tax_invoice_detail_data_product_type_'+$grid_row+'" value="product" />';  
    $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="" autocomplete="off" />';
    $html += '</td>';
    $html += '<td style="min-width: 300px;" id="sale_tax_invoice_detail_product_div_'+$grid_row+'">';
    $html += '<div class="input-group">';
    $html += '<select style="min-width: 100px;" onchange="getProductById(this);" class="form-control select2" id="sale_tax_invoice_detail_product_id_'+$grid_row+'" name="sale_tax_invoice_details['+$grid_row+'][product_id]" >';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html += '<span class="input-group-btn ">';
    $html += '<button class="btn btn-default btn-flat QSearchProduct" data-row_id = "'+$grid_row+'" id="QSearchProduct" type="button" data-element="sale_tax_invoice_detail_product_id_'+$grid_row+'" data-field="product_id">';
    $html += '<i class="fa fa-search"></i>';
    $html += '</button>';
    $html += '</span>';
    $html += '</div>';
    $html += '</td>';

    $html+='<td style="display:none;min-width: 300px;" id="sale_tax_invoice_detail_product_name_div_'+$grid_row+'" >';
    $html += '<input style="min-width: 100px;" type="text" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][part_name]" id="sale_tax_invoice_detail_part_name_'+$grid_row+'" value="" />';
    $html += '</td>';

    $html += '<td style="min-width: 300px;">';
    $html += '<input  type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][description]" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="" />';
    $html += '</td>';
    // $html += '<td>';
    // $html += '<select onchange="validateWarehouseStock(this);" class="form-control select2 warehouse_id" id="sale_tax_invoice_detail_warehouse_id_'+$grid_row+'" name="sale_tax_invoice_details['+$grid_row+'][warehouse_id]" >';
    // $html += '<option value="">&nbsp;</option>';
    // $warehouses.forEach(function($warehouse) {
    //     $html += '<option value="'+$warehouse.warehouse_id+'">'+$warehouse.name+'</option>';
    // });
    // $html += '</select>';
    // $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][qty]" id="sale_tax_invoice_detail_qty_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" readonly class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit]" id="sale_tax_invoice_detail_unit_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit_id]" id="sale_tax_invoice_detail_unit_id_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][rate]" id="sale_tax_invoice_detail_rate_'+$grid_row+'" value="0.00" />';
    $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][cog_rate]" id="sale_tax_invoice_detail_cog_rate_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][amount]" id="sale_tax_invoice_detail_amount_'+$grid_row+'" value="0.00" readonly="true" />';
    $html += '<input type="hidden"class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][cog_amount]" id="sale_tax_invoice_detail_cog_amount_'+$grid_row+'" value="0.00" readonly="true" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_percent]" id="sale_tax_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_amount]" id="sale_tax_invoice_detail_discount_amount_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td >';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][gross_amount]" id="sale_tax_invoice_detail_gross_amount_'+$grid_row+'" value="" readonly="true"/>';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_percent]" id="sale_tax_invoice_detail_tax_percent_'+$grid_row+'" value="0" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_amount]" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="0.00" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][total_amount]" id="sale_tax_invoice_detail_total_amount_'+$grid_row+'" value="" readonly="true" />';
    $html += '</td>';
    $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';


    //$('#tblSaleInvoice tbody').prepend($html);
    $('#tblSaleInvoice tbody').append($html);
    setFormat();
    $('#sale_tax_invoice_detail_product_id_'+$grid_row).select2({width: '100%'});
    $('#sale_tax_invoice_detail_product_type_'+$grid_row).select2({width: '100%'});
    $('#sale_tax_invoice_detail_product_code_'+$grid_row).focus();

    var $product_type = $('#sale_tax_invoice_detail_product_type_'+$grid_row).find('option:selected').val();
    var $data_product_type = $('#sale_tax_invoice_detail_data_product_type_'+$grid_row).val();

    if($product_type == 'product' || $product_type == 'service')
    {
    $('#sale_tax_invoice_detail_product_id_'+$grid_row).select2({
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
                    page: params.page,
                    t : $data_product_type
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
        minimumInputLength: 2,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
    });
  }
    if($('#sale_invoice').is(":checked"))
    {

        $('#sale_tax_invoice_detail_tax_percent_'+$grid_row).attr('readonly',true);
        $('#sale_tax_invoice_detail_tax_amount_'+$grid_row).attr('readonly',true);
    }

    $grid_row++;
});


function setProductIDField($obj){
        var $row_id = $($obj).parent().parent().data('row_id');
        $product_type = $('#sale_tax_invoice_detail_product_type_'+$row_id).find('option:selected').val();
        getProductByCode($obj);

        if($product_type == 'product')
        {
            $('#sale_tax_invoice_detail_qty_'+$row_id).prop("readonly", false);
            $('#sale_tax_invoice_detail_product_name_div_'+$row_id).hide();
            $('#sale_tax_invoice_detail_product_div_'+$row_id).show();
            $('#sale_tax_invoice_detail_data_product_type_'+$row_id).val($product_type);
            $data_product_type = $('#sale_tax_invoice_detail_data_product_type_'+$row_id).val();

            if($isEdit == 0)
            {
                 $('#sale_tax_invoice_detail_qty_'+$row_id).val(0);
            }

        }
        else if($product_type == 'service')
        {
            if($isEdit == 0)
            {
                 $('#sale_tax_invoice_detail_qty_'+$row_id).val('1.00');
            }
            else
            {
                $('#sale_tax_invoice_detail_qty_'+$row_id).val('1.00');
            }
            $('#sale_tax_invoice_detail_qty_'+$row_id).prop("readonly", true);
            $('#sale_tax_invoice_detail_product_name_div_'+$row_id).hide();
            $('#sale_tax_invoice_detail_product_div_'+$row_id).show();
            $('#sale_tax_invoice_detail_data_product_type_'+$row_id).val($product_type);
            $data_product_type = $('#sale_tax_invoice_detail_data_product_type_'+$row_id).val();
        }
        else
        {
            $('#sale_tax_invoice_detail_qty_'+$row_id).prop("readonly", false);
            $('#sale_tax_invoice_detail_product_name_div_'+$row_id).show();
            $('#sale_tax_invoice_detail_product_div_'+$row_id).hide();
            $('#sale_tax_invoice_detail_data_product_type_'+$row_id).val('');

             if($isEdit == 0)
            {
                 $('#sale_tax_invoice_detail_qty_'+$row_id).val(0);
            }

        }
        
    $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({
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
                    page: params.page,
                    t : $data_product_type
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
        minimumInputLength: 2,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
    });

   


}

// function getPartyByRefDoc($obj){

//     $('#tblSaleInvoice tbody').html('');
//     $('#customer_contact').val('Customer Name');
//     $('#product_id').val('Product Name');
//     $('#total_quantity').val('30');
//     $('#item_amount').val('30');

//     $html = '';

//     for($i=1;$i<=3;$i++){

//         $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
//         $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
//         $html += '<td>';
//         $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_type_id]" id="sale_tax_invoice_detail_ref_document_type_id_'+$grid_row+'" value="" />';
//         $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_identity]" id="sale_tax_invoice_detail_ref_document_identity_'+$grid_row+'" value="" />';
//         $html += '&nbsp;';
//         $html += '</td>';
//         if($i==1){
//             $html += '<td>';
//             $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="Product Code" autocomplete="off" />';
//             $html += '</td>';
//             $html += '<td style="min-width: 300px;">';
//             $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="Product Name" autocomplete="off" />';
//             $html += '</td>';
//             $html += '<td>';
//             $html += '<input type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details[<?php echo $grid_row; ?>][product_type]" id="sale_tax_invoice_detail_product_type_<?php echo $grid_row; ?>" value="Product" />';
//             $html += '</td>';
//             $html += '<td style="min-width: 300px;">';
//             $html += '<input  type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][description]" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="Product Description" />';
//             $html += '</td>';
//         }
//         else if($i==2){
//             $html += '<td>';
//             $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="Part Code" autocomplete="off" />';
//             $html += '</td>';
//             $html += '<td style="min-width: 300px;">';
//             $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="Part Name" autocomplete="off" />';
//             $html += '</td>';
//             $html += '<td>';
//             $html += '<input type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details[<?php echo $grid_row; ?>][product_type]" id="sale_tax_invoice_detail_product_type_<?php echo $grid_row; ?>" value="Part" />';
//             $html += '</td>';
//             $html += '<td style="min-width: 300px;">';
//             $html += '<input  type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][description]" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="Part Description" />';
//             $html += '</td>';
//         }
//         else if($i==3){
//             $html += '<td>';
//             $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="Service Code" autocomplete="off" />';
//             $html += '</td>';
//             $html += '<td style="min-width: 300px;">';
//             $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="Service Name" autocomplete="off" />';
//             $html += '</td>';
//             $html += '<td>';
//             $html += '<input type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details[<?php echo $grid_row; ?>][product_type]" id="sale_tax_invoice_detail_product_type_<?php echo $grid_row; ?>" value="Service" />';
//             $html += '</td>';
//             $html += '<td style="min-width: 300px;">';
//             $html += '<input  type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][description]" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="Service Description" />';
//             $html += '</td>';
//         }
        
//         $html += '<td class="hide">';
//         $html += '<input type="text" name="sale_tax_invoice_details['+ $grid_row +'][available_stock]" id="sale_tax_invoice_details_available_stock_'+ $grid_row +'" readonly disabled class="form-control">';
//         $html += '</td>';
        

//         $html += '<td>';
//         $html += '<select onchange="validateWarehouseStock(this);" class="form-control select2 warehouse_id" id="sale_tax_invoice_detail_warehouse_id_'+$grid_row+'" name="sale_tax_invoice_details['+$grid_row+'][warehouse_id]" >';
//         $html += '<option value="">&nbsp;</option>';
//         $warehouses.forEach(function($warehouse) {
//             $html += '<option value="'+$warehouse.warehouse_id+'">'+$warehouse.name+'</option>';
//         });
//         $html += '</select>';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][qty]" id="sale_tax_invoice_detail_qty_'+$grid_row+'" value="0" />';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input type="text" style="min-width: 100px;" readonly class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit]" id="sale_tax_invoice_detail_unit_'+$grid_row+'" value="" />';
//         $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit_id]" id="sale_tax_invoice_detail_unit_id_'+$grid_row+'" value="" />';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][rate]" id="sale_tax_invoice_detail_rate_'+$grid_row+'" value="0.00" />';
//         $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][cog_rate]" id="sale_tax_invoice_detail_cog_rate_'+$grid_row+'" value="0.00" />';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][amount]" id="sale_tax_invoice_detail_amount_'+$grid_row+'" value="0.00" readonly="true" />';
//         $html += '<input type="hidden"class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][cog_amount]" id="sale_tax_invoice_detail_cog_amount_'+$grid_row+'" value="0.00" readonly="true" />';
//         $html += '</td>';
//         $html += '<td >';
//         $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_percent]" id="sale_tax_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
//         $html += '</td>';
//         $html += '<td >';
//         $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_amount]" id="sale_tax_invoice_detail_discount_amount_'+$grid_row+'" value="0.00" />';
//         $html += '</td>';
//         $html += '<td >';
//         $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][gross_amount]" id="sale_tax_invoice_detail_gross_amount_'+$grid_row+'" value="" readonly="true"/>';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_percent]" id="sale_tax_invoice_detail_tax_percent_'+$grid_row+'" value="0" />';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_amount]" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="0.00" />';
//         $html += '</td>';
//         $html += '<td>';
//         $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][total_amount]" id="sale_tax_invoice_detail_total_amount_'+$grid_row+'" value="" readonly="true" />';
//         $html += '</td>';
//         $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
//         $html += '</tr>';

//         $grid_row++;
//     }

//     setFormat();
//     $('#tblSaleInvoice tbody').append($html);

// }



function getPartyByRefDoc($obj) {

    $job_order_id = $($obj).val();
    $('#tblSaleInvoice tbody').html('');
    $readonly = '';
    $product_type = '';
    $data_product_type = '';
    $product_name = '';
    $product_unit = '';
    $product_quantity = '';
    $product_rate = '';
    $quantity = '';
    $grid_row = 0;
    $.ajax({
        url: $UrlGetRefDocDetail,
        dataType: 'json',
        type: 'post',
        data: 'job_order_id=' + $job_order_id,
        mimeType: "multipart/form-data",
        success: function (json) {
            $data = json;

            if ($data.length>0) {
                
                $data.forEach(function(data) {
                $html = '';

           if(data['product_type'] == 'product'){
             $readonly = '';
             $product_type = data['product_type'];
             $product_name = data['part_name'];
             $product_unit = data['product_unit'];
             $quantity = data['quantity'];
             $product_quantity = $quantity;
             $data_product_type = 'product';
            }

            if(data['product_type'] == 'service'){
             $readonly = 'readonly';
             $product_type = data['product_type'];
             $product_name = data['part_name'];
             $product_unit = data['product_unit'];
             $quantity = '1.00';
             $product_quantity = 1.00;
             $data_product_type = 'service';
           } 

    
           if(data['product_type'] == 'part'){
            $readonly = '';
            $product_type = data['product_type'];
            $product_name = data['product_name'];
            $product_unit = data['product_unit'];
            $quantity = data['quantity'];  
            $product_quantity = $quantity; 
            $data_product_type = '';     
          }
          if(data['product_type'] == null)
          {
            $product_type = data['product_type'];
            $product_name = data['product_name'];
            $product_unit = data['product_unit'];
            $quantity = data['quantity'];      
            $product_rate = data['amount']; 
            $product_quantity = $quantity; 
            $data_product_type = 'product';
          }

          if(data['rate'] == 0)
          {
            $product_rate = data['amount'];
          }
          else
          {
            $product_rate = data['rate'];
          }

         if(data['product_name'])
         {
            $product_name = data['product_name'];
         }
         if(data['part_name'])
         {
           $product_name = data['part_name'];
         }

        $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
        $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
        $html += '<td>';
        $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_type_id]" id="sale_tax_invoice_detail_ref_document_type_id_'+$grid_row+'" value="" />';
        $html += '<input type="hidden" name="sale_tax_invoice_details['+$grid_row+'][ref_document_identity]" id="sale_tax_invoice_detail_ref_document_identity_'+$grid_row+'" value="" />';
        $html += '&nbsp;';
        $html += '</td>';
        $html += '<td>';

      if(data['product_type'] == 'product')
      {
        $html += '<select class="form-control select2 product-type" id="sale_tax_invoice_detail_product_type_'+$grid_row+'"  name="sale_tax_invoice_details['+$grid_row+'][product_type]" >';
        $html += '<option value="product" selected >Product</option>';
        $html += '<option value="service">Service</option>';
        $html += '<option value="part" >Part</option>';
        $html += '</select>';
      }     
       if(data['product_type'] == 'service'){
        $html += '<select class="form-control select2 product-type" id="sale_tax_invoice_detail_product_type_'+$grid_row+'"  name="sale_tax_invoice_details['+$grid_row+'][product_type]" >';
        $html += '<option value="product" >Product</option>';
        $html += '<option value="service" selected >Service</option>';
        $html += '<option value="part" >Part</option>';
        $html += '</select>';
      }
       if(data['product_type'] == 'part'){
        $html += '<select class="form-control select2 product-type" id="sale_tax_invoice_detail_product_type_'+$grid_row+'"  name="sale_tax_invoice_details['+$grid_row+'][product_type]" >';
        $html += '<option value="product" >Product</option>';
        $html += '<option value="service">Service</option>';
        $html += '<option value="part" selected>Part</option>';
        $html += '</select>';
      }
      if(data['product_type'] == null)
      {
        $html += '<select class="form-control select2 product-type" id="sale_tax_invoice_detail_product_type_'+$grid_row+'"  name="sale_tax_invoice_details['+$grid_row+'][product_type]" >';
        $html += '<option value="product" >Product</option>';
        $html += '<option value="service">Service</option>';
        $html += '<option value="part">Part</option>';
        $html += '</select>';
      }     
        $html += '<input type="hidden" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][data_product_type]" id="sale_tax_invoice_detail_data_product_type_'+$grid_row+'" value="'+$data_product_type+'" />';   
        $html += '</td>';
        $html += '<td>';
        $html += '<input onchange="getProductByCode(this);" type="text" style="min-width: 100px;" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][product_code]" id="sale_tax_invoice_detail_product_code_'+$grid_row+'" value="'+data['product_code']+'" />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input type="hidden" class="form-control select2 product" name="sale_tax_invoice_details['+$grid_row+'][product_id]" id="sale_tax_invoice_detail_product_id_'+$grid_row+'" value="'+data['product_id']+'" readonly/>';
        $html += '<input type="text" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][part_name]" id="sale_tax_invoice_detail_part_name_'+$grid_row+'" value="'+$product_name+'" readonly/>';
        $html += '</td>';
        $html += '<td>';
        $html += '<input style="min-width: 100px;" type="text" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][description]" id="sale_tax_invoice_detail_description_'+$grid_row+'" value="'+$product_name+'" />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][qty]" id="sale_tax_invoice_detail_qty_'+$grid_row+'" value="'+$quantity+'" '+$readonly+' />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input type="text" style="min-width: 100px;" readonly class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit]" id="sale_tax_invoice_detail_unit_'+$grid_row+'" value="'+$product_unit+'" />';
        $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][unit_id]" id="sale_tax_invoice_detail_unit_id_'+$grid_row+'" value="'+data['unit_id']+'" />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input onchange="calculateRowTotal(this);" style="min-width: 100px;" type="text" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][rate]" id="sale_tax_invoice_detail_rate_'+$grid_row+'" value="'+$product_rate+'" />';
        $html += '<input type="hidden" class="form-control" name="sale_tax_invoice_details['+$grid_row+'][cog_rate]" id="sale_tax_invoice_detail_cog_rate_'+$grid_row+'" value="0.00" />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][amount]" id="sale_tax_invoice_detail_amount_'+$grid_row+'" value="'+data['amount']+'" readonly="true" />';
        $html += '<input type="hidden"class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][cog_amount]" id="sale_tax_invoice_detail_cog_amount_'+$grid_row+'" value="0.00" readonly="true" />';
        $html += '</td>';
        $html += '<td >';
        $html += '<input onchange="calculateDiscountAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_percent]" id="sale_tax_invoice_detail_discount_percent_'+$grid_row+'" value="0" />';
        $html += '</td>';
        $html += '<td >';
        $html += '<input onchange="calculateDiscountPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][discount_amount]" id="sale_tax_invoice_detail_discount_amount_'+$grid_row+'" value="0.00" />';
        $html += '</td>';
        $html += '<td >';
        $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][gross_amount]" id="sale_tax_invoice_detail_gross_amount_'+$grid_row+'" value="" readonly="true"/>';
        $html += '</td>';
        $html += '<td>';
        $html += '<input onchange="calculateTaxAmount(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_percent]" id="sale_tax_invoice_detail_tax_percent_'+$grid_row+'" value="0" />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input onchange="calculateTaxPercent(this);" type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][tax_amount]" id="sale_tax_invoice_detail_tax_amount_'+$grid_row+'" value="0.00" />';
        $html += '</td>';
        $html += '<td>';
        $html += '<input type="text" style="min-width: 100px;" class="form-control fPDecimal" name="sale_tax_invoice_details['+$grid_row+'][total_amount]" id="sale_tax_invoice_detail_total_amount_'+$grid_row+'" value="" readonly="true" />';
        $html += '</td>';
        $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
        $html += '</tr>';
  
      setFormat();
      $('#tblSaleInvoice tbody').append($html);
      $('#sale_tax_invoice_detail_product_type_'+$grid_row).select2({width: '100%'});
      $('#sale_tax_invoice_detail_product_code_'+$grid_row).focus();
      var $qty = parseFloat($product_quantity);
      var $rate = parseFloat($product_rate);
      if($qty == 0)
      {
         var $amount = $rate;
      }
      else
      {
         var $amount = $qty * $rate;
      }
      var $dis_percent = parseFloat($('#sale_tax_invoice_detail_discount_percent_'+ $grid_row).val() || 0.0000);
      var $discount_amount = roundUpto($amount * $dis_percent / 100,2);
      var $tax_percent = parseFloat($('#sale_tax_invoice_detail_tax_percent_'+ $grid_row).val() || 0.0000);
      var $tax_amount = roundUpto($amount * $tax_percent / 100,2);
      var $gross_amount = roundUpto($amount - $discount_amount,2);
      var $total_amount = roundUpto($gross_amount + $tax_amount,2);
      $('#sale_tax_invoice_detail_discount_amount_' + $grid_row).val($discount_amount);
      $('#sale_tax_invoice_detail_gross_amount_' + $grid_row).val($gross_amount);
      $('#sale_tax_invoice_detail_tax_amount_' + $grid_row).val($tax_amount);
      $('#sale_tax_invoice_detail_total_amount_' + $grid_row).val(data['amount']);
      $('#customer_name').val(data['customer_name']);
      $('#mobile').val(data['customer_contact']);
      $grid_row++; 
      calculateTotal();
      });          
     }
    },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })

}

function getProductById($obj) {
    $product_id = $($obj).val();
    $partner_id = $('#partner_id').val();
    var $row_id = $($obj).parent().parent().parent().data('row_id');
    $product_type = $('#sale_tax_invoice_detail_product_type_'+$row_id).find('option:selected').val();
    $.ajax({
        url: $UrlGetProductById,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id+'&partner_id=' + $partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-refresh fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2('destroy');
            // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val('');
            // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2({width:'100%'});
            // $('#sale_tax_invoice_detail_qty_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_discount_percent_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_discount_amount_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_tax_percent_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_tax_amount_'+$row_id).val(0);
            if(json.success) {
                $('#sale_tax_invoice_detail_description_'+$row_id).val(json.product['name']);
                $('#sale_tax_invoice_detail_product_code_'+$row_id).val(json.product['product_code']);
                $('#sale_tax_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#sale_tax_invoice_detail_unit_'+$row_id).val(json.product['unit']);
                $('#sale_tax_invoice_detail_cubic_meter_'+$row_id).val(json.product['cubic_meter']);
                $('#sale_tax_invoice_detail_cubic_feet_'+$row_id).val(json.product['cubic_feet']);
                // $('#sale_tax_invoice_detail_rate_'+$row_id).val(0);
                $('#sale_tax_invoice_detail_rate_'+$row_id).val(json.product['cost_price']);
                // $('#sale_tax_invoice_detail_cog_rate_'+$row_id).val(json.product['stock']['avg_stock_rate']);
                $('#sale_tax_invoice_detail_rate_'+$row_id).trigger('change');
                $('#sale_tax_invoice_detail_discount_percent_'+$row_id).trigger('change');
                $('#sale_tax_invoice_detail_tax_percent_'+$row_id).trigger('change');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).html('<option selected="selected" value="'+json.product['product_id']+'">'+json.product['name']+'</option>');
                $('#last_rate').val(json.customer_rate);
                //  console.log(json.customer_rate);

            } else {
                alert(json.error);
            }
              $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({
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
                            page: params.page,
                            t: $product_type
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
                minimumInputLength: 2,
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

function getProductByCode($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    // $product_code = $($obj).val();
    $product_code = $('#sale_tax_invoice_detail_product_code_'+$row_id).val();
    $partner_id = $('#partner_id').val();
    $product_type = $('#sale_tax_invoice_detail_product_type_'+$row_id).find('option:selected').val();

    if($product_code!='')
    {

     $.ajax({
        url: $UrlGetProductByCode,
        dataType: 'json',
        type: 'post',
        data: 'product_code=' + $product_code+'&partner_id=' + $partner_id+'&product_type=' + $product_type,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-search').addClass('fa-refresh fa-spin');
        },
        complete: function() {
            $('#grid_row_'+$row_id+' .QSearchProduct i').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
            // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2('destroy');
            // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val('');
            // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2({width:'100%'});
            // $('#sale_tax_invoice_detail_qty_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_discount_percent_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_discount_amount_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_tax_percent_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_tax_amount_'+$row_id).val(0);
            $('#sale_tax_invoice_detail_product_id_'+$row_id).select2('destroy');
            if(json.success)
            {
                console.log(json.product)
                $('#sale_tax_invoice_detail_description_'+$row_id).val(json.product['name']);
                $('#sale_tax_invoice_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#sale_tax_invoice_detail_unit_'+$row_id).val(json.product['unit']);
                // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2('destroy');
                // $('#sale_tax_invoice_detail_product_id_'+$row_id).val(json.product['product_id']);
                // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#sale_tax_invoice_detail_product_id_'+$row_id).html('<option selected="selected" value="'+json.product['product_id']+'">'+json.product['name']+'</option>');
                $('#sale_tax_invoice_detail_rate_'+$row_id).val(json.product['cost_price']);
                $('#sale_tax_invoice_detail_cubic_meter_'+$row_id).val(json.product['cubic_meter']);
                $('#sale_tax_invoice_detail_cubic_feet_'+$row_id).val(json.product['cubic_feet']);
                $('#sale_tax_invoice_detail_rate_'+$row_id).trigger('change');
                $('#sale_tax_invoice_detail_discount_percent_'+$row_id).trigger('change');
                $('#sale_tax_invoice_detail_tax_percent_'+$row_id).trigger('change');
                $('#last_rate').val(json.customer_rate);
            } else {
                var pname = $('#sale_tax_invoice_detail_part_name_'+$row_id).val();
                if($product_type == 'part')
                {
                }
                else
                {
                alert(json.error);
                }

                $('#sale_tax_invoice_detail_description_'+$row_id).val('');
                $('#sale_tax_invoice_detail_unit_id_'+$row_id).val('');
                $('#sale_tax_invoice_detail_unit_'+$row_id).val('');
                // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2('destroy');
                $('#sale_tax_invoice_detail_product_id_'+$row_id).html('');
                // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({width:'100%'});
                $('#sale_tax_invoice_detail_rate_'+$row_id).val('0.00');
                $('#last_rate').val('0.00');
            }
            $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({
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
                            page: params.page,
                            t: $product_type
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
                minimumInputLength: 2,
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    });
}
}

function setProductInformation($obj) {
    var $data = $($obj).data();
    var $row_id = $('#'+$data['element']).parent().parent().parent().data('row_id');
    $product_type = $('#sale_tax_invoice_detail_product_type_'+$row_id).find('option:selected').val();
    $('#_modal').modal('hide');
    setTimeout(function(){
    $('#sale_tax_invoice_detail_product_code_'+$row_id).val($data['product_code']).change();
    },100);
    

    // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2('destroy');
    // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val('');
    // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2({width:'100%'});
    // $('#sale_tax_invoice_detail_qty_'+$row_id).val(0);
    // $('#sale_tax_invoice_detail_discount_percent_'+$row_id).val(0);
    // $('#sale_tax_invoice_detail_discount_amount_'+$row_id).val(0);
    // $('#sale_tax_invoice_detail_tax_percent_'+$row_id).val(0);
    // $('#sale_tax_invoice_detail_tax_amount_'+$row_id).val(0);
    // $('#sale_tax_invoice_detail_description_'+$row_id).val($data['name']);
    // $('#sale_tax_invoice_detail_product_code_'+$row_id).val($data['product_code']);
    // $('#sale_tax_invoice_detail_unit_id_'+$row_id).val($data['unit_id']);
    // $('#sale_tax_invoice_detail_unit_'+$row_id).val($data['unit']);
    // $('#sale_tax_invoice_detail_rate_'+$row_id).val($data['cost_price']);
    // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2('destroy');
    // // $('#sale_tax_invoice_detail_product_id_'+$row_id).val($data['product_id']);
    // // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({width: '100%'});
    // // $('#last_rate').val($data['customer_rate']);
    // $('#sale_tax_invoice_detail_product_id_'+$row_id).html('<option selected="selected" value="'+$data['product_id']+'">'+$data['name']+'</option>');
    // $('#sale_tax_invoice_detail_product_id_'+$row_id).select2({
    //     width: '100%',
    //     ajax: {
    //         url: $UrlGetProductJSON,
    //         dataType: 'json',
    //         type: 'post',
    //         mimeType:"multipart/form-data",
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 q: params.term, // search term
    //                 page: params.page,
    //                 t: $product_type
    //             };
    //         },
    //         processResults: function (data, params) {
    //             // parse the results into the format expected by Select2
    //             // since we are using custom formatting functions we do not need to
    //             // alter the remote JSON data, except to indicate that infinite
    //             // scrolling can be used
    //             params.page = params.page || 1;

    //             return {
    //                 results: data.items,
    //                 pagination: {
    //                     more: (params.page * 30) < data.total_count
    //                 }
    //             };
    //         },
    //         cache: true
    //     },
    //     escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    //     minimumInputLength: 2,
    //     templateResult: formatRepo, // omitted for brevity, see the source of this page
    //     templateSelection: formatRepoSelection // omitted for brevity, see the source of this page                }
    // });

}

function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
}

function calculateRowTotal($obj) {


    var $row_id = $($obj).parent().parent().data('row_id');
    var $available_stock = parseFloat($('#sale_tax_invoice_details_available_stock_'+$row_id).val()) || 0.00;
    var $qty = parseFloat($('#sale_tax_invoice_detail_qty_' + $row_id).val());
    if(  ($qty>$available_stock) && $allow_out_of_stock == 0 ) {
       // alert('Stock not available');
        $('#sale_tax_invoice_detail_qty_' + $row_id).val(0);
    } else {
        var $rate = parseFloat($('#sale_tax_invoice_detail_rate_' + $row_id).val());
        var $cog_rate = parseFloat($('#sale_tax_invoice_detail_cog_rate_' + $row_id).val());

        var $amount = $qty * $rate;
        var $cog_amount = $qty * $cog_rate;
        $amount = roundUpto($amount,2);
        $cog_amount = roundUpto($cog_amount,2);

        var $dis_percent = parseFloat($('#sale_tax_invoice_detail_discount_percent_'+ $row_id).val() || 0.0000);
        var $discount_amount = roundUpto($amount * $dis_percent / 100,2);

        var $tax_percent = parseFloat($('#sale_tax_invoice_detail_tax_percent_'+ $row_id).val() || 0.0000);
        var $tax_amount = roundUpto($amount * $tax_percent / 100,2);


        var $gross_amount = roundUpto($amount - $discount_amount,2);

        // var $tax_amount = parseFloat($('#sale_tax_invoice_detail_tax_amount_' + $row_id).val());
        var $total_amount = roundUpto($gross_amount + $tax_amount,2);

        $('#sale_tax_invoice_detail_cog_amount_' + $row_id).val($cog_amount);
        $('#sale_tax_invoice_detail_amount_' + $row_id).val($amount);
        $('#sale_tax_invoice_detail_discount_amount_' + $row_id).val($discount_amount);
        $('#sale_tax_invoice_detail_gross_amount_' + $row_id).val($gross_amount);
        $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val($tax_amount);
        $('#sale_tax_invoice_detail_total_amount_' + $row_id).val($total_amount);

        calculateTotal();
    }
}



function calculateTotal() {
    var $item_amount = 0;
    var $item_discount = 0;
    var $item_tax = 0;
    var $item_total = 0;
    $('#tblSaleInvoice tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $amount = $('#sale_tax_invoice_detail_amount_' + $row_id).val();
        $discount_amount = $('#sale_tax_invoice_detail_discount_amount_' + $row_id).val();
        $tax_amount = $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val();
        $total_amount = $('#sale_tax_invoice_detail_total_amount_' + $row_id).val();

        $item_amount += parseFloat($amount);
        $item_discount += parseFloat($discount_amount);
        $item_tax += parseFloat($tax_amount);
        $item_total += parseFloat($total_amount) || 0.00;
    })

    var $discount = $('#discount_amount').val() || 0.00;
    var $cartage = $('#cartage').val() || 0.00;

    var $net_amount = parseFloat($item_total) - parseFloat($discount) + parseFloat($cartage) || 0.00;

    $('#item_amount').val(roundUpto($item_amount,2));
    $('#item_discount').val(roundUpto($item_discount,2));
    $('#item_tax').val(roundUpto($item_tax,2));
    $('#item_total').val(roundUpto($item_total,2));
    $('#discount_amount').val(roundUpto($discount,2));
    $('#cartage').val(roundUpto($cartage,2));
    $('#net_amount').val(roundUpto($net_amount,2));

}

function calculateDiscountAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $discount_percent = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $discount_amount = roundUpto($amount * $discount_percent / 100,2);
    $('#sale_tax_invoice_detail_discount_amount_' + $row_id).val($discount_amount);
    calculateRowTotal($obj);
}

function calculateDiscountPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $discount_amount = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $discount_percent = roundUpto($discount_amount / $amount * 100,2);

    $('#sale_tax_invoice_detail_discount_percent_' + $row_id).val($discount_percent);
    calculateRowTotal($obj);
}

function calculateTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_percent = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_amount = roundUpto($amount * $tax_percent / 100,2);

    $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val($tax_amount);
    calculateRowTotal($obj);
}

function calculateTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_amount = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_percent = roundUpto($tax_amount / $amount * 100,2);

    $('#sale_tax_invoice_detail_tax_percent_' + $row_id).val($tax_percent);
    calculateRowTotal($obj);
}

function AddTaxes() {
    var $tax_per = $('#tax_per').val();

    $('#tblSaleInvoice tbody tr').each(function() {

        $row_id = $(this).data('row_id');

        var $amount = parseFloat($('#sale_tax_invoice_detail_amount_' + $row_id).val()) || 0.00;

        var $wht_percent = parseFloat($('#sale_tax_invoice_detail_tax_percent_' + $row_id).val($tax_per)) || 0.00;

        var $wht_amount = roundUpto(($amount * $tax_per / 100),2);
        $('#sale_tax_invoice_detail_tax_amount_' + $row_id).val($wht_amount);


        var $net_amount = $amount + $wht_amount;

        $('#sale_tax_invoice_detail_total_amount_' + $row_id).val(roundUpto($net_amount,2));
        $('#sale_tax_invoice_detail_amount_' + $row_id).val(roundUpto($amount,2));


    })

    calculateTotal();
}

function Save() {
    $('.warehouse_id').each(function() {
        $(this).rules("add", 
            {
                required: true,
                // remote: {url: $url_validate_stock, type: 'post'},
                messages: {
                    required: "Warehouse is required",
                  }
            });
    });
    $('.btnsave').attr('disabled','disabled');
    if($('#form').valid() == true){
        $('#form').submit();
    }
    else{
        $('.btnsave').removeAttr('disabled');
    }
}

$('[name="document_date"]').change(function(){

    $('#tblSaleInvoice tbody tr').each(function() {
        $row_id = $(this).data('row_id');        
        $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).trigger('change');
    });


});

function validateWarehouseStock($obj, $isEdit = false)
{
    var $row_id = $($obj).parent().parent().data('row_id');
    var $warehouse_id = $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val();
    var $product_id = $('#sale_tax_invoice_detail_product_id_'+$row_id).val();
    var $document_identity = '';
    if( $isEdit ) {
        $document_identity = $('[name="document_identity"]').val();
    }

    var $change_qty = parseFloat($('#sale_tax_invoice_detail_qty_'+$row_id).val()) || 0;
    var $document_date = $('[name="document_date"]').val();

    $.ajax({
        url: $url_validate_stock,
        dataType: 'json',
        type: 'post',
        data: {
          'warehouse_id' : $warehouse_id,  
          'product_id' : $product_id,  
          'document_identity' : $document_identity,  
          'document_date' : $document_date
        },
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
                $available_stock = parseFloat(json.stock_qty) || 0;
                if(!($available_stock > $change_qty) && $allow_out_of_stock == 0)
                {
                    // alert('hello');
                    //alert('Stock not available');
                    // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).append('<label style="color:red;"></label>');
                    $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2('destroy');
                    $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val('');
                    $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).select2({width:'100%'});
                    // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val('');
                    // $('#sale_tax_invoice_detail_warehouse_id_'+$row_id).val('');

                }
                if( !$isEdit ) {
                    $('#sale_tax_invoice_details_available_stock_'+$row_id).val(json.stock_qty);
                } else {
                    $('#sale_tax_invoice_details_available_stock_'+$row_id).val(parseFloat(json.stock_qty));
                }
                $('#sale_tax_invoice_detail_cog_rate_'+$row_id).val(json['avg_stock_rate']);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}