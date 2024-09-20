<?php

// include header //

include_once 'header.php';

// this is used for include header //

// end of include header //

?>

<?php

$waid = '';

$cid = '';

$company = '';

$wadd = '';

$isdeleted = '';

$isedit = '';

$isrestore = '';

$isactive = '';

$thiswaid = '';

$thiscid = '';

$thisname = '';

$thiswadd = '';

$thiscompany = '';

$thisstatus = '';

$thishref = '';

$thismsglabel = '';

$thisheading = '';

$thisaction = '';

$thisactive = '0';

$thischecked = '';

$sql = '';

$res = '';

if (isset($_GET['wallet']) == '') {

    $_GET['wallet'] = '';

    $wallet = '';

    $thisheading = 'Add Wallet';

    $thisaction = ' 

       <button type="button" class="btn btn-primary btn-save" style="background-color:#dee2e6;border:1px solid #dee2e6;" disabled> <i class="fa fa-save"></i> Save </button>

       <button type="button" class="btn btn-default btn-squared btn-cancel"> <i class="fa fa-arrow-close"></i> Cancel </button>

       <button type="button" class="btn btn-primary" onclick=window.location.href="wallet.php"><i class="fa fa-arrow-left"></i> Back </button>';

}

if (isset($_GET['wallet'])) {

    $wallet = $_GET['wallet'];

    $thisheading = 'Update Wallet';

    $thisaction = '

       <button type="button" class="btn btn-primary btn-update"><i class="fa fa-undo"></i> Update </button>

       <button type="button" class="btn btn-primary" onclick=window.location.href="wallet.php"> <i class="fa fa-arrow-left"></i> Back </button>';

}

if (!empty($wallet)) {

    $sql =

        "SELECT wallet_address.*,company.company from wallet_address inner join company on company.cid = wallet_address.cid where wallet_address.isdeleted = 0 and wallet_address.waid = '" . $wallet . "' order by wallet_address.waid desc";

    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res)) {

        foreach ($res as $key => $row) {

            $key++;

            $waid = $row['waid'];

            $cid = $row['cid'];

            $company = $row['company'];

            $name = $row['name'];

            $wadd = $row['waddress'];

            $isactive = $row['isactive'];

            $isdeleted = $row['isdeleted'];

            $isrestore = $row['isrestore'];

            $isedit = $row['isedit'];

            $status = $row['status'];

            $thiswaid = $waid;

            $thiscid = $cid;

            $thisname = $name;

            $thiswadd = $wadd;

            $thiscompany = $company;

            if ($isactive == 1) {

                $thisactive = 1;

                $thischecked = 'checked="checked"';

            } else {

                $thisactive = 0;

                $thischecked = '';

            }

        }

    } else {

        $thisheading = 'Add Wallet';

        $thisaction = ' 

      <button type="button" class="btn btn-primary btn-save" style="background-color:#dee2e6;border:1px solid #dee2e6;" disabled> <i class="fa fa-save"></i> Save </button>

       <button type="button" class="btn btn-default btn-squared btn-cancel"> <i class="fa fa-close"></i> Cancel </button>

       <button type="button" class="btn btn-primary" onclick=window.location.href="wallet.php"> <i class="fa fa-arrow-left"></i> Back </button>';

    }

} else {

    $thisheading = 'Add Wallet';

    $thisaction = ' 

       <button type="button" class="btn btn-primary btn-save" style="background-color:#dee2e6;border:1px solid #dee2e6;" disabled> <i class="fa fa-save"></i> Save </button>

       <button type="button" class="btn btn-default btn-squared btn-cancel"> <i class="fa fa-close"></i> Cancel </button>

       <button type="button" class="btn btn-primary" onclick=window.location.href="wallet.php"> <i class="fa fa-arrow-left"></i> Back </button>';

}

?>



<!-- title -->

<title><?php echo $thisheading ?></title>

<!-- /.title -->

<?php

   // include form style //

   include_once('style/form-style.php'); // this is used for include form style //

    // end of include form style // ?>

<?php

   // include toggle style //

   include_once('style/toggle-style.php'); // this is used for include toggle style //

    // end of include toggle style // 

   ?> 

<!-- body -->

