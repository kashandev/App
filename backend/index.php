<body>
   <?php
      // include login header
      include_once('login-header.php'); // this is used for include login header
      // include conn
      include_once('conn/config.php'); // this is used for include conn
      ?>
   <?php
      // variables
      $sql = "SELECT * FROM users WHERE roleid = 1";
      $res = mysqli_query($conn, $sql);
      $total_row = mysqli_num_rows($res);
      
      // Check total rows
      if ($total_row == 0) {
          $this_form = '<div class="card login-card">
                          <div class="card-body text-center">
                              <div class="login-title">
                                  <h1>Main Admin Panel</h1>
                                  <h2>Sign in to your account</h2>
                              </div>
                              <form action="{action}" method="{method}" class="log-form">
                                  <div class="form-group">
                                      <label for="email_id">Username</label>
                                      <div class="input-group">
                                          <i class="fas fa-user"></i>
                                          <input type="text" id="email_id" class="form-control email" name="email" placeholder="Username">
                                      </div>
                                      <div class="login-error">  
                                          <label class="error-email"></label>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="password">Password</label>
                                      <div class="input-group">
                                          <i class="fas fa-lock"></i>
                                          <input type="password" id="password" class="form-control password" name="password" placeholder="Password">
                                      </div>
                                      <div class="login-error">  
                                          <label class="error-password"></label>
                                      </div>
                                  </div>
                                  <div class="form-actions">
                                      <button type="button" class="btn btn-primary btn-block login-btn">Log In</button>
                                  </div>
                              </form>
                          </div>
                      </div>';
      } else {
          $this_message = "";
          $this_form = '<div class="card login-card">
                          <div class="card-body text-center">
                              <div class="login-title">
                                  <h1>Main Admin Panel</h1>
                                  <h2>Sign in to your account</h2>
                              </div>
                              <form action="{action}" method="{method}" class="log-form">
                                  <div class="form-group">
                                      <label for="email_id">Username</label>
                                      <div class="input-group">
                                          <i class="fas fa-user"></i>
                                          <input type="text" id="email_id" class="form-control email" name="email" placeholder="Username">
                                      </div>
                                      <div class="login-error">  
                                          <label class="error-email"></label>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="password">Password</label>
                                      <div class="input-group">
                                          <i class="fas fa-lock"></i>
                                          <input type="password" id="password" class="form-control password" name="password" placeholder="Password">
                                      </div>
                                      <div class="login-error">  
                                          <label class="error-password"></label>
                                      </div>
                                  </div>
                                  <div class="form-actions">
                                      <button type="button" class="btn btn-primary btn-block login-btn">Log In</button>
                                  </div>
                              </form>
                          </div>
                      </div>';
      }
      ?>
   <section class="loginform">
      <div class="success-message-div">
         <div class="alert alert-success" role="alert"><strong class="successtxt "></strong></div>
      </div>
      <div class="error-message-div">
         <div class="alert alert-danger" role="alert"><strong class="errortxt"></strong><strong><span id="timer" class="timer"> </span></strong></div>
      </div>
      <div class="signout-message-div">
         <div class="alert alert-success" role="alert"><strong class="signouttxt"></strong></div>
      </div>
      <div class="container">
         <input type="hidden" name="signout_message" class="form-control signout_message" value="<?php echo $signout_message ?>">
         <input type="hidden" name="unset_session" class="unset_session" value="<?php echo unset_session() ?>">
         <?php echo $this_form ?>
      </div>
   </section>
   <?php
      // include login footer
      include_once('login-footer.php'); // this is used for include login footer
      ?>
</body>
</html>