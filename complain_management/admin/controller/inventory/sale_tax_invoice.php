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
        $aColumns = array('action', 'document_date', 'document_identity','customer_name', 'net_amount','invoice_status', 'created_at', 'check_box');

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

            // $actions[] = array(
            //     'text' => $lang['print_bill'],
            //     'target' => '_blank',
            //     'href' => $this->url->link($this->getAlias() . '/printCommercialInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL'),
            //     'btn_class' => 'btn btn-info btn-xs',
            //     'class' => 'fa fa-print'
            // );

            $actions[] = array(
                'text' => $lang['print_sales_invoice'],
                'target' => '_blank',
                'href' => $this->url->link($this->getAlias() . '/printSalesInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()].'&with_previous_balance=1', 'SSL'),
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

        $this->model['customer_unit'] = $this->load->model('inventory/customer_unit');
        $this->data['customer_units'] = $this->model['customer_unit']->getRows(array('company_id' => $this->session->data['company_id']),array('customer_unit'));
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

        $this->data['partner_type_id'] = 2;

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


         $this->model['job_order'] = $this->load->model('inventory/job_order');
         $sale_invoice_job_order_id = $result['job_order_id'];
         $job_order = $this->model['job_order']->getFilteredRowsForJOE($sale_invoice_job_order_id);
         foreach($job_order as $key=>$row)
         {
            $job_order_id = $row['job_order_id'];
            $document_identity = $row['document_identity'];
            if($job_order_id == $sale_invoice_job_order_id)
            {
              $this->data['job_order_no'] = $document_identity;
            }
         }
            $this->model['quotation'] = $this->load->model('inventory/quotation');
            $this->data['quotations'] = $this->model['quotation']->getRows(array('partner_id' => $result['partner_id']));
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

            $where = " company_id=".$this->session->data['company_id'];
            $where .= " AND delivery_challan_id IN('" . implode("','", json_decode($result['ref_document_id'])) . "')";

            $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
            $this->data['ref_documents'] = $this->model['delivery_challan']->getRows($where);
            $this->data['ref_document_id'] = json_decode($result['ref_document_id']);

            $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
            $details = $this->model['sale_tax_invoice_detail']->getRows(array('sale_tax_invoice_id' => $this->request->get['sale_tax_invoice_id']), array('sort_order asc'));

            // $this->model['partner'] = $this->load->model('common/partner');
            // $this->data['partners'] = $this->model['partner']->getRows(array('partner_type_id' => $result['partner_type_id']));

            $this->data['sale_tax_invoice_details'] = $details;


            // $this->data['action_cash_receipt'] = $this->url->link('gl/cash_receipt/insert', 'token=' . $this->session->data['token'] . '&sale_tax_invoice_id='.$this->request->get[$this->getPrimaryKey()] , 'SSL');
            $this->data['action_receipt'] = $this->url->link('gl/receipts/insert', 'token=' . $this->session->data['token'] . '&sale_tax_invoice_id='.$this->request->get[$this->getPrimaryKey()] , 'SSL');
        }

        // d($this->data['ref_documents'],true);

       $this->data['href_get_ref_doc_detail'] = $this->url->link($this->getAlias() . '/getRefDocDetail', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

       $this->data['href_get_job_order_no'] = $this->url->link($this->getAlias() . '/getJobOrderNo', 'token=' . $this->session->data['token'], 'SSL');
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
        
        $this->data['action_print_sales_invoice'] = $this->url->link($this->getAlias() . '/printSalesInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()].'&with_previous_balance=1', 'SSL');
        
        $this->data['action_print_exempted_invoice'] = $this->url->link($this->getAlias() . '/printExemptedInvoice', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()].'&with_previous_balance=1', 'SSL');
        
        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);

        $this->data['url_validate_stock'] = $this->url->link('common/function/getWarehouseStock', 'token=' . $this->session->data['token']);
        
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'customer_name': {'required': true},
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

    // public function validateWarehouseStock()
    // {
    //     $post = $this->request->post;
    //     d($post,true);

    // }

   public function getJobOrderNo()
   {
        $html = '';
        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $document_type = $_POST['document_type'];
        $job_order_id = $_POST['job_order_id'];
        $job_order = $this->model['job_order']->getFilteredRowsForJOE($job_order_id);

        if($document_type == '')
        {
            $html = '<option value="">&nbsp;</option>';
        }
        else
        {
        if($document_type == 'without_reference')
        {
            $html = '<option value="">&nbsp;</option>';
        }
        else
        {   
           if($job_order_id == '')
           {
            $html = '<option value="">&nbsp;</option>';
           }
         foreach($job_order as $job_orders)
         {
          if(!empty($job_order))
          {
           if($job_orders['job_order_id'] == $job_order_id)
           {
               $selected = 'selected';  
           } 
           else
           {
               $selected = '';
           }
           $html.= '<option value="'.$job_orders['job_order_id'].'" '.$selected.'>'.$job_orders['document_identity'].'</option>';
        }
        else
        {
            $html = ''; 
        }
       } 
      }
     }
        $json = array(
            'html' => $html
        );
        echo json_encode($json);
   }

    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];
        $product_type = $this->request->post['t'];


        $this->model['product'] = $this->load->model('inventory/product');
        if($product_type == 'product' || $product_type == 'service')
        {
          $rows = $this->model['product']->getProductJson($search, $page, $product_type);
          echo json_encode($rows);
        }
    }


    public function getRefDocumentJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];
        // $challan_type = 'GST';
        $type = 'sale_tax_invoice';
        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $rows = $this->model['delivery_challan']->getRefDocumentJson($search, $page,$challan_type,$type);
        echo json_encode($rows);
    }


    public function getRefDocumentRecord() {
        $post = $this->request->post;
        $ref_document_id = $post['ref_document_id'];


        $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
        $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
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

        $resultstr = array();
        foreach($DeliveryChallans as $DeliveryChallan)
        {
            $resultstr[] = $DeliveryChallan['document_identity'];
            $PoNo = $DeliveryChallan['po_no'];
            $PoDate = stdDate($DeliveryChallan['po_date']);
//            $PoNo = $row['po_no'];
            $CustomerUnitId = $DeliveryChallan['customer_unit_id'];

            $delivery_challan = $Delivery_Challans[$DeliveryChallan['document_identity']];

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

    public function getRefDocDetail() {
        $job_order_id= $this->request->post['job_order_id'];
        $this->model['job_order_estimate'] = $this->load->model('inventory/job_order_estimate');
        $rows = $this->model['job_order_estimate']->getProductsByEstimate($job_order_id);
        // $this->model['product_issuance'] = $this->load->model('inventory/product_issuance');
        // $rows = $this->model['product_issuance']->getProductsByIssuance($job_order_id);
        // d($rows,true);
        echo json_encode($rows);
    }
    

    protected function insertData($data) {
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['product']= $this->load->model('inventory/product');
        $this->model['setting']= $this->load->model('common/setting');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['document_type'] = $this->load->model('common/document_type');
        $this->model['customer_rate']= $this->load->model('inventory/customer_rate');
        $this_cogs_id = '';
        $inventory_cogs_id = '';
        $revenue_cogs_id = '';
        $outstanding_cogs_id = '';



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

        $job_order_status['repair_status'] = 'CLD';     
        $this->model['job_order']->edit($this->getAlias(), $data['job_order_id'], $job_order_status);

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

            // $this->model['stock'] = $this->load->model('common/stock_ledger');
            // $stock = $this->model['stock']->getWarehouseStock($detail['product_id'], $detail['warehouse_id'], $data['document_identity'], $data['document_date']);

            $detail['sale_tax_invoice_id'] = $sale_tax_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_total'] = $detail['total_amount'] * $data['conversion_rate'];
            $sale_tax_invoice_detail_id = $this->model['sale_tax_invoice_detail']->add($this->getAlias(), $detail);

            $customer_rate = array(
                'company_id' => $detail['company_id'],
                'customer_id' => $data['partner_id'],
                'product_id' => $detail['product_id'],
                'rate' => $detail['rate'],
                'invoice_date' => $data['document_date'],
                'created_at' => date("Y-m-d H:i:s"),
            );

            // Add customer_rate //
            $rate_id = $this->model['customer_rate']->add($this->getAlias(), $customer_rate);
            $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));

            if($detail['product_id'] == '')
            {
                $detail['product_id'] = 'null';
            }
            else
            {
                $detail['product_id'] = $detail['product_id'];

            }

            if($product['cogs_account_id'] == '' || $product['inventory_account_id'] == '' || $product['revenue_account_id'] ||  $outstanding_account_id == '' )
            {

                $this_cogs_id = 'null';
                $inventory_cogs_id = 'null';
                $revenue_cogs_id = 'null';
                $outstanding_cogs_id = 'null';    
            }
            else
            {
                 $this_cogs_id = $product['cogs_account_id'];
                 $inventory_cogs_id = $product['inventory_account_id'];
                 $revenue_account_id = $product['revenue_account_id'];
                 $outstanding_cogs_id = $outstanding_account_id;              
            }

            if($detail['ref_document_type_id'] == 16) {
                // If we are making Invoice through Delivery Challan.
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $gr_ir_account_id,
                    'document_credit' => $detail['cog_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'GRIR Account Debit',
                );


                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    // 'coa_id' => $product['cogs_account_id'],
                     'coa_id' => $this_cogs_id,
                    'document_debit' => $detail['cog_amount'],
                    'document_credit' => 0,
                    'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'credit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'COG Account',
                );          
            
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
                    // 'warehouse_id' => $detail['warehouse_id'],
                    'container_no' => $detail['container_no'],
                    'batch_no' => $detail['batch_no'],
                    'product_id' => $detail['product_id'],
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


                // Add Stock Ledger //
                $stock_ledger_id = $this->model['stock_ledger']->add($this->getAlias(), $stock_ledger);


                 
                // If we are making direct invoice.
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    // 'coa_id' => $product['inventory_account_id'],
                    'coa_id' => $inventory_cogs_id,
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
              }

  
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    // 'coa_id' => $product['cogs_account_id'],
                    'coa_id' => $this_cogs_id,
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
                    'coa_id' => $revenue_cogs_id,
                    // 'coa_id' => $product['revenue_account_id'],
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


        $partner = $this->model['partner']->getRow(array('company_branch_id' => $this->session->data['company_branch_id'], 'partner_type_id' => 2, 'partner_id' => $data['partner_id']));
        $outstanding_account_id = $partner['outstanding_account_id'];
        // d($outstanding_account_id);
        //d(array($data, $partner, $outstanding_account_id), true);

 
        $gl_data[] = array(
            'ref_document_type_id' => $this->document_type_id,
            'ref_document_identity' => $data['document_identity'],
            // 'coa_id' => $outstanding_account_id,
            'coa_id' => $outstanding_cogs_id,
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
      
    
        foreach($gl_data as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
            $ledger['company_branch_id'] = $this->session->data['company_branch_id'];
            $ledger['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $ledger['document_type_id'] = $this->document_type_id;
            $ledger['document_id'] = $sale_tax_invoice_id;
            $ledger['document_identity'] = $data['document_identity'];
            $ledger['document_date'] = $data['document_date'];
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
        $this->generateSms($data);
        return $sale_tax_invoice_id;
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
     $this->model['job_order'] = $this->load->model('inventory/job_order');
     $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'setup',
            'field' => 'sale_invoice_message_box'
        );
        $results = $this->model['setting']->getRow($filter);
        $message_txt = $results['value'];

         $job_order = $this->model['job_order']->getRow(array('job_order_id' => $data['job_order_id']));

         if (strpos($message_txt, "<CN>") || strpos($this_message, "<SIN>") || strpos($message_txt, "<JN>") || strpos($message_txt, "<SINAMT>") ) {
              $this_message = (str_replace('<CN>' , $data['customer_name'] , $message_txt));
              $this_message = (str_replace('<SIN>' , $data['document_identity'] , $this_message));
              $this_message = (str_replace('<JN>' , $job_order['document_identity'] , $this_message));
              $this_message = (str_replace('<SINAMT>' , 'Rs.' . number_format($data['net_amount'],2) , $this_message));
         }
       $mobile = trim($data['mobile']);
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

    protected function updateData($primary_key, $data) {
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['product']= $this->load->model('inventory/product');
        $this->model['setting']= $this->load->model('common/setting');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['customer_rate']= $this->load->model('inventory/customer_rate');

        $this_cogs_id = '';
        $inventory_cogs_id = '';
        $revenue_cogs_id = '';
        $outstanding_cogs_id = '';  

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
        $this->model['document']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'],'document_type_id' => $this->document_type_id, 'document_id' => $primary_key));

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

            $detail['sale_tax_invoice_id'] = $sale_tax_invoice_id;
            $detail['sort_order'] = $sort_order;
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_total'] = $detail['total_amount'] * $data['conversion_rate'];
            $sale_tax_invoice_detail_id = $this->model['sale_tax_invoice_detail']->add($this->getAlias(), $detail);
            
            //d(array($stock_ledger_id, $stock_ledger), true);

            $customer_rate = array(
                'company_id' => $detail['company_id'],
                'customer_id' => $data['partner_id'],
                'product_id' => $detail['product_id'],
                'rate' => $detail['rate'],
                'invoice_date' => $data['document_date'],
                'created_at' => date("Y-m-d H:i:s"),

            );
            // Add customer_rate //
            $rate_id = $this->model['customer_rate']->add($this->getAlias(), $customer_rate);
            $product = $this->model['product']->getRow(array('product_id' => $detail['product_id']));

            if($detail['product_id'] == '')
            {
                $detail['product_id'] = 'null';
            }
            else
            {
                $detail['product_id'] = $detail['product_id'];

            }

            if($product['cogs_account_id'] == '' || $product['inventory_account_id'] == '' || $product['revenue_account_id'] ||  $outstanding_account_id == '' )
            {

                $this_cogs_id = 'null';
                $inventory_cogs_id = 'null';
                $revenue_cogs_id = 'null';
                $outstanding_cogs_id = 'null';    
            }
            else
            {
                 $this_cogs_id = $product['cogs_account_id'];
                 $inventory_cogs_id = $product['inventory_account_id'];
                 $revenue_account_id = $product['revenue_account_id'];
                 $outstanding_cogs_id = $outstanding_account_id;              
            }

            if($detail['ref_document_type_id'] == 16) {
                // If we are making Invoice through Delivery Challan.
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    'coa_id' => $gr_ir_account_id,
                    'document_credit' => $detail['cog_amount'],
                    'document_debit' => 0,
                    'credit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'debit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'GRIR Account Debit',
                );

   
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    // 'coa_id' => $product['cogs_account_id'],
                    'coa_id' => $this_cogs_id,  
                    'document_debit' => $detail['cog_amount'],
                    'document_credit' => 0,
                    'debit' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'credit' => 0,
                    'product_id' => $detail['product_id'],
                    'qty' => $detail['qty'],
                    'document_amount' => $detail['cog_amount'],
                    'amount' => ($detail['cog_amount'] * $data['conversion_rate']),
                    'comment' => 'COG Account',
                );
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
                // 'warehouse_id' => $detail['warehouse_id'],
                'container_no' => $detail['container_no'],
                'batch_no' => $detail['batch_no'],
                'product_id' => $detail['product_id'],
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


                // If we are making direct invoice.
             
     
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    // 'coa_id' => $product['inventory_account_id'],
                    'coa_id' => $inventory_cogs_id,
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
                    // 'coa_id' => $product['cogs_account_id'],
                    'coa_id' => $this_cogs_id, 
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
            }

            if(floatval($detail['amount']) > 0) {
             
                $gl_data[] = array(
                    'document_detail_id' => $sale_tax_invoice_detail_id,
                    'ref_document_type_id' => $detail['ref_document_type_id'],
                    'ref_document_id' => $detail['ref_document_id'],
                    'ref_document_identity' => $detail['ref_document_identity'],
                    //'coa_id' => $gr_ir_account_id,
                    // 'coa_id' => $product['revenue_account_id'],
                    'coa_id' => $revenue_cogs_id,  
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

        $partner = $this->model['partner']->getRow(array('company_branch_id' => $this->session->data['company_branch_id'], 'partner_type_id' => 2, 'partner_id' => $data['partner_id']));
        $outstanding_account_id = $partner['outstanding_account_id'];

        $gl_data[] = array(
            'ref_document_type_id' => $this->document_type_id,
            'ref_document_identity' => $data['document_identity'],
            // 'coa_id' => $outstanding_account_id,
            'coa_id' => $outstanding_cogs_id,  
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

   
public function printSalesInvoice() {


  ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $this->model['user'] = $this->load->model('user/user');
        $this->model['job_order'] = $this->load->model('inventory/job_order');
        $sale_tax_invoice_id = $this->request->get['sale_tax_invoice_id'];
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['company'] = $this->load->model('setup/company_branch');
        $company_address = $this->model['company']->getRow(array('company_id' => $session['company_id']));

        $sale_tax_invoice = $this->model['sale_tax_invoice']->getRow(array('sale_tax_invoice_id' => $sale_tax_invoice_id));


        $sale_tax_invoice_id = $sale_tax_invoice['sale_tax_invoice_id'];
        $document_type = $sale_tax_invoice['document_type'];

        if($document_type == 'with_reference')
        {
            
        $job_order = $this->model['sale_tax_invoice']->getJobOrder(array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        }
        else
        {

         $job_order = $this->model['sale_tax_invoice']->getSaleInvoice(array('sale_tax_invoice_id' => $sale_tax_invoice_id));
        }

         $rows = $this->model['sale_tax_invoice']->getSaleInvoiceDetail(array('sale_tax_invoice_id' => $sale_tax_invoice_id), array('product_type desc'));

        if($job_order['print_date'] == '') {
            $job_order['print_date'] = MySqlDate($data['print_date']);
        } 


        if($job_order['job_order_id']!='' && $sale_tax_invoice['print_date'] == '')
         {
            $job_order['delivery_date'] = $job_order['print_date'];     
            $this->model['job_order']->edit($this->getAlias(), $job_order['job_order_id'], $job_order);

         }
         if($sale_tax_invoice['print_date'] == '' && $sale_tax_invoice['print_date'] == '' || $sale_tax_invoice['print_date'] == null || $sale_tax_invoice['print_date'] == '0000-00-00')
         {
            $sale_tax_invoice['print_date'] = $job_order['print_date'];   
            $this->model['sale_tax_invoice']->edit($this->getAlias(), $sale_tax_invoice['sale_tax_invoice_id'], $sale_tax_invoice);
         }


        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Fahad Siddiqui');
        $pdf->SetTitle('Sales Invoice');
        $pdf->SetSubject('Sales Invoice');

        $pdf->SetMargins(10, 20, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    

        // set auto page breaks
        $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
        // add a page
        $pdf->AddPage();
        // set font

        $warranty = '';
        $receiving_date = '';
        $received_date = '';
        $purchased_date = '';
        $complete_date = '';
        $receipt_date = '';
        $date = '';
        $rday = '';
        $rmonth = '';
        $ryear = '';
        $cday = '';
        $cmonth = '';
        $cyear = '';

        $job_order['warranty'] == 'Y' ? $warranty = 'Yes' : $warranty = 'No'; 
        if($sale_tax_invoice['print_date']!='')
        {
         $job_order['date'] = stdDate($sale_tax_invoice['print_date']);
        }
        $job_order['time'] = date('h:i:s a');


         $pdf->SetFillColor(255,255,255);

        $pdf->SetFont('helvetica', 'B', 13);

        $pdf->SetFillColor(240, 240, 240);  
        $pdf->MultiCell(125, 5, '', 0, 'C', 1, 2,16, 48, true);   
        $pdf->SetFillColor(240, 240, 240);   
        $pdf->MultiCell(95, 5, 'INVOICE NO.', 0, 'R', 1, 2, 110, 48, true);
        $pdf->SetFillColor(240, 240, 240);  
        $pdf->MultiCell(125, 5, '', 0, 'C', 1, 2,16, 52, true); 
        $pdf->MultiCell(95, 5, '', 0, 'R', 1, 2, 110, 52, true);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(125, 5, '', 0, 'C', 1, 2,16, 54, true); 
        $pdf->MultiCell(95, 5, $job_order['invoice_no'], 0, 'R', 1, 2, 110, 54, true);

        $pdf->SetFont('helvetica', 'B', 8);
        if($job_order['job_order_no']!='')
        {

        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(18, 4, 'Job.No.', 0, 'L', 1, 2, 15, 88, true);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell(30, 7, $job_order['job_order_no'], 0, 'L', 1, 2, 40, 88, true);
        }


        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(18, 4, 'Customer:', 0, 'L', 1, 2, 15, 96, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(95, 7, $job_order['customer_name'], 0, 'L', 1, 2, 40, 96, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(35, 7, $job_order['customer_address'], 0, 'L', 1, 2, 40, 104, true);


        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(20, 4, 'Date:', 0, 'L', 1, 2, 80, 66, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(20, 3,  $job_order['date'], 0, 'L', 1, 2, 105, 66, true);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(20, 4, 'TIME.:', 0, 'L', 1, 2, 80, 74, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(20, 3, $job_order['time'], 0, 'L', 1, 2, 105, 74, true);


        if($job_order['warranty_card_no']!='')
        {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(20, 4, 'Wty Card', 0, 'L', 1, 2, 80, 87, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(20, 3, $job_order['warranty_card_no'], 0, 'L', 1, 2, 105, 87, true);
        }


        if($job_order['fault_description']!='')
        {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(30, 4, 'Faulty Description', 0, 'L', 1, 2, 80, 100, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(40, 3,$job_order['fault_description'], 0, 'L', 1, 2, 80, 104, true);
        }


        if($job_order['model']!='')
        {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(25, 4, 'Model No.', 0, 'L', 1, 2, 140, 66, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(25, 7, $job_order['model'], 0, 'L', 1, 2, 140, 70, true);
        }



        if($job_order['product_serial_no']!='')
        {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(25, 4, 'SERIAL', 0, 'L', 1, 2, 140, 74, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(25, 3, $job_order['product_serial_no'], 0, 'L', 1, 2, 140, 78, true);
        }



        if($job_order['warranty']!='')
        {
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(25, 4, 'Wty Status', 0, 'L', 1, 2, 140, 82, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(25, 3, $warranty, 0, 'L', 1, 2, 140, 86, true);
       }


        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(60, 4, 'Extension and cansol No.', 0, 'L', 1, 2, 140, 100, true);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(27, 4, 'Tele.No.', 0, 'L', 1, 2, 140, 104, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->MultiCell(25, 3, $job_order['customer_contact'], 0, 'L', 1, 2, 140, 108, true);



        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(35, 4, 'Quantity', 0, 'L', 1, 2, 15, 125, true);
        $pdf->MultiCell(35, 4, 'Description', 0, 'L', 1, 2, 35, 125, true);
        $pdf->MultiCell(35, 4, 'Amount', 0, 'L', 1, 2, 165, 125, true);

        $total_product_amount = 0;
        $total_service_amount = 0;
        $total_part_amount = 0;
        $total_amount = 0;
        $quantity = 0;
        $sr = 0;
        $height = 0;

          foreach($rows as $key=> $detail) {
            $pdf->SetFillColor(255,255,255);
            $sr++;
            if($detail['product_type'] == 'product')
            {
             $arrprd = strlen($detail['service_name']);     
             $quantity = number_format($detail['qty'],0);
             $total_product_amount+=$detail['amount'];
             if($sr == 1)
             {
                $height = 135;
                $pdf->MultiCell(35, 4, $quantity, 0, 'L', 1, 2, 15, 135, true);
                $pdf->MultiCell(45, 4, html_entity_decode($detail['service_name']), 0, 'L', 1, 2,35,135, true);
                $pdf->MultiCell(35, 4, number_format($detail['amount'],2), 0, 'R', 1, 2, 165, 135, true);
              }
             else
             {
                $height+=8;
                $pdf->MultiCell(35, 4, $quantity, 0, 'L', 1, 2, 15, $height, true);
                $pdf->MultiCell(45, 4, html_entity_decode($detail['service_name']), 0, 'L', 1, 2, 35, $height, true);
                $pdf->MultiCell(35, 4, number_format($detail['amount'],2), 0, 'R', 1, 2, 165, $height, true);     
             }
         }

           if($detail['product_type'] == 'service')
            {
               $arrprd = strlen($detail['service_name']);
               $quantity = number_format(1,0);
               $total_service_amount+=$detail['amount'];
             if($sr == 1)
             {
                $height = 135;
                $pdf->MultiCell(35, 4, $quantity, 0, 'L', 1, 2, 15, 135, true);
                $pdf->MultiCell(45, 4, html_entity_decode($detail['service_name']), 0, 'L', 1, 2, 35, 135, true);
                $pdf->MultiCell(35, 4, number_format($detail['amount'],2), 0, 'R', 1, 2, 165, 135, true);
              }
             else
             {
                $height+=8;
                $pdf->MultiCell(35, 4, $quantity, 0, 'L', 1, 2, 15, $height, true);
                $pdf->MultiCell(45, 4, html_entity_decode($detail['service_name']), 0, 'L', 1, 2, 35, $height, true);
                $pdf->MultiCell(35, 4, number_format($detail['amount'],2), 0, 'R', 1, 2, 165, $height, true);
             }
         }

           if($detail['product_type'] == 'part')
            {
             $arrprd = strlen($detail['part_name']);
             $quantity = number_format($detail['qty'],0);
             $total_part_amount+=$detail['amount'];

             if($sr == 1)
             {
                $height = 135;
                $pdf->MultiCell(35, 4, $quantity, 0, 'L', 1, 2, 15, 135, true);
                $pdf->MultiCell(45, 4, html_entity_decode($detail['part_name']), 0, 'L', 1, 2,35,135, true);
                $pdf->MultiCell(35, 4, number_format($detail['amount'],2), 0, 'R', 1, 2, 165, 135, true);
              }
             else
             {
                $height+=8;
                $pdf->MultiCell(35, 4, $quantity, 0, 'L', 1, 2, 15, $height, true);
                $pdf->MultiCell(45, 4, html_entity_decode($detail['part_name']), 0, 'L', 1, 2,35, $height, true);
                $pdf->MultiCell(35, 4, number_format($detail['amount'],2), 0, 'R', 1, 2, 165, $height, true);
             }
           }

          $total_amount = ($total_product_amount + $total_service_amount + $total_part_amount);  
        }
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(35, 4, 'Rupees', 0, 'L', 1, 2, 15, 210, true);
        $pdf->MultiCell(165, 4, Number2Words(round($total_amount)) . ' ' . 'Only', 0, 'L', 1, 2, 35, 210, true);
        $pdf->MultiCell(35, 4, 'Grand Total', 0, 'L', 1, 2, 150, 210, true);
        $pdf->MultiCell(25, 4,number_format($total_amount,2), 0, 'R', 1, 2, 175, 210, true);

        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(25, 4, 'GST', 0, 'L', 1, 2, 100, 218, true);
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell(25, 4, '-', 0, 'L', 1, 2, 190, 218, true);

        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(25, 4, 'Net Payable', 0, 'L', 1, 2, 100, 226, true);

        $pdf->SetFillColor(240, 240, 240);
        $pdf->MultiCell(25, 4, '', 0, 'R', 1, 2, 170, 226, true);
        $pdf->MultiCell(25, 4, number_format($total_amount,2), 0, 'R', 1, 2, 175, 226, true);


          //Close and output PDF document
        $pdf->Output('Sales invoice - '.$job_order['invoice_no'].'.pdf', 'I');

    }
  
}

class PDF extends TCPDF {
    public $data = array();
    Public $InvoiceCheck;
    //Page header
    public function Header() {
    }

    // Page footer
    public function Footer() {
    }
}

?>