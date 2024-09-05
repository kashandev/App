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
   <!-- title -->
    <?php
      // include nav //
      include_once('nav/nav.php'); // this is used for include nav //
      // end of include nav // ?>  
<!-- title -->

 <link rel="stylesheet" href="css/profile.css" />
<title>Edit Profile Pic</title>
<body class="teamreports">

<section id="screens">
<div class="container-fluid">
    <div class="mediascreens pr">
       <?php // include variable //
      // include variable //
      include_once "variable/variable.php"; // this is used for include variable //
        // end of include variable // ?>
         <input type="hidden" class="image" name="image">
            <div class="row no-gutters ">
                    <div class="col-md-12 col-sm-6">
                    <div class="search-bar epp">
                                <h3>Edit Profile Picture</h3>
                    </div>
                    <div class="images_list">
                            <li class="border-pc" image="michael-jai.jpg">
                                <img src="images/profile/michael-jai.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="messi.jpg">
                                <img src="images/profile/messi.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="owen.jpg">
                                <img src="images/profile/owen.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="ronaldo.jpg">
                                <img src="images/profile/ronaldo.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="Rupert.jpg">
                                <img src="images/profile/Rupert.jpg" width="150" height="150" />
                            </li>
                    </div>
                    <div class="images_list">
                            <li class="border-pc" image="triple-h.jpg">
                                <img src="images/profile/triple-h.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="josh-duhamel-2011-mtv-movie-awards-01.jpg">
                                <img src="images/profile/josh-duhamel-2011-mtv-movie-awards-01.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="jhon.jpg">
                                <img src="images/profile/jhon.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="img-14.jpg">
                                <img src="images/profile/img-14.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="img-15.jpg">
                                <img src="images/profile/img-15.jpg" width="150" height="150" />
                            </li>
                    </div>
                    <div class="images_list">
                            <li class="border-pc" image="img-16.jpg">
                                <img src="images/profile/img-16.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="img-20.jpg">
                                <img src="images/profile/img-20.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="img-24.jpg">
                                <img src="images/profile/img-24.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="img-25.jpg">
                                <img src="images/profile/img-25.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="img-30.jpg">
                                <img src="images/profile/img-30.jpg" width="150" height="150" />
                            </li>
                    </div>
                    <div class="images_list">
                            <li class="border-pc" image="harvey.jpg">
                                <img src="images/profile/harvey.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="Emma.jpg">
                                <img src="images/profile/Emma.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="Daniel.jpg">
                                <img src="images/profile/Daniel.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="Brad-Pitt.jpg">
                                <img src="images/profile/Brad-Pitt.jpg" width="150" height="150" />
                            </li>
                            <li class="border-pc" image="batista.jpg">
                                <img src="images/profile/batista.jpg" width="150" height="150" />
                            </li>
                    </div>
                    <div class="conbtn save">
                              <button id="confirm" class="confirm btn-save" type="button">Save</button>
                              <button class="backk" type="button" onclick="window.location.href='<?php echo $thisaurl?>'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</button>
                           </div>

     <div id="success-d">
      <h5 class="ebay ttxt"></h5>
      <div class="txt">
         <h5 class="htxt"></h5>
      </div>
      <div class="sub-btns">
         <button type="button" class="btn cancel" onclick="hidemsg()">Close</button>
      </div>
   </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script>

// hide success function //
function hidemsg() {
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
   

       //function disable button //
     function disablebutton()
     {
     $('#confirm').css('background-color','#dee2e6');
     $('#confirm').attr('disabled',true);
     } 
     
   // end of function disable button //
   

   // function enable button //
     function enablebutton()
     {
     $('#confirm').css('background-color','#FF8B02');
     $('#confirm').attr('disabled',false);
     }
   
    // end of function enable button //
   


    // update image function //
            function update_image(uid='',uname='',img='')
            {
             var tlvid = tlvid;
             var uid = uid;
             var uname = uname;
             var img = img;
             var title = '';
             var msg = '';
             var icon = '';
             var aurl = '';
             aurl ='<?php echo $thisaurl?>';
              $.ajax({
                url:"update/update-image.php",
                type:"post",
                data:{uid : uid, uname : uname, img : img},
                dataType:"json",
                beforeSend:function(){
                 disablebutton();
                },
                success:function(result){
                msg = result.msg;
                title = 'Edit Profile Picture';  
                icon = '<i class="fa fa-check" aria-hidden="true" id="icon-s"></i>';
                if(msg!='Failed')
               {   
              setTimeout(function(){
              disablebutton();
              show_success(title,msg,icon);
              },400);
              setTimeout(function(){
               hidemsg();
               $('.images_list .selected').removeClass('selected');
              },1100);

              setTimeout(function(){
               window.location.href=aurl;
              },1500);   
               }
             }
             });
   
            }
       // end of update oimage function //
   

   // start jquery //
$(document).ready(function(){

disablebutton();

// select image function //
$('.images_list li').click(function() {
			$('.images_list .selected').removeClass('selected');
			$(this).toggleClass('selected');
			var image= $(this).attr('image');
			$("#"+image).removeClass("hidden").siblings().addClass("hidden");
            $('.image').val(image);
            enablebutton();

		});
// end of select image function //

// call save function //
$('.btn-save').click(function() {
    var uid = $('.uid').val();
    var uname = $('.uname').val();
    var image = $('.image').val();
    update_image(uid,uname,image);

});
// end of call save function //

});
// end of jquery //   
</script>
</body>
 <?php
  // include footer //
  include_once('foot2.php'); // this is used for include footer //
 // end of include footer // ?>
