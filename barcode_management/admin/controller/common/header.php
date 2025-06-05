<?php
class ControllerCommonHeader extends Controller {

    protected function index() {
        $this->data = $this->load->language('common/header');
        $company_name = $this->session->data['company_name'];

        $this->data['page_title'] = $company_name . ' | ' . $this->document->getTitle();
        if(isset($this->session->data['token'])) {
            $this->data['action_open_file_manager'] = $this->url->link('common/function/openFileManager', 'token=' . $this->session->data['token']);
            $this->data['action_upload_file'] = $this->url->link('common/function/uploadFile', 'token=' . $this->session->data['token']);
            $this->data['href_get_partner'] = $this->url->link('common/function/getPartner', 'token=' . $this->session->data['token']);
            $this->data['href_get_document_ledger'] = $this->url->link('common/function/getDocumentLedger', 'token=' . $this->session->data['token']);
            $this->data['href_get_product_by_code'] = $this->url->link('common/function/getProductByCode', 'token=' . $this->session->data['token']);
            $this->data['href_get_product_by_serial_no'] = $this->url->link('common/function/getProductBySerialNo', 'token=' . $this->session->data['token']);
            $this->data['href_get_product_by_serial_no_warehouse'] = $this->url->link('common/function/getProductBySerialNoAndWarehouse', 'token=' . $this->session->data['token']);
            $this->data['href_get_product_by_id'] = $this->url->link('common/function/getProductById', 'token=' . $this->session->data['token']);
            $this->data['href_get_warehouse_stock'] = $this->url->link('common/function/getWarehouseStock', 'token=' . $this->session->data['token']);

            $this->data['href_get_option_partner'] = $this->url->link('setup/partner/getOptionList', 'token=' . $this->session->data['token'],'SSL');
            $this->data['href_get_option_customer'] = $this->url->link('setup/customer/getOptionList', 'token=' . $this->session->data['token'],'SSL');
            $this->data['href_get_option_supplier'] = $this->url->link('setup/supplier/getOptionList', 'token=' . $this->session->data['token'],'SSL');
            $this->data['href_get_option_sub_project'] = $this->url->link('setup/sub_project/getOptionList', 'token=' . $this->session->data['token'],'SSL');
            $this->data['href_get_option_product'] = $this->url->link('inventory/product/getOptionList', 'token=' . $this->session->data['token'],'SSL');
            $this->data['href_get_option_product_master'] = $this->url->link('inventory/product_master/getOptionList', 'token=' . $this->session->data['token'],'SSL');
            $this->data['href_get_partner_by_id'] = $this->url->link('common/function/getPartnerById', 'token=' . $this->session->data['token'],'SSL');

        } else {
            $this->data['action_open_file_manager'] = '';
            $this->data['action_upload_file'] = '';
        }

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_BASE;
        } else {
            $this->data['base'] = HTTP_BASE;
        }

        $this->template = 'common/header.tpl';
        $this->render();
    }

}

?>