<?php

class ControllerInventoryProductIssuance extends HController {
    protected $document_type_id = 48;

    protected function getAlias() {
        return 'inventory/product_issuance';
    }

    protected function getPrimaryKey() {
        return 'product_issuance_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }


    public function getAjaxLists() {
        $lang = $this->load->language('inventory/quotation');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $data = array();
        $aColumns = array('action', 'document_date', 'document_identity', 'job_order_identity' ,'customer_name','product_name','fault_description', 'created_at', 'check_box');
        $aFields = array('action','jo.document_date','pi.document_identity','jo.document_identity', 'jo.customer_name','p.name','jo.fault_description','pi.created_at','check_box');

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
                    $sOrder .= $aFields[intval($_GET['iSortCol_' . $i])] .
                        ($_GET['sSortDir_' . $i] === 'asc' ? ' asc' : ' desc') . ", ";
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
        $arrWhere[] = "jo.company_id='".$this->session->data['company_id']."'";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $arrSSearch = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch'] != '') {
                    $arrSSearch[] = "LOWER(" . $aFields[$i] . ") LIKE '%" . $this->db->escape(strtolower($_GET['sSearch'])) . "%'";
                }
            }
            if(!empty($arrSSearch)) {
                $arrWhere[] = '(' . implode(' OR ', $arrSSearch) . ')';
            }
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                $arrWhere[] = "LOWER(" . $aFields[$i] . ") LIKE '%" . $this->db->escape(strtolower($_GET['sSearch_' . $i])) . "%' ";
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

            // $actions[] = array(
            //     'text' => $lang['print'],
            //     'target' => '_blank',
            //     // 'href' => $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
            //     'btn_class' => 'btn btn-info btn-xs',
            //     'class' => 'fa fa-print'
            // );
            // $actions[] = array(
            //     'text' => $lang['print_with_header'],
            //     'target' => '_blank',
            //     'href' => $this->url->link($this->getAlias() . '/printDocumentHeaderWise', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
            //     'btn_class' => 'btn btn-info btn-xs',
            //     'class' => 'fa fa-print'
            // );

