<?php

   // include header //

   include_once('header.php'); // this is used for include header //

   // end of include header //

   ?>

<!-- title -->

<title>Create User</title>

<!-- /.title -->

<?php

   // include form style //

   include_once('style/form-style.php'); // this is used for include form style //

    // end of include form style // ?>

<!-- /.title -->

<!-- body -->

<body class="page-full-width generic-content">

   <?php

      // include top nav //

      include_once('top-nav.php'); // this is used for include top nav //

      // end of include top nav // ?>

   <div class="main-container">

      <div class="container">

         <div class="cms-wrap panel-scroll-  panel-default" style="height: 458px;">

            <div class="panel-body wrapper-panel autoheight" style="height: 458px;">

               <!-- start: DYNAMIC TABLE PANEL -->

               <div class="panel panel-default">

                  <div class="panel-heading top-heading">

                     <h2> Create User </h2>

                     <?php

                        // include message //

                       include_once('message/message.php'); // this is used for include message //

                        // end of include message // ?>      

                  </div>

                  <div class="panel-body">

                     <div class="top-content">

                        <div class="row">

                        </div>

                     </div>

                     <div id="w0" class="grid-view">

                        <form id="w0" class="form-horizontal form" method="post" role="form">

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Role</label>

                              <div class="col-sm-4">

                                 <select id="store_id" class="form-control storeid" name="stid">

                                    <option value="">---Select Role---</option>

                                    <option value="2" data-name="Admin" selected="">Administrator</option>

                                    <option value="3" data-name="User">User</option>

                                 </select>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">User Name</label>

                              <div class="col-sm-4">

                                 <input type="hidden" id="uid" class="form-control uid" name="uid" value="">

                                 <input type="text" id="tblcntseller-name" class="form-control uname" name="uname" maxlength="100" value="" placeholder="User Name">

                                 <label class="invalid-div">

                                    <div class="error-u-name">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Email</label>

                              <div class="col-sm-4">

                                 <input type="text" id="tblcntseller-name" class="form-control email" name="email" maxlength="100" value="" placeholder="Email">

                                 <label class="invalid-div">

                                    <div class="error-email">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Password </label>

                              <div class="col-sm-4">

                                 <input type="password" id="tblcntseller-name" class="form-control pass" name="pass" maxlength="100" value="" placeholder="Password">

                                 <label class="invalid-div">

                                    <div class="error-pass">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Confirm Password </label>

                              <div class="col-sm-4">

                                 <input type="password" id="tblcntseller-name" class="form-control cpass" name="cpass" maxlength="100" value="" placeholder="Confirm Password">

                                 <label class="invalid-div">

                                    <div class="error-cpass">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Mobile No</label>

                              <div class="col-sm-4">

                                 <input type="text" id="tblcntseller-name" class="form-control  mobile" name="mobile" maxlength="15" value="" placeholder="Mobile No">

                                 <label class="invalid-div">

                                    <div class="error-mobile">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Country</label>

                              <div class="col-sm-4">

                                 <select id="country" class="form-control country" name="country">

                                    <option value="">---Select Country---</option>

                                    <option value="pakistan" data-name="pakistan" selected="">Pakistan</option>

                                 </select>

                                 <label class="invalid-div">

                                    <div class="error-country">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="col-sm-1"></div>

                           <div class="form-group field-tblcntseller-name required">                                            

                              <button type="button" class="btn btn-primary btn-create"><i class="fa fa-save"></i> Create</button>

                              <button class="btn btn-default btn-squared btn-cancel"> <i class="fa fa-close"></i> Cancel</button>

                               

                               <button type="button" class="btn btn-primary" onclick=window.location.href="user-management.php"><i class="fa fa-arrow-left"></i> Back </button>

                           </div>

                        </form>

                     </div>

                  </div>

               </div>

               <!-- end: DYNAMIC TABLE PANEL -->

               <div class="clear"></div>

            </div>

         </div>

      </div>

   </div>

</body>

<!-- /.body -->

<?php

   // include footer //

   include_once('footer.php'); // this is used for include footer //

    // end of include footer // ?>  

