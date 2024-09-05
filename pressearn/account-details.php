<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header //
if(isset($_SESSION['u_id_pk']) == ''){
echo "<script>location.assign('signin.php')</script>";
}  
?>
<?php
   
  // include get code //
   include_once('get/get-code.php'); // this is used for include get code //
    // end of includeget code //
   ?> 
   <!-- title -->
    <?php
      // include nav //
      include_once('nav/nav.php'); // this is used for include nav //
      // end of include nav // ?>  
<!-- title -->
<title>Account Details</title>
<body class="teamreports">

<section id="screens">
<div class="container-fluid">
    <div class="mediascreens sec">
       <?php // include variable //
      // include variable //
      include_once "variable/variable.php"; // this is used for include variable //
        // end of include variable // ?>
            <div class="row no-gutters">
                </div>
            <div class="col-md-12 info">
                    <div class="search-bar">
                        <h3>Account Details</h3>
                        <div class="search-box">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <input type="text" name="name" class="search-txt" placeholder="2022-04-18 / 2022-04-18" />
                                <a class="search-btn" href="#">
                                  <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                        </div>
                    </div>
                <div class="infobox acc2">
                        <ul class="nav nav-tabs ">
                            <li class="nav-item mynavtabs team active">
                                <a class="nav-link tab-links team" href="#dep" data-toggle="tab" data-id="dep">Deposit</a>
                            </li>
                            <li class="nav-item mynavtabs team">
                                <a class="nav-link tab-links team" href="#with" data-toggle="tab" data-id="with">Withdrawal</a>
                            </li>
                            <li class="nav-item mynavtabs team">
                                <a class="nav-link tab-links team" href="#com" data-toggle="tab" data-id="com">Team Commission</a>
                            </li>
                        </ul>

                           <div class="tab-content">


                          <div class="tab-pane active" id="dep">
                        <div class="row">
                       <div class="col-sm-12">
                        <div class="view-dep">
                        </div>
                     </div>
                  </div>                   
                  </div>

                        <div class="tab-pane" id="with">
                        <div class="row">
                       <div class="col-sm-12">
                        <div class="view-with">



                        </div>
                     </div>
                  </div>                   
                  </div>

                        <div class="tab-pane" id="com">
                        <div class="row">
                       <div class="col-sm-12">
                        <div class="view-com">



                        </div>
                     </div>
                  </div>                   
                  </div>


                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>


  //function view pagination//
function view(page = "", search = "", type = "") {
    var html = "";
    var search = search;
    var page = page;
    var type = type;
    var uid = '';
    var refcode = '';
    uid = $('.uid').val();
    refcode = $('.myrefcode').val();

    if(type == 'dep'){
    $.ajax({
        url: "view/view_deposit.php",
        method: "POST",
        data: { page: page, search: search, type: type, uid : uid},
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
           
            if (type == "dep") {
              $(".view-dep").html(html);
            } 
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
             
               if (type == "dep") {
                $(".view-dep").html(html);
                } 
               
            }, 200);
        },
    });
  }
    if(type == 'with'){
    $.ajax({
        url: "view/view_withdrawal.php",
        method: "POST",
        data: { page: page, search: search, type: type, uid : uid},
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
           
            if (type == "with") {
                $(".view-with").html(html);
            } 
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
             
               if (type == "with") {
                $(".view-with").html(html);
                } 
               
            }, 200);
        },
    });
  }
    if(type == 'com'){
    $.ajax({
        url: "view/view_team_commission.php",
        method: "POST",
        data: { page: page, search: search, type: type, uid : uid, refcode : refcode },
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
           
            if (type == "com") {
                $(".view-com").html(html);
            } 
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
             
               if (type == "com") {
                $(".view-com").html(html);
                } 
               
            }, 200);
        },
    });
  }

}
//end of function view//

//function view on key enter//
function viewkeyenter(page = "", search = "", type = "", e = "") {
    var html = "";
    var search = search;
    var page = page;
    var type = type;
    var uid = '';
    var refcode = '';
    uid = $('.uid').val();
    refcode = $('.myrefcode').val();
    var view = "";
    if (e.which == 13) {
        e.preventDefault();
    if(type == 'dep'){
    $.ajax({
        url: "view/view_deposit.php",
        method: "POST",
        data: { page: page, search: search, type: type, uid : uid},
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
           
            if (type == "dep") {
              $(".view-dep").html(html);
            } 
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
             
               if (type == "dep") {
                $(".view-dep").html(html);
                }              
            }, 200);
        },
    });
  }
    if(type == 'with'){
    $.ajax({
        url: "view/view_withdrawal.php",
        method: "POST",
        data: { page: page, search: search, type: type, uid : uid},
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
           
            if (type == "with") {
                $(".view-with").html(html);
            } 
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
             
               if (type == "with") {
                $(".view-with").html(html);
                } 
               
            }, 200);
        },
    });
  }
    if(type == 'com'){
    $.ajax({
        url: "view/view_team_commission.php",
        method: "POST",
        data: { page: page, search: search, type: type, uid : uid, refcode : refcode },
        dataType: "html",
        beforeSend: function () {
            html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
           
            if (type == "com") {
                $(".view-com").html(html);
            } 
          
        },
        success: function (responseData) {
            html = responseData;
            setTimeout(function () {
             
               if (type == "com") {
                $(".view-com").html(html);
                } 
               
            }, 200);
        },
    });
  }
    }
}
//end of function view on key enter //


var search = "";
var page = "";
var type = "all";


   // start jquery //
$(document).ready(function(){

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

    // click function for tabs//
    $("body").on("click", ".nav-tabs li a", function () {
        type = $(this).attr("data-id");
        $('li.active').removeClass('active');
        $(this).parent('li').addClass('active');
        search = $(".search").val();
        page = $(".btn-page").attr("data-page");
        view(page, search, type);
    });

    // end of click function for tabs //

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

});
// end of jquery //   

</script>

</body>

   <?php
      // include footer //
      include_once('foot2.php'); // this is used for include footer //
       // end of include footer // ?>
