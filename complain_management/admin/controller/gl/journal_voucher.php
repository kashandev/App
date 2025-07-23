<?php

class ControllerGlJournalVoucher extends HController {

    protected $document_type_id = 10;

    protected function getAlias() {
        return 'gl/journal_voucher';
    }

    protected function getPrimaryKey() {
        return 'journal_voucher_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {

        $lang = $this->load->language('gl/bank_payment');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());

        $data = array();
        $aColumns = array('action','document_date', 'document_identity' ,'remarks','created_at', 'check_box');

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
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' '.(isset($action['target'])?'target="'.$action['target'].'"':'').' href="' . $action['href'] . '" data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
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
        $this->data['document_identity'] = $this->data['lang']['auto'];
        $this->data['document_date'] = stdDate();
        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencies'] = $this->model['currency']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['coa'] = $this->load->model('gl/coa_level3');
        $this->data['coas'] = $this->model['coa']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['project'] = $this->load->model('setup/project');
        $this->data['projects'] = $this->model['project']->getRows(['company_id'=>$this->session->data['company_id']]);

        $this->data['job_carts'] = [];

        $this->data['partner_types'] = $this->session->data['partner_types'];
        $this->model['partner'] = $this->load->model('common/partner');
        $partners = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id']));
        //d($partners, true);

        foreach($partners as $partner) {
            $this->data['partners'][$partner['partner_type_id']][$partner['partner_id']] = $partner;
        }

