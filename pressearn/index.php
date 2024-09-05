<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header //
?>
<?php
  // include get code //
   include_once('get/get-code.php'); // this is used for include get code //
    // end of includeget code //
   ?>    
   <?php
    // include nav //
    include_once('nav/nav.php'); // this is used for include nav //
   // end of include nav // ?>
   <!-- title -->
<title>Pressearn</title>
<body>
   <?php
      // include banner //
      include_once('banner/banner.php'); // this is used for banner //
       // end of include banner // ?>
    <!-- Detail box Start here  -->
<section class="detail-box">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top" src="images/company-vision.png" alt="Card image cap">
          <div class="card-body">
            <h2>Company Profile</h2>
            <hr>
            <p class="card-text">A company profile is your brand's professional introduction to your audience. It's meant to inform visitors and prospects on your products, services, and current positioning in the market. A well crafted company profile is a way to make yourself stand out from the competition and offer how you're unique.</p>
            <hr>
            <div class="iconcard">
            <button type="button" class="btn my-btn3" onclick="window.location.href='company-profile.php'">Read More</button>
          </div>
        </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top2" src="images/promote.png" alt="Card image cap">
          <div class="card-body2">
            <h2>Promotion Rewards</h2>
            <hr>
            <p class="card-text">In the age of the consumer, marketers know that each sale, customer acquisition and customer retained is hard-fought. To add to the challenge, shoppers have increasingly grown accustomed to constant promotions and rewards and now respond better to frequent discounting than an everyday low price.</p>
            <hr>
            <div class="iconcard2">
            <button type="button" class="btn my-btn4" onclick="window.location.href='<?php echo $thispurl ?>'">Read More</button>
          </div>
        </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top" src="images/stairs.png" alt="Card image cap">
          <div class="card-body">
            <h2>Beginner Tutorial</h2>
            <hr>
            <p class="card-text">In the age of the consumer, marketers know that each sale, customer acquisition and customer retained is hard-fought. To add to the challenge, shoppers have increasingly grown accustomed to constant promotions and rewards and now respond better to frequent discounting than an everyday low price.</p>
            <hr>
            <div class="iconcard">
            <button type="button" class="btn my-btn3"  onclick="window.location.href='beginner.php'">Read More</button>
          </div>
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top2" src="images/invitation.png" alt="Card image cap">
          <div class="card-body2">
            <h2>Invitation</h2>
            <hr>
            <p class="card-text">In the age of the consumer, marketers know that each sale, customer acquisition and customer retained is hard-fought. To add to the challenge, shoppers have increasingly grown accustomed to constant promotions and rewards and now respond better to frequent discounting than an everyday low price.</p>
            <hr>
            <div class="iconcard2">
            <button type="button" class="btn my-btn4" onclick="window.location.href='<?php echo $thisinvurl ?>'">Read More</button>
          </div>
        </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top2" src="images/financial-profit.png" alt="Card image cap">
          <div class="card-body">
            <h2>Financial</h2>
            <hr>
            <p class="card-text">In the age of the consumer, marketers know that each sale, customer acquisition and customer retained is hard-fought. To add to the challenge, shoppers have increasingly grown accustomed to constant promotions and rewards and now respond better to frequent discounting than an everyday low price.</p>
            <hr>
            <div class="iconcard">
            <button type="button" class="btn my-btn3">Read More</button>
          </div>
        </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img class="card-img-top2" src="images/red-carpet.png" alt="Card image cap">
          <div class="card-body2">
            <h2>Vip Events</h2>
            <hr>
            <p class="card-text">In the age of the consumer, marketers know that each sale, customer acquisition and customer retained is hard-fought. To add to the challenge, shoppers have increasingly grown accustomed to constant promotions and rewards and now respond better to frequent discounting than an everyday low price.</p>
            <hr>
            <div class="iconcard2">
            <button type="button" class="btn my-btn4">Read More</button>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
 <!-- Detail box End here  -->
    <!-- _________________________ -->
    <!-- _________________________ -->
    <!-- First Footer Start here  -->
</body>
   <?php
    // include footer //
    include_once('footer.php'); // this is used for include footer //
   // end of include footer // ?>
