<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header //?>
<!-- title -->
<title>Reports</title>
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
                     <h2> Reports </h2>
                     <?php
                        // include message //
                        include_once('message/message.php'); // this is used for include message //
                        // end of include message // ?>      
                  </div>
                  <div class="panel-body">
                     <div class="top-content">
                        <div class="row">
                           <?php
                              // include search report box //
                              // include_once('search-report-box.php'); // this is used for include search report box //
                              // end of include search report box // ?>   
                        </div>
                     </div>
                     <div id="w0" class="grid-view">
                        <form id="w0" class="form-horizontal form" method="post" role="form">
                           <ul class="nav nav-tabs">
                              <li class="active">
                                 <a href="#all" data-toggle="tab" data-id="all">All</a>
                              </li>
                              <li><a href="#tmr" data-toggle="tab" data-id="tmr">Team Report</a>
                              </li>
                              <li><a href="#acr" data-toggle="tab" data-id="acr">Account Report</a>
                              </li>
                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane active" id="all">
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="col-sm-2">
                                          <select id="accreport" class="form-control all-report" name="allreport">
                                             <option value="">---Select All Report---</option>
                                             <option value="teamreport" data-name="teamreport" >Team Report</option>
                                             <option value="accountreport" data-name="accountreport">Account Report</option>
                                          </select>
                                       </div>
                                       <div class="col-sm-2" id="tmr-div" style="display: none;">
                                          <select id="tmreport" class="form-control tm-report-all" name="tmreport">
                                             <option value="">---Select Team Report---</option>
                                             <option value="tmdeposit" data-name="tmdeposit" >Deposit</option>
                                             <option value="tmwithdrawal" data-name="tmwithdrawal">Withdrawal</option>
                                             <option value="tmcommission" data-name="tmcommission">Commission</option>
                                          </select>
                                       </div>
                                       <div class="col-sm-2" id="acr-div" style="display: none;">
                                          <select id="accreport" class="form-control acc-report-all" name="accreport" >
                                             <option value="">---Select Account Report---</option>
                                             <option value="acdeposit" data-name="acdeposit" >Deposit</option>
                                             <option value="acwithdrawal" data-name="acwithdrawal">Withdrawal</option>
                                          </select>
                                       </div>
                                       <button type="button" class="btn btn-primary btn-r" style="display: none;">
                                       <i class="fa fa-spinner fa-spin"></i>
                                       Searching
                                       </button>
                                       <div class="col-sm-2" id="search-all-div">
                                          <button type="button" class="btn btn-primary btn-search-allr" disabled=""><i class="fa fa-search"> </i>  Seacrh </button>
                                          <button type="button" class="btn btn-default btn-squared btn-cancel-allr"> <i class="fa fa-close"></i> Cancel </button>
                                       </div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="all-view"></div>
                              </div>
                              <div class="tab-pane" id="tmr">
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="col-sm-2">
                                          <select id="tmreport" class="form-control tm-report" name="tmreport">
                                             <option value="">---Select Team Report---</option>
                                             <option value="tmsdeposit" data-name="tmsdeposit" >Deposit</option>
                                             <option value="tmswithdrawal" data-name="tmswithdrawal">Withdrawal</option>
                                             <option value="tmscommission" data-name="tmscommission">Commission</option>
                                          </select>
                                       </div>
                                       <button type="button" class="btn btn-primary btn-r" style="display: none;">
                                       <i class="fa fa-spinner fa-spin"></i>
                                       Searching
                                       </button>
                                       <div class="col-sm-2" id="search-tm-div">
                                          <button type="button" class="btn btn-primary btn-search-tmr" disabled=""><i class="fa fa-search"> </i>  Seacrh </button>
                                          <button type="button" class="btn btn-default btn-squared btn-cancel-tmr"> <i class="fa fa-close"></i> Cancel </button>
                                       </div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="team-view"></div>
                              </div>
                              <div class="tab-pane" id="acr">
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="col-sm-2">
                                          <select id="accreport" class="form-control acc-report" name="accreport" >
                                             <option value="">---Select Account Report---</option>
                                             <option value="acsdeposit" data-name="acsdeposit" >Deposit</option>
                                             <option value="acswithdrawal" data-name="acswithdrawal">Withdrawal</option>
                                          </select>
                                       </div>
                                       <button type="button" class="btn btn-primary btn-r" style="display: none;">
                                       <i class="fa fa-spinner fa-spin"></i>
                                       Searching
                                       </button>
                                       <div class="col-sm-2" id="search-ac-div">
                                          <button type="button" class="btn btn-primary btn-search-acr" disabled=""><i class="fa fa-search"> </i>  Seacrh </button>
                                          <button type="button" class="btn btn-default btn-squared btn-cancel-acr"> <i class="fa fa-close"></i> Cancel </button>
                                       </div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="account-view"></div>
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
     var allreport = $('.all-report').val();
   
     if(type == 'tmdeposit' && allreport == 'teamreport'){
   
     $.ajax({
         url: "view/view_team_deposit_all_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".all-view").html(html);
              $('#search-all-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-all-div').show();
              $('.btn-r').hide();
              $(".all-view").html(html);
   
             
             },400);
         },
     });
   }
     if(type == 'tmwithdrawal' && allreport == 'teamreport'){
   
     $.ajax({
         url: "view/view_team_withdrawal_all_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".all-view").html(html);
              $('#search-all-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-all-div').show();
              $('.btn-r').hide();
              $(".all-view").html(html);
             
             },400);
         },
     });
   }
     if(type == 'tmcommission' && allreport == 'teamreport'){
    $.ajax({
         url: "view/view_team_commission_all_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".all-view").html(html);
              $('#search-all-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-all-div').show();
              $('.btn-r').hide();
              $(".all-view").html(html);
             
             },400);
         },
     });
   }
   
   
     if(type == 'acdeposit' && allreport == 'accountreport'){
   
   $.ajax({
         url: "view/view_deposit_all_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".all-view").html(html);
              $('#search-all-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-all-div').show();
              $('.btn-r').hide();
              $(".all-view").html(html);
             
             },400);
         },
     });
   }
     if(type == 'acwithdrawal' && allreport == 'accountreport'){
   $.ajax({
         url: "view/view_withdrawal_all_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".all-view").html(html);
              $('#search-all-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-all-div').show();
              $('.btn-r').hide();
              $(".all-view").html(html);
             
             },400);
         },
     });
   }
   
   
     if(type == 'tmsdeposit'){
   
     $.ajax({
         url: "view/view_team_deposit_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".team-view").html(html);
              $('#search-tm-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-tm-div').show();
              $('.btn-r').hide();
              $(".team-view").html(html);
             
             },400);
         },
     });
   }
     if(type == 'tmswithdrawal'){
   
     $.ajax({
         url: "view/view_team_withdrawal_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".team-view").html(html);
              $('#search-tm-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-tm-div').show();
              $('.btn-r').hide();
              $(".team-view").html(html);
             
             },400);
         },
     });
   }
     if(type == 'tmscommission'){
    $.ajax({
         url: "view/view_team_commission_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".team-view").html(html);
              $('#search-tm-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-tm-div').show();
              $('.btn-r').hide();
              $(".team-view").html(html);
             
             },400);
         },
     });
   }
   
   if(type == 'acsdeposit'){
   
   $.ajax({
         url: "view/view_deposit_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".account-view").html(html);
              $('#search-ac-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-ac-div').show();
              $('.btn-r').hide();
              $(".account-view").html(html);
             
             },400);
         },
     });
   }
   if(type == 'acswithdrawal'){
   $.ajax({
         url: "view/view_withdrawal_report.php",
         method: "POST",
         data: { page: page, search: search, type: type},
         dataType: "html",
         beforeSend: function () {
             html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';          
              $(".account-view").html(html);
              $('#search-ac-div').hide();
              $('.btn-r').show();
         },
         success: function (responseData) {
             html = responseData;
             setTimeout(function () { 
              $('#search-ac-div').show();
              $('.btn-r').hide();
              $(".account-view").html(html);
             
             },400);
         },
     });
   }
   
   }
   //end of function view//
       
   // start jquery //
   $(document).ready(function(){ 
   var search = "";
   var page = "";
   var type = "all";
   
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
   
    
   // set report function //
   
   $('.all-report').on('change',function(){
     var report = $(this).val();
     if(report == "")
     {
      $(this).val("");
      $('.btn-search-allr').attr('disabled',true);
      $('#tmr-div').hide();
      $('#acr-div').hide();
      $('.all-view').html('');
      $('.tm-report-all').val("");
      $('.ac-report-all').val("");
     }else{
       if(report == 'teamreport')
       {
          $('#tmr-div').show();
          $('#acr-div').hide();
          $('.btn-search-allr').attr('disabled',true);
       } if(report == 'accountreport')
       {
          $('#tmr-div').hide();
          $('#acr-div').show();
          $('.btn-search-allr').attr('disabled',true);
       }
     }
   });
   
   $('.tm-report-all').on('change',function(){
     var report = $(this).val();
     if(report == "")
     {
      $('.all-view').html('');
      $(this).val("");
     $('.btn-search-allr').attr('disabled',true);
     }else{
       $('#acr-div').hide();
       $('.btn-search-allr').attr('disabled',false);
     }
   });
   
   $('.acc-report-all').on('change',function(){
     var report = $(this).val();
     if(report == "")
     {
      $('.all-view').html('');
      $(this).val("");
      $('.btn-search-allr').attr('disabled',true);
     }else{
       $('#tmr-div').hide();
       $('.btn-search-allr').attr('disabled',false);
     }
   });
   
   $('.tm-report').on('change',function(){
     var report = $(this).val();
     if(report == "")
     {
      $('.team-view').html('');
      $(this).val("");
     $('.btn-search-tmr').attr('disabled',true);
     }else{
       $('.btn-search-tmr').attr('disabled',false);
     }
   });
   
   $('.acc-report').on('change',function(){
     var report = $(this).val();
     if(report == "")
     {
      $('.account-view').html('');
      $(this).val("");
     $('.btn-search-acr').attr('disabled',true);
     }else{
       $('.btn-search-acr').attr('disabled',false);
     }
   });
   
   $('.btn-search-allr').on('click',function(){
     var allreport = $('.all-report').val();
     var tmreport = $('.tm-report-all').val();
     var acreport = $('.acc-report-all').val();
   
   
      if(allreport == 'teamreport'){
   
       if(tmreport == 'tmdeposit')
       {
        view(page, search, tmreport);
   
       }
       if(tmreport == 'tmwithdrawal')
       { 
        view(page, search, tmreport);
       }
       
       if(tmreport == 'tmcommission')
       { 
         view(page, search, tmreport);
       }
    
      }
       if(allreport == 'accountreport'){
   
       if(acreport == 'acdeposit')
       {
         view(page, search, acreport);
   
       }
       if(acreport == 'acwithdrawal')
       { 
          view(page, search, acreport);
       }
   
     }  
   });
   
   $('.btn-search-tmr').on('click',function(){
     var tmreport = $('.tm-report').val();
       if(tmreport == 'tmsdeposit')
       {
        view(page, search, tmreport);
       }
       if(tmreport == 'tmswithdrawal')
       { 
          view(page, search, tmreport);
       }
        if(tmreport == 'tmscommission')
       { 
         view(page, search, tmreport);
       }
   });
  
   $('.btn-search-acr').on('click',function(){
      var acreport = $('.acc-report').val();
       if(acreport == 'acsdeposit')
       {
         view(page, search, acreport);
       }
       if(acreport == 'acswithdrawal')
       { 
          view(page, search, acreport);
       }
   });
   
   // end of set report function //

   // reset fields function //
   $('.btn-cancel-allr').on('click',function(){
    $('.all-view').html('');
    $('.btn-search-allr').attr('disabled',true);
    $('.acc-report-all').val("");
    $('.tm-report-all').val("");
    $('.all-report').val("");
    $('#tmr-div').hide();
    $('#acr-div').hide();
   });

   $('.btn-cancel-tmr').on('click',function(){
    $('.team-view').html('');
    $('.btn-search-tmr').attr('disabled',true);
    $('.tm-report').val("");

   });   

   $('.btn-cancel-acr').on('click',function(){
    $('.account-view').html('');
    $('.btn-search-acr').attr('disabled',true);
    $('.acc-report').val("");

   });      

   // end of reset fields function //
    
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