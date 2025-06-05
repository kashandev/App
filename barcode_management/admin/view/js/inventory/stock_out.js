/**
 * Created by Huzaifa on 9/18/15.
 */

$(document).ready(function(){
    $("#loaderjs").addClass('hide');
});


// $(document).on('change','#ref_document_id',function() {
//    var $ref_document_id = $(this).val();
//    // console.log( $ref_document_id )
//    $.ajax({
//        url: $GetRefDocumentRecord,
//        dataType: 'json',
//        type: 'post',
//        data: 'ref_document_id='+$ref_document_id,
//        mimeType:"multipart/form-data",
//        beforeSend: function() {
// //            $('#unit_id').parent().before('<i id="loader" class="fas fa-spinner fa-spin pull-right"></i>');
//        },
//        complete: function() {
// //            $('#loader').remove();
//        },
//        success: function(json) {

//            // $('#partner_id').val(json.data['partner_id']).trigger('change');
//            // $('#po_no').val(json.data['po_no']);

//        },
//        error: function(xhr, ajaxOptions, thrownError) {
//            console.log(xhr.responseText);
//        }
//    })
// })


$(document).on('change','#partner_type_id', function() {
    $partner_type_id = $(this).val();
    $.ajax({
        url: $UrlGetPartnerById,
        dataType: 'json',
        type: 'post',
        data: 'partner_type_id=' + $partner_type_id+'&partner_id='+$partner_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#partner_id').before('<i id="loader" class="fas fa-spinner fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            console.log(  )
            if(json.success)
            {
                $('#partner_id').select2('destroy');
                $('#partner_id').select2({width:'100%'});
                $('#partner_id').html('<option selected="selected" value="'+(json.partner['partner_id']??'')+'">'+(json.partner['name']??'')+'</option>');
                $('#partner_id').select2({
                    width: '100%',
                    ajax: {
                        url: $UrlGetPartnerJSON + '&partner_type_id='+$('#partner_type_id').val(),
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

// $('#partner_id').on('change', function(){
//     $('#tblStockOut tbody').empty();
// })

$(document).on('click','.btnAddGrid', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '<td>';
    $html += '<input onchange="getProductBySerialNo(this);" type="text" class="form-control" name="stock_out_details['+$grid_row+'][serial_no]" id="stock_out_detail_serial_no_'+$grid_row+'" value="" />';
    $html += '<input type="hidden" class="form-control" name="stock_out_details['+$grid_row+'][product_code]" id="stock_out_detail_product_code_'+$grid_row+'"  />';
    $html += '</td>';
    $html += '<td style="min-width: 200px">';
    $html += '<select class="form-control Select2Product" id="stock_out_detail_product_master_id_'+$grid_row+'" name="stock_out_details['+$grid_row+'][product_master_id]">';
    $html += '<option value="">&nbsp;</option>';
    $html += '</select>';
    $html+= '<input type="hidden" id="stock_out_detail_product_id_'+$grid_row+'" name="stock_out_details['+$grid_row+'][product_id]">'
    $html += '</td>';

    $html += '<td>';
    $html += '<textarea style="width: 200px" rows="2" type="text" class="form-control" name="stock_out_details['+$grid_row+'][description]" id="stock_out_detail_description_'+$grid_row+'" readonly></textarea>';
    $html += '</td>';

    $html += '<td>';
    $html += '<select style="width: 300px" required class="form-control select2 required" name="stock_out_details['+$grid_row+'][warehouse_id]" id="stock_out_detail_warehouse_id_'+$grid_row+'" >';
    $html += '<option value="">&nbsp;</option>';
    $warehouses.forEach(function($warehouse){
        $html += '<option value="'+ $warehouse.warehouse_id +'">'+ $warehouse.name +'</option>';
    });
    $html += '</select>';
    $html += '<label for="stock_out_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="hidden" name="stock_out_details['+$grid_row+'][unit_id]" id="stock_out_detail_unit_id_'+$grid_row+'" class="form-control" readonly>';  
    $html += '<input type="text" name="stock_out_details['+$grid_row+'][unit]" id="stock_out_detail_unit_'+$grid_row+'" class="form-control" readonly>';
    $html += '</td>';

    $html += '<td>';
    $html += '<input style="min-width: 100px; text-align: right; " type="text" class="form-control fPDecimal" name="stock_out_details['+$grid_row+'][qty]" id="stock_out_detail_qty_'+$grid_row+'" value="1" readonly="true" />';
    $html += '</td>';

    $html += '<td>';
    $html += '<input type="text" onchange="calculateRowTotal(this);" style="min-width: 100px; text-align: right;" class="form-control fPDecimal" name="stock_out_details['+$grid_row+'][unit_price]" id="stock_out_detail_unit_price_'+$grid_row+'" value="0" />';
    $html += '</td>';


    $html += '<td>';
    $html += '<input type="text" style="min-width: 100px; text-align: right;" class="form-control fPDecimal" id="stock_out_detail_total_price_'+$grid_row+'"  name="stock_out_details['+$grid_row+'][total_price]" value="" readonly="true" />';
    $html += '</td>';

    $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
    $html += '</tr>';


    $('#tblStockOut tbody').prepend($html);
    //setFieldFormat();
    Select2ProductJsonStockOut('#stock_out_detail_product_master_id_'+$grid_row);
    $('#stock_out_detail_product_master_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        var $product_id = $data['id'];
        getProductById($row_id,$product_id)
    });

    $('#stock_out_detail_warehouse_id_'+$grid_row).select2({'width':'100%'});
    $grid_row++;
});


function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    $('#grid_row_'+$row_id).remove();
    calculateTotal();
    $grid_row--;
}

function calculateRowTotal($obj) {
        var $row_id = $($obj).parent().parent().data('row_id');
        var $qty = parseFloat($('#stock_out_detail_qty_' + $row_id).val());
        var $rate = parseFloat($('#stock_out_detail_unit_price_' + $row_id).val());

        var $amount = $qty * $rate;

        var $gross_amount = roundUpto($amount,2);

        // var $tax_amount = parseFloat($('#stock_out_detail_tax_amount_' + $row_id).val());
        var $total_price = roundUpto($gross_amount);
        $('#stock_out_detail_total_price_' + $row_id).val($total_price);

        calculateTotal();
}

// calculate discount amount function
function calculateDiscountAmount() {
    var $discount_percent = parseFloat($('#discount_percent').val() || 0.00);
    var $amount = parseFloat($('#total_price_master').val() || 0.00);
    var $discount_amount = roundUpto($amount * $discount_percent / 100,2);
    var $net_amount = roundUpto($amount - $discount_amount);
    $('#discount_amount').val(rDecimal($discount_amount,2));
    $('#net_amount').val(rDecimal($net_amount,2));
}

// calculate discount percent function
function calculateDiscountPercent() {
    var $discount_amount = $('#discount_amount').val() || 0.00;
    var $amount = parseFloat($('#total_price_master').val() || 0.00);
    var $discount_percent = roundUpto($discount_amount / $amount * 100,2);
    var $net_amount = roundUpto($amount - $discount_amount);
    $('#discount_percent').val(rDecimal($discount_percent,2));
    $('#net_amount').val(rDecimal($net_amount,2));
}


function calculateTotal() {
    var $total_qty = 0;
    var $total_price = 0;
    var $item_total = 0;
    $('#tblStockOut tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $qty = parseFloat($('#stock_out_detail_qty_'+$row_id).val());
        $total_price = parseFloat($('#stock_out_detail_total_price_' + $row_id).val());
        $total_qty += $qty;
        $item_total += parseFloat($total_price);
    })
    var $discount_amount = $('#discount_amount').val() || 0.00;
    var $total_net_amount = parseFloat($item_total) - parseFloat($discount_amount);
    $('#qty_master').val(rDecimal($total_qty,2));
    $('#total_qty_master').val(rDecimal($total_qty,2));      
    $('#total_price_master').val(rDecimal($item_total,2));
    $('#net_amount').val(rDecimal($total_net_amount,2));

}

$('[name="document_date"]').change(function(){

    $('#tblStockOut tbody tr').each(function() {
        $row_id = $(this).data('row_id');
        $('#stock_out_detail_warehouse_id_'+$row_id).trigger('change');
    });


});

$(document).on('change','#master_serial_no', function() {
    var $obj = this;
    var $master_serial_no = $(this).val();
    $.ajax({
        url: $UrlGetProductBySerialNo,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $master_serial_no,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#serial_code').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
            $('#serial_code').val('');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            fillGrid(json,$master_serial_no);
            $('#master_serial_no').val('');
            $('#master_serial_no').focus();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
});

 function fillGrid($data,$serial_no) {
    if($data.error)
    {
      alert($data.error)
    }
    else
    {    
        let $isExists = $('#tblStockOut').find('tbody').find('tr[data-serial-no="'+$serial_no+'"]').length;
        if($isExists===0) {
            $html = '';
            $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'" data-serial-no="'+$serial_no+'">';
            $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
            $html += '<td>';
            $html += '<input type="text" class="form-control row-serial-no" name="stock_out_details['+$grid_row+'][serial_no]" id="stock_out_detail_serial_no_'+$grid_row+'" value="'+$data.product['serial_no']+'" readonly />';
            $html += '<input type="hidden" class="form-control" name="stock_out_details['+$grid_row+'][product_code]" id="stock_out_detail_product_code_'+$grid_row+'"  value="'+$data.product['product_code']+'"  />';
            $html += '</td>';
            $html += '<td style="min-width: 200px">';
            $html += '<select class="form-control Select2Product" id="stock_out_detail_product_master_id_'+$grid_row+'" name="stock_out_details['+$grid_row+'][product_master_id]">';
            $html += '<option value="">&nbsp;</option>';
            $html+= '<option value="'+$data.product['product_master_id']+'" selected>'+ $data.product['product_code'] + ' - ' + $data.product['name'] +'</option>';
            $html += '</select>';
            $html+= '<input type="hidden" id="stock_out_detail_product_id_'+$grid_row+'" name="stock_out_details['+$grid_row+'][product_id]" value="'+$data.product['product_id']+'">'
            $html += '</td>';

            $html += '<td>';
            $html += '<textarea style="width: 200px" rows="2" type="text" class="form-control" name="stock_out_details['+$grid_row+'][description]" id="stock_out_detail_description_'+$grid_row+'" readonly>'+$data.product['name']+'</textarea>';
            $html += '</td>';

            $html += '<td>';
            $html += '<select style="width: 300px" required class="form-control select2 required" name="stock_out_details['+$grid_row+'][warehouse_id]" id="stock_out_detail_warehouse_id_'+$grid_row+'" >';
            $html += '<option value="">&nbsp;</option>';
            $warehouses.forEach(function($warehouse){
            if($data.product['product_warehouse'] == $warehouse.warehouse_id)
            {
                $selected = 'selected';
            }
            else
            {
                $selected = ''; 
            }
              $html += '<option value="'+ $warehouse.warehouse_id +'" '+$selected+'>'+ $warehouse.name +'</option>';
            });
            $html += '</select>';
            $html += '<label for="stock_out_detail_warehouse_id_'+$grid_row+'" class="error" style="display:none"></label>';
            $html += '</td>';

            $html += '<td>';
            $html += '<input type="hidden" name="stock_out_details['+$grid_row+'][unit_id]" id="stock_out_detail_unit_id_'+$grid_row+'" class="form-control" value="'+$data.product['unit_id']+'" readonly>';  
            $html += '<input type="text" name="stock_out_details['+$grid_row+'][unit]" id="stock_out_detail_unit_'+$grid_row+'" class="form-control" value="'+$data.product['unit']+'" readonly>';
            $html += '</td>';

            $html += '<td>';
            $html += '<input style="min-width: 100px; text-align: right;" type="text" class="form-control fPDecimal" name="stock_out_details['+$grid_row+'][qty]" id="stock_out_detail_qty_'+$grid_row+'" value="1" readonly="true" />';
            $html += '</td>';

            $html += '<td>';
            $html += '<input type="text" onchange="calculateRowTotal(this);" style="min-width: 100px; text-align: right;" class="form-control fPDecimal" name="stock_out_details['+$grid_row+'][unit_price]" id="stock_out_detail_unit_price_'+$grid_row+'" value="'+$data.product['cost_price']+'" />';
            $html += '</td>';

            $html += '<td>';
            $html += '<input type="text" style="min-width: 100px; text-align: right;" class="form-control fPDecimal" id="stock_out_detail_total_price_'+$grid_row+'"  name="stock_out_details['+$grid_row+'][total_price]" value="" readonly="true" />';
            $html += '</td>';

            $html += '<td><a id="btnAddGrid" title="Add" class="btn btn-xs btn-primary btnAddGrid" href="javascript:void(0);"><i class="fa fa-plus"></i></a><a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a></td>';
            $html += '</tr>';
            $grid_row++;
             $('#tblStockOut tbody').prepend($html);  

            $('#tblStockOut tbody tr').each(function(){
            var $row = $(this).data('row_id');
             $('#stock_out_detail_warehouse_id_'+$row).select2({'width':'100%'});
             $('#stock_out_detail_unit_price_'+$row).trigger('change');

             });
           }
         if ($data.available_stock['stock_amount'] == 0)
         {
         alert('Stock not available');
         $('#tblStockOut tbody tr').each(function(){
         var $row = $(this).data('row_id');
         $('#grid_row_'+$row).remove();
         $grid_row--;
         $grid_row = 0;
         calculateTotal();
         $('#stock_out_detail_description_'+$row).val('');
         $('#stock_out_detail_serial_no_'+$row).val('');  
         $('#stock_out_detail_product_code_'+$row).val('');   
         $('#stock_out_detail_unit_id_'+$row).val('');
         $('#stock_out_detail_unit_'+$row).val('');
         $('#stock_out_detail_product_id_'+$row).val('');  
         $('#stock_out_detail_product_master_id_'+$row).select2('destroy');
         $('#stock_out_detail_product_master_id_'+$row).html('');
         $('#stock_out_detail_product_master_id_'+$row).select2({'width':'100%'});
         $('#stock_out_detail_warehouse_id_'+$row).val('');
         $('#stock_out_detail_warehouse_id_'+$row).select2('destroy');
         $('#stock_out_detail_warehouse_id_'+$row).select2({'width':'100%'})
         $('#stock_out_detail_warehouse_id_'+$row).attr('selected',false);
         $('#stock_out_detail_unit_price_'+$row).val('0.00');
         });   
      } 
        Select2ProductJsonStockOut('#stock_out_detail_product_master_id_'+$grid_row);
        $('#stock_out_detail_unit_price_'+$grid_row).trigger('change');
        $('#stock_out_detail_product_master_id_'+$grid_row).on('select2:select', function (e) {
        var $row_id = $(this).parent().parent().data('row_id');
        var $data = e.params.data;
        var $product_id = $data['id'];
        getProductById($row_id,$product_id)
      });   
   }
}
// function get product by serial no 
function getProductBySerialNo($obj) {
    $serial_no = $($obj).val();
    var $row_id = $($obj).parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductBySerialNo,
        dataType: 'json',
        type: 'post',
        data: 'serial_no=' + $serial_no,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            //$('#stock_out_detail_product_code_'+$row_id).removeClass('fa-search').addClass('fa-spinner fa-spin');
        },
        complete: function() {
            // $('#stock_out_detail_product_code_'+$row_id).removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-search');
        },
        success: function(json) {
             if(json.success)
             {

              if(json.available_stock['stock_amount'] > 0 )
               {   
                $('#stock_out_detail_product_code_'+$row_id).val(json.product['product_code']);   
                $('#stock_out_detail_description_'+$row_id).val(json.product['name']);
                $('#stock_out_detail_warehouse_id_'+$row_id).val(json.product['product_warehouse']).trigger('change');
                $('#stock_out_detail_unit_id_'+$row_id).val(json.product['unit_id']);
                $('#stock_out_detail_unit_'+$row_id).val(json.product['unit']);
                $('#stock_out_detail_product_id_'+$row_id).val(json.product['product_id']);  
                $('#stock_out_detail_product_master_id_'+$row_id).html('<option value="'+ json.product['product_master_id'] +'">'
                    + json.product['product_code'] + ' - ' + json.product['name'] +
                '</option>');
                $('#stock_out_detail_product_master_id_'+$row_id).select2({'width':'100%'});
                $('#stock_out_detail_unit_price_'+$row_id).val(json.product['cost_price']).trigger('change');
             }
             else {
                alert('Stock not available');
                $('#stock_out_detail_description_'+$row_id).val('');
                $('#stock_out_detail_serial_no_'+$row_id).val('');  
                $('#stock_out_detail_product_code_'+$row_id).val('');   
                $('#stock_out_detail_unit_id_'+$row_id).val('');
                $('#stock_out_detail_unit_'+$row_id).val('');
                $('#stock_out_detail_product_id_'+$row_id).val('');  
                $('#stock_out_detail_product_master_id_'+$row_id).select2('destroy');
                $('#stock_out_detail_product_master_id_'+$row_id).html('');
                $('#stock_out_detail_product_master_id_'+$row_id).select2({'width':'100%'});
                $('#stock_out_detail_unit_price_'+$row_id).val('0.00');
            }
            }
            else {

 if (typeof json.error === "undefined") {
   alert('Stock not available');
 }
 else
 {
   alert(json.error); 

 }


                $('#stock_out_detail_description_'+$row_id).val('');
                $('#stock_out_detail_serial_no_'+$row_id).val('');  
                $('#stock_out_detail_product_code_'+$row_id).val('');   
                $('#stock_out_detail_unit_id_'+$row_id).val('');
                $('#stock_out_detail_unit_'+$row_id).val('');
                $('#stock_out_detail_product_id_'+$row_id).val('');  
                $('#stock_out_detail_product_master_id_'+$row_id).select2('destroy');
                $('#stock_out_detail_product_master_id_'+$row_id).html('');
                $('#stock_out_detail_product_master_id_'+$row_id).select2({'width':'100%'});
                $('#stock_out_detail_unit_price_'+$row_id).val('0.00');
            }
        Select2ProductJsonStockOut('#stock_out_detail_product_master_id_'+$row_id);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}


// function get product by Id
function getProductById($obj,$id) {
    var $row_id = $obj
    var $product_id = $id;  
    $.ajax({
        url: $UrlGetProductBySerialNo,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id,
        mimeType:"multipart/form-data",
        success: function($products) {
           $products['product'].forEach(function($product,$index){
              if($row_id == $index)
              {
                $('#stock_out_detail_serial_no_'+$row_id).val($product['serial_no']).trigger('change');  
              }
           });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

    function Save(){
        if($('#form').valid() == true){
            
            $('.btnSave').attr('disabled','disabled');
            $("#loaderjs").removeClass('hide');
            
            setTimeout(function(){
               
               $('#tblStockOut tbody tr').each(function(sort_order) {
                    var $row_id = $(this).data('row_id');
                    $data = [];
                    $data['row_id'] = $row_id;
                    $data['sort_order'] = sort_order;
                    $data['form_key'] = $('#form_key').val();

                    $(this).children('td').find('input, select, textarea').each(function(){
                        $name = $(this).attr('id').replace('stock_out_detail_', '');
                        $name = $name.replace(/_[0-9]+/, '');
                        $data[$name] = $(this).val();
                    });

                    $.ajax({
                        url: $UrlAddRecords,
                        dataType: 'json',
                        type: 'post',
                        async: false,
                        data: $.extend({}, $data), // Convert data array into object
                        mimeType:"multipart/form-data",
                        beforeSend: function() {},
                        complete: function() {},
                        success: function(json) {
                            if(json.success) {
                                console.log( json )
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr.responseText);
                        }
                    });                

                });

                $('#form').submit();
            
            },1000);

        } else {
            $('.btnSave').removeAttr('disabled');
            $("#loaderjs").addClass('hide');
        }
    }