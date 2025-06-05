<?php
class ControllerInventorySaleTaxInvoice extends HController {

    protected $document_type_id = 39;

    protected function getAlias() {
        return 'inventory/sale_tax_invoice';
    }

    protected function getPrimaryKey() {
        return 'sale_tax_invoice_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {
        $lang = $this->load->language($this->getAlias());
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $data = array();
        $aColumns = array('action', 'document_date', 'document_identity', 'manual_ref_no','partner_name', 'net_amount','invoice_status', 'created_at', 'check_box');

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $data['criteria']['start'] = $_GET['iDisplayStart'];
            $data['criteria']['limit'] = $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = " ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                        ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == " ORDER BY") {
                $sOrder = "";
            }
            $data['criteria']['orderby'] = $sOrder;
        }


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $arrWhere = array();
        $arrWhere[] = "`company_id` = '".$this->session->data['company_id']."'";
        $arrWhere[] = "`company_branch_id` = '".$this->session->data['company_branch_id']."'";
        $arrWhere[] = "`fiscal_year_id` = '".$this->session->data['fiscal_year_id']."'";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $arrSSearch = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch'] != '') {
                    $arrSSearch[] = "LOWER(`" . $aColumns[$i] . "`) LIKE '%" . $this->db->escape(strtolower($_GET['sSearch'])) . "%'";
                }
            }
            if(!empty($arrSSearch)) {
                $arrWhere[] = '(' . implode(' OR ', $arrSSearch) . ')';
            }
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                $arrWhere[] = "LOWER(`" . $aColumns[$i] . "`) LIKE '%" . $this->db->escape(strtolower($_GET['sSearch_' . $i])) . "%' ";
            }
        }

        if (!empty($arrWhere)) {
            //$data['filter']['RAW'] = substr($sWhere, 5, strlen($sWhere) - 5);
            $data['filter']['RAW'] = implode(' AND ', $arrWhere);
        }

        //d($data, true);
        $results = $this->model[$this->getAlias()]->getLists($data);
        $iFilteredTotal = $results['total'];
        $iTotal = $results['table_total'];


        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        foreach ($results['lists'] as $aRow) {
            $row = array();
            $actions = array();

            $actions[] = array(
                'text' => $lang['edit'],
                'href' => $this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
                'btn_class' => 'btn btn-warning btn-xs',
                'class' => 'fa fa-edit'
            );

            $actions[] = array(
                'text' => 'Print Commercial Invoice',
                'target' => '_blank',
                'href' => $this->url->link($this->getAlias() . '/printCommercialInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
                'btn_class' => 'btn btn-info btn-xs',
                'class' => 'fa fa-print'
            );

            $actions[] = array(
                'text' => $lang['print_sales_tax_invoice'],
                'target' => '_blank',
                'href' => $this->url->link($this->getAlias() . '/printSalesTaxInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()].'&with_previous_balance=1', 'SSL'),
                'btn_class' => 'btn btn-info btn-xs',
                'class' => 'fa fa-print'
            );

            if($aRow['is_post']==0) {
                $actions[] = array(
                    'text' => $lang['post'],
                    'href' => $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
                    'btn_class' => 'btn btn-info btn-xs',
                    'class' => 'fa fa-thumbs-up',
                    'click'=> 'return confirm(\'Are you sure you want to post this item?\');'
                );

                $actions[] = array(
                    'text' => $lang['delete'],
                    'href' => 'javascript:void(0);',
                    'click' => "ConfirmDelete('" . $this->url->link($this->getAlias() . '/delete', 'token=' . $this->session->data['token'] . '&id=' . $aRow[$this->getPrimaryKey()], 'SSL') . "')",
                    'btn_class' => 'btn btn-danger btn-xs',
                    'class' => 'fa fa-times'
                );
            }

            $strAction = '';
            foreach ($actions as $action) {
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' href="' . $action['href'] .'" '. (isset($action['target']) ? 'target="' . $action['target'] . '"' : '') . ' data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
                if (isset($action['class'])) {
                    $strAction .= '<span class="' . $action['class'] . '"></span>';
                } else {
                    $strAction .= $action['text'];
                }
                $strAction .= '</a>&nbsp;';
            }

            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'action') {
                    $row[] = $strAction;
                } elseif ($aColumns[$i] == 'document_date') {
                    $row[] = stdDate($aRow['document_date']);
                } elseif ($aColumns[$i] == 'created_at') {
                    $row[] = stdDateTime($aRow['created_at']);
                } elseif ($aColumns[$i] == 'invoice_status') {
                    $html = '';
                    //$balance = $aRow['net_amount'] - ($aRow['bank_receipt_amount'] + $aRow['cash_receipt_amount']);
                    if($aRow['invoice_status'] == "Cleared")
                    {
                        $html .= '<label class="btn btn-success btn-xs" style="margin:1px;">Cleared</label>';
                    }else{
                        $html .= '<label class="btn btn-danger btn-xs" style="margin:1px;">Pending</label>';
                    }
                    $row[] = $html;
                }
                elseif ($aColumns[$i] == 'check_box') {
                    if($aRow['is_post']==0) {
                        $row[] = '<input type="checkbox" name="selected[]" value="' . $aRow[$this->getPrimaryKey()] . '" />';
                    } else {
                        $row[] = '';
                    }
                } else {
                    $row[] = $aRow[$aColumns[$i]];
                }

            }
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    protected function getForm() {
        // d($_SESSION,true);
        parent::getForm();

        $this->model['image'] = $this->load->model('tool/image');
        $this->data['loader_image'] = (HTTP_SERVER.'/image/loading.gif');
        $this->data['form_key'] = date('YmdHis') . mt_rand(1, 999999);

        // Allow out of Stock Check
        $this->model['setting'] = $this->load->model('common/setting');
        $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field'  => 'allow_out_of_stock'
        );
        $status = $this->model['setting']->getRow($filter);
        $this->data['allow_out_of_stock'] = $status['value'] ?? 0;
        
//        $this->model['product'] = $this->load->model('inventory/product');
//        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']),array('name'));

        // $this->model['product'] = $this->load->model('inventory/product');
        // $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']),array('name'));

//        $this->data['products'] = $products;

        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencys'] = $this->model['currency']->getRows();
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->data['units'] = $this->model['unit']->getRows(array('company_id' => $this->session->data['company_id']));
        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));
        $this->data['arrWarehouses'] = json_encode($this->data['warehouses']);
        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        // $this->model['customer'] = $this->load->model('setup/customer');
        // $where = "company_id=" . $this->session->data['company_id'];
        // removining this where clause to add all the GST + NONGST customers into the system
        // $where .= " AND partner_category_id=" .'1';
        // $this->data['partners'] = $this->model['customer']->getRows($where,array('name'));

        // $this->model['partner'] = $this->load->model('common/partner');
        // $this->data['partners'] = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'partner_type_id' => 2),array('name'));


       
        $this->data['partner_types'] = $this->session->data['partner_types'];

        $this->data['document_date'] = stdDate();
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        if (isset($this->request->get['sale_tax_invoice_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getRow(array('sale_tax_invoice_id' => $this->request->get[$this->getPrimaryKey()]));
            // d($result,true);
            //$this->model['quotation'] = $this->load->model('inventory/quotation');
            //$this->data['quotations'] = $this->model['quotation']->getRows(array('partner_id' => $result['partner_id']));
            // d($result,true);

            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } elseif($field=='po_date') {
                    if($value == "" || $value == '0000-00-00'){
                        $this->data[$field] = null;
                    }
                    else{
                        $this->data[$field] = stdDate($value);
                    }

                }elseif($field=='bilty_date') {
                    $this->data[$field] = stdDate($value);
                }
//                elseif($field=='ref_document_id')
//                {
//                    $this->data[$field] = json_decode($value);
//                }
                else
                {
                    $this->data[$field] = $value;
                }
            }
            $this->model['document'] = $this->load->model('common/document');

            $where = " company_id=".$this->session->data['company_id'];
            $where .= " AND delivery_challan_id IN('" . implode("','", json_decode($result['ref_document_id'])) . "')";

            $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
            $this->data['ref_documents'] = $this->model['delivery_challan']->getRows($where);

            $this->data['ref_document_id'] = json_decode($result['ref_document_id']);

            $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
            $details = $this->model['sale_tax_invoice_detail']->getRows(array('sale_tax_invoice_id' => $this->request->get['sale_tax_invoice_id']), array('sort_order asc'));

            // $this->model['partner'] = $this->load->model('common/partner');
            // $this->data['partners'] = $this->model['partner']->getRows(array('partner_type_id' => $result['partner_type_id']));

            $arrData = array();
            foreach ($details as $detail) {
                $this->model['stock'] = $this->load->model('common/stock_ledger');
                $stock = $this->model['stock']->getWarehouseStock($detail['product_id'], $detail['warehouse_id'], $result['document_identity'], $result['document_date']);
                $detail['stock_qty']         = $stock['stock_qty'];
                $detail['avg_stock_rate']    = $stock['avg_stock_rate'];
                $detail['stock_amount']      = ($stock['stock_qty'] * $stock['avg_stock_rate']);
                if($detail['ref_document_type_id'] && $detail['ref_document_identity']) {
                    $ref_document = $this->model['document']->getRow(array('document_type_id' => $detail['ref_document_type_id'], 'document_identity' => $detail['ref_document_identity']));
                    $detail['href'] = $this->url->link($ref_document['route'].'/update', 'token=' . $this->session->data['token'] . '&' . $ref_document['primary_key_field'] . '=' . $ref_document['primary_key_value'], 'SSL');
                }
                $arrData[$detail['sort_order']] = $detail;
            }

            // $this->session->data['detail'][$this->session->data['session_time']] = $details;
            $this->data['sale_tax_invoice_details'] = $arrData;
            // d($details,true);

            // $this->data['action_cash_receipt'] = $this->url->link('gl/cash_receipt/insert', 'token=' . $this->session->data['token'] . '&sale_tax_invoice_id='.$this->request->get[$this->getPrimaryKey()] , 'SSL');
            $this->data['action_receipt'] = $this->url->link('gl/receipts/insert', 'token=' . $this->session->data['token'] . '&sale_tax_invoice_id='.$this->request->get[$this->getPrimaryKey()] , 'SSL');
        }

        $this->data['partner_type_id'] = 2;

        $this->data['href_get_partner_json'] = $this->url->link($this->getAlias() . '/getPartnerJson', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_partner'] = $this->url->link($this->getAlias() . '/getPartner', 'token=' . $this->session->data['token']);

         $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['href_get_ref_document_json'] = $this->url->link($this->getAlias() . '/getRefDocumentJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['href_get_document_detail'] = $this->url->link($this->getAlias() . '/getDocumentDetails', 'token=' . $this->session->data['token'] . '&announcement_id=' . $this->request->get['announcement_id']);
        
        $this->data['href_get_container_products'] = $this->url->link($this->getAlias() . '/getContainerProducts', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['get_ref_document'] = $this->url->link($this->getAlias() . '/getRefDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['get_ref_document_record'] = $this->url->link($this->getAlias() . '/getRefDocumentRecord', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['action_print_bill'] = $this->url->link($this->getAlias() . '/printCommercialInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['action_print_sales_tax_invoice'] = $this->url->link($this->getAlias() . '/printSalesTaxInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()].'&with_previous_balance=1', 'SSL');
        
        $this->data['action_print_exempted_invoice'] = $this->url->link($this->getAlias() . '/printExemptedInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()].'&with_previous_balance=1', 'SSL');
        
        $this->data['href_add_record_session'] = $this->url->link($this->getAlias() . '/AddRecordSession', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);

        $this->data['url_validate_stock'] = $this->url->link('common/function/getWarehouseStock', 'token=' . $this->session->data['token']);

        $url_validate_manual_ref_no = $this->url->link($this->getAlias() . '/validateManualRefNo', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'partner_id': {'required': true},
                'net_amount': {'required': true},
            },
            messages: {
            document_date:{
                remote: 'Invalid Date'
            }}
        }";

        $this->response->setOutput($this->render());
    }

    public function AddRecordSession()
    {
        $post = $this->request->post;
        $detail_array = array(
            'sort_order'=> $post['sort_order'],
            'ref_document_type_id' => $post['ref_document_type_id'],
            'ref_document_identity' => $post['ref_document_identity'],
            'serial_no' => $post['serial_no'],
            'product_code' => $post['product_code'],
            'product_id' => $post['product_id'],
            'description' => $post['description'],
            'batch_no' => $post['batch_no'],
            'warehouse_id' => $post['warehouse_id'],
            'qty' => $post['qty'],
            'unit_id' => $post['unit_id'],
            'cog_rate' => $post['cog_rate'],
            'amount' => $post['amount'],
            'cog_amount' => $post['cog_amount'],
            'discount_percent' => $post['discount_percent'],
            'discount_amount' => $post['discount_amount'],
            'gross_amount' => $post['gross_amount'],
            'tax_percent' => $post['tax_percent'],
            'tax_amount' => $post['tax_amount'],
            'further_tax_percent' => $post['further_tax_percent'],
            'further_tax_amount' => $post['further_tax_amount'],
            'total_amount' => $post['total_amount'],
        );

        $this->session->data['detail'][$post['form_key']][$post['sort_order']] = $detail_array;
        $json = array(
            'success'   => true,
            'post' => $post,
            'session_data' => $this->session->data['detail'],
            'detail' => $this->session->data['detail'][$post['form_key']],
        );
        $this->response->setOutput(json_encode($json));
    }

    public function getProductJson() {
       
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $filter = [];
        $filter[] = "p.company_id = '". $session['company_id'] ."'";
//        $filter[] = "(p.product_type = 'Raw Material' OR p.product_type = 'Finished Goods')";
//        $filter[] = "LOWER(`p`.`status`) = 'active'";
//        $filter[] = "LOWER(`p`.`tracing_type`) = 'traceable'";
        $filter = implode(' AND ', $filter);
        $options = $this->model['product_master']->getOptionList($post['q'], $filter, ['p.name']);
        //d($options,true);
        $items = [];
        foreach($options['items'] as $row) {
            $items[] = [
                'id' => $row['product_master_id'],
                // 'text' => $row['name'],
                'text' => implode(' - ', array(
                    $row['product_code'],
                    $row['brand'],
                    $row['model'],
                    $row['name'],
                )),
                'description' => $row['description'],
                'product_code' => $row['product_code'],
                'category_id' => $row['category_id'],
                'unit_id' => $row['unit_id'],
                'unit' => $row['unit'],
            ];
        }
        $json = [
            'total_count' => $options['total_count'],
            'items' => $items,
            'filter' => $filter
        ];

        echo json_encode($json);
        exit;

    }

    public function validateManualRefNo()
    {
        $manual_ref_no = $this->request->post['manual_ref_no'];
        $company_id = $this->session->data['company_id'];
        $company_branch_id = $this->session->data['company_branch_id'];
        $fiscal_year_id = $this->session->data['fiscal_year_id'];

        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];

        $this->load->language($this->getAlias());
        if ($manual_ref_no) {
            $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
            $where = "company_id='" . $company_id . "' AND company_branch_id='" . $company_branch_id . "' AND fiscal_year_id='" . $fiscal_year_id . "'";
            $where .= " AND `manual_ref_no` = '".($manual_ref_no)."' AND sale_tax_invoice_id != '".$sale_tax_invoice_id."'";
            $coa = $this->model[$this->getAlias()]->getRow($where);
            if ($coa) {
                echo json_encode($this->language->get('error_duplicate_manual_ref_no'));
            } else {
                echo json_encode("true");
            }
        } else {
            echo json_encode($this->language->get('error_manual_ref_no'));
        }
        exit;
    }

    public function getPartnerJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $partner_type_id = '';
        if( isset($this->request->get['partner_type_id']) )
        {
            $partner_type_id = $this->request->get['partner_type_id'];
        }

        $this->model['partner'] = $this->load->model('common/partner');
        $rows = $this->model['partner']->getPartnerJson($search, $page, 25, ['partner_type_id' => $partner_type_id]);

        echo json_encode($rows);
    }

    public function getPartner() {
        $partner_type_id = $this->request->post['partner_type_id'];
        $partner_id = $this->request->post['partner_id'];

        $this->model['partner'] = $this->load->model('common/partner');
        $partners = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'partner_type_id' => $partner_type_id));


         $html = '<option value="">&nbsp;</option>';
        foreach($partners as $partner) {
            $html .= '<option value="'.$partner['partner_id'].'">'.$partner['name'].'</option>';
        }

        $json = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($json);
    }



    public function getRefDocumentJson() {
        $search = $this->request->post['q'];
        $partner_id = $this->request->post['partner_id'];
        $page = $this->request->post['page'];
        // $challan_type = 'GST';
         $challan_type = '';
        $type = 'sale_tax_invoice';
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $rows = $this->model['delivery_challan']->getRefDocumentJson($search,$partner_id, $page,$challan_type,$type);
        echo json_encode($rows);
    }


    public function getRefDocumentRecord() {
        $post = $this->request->post;
        $ref_document_id = $post['ref_document_id'];


        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id'    => $this->session->data['fiscal_year_id'],
            'delivery_challan_id' => $ref_document_id
        );

        $delivery_challans = $this->model['delivery_challan']->getRow($filter);

        $json = array(
            'success' => true,
            'data' => $delivery_challans
        );
