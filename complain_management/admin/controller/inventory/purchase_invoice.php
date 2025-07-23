<?php

class ControllerInventoryPurchaseInvoice extends HController {

    protected $document_type_id = 1;

    protected function getAlias() {
        return 'inventory/purchase_invoice';
    }

    protected function getPrimaryKey() {
        return 'purchase_invoice_id';
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
        $aColumns = array('action', 'document_date', 'document_identity','partner_name','remarks', 'net_amount', 'created_at', 'check_box');

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
                'btn_class' => 'btn btn-primary btn-xs',
                'class' => 'fa fa-pencil'
            );

            $actions[] = array(
                'text' => $lang['print'],
                'target' => '_blank',
                'href' => $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
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
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' '.(isset($action['target'])?'target="'.$action['target'].'"':'').' '.' href="' . $action['href'] . '" data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
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
                } elseif ($aColumns[$i] == 'created_at') {
                    $row[] = stdDateTime($aRow['created_at']);
                } elseif ($aColumns[$i] == 'check_box') {
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
        parent::getForm();

       // $this->model['product'] = $this->load->model('inventory/product');
       // $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        // $this->model['supplier'] = $this->load->model('setup/supplier');
        // $this->data['suppliers'] = $this->model['supplier']->getRows(array('company_id' => $this->session->data['company_id']),array('name'));


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
        //d($this->data, true);

        $this->data['partner_types'] = $this->session->data['partner_types'];
        

        $this->data['document_date'] = stdDate();
        if (isset($this->request->get['purchase_invoice_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getRow(array('purchase_invoice_id' => $this->request->get[$this->getPrimaryKey()]));
            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } else {
                    $this->data[$field] = $value;
                }
            }
            $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');
            $this->data['purchase_invoice_details'] = $this->model['purchase_invoice_detail']->getRows(array('purchase_invoice_id' => $this->request->get['purchase_invoice_id']), array('sort_order'));
        }

        $this->data['partner_type_id'] = 1;
        $this->data['href_get_partner_json'] = $this->url->link($this->getAlias() . '/getPartnerJson', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_partner'] = $this->url->link($this->getAlias() . '/getPartner', 'token=' . $this->session->data['token']);

        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_ref_document_no'] = $this->url->link($this->getAlias() . '/getReferenceDocumentNos', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_ref_document'] = $this->url->link($this->getAlias() . '/getReferenceDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
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

    protected function insertData($data) {
        $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');
        foreach ($data['purchase_invoice_details'] as $key => $value) {
            // d($value);
            $temp = $this->model['purchase_invoice_detail']->getRow(array('company_id' => $this->session->data['company_id'], 'ref_document_type_id' => $value['ref_document_type_id'], 'ref_document_identity' => $value['ref_document_identity']));
            if(!empty($temp) && $value['ref_document_type_id'] != 0 && !empty($value['ref_document_identity']))
            {
                $previous_invoice[] = $temp;
            }
        }

        if($previous_invoice)
        {
            return $this->session->data['error_warning'] = 'Purchase Invoice already created for this Good Receive Note';
        }
        // d($previous_invoice,true);
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['product']= $this->load->model('inventory/product');
        $this->model['setting']= $this->load->model('common/setting');

        //d($data, true);
        $document = $this->model['document_type']->getNextDocument($this->document_type_id);

        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_amount'] = $data['net_amount'] * $data['conversion_rate'];
        $purchase_invoice_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $purchase_invoice_id;

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $purchase_invoice_id,
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['net_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['base_amount'],
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
            'field' => 'purchase_discount_account_id',
        ));
        $purchase_discount_account_id = $setting['value'];

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
            'field' => 'gr_ir_account_id',
        ));
        $gr_ir_account_id = $setting['value'];

        $partner = $this->model['partner']->getRow(array('partner_type_id' => $data['partner_type_id'], 'partner_id' => $data['partner_id']));
        $outstanding_account_id = $partner['outstanding_account_id'];