<script type="text/javascript">

   // function disable button //

   function disablebutton()

   {

   $('.btn-save').css('background-color','#dee2e6');

   $('.btn-save').css('border','1px solid #dee2e6');

   $('.btn-save').attr('disabled',true);

   }

   

   // end of function disable button //

   

   // function disable update button //

   function disableupdatebutton()

   {

   $('.btn-update').css('background-color','#dee2e6');

   $('.btn-update').css('border','1px solid #dee2e6');

   $('.btn-update').attr('disabled',true);

   }

   

   // end of function disable update button //

   

     // function disable delete button //

   function disabledeletebutton()

   {

   $('.delete-btn').css('background-color','#dee2e6');

   $('.delete-btn').css('border','1px solid #dee2e6');

   $('.delete-btn').attr('disabled',true);

   }

   

   // end of function disable delete button //

   

   

     // function disable black list button //

   function disableblacklistbutton()

   {

   $('.blacklist-btn').css('background-color','#dee2e6');

   $('.blacklist-btn').css('border','1px solid #dee2e6');

   $('.blacklist-btn').attr('disabled',true);

   }

   

   // end of function disable black list button //

   

   // function enable button //

   function enablebutton()

   {

   $('.btn-save').css('background-color','#089000');

   $('.btn-save').css('border','1px solid #089000');

   $('.btn-save').attr('disabled',false);

   

   }

   // end of function enable button //

   

   

   // function enable update button //

   function enableupdatebutton()

   {

   $('.btn-update').css('background-color','#089000');

   $('.btn-update').css('border','1px solid #089000');

   $('.btn-update').attr('disabled',false);

   

   }

   // end of function enable update button //

   

   

   // function enable delete button //

   function enabledeletebutton()

   {

   $('.delete-btn').css('background-color','#dd4b39');

   $('.delete-btn').css('border','1px solid #d73925');

   $('.delete-btn').attr('disabled',false);

   

   }

   // end of function enable delete button //

   

   

   

   // function enable black list button //

   function enableblacklistbutton()

   {

   $('.blacklist-btn').css('background-color','#dd4b39');

   $('.blacklist-btn').css('border','1px solid #d73925');

   $('.blacklist-btn').attr('disabled',false);

   $('.btn-add').show(); 

   

   }

   // end of function enable black list button //

   

   // function enable button //

   function enablebutton()

   {

   $('.btn-save').css('background-color','#089000');

   $('.btn-save').css('border','1px solid #089000');

   $('.btn-save').attr('disabled',false);

   

   }

   // end of function enable button //

   

   

   // reset form function //

   

   function resetform()

   {

     $('form').trigger("reset");

     $('.fileupload-preview').html("");

     $(".br-img").val("");

     $(".br-img-url").val("");

     $('.fileupload-new .fileupload-exists').hide();

     $('.fileupload .fileupload-new').show();

   }

   // end of reset form function //

   

//   //function delete//

//   function del(bid='')

//   { 

//   var bid = bid;

//   var msg = msg;

//   $.ajax({

//      url:"",

//      method:"POST",

//      data:{bid : bid},

//      dataType:'json',

//      beforeSend:function()

//      {

//       //disabledeletebutton();

//      },

//      success:function(data)

//      {  

//       console.log(data)

//       // msg = data.msg;

//       // setTimeout(function()

//       // {

//       //  $('.message-box').show();

//       //  $('.message-box').html(msg);

//       //  $('.message-box').fadeOut(6000);

//       //  enabledeletebutton();

//       // },600);

   

//       // setTimeout(function(){

//       //  $('#DlModal').css('display','none');  

//       //  $('.btn-update').hide();  

//       //  window.location.href = '';

//       // },6600);

   

//      }

//   });

//   }

//   // end of function delete //

   

   

//   //function black list//

//   function blacklist(vid='')

//   { 

//   var vid = vid;

//   var msg = msg;

//   $.ajax({

//      url:"",

//      method:"POST",

//      data:{vid : vid},

//      dataType:'json',

//      beforeSend:function()

//      {

//       disableblacklistbutton();

//      },

//      success:function(data)

//      {  

//       msg = data.msg;

//       setTimeout(function()

//       {

//       $('.message-box').show();

//       $('.message-box').html(msg);

//       $('.message-box').fadeOut(6000);

//       enableblacklistbutton();

//       },600);

   

//       setTimeout(function(){

//       $('#BlModal').css('display','none'); 

//       $('.btn-update').hide();  

//       window.location.href = '';

//       },6600);

   

//      }

//   });

//   }

//   // end of function black list //

   

   

//   //function save//

//   function save(data='')

