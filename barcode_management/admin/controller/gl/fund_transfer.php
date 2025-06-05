<?php

class ControllerGlFundTransfer extends HController {

    protected $document_type_id = 45;

    protected function getAlias() {
        return 'gl/fund_transfer';
    }

    protected function getPrimaryKey() {
        return 'fund_transfer_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {

        $lang = $this->load->language('gl/fund_transfer');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());

        $data = array();
        $aColumns = array('action','document_date', 'document_identity', 'remarks','total_amount','created_at', 'check_box');

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
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' '.(isset($action['target'])?'target="'.$action['target'].'"':'').' href="' . $action['href'] . '" data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
                if (isset($action['class'])) {
                    $strAction .= '<span class="' . $action['class'] . '"></span>';
                } else {
                    $strAction .= $action['text'];
                }
                $strAction .= '</a>&nbsp;';
            }
            $action_update = $this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL');
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'action') {
                    $row[] = $strAction;
                } elseif ($aColumns[$i] == 'document_identity') {
                    $row[] = '<a href="'.$action_update.'">'.$aRow['document_identity'].'</a>';
                }elseif ($aColumns[$i] == 'created_at') {
                    $row[] = stdDateTime($aRow['created_at']);
                } elseif ($aColumns[$i] == 'document_date') {
                    $row[] = stdDate($aRow['document_date']);
                } elseif ($aColumns[$i] == 'check_box') {
                    if($aRow['is_post']==0){
                        $row[] = '<input type="checkbox" name="selected[]" value="' . $aRow[$this->getPrimaryKey()] . '" />';
                    }else{
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

        $this->data['document_identity'] = $this->data['lang']['auto'];
        $this->data['document_date'] = stdDate();
        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencies'] = $this->model['currency']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['coa'] = $this->load->model('gl/coa_level3');

        $this->model['project'] = $this->load->model('setup/project');
        $this->data['projects'] = $this->model['project']->getRows(['company_id'=>$this->session->data['company_id']]);

        $this->model['setting']= $this->load->model('common/setting');
        $accounts = $this->model['setting']->getRows(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'gl',
            'field' => 'transaction_account_id',
        ));
        foreach($accounts as $account) {
            $this->data['transaction_accounts'][] = $this->model['coa']->getRow(array('company_id' => $this->session->data['company_id'], 'coa_level3_id' => $account['value']));
        }

        $this->data['coas'] = $this->data['transaction_accounts'];
        $this->data['partner_types'] = $this->session->data['partner_types'];

        if (isset($this->request->get['fund_transfer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $this->data['document_type_id'] = $this->document_type_id;
            $this->data['document_id'] = $this->request->get['fund_transfer_id'];

            $result = $this->model[$this->getAlias()]->getRow(array('fund_transfer_id' => $this->request->get['fund_transfer_id']));
            // d($result,true);
            foreach ($result as $field => $value) {
                if ($field == 'document_date' || $field == 'instrument_date') {
                    $this->data[$field] = stdDate($value);
                } else {
                    $this->data[$field] = $value;
                }
            }

            $this->model['document'] = $this->load->model('common/document');
            $this->model['fund_transfer_detail'] = $this->load->model('gl/fund_transfer_detail');
            $filter = array(
                'fund_transfer_id' => $this->request->get['fund_transfer_id']
            );
            $details = $this->model['fund_transfer_detail']->getRows($filter,array('sort_order DESC'));
            foreach($details as $detail) {
                $row_id = $detail['sort_order'];
                if(empty($detail['cheque_date']) || $detail['cheque_date']=='0000-00-00') {
                    $detail['cheque_date'] = '';
                } else {
                    $detail['cheque_date'] = stdDate($detail['cheque_date']);
                }
                if($detail['ref_document_type_id'] && $detail['ref_document_identity']) {
                    $ref_document = $this->model['document']->getRow(array('document_type_id' => $detail['ref_document_type_id'], 'document_identity' => $detail['ref_document_identity']));
                    $detail['href'] = $this->url->link($ref_document['route'].'/update', 'token=' . $this->session->data['token'] . '&' . $ref_document['primary_key_field'] . '=' . $ref_document['primary_key_value'], 'SSL');
                }
                $this->data['fund_transfer_details'][$row_id] = $detail;
            }
            $this->model['partner'] = $this->load->model('common/partner');
            $this->data['partners'] = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'partner_type_id' => $result['partner_type_id']));
        }

        // $this->data['partner_type_id'] = 1;

        $this->data['href_get_sub_projects'] = $this->url->link($this->getAlias() . '/getSubProjects', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_get_partner_json'] = $this->url->link($this->getAlias() . '/getPartnerJson', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_get_document_ledger'] = $this->url->link('common/function/getDocumentLedger', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_partner'] = $this->url->link($this->getAlias() . '/getPartner', 'token=' . $this->session->data['token']);
        $this->data['href_get_documents'] = $this->url->link($this->getAlias() . '/getDocuments', 'token=' . $this->session->data['token']);
        $this->data['href_get_document_data'] = $this->url->link($this->getAlias() . '/getDocumentData', 'token=' . $this->session->data['token']);
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'transaction_account_id': {'required': true},
                'total_net_amount': {'required': true},
                'total_amount':{'required': true, 'min':'1'}
            },
            messages: {
            document_date:{
                remote: 'Invalid Date'
            }}
        }";

        $this->response->setOutput($this->render());
    }

    public function getSubProjects() {
        $project_id = $this->request->post['project_id'];
        $sub_project_id = $this->request->post['sub_project_id'];

        $this->model['sub_project'] = $this->load->model('setup/sub_project');
        $sub_projects = $this->model['sub_project']->getRows(array('company_id' => $this->session->data['company_id'], 'project_id' => $project_id));

        $html = '<option value="">&nbsp;</option>';
        foreach($sub_projects as $sub_project) {

            if( $sub_project_id == $sub_project['sub_project_id'] )
            {
                $html .= '<option value="'.$sub_project['sub_project_id'].'" selected="true">'.$sub_project['name'].'</option>';
            }
            else
            {
                $html .= '<option value="'.$sub_project['sub_project_id'].'">'.$sub_project['name'].'</option>';
            }
        }

        $json = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($json);
    }

    public function getPartnerJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model['partner'] = $this->load->model('common/partner');
        $rows = $this->model['partner']->getPartnerJson($search, $page, 25, ['partner_type_id' => 1]);

        echo json_encode($rows);
    }

    public function getPartner() {
        $partner_type_id = $this->request->post['partner_type_id'];
        $partner_id = $this->request->post['partner_id'];
        // $this->model['partner'] = $this->load->model('common/partner');
        // $partners = $this->model['partner']->getPartners(array('company_id'=>$this->session->data['company_id'], 'partner_type_id' => $partner_type_id));

        $this->model['partner'] = $this->load->model('common/partner');
        $partners = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'partner_type_id' => $partner_type_id));

        // $html = '<option value="">&nbsp;</option>';
        // foreach($partners as $partner) {
        //     $html .= '<option data-wht_tax="'.$partner['wht_tax'].'" data-other_tax="'.$partner['other_tax'].'" value="'.$partner['partner_id'].'" '.($partner['partner_id']==$partner_id?'selected="true"':'').'>'.$partner['name'].'</option>';
        // }

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

    public function getDocuments() {
        $partner_type_id = $this->request->post['partner_type_id'];
        $partner_id = $this->request->post['partner_id'];
        $this->model['document'] = $this->load->model('common/document');
        $this->model['partner'] = $this->load->model('common/partner');

        $partner = $this->model['partner']->getRow(array('partner_type_id' => $partner_type_id, 'partner_id' => $partner_id));
        $COAS = array();
        $COAS[$partner['outstanding_account_id']] = array(
            'coa_level3_id' => $partner['outstanding_account_id'],
            'level3_display_name' => $partner['outstanding_account']
        );
//        $COAS[$partner['cash_account_id']] = array(
//            'coa_level3_id' => $partner['cash_account_id'],
//            'level3_display_name' => $partner['cash_account']
//        );
        $COAS[$partner['advance_account_id']] = array(
            'coa_level3_id' => $partner['advance_account_id'],
            'level3_display_name' => $partner['advance_account']
        );

        $where = " `l`.`partner_type_id` = '".$partner_type_id."' AND `l`.`partner_id` = '".$partner_id."'";
        $where .= "  AND l.company_branch_id = '".$this->session->data['company_branch_id']."' AND l.company_id = '".$this->session->data['company_id']."' ";

        if( $partner_type_id == 1 )
        {
            // Supplier
            $where .= " AND l.ref_document_type_id = '1'";
        } else if( $partner_type_id == 2 ) {
            // Customer
            $where .= " AND l.ref_document_type_id = '3'";
        }

        // $where .= " AND is_post=1";
        $documents = $this->model['document']->getPendingDocuments($where,array('document_date'));
        // d($documents,true);
        $arrDocuments = array();
        $html = '<option value="">&nbsp;</option>';
        foreach($documents as $document) {
            // $model_document_actual = $this->load->model($document['route']);
            // $row = $model_document_actual->getRow(array($document['primary_key_field'] => $document['primary_key_value']));
            // $document['document_tax'] = $row['item_tax'];
            $arrDocuments[$document['ref_document_identity']] = $document;
            $arrDocuments[$document['ref_document_identity']]['href'] = $this->url->link($document['route'] . '/update', 'token=' . $this->session->data['token'] . '&' . $document['primary_key_field'] . '=' . $document['primary_key_value'], 'SSL');

            $html .= '<option value="'.$document['ref_document_identity'].'">'.$document['ref_document_identity'].'</option>';
        }

        $json = array(
            'success' => true,
            'html' => $html,
            'documents' => $arrDocuments,
            'partner_coas' => $COAS,
        );

        echo json_encode($json);
    }

    protected function insertData($data) {
        // d($data,true);
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['document'] = $this->load->model('common/document');
        // $this->model['mapping_account'] = $this->load->model('gl/mapping_coa');
        $this->model['fund_transfer_detail'] = $this->load->model('gl/fund_transfer_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $document = $this->model['document_type']->getNextDocument($this->document_type_id);

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['instrument_date'] = MySqlDate($data['instrument_date']);
        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];
        $data['base_total_amount'] = $data['total_amount'] * $data['conversion_rate'];
        $data['base_total_wht_amount'] = $data['total_wht_amount'] * $data['conversion_rate'];
        $data['base_total_other_tax_amount'] = $data['total_other_tax_amount'] * $data['conversion_rate'];
        $data['base_total_net_amount'] = $data['total_net_amount'] * $data['conversion_rate'];
        $fund_transfer_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $fund_transfer_id;

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

        $gl_data[] = array(
            'coa_id' => $data['transaction_account_id'],
            'document_debit' => 0,
            'document_credit' => $data['total_net_amount'],
            'debit' => 0,
            'credit' => $data['total_net_amount'] * $data['conversion_rate'],
            'remarks' => $data['remarks'],
        );

        $this->model['setting'] = $this->load->model('common/setting');
        $config = $this->model['setting']->getArrays('field','value',array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'gl',
        ));
        $other_tax_account_id = $config['other_tax_account_id'];
        $wht_account_id = $config['withholding_tax_account_id'];

        //d($data, true);
        foreach ($data['fund_transfer_details'] as $sort_order => $detail) {
            $detail['fund_transfer_id'] = $fund_transfer_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_amount'] = $detail['amount'] * $data['conversion_rate'];
            $detail['base_wht_amount'] = $detail['wht_amount'] * $data['conversion_rate'];
            $detail['base_other_tax_amount'] = $detail['other_tax_amount'] * $data['conversion_rate'];
            $detail['base_net_amount'] = $detail['net_amount'] * $data['conversion_rate'];
            if($detail['cheque_date'] != '') {
                $detail['cheque_date'] = MySqlDate($detail['cheque_date']);
            } else {
                unset($detail['cheque_date']);
            }
            $fund_transfer_detail_id =  $this->model['fund_transfer_detail']->add($this->getAlias(), $detail);

            $gl_data[] = array(
                'document_detail_id' => $fund_transfer_detail_id,
                'coa_id' => $detail['coa_id'],
                'document_currency_id' => $data['document_currency_id'],
                'document_debit' => $detail['amount'],
                'document_credit' => 0,
                'base_currency_id' => $data['base_currency_id'],
                'conversion_rate' => $data['conversion_rate'],
                'debit' => $detail['amount'] * $data['conversion_rate'],
                'credit' => 0,
                'partner_type_id' => $data['partner_type_id'],
                'partner_id' => $data['partner_id'],
                'ref_document_type_id' => $detail['ref_document_type_id'],
                'ref_document_identity' => $detail['ref_document_identity'],
                'remarks' => $detail['remarks'],
            );

            if($detail['wht_amount'] > 0)
            {
                $gl_data[] = array(
                    'document_detail_id' => $fund_transfer_detail_id,
                    'coa_id' => $wht_account_id,
                    'document_currency_id' => $data['document_currency_id'],
                    'document_debit' => 0,
                    'document_credit' => $detail['wht_amount'],
                    'base_currency_id' => $data['base_currency_id'],
                    'conversion_rate' => $data['conversion_rate'],
                    'debit' => 0,
                    'credit' => $detail['wht_amount'] * $data['conversion_rate'],
                    'partner_type_id' => $data['partner_type_id'],
                    'partner_id' => $data['partner_id'],
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'remarks' => $detail['remarks'],
                );
            }


            if($detail['other_tax_amount'] > 0)
            {
                $gl_data[] = array(
                    'document_detail_id' => $fund_transfer_detail_id,
                    'coa_id' => $other_tax_account_id,
                    'document_currency_id' => $data['document_currency_id'],
                    'document_debit' => 0,
                    'document_credit' => $detail['other_tax_amount'],
                    'base_currency_id' => $data['base_currency_id'],
                    'conversion_rate' => $data['conversion_rate'],
                    'debit' => 0,
                    'credit' => $detail['other_tax_amount'] * $data['conversion_rate'],
                    'partner_type_id' => $data['partner_type_id'],
                    'partner_id' => $data['partner_id'],
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'remarks' => $detail['remarks'],
                );
            }

        }

        // d($gl_data,true);

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['cheque_no'] = $data['instrument_no'];
            $ledger['project_id'] = $data['project_id'];
            $ledger['sub_project_id'] = $data['sub_project_id'];
            $ledger['job_cart_id'] = $data['job_cart_id'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }

        return $fund_transfer_id;
    }

    protected function updateData($primary_key, $data) {
        // d($data,true);
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['document'] = $this->load->model('common/document');
        //$this->model['mapping_account'] = $this->load->model('gl/mapping_coa');
        $this->model['fund_transfer_detail'] = $this->load->model('gl/fund_transfer_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));
        $this->model['fund_transfer_detail']->deleteBulk($this->getAlias(), array('fund_transfer_id' => $primary_key));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['instrument_date'] = MySqlDate($data['instrument_date']);
        $data['base_total_amount'] = $data['total_amount'] * $data['conversion_rate'];
        $data['base_total_wht_amount'] = $data['total_wht_amount'] * $data['conversion_rate'];
        $data['base_total_other_tax_amount'] = $data['total_other_tax_amount'] * $data['conversion_rate'];
        $data['base_total_net_amount'] = $data['total_net_amount'] * $data['conversion_rate'];
        $fund_transfer_id = $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);
        $data['document_id'] = $fund_transfer_id;

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

        $gl_data[] = array(
            'coa_id' => $data['transaction_account_id'],
            'document_debit' => 0,
            'document_credit' => $data['total_net_amount'],
            'debit' => 0,
            'credit' => $data['total_net_amount'] * $data['conversion_rate'],
            'remarks' => $data['remarks'],
        );

        $this->model['setting'] = $this->load->model('common/setting');
        $config = $this->model['setting']->getArrays('field','value',array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'gl',
        ));
        $other_tax_account_id = $config['other_tax_account_id'];
        $wht_account_id = $config['withholding_tax_account_id'];

        //d($data, true);
        foreach ($data['fund_transfer_details'] as $sort_order => $detail) {
            $detail['fund_transfer_id'] = $fund_transfer_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_amount'] = $detail['amount'] * $data['conversion_rate'];
            $detail['base_wht_amount'] = $detail['wht_amount'] * $data['conversion_rate'];
            $detail['base_other_tax_amount'] = $detail['other_tax_amount'] * $data['conversion_rate'];
            $detail['base_net_amount'] = $detail['net_amount'] * $data['conversion_rate'];
            if($detail['cheque_date'] != '') {
                $detail['cheque_date'] = MySqlDate($detail['cheque_date']);
            } else {
                unset($detail['cheque_date']);
            }
            $fund_transfer_detail_id =  $this->model['fund_transfer_detail']->add($this->getAlias(), $detail);

            $gl_data[] = array(
                'document_detail_id' => $fund_transfer_detail_id,
                'coa_id' => $detail['coa_id'],
                'document_currency_id' => $data['document_currency_id'],
                'document_debit' => $detail['amount'],
                'document_credit' => 0,
                'base_currency_id' => $data['base_currency_id'],
                'conversion_rate' => $data['conversion_rate'],
                'debit' => $detail['amount'] * $data['conversion_rate'],
                'credit' => 0,
                'partner_type_id' => $data['partner_type_id'],
                'partner_id' => $data['partner_id'],
                'ref_document_type_id' => $detail['ref_document_type_id'],
                'ref_document_identity' => $detail['ref_document_identity'],
                'remarks' => $detail['remarks'],
            );

            if($detail['wht_amount'] > 0)
            {
                $gl_data[] = array(
                    'document_detail_id' => $fund_transfer_detail_id,
                    'coa_id' => $wht_account_id,
                    'document_currency_id' => $data['document_currency_id'],
                    'document_debit' => 0,
                    'document_credit' => $detail['wht_amount'],
                    'base_currency_id' => $data['base_currency_id'],
                    'conversion_rate' => $data['conversion_rate'],
                    'debit' => 0,
                    'credit' => $detail['wht_amount'] * $data['conversion_rate'],
                    'partner_type_id' => $data['partner_type_id'],
                    'partner_id' => $data['partner_id'],
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'remarks' => $detail['remarks'],
                );
            }


            if($detail['other_tax_amount'] > 0)
            {
                $gl_data[] = array(
                    'document_detail_id' => $fund_transfer_detail_id,
                    'coa_id' => $other_tax_account_id,
                    'document_currency_id' => $data['document_currency_id'],
                    'document_debit' => 0,
                    'document_credit' => $detail['other_tax_amount'],
                    'base_currency_id' => $data['base_currency_id'],
                    'conversion_rate' => $data['conversion_rate'],
                    'debit' => 0,
                    'credit' => $detail['other_tax_amount'] * $data['conversion_rate'],
                    'partner_type_id' => $data['partner_type_id'],
                    'partner_id' => $data['partner_id'],
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'remarks' => $detail['remarks'],
                );
            }
        }

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
            $ledger['cheque_no'] = $data['instrument_no'];
            $ledger['project_id'] = $data['project_id'];
            $ledger['sub_project_id'] = $data['sub_project_id'];
            $ledger['job_cart_id'] = $data['job_cart_id'];


            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }
    }

    protected function deleteData($primary_key) {
        $this->model['document'] = $this->load->model('common/document');
        $this->model['fund_transfer_detail'] = $this->load->model('gl/fund_transfer_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));
        $this->model['fund_transfer_detail']->deleteBulk($this->getAlias(), array('fund_transfer_id' => $primary_key));
        $this->model['document']->delete($this->getAlias(), $primary_key);
        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);

    }

    public function ajaxValidateForm() {
        $post  = $this->request->post;
        $ID = $this->request->get;
//        d($ID,true);
//       d($post,true);
        $lang = $this->load->language($this->getAlias());
        $error = array();

        if($post['voucher_date'] == '') {
            $error[] = $lang['error_voucher_date'];
        }
        if($post['transaction_account_id'] == '') {
            $error[] = $lang['error_transaction_account'];
        }
        if($post['document_currency_id'] == '') {
            $error[] = $lang['error_document_currency'];
        }
        if($post['conversion_rate'] == '' || $post['conversion_rate'] <= 0 ) {
            $error[] = $lang['error_conversion_rate'];
        }

        $conversation = $post['conversion_rate'];
        $details = $post['fund_transfer_details'];
        //d($details,true);
        if($post['people_id'] && $post['people_id'] != "") {
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'people_type_id' => $post['people_type_id'],
                'people_id' => $post['people_id'],
            );

            $this->model['ledger'] = $this->load->model('gl/ledger');

            $Amount =array();
            foreach($details as $stock){
                if(isset($Amount[$stock['ref_document_identity']])) {
                    $Amount[$stock['ref_document_identity']] += $stock['amount'];
                } else
                {
                    $Amount[$stock['ref_document_identity']] = $stock['amount'];
                }
            }
//d($Amount,true);
            foreach($Amount as  $ref_document_id => $amount)
            {

                $filter ['ref_document_id'] = $ref_document_id;
                $filter ['document_id'] = $ID['fund_transfer_id'];

                $outstanding = $this->model['ledger']->getDocumentOutstanding($filter);
//                    d(array($outstanding,$amount),true);
                if($outstanding['outstanding'] < $amount * $conversation)
                {
                    $error[] =  $lang['error_amounts'] ;
                    $error[] =   ' Ref Document No= ' . $ref_document_id .' , Invoice Amount= ' . $outstanding['outstanding'] . ' , Pay Amount= '. $amount * $conversation;
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

                if($detail['coa_id'] == '') {
                    $error[] = $lang['error_coa_id'] . ' for Row ' . $row_no;
                }

                if($detail['amount'] == '') {
                    $error[] = $lang['error_amount'] . ' for Row ' . $row_no;
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
    }

    public function printDocument() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);
        $lang = $this->load->language($this->getAlias());
        $FundTransferId = $this->request->get['fund_transfer_id'];
        $post = $this->request->post;
        $session = $this->session->data;
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['fund_transfer'] = $this->load->model('gl/fund_transfer');
        $this->model['fund_transfer_detail'] = $this->load->model('gl/fund_transfer_detail');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['coa'] = $this->load->model('gl/coa');
        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
        $FundTransfer = $this->model['fund_transfer']->getRow(array('fund_transfer_id' => $FundTransferId));
        $FundTransferDetails = $this->model['fund_transfer_detail']->getRows(array('fund_transfer_id' => $FundTransferId));
        $TransactionAccount = $this->model['coa']->getRow(array('coa_level3_id' => $FundTransfer['transaction_account_id']));
        $Partner = $this->model['partner']->getRow(array('partner_id' => $FundTransfer['partner_id']));
        $pdf = new PDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Fahad Siddiqui');
        $pdf->SetTitle('Fund Transfer');
        $pdf->SetSubject('Fund Transfer');
        $pdf->data = array(
            'company_name' => $session['company_branch_name'],
            'company_address' => $branch['address'],
            'company_phone' => $branch['phone_no'],
            'report_name' => 'Fund Transfer',
            'company_logo' => $session['company_image']
        );
        $pdf->SetMargins(5, 8, 5);
        $pdf->SetHeaderMargin(2);
        $pdf->SetFooterMargin(2);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->AddPage();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 15);
        //$pdf->Cell(0, 8, $pdf->data['company_name'], 0, false, 'C', 1, '', 0, false, 'M', 'M');
        //$pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 4, $branch['name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 4, $pdf->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');



        $pdf->Ln(9);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(25, 7, 'Document No', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30,7, $FundTransfer['document_identity'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(83, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 7, 'Document Date', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30,7, stdDate($FundTransfer['document_date']), 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        $pdf->Ln(11);
        $pdf->Cell(30, 7, 'Transaction Account', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(73, 7, $TransactionAccount['level3_name'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        /*New*/
        $pdf->Cell(25, 7, $lang['instrument_date'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, (!empty($FundTransfer['instrument_date'])?stdDate($FundTransfer['instrument_date']):''), 'B', false, 'L', 0, '', 0, false, 'M', 'M');


        $pdf->Cell(5.5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 7, $lang['instrument_no'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, $FundTransfer['instrument_no'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');


        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(70, 7, 'Account', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(100, 7, 'Remarks', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 7, 'Net Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $sr = 0;
        $pdf->Ln(-2);
        $pdf->Ln(1);
        $NetAmount = 0;
        $pdf->SetFont('helvetica', '', 8);
        foreach($FundTransferDetails as $detail) {
            $Account = $this->model['coa']->getRow(array('coa_level3_id' => $detail['coa_id']));
            $NetAmount += $detail['net_amount'];
            $remarks = $detail['remarks'];
            $sr++;
            $pdf->Ln(7);
            if(strlen($remarks)<=55){
                $pdf->Cell(70, 7, $Account['level3_name'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(100, 7, $remarks, 1, false, 'L', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(30, 7, number_format($detail['net_amount'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
                $pdf->Ln(5);
                $pdf->Ln(-5);
            } else {
                $arrRemarks = splitString($remarks, 55);
                foreach($arrRemarks as $index => $remark){
                    if($index==0){
                        $pdf->Cell(70, 5, $Account['level3_name'], 'TLR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(100, 5, $remark, 'TLR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 5, number_format($detail['net_amount'],2), 'TLR', false, 'R', 0, '', 0, false, 'M', 'M');    
                    } else if($index<=count($arrRemarks)-1) {
                        $pdf->Cell(70, 5, '', 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(100, 5, $remark, 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 5, '', 'LR', false, 'R', 0, '', 0, false, 'M', 'M');
                    } else {
                        $pdf->Cell(70, 5, '', 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(100, 5, $remark, 'LR', false, 'L', 0, '', 0, false, 'M', 'M');
                        $pdf->Cell(30, 5, '', 'LR', false, 'R', 0, '', 0, false, 'M', 'M');
                    }

                    $pdf->Ln(5);
                    
                }
                $pdf->Ln(-6);

            }
        }
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->setXY($x,$y);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Ln(-6);
        $pdf->Ln(13);
        $pdf->Cell(170, 7, 'Total', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 7, number_format($NetAmount,2), 1, false, 'R', 0, '', 0, false, 'M', 'M');

        // // Previous Balance
        // $where[] = "l.document_identity != '{$FundTransfer['document_identity']}'";
        // $where[] = "l.partner_type_id = '{$FundTransfer['partner_type_id']}'";
        // $where[] = "l.partner_id = '{$FundTransfer['partner_id']}'";
        // $where[] = "l.document_date <= '{$FundTransfer['document_date']}'";
        // $where = 'WHERE ' . implode( ' AND ', $where );
        // $this->model['purchase_invoice'] = $this->load->model('inventory/purchase_invoice');
        // $previous_balance = $this->model['purchase_invoice']->getPreviousBalance($where, $FundTransfer['document_date']);

        // $pdf->Ln(7);
        // $pdf->Cell(80, 7, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(90, 7, 'Previous Balance', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        // if( $previous_balance < 0 )
        // {
        //     $pdf->Cell(30, 7, number_format(($previous_balance*-1),2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        // }
        // else
        // {
        //     $pdf->Cell(30, 7, number_format($previous_balance,2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        // }
        // $pdf->Ln(7);
        // $pdf->Cell(80, 7, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(90, 7, 'Current Balance', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(30, 7, number_format((($previous_balance-$NetAmount)),2), 1, false, 'R', 0, '', 0, false, 'M', 'M');


        $pdf->setCellPaddings(1,1,1,1);
        $pdf->Ln(7);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(15, 7, 'Rupees: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(180, 7, Number2Words(round($NetAmount,2)).' only', 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFillColor(255,255,255);
        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x,$y);
        $pdf->ln(5);
        $pdf->Cell(20, 7, 'Remarks : ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(180, 8, html_entity_decode($FundTransfer['remarks']), 1, 'L', 1, $y, '', '', true, 0, false, true, 40, 'T');

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x,$y);

        $pdf->Ln(20);
        $pdf->SetFont('times', 'B', 8);
        //$pdf->Cell(180, 4, '', 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        //$pdf->Ln(10);

        $pdf->Cell(10, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, 'Prepared By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, 'Checked By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, 'Approved By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, 'Received By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');


        //Close and output PDF document
        $pdf->Output('Opening Contribution Slip:'.date('YmdHis').'.pdf', 'I');
    }

}

class PDF extends TCPDF {
    public $data = array();

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
        // $this->SetFont('helvetica', 'B', 20);
        // $this->Ln(2);
        // Title
        // $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln(10);
        // $this->SetFont('helvetica', '', 16);
        // $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

?>