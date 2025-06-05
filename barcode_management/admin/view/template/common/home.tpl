<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="skin-josh">
<?php echo $page_header; ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php echo $column_left; ?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <!--page level css -->
    <!--end of page level css-->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?php echo $lang['heading_title']; ?></h1>
                    <ol class="breadcrumb">
                        <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <li>
                            <a href="<?php echo $breadcrumb['href']; ?>">
                                <i class="<?php echo $breadcrumb['class']; ?>"></i>
                                <?php echo $breadcrumb['text']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </section>
    </aside>
    <aside class="right-side">
        <section class="content">

        </section><!-- /.content -->
        <br>
        <?php echo $page_footer; ?>
    </aside>
    <!-- right-side -->
</div>

<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- Current Document js -->
<!-- end of Current Document js -->
<script src="assets/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/plugins/highcharts500/highcharts.js"></script>
<script src="assets/plugins/highcharts500/modules/data.js"></script>
<script src="assets/plugins/highcharts500/modules/exporting.js"></script>
<script type="text/javascript" src="./admin/view/js/home.js"></script>

<script type="text/javascript">



</script>


<script type="text/javascript">
    var $lang = <?php echo json_encode($lang); ?>;
</script>
<?php echo $footer; ?>
</body>
</html>