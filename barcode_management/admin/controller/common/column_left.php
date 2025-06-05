<?php

class ControllerCommonColumnLeft extends Controller {

    public function index() {
        $this->data['lang'] = $this->load->language('common/column_left');

        $this->data['href_dashboard'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_administrator_dashboard'] = $this->url->link('setup/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_company'] = $this->url->link('setup/company', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_company_setting'] = $this->url->link('setup/company_setting', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_company_branch'] = $this->url->link('setup/company_branch', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_currency'] = $this->url->link('setup/currency', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_partner_category'] = $this->url->link('setup/partner_category', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_customer'] = $this->url->link('setup/customer', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_supplier'] = $this->url->link('setup/supplier', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_document'] = $this->url->link('setup/document', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_closing_transfer'] = $this->url->link('setup/closing_transfer', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_project'] = $this->url->link('setup/project', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_sub_project'] = $this->url->link('setup/sub_project', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_gl_dashboard'] = $this->url->link('gl/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_module_setting'] = $this->url->link('gl/module_setting', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_coa1'] = $this->url->link('gl/coa_level1', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_coa2'] = $this->url->link('gl/coa_level2', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_coa3'] = $this->url->link('gl/coa_level3', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_module_setting'] = $this->url->link('gl/module_setting', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_coa_copy'] = $this->url->link('gl/copy_coa', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_opening_account'] = $this->url->link('gl/opening_account', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_debit_invoice'] = $this->url->link('gl/debit_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_credit_invoice'] = $this->url->link('gl/credit_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_bank_payment'] = $this->url->link('gl/bank_payment', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_cash_payment'] = $this->url->link('gl/cash_payment', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_bank_receipt'] = $this->url->link('gl/bank_receipt', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_cash_receipt'] = $this->url->link('gl/cash_receipt', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_journal_voucher'] = $this->url->link('gl/journal_voucher', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_advance_payment'] = $this->url->link('gl/advance_payment', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_gl_advance_receipt'] = $this->url->link('gl/advance_receipt', 'token=' . $this->session->data['token'], 'SSL');

        /*new*/
        $this->data['href_gl_payments'] = $this->url->link('gl/payments', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_gl_fund_transfer'] = $this->url->link('gl/fund_transfer', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_gl_receipts'] = $this->url->link('gl/receipts', 'token=' . $this->session->data['token'], 'SSL');


        $this->data['href_inventory_dashboard'] = $this->url->link('inventory/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_module_setting'] = $this->url->link('inventory/module_setting', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_warehouse'] = $this->url->link('inventory/warehouse', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_product_category'] = $this->url->link('inventory/product_category', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_brand'] = $this->url->link('inventory/brand', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_make'] = $this->url->link('inventory/make', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_model'] = $this->url->link('inventory/model', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_unit'] = $this->url->link('inventory/unit', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_product'] = $this->url->link('inventory/product', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_product_master'] = $this->url->link('inventory/product_master', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_opening_stock'] = $this->url->link('inventory/opening_stock', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_purchase_order'] = $this->url->link('inventory/purchase_order', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_goods_received'] = $this->url->link('inventory/goods_received', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_purchase_invoice'] = $this->url->link('inventory/purchase_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_purchase_return'] = $this->url->link('inventory/purchase_return', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_supplier_invoice'] = $this->url->link('inventory/supplier_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_sale_order'] = $this->url->link('inventory/sale_order', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_delivery_challan'] = $this->url->link('inventory/delivery_challan', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_sale_invoice'] = $this->url->link('inventory/sale_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_sale_tax_invoice'] = $this->url->link('inventory/sale_tax_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_pos_invoice'] = $this->url->link('inventory/pos_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_sale_return'] = $this->url->link('inventory/sale_return', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_customer_invoice'] = $this->url->link('inventory/customer_invoice', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_stock_out'] = $this->url->link('inventory/stock_out', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_stock_in'] = $this->url->link('inventory/stock_in', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_label_print'] = $this->url->link('inventory/label_print', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_loan_dc'] = $this->url->link('inventory/loan_dc', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_loan_return'] = $this->url->link('inventory/loan_return', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['href_stock_adjustment'] = $this->url->link('inventory/stock_adjustment', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_stock_transfer'] = $this->url->link('inventory/stock_transfer', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_requisition'] = $this->url->link('inventory/inventory_requisition', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_delivery_requisition'] = $this->url->link('inventory/delivery_requisition', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_consumption'] = $this->url->link('inventory/inventory_consumption', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_inventory_return'] = $this->url->link('inventory/inventory_return', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_production_dashboard'] = $this->url->link('production/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_bill_of_material'] = $this->url->link('production/bom', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_production_expense'] = $this->url->link('production/expense', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_production'] = $this->url->link('production/production', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_vehicle_dashboard'] = $this->url->link('vehicle/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_work_order'] = $this->url->link('vehicle/work_order', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_dispatch_invoice'] = $this->url->link('vehicle/dispatch_invoice', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_report_dashboard'] = $this->url->link('report/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_opening_stock'] = $this->url->link('report/opening_stock', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_purchase_order'] = $this->url->link('report/purchase_order_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_goods_received'] = $this->url->link('report/goods_received_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_purchase_invoice'] = $this->url->link('report/purchase_invoice_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_delivery_challan'] = $this->url->link('report/delivery_challan_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_sale_order'] = $this->url->link('report/sale_order_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_sale_invoice'] = $this->url->link('report/sale_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_stock'] = $this->url->link('report/stock', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_stock_detail'] = $this->url->link('report/stock_detail', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_barcode_report'] = $this->url->link('report/barcode_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_aging'] = $this->url->link('report/aging', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_inventory_consumption'] = $this->url->link('report/inventory_consumption_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_coa'] = $this->url->link('report/coa', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_ledger'] = $this->url->link('report/ledger_report', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_document_ledger'] = $this->url->link('report/document_ledger', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_party_ledger'] = $this->url->link('report/party_ledger', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_trial_balance'] = $this->url->link('report/trial_balance', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_balance_sheet'] = $this->url->link('report/balance_sheet', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_income_statement'] = $this->url->link('report/income_statement', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_project_sub_project'] = $this->url->link('report/project_sub_project', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_report_project_summary_report'] = $this->url->link('report/project_summary_report', 'token=' . $this->session->data['token'], 'SSL');


        $this->data['href_tool'] = $this->url->link('tool/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_tool_reminder'] = $this->url->link('tool/reminder', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_tool_backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_tool_sms'] = $this->url->link('tool/sms', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_user_management_dashboard'] = $this->url->link('user/dashboard', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_user_group_permission'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['href_user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_user_profile'] = $this->url->link('user/user_profile', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');

        $route = $this->request->get['route'];
        $arrRoute = explode('/',$route);
        $this->data['controller']  = $arrRoute[0].'/'.$arrRoute[1];

        $this->data['permissions'] = array_keys($this->user->getViewPermissions());
        $this->data['permissions'][] = 'common/home';
        $this->data['permissions'][] = 'common/logout';
        $this->data['permissions'][] = 'user/user_profile';
        $this->template = 'common/column_left.tpl';
        $this->render();

    }

}

?>