        if (isset($this->request->get['journal_voucher_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $this->data['document_type_id'] = $this->document_type_id;
            $this->data['document_id'] = $this->request->get['journal_voucher_id'];

            $result = $this->model[$this->getAlias()]->getRow(array('journal_voucher_id' => $this->request->get['journal_voucher_id']));
            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } else {
                    $this->data[$field] = $value;
                }
            }

            $this->model['document'] = $this->load->model('common/document');
            $this->model['journal_voucher_detail'] = $this->load->model('gl/journal_voucher_detail');
            $filter = array(
                'journal_voucher_id' => $this->request->get['journal_voucher_id']
            );
            $details = $this->model['journal_voucher_detail']->getRows($filter,array('sort_order DESC'));
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
                $this->data['journal_voucher_details'][$row_id] = $detail;
            }
        }

        $this->data['href_get_sub_projects'] = $this->url->link($this->getAlias() . '/getSubProjects', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_get_partner_account'] = $this->url->link($this->getAlias() .'/getPartnerAccount', 'token=' . $this->session->data['token']);

        $this->data['href_get_document_ledger'] = $this->url->link('common/function/getDocumentLedger', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_pending_document'] = $this->url->link($this->getAlias() .'/getPendingDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/home/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation']= "{
            'rules':{
                'document_date': {'required':true},
                'conversion_rate': {'required':true},
                'document_debit' : {'required': true, 'min': 1},
                'document_credit' : {'required': true, 'min': 1, equalTo: '#document_debit'},
            },
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

    public function getPartnerAccount()
    {
        $post = $this->request->post;
        // d($post);
        $partner_id = $post['partner_id'];
        $this->model['partner'] = $this->load->model('common/partner');
        $partner = $this->model['partner']->getRow(array('partner_id' => $partner_id));
        $partner_account = $partner['outstanding_account_id'];
        $json = array(
            'success' => true,
            'account' => $partner_account,
        );
        echo json_encode($json);
        exit;
        // d($partner,true);
    }

    public function getPendingDocument() {

        $post = $this->request->post;
        $session = $this->session->data;

        $filterStr = '`l`.`company_id`='.$session['company_id']. ' AND `l`.`company_branch_id`='.$session['company_branch_id'].' AND `l`.`partner_type_id`='.$post['partner_type_id'].' AND `l`.`partner_id`="'. $post['partner_id'].'" AND `l`.`fiscal_year_id`='.$session['fiscal_year_id'];
        $this->model['document'] = $this->load->model('common/document');
        $this->model['partner'] = $this->load->model('common/partner');
        $filter = array(
            'company_id' => $session['company_id'],
            'company_branch_id' => $session['company_branch_id'],
            'partner_type_id' => $post['partner_type_id'],
            'partner_id' => $post['partner_id'],
        );
        

        $partner = $this->model['partner']->getRow($filter);
        $documents = $this->model['document']->getPendingDocuments($filterStr);
        $html = '<option data-balance_amount="0" data-adjust_on="DR" data-document_type_id="" data-coa_id="'.$partner['outstanding_account_id'].'" value="">&nbsp;</option>';

        //d($documents,true);
        foreach($documents as $document) {
            $html .= '<option data-balance_amount="'.$document['balance_amount'].'" data-adjust_on="'.$document['adjust_on'].'" data-document_type_id="'.$document['ref_document_type_id'].'" data-coa_id="'.$document['coa_id'].'" value="'.$document['ref_document_identity'].'">'.$document['ref_document_identity'].'</option>';
        }

        $json = array(
            'success' => true,
            'html' => $html,
            'documents' => $documents,
            'outstanding_account_id' => $partner['outstanding_account_id'],
        );
        echo json_encode($json);
    }

    protected function insertData($data) {
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['document'] = $this->load->model('common/document');
        //$this->model['mapping_account'] = $this->load->model('gl/mapping_coa');
        $this->model['journal_voucher_detail'] = $this->load->model('gl/journal_voucher_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $document = $this->model['document_type']->getNextDocument($this->document_type_id);

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_debit'] = $data['document_debit'] * $data['conversion_rate'];
        $data['base_credit'] = $data['document_credit'] * $data['conversion_rate'];
        $journal_voucher_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $journal_voucher_id;

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $data['document_id'],
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['document_debit'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['base_debit'],
        );
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        foreach ($data['journal_voucher_details'] as $sort_order => $detail) {
            $detail['journal_voucher_id'] = $journal_voucher_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_debit'] = $detail['document_debit'] * $data['conversion_rate'];
            $detail['base_credit'] = $detail['document_credit'] * $data['conversion_rate'];
            if($detail['cheque_date'] != '') {
                $detail['cheque_date'] = MySqlDate($detail['cheque_date']);
            } else {
                unset($detail['cheque_date']);
            }
            $journal_voucher_detail_id =  $this->model['journal_voucher_detail']->add($this->getAlias(), $detail);

            $gl_data[] = array(
                'document_detail_id' => $journal_voucher_detail_id,
                'coa_id' => $detail['coa_id'],
                'document_currency_id' => $data['document_currency_id'],
                'document_credit' => $detail['document_credit'],
                'document_debit' => $detail['document_debit'],
                'base_currency_id' => $data['base_currency_id'],
                'conversion_rate' => $data['conversion_rate'],
                'credit' => $detail['document_credit'] * $data['conversion_rate'],
                'debit' => $detail['document_debit'] * $data['conversion_rate'],
                'partner_type_id' => $detail['partner_type_id'],
                'partner_id' => $detail['partner_id'],
                'ref_document_type_id' => $detail['ref_document_type_id'],
                'ref_document_identity' => $detail['ref_document_identity'],
                'remarks' => $detail['remarks'],
                'project_id' => $detail['project_id'],
                'sub_project_id' => $detail['sub_project_id'],
                'job_cart_id' => $detail['job_cart_id'],
            );
            //d(array($detail, $gl_data), true);
        }

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }

        return $journal_voucher_id;
    }

    protected function updateData($primary_key, $data) {
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['document'] = $this->load->model('common/document');
        //  $this->model['mapping_account'] = $this->load->model('gl/mapping_coa');
        $this->model['journal_voucher_detail'] = $this->load->model('gl/journal_voucher_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));
        $this->model['journal_voucher_detail']->deleteBulk($this->getAlias(), array('journal_voucher_id' => $primary_key));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_debit'] = $data['document_debit'] * $data['conversion_rate'];
        $data['base_credit'] = $data['document_credit'] * $data['conversion_rate'];
        $journal_voucher_id = $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);
        $data['document_id'] = $journal_voucher_id;

        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $data['document_id'],
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['document_debit'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => $data['base_debit'],
        );
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        foreach ($data['journal_voucher_details'] as $sort_order => $detail) {
            $detail['journal_voucher_id'] = $journal_voucher_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_debit'] = $detail['document_debit'] * $data['conversion_rate'];
            $detail['base_credit'] = $detail['document_credit'] * $data['conversion_rate'];
            if($detail['cheque_date'] != '') {
                $detail['cheque_date'] = MySqlDate($detail['cheque_date']);
            } else {
                unset($detail['cheque_date']);
            }
            $journal_voucher_detail_id =  $this->model['journal_voucher_detail']->add($this->getAlias(), $detail);

            $gl_data[] = array(
                'document_detail_id' => $journal_voucher_detail_id,
                'coa_id' => $detail['coa_id'],
                'document_currency_id' => $data['document_currency_id'],
                'document_credit' => $detail['document_credit'],
                'document_debit' => $detail['document_debit'],
                'base_currency_id' => $data['base_currency_id'],
                'conversion_rate' => $data['conversion_rate'],
                'credit' => $detail['document_credit'] * $data['conversion_rate'],
                'debit' => $detail['document_debit'] * $data['conversion_rate'],
                'partner_type_id' => $detail['partner_type_id'],
                'partner_id' => $detail['partner_id'],
                'ref_document_type_id' => $detail['ref_document_type_id'],
                'ref_document_identity' => $detail['ref_document_identity'],
                'remarks' => $detail['remarks'],
                'project_id' => $detail['project_id'],
                'sub_project_id' => $detail['sub_project_id'],
                'job_cart_id' => $detail['job_cart_id'],
            );
            //d(array($detail, $gl_data), true);
        }

        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $data['document_id'];
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];

            $ledger_id = $this->model['ledger']->add($this->getAlias(), $ledger);
        }
        return $journal_voucher_id;
    }

    protected function deleteData($primary_key) {
        $this->model['document'] = $this->load->model('common/document');
        $this->model['journal_voucher_detail'] = $this->load->model('gl/journal_voucher_detail');
        $this->model['ledger'] = $this->load->model('gl/ledger');

        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));
        $this->model['journal_voucher_detail']->deleteBulk($this->getAlias(), array('journal_voucher_id' => $primary_key));
        $this->model['document']->delete($this->getAlias(), $primary_key);
        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);
    }

    public function printDocument() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $journal_voucher_id = $this->request->get['journal_voucher_id'];

        $this->model['journal_voucher'] = $this->load->model('gl/journal_voucher');
        $this->model['journal_voucher_detail'] = $this->load->model('gl/journal_voucher_detail');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');

        $voucher = $this->model['journal_voucher']->getRow(array('journal_voucher_id' => $journal_voucher_id));
        $details = $this->model['journal_voucher_detail']->getRows(array('journal_voucher_id' => $journal_voucher_id),array('sort_order ASC'));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));

        $pdf = new PDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Aamir Shakil');
        $pdf->SetTitle('Journal Voucher');
        $pdf->SetSubject('Journal Voucher');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'company_logo' => $session['company_image']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 8, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // add a page
        $pdf->AddPage();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 8, $pdf->data['company_name'], 0, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 4, $branch['name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 4, $pdf->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(8);

        $pdf->SetFont('helvetica', '', 8);
        
        $pdf->Cell(25, 7, 'Document Date', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30,7, stdDate($voucher['document_date']), 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        $pdf->Cell(165, 7, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 7, 'Document No', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30,7, $voucher['document_identity'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        
        $pdf->ln(10);
        

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(60, 8, $lang['partner_name'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(70, 8, html_entity_decode($lang['coa']), 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 8, $lang['project'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 8, $lang['sub_project'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        
        //$pdf->Cell(30, 8, $lang['job_cart_no'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        
        $pdf->Cell(25, 8, $lang['cheque_no'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 8, $lang['debit'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 8, $lang['credit'], 1, false, 'C', 1, '', 0, false, 'M', 'M');
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $total_amount = 0;
        $pdf->ln(4);
        foreach($details as $detail) {
            $pdf->Cell(60, 8, $detail['partner_name'], 1, false, 'L', 0, '', 1);
            $pdf->Cell(70, 8, html_entity_decode($detail['account']), 1, false, 'L', 0, '', 1);
            $pdf->Cell(40, 8, $detail['project_name'], 1, false, 'C', 0, '', 1);
            $pdf->Cell(40, 8, $detail['sub_project_name'], 1, false, 'C', 0, '', 1);
            
            //$pdf->Cell(30, 8, $detail['job_cart_name'], 1, false, 'C', 0, '', 1);
            
            $pdf->Cell(25, 8, $detail['cheque_no'], 1, false, 'C', 0, '', 1);
            $pdf->Cell(20, 8, number_format($detail['document_debit'],2), 1, false, 'R', 0, '', 1);
            $pdf->Cell(20, 8, number_format($detail['document_credit'],2), 1, false, 'R', 0, '', 1);
            $pdf->ln(8);
        }

        $pdf->SetFont('helvetica', 'B', 8);
        if($voucher['document_currency_id'] == $voucher['base_currency_id'] || $voucher['conversion_rate'] == 1) {
            $pdf->ln(3.5);
            $pdf->Cell(235, 7, 'Total', 1, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($voucher['document_debit'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($voucher['document_credit'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');

            $pdf->ln(10);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->Cell(20, 7,'Rupees', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(255, 7,Number2Words(round($voucher['document_debit'],2)).' only', 'B', false, 'L', 0, '', 0, false, 'M', 'M');



        } else {
            $pdf->ln(8);
            $pdf->Cell(145, 8, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 8, number_format($voucher['document_debit'],2), 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 8, number_format($voucher['document_credit'],2), 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->ln(8);
            $pdf->Cell(145, 8, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 8, $lang['conversion_rate'].': ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 8, number_format($voucher['conversion_rate'],2), 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->ln(8);

            $pdf->Cell(145, 7, Number2Words(round($voucher['base_debit'],2)).' only', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 8, number_format($voucher['base_debit'],2), 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 8, number_format($voucher['base_credit'],2), 0, false, 'R', 0, '', 0, false, 'M', 'M');
        }
        $pdf->ln(7);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(20, 7, 'Remarks', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->MultiCell(255, 15, html_entity_decode($voucher['remarks']), 1, 'L', 1, 0, '', '', true, 0, false, true, 40, 'T');

        //Close and output PDF document
        $pdf->Output('Journal Voucher - '.$voucher['document_identity'].'.pdf', 'I');

    }
}

class PDF extends TCPDF {
    public $data = array();

    //Page header
    public function Header() {
        // Logo
//        if($this->data['company_logo'] != '') {
//            $image_file = DIR_IMAGE.$this->data['company_logo'];
//            //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
//            $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//        }
//      // Set font
        // $this->SetFont('helvetica', 'B', 20);
        // $this->Ln(2);
        // // Title
        // $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln(10);
        // $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //  $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $this->Ln(5);
        // $this->Cell(, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(30, 7, 'Prepared By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(215, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(30, 7, 'Receiver`s Sign', 'T', false, 'C', 0, '', 0, false, 'M', 'M');

    }
}

?>