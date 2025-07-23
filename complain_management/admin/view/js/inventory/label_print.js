$(function(){
	$('#product_id').change(function(){

		$.ajax({
			url:$urlgetProductInfo,
			method:'post',
			data: {
				'product_id': $(this).val(),
			},
			dataType:'json',
			cache:false,
			beforeSend:function(){
				$('#sale_price').val('Loading...');
			},
			complete:function(){},
			success:function(json){

				$('#sale_price').val(json.product['sale_price']);
				$('#percent').val(18);

				$sale_price = parseFloat($('#sale_price').val());
				$percent = parseFloat($('#percent').val());
				$total = ((($sale_price*$percent)/100)+$sale_price);

				$('#total_price').val(Math.round($total));
			},
			error:function(){},
		})
	});
	$('#percent').change(function(){
		$sale_price = parseFloat($('#sale_price').val());
		$percent = $(this).val();
		$total = ((($sale_price*$percent)/100)+$sale_price);
		$('#total_price').val(Math.round($total));
	});
});