//d($json,true);
        $this->response->setOutput(json_encode($json));
    }


    public function getRefDocument() {

        $delivery_challan_id = $this->request->get['delivery_challan_id'];
        $post = $this->request->post;
        // d($post, true);

        //Purchase Order
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
        //  because we have added all partners in sale invoice
        // $where .= " AND partner_type_id='" . 2 . "'";
        $where .= " AND partner_id='" . $post['partner_id'] . "'";

//        $where .= " AND is_post=1";

        $delivery_challans = $this->model['delivery_challan']->getDeliveryChallans($where,$delivery_challan_id);

        // d($delivery_challans,true);
        foreach($delivery_challans as $delivery_challan_id => $delivery_challan) {
            foreach($delivery_challan['products'] as $product_id => $product) {
                if($product['order_qty'] <= $product['utilized_qty']) {
                    unset($delivery_challan['products'][$product_id]);
                }
            }
            if(empty($delivery_challan['products'])) {
                unset($delivery_challan[$delivery_challan_id]);
            }
        }

        $html = "";
        if(count($delivery_challans) != 1) {
//            $html .= '<option value="">&nbsp;</option>';
        }
        $html .= '<option value="">&nbsp;</option>';
        foreach($delivery_challans as $sale_order_id => $delivery_challan) {
            if($delivery_challan['sale_order_id']==$post['ref_document_id']) {
                $html .= '<option value="'.$sale_order_id.'" selected="true">'.$delivery_challan['document_identity'].'</option>';
            } else {
                $html .= '<option value="'.$sale_order_id.'">'.$delivery_challan['document_identity'].'</option>';
            }
        }

        $json = array(
            'success' => true,
            'delivery_challan_id' => $delivery_challan_id,
            'post' => $post,
            'where' => $where,
            'html' => $html,
            'partners' => $delivery_challans
        );

        echo json_encode($json);

    }


//    public function getDocumentDetails() {
//
//        $post = $this->request->post;
////d($post,true);
//
//        $PoNo = '';
//        $PoDate = '';
//
//
//        $arrPartner = array();
//        $Partner="";
//        $PoNo = "";
//        $PoDate = "";
//        $CustomerUnitId = "";
//
//
//        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
//        if($post['ref_document_id'] != '')
//        {
//            $where = " delivery_challan_id IN('" . implode("','", array_values($post['ref_document_id'])) . "')";
//        }
//        $DeliveryChallans = $this->model['delivery_challan']->getRows($where);
//
//        $resultstr = array();
//        foreach($DeliveryChallans as $DeliveryChallan)
//        {
//            $resultstr[] = $DeliveryChallan['document_identity'];
//            $PoNo = $DeliveryChallan['po_no'];
//        }
//
//
//        $this->model['delivery_challan_detail'] = $this->load->model('inventory/delivery_challan_detail');
//
//        if($post['ref_document_id'] != '')
//        {
//            $where = " delivery_challan_id IN('" . implode("','", array_values($post['ref_document_id'])) . "')";
//        }
//        $rows = $this->model['delivery_challan_detail']->getRows($where);
//
////        d(array($post,$where,$rows),true);
//
//        $html = '';
//
//        $details = array();
//
//
//        foreach($rows as $row_no => $row) {
//
//            $arrPartner[$row['partner_id']] = $row['document_identity'];
//            $Partner = $row['partner_id'];
//            $PoDate = stdDate($row['po_date']);
//            $PoNo = $row['po_no'];
//            $CustomerUnitId = $row['customer_unit_id'];
//
//            $href = $this->url->link('inventory/delivery_challan/update', 'token=' . $this->session->data['token'] . '&delivery_challan_id=' . $row['delivery_challan_id']);
//            $details[$row_no] = $row;
//            $details[$row_no]['ref_document_identity'] = $row['document_identity'];
//            $details[$row_no]['row_identity'] = $row['document_identity'].'-'.$row['product_code'];
//            $details[$row_no]['href'] = $href;
//            $details[$row_no]['amount'] = ($row['qty']) * ($row['cog_rate']);
//
//        }
//        $DcNo = implode(",",$resultstr);
//
//        if(count($arrPartner) == 1)
//        {
//            $json = array(
//                'success' => true,
//                'post' => $post,
//                'where' => $where,
//                'po_no' => $PoNo,
//                'dc_no' => $DcNo,
//                'po_date'=> $PoDate,
//                'partner_id' => $Partner,
//                'customer_unit_id' => $CustomerUnitId,
//                'details' => $details
//            );
//
//        }
//        else{
//            $json = array(
//                'success' => false,
//                'error' => "Delivery challan with multiple customer.",
//            );
//
//        }
//
////        d($json,true);
//        echo json_encode($json);
//
//    }



    public function getDocumentDetails() {


        $post = $this->request->post;

        $sale_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $post = $this->request->post;

        $arrPartner = array();
        $Partner="";
        $PoNo = "";
        $PoDate = "";
        $CustomerUnitId = "";
        //Purchase Order
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');

        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
//        $where .= " AND partner_id='" . $post['partner_id'] . "'";
        $where .= " AND delivery_challan_id IN('" . implode("','", array_values($post['ref_document_id'])) . "')";

        $Delivery_Challans = $this->model['delivery_challan']->getDeliveryChallans($where,'sale_tax_invoice',$sale_invoice_id);

        $details = array();
        $row_no = 0;


        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        if($post['ref_document_id'] != '')
        {
            $where = " delivery_challan_id IN('" . implode("','", array_values($post['ref_document_id'])) . "')";
        }
        $DeliveryChallans = $this->model['delivery_challan']->getRows($where);

        // d($DeliveryChallans, true);

        $resultstr = array();
        foreach($DeliveryChallans as $DeliveryChallan)
        {
            $resultstr[] = $DeliveryChallan['document_identity'];
            $PoNo = $DeliveryChallan['po_no'];
            $PoDate = !empty($DeliveryChallan['po_date']) ? stdDate($DeliveryChallan['po_date']) : '';
            // $PoNo = $row['po_no'];
            $CustomerUnitId = $DeliveryChallan['customer_unit_id'];

            $delivery_challan = $Delivery_Challans[$DeliveryChallan['document_identity']];
            // d($delivery_challan, true);

            foreach($delivery_challan['products'] as $product) {
                if($product['order_qty'] - $product['utilized_qty'] > 0)
                {

                    $balance = ($product['order_qty'] - $product['utilized_qty']);
                    $href = $this->url->link('inventory/delivery_challan/update', 'token=' . $this->session->data['token'] . '&delivery_challan_id=' . $delivery_challan['delivery_challan_id']);
                    $details[$row_no] = $product;
                    $details[$row_no]['ref_document_identity'] = $delivery_challan['document_identity'];
                    $details[$row_no]['row_identity'] = $delivery_challan['document_identity'].'-'.$product['product_code'];
                    $details[$row_no]['href'] = $href;
                    $details[$row_no]['balanced_qty'] = ($product['order_qty'] - $product['utilized_qty']);
                    $details[$row_no]['utilized_qty'] = ($product['order_qty'] - $product['utilized_qty']);
                    $details[$row_no]['amount'] = ($balance * $product['rate']);


                    if($product['tax_percent'] == 0)
                    {
                        $details[$row_no]['net_amount'] = ($balance * $product['rate']);
                    }
                    else{
                        $details[$row_no]['net_amount'] = $product['net_amount'];

                    }
                    $arrPartner[$delivery_challan['partner_id']] = $delivery_challan['document_identity']['document_identity'];
                    $Partner = $delivery_challan['partner_id'];

                    $row_no++;

                }
            }
        }

        $delivery_challan['products'] = $details;

        $DcNo = implode(",",$resultstr);

      //  d($delivery_challan,true);
        if(count($arrPartner) == 1)
        {
            $json = array(
                'success' => true,
                'post' => $post,
                'where' => $where,
                'po_no' => $PoNo,
                'dc_no' => $DcNo,
                'po_date'=> $PoDate,
                'partner_id' => $Partner,
                'sale_invoice_id' =>$sale_invoice_id,
                'customer_unit_id' => $CustomerUnitId,
                'data' => $delivery_challan,
                'details' => $delivery_challan
            );
        }
        else{
            $json = array(
                'success' => false,
                'error' => "Delivery challan with multiple customer.",
            );
        }

        echo json_encode($json);


    }


    public function getContainerProducts() {
        $post = $this->request->post;
        $container_no = $post['container_no'];

        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $stocks = $this->model['stock_ledger']->getBalanceContainerStocks($container_no);

        $json = array(
            'success' => true,
            'details' => $stocks
        );

        echo json_encode($json);
    }

    public function ajaxValidateForm() {
        $post  = $this->request->post;
        $ID = $this->request->get;
//        d($ID,true);
//       d($post,true);
        $lang = $this->load->language($this->getAlias());
        $error = array();

        if($post['invoice_date'] == '') {
            $error[] = $lang['error_invoice_date'];
        }

        if($post['customer_id'] == '') {
            $error[] = $lang['error_customer'];
        }

        if($post['document_currency_id'] == '') {
            $error[] = $lang['error_document_currency'];
        }
        if($post['conversion_rate'] == '' || $post['conversion_rate'] <= 0 ) {
            $error[] = $lang['error_conversion_rate'];
        }

        $details = $post['sale_tax_invoice_details'];
        $this->model['company'] = $this->load->model('setup/company');
        $company =  $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
//        d($company,true);
        if($company['out_of_stock'] == 1)
        {

            $this->model['product'] = $this->load->model('inventory/product');
            $arrProducts = $this->model['product']->getArrays('product_id','name', array('company_id' => $this->session->data['company_id']));
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
            );


            $stocks =array();
            foreach($details as $stock){
                if(empty($stock['ref_document_type_id']) || $stock['ref_document_type_id'] != 16) {
                    if(isset($stocks[$stock['warehouse_id']][$stock['product_id']])) {
                        $stocks[$stock['warehouse_id']][$stock['product_id']] += $stock['qty'];
                    } else {
                        $stocks[$stock['warehouse_id']][$stock['product_id']] = $stock['qty'];
                    }
                }
            }
            //$error[] =  $lang['error_stock'] ;
            foreach($stocks as  $warehouse_id => $rows)
            {
                foreach($rows as $product_id => $qty) {
                    $filter ['product_id'] = $product_id;
                    $filter ['warehouse_id'] = $warehouse_id;
                    $filter ['document_id'] = $ID['sale_tax_invoice_id'];

                    $product_stock = $this->model['product']->getProductStock($filter);

                    if($product_stock['qty'] < $qty)
                    {
                        $product =  $arrProducts[$product_id];
                        $error[] =   ' Product ' . $product .' , Stock Qty= ' . $product_stock['qty'] . ' , Qty= '. $qty;
                    }
                }
            }
        }
