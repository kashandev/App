<?php

   // include header //

   include_once('header.php'); // this is used for include header //

    // end of include header // ?>

<!-- title -->

<title>User Mangement</title>

<!-- /.title -->

<!-- body -->

<body class="page-full-width generic-content">

   <?php

      // include top nav //

      include_once('top-nav.php'); // this is used for include top nav //

      // end of include top nav // ?>

   <div class="main-container">

      <div class="container">

         <div class="cms-wrap panel-scroll-  panel-default" style="height: 468px;">

            <div class="panel-body wrapper-panel autoheight" style="height: 468px;">

               <div class="panel panel-default no-bg">

                  <div class="panel-heading top-heading">

                     <h2> User Management  <a class="btn btn-primary pull-right btn-create" href="create-user.php"><i class="fa fa-save"> </i> Create User</a> </h2>

                  </div>

                  <div class="panel-body">

                     <div class="inv-search" style="position: absolute;top: 99px;z-index: 999;left: 260px;width: 63%;">

                        <?php // include variable //

                           include_once("variable/variable.php"); // this is used for include variable //

                           // end of include variable // ?>

                        <?php

                           // include search user //

                           // include_once('search-user.php'); // this is used for include search user //

                           // end of include search user // ?>   

                     </div>

                     <div style="background: #fff;border: 1px solid #ccc; margin-left:-15px; margin-right:-15px;padding:10px;">

                        <div id="content-nav" class="clearfix">

                           <ul id="dirNav">

                              <li data-letter="All" class=" FL_All">

                                 <a href="/backend/web/index.php/customers/customers/#?sort=All">All</a>

                              </li>

                              <li data-letter="A" class=" FL_A">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=A">A</a>

                              </li>

                              <li data-letter="B" class=" FL_B">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=B">B</a>

                              </li>

                              <li data-letter="C" class=" FL_C">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=C">C</a>

                              </li>

                              <li data-letter="D" class=" FL_D">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=D">D</a>

                              </li>

                              <li data-letter="E" class=" FL_E">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=E">E</a>

                              </li>

                              <li data-letter="F" class=" FL_F">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=F">F</a>

                              </li>

                              <li data-letter="G" class=" FL_G">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=G">G</a>

                              </li>

                              <li data-letter="H" class=" FL_H">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=H">H</a>

                              </li>

                              <li data-letter="I" class=" FL_I">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=I">I</a>

                              </li>

                              <li data-letter="J" class=" FL_J">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=J">J</a>

                              </li>

                              <li data-letter="K" class=" FL_K">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=K">K</a>

                              </li>

                              <li data-letter="L" class=" FL_L">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=L">L</a>

                              </li>

                              <li data-letter="M" class=" FL_M">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=M">M</a>

                              </li>

                              <li data-letter="N" class=" FL_N">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=N">N</a>

                              </li>

                              <li data-letter="O" class=" FL_O">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=O">O</a>

                              </li>

                              <li data-letter="P" class=" FL_P">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=P">P</a>

                              </li>

                              <li data-letter="Q" class=" FL_Q">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=Q">Q</a>

                              </li>

                              <li data-letter="R" class=" FL_R">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=R">R</a>

                              </li>

                              <li data-letter="S" class=" FL_S">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=S">S</a>

                              </li>

                              <li data-letter="T" class=" FL_T">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=T">T</a>

                              </li>

                              <li data-letter="U" class=" FL_U">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=U">U</a>

                              </li>

                              <li data-letter="V" class=" FL_V">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=V">V</a>

                              </li>

                              <li data-letter="W" class=" FL_W">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=W">W</a>

                              </li>

                              <li data-letter="X" class=" FL_X">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=X">X</a>

                              </li>

                              <li data-letter="Y" class=" FL_Y">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=Y">Y</a>

                              </li>

                              <li data-letter="Z" class=" FL_Z">

                                 <a class="" href="/backend/web/index.php/customers/customers/#?sort=Z">Z</a>

                              </li>

                           </ul>

                        </div>

                     </div>

                     <br>

                     <div class="row">

                        <div class="col-md-12 ht-sauto-child panel-scrosll bg-white xmasrgin">

                           <div id="w0" class="grid-view">

                              <ul class="nav nav-tabs">

                                 <li class="active">

                                    <a href="#all" data-toggle="tab" data-id="all">All</a>

                                 </li>

                                 <li><a href="#new" data-toggle="tab" data-id="new">New Users</a>

                                 </li>

                                 <li><a href="#deleted" data-toggle="tab" data-id="deleted">Deleted Users</a>

                                 </li>

                              </ul>

                              <div class="tab-content">

                                 <div class="tab-pane active" id="all">

                                    <div class="row">

                                       <div class="col-sm-12">

                                          <div class="view-all"></div>

                                       </div>

                                    </div>

                                 </div>

                                 <div class="tab-pane" id="new">

                                    <div class="row">

                                       <div class="col-sm-12">

                                          <div class="view-new"></div>

                                       </div>

                                    </div>

                                 </div>

                                 <div class="tab-pane" id="deleted">

                                    <div class="row">

                                       <div class="col-sm-12">

                                          <div class="view-deleted"></div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

               <div class="clear"></div>

            </div>

         </div>

      </div>

   </div>

   <?php

      // include footer //

      include_once('footer.php'); // this is used for include footer //

       // end of include footer // ?>

