<?php
// include header //
include_once('header.php'); // this is used for include header //
// end of include header //
?>

<!-- title -->
<title>Wallet</title>
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
                    <h2> Wallet <a class="btn btn-primary pull-right btn-create" href="add-wallet.php"><i class="fa fa-plus"> </i> Add Walet</a> </h2>
                     <?php
                        // include message //
                        include_once('message/message.php'); // this is used for include message //
                        // end of include message // ?>      
                  </div>
                  <div class="panel-body">
                     <div class="top-content">
                        <div class="row">
                      <?php
                        // include search box //
                        //include_once('search-box.php'); // this is used for include search box //
                        // end of include search box // ?>   
                        </div>
                     </div>
                     <div id="w0" class="grid-view">
                        <form id="w0" class="form-horizontal form" method="post" role="form">
                          <?php // include variable //
                            include_once("variable/variable.php"); // this is used for include variable //
                            // end of include variable // ?>
                           <ul class="nav nav-tabs">
                              <li class="active">
                                 <a href="#all" data-toggle="tab" data-id="all">All</a>
                              </li>
                                <li>
                                 <a href="#del" data-toggle="tab" data-id="del">Deleted</a>
                              </li>

                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane active" id="all">
                        <div class="row">
                      <div class="col-sm-12">
                        <div class="view-all"> 
                        </div>
                     </div>
                  </div>                   
                              </div>

                      <div class="tab-pane" id="del">

                   <div class="row">
                      <div class="col-sm-12">
                        <div class="view-del"></div>

                     </div>

                  </div>     
                                
                              </div>

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
  //function view pagination//
