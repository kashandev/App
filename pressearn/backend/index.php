<?php
// include login header //
include_once('login-header.php'); // this is used for include login header //
 // end of include login header //
// include conn //
include_once ('../conn/conn.php'); // this is used for include conn //
// end of include conn //
// variables //

    $sql          = "SELECT * from users where roleid = 1 ";
    $res          = mysqli_query($conn, $sql);
    $total_row        = mysqli_num_rows($res);
//check total rows //
if($total_row==0){
$this_form = '<div class="row">
                <div class="col-md-4">
            <div class="form">
           
     <form action="{action}" method="{method}" class="log-form">
    <div class="form-group">
            <div class="login-success">  
            <label class="login-txt"></label>
            </div>   
            
    <div class="login-error">  
            <label class="error-txt"></label>
            </div>           
    </div>
                    <div class="form-group">
                <input type="text" id="email_id" class="form-control email" name="email" placeholder="Username">                    
                     </div>
              <div class="login-error">  
            <label class="error-email"></label>
            </div>           
                     <div class="form-group">
                        <input type="password" id="password" class="form-control password" name="password" placeholder="Password">                    
                     </div>
                          <div class="login-error">  
            <label class="error-password"></label>
            </div>           
                     <div class="form-actions">
                        <button type="button" class="btn btn-bricky btn-block login-btn">Log In</button>                    
                     </div>
                </form>
            </div>
        </div>
        </div>';
}else{

  $this_message = "";
  $this_form = '<div class="row">
                <div class="col-md-4">
            <div class="form">
           
     <form action="{action}" method="{method}" class="log-form">
    <div class="form-group">
            <div class="login-success">  
            <label class="login-txt"></label>
            </div>   
            
    <div class="login-error">  
            <label class="error-txt"></label>
            </div>           
    </div>
                    <div class="form-group">
                <input type="text" id="email_id" class="form-control email" name="email" placeholder="Username">                    
                     </div>
              <div class="login-error">  
            <label class="error-email"></label>
            </div>           
                     <div class="form-group">
                        <input type="password" id="password" class="form-control password" name="password" placeholder="Password">                    
                     </div>
                          <div class="login-error">  
            <label class="error-password"></label>
            </div>           
                     <div class="form-actions">
                        <button type="button" class="btn btn-bricky btn-block login-btn">Log In</button>                    
                     </div>
                </form>
            </div>
        </div>
        </div>';
}
                      
//end of check total rows //
?>
<body>
    <div class="backimg">
    <section class="logo">
        <div class="mycontainer">
            <div class="allogo">
                <img src="public/images/logo/logo_79x80.png" alt="">
            </div>
        </div>
    
    </section>
    
    <section class="loginform">
        <div class="success-message-div">
            <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-success" role="alert"><strong class="successtxt "></strong></div>
            </div>
          </div>
      </div>

           <div class="error-message-div">
            <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-danger" role="alert"><strong class="errortxt"></strong><strong><span id="timer" class="timer"> </span></strong></div>
            </div>
          </div>
          </div>

   <div class="signout-message-div">
<div class="row">
<div class="col-sm-12">
<div class="alert alert-success" role="alert"><strong class="signouttxt"></strong></div>
</div>
</div>    
</div>   
               
<div class="container">            
<input type="hidden" name="signout_message" class="form-control signout_message" value="<?php echo $signout_message ?>">
<input type="hidden" name="unset_session" class="unset_session" value="<?php echo unset_session()?>"> 
        <?php echo $this_form?>        
   <?php
   // include login footer //
   include_once('login-footer.php'); // this is used for include login footer //
    // end of include login  footer //
     ?>       
    </section>
</div>
</body>