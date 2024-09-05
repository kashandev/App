<?php
// include header //
include_once('header.php'); // this is used for include header //
// end of include header // 
?>
<!-- title -->
<title>Dashboard</title>
<!-- /.title -->
<?php
   // include mystyle //
   include_once('style/my-style.php'); // this is used for include mstyle //
    // end of include mystyle // ?>
<!-- body -->
<body class="page-full-width generic-content">
  <?php
      // include top nav //
      include_once('top-nav.php'); // this is used for include top nav //
      // end of include top nav // ?>

  <div class="top-heading">
        <h2>Dashboard</h2>
    </div>
    <section class="summary">

  <input type="hidden" name="user_name" class="user_name" value="<?php echo $user_name?>">
                        <input type="hidden" name="welcome_message" class="welcome_message" value="<?php echo $welcome_message?>">
                        <input type="hidden" name="unset_session" class="unset_session" value="<?php echo unset_session()?>">

                    <div class="row welcome-message-div">
                     <div class="col-sm-12">
                        <div class="alert alert-success" role="alert"><strong class="welcometxt"></strong></div>
                     </div>
                  </div>    
    <div class="mycontainer">
<!--         <div class="row ">
            <div class="col-sm-6">
                <div class="sum-box"> 


                    <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Total Deposite
                        </div>
                    </li>

                      <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Weekly Deposite
                        </div>
                    </li>

                       <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Monthly Deposite
                        </div>
                    </li>      


                </div>
            </div>
          </div> -->
          <br>
<!--                   <div class="row ">
            <div class="col-sm-6">
                <div class="sum-box"> 

                      <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Total Withdrawal
                        </div>
                    </li>

                      <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Weekly Withdrawal
                        </div>
                    </li>

                       <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Monthly Withdrawal
                        </div>
                    </li>                 
                     <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                             Jazz Cash
                        </div>
                    </li>
                    <li>         
                        <div class="values">
                            <strong>0</strong> <br>
                            Easy Paisa
                        </div>
                    </li> -->

                </div>
            </div>

        </div>
    </div>
    </section>
</body>
<?php
   // include footer //
   include_once('footer.php'); // this is used for include footer //
    // end of include footer // ?>  
<!-- /.body -->