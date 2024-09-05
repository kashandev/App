<?php
   // include header //
include_once('header.php'); // this is used for include header //
    // end of include header // 
if(isset($_SESSION['u_id_pk']) == ''){
echo "<script>location.assign('signin.php')</script>";
}
?>
<?php
      // include nav //
include_once('nav/nav.php'); // this is used for include nav //
      // end of include nav // 
?>
    <!-- title -->
<title>Top-up Method</title>
<body class="customer">
<section id="topupmethod">
<div class="container">
<div class="topmethod">   
<h3>Select a Top-up Method</h3> 
<?php
  // include get method //
   include_once('get/get-method.php'); // this is used for include get code //
    // end of includeget code //
   ?> 
<!-- <div class="row">
<div class="flexy">
<label class="hash">USDT TRC-20
  <input type="checkbox" checked="checked" name="check" onclick="onlyOne(this)">
  <span class="checkmark"></span>
</label>
<label class="hash">USDT ERC-20
  <input type="checkbox" name="check" onclick="onlyOne(this)">
  <span class="checkmark"></span>
</label>
  </div>
</div> -->
<a type="button" class="btn next">Next</a>
</div>
</div>
</section>
<script>

 // get method function //
         function get_method(id='')
         {
           var id = id;
           window.location.href ='deposit.php?method='+id+'';
            
         }
         // end of get method function //
   

   // check only one function //
    function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('tmpid')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}
   // end of check only one function //

// start jquery //
$(document).ready(function(){

  // call get method function //
$('body').on('click','a',function(){
  $('.flexy').find('input.tmpid:checked').each(function(){
    var id = $(this).val();
    get_method(id);
  });
});
  //  end of call get method function //
});

// end of jquery //
</script>
</body>

   <?php
      // include footer //
      include_once('foot2.php'); // this is used for include footer //
       // end of include footer // ?>