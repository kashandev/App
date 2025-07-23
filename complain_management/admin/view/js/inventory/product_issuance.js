/**
 * Created by Huzaifa on 9/18/15.
 */

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

$(document).on('click','#btnAddGridParts', function() {
    $html = '';
    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGridParts" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '<td>';
    $html += '<select onchange="setProductIDField();" class="form-control select2 product code1" id="product_issuance_detail_product_type_'+$grid_row+'"  name="product_issuance_details['+$grid_row+'][product_type]" >';
    $html += '<option value="service">Service</option>';
    $html += '<option value="part">Part</option>';
    $html += '</select>';
    $html += '<td>';
    $html += '<input  type="text" class="form-control" name="product_issuance_details['+$grid_row+'][product_code]" id="product_issuance_detail_product_code_'+$grid_row+'" />';
    $html += '<td>'; 
    $html += '<select onchange="getProductById(this);" class="form-control select2 product code1" id="product_issuance_detail_product_id_'+$grid_row+'" name="product_issuance_details['+$grid_row+'][product_id]" >';
    $html += '<option value="">&nbsp;</option>';
     $products.forEach(function($product) {
            $html += '<option value="'+$product.product_id+'" >'+$product.name+'</option>';
    });
    $html += '</select>';
    $html += '<input style="display:none" type="text" class="form-control" name="product_issuance_details['+$grid_row+'][part_name]" id="product_issuance_detail_part_name_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" onchange="calculatPartTotalAmount();" class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][quantity]" id="product_issuance_detail_qty_'+$grid_row+'" value="" />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text"  onchange="calculatPartTotalAmount();" class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][rate]" id="product_issuance_detail_rate_'+$grid_row+'" value=""  />';
    $html += '</td>';
    $html += '<td>';
    $html += '<input type="text" readonly onchange="calculatPartTotalAmount();"  class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][amount]" id="product_issuance_detail_amount_'+$grid_row+'" value=""  />';
    $html += '</td>';
    $html += '<td>';
    $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGridParts" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
    $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
    $html += '</td>';
    $html += '</tr>';

    $('#tblParts tbody').append($html);
    setFieldFormat();

    $('#product_issuance_detail_product_type_'+$grid_row).trigger('change');

    $grid_row++;

});




