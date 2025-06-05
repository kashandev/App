/**
 * Created by Huzaifa on 12/03/2018.
 */
$(document).on('change', '#module', function() {
    var $module = $('#module').val();
    $.ajax({
        url: $UrlGetDocuments,
        dataType: 'json',
        type: 'post',
        data: 'module=' + $module,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#document').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#document').html(json.html).trigger('change');
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })
})

$(document).on('change', '#document', function() {
    var $document = $('#document').val();
    var $module = $('#module').val();
    $.ajax({
        url: $UrlGetVariables,
        dataType: 'json',
        type: 'post',
        data: 'document=' + $document + '&module=' + $module,
        mimeType:"multipart/form-data",
        beforeSend: function() {
            $('#tblVariable').before('<i id="loader" class="fa fa-refresh fa-spin"></i>');
        },
        complete: function() {
            $('#loader').remove();
        },
        success: function(json) {
            if(json.success)
            {
                $('#tblVariable tbody').html(json.html);
            }
            else {
                alert(json.error);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.responseText);
        }
    })

})