$(document).ready(function() {
  var welcome_message = $('.welcome_message').val();
  var user_name = $('.user_name').val();
  if (welcome_message) {
    setTimeout(function() {
      $(".welcome-message-div").show();
      $(".welcometxt").html(welcome_message + " " + user_name);
      $(".welcome-message-div").fadeOut(1000);
      $('.unset_session').val();
    }, 20)
  }
});