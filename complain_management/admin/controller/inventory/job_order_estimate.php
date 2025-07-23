<?php

class ControllerInventoryJobOrderEstimate extends HController {
    protected $document_type_id = 47;

    protected function getAlias() {
        return 'inventory/job_order_estimate';
    }

    protected function getPrimaryKey() {
        return 'job_order_estimate_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }


    public function getAjaxLists() {
        $lang = $this->load->language('inventory/job_order_estimate');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $data = array();
        $aColumns = array('action', 'document_date', 'document_identity', 'job_order_identity', 'customer_name','product_name','fault_description', 'created_at', 'check_box');
        $aFields = array('action','jo.document_date','joe.document_identity', 'jo.document_identity', 'jo.customer_name','p.name','jo.fault_description','joe.created_at','check_box');

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
        // d($results, true);

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
                'href' => $this->url->link($this->getAlias() . '/printJobOrderEstimate', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
                'btn_class' => 'btn btn-info btn-xs',
                'class' => 'fa fa-print'
            );

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
                    'href' => $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
                    'btn_class' => 'btn btn-info btn-xs',
                    // 'href' => $this->url->link($this->getAlias() . '#'),

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
             $title = '';
             foreach ($actions as $action) {
             if($action['text'] == 'Post')
             {
                $title = 'Product Issuance';
             }
             else
             {
                $title = $action['text'];
             }
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' '.(isset($action['target'])?'target="'.$action['target'].'"':'').' href="' . $action['href'] .'" '. (isset($action['target']) ? 'target="' . $action['target'] . '"' : '') . ' data-toggle="tooltip" title="' . $title . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
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

        $this->model['terms'] = $this->load->model('common/terms');
        $this->data['terms'] = $this->model['terms']->getRows();

        
        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $this->data['job_order'] = $this->model['job_order']->getFilteredRows();

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
        if (isset($this->request->get['job_order_estimate_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getJobOrderEstimate(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));

     
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
            $this->model['job_order_estimate_detail'] = $this->load->model('inventory/job_order_estimate_detail');
            $rows = $this->model['job_order_estimate_detail']->getJobOrderEstimateDetail(array('job_order_estimate_id' => $this->request->get['job_order_estimate_id']));


            // d($rows,true);

            foreach($rows as $row_no => $row) {
                if($row['product_type']=="service"){
                    $this->data['job_order_estimate_service'][$row_no] = $row;
                }
                else if($row['product_type']=="part"){
                    $this->data['job_order_estimate_part'][$row_no] = $row;
                }
            }
        }
        // d( $this->data['job_order_estimatse_part'],true);

        $data['is_post'] = $result['is_post'];
        
        $this->data['href_get_ref_doc_detail'] = $this->url->link($this->getAlias() . '/getRefDocDetail', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_By_ID'] = $this->url->link($this->getAlias() . '/getProductByID', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_By_Code'] = $this->url->link($this->getAlias() . '/getProductByCode', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['restrict_out_of_stock'] = $this->session->data['restrict_out_of_stock'];
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printJobOrderEstimate', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print_header_wise'] = $this->url->link($this->getAlias() . '/printDocumentHeaderWise', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_get_excel_figures'] = $this->url->link($this->getAlias() . '/ExcelFigures', 'token=' . $this->session->data['token']. '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'job_order_id': {'required': true},
            },
            messages: {
            document_date:{
                remote: 'Invalid Date'
            }}
        }";
        $this->response->setOutput($this->render());
    }

    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model['product'] = $this->load->model('inventory/product');
        $rows = $this->model['product']->getProductJson($search, $page);

        echo json_encode($rows);
    }

    public function getRefDocDetail() {
        $job_order_id= $this->request->post['job_order_id'];
        $where="job_order_id='".$job_order_id."'";
        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $data= $this->model['job_order']->getRow($where);
        echo json_encode($data);
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


    protected function insertData($data) {

        $this->model['document_type'] = $this->load->model('common/document_type');
        $document = $this->model['document_type']->getNextDocument($this->document_type_id);

        $total_part_amount = 0;
        $total_service_amount = 0;
        $total_amount = 0;

        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];

        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_date'] = MySqlDate($data['document_date']);
        $data['base_amount'] = $data['total_amount'] * $data['conversion_rate'];

        if($data['customer_date'] != '') {
            $data['customer_date'] = MySqlDate($data['customer_date']);
        } else {
            $data['customer_date'] = NULL;
        }
        if($data['due_date'] != '') {
            $data['due_date'] = MySqlDate($data['due_date']);
        } else {
            $data['due_date'] = NULL;
        }
        if($data['term_id'] != '') {
            $data['term_id'] = json_encode($data['term_id']);
        } else {
            $data['term_id'] = NULL;
        }
        $estimateDetails = array();

        if($data['part_details'] || $data['service_details']){
            $estimateDetails[] = $data['part_details'];
            $estimateDetails[] = $data['service_details'];
        }
        // d($estimateDetails,true);

        $job_order_estimate_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $job_order_estimate_id;


        $this->model['job_order_estimate_detail'] = $this->load->model('inventory/job_order_estimate_detail');


        foreach ($estimateDetails as $details) {
            foreach ($details as $detail) {
                $detail['job_order_estimate_id'] = $job_order_estimate_id;
                $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
                $detail['company_branch_id'] = $this->session->data['company_branch_id'];
                $detail['company_id'] = $this->session->data['company_id'];

                if($detail['product_type'] == 'part')
                {
                  $total_part_amount+=$detail['amount'];
                }
                if($detail['product_type'] == 'service')
                {
                  $total_service_amount+=$detail['amount'];
                }

                $total_amount = ($total_service_amount + $total_part_amount);
                $job_order_estimate_detail_id=$this->model['job_order_estimate_detail']->add($this->getAlias(), $detail);
            }
        }
            $data['total_amount'] = $total_amount;
            $this->generateSms($data);
            return $job_order_estimate_id;
    }



   // function generate sms 
   public function generateSms($data)
   {

     $message = '';
     $mobile = '';   
     $valid_mobile_no = '';
     $message_txt = '';
     $this_message = '';
     $this->model['setting'] = $this->load->model('common/setting');
     $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'setup',
            'field' => 'estimate_message_box'
        );
        $results = $this->model['setting']->getRow($filter);
        $message_txt = $results['value'];


         if (strpos($message_txt, "<CN>") || strpos($this_message, "<ESTN>") || strpos($message_txt, "<JN>") || strpos($message_txt, "<ESTAMT>") ) {
              $this_message = (str_replace('<CN>' , $data['customer_name'] , $message_txt));
              $this_message = (str_replace('<ESTN>' , $data['document_identity'] , $this_message));
              $this_message = (str_replace('<JN>' , $data['job_order_no'] , $this_message));
              $this_message = (str_replace('<ESTAMT>' , 'Rs.' . number_format($data['total_amount'],2) , $this_message));
         }

       $mobile = trim($data['customer_contact']);
       $message = $this_message;

      if(filter_var($mobile, FILTER_SANITIZE_NUMBER_INT)) {

      if(strlen($mobile) > 10)
      {
        if(!empty($mobile) && !empty($message))
        { 
          SendSms($mobile,$message);
        }  
      }
    }
   }
    protected function insertRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&job_order_estimate_id=' . $id, 'SSL'));
    }

