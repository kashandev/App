<?php

   // include header //

   include_once('slot-head.php'); // this is used for include header //

    // end of include header //   

if(isset($_SESSION['u_id_pk']) == ''){

echo "<script>location.assign('signin.php')</script>";

}  

?>

<?php

   // include nav //

   include_once('nav/nav.php'); // this is used for inclue nav //

   // end of include nav // ?>  

<title>Grab</title>

<body class="customer">

   <?php // include variable //

      // include variable //

      include_once "variable/variable.php"; // this is used for include variable //

        // end of include variable // ?>

   <div id="lvselected">

   </div>

   <div id="viewport">

      <div id="container">

         <div id="header">

            <h1 id="mh">SPIN & WIN</h1>

         </div>

         <div id="reels">

            <canvas id="canvas1" width="70" height="300"></canvas>

            <canvas id="canvas2" width="70" height="300"></canvas>

            <canvas id="canvas3" width="70" height="300"></canvas>

            <div id="overlay">

               <div id="winline"></div>

            </div>

         </div>

         <div id="results"></div>

         <div id="label">

            <label class="torder"></label>

            <input type="hidden" class="tlvid" name="tlvid">

            <input type="hidden" class="noid" name="noid">

            <input type="hidden" class="oid" name="oid">

            <input type="hidden" class="tord" name="tord">

            <input type="hidden" class="tcord" name="tcord">

            <input type="hidden" class="rord" name="rord">

            <input type="hidden" class="title" name="title">

            <input type="hidden" class="com" name="com">

            <input type="hidden" class="pcom" name="pcom">

            <input type="hidden" class="prc" name="prc">

            <input type="hidden" class="wbal" name="wbal">

            <input type="hidden" class="ttc" name="ttc">

            <input type="hidden" class="tyc" name="tyc">

            <input type="hidden" class="myc" name="myc">

            <input type="hidden" class="ocoma" name="ocoma">

            <input type="hidden" class="ocomb" name="ocomb">

            <input type="hidden" class="tpca" name="tpca">

            <input type="hidden" class="tpcb" name="tpcb">

            <input type="hidden" class="tpc" name="tpcc">

            <input type="hidden" class="nc" name="nc">

            <input type="hidden" class="temca" name="temca">

            <input type="hidden" class="temcb" name="temcb">

            <input type="hidden" class="temcc" name="temcc">

         </div>

         <div id="buttons">

            <div class="row">

               <div class="col-md-6">

                  <div id="play" class="button button-default btn-order">Get Order</div>

               </div>

               <div class="col-md-6">

                  <div id="play" class="button button-default btn-recharge" onclick="window.location.href='<?=$thisturl?>'">

                     Recharge

                  </div>

               </div>

            </div>

            <button class="backk" type="button"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button>

            <h1 id="bs">Balance Status</h1>

            <div class="servicesboxes minebox">

               <div class="row minebox">

                  <div class="col-md-2">

                     <div class="ordercards">

                        <div class="cardor card Tier">

                           <h6>Account Balance </h6>

                           <h6 class="bal"></h6>

                        </div>

                     </div>

                  </div>

                  <div class="col-md-2">

                     <div class="ordercards">

                        <div class="cardor card Tier">

                           <h6 class="tf-text">Finished Today</h6>

                           <h6 class="tf"></h6>

                        </div>

                     </div>

                  </div>

                  <div class="col-md-2">

                     <div class="ordercards">

                        <div class="cardor card Tier">

                           <h6>Commission today</h6>

                           <h6 class="tc"></h6>

                        </div>

                     </div>

                  </div>

                  <div class="col-md-2">

                     <div class="ordercards">

                        <div class="cardor card Tier">

                           <h6>Commission yesterday</h6>

                           <h6 class="yc"></h6>

                        </div>

                     </div>

                  </div>

                  <div class="col-md-2">

                     <div class="ordercards">

                        <div class="cardor card Tier">

                           <h6>Team Commission</h6>

                           <h6 class="tmc"></h6>

                        </div>

                     </div>

                  </div>

                  <div class="col-md-2">

                  </div>

               </div>

            </div>

         </div>

      </div>

   </div>

   <div id="error">

      <h5 class="ebay ttxt"></h5>

      <div class="txt">

         <h5 class="htxt"></h5>

      </div>

      <div class="sub-btns">

         <button type="button" class="btn cancel" onclick="hideerror()">Close</button>

      </div>

   </div>

   <div id="success">

      <h5 class="ebay ttxt"></h5>

      <div class="txt">

         <h5 class="htxt"></h5>

      </div>

      <div class="sub-btns">

         <button type="button" class="btn cancel" onclick="hidesuccess()">Close</button>

      </div>

   </div>