function getProductById($obj) {

    $product_id = $($obj).val();
    var $row_id = $($obj).parent().parent().data('row_id');
    $.ajax({
        url: $UrlGetProductById,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id,
        mimeType:"multipart/form-data",
      
        success: function(json) {
            if(json)
            {
                $('#product_issuance_detail_product_code_'+$row_id).val(json.product['product_code']);
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
       
        success: function(json) {
            if(json.success)
            {
                $('#product_issuance_detail_product_id_'+$row_id).val(json.product['product_id']);
                $('#product_issuance_detail_product_id_'+$row_id).trigger('change');
            }
            else {
                alert(json.error);
              
            }
           
        }
    });
}


function getPartyByRefDoc($obj) {

    $job_order_id = $($obj).val();
    $('#tblParts tbody').html('');
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
                $('#customer_name').val($data[0]['customer_name']);
                $('#product_name').val($data[0]['job_order_product_name']);

                
                $data.forEach(function(data) {
                    $html = '';

                    $html += '<tr id="grid_row_'+$grid_row+'" data-row_id="'+$grid_row+'">';
                        $html += '<td>';
                        $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGridParts" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
                        $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
                        $html += '</td>';

                    
                        if(data['product_type']=="part"){
                            $html += '<td>'; 
                            $html += '<select onchange="setProductIDField();" class="form-control select2 product code1" id="product_issuance_detail_product_type_'+$grid_row+'" name="product_issuance_details['+$grid_row+'][product_type]" >';
                            $html += '<option value="part" selected >Part</option>';
                            $html += '<option value="service">Service</option>';
                            $html += '</select>';  
                            $html += '</td>';

                            $html += '<td>'; 
                            $html += '<input type="text" class="form-control" name="product_issuance_details['+$grid_row+'][product_code]" id="product_issuance_detail_product_code_'+$grid_row+'" value="'+data['product_code']+'" />';
                            $html += '</td>';

                            $html += '<td>'; 
                            $html += '<input type="text" class="form-control" name="product_issuance_details['+$grid_row+'][part_name]" id="product_issuance_detail_part_name_'+$grid_row+'" value="'+data['part_name']+'" />';
                            $html += '<select onchange="getProductById(this);" class="form-control select2 product code1 " id="product_issuance_detail_product_id_'+$grid_row+'" name="product_issuance_details['+$grid_row+'][product_id]" >';
                            $html += '<option value="">&nbsp;</option>';
                            $products.forEach(function($Allproduct) {
                                if($Allproduct['product_id']==data['product_id']){
                                    $html += '<option value="'+$Allproduct.product_id+'" selected> '+$Allproduct.name+'</option>';
                                }
                                else{
                                    $html += '<option value="'+$Allproduct.product_id+'"> '+$Allproduct.name+'</option>';
                                }
                            });
                            $html += '</select>';
                            $html += '</td>';

                            $html += '<td>';
                            $html += '<input type="text" onchange="calculatPartTotalAmount();" class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][quantity]" id="product_issuance_detail_qty_'+$grid_row+'" value="'+data['quantity']+'"   />';
                            $html += '</td>';

                            $html += '<td>';
                            $html += '<input type="text" onchange="calculatPartTotalAmount();" class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][rate]" id="product_issuance_detail_rate_'+$grid_row+'" value="'+data['rate']+'"  />';
                            $html += '</td>';
                            $html += '<td>';
                            $html += '<input type="text" readonly class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][amount]" id="product_issuance_detail_amount_'+$grid_row+'" readonly value="'+data['amount']+'"  />';
                            $html += '</td>';


                        }
                        else if(data['product_type']=="service"){
                            $html += '<td>'; 
                            $html += '<select onchange="setProductIDField();" class="form-control select2 product code1" id="product_issuance_detail_product_type_'+$grid_row+'" name="product_issuance_details['+$grid_row+'][product_type]" >';
                            $html += '<option value="part" >Part</option>';
                            $html += '<option value="service" selected>Service</option>';
                            $html += '</select>';  
                            $html += '</td>';

                            $html += '<td>'; 
                            $html += '<input onchange="getProductByCode(this);" type="text" class="form-control" name="product_issuance_details['+$grid_row+'][product_code]" id="product_issuance_detail_product_code_'+$grid_row+'" value="'+data['product_code']+'" />';
                            $html += '</td>';

                            $html += '<td>'; 
                            $html += '<input type="text" class="form-control" name="product_issuance_details['+$grid_row+'][part_name]" id="product_issuance_detail_part_name_'+$grid_row+'" value="'+data['part_name']+'" />';
                            $html += '<select onchange="getProductById(this);" class="form-control select2 product code1" id="product_issuance_detail_product_id_'+$grid_row+'" name="product_issuance_details['+$grid_row+'][product_id]" >';
                            $html += '<option value="">&nbsp;</option>';
                            $products.forEach(function($Allproduct) {
                                if($Allproduct['product_id']==data['product_id']){
                                    $html += '<option value="'+$Allproduct.product_id+'" selected> '+$Allproduct.name+'</option>';
                                }
                                else{
                                    $html += '<option value="'+$Allproduct.product_id+'"> '+$Allproduct.name+'</option>';
                                }
                            });
                            $html += '</select>';
                            $html += '</td>';

                            $html += '<td>';
                            $html += '<input type="text" readonly class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][quantity]" id="product_issuance_detail_qty_'+$grid_row+'"   />';
                            $html += '</td>';
                            $html += '<td>';
                            $html += '<input type="text"  onchange="calculatPartTotalAmount();" class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][rate]" id="product_issuance_detail_rate_'+$grid_row+'" value="'+data['amount']+'"  />';
                            $html += '</td>';
                            $html += '<td>';
                            $html += '<input type="text" readonly  class="form-control fDecimal" name="product_issuance_details['+$grid_row+'][amount]" id="product_issuance_detail_amount_'+$grid_row+'"  />';
                            $html += '</td>';

                        }
                
                        $html += '<td>';
                        $html += '<a title="Add" class="btn btn-xs btn-primary btnAddGrid" id="btnAddGridParts" href="javascript:void(0);"><i class="fa fa-plus"></i></a>';
                        $html += '<a onclick="removeRow(this);" title="Remove" class="btn btn-xs btn-danger" href="javascript:void(0);"><i class="fa fa-times"></i></a>';
                        $html += '</td>';
                    $html += '</tr>';
                    
                    $('#tblParts tbody').append($html);
                    setFieldFormat();


                    // $('#select2-product_issuance_detail_product_type_'+$grid_row+'-container').parent().parent().parent().trigger('change');
                    $grid_row++;

                });
                
                setProductIDField();
            }
        },
      
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })

}


