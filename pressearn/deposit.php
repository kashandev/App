<?php

   // include header //

   include_once('header.php'); // this is used for include header //

    // end of include header // 

   if(isset($_SESSION['u_id_pk']) == ''){

   echo "<script>location.assign('signin.php')</script>";

   }

   

    $tpmid               = ""; 

    $method              = ""; 

    $channel             = "";

    $sql                 = "";

    $res                 = "";

    $row                 = "";

    $thisid              = "";

    $thismethod          = "";

    $thischannel         = "";

    $thismlabel          = ""; 

    $thisclabel          = ""; 

    $method = '';

   if(isset($_GET['method']) == ''){

    $_GET['method'] = '';

    $method = '';

   }

   

   if(isset($_GET['method'])!=''){

    $method = $_GET['method'];

   }

   

   if($method == '')

   {

    $sql = "SELECT * from topup_method order by tpmid asc limit 1 ";

   }

   

   if($method != '')

   {

    $sql = "SELECT * from topup_method where tpmid = '".$method."' order by tpmid asc ";

   }

    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res))

    {

    while($row = mysqli_fetch_array($res))

    {   

    $tpmid  = $row['tpmid'];    

    $method = $row['tpmethod'];

    $channel = $row['tpchannel'];

    $thisid = $tpmid;

    $thismethod = $method;

    $thischannel = $channel;

   

    $thisclabel = '<h3>Transfer Channel:'.$thischannel.'</h3>';

    $thismlabel = '<h4><b>'.$thischannel.' Top-Up</b></h4>';

   

   }

   }

   else

   {

     $thismethod = '';

     $thischannel = '';

     $thisclabel = '<h3>Transfer Channel:USDT</h3>';

     $thismlabel = '<h4><b>USDT Top-Up</b></h4>';

   }

   ?>

<?php

   // include get code //

    include_once('get/get-code.php'); // this is used for include get code //

     // end of includeget code //

    ?> 

<!-- title -->

<?php

   // include nav //

   include_once('nav/nav.php'); // this is used for include nav //

   // end of include nav // ?>  

<title>Deposit</title>

<body class="customer">

   <section id="first">

      <div class="container">

         <div class="row">

            <div class="col-md-12">

               <div class="top">

                  <?= $thisclabel ?>

                  <?= $thismlabel ?> 

                  <form method="post" class="deposit-form">

                     <?php // include variable //

                        include_once("variable/variable.php"); // this is used for include variable //

                        // end of include variable // ?>

                     <input class="waid" name="waid" type="hidden">

                     <input class="tpmid" name="tpmid" type="hidden" value="<?=$tpmid?>">

                     <input class="tximg" name="tximg" type="hidden">

                     <input class="Traded trad" id="trad" name="trad" type="text" placeholder="Please input the number of USDT to be traded">

                     <input id="deposit" class="deposit" name="deposit" type="hidden">

                     <div class="error-div"> <label class="number-error"></label></div>

                     <div class="btnss">

                        <div class="row">

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="30">30</button>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="50">50</button>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="100">100</button>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="300">300</button>

                              </div>

                           </div>

                        </div>

                        <div class="row">

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="500">500</button>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="1000">1000</button>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="5000">5000</button>

                              </div>

                           </div>

                           <div class="col-md-3">

                              <div class="prices">

                                 <button type="button" class="pricebtn" data-price="10000">10000</button>

                              </div>

                           </div>

                        </div>

                        <div class="down">

                           <h4><b>Receiver's address</b></h4>

                           <input class="waddress" name="waddress" type="hidden">

                           <input class="copytxt" name="copytxt" id="copytxt" type="text" readonly>

                           <button class="btn btn-copy" type="button" onclick="copy(copytxt,'copy')">Copy</button>

                        </div>

                        <div class="imgearea">

                           <h4><b>Transaction TXID or Transaction HASH</b></h4>

                           <p><span>Note:</span>(it is forbidden to use TXID or HASH of other users,and the account will be frozen if found)</p>

                           <input class="Traded txid" id="txid" type="text" name="txid" placeholder="Fill in transaction TXID or transaction HASH">

                           <div class="error-div"> <label class="txid-error"></label></div>

                           <div class="chooseimg">

                              <!-- actual upload which is hidden -->

                              <input type="file" name="file" id="file" class="file" hidden/>

                              <!-- our custom upload button -->

                              <label for="file">Upload Transaction Certificate</label>

                              <div class="img-error-div">

                                 <div class="img-preview"></div>

                              </div>

                              <div class="img-error-div">  

                                 <label class="img-error"></label>

                              </div>

                           </div>

                           <div class="conbtn">

                              <button id="confirm" class="confirm" type="button">Confrim</button>

                           </div>

                           <div class="msg-div">  

                              <label class="success-txt"></label>

                           </div>

                           <div id="success-d">

                              <h5 class="ebay ttxt"></h5>

                              <div class="txt">

                                 <h5 class="htxt"></h5>

                              </div>

                              <div class="sub-btns">

                                 <button type="button" class="btn cancel" onclick="hidesuccess()">Close</button>

                              </div>

                           </div>

                        </div>

                     </div>

                  </form>

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

