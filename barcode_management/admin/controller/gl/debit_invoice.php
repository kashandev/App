<?php

class ControllerGlDebitInvoice extends HController {

    protected $document_type_id = 11;

    protected function getAlias() {
        return 'gl/debit_invoice';
    }

    protected function getPrimaryKey() {
        return 'debit_invoice_id';
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
        $aColumns = array('action', 'document_date', 'document_identity', 'partner_type', 'partner_name', 'remarks', 'base_amount', 'created_at', 'check_box');

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
                'class' => 'fa fa-print',
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
                $strAction .= '<a '.(isset($action['target'])?'target="'.$action['target'].'"':'').' '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' href="' . $action['href'] . '" data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
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

        $this->model['coa'] = $this->load->model('gl/coa_level3');
        $this->data['coas'] = $this->model['coa']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencies'] = $this->model['currency']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        $this->data['partner_types'] = $this->session->data['partner_types'];
        // d($this->data['partner_types'], true);

        $this->data['document_date'] = stdDate();
        $this->data['document_identity'] = $this->data['lang']['auto'];

        if (isset($this->request->get['debit_invoice_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getRow(array('debit_invoice_id' => $this->request->get['debit_invoice_id']));
            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } else {
                    $this->data[$field] = $value;
                }
            }
            $this->data['document_id'] = $this->request->get[$this->getPrimaryKey()];
            $this->model['debit_invoice_detail'] = $this->load->model('gl/debit_invoice_detail');
            $this->data['debit_invoice_details'] = $this->model['debit_invoice_detail']->getRows(array('debit_invoice_id' => $this->request->get['debit_invoice_id']), array('sort_order ASC'));

        }

        $this->data['href_get_previous_balance'] = $this->url->link($this->getAlias() . '/getPreviousBalance', 'token=' . $this->session->data['token']);

        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');        
        // $this->data['action_print_without_header'] =$this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()].'&header=0', 'SSL');

        $this->data['href_get_document_ledger'] = $this->url->link('common/function/getDocumentLedger', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_partner'] = $this->url->link('common/function/getPartner', 'token=' . $this->session->data['token']);
        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation']= "{
            'rules':{
                'document_date': {'required':true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'partner_type_id': {'required':true},
                'partner_id': {'required':true},
                'total_amount': {'required':true},
                'cost_center_id': {'required':true},

            },
            'ignore': []
          }";

        $this->response->setOutput($this->render());
    }

    function getPreviousBalance(){
        $post = $this->request->post;
        $post['document_date'] = MySqlDate($post['document_date']);        
        if( $post['document_identity'] != ''){

            $where[] = "l.document_identity != '{$post['document_identity']}'";
        }
        
        if( $post['partner_type_id'] != ''){

            $where[] = "l.partner_type_id = '{$post['partner_type_id']}'";
        }
        
        if( $post['partner_id'] != ''){

            $where[] = "l.partner_id = '{$post['partner_id']}'";
        }
        
        if( $post['document_date'] != ''){

            $where[] = "l.document_date <= '{$post['document_date']}'";
        }

        $where = 'WHERE ' . implode( ' AND ', $where );

        $this->model['debit_invoice'] = $this->load->model('gl/debit_invoice');
        $previous_balance = $this->model['debit_invoice']->getPreviousBalance($where, $post['document_date']);

        echo json_encode([
            'success' => true,
            'post' => $post,
            'previous_balance' => number_format($previous_balance, 2),
            'whhere' => $where
        ]);
    }

    protected function insertData($data) {
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['debit_invoice_detail'] = $this->load->model('gl/debit_invoice_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $document_type_id = 0;
        if($data['sale_tax_invoice']=='Yes') {
            $document_type_id = 46;
        } else {
            $document_type_id = $this->document_type_id;
        }
        $document = $this->model['document_type']->getNextDocument($document_type_id);

        $data['document_type_id'] = $document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_amount'] = $data['net_amount'] * $data['conversion_rate'];
        if($data['sale_tax_invoice']=='Yes') {
            $data['manual_ref_no'] = $this->model[$this->getAlias()]->getSaleTaxNo();
        }
        $debit_invoice_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $document_type_id,
            'document_id' => $debit_invoice_id,
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

        $partner = $this->model['partner']->getRow(array('partner_type_id' => $data['partner_type_id'], 'partner_id' => $data['partner_id']));

        $this->model['setting'] = $this->load->model('common/setting');
        $config = $this->model['setting']->getArrays('field','value',array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'gl',
        ));
        $discount_account_id = $config['discount_account_id'];

        foreach ($data['debit_invoice_details'] as $sort_order => $detail) {
            $detail['debit_invoice_id'] = $debit_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['partner_type_id'] = $data['partner_type_id'];
            $detail['partner_id'] = $data['partner_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_amount'] = $detail['amount'] * $data['conversion_rate'];
            $debit_invoice_detail_id = $this->model['debit_invoice_detail']->add($this->getAlias(), $detail);

            $gl_data[] = array(
                'document_detail_id' => $debit_invoice_detail_id,
                'ref_document_type_id' => $document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $detail['coa_id'],
                'remarks' => $detail['remarks'],
                'document_debit' => 0,
                'document_credit' => ($detail['quantity'] * $detail['rate']),
                'debit' => 0,
                'credit' => (($detail['quantity'] * $detail['rate']) * $data['conversion_rate']),
            );
        
            if($detail['discount'] > 0)
                {
                    $gl_data[] = array(
                        'document_detail_id' => $debit_invoice_detail_id,
                        'ref_document_type_id' => $document_type_id,
                        'ref_document_identity' => $data['document_identity'],
                        'coa_id' => $discount_account_id,
                        'remarks' => $detail['remarks'],
                        'document_debit' => $detail['discount'],
                        'document_credit' => 0,
                        'debit' => $detail['discount'],
                        'credit' => 0,
                    );    
                }
            }

            if($data['tax_amount'] > 0)
            {
                $gl_data[] = array(
                    'ref_document_type_id' => $document_type_id,
                    'ref_document_identity' => $data['document_identity'],
                    'coa_id' => $data['tax_account_id'],
                    'remarks' => $data['document_identity'],
                    'document_debit' => 0,
                    'document_credit' => $data['tax_amount'],
                    'debit' => 0,
                    'credit' => ($data['tax_amount'] * $data['conversion_rate']),
                );    
            }

        

            $gl_data[] = array(
                'ref_document_type_id' => $document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $partner['outstanding_account_id'],
                'remarks' => $data['remarks'],
                'document_credit' => 0,
                'document_debit' => $data['net_amount'],
                'credit' => 0,
                'debit' => ($data['net_amount']  * $data['conversion_rate']),
            );

        // d($gl_data, true);        

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $document_type_id;
            $ledger['document_id'] = $debit_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];
            // $ledger['cost_center_id'] = $data['cost_center_id'];
            $ledger['remarks'] = (isset($ledger['remarks'])?$ledger['remarks']:$data['remarks']);

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }
        return $debit_invoice_id;
    }

    protected function updateData($primary_key, $data) {

        // d($data, true);

        $document_type_id = 0;
        if ($data['sale_tax_invoice']!='Yes') {
            $data['sale_tax_invoice'] = 'No';
        }

        if($data['sale_tax_invoice']=='Yes') {
            $document_type_id = 46;
        } else {
            $document_type_id = $this->document_type_id;
        }

        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['debit_invoice_detail'] = $this->load->model('gl/debit_invoice_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $this->model['document']->delete($this->getAlias(), $primary_key);
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $document_type_id, 'document_id' => $primary_key));
        $this->model['debit_invoice_detail']->deleteBulk($this->getAlias(), array('debit_invoice_id' => $primary_key));

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_amount'] = $data['net_amount'] * $data['conversion_rate'];
        $debit_invoice_id = $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $document_type_id,
            'document_id' => $debit_invoice_id,
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

        $partner = $this->model['partner']->getRow(array('partner_type_id' => $data['partner_type_id'], 'partner_id' => $data['partner_id']));
        $this->model['setting'] = $this->load->model('common/setting');
        $config = $this->model['setting']->getArrays('field','value',array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'gl',
        ));
        $discount_account_id = $config['discount_account_id'];

        foreach ($data['debit_invoice_details'] as $sort_order => $detail) {
            $detail['debit_invoice_id'] = $debit_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['partner_type_id'] = $data['partner_type_id'];
            $detail['partner_id'] = $data['partner_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_amount'] = $detail['amount'] * $data['conversion_rate'];
            $debit_invoice_detail_id = $this->model['debit_invoice_detail']->add($this->getAlias(), $detail);

            $gl_data[] = array(
                'document_detail_id' => $debit_invoice_detail_id,
                'ref_document_type_id' => $document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $detail['coa_id'],
                'remarks' => $detail['remarks'],
                'document_debit' => 0,
                'document_credit' => ($detail['quantity'] * $detail['rate']),
                'debit' => 0,
                'credit' => (($detail['quantity'] * $detail['rate']) * $data['conversion_rate']),
            );

            if($detail['discount'] > 0)
            {
                $gl_data[] = array(
                    'document_detail_id' => $debit_invoice_detail_id,
                    'ref_document_type_id' => $document_type_id,
                    'ref_document_identity' => $data['document_identity'],
                    'coa_id' => $discount_account_id,
                    'remarks' => $detail['remarks'],
                    'document_debit' => $detail['discount'],
                    'document_credit' => 0,
                    'debit' => $detail['discount'],
                    'credit' => 0,
                );    
            }
            
        }

        if($data['tax_amount'] > 0)
        {
            $gl_data[] = array(
                'ref_document_type_id' => $document_type_id,
                'ref_document_identity' => $data['document_identity'],
                'coa_id' => $data['tax_account_id'],
                'remarks' => $data['document_identity'],
                'document_debit' => 0,
                'document_credit' => $data['tax_amount'],
                'debit' => 0,
                'credit' => ($data['tax_amount'] * $data['conversion_rate']),
            );    
        }

        $gl_data[] = array(
            'ref_document_type_id' => $document_type_id,
            'ref_document_identity' => $data['document_identity'],
            'coa_id' => $partner['outstanding_account_id'],
            'remarks' => $data['remarks'],
            'document_credit' => 0,
            'document_debit' => $data['net_amount'],
            'credit' => 0,
            'debit' => ($data['net_amount'] * $data['conversion_rate']),
        );

        // d($gl_data, true);

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $document_type_id;
            $ledger['document_id'] = $debit_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['sort_order'] = $sort_order;
            $ledger['base_currency_id'] = $data['base_currency_id'];
            $ledger['document_currency_id'] = $data['document_currency_id'];
            $ledger['conversion_rate'] = $data['conversion_rate'];
            $ledger['partner_type_id'] = $data['partner_type_id'];
            $ledger['partner_id'] = $data['partner_id'];
            // $ledger['cost_center_id'] = $data['cost_center_id'];
            $ledger['remarks'] = (isset($ledger['remarks'])?$ledger['remarks']:$data['remarks']);

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }
        return $debit_invoice_id;
    }

    protected function deleteData($primary_key) {
        // d($primary_key, true);
        $this->model['document'] = $this->load->model('common/document');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['debit_invoice_detail'] = $this->load->model('gl/debit_invoice_detail');
        
        $this->model['debit_invoice_detail']->deleteBulk($this->getAlias(), array('debit_invoice_id' => $primary_key));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'], 'document_id' => $primary_key));
        $this->model['document']->delete($this->getAlias(), $primary_key);

        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);
    }


     public function cancle() {
        $lang = $this->load->language($this->getAlias());
        $data = array(
            'is_post' => 2,
            'post_date' => date('Y-m-d H:i:s'),
            'post_by_id' => $this->session->data['user_id']
        );
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $this->model[$this->getAlias()]->edit($this->getAlias(),$this->request->get[$this->getPrimaryKey()],$data);

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->edit($this->getAlias(),$this->request->get[$this->getPrimaryKey()],$data);

        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $this->request->get[$this->getPrimaryKey()]));

        $this->redirect($this->url->link($this->getAlias(), 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL'));
    }

    public function printDocument() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $get = $this->request->get;
        $session = $this->session->data;
        $debit_invoice_id = $this->request->get['debit_invoice_id'];

        $this->model['setting'] = $this->load->model('common/setting');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['debit_invoice'] = $this->load->model('gl/debit_invoice');
        $this->model['debit_invoice_detail'] = $this->load->model('gl/debit_invoice_detail');

        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $config = $this->model['setting']->getArrays('field','value',array('module' => 'general'));
        $invoice = $this->model['debit_invoice']->getRow(array('debit_invoice_id' => $debit_invoice_id));
        $details = $this->model['debit_invoice_detail']->getRows(array('debit_invoice_id' => $debit_invoice_id), array('sort_order'));
        $partner = $this->model['partner']->getRow(array('partner_id' => $invoice['partner_id']));
        
        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Debit Invoice');
        $pdf->SetSubject('Debit Invoice');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_branch_name'],
            'company_logo' => $session['company_image'],
            'report_name' => 'Debit Service Invoice',
            'document_identity' => $invoice['document_identity'],
            'header' => $get['header']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 43, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // add a page
        $pdf->AddPage();

        // set font
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);

        $pdf->Ln(-7);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(150, 7, 'M/S. ' . $invoice['partner_name'], 1, false, '', 0, '', 1);

        $pdf->Cell(40, 7, 'Invoice Date: ' . stdDate($invoice['document_date']) , 1, false, 'L', 0, '', 1);
        $pdf->Ln(7);
        $pdf->Cell(150, 7, 'Address: ' . $partner['address'], 1, false, '', 0, '', 1);
        $pdf->Cell(40, 7, 'Invoice No. '. $invoice['document_identity'], 1, false, 'L', 0, '', 1);
        
        $pdf->Ln(10);
        $pdf->Cell(7, 7, 'SNo.', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(93, 7, 'Description', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(10, 7, 'Qty', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Rate', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Amount', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Tax Amount', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Net Amount', 1, false, 'C', 1, '', 0, false, 'M', 'M');
        
        $total_amount = 0;
        $total_discount = 0;
        $total_net = 0;
        $sr=1;
        $pdf->SetFont('helvetica', '', 7);
        foreach($details as $detail) {
            $total_amount += $detail['amount'];
            $total_discount += $detail['discount'];
            $net_amount = ($detail['quantity']*$detail['rate'])+$detail['tax_amount'];
            $total_net += $net_amount; 
            $pdf->setCellPaddings(2, 2, 1, 1);
            $pdf->SetFont('helvetica', 'B', 7);

            if(strlen($detail['remarks'])<=80) {
                $pdf->Ln(7);      
                $pdf->Cell(7, 7, ($sr++), 1, false, 'C', 1, '', 0, false, 'M', 'M');
                $pdf->Cell(93, 7, $detail['remarks'], 1, false, 'L', 1, '', 0, false, 'M', 'M');
                $pdf->Cell(10, 7, number_format($detail['quantity'],0), 1, false, 'R', 1, '', 0, false, 'M', 'M');
                $pdf->Cell(20, 7, number_format($detail['rate'],2), 1, false, 'R', 1, '', 0, false, 'M', 'M');
                $pdf->Cell(20, 7, number_format(($detail['quantity']*$detail['rate']),2), 1, false, 'R', 1, '', 0, false, 'M', 'M');
                $pdf->Cell(20, 7, number_format(($detail['tax_amount']),2), 1, false, 'R', 1, '', 0, false, 'M', 'M');
                $pdf->Cell(20, 7, number_format($net_amount,2), 1, false, 'R', 1, '', 0, false, 'M', 'M');

            } else {

                $arrRemarks = splitString($detail['remarks'], 80);
                foreach($arrRemarks as $index => $remarks) {
                    if($index==0) {
                        $pdf->Ln(5);
                        $pdf->Cell(7, 5, ($sr++), 'TLR', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(93, 5, $remarks, 'TLR', false, 'L', 1, 'T', 0, false, 'M', 'M');
                        $pdf->Cell(10, 5, number_format($detail['quantity'], 2), 'TLR', false, 'R', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, number_format($detail['rate'],2), 'TLR', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, number_format(($detail['quantity']*$detail['rate']),2), 'TLR', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, number_format($detail['tax_amount'],2), 'TLR', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, number_format($net_amount,2), 'TLR', false, 'C', 'LRB', '', 0, false, 'M', 'M');

                    } elseif($index==count($arrRemarks)-1) {
                        $pdf->Ln(5);
                        $pdf->Cell(7, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(93, 5, $remarks, 'LRB', false, 'L', 1, '', 0, false, 'M', 'M');
                        $pdf->Cell(10, 5, '', 'LR', false, 'R', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                    } else {
                        $pdf->Ln(5);                        
                        $pdf->Cell(7, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(93, 5, $remarks, 'LRB', false, 'L', 1, '', 0, false, 'M', 'M');
                        $pdf->Cell(10, 5, '', 'LR', false, 'R', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                        $pdf->Cell(20, 5, '', 'LRB', false, 'C', 'LRB', '', 0, false, 'M', 'M');
                    }
                }
            }
        }


        $x = $pdf->GetX();
        $y = $pdf->GetY();


        for ($i = $y; $i <= 220; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(7, 7,'', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(93, 7, '', 'L', false, 'L', 0, '', 1);
            $pdf->Cell(10, 7, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'L,R', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'L,R', false, 'R', 0, '', 1);
            $pdf->Cell(20, 7, '', 'L,R', false, 'R', 0, '', 1);
            $y =$i;
        }
        $pdf->Ln(-1);
        $pdf->Ln(5);
        $pdf->setXY($x,$y);
        $pdf->Ln(8);
        $total_net = $total_net - $total_discount;
        $pdf->Cell(150, 7,'IN WORD: ' . Number2Words(round($total_net,2)). ' only', 1, false, 'L', 0, '', 1);
        $pdf->Cell(20, 7, 'Discount', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_discount,2), 1, false, 'R', 0, '', 1);
        $pdf->Ln(7);
        $pdf->Cell(150, 7,'', 0, false, 'L', 0, '', 1);
        $pdf->Cell(20, 7, 'Total', 1, false, 'R', 0, '', 1);
        $pdf->Cell(20, 7, number_format($total_net,2), 1, false, 'R', 0, '', 1);            
        
        
        $pdf->Ln(25);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(130, 7,'', 0, false, 'L', 0, '', 1);
        $pdf->Cell(60, 7,'FOR ' . strtoupper($this->session->data['company_branch_name']), 'T', false, 'C', 0, '', 1);
        
        //Close and output PDF document
        $pdf->Output('Travel Invoice - '.$invoice['document_identity'].'.pdf', 'I');

    }
}

class PDF extends TCPDF {
    public $data = array();

    //Page header
    public function Header() {
        // Logo

        // $image_file = DIR_IMAGE.'header.png';
        //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);

        // if( $this->data['header'] == 1 ){
        //     $this->Image($image_file, 10, 10, 190, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // }
        $this->Ln(10);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(8);
        // $this->SetFont('helvetica', '', 10);
        // if($this->data['header1'] != '') {
        //     $this->Cell(0, 10, $this->data['header1'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Ln(5);
        // }
        // if($this->data['header2'] != '') {
        //     $this->Cell(0, 10, $this->data['header2'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Ln(5);
        // }
        // if($this->data['header3'] != '') {
        //     $this->Cell(0, 10, $this->data['header3'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Ln(5);
        // }
        // if($this->data['header4'] != '') {
        //     $this->Cell(0, 10, $this->data['header4'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Ln(5);
        // }
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        // Page number
        // $this->Cell(60, 5, $this->data['document_identity'], 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(p, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // $this->Cell(60, 5, date('d-m-Y H:i:s'), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        // $image_file = DIR_IMAGE.'footer.png';
        // if( $this->data['header'] == 1 ){
        //     $this->Image($image_file, 10, 270, 190, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // }
    }
}

?>