function setProductIDField(){
    $grand_total_quantity=0;
    $grand_total_amount=0;

    $('#tblParts tbody tr').each(function(){
        let $i = $(this).data('row_id');
        $product_type = $('#product_issuance_detail_product_type_'+$i).find('option:selected').val();
        let obj = $('#product_issuance_detail_product_id_'+$i).next(".select2-container");
        const btn = document.getElementById('product_issuance_detail_product_code_'+$i);

        if($product_type=="part"){
            $('#product_issuance_detail_part_name_'+$i).show();

            $('#product_issuance_detail_product_id_'+$i).next(".select2-container").hide();
            $('#product_issuance_detail_product_id_'+$i).css("display","none");

            $('#product_issuance_detail_qty_'+$i).prop("readonly", false);
            $('#product_issuance_detail_amount_'+$i).prop("readonly", true);

            var $quantity = parseFloat($('#product_issuance_detail_qty_'+$i).val()) || 0.0000;

            var $rate = parseFloat($('#product_issuance_detail_rate_'+$i).val()) || 0.0000;
            var $total_amount = parseFloat($rate) * parseFloat($quantity);

            $('#product_issuance_detail_amount_'+$i).val($total_amount) ;
            btn.removeEventListener('change', getProductByCode, true);


        }else if($product_type=="service"){

            $('#product_issuance_detail_part_name_'+$i).hide();
            $('#product_issuance_detail_product_id_'+$i).next(".select2-container").show();
            $('.input-group').css("display","unset");

            $('#product_issuance_detail_qty_'+$i).prop("readonly", true);
            $('#product_issuance_detail_qty_'+$i).val('1.0000');
            $('#product_issuance_detail_amount_'+$i).prop("readonly", true);
            // $('#product_issuance_detail_rate_'+$i).val(0.00);
            var $quantity = parseFloat($('#product_issuance_detail_qty_'+$i).val()) || 0.0000;

            var $rate = parseFloat($('#product_issuance_detail_rate_'+$i).val()) || 0.0000;
            var $total_amount = parseFloat($rate) * parseFloat($quantity);

            $('#product_issuance_detail_amount_'+$i).val($total_amount) ;

            btn.addEventListener("change", getProductByCode,true);
        
        }else{
            $('#product_issuance_detail_part_name_'+$i).hide();
            $('#select2-product_issuance_detail_product_id_'+$i+'-container').parent().parent().parent().hide();
        }

         $grand_total_amount = parseFloat($total_amount) + parseFloat($grand_total_amount);
         $grand_total_quantity = parseFloat($quantity) + parseFloat($grand_total_quantity);

        $i++;
     });

     $('#total_amount').val($grand_total_amount);
     $('#total_quantity').val($grand_total_quantity);

}