<script>

   // hide success function //

   function hidesuccess() {

      $('#success-d').hide();

     } 

   // end of hide success function //

   

       // show success function //

               function show_success(title ='',msg='',icon='')

               {

                var title = title;

                var msg = msg;

                var icon = icon;

                $('.ttxt').html(title);   

                $('.htxt').html(msg +' '+ icon);  

                $('#success-d').show();

               }

          // end of show success function //

      

   

      // copy function //

      function copy(id='',data='') {

       var id = id;

       var data = data;

       var thisclass = '';

       if(data == 'copy')

       { 

         thisclass = '.btn-copy';

       }

       var range = document.createRange();

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

      

      //function disable button //

        function disablebutton()

        {

        $('#confirm').css('background-color','#dee2e6');

        $('#confirm').attr('disabled',true);

        } 

        

      // end of function disable button //

      

       // function disable input //

        function disableinput()

        {

        $('.deposit-form').find('input.waddress').attr('disabled',true);

        $('.deposit-form').find('input.trad').attr('disabled',false);

        $('.deposit-form').find('button.pricebtn').attr('disabled',false);

        $('.deposit-form').find('input.file').attr('disabled',true);

        $('label[for=file]').css('cursor','default');

        }

       // end of function disable input //

      

      

       // function disable file //

        function disablefile()

        {

        $('.deposit-form').find('input.file').attr('disabled',true);

        $('label[for=file]').css('cursor','default');

        }

      

       // end of function disable file //

      

      

      // function enable button //

        function enablebutton()

        {

        $('#confirm').css('background-color','#FF8B02');

        $('#confirm').attr('disabled',false);

        }

      

       // end of function enable button //

      

       // function enable input //

        function enableinput()

        {

        $('.deposit-form').find('input.waddress').attr('disabled',false);

        $('.deposit-form').find('input.txid').attr('disabled',false);

        $('.deposit-form').find('input.file').attr('disabled',true);

        $('.deposit-form').find('button.pricebtn').attr('disabled',false);

        $('label[for=file]').css('cursor','default');

        }

      

       // end of function enable input //

      

       // function enable file //

        function enablefile()

        {

        $('.deposit-form').find('input.file').attr('disabled',false);

        $('label[for=file]').css('cursor','pointer');

        }

      

       // end of function enable file //

      

       // function reset form //

        function resetform()

        {

         $('.deposit-form').find('.trad').val('');

         $('.deposit-form').find('.txid').val('');

         $('.deposit-form').find('.tximg').val('');

         $('.img-preview').html('');

         $('.img-error').html('');

      

        }

       // end of function reset form //

      

      // function valid txtid //

      function validnumber(val='')

      {

        var val = val;

        var number = /^[0-9]+$/; 

        if(val.match(number))

          {

           $('.number-error').html("");

             enablebutton();

             enableinput();

          }       

         else

          {

           $('.number-error').html("Please enter valid number of (USDT)!");

           disablebutton();

           disableinput();

          }

      }    

      // end of function valid txtid //

      

      // function deposit //

      function checkdeposit(txid='')

      {

        var txid = txid;

      

           $.ajax({

                  url:"check/check-deposit.php",

                  type:"post",

                  data:{txid : txid},

                  dataType:"text",

                  success:function(result){

                   if(result == 1)

                   {

                     $('.txid-error').html('This transaction id has been expired!');

                     disablebutton();

                     disablefile();

                   }else{

                     $('.txid-error').html('');

                     enablefile();

                   }

                  }

               });

      

      }    

      // end of function check deposit //

      

      // function valid txtid //

      function validtxid(txid='')

      {

        var txid = txid;

        var hash = /\b[^>]*>([\s\S]*?)<\//gm;

        var string = /^[a-zA-Z'-]+$/;

        var number = /^[0-9]+$/;

      

        if(txid.match(hash) && txid.length == 0)

        {

         $('.txid-error').html("");

         checkdeposit(txid);

        }

        else if(txid.match(string) && txid.length !=0)

         {

          $('.txid-error').html("");

          checkdeposit(txid);

         }  

         else if(txid.match(number) && txid.length !=0)

          {

           $('.txid-error').html("");

           checkdeposit(txid);

          }       

         else

          {

           $('.txid-error').html("Please enter valid (TXID/HASH)!");

           disablebutton();

          }

      }    

      // end of function valid txtid //

      

      // get wallet function //

              function get_wallet()

              {

                var id = id;

                var waid= '';

                var waddress = '';

                $.ajax({

                  url:"get/get-wallet.php",

                  type:"post",

                  dataType:"json",

                  success:function(result){

                     waid = result.waid;

                     waddress = result.waddress;

                     if(waddress == ''){

                     $('.btn-copy').attr('disabled',true);

                     $('input,button').attr('disabled',true);

                     $('.txid').html('You can`t be deposit without wallet address!');

                     $('.waid').val(waid);

                     $('.copytxt').val(waddress);

                     $('.waddress').val(waddress);

                     }else{

                     $('.btn-copy').attr('disabled',false);

                     $('input,button').attr('disabled',false);

                     $('.txid').html('');

                     $('.waid').val(waid);

                     $('.copytxt').val(waddress);

                     $('.waddress').val(waddress);

                    }

                  }

               });

              }

              // end of get wallet function //

        

      

      //save function //

           function save(data='')

            {

             var data = data;

             var title = '';

             var msg = '';

             var icon = '';

             $.ajax({

               url:"insert/save-deposit.php",

               method:"post",

               data:data,

               dataType:"json",

               beforeSend:function(){

                disablebutton();

               },

               success:function(result){

                title = 'Deposit';  

                msg = result.msg;

                icon = '<i class="fa fa-check" aria-hidden="true" id="icon-s"></i>';

                if(msg!='Failed')

                {   

                 setTimeout(function(){

                 disablebutton();

                 disableinput();

                 show_success(title,msg,icon);

                 resetform();

                },400);

                 setTimeout(function(){

                  hidesuccess();

                 },3000);

               }

           }

             });

           }

           //end of save function //

      

      setInterval(get_wallet,100);

      

      

      // start jquery //

      $(document).ready(function(){

      

      disablebutton();

      disableinput();

       // call get method function //

      $('body').on('click','button.pricebtn',function(){

         var price = $(this).attr('data-price');

         var txid = $('.txid').val();

         var tximg = $('.tximg').val();

         $('.trad').val(price);

         $('.deposit').val(price);

         enableinput();

         validtxid(txid);

         if(tximg!=''){

         enablebutton();

         }

      

       });

       //  end of call get method function //

      

       // reset feild function //

      $('.trad').on('keyup', function(){

      var trad = $('.trad').val();

      var txid = $('.txid').val();

      var tximg = $('.tximg').val();

      if(trad == ''){

       disablebutton();

       disableinput();

       $('.deposit').val('');

       $('.txid').val('');

       $('.number-error').html("");

       $('.img-error').html("");

       $(".tximg").val("");

       $('.img-preview').html('');

      }else{

       validnumber(trad);

       $('.deposit').val(trad);

       validtxid(txid);

       if(tximg!=''){

        enablebutton();

       }

      }

      });

      // end of reset feild function //

      

      // call valid txid function //

      $('.txid').on('keyup', function(){

      var txid = $('.txid').val();

      var tximg = $('.tximg').val();

      if(txid == '' && tximg!=''){

       $('.deposit-form').find('input.txid').attr('disabled',false);

       $('.deposit-form').find('input.file').attr('disabled',true);

       $('label[for=file]').css('cursor','default');

       $('.tximg').val('');

       $('.img-preview').html('');

       $('.txid-error').html("");

       disablebutton();

      }

      else if(txid == '' && tximg ==''){

        $('.deposit-form').find('input.txid').attr('disabled',false);

       $('.deposit-form').find('input.file').attr('disabled',true);

        $('label[for=file]').css('cursor','default');

       $('.txid-error').html("");

       $('.tximg').val('');

       $('.img-preview').html('');

       disablebutton();

      }

      else{

       if(tximg!=''){

        enablebutton();

       }

       validtxid(txid);

      }

      });

      

      // end of call valid txid function //

      

                        // upload function //

                       var _URL = window.URL || window.webkitURL;

                       var thisimage = '';   

                       $('#file').change(function () {

                       var file = $(this)[0].files[0];

                       var name = document.getElementById("file").files[0].name;

                       var form_data = new FormData();

                       var ext = name.split('.').pop().toLowerCase();

                       img = new Image();

                       var imgwidth = 0;

                       var imgheight = 0;

                       var maxwidth = 640;

                       var maxheight = 640;

                       if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 

                       {

                       $('.img-error').html("Invalid File");

                        $(".tximg").val("");

                        $('.img-preview').html('');

                        disablebutton();

                       

                       }

                       var oFReader = new FileReader();

                       oFReader.readAsDataURL(document.getElementById("file").files[0]);

                       var f = document.getElementById("file").files[0];

                       var fsize = f.size||f.fileSize;

                       if(fsize > 2000000)

                       {

                       $('.img-error').html(" File Size must be 10 kb ...");

                       $(".tximg").val("");

                       $('.img-preview').html('');

                       disablebutton();

      

                       }

                       

                       img.src = _URL.createObjectURL(file);

                       img.onload = function() {

                       imgwidth = this.width;

                       imgheight = this.height;

                       

                       // if(imgwidth <= maxwidth && imgheight <= maxheight){

                       

                       var formData = new FormData();

                       formData.append('file', $('#file')[0].files[0]);

                       var url = "upload/upload.php";

                       var method = "POST";  

                            $.ajax({

                                  url: url,

                                  type: method,

                                  data: formData,

                                  processData: false,

                                  contentType: false,

                                  dataType: 'json',

                                  beforeSend:function(){

                                  $('.img-error').html("uploading...");

                                  $('.img-preview').html('');

                                 },

                       success: function (data) {

                       var imageurl = data.imageurl;

                       var image = data.image;

                       if(image == '')

                       {

                       $('.img-error').html("This image already exists");

                       $(".tximg").val("");

                       $('.img-preview').html('');

                       disablebutton();

      

                       }else

                       {

      

                       thisimage = 'backend/public/images/deposit/'+image;   

                       $('.img-preview').html("<label class='text-success'><strong><img src='"+thisimage+"' style='width:50px;height:50px;'></strong></label>");

                       $(".tximg").val(image);

                       $('.img-error').html("");

                       enablebutton();

                     

                       }

                                  }

                             });

                       };

                       });

                       // end of upload function //

      

             // call save function on click //

             $('body').on('click','.confirm',function(){

             var data = '';

             var txid = '';

             var tximg = '';

             data = $('.deposit-form').serialize();

             txid = $('.txid').val();

             var tximg = $('.tximg').val();

             if(txid == ''){

              $('.txid-error').html('Please enter valid (TXID/HASH)!');

             }

             if(tximg == ''){

               $('.img-error').html("Transaction certificate can`t be empty!");

             }

             else if(txid == ''){

              $('.txid-error').html('Please enter valid (TXID/HASH)!');

             }

             else if(tximg == ''){

               $('.img-error').html("Transaction certificate can`t be empty!");

             }

             else{

              save(data);

             }

           });

         // end of call save function on click //

      });

      // end of jquery //

</script>