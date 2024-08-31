   // upload function //
   
   $(".uploadform").on('change',function(e) {
   
   
   var img = '';
   var property = document.getElementById("companyimage").files[0];
   
   var image_name = property.name;
   
   var image_extension = image_name.split('.').pop().toLowerCase();
   
   if(jQuery.inArray(image_extension,['gif','jpg','png','jpeg'])== -1){
   
   $(".image-error").html("Only Images Are Allowed"); 
   
   $('.img-view').html("");
   
   $('.img-view-txt').html("");
   
   $(".company-logo-name").val("");
   
   $(".company-logo-guid").val("");
   }
   
   else{
   
   var ajaxData = new FormData(this);
   
   e.preventDefault();
   
   var thisurl = $("form").attr("action");
   
   var thismethod = $("form").attr("method");
   
   var url = thisurl.replace(thisurl,"../upload/upload-company-logo.php");
   
   var method = thismethod.replace(thismethod,"post");
   
    $.ajax({
   
     url:url,
   
     type:method,
   
     data:ajaxData,
   
     dataType:"json",
   
     contentType: false,
   
     cache: false,
   
     processData:false,
   
     success: function(abc)
   
     {
     var image_name = abc.image_name;
     var image_guid = abc.image_guid;
     img = '<div class="row"><div class="col-sm-2 col-md-3 col-xs-3"> <img src="../images/'+image_guid+'" class="img-responsive"><div class="cross-icon"></div></div></div>';
   
      $('.img-view').html(img);
   
      $(".image-error").html("")
   
      $('.img-view-txt').html("")
   
      $(".image-input-error").html("")
   
      $(".company-logo-name").val(image_name);
   
      $(".company-logo-guid").val(image_guid);
   
     }
   
     });
   
   }
   
   });
   
   // end of upload function //