//   { 

//   var data = data;

//   var msg = '';

//   $.ajax({

//      url:"",

//      method:"POST",

//      data:data,

//      dataType:'json',

//      beforeSend:function()

//      {

//       disablebutton();

//       // $('.alert-info').show();

//       // $('.alert-info').html('Creating....');

//      },

//      success:function(data)

//      {

//       msg = data.msg;

//       setTimeout(function()

//       {

//       enablebutton();  

//       // $('.alert-info').hide();

//       $('.alert-success').show();

//       $('.alert-success').html(msg);

//       $('.alert-success').fadeOut(6000); 

//       },600);

   

//       setTimeout(function()

//       {

//       var body = $("html, body");

//          body.stop().animate({scrollTop:0}, 500, 'swing', function() { 

//         });

//         resetform();

//       },800);   

//      }

//   });

//   }

   

//   // end of function save //

   

   

//   //function update//

//   function update(data='')

//   { 

//   var data = data;

//   var msg = '';

//   var thisurl = '';

//     thisurl = '';

//     $.ajax({

//      url:thisurl,

//      method:"POST",

//      data:data,

//      dataType:'json',

//      beforeSend:function()

//      {

//       disableupdatebutton();

//       // $('.alert-info').show();

//       // $('.alert-info').html('Updating....');

//      },

//      success:function(data)

//      {

     

//       msg = data.msg;

//       setTimeout(function()

//       {

//       enableupdatebutton();  

//       // $('.alert-info').hide();

//       $('.alert-success').show();

//       $('.alert-success').html(msg);

//       $('.alert-success').fadeOut(6000); 

//       },600);

   

//       setTimeout(function()

//       {

//       var body = $("html, body");

//          body.stop().animate({scrollTop:0}, 500, 'swing', function() { 

//         });

//       },800);   

//      }

//   });

//   }

