<!DOCTYPE html>
<html>
<?php echo $header; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php echo $page_header; ?>
<?php echo $column_left; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
  </section>

<style type="text/css">
.box-link {
    color: #f9f9f9 !important;
    font-weight: bold !important;
}

p.box-text {
    font-size: 20px !important;
    margin-top: 25px;
}

.box-link:hover {
    color: #f9f9f9;
}
.box-link:visited {
    color: #f9f9f9;
}

.box {
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
    height: 95px;
}

.icon-box {
    width: 96px;
    height: 105px;
    margin-right: -10px;
    background: #fff;
}

.icon-box img {
    margin-left: 16px;
    margin-bottom: 25px;
}

 </style>

<!-- Main content -->
<section class="content">
    <!-- <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a style="font-size: 20px;font-weight: bold" href="#collapseOne" data-parent="#accordion" data-toggle="collapse" class=""><?php echo $lang['report_link']; ?></a>
                    </h4>
                </div>
                <div class="panel-collapse in" id="collapseOne" style="height: auto;">
                    <div class="panel-body">
                        <div class="row">
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $ledger_report; ?>"><?php echo $lang['ledger_report']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $party_ledger_report; ?>"><?php echo $lang['party_ledger_report']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $outstanding_report; ?>"><?php echo $lang['outstanding_report']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $sale_tax_report; ?>"><?php echo $lang['sale_tax_report']; ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a style="font-size: 20px;font-weight: bold" href="#collapseTwo" data-parent="#accordion" data-toggle="collapse" class=""><?php echo $lang['insert_link']; ?></a>
                    </h4>
                </div>
                <div class="panel-collapse in" id="collapseTwo" style="height: auto;">
                    <div class="panel-body">

    <div class="row">
    <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $inventory_supplier; ?>">      
            <div class="small-box bg-aqua box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['inventory_supplier']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/supplier-2.png">
                   <!--  <i class="ion ion-person"></i> -->
                </div>
            </div>
         </a>       
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $inventory_product_category; ?>">      
            <div class="small-box bg-green box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['inventory_product_category']; ?></p>
                </div>
                 <div class="icon icon-box">
                      <img src="../image/category-2.png">
                </div>
            </div>
        </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
       <a class="box-link" target="_blank" href="<?php echo $inventory_product; ?>">     
            <div class="small-box bg-yellow box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['inventory_product']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/product.png">
                </div>
            </div>
           </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
            <a class="box-link" target="_blank" href="<?php echo $inventory_job_order; ?>">
            <div class="small-box bg-aqua box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['inventory_job_order']; ?></p>
                </div>
                 <div class="icon icon-box">
                  <img src="../image/job-order.png">
                </div>
            </div>
        </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $inventory_job_order_estimate; ?>">      
            <div class="small-box bg-green box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['inventory_job_order_estimate']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/estimate.png">
                </div>
            </div>
        </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $inventory_sale_tax_invoice; ?>">      
            <div class="small-box bg-aqua box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['inventory_sale_invoice']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/invoice.png">
                </div>
            </div>
           </a>
        </div>

        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $href_job_order_report; ?>">      
            <div class="small-box bg-aqua box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['job_order_report']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/report.png">
                </div>
            </div>
           </a>
        </div>

        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $href_repair_data_report; ?>">      
            <div class="small-box bg-aqua box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['repair_data_report']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/report.png">
                </div>
            </div>
           </a>
        </div>

        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
      <a class="box-link" target="_blank" href="<?php echo $href_report_sale_tax_invoice; ?>">      
            <div class="small-box bg-aqua box">
                <div class="inner">
                    <h3></h3>
                    <p class="box-text"><?php echo $lang['report_sale_invoice']; ?></p>
                </div>
                 <div class="icon icon-box">
                    <img src="../image/report.png">
                </div>
            </div>
           </a>
        </div>

        


    </div>