    protected function updateData($primary_key, $data) {

        $job_order_estimate_id = $primary_key;
        $data['document_date'] = MySqlDate($data['document_date']);

        if($data['customer_date'] != '') {
            $data['customer_date'] = MySqlDate($data['customer_date']);
        } else {
            $data['customer_date'] = NULL;
        }
        if($data['due_date'] != '') {
            $data['due_date'] = MySqlDate($data['due_date']);
        } else {
            $data['due_date'] = NULL;
        }

        if($data['term_id'] != '') {
            $data['term_id'] = json_encode($data['term_id']);
        } else {
            $data['term_id'] = NULL;
        }


        $this->model['job_order_estimate'] = $this->load->model('inventory/job_order_estimate');
        $this->model['job_order_estimate_detail'] = $this->load->model('inventory/job_order_estimate_detail');

        $this->model['job_order_estimate']->edit($this->getAlias(), $primary_key, $data);
        // d($data,true);
        $this->model['job_order_estimate_detail']->deleteBulk($this->getAlias(), array('job_order_estimate_id' => $job_order_estimate_id));
        // $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $quotation_id));

        $estimateDetails = array();

        if($data['part_details'] || $data['service_details']){
            $estimateDetails[] = $data['part_details'];
            $estimateDetails[] = $data['service_details'];
        }

        // d($estimateDetails,true);

        foreach ($estimateDetails as $details) {
            foreach ($details as $detail) {
                $detail['job_order_estimate_id'] = $job_order_estimate_id;
                $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
                $detail['company_branch_id'] = $this->session->data['company_branch_id'];
                $detail['company_id'] = $this->session->data['company_id'];
                $job_order_estimate_detail_id=$this->model['job_order_estimate_detail']->add($this->getAlias(), $detail);
                // d($detail,true);

            }
        }

        // $this->model['document'] = $this->load->model('common/document');
        // $insert_document = array(
        //     'company_id' => $this->session->data['company_id'],
        //     'company_branch_id' => $this->session->data['company_branch_id'],
        //     'fiscal_year_id' => $this->session->data['fiscal_year_id'],
        //     'document_type_id' => $this->document_type_id,
        //     'document_id' => $data['document_id'],
        //     'document_identity' => $data['document_identity'],
        //     'document_date' => $data['document_date'],
        //     'partner_type_id' => $data['partner_type_id'],
        //     'partner_id' => $data['partner_id'],
        //     'document_currency_id' => $data['document_currency_id'],
        //     'document_amount' => $data['total_amount'],
        //     'conversion_rate' => $data['conversion_rate'],
        //     'base_currency_id' => $data['base_currency_id'],
        //     'base_amount' => $data['total_amount'] * $data['conversion_rate'],
        // );
        // $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        // $gl_data = array();
        // $stock_ledger = array();
        // foreach ($data['job_order_estimate_details'] as $sort_order => $detail) {
        //     $detail['job_order_estimate_id'] = $job_order_estimate_id;
        //     $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        //     $detail['company_branch_id'] = $this->session->data['company_branch_id'];
        //     $detail['company_id'] = $this->session->data['company_id'];
        //     $detail['sort_order'] = $sort_order;
        //     $quotation_detail_id=$this->model['quotation_detail']->add($this->getAlias(), $detail);

        // }


        return $job_order_estimate_id;
    }

