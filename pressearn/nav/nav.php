<?php
$thishurl = '';
$thissurl = '';
$thisaurl = '';
$thisourl = '';
$thisinvurl = '';
$thispurl = '';
$thisgurl = '';
$thisepurl = '';
$activeclass1 = "";
$activeclass2 = "";
$activeclass3 = "";
$activeclass4 = "";
$defaultclass = "";
if(isset($_GET['login_id']) == ''){
$_GET['login_id'] = '';
}
if(isset($_GET['login_id']) != ''){
$login_id = $_GET['login_id'];
}
if(isset($_GET['pageid']) == ''){
$_GET['pageid'] = '';
}
if(isset($_GET['pageid']) != ''){
$pageid = $_GET['pageid'];
}

if(isset($_SESSION['login_id'])!= '' && isset($_SESSION['u_id_pk'])!= ''){
  $login_id = $_SESSION['login_id'];
  $thishurl = 'index.php?pageid=home'; 
  $thissupurl = 'customerservice.php?pageid=support';
  $thisourl = 'order.php?pageid=order';
  $thisaurl = 'my-account.php?' . $login_id . '&pageid=account';
  $thisinvurl = 'invite-friends.php';
  $thispurl = 'promotion.php';
  $thisgurl = 'grab.php';
  $thisepurl = 'edit-profile-pic.php';
}else{
   $thishurl = 'index.php?pageid=home';
   $thissurl = '<li class="'.$activeclass4.'">
                  <a class="nav-link disabled" href="signup.php?pageid=signup" target="_blank" data-id="sign">SignUp</a>
                </li>';
   $thisaurl = 'signin.php';
   $thisinvurl ='signin.php';
   $thispurl = 'promotion.php';
   $thissupurl = 'customerservice.php?pageid=support';
   $thisourl = 'signin.php';
   $thisgurl = 'signin.php';
   $thisepurl = 'signin.php';
}
if($pageid == 'home'){
 $defaultclass = 'nav-item active';
}else{
 $defaultclass = 'nav-item';
}
if($pageid == 'order'){
 $activeclass1 = 'nav-item active';
 $defaultclass = 'nav-item';
}else{
 $activeclass1 = 'nav-item';
}
if($pageid == 'support'){
 $activeclass2 = 'nav-item active';
 $defaultclass = 'nav-item';
}else{
 $activeclass2 = 'nav-item';
}
if($pageid == 'account'){
 $activeclass3 = 'nav-item active';
 $defaultclass = 'nav-item';
}else{
 $activeclass3 = 'nav-item';
}
if($pageid == 'signup'){
 $activeclass4 = 'nav-item active';
 $defaultclass = 'nav-item';
}else{
 $activeclass4 = 'nav-item';
}
?>

    <!-- header start here  -->
    <header> 
        <nav class="navbar navbar-expand-lg navbar-light my-nav">
            <a href="index.php"><img class="logo" src="images/logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="<?php echo $defaultclass?>">
                  <a class="nav-link" href="<?php echo $thishurl?>" data-id="hm">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="<?php echo $activeclass1?>">
                  <a class="nav-link" href="<?php echo $thisourl?>" data-id="ord">Order</a>
                </li>
                <li class="<?php echo $activeclass2?>">
                  <a class="nav-link" href="<?php echo $thissupurl?>" data-id="supp">Support</a>
                </li>
                <li class="<?php echo $activeclass3?>">
                  <a class="nav-link disabled" href="<?php echo $thisaurl?>" data-id="acc">Account</a>
                </li>

                <?php echo $thissurl?>
              </ul>
            </div>
          </nav>
    </header>
    <!-- header end here -->
    
    <!-- _________________________ -->
    <!-- _________________________ -->

    <script type="text/javascript">
      
    // click function for tabs//
    $("body").on("click", ".navbar-nav li a", function () {
        var id = $(this).attr("data-id");
        $('li.active').removeClass('active');
        $(this).parent('li').addClass('active');

    });

    // end of click function for tabs //
    </script>