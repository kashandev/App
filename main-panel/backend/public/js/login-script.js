//valid number function //
function validnumber() {
  var contact = $("#contact").val();
  var filter = /([+]?\d{1,2}[.-\s]?)?(\d{2}[.-]?){3}\d{5}/;
  if (filter.test(contact)) {
    return true;
  } else {
    return false;
  }
}
// end of valid number function //

// cancel function //


// cancel function //
function cancel() {
  $('.error-name').html("");
  $('.name-success').hide();
  $('.name-error').hide();
  $('.error-contact').html("");
  $('.contact-success').hide();
  $('.contact-error').hide();
  $('.error-confirm-password').html("");
  $('.cpass-success').hide();
  $('.cpass-error').hide();
  $('.error-pass').html("");
  $('.pass-success').hide();
  $('.pass-error').hide();
  $('.error-email').html("");
  $('.email-success').hide();
  $('.email-error').hide();
  $('.error-cnic').html("");
  $('.cnic-success').hide();
  $('.cnic-error').hide();
  $('.error-address').html("");
  $(".btn-save-user-profile").attr('disabled', false);
}

// end of cancel function//
// load function //
$(document).ready(function() {

  // check valid number function //  
  $("#contact").on('keyup', function() {
    var contact = $("#contact").val();
    if (contact == "") {
      $('.error-contact').html("");
      $('.contact-success').hide();
      $('.contact-error').hide();
      $(".signup-btn").attr('disabled', false);
    } else {
      if (validnumber('contact')) {
        $('.error-contact').html("");
        $('.contact-success').show();
        $('.contact-error').hide();
        $(".signup-btn").attr('disabled', false);
      } else {
        $('.error-contact').html("Invalid Contact");
        $('.error-contact').css("color", "red");
        $('.contact-error').show();
        $('.contact-success').hide();
        $(".signup-btn").attr('disabled', true);
      }
    }
  });
  // end of check valid number function //  

  // check confirm password function //  
  $("#confirm-password").on('keyup', function() {
    var password = $("#password").val();
    var confirmpassword = $("#confirm-password").val();
    if (confirmpassword == "") {
      $('.error-confirm-password').html("");
      $('.cpass-success').hide();
      $('.cpass-error').hide();
      $(".signup-btn").attr('disabled', false);
    } else {
      if (confirmpassword == password) {
        $('.error-confirm-password').html("password matched");
        $('.error-confirm-password').css("color", "green");
        $('.cpass-success').show();
        $('.cpass-error').hide();
        $(".signup-btn").attr('disabled', false);
      } else {
        $('.error-confirm-password').html("password not match");
        $('.error-confirm-password').css("color", "red");
        $('.cpass-error').show();
        $('.cpass-success').hide();
        $(".signup-btn").attr('disabled', true);
      }
    }
  });
  //end of check confirm password function //  

  // check email function //  
  $('#email').on('keyup', function() {
    var user_email = $("#email").val();
    var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (user_email == "") {
      $('.error-email').html("");
      $('.email-success').hide();
      $('.email-error').hide();
      $(".signup-btn").attr('disabled', false);
    } else {
      if (!reg.test(user_email)) {
        $('.error-email').html("Invalid Email");
        $('.error-email').css("color", "red");
        $('.email-error').show();
        $('.email-success').hide();
        $(".signup-btn").attr('disabled', true);
      } else {
        var url = $('form').attr("action");
        var method = $('form').attr("method");
        var thisurl = url.replace(url, "email/check-user-email.php");
        var thismethod = method.replace(method, "post");
        $.ajax({
          url: thisurl,
          method: thismethod,
          data: {
            user_email: user_email
          },
          dataType: "text",
          success: function(x) {
            if (x == 0) {
              $('.error-email').html("Email Already Exists");
              $('.error-email').css("color", "red");
              $('.email-error').show();
              $('.email-success').hide();
              $(".signup-btn").attr('disabled', true);
            } else {
              $('.error-email').html("");
              $('.email-success').show();
              $('.email-error').hide();
              $(".signup-btn").attr('disabled', false);
            }
          }
        });
      }
    }
  });
  //end of check email function //  


  // check cnic function //  
  $('.cnic').on('keyup', function() {
    var cnic = $(".cnic").val();
    var reg = /^[0-9+]{5}-[0-9+]{7}-[0-9]{1}$/;
    if (cnic == "") {
      $('.error-cnic').html("");
      $('.cnic-success').hide();
      $('.cnic-error').hide();
      $(".btn-edit").attr('disabled', false);
    } else {
      if (!reg.test(cnic)) {
        $('.error-cnic').html("Invalid Cnic");
        $('.error-cnic').css("color", "red");
        $('.cnic-error').show();
        $('.cnic-success').hide();
        $(".btn-edit").attr('disabled', true);
      } else {
        $('.error-cnic').html("");
        $('.cnic-success').show();
        $('.cnic-error').hide();
        $(".btn-edit").attr('disabled', false);
      }
    }
  });
  //end of check cnic function //  

  // check valid text function //  
  $("#username").on('keyup', function() {
    var username = $("#username").val();
    var name = /^[a-zA-Z ]{1,30}$/;
    if (username == "") {
      $('.error-name').html("");
      $('.name-success').hide();
      $('.name-error').hide();
      $(".signup-btn").attr('disabled', false);
      $(".btn-save-user-profile").attr('disabled', false);
    } else {
      if (!name.test(username)) {
        $('.error-name').html("Invalid Text");
        $('.error-name').css("color", "red");
        $('.name-error').show();
        $('.name-success').hide();
        $(".signup-btn").attr('disabled', true);
        $(".btn-save-user-profile").attr('disabled', true);
      } else {
        $('.error-name').html("");
        $('.name-success').show();
        $('.name-error').hide();
        $(".signup-btn").attr('disabled', false);
      }
    }
  });
  // end of check valid text function // 

  //   // check valid password function //  
  // $("#password").on('keyup',function(){
  //    var password = $("#password").val();
  //    var pattren = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  //    if(password==""){
  //      $('.error-pass').html(""); 
  //      $('.pass-success').hide();
  //      $('.pass-error').hide();
  //      $(".signup-btn").attr('disabled',false);

  //    }else{
  //       if(!pattren.test(password)){
  //       $('.error-pass').html("Week Password"); 
  //       $('.error-pass').css("color","red"); 
  //       $('.pass-error').show();
  //       $('.pass-success').hide();
  //       $(".signup-btn").attr('disabled',true);
  //    }else{
  //      $('.error-pass').html("Strong Password"); 
  //      $('.error-pass').css("color","green");
  //      $('.pass-success').show();
  //      $('.pass-error').hide();
  //      $(".signup-btn").attr('disabled',false);
  //      }
  //    }
  // });
  // // end of check valid password function // 


  // check valid password function //  
  $("#password").on('keyup', function() {
    var password = $("#password").val();
    var pattren = /(?!^[0-9]*$)(?!^[a-z]*$)(?!^[A-Z]*$)^(.{8,15})$/;
    if (password == "") {
      $('.error-pass').html("");
      $('.pass-success').hide();
      $('.pass-error').hide();
      $(".signup-btn").attr('disabled', false);
      $('.error-pass').css("color", "red");

    } else {
      if (password.length < 8) {
        $('.error-pass').html("Password should contain at least 8 characters");
        $('.error-pass').css("color", "red");
        $('.pass-error').show();
        $('.pass-success').hide();
      } else if (password.length == 8) {
        $('.error-pass').html("Password Strength Medium");
        $('.error-pass').css("color", "orange");
        $('.pass-error').hide();
        $('.pass-success').show();
      } else if (password.length > 8) {
        $('.error-pass').html("Password Strength Strong");
        $('.error-pass').css("color", "green");
        $('.pass-error').hide();
        $('.pass-success').show();
      }
    }
  });
  // end of check valid password function // 





  $("#address").on('keyup', function() {
    $('.error-address').html("");
  });

  // cancel function //  
  $('body').on('click', '.btn-cancel', function() {
    cancel()
  });

  // save function //  
  $('body').on('click', '.signup-btn', function() {
    var username = $(".username").val();
    var email = $(".email").val();
    var password = $(".password").val();
    var confirmpassword = $(".confirm-password").val();
    var address = $(".address").val();
    var contact = $(".contact").val();
    var cnic = $(".cnic").val();
    if (username == "") {
      $('.error-name').html("Please Enter Valid UserName");
      $('.error-name').css("color", "red");
    }
    if (email == "") {
      $('.error-email').html(" Please Enter Valid Email ");
      $('.error-email').css("color", "red");
    }
    if (password == "") {
      $('.error-pass').html("Please Enter Valid Password");
      $('.error-pass').css("color", "red");
    }
    if (confirmpassword == "") {
      $('.error-confirm-password').html("Please Enter Valid Confirm-Password");
      $('.error-confirm-password').css("color", "red");
    }
    if (contact == "") {
      $('.error-contact').html("Please Enter Valid Contact");
      $('.error-contact').css("color", "red");
    }
    if (address == "") {
      $('.error-address').html("Please Enter Valid Address");
      $('.error-address').css("color", "red");
    }
    if (cnic == "") {
      $('.error-cnic').html("Please Enter Valid Cnic");
      $('.error-cnic').css("color", "red");
    } else {
      var url = $('form').attr("action");
      var method = $('form').attr("method");
      var thisurl = url.replace(url, "insert/insert.php");
      var thismethod = method.replace(method, "post");
      var data = $('form').serialize();
      $.ajax({
        url: thisurl,
        method: thismethod,
        data: data,
        beforeSend: function() {
          $(".error-div").show();
          $(".errortxt").html("Saving.....");
          $(".signup-btn").attr('disabled', true);
          window.scrollTo(0, 0);
        },
        success: function(abc) {
          setTimeout(function() {
            $(".error-div").hide();
            $('.success-div').show();
            $('.successtxt').html(abc);
            // $('.success-div').fadeOut(800);
            $(".signup-btn").attr('disabled', false);
            $("form")[0].reset();
            cancel();
          }, 400);
          setTimeout(function() {
            window.location.href = "index.php";
          }, 1000);
        }
      });
    }
  });
  //end of save function //
  // $('body').on('click','.btn-verify-email',function(){
  //      var verify_email = $('.verify_email').val();
  //      var url = $('form').attr("action");
  //      var method = $('form').attr("method");
  //      var thisurl = url.replace(url,"verify.php");
  //      var thismethod = method.replace(method,"post");
  //     $.ajax({
  //      url:thisurl,
  //      method:thismethod,
  //      data:{verify_email : verify_email},
  //      beforeSend:function(){
  //      $(".btn-verify-email").attr('disabled',true);
  //    },
  //     success:function(res){
  //     window.setTimeout(function(){
  //       $('.msgtxt').html(res);
  //       $(".btn-verify-email").attr('disabled',false);
  //      },300);
  //       window.setTimeout(function(){
  //       window.location.href = 'https://roboticspk.com/web/admin/';
  //      },1000);
  //      }
  //     });
  // });  
});
//end of load function //