    protected function updateRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&job_order_estimate_id=' . $id, 'SSL'));
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

        
        $this->model['job_order_estimate_detail'] = $this->load->model('inventory/job_order_estimate_detail');
        $this->model['job_order_estimate_detail']->deleteBulk($this->getAlias(),array('job_order_estimate_id' => $primary_key));

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

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


    public function printJobOrderEstimate() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $this->model['user'] = $this->load->model('user/user');
        $job_order_estimate_id = $this->request->get['job_order_estimate_id'];
        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $this->model['job_order_estimate'] = $this->load->model('inventory/job_order_estimate');
        $this->model['company'] = $this->load->model('setup/company_branch');
        $company_address = $this->model['company']->getRow(array('company_id' => $session['company_id']));

        $job_order_estimate = $this->model['job_order_estimate']->getJobOrderEstimate(array('job_order_estimate_id' => $job_order_estimate_id));
         $rows = $this->model['job_order_estimate']->getJobOrderEstimateDetail(array('job_order_estimate_id' => $job_order_estimate_id), array('product_type desc'));
        $this->data['user'] = $this->model['user']->getRow(array('user_id' => $job_order_estimate['created_by_id']));

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Fahad Siddiqui');
        $pdf->SetTitle('Job Order Estimate');
        $pdf->SetSubject('Job Order Estimate');

        //Set Header

        // $pdf->data = array(
        //     'company_name' => $session['company_name'],
        //     //'report_name' => $lang['heading_title'],
        //     'report_name' => 'Bill',
        //     'company_logo' => $session['company_image']
        // );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $pdf->SetMargins(10, 40, 5);
        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetMargins(10, 50, 5);
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

        $warranty = '';
        $receiving_date = '';
        $received_date = '';
        $purchased_date = '';
        $complete_date = '';
        $estimate_date = '';
        $date = '';
        $day = '';
        $month = '';
        $year = '';
        $job_order_estimate['warranty'] == 'Y' ? $warranty = 'Yes' : $warranty = 'No';
        $job_order_estimate['purchased_date'] == '' ? $purchased_date = '' : $purchased_date = stdDate($job_order_estimate['purchased_date']);
        $job_order_estimate['received_date'] == '' ? $received_date = '' : $received_date = stdDate($job_order_estimate['received_date']);
        $job_order_estimate['complete_date'] == '' ? $complete_date = '' : $complete_date = stdDate($job_order_estimate['complete_date']);  

        $job_order_estimate['document_date'] == '' ? $receiving_date = '' : $receiving_date = stdDate($job_order_estimate['document_date']);  

        $job_order_estimate['document_date'] == '' ? $estimate_date = '' : $estimate_date = stdDate($job_order_estimate['document_date']); 
        $date = stdDate();

        if($receiving_date!='')
        {
             $day = date_create($receiving_date);
             $day = date_format($day,'d');
             $month = date_create($receiving_date);
             $month = date_format($month,'m');
             $year = date_create($receiving_date);
             $year = date_format($year,'Y');
        }
   

