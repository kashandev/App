<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <section class="sidebar ">
        <div class="page-sidebar sidebar-nav">
            <div class="clearfix"></div>

            <!-- BEGIN SIDEBAR MENU -->
            <ul id="menu" class="page-sidebar-menu">
            <li class="treeview" data-route="common/home">
                <a href="<?php echo $href_dashboard; ?>">
                    <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>

                    <span><?php echo $lang['dashboard']; ?></span>
                </a>
            </li>
            <li class="treeview level1">
                <a href="<?php echo $href_administrator_dashboard; ?>">
                    <i class="livicon" data-name="gear" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                    <span><?php echo $lang['administrator']; ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sub-menu">
                    <li class="level2">
                        <a href="#"> <i class="livicon" data-name="gear" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                            <?php echo $lang['general_setup']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="sub-menu">
                            <li data-route="setup/company"><a href="<?php echo $href_company; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['company']; ?></a></li>
                            <li data-route="setup/company_setting"><a href="<?php echo $href_company_setting; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['company_setting']; ?></a></li>
                            <li data-route="setup/partner_category"><a href="<?php echo $href_partner_category; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['partner_category']; ?></a></li>
                            <li data-route="setup/customer"><a href="<?php echo $href_customer; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['customer']; ?></a></li>
                            <li data-route="setup/supplier"><a href="<?php echo $href_supplier; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['supplier']; ?></a></li>
                            <li data-route="setup/document"><a href="<?php echo $href_document; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['document']; ?></a></li>
                            <li data-route="setup/currency"><a href="<?php echo $href_currency; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['currency']; ?></a></li>

                            <!--
                            <li data-route="setup/closing_transfer"><a href="<?php echo $href_closing_transfer; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['closing_transfer']; ?></a></li>
                            -->
                            <li data-route="setup/project"><a href="<?php echo $href_project; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['project']; ?></a></li>
                            <li data-route="setup/sub_project"><a href="<?php echo $href_sub_project; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['sub_project']; ?></a></li>
                            <li data-route="setup/building"><a href="<?php echo $href_building; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['building']; ?></a></li>

                        </ul>
                    </li>
                    <li class="level2">
                        <a href="#"> <i class="livicon" data-name="gear" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                            <?php echo $lang['user_management']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="sub-menu">
                            <li data-route="user/user_permission"><a href="<?php echo $href_user_group_permission; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['user_group_permission']; ?></a></li>
                            <li data-route="user/user"><a href="<?php echo $href_user; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['user']; ?></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview level1">
                <a href="<?php echo $href_gl_dashboard; ?>">
                    <i class="livicon" data-name="archive-add" data-size="18" data-c="#90a4ae" data-hc="#90a4ae" data-loop="true"></i>
                    <span><?php echo $lang['general_ledger']; ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sub-menu">
                    <li class="level2">
                        <a href="#"><i class="livicon" data-name="archive-add" data-size="18" data-c="#90a4ae" data-hc="#90a4ae" data-loop="true"></i>
                            <?php echo $lang['gl_setup']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="sub-menu">
                            <li data-route="gl/module_setting"><a href="<?php echo $href_gl_module_setting; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_module_setting']; ?></a></li>
                            <li data-route="gl/coa_level1"><a href="<?php echo $href_gl_coa1; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_chart_of_account_level1']; ?></a></li>
                            <li data-route="gl/coa_level2"><a href="<?php echo $href_gl_coa2; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_chart_of_account_level2']; ?></a></li>
                            <li data-route="gl/coa_level3"><a href="<?php echo $href_gl_coa3; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_chart_of_account_level3']; ?></a></li>

                        </ul>
                    </li>
                    <li class="level2">
                        <a href="#"><i class="livicon" data-name="archive-add" data-size="18" data-c="#90a4ae" data-hc="#90a4ae" data-loop="true"></i><?php echo $lang['gl_transaction']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="sub-menu">
                            <li data-route="gl/opening_account"><a href="<?php echo $href_gl_opening_account; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_opening_account']; ?></a></li>
                            <li data-route="gl/debit_invoice"><a href="<?php echo $href_gl_debit_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_debit_invoice']; ?></a></li>
                            <li data-route="gl/credit_invoice"><a href="<?php echo $href_gl_credit_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_credit_invoice']; ?></a></li>
                            <li data-route="gl/bank_payment"><a href="<?php echo $href_gl_bank_payment; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_bank_payment']; ?></a></li>
                            <li data-route="gl/cash_payment"><a href="<?php echo $href_gl_cash_payment; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_cash_payment']; ?></a></li>
                            <li data-route="gl/bank_receipt"><a href="<?php echo $href_gl_bank_receipt; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_bank_receipt']; ?></a></li>
                            <li data-route="gl/cash_receipt"><a href="<?php echo $href_gl_cash_receipt; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_cash_receipt']; ?></a></li>

                            <li data-route="gl/payments"><a href="<?php echo $href_gl_payments; ?>"><i class="fa fa-arrow-right"></i><?php echo $lang['gl_payments']; ?></a></li>
                            <li data-route="gl/fund_transfer"><a href="<?php echo $href_gl_fund_transfer; ?>"><i class="fa fa-arrow-right"></i><?php echo $lang['gl_fund_transfer']; ?></a></li>
                            <li data-route="gl/receipts"><a href="<?php echo $href_gl_receipts; ?>"><i class="fa fa-arrow-right"></i><?php echo $lang['gl_receipts']; ?></a></li>

                            <li data-route="gl/journal_voucher"><a href="<?php echo $href_gl_journal_voucher; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_journal_voucher']; ?></a></li>
                        </ul>
                    </li>
                    <!-- <li class="level2">
                         <a href="#"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_advances']; ?><i class="fa fa-angle-left pull-right"></i></a>
                         <ul class="treeview-menu">
                             <li data-route="gl/advance_payment"><a href="<?php echo $href_gl_advance_payment; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_advance_payment']; ?></a></li>
                             <li data-route="gl/advance_receipt"><a href="<?php echo $href_gl_advance_receipt; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['gl_advance_receipt']; ?></a></li>
                         </ul>
                     </li>
                     -->
                </ul>
            </li>

            <li class="treeview level1">
                <a href="<?php echo $href_inventory_dashboard; ?>">
                    <i class="livicon" data-name="archive-add" data-size="18" data-c="#90a4ae" data-hc="#90a4ae" data-loop="true"></i>
                    <span><?php echo $lang['inventory_management']; ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="level2">
                        <a href="#"><i class="livicon" data-name="archive-add" data-size="18" data-c="#90a4ae" data-hc="#90a4ae" data-loop="true"></i><?php echo $lang['inventory_setup']; ?><i class="fa fa-angle-left pull-right"></i></a>

                        <ul class="sub-menu">
                            <li data-route="inventory/module_setting"><a href="<?php echo $href_inventory_module_setting; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_module_setting']; ?></a></li>
                            <li data-route="inventory/warehouse"><a href="<?php echo $href_inventory_warehouse; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_warehouse']; ?></a></li>
                            <li data-route="inventory/product_category"><a href="<?php echo $href_inventory_product_category; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_product_category']; ?></a></li>
                            <li data-route="inventory/brand"><a href="<?php echo $href_inventory_brand; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_brand']; ?></a></li>
                            <li data-route="inventory/make"><a href="<?php echo $href_inventory_make; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_make']; ?></a></li>
                            <li data-route="inventory/model"><a href="<?php echo $href_inventory_model; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_model']; ?></a></li>
                            <li data-route="inventory/unit"><a href="<?php echo $href_inventory_unit; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_unit']; ?></a></li>
                            <li data-route="inventory/product"><a href="<?php echo $href_inventory_product; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_product']; ?></a></li>
                            <li data-route="inventory/product_master"><a href="<?php echo $href_inventory_product_master; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_product_master']; ?></a></li>

                        </ul>
                    </li>
                    <li class="level2">
                        <a href="#"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_stock_management']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li data-route="inventory/stock_transfer"><a href="<?php echo $href_stock_transfer; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_stock_transfer']; ?></a></li>
                            <li data-route="inventory/branch_stock_transfer"><a href="<?php echo $href_branch_stock_transfer; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['branch_stock_transfer']; ?></a></li>
                            <li data-route="inventory/stock_adjustment"><a href="<?php echo $href_stock_adjustment; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_stock_adjustment']; ?></a></li>
                            

                            <li data-route="inventory/stock_in"><a href="<?php echo $href_stock_in; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_stock_in']; ?></a></li>
                            <li data-route="inventory/stock_out"><a href="<?php echo $href_stock_out; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_stock_out']; ?></a></li>
                            <li data-route="inventory/label_print"><a href="<?php echo $href_label_print; ?>"><i class="fa fa-arrow-right"></i><?php echo $lang['label_print']; ?></a></li>
                            <li data-route="inventory/loan_dc"><a href="<?php echo $href_loan_dc; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_loan_dc']; ?></a></li>
                            <li data-route="inventory/loan_return"><a href="<?php echo $href_loan_return; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_loan_return']; ?></a></li>
                            
                        </ul>
                    </li>
                    <li class="level2">
                        <a href="#"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_purchase_management']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li data-route="inventory/purchase_order"><a href="<?php echo $href_purchase_order; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_purchase_order']; ?></a></li>
                            <li data-route="inventory/goods_received"><a href="<?php echo $href_goods_received; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_goods_received']; ?></a></li>
                            <li data-route="inventory/purchase_invoice"><a href="<?php echo $href_purchase_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_purchase_invoice']; ?></a></li>
                            <li data-route="inventory/purchase_return"><a href="<?php echo $href_purchase_return; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_purchase_return']; ?></a></li>
                        </ul>
                    </li>
                    <li class="level2">
                        <a href="#"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_sale_management']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li data-route="inventory/sale_order"><a href="<?php echo $href_sale_order; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_sale_order']; ?></a></li>
                            <li data-route="inventory/delivery_challan"><a href="<?php echo $href_delivery_challan; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_delivery_challan']; ?></a></li>
                            <li data-route="inventory/sale_tax_invoice"><a href="<?php echo $href_sale_tax_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_sale_tax_invoice']; ?></a></li>
                            <!--<li data-route="inventory/sale_invoice"><a href="<?php echo $href_sale_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_sale_invoice']; ?></a></li>


                            <li data-route="inventory/sale_tax_invoice"><a href="<?php echo $href_sale_tax_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_sale_invoice']; ?></a></li>


                            <li data-route="inventory/pos_invoice"><a href="<?php echo $href_pos_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_pos_invoice']; ?></a></li>
                            <li data-route="inventory/sale_return"><a href="<?php echo $href_sale_return; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['inventory_sale_return']; ?></a></li>-->
                        </ul>
                    </li>
                    <li class="level2">
                        <a href="#"><i class="fa fa-angle-double-right"></i><?php echo $lang['production']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li data-route="production/production"><a href="<?php echo $href_production; ?>"><?php echo $lang['production']; ?></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview level1">
                <a href="<?php echo $href_report_dashboard; ?>">
                    <i class="livicon" data-name="printer" data-size="18" data-c="#26c6da" data-hc="#26c6da" data-loop="true"></i>
                    <span><?php echo $lang['report']; ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sub-menu">
                    <li class="level2">
                        <a href="#"><i class="livicon" data-name="printer" data-size="18" data-c="#26c6da" data-hc="#26c6da" data-loop="true"></i>
                            <?php echo $lang['general_ledger_report']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="sub-menu">
                            <li data-route="report/coa"><a href="<?php echo $href_report_coa; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['chart_of_account']; ?></a></li>
                            <li data-route="report/ledger_report"><a href="<?php echo $href_report_ledger; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['ledger']; ?></a></li>
                            <li data-route="report/project_summary_report"><a href="<?php echo $href_report_project_summary_report; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['project_summary_report']; ?></a></li>
