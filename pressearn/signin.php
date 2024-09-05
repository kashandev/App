<?php
   // include header //
include_once('header.php'); // this is used for include header //
    // end of include header // 
// include get code //
include_once('get/get-code.php'); // this is used for include get code //
    // end of includeget code //
?>
       <link rel="stylesheet" href="css/form.css">
<title>Pressearn Signin</title>

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
                  <p class="registerTitle">Welcome to Login</p>
                  <div class="form-group">
                     <div class="success-box">  
                        <label class="login-success"></label>
                     </div>
                     <div class="error-box">  
                        <label class="login-error"></label>
                     </div>
                  </div>
                  <form method="post" class="loginform">
                     <div class="wirteInput">
                        <div class="inputFirst"><span class="inputFirst_icon"><i class='fas fa-user-alt'></i></span></div>
                        <!----><!----><!----><input placeholder="Username" autocomplete="off" type="text" class="uname" name="uname">
                     </div>
                     <div class="wirteInput">
                        <div class="inputFirst"><span class="inputFirst_icon"><i class="fa fa-lock"></i></span></div>
                        <!----><!----><!----><input placeholder="Password" autocomplete="off" type="password" class="upass" name="upass" >
                     </div>
                     <button type="button" class="loginBtn btn-login" id="loginBtn"> Login </button>
                     <a href="signup.php" type="button" class="btnopen"> <i class="fa fa-user"> </i> Don`t have a account ? register here </a>
                     <br>
                      <a href="index.php?pageid=home" type="button" class="btnopen"> <i class="fa fa-arrow-left"> </i> Back to home page  </a>
                  </form>
               </div>
               <!---->
            </div>
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
   
     function disablelogbutton()
      {
      $('#loginBtn').css('background-color','#dee2e6');
      $('#loginBtn').removeClass('loginBtn');
      $('#loginBtn').attr('disabled',true);
      }  
      
    // end of function disable button //
   
   // function enable button //
   
      function enablelogbutton()
      {
      $('#loginBtn').css('background-color','#000');
      $('#loginBtn').addClass('loginBtn');
      $('#loginBtn').attr('disabled',false);
      }  
      
     // end of function enable button //
  
   
     // count user function //
         function count_user()
         {
           var msg = '';
           $.ajax({
             url:"count/count-user.php",
             type:"post",
             dataType:"TEXT",
             beforeSend:function(){
             msg = '';
             disablelogbutton();
             $('.login-error').html(msg);
             },
             success:function(result){
             setTimeout(function(){
             if(result == 1){
              msg = '';
              enablelogbutton();
              $('input').attr('readonly',false);
              $('.login-error').html(msg);
             }if(result == 0){
             msg = 'please register your account!';
             disablelogbutton();
              $('input').attr('readonly',true);
             $('.login-error').html(msg); 
           }
          },200)
              }
          });
         }
      
         // end of count user function //
   
   
     // start jquery //
     $(document).ready(function() {
   
     // call count user function //
       count_user();
   
   // count user function //
   $(".uname").on("keyup", function (e) {
   enablelogbutton();

   });
     // end of count user function //
   
     // reset password function //
   $(".upass").on("keyup", function (e) {
   var password = $('.upass').val();
   if(password == '')
   {
   enablelogbutton();
   }
   });
   
   // login on key press function //
   $(document).keypress(function(e) {
   
       var login = '';
       var loginurl = '';
       if (e.which == 13) {
         $.ajax({
           url:"login/login.php",
           method:"post",
           data: $("form").serialize(),
           dataType: "json",
           beforeSend: function() {
           disablelogbutton();
           $('.login-error').html('');
           },
           success: function(response) {
   
             login = response.login;
             loginurl = response.loginurl;
             if (login == 1) {
               setTimeout(function() {
                 enablelogbutton();
                 $('.login-success').html(response.success_message);
                 $('.login-error').html('');
               }, 400);
               setTimeout(function() {
                 window.location.href = loginurl;
               }, 1000);
             } else if (login == 2) {
               disablelogbutton();
               $('.login-error').html(response.error_message);
             } else if (login == 3) {
               disablelogbutton();
                $('.login-error').html(response.error_message);
             } else if (login == 0) {
               disablelogbutton();
               $('.login-error').html(response.error_message);
             }
           }
         });
       }
     });
      // end of login on key press function //
      
      // login on click function //
     $('body').on('click','.btn-login', function() {
       var uname = $('.uname').val();
       var upass = $('.upass').val();
       var data = $('.loginform').serialize();
       var login = '';
       var loginurl = '';
      if (uname == "" && upass == '') {
         $('.login-error').html("You must specify a username & password to login");
      }
     
     else if (uname == "") {
         $('.login-error').html("username can`t be empty");
      }  
      
      else if (upass == "") {
         $('.login-error').html("password can`t be empty");
      } 
      else {
         $.ajax({
          url:"login/login.php",
          method:"post",
          data:data,
          dataType: "json",
          beforeSend: function() {
            disablelogbutton();
          $('.login-error').html('');
          },
          success: function(response) {
   
             login = response.login;
             loginurl = response.loginurl;
             if (login == 1) {
              setTimeout(function() {
                 enablelogbutton();
                 $('.login-success').html(response.success_message);
                 $('.login-error').html('');
              }, 400);
              setTimeout(function() {
                 window.location.href = loginurl;
              }, 1000);
             } else if (login == 2) {
              disablelogbutton();
              $('.login-error').html(response.error_message);
   
             } else if (login == 3) {
              disablelogbutton();
              $('.login-error').html(response.error_message);
             }
            else if (login == 0) {
              disablelogbutton();
              $('.login-error').html(response.error_message);
             }
          }
         });
      }
     });
    // end of login on click function //  
   });
  // end of jquery //    
</script>