<body class="page-full-width generic-content">

   <?php

      // include top nav //

      include_once('top-nav.php'); // this is used for include top nav //

      // end of include top nav // ?>

   <div class="main-container">

      <div class="container">

         <div class="cms-wrap panel-scroll-  panel-default" style="height: 458px;">

            <div class="panel-body wrapper-panel autoheight" style="height: 458px;">

               <!-- start: DYNAMIC TABLE PANEL -->

               <div class="panel panel-default">

                  <div class="panel-heading top-heading">

                     <h2> <?php echo $thisheading ?> </h2>

                     <?php

                        // include message //

                        include_once('message/message.php'); // this is used for include message //

                        // end of include message // ?>      

                  </div>

                  <div class="panel-body">

                     <div class="top-content">

                        <div class="row">

                        </div>

                     </div>

                     <div id="w0" class="grid-view">

                        <form id="w0" class="form-horizontal wallet-form" method="post" role="form">

                           <?php // include variable //

                              include_once("variable/variable.php"); // this is used for include variable //

                              // end of include variable // ?>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Name</label>

                              <div class="col-sm-4">

                                 <input type="hidden" id="waid" class="form-control waid" name="waid" value="<?php echo $thiswaid ?>">    

                                 <input type="hidden" id="cid" class="form-control cid" name="cid" value="<?php echo $thiscid ?>">     

                                 <input type="text" id="tblcntseller-name" class="form-control name" name="name" maxlength="100" placeholder="Name" value="<?php echo $thisname ?>">

                                 <label class="invalid-div">

                                    <div class="error-name">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Wallet Address</label>

                              <div class="col-sm-4">

                                 <input type="text" id="tblcntseller-name" class="form-control wadd" name="wadd" maxlength="100" placeholder="Wallet Address" value="<?php echo $thiswadd ?>">

                                 <label class="invalid-div">

                                    <div class="error-address">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Company</label>

                              <div class="col-sm-4">

                                 <input type="text" id="tblcntseller-name" class="form-control company-name" name="company" maxlength="100" placeholder="Company" value="<?php echo $thiscompany ?>">

                                 <label class="invalid-div">

                                    <div class="error-companys">

                                    </div>

                                 </label>

                              </div>

                           </div>

                           <div class="form-group field-tblcntseller-name required">

                              <label class="control-label col-sm-1" for="tblcntseller-name">Active</label>

                              <div class="col-sm-8">

                                 <div class="row">

                                    <div class="col-lg-1">

                                       <div class="row">

                                          <div class="col-sm-12">

                                             <div class="toggle-button-cover">

                                                <div class="button-cover">

                                                   <div class="button r" id="button-1">

                                                      <input type="checkbox" class="checkbox isactive" id="isactive" name="isactive" value="<?php echo $thisactive ?>" <?php echo $thischecked ?> />

                                                      <div class="knobs"></div>

                                                      <div class="layer"></div>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>

                           <div class="col-sm-1"></div>

                           <div class="form-group field-tblcntseller-name required">                                         

                              <?php echo $thisaction ?>

                           </div>

                        </form>

                     </div>

                  </div>

               </div>

               <!-- end: DYNAMIC TABLE PANEL -->

               <div class="clear"></div>

            </div>

         </div>

      </div>

   </div>

</body>

<!-- /.body -->

<?php

   // include footer //

   include_once('footer.php'); // this is used for include footer //

    // end of include footer // ?>  

