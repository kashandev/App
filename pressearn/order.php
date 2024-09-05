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
<title>Order</title>
<body class="teamreports">
   <section id="screens">
      <div class="container-fluid">
         <div class="mediascreens details">
            <?php 
               // include variable //
             include_once "variable/variable.php"; // this is used for include variable //   
            // end of include variable // ?>
            <div class="row no-gutters ">
               <div class="col-md-12 info">
                  <div class="show-content s-assets">
                     <h3>Remaining available assets</h3>
                     <div class="show-box ">
                        <h2><label class="bal"></label>  <i class="fa fa-eye btn-s-assets"></i> </h2>
                        <div class="commission_table">
                           <table>
                              <tr class="mytbl">
                                 <td>Accumulated Order Commission</td>
                                 <td class="accucom"></td>
                              </tr>
                              <tr class="mytbl">
                                 <td>Accumulated Team Commission</td>
                                 <td class="accutcom"></td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="show-content-2 h-assets">
                     <h3>Remaining available assets</h3>
                     <div class="show-box">
                        <div>
                           <h2>***** <i class="fa fa-eye-slash btn-h-assets"></i> </h2>
                        </div>
                        <div class="commission_table">
                           <table>
                              <tr class="mytbl">
                                 <td>Accumulated Order Commission</td>
                                 <td>*****</td>
                              </tr>
                              <tr class="mytbl">
                                 <td>Accumulated Team Commission</td>
                                 <td>*****</td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="taccucom" class="taccucom">
                  <div class="infobox acc2">
                     <ul class="nav nav-tabs ">
                        <li class="nav-item mynavtabs active">
                           <a class="nav-link tab-links" href="#all" data-toggle="tab" data-id="all">All</a>
                        </li>
                        <li class="nav-item mynavtabs">
                           <a class="nav-link tab-links" href="#pend" data-toggle="tab" data-id="pend">Pending</a>
                        </li>
                        <li class="nav-item mynavtabs">
                           <a class="nav-link tab-links" href="#comp" data-toggle="tab" data-id="comp">Completed</a>
                        </li>
                        <li class="nav-item mynavtabs">
                           <a class="nav-link tab-links" href="#can" data-toggle="tab" data-id="can">Cancelled</a>
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
                        <div class="tab-pane" id="pend">
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="view-pending">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane" id="comp">
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="view-complete">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane" id="can">
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="view-cancel">
                                 </div>
                              </div>
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
      // round function //   
      
      function round(value, precision) {
      
      var multiplier = Math.pow(10, precision || 0);
      
      return Math.round(value * multiplier) / multiplier;
      
      }
      
      // end of round function //
      
      
      
      function convert_positive(a) {
      
      // Check the number is negative 
      
      if (a < 0) {
      
          // Multiply number with -1 
      
          // to make it positive 
      
          a = a * -1;
      
      }
      
      // Return the positive number 
      
      return a;
      
      }
      
      
      
      //function view order //
      
     function view(page = "", search = "", type = "") {
      
      var html = "";
      
      var search = search;
      
      var page = page;
      
      var type = type;
      
      var uid = $('.uid').val();
      
      $.ajax({
      
          url: "view/view_order.php",
      
          method: "POST",
      
          data: {
              page: page,
              search: search,
              type: type,
              uid: uid
          },
      
          dataType: "html",
      
          beforeSend: function() {
      
              html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
      
              if (type == "all") {
      
                  $(".view-all").html(html);
      
              }
      
              if (type == "pend") {
      
                  $(".view-pending").html(html);
      
              }
      
              if (type == "comp") {
      
                  $(".view-complete").html(html);
      
              }
      
              if (type == "can") {
      
                  $(".view-cancel").html(html);
      
              }
      
      
      
          },
      
          success: function(responseData) {
      
              html = responseData;
      
              setTimeout(function() {
      
                  if (type == "all") {
      
                      $(".view-all").html(html);
      
                  }
      
                  if (type == "pend") {
      
                      $(".view-pending").html(html);
      
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
      
      var uid = $('.uid').val();
      
      if (e.which == 13) {
      
          e.preventDefault();
      
          $.ajax({
      
              url: "view/view_order.php",
      
              method: "POST",
      
              data: {
                  page: page,
                  search: search,
                  type: type,
                  uid: uid
              },
      
              dataType: "html",
      
              beforeSend: function() {
      
                  html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
      
                  if (type == "all") {
      
                      $(".view-all").html(html);
      
                  }
      
                  if (type == "pend") {
      
                      $(".view-pending").html(html);
      
                  }
      
                  if (type == "comp") {
      
                      $(".view-complete").html(html);
      
                  }
      
      
      
                  if (type == "can") {
      
                      $(".view-cancel").html(html);
      
                  }
      
      
      
              },
      
              success: function(responseData) {
      
                  html = responseData;
      
                  setTimeout(function() {
      
                      if (type == "all") {
      
                          $(".view-all").html(html);
      
                      }
      
                      if (type == "pend") {
      
                          $(".view-pending").html(html);
      
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
      
      
      
      
      
      var search = "";
      var page = "";
      var type = "all";
      // start jquery //
      $(document).ready(function() {
      
      // show assets function //
      
      $('.btn-h-assets').on('click', function() {
      
          $('.h-assets').hide();
      
          $('.s-assets').show();
      
      });
      
      // end of show assets function //
      
      
      
      // hide assets function //
      
      $('.btn-s-assets').on('click', function() {
      
          $('.h-assets').show();
      
          $('.s-assets').hide();
      
      });
      
      // end of hide assets function //
      
      
      
      type = $(".nav-tabs li.active a").attr("data-id");
      
      view(page, search, type);
      
      
      
      // search function //
      
      $(document).keypress(".search", function(e) {
      
          search = $(".search").val();
      
          page = $(".btn-page").attr("data-page");
      
          viewkeyenter(page, search, type, e);
      
      });
      
      
      
      $("body").on("click", ".search-btn", function(e) {
      
          e.preventDefault();
      
          page = $(this).attr("data-page");
      
          search = $(".search").val();
      
          view(page, search, type);
      
      });
      
      // end of search function //
      
      
      
      // call view function //
      
      $("body").on("click", ".btn-page", function(e) {
      
          e.preventDefault();
      
          page = $(this).attr("data-page");
      
          search = $(".search").val();
      
          view(page, search, type);
      
      });
      
      
      
      $("body").on("click", ".btn-next", function(e) {
      
          e.preventDefault();
      
          page = $(this).attr("data-page");
      
          search = $(".search").val();
      
          view(page, search, type);
      
      });
      
      // end of call view function //
      
      
      
      // search function//
      
      
      
      $("body").on("keyup", ".search", function() {
      
          search = $(this).val();
      
          page = $(".btn-page").attr("data-page");
      
          if (search == "") {
      
              view(page, search, type);
      
          }
      
      });
      
      
      
      // end of search function//
      
      
      
      // click function for tabs//
      
      $("body").on("click", ".nav-tabs li a", function() {
      
          type = $(this).attr("data-id");
      
          $('li.active').removeClass('active');
      
          $(this).parent('li').addClass('active');
      
          search = $(".search").val();
      
          page = $(".btn-page").attr("data-page");
      
          view(page, search, type);
      
      });
      
      
      
      // end of click function for tabs //
      
      
      
      // remove space function from string //
      
      $(document).on("paste", ".search", function(e) {
      
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
      
      // document add event listner //
      document.addEventListener('DOMContentLoaded', function() {
      let intervalId = null; // Store the interval ID
      
      // accu com function //
      function accu_com(result) {
          let accucom = 0;
          let thisaccuc = '';
          accucom = result;
          if (accucom == 0) {
              thisaccuc = '$' + '' + accucom;
          } 
          if(!isNaN(accucom)){	
            if (accucom != 0) {
              thisaccuc = '$' + '' + accucom;
          }
        }
          $('.accucom').html(thisaccuc);
          // Stop the interval check after updating commission
          clearInterval(intervalId);
      }
      
      // set team com function //
      function set_team_com(result) {
      
          let tcom = 0;
      
          let tcoma = 0;
      
          let tcomb = 0;
      
          let tcomc = 0;
          
          let thistca = 0;
      
          let thistcb = 0;
      
          let thistcc = 0;
      
          let thiscomb = 0;
      
          let thiscomc = 0;
      
          let thiscom = 0;
      
          let thiscoma = 0;
      
          let thistcoma = 0;
      
          let thistcom = 0;
      
          if (result.coma == 0 || result.comb == 0 || result.comc == 0)
      
          {
      
              thiscoma = 0;
      
              thiscomb = 0;
      
              thiscomc = 0;
      
              thistcoma = '$0';
      
          }
      
      
      
          if (result.coma != 0 || result.comb != 0 || result.comc != 0)
      
          {
      
              tcoma = parseFloat(result.coma);
      
              pca = parseFloat(result.pcoma);
      
              tcomb = parseFloat(result.comb);
      
              pcb = parseFloat(result.pcomb);
      
              tcomc = parseFloat(result.comc);
      
              pcc = parseFloat(result.pcomc);
      
      
      
              if (tcoma != 0 || tcomb != 0 || tcomc != 0) {
      
                  thistca = (Math.round(tcoma * 100) / 100);
      
                  thiscoma = round(thistca, 2);
      
                  thispcoma = pca;
      
                  thistcb = (Math.round(tcomb * 100) / 100);
      
                  thiscomb = round(thistcb, 2);
      
                  thispcomb = pcb;
      
                  thistcc = (Math.round(tcomc * 100) / 100);
      
                  thiscomc = round(thistcc, 2);
      
                  thispcomc = pcc;
      
                  thistcom = parseFloat(thiscoma + thiscomb + thiscomc);
      
                  thiscom = round(thistcom, 2);
      
                  thistcoma = '$' + '' + thiscom;      
              }

          }
          else {
                thistcoma = '$' + '' + thiscom;   
          }
              $('.accutcom').html(thistcoma);
      
          // Stop the interval check after updating commission
          clearInterval(intervalId);
      }
      
      // get balance function //
      function get_balance(result) {
          let bal = '$' + '' + result;
          $('.bal').html(bal);
      
          // Stop the interval check after updating balance
          clearInterval(intervalId);
      }
      // get check new data function //
      function checkForNewData() {
          let uid = $('.uid').val(); // Get user ID
          let refcode = $('.myrefcode').val(); // Get Ref Code
          // ajax call for get balance
          $.ajax({
              url: "get/get-balance.php",
              type: "post",
              data: {
                  uid: uid
              },
              dataType: "html",
              success: function(result) {
                  if (result.trim() !== "") { // Check if result is not empty
                      get_balance(result); // Update balance with the result
      
                      // Stop the interval check after new data is detected
                      clearInterval(intervalId);
                  }
              },
              error: function() {
                  console.error('Error fetching balance');
              }
          });
      
          // ajax call for get accu commission
          $.ajax({
              url: "get/accu-com.php",
              type: "post",
              data: {
                  uid: uid
              },
              dataType: "html",
              success: function(result) {
                  if (result.trim() !== "") { // Check if result is not empty
                      accu_com(result); // Update commission with the result
      
                      // Stop the interval check after new data is detected
                      clearInterval(intervalId);
                  }
              },
              error: function() {
                  console.error('Error fetching balance');
              }
          });
      
          // ajax call for set team commission
          $.ajax({
              url: "get/team-com.php",
              type: "post",
              data: {
                  uid: uid,
                  refcode: refcode
      
              },
              dataType: "json",
              success: function(result) {
                  if (result != "") { // Check if result is not empty
                      set_team_com(result); // Update commission with the result
      
                      // Stop the interval check after new data is detected
                      clearInterval(intervalId);
                  }
              },
              error: function() {
                  console.error('Error fetching balance');
              }
          });
      
      
      
      }
      // Start the interval check
      intervalId = setInterval(checkForNewData, 1000); // Check every second
      });
      // end of document add event listner //
   </script>
</body>
<?php include_once('foot2.php') ?>