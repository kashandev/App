<?php
   // signup //
      // include header //
      include_once('header.php'); // this is used for include header //
       // end of include header // 
   
   // include conn //
   include_once('conn/conn.php'); // this is used for include conn //
   // end of include conn //
   
   ?>
<?php
   if (isset($_GET['referCode']) == "") {
      $_GET['referCode'] =  "";
      $msg ='';
    }
   
   if (isset($_GET['referCode'])) {
       
       // initializing variables//
       $referCode           = $_GET['referCode'];
       $invcode             = ""; 
       $thiscode            = "";
       $sql                 = "";
       $res                 = "";
       $row                 = "";
       $msg                 = "";
       // end of initializing variables//
       
       $sql = "SELECT invcode as invc from user_invitation_code where invcode = '" . $referCode . "' ";
       $res = mysqli_query($conn, $sql);
       if($row = mysqli_fetch_array($res))
       {   
       $invcode = $row['invc'];
       $thiscode = $invcode;
       $msg = '';
      }
      else
      {
        $thiscode = $referCode;
        $invcode = '';
        $msg = '';
      }
   }
   
   ?>    
<link rel="stylesheet" href="css/form.css">
<title>Pressearn Register Account</title>
<body>
   <!-- Form start here  -->
   <!-- _________________________ -->
   <!-- _________________________ -->
   <section id="forms">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="registerContent">
                  <div class="registerLogo"><img src="images/logo2.png" alt=""></div>
                  <p class="registerTitle">Welcome to register</p>
                  <div class="form-group">
                     <div class="success-box">  
                        <label class="register-success"></label>
                     </div>
                     <div class="error-box">  
                        <label class="register-error"></label>
                        <label class="error-uname"></label>
                        <label class="error-pass"></label>
                        <label class="error-cpass"></label>
                        <label class="error-refcode"></label>
                        <label class="error-phone"></label>
                        <label class="error-captcha"></label>
                        <label class="error-tpass"></label>
                     </div>
                  </div>
                  <div>
                     <form method="post" class="regform">
                        <div class="wirteInput">
                           <div class="inputFirst"><span class="inputFirst_icon"><i class='fas fa-user-alt'></i></span></div>
                           <input type="hidden" class="invcid" name="invcid">
                           <input type="hidden" class="limit" name="limit">
                           <input type="hidden" class="used" name="used">
                           <input type="hidden" class="remain" name="remain">
                           <input placeholder="Create a Username" type="text" class="username" name="username" >
                        </div>
                  </div>
                  <div>
                  <div class="wirteInput">
                  <div class="inputFirst"><span class="inputFirst_icon"><i class="fa fa-lock"></i></span></div>
                  <input placeholder="Create a Password" type="password" class="password" name="password">
                  </div>
                  </div>
                  <div>
                  <div class="wirteInput">
                  <div class="inputFirst"><span class="inputFirst_icon"><i class="fa fa-lock"></i></span></div>
                  <input placeholder="Confirm your password" type="password" class="cpassword" name="cpassword">
                  </div>
                  </div>
                  <div>
                  <div class="wirteInput">
                  <div class="inputFirst"><span class="inputFirst_icon"><i class="fa fa-share-alt"></i></span></div>
                  <input placeholder="Enter the invitation code" readonly="" type="text" class="refcode" name="refcode" value="<?php echo $thiscode ?>">
                  </div>
                  </div>
                  <div>
                  <div class="wirteInput">
                  <div class="inputFirst"><span class="inputFirst_icon"></span>
                  </div>
                  <input name="mobile" class="mobile" type="hidden">
                  <input name="ccode" class="ccode" type="hidden">
                  <input name="ctitle" class="ctitle" type="hidden">
                  <input name="country" class="country" type="hidden">
                  <input id="phone" name="phone" class="phone" type="tel">
                  </div>
                  </div>
                  <div>
                  <!---->
                  </div>
                  <div class="wirteInput wirteInput2">
                  <div class="inputFirst"><span class="inputFirst_icon"><i class='fas fa-shield-alt'></i></span></div>
                  <!----><!---->
                  <div class="codeDiv"></div>
                  <input placeholder="Captcha" type="text" class="captcha" name="captcha" readonly="">
                  </div>
                  <div class="codeDiv1">
                  <input type="text" class="generate-captcha">
                  <input type="hidden" class="generate-captcha-code" name="capcode">
                  </div>
                  <div class="maincon">
                  <h1>Set Transaction Password</h1>
                  <div class="row">
                  <div class="col-md-3 col-sm-3 mycol">
                  <div class="confirmation">
                  <input type="password" maxlength="1" class="p1" readonly="">
                  </div>
                  </div>
                  <div class="col-md-3 col-sm-3 mycol">
                  <div class="confirmation">
                  <input type="password" maxlength="1" class="p2" readonly="">
                  </div>
                  </div>
                  <div class="col-md-3 col-sm-3 mycol">
                  <div class="confirmation">
                  <input type="password" maxlength="1" class="p3" readonly="" >
                  </div></div>
                  <div class="col-md-3 col-sm-3 mycol">
                  <div class="confirmation">
                  <input type="password" maxlength="1" class="p4" readonly="">
                  </div>
                  <input type="hidden" class="tpass" name="tpass">
                  </div>
                  </div>
                  </div>
                  <button type="button" class="sumbitBtn" id="regBtn"> Register now </button>
                  <a href="signin.php" type="button" class="btnopen"> <i class="fas fa-sign-in-alt"> </i> Already have a account ? login here </a>
                  <br>
                  <a href="index.php?pageid=home" type="button" class="btnopen"> <i class="fa fa-arrow-left"> </i> Back to home page  </a>
               </div>
            </div>
            </form>
         </div>
      </div>
      </div>
   </section>
