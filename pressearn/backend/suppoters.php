<?php
// include header //
include_once('header.php'); // this is used for include header //
// end of include header //
?>
<!-- title -->
<title>Supporters</title>
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
                    <h2> Supporters </h2>
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
                           <ul class="nav nav-tabs">
                              <li class="active">
                                 <a href="#all" data-toggle="tab" data-id="all">Total Signup</a>
                              </li>
                              <li>
                                 <a href="#new" data-toggle="tab" data-id="new">New Signup</a>
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
        url: "view/view_supporters.php",
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
            url: "view/view_supporters.php",
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
});
// end of jquery //
</script>


