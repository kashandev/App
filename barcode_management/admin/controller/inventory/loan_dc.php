<?php

class ControllerInventoryLoanDc extends HController {
    protected $document_type_id = 47;

    protected function getAlias() {
        return 'inventory/loan_dc';
    }

    protected function getPrimaryKey() {
        return 'loan_dc_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {
        $lang = $this->load->language('inventory/loan_dc');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $data = array();
        $aColumns = array('action', 'document_date', 'document_identity', 'partner_name', 'total_qty', 'created_at', 'check_box');

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
                    'class' => 'fa fa-thumbs-up'
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
                } elseif ($aColumns[$i] == 'check_box') {
                    $row[] = '<input type="checkbox" name="selected[]" value="' . $aRow[$this->getPrimaryKey()] . '" />';
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


        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencys'] = $this->model['currency']->getRows();

        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->data['units'] = $this->model['unit']->getRows(array('company_id' => $this->session->data['company_id']));
        $arrUnits = $this->model['unit']->getArrays('unit_id','name',array('company_id' => $this->session->data['company_id']));

        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));

        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        $this->data['partner_type_id'] = 2;

        $this->model['partner'] = $this->load->model('common/partner');
        $this->data['partners'] = $this->model['partner']->getRows(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'partner_type_id' => 2,
        ));

        $this->data['document_date'] = stdDate();
        if (isset($this->request->get['loan_dc_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));
            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } else {
                    $this->data[$field] = $value;
                }
            }

            $this->model['loan_dc_detail'] = $this->load->model('inventory/loan_dc_detail');
            $this->data['loan_dc_details'] = $this->model['loan_dc_detail']->getRows(array('loan_dc_id' => $this->request->get['loan_dc_id']));
        }


        $this->data['href_get_product_stock'] = $this->url->link($this->getAlias() . '/getProductStock', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'partner_id': {'required': true},
                'total_qty': {'required': true, 'min':1},
            },
            'ignore': [],
        }";

        $this->response->setOutput($this->render());
    }

    public function getProductStock() {
        $post = $this->request->post;
        $this->model['stock'] = $this->load->model('common/stock_ledger');
        $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'warehouse_id' => $post['warehouse_id'],
            'product_id' => $post['product_id'],
        );
        $stock = $this->model['stock']->getStock($filter);

        $json = array(
            'success' => true,
            'post' => $post,
            'filter' => $filter,
            'stock' => $stock
        );

        echo json_encode($json);
    }

    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model['product'] = $this->load->model('inventory/product');
        $rows = $this->model['product']->getProductJson($search, $page);

        echo json_encode($rows);
    }

    protected function insertData($data) {

        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['partner'] = $this->load->model('common/partner');
        $document = $this->model['document_type']->getNextDocument($this->document_type_id);

        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_amount'] = $data['total_amount'] * $data['conversion_rate'];

        // d($data, true);
        
        $loan_dc_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $loan_dc_id;

        $this->model['loan_dc_detail'] = $this->load->model('inventory/loan_dc_detail');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');
        
        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $data['document_id'],
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['total_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['base_amount'],
        );
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        $partner = $this->model['partner']->getRow(array('partner_id' => $data['partner_id']));
        
        $gl_data = array();
        $stock_ledger = array();
        foreach ($data['loan_dc_details'] as $sort_order => $detail) {
            $stock = $this->model['stock_ledger']->getWarehouseStock($detail['product_master_id'], $detail['warehouse_id'], $data['document_identity'], $data['document_date']);

            $detail['cog_rate'] = $stock['avg_stock_rate'];
            $detail['cog_amount'] = ($stock['avg_stock_rate']*$detail['qty']);

            $detail['loan_dc_id'] = $loan_dc_id;
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['sort_order'] = $sort_order;
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_cog_rate'] = ($detail['cog_rate'] * $data['conversion_rate']);
            $detail['base_cog_amount'] = ($detail['cog_amount'] * $data['conversion_rate']);
            $loan_dc_detail_id=$this->model['loan_dc_detail']->add($this->getAlias(), $detail);

            $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));
            $gl_data[] = array(
                'document_detail_id' => $loan_dc_detail_id,
                'coa_id' => $product['inventory_account_id'],
                'document_credit' => $detail['cog_amount'],
                'document_debit' => 0,
                'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                'debit' => 0,
                'remarks' => $data['remarks'],
                'product_id' => $detail['product_id'],
                'qty' => $detail['qty'],
                'document_amount' => $detail['cog_amount'],
                'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
            );

            $gl_data[] = array(
                'document_detail_id' => $loan_dc_detail_id,
                'coa_id' => $partner['outstanding_account_id'],
                'document_debit' => $detail['cog_amount'],
                'document_credit' => 0,
                'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                'credit' => 0,
                'remarks' => $data['remarks'],
            );

            $stock_ledger[] = array(
                'document_detail_id' => $loan_dc_detail_id,
                'warehouse_id' => $data['warehouse_id'],
                'product_id' => $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => (-1 * $detail['qty']),
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => (-1 * $detail['qty']),
                'document_rate' => $detail['cog_rate'],
                'document_amount' => (-1 * $detail['cog_amount']),
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * $detail['cog_amount'] * $detail['conversion_rate']),
                'remarks' => $data['remarks'],
            );

            $stock_ledger_history = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $detail['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $this->document_type_id,
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $loan_dc_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'product_id' => $detail['product_id'],
                'product_master_id' =>  $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => -1,
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => -1,
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

        }

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }

        //d($stock_ledger, true);
        foreach($stock_ledger as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['currency_conversion'] = $data['conversion_rate'];

            $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $ledger);
            //d(array($stock_ledger_id, $ledger), true);
        }

        return $loan_dc_id;
    }

    protected function insertRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&loan_dc_id=' . $id, 'SSL'));
    }

    protected function updateData($primary_key, $data) {
        //d($data, true);
        $loan_dc_id = $primary_key;
        $data['document_date'] = MySqlDate($data['document_date']);

        $this->model['loan_dc'] = $this->load->model('inventory/loan_dc');
        $this->model['loan_dc_detail'] = $this->load->model('inventory/loan_dc_detail');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');

        $this->model['loan_dc']->edit($this->getAlias(), $primary_key, $data);
        $this->model['loan_dc_detail']->deleteBulk($this->getAlias(), array('loan_dc_id' => $loan_dc_id));
        $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $loan_dc_id));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $loan_dc_id));
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('document_id' => $loan_dc_id));
        $this->model['stock_ledger_history']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id,'document_id' => $loan_dc_id));

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $data['document_id'],
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['total_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['base_amount'],
        );
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);
        //d(array($document_id, $document), true);
        $partner = $this->model['partner']->getRow(array('partner_id' => $data['partner_id']));

        $gl_data = array();
        $stock_ledger = array();
        $sort_order = 0;
        foreach ($data['loan_dc_details'] as $sort_order => $detail) {
            $stock = $this->model['stock_ledger']->getWarehouseStock($detail['product_master_id'], $detail['warehouse_id'], $data['document_identity'], $data['document_date']);

            $detail['cog_rate'] = $stock['avg_stock_rate'];
            $detail['cog_amount'] = ($stock['avg_stock_rate']*$detail['qty']);

            $detail['loan_dc_id'] = $loan_dc_id;
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['sort_order'] = $sort_order;
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_cog_rate'] = ($detail['cog_rate'] * $data['conversion_rate']);
            $detail['base_cog_amount'] = ($detail['cog_amount'] * $data['conversion_rate']);
            $loan_dc_detail_id=$this->model['loan_dc_detail']->add($this->getAlias(), $detail);

            $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));
            $gl_data[] = array(
                'document_detail_id' => $loan_dc_detail_id,
                'coa_id' => $product['inventory_account_id'],
                'document_credit' => $detail['cog_amount'],
                'document_debit' => 0,
                'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                'debit' => 0,
                'remarks' => $data['remarks'],
                'product_id' => $detail['product_id'],
                'qty' => $detail['qty'],
                'document_amount' => $detail['cog_amount'],
                'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
            );

            $gl_data[] = array(
                'document_detail_id' => $loan_dc_detail_id,
                'coa_id' => $partner['outstanding_account_id'],
                'document_debit' => $detail['cog_amount'],
                'document_credit' => 0,
                'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                'credit' => 0,
                'remarks' => $data['remarks'],
            );

            $stock_ledger[] = array(
                'document_detail_id' => $loan_dc_detail_id,
                'warehouse_id' => $data['warehouse_id'],
                'product_id' => $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => (-1 * $detail['qty']),
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => (-1 * $detail['qty']),
                'document_rate' => $detail['cog_rate'],
                'document_amount' => (-1 * $detail['cog_amount']),
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * $detail['cog_amount'] * $detail['conversion_rate']),
                'remarks' => $data['remarks'],
            );

            $stock_ledger_history = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $detail['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $this->document_type_id,
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $loan_dc_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'product_id' => $detail['product_id'],
                'product_master_id' =>  $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => -1,
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => -1,
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

        }

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }

        //d($stock_ledger, true);
        foreach($stock_ledger as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['currency_conversion'] = $data['conversion_rate'];

            $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $ledger);
            //d(array($stock_ledger_id, $ledger), true);
        }

        return $loan_dc_id;
    }

    protected function updateRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&loan_dc_id=' . $id, 'SSL'));
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('delete', $this->getAlias())) {
            $this->error['warning'] = $this->language->get('error_permission_delete');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    protected function deleteData($primary_key) {
        $this->model['loan_dc_detail'] = $this->load->model('inventory/loan_dc_detail');
        $this->model['loan_dc_detail']->deleteBulk($this->getAlias(),array('loan_dc_id' => $primary_key));

        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');
        $this->model['stock_ledger_history']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);
    }

    public function ajaxValidateForm() {
        $post  = $this->request->post;
        $lang = $this->load->language('inventory/loan_dc');
        $error = array();

        if($post['voucher_date'] == '') {
            $error[] = $lang['error_voucher_date'];
        }

        if($post['supplier_id'] == '') {
            $error[] = $lang['error_supplier'];
        }

        $details = $post['loan_dc_details'];
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
                'errors' => $error,
                'post' => $post
            );
        }

        echo json_encode($json);
        exit;
    }

    public function printDocument() {

        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $loan_dc_id = $this->request->get['loan_dc_id'];
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['company'] = $this->load->model('setup/company');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['loan_dc'] = $this->load->model('inventory/loan_dc');
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->model['loan_dc_detail'] = $this->load->model('inventory/loan_dc_detail');

        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
        $loan_dc = $this->model['loan_dc']->getRow(array('loan_dc_id' => $loan_dc_id));
        $loan_dc_details = $this->model['loan_dc_detail']->getRows(array('loan_dc_id' => $loan_dc_id),array('sort_order asc'));

        $Partner = $this->model['partner']->getRow(array('partner_type_id' => $loan_dc['partner_type_id'],'partner_id' => $loan_dc['partner_id']));

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Loan DC');
        $pdf->SetSubject('Loan DC');

        //Set Header
        $pdf->data = array(
            'company_name' =>  $session['company_branch_name'],
            'company_address' => $company['address'],
            'company_phone' => $company['phone_no'],
            'report_name' => 'Loan DC',
            'company_logo' => $session['company_image'],
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(7, 45, 7);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 20);

        // set font

        // add a page
        $pdf->AddPage();

        $pdf->SetTextColor(0,0,0);


        $pdf->SetFont('times', 'B', 9);
        $pdf->Cell(20, 7, 'Doc No.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(35, 7, $loan_dc['document_identity'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        $pdf->Cell(75, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
        $pdf->Cell(20, 7, 'Doc Date', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 7, stdDate($loan_dc['document_date']), 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        
        $pdf->Ln(7);
        $pdf->Cell(20, 7, 'Customer', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $customer = implode(' - ', array(
            $Partner['name'],
            $Partner['address'],
        ));
        $pdf->Cell(175, 7, $customer, 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        
        $pdf->Ln(7);
        $pdf->Cell(20, 7, 'Remarks', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(175, 7, $loan_dc['remarks'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        $pdf->Ln(10);

        $pdf->SetFont('times', 'B', 8);
        $pdf->Cell(10,  7, 'SNo.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(155, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30,  7, 'Qty/Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(-.5);
        $pdf->Ln(1);


        $sr = 1;
        $total_qty = 0;
        $pdf->SetFont('times', '', 8);
        
        $details = [];
        foreach ($loan_dc_details as $detail) {            
            if(isset($details[$detail['product_master_id']])) {} else {
                $details[$detail['product_master_id']] = $detail;
            }
        }

        foreach($details as $detail) {

            $productVendors = $this->model['loan_dc_detail']->getProductVendorSerials($loan_dc_id, $detail['product_master_id']);

            $productDesc = [];
            $productDesc[] = $detail['description'];

            $desc = [];

            $desc[] = implode(' - ', $productDesc);
            $desc[] = 'Serial No: ' . implode(', ', explode(',', $productVendors['vendor_serial_no']));

            $total_qty += $productVendors['qty'];

            if(strlen($desc[1])<=125){

                $pdf->Ln(6);
                $pdf->Cell(10, 6, $sr, 'TLR',  false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(155, 6, html_entity_decode($desc[0]), 'TLR', false, 'L', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(30, 6, $productVendors['qty'].' '.$detail['unit'], 'TLR', false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Ln(6);
                $pdf->Cell(10, 6, '', 'BLR',  false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(155, 6, html_entity_decode($desc[1]), 'BLR', false, 'L', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(30, 6, '', 'BLR', false, 'L', 0, '', 0, false, 'M', 'M');
            }
            else
            {
                $arrRemarks = splitString($desc[1], 125);
                foreach ($arrRemarks as $index => $remark) {
                    if($index==0){
                        $pdf->Ln(6);
                        $pdf->Cell(10, 6, $sr, 'TLR',  false, 'C', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(155, 6, html_entity_decode($desc[0]), 'TLR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 6, $productVendors['qty'].' '.$detail['unit'], 'TLR', false, 'C', 0, '', 0, false, 'M', 'M');
                        $pdf->Ln(6);
                        $pdf->Cell(10, 6, '', 'LR',  false, 'C', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(155, 6, html_entity_decode($remark), 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 6, '', 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                    }
                    else if($index<=count($arrRemarks)-1){
                        $pdf->Ln(6);
                        $pdf->Cell(10, 6, '', 'LR',  false, 'C', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(155, 6, html_entity_decode($remark), 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 6, '', 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                    }
                    else
                    {
                        $pdf->Ln(6);
                        $pdf->Cell(10, 6, '', 'LR',  false, 'C', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(155, 6, html_entity_decode($remark), 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 6, '', 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                    }
                }
            }

            $sr++;

            $Y = $pdf->getY();
            if(($Y%263)==0){
                $pdf->Ln(6);
                $pdf->Cell(195, 1, '', 'T', false, 'L', 0, '', 0, false, 'M', 'M');
                $pdf->AddPage();
                $pdf->SetFont('times', 'B', 8);
                $pdf->Cell(10,  7, 'SNo.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(155, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(30,  7, 'Qty/Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            }

        }

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x, $y);
        $pdf->Ln(7);
        $pdf->SetFont('times', 'B', 8);
        $pdf->Cell(165, 7, 'Total', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 7, $total_qty, 1, false, 'C', 0, '', 0, false, 'M', 'M');

        $pdf->Output('Loan DC-'.$loan_dc['document_identity'].'.pdf', 'I');

    }

}

class PDF extends TCPDF {
    public $data = array();
    public $term = array();
    public $txt;

    //Page header
    public function Header() {

        // Set font
        if($this->data['header']!=2){

            $this->SetTextColor(0,0,0);
            $this->SetFont('times', 'B,I', 20);
            $this->Ln(8);
            
            // Title
            $this->Cell(0, 4, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(9);
            
            if($this->data['company_address']) {
                $this->Cell(0, 4, $this->data['company_address'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(12);
            }
            
            $this->SetFont('times', '', 10);
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0,0,0);
        
        } else {
            $this->Ln(20);
        }

        $this->Ln(8);
        $this->SetFont('times', 'B,I', 15);
        $this->Cell(0, 4, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        $this->SetY(-10);
    }
}

?>