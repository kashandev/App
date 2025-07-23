/**
 * Created by Huzaifa on 9/18/15.
 */

 function getProductById($obj) {
    $product_id = $($obj).val();

    $.ajax({
        url: $UrlGetProductById,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id,
        mimeType:"multipart/form-data",
      
        success: function(json) {
            if(json.success)
            {
               $('#model').val(json.product['model']);
               $('#product_serial_no').val(json.product['serial_no']);
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


 function getserviceCharges($obj) {
    var $product_id = $($obj).val();
    if($product_id == ''){
      $('#service_charges').val('');
    }
    else
    {
    $.ajax({
        url: $UrlGetServiceCharges,
        dataType: 'json',
        type: 'post',
        data: 'product_id=' + $product_id,
        mimeType: "multipart/form-data",
      
        success: function(json) {
           $('#service_charges').val(json.service_charges);
        }
     });
 }
}

function Save() {

    $('.btnsave').attr('disabled','disabled');
    if($('#form').valid() == true){
        $('#form').submit();
    }
    else{
        $('.btnsave').removeAttr('disabled');
    }
}