//   // end of function update //

   

   

   // start jquery //

   $(document).ready(function(){

    disablebutton();

    var _URL = window.URL || window.webkitURL;

   var thisimage = '';  

    $('#file').change(function () {

    var file = $(this)[0].files[0];

   var name = document.getElementById("file").files[0].name;

   var form_data = new FormData();

   var ext = name.split('.').pop().toLowerCase();

           img = new Image();

           var imgwidth = 0;

           var imgheight = 0;

           var maxwidth = 640;

           var maxheight = 640;

   

   if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 

   {

   $('.fileupload-preview').html("<label class='text-danger'><strong> Invalid Image File...</strong></label>");

   }

   var oFReader = new FileReader();

   oFReader.readAsDataURL(document.getElementById("file").files[0]);

   var f = document.getElementById("file").files[0];

   var fsize = f.size||f.fileSize;

   if(fsize > 2000000)

   {

   $('.fileupload-preview').html("<label class='text-danger'><strong>Image File Size is very big ...</strong></label>");

   }

           img.src = _URL.createObjectURL(file);

           img.onload = function() {

                  imgwidth = this.width;

                  imgheight = this.height;

   

        if(imgwidth <= maxwidth && imgheight <= maxheight){

   

         var formData = new FormData();

         formData.append('file', $('#file')[0].files[0]);

   var url = "";

   var method = "POST";  

                       $.ajax({

                             url: url,

                             type: method,

                             data: formData,

                             processData: false,

                             contentType: false,

                             dataType: 'json',

                             beforeSend:function(){

                             $('.fileupload-preview').html("<label class='text-success'><strong>uploading...</strong></label>");

                            },

                             success: function (data) {

                               var imageurl = data.imageurl;

   var image = data.image;

   if(image == '')

   {

   $('.fileupload-preview').html("<label class='text-danger'><strong>This image already exists</strong></label>");

   $(".br-img").val("");

   $(".br-img-url").val("");

   $('.fileupload-new .fileupload-exists').hide();

   $('.fileupload .fileupload-new').show();

   }else

   {

   $('.fileupload-preview').show();

   thisimage = '<?=base_url()?>public/images/brand/'+image;   

   $('.fileupload-preview').html("<label class='text-success'><strong><img src='"+thisimage+"' style='width:50px;height:50px;'></strong></label>");

    $(".br-img").val(image);

    $(".br-img-url").val(imageurl);

   $('.fileupload-new .fileupload-exists').show();

   $('.fileupload .fileupload-new').hide();

   }

                             }

                        });

                  }else{

          $('.fileupload-preview').html("<label class='text-danger'><strong style='width:50px;height:50px;'>Image size must be "+maxwidth+" X "+maxheight+"</strong></label>");

   

                  }

           };

           

   

     });

   

   

                // call save function //

                $('body').on('click','.btn-save',function(){

                  var data = $('form').serialize();

                  var bname = $('.bname').val();

                  var body = $("html, body");

                  body.stop().animate({scrollTop:0}, 500, 'swing', function() { 

                 }); 

   

                  if(bname == '')

                  {

                   $('.error-b-name').html("brand name can't be empty")

   

                  }                    

                  else

                  { 

                  if(bname == '')

                  {

                   $('.error-b-name').html("brand name can't be empty")

   

                  }else{

                   save(data); 

                  }

                  }

                });

                // end of call save function //

   

               // call update function //

                $('body').on('click','.btn-update',function(){

                  var data = $('form').serialize();

                   var bname = $('.bname').val();

                  var body = $("html, body");

                  body.stop().animate({scrollTop:0}, 500, 'swing', function() { 

                 }); 

   

                  if(bname == '')

                  {

                   $('.error-b-name').html("brand name can't be empty")

   

                  }                    

                  else

                  { 

                  if(bname == '')

                  {

                   $('.error-b-name').html("brand name can't be empty")

   

                  }else{

                    update(data); 

                  }

                  }

                });

                // end of call update function //

   

   

             

   // show modal function //

                    var bid = ''; 

                    var thismtxt = '';

                   $('body').on('click','.btn-delete',function(){

                     bid = $(this).attr('id'); 

                     thismtxt ='<strong class="mttxt">Delete Brand<strong></strong>';

                     $('.delete-btn').attr('id',bid);

                     $('#DlModal').css('display','block');

                     $('#DlModal').find('.modal-title').html(thismtxt);

                   });

   

                     $('body').on('click','.btn-restore',function(){

                     bid = $(this).attr('id');

                      thismtxt ='<strong class="mttxt">Restore Brand<strong></strong>'; 

                     $('.restore-btn').attr('id',bid);

                     $('#RsModal').css('display','block');

                     $('#RsModal').find('.modal-title').html(thismtxt);

                   });

             // // end of show modal function //

   

               // hide modal function //

                   $('body').on('click','.btn-close',function(){

                     $('#DlModal').css('display','none');

                     $('#RsModal').css('display','none');

                   });

             // end of hide modal function //   

   

   

            // hide modal function //

                $('body').on('click','.btn-close',function(){

                  $('#DlModal').css('display','none');

                  $('#BlModal').css('display','none');

                });

          // end of hide modal function //   

   

   

              // call delete function //

                var bid = '';

                $('body').on('click','.delete-btn',function(){

                  bid = $(this).attr('id');

                  del(bid);

                });

                // end of call delete function //

             

   

                // reset feild function //

                 $('body').on('keyup','.bname',function(){

                  var bname = $('.bname').val();

                  if(bname == '')

                  {

                   $('.error-b-name').html("");

                   disablebutton();

                  }else

                  {

                  $('.error-b-name').html("");

                  enablebutton();   

   

                  }

                 });

   

                 

                // end of reset feild function //

   

               // remove function //

                $('body').on('click','.close',function(){

                  $('.fileupload-preview').html("");

                  $(".br-img").val("");

                  $(".br-img-url").val("");

                  $('.fileupload-new .fileupload-exists').hide();

                  $('.fileupload .fileupload-new').show();

                

                });

                // end of remove function //

   

              // call add contact person function //

             var index = 0; 

             index = parseInt($('table tr:last').find('.index').val())

              $('body').on('click','.btn-add',function(){

               if(isNaN(index)){

                 index = 1;

               }else{

                index = parseInt(index)+1;

               }

               add_contact_person(index);

               $('.empty').remove();

              });

              // end of add contact person function //

   

   

              // remove contact person function //

              var index = parseInt($('table tr:last').find('.index').val())

              $('body').on('click','.btn-remove',function(){

               var id = $(this).attr('id'); 

               var copid = $(this).attr('data-id'); 

               remove(copid,id,index)

              });

              // end of remove contact person function //

   

   

             // execute select function // 

             $('select').select2();

             // end of execute select function // 

       });

             // end of jquery //

   

</script>