<!--                            <li data-route="report/document_ledger"><a href="<?php echo $href_report_document_ledger; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['document_ledger']; ?></a></li>-->
                            <li data-route="report/party_ledger"><a href="<?php echo $href_report_party_ledger; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['party_ledger']; ?></a></li>
                            <li data-route="report/trial_balance"><a href="<?php echo $href_report_trial_balance; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['trial_balance']; ?></a></li>
                            <li data-route="report/balance_sheet"><a href="<?php echo $href_report_balance_sheet; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['balance_sheet']; ?></a></li>
                            <li data-route="report/income_statement"><a href="<?php echo $href_report_income_statement; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['profit_lost']; ?></a></li>
                        </ul>
                    </li>

                    <li class="level2">
                        <a href="#"><i class="livicon" data-name="printer" data-size="18" data-c="#26c6da" data-hc="#26c6da" data-loop="true"></i><?php echo $lang['inventory_report']; ?><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li data-route="report/purchase_order_report"><a href="<?php echo $href_report_purchase_order; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_purchase_order']; ?></a></li>
                            <li data-route="report/goods_received_report"><a href="<?php echo $href_report_goods_received; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_goods_received']; ?></a></li>
                            <li data-route="report/purchase_invoice_report"><a href="<?php echo $href_report_purchase_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_purchase_invoice']; ?></a></li>
                            <li data-route="report/delivery_challan_report"><a href="<?php echo $href_report_delivery_challan; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_delivery_challan']; ?></a></li>
                            <li data-route="report/sale_order_report"><a href="<?php echo $href_report_sale_order; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_sale_order']; ?></a></li>
                            <li data-route="report/sale_report"><a href="<?php echo $href_report_sale_invoice; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_sale_invoice']; ?></a></li>
                            <li data-route="report/stock"><a href="<?php echo $href_report_stock; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_stock']; ?></a></li>
                            <li data-route="report/stock_detail"><a href="<?php echo $href_report_stock_detail; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_stock_detail']; ?></a></li>
                            <li data-route="report/barcode_report"><a href="<?php echo $href_report_barcode_report; ?>"><i class="fa fa-angle-double-right"></i><?php echo $lang['report_barcode_report']; ?></a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <hr>
            <li class="treeview" data-route="user/user_profile">
                <a href="<?php echo $href_user_profile; ?>">
                    <i class="livicon" data-name="users" data-size="18" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>

                    <span><?php echo $lang['user_profile']; ?></span>
                </a>
            </li>
            <li class="treeview" data-route="common/logout">
                <a href="<?php echo $href_logout; ?>">
                    <i class="livicon" data-name="sign-out" data-size="18" data-c="#82b1ff" data-hc="#82b1ff" data-loop="true"></i>
                    <span><?php echo $lang['sign_out']; ?></span>
                </a>
            </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </section>
    <!-- /.sidebar -->
</aside>
<script type="text/javascript">
    var $permissions = <?php echo json_encode($permissions); ?>;
    $("li[data-route]").each(function(){
        var $route = $(this).data('route');
        var $position = $.inArray($route, $permissions);
        if($position < 0) {
            $(this).remove();
        }
    });

    $(".level2 ul").each(function(){
        var $length = $(this).has('li').length;
        if($length == 0) {
            var $obj = $(this).parent();
            $($obj).remove();
        }
    });

    $(".level1 ul").each(function(){
        var $length = $(this).has('li').length;
        if($length == 0) {
            var $obj = $(this).parent();
            $($obj).remove();
        }
    });

    var $controller='<?php echo $controller; ?>';
    $("[data-route='" + $controller + "']").parents('li').addClass('active');
    $("[data-route='" + $controller + "']").addClass('active');
</script>