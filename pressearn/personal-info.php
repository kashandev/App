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
<title>Personal Info</title>
<body class="customer">

<section id="widthdraw">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <div class="servicescontent">
<h1>PERSONAL INFO</h1>
<div class="servicesboxes">
<div class="container">

<form method="post" role="form" class="user-form">
   <?php // include variable //
  include_once("variable/variable.php"); // this is used for include variable //
 // end of include variable // ?>
  <div class="data-fields">
  <label for="realname" class="col-sm-2 col-form-label">Account Holder</label>
    <div class="col-sm-10">
      <input type="text" class="form-control uname" id="name" name="name" placeholder="Account Holder" readonly>
    </div>
    <!-- phone -->
    <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
    <div class="col-sm-10">
      <input type="text" class="form-control phone" id="phone" placeholder="Phone Number" name="phone" readonly>
    </div>
  </div>
  </div>
  <div class="container">
<h1 style="margin-top: 20px !important;">Change login password</h1>
  <div class="data-fields">
  <label for="oldpass" class="col-sm-4 col-form-label">Current Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control oldpass" id="oldpass" name="oldpass" placeholder="Current Password">
      <div class="error-div"><div class="pass-error"></div></div>  
    </div>
  <label for="newpass" class="col-sm-4 col-form-label">New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control newpass" id="newpass" name="newpass" placeholder="New Password" disabled="">
    </div>
    <!-- phone -->
    <label for="cpass" class="col-sm-4 col-form-label">Retype new password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control cpass" id="cpass" name="cpass" placeholder="Retype New Password" disabled="">
      <div class="error-div"> <div class="cpass-error"></div></div>
    </div>
  </div>
  <h1 style="margin-top: 20px !important; text-align:center !important">Transaction Password</h1>
  <div class="transcationnumbers">
  <input type="text" class="trans p1" readonly="">
  <input type="text" class="trans p2" readonly=""> 
  <input type="text" class="trans p3" readonly="">
  <input type="text" class="trans p4" readonly="">
  <input type="hidden" class="tpass" name="tpass">
  <div class="pass-div"> <div class="passcode-error"></div></div>
  </div>
</div>
</div>
<button type="button" class="btn confirm btn-save" id="confirm">SAVE</button>
<div class="msg-div">  
<label class="success-txt"></label>
</div>
</form>
</section>


</body>
<?php include_once('foot2.php') ?>
<script>


//function disable button //
   function disablebutton()
   {
   $('#confirm').css('background-color','#dee2e6');
   $('#confirm').attr('disabled',true);
   } 
   
 // end of function disable button //

// function enable button //
   function enablebutton()
   {
   $('#confirm').css('background-color','#FF8B02');
   $('#confirm').attr('disabled',false);

   }

  // end of function enable button //


  // function disable input //
   function disableinput()
   {
   $('.data-fields').find('input.oldpass').attr('disabled',false);
   $('.data-fields').find('input.newpass').attr('disabled',true);
   $('.data-fields').find('input.p1').attr('disabled',true);

   }
  // end of function disable input //


 // get user function //
         function get_user(uid='')
         {
           var uid = uid;
           var uname = '';
           var mobile = '';
           $.ajax({
             url:"get/get-user.php",
             type:"post",
             data:{uid : uid},
             dataType:"json",
             success:function(result){
              for(i = 0;i<result.length;i++){
                var name = result[i].uname;
                var mobile = result[i].mobile;
                $('.uname').val(name);
                $('.phone').val(mobile);
              }              
             }
          });
         }
         // end of get user function //

// function check password //
function checkpassword(uid='',upass='')
{
   var uid = uid;
   var upass = upass;

      $.ajax({
             url:"check/check-password.php",
             type:"post",
             data:{uid : uid,upass : upass},
             dataType:"text",
             success:function(result){
              if(result == 1)
              {
                $('.pass-error').html('');
                $('.newpass').attr('disabled',false);
                $('.newpass').focus();
              }else{
               $('.pass-error').html('Password not found!');
               $('.newpass').attr('disabled',true);

               disablebutton(); 
              }
             }
          });

}    
// end of function check passcode  //


  // function reset form //
   function resetform()
   {
    $('.transcationnumbers').find('input').val('');
    $('.data-fields').find('input.oldpass').val('');
     $('.data-fields').find('input.newpass').val('');
      $('.data-fields').find('input.cpass').val('');
   }
  // end of function reset form //

//save function //
      function update(data='')
       {
        var data = data;
        var msg = '';
        $.ajax({
          url:"update/update-user.php",
          method:"post",
          data:data,
          dataType:"json",
          beforeSend:function(){
           disablebutton();
          },
          success:function(result){
           msg = result.msg;
           if(msg!='Failed')
           {   
            setTimeout(function(){
            disablebutton();
            disableinput();
            $('.msg-div').show();
            $('.success-txt').html(msg);
            $('.msg-div').fadeOut(3000);
            resetform();
           },400);
          }
      }
        });
      }
      //end of save function //


$(document).ready(function(){
 disablebutton();
  // call get users function //
  var uid = $('.uid').val();
  get_user(uid);
  // end of call get users function //

  // check password function //
$(".oldpass").on("keyup", function (e) {
var oldpass = $('.oldpass').val();
var uid = $('.uid').val();
if(oldpass == '')
{
$('.pass-error').html('');
$('.newpass').attr('disabled',true);
}else
{
if(oldpass.length!=''){
$('.pass-error').html('');
checkpassword(uid,oldpass);
}else{
 $('.pass-error').html('');
}
}
});
  // end of check password function //


    // check password function //
$(".newpass").on("keyup", function (e) {
var newpass = $('.newpass').val();
if(newpass == '')
{
$('.cpass').attr('disabled',true);
}else
{
if(newpass.length>=6){
  $('.cpass').attr('disabled',false);
  $('.cpass').focus();
}else{
$('.cpass').attr('disabled',true);
}
}
});
  // end of check password function //

// check confirm password function //
$(".cpass").on("keyup", function (e) {
var newpass = $('.newpass').val();
var cpass = $('.cpass').val();
if(newpass== '' || cpass == '')
{
$('.cpass-error').html('');
$('.p1').attr('readonly',true);
$('.cpass').focus();
}else
{
if(cpass == newpass){
$('.cpass-error').html('');
$('.p1').attr('readonly',false);
$('.p1').focus();
}else{
 $('.cpass-error').html('Confirm password not match!');
 $('.p1').attr('readonly',true);
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
  uid = $('.uid').val();
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
  uid = $('.uid').val();
  $('.p4').focus();
  $('.p4').attr('readonly',false);
  if(p3 == ''){
    $('.p2').focus();
    $('.p4').attr('readonly',true);
    $('.tpass').val(thistpass);
  }else{
  thistpass = parseInt(p1+p2+p3+p4);
   $('.tpass').val(thistpass);
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
     $('.tpass').val(thistpass);
     $('.passcode-error').html('');
      disablebutton();
  }else{
   thistpass = parseInt(p1+p2+p3+p4);
   $('.tpass').val(thistpass);
   enablebutton();
  }
});// end of call check passcode function //
// end of set passcode function //


        // call save function on click //
        $('body').on('click','.btn-save',function(){
        var data = '';
        data = $('.user-form').serialize();
        update(data);
  
      });
    // end of call save function on click //

});
// end of jquery //   

</script>

</body>

   <?php
      // include footer //
      include_once('foot2.php'); // this is used for include footer //
       // end of include footer // ?>