<!--                         <div class="row">
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_supplier; ?>"><?php echo $lang['inventory_supplier']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_product_category; ?>"><?php echo $lang['inventory_product_category']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_product; ?>"><?php echo $lang['inventory_product']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_job_order; ?>"><?php echo $lang['inventory_job_order']; ?></a></div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                        </div>
<!--                         <div class="row">
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_job_order_estimate; ?>"><?php echo $lang['inventory_job_order_estimate']; ?></a></div>

                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_sale_tax_invoice; ?>"><?php echo $lang['inventory_sale_invoice']; ?></a></div>
                            </div>
 -->
                        <!-- <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_sale_order; ?>"><?php echo $lang['inventory_sale_order']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_delivery_challan; ?>"><?php echo $lang['inventory_delivery_challan']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_sale_invoice; ?>"><?php echo $lang['inventory_sale_invoice']; ?></a></div>
                            <div style="font-size: 16px" class="col-md-3"><i class="fa fa-arrow-right fa-lg"></i>&nbsp;&nbsp;<a target="_blank" href="<?php echo $inventory_sale_tax_invoice; ?>"><?php echo $lang['inventory_sale_tax_invoice']; ?></a></div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $total_product_category; ?></h3>

                    <p>Total Products Category</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $total_products; ?></h3>
                    <p>Total Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pin"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-8">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo $total_supplier; ?></h3>
                    <p>Total Suppliers</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <!-- <div class="col-lg-4 col-xs-8">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $total_pending_dc; ?></h3>
                    <p>Pending Non Gst Delivery challan</p>
                </div>
            </div>
        </div> -->
        <!-- ./col -->
        <!-- <div class="col-lg-4 col-xs-8">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $total_pending_gst_dc; ?></h3>
                    <p>Pending Gst Delivery challan</p>
                </div>
            </div>
        </div> -->
        <!-- ./col -->
    </div>

<!---Graph Start--->
<div class="row">
    <div class="col-md-12" id="container" >

    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12" id="container1" >

    </div>
</div>

<!-- Graph End -->
    <!-- <div class="row">
        <div class="col-sm-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Sale Orders</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive form-group">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Customer</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($sale_order_details as $detail): ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo $detail['href']; ?>" title="Ref. Document"><?php echo $detail['document_identity']; ?></a></td>
                                <td><?php echo $detail['partner_name']; ?></td>
                                <td><?php echo $detail['item_total']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a target="_blank" href="<?php echo $new_sale_order; ?>" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                    <a target="_blank" href="<?php echo $all_sale_order; ?>" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                </div>
            </div>
            </div>
        <div class="col-sm-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Challan</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Challan No</th>
                                <th>Customer</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($challan_details as $detail): ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo $detail['href']; ?>" title="Ref. Document"><?php echo $detail['document_identity']; ?></a></td>
                                <td><?php echo $detail['partner_name']; ?></td>
                                <td><?php echo $detail['total_qty']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a target="_blank" href="<?php echo $new_challan; ?>" class="btn btn-sm btn-info btn-flat pull-left">Place New Challan</a>
                    <a target="_blank" href="<?php echo $all_challan; ?>" class="btn btn-sm btn-default btn-flat pull-right">View All Challan</a>
                </div>
            </div>
        </div>
    </div> -->
    <!-- <div class="row">
        <div class="col-sm-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Bank Receipt</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Receipt No</th>
                                <th>Customer</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($bank_receipts as $detail): ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo $detail['href']; ?>" title="Ref. Document"><?php echo $detail['document_identity']; ?></a></td>
                                <td><?php echo $detail['partner_name']; ?></td>
                                <td><?php echo $detail['total_net_amount']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a target="_blank" href="<?php echo $new_receipt; ?>" class="btn btn-sm btn-info btn-flat pull-left">Place New Receipt</a>
                    <a target="_blank" href="<?php echo $all_receipt; ?>" class="btn btn-sm btn-default btn-flat pull-right">View All Receipts</a>
                </div>
            </div>
        </div>
    </div> -->


</section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">

    var $UrlGetSaleMonthChart = '<?php echo $href_get_sale_month_chart; ?>';
    var $UrlGettop5customers = '<?php echo $href_get_top_5_customers; ?>';

</script>

<script src="plugins/highcharts500/highcharts.js"></script>
<script src="plugins/canvasjs/canvasjs.js"></script>

<script type="text/javascript" src="../admin/view/js/home.js"></script>

<?php echo $page_footer; ?>
<?php echo $column_right; ?>
</div><!-- ./wrapper -->
<?php echo $footer; ?>
</body>
</html>