//        d(array($filter,$product_stock),true);

        if(empty($details)) {
            $error[] = $lang['error_input_detail'];
        } else {
            $row_no = 0;
            foreach($details as $detail) {
                $row_no++;
                if($detail['product_code'] == '') {
                    $error[] = $lang['error_product_code'] . ' for Row ' . $row_no;
                }
                if($detail['product_id'] == '') {
                    $error[] = $lang['error_product'] . ' for Row ' . $row_no;
                }
                if($detail['warehouse_id'] == '') {
                    $error[] = $lang['error_warehouse'] . ' for Row ' . $row_no;
                }
                if($detail['qty'] == '') {
                    $error[] = $lang['error_qty'] . ' for Row ' . $row_no;
                }
                if($detail['unit_id'] == '') {
                    $error[] = $lang['error_unit'] . ' for Row ' . $row_no;
                }
                if($detail['rate'] == '') {
                    $error[] = $lang['error_rate'] . ' for Row ' . $row_no;
                }
                if($detail['amount'] == '') {
                    $error[] = $lang['error_amount'] . ' for Row ' . $row_no;
                }
                if($detail['qty'] > ($detail['order_qty']-$detail['received_qty'])) {
                    $error[] = $lang['error_qty'] . ' for Row ' . $row_no;
                }
            }
        }


        if (!$error) {
            $json = array(
                'success' => true
            );
        } else {
            $json = array(
                'success' => false,
                'error' => implode("\r\n",$error),
                'errors' => $error
            );
        }

        echo json_encode($json);
        exit;
    }

    protected function insertData($data) {

        $form_key = $data['form_key'];
        $data['sale_tax_invoice_details'] = $this->session->data['detail'][$form_key];
        
        $data['partner_type_id'] = 2;
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['product']= $this->load->model('inventory/product');
        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $this->model['setting']= $this->load->model('common/setting');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['document_type'] = $this->load->model('common/document_type');
       // $this->model['customer_rate']= $this->load->model('inventory/customer_rate');


        // get Customer //
        $this->model['customer'] = $this->load->model('setup/customer');
        $customer = $this->model['customer']->getRow(array('customer_id' => $data['partner_id']));

        // get Document //
        // $document = $this->model[$this->getAlias()]->getNextDocument($this->document_type_id,$customer['customer_code']);

        // now getting document number without customer code
        if($data['sale_type'] == 'sale_tax_invoice')
        {
            // get sale tax no.
            $document = $this->model[$this->getAlias()]->getNextDocument($this->document_type_id);
            // d('sale tax inv');
            // d($document,true);
        }
        else
        {
            // get sale invoice no.
            // by using sale invoice document type id
            $document = $this->model[$this->getAlias()]->getSaleInvNextDocument(2);
            // d('sale inv');
            // d($document,true);
        }        

        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];

        $data['ref_document_id'] = json_encode($data['ref_document_id']);

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_net_amount'] = $data['net_amount'] * $data['conversion_rate'];

        if($data['po_date'] != '') {
            $data['po_date'] = MySqlDate($data['po_date']);
        } else {
            $data['po_date'] = NULL;
        }
        if($data['bilty_date'] != '') {
            $data['bilty_date'] = MySqlDate($data['bilty_date']);
        } else {
            $data['bilty_date'] = NULL;
        }

        if($data['sale_type'] == 'sale_tax_invoice')
        {
            // get sale tax no.
            $this->model['sale_tax_no'] = $this->load->model('inventory/sale_tax_invoice');
            $sale_tax_no = $this->model['sale_tax_no']->getSaleTaxNo();
            // d($sale_tax_no,true);
            $sale_tax_no = $sale_tax_no['sale_tax_no'] + 1;
            $sale_tax_no = '000'.$sale_tax_no;
            $data['sale_tax_no'] = $sale_tax_no;
            // d($manual_ref_no,true);
        }

        // insert Sale Invoice
        $sale_tax_invoice_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $sale_tax_invoice_id;

        // document add
        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $sale_tax_invoice_id,
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['net_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['net_amount'],
            'exempted' => $data['exempted'],
        );
        // insert document
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'cash_account_id',
        ));
        $cash_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'sale_discount_account_id',
        ));
        $sale_discount_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'sale_tax_account_id',
        ));
        $sale_tax_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'additional_sale_tax_account_id',
        ));
        $additional_sale_tax_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'gr_ir_account_id',
        ));
        $gr_ir_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'labour_charges_account_id',
        ));
        $labour_charges_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'misc_charges_account_id',
        ));
        $misc_charges_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'rent_charges_account_id',
        ));
        $rent_charges_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'cartage_account_id',
        ));
        $cartage_account_id = $setting['value'];


        //  Add Sale Invoice Detail
        foreach ($data['sale_tax_invoice_details'] as $sort_order => $detail) {

            $this->model['stock'] = $this->load->model('common/stock_ledger');
            $stock = $this->model['stock']->getWarehouseStock($detail['product_id'], $detail['warehouse_id'], $data['document_identity'], $data['document_date']);
            $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));

            $detail['sale_tax_invoice_id'] = $sale_tax_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['product_master_id'] = $product['product_master_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_total'] = $detail['total_amount'] * $data['conversion_rate'];
            $sale_tax_invoice_detail_id = $this->model['sale_tax_invoice_detail']->add($this->getAlias(), $detail);

            if($detail['ref_document_type_id'] == 16) {
                // If we are making Invoice through Delivery Challan.
                // $gl_data[] = array(
                //     'document_detail_id' => $sale_tax_invoice_detail_id,
                //     'ref_document_type_id' => $detail['ref_document_type_id'],
                //     'ref_document_id' => $detail['ref_document_id'],
                //     'ref_document_identity' => $detail['ref_document_identity'],
                //     'coa_id' => $gr_ir_account_id,
                //     'document_credit' => $detail['cog_amount'],
                //     'document_debit' => 0,
                //     'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'debit' => 0,
                //     'product_id' => $detail['product_id'],
                //     'qty' => $detail['qty'],
                //     'document_amount' => $detail['cog_amount'],
                //     'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'comment' => 'GRIR Account Debit',
                // );
                // $gl_data[] = array(
                //     'document_detail_id' => $sale_tax_invoice_detail_id,
                //     'ref_document_type_id' => $detail['ref_document_type_id'],
                //     'ref_document_id' => $detail['ref_document_id'],
                //     'ref_document_identity' => $detail['ref_document_identity'],
                //     'coa_id' => $product['cogs_account_id'],
                //     'document_debit' => $detail['cog_amount'],
                //     'document_credit' => 0,
                //     'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'credit' => 0,
                //     'product_id' => $detail['product_id'],
                //     'qty' => $detail['qty'],
                //     'document_amount' => $detail['cog_amount'],
                //     'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'comment' => 'COG Account',
                // );                
            
            } else {

                $stock_ledger = array(
                    'company_id' => $detail['company_id'],
                    'company_branch_id' => $detail['company_branch_id'],
                    'fiscal_year_id' => $detail['fiscal_year_id'],
                    'document_type_id' => $data['document_type_id'],
                    'document_id' => $data['document_id'],
                    'document_identity' => $data['document_identity'],
                    'document_date' => $data['document_date'],
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'warehouse_id' => $detail['warehouse_id'],
                    'batch_no' => $detail['batch_no'],
                    'product_id' => $product['product_master_id'],
                    'document_unit_id' => $detail['unit_id'],
                    'document_qty' => (-1 * $detail['qty']),
                    'unit_conversion' => 1,
                    'base_unit_id' => $detail['unit_id'],
                    'base_qty' => (-1 * $detail['qty']),
                    'document_currency_id' => $detail['document_currency_id'],
                    'document_rate' => $stock['avg_stock_rate'],
                    'document_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'])),
                    'currency_conversion' => $detail['conversion_rate'],
                    'base_currency_id' => $detail['base_currency_id'],
                    'base_rate' => ($stock['avg_stock_rate'] * $detail['conversion_rate']),
                    'base_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'] * $detail['conversion_rate'])),
                );
                $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $stock_ledger);


                $stock_ledger_history = array(
                    'company_id' => $detail['company_id'],
                    'company_branch_id' => $detail['company_branch_id'],
                    'fiscal_year_id' => $detail['fiscal_year_id'],
                    'document_type_id' => $this->document_type_id,
                    'document_id' => $data['document_id'],
                    'document_identity' => $data['document_identity'],
                    'document_date' => $data['document_date'],
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'warehouse_id' => $detail['warehouse_id'],
                    'product_id' => $detail['product_id'],
                    'product_master_id' =>  $detail['product_master_id'],
                    'document_unit_id' => $detail['unit_id'],
                    'document_qty' => 1,
                    'unit_conversion' => 1,
                    'base_unit_id' => $detail['unit_id'],
                    'base_qty' => 1,
                    'document_currency_id' => $detail['document_currency_id'],
                    'document_rate' => ($stock['avg_stock_rate']),
                    'document_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'])),
                    'currency_conversion' => $data['conversion_rate'],
                    'base_currency_id' => $data['base_currency_id'],
                    'base_rate' => ($stock['avg_stock_rate'] * $detail['conversion_rate']),
                    'base_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'] * $detail['conversion_rate'])),
                    'batch_no' => $detail['batch_no'],
                    'serial_no' => $detail['serial_no'],
                );
                $stock_ledger_history_id = $this->model['stock_ledger_history']->add($this->getAlias(), $stock_ledger_history);

                // Add Stock Ledger //

                // If we are making direct invoice.
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $product['inventory_account_id'],
                    'document_credit' => $detail['cog_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'Inventory Account',
                );
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $product['cogs_account_id'],
                    'document_debit' => $detail['cog_amount'],
                    'document_credit' => 0,
                    'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'credit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'COGS Account',
                );
            }

            if( floatval($detail['amount']) > 0 ){

                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    //'coa_id' => $gr_ir_account_id,
                    'coa_id' => $product['revenue_account_id'],
                    'document_credit' => $detail['amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['amount'],
                    'amount' => ($detail['amount'] * $data['conversion_rate']),
                    'comment' => 'Revenue Account',
                );
            }

            if(floatval($detail['discount_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_discount_account_id,
                    'document_credit' => 0,
                    'document_debit' => $detail['discount_amount'],
                    'credit' => 0,
                    'debit' => ($detail['discount_amount'] * $data['conversion_rate']),
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['discount_amount'],
                    'amount' => ($detail['discount_amount'] * $data['conversion_rate']),
                    'comment' => 'Item Discount Account',
                );
            }

            if(floatval($detail['tax_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_tax_account_id,
                    'document_credit' => $detail['tax_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['tax_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['tax_amount'],
                    'amount' => ($detail['tax_amount'] * $data['conversion_rate']),
                    'comment' => 'Sales Tax Account',
                );
            }

            if(floatval($detail['further_tax_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $additional_sale_tax_account_id,
                    'document_credit' => $detail['further_tax_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['further_tax_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['further_tax_amount'],
                    'amount' => ($detail['further_tax_amount'] * $data['conversion_rate']),
                    'comment' => 'Add. Sales Tax Account',
                );
            }
        }

        $partner = $this->model['partner']->getRow(array('company_branch_id' => $this->session->data['company_branch_id'], 'partner_type_id' => 2, 'partner_id' => $data['partner_id']));
        $outstanding_account_id = $partner['outstanding_account_id'];
        // d($outstanding_account_id);
        //d(array($data, $partner, $outstanding_account_id), true);

        $gl_data[] = array(
            'ref_document_type_id' => $this->document_type_id,
            'ref_document_identity' => $data['document_identity'],
            'coa_id' => $outstanding_account_id,
            'document_credit' => 0,
            'document_debit' => $data['net_amount'],
            'credit' => 0,
            'debit' => ($data['net_amount'] * $data['conversion_rate']),
            'comment' => 'Outstanding Account Debit',
        );

        if(floatval($data['discount_amount']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $sale_discount_account_id,
                'document_credit' => 0,
                'document_debit' => $data['discount_amount'],
                'credit' => 0,
                'debit' => ($data['discount_amount'] * $data['conversion_rate']),
                'comment' => 'Additional Discount Account',
            );
        }

        if(floatval($data['labour_charges']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $labour_charges_account_id,
                'document_debit' => 0,
                'document_credit' => $data['labour_charges'],
                'debit' => 0,
                'credit' => ($data['labour_charges'] * $data['conversion_rate']),
                'comment' => 'Labour Charges Account',
            );
        }

        if(floatval($data['misc_charges']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $misc_charges_account_id,
                'document_debit' => 0,
                'document_credit' => $data['misc_charges'],
                'debit' => 0,
                'credit' => ($data['misc_charges'] * $data['conversion_rate']),
                'comment' => 'Misc Charges Account',
            );
        }

        if(floatval($data['rent_charges']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $rent_charges_account_id,
                'document_debit' => 0,
                'document_credit' => $data['rent_charges'],
                'debit' => 0,
                'credit' => ($data['rent_charges'] * $data['conversion_rate']),
                'comment' => 'Rent Charges Account',
            );
        }

        if(floatval($data['cartage']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cartage_account_id,
                'document_debit' => 0,
                'document_credit' => $data['cartage'],
                'debit' => 0,
                'credit' => ($data['cartage'] * $data['conversion_rate']),
                'comment' => 'Sale Cartage Account',
            );
        }

        if(floatval($data['cash_received']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $outstanding_account_id,
                'document_debit' => 0,
                'document_credit' => $data['cash_received'],
                'debit' => 0,
                'credit' => ($data['cash_received'] * $data['conversion_rate']),
                'comment' => 'Outstanding Account Cash Received',
            );

            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cash_account_id,
                'document_credit' => 0,
                'document_debit' => $data['cash_received'],
                'credit' => 0,
                'debit' => ($data['cash_received'] * $data['conversion_rate']),
                'comment' => 'Cash Account Cash Received',
            );
        }

        if($data['invoice_type'] == 'Cash') {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $outstanding_account_id,
                'document_debit' => 0,
                'document_credit' => $data['net_amount'],
                'debit' => 0,
                'credit' => ($data['net_amount'] * $data['conversion_rate']),
                'comment' => 'Outstanding Account Cash Received',
            );

            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cash_account_id,
                'document_credit' => 0,
                'document_debit' => $data['net_amount'],
                'credit' => 0,
                'debit' => ($data['net_amount'] * $data['conversion_rate']),
                'comment' => 'Cash Account Cash Received',
            );
        }
        $this->model['ledger'] = $this->load->model('gl/ledger');
        // d($gl_data, true);
        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $sale_tax_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['project_id'] = $data['project_id'];
            $ledger['sub_project_id'] = $data['sub_project_id'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];
            $ledger['remarks'] = $data['remarks'];
            $ledger['po_no'] = $data['po_no'];
            $ledger['dc_no'] = $data['dc_no'];
            $ledger['customer_unit_id'] = $data['customer_unit_id'];
            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }

        unset($this->session->data['detail'][$form_key]);
        return $sale_tax_invoice_id;
    }

    protected function updateData($primary_key, $data) {

        $form_key = $data['form_key'];
        $data['sale_tax_invoice_details'] = $this->session->data['detail'][$form_key];

        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['product']= $this->load->model('inventory/product');
        $this->model['setting']= $this->load->model('common/setting');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');
        $this->model['product_master'] = $this->load->model('inventory/product_master');

        $data['partner_type_id'] = 2;

        //d(array($primary_key, $data), true);
        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_date'] = MySqlDate($data['document_date']);

        if($data['po_date'] != '') {
            $data['po_date'] = MySqlDate($data['po_date']);
        }
        else
        {
            $data['po_date'] = NULL;
        }
        if($data['bilty_date'] != '')
        {
            $data['bilty_date'] = MySqlDate($data['bilty_date']);
        }
        else
        {
            $data['bilty_date'] = NULL;
        }

        if($data['exempted'] == 1)
        {
            $data['exempted'] = 1;

        }else   {
            $data['exempted'] =0;
        }

        $data['base_amount'] = $data['net_amount'] * $data['conversion_rate'];
        $sale_tax_invoice_id = $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);
        $data['document_id'] = $sale_tax_invoice_id;

        $this->model['sale_tax_invoice_detail']->deleteBulk($this->getAlias(), array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        $this->model['document']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['stock_ledger_history']->deleteBulk($this->getAlias(), array('document_id' => $sale_tax_invoice_id));

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $sale_tax_invoice_id,
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['net_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['net_amount'],
            'exempted' => $data['exempted'],
        );
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'cash_account_id',
        ));
        $cash_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'sale_discount_account_id',
        ));
        $sale_discount_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'sale_tax_account_id',
        ));
        $sale_tax_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'additional_sale_tax_account_id',
        ));
        $additional_sale_tax_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'gr_ir_account_id',
        ));
        $gr_ir_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'labour_charges_account_id',
        ));
        $labour_charges_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'misc_charges_account_id',
        ));
        $misc_charges_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'rent_charges_account_id',
        ));
        $rent_charges_account_id = $setting['value'];

        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
            'field' => 'cartage_account_id',
        ));
        $cartage_account_id = $setting['value'];

        //d(array($misc_charges_account_id, $labour_charges_account_id, $gr_ir_account_id, $sale_tax_account_id, $sale_discount_account_id, $cash_account_id), true);
        foreach ($data['sale_tax_invoice_details'] as $sort_order => $detail) {

            $this->model['stock'] = $this->load->model('common/stock_ledger');
            $stock = $this->model['stock']->getWarehouseStock($detail['product_id'], $detail['warehouse_id'], $data['document_identity'], $data['document_date']);
            $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));

            $detail['sale_tax_invoice_id'] = $sale_tax_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['product_master_id'] = $product['product_master_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_total'] = $detail['total_amount'] * $data['conversion_rate'];
            $sale_tax_invoice_detail_id = $this->model['sale_tax_invoice_detail']->add($this->getAlias(), $detail);
            
            //d(array($stock_ledger_id, $stock_ledger), true);