function view(page = "", search = "", type = "") {
    var html = "";
    var search = search;
    var page = page;
    var type = type;
    var view = "";
    $.ajax({
        url: "view/view_wallet_address.php",
        method: "POST",
        data: { page: page, search: search, type: type },
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
            if (type == "all") {
                $(".view-all").html(html);
            }
             if (type == "del") {
                $(".view-del").html(html);
            }
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
                if (type == "all") {
                    $(".view-all").html(html);
                }
                 if (type == "del") {
                $(".view-del").html(html);
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
            url: "view/view_wallet_address.php",
            method: "POST",
            data: { page: page, search: search, type: type },
            dataType: "html",
            beforeSend: function () {
                html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
                if (type == "all") {
                    $(".view-all").html(html);
                }
                if (type == "comp") {
                    $(".view-del").html(html);
                }
              
            },
            success: function (responseData) {
                html = responseData;
                setTimeout(function () {
                    if (type == "all") {
                        $(".view-all").html(html);
                    }
                    if (type == "all") {
                        $(".view-del").html(html);
                    }
                    
                }, 200);
            },
        });
    }
}
//end of function view on key enter //


   
      // function disable button //
      function disablebutton()
      {
      $('.delete-btn').css('background-color','#dee2e6');
      $('.delete-btn').css('border','1px solid #dee2e6');
      $('.delete-btn').attr('disabled',true);
      $('.restore-btn').css('background-color','#dee2e6');
      $('.restore-btn').css('border','1px solid #dee2e6');
      $('.restore-btn').attr('disabled',true);   
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
      
      }
      // end of function enable button //


   //function del//
      function del(waid='',aid='',uname='')
      { 
      var waid = waid;
      var aid = aid;
      var uname = uname;
      var msg = msg;
      var type ='';

      $.ajax({
        url:"delete/delete-wallet.php",
        method:"POST",
        data:{waid : waid, aid : aid, uname : uname},
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
          $('.table').find('#row'+waid).remove();
           type = $(".nav-tabs li.active a").attr("data-id");
          view("","",type);
         },2000);
   
        }
      });
      }
      // end of function del //


   //function restore//
      function restore(dwaid='',aid='',uname='')
      { 
      var dwaid = dwaid;
      var aid = aid;
      var uname = uname;
      var msg = msg;
      var type ='';
   
      $.ajax({
        url:"restore/restore-wallet.php",
        method:"POST",
        data:{dwaid : dwaid, aid : aid, uname : uname},
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
          $('.table').find('#row'+dwaid).remove();
           type = "all";
          view("","",type);
         },2000);
   
        }
      });
      }
      // end of function restore //


   
   //function search//
   function search_wallet(waid='')
   { 
   var waid = waid;
   var thisurl = '';
   $.ajax({
     url:"add-wallet.php",
     method:"GET",
     success:function(data)
     {  
       thisurl = "add-wallet.php?wallet="+waid;
       window.location.href = thisurl;   
     }
   });
   }
   // end of function search //


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
    // check row function //
      $('body').on('click','.waid',function (e) {
         $('.waid:checked').each(function(){
       });
         if($('.waid').is(':checked')){
          $('.btn-delete').attr('disabled',false);
         }else{
          $('.btn-delete').attr('disabled',true);
         }   
      });

      $('body').on('click','.dwaid',function (e) {
         $('.dwaid:checked').each(function(){
       });
         if($('.dwaid').is(':checked')){
          $('.btn-restore').attr('disabled',false);
         }else{
          $('.btn-restore').attr('disabled',true);
         }   
      });

        
      // enable button on check //
      $('body').on('click','.btn-check',function(){
        $(".table tr").each( function() {
         $(this).find('input[type="checkbox"]').prop('checked', true);  
        check = $(this).find('input[type="checkbox"]').val();
        });
        $('.btn-delete').attr('disabled',false);
      });

        // disable button on uncheck //
       $('body').on('click','.btn-uncheck',function(){
        $(".table tr").each( function() {
        $(this).find('input[type="checkbox"]').prop('checked', false);  
        $(this).find('input[type="checkbox"]').val(0);    
        $('.btn-delete').attr('disabled',true);  
        });
     });

         $('body').on('click','.btn-check-r',function(){
        $(".table tr").each( function() {
         $(this).find('input[type="checkbox"]').prop('checked', true);  
        check = $(this).find('input[type="checkbox"]').val();
        });
        $('.btn-restore').attr('disabled',false);
      });

        // disable button on uncheck //
       $('body').on('click','.btn-uncheck-r',function(){
        $(".table tr").each( function() {
        $(this).find('input[type="checkbox"]').prop('checked', false);  
        $(this).find('input[type="checkbox"]').val(0);    
        $('.btn-restore').attr('disabled',true);  
        });
     });

        // show modal function //
                    var waid = ''; 
                    var thismtxt = '';
                   $('body').on('click','.btn-delete',function(){
                     thismtxt ='<h3><strong class="mttxt"> Delete Wallet Address <strong></strong></h3>';
                     $('#DlModal').css('display','block');
                     $('#DlModal').find('.modal-title').html(thismtxt);
                     enablebutton();
                   });

                    $('body').on('click','.btn-restore',function(){
                     thismtxt ='<h3><strong class="mttxt"> Restore Wallet Address <strong></strong></h3>';
                     $('#RsModal').css('display','block');
                     $('#RsModal').find('.modal-title').html(thismtxt);
                     enablebutton();
                   });          
   

             // end of show modal function //
   
               // hide modal function //
                   $('body').on('click','.btn-close',function(){
                     $('#DlModal').css('display','none');
                     $('#DlModal').css('display','none');
                     $('#RsModal').css('display','none');
                     $('#RsModal').css('display','none');  
                   });
             // end of hide modal function //   
   


                // call del function //
                  var aid = '';
                  var uname = '';
                  $('body').on('click','.delete-btn',function(){
                    var waid = [];
                    $('.waid:checked').each(function(){
                     waid.push($(this).val()); 
                     aid = $('.uid').val();
                     uname = $('.uname').val();
                   });
                    if(waid.length != 0){
                      del(waid,aid,uname)
                    }
                   });
                   // end of call del function //
                

                // call restore function //
                  var aid = '';
                  var uname = '';
                  $('body').on('click','.restore-btn',function(){
                    var dwaid = [];
                    $('.dwaid:checked').each(function(){
                     dwaid.push($(this).val()); 
                     aid = $('.uid').val();
                     uname = $('.uname').val();
                   });
                    if(dwaid.length != 0){
                      restore(dwaid,aid,uname)
                    }
                   });
                   // end of call restore function //

                // call search function //

                  $('body').on('click','.btn-search',function(){
                    var waid = '';
                     waid = $(this).attr('data-id'); 
                    if(waid.length != 0){
                      search_wallet(waid)
                    }
                   });
                   // end of call search function //
                


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
});
// end of jquery //
</script>