</body>

<!-- /.body -->

<script type="text/javascript">



      // function disable button //

      function disablebutton()

      {

      $('.delete-btn').css('background-color','#dee2e6');

      $('.delete-btn').css('border','1px solid #dee2e6');

      $('.delete-btn').attr('disabled',true);

      $('.restore-btn').css('background-color','#dee2e6');

      $('.restore-btn').css('border','1px solid #dee2e6');

      $('.restore-btn').attr('disabled',true);   

      $('.restore-bl-btn').css('background-color','#dee2e6');

      $('.restore-bl-btn').css('border','1px solid #dee2e6');

      $('.restore-bl-btn').attr('disabled',true); 

      $('.block-btn').css('background-color','#dee2e6'); 

      $('.block-btn').css('border','1px solid #dee2e6');

      $('.block-btn').attr('disabled',true);   

      }

      

      // end of function disable button //

   

      

     // function enable button //

      function enablebutton()

      {

      $('.delete-btn').css('background-color','#089000');

      $('.delete-btn').css('border','1px solid #327b00');

      $('.delete-btn').attr('disabled',false);

      $('.restore-btn').css('background-color','#089000');

      $('.restore-btn').css('border','1px solid #327b00');

      $('.restore-btn').attr('disabled',false); 

      $('.restore-bl-btn').css('background-color','#089000');

      $('.restore-bl-btn').css('border','1px solid #327b00');

      $('.restore-bl-btn').attr('disabled',false); 

      $('.block-btn').css('background-color','#089000');

      $('.block-btn').css('border','1px solid #327b00');

      $('.block-btn').attr('disabled',false); 

      }

      // end of function enable button //





   //function del//

      function del(uid='',aid='',uname='')

      { 

      var uid = uid;

      var aid = aid;

      var uname = uname;

      var msg = msg;

      var type ='';



      $.ajax({

        url:"delete/delete-user.php",

        method:"POST",

        data:{uid : uid, aid : aid, uname : uname},

        dataType:'json',

        beforeSend:function()

        {

         disablebutton();

        },

        success:function(data)

        { 

         msg = data.msg;

         setTimeout(function()

         {

          $('.message-box').show();

          $('.message-box').html(msg);

          $('.message-box').fadeOut(1500);

         },400);

   

         setTimeout(function(){

          $('#DlModal').css('display','none');  

          $('.table').find('#row'+uid).remove();

           type = $(".nav-tabs li.active a").attr("data-id");

          view("","",type);

         },2000);

   

        }

      });

      }

      // end of function del //



   //function block//

      function block(uid='',aid='',uname='')

      { 

      var uid = uid;

      var aid = aid;

      var uname = uname;

      var msg = msg;

      var type ='';

   

      $.ajax({

        url:"block/block-user.php",

        method:"POST",

        data:{uid : uid, aid : aid, uname : uname},

        dataType:'json',

        beforeSend:function()

        {

         disablebutton();

        },

        success:function(data)

        { 

         msg = data.msg;

         setTimeout(function()

         {

          $('.message-box').show();

          $('.message-box').html(msg);

          $('.message-box').fadeOut(1500);

         },400);

   

         setTimeout(function(){

          $('#BlModal').css('display','none');  

          $('.table').find('#row'+uid).remove();

          type = $(".nav-tabs li.active a").attr("data-id");

          view("","",type);

         },2000);

   

        }

      });

      }

      // end of function block //





   //function restore//

      function restore(duid='',aid='',uname='')

      { 

      var duid = duid;

      var aid = aid;

      var uname = uname;

      var msg = msg;

      var type ='';

   

      $.ajax({

        url:"restore/restore-user.php",

        method:"POST",

        data:{duid : duid, aid : aid, uname : uname},

        dataType:'json',

        beforeSend:function()

        {

         disablebutton();

        },

        success:function(data)

        { 

         msg = data.msg;

         setTimeout(function()

         {

          $('.message-box').show();

          $('.message-box').html(msg);

          $('.message-box').fadeOut(1500);

         },400);

   

         setTimeout(function(){

          $('#RsModal').css('display','none');  

          $('.table').find('#row'+duid).remove();

           type = $(".nav-tabs li.active a").attr("data-id");

          view("","",type);

         },2000);

   

        }

      });

      }

      // end of function restore //





   //function restore block//

      function blockrestore(buid='',aid='',uname='')

      { 

      var buid = buid;

      var aid = aid;

      var uname = uname;

      var msg = msg;

      var type ='';

   

      $.ajax({

        url:"restore/restore-block-user.php",

        method:"POST",

        data:{buid : buid, aid : aid, uname : uname},

        dataType:'json',

        beforeSend:function()

        {

         disablebutton();

        },

        success:function(data)

        { 

         msg = data.msg;

         setTimeout(function()

         {

          $('.message-box').show();

          $('.message-box').html(msg);

          $('.message-box').fadeOut(1500);

         },400);

   

         setTimeout(function(){

          $('#RsbModal').css('display','none');  

          $('.table').find('#row'+buid).remove();

          type = $(".nav-tabs li.active a").attr("data-id");

          view("","",type);

         },2000);

   

        }

      });

      }

      // end of function restore block //





   

   //function search//

   function search_user(uid='')

   { 

   var uid = uid;

   var thisurl = '';

   $.ajax({

     url:"add-user.php",

     method:"GET",

     success:function(data)

     {  

       thisurl = "add-user.php?user="+uid;

       window.location.href = thisurl;   

     }

   });

   }

   // end of function search //







   //function view pagination//

   function view(page = "", search = "", type = "") {

     var html = "";

     var search = search;

     var page = page;

     var type = type;

     var view = "";

     $.ajax({

         url: "view/view_users.php",

         method: "POST",

         data: { page: page, search: search, type: type },

         dataType: "html",

         beforeSend: function () {

             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';

             if (type == "all") {

                 $(".view-all").html(html);

             }

             if (type == "new") {

                 $(".view-new").html(html);

             }

             if (type == "top") {

                 $(".view-top").html(html);

             }

             if (type == "block") {

                 $(".view-block").html(html);

             }

             if (type == "deleted") {

                 $(".view-deleted").html(html);

             }

           

         },

         success: function (responseData) {

             html = responseData;

             setTimeout(function () {

                 if (type == "all") {

                     $(".view-all").html(html);

                 }

                 if (type == "new") {

                     $(".view-new").html(html);

                 }

   

           if (type == "top") {

                 $(".view-top").html(html);

             }

             if (type == "block") {

                 $(".view-block").html(html);

             }

             if (type == "deleted") {

                 $(".view-deleted").html(html);

             }       

                

             }, 200);

         },

     });

   }

   //end of function view//

   

   //function view on key enter//

   function viewkeyenter(page = "", search = "", type = "", e = "") {

     var html = "";

     var search = search;

     var page = page;

     var type = type;

     var view = "";

     if (e.which == 13) {

         e.preventDefault();

         $.ajax({

             url: "view/view_users.php",

             method: "POST",

             data: { page: page, search: search, type: type },

             dataType: "html",

             beforeSend: function () {

                 html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';

                 if (type == "all") {

                     $(".view-all").html(html);

                 }

                 if (type == "new") {

                     $(".view-new").html(html);

                 }

               

             },

             success: function (responseData) {

                 html = responseData;

                 setTimeout(function () {

                     if (type == "all") {

                         $(".view-all").html(html);

                     }

                     if (type == "new") {

                         $(".view-new").html(html);

                     }

                     

                 }, 200);

             },

         });

     }

   }

   //end of function view on key enter //

   

   var search = "";

   var page = "";

   var type = "all";

   

   // start jquery //

   $(document).ready(function () {

   

   

     type = $(".nav-tabs li.active a").attr("data-id");

     view(page, search, type);

   

     // search function //

     $(document).keypress(".search", function (e) {

         search = $(".search").val();

         page = $(".btn-page").attr("data-page");

         viewkeyenter(page, search, type, e);

     });

   

     $("body").on("click", ".search-btn", function (e) {

         e.preventDefault();

         page = $(this).attr("data-page");

         search = $(".search").val();

         view(page, search, type);

     });

     // end of search function //

   

     // call view function //

     $("body").on("click", ".btn-page", function (e) {

         e.preventDefault();

         page = $(this).attr("data-page");

         search = $(".search").val();

         view(page, search, type);

     });

   

     $("body").on("click", ".btn-next", function (e) {

         e.preventDefault();

         page = $(this).attr("data-page");

         search = $(".search").val();

         view(page, search, type);

     });

     // end of call view function //

   

     // search function//

   

     $("body").on("keyup", ".search", function () {

         search = $(this).val();

         page = $(".btn-page").attr("data-page");

         if (search == "") {

             view(page, search, type);

         }

     });

   

     // end of search function//

   

     // remove space function from string //

     $(document).on("paste", ".search", function (e) {

         e.preventDefault();

         // prevent copying action

         var withoutSpaces = e.originalEvent.clipboardData.getData("Text");

         withoutSpaces = $.trim(withoutSpaces);

         $(this).val(withoutSpaces);

         // you need to use val() not text()

     });

     // remove space function  from string //

   

     // click function for tabs//

     $("body").on("click", ".nav-tabs li a", function () {

         type = $(this).attr("data-id");

         search = $(".search").val();

         page = $(".btn-page").attr("data-page");

         view(page, search, type);

     });

   

     // end of click function for tabs //





    // check row function //

      $('body').on('click','.uid',function (e) {

         $('.uid:checked').each(function(){

       });

         if($('.uid').is(':checked')){

          $('.btn-delete').attr('disabled',false);

           $('.btn-bl-list').attr('disabled',false);

         }else{

          $('.btn-delete').attr('disabled',true);

          $('.btn-bl-list').attr('disabled',true);

         }   

      });



      $('body').on('click','.duid',function (e) {

         $('.duid:checked').each(function(){

       });

         if($('.duid').is(':checked')){

          $('.btn-restore').attr('disabled',false);

         }else{

          $('.btn-restore').attr('disabled',true);

         }   

      });



      $('body').on('click','.buid',function (e) {

         $('.buid:checked').each(function(){

       });

         if($('.buid').is(':checked')){

          $('.btn-restore-bl').attr('disabled',false);

         }else{

          $('.btn-restore-bl').attr('disabled',true);

         }   

      });



        

      // enable button on check //

      $('body').on('click','.btn-check',function(){

        $(".table tr").each( function() {

         $(this).find('input[type="checkbox"]').prop('checked', true);  

        check = $(this).find('input[type="checkbox"]').val();

        });

        $('.btn-delete').attr('disabled',false);

        $('.btn-bl-list').attr('disabled',false);

      });



        // disable button on uncheck //

       $('body').on('click','.btn-uncheck',function(){

        $(".table tr").each( function() {

        $(this).find('input[type="checkbox"]').prop('checked', false);  

        $(this).find('input[type="checkbox"]').val(0);    

        $('.btn-delete').attr('disabled',true);  

        $('.btn-bl-list').attr('disabled',true);

        });

     });



         $('body').on('click','.btn-check-r',function(){

        $(".table tr").each( function() {

         $(this).find('input[type="checkbox"]').prop('checked', true);  

        check = $(this).find('input[type="checkbox"]').val();

        });

        $('.btn-restore').attr('disabled',false);

      });



         $('body').on('click','.btn-check-r-bl',function(){

        $(".table tr").each( function() {

         $(this).find('input[type="checkbox"]').prop('checked', true);  

        check = $(this).find('input[type="checkbox"]').val();

        });

        $('.btn-restore-bl').attr('disabled',false);

      });





     //    // disable button on uncheck //

       $('body').on('click','.btn-uncheck-r',function(){

        $(".table tr").each( function() {

        $(this).find('input[type="checkbox"]').prop('checked', false);  

        $(this).find('input[type="checkbox"]').val(0);    

        });

        $('.btn-restore').attr('disabled',true);  



      });



       $('body').on('click','.btn-uncheck-r-bl',function(){

        $(".table tr").each( function() {

        $(this).find('input[type="checkbox"]').prop('checked', false);  

        $(this).find('input[type="checkbox"]').val(0);    

        });

        $('.btn-restore-bl').attr('disabled',true);  

      });  

        // show modal function //

                    var uid = ''; 

                    var thismtxt = '';

                   $('body').on('click','.btn-delete',function(){

                     thismtxt ='<h3><strong class="mttxt"> Delete User <strong></strong></h3>';

                     $('#DlModal').css('display','block');

                     $('#DlModal').find('.modal-title').html(thismtxt);

                     enablebutton();

                   });



                    $('body').on('click','.btn-restore',function(){

                     uid = $(this).attr('id'); 

                     thismtxt ='<h3><strong class="mttxt"> Restore User <strong></strong></h3>';

                     $('#RsModal').css('display','block');

                     $('#RsModal').find('.modal-title').html(thismtxt);

                     enablebutton();

                   });   



                     $('body').on('click','.btn-restore-bl',function(){

                     thismtxt ='<h3><strong class="mttxt"> Restore Block User <strong></strong></h3>';

                     $('#RsbModal').css('display','block');

                     $('#RsbModal').find('.modal-title').html(thismtxt);

                     enablebutton();

                   });   



                    $('body').on('click','.btn-bl-list',function(){

                     thismtxt ='<h3><strong class="mttxt"> Block User <strong></strong></h3>';

                     $('#BlModal').css('display','block');

                     $('#BlModal').find('.modal-title').html(thismtxt);

                     enablebutton();

                   });                     

   



             // end of show modal function //

   

               // hide modal function //

                   $('body').on('click','.btn-close',function(){

                     $('#DlModal').css('display','none');

                     $('#DlModal').css('display','none');

                     $('#RsModal').css('display','none');

                     $('#RsModal').css('display','none');  

                     $('#RsbModal').css('display','none');

                     $('#RsbModal').css('display','none');  

                     $('#BlModal').css('display','none');

                     $('#BlModal').css('display','none');  

                   });

            // end of hide modal function //   

   





                // call del function //

                  var aid = '';

                  var uname = '';

                  $('body').on('click','.delete-btn',function(){

                    var uid = [];

                    $('.uid:checked').each(function(){

                     uid.push($(this).val()); 

                     aid = $('.uid').val();

                     uname = $('.uname').val();

                   });

                    if(uid.length != 0){

                      del(uid,aid,uname)

                    }

                   });

                   // end of call del function //

                



                // call restore function //

                  var aid = '';

                  var uname = '';

                  $('body').on('click','.restore-btn',function(){

                    var duid = [];

                    $('.duid:checked').each(function(){

                     duid.push($(this).val()); 

                     aid = $('.uid').val();

                     uname = $('.uname').val();

                   });

                    if(duid.length != 0){

                      restore(duid,aid,uname)

                    }

                   });

                   // end of call restore function //





                 // call block restore function //

                  var bid = '';

                  var uname = '';

                  $('body').on('click','.restore-bl-btn',function(){

                    var buid = [];

                    $('.buid:checked').each(function(){

                     buid.push($(this).val()); 

                     aid = $('.uid').val();

                     uname = $('.uname').val();

                   });

                    if(buid.length != 0){

                      blockrestore(buid,aid,uname)

                    }

                   });

                   // end of call block restore function //





                // call block function //

                  var aid = '';

                  var uname = '';

                  $('body').on('click','.block-btn',function(){

                    var uid = [];

                    $('.uid:checked').each(function(){

                     uid.push($(this).val()); 

                     aid = $('.uid').val();

                     uname = $('.uname').val();

                   });

                    if(uid.length != 0){

                      block(uid,aid,uname)

                    }

                   });

                   // end of call block function //

                // call search function //



                  $('body').on('click','.btn-search',function(){

                    var uid = '';

                     uid = $(this).attr('data-id'); 

                    if(uid.length != 0){

                      search_user(uid)

                    }

                   });

                   // end of call search function //          

   });

   // end of jquery //

</script>