<script type="text/javascript">

   // function disable button //

   function disablebutton()

   {

   $('.btn-save').css('background-color','#dee2e6');

   $('.btn-save').css('border','1px solid #dee2e6');

   $('.btn-save').attr('disabled',true);

   }

   

   // end of function disable button //

   

   // function disable update button //

   function disableupdatebutton()

   {

   $('.btn-update').css('background-color','#dee2e6');

   $('.btn-update').css('border','1px solid #dee2e6');

   $('.btn-update').attr('disabled',true);

   }

   

   // end of function disable update button //

   

   

   // function enable button //

   function enablebutton()

   {

   $('.btn-save').css('background-color','#089000');

   $('.btn-save').css('border','1px solid #089000');

   $('.btn-save').attr('disabled',false);

   

   }

   // end of function enable button //

   

   

   // function enable update button //

   function enableupdatebutton()

   {

   $('.btn-update').css('background-color','#089000');

   $('.btn-update').css('border','1px solid #089000');

   $('.btn-update').attr('disabled',false);

   

   }

   // end of function enable update button //

   

   

   // reset form function //

   

   function resetform()

   {

     $('.wallet-form').trigger('reset');

     $('.wallet-form').find('input.isactive').val(0);

     $('.wallet-form').find('input.active').attr('checked',false);

     disablebutton();

   }

   // end of reset form function //

   

     

   //function save//

   function save(data='')

   { 

   var data = data;

   var msg = '';

   $.ajax({

     url:"insert/save-wallet.php",

     method:"POST",

     data:data,

     dataType:'json',

     beforeSend:function()

     {

      disablebutton();

     },

     success:function(data)

     { 

      msg = data.msg;

      setTimeout(function()

      {

       $('.alert-info').hide();

       $('.alert-success').show();

       $('.alert-success').html(msg);

       $('.alert-success').fadeOut(3000); 

       resetform();

      },400);

   

       setTimeout(function()

      {

        window.location.href = 'wallet.php';

       },3600);   

     }

   });

   }

   

   // end of function save //



   //function update//

   function update(data='')

   { 

   var data = data;

   var msg = '';

   $.ajax({

     url:"update/update-wallet.php",

     method:"POST",

     data:data,

     dataType:'json',

     beforeSend:function()

     {

      disableupdatebutton();

     },

     success:function(data)

     { 

      msg = data.msg;

      setTimeout(function()

      {

       enableupdatebutton(); 

       $('.alert-info').hide();

       $('.alert-success').show();

       $('.alert-success').html(msg);

       $('.alert-success').fadeOut(3000); 

      },400);

   

      setTimeout(function()

      {

        window.location.href = 'wallet.php';

       },3600);   

     }

   });

   }

   // end of function update //

   

   

   // function valid text //

   function validtext(val='')

   {

   var val = val;

   var string = /^[a-zA-Z'-]+$/;

   if(val.match(string) && val.length !=0)

     {

        $('.error-name').html("");

     }  

    else

     {

      $('.error-name').html("Please enter valid name !");

      disablebutton();

     }

   }    

   // end of function valid text //

   

   // function valid company //

   function validcompany(val='')

   {

   var val = val;

   var string = /^[a-zA-Z'-]+$/;

   if(val.match(string) && val.length !=0)

     {

        $('.error-company').html("");

        $('.company').attr('disabled',false);

        enablebutton();

     }  

    else

     {

      $('.error-company').html("Please enter valid company name !");

      disablebutton();

     }

   }    

   // end of function valid company //

   

   

   

   

   // start jquery //

   $(document).ready(function(){

    disablebutton();

   

   

   

                // call save function //

                $('body').on('click','.btn-save',function(){

                  var data = $('.wallet-form').serialize();

                  var name = $('.name').val();

                  var wadd = $('.wadd').val();

                  var company = $('.company-name').val();

                  var body = $("html, body");

                  body.stop().animate({scrollTop:0}, 500, 'swing', function() { 

                 }); 

   

                  if(name == '')

                  {

                   $('.error-name').html("name can't be empty")

   

                  }

                  if(wadd == '')

                  {

                   $('.error-address').html("wallet address can't be empty")

   

                  }

                 if(company == '')

                  {

                   $('.error-address').html("company can't be empty")

   

                  }                     

                  else

                  { 

                  if(name == '')

                  {

                   $('.error-b-name').html("name can't be empty")

   

                  }

                  if(wadd == '')

                  {

                   $('.error-address').html("wallet address can't be empty")

   

                  }

                 if(company == '')

                  {

                   $('.error-address').html("company can't be empty")

   

                  }

                  else{

                   save(data); 

                  }

                  }

                });

                // end of call save function //

   

               // call update function //

                $('body').on('click','.btn-update',function(){

                  var data = $('.wallet-form').serialize();

                  var name = $('.name').val();

                  var wadd = $('.wadd').val();

                  var company = $('.company-name').val();

                  var body = $("html, body");

                  body.stop().animate({scrollTop:0}, 500, 'swing', function() { 

                 }); 

   

                  if(name == '')

                  {

                   $('.error-name').html("name can't be empty")

   

                  }

                  if(wadd == '')

                  {

                   $('.error-address').html("wallet address can't be empty")

   

                  }

                 if(company == '')

                  {

                   $('.error-address').html("company can't be empty")

   

                  }                     

                  else

                  { 

                  if(name == '')

                  {

                   $('.error-b-name').html("name can't be empty")

   

                  }

                  if(wadd == '')

                  {

                   $('.error-address').html("wallet address can't be empty")

   

                  }

                 if(company == '')

                  {

                   $('.error-address').html("company can't be empty")

   

                  }

                  else{

                   update(data); 

                  }

                  }

                });

                // end of call update function //

   

   

                 // cancel function //

                 $('body').on('click','.btn-cancel',function(){

                  resetform();

                 });

                 // end of cancel function //

                // reset feild function //

                 $('body').on('keyup','.name',function(){

                  var name = $('.name').val();

                  if(name == '')

                  {

                   $('.error-name').html("");

                  }else

                  {

                   validtext(name);

                   disablebutton();

   

                  }

                 });

   

                  $('body').on('keyup','.company-name',function(){

                  var company = $('.company-name').val();

                  if(company == '')

                  {

                   $('.error-company').html("");

                   disablebutton();

                  }else

                  {

                   validcompany(company);

                  }

                 });                   

                // end of reset feild function //

   

   

   

   // set scheckbox value //

   document.getElementById('isactive').addEventListener('change', (e) => {

   this.checkboxValue = e.target.checked ? '1' : '0';

   $('.isactive').val(this.checkboxValue);

   if(this.checkboxValue ==  1){

   $('#isactive').attr('checked',true);
   $('#isactive').val(1);

   }else{

   $('#isactive').attr('checked',false);
   $('#isactive').val(0);

   }

   });   

   

   // end of set checkbox value //

   

   });

   // end of jquery //

   

</script>