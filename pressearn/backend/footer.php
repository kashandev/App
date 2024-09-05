<!-- footer --> 
    <section class="footer">
        <div class="container">
            <div class="copyright">
                <h6><?php echo $now ?> CRM All Rights Reserved Developed By <a href="" target="_blank">Sofxol</a> </h6>
            </div>
        </div>
    </section>
<!-- /.footer --> 
<?php
   // include modal //
   include_once('modal/modal.php'); // this is used for include modal //
    // end of include modal // ?>  
</html>
<!-- /.html -->
<!-- Javascript Links -->
<script src="public/admin/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/intlTelInput-jquery.min.js"></script>
<script src="public/js/main-script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="public/js/wysiwyg.js"></script>
<script src="public/js/highlight.js"></script>
<script src="public/js/bootstrap-switch.js" type="text/javascript"></script>    
<script src="public/admin/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="public/admin/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="public/admin/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="public/admin/plugins/fastclick/fastclick.min.js"></script>
<script src="public/admin/plugins/fullcalendar/moment.min.js"></script>
<script src="public/admin/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="public/admin/plugins/highchart/highcharts.js"></script>
<script src="public/admin/plugins/highchart/series-label.js"></script>
<script src="public/admin/plugins/highchart/exporting.js"></script>
<script src="public/admin/plugins/highchart/export-data.js"></script>
<script src="public/js/select2.js"></script>
<script src="public/js/datepicker.js"></script>
<script src="public/js/jstree.min.js"></script>
<!-- /.Javascript Links -->

<script type="text/javascript">
    //update function //
      function update()
       {
        $.ajax({
          url:"update/update.php",
          method:"post",
          dataType:"html",
          success:function(result){
          }
        });
      }
      //end of update function //
      
      
       // end of get date function//
       
     // count user function //
         function count_user()
         {
          var data = '';
           $.ajax({
             url:"count/count-user.php",
             type:"post",
             dataType:"TEXT",
             beforeSend:function(){
             },
             success:function(result){
              if(result == 0){
              }else{
              data = get_event();
              }
              return data;
              }
          });
         }
      
         // end of count user function //

     // count supporters function //
         function count_supporters()
         {
          var data = '';
           $.ajax({
             url:"count/count-supporters.php",
             type:"post",
             dataType:"TEXT",
             beforeSend:function(){
             },
             success:function(result){
              if(result == 0){
              }else{
              data = get_event();
              }
              return data;
              }
          });
         }
      
         // end of count supporters function //

     // get event function //
         function get_event()
         {
          var startdate = '';
          var enddate = '';
           $.ajax({
             url:"get/get-event.php",
             type:"post",
             dataType:"json",
             beforeSend:function(){
             },
             success:function(result){
              var startdate = result.startdate
              var enddate = result.enddate;
              if(startdate == enddate && startdate!='' && enddate!=''){
                 update();
              }else if(startdate > enddate){
                 update();
              }
            }
             
          });
         }
  // end of get event function //

var a = count_user;
setInterval(a,100);

var a = count_supporters;
setInterval(a,100);  
</script>