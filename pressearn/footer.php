<!-- Footer Start here  -->
<footer class="fixed-bottom">
<section class="first-footer ">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="foobutton1">
        <a type="button" class="btn my-btn" href="<?=$thisturl?>">Deposit</a>
      </div>
    </div>
      <div class="col-md-6 col-sm-12">
        <div class="foobutton2">
        <a type="button" class="btn my-btn-2" href="<?=$thiswurl?>">Withdrawal</a>
      </div>
    </div>
    </div>
  </div>
</section>
  <div class="container">
    <div class="row foot-links">
      <div class="col-md-2 my-link-col my-auto">
        <div class="link">
       <a href="<?php echo $thishurl?>">   
          <img src="images/house.png" alt=""><br>
          Home
        </a>
        </div>
      </div>
      <div class="col-md-2 my-link-col my-auto">
        <div class="link">
       <a href="<?php echo $thisourl?>">   
          <img src="images/order.png" alt=""><br>
          Order
        </a>
        </div>
      </div>
      <div class="col-md-3 my-link-col2 my-auto grab">
        <div class="link">
        <a href="<?php echo $thisgurl?>">   
          <img class="foomainimg" src="images/grab.png"><br>
        </a>
        </div>
      </div>
      <div class="col-md-2 my-link-col my-auto">
        <div class="link">
           <a href="<?php echo $thissupurl?>">
          <img src="images/videoconference.png" alt=""><br>
         Support
       </a>
        </div>
      </div>
      <div class="col-md-2 my-link-col my-auto ">
        <div class="link">
          <a href="<?php echo $thisaurl?>">
          <img src="images/user.png" alt=""><br>
          Account
        </a>
        </div>
      </div>
     
        <a id="button"><span class="glyphicon glyphicon-arrow-up"></span></a>
    </div>
  </div>
</footer>
<!-- Scripts -->

<script>
  var btn = $('#button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});


</script><script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.js' crossorigin='anonymous'></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
// $('.banner-slick').slick({
//   slidesToShow: 1,
//   slidesToScroll: 1,
//   autoplay: true,
//   autoplaySpeed: 2000,
// });  
</script>
<script>
  $(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $("header").addClass("active");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
           $("header").removeClass("active");
        }
    });
});

</script>
</html>