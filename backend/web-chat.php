<?php
   // include header //
   include_once('header.php'); // this is used for include header //
    // end of include header //?>
<!-- title -->
<title>Web Chat</title>
<!-- /.title -->
<?php
   // include form style //
   include_once('style/form-style.php'); // this is used for include form style //
    // end of include form style // ?>
<!-- /.title -->
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
                     <h2> Web Chat </h2>
                     <?php
                        // include message //
                        include_once('message/message.php'); // this is used for include message //
                        // end of include message // ?>      
                  </div>
                  <div class="panel-body">
                     <div class="top-content">
                        <div class="row">
                      <?php
                        // include search report box //
                        //include_once('search/search-report-box.php'); // this is used for include search report box //
                        // end of include search report box // ?>   
                        </div>
                     </div>
                     <div id="w0" class="grid-view">
                        <form id="w0" class="form-horizontal form" method="post" role="form">
                           <ul class="nav nav-tabs">
                              <li class="active">
                                 <a href="#all" data-toggle="tab" data-id="all">All</a>
                              </li>
                              <li><a href="#bank" data-toggle="tab" data-id="bank">Billing Support</a>
                              </li>

                             <li><a href="#bank" data-toggle="tab" data-id="bank">Technical Support</a>
                              </li>

                              
                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane active" id="all">
                        <div class="row">
                      <div class="col-sm-12">
                        <div class="view-all"></div>
                     </div>
                  </div>                   
<!-- 
                                 <table class="table table-striped table-bordered all-table" id="table">
                                    <thead>
                                       <tr>
                                          <th>Reg No</th>
                                          <th>Full Name</th>
                                          <th>Father's Name</th>
                                          <th>CNIC/NICOP</th>
                                          <th>Residential Address</th>
                                          <th>Email address</th>
                                          <th>Mobile Number</th>
                                          <th>Whatsapp Number</th>
                                          <th>Next Of Kin </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table> -->
                              </div>
                              <div class="tab-pane" id="bank">

               <div class="row">
                      <div class="col-sm-12">
                        <div class="view-bank"></div>

                     </div>

                  </div>     
                                 <!--  <table class="table table-striped table-bordered bank-table" id="table">    
                                    <thead>
                                       <tr>
                                          <th>Reg No</th>
                                          <th>Full Name</th>
                                          <th>Father's Name</th>
                                          <th>CNIC/NICOP</th>
                                          <th>Residential Address</th>
                                          <th>Email address</th>
                                          <th>Mobile Number</th>
                                          <th>Whatsapp Number</th>
                                          <th>Next Of Kin </th>

                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>    --> 
                              </div>
                              <div class="tab-pane" id="easy"> 
                  <div class="row">
                      <div class="col-sm-12">
                        <div class="view-easy"></div>

                     </div>

                  </div> 
                              <!--   <table class="table table-striped table-bordered easy-table" id="table">   
                                    <thead>
                                       <tr>
                                          <th>Reg No</th>
                                          <th>Full Name</th>
                                          <th>Father's Name</th>
                                          <th>CNIC/NICOP</th>
                                          <th>Residential Address</th>
                                          <th>Email address</th>
                                          <th>Mobile Number</th>
                                          <th>Whatsapp Number</th>
                                          <th>Next Of Kin </th>

                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>    -->
                                 </div>

                              <div class="tab-pane" id="jazz">
                        <div class="row">
                      <div class="col-sm-12">
                        <div class="view-jazz"></div>

                     </div>

                  </div> 