function timer() {
  var seconds = 10;
  var countdown = setInterval(function() {
    seconds--;
    document.getElementById("timer").textContent = " Login Agian After " + seconds + " Seconds ";
    if (seconds <= 0) {
      $('form').find('input').attr('disabled', false);
      $('.login-btn').attr('disabled', false);
      clearInterval(countdown);
      document.getElementById("timer").textContent = " ";
      return;
    }
  }, 1000);
}

var loginattempt = 0;

function count_login_attempt() {
  loginattempt = parseInt(loginattempt) + 1;
  return loginattempt;
}

function check_login_attempt() {
  var count_attempt = count_login_attempt();
  if (count_attempt >= 3) {
    timer();
    $('form').find('input').attr('disabled', true);
    $('.login-btn').attr('disabled', true);
  }
}

$(document).ready(function() {
  // $('.email').on('keyup',function(){
  //   var thisurl = $("form").attr("action");
  //   var thismethod = $("form").attr("method");
  //   var url = thisurl.replace(thisurl,"email/checkuseraccess.php");
  //   var method = thismethod.replace(thismethod,"post");
  //   var email = $('.email').val();
  //   if(email == ""){
  //           $(".error-message-div").hide();
  //           $(".errortxt").html("");
  //           $('.login-btn').attr('disabled',false); 
  //           $('.password').attr('disabled',false);
  //   }else{
  //   $.ajax({
  //         url:url,
  //         method:method,
  //         data:$("form").serialize(),
  //         dataType:"json",
  //         success:function(test){
  //           var email = test.email;
  //           var is_verified = test.is_verified;
  //           var user_role = test.user_role;
  //           if(email == "" && is_verified == ""){
  //           $(".error-message-div").show();
  //           $(".errortxt").html("No User Found");
  //           $('.login-btn').attr('disabled',true); 
  //           }
  //           else if(is_verified == 0 && user_role!="User"){
  //             console.log(user_role)
  //           $(".error-message-div").show();
  //           $(".errortxt").html("Please Verify Your Account");
  //           $('.login-btn').attr('disabled',true); 
  //           }
  //           else if(is_verified == 1 && user_role!="User"){
  //             console.log(user_role)
  //           $(".error-message-div").hide();
  //           $(".errortxt").html("");
  //           $('.login-btn').attr('disabled',false); 
  //           $('.password').attr('disabled',false);
  //           }
  //           else if(is_verified == 1 && user_role!="Admin"){
  //          $(".error-message-div").show();
  //           $(".errortxt").html("Access Denied");
  //           $('.login-btn').attr('disabled',true);
  //           $('.password').attr('disabled',true); 
  //           }
  //         }
  //       });
  // }
  // });


  $(document).keypress(function(e) {

    var email = $('.email').val();
    var password = $('.password').val();
    var thisurl = $(".log-form").attr("action");
    var thismethod = $(".log-form").attr("method");
    var url = thisurl.replace(thisurl, "login/login.php");
    var method = thismethod.replace(thismethod, "post");
    if (e.which == 13) {
      $.ajax({
        url: url,
        method: method,
        data: $(".log-form").serialize(),
        dataType: "json",
        beforeSend: function() {
        $('.form-actions').css('background-color','#dee2e6');
        $('.login-btn').attr('disabled',true);
        },
        success: function(response) {

          var login = response.login;
          if (login == 1) {
            setTimeout(function() {
              $('.form-actions').css('background-color','#ffb800');
              $('.login-btn').attr('disabled', false);
              $('.login-txt').html(response.success_message);
              $('.error-txt').html('');
            }, 400);
            setTimeout(function() {
              window.location.href = 'dashboard.php';
            }, 1000);
          } else if (login == 2) {
            $('.login-btn').attr('disabled', false);
            $('.error-email').html(response.error_message);
            $('.error-txt').html('');
            check_login_attempt();
          } else if (login == 3) {
            $('.login-btn').attr('disabled', false);
            $('.error-password').html(response.error_message);
            $('.error-txt').html('');
            check_login_attempt();
          } else if (login == 0) {
            $('.login-btn').attr('disabled', false);
            $('.error-txt').html(response.error_message);
          }
        }
      });
    }
  });


  $('.login-btn').on('click', function() {
    var email = $('.email').val();
    var password = $('.password').val();
    var thisurl = $(".log-form").attr("action");
    var thismethod = $(".log-form").attr("method");
    var url = thisurl.replace(thisurl, "login/login.php");
    var method = thismethod.replace(thismethod, "post");
    if (email == "") {
      $('.error-email').html(" username can`t be empty ");
      $('.error-email').css("color", "red");
    }
    if (password == "") {
      $('.error-password').html("password can`t be empty");
      $('.error-password').css("color", "red");
    } else {
      $.ajax({
        url: url,
        method: method,
        data: $(".log-form").serialize(),
        dataType: "json",
        beforeSend: function() {
        $('.form-actions').css('background-color','#dee2e6');
        $('.login-btn').attr('disabled',true);
        },
        success: function(response) {

          var login = response.login;
          if (login == 1) {
            setTimeout(function() {
              $('.login-btn').attr('disabled',false);
              $('.login-txt').html(response.success_message);
              $('.error-txt').html('');
            }, 400);
            setTimeout(function() {
              window.location.href = 'dashboard.php';
            }, 1000);
          } else if (login == 2) {
            $('.form-actions').css('background-color','#ffb800');
            $('.login-btn').attr('disabled', false);
            $('.error-email').html(response.error_message);
            $('.error-txt').html('');
            check_login_attempt();
          } else if (login == 3) {
            $('.login-btn').attr('disabled', false);
            $('.error-password').html(response.error_message);
            $('.error-txt').html('');
            check_login_attempt();
          }
        }
      });
    }
  });
});
$(document).ready(function() {
  var signout_message = $('.signout_message').val();
  if (signout_message) {
    setTimeout(function() {
      $(".signout-message-div").show();
      $(".signouttxt").html(signout_message);
      $(".signout-message-div").fadeOut(1000);
      $('.unset_session').val();
    }, 20)
  }
});