<div class="navbar navbar-inverse navbar-fixed-top">

   <!-- start: TOP NAVIGATION CONTAINER -->

   <div class="navbar-header">

      <!-- start: RESPONSIVE MENU TOGGLER -->

      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">

      <span class="fa fa-list"></span>

      </button>

      <!-- end: RESPONSIVE MENU TOGGLER -->

      <!-- start: LOGO -->

      <a class="navbar-brand clearfix" href="#">

      <?php

         // include logo //

           include_once('logo/logo.php'); // this is used for include logo //

         // end of include logo function // ?>

      </a>

      <!-- end: LOGO -->

   </div>

   <div class="navbar-header-left">

      <div class="navbar-tools" id="noti">



         <div class="role-name">

            <h2>Pressearn</h2>

         </div>    

         <!-- start: TOP NAVIGATION MENU -->

         <ul class="nav navbar-right">

            <li class="setting-tab">

               <a href="#">

               <i class="fa fa-cog"></i>

               </a>

            </li>

            <li class="dropdown current-user">

               <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">

               <span clafss="username"><img src="public/images/logo/<?php echo $user_image_guid?>" class="circle-img" alt="profile" title="profile"></span>

               </a>

               <ul class="dropdown-menu">

                  <li>

                     <a href="" target="_blank">

                     <i class="fa fa-calendar"></i>

                     &nbsp;Change Password

                     </a>

                  </li>

                  <li class="divider"></li>

                  <li>

                     <a href="signout/signout.php">

                     <i class="fa fa-sign-out"></i>

                     &nbsp;Log Out

                     </a>

                  </li>

               </ul>

            </li>

            <!-- end: USER DROPDOWN -->

         </ul>

         <!-- end: TOP NAVIGATION MENU -->

         <!-- start: SIDEBAR -->

         <div class="clearfix"></div>

         <div class="navbar-collapse collapse top-nav">

            <div class="col-sm-12">

               <ul class="nav navbar-nav">

                  <li class="active dashboard"><a href="dashboard.php">Dashboard</a></li>

                  <li class="usermanage"><a href="user-management.php">User Management</a></li>

                  <li class=""><a href="suppoters.php">Supporters</a></li>

                  <li class="">

                     <a href="javascript:void(0)" class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown">Manage <i class="fa fa-angle-down"></i></a>

                     <ul class="dropdown-menu">

                       <li class=""><a href="deposit.php">Deposit</a></li> 

                      <li class=""><a href="withdrawal.php">Withdrawal</a>

                      <li class=""><a href="wallet.php">Wallet</a></li> 

                       <li class=""><a href="reports.php">Reports</a></li>

                       <li class=""><a href="whatsapp-chat.php">Whatsapp Chat</a></li>

                       <li class=""><a href="web-chat.php">Web Chat</a></li>

                   

                     </ul>

                  </li>

               </ul>

            </div>

            <div class="col-sm-2" style="margin-top:8px;">

            </div>

         </div>

      </div>

   </div>

</div>

<!-- <script src="public/admin/plugins/jQuery/jQuery-2.1.3.min.js"></script>

<script>

$(function(){

$('.top-nav ul li a').on('click', function(){

    $(this).parent().addClass('active').siblings().removeClass('active');

  });

});





</script> -->