            if($aRow['is_post']==0) {
                $actions[] = array(
                    'text' => $lang['post'],
                    // 'href' => $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
                    'href' => $this->url->link($this->getAlias() . '#'),

                    'btn_class' => 'btn btn-info btn-xs',
                    'class' => 'fa fa-thumbs-up',
                    // 'click'=> 'return confirm(\'Are you sure you want to post this item?\');'
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
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' '.(isset($action['target'])?'target="'.$action['target'].'"':'').' href="' . $action['href'] .'" '. (isset($action['target']) ? 'target="' . $action['target'] . '"' : '') . ' data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
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

        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $this->data['job_order'] = $this->model['job_order']->getFilteredRowsForPI();

        $this->model['terms'] = $this->load->model('common/terms');
        $this->data['terms'] = $this->model['terms']->getRows();
        $this->model['product'] = $this->load->model('inventory/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']),array('name'));
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->data['units'] = $this->model['unit']->getRows(array('company_id' => $this->session->data['company_id']));
        $arrUnits = $this->model['unit']->getArrays('unit_id','name',array('company_id' => $this->session->data['company_id']));
        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));
        $this->data['arrWarehouses'] = json_encode($this->data['warehouses']);
        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        $this->data['partner_types'] = $this->session->data['partner_types'];
        $this->data['partner_type_id'] = 2;

        $this->model['partner'] = $this->load->model('common/partner');
        $this->data['partners'] = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'partner_type_id' => 2));

        $this->data['document_date'] = stdDate();
        if (isset($this->request->get['product_issuance_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            // $result = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));
            
            $result = $this->model[$this->getAlias()]->getProductIssuance(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));
     
            $where="job_order_id='".$result['job_order_id']."'";
            $this->model['job_order'] = $this->load->model('inventory/job_order');
            $data= $this->model['job_order']->getRow($where);

            $this->data['ref_document_identity'] = $data['document_identity'];
            
            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } elseif($field=='customer_date') {
                    $this->data[$field] = stdDateTime($value);
                }elseif($field=='due_date') {
                    $this->data[$field] = stdDate($value);
                }elseif($field=='term_id' && !empty($value)) {
                    $this->data[$field] = json_decode($value);
                } else {
                    $this->data[$field] = $value;
                }
            }

            $this->model['product_issuance_detail'] = $this->load->model('inventory/product_issuance_detail');
            $rows = $this->model['product_issuance_detail']->getRows(array('product_issuance_id' => $this->request->get['product_issuance_id']),array('sort_order asc'));
            foreach($rows as $row_no => $row) {
                $this->data['product_issuance_detail'][$row_no] = $row;
            }

        }
        $this->model['product'] = $this->load->model('inventory/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']),array('name'));
        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_ref_doc_detail'] = $this->url->link($this->getAlias() . '/getRefDocDetail', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_By_ID'] = $this->url->link($this->getAlias() . '/getProductByID', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_By_Code'] = $this->url->link($this->getAlias() . '/getProductByCode', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['restrict_out_of_stock'] = $this->session->data['restrict_out_of_stock'];
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print_header_wise'] = $this->url->link($this->getAlias() . '/printDocumentHeaderWise', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_get_excel_figures'] = $this->url->link($this->getAlias() . '/ExcelFigures', 'token=' . $this->session->data['token']. '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'partner_id': {'required': true},
                'total_qty': {'required': true, 'min':1},
            },
            messages: {
            document_date:{
                remote: 'Invalid Date'
            }}
        }";
        // d($this->data,true);
        $this->response->setOutput($this->render());
    }

    public function getProductByID() {
        $product_id= $this->request->post['product_id'];

        $where="product_id='".$product_id."'";
        $where.="company_id='".$this->session->data['company_id']."'";

        $this->model['product'] = $this->load->model('inventory/product');
        $data = $this->model['product']->getRow($where);

        echo json_encode($data);
    }


    public function getProductByCode() {
        $product_code= $this->request->post['product_code'];

        $where="product_code='".$product_code."'";
        $where.="company_id='".$this->session->data['company_id']."'";

        $this->model['product'] = $this->load->model('inventory/product');
        $data = $this->model['product']->getRow($where);
        
        echo json_encode($data);
    }

    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model['product'] = $this->load->model('inventory/product');
        $rows = $this->model['product']->getProductJson($search, $page);

        echo json_encode($rows);
    }

    protected function insertData($data) {

        // d($data,true);
        $this->model['document_type'] = $this->load->model('common/document_type');
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

        $product_issuance_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $product_issuance_id;


        $this->model['product_issuance_detail'] = $this->load->model('inventory/product_issuance_detail');

        foreach ($data['product_issuance_details'] as $details) {
                $details['product_issuance_id'] = $product_issuance_id;
                $details['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
                $details['company_branch_id'] = $this->session->data['company_branch_id'];
                $details['company_id'] = $this->session->data['company_id'];
               
                $product_issuance_detail_id=$this->model['product_issuance_detail']->add($this->getAlias(), $details);

        }
        
        return $product_issuance_id;
    }

    protected function insertRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&product_issuance_id=' . $id, 'SSL'));
    }

    public function getRefDocDetail() {
        $job_order_id= $this->request->post['job_order_id'];
        $this->model['product_issuance'] = $this->load->model('inventory/product_issuance');
        $rows = $this->model['product_issuance']->getProductsByJobOrder($job_order_id);
        // d($rows,true);
        echo json_encode($rows);
    }
    
    protected function updateData($primary_key, $data) {

        // d("hello",true);
        $product_issuance_id = $primary_key;
        $data['document_date'] = MySqlDate($data['document_date']);

        $this->model['product_issuance'] = $this->load->model('inventory/product_issuance');
        $this->model['product_issuance_detail'] = $this->load->model('inventory/product_issuance_detail');


        $this->model['product_issuance']->edit($this->getAlias(), $primary_key, $data);
        $this->model['product_issuance_detail']->deleteBulk($this->getAlias(), array('product_issuance_id' => $product_issuance_id));

    
        foreach ($data['product_issuance_details'] as $details) {
            $details['product_issuance_id'] = $product_issuance_id;
            $details['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $details['company_branch_id'] = $this->session->data['company_branch_id'];
            $details['company_id'] = $this->session->data['company_id'];
            $product_issuance_detail_id=$this->model['product_issuance_detail']->add($this->getAlias(), $details);
        }
        return $product_issuance_id;
    }

    protected function updateRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&product_issuance_id=' . $id, 'SSL'));
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

        $this->model['product_issuance_detail'] = $this->load->model('inventory/product_issuance_detail');
        $this->model['product_issuance_detail']->deleteBulk($this->getAlias(),array('product_issuance_id' => $primary_key));


        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);
    }


    public function ajaxValidateForm() {
        $post  = $this->request->post;
        $lang = $this->load->language('inventory/quotation');
        $error = array();

        if($post['voucher_date'] == '') {
            $error[] = $lang['error_voucher_date'];
        }

        if($post['supplier_id'] == '') {
            $error[] = $lang['error_supplier'];
        }

        $details = $post['quotation_details'];
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


    public  function ExcelFigures()
    {
        $QuotationId = $this->request->get['quotation_id'];
//        d($QuotationId,true);
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $QuotationId = $this->request->get['quotation_id'];
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['company'] = $this->load->model('setup/company');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['quotation'] = $this->load->model('inventory/quotation');
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->model['quotation_detail'] = $this->load->model('inventory/quotation_detail');


        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
        $Quotation = $this->model['quotation']->getRow(array('quotation_id' => $QuotationId));
        $QuotationDetails = $this->model['quotation_detail']->getRows(array('quotation_id' => $QuotationId),array('sort_order asc'));
        $Partner = $this->model['partner']->getRow(array('partner_type_id' => $Quotation['partner_type_id'],'partner_id' => $Quotation['partner_id']));


        $this->model['terms'] = $this->load->model('common/terms');
        if($Quotation['term_id']) {
            $rows = json_decode($Quotation['term_id'],true);
            foreach($rows as $row1 => $row) {
                $Term = $this->model['terms']->getRow(array('term_id' => $row['term_id']));
                $arrRows[] = array(
                    'term' => $Term['term']
                );
            }
        }

        $salesTax = '';
        foreach($QuotationDetails as $detail) {
            $salesTax = $detail['tax_percent'];
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
                'bold' => true,
                'size' => 14,
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,'NTN-1135326-7');
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
                'bold' => true,
                'size' => 14,
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );

        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,'GST-12-22-9999-050-91');
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
                'bold' => true,
                'size' => 18,
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
        );

        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,'Quotation')->getStyle('F'.$rowCount)->getFont()->setBold( true )->setSize(14);
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,$Partner['name']);
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':F'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,'Quotation No : ');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,$Quotation['document_identity']);
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,'');
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':F'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,'Quotation Date : ');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,stdDate($Quotation['document_date']));
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,$Partner['address']);
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':F'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,'Ref No :');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,$Quotation['customer_ref_no']);
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,'');
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':F'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,'Our Ref No :');
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':H'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,$Quotation['ref_no']);
        $rowCount++;


        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Sr.')->getStyle('A'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Description')->getStyle('B'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Qty')->getStyle('C'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Unit')->getStyle('D'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Price.')->getStyle('E'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Amt Excl Gst')->getStyle('F'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'GST ('.number_format($salesTax,0).'%)')->getStyle('G'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Amt Incl GST')->getStyle('H'.$rowCount)->getFont()->setBold( true );

        $rowCount++;
        $sr = 0;

        foreach($QuotationDetails as $detail) {

            $sr++;
            $Unit = $this->model['unit']->getRow(array('unit_id' => $detail['unit_id']));

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $sr);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, html_entity_decode($detail['description']));
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $detail['qty']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $Unit['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($detail['rate'],2,".",""));
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($detail['amount'],2,".",""));
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($detail['tax_amount'],2,".",""));
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($detail['net_amount'],2,".",""));
            $rowCount++;

        }

        $rowCount += 5;

        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($Quotation['item_amount'],2,".",""));
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($Quotation['item_tax'],2,".",""));
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($Quotation['item_total'],2,".",""));

        $rowCount++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Terms & Condition');

        //$rowCount++;
        //$objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount+7);
        //$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,$Quotation['term_desc']);

        foreach($arrRows as $r => $row) {
            foreach($row as $term ) {
                $rowCount++;
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':H'.$rowCount);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '* '.$term);
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Quotation.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;

        // d($html,true);

    }


    public function printDocument() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $QuotationId = $this->request->get['quotation_id'];
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['company'] = $this->load->model('setup/company');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['quotation'] = $this->load->model('inventory/quotation');
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->model['quotation_detail'] = $this->load->model('inventory/quotation_detail');


        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
        $Quotation = $this->model['quotation']->getRow(array('quotation_id' => $QuotationId));
        $QuotationDetails = $this->model['quotation_detail']->getRows(array('quotation_id' => $QuotationId),array('sort_order asc'));
        $Partner = $this->model['partner']->getRow(array('partner_type_id' => $Quotation['partner_type_id'],'partner_id' => $Quotation['partner_id']));


        $this->model['terms'] = $this->load->model('common/terms');
        if($Quotation['term_id']) {
            $rows = json_decode($Quotation['term_id'],true);
            foreach($rows as $row1 => $row) {
                $Term = $this->model['terms']->getRow(array('term_id' => $row['term_id']));
                $arrRows[] = array(
                    'term' => $Term['term']
                );
            }
        }


        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Fahad Siddiqui');
        $pdf->SetTitle('Quotation Voucher');
        $pdf->SetSubject('Quotation Voucher');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'company_address' => $branch['address'],
            'company_phone' => $branch['phone_no'],
            'report_name' => 'Quotation',
            'company_logo' => $session['company_image'],
            'status' => 'Without Header',
            'term_desc' => $Quotation['term_desc']
        );

        $pdf->term = array(
            $arrRows
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(2, 2, 2);
        $pdf->SetHeaderMargin(2);
        $pdf->SetFooterMargin(2);

        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('times', 'B', 10);

        // add a page
        $pdf->AddPage();

        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(40);

        $salesTax = '';
        foreach($QuotationDetails as $detail) {
            $salesTax = $detail['tax_percent'];
        }
        $pdf->SetFont('times', '', 9);
        $pdf->Cell(0, 6, 'NTN-1135326-7', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(6);
        $pdf->Cell(0, 6, 'GST-12-22-9999-050-91', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(6);
        $pdf->SetFont('times', 'B', 20);
        $pdf->Cell(0, 4, $pdf->data['report_name'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('times', '', 10);
        $pdf->Ln(10);
        $pdf->Cell(120,7, html_entity_decode($Partner['name']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(36, 7, 'Quotation No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(50, 7, $Quotation['document_identity'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(7);
        $pdf->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(36, 7, 'Quotation Date :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(50, 7, stdDate($Quotation['document_date']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(7);
        $pdf->Cell(120,7, $Partner['address'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(36, 7, 'Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(50, 7, $Quotation['customer_ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(7);
        $pdf->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(36, 7, 'Our Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(50, 7, $Quotation['ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(10);

        $pdf->SetFont('times', 'B', 8);
        $pdf->Cell(6, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(100, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
///        $pdf->Cell(20, 7, 'Delivery', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(15, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(13, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, 'Price', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Amt Excl Gst', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(17, 7, 'GST ('.number_format($salesTax,0).'%)', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Amt Incl GST', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $sr = 0;
        $pdf->Ln(0);

        $Amount = 0;
        $WhAmount = 0;
        $OtAmount = 0;
        $NetAmount = 0;

        $pdf->SetFont('times', '', 7);
        foreach($QuotationDetails as $detail) {

            $Unit = $this->model['unit']->getRow(array('unit_id' => $detail['unit_id']));

            $sr++;
            $pdf->Ln(7);
            $pdf->Cell(6, 7, $sr, 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(100, 7, html_entity_decode($detail['description']), 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(15, 7, $detail['qty'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(13, 7, $Unit['name'], 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(16, 7, number_format($detail['rate'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, number_format($detail['tax_amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['net_amount'],2), 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');

        }
        $x = $pdf->GetX();
        $y = $pdf->GetY();


        for ($i = $y; $i <= 140; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(6, 7, '', 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(100, 7,'', 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(15, 7, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(13, 7, '', 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(16, 7, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, '', 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');
            $y =$i;
        }
        $pdf->Ln(-1);
        $pdf->Ln(1);
        $pdf->Cell(207, 7, '', 'B', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->setXY($x,$y);
        $pdf->SetFont('times', 'B', 8);

        $pdf->Ln(8);
        $pdf->Cell(150, 7, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, number_format($Quotation['item_amount'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(17, 7, number_format($Quotation['item_tax'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, number_format($Quotation['item_total'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');

        $pdf->SetFont('times', 'B', 11);
        $pdf->Ln(1);

        $pdf->Cell(0, 5, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('times', 'B', 9);
        $pdf->setFillColor(255,255,255);
        $pdf->MultiCell(205, 35, $Quotation['term_desc'], 0, 'L', 1, 2, 2, 163, true);

//        $pdf->Ln(15);
//        $pdf->Cell(0, 6, 'Authorized Signature.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $data= $Quotation;
        //Close and output PDF document
        $pdf->Output('Quotation :'.date('YmdHis').'.pdf', 'I');
    }

    public function printDocumentHeaderWise() {

        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $QuotationId = $this->request->get['quotation_id'];
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['company'] = $this->load->model('setup/company');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['quotation'] = $this->load->model('inventory/quotation');
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->model['quotation_detail'] = $this->load->model('inventory/quotation_detail');


        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
        $Quotation = $this->model['quotation']->getRow(array('quotation_id' => $QuotationId));
        $QuotationDetails = $this->model['quotation_detail']->getRows(array('quotation_id' => $QuotationId),array('sort_order asc'));
        $Partner = $this->model['partner']->getRow(array('partner_type_id' => $Quotation['partner_type_id'],'partner_id' => $Quotation['partner_id']));


        $this->model['terms'] = $this->load->model('common/terms');
        if($Quotation['term_id']) {
            $rows = json_decode($Quotation['term_id'],true);
            foreach($rows as $row1 => $row) {
                $Term = $this->model['terms']->getRow(array('term_id' => $row['term_id']));
                $arrRows[] = array(
                    'term' => $Term['term']
                );
            }
        }


        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Fahad Siddiqui');
        $pdf->SetTitle('Quotation Voucher');
        $pdf->SetSubject('Quotation Voucher');


        $salesTax = '';
        foreach($QuotationDetails as $detail) {
            $salesTax = $detail['tax_percent'];
        }

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'company_address' => $branch['address'],
            'company_phone' => $branch['phone_no'],
            'report_name' => 'Quotation',
            'company_logo' => $session['company_image'],
            'header_image' => HTTP_IMAGE.'header.jpg',
            'footer_image' => HTTP_IMAGE.'footer.jpg',
            'status' => 'With Header',
            'term_desc' => $Quotation['term_desc'],
            'name' => $Partner['name'],
            'document_date' => $Quotation['document_date'],
            'document_identity' => $Quotation['document_identity'],
            'address' => $Partner['address'],
            'customer_ref_no' => $Quotation['customer_ref_no'],
            'ref_no' => $Quotation['ref_no'],
            'sales_tax' => $salesTax,

        );

        $pdf->term = array(
            $arrRows
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(2, 105, 2);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(50);

        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('times', 'B', 10);

        // add a page
        $pdf->AddPage();

        $pdf->SetTextColor(0,0,0);
//        $pdf->Ln(40);

//        $pdf->SetFont('times', '', 10);
//        $pdf->Ln(10);
//        $pdf->Cell(120,7, html_entity_decode($Partner['name']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(36, 7, 'Quotation No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(50, 7, $Quotation['document_identity'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Ln(7);
//        $pdf->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(36, 7, 'Quotation Date :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(50, 7, stdDate($Quotation['document_date']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Ln(7);
//        $pdf->Cell(120,7, $Partner['address'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(36, 7, 'Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(50, 7, $Quotation['customer_ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Ln(7);
//        $pdf->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(36, 7, 'Our Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(50, 7, $Quotation['ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//        $pdf->Ln(10);
//
//        $pdf->SetFont('times', 'B', 8);
//        $pdf->Cell(6, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(100, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
/////        $pdf->Cell(20, 7, 'Delivery', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(15, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(13, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(16, 7, 'Price', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(20, 7, 'Amt Excl Gst', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(17, 7, 'GST (17%)', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//        $pdf->Cell(20, 7, 'Amt Incl GST', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $sr = 0;
//        $pdf->Ln(7);

        $Amount = 0;
        $WhAmount = 0;
        $OtAmount = 0;
        $NetAmount = 0;

        $pdf->SetFont('times', '', 7);
        foreach($QuotationDetails as $row_no => $detail) {

            if($row_no%16==0 && $row_no !=0) {
                $pdf->Cell(207, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->AddPage();
            }
            $Unit = $this->model['unit']->getRow(array('unit_id' => $detail['unit_id']));

            $sr++;
            $pdf->Cell(6, 7, $sr, 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(100, 7, html_entity_decode($detail['description']), 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(15, 7, $detail['qty'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(13, 7, $Unit['name'], 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(16, 7, number_format($detail['rate'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, number_format($detail['tax_amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['net_amount'],2), 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(7);
        }
        $pdf->Ln(-2);

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        for ($i = $y; $i <= 190; $i++) {
            $pdf->Cell(6, 1, '', 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(100, 1,'', 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(15, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(13, 1, '', 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(16, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 1, '', 'LR', false, 'R', 0, '', 0, false, 'M', 'M');
            $y =$i;
            $pdf->Ln(1);
        }
        $pdf->Ln(3);
        $pdf->Cell(207, 4, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
        //$pdf->setXY($x,$y);
        $pdf->SetFont('times', 'B', 8);

        $pdf->Ln(2);
        $pdf->Cell(150, 7, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, number_format($Quotation['item_amount'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(17, 7, number_format($Quotation['item_tax'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, number_format($Quotation['item_total'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');

        $pdf->SetFont('times', 'B', 11);

        $pdf->Ln(3);
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        //$pdf->Cell(0, 5, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('times', 'B', 9);
        $pdf->MultiCell(0, 5, $Quotation['term_desc'], 0, 'J', 0, 2, $x, $y, true);
        $pdf->Ln(8);
        $pdf->Ln(50);

//        $pdf->Ln(15);
//        $pdf->Cell(0, 6, 'Authorized Signature.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $data= $Quotation;
        //Close and output PDF document
        $pdf->Output('Quotation :'.date('YmdHis').'.pdf', 'I');
    }

}

class PDF extends TCPDF {
    public $data = array();
    public $term = array();


    //Page header
    public function Header() {
        // Logo
//        if($this->data['company_logo'] != '') {
//            $image_file = DIR_IMAGE.$this->data['company_logo'];
//            //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
//            $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//        }
//        // Set font
//        $this->SetTextColor(255,255,255);
//        $this->SetFont('helvetica', 'B', 10);
//        $this->Ln(2);
//        // Title
//        $this->Cell(0, 4, $this->data['company_name'], 0, false, 'C', 1, '', 0, false, 'M', 'M');
//        $this->Ln(4);
//        if($this->data['company_address']) {
//            $this->Cell(0, 4, $this->data['company_address'], 0, false, 'C', 0, '', 1, false, 'M', 'M');
//            $this->Ln(4);
//        }
//        if($this->data['company_phone']) {
//            $this->Cell(0, 4, 'Phone: '.$this->data['company_phone'], 0, false, 'C', 1, '', 0, false, 'M', 'M');
//            $this->Ln(4);
//        }
//        $this->SetTextColor(0,0,0);
//        $this->Cell(0, 4, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        if($this->data['status'] == "With Header")
        {
            // $this->Image($this->data['header_image'], 0, 5, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);

            $this->Ln(40);
            $this->SetFont('times', '', 9);
            $this->Cell(0, 6, 'NTN-1135326-7', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $this->Ln(6);
            $this->Cell(0, 6, 'GST-12-22-9999-050-91', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $this->Ln(6);
            $this->SetFont('times', 'B', 20);
            $this->Cell(0, 4, $this->data['report_name'], 0, false, 'R', 0, '', 0, false, 'M', 'M');

            $this->SetFont('times', '', 10);
            $this->Ln(10);
            $this->Cell(120,7, html_entity_decode($this->data['name']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(36, 7, 'Quotation No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(50, 7, $this->data['document_identity'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7);
            $this->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(36, 7, 'Quotation Date :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(50, 7, stdDate($this->data['document_date']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7);
            $this->SetFont('times', '', 9);
            $this->Cell(120,7, $this->data['address'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(36, 7, 'Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->SetFont('times', '', 10);
            $this->Cell(50, 7, $this->data['customer_ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(7);
            $this->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(36, 7, 'Our Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Cell(50, 7, $this->data['ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
            $this->Ln(10);

            $this->SetFont('times', 'B', 8);
            $this->Cell(6, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(100, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
///        $this->Cell(20, 7, 'Delivery', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(13, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(16, 7, 'Price', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Amt Excl Gst', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'GST ('.number_format($this->data['sales_tax'],0).'%)', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Amt Incl GST', 1, false, 'C', 0, '', 0, false, 'M', 'M');


        }

    }

    // Page footer
    public function Footer() {
//        // Position at 15 mm from bottom
        $this->SetY(-140);
//        // Set font
//        $this->SetFont('times', 'B', 12);
//
//        $this->Cell(0, 5, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $this->SetFont('times', 'B', 10);
//        // Page number

        $rows = $this->term;
        $this->Ln(6);

//            foreach($rows as $r => $row) {
//                foreach($row as $term ) {
//                    $this->Cell(0, 5, '* '.$term['term'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
//                    $this->Ln(5);
//                }
//            }
//                            $this->MultiCell(0, 15, $this->data['term_desc']);
//        $this->MultiCell(0, 5, $this->data['term_desc'], 0, 'J', 0, 2, 5, 232, true);


        $this->SetFont('times', 'B', 11);
//        $this->Ln(5);
//        $this->Cell(0, 5, 'In case of any clarification or query , please feel free to contact us.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//        $this->Ln(5);
        if($this->data['status'] == "With Header")
        {
            // $this->Image($this->data['footer_image'], 0, 250, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);

        }
    }


}

?>