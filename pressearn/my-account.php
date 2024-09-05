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

<?php

      // include nav //

      include_once('nav/nav.php'); // this is used for include nav //

      // end of include nav // ?>

<!-- title -->

<title>My Account</title>

<body class="teamreports">

   <section id="screens">

      <div class="container-fluid">

         <div class="mediascreens">

            <div class="row no-gutters ">

               <div class="col-md-3 users">

                  <div class="userdat">

                      <?php // include variable //

                        include_once("variable/variable.php"); // this is used for include variable //

                     // end of include variable // ?>

                     <a href="<?=$thisepurl?>">   

                      <?php echo $thisimage ?>

                   </a>

                     <h6>User name: <?php echo $u_name ?></h6>

                     <p>Invitation code: <span class="code-txt" id="codetxt" data-id="code"></p>

                     <div class="down">

                        <h6>Available balance</h6>

                        <h1 class="bal-txt"></h1>

                        <button class="btn deposite" onclick="window.location.href='<?=$thisturl?>'">Deposite</button>

                        <button class="btn withdraw" onclick="window.location.href='<?=$thiswurl?>'">Withdrawal</button>

                        <div class="starts">

                           <span class="fa fa-star checked"></span>

                           <span class="fa fa-star checked"></span>

                           <span class="fa fa-star checked"></span>

                           <span class="fa fa-star checked"></span>

                           <span class="fa fa-star checked"></span>

                        </div>

                     </div>

                  </div>

               </div>

               <div class="col-md-8 col-sm-12 info">

                  <div class="infobox">

                     <div class="boxes">

                        <div class="card teams">

                           <a href='personal-info.php'><img src="images/use.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='personal-info.php'">Personal<br> information</p>

                        </div>

                        <div class="card teams">

                           <a href='order.php'><img src="./images/checklist.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='<?php echo $thisourl?>'">Order<br>records</p>

                        </div>

                        <div class="card teams">

                          <a href='account-details.php'> <img src="./images/seo.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='account-details.php'">Account <br>detail</p>

                        </div>

                     </div>

                     <!-- Boxes 2 -->

                     <div class="boxes">

                        <div class="card teams">

                          <a href='teamreports.php'> <img src="./images/turn-down.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='teamreports.php'">team<br>reports</p>

                        </div>

                        <div class="card teams">

                           <a href='announcement.php'><img src="./images/megaphone.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='announcement.php'">Announcement</p>

                        </div>

                        <div class="card teams">

                          <a href='invite-friends.php'> <img src="./images/add-friend.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='invite-friends.php'">Friend<br>invitation</p>

                        </div>

                     </div>

                     <!-- Boxes 3 -->

                     <div class="boxes">

    <!--                     <div class="card teams">

                           <img src="./images/downloads.png">

                           <p class="infopara">App<br>download</p>

                        </div> -->

                        <div class="card teams">

                           <a href='help-guide.php'><img src="./images/pencil.png" alt=""></a>

                           <p class="infopara" onclick="window.location.href='help-guide.php'">Help<br>guide</p>

                        </div>

                        <div class="card teams">

                           <a href="#"><img src="./images/coming-soon.png" alt=""></a>

                           <p class="infopara">coming<br>soon</p>

                        </div>

                     </div>

                  </div>

               </div>

               <div class="col-md-1">

                  <div class="exit">

                     <img src="./images/country.png" alt="Country">

                     <a href="signout/signout.php"><i class="fas fa-sign-out-alt"></i></a>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </section>

</body>

<?php

      // include footer //

      include_once('foot2.php'); // this is used for include footer //

       // end of include footer // ?>



<script type="text/javascript">

// get code function //

function get_code(uid = '')

{

   var uid = uid;

   var code = '';

   var code_txt = '';

   $.ajax({

      url: "get/get-code.php",

      type: "post",

      data: {
         uid: uid
      },

      dataType: "json",

      success: function (result) {

         code = result.code;

         code_txt = code;

         $('.code-txt').html(code_txt);

      }

   });

}

// end of get code function //

// document add event listner //
document.addEventListener('DOMContentLoaded', function () {
   let intervalId = null; // Store the interval ID
   // get balance function //
   function get_balance(result) {
      let bal = result + " USDT";
      $('.bal-txt').html(bal);

      // Stop the interval check after updating balance
      clearInterval(intervalId);
   }
   // get check new data function //
   function checkForNewData() {
      let uid = $('.uid').val(); // Get user ID

      $.ajax({
         url: "get/get-balance.php",
         type: "post",
         data: {
            uid: uid
         },
         dataType: "html",
         success: function (result) {
            if (result.trim() !== "") { // Check if result is not empty
               get_balance(result); // Update balance with the result

               // Stop the interval check after new data is detected
               clearInterval(intervalId);
            }
         },
         error: function () {
            console.error('Error fetching balance');
         }
      });
   }

   // Start the interval check
   intervalId = setInterval(checkForNewData, 1000); // Check every second

   // call get code function //

   var uid = $('.uid').val();

   get_code(uid);

   // end of call get code function //

});
// end of document add event listner //

</script>