function setProductInformation($obj) {
    var $data = $($obj).data();
    var $row_id = $('#'+$data['element']).parent().parent().parent().data('row_id');
    $('#_modal').modal('hide');
    $('#quotation_detail_product_code_'+$row_id).val($data['product_code']);
    $('#quotation_detail_unit_id_'+$row_id).val($data['unit_id']);
    $('#quotation_detail_unit_'+$row_id).val($data['unit']);
    $('#quotation_detail_description_'+$row_id).val($data['name']);
    $('#quotation_detail_product_id_'+$row_id).select2('destroy');
    $('#quotation_detail_product_id_'+$row_id).html('<option selected="selected" value="'+$data['product_id']+'">'+$data['name']+'</option>');
    $('#quotation_detail_product_id_'+$row_id).select2({
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
}




function calculateAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $qty = parseFloat($('#quotation_detail_qty_' + $row_id).val()) || 0.00;
    var $rate = parseFloat($('#quotation_detail_rate_' + $row_id).val()) || 0.00;


    var $amount = $qty * $rate;
    $amount = roundUpto($amount,2);

    $('#quotation_detail_amount_' + $row_id).val($amount);
    $('#quotation_detail_tax_percent_' + $row_id).trigger('change');
}

function removeRow($obj) {
    //console.log($obj);
    var $row_id = $($obj).parent().parent().data('row_id');
    var $quantity = $('#product_issuance_detail_qty_'+$row_id).val() || 0.0000;
    var $rate = $('#product_issuance_detail_rate_'+$row_id).val() || 0.0000;
    $total_quantity= $('#total_quantity').val();
    $total_amount=$('#total_amount').val();

    var $amount = $rate * $quantity;
    var $qty = $quantity;
    $new_amount = $total_amount-$amount;
    $new_quantity= $total_quantity - $qty;

    $('#total_quantity').val($new_quantity);
    $('#total_amount').val($new_amount);


    $('#grid_row_'+$row_id).remove();

}

function calculatPartTotalAmount() {

    $i=0;
    var $grand_total_quantity=0.00;
    var $grand_total_amount=0.00;

    $('#tblParts tbody tr').each(function(){

        var $rate = parseFloat($('#product_issuance_detail_rate_'+$i).val()) || 0.0000;
        var $quantity = parseFloat($('#product_issuance_detail_qty_'+$i).val()) || 0.0000;

        var $total_amount = $rate * $quantity;
    
        $('#product_issuance_detail_amount_'+$i).val($total_amount) ;

        $grand_total_quantity = parseFloat($quantity) + parseFloat($grand_total_quantity);
        $grand_total_amount = parseFloat($total_amount) + parseFloat($grand_total_amount);

        $i++;
    });
    $('#total_amount').val($grand_total_amount);
    $('#total_quantity').val($grand_total_quantity);
}


function calculateTaxAmount($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_percent = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#quotation_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_amount = roundUpto($amount * $tax_percent / 100,2);

    $('#quotation_detail_tax_amount_' + $row_id).val($tax_amount);
    calculateRowTotal($obj);
}

function calculateTaxPercent($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');
    var $tax_amount = parseFloat($($obj).val() || 0.0000);
    var $amount = parseFloat($('#quotation_detail_amount_' + $row_id).val() || 0.0000);
    var $tax_percent = roundUpto($tax_amount / $amount * 100,2);

    $('#quotation_detail_tax_percent_' + $row_id).val($tax_percent);
    calculateRowTotal($obj);
}

function calculateRowTotal($obj) {
    var $row_id = $($obj).parent().parent().data('row_id');

    var $amount = parseFloat($('#quotation_detail_amount_' + $row_id).val());

    var $tax_amount = parseFloat($('#quotation_detail_tax_amount_' + $row_id).val());
    var $total_amount = roundUpto($amount + $tax_amount,2);

    $('#quotation_detail_net_amount_' + $row_id).val($total_amount);

    calculateTotal();
}

function calculateTotal() {
    var $item_amount = 0;
    var $item_discount = 0;
    var $item_tax = 0;
    var $item_total = 0;
    var $total_quantity = 0;
    $('#tblQuotation tbody tr').each(function() {
        var $row_id = $(this).data('row_id');
        var $amount = $('#quotation_detail_amount_' + $row_id).val();
        var $tax_amount = $('#quotation_detail_tax_amount_' + $row_id).val();
        var $total_amount = $('#quotation_detail_net_amount_' + $row_id).val();
        var $quantity = $('#quotation_detail_qty_' + $row_id).val();

        $item_amount += parseFloat($amount);
        $item_tax += parseFloat($tax_amount);
        $item_total += parseFloat($total_amount);
        $total_quantity += parseFloat($quantity);
    })

    var $net_amount = $item_total ;

    $('#total_quantity').val(roundUpto($total_quantity,0));
    $('#item_amount').val(roundUpto($item_amount,2));
    $('#item_tax').val(roundUpto($item_tax,2));
    $('#item_total').val(roundUpto($item_total,2));
}


$(document).on('change','#term_id', function() {
    var $terms ='';
    var $lb ='\n';
    $("#term_id option:selected").each(function () {
        var $this = $(this);
        if ($this.length) {
            var selText = $this.text();
            $terms  += '* '+selText + $lb;
        }
            $('#term_desc').val($terms);

});

});

function Save() {
    $('.btnsave').attr('disabled','disabled');
    if($('#form').valid() == true){
        $('#form').submit();
    }
    else{
        $('.btnsave').removeAttr('disabled');
    }
}