</body>
<?php
   // include login footer //
   include_once('login-footer.php'); // this is used for include login footer //
    // end of include login footer // ?>
<script type="text/javascript">
   //function disable button //
      function disableregbutton()
      {
      $('#regBtn').css('background-color','#dee2e6');
      $('#regBtn').removeClass('sumbitBtn');
      $('#regBtn').attr('disabled',true);
      } 
      
    // end of function disable button //
   
   // function enable button //
      function enableregbutton()
      {
      $('#regBtn').css('background-color','#000');
      $('#regBtn').addClass('sumbitBtn');
      $('#regBtn').attr('disabled',false);
      }
   
     // end of function enable button //
   
      // function reset form //
      function resetform()
      {
       $('.regform').trigger('reset');      
      }
     // end of function reset form //
   
   
       // count limit function //
         function count_limit(refcode = '')
         {
           var refcode = refcode;
           var invcid = '';
           var limit = '';
           var used = '';
           var remain = '';
           $.ajax({
             url:"count/count-limit.php",
             type:"post",
             data:{refcode : refcode},
             dataType:"json",
   
             success:function(result){
              invcid = result.invcid;
              $('.invcid').val(invcid);
   
            }
           
          });
         }
      
         // end of count limit function //
   
   
   // // check limit function //
   //       function check_limit(refcode = '')
   //       {
   //         var refcode = refcode;
   //         var msg = '';
   //         if(refcode!='')
   //         {
   //         $.ajax({
   //           url:"check/check-limit.php",
   //           type:"post",
   //           data:{refcode : refcode},
   //           dataType:"text",
   //           success:function(result){ 
   //           if(result == false)
   //           { 
   //             $('.register-error').html(msg); 
   //            $('.username').attr('readonly',false);
   //            $('.phone').attr('readonly',false);
   //            count_limit(refcode);
   //            disableregbutton();
   //           }
   //           if(result == true)
   //           {
   //            msg = 'This invitation code has been expired!';     
   //            disableregbutton();
   //            $('.username').attr('readonly',true);
   //            $('.register-error').html(msg);
   //            $('.phone').attr('readonly',true);
   //          }
   //           }
   //        });
   //       }
   //       }
      
   //       // end of check limit function //
   
   
   // check code function //
         function check_code(refcode = '')
         {
           var refcode = refcode;
           var thiscode = '<?php echo $thiscode?>';
           var msg = '';
           if(refcode!='')
           {
           $.ajax({
             url:"check/check-code.php",
             type:"post",
             data:{refcode : refcode},
             dataType:"text",
             success:function(result){ 
   
              if(result == 1)
              {
               $('.register-error').html(''); 
               $('.username').attr('readonly',false);
               $('.phone').attr('readonly',false);
               count_limit(refcode)
              disableregbutton();
              if(thiscode!=''){
               $('.refcode').focus();
              }else{
               $('.phone').focus();
              }
             }else{
              msg = 'there is no invitation code found of ' + '' + refcode;    
              disableregbutton();
              //$('.refcode').focus();
              $('.username').attr('readonly',true);
              $('.register-error').html(msg);
              $('.phone').attr('readonly',true);
              $('.captcha').attr('readonly',true);
              $('.invcid').val('');
              $('.limit').val('');
              $('.used').val('');
              $('.remain').val(''); 
             }
   
             }
          });
         }
         }
      
         // end of check code function //
   
         // set code function //
         function set_code()
         {
           var defaultcode = '';
           var urlcode = '';
           var thisrefcode = '';
            urlcode = '<?php echo $thiscode?>';
           $.ajax({
             url:"get/set-code.php",
             type:"post",
             dataType:"html",
             success:function(result){ 
               defaultcode = result;
               if(defaultcode == '')
               {
                 thisrefcode = urlcode;
               }
               else
               {
                 thisrefcode = defaultcode;
               }
               $('.refcode').val(thisrefcode);       
             }
          });
         }
         // end of set code function //
         
         // check user function //
         function check_user(username='',refcode = '')
         {
           var username = username;
           var refcode = refcode;
           var msg = '';
           var name = '';
           $.ajax({
             url:"check/check-user.php",
             type:"post",
             data:{username : username},
             dataType:"TEXT",
             beforeSend:function(){
               msg = '';
               disableregbutton();
              $('.register-error').html(msg);
   
             },
             success:function(result){
   
              setTimeout(function(){
   
              if(result == false){
                msg = username + " " + 'already registered try different!';
               disableregbutton();
               $('.register-error').html(msg);
               $('.password').attr('readonly',true);
               $('.cpassword').attr('readonly',true);
               $('.password').focus();
               $('.refcode').attr('readonly',true);
              }else{
               msg = '';
               disableregbutton();
               $('.register-error').html(msg); 
               if(refcode!=''){
               $('.refcode').attr('readonly',true);
               }else{
               $('.refcode').attr('readonly',false);
               }
               
              }
             },200)
          }
          });
         }
      
         // end of check user function //
   
     // generate captcha function //
         function generate_captcha()
         {
         
           $.ajax({
             url:"generate/generate-captcha.php",
             type:"post",
             success:function(result){
               $('.generate-captcha').val(result);
               $('.generate-captcha-code').val(result)
            }
         
          });
         }
         // end of generate captcha function //
   
   
   // verify captcha function //
         function  verify_captcha(captcha = '',generate_captcha ='')
         {
           var captcha = captcha;
           var generate_captcha = generate_captcha;
           var msg = '<?php echo $msg ?>';
           if(msg!=''){
             disableregbutton();
             $('.p1').attr('readonly',true);
           }else{ 
           if(captcha == '')
           { 
             $('.error-captcha').html('');
             $('.error-phone').html('');
             $('.p1').attr('readonly',true);
           }else
           {  
             $('.error-captcha').html('');
           if(captcha == generate_captcha)
           { 
             $('.error-captcha').html('');
             $('.error-phone').html('');
             $('.p1').attr('readonly',false);
             $('.p1').focus();
           }else{
             $('.error-captcha').html('oops invalid captcha!');
             disableregbutton();
             $('.p1').attr('readonly',true);
           }
           }
         }
         }
         // end of verify captcha function //
   
   //save function //
         function save(data='',refcode='')
          {
           var data = data;
           var refcode = refcode;
           var msg = '';
           var loginurl = '';
   
           $.ajax({
             url:"insert/insert.php",
             method:"post",
             data:data,
             dataType:"json",
             beforeSend:function(){
             disableregbutton();
             },
             success:function(result){ 
             msg = result.msg;
             loginurl = result.loginurl;
             if(msg!='Failed')
             {   
               setTimeout(function(){
               enableregbutton();
               $('.register-success').html(msg)
               generate_captcha();
               reset_country_code();
               resetform(); 
               $('.mobile').val('');
               $('.ccode').val('');
               $('.ctitle').val('');
               $('.country').val('');
             },400);
               setTimeout(function() {
                  window.location.href = loginurl;
             }, 1000);
             }    
         }
           });
         }
         //end of save function //
   
   
     // generate country code function //
   
      function generate_country_code(){
          var phoneInput = $("#phone").intlTelInput({
             utilsScript: "js/utils.js",
             initialCountry:"",
             formatOnDisplay:true,
             placeholderNumberType:"MOBILE",
             allowDropdown:true
   
           }); 
      }
     // end of generate country code function //
   
    // reset country code function //
     function reset_country_code(){
     $("#phone").intlTelInput("setCountry", "us");
     $('#phone').val( "" );
     $('#phone').attr( "placeholder", "(201) 555-0123" );
     }
     //  reset of generate country code function //
   
     // start jquery //
     $(document).ready(function() {
   
       set_code();
   
         generate_country_code();
         var refcode = $('.refcode').val();
         if(refcode == ''){
          disableregbutton();
         }else{
           disableregbutton();
           check_code(refcode) 
         }
       
       // call generate captcha function //
        generate_captcha();
    
    // execute country code function //
   
    // call generate captcha function on click//
   $(".generate-captcha").click(function(e) {
     generate_captcha()
   });
    // end of call generate captcha function on click//
   
    // set country code with country function on change//
   $("#phone").on("countrychange", function (e) {
        e.preventDefault();
      var ccode = '';
      var ctitle = '';
      var country = '';   
      ccode = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
      ctitle = $("#phone").intlTelInput("getSelectedCountryData").iso2;
      country = $("#phone").intlTelInput("getSelectedCountryData").name;
      $('.ccode').val(ccode);
      $('.ctitle').val(ctitle);
      $('.country').val(country);
   });
    // end of set country code with country function on change//
   
    // valid phone function //
   $("#phone").on("keyup", function (e) {
      e.preventDefault();
      var ccode = '';
      var ctitle = '';
      var country = '';
      var phone = '';
      var number = '';
   
       ccode = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
       ctitle = $("#phone").intlTelInput("getSelectedCountryData").iso2;
       country = $("#phone").intlTelInput("getSelectedCountryData").name;
       phone = $("#phone").intlTelInput("getNumber");
      if(phone == '')
       {
       $('.ccode').val('');
       $('.ctitle').val('');
       $('.country').val('');
       $('.mobile').val('');
       $('.error-phone').html('');
       $('.captcha').attr('readonly',true);
       $('.phone').focus();
       }else{
       if($("#phone").intlTelInput("isValidNumber")) {
       $('.error-phone').html("");
       $('.ccode').val(ccode);
       $('.ctitle').val(ctitle);
       $('.mobile').val(phone);
       $('.country').val(country);
       $('.captcha').attr('readonly',false);
       $('.captcha').focus();
     }else{
       $('.error-phone').html("Not a valid number ");
       $('.ccode').val('');
       $('.ctitle').val('');
       $('.country').val('');
       $('.mobile').val('');
       $('.captcha').attr('readonly',false);
       $('.phone').focus();
     }
   }
   });
    // end of valid phone function //
   
     // verify captcha function //
   $(".captcha").on("keyup", function (e) {
   var captcha = $('.captcha').val();
   var generate_captcha = $('.generate-captcha').val();
   if(captcha == ''){
   $('.error-captcha').html('');
   $('.p1').attr('readonly',true);
   }else{
   verify_captcha(captcha,generate_captcha);   
   }
   });
   // end of verify captcha function //
   
   
     // check code function on keyup //
   $(".refcode").on("keyup", function (e) {
   var refcode = $('.refcode').val();
   if(refcode == ''){
   $('.register-error').html('');
   $('.invcid').val('');
   $('.limit').val('');
   $('.used').val('');
   $('.remain').val(''); 
   $('.phone').attr('readonly',true);
   }else{
     check_code(refcode);
   }
   });
   // end of code function on keyup //
   
   
   // check username function //
   $(".username").on("keyup", function (e) {
   var username = $('.username').val();
   var refcode = $('.refcode').val();
   if(username == '')
   {
   $('.error-cpass').html('');
   $('.password').attr('readonly',true);
   $('.refcode').attr('readonly',false);
   }else
   {
   if(username!=''){
     check_user(username,refcode);
   $('.error-cpass').html('');
   $('.password').attr('readonly',false);
   }
   
   }
   });
     // end of check username function //
   
     // check password function //
   $(".password").on("keyup", function (e) {
   var password = $('.password').val();
   if(password == '')
   {
   $('.error-pass').html('');
   $('.error-cpass').html('');
   $('.cpassword').attr('readonly',true);
   $('.refcode').attr('readonly',true);
   }else
   {
   if(password.length < 7){
   $('.error-pass').html('password should be at least 7 characters!');
   $('.error-cpass').html('');
   $('.cpassword').attr('readonly',true);
   $('.refcode').attr('readonly',true);
   $('.password').focus();
   }else{
   $('.error-pass').html('');
   $('.error-cpass').html('');
   $('.cpassword').attr('readonly',false);
   $('.refcode').attr('readonly',false);
   $('.cpassword').focus();
   }
   }
   });
     // end of check password function //
   
   // check confirm password function //
   $(".cpassword").on("keyup", function (e) {
   var password = $('.password').val();
   var cpassword = $('.cpassword').val();
   var refcode = $('.refcode').val();
   if(password == '' || cpassword == '')
   {
   $('.error-cpass').html('');
   $('.error-pass').html('');
   $('.phone').attr('readonly',true);
   $('.refcode').attr('readonly',true);
   $('.cpassword').focus();
   }else
   {
   if(cpassword == password && refcode == ''){
   $('.error-cpass').html('');
   $('.error-pass').html('');
   $('.refcode').attr('readonly',false);
   $('.refcode').focus();
   }
   else if(cpassword == password && refcode!=''){
   $('.error-cpass').html('');
   $('.error-pass').html('');
   $('.phone').attr('readonly',false);
   $('.phone').focus();
   }
   else{
    $('.error-cpass').html('confirm password not match!');
    $('.error-pass').html('');
    $('.phone').attr('readonly',true);
    $('.refcode').attr('readonly',true);
   }
    }
   });
   // end of check confirm password function //
   
   
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
     $('.p2').attr('readonly',false);
     if(p1 == ''){
       $('.p2').attr('readonly',true);
       thistpass = parseInt(p1-p2-p3-p4);
       if(thistpass == 0){
       $('.tpass').val('');
       }else{
       $('.tpass').val(thistpass);
     }
     }else{
     thistpass = parseInt(p1+p2+p3+p4);
     $('.tpass').val(thistpass);
       $('.p2').focus();
     }
   });
   $(".p2").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
     $('.p3').focus();
     $('.p3').attr('readonly',false);
     if(p2 == ''){
       $('.p1').focus();
       $('.p3').attr('readonly',true);
       thistpass = parseInt(p1-p2-p3-p4);
       $('.tpass').val(thistpass);
     }else{
     thistpass = parseInt(p1+p2+p3+p4);
     $('.tpass').val(thistpass);
     }
   
   });
   $(".p3").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
     $('.p4').focus();
     $('.p4').attr('readonly',false);
     if(p3 == ''){
       $('.p2').focus();
       $('.p4').attr('readonly',true);
       thistpass = parseInt(p1+p2-p3-p4);
       $('.tpass').val(thistpass);
     }else{
     thistpass = parseInt(p1+p2+p3+p4);
     $('.tpass').val(thistpass);
     }
   });
   
   $(".p4").on("keyup", function (e) {
     p1 = $('.p1').val();
     p2 = $('.p2').val();
     p3 = $('.p3').val();
     p4 = $('.p4').val();
   
     if(p4 == ''){
       $('.p3').focus();
       thistpass = parseInt(p1+p2+p3-p4);
       $('.tpass').val(thistpass);
       disableregbutton();
      }else{
      thistpass = parseInt(p1+p2+p3+p4);
      $('.tpass').val(thistpass);
      enableregbutton();
     }
   });
   // end of set passcode function //
   
      // login on key press function //
      $(document).keypress(function(e) {
      
           var msg = '';
           var refcode = '';
           var loginurl = '';
           refcode = $('.refcode').val();
           data = $('.regform').serialize();
   
            if (e.which == 13) {
            $.ajax({
              url:"insert/insert.php",
              method:"post",
              data: $("form").serialize(),
              dataType: "json",
             beforeSend: function(){
             disableregbutton();
             },
             success: function(result){ 
             msg = result.msg;
             loginurl = result.loginurl;
             if(msg!='Failed')
              {   
               setTimeout(function(){
               enableregbutton();
               $('.register-success').html(msg)
               generate_captcha();
               reset_country_code();
               resetform();
               $('.mobile').val('');
               $('.ccode').val('');
               $('.ctitle').val('');
               $('.country').val('');
             },400);
              setTimeout(function() {
                  window.location.href = loginurl;
             },1000);   
             }
           }
          });
         }
        });
         // end of login on key press function //
   
           // call save function on click //
           $('body').on('click','.sumbitBtn',function(){
           var data = '';
           var refcode = '';
           data = $('.regform').serialize();
           refcode = $('.refcode').val();
           var username = $('.username').val();
           var password = $('.password').val();
           var cpassword = $('.cpassword').val();
           var refcode = $('.refcode').val();
           var phone = $('.phone').val();
           var captcha = $('.captcha').val();
           var p1 = $('.p1').val();
   
           if(username == ''){
            $('.error-uname').html('username can`t be empty');
           } 
           if(password == ''){
            $('.error-pass').html('password can`t be empty');
           } 
           if(cpassword == ''){
            $('.error-cpass').html('confirm password can`t be empty');
           } 
           if(refcode == ''){
            $('.error-refcode').html('refcode can`t be empty');
           } 
           if(refcode == ''){
            $('.error-phone').html('phone number can`t be empty');
           }  
           if(captcha == ''){
            $('.error-refcode').html('captcha can`t be empty');
           }   
           if(p1 == ''){
            $('.error-tpass').html('transaction password can`t be empty');
           }else{
            save(data,refcode);
           }   
         });
       // end of call save function on click //
   });
   // end of jquery //
</script>