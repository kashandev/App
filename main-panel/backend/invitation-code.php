<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header // ?>
<!-- title -->
<title>Invitation Code</title>
<!-- /.title -->
<!-- body -->
<body class="page-full-width generic-content">
   <?php
      // include top nav //
      include_once('top-nav.php'); // this is used for include top nav //
      // end of include top nav // ?>
   <div class="main-container">
      <div class="container">
         <div class="cms-wrap panel-scroll-  panel-default" style="height: 468px;">
            <div class="panel-body wrapper-panel autoheight" style="height: 468px;">
               <div class="panel panel-default no-bg">
                  <div class="panel-heading top-heading">
                     <h2> Invitation Code </h2>
                  </div>
                  <div class="panel-body">
                     <div class="inv-search" style="position: absolute;top: 99px;z-index: 999;left: 260px;width: 63%;">
<?php
                        // include search box //
                        //include_once('search-box.php'); // this is used for include search box //
                        // end of include search box // ?>   
                     </div>
                     <br>
                     <div class="row">

                        <div class="col-md-12 ht-sauto-child panel-scrosll bg-white xmasrgin">

                           <div id="w0" class="grid-view">
   
                              <table class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                               
                                     <th><a href="/backend/web/index.php/customers/customers/index?sort=first_name" data-sort="first_name">Invitation Code</a></th>

 
                                       <th><a href="/backend/web/index.php/customers/customers/index?sort=email" data-sort="email">Allow</a></th>

                                        <th><a href="/backend/web/index.php/customers/customers/index?sort=email" data-sort="email">Used</a></th>

                                         <th><a href="/backend/web/index.php/customers/customers/index?sort=email" data-sort="email">Remaining</a></th>

                                       <th>Status</th>
      
                                    <th class="action-column">&nbsp;</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                     <tr>
                                       <td>
                                          <div class="empty"></div>
                                       </td>
                         
                                       <td>
                                          <div class="empty"></div>
                                       </td>
                                    
                                  
                                       <td>
                                          <div class="empty"></div>
                                       </td>
                                
                                    
                                       <td>
                                          <div class="empty"></div>
                                       </td>
                                    
                                    
                                       <td>
                                          <div class="empty"></div>
                                       </td>

                                         <td>
                                          <div class="empty"></div>
                                       </td>
                                    </tr>
                                <tr>
                                       <td colspan="7">
                                          <div class="empty">No invitation code found.</div>
                                       </td>
                                    </tr>    
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="clear"></div>
            </div>
         </div>
      </div>
   </div>
   <?php
   // include footer //
   include_once('footer.php'); // this is used for include footer //
    // end of include footer // ?>
</body>
<!-- /.body -->