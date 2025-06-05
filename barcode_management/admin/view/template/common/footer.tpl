<form enctype="multipart/form-data" id="form-upload" style="display: none;">
    <input id="image_file" type="file" name="image" value="" />
    <input id="image_width" type="text" name="width" value="300" />
    <input id="image_height" type="text" name="height" value="300" />
</form>
<script type="text/javascript"><!--
    var $image_form_data;
    var $URLUploadImage = '<?php echo $href_upload_image; ?>';
    $('.img-thumbnail').on('click', function() {
        $id = $(this).attr('id');
        $image_src = $(this).attr('data-src_image');
        $input_src = $(this).attr('data-src_input');
        $image_width = $(this).attr('data-width');
        $image_height = $(this).attr('data-height');
        console.log($image_src, $input_src, $image_width, $image_height);
        if($image_width != '') {
            $('#form-upload #image_width').val($image_width);
        }
        if($image_height != '') {
            $('#form-upload #image_height').val($image_height);
        }
        //$('#form-upload').remove();

        $('#form-upload #image_file').trigger('click');

        $('#form-upload #image_file').on('change', function() {
            $image_form_data = null;
            $image_form_data = new FormData($('#form-upload #image_file').parent()[0]);
            $.ajax({
                url: $URLUploadImage,
                type: 'post',
                dataType: 'json',
                data: $image_form_data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    jQuery('.wait').remove();
                    $('#'+$id).after('<span class="wait">&nbsp;<img src="dist/img/loading.gif" alt="" /></span>');
                },
                complete: function() {
                    jQuery('.wait').remove();
                },
                success: function(json) {
                    if (json['error']) {
                        alert(json['error']);
                    }

                    if (json['success']) {
                        $('#'+$image_src).attr('src',json['image_thumb']);
                        $('#'+$input_src).val(json['image']);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
//--></script>
<div style="display: none;" class="modal fade" id="_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('input,textarea').attr('autocomplete','off');
        $('.btnAddGrid, #btnAddGrid, #addRefDocument').click(function(){
            setTimeout(function(){
                $('table tr td input').attr('autocomplete','off');
                $('table tr td').find('input, select, textarea').each(function(){
                  $(this).parents('td').find('label.error').remove();
                  $(this).parents('td').append('<label for="'+ $(this).attr('id') +'" class="error" style="display:none"></label>')  
                });
            },1);
        });

        $('body').find('.form-group').each(function(){
            setTimeout(function(){
                $(this).find('label.error').remove();
                $parent = $(this);
                $(this).find('input, select, textarea').each(function(){
                    $parent.append('<label for="'+ $(this).find('input, select, textarea').attr('id') +'" class="error" style="display:none"></label>');
                });
            },1000);
        });
    });
</script>