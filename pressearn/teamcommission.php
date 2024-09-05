<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header // 

      // include nav //
      include_once('nav/nav.php'); // this is used for include nav //
      // end of include nav // ?>
    <!-- title -->
<title>Grab</title>

<body class="teamreports">

<section id="screens">
<div class="container-fluid">
    <div class="mediascreens sec">
   
            <div class="row no-gutters ">
                <div class="col-md-3 users">
                <div class="userdatagrab">
                    <h1>Rule Description</h1>
                    <div class="down">
                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                    </div>
                </div>
                
                
                  <!-- Boxes 1 -->
                </div>
                <div class="col-md-9 info">
                    <div class="grab-top">
                        <h3>Grab</h3>
                    </div>
                <div class="infobox2">
                    <div class="boxes">
                    <div class="card-box">
                        <p class="infopara">Term balance</p>
                        <h3>00:00</h3>
                    </div>
                    <div class="card-box">
                        <p class="infopara">Team cash flow</p>
                        <h3>00:00</h3>
                    </div>
                    <div class="card-box">
                        <p class="infopara">Team Deposite</p>
                        <h3>00:00</h3>
                    </div>

                    </div>
                    <!-- Boxes 2 -->
                    <div class="boxes">
                    <div class="card-box">
                        <p class="infopara">Term order commission</p>
                        <h3>00:00</h3>
                    </div>
                    <div class="card-box">
                        <p class="infopara">First time depositor</p>
                        <h3>00:00</h3>
                    </div>
                    <div class="card-box">
                        <p class="infopara">First-level member</p>
                        <h3>00:00</h3>
                    </div>
                    </div>
                    <div class="txt-bar">
                        <div class="txt-box">
                            <h3>A higher rank member can unlock more orders and get more commission.</h3>
                        </div>
                    </div>
                    <div class="grab-bottom">
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
     $( function() {
    $( "#eventDate" ).datepicker({
      minDate: 0
    });
  } );
  
 $('.mybtn').click( function() { $('#ourDate').html('This is the date you selected: '+ $('#eventDate').val()); } )
  
  $( document ).ready(function() {
       var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd='0'+dd
}

if(mm<10) {
    mm='0'+mm
}

today = mm+'/'+dd +'/'+yyyy ;
   $('#eventDate').val(today);
});
</script>
</body>

   <?php
      // include footer //
      include_once('foot2.php'); // this is used for include footer //
       // end of include footer // ?>