</body>

<?php

   // include footer //

   include_once('foot2.php'); // this is used for include footer //

    // end of include footer // ?>

<script type="text/javascript">

//function disable button //

function disablebutton()

{

   $('.btn-order').css('background-color', '#dee2e6');

   $('.btn-order').css('cursor', 'default');

   $('.btn-order').attr('disabled', true);

   $('.btn-recharge').css('background-color', '#dee2e6');

   $('.btn-recharge').css('cursor', 'default');

   $('.btn-recharge').attr('disabled', true);

   $('.backk').css('background-color', '#dee2e6');

   $('.backk').css('cursor', 'default');

   $('.backk').attr('disabled', true);

}


// end of function disable button //


// function enable button //

function enablebutton()

{

   $('.btn-order').css('background-color', '#FF8B02');

   $('.btn-order').css('cursor', 'pointer');

   $('.btn-order').attr('disabled', false);

   $('.btn-recharge').css('background-color', '#FF8B02');

   $('.btn-recharge').css('cursor', 'pointer');

   $('.btn-recharge').attr('disabled', false);

   $('.backk').css('background-color', '#FF8B02');

   $('.backk').css('cursor', 'pointer');

   $('.backk').attr('disabled', false);

}


// end of function enable button //


// get tier function //

function get_tier()

{

   let uid = $('.uid').val();

   $.ajax({

      url: "get/get-tier.php",

      type: "post",

      data: {
         uid: uid
      },

      dataType: "html",

      success: function (result) {

         $('#lvselected').html(result);

      }

   });

}

// end of get tier function //


// show error function //

function show_error(ttl = '', mssg = '', ico = '')

{

   let title = ttl;

   let icon = ico;

   let msg = mssg;

   $('.ttxt').html(title);

   $('.htxt').html(icon + ' ' + msg);

   $('#error').show();

}

// end of show error function //


// show success function //

function show_success(ttl = '', mssg = '', ico = '')

{

   let title = ttl;

   let msg = mssg;

   let icon = ico;

   $('.ttxt').html(title);

   $('.htxt').html(msg + ' ' + icon);

   $('#success').show();

}

// end of show success function //


// show game function //

function show_game()

{


   $('#viewport').show();

   $('#mycustomerscreen').show();

   $('#lvselected').hide();

}

// end of show game function //


// hide game function //

function hide_game()

{


   $('#viewport').hide();

   $('#mycustomerscreen').hide();

   $('#lvselected').show();

}

// end of hide game function //


// save order no function //

function save_order_no(tlvi = '', ui = '', tn = '')

{

   let tlvid = tlvi;

   let uid = ui;

   let tno = tn;

   let noid = '';

   $.ajax({

      url: "insert/save-order-no.php",

      type: "post",

      data: {
         tlvid: tlvid,
         uid: uid,
         tno: tno
      },

      dataType: "json",

      success: function (result) {

         noid = result.noid;

         $('.noid').val(noid);

         show_game();

         get_order_no(noid, tlvid, uid);

      }

   });


}

// end of save order no function //


// round function //   