        $pdf->SetFillColor(255,255,255);

        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->MultiCell(95, 5, 'Job Order Estimate', 0, 'C', 1, 2, 60, 11, true);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(95, 5, 'Recieving Date:', 0, 'L', 1, 2, 14, 26, true);
        $pdf->MultiCell(95, 5, 'Day', 0, 'L', 1, 2, 50, 23, true);
        $pdf->MultiCell(95, 5, 'Month', 0, 'L', 1, 2, 60, 23, true);
        $pdf->MultiCell(95, 5, 'Year', 0, 'L', 1, 2, 74, 23, true);
        $pdf->MultiCell(95, 5, $day, 0, 'L', 1, 2, 50, 26, true);
        $pdf->MultiCell(95, 5, $month, 0, 'L', 1, 2, 62, 26, true);
        $pdf->MultiCell(95, 5, $year, 0, 'L', 1, 2, 74, 26, true);
        $pdf->MultiCell(95, 5, 'JOB.NO.'.' '.$job_order_estimate['job_order_no'], 0, 'L', 1, 2, 159, 26, true);
        $pdf->MultiCell(95, 7, 'Customer Name', 1, 'L', 1, 2, 15, 33, true);
        $pdf->MultiCell(95, 7, $job_order_estimate['customer_name'], 1, 'L', 1, 2, 15, 38, true);
        $pdf->MultiCell(95, 7, 'Customer Address:'. ' ' . $job_order_estimate['customer_address'], 1, 'L', 1, 2, 15, 43, true);
        // $pdf->MultiCell(95, 7, $job_order_estimate['customer_address'], 1, 'L', 1, 2, 15, 48, true);
        $pdf->MultiCell(95, 7, 'Email Address:'. ' ' . $job_order_estimate['customer_email'], 1, 'L', 1, 2, 15, 51, true);
        // $pdf->MultiCell(95, 7, $job_order_estimate['customer_email'], 1, 'L', 1, 2, 15, 58, true);
        $pdf->MultiCell(95, 7, 'Office Telephone', 1, 'L', 1, 2, 15, 56, true);
        $pdf->MultiCell(95, 7, '', 1, 'L', 1, 2, 15, 61, true);
        $pdf->MultiCell(95, 7, 'Home Telephone', 1, 'L', 1, 2, 15, 67, true);
        $pdf->MultiCell(95, 5, $job_order_estimate['customer_contact'], 1, 'L', 1, 2, 15, 73, true);
        $pdf->ln(3);
        $pdf->MultiCell(95, 5, 'Complain', 0, 'L', 1, 2, 14, 86, true);
        $pdf->MultiCell(95, 5, $job_order_estimate['fault_description'], 0, 'L', 1, 2, 14, 90, true);
        $pdf->MultiCell(95, 5, 'Remarks', 0, 'L', 1, 2, 108, 86, true);
        $pdf->MultiCell(95, 5, $job_order_estimate['repair_remarks'], 0, 'L', 1, 2, 108, 90, true);


        $pdf->MultiCell(95, 5,'(1) Hereby declare that the above set was purchased by me legally.', 0, 'L', 1, 2, 14, 108, true);
        $pdf->MultiCell(95, 5, '(2) I agree with the conditions for repairs set by the company.', 0, 'L', 1, 2, 14, 118, true);