//            $customer_rate = array(
//                'company_id' => $detail['company_id'],
//                'customer_id' => $data['partner_id'],
//                'product_id' => $detail['product_id'],
//                'rate' => $detail['rate'],
//                'invoice_date' => $data['document_date'],
//                'created_at' => date("Y-m-d H:i:s"),
//
//            );
//
//            // Add customer_rate //
//            $rate_id = $this->model['customer_rate']->add($this->getAlias(), $customer_rate);
            if($detail['ref_document_type_id'] == 16) {
                // If we are making Invoice through Delivery Challan.
                // $gl_data[] = array(
                //     'document_detail_id' => $sale_tax_invoice_detail_id,
                //     'ref_document_type_id' => $detail['ref_document_type_id'],
                //     'ref_document_id' => $detail['ref_document_id'],
                //     'ref_document_identity' => $detail['ref_document_identity'],
                //     'coa_id' => $gr_ir_account_id,
                //     'document_credit' => $detail['cog_amount'],
                //     'document_debit' => 0,
                //     'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'debit' => 0,
                //     'product_id' => $detail['product_id'],
                //     'qty' => $detail['qty'],
                //     'document_amount' => $detail['cog_amount'],
                //     'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'comment' => 'GRIR Account Debit',
                // );
                // $gl_data[] = array(
                //     'document_detail_id' => $sale_tax_invoice_detail_id,
                //     'ref_document_type_id' => $detail['ref_document_type_id'],
                //     'ref_document_id' => $detail['ref_document_id'],
                //     'ref_document_identity' => $detail['ref_document_identity'],
                //     'coa_id' => $product['cogs_account_id'],
                //     'document_debit' => $detail['cog_amount'],
                //     'document_credit' => 0,
                //     'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'credit' => 0,
                //     'product_id' => $detail['product_id'],
                //     'qty' => $detail['qty'],
                //     'document_amount' => $detail['cog_amount'],
                //     'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                //     'comment' => 'COG Account',
                // );
            } else {

                $stock_ledger = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $detail['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $data['document_type_id'],
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $sale_tax_invoice_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'batch_no' => $detail['batch_no'],
                'product_id' => $product['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => (-1 * $detail['qty']),
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => (-1 * $detail['qty']),
                'document_currency_id' => $detail['document_currency_id'],
                'document_rate' => $stock['avg_stock_rate'],
                'document_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'])),
                'currency_conversion' => $detail['conversion_rate'],
                'base_currency_id' => $detail['base_currency_id'],
                'base_rate' => ($stock['avg_stock_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'] * $detail['conversion_rate'])),
            );
            $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $stock_ledger);

                $stock_ledger_history = array(
                    'company_id' => $detail['company_id'],
                    'company_branch_id' => $detail['company_branch_id'],
                    'fiscal_year_id' => $detail['fiscal_year_id'],
                    'document_type_id' => $this->document_type_id,
                    'document_id' => $data['document_id'],
                    'document_identity' => $data['document_identity'],
                    'document_date' => $data['document_date'],
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'warehouse_id' => $detail['warehouse_id'],
                    'product_id' => $detail['product_id'],
                    'product_master_id' =>  $detail['product_master_id'],
                    'document_unit_id' => $detail['unit_id'],
                    'document_qty' => 1,
                    'unit_conversion' => 1,
                    'base_unit_id' => $detail['unit_id'],
                    'base_qty' => 1,
                    'document_currency_id' => $detail['document_currency_id'],
                    'document_rate' => ($stock['avg_stock_rate']),
                    'document_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'])),
                    'currency_conversion' => $data['conversion_rate'],
                    'base_currency_id' => $data['base_currency_id'],
                    'base_rate' => ($stock['avg_stock_rate'] * $detail['conversion_rate']),
                    'base_amount' => (-1 * ($detail['qty'] * $stock['avg_stock_rate'] * $detail['conversion_rate'])),
                    'batch_no' => $detail['batch_no'],
                    'serial_no' => $detail['serial_no'],
                );
                $stock_ledger_history_id = $this->model['stock_ledger_history']->add($this->getAlias(), $stock_ledger_history);

                // If we are making direct invoice.
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $product['inventory_account_id'],
                    'document_credit' => $detail['cog_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'Inventory Account',
                );
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $product['cogs_account_id'],
                    'document_debit' => $detail['cog_amount'],
                    'document_credit' => 0,
                    'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'credit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'COGS Account',
                );
            }

            if(floatval($detail['amount']) > 0) {
                
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    //'coa_id' => $gr_ir_account_id,
                    'coa_id' => $product['revenue_account_id'],
                    'document_credit' => $detail['amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['amount'],
                    'amount' => ($detail['amount'] * $data['conversion_rate']),
                    'comment' => 'Revenue Account',
                );
            }

            if(floatval($detail['discount_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_discount_account_id,
                    'document_credit' => 0,
                    'document_debit' => $detail['discount_amount'],
                    'credit' => 0,
                    'debit' => ($detail['discount_amount'] * $data['conversion_rate']),
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['discount_amount'],
                    'amount' => ($detail['discount_amount'] * $data['conversion_rate']),
                    'comment' => 'Item Discount Account',
                );
            }

            if(floatval($detail['tax_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_tax_account_id,
                    'document_credit' => $detail['tax_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['tax_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['tax_amount'],
                    'amount' => ($detail['tax_amount'] * $data['conversion_rate']),
                    'comment' => 'Sales Tax Account',
                );
            }

            if(floatval($detail['further_tax_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_tax_account_id,
                    'document_credit' => $detail['further_tax_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['further_tax_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['further_tax_amount'],
                    'amount' => ($detail['further_tax_amount'] * $data['conversion_rate']),
                    'comment' => 'Add. Sales Tax Account',
                );
            }
        }

        $partner = $this->model['partner']->getRow(array('company_branch_id' => $this->session->data['company_branch_id'], 'partner_type_id' => 2, 'partner_id' => $data['partner_id']));
        $outstanding_account_id = $partner['outstanding_account_id'];

        $gl_data[] = array(
            'ref_document_type_id' => $this->document_type_id,
            'ref_document_identity' => $data['document_identity'],
            'coa_id' => $outstanding_account_id,
            'document_credit' => 0,
            'document_debit' => $data['net_amount'],
            'credit' => 0,
            'debit' => ($data['net_amount'] * $data['conversion_rate']),
            'comment' => 'Outstanding Account Debit',
        );

        if(floatval($data['discount_amount']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $sale_discount_account_id,
                'document_credit' => 0,
                'document_debit' => $data['discount_amount'],
                'credit' => 0,
                'debit' => ($data['discount_amount'] * $data['conversion_rate']),
                'comment' => 'Additional Discount Account',
            );
        }

        if(floatval($data['labour_charges']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $labour_charges_account_id,
                'document_debit' => 0,
                'document_credit' => $data['labour_charges'],
                'debit' => 0,
                'credit' => ($data['labour_charges'] * $data['conversion_rate']),
                'comment' => 'Labour Charges Account',
            );
        }

        if(floatval($data['misc_charges']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $misc_charges_account_id,
                'document_debit' => 0,
                'document_credit' => $data['misc_charges'],
                'debit' => 0,
                'credit' => ($data['misc_charges'] * $data['conversion_rate']),
                'comment' => 'Misc Charges Account',
            );
        }

        if(floatval($data['rent_charges']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $rent_charges_account_id,
                'document_debit' => 0,
                'document_credit' => $data['rent_charges'],
                'debit' => 0,
                'credit' => ($data['rent_charges'] * $data['conversion_rate']),
                'comment' => 'Rent Charges Account',
            );
        }

        if(floatval($data['cartage']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cartage_account_id,
                'document_debit' => 0,
                'document_credit' => $data['cartage'],
                'debit' => 0,
                'credit' => ($data['cartage'] * $data['conversion_rate']),
                'comment' => 'Cartage Account',
            );
        }

        if(floatval($data['cash_received']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $outstanding_account_id,
                'document_debit' => 0,
                'document_credit' => $data['cash_received'],
                'debit' => 0,
                'credit' => ($data['cash_received'] * $data['conversion_rate']),
                'comment' => 'Outstanding Account Cash Received',
            );

            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cash_account_id,
                'document_credit' => 0,
                'document_debit' => $data['cash_received'],
                'credit' => 0,
                'debit' => ($data['cash_received'] * $data['conversion_rate']),
                'comment' => 'Cash Account Cash Received',
            );
        }

        if($data['invoice_type'] == 'Cash') {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $outstanding_account_id,
                'document_debit' => 0,
                'document_credit' => $data['net_amount'],
                'debit' => 0,
                'credit' => ($data['net_amount'] * $data['conversion_rate']),
                'comment' => 'Outstanding Account Cash Received',
            );

            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cash_account_id,
                'document_credit' => 0,
                'document_debit' => $data['net_amount'],
                'credit' => 0,
                'debit' => ($data['net_amount'] * $data['conversion_rate']),
                'comment' => 'Cash Account Cash Received',
            );
        }
        $this->model['ledger'] = $this->load->model('gl/ledger');
        //d($gl_data, true);
        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $sale_tax_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['project_id'] = $data['project_id'];
            $ledger['sub_project_id'] = $data['sub_project_id'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];
            $ledger['remarks'] = $data['remarks'];
            $ledger['po_no'] = $data['po_no'];
            $ledger['dc_no'] = $data['dc_no'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }

        unset($this->session->data['detail'][$form_key]);
        return $sale_tax_invoice_id;
    }

    protected function deleteData($primary_key) {
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['sale_tax_invoice_detail']->deleteBulk($this->getAlias(), array('sale_tax_invoice_id' => $primary_key));

        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');
        $this->model['stock_ledger_history']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));

        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);
    }

    public function getReferenceDocumentNos() {
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $post = $this->request->post;

        $this->model['document'] = $this->load->model('common/document');
        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
        $where .= " AND partner_type_id='" . $post['partner_type_id'] . "'";
        $where .= " AND partner_id='" . $post['partner_id'] . "'";
        $where .= " AND document_type_id='" . $post['ref_document_type_id'] . "'";
        //$where .= " AND document_currency_id='" . $post['document_currency_id'] . "'";
        //$where .= " AND is_post=1";

        $orders = $this->model['document']->getRows($where);

        $html = "";
        $html .= '<option value="">&nbsp;</option>';
        foreach($orders as $goods_received) {
            $html .= '<option value="'.$goods_received['document_identity'].'">'.$goods_received['document_identity']. '</option>';
        }

        //d($goods_received,true);
        $json = array(
            'success' => true,
            'sale_tax_invoice_id' => $sale_tax_invoice_id,
            'post' => $post,
            'where' => $where,
            'orders' => $orders,
            'html' => $html
        );

        echo json_encode($json);
    }

    public function getReferenceDocument() {
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $post = $this->request->post;

        if($post['ref_document_type_id'] == 26) {
            //Sale Inquiry
            $this->model['sale_inquiry_detail'] = $this->load->model('inventory/sale_inquiry_detail');
            $where = "company_id=" . $this->session->data['company_id'];
            $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
            $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
            $where .= " AND partner_type_id='" . $post['partner_type_id'] . "'";
            $where .= " AND partner_id='" . $post['partner_id'] . "'";
            $where .= " AND document_identity='" . $post['ref_document_identity'] . "'";
//            $where .= " AND document_currency_id='" . $post['document_currency_id'] . "'";
//            $where .= " AND is_post=1";

            $rows = $this->model['sale_inquiry']->getRows($where);
            $html = '';
            $details = array();
            $this->model['product'] = $this->load->model('inventory/product');
            $this->model['stock'] = $this->load->model('common/stock_ledger');
            foreach($rows as $row_no => $row) {
                $product = $this->model['product']->getRow(array('product_id' => $row['product_id']));
                $filter = array(
                    'company_id' => $this->session->data['company_id'],
                    'company_branch_id' => $this->session->data['company_branch_id'],
                    'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                    'product_id' => $row['product_id'],
                );
                $stock = $this->model['stock']->getStock($filter);
                $href = $this->url->link('inventory/sale_inquiry/update', 'token=' . $this->session->data['token'] . '&sale_inquiry_id=' . $row['sale_inquiry_id']);
                $details[$row_no] = $row;
                $details[$row_no]['href'] = $href;
                $details[$row_no]['rate'] = $product['sale_price'];
                $details[$row_no]['amount'] = ($row['qty'] * $product['sale_price']);
                $details[$row_no]['cog_rate'] = $stock['avg_stock_rate'];
                $details[$row_no]['cog_amount'] = ($row['qty'] * $stock['avg_stock_rate']);
                $details[$row_no]['stock_qty'] = $stock['stock_qty'];
            }
        } elseif($post['ref_document_type_id'] == 16) {
            //Delivery Challan
            $this->model['delivery_challan_detail'] = $this->load->model('inventory/delivery_challan_detail');
            $where = "company_id=" . $this->session->data['company_id'];
            $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
            $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
            $where .= " AND partner_type_id='" . $post['partner_type_id'] . "'";
            $where .= " AND partner_id='" . $post['partner_id'] . "'";
            $where .= " AND document_identity='" . $post['ref_document_identity'] . "'";
//            $where .= " AND document_currency_id='" . $post['document_currency_id'] . "'";
//            $where .= " AND is_post=1";

            $rows = $this->model['delivery_challan_detail']->getRows($where);
            $html = '';
            $details = array();
            $this->model['product'] = $this->load->model('inventory/product');
            $this->model['stock'] = $this->load->model('common/stock_ledger');
            foreach($rows as $row_no => $row) {
                $filter = array(
                    'company_id' => $this->session->data['company_id'],
                    'company_branch_id' => $this->session->data['company_branch_id'],
                    'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                    'product_id' => $row['product_id'],
                );
                $stock = $this->model['stock']->getStock($filter);
                $product = $this->model['product']->getRow(array('product_id' => $row['product_id']));
                $href = $this->url->link('inventory/delivery_challan/update', 'token=' . $this->session->data['token'] . '&delivery_challan_id=' . $row['delivery_challan_id']);
                $details[$row_no] = $row;
                $details[$row_no]['href'] = $href;
                $details[$row_no]['rate'] = $product['sale_price'];
                $details[$row_no]['amount'] = ($row['qty'] * $product['sale_price']);
                $details[$row_no]['stock_qty'] = $stock['stock_qty'];
            }
        }

        $json = array(
            'success' => true,
            'sale_tax_invoice_id' => $sale_tax_invoice_id,
            'post' => $post,
            'where' => $where,
            'details' => $details);
        echo json_encode($json);
    }

    public function printExemptedInvoice() {

        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);


        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $with_previous_balance = isset($this->request->get['with_previous_balance'])?1:0;

        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');

        $invoice = $this->model['sale_tax_invoice']->getRow(array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        $partner = $this->model['partner']->getRow(array('partner_id' => $invoice['partner_id']));
        $Company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
//        d($Company,true);


        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Exempted Invoice');
        $pdf->SetSubject('Exempted Invoice');

        //Set Header

        $pdf->InvoiceCheck = "Exempted Bill";
        $pdf->data = array(
            'company_name' => $session['company_name'],
            //'report_name' => $lang['heading_title'],
            'report_name' => 'Exempted Invoice',
            'header_image' => HTTP_IMAGE.'header.jpg',
            'footer_image' => HTTP_IMAGE.'footer.jpg',
            'company_logo' => $session['company_image']
        );


        $pdf->SetMargins(25, 55, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 55);

        // add a page
        $pdf->AddPage();
        // set font

        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(160, 7, 'Date: '.stdDate($invoice['document_date']), 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->ln(4);
        $pdf->Cell(80, 7, 'M/S: '.html_entity_decode($invoice['partner_name']), 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->ln(5);
        $pdf->Cell(80, 7, 'NTN No: '.$partner['ntn_no'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->ln(5);
        $pdf->Cell(80, 7, 'STR No: '.$partner['gst_no'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->ln(5);
        $pdf->Cell(80, 7, 'INVOICE # '.$invoice['document_identity'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->ln(5);
        $pdf->Cell(80, 7, 'Excluding Value: '.number_format($invoice['item_amount'],2), 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->ln(5);
        $pdf->Cell(80, 7, 'Sales Tax Value: '.number_format($invoice['item_tax'],2), 0, false, 'L', 0, '', 0, false, 'M', 'M');


        $pdf->ln(10);
        $html = $Company['description'];
        $pdf->writeHTML($html, true, false, true, false, '');

//        $pdf->SetFont('helvetica', 'B,U', 14);
//        $pdf->Cell(20, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(120, 7, 'Undertaking of Non Deduction of Tax on Supplies', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(20, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(12);
//        $pdf->SetFont('helvetica', 'B', 14);
//        $pdf->Cell(20, 7, 'Dear Sir,', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(8);
//        $pdf->SetFont('helvetica', 'B,U', 14);
//        $pdf->Cell(20, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(120, 7, 'Sales Tax:', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(20, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//
//        $pdf->ln(15);
//        $pdf->SetFont('helvetica', '', 14);
//        $pdf->Cell(180, 7, "We hereby confirm that we are not liable for the Withhold of Sales Tax Under The", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "Sales Tax Special Procedure (Withholding) Rules, 2007 vide SRO 660(1)/2007", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "Dated 30-06-2014 as supplies made by Commercial Importers on which VAT has", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "been paid at the time of import re excluded under Rule 5 (Exclusion) of The Sales", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "Tax Special Procedure (Withholding) Rules, 2007 vide SRO 897(1)/2013 Dated", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "04-10-2013.", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(15);
//
//
//        $pdf->SetFont('helvetica', 'B,U', 14);
//        $pdf->Cell(20, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(120, 7, 'Income Tax:', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(20, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//
//        $pdf->ln(15);
//        $pdf->SetFont('helvetica', '', 14);
//        $pdf->Cell(180, 7, "The supplied material is imported by us and Income Tax U/s 148 of the", 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "Income Tax Ordinance, 2001 is already paid by us, so further tax deducted U/s 153", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "of the Income Tax is not applicable on above mentioned supplies.", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(10);
//        $pdf->Cell(180, 7, "We do hereby undertake to indemnify against any tax liability to be borne by", 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "you in respect of the above transaction. And we also assure that we will be", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(6);
//        $pdf->Cell(180, 7, "responsible for any misstatement in this regard.", 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->ln(12);
//        $pdf->Cell(180, 7, "Thank you.", 0, false, 'L', 0, '', 0, false, 'M', 'M');

        //Close and output PDF document
        $pdf->Output('Exempted Invoice - '.$invoice['document_identity'].'.pdf', 'I');

    }



    public function printSaleInvoice() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $with_previous_balance = isset($this->request->get['with_previous_balance'])?1:0;


        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company = $this->model['company']->getRow(array('company_id' => $session['company_id']));
        $company_branch = $this->model['company_branch']->getRow(array('company_id' => $session['company_id']));
        // d([$company, $company_branch], true);


        $invoice = $this->model['sale_tax_invoice']->getRow(array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        // d($invoice,true);
        $details = $this->model['sale_tax_invoice_detail']->getRows(array('sale_tax_invoice_id' => $sale_tax_invoice_id), array('sort_order asc'));
        $partner = $this->model['partner']->getRow(array('partner_id' => $invoice['partner_id']));
        $delivery_challan_id = $invoice['ref_document_id'];


        $outstanding = $this->model['partner']->getOutstanding("l.`partner_id` = '".$invoice['partner_id']."' AND l.`created_at` < '".$invoice['created_at']."'");
        //d(array($sale_tax_invoice_id, $invoice, $details), true);
        $result_str = array();

        $dcnos = json_decode($invoice['ref_document_id'],true);

        foreach($dcnos as $item){

            $delivery_challan = $this->model['delivery_challan']->getRow(array('delivery_challan_id' => $item));
            //d($delivery_challan,true);

            $result_str[] = $delivery_challan['document_identity'];
        }
        $abc = implode(", ",$result_str);

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        if($invoice['po_date'] == "" || $invoice['po_date'] == '0000-00-00'){
            $this->data['po_date'] = null;
        }
        else{
            $this->data[$invoice['po_date']] = stdDate($invoice['po_date']);
        }

        /*if($invoice['billty_date'] == "" || $invoice['billty_date'] == '0000-00-00'){
            $this->data['billty_date'] = null;
        }
        else{
            $this->data[$invoice['billty_date']] = stdDate($invoice['billty_date']);
        }
*/

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Sale Invoice');
        $pdf->SetSubject('Sale Invoice');

        //Set Header
        // $pdf->InvoiceCheck = "SalesTaxInvoice";
        $pdf->InvoiceCheck = 'sale_invoice';
        $pdf->data = array(
            'company_name' => $session['company_name'],
            //'report_name' => $lang['heading_title'],
            'report_name' => 'Sale Invoice',
            'company_logo' => $session['company_image']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 40, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // add a page
        $pdf->AddPage();
        // set font
        if($invoice['po_date'] != '')
        {
            $invoice['po_date'] = stdDate($invoice['po_date']);
        }

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(80, 7, 'Invoice No: ' . $invoice['manual_ref_no'], 1, false, 'C', 1, '', 1);
        $pdf->Cell(30, 7, '', 'LR', false, 'C', 1, '', 1);
        $pdf->Cell(80, 7, 'Date: ' . stdDate($invoice['document_date']), 1, false, 'C', 1, '', 1);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->ln(8);
        $pdf->MultiCell(50, 15, implode("\n", array('Supplier Name:', 'Address:')), 1, 'L', 1, 2, 10, $y+14, true);
        $pdf->MultiCell(70, 15, implode("\n", array($this->session->data['company_branch_name'], $company_branch['address'])), 1, 'L', 1, 2, 50, $y+14, true);
        $pdf->MultiCell(30, 15, implode("\n", array('Buyer\'s Name:', 'Address:')), 1, ':', 1, 2, 120, $y+14, true);
        $pdf->MultiCell(50, 15, implode("\n", array(html_entity_decode($invoice['partner_name']), $partner['address'])), 1, 'L', 1, 2, 150, $y+14, true);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->Ln(-7);
        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'Telephone No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, $company_branch['phone_no'], 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, 'Telephone No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['mobile'], 1, false, 'L', 1, '', 1);

        // $pdf->Ln(5);
        // $pdf->Cell(40, 5, 'National Tax No:', 1, false, 'L', 1, '', 1);
        // $pdf->Cell(70, 5, '', 1, false, 'L', 1, '', 1);
        // $pdf->Cell(30, 5, 'National Tax No:', 1, false, 'L', 1, '', 1);
        // $pdf->Cell(50, 5, $partner['ntn_no'], 1, false, 'L', 1, '', 1);

        // $pdf->Ln(5);
        // $pdf->Cell(40, 5, 'Sales Tax No:', 1, false, 'L', 1, '', 1);
        // $pdf->Cell(70, 5, $company['gst_no'], 1, false, 'L', 1, '', 1);
        // $pdf->Cell(30, 5, 'Sales Tax No:', 1, false, 'L', 1, '', 1);
        // $pdf->Cell(50, 5, $partner['gst_no'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, '', 1, false, 'L', 1, '', 1);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);
        $pdf->ln(10);

        //1 $w,
        //2 $h,
        //3 $txt,
        //4 $border=0,
        //5 $align='J',
        //6 $fill=false,
        //7 $ln=1,
        //8 $x='',
        //9 $y='',
        //10 $reseth=true,
        //11 $stretch=0,
        //12 $ishtml=false,
        //13 $autopadding=true,
        //14 $maxh=0,
        //15 $valign='T',
        //16 $fitcell=false

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(15, 10, 'QTY IN UNITS', 1, 'C', false, 1, 10, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(135, 10, 'DESCRIPTION OF GOODS', 1, 'C', false, 1, 25, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 10, 'UNIT PRICE', 1, 'C', false, 1, 160, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 10, 'VALUE OF GOODS', 1, 'C', false, 1, 180, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'RATE OF SALES TAX', 1, 'C', false, 1, 120, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'AMOUNT OF SALES TAX', 1, 'C', false, 1, 140, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'FURTHER TAX ON UNREGISTERED PERSON', 1, 'C', false, 1, 160, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'TOTAL', 1, 'C', false, 1, 180, $y+10, true, 0, false, true, 0, 'C', false);
        
        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $total_amount = 0;
        $total_tax_amount = 0;
        $total_further_tax_amount = 0;
        $total_net_amount = 0;
        $sr = 0;
        $pdf->ln(-7);

        $Details = [];
        foreach ($details as $detail) {            
            if(isset($Details[$detail['product_master_id']])) {
                $Details[$detail['product_master_id']]['qty'] += $detail['qty'];
                $Details[$detail['product_master_id']]['amount'] += $detail['amount'];
                $Details[$detail['product_master_id']]['tax_amount'] += $detail['tax_amount'];
                $Details[$detail['product_master_id']]['further_tax_amount'] += $detail['further_tax_amount'];
                $Details[$detail['product_master_id']]['total_amount'] += $detail['total_amount'];
            } else {
                $Details[$detail['product_master_id']] = $detail;
            }
        }


        $SalesTax='';
        $pdf->SetFont('times', '', 8);
        foreach($Details as $detail) {
            $SalesTax = $detail['tax_percent'];
            $sr++;
            $pdf->ln(7);
            $pdf->Cell(15, 7, number_format($detail['qty'],0) . ' ' . $detail['unit'], 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(135, 7, html_entity_decode($detail['description']), 'L', false, 'LR', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['rate'],2), 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['tax_percent'],2) . '%', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['tax_amount'],2), 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['further_tax_amount'],2), 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['total_amount'],2), 'LR', false, 'R', 0, '', 1);

            $total_amount += $detail['amount'];
            $total_tax_amount += $detail['tax_amount'];
            $total_further_tax_amount += $detail['further_tax_amount'];
            $total_net_amount += $detail['total_amount'];
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);

        for ($i = $y; $i <= 170; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(15, 7, '', 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(135, 7, '', 'LR', false, 'L', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'C', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $y =$i;
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);
        
        $this->model['currency'] = $this->load->model('setup/currency');
        $currency = $this->model['currency']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'currency_id' => $invoice['document_currency_id'],
        ));

        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(150, 7, 'Amount In Words ('. $currency['currency_code'] .'): ' . Number2Words(round($total_net_amount,2)). ' only', 'TR', false, 'L', 0, '', 1);
        $pdf->Cell(20, 7, 'Amount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_amount, 2), 1, false, 'R', 0, '', 1);
        
        // $pdf->Ln(7);
        // $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        // $pdf->Cell(20, 7, 'Tax Amount', 1, false, 'R', 0, '', 1);
        // $pdf->Cell(20, 7, number_format(($total_tax_amount+$total_further_tax_amount), 2), 1, false, 'R', 0, '', 1);
     /*   
        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Net Amount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_net_amount, 2), 1, false, 'R', 0, '', 1);
*/



        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Discount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($invoice['discount_amount']), 2), 1, false, 'R', 0, '', 1);


        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Cartage', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($invoice['cartage']), 2), 1, false, 'R', 0, '', 1);




        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Net Amount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($total_net_amount - $invoice['discount_amount'] + $invoice['cartage']), 2), 1, false, 'R', 0, '', 1);





        $pdf->Ln(40);
        $pdf->Cell(15, 7, 'Signature:', 0, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, '', 'B', false, 'C', 0, '', 1);
        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 7, '', 0, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, $this->session->data['company_branch_name'], 0, false, 'C', 0, '', 1);


        //Close and output PDF document
        $pdf->Output('Sale Invoice - '.$invoice['document_identity'].'.pdf', 'I');

    }

    public function printCommercialInvoice() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $with_previous_balance = isset($this->request->get['with_previous_balance'])?1:0;


        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company = $this->model['company']->getRow(array('company_id' => $session['company_id']));
        $company_branch = $this->model['company_branch']->getRow(array('company_id' => $session['company_id']));
        // d([$company, $company_branch], true);


        $invoice = $this->model['sale_tax_invoice']->getRow(array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        //d($invoice,true);
        $details = $this->model['sale_tax_invoice_detail']->getRows(array('sale_tax_invoice_id' => $sale_tax_invoice_id), array('sort_order asc'));
        $partner = $this->model['partner']->getRow(array('partner_id' => $invoice['partner_id']));
        $delivery_challan_id = $invoice['ref_document_id'];


        $outstanding = $this->model['partner']->getOutstanding("l.`partner_id` = '".$invoice['partner_id']."' AND l.`created_at` < '".$invoice['created_at']."'");
        //d(array($sale_tax_invoice_id, $invoice, $details), true);
        $result_str = array();

        $dcnos = json_decode($invoice['ref_document_id'],true);

        foreach($dcnos as $item){

            $delivery_challan = $this->model['delivery_challan']->getRow(array('delivery_challan_id' => $item));
            //d($delivery_challan,true);

            $result_str[] = $delivery_challan['document_identity'];
        }
        $abc = implode(", ",$result_str);

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        if($invoice['po_date'] == "" || $invoice['po_date'] == '0000-00-00'){
            $this->data['po_date'] = null;
        }
        else{
            $this->data[$invoice['po_date']] = stdDate($invoice['po_date']);
        }

        /*if($invoice['billty_date'] == "" || $invoice['billty_date'] == '0000-00-00'){
            $this->data['billty_date'] = null;
        }
        else{
            $this->data[$invoice['billty_date']] = stdDate($invoice['billty_date']);
        }
*/

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Commercial Invoice');
        $pdf->SetSubject('Commercial Invoice');

        //Set Header
        // $pdf->InvoiceCheck = "SalesTaxInvoice";
        if($invoice['sale_type']=='sale_invoice'){
            $this->printSaleInvoice();
            exit;
        }
        $pdf->InvoiceCheck = 'CommercialInvoice';
        $pdf->data = array(
            'company_name' => $session['company_name'],
            //'report_name' => $lang['heading_title'],
            'report_name' => 'Commercial Invoice',
            'company_logo' => $session['company_image']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 40, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // add a page
        $pdf->AddPage();
        // set font
        if($invoice['po_date'] != '')
        {
            $invoice['po_date'] = stdDate($invoice['po_date']);
        }

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(80, 7, 'Invoice No: ' . $invoice['manual_ref_no'], 1, false, 'C', 1, '', 1);
        $pdf->Cell(30, 7, '', 'LR', false, 'C', 1, '', 1);
        $pdf->Cell(80, 7, 'Date: ' . stdDate($invoice['document_date']), 1, false, 'C', 1, '', 1);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->ln(8);
        $pdf->MultiCell(50, 15, implode("\n", array('Supplier Name:', 'Address:')), 1, 'L', 1, 2, 10, $y+14, true);
        $pdf->MultiCell(70, 15, implode("\n", array($this->session->data['company_branch_name'], $company_branch['address'])), 1, 'L', 1, 2, 50, $y+14, true);
        $pdf->MultiCell(30, 15, implode("\n", array('Buyer\'s Name:', 'Address:')), 1, ':', 1, 2, 120, $y+14, true);
        $pdf->MultiCell(50, 15, implode("\n", array(html_entity_decode($invoice['partner_name']), $partner['address'])), 1, 'L', 1, 2, 150, $y+14, true);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->Ln(-7);
        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'Telephone No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, $company_branch['phone_no'], 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, 'Telephone No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['mobile'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'National Tax No:', 1, false, 'L', 1, '', 1);
        if($this->session->data['company_branch_id']==20){
            $pdf->Cell(70, 5, '2910744-0', 1, false, 'L', 1, '', 1);
        } else if($this->session->data['company_branch_id']==22){
            $pdf->Cell(70, 5, '2910599-4', 1, false, 'L', 1, '', 1);
        }
        $pdf->Cell(30, 5, 'National Tax No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['ntn_no'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'Sales Tax No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, $company['gst_no'], 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, 'Sales Tax No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['gst_no'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, '', 1, false, 'L', 1, '', 1);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);
        $pdf->ln(10);

        //1 $w,
        //2 $h,
        //3 $txt,
        //4 $border=0,
        //5 $align='J',
        //6 $fill=false,
        //7 $ln=1,
        //8 $x='',
        //9 $y='',
        //10 $reseth=true,
        //11 $stretch=0,
        //12 $ishtml=false,
        //13 $autopadding=true,
        //14 $maxh=0,
        //15 $valign='T',
        //16 $fitcell=false

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(15, 10, 'QTY IN UNITS', 1, 'C', false, 1, 10, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(135, 10, 'DESCRIPTION OF GOODS', 1, 'C', false, 1, 25, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 10, 'UNIT PRICE', 1, 'C', false, 1, 160, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 10, 'VALUE OF GOODS', 1, 'C', false, 1, 180, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'RATE OF SALES TAX', 1, 'C', false, 1, 120, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'AMOUNT OF SALES TAX', 1, 'C', false, 1, 140, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'FURTHER TAX ON UNREGISTERED PERSON', 1, 'C', false, 1, 160, $y+10, true, 0, false, true, 0, 'C', false);
        // $pdf->MultiCell(20, 15, 'TOTAL', 1, 'C', false, 1, 180, $y+10, true, 0, false, true, 0, 'C', false);
        
        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $total_amount = 0;
        $total_tax_amount = 0;
        $total_further_tax_amount = 0;
        $total_net_amount = 0;
        $discount = 0;
        $sr = 0;
        $pdf->ln(-7);

        $Details = [];
        foreach ($details as $detail) {            
            if(isset($Details[$detail['product_master_id']])) {
                $Details[$detail['product_master_id']]['qty'] += $detail['qty'];
                $Details[$detail['product_master_id']]['amount'] += $detail['amount'];
                $Details[$detail['product_master_id']]['tax_amount'] += $detail['tax_amount'];
                $Details[$detail['product_master_id']]['further_tax_amount'] += $detail['further_tax_amount'];
                $Details[$detail['product_master_id']]['total_amount'] += $detail['total_amount'];
                //$Details[$detail['product_master_id']]['discount_amount'] += $detail['discount_amount'];
            } else {
                $Details[$detail['product_master_id']] = $detail;
            }
        }

 
        $SalesTax='';
        $pdf->SetFont('times', '', 8);
        foreach($Details as $detail) {
            $SalesTax = $detail['tax_percent'];
            $sr++;
            $pdf->ln(7);
            $pdf->Cell(15, 7, number_format($detail['qty'],0) . ' ' . $detail['unit'], 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(135, 7, html_entity_decode($detail['description']), 'L', false, 'LR', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['rate'],2), 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['tax_percent'],2) . '%', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['tax_amount'],2), 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['further_tax_amount'],2), 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, number_format($detail['total_amount'],2), 'LR', false, 'R', 0, '', 1);

            $total_amount += $detail['amount'];
            $total_tax_amount += $detail['tax_amount'];
            $total_further_tax_amount += $detail['further_tax_amount'];
            $total_net_amount += $detail['total_amount'];
           // $discount += $detail['discount_amount'];
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);

        for ($i = $y; $i <= 170; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(15, 7, '', 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(135, 7, '', 'LR', false, 'L', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'C', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            // $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $y =$i;
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);
        
        $this->model['currency'] = $this->load->model('setup/currency');
        $currency = $this->model['currency']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'currency_id' => $invoice['document_currency_id'],
        ));

        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(150, 7, 'Amount In Words ('. $currency['currency_code'] .'): ' . Number2Words(round($total_net_amount,2)). ' only', 'TR', false, 'L', 0, '', 1);
        $pdf->Cell(20, 7, 'Amount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_amount, 2), 1, false, 'R', 0, '', 1);
        
        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Tax Amount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($total_tax_amount+$total_further_tax_amount), 2), 1, false, 'R', 0, '', 1);
        
//d ($invoice,true);

        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Discount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($invoice['discount_amount']), 2), 1, false, 'R', 0, '', 1);


        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Cartage', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($invoice['cartage']), 2), 1, false, 'R', 0, '', 1);




        $pdf->Ln(7);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, 'Net Amount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format(($total_net_amount - $invoice['discount_amount'] + $invoice['cartage']), 2), 1, false, 'R', 0, '', 1);



        $pdf->Ln(40);
        $pdf->Cell(15, 7, 'Signature:', 0, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, '', 'B', false, 'C', 0, '', 1);
        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 7, '', 0, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, $this->session->data['company_branch_name'], 0, false, 'C', 0, '', 1);


        //Close and output PDF document
        $pdf->Output('Commercial Invoice - '.$invoice['document_identity'].'.pdf', 'I');

    }


    public function printSalesTaxInvoice() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $with_previous_balance = isset($this->request->get['with_previous_balance'])?1:0;


        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company = $this->model['company']->getRow(array('company_id' => $session['company_id']));
        $company_branch = $this->model['company_branch']->getRow(array('company_id' => $session['company_id']));
        // d([$company, $company_branch], true);


        $invoice = $this->model['sale_tax_invoice']->getRow(array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        // d($invoice,true);
        $details = $this->model['sale_tax_invoice_detail']->getRows(array('sale_tax_invoice_id' => $sale_tax_invoice_id), array('sort_order asc'));
        $partner = $this->model['partner']->getRow(array('partner_id' => $invoice['partner_id']));
        $delivery_challan_id = $invoice['ref_document_id'];


        $outstanding = $this->model['partner']->getOutstanding("l.`partner_id` = '".$invoice['partner_id']."' AND l.`created_at` < '".$invoice['created_at']."'");
        //d(array($sale_tax_invoice_id, $invoice, $details), true);
        $result_str = array();

        $dcnos = json_decode($invoice['ref_document_id'],true);

        foreach($dcnos as $item){

            $delivery_challan = $this->model['delivery_challan']->getRow(array('delivery_challan_id' => $item));
            //d($delivery_challan,true);

            $result_str[] = $delivery_challan['document_identity'];
        }
        $abc = implode(", ",$result_str);

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        if($invoice['po_date'] == "" || $invoice['po_date'] == '0000-00-00'){
            $this->data['po_date'] = null;
        }
        else{
            $this->data[$invoice['po_date']] = stdDate($invoice['po_date']);
        }

        /*if($invoice['billty_date'] == "" || $invoice['billty_date'] == '0000-00-00'){
            $this->data['billty_date'] = null;
        }
        else{
            $this->data[$invoice['billty_date']] = stdDate($invoice['billty_date']);
        }
*/

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Sales Tax Invoice');
        $pdf->SetSubject('Sales Tas Invoice');

        //Set Header
        // $pdf->InvoiceCheck = "SalesTaxInvoice";
        if($invoice['sale_type']=='sale_invoice'){
            $this->printSaleInvoice();
            exit;
        }

        $pdf->InvoiceCheck = $invoice['sale_type'];
        $pdf->data = array(
            'company_name' => $session['company_name'],
            //'report_name' => $lang['heading_title'],
            'report_name' => 'Bill',
            'company_logo' => $session['company_image']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 40, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // add a page
        $pdf->AddPage();
        // set font

        // $txt="21,Adnan Centre Jeswani Street, off. Aiwan-E-Tijarat Road,
        // Karachi - 74000, Pakistan
        // TEL: 92-21-32401236,92-21-32415063
        // FAX: 92-21-32428040
        // Email : info@hacsons.com Web: www.hacsons.com.
        // 82/4 Railway Road Chowk Dalgarah Lahore.
        // TEL: 042-37662521,042-37662527";

        // $txt = $company_address['address'].' , 
        // '.$company_address['name'].' 
        // TEL: '.$company_address['phone_no'];

//        $txt = "";

        if($invoice['po_date'] != '')
        {
            $invoice['po_date'] = stdDate($invoice['po_date']);
        }

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(80, 7, 'Invoice No: ' . $invoice['manual_ref_no'], 1, false, 'C', 1, '', 1);
        $pdf->Cell(30, 7, '', 'LR', false, 'C', 1, '', 1);
        $pdf->Cell(80, 7, 'Date: ' . stdDate($invoice['document_date']), 1, false, 'C', 1, '', 1);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->ln(8);
        $pdf->MultiCell(50, 15, implode("\n", array('Supplier Name:', 'Address:')), 1, 'L', 1, 2, 10, $y+14, true);
        $pdf->MultiCell(70, 15, implode("\n", array($this->session->data['company_branch_name'], $company_branch['address'])), 1, 'L', 1, 2, 50, $y+14, true);
        $pdf->MultiCell(30, 15, implode("\n", array('Buyer\'s Name:', 'Address:')), 1, ':', 1, 2, 120, $y+14, true);
        $pdf->MultiCell(50, 15, implode("\n", array(html_entity_decode($invoice['partner_name']), $partner['address'])), 1, 'L', 1, 2, 150, $y+14, true);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->Ln(-7);
        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'Telephone No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, $company_branch['phone_no'], 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, 'Telephone No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['mobile'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'National Tax No:', 1, false, 'L', 1, '', 1);
        if($this->session->data['company_branch_id']==20){
            $pdf->Cell(70, 5, '2910744-0', 1, false, 'L', 1, '', 1);
        } else if($this->session->data['company_branch_id']==22){
            $pdf->Cell(70, 5, '2910599-4', 1, false, 'L', 1, '', 1);
        }
        $pdf->Cell(30, 5, 'National Tax No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['ntn_no'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, 'Sales Tax No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, $company['gst_no'], 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, 'Sales Tax No:', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, $partner['gst_no'], 1, false, 'L', 1, '', 1);

        $pdf->Ln(5);
        $pdf->Cell(40, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(70, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(30, 5, '', 1, false, 'L', 1, '', 1);
        $pdf->Cell(50, 5, '', 1, false, 'L', 1, '', 1);

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);
        $pdf->ln(10);

        //1 $w,
        //2 $h,
        //3 $txt,
        //4 $border=0,
        //5 $align='J',
        //6 $fill=false,
        //7 $ln=1,
        //8 $x='',
        //9 $y='',
        //10 $reseth=true,
        //11 $stretch=0,
        //12 $ishtml=false,
        //13 $autopadding=true,
        //14 $maxh=0,
        //15 $valign='T',
        //16 $fitcell=false

        $pdf->MultiCell(15, 15, 'QTY IN UNITS', 1, 'C', false, 1, 10, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(55, 15, 'DESCRIPTION OF GOODS', 1, 'C', false, 1, 25, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 15, 'UNIT PRICE', 1, 'C', false, 1, 80, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 15, 'VALUE OF GOODS', 1, 'C', false, 1, 100, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 15, 'RATE OF SALES TAX', 1, 'C', false, 1, 120, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 15, 'AMOUNT OF SALES TAX', 1, 'C', false, 1, 140, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 15, 'FURTHER TAX ON UNREGISTERED PERSON', 1, 'C', false, 1, 160, $y+10, true, 0, false, true, 0, 'C', false);
        $pdf->MultiCell(20, 15, 'TOTAL', 1, 'C', false, 1, 180, $y+10, true, 0, false, true, 0, 'C', false);
        
        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x, $y);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $total_amount = 0;
        $total_tax_amount = 0;
        $total_further_tax_amount = 0;
        $total_net_amount = 0;
        $sr = 0;
        $pdf->ln(-7);

        $Details = [];
        foreach ($details as $detail) {            
            if(isset($Details[$detail['product_master_id']])) {
                $Details[$detail['product_master_id']]['qty'] += $detail['qty'];
                $Details[$detail['product_master_id']]['amount'] += $detail['amount'];
                $Details[$detail['product_master_id']]['tax_amount'] += $detail['tax_amount'];
                $Details[$detail['product_master_id']]['further_tax_amount'] += $detail['further_tax_amount'];
                $Details[$detail['product_master_id']]['total_amount'] += $detail['total_amount'];
            } else {
                $Details[$detail['product_master_id']] = $detail;
            }
        }

        $SalesTax='';
        $pdf->SetFont('times', '', 7);
        foreach($Details as $detail) {
            $SalesTax = $detail['tax_percent'];
            $sr++;
            $pdf->ln(7);
            $pdf->Cell(15, 7, number_format($detail['qty'],0) . ' ' . $detail['unit'], 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(55, 7, html_entity_decode($detail['description']), 'L', false, 'LR', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['rate'],2), 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['tax_percent'],2) . '%', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['tax_amount'],2), 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['further_tax_amount'],2), 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, number_format($detail['total_amount'],2), 'LR', false, 'R', 0, '', 1);

            $total_amount += $detail['amount'];
            $total_tax_amount += $detail['tax_amount'];
            $total_further_tax_amount += $detail['further_tax_amount'];
            $total_net_amount += $detail['total_amount'];
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);

        for ($i = $y; $i <= 170; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(15, 7, '', 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(55, 7, '', 'LR', false, 'L', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'C', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'LR', false, 'R', 0, '', 1);
            $y =$i;
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);
        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(15, 7, 'Total', 1, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, '', 1, false, 'L', 0, '', 1);
        $pdf->Cell(20, 7, '', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_amount, 2), 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, '', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_tax_amount, 2), 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_further_tax_amount, 2), 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_net_amount, 2), 1, false, 'R', 0, '', 1);

        $pdf->Ln(7);
        $this->model['currency'] = $this->load->model('setup/currency');
        $currency = $this->model['currency']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'currency_id' => $invoice['document_currency_id'],
        ));

        $pdf->Cell(190, 7, 'Amount In Words ('. $currency['currency_code'] .'): ' . Number2Words(round($total_net_amount,2)). ' only', 1, false, 'L', 0, '', 1);

        $pdf->Ln(40);
        $pdf->Cell(15, 7, 'Signature:', 0, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, '', 'B', false, 'C', 0, '', 1);
        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 7, '', 0, false, 'C', 0, '', 1);
        $pdf->Cell(55, 7, $this->session->data['company_branch_name'], 0, false, 'C', 0, '', 1);




        //Close and output PDF document
        $pdf->Output('Sale Tax Invoice - '.$invoice['document_identity'].'.pdf', 'I');

    }


}

