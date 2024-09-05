<?php

// include header //

include_once('header.php'); // this is used for include header //

// end of include header //

?>

<!-- title -->

<title>Deposit</title>

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

                    <h2> Deposit </h2>

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

                                 <a href="#new" data-toggle="tab" data-id="new">New</a>

                              </li>

                              <li>

                                 <a href="#comp" data-toggle="tab" data-id="comp">Approved</a>

                              </li>

                                <li>

                                 <a href="#can" data-toggle="tab" data-id="can">Rejected</a>

                              </li>



                           </ul>

                           <div class="tab-content">

                              <div class="tab-pane active" id="new">

                        <div class="row">

                      <div class="col-sm-12">

                        <div class="view-new"> 

                        </div>

                     </div>

                  </div>                   

                              </div>

                      <div class="tab-pane" id="comp">



                   <div class="row">

                      <div class="col-sm-12">

                        <div class="view-complete"></div>

                     </div>

                  </div>                     

                 </div>



                      <div class="tab-pane" id="can">



                   <div class="row">

                      <div class="col-sm-12">

                        <div class="view-cancel"></div>



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

        url: "view/view_deposit.php",

        method: "POST",

        data: { page: page, search: search, type: type },

        dataType: "html",

        beforeSend: function () {

            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';

            if (type == "new") {

                $(".view-new").html(html);

            }

            if (type == "comp") {

                $(".view-complete").html(html);

            }

             if (type == "can") {

                $(".view-cancel").html(html);

            }

          

        },

        success: function (responseData) {

            html = responseData;

            setTimeout(function () {

                if (type == "new") {

                    $(".view-new").html(html);

                }

                if (type == "comp") {

                    $(".view-complete").html(html);

                }

                 if (type == "can") {

                $(".view-cancel").html(html);

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

            url: "view/view_deposite.php",

            method: "POST",

            data: { page: page, search: search, type: type },

            dataType: "html",

            beforeSend: function () {

                html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';

                if (type == "new") {

                    $(".view-new").html(html);

                }

                if (type == "comp") {

                    $(".view-complete").html(html);

                }

             

              if (type == "can") {

                $(".view-cancel").html(html);

            } 



            },

            success: function (responseData) {

                html = responseData;

                setTimeout(function () {

                if (type == "new") {

                    $(".view-new").html(html);

                }

                if (type == "comp") {

                    $(".view-complete").html(html);

                }

                 if (type == "can") {

                $(".view-cancel").html(html);

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

      $('.approve-btn').css('background-color','#dee2e6');

      $('.approve-btn').css('border','1px solid #dee2e6');

      $('.approve-btn').attr('disabled',true);

      $('.dis-approve-btn').css('background-color','#dee2e6');

      $('.dis-approve-btn').css('border','1px solid #dee2e6');

      $('.dis-approve-btn').attr('disabled',true);   

      }

      

      // end of function disable button //

   

      

     // function enable button //

      function enablebutton()

      {

      $('.approve-btn').css('background-color','#089000');

      $('.approve-btn').css('border','1px solid #327b00');

      $('.approve-btn').attr('disabled',false);

      $('.dis-approve-btn').css('background-color','#089000');

      $('.dis-approve-btn').css('border','1px solid #327b00');

      $('.dis-approve-btn').attr('disabled',false); 

      

      }

      // end of function enable button //





   //function approve//

      function approve(dpid='',uid='',aid='',uname='')

      { 

      var dpid = dpid;

      var uid = uid;

      var aid = aid;

      var uname = uname;

      var msg = '';

      var type ='';

   

      $.ajax({

        url:"approve/approve-deposit.php",

        method:"POST",

        data:{dpid : dpid, uid : uid, aid : aid, uname : uname},

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

          $('#ApModal').css('display','none');  

          $('new-table').find('#row'+dpid).remove();

           type = $(".nav-tabs li.active a").attr("data-id");

          view("","",type);

         },2000);

   

        }

      });

      }

      // end of function approve //



   //function disapprove//

      function disapprove(dpid='',aid='',uname='')

      { 

      var dpid = dpid;

      var aid = aid;

      var uname = uname;

      var msg = '';

      var type ='';

   

      $.ajax({

        url:"approve/dis-approve-deposit.php",

        method:"POST",

        data:{dpid : dpid, aid : aid, uname : uname},

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

          $('.message-box').fadeOut(3000);

         },400);

   

         setTimeout(function(){

          $('#DpModal').css('display','none');  

          $('new-table').find('#row'+dpid).remove();

           type = $(".nav-tabs li.active a").attr("data-id");

          view("","",type);

         },3200);

   

        }

      });

      }

      // end of function disapprove //





var search = "";

var page = "";

var type = "new";



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

      $('body').on('click','.dpid',function (e) {

         $('.dpid:checked').each(function(){

       });

         if($('.dpid').is(':checked')){

          $('.btn-approve').attr('disabled',false);

          $('.btn-dis-approve').attr('disabled',false);   

         }else{

          $('.btn-approve').attr('disabled',true);

          $('.btn-dis-approve').attr('disabled',true);

         }   

      });



      // enable button on check //

      $('body').on('click','.btn-check',function(){

        $(".new-table tr").each( function() {

         $(this).find('input[type="checkbox"]').prop('checked', true);  

        check = $(this).find('input[type="checkbox"]').val();

        });

        $('.btn-approve').attr('disabled',false);

        $('.btn-dis-approve').attr('disabled',false);

      });



        // disable button on uncheck //

       $('body').on('click','.btn-uncheck',function(){

        $(".new-table tr").each( function() {

        $(this).find('input[type="checkbox"]').prop('checked', false);  

        $(this).find('input[type="checkbox"]').val(0);    

        $('.btn-approve').attr('disabled',true);  

        $('.btn-dis-approve').attr('disabled',true);

        });

     });



        // show modal function //

                    var dpid = ''; 

                    var thismtxt = '';

                   $('body').on('click','.btn-approve',function(){

                     thismtxt ='<h3><strong class="mttxt"> Approve Deposit </strong></h3>';

                     $('#ApModal').css('display','block');

                     $('#ApModal').find('.modal-title').html(thismtxt);

                     enablebutton();

                   });



                    $('body').on('click','.btn-dis-approve',function(){

                     thismtxt ='<h3><strong class="mttxt">  Reject Deposit  </strong></h3>';

                     $('#DpModal').css('display','block');

                     $('#DpModal').find('.modal-title').html(thismtxt);

                     enablebutton();

                   });          

   



             // end of show modal function //

   

               // hide modal function //

                   $('body').on('click','.btn-close',function(){

                     $('#ApModal').css('display','none');

                     $('#ApModal').css('display','none');

                     $('#DpModal').css('display','none');

                     $('#DpModal').css('display','none');  

                   });

             // end of hide modal function //   

   





                // call approve function //

                 // var dpid = [];

                  var uid = '';

                  var aid = '';

                  var uname = '';

                  $('body').on('click','.approve-btn',function(){

                    var dpid = [];

                    $('.dpid:checked').each(function(){

                     dpid.push($(this).val()); 

                     uid = $(this).attr('data-uid');

                     aid = $('.uid').val();

                     uname = $('.uname').val();

                   });

                    if(dpid.length != 0){

                      approve(dpid,uid,aid,uname)

                    }

                   });

                   // end of call approve function //

                



                // call disapprove function //

                  var aid = '';

                  var uname = '';

                  $('body').on('click','.dis-approve-btn',function(){

                    var dpid = [];

                    $('.dpid:checked').each(function(){

                     dpid.push($(this).val()); 

                     aid = $('.uid').val();

                     uname = $('.uname').val();

                   });

                    if(dpid.length != 0){

                      disapprove(dpid,aid,uname)

                    }

                   });

                   // end of call disapprove function //





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