        foreach ($data['purchase_invoice_details'] as $sort_order => $detail) {
            $detail['purchase_invoice_id'] = $purchase_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_total'] = $detail['total_amount'] * $data['conversion_rate'];
            $purchase_invoice_detail_id = $this->model['purchase_invoice_detail']->add($this->getAlias(), $detail);

            $document_datetime = date('Y-m-d H:i:s',strtotime($data['document_date'].date('H:i:s')));
            $product = $this->model['product']->getRow(['product_id' => $detail['product_id']]);

            if( ($document_datetime >=  $product['document_datetime']) || empty($product['document_datetime'])){
                $product_update_date = [];
                $product_update_date['cost_price'] = $detail['rate'];
                $product_update_date['document_datetime'] = $document_datetime;
                $product = $this->model['product']->edit('inventory/product', $detail['product_id'], $product_update_date);
            }

            if($detail['ref_document_type_id'] == 17) {

                if(floatval($detail['amount']) > 0) {
                    $gl_data[] = array(
                        'document_detail_id' => $purchase_invoice_detail_id,
                        'ref_document_type_id' => $detail['ref_document_type_id'],
                        'ref_document_id' => $detail['ref_document_id'],
                        'ref_document_identity' => $detail['ref_document_identity'],
                        'coa_id' => $gr_ir_account_id,
                        'document_debit' => $detail['amount'],
                        'document_credit' => 0,
                        'debit' => ($detail['amount'] * $data['conversion_rate']),
                        'credit' => 0,
                        'product_id' => $detail['product_id'],
                        'qty' => $detail['qty'],
                        'document_amount' => $detail['amount'],
                        'amount' => ($detail['amount'] * $data['conversion_rate']),
                    );
                }
            } else {
                
                $stock_ledger = array(
                    'company_id' => $detail['company_id'],
                    'company_branch_id' => $detail['company_branch_id'],
                    'fiscal_year_id' => $detail['fiscal_year_id'],
                    'document_type_id' => $data['document_type_id'],
                    'document_id' => $data['document_id'],
                    'document_identity' => $data['document_identity'],
                    'document_date' => $data['document_date'],
                    'document_detail_id' => $purchase_invoice_detail_id,
                    'warehouse_id' => $detail['warehouse_id'],
                    'product_id' => $detail['product_id'],
                    'document_unit_id' => $detail['unit_id'],
                    'document_qty' => $detail['qty'],
                    'unit_conversion' => 1,
                    'base_unit_id' => $detail['unit_id'],
                    'base_qty' => $detail['qty'],
                    'container_no' => $detail['container_no'],
                    'batch_no' => $detail['batch_no'],
                    'document_currency_id' => $detail['document_currency_id'],
                    'document_rate' => $detail['rate'],
                    'document_amount' => $detail['amount'],
                    'currency_conversion' => $detail['conversion_rate'],
                    'base_currency_id' => $detail['base_currency_id'],
                    'base_rate' => ($detail['rate'] * $detail['conversion_rate']),
                    'base_amount' => ($detail['amount'] * $detail['conversion_rate']),
                );
            $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $stock_ledger);

                $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));
                
                if(floatval($detail['amount']) > 0) {
                    $gl_data[] = array(
                        'document_detail_id' => $purchase_invoice_detail_id,
                        'ref_document_type_id' => $detail['ref_document_type_id'],
                        'ref_document_identity' => $detail['ref_document_identity'],
                        'coa_id' => $product['inventory_account_id'],
                        'document_debit' => $detail['amount'],
                        'document_credit' => 0,
                        'debit' => ($detail['amount'] * $data['conversion_rate']),
                        'credit' => 0,
                        'product_id' => $detail['product_id'],
                        'qty' => $detail['qty'],
                        'document_amount' => $detail['amount'],
                        'amount' => ($detail['amount'] * $data['conversion_rate']),
                    );
                }
            }

            if(floatval($detail['discount_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $purchase_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $purchase_discount_account_id,
                    'document_debit' => 0,
                    'document_credit' => $detail['discount_amount'],
                    'debit' => 0,
                    'credit' => ($detail['discount_amount'] * $data['conversion_rate']),
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['discount_amount'],
                    'amount' => ($detail['discount_amount'] * $data['conversion_rate']),
                );
            }

            if(floatval($detail['tax_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $purchase_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_tax_account_id,
                    'document_debit' => $detail['tax_amount'],
                    'document_credit' => 0,
                    'debit' => ($detail['tax_amount'] * $data['conversion_rate']),
                    'credit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['tax_amount'],
                    'amount' => ($detail['tax_amount'] * $data['conversion_rate']),
                );
            }
        }

        if(floatval($data['discount']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $purchase_discount_account_id,
                'document_debit' => 0,
                'document_credit' => $data['discount'],
                'debit' => 0,
                'credit' => ($data['discount'] * $data['conversion_rate'])
            );
        }

        $gl_data[] = array(
            'ref_document_type_id' => $this->document_type_id,
            'ref_document_identity' => $data['document_identity'],
            'coa_id' => $outstanding_account_id,
            'document_debit' => 0,
            'document_credit' => $data['net_amount'],
            'debit' => 0,
            'credit' => ($data['net_amount'] * $data['conversion_rate']),
        );

        if($data['invoice_type']=='Cash') {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $outstanding_account_id,
                'document_credit' => 0,
                'document_debit' => $data['net_amount'],
                'credit' => 0,
                'debit' => ($data['net_amount'] * $data['conversion_rate']),
            );

            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cash_account_id,
                'document_debit' => 0,
                'document_credit' => $data['net_amount'],
                'debit' => 0,
                'credit' => ($data['net_amount'] * $data['conversion_rate']),
            );
        }

        //d($gl_data, true);
        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $purchase_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];
            $ledger['remarks'] = $data['remarks'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }
        return $purchase_invoice_id;
    }

    protected function updateData($primary_key, $data) {
        $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['product']= $this->load->model('inventory/product');
        $this->model['setting']= $this->load->model('common/setting');
        $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_amount'] = $data['net_amount'] * $data['conversion_rate'];
        $purchase_invoice_id = $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);
        $data['document_id'] = $purchase_invoice_id;

        $this->model['purchase_invoice_detail']->deleteBulk($this->getAlias(), array('purchase_invoice_id' => $purchase_invoice_id));
        $this->model['document']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $purchase_invoice_id,
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['net_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['base_amount'],
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
            'field' => 'purchase_discount_account_id',
        ));
        $purchase_discount_account_id = $setting['value'];

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
            'field' => 'gr_ir_account_id',
        ));
        $gr_ir_account_id = $setting['value'];

        $partner = $this->model['partner']->getRow(array('partner_type_id' => $data['partner_type_id'], 'partner_id' => $data['partner_id']));
        $outstanding_account_id = $partner['outstanding_account_id'];

        foreach ($data['purchase_invoice_details'] as $sort_order => $detail) {
            $detail['purchase_invoice_id'] = $purchase_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_total'] = $detail['total_amount'] * $data['conversion_rate'];
            $purchase_invoice_detail_id = $this->model['purchase_invoice_detail']->add($this->getAlias(), $detail);

            $document_datetime = date('Y-m-d H:i:s',strtotime($data['document_date'].date('H:i:s')));
            $product = $this->model['product']->getRow(['product_id' => $detail['product_id']]);

            if( ($document_datetime >=  $product['document_datetime']) || empty($product['document_datetime'])){
                $product_update_date = [];
                $product_update_date['cost_price'] = $detail['rate'];
                $product_update_date['document_datetime'] = $document_datetime;
                $product = $this->model['product']->edit('inventory/product', $detail['product_id'], $product_update_date);
            }

            if($detail['ref_document_type_id'] == 17) {
                if(floatval($detail['amount']) > 0) {

                    $gl_data[] = array(
                        'document_detail_id' => $purchase_invoice_detail_id,
                        'ref_document_type_id' => $detail['ref_document_type_id'],
                        'ref_document_id' => $detail['ref_document_id'],
                        'ref_document_identity' => $detail['ref_document_identity'],
                        'coa_id' => $gr_ir_account_id,
                        'document_debit' => $detail['amount'],
                        'document_credit' => 0,
                        'debit' => ($detail['amount'] * $data['conversion_rate']),
                        'credit' => 0,
                        'product_id' => $detail['product_id'],
                        'qty' => $detail['qty'],
                        'document_amount' => $detail['amount'],
                        'amount' => ($detail['amount'] * $data['conversion_rate']),
                    );
                }
            } else {

                $stock_ledger = array(
                    'company_id' => $detail['company_id'],
                    'company_branch_id' => $detail['company_branch_id'],
                    'fiscal_year_id' => $detail['fiscal_year_id'],
                    'document_type_id' => $data['document_type_id'],
                    'document_id' => $data['document_id'],
                    'document_identity' => $data['document_identity'],
                    'document_date' => $data['document_date'],
                    'document_detail_id' => $purchase_invoice_detail_id,
                    'warehouse_id' => $detail['warehouse_id'],
                    'product_id' => $detail['product_id'],
                    'document_unit_id' => $detail['unit_id'],
                    'document_qty' => $detail['qty'],
                    'unit_conversion' => 1,
                    'base_unit_id' => $detail['unit_id'],
                    'base_qty' => $detail['qty'],
                    'container_no' => $detail['container_no'],
                    'batch_no' => $detail['batch_no'],
                    'document_currency_id' => $detail['document_currency_id'],
                    'document_rate' => $detail['rate'],
                    'document_amount' => $detail['amount'],
                    'currency_conversion' => $detail['conversion_rate'],
                    'base_currency_id' => $detail['base_currency_id'],
                    'base_rate' => ($detail['rate'] * $detail['conversion_rate']),
                    'base_amount' => ($detail['amount'] * $detail['conversion_rate']),
                );
                $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $stock_ledger);

                


                $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));
                if(floatval($detail['amount']) > 0) {
                
                    $gl_data[] = array(
                        'document_detail_id' => $purchase_invoice_detail_id,
                        'ref_document_type_id' => $detail['ref_document_type_id'],
                        'ref_document_identity' => $detail['ref_document_identity'],
                        'coa_id' => $product['inventory_account_id'],
                        'document_debit' => $detail['amount'],
                        'document_credit' => 0,
                        'debit' => ($detail['amount'] * $data['conversion_rate']),
                        'credit' => 0,
                        'product_id' => $detail['product_id'],
                        'qty' => $detail['qty'],
                        'document_amount' => $detail['amount'],
                        'amount' => ($detail['amount'] * $data['conversion_rate']),
                    );
                }
            }

            if(floatval($detail['discount_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $purchase_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $purchase_discount_account_id,
                    'document_debit' => 0,
                    'document_credit' => $detail['discount_amount'],
                    'debit' => 0,
                    'credit' => ($detail['discount_amount'] * $data['conversion_rate']),
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['discount_amount'],
                    'amount' => ($detail['discount_amount'] * $data['conversion_rate']),
                );
            }

            if(floatval($detail['tax_amount']) > 0) {
                $gl_data[] = array(
                    'document_detail_id' => $purchase_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $sale_tax_account_id,
                    'document_debit' => $detail['tax_amount'],
                    'document_credit' => 0,
                    'debit' => ($detail['tax_amount'] * $data['conversion_rate']),
                    'credit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['tax_amount'],
                    'amount' => ($detail['tax_amount'] * $data['conversion_rate']),
                );
            }
        }

        if(floatval($data['discount']) > 0) {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $purchase_discount_account_id,
                'document_debit' => 0,
                'document_credit' => $data['discount'],
                'debit' => 0,
                'credit' => ($data['discount'] * $data['conversion_rate'])
            );
        }

        $gl_data[] = array(
            'ref_document_type_id' => $this->document_type_id,
            'ref_document_identity' => $data['document_identity'],
            'coa_id' => $outstanding_account_id,
            'document_debit' => 0,
            'document_credit' => $data['net_amount'],
            'debit' => 0,
            'credit' => ($data['net_amount'] * $data['conversion_rate']),
        );

        if($data['invoice_type']=='Cash') {
            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $outstanding_account_id,
                'document_credit' => 0,
                'document_debit' => $data['net_amount'],
                'credit' => 0,
                'debit' => ($data['net_amount'] * $data['conversion_rate']),
            );

            $gl_data[] = array(
                'ref_document_type_id' => $this->document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $cash_account_id,
                'document_debit' => 0,
                'document_credit' => $data['net_amount'],
                'debit' => 0,
                'credit' => ($data['net_amount'] * $data['conversion_rate']),
            );
        }

        //d($gl_data, true);
        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $purchase_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];
            $ledger['remarks'] = $data['remarks'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }
        return $purchase_invoice_id;
    }

    protected function deleteData($primary_key) {
        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);

        $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');
        $this->model['purchase_invoice_detail']->deleteBulk($this->getAlias(), array('purchase_invoice_id' => $primary_key));

        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
    }

    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model['product'] = $this->load->model('inventory/product');
        $rows = $this->model['product']->getProductJson($search, $page);

        echo json_encode($rows);
    }

    public function getReferenceDocumentNos() {
        $purchase_invoice_id = $this->request->get['purchase_invoice_id'];
        $post = $this->request->post;
        //d(array($goods_received_id, $post), true);

        //Purchase Order
        $this->model['purchase_order'] = $this->load->model('inventory/purchase_order');
        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
        $where .= " AND partner_type_id='" . $post['partner_type_id'] . "'";
        $where .= " AND partner_id='" . $post['partner_id'] . "'";
//        $where .= " AND is_post=1";
        $purchase_orders = $this->model['purchase_order']->getPurchaseOrders($where,$purchase_invoice_id);
        foreach($purchase_orders as $purchase_order_id => $purchase_order) {
            foreach($purchase_order['products'] as $product_id => $product) {
                if($product['order_qty'] <= $product['utilized_qty']) {
                    unset($purchase_order['products'][$product_id]);
                }
            }
            if(empty($purchase_order['products'])) {
                unset($purchase_orders[$purchase_order_id]);
            }
        }

//        $html = "";
//        if(count($purchase_orders) != 1) {
//            $html .= '<option value="">&nbsp;</option>';
//        }
        $html = "";
        $html .= '<option value="">&nbsp;</option>';
        foreach($purchase_orders as $purchase_order_id => $purchase_order) {

                if($purchase_order['purchase_order_id']==$post['ref_document_id']) {
                    $html .= '<option value="'.$purchase_order_id.'" selected="true">'.$purchase_order['document_identity'].' '.'('.$purchase_order['manual_ref_no'].')'. '</option>';
                } else {
                    $html .= '<option value="'.$purchase_order_id.'">'.$purchase_order['document_identity'].' '.'('.$purchase_order['manual_ref_no'].')'. '</option>';
                }

        }

       // d($html,true);
        $json = array(
            'success' => true,
            'purchase_invoice_id' => $purchase_invoice_id,
            'post' => $post,
            'where' => $where,
            'html' => $html
        );  

        echo json_encode($json);
    }

    public function getReferenceDocument() {
        $purchase_invoice_id = $this->request->get['purchase_invoice_id'];
        $post = $this->request->post;

        //Purchase Order
        $this->model['purchase_order'] = $this->load->model('inventory/purchase_order');
        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
        $where .= " AND partner_id='" . $post['partner_id'] . "'";
        $where .= " AND document_identity='" . $post['ref_document_identity'] . "'";

        $PO = $this->model['purchase_order']->getRow($where);

        $purchase_orders = $this->model['purchase_order']->getPurchaseOrders($where,$purchase_invoice_id);
        $purchase_order = $purchase_orders[$post['ref_document_identity']];
        //        d($purchase_order,true);


        $details = array();
        $row_no = 0;
        foreach($purchase_order['products'] as $product) {
//d($product);
            if($product['order_qty'] - $product['utilized_qty'] > 0)
            {

                $href = $this->url->link('inventory/goods_received/update', 'token=' . $this->session->data['token'] . '&goods_received_id=' . $purchase_order['goods_received_id']);
                $details[$row_no] = $product;
                $details[$row_no]['ref_document_identity'] = $purchase_order['document_identity'];
                $details[$row_no]['row_identity'] = $purchase_order['document_identity'].'-'.$product['product_code'];
                $details[$row_no]['href'] = $href;
                $details[$row_no]['balanced_qty'] = ($product['order_qty'] - $product['utilized_qty']);
                $details[$row_no]['utilized_qty'] = ($product['order_qty'] - $product['utilized_qty']);

                $row_no++;
//d($details,true);
            }
        }

        $purchase_order['products'] = $details;
//d($purchase_order['products'],true);
        $json = array(
            'success' => true,
            'purchase_invoice_id' => $purchase_invoice_id,
            'post' => $post,
            'data' => $purchase_order,
            'PO' => $PO,
        );
//        d($json,true);

        echo json_encode($json);
    }


  /*  public function printDocument() {
        $company_id = $this->session->data['company_id'];
        $company_branch_id = $this->session->data['company_branch_id'];
        $fiscal_year_id = $this->session->data['fiscal_year_id'];

        $purchase_invoice_id = $this->request->get['purchase_invoice_id'];
        $this->data['lang'] = $this->load->language($this->getAlias());

        $this->model['image'] = $this->load->model('tool/image');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');

        $company = $this->model['company']->getRow(array('company_id' => $company_id));
        $this->data['company'] = $company;
        if ($company['company_logo'] && file_exists(DIR_IMAGE . $company['company_logo'])) {
            $company_logo = $this->model['image']->resize($company['company_logo'], 75, 75);
        } else {
            $company_logo = "";
        }
        $this->data['company_logo'] = $company_logo;
        $this->data['company_branch'] = $this->model['company_branch']->getRow(array('company_id' => $company_id, 'company_branch_id' => $company_branch_id));

        $this->model['purchase_invoice'] = $this->load->model('inventory/purchase_invoice');
        $row = $this->model['purchase_invoice']->getRow(array('purchase_invoice_id' => $purchase_invoice_id));

        $this->model['partner'] = $this->load->model('common/partner');
        $partner = $this->model['partner']->getRow(array('company_id' => $company_id, 'company_branch_id' => $company_branch_id, 'partner_type_id' => $row['partner_type_id'], 'partner_id' => $row['partner_id']));
        //d($partner, true);

        $this->data['document_date'] = $row['document_date'];
        $this->data['document_no'] = $row['document_identity'];
        $this->data['partner_name'] = $partner['name'];
        $this->data['phone_no'] = $partner['phone'];
        $this->data['address'] = $partner['address'];

        $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');
        $details = $this->model['purchase_invoice_detail']->getRows(array('purchase_invoice_id' => $purchase_invoice_id));
        foreach($details as $row_no => $detail) {
            $this->data['details'][$row_no] = $detail;
        }
        //d($row,$detail,true);
        $this->template = 'inventory/purchase_invoice_print.tpl';
        $contents = $this->render();

        try
        {
            // init HTML2PDF
            $html2pdf = new HTML2PDF('L', 'A5', 'en', true, 'UTF-8', array(0, 0, 0, 0));

            // display the full page
            $html2pdf->pdf->SetDisplayMode('fullpage');

            // convert
            $html2pdf->writeHTML($contents);

            // send the PDF
            $html2pdf->Output('Purchase Invoice.pdf');
        } catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

  */

    public function printDocument() {

        $post = $this->request->post;
        $lang = $this->load->language($this->getAlias());

        $purchase_invoice_id = $this->request->get['purchase_invoice_id'];
       // d($purchase_invoice_id,true);
        $this->model['company'] = $this->load->model('setup/company');
        //$this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['purchase_invoice'] = $this->load->model('inventory/purchase_invoice');
        $this->model['purchase_invoice_detail'] = $this->load->model('inventory/purchase_invoice_detail');
        $this->model['partner'] = $this->load->model('common/partner');

        $company_id = $this->session->data['company_id'];

        $purchase_invoice =  $this->model['purchase_invoice']->getRow(array('purchase_invoice_id'=>$purchase_invoice_id));
        $purchase_invoice_details = $this->model['purchase_invoice_detail']->getRows(array('purchase_invoice_id'=>$purchase_invoice_id));
        $Partner = $this->model['partner']->getRow(array('partner_type_id' => $purchase_invoice['partner_type_id'],'partner_id' => $purchase_invoice['partner_id']));



        $fiscal_year_id = $this->session->data['fiscal_year_id'];



      $company = $this->model['company']->getRow(array('company_id' => $company_id));
      $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Aamir Shakil');
        $pdf->SetTitle('Purchase Invoice');
        $pdf->SetSubject('Purchase Invoice');

        //Set Header

        $pdf->data = array(
            'company_name' => $company['name'],
            //'company_address' => $company_branch,
             'report_name' => 'Purchase Invoice',

        );



        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 2, 2);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(2);

        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        $pdf->AddPage();

        $pdf->SetTextColor(0,0,0);

        $pdf->Ln(40);
        $pdf->Cell(20,10,'Invoice No : ',0,false,'L',0,'',0,false,'M','M');
        $pdf->Cell(20,10,$purchase_invoice['document_identity'],0,false,'L',0,'',0,false,'M','M');

        $pdf->Cell(120,10,'Invoice Date : ',0,false,'R',0,'',0,false,'M','M');
        $pdf->Cell(20,10,$purchase_invoice['document_date'],0,false,'L',0,'',0,false,'M','M');

        $pdf->Ln(5);
        $pdf->Cell(30,10,'Supplier Name : ',0,false,'L',0,'',0,false,'M','M');
        $pdf->Cell(20,10,$Partner['name'],0,false,'L',0,'',0,false,'M','M');

        $pdf->Ln(5);
        $pdf->Cell(20,10,'Remarks : ',0,false,'L',0,'',0,false,'M','M');
        $pdf->Cell(20,10,$purchase_invoice['remarks'],0,false,'L',0,'',0,false,'M','M');

        $pdf->Ln(12);

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(60, 8, 'Product', 1, false, 'C', 1, '', 1);
        $pdf->Cell(30, 8, 'Warehouse', 1, false, 'C', 1, '', 1);
        $pdf->Cell(30, 8, 'Qty', 1, false, 'C', 1, '', 1);
        $pdf->Cell(20, 8, 'Unit', 1, false, 'C', 1, '', 1);
        $pdf->Cell(20, 8, 'Rate', 1, false, 'C', 1, '', 1);
        $pdf->Cell(30, 8, 'Amount', 1, false, 'C', 1, '', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $total_amount = 0;
        $total_discount = 0;
        $total_tax = 0;
        $total_net_amount = 0;

        foreach($purchase_invoice_details as $details){
            $pdf->Ln(8);
            $pdf->Cell(60, 8, $details['product_name'], 'L', false, 'L', 1, '', 1);
            $pdf->Cell(30, 8, $details['warehouse'], 'L', false, 'C', 1, '', 1);
            $pdf->Cell(30, 8, $details['qty'], 'L', false, 'C', 1, '', 1);
            $pdf->Cell(20, 8, $details['unit'], 'L', false, 'C', 1, '', 1);
            $pdf->Cell(20, 8, $details['rate'], 'L', false, 'C', 1, '', 1);
            $pdf->Cell(30, 8, $details['amount'], 'L,R', false, 'C', 1, '', 1);

            $total_amount += $details['amount'];
            $total_discount += $details['discount_amount'];
            $total_tax += $details['tax_amount'];
            $total_net_amount += $details['gross_amount'];
        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        for ($i = $y; $i <= 200; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(60, 8,'', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(30, 8, '', 'L', false, 'L', 0, '', 1);
            $pdf->Cell(30, 8, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(20, 8, '', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(20, 8, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(30, 8, '', 'L,R', false, 'R', 0, '', 1);
            $y =$i;
        }
        $pdf->Ln(-1);
        $pdf->Ln(5);
        $pdf->Cell(190, 8, '', 'B', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->setXY($x,$y);


        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('helvetica', '', 9);
        $pdf->ln(9);
        // $pdf->Cell(130, 7, '', 0, false, 'L');
        $pdf->Cell(160, 7, $lang['total_amount'].': ', 'L,R,B', false, 'R');
        $pdf->Cell(30, 7, number_format($total_amount,2), 'L,R,B', false, 'C');

        $pdf->ln(7);

        // $pdf->Cell(130, 7, '', 0, false, 'L');
        $pdf->Cell(160, 7, $lang['discount_amount'].': ', 'L,R,B', false, 'R');
        $pdf->Cell(30, 7, number_format($total_discount,2), 'L,R,B', false, 'C');

        $pdf->ln(7);


        // $pdf->Cell(130, 7, '', 0, false, 'L');
        $pdf->Cell(160, 7, $lang['tax_amount'].': ', 'L,R,B', false, 'R');
        $pdf->Cell(30, 7, number_format($total_tax,2), 'L,R,B', false, 'C');

        $pdf->ln(7);


        // $pdf->Cell(130, 7, '', 0, false, 'L');
        $pdf->Cell(160, 7, $lang['net_amount'].': ', 'L,R,B', false, 'R');
        $pdf->Cell(30, 7, number_format($total_net_amount,2), 'L,R,B', false, 'C');

        $pdf->ln(7);
        $pdf->Cell(190, 7, 'Amount In words: ' . Number2Words(round($total_net_amount,2)). ' only', 1, false, 'R');

       // $data= $Quotation;//Close and output PDF document
        $pdf->Output('Purchase Invoice :'.date('YmdHis').'.pdf', 'I');


}
}

class PDF extends TCPDF {
    public $data = array();
    public $term = array();

    //Page header
        //Page header
        public function Header() {
            // Logo

            if($this->data['company_logo'] != '') {
                $image_file = DIR_IMAGE.$this->data['company_logo'];
                //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
                $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }
            // Set font
            $this->SetFont('helvetica', 'B', 20);
            $this->Ln(5);
            // Title
            $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(10);
            $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetFont('helvetica', 'B', 10);
            //$this->Ln(10);
            //$this->Cell(0, 10, 'From Date : '.$this->data['date_from'].'     To Date  :  '.$this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(20);


            //$this->Cell(20,10,'Invoice No : ',0,false,'L',0,'',0,false,'M','M');

            //$this->Cell(140,10,'Invoice Date : ',0,false,'R',0,'',0,false,'M','M');

            //$this->Ln(8);
            //$this->Cell(20,10,'Supplier Name : ',0,false,'L',0,'',0,false,'M','M');


           /* $this->Ln(8);
            $this->Cell(20,10,'Remarks : ',0,false,'L',0,'',0,false,'M','M');

            $this->Ln(12);

            $this->SetFont('times', '', 8);
            $this->SetFillColor(215, 215, 215);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(60, 8, 'Product', 1, false, 'C', 1, '', 1);
            $this->Cell(30, 8, 'Warehouse', 1, false, 'C', 1, '', 1);
            $this->Cell(30, 8, 'Qty', 1, false, 'C', 1, '', 1);
            $this->Cell(20, 8, 'Unit', 1, false, 'C', 1, '', 1);
            $this->Cell(20, 8, 'Rate', 1, false, 'C', 1, '', 1);
            $this->Cell(30, 8, 'Amount', 1, false, 'C', 1, '', 1);


            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
           */

           /* $this->SetFont('times', 'B', 7);
            $this->Cell(20, 5, 'Document Date', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 5, 'Document Identity', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 5, 'Warehouse Name', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(50, 5, 'Partner Name', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(50, 5, 'Product', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 5, 'Unit', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 5, 'Quantity', 'T,B', false, 'R', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 5, 'Rate', 'T,B', false, 'R', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 5, 'Amount', 'T,B', false, 'R', 0, '', 0, false, 'M', 'M');
            */
            // set font


        }



    // Page footer
    public function Footer() {
//        // Position at 15 mm from bottom
        //$this->SetY(-75);
//        // Set font
        //$this->SetFont('times', 'B', 12);

        //$this->Cell(0, 5, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        //$this->SetFont('times', 'B', 10);
//        // Page number

        //$rows = $this->term;
        //$this->Ln(6);

        /*foreach($rows as $r => $row) {
            foreach($row as $term ) {
                $this->Cell(0, 5, '* '.$term['term'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->Ln(5);
            }
        }
        $this->SetFont('times', 'B', 11);
        $this->Ln(5);
        $this->Cell(0, 5, 'In case of any clarification or query , please feel free to contact us.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->Ln(5);
        */

    }





}

?>