class PDF extends TCPDF {
    public $data = array();
    Public $InvoiceCheck;
    //Page header
    public function Header() {
        // Logo
        /*
        if($this->data['company_logo'] != '') {
            $image_file = DIR_IMAGE.$this->data['company_logo'];
            //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
            //$this->Image($image_file, 10, 5, 150, '', '', '', 'C', false, 300, '', false, false, 1, false, false, false);
            $x = 15;
            $y = 0;
            $w = 180;
            $h = 40;
            //$this->Rect($x, $y, $w, $h, 'F', array(), array(128,255,128));
            $this->Image($image_file, $x, $y, $w, $h, '', '', '', false, 300, '', false, false, 0, 'LM', false, false);
        }
        */
        // Set font

        if($this->InvoiceCheck == "Bill")
        {
//            $txt="TEL: 92-21-32401236 92-21-32415063
//        FAX: 92-21-32428040";
//
//            $this->Ln(6);
//            $this->SetFont('helvetica', 'B', 30);
//            $this->Ln(2);
//            // Title
//            $this->Cell(190, 12, html_entity_decode($this->data['company_name']), 0, false, 'C', 0, '', 0, false, 'M', 'M');
//
//            $this->SetFont('helvetica', 'B', 10);
//            $this->SetFillColor(255,255,255);
//            $this->MultiCell(55, 5, $txt, 0, 'R', 1, 2, 150, 7, true);
//
//            $this->Ln(5);
//            $this->SetFont('helvetica', 'B', 10);
//            $this->Cell(0, 5, "IMOPERTERS, EXPORTERS, AGENTS, MANUFACTURER'S & REPRESNTATIVE", 0, false, 'C', 0, '', 0, false, 'M', 'M');
//            $this->Ln(5);
//            $this->Cell(0, 5, "Deals in : Hardware Tools, Safety Equipments & General Order Suppliers.", 0, false, 'C', 0, '', 0, false, 'M', 'M');
//            $this->Ln(5);
//            $this->Cell(0, 5, "21,Adnan Centre Jeswani Street, off. Aiwan-E-Tijarat Road, Karachi - 74000, Pakistan", 0, false, 'C', 0, '', 0, false, 'M', 'M');
//            $this->Ln(5);
//            $this->Cell(0, 5, "Email : info@hacsons.com , Web: www.hacsons.com", 0, false, 'C', 0, '', 0, false, 'M', 'M');
//            $this->Ln(10);
            $this->Image($this->data['header_image'], 0, 5, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
            $this->Ln(47);

            $this->SetFont('helvetica', 'B,I', 16);
            $this->Cell(0, 5, "Estimate", 0, false, 'C', 0, '', 0, false, 'M', 'M');


        }
        if($this->InvoiceCheck == "sale_tax_invoice")
        {

            $this->Ln(6);
            $this->SetFont('helvetica', 'B', 14);
            $this->Ln(2);
            // Title
            $this->Cell(0, 12, 'SALES TAX INVOICE', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            // $this->SetFont('helvetica', 'B', 30);
            // $this->Cell(95, 12, html_entity_decode($this->data['company_name']), 0, false, 'C', 0, '', 0, false, 'M', 'M');


            $this->Ln(10);

        }
        if($this->InvoiceCheck == "sale_invoice")
        {

            $this->Ln(6);
            $this->SetFont('helvetica', 'B', 14);
            $this->Ln(2);
            // Title
            $this->Cell(0, 12, 'SALES INVOICE', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            // $this->SetFont('helvetica', 'B', 30);
            // $this->Cell(95, 12, html_entity_decode($this->data['company_name']), 0, false, 'C', 0, '', 0, false, 'M', 'M');


            $this->Ln(10);

        }
        if($this->InvoiceCheck == "CommercialInvoice")
        {

            $this->Ln(6);
            $this->SetFont('helvetica', 'B', 14);
            $this->Ln(2);
            // Title
            $this->Cell(0, 12, 'COMMERCIAL INVOICE', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            // $this->SetFont('helvetica', 'B', 30);
            // $this->Cell(95, 12, html_entity_decode($this->data['company_name']), 0, false, 'C', 0, '', 0, false, 'M', 'M');


            $this->Ln(10);

        }

        if($this->InvoiceCheck == "Exempted Bill")
        {
//            $this->Image($this->data['header_image'], 0, 5, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
            $this->Image($this->data['header_image'], 0, 5, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
//            $this->Ln(47);
        }

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        // Set font

        if($this->InvoiceCheck == "Bill")
        {
            $this->SetY(-55);
            $this->SetFont('helvetica', 'B,I', 10);
            $this->Cell(100, 5, "Goods once sold can not be taken back of exchanged", 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(80, 5, 'For '.html_entity_decode($this->data['company_name']), 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $this->Ln(5);
//            $this->SetFont('helvetica', 'I', 8);
//            // Page number
//            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $this->Image($this->data['footer_image'], 0, 250, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
            $this->Ln(5);
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        }
        if($this->InvoiceCheck == "sale_tax_invoice")
        {
            $this->SetY(-20);
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        }
        if($this->InvoiceCheck == "sale_invoice")
        {
            $this->SetY(-20);
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        }

        if($this->InvoiceCheck == "Exempted Bill")
        {
            $this->SetY(-55);
            $this->SetFont('helvetica', 'B,I', 10);
            $this->Image($this->data['footer_image'], 0, 250, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
//            $this->Ln(5);
//            $this->SetFont('helvetica', 'I', 8);
            // Page number
//            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        }

    }
}




?>