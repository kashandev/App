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
   // end of include nav // ?>
<!-- title -->
<title>Invite Friends</title>
<body>
   <!-- banner start here  -->
   <section class="banner">
      <div class="bann1">
         <img class="banslides" src="images/promotionbanner.png" alt="banner1" >
         <div class="row">
            <div class="col-md-8">
               <div class="bannercontent Promotion">
                  <?php // include variable //
                     include_once("variable/variable.php"); // this is used for include variable //
                     // end of include variable // ?>
                  <h1>Promotion Reward</h1>
                  <p>Pressearn platform investment starts with a three-tier development model. Three levels, it means that the agent can get three <br> levels of commission share, and can not get commission share for more than three levels. For example, if you are the user A <br>of this platform, you get the agent authority after performing the purchase task. The system will automatically form your  center<br> and promote your exclusive QR code and promotion link. B will register as a user by scanning the QR code or promotion link.<br> After completing the purchase task, A will get 16% of B's commission.At the same time, the system will automatically create a user <br>center for B to promote exclusive QR code and promotion link. C will register as a user by scanning the QR code or promotion <br>link, and after completing the purchase task, B will get 16% commission of C. A will get 8% of C; and so on, if D becomes a <br>user through C, C will get 16%, B will get 8%, and A will get 4%.
                     <br><br>Note: The commission rewards generated by all the agents' offline users are issued by the platform and will not affect the <br>commissions of all agents and offline users!
                     Agent commissions will be <br>paid at 00:30 (USA Time)
                  </p>
               </div>
            </div>
            <div class="col-md-4">
            </div>
         </div>
      </div>
      </div>
   </section>
   <!-- QR Section -->
   <section id="qr">
      <div class="container">
         <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
               <div class="box">
                  <div class="img-div"></div>
                  <p>Long Press & Hold the the picture to save the Album</p>
                  <h3 class="txt fr"><strong>Invitation code: <span class="code-txt" id="codetxt" data-id="code"></span></strong> </h3>
                  <button class="btn btn-copy-code " id="btn-copy-code" onclick="copy(codetxt,'code')">Copy</button>
                  <br>
                  <h3 class="txt fr"><strong>Invitation link: <span class="link-txt" id="linktxt" data-id="link"></span></strong> </h3>
                  <button class="btn btn-copy-link" onclick="copy(linktxt,'link')">Copy</a>
               </div>
            </div>
            <div class="col-md-2"></div>
         </div>
      </div>
   </section>
</body>
<?php
   // include footer //
   include_once('footer.php'); // this is used for include footer //
    // end of include footer // ?>
<script>
   // get code function //
           function get_code(uid='')
           {
             var uid = uid;
             var code = '';
             var link = '';
             var img = '';
             var code_txt = '';
             var link_txt = '';
             var img_div = '';
             $.ajax({
               url:"get/get-code.php",
               type:"post",
               data:{uid : uid},
               dataType:"json",
               success:function(result){
                code = result.code;
                link = result.link;
                img = result.img;
                code_txt = code;
                link_txt = link;
                img_div = '<img id="barcode" src="'+img+'"  alt="Invitation"  title="Invitation" width="120"  height="120" />'
                 $('.code-txt').html(code_txt);
                 $('.link-txt').html(link_txt);
                 $('.img-div').html(img_div)
                
               }
            });
           }
           // end of get code function //
     
   
   
   // copy function //
   function copy(id='',data='') {
    var id = id;
    var data = data;
    var thisclass = '';
    if(data == 'code')
    { 
      thisclass = '.btn-copy-code';
    }
    else
    {
      thisclass = '.btn-copy-link';
    }
    var range = document.createRange();
    console.log(range)
    range.selectNode(id); //changed here
    window.getSelection().removeAllRanges(); 
    window.getSelection().addRange(range); 
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
    $(thisclass).html('Copied');
    setTimeout(function(){
      $(thisclass).html('Copy');
    },1000);
   }
   // end of copy function //
   // start jquery //
   $(document).ready(function(){
   
    var uid = $('.uid').val();
    get_code(uid);
   });
   // end of jquery //
</script>