<!--                               <table class="table table-striped table-bordered jazz-table" id="table">          
                                    <thead>
                                       <tr>
                                          <th>Reg No</th>
                                          <th>Full Name</th>
                                          <th>Father's Name</th>
                                          <th>CNIC/NICOP</th>
                                          <th>Residential Address</th>
                                          <th>Email address</th>
                                          <th>Mobile Number</th>
                                          <th>Whatsapp Number</th>
                                          <th>Next Of Kin </th>

                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                 </table>   --> 
                              </div>     
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
   //function view pagination//
   function view(page='',search='',paymentmethod=''){
      var html = '';
      var search = search;
      var page = page;
      var paymentmethod = paymentmethod;
      var view = '';
      var thisurl ='';
       $.ajax({
        url:"view_forms.php",
        method:"POST",
        data:{page : page, search : search, paymentmethod : paymentmethod},
        dataType: "html", 
        beforeSend:function(){
        html = '<tr><td colspan="6"><strong>loading...</strong></td></tr>';
      //  if(paymentmethod == 'all')
      //  {
      //  $('.view-all').html(html);
      // }
      // if(paymentmethod == 'bank')
      //  {
      //  $('.view-bank').html(html);
      // }
      // if(paymentmethod == 'easy')
      //  {
      //  $('.view-easy').html(html);
      // }
      //  if(paymentmethod == 'jazz')
      //  {
      //  $('.view-jazz').html(html);
      // }
        },  
        success:function(responseData){
        html = responseData;
        console.log(responseData)
      //    setTimeout(function(){
      //   if(paymentmethod == 'all')
      //  {
      //  $('.view-all').html(html);
      // }
      // if(paymentmethod == 'bank')
      //  {
      //  $('.view-bank').html(html);
      // }
      // if(paymentmethod == 'easy')
      //  {
      //  $('.view-easy').html(html);
      // }
      //  if(paymentmethod == 'jazz')
      //  {
      //  $('.view-jazz').html(html);
      // }
      //  },200);
        }
      });
     }
   //end of function view//
   
   
   //function view on key enter//
   function viewkeyenter(page,search='',paymentmethod='',e=''){
      var html = '';
      var id = id;
      var search = search;
      var thisurl ='';
      if(id == 'all')
      { 
       thisurl = '';
      }
      if(id == 'deleted')
      { 
       thisurl = '';
      }
       if (e.which == 13)
       {   
        e.preventDefault();
       $.ajax({
         url: thisurl,
         type: 'post',
         data:{search : search},
         dataType: 'json',
         success: function(responseData){
           paginationData(responseData,id);
           
         }
       });
     }
     }
   //end of function view on key enter pagination//
   
   
  
   
   
   
     //  // function disable button //
     //  function disablebutton()
     //  {
     //  $('.delete-btn').css('background-color','#dee2e6');
     //  $('.delete-btn').css('border','1px solid #dee2e6');
     //  $('.delete-btn').attr('disabled',true);
     //  }
      
     //  // end of function disable button //
   
   
     //  // function restore button //
     //  function disablerestorebutton()
     //  {
     //  $('.restore-btn').css('background-color','#dee2e6');
     //  $('.restore-btn').css('border','1px solid #dee2e6');
     //  $('.restore-btn').attr('disabled',true);
     //  }
      
     //  // end of function restore button //
      
   
     // // function enable button //
     //  function enablebutton()
     //  {
     //  $('.delete-btn').css('background-color','#dd4b39');
     //  $('.delete-btn').css('border','1px solid #d73925');
     //  $('.delete-btn').attr('disabled',false);
      
     //  }
     //  // end of function enable button //
   
   
     //  // function enable black list button //
     //  function enablerestorebutton()
     //  {
     //  $('.restore-btn').css('background-color','#dd4b39');
     //  $('.restore-btn').css('border','1px solid #d73925');
     //  $('.restore-btn').attr('disabled',false);
     //  $('.btn-add').show(); 
      
     //  }
     //  // end of function enable black list button //
   
       // start jquery //
      $(document).ready(function(){ 
             var search = '';
             var page = 0;
             var paymentmethod = '';
             paymentmethod = $('.nav-tabs li.active a').attr('data-id');
             
            view(page,search,paymentmethod); 

    // search function //
   $(document).keypress('.search',function (e) {  
       search = $('.search').val();
       page= $('.btn-page').attr('data-page');
       viewkeyenter(search,paymentmethod); 
   });
   
        $('body').on('click','.search-btn',function(e){
        e.preventDefault(); 
        page = $(this).attr('data-page');
        search = $('.search').val();
        view(page,search,paymentmethod); 
     });    
      // end of search function //  


        // call view function //
       $('body').on('click','.btn-page',function(e){
        e.preventDefault(); 
        page = $(this).attr('data-page');
        search = $('.search').val();
        view(page,search,paymentmethod); 
      });

        $('body').on('click','.btn-next',function(e){
        e.preventDefault(); 
        page = $(this).attr('data-page');
        search = $('.search').val();
        view(page,search,paymentmethod); 
      });  
     // end of call view function //

   // search function//    

   $('body').on('keyup','.search',function(){
    search = $(this).val();
    page= $('.btn-page').attr('data-page');
    view(search,paymentmethod);
   });

   // end of search function//    


   // remove space function from string //
   $(document).on('paste', '.search', function(e) {
   e.preventDefault();
   // prevent copying action
   var withoutSpaces = e.originalEvent.clipboardData.getData('Text');
   withoutSpaces = $.trim(withoutSpaces);
   $(this).val(withoutSpaces);
   // you need to use val() not text()
   });
   // remove space function  from string //
   
     // click function for tabs//
          $('body').on('click','.nav-tabs li a',function(){
           paymentmethod = $(this).attr('data-id');
           search = $('.search').val();
           page= $('.btn-page').attr('data-page');
           view(page,search,paymentmethod)
      });
   
     // end of click function for tabs //   
        });
     // end of jquery //
</script>