        $pdf->MultiCell(65, 7, ' Product '.' '. $job_order_estimate['product_name'], 0, 'L', 1, 2, 111, 33, true);
        $pdf->MultiCell(40, 7, ' Model.# '.' '. $job_order_estimate['model'], 0, 'L', 1, 2, 158, 33, true);
        $pdf->MultiCell(40, 7, ' Receipt No.    ', 0, 'L', 1, 2, 158, 43, true);
        $pdf->MultiCell(40, 7, $job_order_estimate['document_identity'], 0, 'L', 1, 2, 178, 43, true);
        $pdf->MultiCell(65, 7, ' Serial.#.'.' '. $job_order_estimate['product_serial_no'], 0, 'L', 1, 2, 111, 43, true);
        $pdf->MultiCell(65, 7, ' Received Date'.' '. $received_date, 0, 'L', 1, 2, 111, 53, true);
        $pdf->MultiCell(65, 7, ' Warranty'.' '. $warranty, 0, 'L', 1, 2, 158, 53, true);
        $pdf->MultiCell(65, 7, ' Attended By'.' '.$this->data['user']['user_name'], 0, 'L', 1, 2, 111, 63, true);
        $pdf->MultiCell(65, 7, ' Warranty Card.#.'.' '. $job_order_estimate['warranty_card_no'], 0, 'L', 1, 2, 158, 63, true);     
        $pdf->MultiCell(65, 7, ' Date of Purchase '.''.$purchased_date, 0, 'L', 1, 2, 111, 73, true);
        $pdf->MultiCell(65, 7, ' Warranty Type.'.' '. $job_order_estimate['warranty_type'], 0, 'L', 1, 2, 158, 73, true);
        $pdf->Ln(65);
        $pdf->Cell(5, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(50, 5, 'Customer`s Signature', "T", false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(50, 5, 'Receptionist`s Signature', "T", false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 0, 'Dealer/Supplier', 0, false, 'R', 0, '', 0, false, 'M', 'M');
   
        $pdf->ln(7);
        // set font
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        // $pdf->Cell(20, 7, 'Code', 1, false, 'C', 1, '', 1);
        // $pdf->Cell(95, 7, 'Description', 1, false, 'C', 1, '', 1);
        // $pdf->Cell(20, 7, 'Qty.', 1, false, 'C', 1, '', 1);
        // $pdf->Cell(27, 7, 'Unit Price', 1, false, 'C', 1, '', 1);
        // $pdf->Cell(28, 7, 'Amount', 1, false, 'C', 1, '', 1);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $total_part_amount = 0;
        $total_service_amount = 0;
        $total_amount = 0;
        $quantity = 0;
        $rate = 0;
        $sr = 0;
        $pdf->SetFont('helvetica', '', 9);
       
  

        foreach($rows as $key=> $detail) {
            $sr++;
            $pdf->ln(7);
            $pdf->Cell(20, 7, $detail['product_code'], 'L', false, 'C', 0, '', 1);
            if($detail['product_type'] == 'service')
            {
            $pdf->Cell(95, 7, html_entity_decode($detail['service_name']), 'L', false, 'L', 0, '', 1);
            $quantity = 1;
            $rate = $detail['amount'];
            $total_service_amount+=$detail['amount'];
            }
            else
            {
             $pdf->Cell(95, 7, html_entity_decode($detail['part_name']), 'L', false, 'L', 0, '', 1);
             $quantity = $detail['quantity'];
             $rate = $detail['rate'];
             $total_part_amount+=$detail['amount'];
            }
            $pdf->Cell(20, 7, number_format($quantity,0), 'L', false, 'R', 0, '', 1);
            $pdf->Cell(27, 7, number_format($rate,2), 'L', false, 'R', 0, '', 1);
            $pdf->Cell(28, 7, number_format($detail['amount'],2), 'L,R', false, 'R', 0, '', 1);
            $total_amount = ($total_service_amount + $total_part_amount);


            $pdf->Ln(-2);
            $pdf->Cell(20, 7,'', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(95, 7, '', 'L', false, 'L', 0, '', 1);
            $pdf->Cell(20, 7, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(27, 7, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(28, 7, '', 'L,R', false, 'R', 0, '', 1);
            $pdf->Ln(4);
            $y = $pdf->GetY();
           
            if($y>=240 && $key < (count($detail)-1))
            {
                $pdf->AddPage();
            }
            $pdf->Cell(190, 10, '', 'B', false, 'C', 0, '', 0, false, 'M', 'M');
        }

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Ln(10);
        $pdf->Cell(5, 5, 'Estimate of Repair:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(-2);

        $pdf->SetFont('helvetica', '', 9);  
        $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(41, 6, 'Total Spare Parts Charges ', 1, false, 'L');
        $pdf->Cell(20, 6, number_format($total_part_amount,2), 1, false, 'R');
        $pdf->Ln(6);
        $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(41, 6, 'Technical Charges', 1, false, 'L');
        $pdf->Cell(20, 6, number_format($total_service_amount,2), 1, false, 'R');
        $pdf->Ln(6);
        // $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(41, 6, 'Outdoor Transport Charges  ', 1, false, 'L');
        // $pdf->Cell(20, 6, number_format(0,2), 1, false, 'R'); 

        // $pdf->Ln(6);
        // $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(41, 6, 'Inspection/Labour Charges ', 1, false, 'L');
        // $pdf->Cell(20, 6, number_format(0,2), 1, false, 'R'); 


        // $pdf->Ln(6);
        // $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(41, 6, 'Grand Total ', 1, false, 'L');
        // $pdf->Cell(20, 6, number_format($total_amount,2), 1, false, 'R'); 


        // $pdf->Ln(6);
        // $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(41, 6, 'GST ', 1, false, 'L');
        // $pdf->Cell(20, 6, number_format(0,2), 1, false, 'R'); 



        $pdf->Cell(129, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(41, 6, 'Net Payable ', 1, false, 'L');
        $pdf->Cell(20, 6, number_format($total_amount,2), 1, false, 'R'); 



        $pdf->Ln(-5);
        $pdf->SetFont('helvetica', 'B', 9);  
        $pdf->Cell(5, 5, 'Technician', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(20, 0, 'Date of Estimate', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 5, $estimate_date, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 9); 
        $pdf->Cell(5, 5, 'Customer`s Acnowledgement', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->ln(8);
        // $pdf->Cell(7, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(20, 0, 'Completion Date', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(18, 0, $complete_date, 0, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(5, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(20, 0, 'Inspection Date', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(18, 0, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(4, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // $pdf->Cell(5, 5, 'Date', 0, false, 'R', 0, '', 0, false, 'M', 'M');  
        // $pdf->Cell(18, 0, $date, 0, false, 'R', 0, '', 0, false, 'M', 'M'); 
        $pdf->ln(8);
        $pdf->Cell(5, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(35, 5, 'Unit has been repaired as', 0, false, 'R', 0, '', 0, false, 'M', 'M'); 
        $pdf->ln(5);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(4, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(27, 5, 'per my Satisfaction', 0, false, 'R', 0, '', 0, false, 'M', 'M');  
        $pdf->SetFont('helvetica', 'B', 9); 
        $pdf->ln(-5);
        $pdf->Cell(35, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(30, 5, 'Receipt No.', 0, false, 'R', 0, '', 0, false, 'M', 'M');   
        $pdf->Cell(35, 5,$job_order_estimate['document_identity'], 0, false, 'L', 0, '', 0, false, 'M', 'M');     

        $pdf->Ln(30);
        $pdf->Cell(1, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 5, 'Technician Signature', "T", false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(10, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 5, 'Inspector Signature', "T", false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(10, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 5, 'Casher Signature', "T", false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(10, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(40, 5, 'Customer Signature', "T", false, 'C', 0, '', 0, false, 'M', 'M');  


        // $x = $pdf->GetX();
        // $y = $pdf->GetY();


        // for ($i = $y; $i <= 5; $i++) {

        //     $pdf->Ln(1);
        //     $pdf->Cell(20, 7,'', 'L', false, 'C', 0, '', 1);
        //     $pdf->Cell(90, 7, '', 'L', false, 'L', 0, '', 1);
        //     $pdf->Cell(20, 7, '', 'L', false, 'R', 0, '', 1);
        //     $pdf->Cell(27, 7, '', 'L', false, 'R', 0, '', 1);
        //     $pdf->Cell(27, 7, '', 'L,R', false, 'R', 0, '', 1);
        //     $y =$i;
        // }
        // $pdf->Ln(-1);
        // $pdf->Ln(5);
        // $pdf->Cell(184, 7, '', 'B', false, 'C', 0, '', 0, false, 'M', 'M');
        // $pdf->setXY($x,$y);

//         $pdf->ln(9);
//         $pdf->SetFont('helvetica', '', 9);
//         $pdf->Cell(130, 6, 'Remarks : '.$invoice['remarks'], 0, 'L', 1, 1, '' ,'', true);
//         $pdf->Cell(40, 6, $lang['total_amount'].': ', 1, false, 'L');
//         $pdf->Cell(20, 6, number_format($total_amount,2), 1, false, 'R');
        

//         $pdf->ln(6);
//         $pdf->Cell(130, 6, 'IN WORD: ' . Number2Words(round($invoice['net_amount'],2)). ' only', 0, false, 'L');        
//         if($invoice['sale_type'] == 'sale_tax_invoice')
//         {
//             $pdf->Cell(40, 6, 'S.T.@ '.number_format($SalesTax,2).' :  ', 1, false, 'L');
//             $pdf->Cell(20, 6, number_format($invoice['item_tax'],2), 1, false, 'R');    
//         }

//         $pdf->ln(6);        
//         $pdf->Cell(130, 6, '', 0, false, 'L');
//         $pdf->Cell(40, 6, 'Discount : ', 1, false, 'L');
//         $pdf->Cell(20, 6, number_format($invoice['item_discount']+$invoice['discount_amount'],2), 1, false, 'R');
        
//         $pdf->ln(6);        
//         $pdf->Cell(130, 6, '', 0, false, 'L');
//         $pdf->Cell(40, 6, 'Cartage : ', 1, false, 'L');
//         $pdf->Cell(20, 6, number_format($invoice['cartage'],2), 1, false, 'R');
        


//         $pdf->ln(6);
//         if($invoice['exempted'] == 1)
//         {

//         $pdf->SetFont('helvetica', 'BU', 10);
//         $pdf->Cell(115, 6, 'EXEMPTED', 0, false, 'C');
//         $pdf->Cell(15, 6, '', 0, false, 'C');
//         }
//         else{
//             $pdf->Cell(130, 6, '', 0, false, 'L');
//         }
//         $pdf->SetFont('helvetica', '', 9);

//         $pdf->Cell(40, 6, 'Net Amount : ', 1, false, 'L');
//         $pdf->Cell(20, 6, number_format($invoice['net_amount'],2), 1, false, 'R');
//         $pdf->ln(8);
// //        $pdf->Cell(180, 6, 'IN WORD: ' . Number2Words(round($invoice['net_amount'],2)). ' only', 0, false, 'L');
// //        $pdf->ln(6);

//         if($invoice['exempted'] == 1)
//         {
//             $pdf->SetFont('helvetica', 'B', 10);
//             $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
//             $pdf->MultiCell(115, 7, 'PLEASE DO NOT DEDUCT WITH HOLDING TAX WE CERTIFIED
// THAT WE ARE EXEMPTED FOR THE DEDUCTION OF TAX U/S 153
//             SUBSECTION 5(1)(a) OF THE INCOME TAX ACT.2001', 1, 'L', 1, 1, '' ,'', true);

//         }

        //Close and output PDF document
        $pdf->Output('Job Order Estimate - '.$job_order_estimate['document_identity'].'.pdf', 'I');

    }




//     public function printDocumentHeaderWise() {

//         ini_set('max_execution_time',0);
//         ini_set('memory_limit',-1);

//         $lang = $this->load->language($this->getAlias());
//         $QuotationId = $this->request->get['quotation_id'];
//         $post = $this->request->post;
//         $session = $this->session->data;

//         $this->model['company'] = $this->load->model('setup/company');
//         $this->model['partner'] = $this->load->model('common/partner');
//         $this->model['company_branch'] = $this->load->model('setup/company_branch');
//         $this->model['quotation'] = $this->load->model('inventory/quotation');
//         $this->model['unit'] = $this->load->model('inventory/unit');
//         $this->model['quotation_detail'] = $this->load->model('inventory/quotation_detail');


//         $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
//         $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
//         $Quotation = $this->model['quotation']->getRow(array('quotation_id' => $QuotationId));
//         $QuotationDetails = $this->model['quotation_detail']->getRows(array('quotation_id' => $QuotationId),array('sort_order asc'));
//         $Partner = $this->model['partner']->getRow(array('partner_type_id' => $Quotation['partner_type_id'],'partner_id' => $Quotation['partner_id']));


//         $this->model['terms'] = $this->load->model('common/terms');
//         if($Quotation['term_id']) {
//             $rows = json_decode($Quotation['term_id'],true);
//             foreach($rows as $row1 => $row) {
//                 $Term = $this->model['terms']->getRow(array('term_id' => $row['term_id']));
//                 $arrRows[] = array(
//                     'term' => $Term['term']
//                 );
//             }
//         }


//         $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

//         // set document information
//         $pdf->SetCreator(PDF_CREATOR);
//         $pdf->SetAuthor('Fahad Siddiqui');
//         $pdf->SetTitle('Quotation Voucher');
//         $pdf->SetSubject('Quotation Voucher');


//         $salesTax = '';
//         foreach($QuotationDetails as $detail) {
//             $salesTax = $detail['tax_percent'];
//         }

//         //Set Header
//         $pdf->data = array(
//             'company_name' => $session['company_name'],
//             'company_address' => $branch['address'],
//             'company_phone' => $branch['phone_no'],
//             'report_name' => 'Quotation',
//             'company_logo' => $session['company_image'],
//             'header_image' => HTTP_IMAGE.'header.jpg',
//             'footer_image' => HTTP_IMAGE.'footer.jpg',
//             'status' => 'With Header',
//             'term_desc' => $Quotation['term_desc'],
//             'name' => $Partner['name'],
//             'document_date' => $Quotation['document_date'],
//             'document_identity' => $Quotation['document_identity'],
//             'address' => $Partner['address'],
//             'customer_ref_no' => $Quotation['customer_ref_no'],
//             'ref_no' => $Quotation['ref_no'],
//             'sales_tax' => $salesTax,

//         );

//         $pdf->term = array(
//             $arrRows
//         );

//         // set margins
//         //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//         $pdf->SetMargins(2, 105, 2);
//         $pdf->SetHeaderMargin(0);
//         $pdf->SetFooterMargin(50);

//         // set auto page breaks
//         //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//         // set font
//         $pdf->SetFont('times', 'B', 10);

//         // add a page
//         $pdf->AddPage();

//         $pdf->SetTextColor(0,0,0);
// //        $pdf->Ln(40);

// //        $pdf->SetFont('times', '', 10);
// //        $pdf->Ln(10);
// //        $pdf->Cell(120,7, html_entity_decode($Partner['name']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(36, 7, 'Quotation No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(50, 7, $Quotation['document_identity'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Ln(7);
// //        $pdf->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(36, 7, 'Quotation Date :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(50, 7, stdDate($Quotation['document_date']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Ln(7);
// //        $pdf->Cell(120,7, $Partner['address'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(36, 7, 'Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(50, 7, $Quotation['customer_ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Ln(7);
// //        $pdf->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(36, 7, 'Our Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(50, 7, $Quotation['ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
// //        $pdf->Ln(10);
// //
// //        $pdf->SetFont('times', 'B', 8);
// //        $pdf->Cell(6, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(100, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// /////        $pdf->Cell(20, 7, 'Delivery', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(15, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(13, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(16, 7, 'Price', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(20, 7, 'Amt Excl Gst', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(17, 7, 'GST (17%)', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $pdf->Cell(20, 7, 'Amt Incl GST', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//         $sr = 0;
// //        $pdf->Ln(7);

//         $Amount = 0;
//         $WhAmount = 0;
//         $OtAmount = 0;
//         $NetAmount = 0;

//         $pdf->SetFont('times', '', 7);
//         foreach($QuotationDetails as $row_no => $detail) {

//             if($row_no%16==0 && $row_no !=0) {
//                 $pdf->Cell(207, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
//                 $pdf->AddPage();
//             }
//             $Unit = $this->model['unit']->getRow(array('unit_id' => $detail['unit_id']));

//             $sr++;
//             $pdf->Cell(6, 7, $sr, 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(100, 7, html_entity_decode($detail['description']), 'L', false, 'L', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(15, 7, $detail['qty'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(13, 7, $Unit['name'], 'L', false, 'L', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(16, 7, number_format($detail['rate'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(20, 7, number_format($detail['amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(17, 7, number_format($detail['tax_amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(20, 7, number_format($detail['net_amount'],2), 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Ln(7);
//         }
//         $pdf->Ln(-2);

//         $x = $pdf->GetX();
//         $y = $pdf->GetY();

//         for ($i = $y; $i <= 190; $i++) {
//             $pdf->Cell(6, 1, '', 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(100, 1,'', 'L', false, 'L', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(15, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(13, 1, '', 'L', false, 'L', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(16, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(20, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(17, 1, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
//             $pdf->Cell(20, 1, '', 'LR', false, 'R', 0, '', 0, false, 'M', 'M');
//             $y =$i;
//             $pdf->Ln(1);
//         }
//         $pdf->Ln(3);
//         $pdf->Cell(207, 4, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
//         //$pdf->setXY($x,$y);
//         $pdf->SetFont('times', 'B', 8);

//         $pdf->Ln(2);
//         $pdf->Cell(150, 7, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//         $pdf->Cell(20, 7, number_format($Quotation['item_amount'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
//         $pdf->Cell(17, 7, number_format($Quotation['item_tax'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
//         $pdf->Cell(20, 7, number_format($Quotation['item_total'],2), 1, false, 'R', 0, '', 0, false, 'M', 'M');

//         $pdf->SetFont('times', 'B', 11);

//         $pdf->Ln(3);
//         $x = $pdf->GetX();
//         $y = $pdf->GetY();

//         //$pdf->Cell(0, 5, 'Terms & Condition', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//         $pdf->SetFont('times', 'B', 9);
//         $pdf->MultiCell(0, 5, $Quotation['term_desc'], 0, 'J', 0, 2, $x, $y, true);
//         $pdf->Ln(8);
//         $pdf->Ln(50);

// //        $pdf->Ln(15);
// //        $pdf->Cell(0, 6, 'Authorized Signature.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
//         $data= $Quotation;
//         //Close and output PDF document
//         $pdf->Output('Quotation :'.date('YmdHis').'.pdf', 'I');
//     }

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





        if($this->PageNo() == 1)
        {
         $this->SetMargins(10, 40, 5);
         $this->ln(148);
        }
        else {
         $this->ln(7);
         $this->SetMargins(10, 10, 5);
        }

        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(20, 7, 'Code', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(95, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(27, 7, 'Unit Price', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(28, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
    


//         if($this->data['status'] == "With Header")
//         {
//             // $this->Image($this->data['header_image'], 0, 5, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);

//             $this->Ln(40);
//             $this->SetFont('times', '', 9);
//             $this->Cell(0, 6, 'NTN-1135326-7', 0, false, 'R', 0, '', 0, false, 'M', 'M');
//             $this->Ln(6);
//             $this->Cell(0, 6, 'GST-12-22-9999-050-91', 0, false, 'R', 0, '', 0, false, 'M', 'M');
//             $this->Ln(6);
//             $this->SetFont('times', 'B', 20);
//             $this->Cell(0, 4, $this->data['report_name'], 0, false, 'R', 0, '', 0, false, 'M', 'M');

//             $this->SetFont('times', '', 10);
//             $this->Ln(10);
//             $this->Cell(120,7, html_entity_decode($this->data['name']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(36, 7, 'Quotation No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(50, 7, $this->data['document_identity'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Ln(7);
//             $this->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(36, 7, 'Quotation Date :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(50, 7, stdDate($this->data['document_date']), 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Ln(7);
//             $this->SetFont('times', '', 9);
//             $this->Cell(120,7, $this->data['address'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(36, 7, 'Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->SetFont('times', '', 10);
//             $this->Cell(50, 7, $this->data['customer_ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Ln(7);
//             $this->Cell(120,7, '', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(36, 7, 'Our Ref No :', 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Cell(50, 7, $this->data['ref_no'], 1, false, 'L', 0, '', 0, false, 'M', 'M');
//             $this->Ln(10);

//             $this->SetFont('times', 'B', 8);
//             $this->Cell(6, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(100, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
// ///        $this->Cell(20, 7, 'Delivery', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(15, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(13, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(16, 7, 'Price', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(20, 7, 'Amt Excl Gst', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(17, 7, 'GST ('.number_format($this->data['sales_tax'],0).'%)', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//             $this->Cell(20, 7, 'Amt Incl GST', 1, false, 'C', 0, '', 0, false, 'M', 'M');


//         }

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