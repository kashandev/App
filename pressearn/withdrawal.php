<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header // 
if(isset($_SESSION['u_id_pk']) == ''){
echo "<script>location.assign('signin.php')</script>";
}
    $tpmid               = ""; 
    $method              = ""; 
    $channel             = "";
    $sql                 = "";
    $res                 = "";
    $row                 = "";
    $thisid              = "";
    $thismethod          = "";
    $thischannel         = "";
    $thismlabel          = ""; 
    $thisclabel          = ""; 
    $method = '';
   if(isset($_GET['method']) == ''){
    $_GET['method'] = '';
    $method = '';
   }
   
   if(isset($_GET['method'])!=''){
    $method = $_GET['method'];
   }
   
   if($method == '')
   {
    $sql = "SELECT * from topup_method order by tpmid asc limit 1 ";
   }
   
   if($method != '')
   {
    $sql = "SELECT * from topup_method where tpmid = '".$method."' order by tpmid asc ";
   }
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res))
    {
    while($row = mysqli_fetch_array($res))
    {   
    $tpmid  = $row['tpmid'];    
    $method = $row['tpmethod'];
    $channel = $row['tpchannel'];
    $thisid = $tpmid;
    $thismethod = $method;
    $thischannel = $channel;
    $thisclabel = '<h3>Transfer Channel:'.$thischannel.'</h3>';
    $thismlabel = '<h4><b>'.$thischannel.' Top-Up</b></h4>';
   }
   }
   else
   {
     $thismethod = '';
     $thischannel = '';
     $thisclabel = '<h3>Transfer Channel:USDT</h3>';
     $thismlabel = '<h4><b>USDT Top-Up</b></h4>';
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
<title>Withdrawal</title>
<body class="customer">
   <section id="widthdraw">
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-12">
      <div class="servicescontent">
      <h1>Add Withdrawal Method</h1>
      <div class="servicesboxes">
         <div class="container">
            <h1>Identity Information</h1>
            <form method="post" class="withdrawal-form">
               <?php // include variable //
                  include_once("variable/variable.php"); // this is used for include variable //
                    // end of include variable // ?>
               <input class="waid" name="waid" type="hidden">
               <input class="tpmid" name="tpmid" type="hidden">
               <input class="avbal" name="avbal" type="hidden">
               <div class="data-fields">
                  <label for="realname" class="col-sm-2 col-form-label">Real Name</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control realname" name="realname" id="realname" placeholder="Real Name">
                     <div class="error-div">
                        <div class="name-error"></div>
                     </div>
                  </div>
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                     <input type="email" class="form-control email" name="email" id="inputEmail3" placeholder="Email">
                     <div class="error-div">
                        <div class="email-error"></div>
                     </div>
                  </div>
                  <!-- phone -->
                  <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control phone" name="phone" id="phone" placeholder="Phone">
                     <div class="error-div">
                        <div class="phone-error"></div>
                     </div>
                  </div>
                  <label for="address" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control address" name="address" id="address" placeholder="Address">
                     <div class="error-div">
                        <div class="add-error"></div>
                     </div>
                  </div>
               </div>
         </div>
         <div class="container" id="method-div">
         <h1 style="margin-top: 20px !important;">Withdrawal Method information</h1>
         <div class="data-fields">
         <label for="realname" class="col-sm-6 col-form-label">Withdrawal Address or Transaction ID </label>
         <div class="col-sm-10">
         <input type="text" class="form-control txid" id="txid" name="txid" placeholder="Withdrawal Address Transaction ID">
         <div class="error-div"> <div class="txid-error"></div></div>
         </div>
         <label for="inputEmail3" class="col-sm-2 col-form-label">Method</label>
         <div class="col-sm-10">
         <input type="text" class="form-control method" name="method" id="inputEmail3" readonly="" placeholder="Method">
         </div>
         <!-- phone -->
         <label for="phone" class="col-sm-2 col-form-label">USDT-Amount</label>
         <div class="col-sm-10">
         <input type="text" class="form-control withdrawal" name="withdrawal" id="withdrawal" placeholder="USDT-Amount" readonly="">
         <div class="error-div"> <div class="number-error"></div></div>
         <div class="error-div"> <div class="detail-error"></div></div>
         </div>
         </div>
         <h1 style="margin-top: 20px !important; text-align:center !important">Transaction Password</h1>
         <div class="transcationnumbers">
         <input type="text" class="trans p1" readonly="">
         <input type="text" class="trans p2" readonly=""> 
         <input type="text" class="trans p3" readonly="">
         <input type="text" class="trans p4" readonly="">
         <div class="pass-div"> <div class="passcode-error"></div></div>
         </div>
         </div>
      </div>
      <button type="button" class="btn confirm" id="confirm">Confirm</button>
      <div class="msg-div">  
      <label class="success-txt"></label>
      </div>

     <div id="success-d">
      <h5 class="ebay ttxt"></h5>
      <div class="txt">
         <h5 class="htxt"></h5>
      </div>
      <div class="sub-btns">
         <button type="button" class="btn cancel" onclick="hidesuccess()">Close</button>
      </div>
   </div>

      </form>
   </section>
</body>
<?php
   // include footer //
   include_once('foot2.php'); // this is used for include footer //
    // end of include footer // ?>
<script>

// hide success function //
function hidesuccess() {
   $('#success-d').hide();
  } 
// end of hide success function //

    // show success function //
            function show_success(title ='',msg='',icon='')
            {
             var title = title;
             var msg = msg;
             var icon = icon;
             $('.ttxt').html(title);   
             $('.htxt').html(msg +' '+ icon);  
             $('#success-d').show();
            }
       // end of show success function //

   //function disable button //
      function disablebutton()
      {
      $('#confirm').css('background-color','#dee2e6');
      $('#confirm').attr('disabled',true);
      } 
      
    // end of function disable button //
   
     // function disable input //
      function disableinput()
      {
      $('.withdrawal-form').find('input.email').attr('disabled',true);
      $('.withdrawal-form').find('input.phone').attr('disabled',true);
      $('.withdrawal-form').find('input.address').attr('disabled',true);
      $('.data-fields').find('input.txid').attr('disabled',true);
      $('.data-fields').find('input.p1').attr('disabled',true);
      }
     // end of function disable input //
   
   // function enable button //
      function enablebutton()
      {
      $('#confirm').css('background-color','#FF8B02');
      $('#confirm').attr('disabled',false);
      }
   
     // end of function enable button //
   
     // function enable input //
      function enableinput()
      {
      $('.withdrawal-form').find('input.email').attr('disabled',false);
      $('.withdrawal-form').find('input.phone').attr('disabled',false);
      $('.withdrawal-form').find('input.address').attr('disabled',false);
      $('.data-fields').find('input.txid').attr('disabled',true);
      $('.data-fields').find('input.p1').attr('disabled',true);
      }
   
     // end of function enable input //
   
     // function reset form //
      function resetform()
      {
       $('.withdrawal-form').find('input.realname').val('');
       $('.withdrawal-form').find('input.phone').val('');
       $('.withdrawal-form').find('input.email').val('');
       $('.withdrawal-form').find('input.address').val('');
       $('#method-div').find('input.txid').val('');
       $('#method-div').find('input.withdrawal').val('');       
       $('#method-div').find('input').val('');
      }
     // end of function reset form //
   
   
   // function valid number //
   function validnumber(amount='',avbal='')
   {
       var amount = amount;
       var avbal = avbal;
       var thisamount = 0;
       var thisavbal = 0;
       var number = /^[0-9]+$/;
       thisamount = parseInt(amount);
       thisavbal = parseInt(avbal); 
      if(!amount.match(number))
        {
          $('.number-error').html("please enter valid amount of (USDT)!");
         disablebutton();
         $('.p1').attr('readonly',true);
        }else{
   
      if(amount.match(number))
        {
         $('.number-error').html("");
         $('.p1').attr('readonly',false);
        }
     
    if(thisamount > thisavbal){
        $('.number-error').html('Insufficient balance!');
           disablebutton();
           $('.p1').attr('readonly',true);
     }
     else if(thisamount < 10){
         $('.number-error').html('Enter amount between 10-1000!');
         disablebutton();
          $('.p1').attr('readonly',true);  
     }
     else{
       $('.number-error').html("");
       $('.p1').attr('readonly',false);
     }
     }        
   }    
   // end of function valid number //
   
   // function check passcode //
   function checkpasscode(uid='',tpass='')
   {
      var uid = uid;
      var tpass = tpass;
   
         $.ajax({
                url:"check/check-passcode.php",
                type:"post",
                data:{uid : uid,tpass : tpass},
                dataType:"text",
                success:function(result){
                 if(result == 1)
                 {
                  attemptpasscode(uid,tpass);
                 }else{
                  $('.passcode-error').html('Ivalid passcode!');
                  disablebutton(); 
                 }
                }
             });
   
   }    
   // end of function check passcode  //
   
   // function attempt passcode //
   function attemptpasscode(uid='',tpass='')
   {
      var uid = uid;
      var tpass = tpass;
   
         $.ajax({
                url:"attempt/attempt-passcode.php",
                type:"post",
                data:{uid : uid,tpass : tpass},
                dataType:"text",
                success:function(result){
                 if(result == 1)
                 {
                 $('.passcode-error').html('');
                  enablebutton();
                 }else{
                  $('.passcode-error').html('Passcode attempt failed!');
                  disablebutton(); 
                 }
                }
             });
   
   }    
   // end of function attempt passcode  //
   
   // function valid txtid //
   function validtxid(txid='',amount)
   {
      var txid = txid;
      var amount = amount;
      var hash = /\b[^>]*>([\s\S]*?)<\//gm;
      var string = /^[a-zA-Z'-]+$/;
      var number = /^[0-9]+$/;
      $('.withdrawal').attr('readonly',false);
      // if(txid.match(hash) && txid.length!=0)
      //   {
      //    $('.txid-error').html("");
      //      //checktransaction(txid,amount);
      //      // get_deposit(txid,amount);
      //      $('.withdrawal').attr('readonly',false)
      //   } 
      //  else if(txid.match(string) && txid.length !=0)
      //   {
      //    $('.txid-error').html("");
      //      //checktransaction(txid,amount);
      //      // get_deposit(txid,amount);
      //      $('.withdrawal').attr('readonly',false)
      //   }  
      // else if(txid.match(number) && txid.length !=0)
      //   {
      //    $('.txid-error').html("");
      //      //checktransaction(txid,amount);
      //      // get_deposit(txid,amount);
      //      $('.withdrawal').attr('readonly',false)
      //   }       
      //  else
      //   {
      //    $('.txid-error').html("Please enter valid (TXID/HASH) !");
      //    disablebutton();
      //    $('.withdrawal').attr('readonly',true);
      //   }
   }    
   // end of function valid txtid //
   
   
   // function valid text //
   function validtext(val='')
   {
      var val = val;
      var string = /^[a-zA-Z'-]+$/;
      if(val.match(string) && val.length !=0)
        {
           $('.name-error').html("");
           $('.email').attr('disabled',false);
        }  
       else
        {
         $('.name-error').html("Please enter valid name !");
         $('.email').attr('disabled',true);
         disablebutton();
        }
   }    
   // end of function valid text //
   
   // function valid email //
   function validemail(val='')
   {
      var val = val;
      var email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(val.match(email) && val.length !=0)
        {
           $('.email-error').html("");
           $('.phone').attr('disabled',false);
        }  
       else
        {
         $('.email-error').html("Please enter valid name !");
         $('.phone').attr('disabled',true);
         disablebutton();
        }
   }    
   // end of function valid email //
   
   //valid phone function //
   function validphone() {
     var phone = $(".phone").val();
     var contact = /([+]?\d{1,2}[.-\s]?)?(\d{2}[.-]?){3}\d{5}/;
     if (contact.test(phone)) {
       return true;
     } else {
       return false;
     }
   }
   // end of valid phone function //
   
    // get wallet function //
            function get_wallet()
            {
              var id = id;
              var waid= '';
              var waddress = '';
              $.ajax({
                url:"get/get-wallet.php",
                type:"post",
                dataType:"json",
                success:function(result){
                   waid = result.waid;
                   wadd = result.waddress;
                   if(waid == ''){
                     $('.detail-error').html('You can`t be withdrawal without wallet address!');
                     $('input.realname').attr('disabled',true);
                     $('.method').val('');
                   }else{
                    $('.waid').val(waid);
                    $('input.realname').attr('disabled',false);
                    get_method(wadd);
                  }
   
                }
             });
            }
            // end of get wallet function //
      
   
    // get method function //
            function get_method(waddress='')
            {
              var waddress = waddress;
              $.ajax({
                url:"get/get-method.php",
                type:"post",
                data:{waddress : waddress},
                dataType:"json",
                success:function(result){
                 if(result!=''){
                   $('.tpmid').val(result.tmpid);
                   $('.method').val(result.method);
                   $('.withdrawal').attr('disabled',false);
                   $('.detail-error').html('');
                 }else{
                   $('.tpmid').val('');
                   $('.method').val('');
   
                 }
                }
             });
            }
            // end of get method function //
   
    // get balance function //
            function get_balance()
            {
              var uid = $('.uid').val();
              var bal = '';
              $.ajax({
                url:"get/get-balance.php",
                type:"post",
                data:{uid : uid},
                dataType:"html",
                success:function(result){
                 bal = parseInt(result)
                 $('.avbal').val(bal);    
                }
             });
            }
            // end of get balance function //
   
   
   //save function //
         function save(data='')
          {
           var data = data;
           var title = '';
           var msg = '';
           var icon = '';
           $.ajax({
             url:"insert/save-withdrawal.php",
             method:"post",
             data:data,
             dataType:"json",
             beforeSend:function(){
              disablebutton();
             },
             success:function(result){
             title = 'Withdrawal';  
             msg = result.msg;
             icon = '<i class="fa fa-check" aria-hidden="true" id="icon-s"></i>';
              if(msg!='Failed')
              {   
               setTimeout(function(){
               disablebutton();
               disableinput();
               show_success(title,msg,icon);
               resetform();
               get_wallet();
              },400);
               setTimeout(function(){
                hidesuccess();
              },3000);
             }
         }
           });
         }
         //end of save function //
   
   
   setInterval(get_balance,100);
   setInterval(get_wallet,100);
   
   // start jquery //
   $(document).ready(function(){
   
    disablebutton();
    disableinput();
   
   // call valid txid function //
   $('.txid').on('keyup', function(){
    var txid = $('.txid').val();
    var withdrawal = $('.withdrawal').val();
    if(txid == ''){
     disablebutton();
     $('.txid-error').html("");
     $('.method').val('');
     $('.withdrawal').val('');
     $('.number-error').html('');
     $('.detail-error').html('');
     $('.p1').attr('readonly',true);
    }else{
     validtxid(txid,withdrawal);
    }
   });
   // end of call valid txid function //
   
   // call valid number function //
   $('.withdrawal').on('keyup', function(){
     var withdrawal = $('.withdrawal').val();
     var avbal = $('.avbal').val();
     
    if(withdrawal == ''){
     disablebutton();
     $('.withdrawal').val('');
     $('.number-error').html("");
     $('.p1').attr('readonly',true);
    }else{
     validnumber(withdrawal,avbal);
    }
   });
   // end of call valid number function //
   
   // set variables //
   p1 = 0;
   p2 = 0;
   p3 = 0;
   p4 = 0;
   var thistpass = '';
   // end of set variables //
   // set passcode function //
   $(".p1").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
     uid = $('.uid').val();
     $('.p2').attr('readonly',false);
     if(p1 == ''){
       $('.p2').attr('readonly',true);
       thistpass = parseInt(p1-p2-p3-p4);
     }else{
     thistpass = parseInt(p1+p2+p3+p4);
       $('.p2').focus();
     }
   });
   $(".p2").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
     uid = $('.uid').val();
     $('.p3').focus();
     $('.p3').attr('readonly',false);
     if(p2 == ''){
       $('.p1').focus();
       $('.p3').attr('readonly',true);
       thistpass = parseInt(p1-p2-p3-p4);
     }else{
     thistpass = parseInt(p1+p2+p3+p4);
     }
   
   });
   $(".p3").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
     uid = $('.uid').val();
     $('.p4').focus();
     $('.p4').attr('readonly',false);
     if(p3 == ''){
       $('.p2').focus();
       $('.p4').attr('readonly',true);
     }else{
     thistpass = parseInt(p1+p2+p3+p4);
     }
   });
   
   // call check passcode function //
   $(".p4").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
     uid = $('.uid').val();
     if(p4 == ''){
       $('.p3').focus();
       thistpass = parseInt(p1+p2+p3-p4);
       $('.passcode-error').html('');
       disablebutton();
     }else{
      thistpass = parseInt(p1+p2+p3+p4);
      checkpasscode(uid,thistpass);
   
     }
   });// end of call check passcode function //
   // end of set passcode function //
   
   // check valid text function //
   $(".realname").on("keyup", function (e) {
   var realname = $('.realname').val();
   if(realname == '')
   {
   $('.name-error').html('');
   $('.email').attr('disabled',true);
   disablebutton();
   }else
   {
   if(realname!=''){
     validtext(realname);
   }
   }
   });
   // end of check valid text function //
   
   
   // check valid email function //
   $(".email").on("keyup", function (e) {
   var email = $('.email').val();
   if(email == '')
   {
   $('.email-error').html('');
   $('.phone').attr('disabled',true);
   disablebutton();
   }else
   {
   if(email!=''){
     validemail(email);
   }
   }
   });
     // end of check valid email function //
   
   
     // check valid phone function //  
     $(".phone").on('keyup', function() {
       var phone = $(".phone").val();
       if (phone == "") {
         $('.phone-error').html("");
         $('.address').attr('disabled',true);
         disablebutton();
       } else {
         if (validphone('phone')) {
             $('.phone-error').html("");
             $('.address').attr('disabled',false);
         } else {
           $('.phone-error').html("Invalid Contact");
           $('.address').attr('disabled',true);
            disablebutton();
         }
       }
     });
     // end of check valid phone function //  
   
   
   
     // reset function //  
     $(".address").on('keyup', function() {
       var address = $(".address").val();
       if (address == "") {
         $('.txid').attr('disabled',true);
         disablebutton();
       }else{
          $('.txid').attr('disabled',false);
       }
     });
     // end of reset function //  
   
           // call save function on click //
           $('body').on('click','.confirm',function(){
           var data = '';
           data = $('.withdrawal-form').serialize();
           realname = $('.realname').val();
           email = $('.email').val();
           phone = $('.phone').val();
           txid = $('.txid').val();
           withdrawal = $('.withdrawal').val();
           if(realname == ''){
            $('.txid-error').html('Name can`t be empty!');
           }
           if(phone == ''){
            $('.txid-error').html('Phone number can`t be empty!');
           }
           if(txid == ''){
            $('.txid-error').html('Transaction (txid) can`t be empty!');
           }
           if(withdrawal == ''){
            $('.number-error').html('USDT can`t be empty!');
           }
          else if(realname == ''){
            $('.txid-error').html('Name can`t be empty!');
           }
          else if(phone == ''){
            $('.txid-error').html('Phone number can`t be empty!');
           }
          else if(txid == ''){
            $('.txid-error').html('Transaction (txid) can`t be empty!');
           }
          else if(withdrawal == ''){
            $('.number-error').html('USDT can`t be empty!');
           } 
           else{
             save(data);
           }
     
         });
       // end of call save function on click //
   
   
   });
   
   // end of jquery //
</script>