function round(value, precision) {

   let multiplier = Math.pow(10, precision || 0);

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


// save order function //

function save_order(tlvi = '', ui = '', tn = '', ttl = '', cm = '', pcm = '', tcor = '')

{

   let oid = '';

   let tlvid = tlvi;

   let uid = ui;

   let uinvcid = '';

   let refcode = '';

   let tno = tn;

   let title = ttl;

   let com = cm;

   let pcom = pcm;

   let tcord = tcor;

   let thistno = 0;

   let thistco = 0;

   let thiscamount = 0;

   let thistc = 0;

   let thispc = 0;

   let thisec = 0;

   let bal = 0;

   let tc = 0;

   let pc = 0;

   let ec = 0;

   let prc = 0;

   let a = 0;

   let b = 0;

   let c = 0;

   let thispcom = 0;

   thistno = tn;

   thistco = tcord;

   uinvcid = $('.uinvcid').val();

   refcode = $('.myrefcode').val();

   bal = parseFloat($('.wbal').val());

   ec = parseFloat($('.prc').val());

   a = parseFloat(pcom / 100);

   pc = parseFloat(a);

   b = parseFloat(bal * pc);

   !isNaN(b) ? thisec = b : thisec = 0;

   c = b;

   tc = parseFloat(b)

   if (thistco == thistno) {

      thistc = (Math.round(tc * 100) / 100);

   } else {

      thistc = (Math.round(tc * 100) / 100);

   }

   prc = parseFloat(ec + thistc)

   thisec = round(prc, 2);

   if (pcom == 0.1)

   {

      thispc = parseFloat(pc.toFixed(3));

   } else {

      thispc = parseFloat(pc.toFixed(4));
   }

   

   $.ajax({

      url: "insert/save-order.php",

      type: "post",

      data: {
         tlvid: tlvid,
         uid: uid,
         thistco: thistco,
         thistc: thistc,
         thispc: thispc,
         thisec: thisec,
         uinvcid: uinvcid,
         refcode: refcode
      },

      dataType: "json",

      beforeSend: function () {

         disablebutton();

      },

      success: function (result) {

         setTimeout(function () {

            let oid = result.oid;

            $('.oid').val(oid);

            get_order(tlvid, uid, oid);

         }, 300);

      }

   });

}

//end of save order function //


// confirm order function //

function confirm_order(oi = '', tlvi = '', ui = '', tn = '', ttl = '', cm = '', pcm = '', tcor = '', noi = '', trn = '')

{

   let oid = oi;

   let noid = noi;

   let tlvid = tlvi;

   let uid = ui;

   let tno = tn;

   let trno = trn;

   let title = ttl;

   let msg = '';

   let icon = '';

   let com = cm;

   let pcom = pcm;

   let tcord = tcor;

   let thistno = 0;

   let thistrno = 0;

   let thistco = 0;

   let thiscamount = 0;

   let thistc = 0;

   let thispc = 0;

   let thisec = 0;

   let bal = 0;

   let tc = 0;

   let pc = 0;

   let ec = 0;

   let prc = 0;

   let a = 0;

   let b = 0;

   let c = 0;

   thistno = tn;

   thistrno = trno;

   thistco = tcord;

   uinvcid = $('.uinvcid').val();

   refcode = $('.myrefcode').val();

   noid = $('.noid').val();

   bal = parseFloat($('.wbal').val());

   ec = parseFloat($('.prc').val());

   a = parseFloat(pcom / 100);

   pc = parseFloat(a);

   b = parseFloat(bal * pc);

   thispc = pc;

   !isNaN(b) ? thisec = b : thisec = 0;

   c = b;

   tc = parseFloat(b)

   if (thistco == thistno) {

      thistc = (Math.round(tc * 100) / 100);

   } else {

      thistc = (Math.round(tc * 100) / 100);

   }

   prc = parseFloat(ec + thistc)

   thisec = round(prc, 2);

   $.ajax({

      url: "confirm/confirm-order.php",

      type: "post",

      data: {
         oid: oid,
         tlvid: tlvid,
         uid: uid,
         thistno: thistno,
         thistco: thistco,
         thistc: thistc,
         thispc: thispc,
         thisec: thisec,
         noid: noid,
         thistrno: thistrno,
         uinvcid: uinvcid,
         refcode: refcode
      },

      dataType: "html",

      success: function (result) {


         msg = " Order Successfully Completed";

         icon = '<i class="fa fa-check" aria-hidden="true" id="icon-s"></i>';

         setTimeout(function () {

            enablebutton();

            show_success(title, msg, icon);

            count_order(tlvid, uid);

            get_order_no(noid, tlvid, uid);

            get_total_balance();

            today_com(tlvid,uid);

            yesterday_com(tlvid,uid);

            today_order(tlvid,uid);

         }, 300);

      }

   });


}

//end of confirm order function //


// cancel order function //

function cancel_order(oi = '', tlvi = '', ui = '', ttl = '')

{

   let oid = oi;

   let tlvid = tlvi;

   let uid = ui;

   let title = ttl;

   let icon = '';

   $.ajax({

      url: "cancel/cancel-order.php",

      type: "post",

      data: {
         oid: oid,
         tlvid: tlvid,
         uid: uid
      },

      dataType: "html",

      success: function (result) {

         msg = " Order Cancelled";

         icon = '<i class="fa fa-times" aria-hidden="true" id="icon-e"></i>';

         setTimeout(function () {

            enablebutton();

            show_error(title, msg, icon);

            get_total_balance();

            today_com(tlvid,uid);

            yesterday_com(tlvid,uid);

            today_order(tlvid,uid);

         }, 300);

      }

   });


}

//end of cancel order function //


// check order function //

function check_order(tlvi = '', ui = '', tn = '', ttl = '', cm = '', pcm = '', tcor = '')

{

   let tlvid = tlvi;

   let uid = ui;

   let tno = tn;

   let title = ttl;

   let com = cm;

   let pcom = pcm;

   let tcord = tcor;

   let msg = '';

   $.ajax({

      url: "check/check-order.php",

      type: "post",

      data: {
         tlvid: tlvid,
         uid: uid
      },

      dataType: "html",

      success: function (result) {

         if (result == 1) {

            msg = "Today's Orders Has Been Completed";

            disablebutton();

            $('.backk').attr('disabled', false);

            show_success(title, msg);

            $('.title').val('');

            $('.noid').val('');

            $('.oid').val('');

            $('.tlvid').val('');

            $('.tord').val('');

            $('.tcord').val('');

            $('.rord').val('');

            $('.camount').html('');

            $('.prcom').html('');

            $('.tcom').html('');

            $('.pcom').val('');

            $('.com').val('');

         } else {

            enablebutton();

            save_order_no(tlvid, uid, tno);

            count_order(tlvid, uid);

            $('.title').val(title);

            $('.tlvid').val(tlvid);

            $('.com').val(com);

            $('.pcom').val(pcom);

         }

      }

   });


}

// end of check order function //


// get order no function //

function get_order_no(nod,tlv,ui)

{

   let noid = nod;

   let tlvid = tlv;

   let uid = ui;

   let torder = 0;

   let rorder = 0;

   let thistorder = 0;

   let thisrorder = 0;

   let thisorder = '';

   $.ajax({

      url: "get/get-order-no.php",

      type: "post",

      data: {
         noid: noid,
         tlvid: tlvid,
         uid: uid
      },

      dataType: "json",

      success: function (result) {

         if (result.tno != 0) {

            torder = (result.tno);

            rorder = (result.rno);

            if (rorder == 0) {

               torder = 0;

               rorder = 0;

               thistorder = 0;

               thistorder = 0;

               thisorder = 'Total Order(0)';

            } else {

               thistorder = convert_positive(torder);

               thisrorder = convert_positive(rorder);

               thisorder = 'Total Order(' + rorder + ')';

            }

         } else {

            torder = 0;

            rorder = 0;

            thistorder = 0;

            thistorder = 0;

            thisorder = 'Total Order(0)';

         }

         $('.torder').html(thisorder);

         $('.tord').val(thistorder);

         $('.rord').val(thisrorder);

         if (rorder == 0) {

            disablebutton();

         } else {

            enablebutton();

            $('.backk').attr('disabled', false);

         }

      }

   });


}

// end of get order no function //


// get today order function //

function get_order(tlvi = '', ui = '', oi = '')

{

   let tlvid = tlvi;

   let uid = ui;

   let oid = oi;

   $.ajax({

      url: "get/get-order.php",

      type: "post",

      data: {
         tlvid: tlvid,
         uid: uid,
         oid: oid
      },

      dataType: "html",

      success: function (result) {

         if (result != '') {

            $('#results').html(result);

         }


      }

   });


}

// end of get today order function //


// count order function //

function count_order(tlvi = '', ui = '')

{

   let tlvid = tlvi;

   let uid = ui;

   let tcord = 0;

   let thiscord = 0;

   $.ajax({

      url: "count/count-order.php",

      type: "post",

      data: {
         tlvid: tlvid,
         uid: uid
      },

      dataType: "html",

      success: function (result) {

         if (result != '') {

            tcord = result;
            tcord = tcord.replace(/\n/g, '');
            thiscord = convert_positive(tcord);

         } else {

            tcord = 0;

            thiscord = convert_positive(0);

         }

         $('.tcord').val(thiscord);

      }

   });


}

// end of count order function //


// get total balance function //

function get_total_balance()

{

   let uid = $('.uid').val();

   let bal = '';

   $.ajax({

      url: "get/get-balance.php",

      type: "post",

      data: {
         uid: uid
      },

      dataType: "html",

      success: function (result) {

         bal = '$' + '' + result;

         $('.bal').html(bal);

         $('.wbal').val(result);


      }

   });

}

// end of get total balance function //


//  today order function //

function today_order(tlvid = '',uid = '')

{

   let tlvi = tlvid;

   let ui = uid;

   let torder = 0;

   let thistorder = '';


   $.ajax({

      url: "get/today-order.php",

      type: "post",

      data: {
         tlvid: tlvi,
         uid: ui
      },

      dataType: "html",

      success: function (result) {

         if (result != '') {

            torder = result;

            if (torder == 0) {

               thistorder = 0;

            } 
            if(!isNaN(torder)) {
               thistorder = torder;
            } 
            else {
               thistorder = 0;
            }

            $('.tf').html(thistorder);
         }

      }
   });
}

// end of today order function //


//  today com function //

function today_com(tlvid = '' ,uid = '')

{

   let ui = '';

   let tlvi = '';

   let tcom = 0;

   let thistc = '';

   tlvi = tlvid;

   ui = uid;

   $.ajax({

      url: "get/today-com.php",

      type: "post",

      data: {
         tlvid: tlvi,
         uid: ui
      },

      dataType: "html",

      success: function (result) {

         if (result != '') {

            tcom = result;
            tcom = tcom.replace(/^\s+/g, '').replace(/\n/g, '');

            if (tcom == 0) {

               thistc = '$'+''+ tcom;

            } if(!isNaN(tcom)) {

               thistc = '$' + '' + tcom;

            }
            else {
               thistc = '';
               tcom = 0;
            }

            $('.tc').html(thistc);

            $('.prc').val(tcom);

            $('.ttc').val(tcom);

         }

      }

   });


}

// end of today com function //


//  yesterday com function //

function yesterday_com(tlvid = '', uid = '')

{

   let tlvi = tlvid;

   let ui = uid;

   let ycom = 0;

   let thisyc = '';

   $.ajax({

      url: "get/yesterday-com.php",

      type: "post",

      data: {
         tlvid: tlvi,
         uid: ui
      },

      dataType: "html",

      success: function (result) {

         if (result != '') {

            ycom = result;
            ycom = ycom.replace(/^\s+/g, '').replace(/\n/g, '');

            if (ycom == 0) {

               thisyc = '$' + '' + ycom;

            } if(!isNaN(ycom)) {

               thisyc = '$' + '' + ycom;

            }
            else {
               thisyc = '';
               ycom = 0;
            }

            $('.yc').html(thisyc);

            $('.tyc').val(ycom);


         }


      }

   });


}

// end of yesterday com function //


// start jquery //

$(document).ready(function () {


   // get tier function //         

   get_tier();

   // end of get tier function //


   // slot game function //

   SlotGame();

   // end of slot game function //


   // call show error function //

   $('body').on('click', '.btn-lock', function () {

      let title = $(this).attr('data-title');

      let range = $(this).attr('data-range');

      let msg = '';

      let icon = '';

      msg = 'This tier will be unlocked on (' + range + ')';

      icon = '<i class="fa fa-exclamation-triangle" aria-hidden="true" id="icon-e"></i>';

      show_error(title, msg, icon);

   });

   // end of call show error function //


   // call check order function //

   $('body').on('click', '.btn-unlock', function () {

      let id = $(this).attr('data-id');

      let tno = parseInt($(this).attr('data-tno'));

      let uid = $('.uid').val();

      let noid = $('.noid').val();

      let title = $(this).attr('data-title');

      let tcord = parseInt($('.tcord').val());

      let com = parseInt($(this).attr('data-com'));

      let pcom = parseFloat($(this).attr('data-p-com'));
      
      check_order(id, uid, tno, title, com, pcom, tcord);
      yesterday_com(id,uid);
      today_com(id,uid);
      today_order(id,uid);
   });

   // end of call check order function // 


   // call check order function //

   $('body').on('click', '.btn-order', function () {

      let id = $('.tlvid').val();

      let tno = parseInt($('.tord').val());

      let uid = $('.uid').val();

      let title = $(this).attr('data-title');

      let tcord = parseInt($('.tcord').val());

      let com = parseInt($('.com').val());

      let pcom = parseFloat($('.pcom').val());

      save_order(id, uid, tno, title, com, pcom, tcord);

   });

   // end of call check order function // 


   // call confirm order function //

   $('body').on('click', '.btn-confirm-order', function () {

      let oid = $('.oid').val();

      let noid = $('.noid').val();

      let id = $('.tlvid').val();

      let tno = parseInt($('.tord').val());

      let trno = parseInt($('.rord').val());

      let uid = $('.uid').val();

      let title = $('.title').val();

      let tcord = parseInt($('.tcord').val());

      let com = parseInt($('.com').val());

      let pcom = parseFloat($('.pcom').val());

      confirm_order(oid, id, uid, tno, title, com, pcom, tcord, noid, trno);

   });

   // end of call confirm order function // 


   // call cancel order function //

   $('body').on('click', '.btn-cancel', function () {

      let oid = $('.oid').val();

      let id = $('.tlvid').val();

      let uid = $('.uid').val();

      let title = $('.title').val();

      cancel_order(oid, id, uid, title);

   });

   // end of call cancel order function // 


   // call hide game function //

   $('body').on('click', '.backk', function () {

      hide_game();

      $('.title').val('');

      $('.noid').val('');

      $('.oid').val('');

      $('.tlvid').val('');

      $('.tord').val('');

      $('.tcord').val('');

      $('.rord').val('');

      $('.camount').html('');

      $('.prcom').html('');

      $('.tcom').html('');

      $('.pcom').val('');

      $('.com').val('');

   });

   // end of call hide game function // 

});

// end of jquery //

      // document add event listner //
      document.addEventListener('DOMContentLoaded', function() {
      let intervalId = null; // Store the interval ID
   
      
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
            } else {
                 thistcoma = '$' + '' + thiscom; 
             }
            $('.tmc').html(thistcoma);
      
      //  Stop the interval check after updating commission
          clearInterval(intervalId);
      }
      
      // get balance function //
      function get_balance(result) {
          let bal = '$' + '' + result;
          $('.bal').html(bal);
          $('.wbal').val(result);
      
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