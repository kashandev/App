<?php
   // include header
   include_once('header.php'); // this is used for include header
   
   ?>
<body class="page-full-width generic-content">
   <?php
      // include top nav
      include_once('top-nav.php'); // this is used for include top nav
      ?>
   <section class="summary">
      <input type="hidden" name="user_name" class="user_name" value="<?php echo $user_name ?>">
      <input type="hidden" name="welcome_message" class="welcome_message" value="<?php echo $welcome_message ?>">
      <input type="hidden" name="unset_session" class="unset_session" value="<?php echo unset_session() ?>">
      <div class="row welcome-message-div">
         <div class="col-sm-12">
            <div class="alert alert-success text-center" role="alert">
               <strong class="welcometxt"></strong>
            </div>
         </div>
      </div>
      <div class="row" style="margin-top:8%;">
         <div class="col-xs-12">
            <div class="text-center">
               <h2 >Website Inquiry Details</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <div class="input-group">
               <input type="text" id="searchInput" class="form-control" placeholder="Search..." />
               <span class="input-group-btn">
               <button id="clearButton" class="btn btn-default" type="button">
               <i class="fa fa-times-circle"></i> Clear
               </button>
               </span>
            </div>
         </div>
      </div>
      <div id="recordInfo" class="mb-3 text-center"></div>
      <div class="table-responsive">
         <table id="inquiryTable" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>Website</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Country</th>
                  <th>Message</th>
                  <th>Date</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
      <div id="pagination" class="mt-3 d-flex justify-content-between align-items-center">
         <div>
            <button id="prevPage" class="btn btn-secondary">Previous</button>
            <button id="nextPage" class="btn btn-secondary">Next</button>
         </div>
         <nav aria-label="Page navigation">
            <ul class="pagination" id="pageNumbers"></ul>
         </nav>
         <span id="currentPageInfo"></span>
      </div>
   </section>
   <?php
      // include footer
      include_once('footer.php'); // this is used for include footer
      ?>
</body>
</html>