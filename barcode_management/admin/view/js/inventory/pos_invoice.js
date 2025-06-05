$("#slider_product_category").lightSlider({
    item:6,
    loop:false,
    keyPress:true
});
$(document).ready(function() {
    $('#product_id').select2({
        width: '100%',
        ajax: {
            url: $UrlGetProductsJSON,
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

    jQuery("#product_id").on("select2:select", function (evt) {
        var $data = evt.params.data;
        var $product_id = $data['product_id'];
        var $product_code = $data['product_code'];
        var $product_name = $data['name'];
        var $unit_id = $data['unit_id'];
        var $rate = $data['sale_price'];
        var $amount = $rate;

        $objTr = $('#tblCart tbody').find('tr[data-product_id="'+$product_id+'"]');
        if($objTr.length) {
            var $id = $($objTr).data('id');
            var $qty = (parseFloat($('#pos_invoice_detail_'+$id+'_qty').val())+1).toFixed(0);
            var $amount = ($qty*$rate).toFixed(2);

            $('#pos_invoice_detail_'+$id+'_qty').val($qty);
            $('#pos_invoice_detail_'+$id+'_amount').val($amount);
            $('#lblAmount'+$id).html($amount);
        } else {
            $html='<tr data-id="'+$row_no+'" data-product_id="'+$product_id+'">';
            $html+='<td>';
            $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_product_id" name="pos_invoice_details['+$row_no+'][product_id]" value="'+$product_id+'" />';
            $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_product_code" name="pos_invoice_details['+$row_no+'][product_code]" value="'+$product_code+'" />';
            $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_unit_id" name="pos_invoice_details['+$row_no+'][unit_id]" value="'+$unit_id+'" />';
            $html+=$product_name;
            $html+='</td>';
            $html+='<td>';
            $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_rate" name="pos_invoice_details['+$row_no+'][rate]" value="'+$rate+'" />';
            $html+=$rate;
            $html+='</td>';
            $html+='<td>';
            $html+='<div class="input-group input-group-sm">';
            $html+='<span class="input-group-btn">';
            $html+='<button class="btn btn-info btn-flat" type="button" onclick="subtractQuantity('+$row_no+');">-</button>';
            $html+='</span>';
            $html+='<input onchange="calculateAmount('+$row_no+');" class="form-control fPInteger text-right" style="min-width: 50px;" type="text" id="pos_invoice_detail_'+$row_no+'_qty" name="pos_invoice_details['+$row_no+'][qty]" value="1">';
            $html+='<span class="input-group-btn">';
            $html+='<button class="btn btn-info btn-flat" type="button" onclick="addQuantity('+$row_no+');">+</button>';
            $html+='</span>';
            $html+='</div>';
            $html+='</td>';
            $html+='<td class="text-right">';
            $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_amount" name="pos_invoice_details['+$row_no+'][amount]" value="'+$amount+'" />';
            $html+='<label id="lblAmount'+$row_no+'">'+$amount+'</label>';
            $html+='</td>';
            $html+='</tr>'

            $('#tblCart tbody').prepend($html);
            //setFieldFormat();

            $row_no++;
        }

        calculateTotal();

    });
});

function getProducts($product_category_id) {
    $.ajax({
        url: $UrlGetProducts,
        dataType: 'json',
        type: 'post',
        data: 'product_category_id='+$product_category_id,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $("#tblProducts").html('');
            $("#fadeLoader").show();
        },
        complete: function() {
            $("#fadeLoader").hide();
        },
        success: function(json) {
            console.log(json);
            $('#divProducts').html(json.html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
}

function addProduct($obj) {
    var $product_id = $($obj).data('product_id');
    var $product_code = $($obj).data('product_code');
    var $product_name = $($obj).data('name');
    var $unit_id = $($obj).data('unit_id');
    var $rate = $($obj).data('rate');
    var $amount = $rate;

    $objTr = $('#tblCart tbody').find('tr[data-product_id="'+$product_id+'"]');
    if($objTr.length) {
        var $id = $($objTr).data('id');
        var $qty = (parseFloat($('#pos_invoice_detail_'+$id+'_qty').val())+1).toFixed(0);
        var $amount = ($qty*$rate).toFixed(2);


        $('#pos_invoice_detail_'+$id+'_qty').val($qty);
        $('#pos_invoice_detail_'+$id+'_amount').val($amount);
        $('#lblAmount'+$id).html($amount);
    } else {
        $html='<tr data-id="'+$row_no+'" data-product_id="'+$product_id+'">';
        $html+='<td>';
        $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_product_id" name="pos_invoice_details['+$row_no+'][product_id]" value="'+$product_id+'" />';
        $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_product_code" name="pos_invoice_details['+$row_no+'][product_code]" value="'+$product_code+'" />';
        $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_unit_id" name="pos_invoice_details['+$row_no+'][unit_id]" value="'+$unit_id+'" />';
        $html+=$product_name;
        $html+='</td>';
        $html+='<td>';
        $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_rate" name="pos_invoice_details['+$row_no+'][rate]" value="'+$rate+'" />';
        $html+=$rate;
        $html+='</td>';
        $html+='<td>';
        $html+='<div class="input-group input-group-sm">';
        $html+='<span class="input-group-btn">';
        $html+='<button class="btn btn-info btn-flat" type="button" onclick="subtractQuantity('+$row_no+');">-</button>';
        $html+='</span>';
        $html+='<input onchange="calculateAmount('+$row_no+');" class="form-control fPInteger text-right" style="min-width: 50px;" type="text" id="pos_invoice_detail_'+$row_no+'_qty" name="pos_invoice_details['+$row_no+'][qty]" value="1">';
        $html+='<span class="input-group-btn">';
        $html+='<button class="btn btn-info btn-flat" type="button" onclick="addQuantity('+$row_no+');">+</button>';
        $html+='</span>';
        $html+='</div>';
        $html+='</td>';
        $html+='<td class="text-right">';
        $html+='<input type="hidden" id="pos_invoice_detail_'+$row_no+'_amount" name="pos_invoice_details['+$row_no+'][amount]" value="'+$amount+'" />';
        $html+='<label id="lblAmount'+$row_no+'">'+$amount+'</label>';
        $html+='</td>';
        $html+='</tr>'

        $('#tblCart tbody').prepend($html);
        setFieldFormat();

        $row_no++;
    }

    calculateTotal();
}


function calculateTotal() {
    var $total_amount = 0.00;
    $('#tblCart tbody tr').each(function() {
        var $id = $(this).data('id');
        var $amount = $('#pos_invoice_detail_'+$id+'_amount').val();
        $total_amount = parseFloat($total_amount) + parseFloat($amount);
    });
    $('#lblTotalAmount').html(parseFloat($total_amount).toFixed(2));
}

function subtractQuantity($row_id) {
    var $rate = $('#pos_invoice_detail_'+$row_id+'_rate').val();
    var $qty = $('#pos_invoice_detail_'+$row_id+'_qty').val();
    if($qty!=0) {
        $qty = parseFloat($qty)-1;
    }

    var $amount = parseFloat($qty) * parseFloat($rate);

    $('#pos_invoice_detail_'+$row_id+'_qty').val($qty);
    $('#pos_invoice_detail_'+$row_id+'_amount').val($amount);
    $('#lblAmount'+$row_id).html($amount);

    calculateTotal();
}

function addQuantity($row_id) {
    var $rate = $('#pos_invoice_detail_'+$row_id+'_rate').val();
    var $qty = $('#pos_invoice_detail_'+$row_id+'_qty').val();
    $qty = parseFloat($qty)+1;

    var $amount = parseFloat($qty) * parseFloat($rate);

    $('#pos_invoice_detail_'+$row_id+'_qty').val($qty);
    $('#pos_invoice_detail_'+$row_id+'_amount').val($amount);
    $('#lblAmount'+$row_id).html($amount);

    calculateTotal();
}

function calculateAmount($row_id) {
    var $rate = $('#pos_invoice_detail_'+$row_id+'_rate').val();
    var $qty = $('#pos_invoice_detail_'+$row_id+'_qty').val();
    $qty = parseFloat($qty);

    var $amount = parseFloat($qty) * parseFloat($rate);

    $('#pos_invoice_detail_'+$row_id+'_qty').val($qty);
    $('#pos_invoice_detail_'+$row_id+'_amount').val($amount);
    $('#lblAmount'+$row_id).html($amount);

    calculateTotal();

}