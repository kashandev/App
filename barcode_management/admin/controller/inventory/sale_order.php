<?php

class ControllerInventorySaleOrder extends HController{
    protected $document_type_id = 5;
    protected function getAlias() {
        return 'inventory/sale_order';
    }

    protected function getPrimaryKey() {
        return 'sale_order_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {
        $lang = $this->load->language('inventory/sale_order');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $data = array();
        $aColumns = array('action', 'document_date', 'document_identity', 'partner_type', 'partner_name', 'item_total', 'created_at');

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

            }

            $actions[] = array(
                'text' => $lang['delete'],
                'href' => 'javascript:void(0);',
                'click' => "ConfirmDelete('" . $this->url->link($this->getAlias() . '/delete', 'token=' . $this->session->data['token'] . '&id=' . $aRow[$this->getPrimaryKey()], 'SSL') . "')",
                'btn_class' => 'btn btn-danger btn-xs',
                'class' => 'fa fa-times'
            );


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
                } elseif ($aColumns[$i] == 'created_at') {
                    $row[] = stdDateTime($aRow['created_at']);
                }elseif ($aColumns[$i] == 'document_date') {
                    $row[] = stdDate($aRow['document_date']);
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

        $this->model['image'] = $this->load->model('tool/image');
        $this->data['loader_image'] = (HTTP_SERVER.'/image/loading.gif');
        $this->data['form_key'] = date('YmdHis') . mt_rand(1, 999999);

        $this->model['product'] = $this->load->model('inventory/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']),array('name'));

        $this->model['partner'] = $this->load->model('common/partner');
        $this->data['partners'] = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id'], 'partner_type_id' => 2));
        // d($this->data['partners'],true);

        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencys'] = $this->model['currency']->getRows();

        // $this->model['partner_category'] = $this->load->model('setup/partner_category');
        // $this->data['partner_categorys'] = $this->model['partner_category']->getRows();

        $this->model['project'] = $this->load->model('setup/project');
        $this->data['projects'] = $this->model['project']->getRows(['company_id'=>$this->session->data['company_id']]);

        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->data['units'] = $this->model['unit']->getRows(array('company_id' => $this->session->data['company_id']));
        $arrUnits = $this->model['unit']->getArrays('unit_id','name',array('company_id' => $this->session->data['company_id']));

        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));
        $this->data['arrWarehouses'] = json_encode($this->data['warehouses']);

        $this->model['salesman'] = $this->load->model('setup/salesman');
        $this->data['salesmans'] = $this->model['salesman']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['href_get_ref_document_no'] = $this->url->link($this->getAlias() . '/getReferenceDocumentNos', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_ref_document'] = $this->url->link($this->getAlias() . '/getReferenceDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['href_get_sale_order'] =  $this->url->link($this->getAlias() . '/getData', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";
        $this->data['partner_types'] = $this->session->data['partner_types'];
        $this->data['partner_type_id'] = 2;

        $this->data['document_date'] = stdDate();

        $this->data['operation_types'] = [
            ['operation_type' => 'production', 'name' =>'Production'],
            ['operation_type' => 'stock', 'name' =>'Stock'],
            ['operation_type' => 'purchase', 'name' =>'Purchase']
        ];

        if (isset($this->request->get['sale_order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));
            foreach ($result as $field => $value) {

                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                }elseif ($field == 'po_date') {
                    if($value != ''){
                        $this->data[$field] = stdDate($value);
                    }
                } else {
                    $this->data[$field] = $value;
                }
            }


            $this->model['sale_order_detail'] = $this->load->model('inventory/sale_order_detail');
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $rows = $this->model['sale_order_detail']->getRows(array('sale_order_id' => $this->request->get['sale_order_id']),array('sort_order asc'));
            //d($rows,true);
            foreach($rows as $row_no => $row) {
                $product = $this->model['product_master']->getRow(array('product_master_id' => $row['product_id']));
                $row['model'] = $product['model'];
                $row['brand'] = $product['brand'];
                $this->data['sale_order_details'][$row_no] = $row;
                //$this->data['sale_order_details'][$row_no]['unit'] = $arrUnits[$row['unit_id']];
            }

        }

        $this->data['href_add_record_session'] = $this->url->link($this->getAlias() . '/AddRecordSession', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['href_get_sub_projects'] = $this->url->link($this->getAlias() . '/getSubProjects', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_get_partner_json'] = $this->url->link($this->getAlias() . '/getPartnerJson', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_partner'] = $this->url->link($this->getAlias() . '/getPartner', 'token=' . $this->session->data['token']);

        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_by_code'] = $this->url->link($this->getAlias() . '/getProductByCode', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_product_by_id'] = $this->url->link($this->getAlias() . '/getProductById', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['restrict_out_of_stock'] = $this->session->data['restrict_out_of_stock'];
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_partner'] = $this->url->link($this->getAlias() . '/getPartner', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_json_products_for_sale_order'] = $this->url->link($this->getAlias() . '/getProductJsonForPurchaseOrder', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'partner_id': {'required': true},
                'project_id': {'required': true},
                'sub_project_id': {'required': true},
                'total_qty': {'required': true, 'min':1},
                'total_quantity': {'required': true, 'min':1},
            },
            messages: {
            document_date:{
                remote: 'Invalid Date'
            }}
        }";
                // 'item_total': {'required': true, 'min':1},

        // d($this->data, true);

        $this->response->setOutput($this->render());
    }

    public function AddRecordSession()
    {
        $post = $this->request->post;
        $detail_array = array(
            'sort_order'=> $post['sort_order'],
            'ref_document_type_id' => $post['ref_document_type_id'],
            'ref_document_identity' => $post['ref_document_identity'],
            'product_code' => $post['product_code'],
            'product_master_id' => $post['product_master_id'],
            'product_id' => $post['product_id'],
            'product_name' => $post['product_name'],
            'description' => $post['description'],
            'unit_id' => $post['unit_id'],
            'unit' => $post['unit'],
            'qty' => $post['qty'],
            'utilized_qty' => $post['utilized_qty'],
            'rate' => $post['rate'],
            'amount' => $post['amount'],
            'tax_percent' => $post['tax_percent'],
            'tax_amount' => $post['tax_amount'],
            'net_amount' => $post['net_amount'],

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

    public function getProductJsonForPurchaseOrder()
    {
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


    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $rows = $this->model[$this->getAlias()]->getProductJson($search, $page);

        echo json_encode($rows);
    }

    public function getProductByCode()
    {
        $lang = $this->load->language('inventory/product');
        $post = $this->request->post;
        $where = [];
        $where[] = "`company_id` = '". $this->session->data['company_id'] ."'";
        $where[] = "`product_code` = '". $post['product_code'] ."'";
       // $where[] = "`product_type` = 'Finished Goods'";
        $where[] = "LOWER(`status`) = 'active'";
        $where = implode(' AND ', $where);
        $this->model['product'] = $this->load->model('inventory/product');
        $product = $this->model['product']->getRow($where);
        $json = array();
        if($product)
        {
            $json = [
                'success' => true,
                'post' => $post,
                'where' => $where,
                'product' => $product
            ];
        }
        else
        {
            $json = [
                'success' => false,
                'post' => $post,
                'where' => $where,
                'product' => $product,
                'error' => $lang['error_invalid_product']
            ];
        }
        echo json_encode($json);
        exit(1);
    }

    public function getProductById()
    {
        $lang = $this->load->language('inventory/product');
        $post = $this->request->post;
        $where = [];
        $where[] = "`company_id` = '". $this->session->data['company_id'] ."'";
        $where[] = "`product_id` = '". $post['product_id'] ."'";
        $where[] = "`product_type` = 'Finished Goods'";
        $where[] = "LOWER(`status`) = 'active'";
        $where = implode(' AND ', $where);
        $this->model['product'] = $this->load->model('inventory/product');
        $product = $this->model['product']->getRow($where);
        $json = array();
        if($product)
        {
            $json = [
                'success' => true,
                'post' => $post,
                'where' => $where,
                'product' => $product
            ];
        }
        else
        {
            $json = [
                'success' => false,
                'post' => $post,
                'where' => $where,
                'product' => $product,
                'error' => $lang['error_invalid_product']
            ];
        }
        echo json_encode($json);
        exit(1);
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
        $partner_id = $this->request->post['partner_id'];
        $partner_type_id = $this->request->get['partner_type_id'];

        $this->model['partner'] = $this->load->model('common/partner');
        $partners = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id'], 'partner_type_id' => $partner_type_id));


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

    public function getSubProjects() {
        $project_id = $this->request->post['project_id'];
        $sub_project_id = $this->request->post['sub_project_id'];

        $this->model['sub_project'] = $this->load->model('setup/sub_project');
        $sub_projects = $this->model['sub_project']->getRows(array('company_id' => $this->session->data['company_id'], 'project_id' => $project_id));

        $html = '<option value="">&nbsp;</option>';
        foreach($sub_projects as $sub_project) {
            if( $sub_project['sub_project_id'] == $sub_project_id )
            {
                $html .= '<option value="'.$sub_project['sub_project_id'].'" selected="selected">'.$sub_project['name'].'</option>';
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


    public function getReferenceDocumentNos() {
        $sale_order_id = $this->request->get['sale_order_id'];
        $post = $this->request->post;
        //d(array($sale_order_id, $post), true);

        //Purchase Order
        $this->model['quotation'] = $this->load->model('inventory/quotation');
        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
        $where .= " AND partner_type_id='" . $post['partner_type_id'] . "'";
        $where .= " AND partner_id='" . $post['partner_id'] . "'";
//        $where .= " AND is_post=1";

        $quotations = $this->model['quotation']->getQuotations($where,$sale_order_id);
//        d($quotations, true);
        foreach($quotations as $quotation_id => $quotation) {
            foreach($quotation['products'] as $product_id => $product) {
                if($product['order_qty'] <= $product['utilized_qty']) {
                    unset($quotation['products'][$product_id]);
                }
            }
            if(empty($quotation['products'])) {
                unset($quotations[$quotation_id]);
            }
        }

        $html = "";

        $html .= '<option value="">&nbsp;</option>';
        foreach($quotations as $quotation_id => $quotation) {
            if($quotation['quotation_id']==$post['ref_document_id']) {
                $html .= '<option value="'.$quotation_id.'" selected="true">'.$quotation['document_identity'].'</option>';
            } else {
                $html .= '<option value="'.$quotation_id.'">'.$quotation['document_identity'].'</option>';
            }

        }

//        d($quotation,true);
        $json = array(
            'success' => true,
            'sale_order_id' => $quotation_id,
            'post' => $post,
            'where' => $where,
            'html' => $html
        );

        echo json_encode($json);
    }

    public function getReferenceDocument() {
        $sale_order_id = $this->request->get['sale_order_id'];
        $post = $this->request->post;

        //Purchase Order
        $this->model['quotation'] = $this->load->model('inventory/quotation');
        $where = "company_id=" . $this->session->data['company_id'];
        $where .= " AND company_branch_id='" . $this->session->data['company_branch_id'] . "'";
        $where .= " AND fiscal_year_id=" . $this->session->data['fiscal_year_id'];
        $where .= " AND partner_id='" . $post['partner_id'] . "'";
        $where .= " AND document_identity='" . $post['ref_document_identity'] . "'";

        $quotations = $this->model['quotation']->getQuotations($where,$sale_order_id);
        $quotation = $quotations[$post['ref_document_identity']];
//        d($quotation,true);


        $details = array();
        $row_no = 0;
        foreach($quotation['products'] as $product) {
//            $details[$row_no]['balanced_qty'] = ($product['order_qty'] - $product['utilized_qty']);
            if($product['order_qty'] - $product['utilized_qty'] > 0)
            {
                $href = $this->url->link('inventory/quotation/update', 'token=' . $this->session->data['token'] . '&quotation_id=' . $quotation['quotation_id']);
                $details[$row_no] = $product;
                $details[$row_no]['ref_document_identity'] = $quotation['document_identity'];
                $details[$row_no]['row_identity'] = $quotation['document_identity'].'-'.$product['product_code'];
                $details[$row_no]['href'] = $href;
                $details[$row_no]['balanced_qty'] = ($product['order_qty'] - $product['utilized_qty']);
                $details[$row_no]['utilized_qty'] = ($product['order_qty'] - $product['utilized_qty']);

                $row_no++;
            }
        }

        $quotation['products'] = $details;
        $json = array(
            'success' => true,
            'quotation_id' => '',
            'post' => $post,
            'data' => $quotation,
        );

        echo json_encode($json);
    }

    protected function insertData($data){

        $form_key = $data['form_key'];
        $data['sale_order_details'] = $this->session->data['detail'][$form_key];

        $this->model['document_type'] = $this->load->model('common/document_type');
        $document = $this->model['document_type']->getNextDocument($this->document_type_id);

        if($data['po_date'] != '') {
            $data['po_date'] = MySqlDate($data['po_date']);
        } else {
            $data['po_date'] = NULL;
        }

        $data['document_date'] = MySqlDate($data['document_date']);
        $data['company_id'] = $this->session->data['company_id'];
        $data['company_branch_id'] = $this->session->data['company_branch_id'];
        $data['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $data['document_type_id'] = $this->document_type_id;
        $data['document_prefix'] = $document['document_prefix'];
        $data['document_no'] = $document['document_no'];
        $data['document_identity'] = $document['document_identity'];
        $data['base_amount'] = $data['item_total'] * $data['conversion_rate'];


        $sale_order_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] =$sale_order_id;
        $this->model['document'] = $this->load->model('common/document');

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

        $this->model['sale_order_detail'] = $this->load->model('inventory/sale_order_detail');

      //  d($data,true);
        foreach ($data['sale_order_details'] as $sort_order =>$detail){
            $detail['sale_order_id'] = $sale_order_id;
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['ref_document_type_id'] = $data['document_type_id'];
            $detail['ref_document_identity'] = $data['document_identity'];
            $detail['sort_order'] = $sort_order;
            $sale_order_detail_id = $this->model['sale_order_detail']->add($this->getAlias(), $detail);
        }

        unset($this->session->data['detail'][$form_key]);
        return $sale_order_id;
    }

    protected function updateData($primary_key, $data) {

        $form_key = $data['form_key'];
        $data['sale_order_details'] = $this->session->data['detail'][$form_key];

        $sale_order_id = $primary_key;
        $data['document_date'] = MySqlDate($data['document_date']);
        $this->model['sale_order'] = $this->load->model('inventory/sale_order');
        $this->model['sale_order_detail'] = $this->load->model('inventory/sale_order_detail');

        if($data['po_date'] != '') {
            $data['po_date'] = MySqlDate($data['po_date']);
        } else {
            $data['po_date'] = NULL;
        }

        $this->model['sale_order']->edit($this->getAlias(), $primary_key, $data);
        $this->model['sale_order_detail']->deleteBulk($this->getAlias(), array('sale_order_id' => $sale_order_id));

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $sale_order_id));
        $insert_document = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'document_type_id' => $this->document_type_id,
            'document_id' => $sale_order_id,
            'document_identity' => $data['document_identity'],
            'document_date' => $data['document_date'],
            'partner_type_id' => $data['partner_type_id'],
            'partner_id' => $data['partner_id'],
            'document_currency_id' => $data['document_currency_id'],
            'document_amount' => $data['net_amount'],
            'conversion_rate' => $data['conversion_rate'],
            'base_currency_id' => $data['base_currency_id'],
            'base_amount' => ($data['item_total'] * $data['conversion_rate']),
        );
        $document_id = $this->model['document']->add($this->getAlias(), $insert_document);

        foreach ($data['sale_order_details'] as $sort_order => $detail) {
            $detail['sale_order_id'] = $sale_order_id;
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['ref_document_type_id'] = $data['document_type_id'];
            $detail['ref_document_identity'] = $data['document_identity'];
            $detail['sort_order'] = $sort_order;
            $sale_order_detail_id=$this->model['sale_order_detail']->add($this->getAlias(), $detail);
        }

        unset($this->session->data['detail'][$form_key]);
        return $sale_order_id;
    }


    protected function deleteData($primary_key) {
        $this->db->beginTransaction();
        $this->model['sale_order_detail'] = $this->load->model('inventory/sale_order_detail');
        $this->model['sale_order_detail']->deleteBulk($this->getAlias(),array('sale_order_id' => $primary_key));

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));

        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $primary_key));


        $this->model[$this->getAlias()]->delete($this->getAlias(), $primary_key);
        $this->db->commit();
    }

    protected function validateDelete($id)
    {
        if (!$this->user->hasPermission('delete', $this->getAlias())) {
            $this->error['warning'][] = $this->language->get('error_permission_delete');
        } else {
            $row = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $id));
            // d($row, true);
            $this->model['delivery_challan'] = $this->load->model('inventory/delivery_challan');
            $rows = $this->model['delivery_challan']->getRows(array('ref_document_identity' => $row['document_identity']));
            // d($rows, true);
            if(count($rows) > 0) {
                $this->error['warning'][] = sprintf("Cannot Delete `%s`. Sale Order is in use.", $row['document_identity']);
            }
        }

        // d($this->error, true);

        if (!$this->error) {
            //d($this->error, true);
            return true;
        } else {
            $this->session->data['warning'] = implode('<br />', $this->error['warning']);
            return false;
        }
    }


    public function post() {
        $lang = $this->load->language($this->getAlias());
        if (!$this->user->hasPermission('post', $this->getAlias())) {
            $this->session->data['error_warning'] = $lang['error_permission_post'];
        } else {

            $this->db->beginTransaction();
            $this->model['sale_order'] = $this->load->model('inventory/sale_order');
            $this->model['sale_order_detail'] = $this->load->model('inventory/sale_order_detail');

            // $where = [];
            // $where[] = "`company_id` = '". $this->session->data['company_id'] ."'";
            // $where[] = "`company_branch_id` = '". $this->session->data['company_branch_id'] ."'";
            // $where[] = "`fiscal_year_id` = '". $this->session->data['fiscal_year_id'] ."'";
            // $where[] = "`sale_order_id` = '". $this->request->get[$this->getPrimaryKey()] ."'";
            // $where = implode(' AND ', $where);
            // $row = $this->model['sale_order']->getRow($where);

            // $where = [];
            // $where[] = "`company_id` = '". $this->session->data['company_id'] ."'";
            // $where[] = "`company_branch_id` = '". $this->session->data['company_branch_id'] ."'";
            // $where[] = "`fiscal_year_id` = '". $this->session->data['fiscal_year_id'] ."'";
            // $where[] = "`sale_order_id` = '". $this->request->get[$this->getPrimaryKey()] ."'";
            // //$where[] = "`operation_type` = 'production'";

            // $where = implode(' AND ', $where);
            // $details = $this->model['sale_order_detail']->getRows($where);

            // if($details)
            // {

            //     //$this->model['bom'] = $this->load->model('production/bom');
            //     $data = array();

            //     foreach ($details as $detail) {

            //         // $where = [];
            //         // $where[] = "`company_id` = '". $this->session->data['company_id'] ."'";
            //         // $where[] = "`company_branch_id` = '". $this->session->data['company_branch_id'] ."'";
            //         // $where[] = "`fiscal_year_id` = '". $this->session->data['fiscal_year_id'] ."'";
            //         // $where[] = "`product_id` = '". $detail['product_id'] ."'";
            //         // $where = implode(' AND ', $where);
            //         // $bom = $this->model['bom']->getRow($where);

            //         $data['ref_document_type_id'] = $row['document_type_id'];
            //         $data['ref_document_identity'] = $row['document_identity'];
            //         $data['sale_order_id'] = $row['sale_order_id'];
            //         $data['sale_order_detail_id'] = $detail['sale_order_detail_id'];
            //         $data['project_id'] = $row['project_id'];
            //         $data['sub_project_id'] = $row['sub_project_id'];
            //         $data['product_id'] = $detail['product_id'];
            //         //$data['bom_id'] = $bom['bom_id'];
            //         $data['qty'] = $detail['qty'];
            //         $objJobOrder->addJobOrder($data);
            //     }
            // }

            $data = array(
                'is_post' => 1,
                'post_date' => date('Y-m-d H:i:s'),
                'post_by_id' => $this->session->data['user_id']
            );
            $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
            $this->model[$this->getAlias()]->edit($this->getAlias(),$this->request->get[$this->getPrimaryKey()],$data);

            $this->model['document'] = $this->load->model('common/document');
            $this->model['document']->edit($this->getAlias(),$this->request->get[$this->getPrimaryKey()],$data);

            $this->db->commit();
        }

        $this->redirect($this->url->link($this->getAlias(), 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL'));
    }
// function get_num_of_words($string) {
//       $string = preg_replace('/\s+/', ' ', trim($string));
//       $words = explode(" ", $string);
//       return count($words);
// }
  

    public function printDocument() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);
        $lang = $this->load->language($this->getAlias());
        $Sale_Order_Id = $this->request->get['sale_order_id'];
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['company'] = $this->load->model('setup/company');
        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['sale_order'] = $this->load->model('inventory/sale_order');
        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->model['sale_order_detail'] = $this->load->model('inventory/sale_order_detail');


        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));
        $SaleOrder = $this->model['sale_order']->getRow(array('sale_order_id' => $Sale_Order_Id));
        $SaleOrderDetails = $this->model['sale_order_detail']->getRows(array('sale_order_id' => $Sale_Order_Id),array('sort_order asc'));
        $Partner = $this->model['partner']->getRow(array('partner_type_id' => $SaleOrder['partner_type_id'],'partner_id' => $SaleOrder['partner_id']));



//        d($this->data['company_footer'],true);
//        $this->model['image'] = $this->load->model('tool/image');
//        $this->data['company_footer'] = $this->model['image']->resize('footer.jpeg',200,50);

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf->footer = HTTP_IMAGE.'footer.jpeg';
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Aamir Shakil');
        $pdf->SetTitle('Sale Order');
        $pdf->SetSubject('Sale Order');

        
    
        //Set Header
        // d($branch['address']);
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'company_branch_name' => $session['company_branch_name'],
            'company_address' => $branch['address'],
            'company_phone' => $branch['phone_no'],
            'report_name' => 'Sale Order',
            'company_logo' => $session['company_image'],
            'header_image' => HTTP_IMAGE.'header.jpg',
            'footer_image' => HTTP_IMAGE.'footer.jpg'
        );

        // d($SaleOrderDetails);

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 48, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(2);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 65);

        // set font
        $pdf->SetFont('helvetica', 'B', 10);

        // add a page
        $pdf->AddPage();

        $pdf->SetTextColor(0,0,0);
       $pdf->Ln(-20);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(120,7, 'M/s. '.html_entity_decode($Partner['name']), 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(25, 7, 'Document No :', 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(45, 7, $SaleOrder['document_identity'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(7);
        $pdf->Cell(120,7, '', 'B', false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 7, 'Date :', 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(45, 7, stdDate($SaleOrder['document_date']), 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(7);
        $addres = splitString($Partner['address'],86);
        // d($addres,true);
        $pdf->Cell(120,7, $addres[0], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 7, 'Po No :', 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(45, 7, $SaleOrder['po_no'], 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        $pdf->Ln(7);
        $pdf->Cell(120,7, $addres[1], 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(5, 7, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(25, 7, 'Po Date :', 'B', false, 'L', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(45, 7, stdDate($SaleOrder['po_date']), 'B', false, 'L', 0, '', 0, false, 'M', 'M');

        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(8, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(55, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(17, 7, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(17, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(17, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(18, 7, 'Tax %', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, 'Tax Amt', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(23, 7, 'Net Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');

        $sr = 0;
        $pdf->Ln(7);

        $Amount = 0;
        $taxAmount = 0;
        $NetAmount = 0;

        $pdf->SetFont('helvetica', '', 8);
        
        foreach($SaleOrderDetails as $detail) {

            //$Unit = $this->model['unit']->getRow(array('unit_id' => $detail['unit_id']));

            $sr++;
       
            $product_desc = $detail['description'];
            if (strlen($product_desc) <= 33 ) {
            $pdf->Cell(8, 7, $sr, 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(55, 7, $product_desc, 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, $detail['qty'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, $detail['unit'], 'L', false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, $detail['rate'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 7, number_format($detail['tax_percent'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['tax_amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(23, 7, number_format($detail['net_amount'],2), 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->ln(7);

            }else

            $product_descArr = splitString($product_desc, 33);
            foreach($product_descArr as $index => $dataname){

                if($index == 0){
            $pdf->Cell(8, 7, $sr, 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(55, 7, $dataname, 'L', false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, $detail['qty'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, $detail['unit'], 'L', false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(17, 7, $detail['rate'], 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(18, 7, number_format($detail['tax_percent'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, number_format($detail['tax_amount'],2), 'L', false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(23, 7, number_format($detail['net_amount'],2), 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');

                }elseif ($index == count($product_descArr)-1) {
                    $pdf->Cell(8, 7, '', 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(55, 7, $dataname, 'L', false, 'L', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(17, 7, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(17, 7,'', 'L', false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(17, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(18, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(23, 7, '', 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');
                }  else{
                    // d($dataname);
                    $pdf->Cell(8, 7, '', 'L',  false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(55, 7, $dataname, 'L', false, 'L', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(17, 7, '', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(17, 7,'', 'L', false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(17, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(18, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7,'', 'L', false, 'R', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(23, 7, '', 'L,R', false, 'R', 0, '', 0, false, 'M', 'M');
                }
                    $pdf->ln(7);

            }
            $Amount+=$detail['amount'];
            $taxAmount+=$detail['tax_amount'];
            $NetAmount+=$detail['net_amount'];

        }

        $pdf->ln(-4);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        for ($i = $y; $i <= 200; $i++) {

            $pdf->Ln(1);
            $pdf->Cell(8, 8,'', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(55, 8, '', 'L', false, 'L', 0, '', 1);
            $pdf->Cell(17, 8, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(17, 8, '', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(17, 8, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(20, 8, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(18, 8, '', 'L', false, 'C', 0, '', 1);
            $pdf->Cell(20, 8, '', 'L', false, 'R', 0, '', 1);
            $pdf->Cell(23, 8, '', 'L,R', false, 'R', 0, '', 1);
            $y =$i;
        }
        $pdf->Ln(-1);
        $pdf->Ln(5);
        $pdf->Cell(195, 8, '', 'B', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->setXY($x,$y);
        $pdf->Ln(13);
        $pdf->Cell(114, 7, '', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, number_format($Amount,2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(18, 7, '', 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(20, 7, number_format($taxAmount,2), 1, false, 'R', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(23, 7, number_format($NetAmount,2), 1, false, 'R', 0, '', 0, false, 'M', 'M');

        //Close and output PDF document

        $pdf->Output('Sale Order :'.date('YmdHis').'.pdf', 'I');
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
//            $this->Ln(4);
//        }
//        $this->SetTextColor(0,0,0);
//        $this->Cell(0, 4, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $this->Image($this->data['header_image'], 0, 5, 205, "", "JPG", "", "T", false, 300, "", false, false, 0, false, false, false);
        $this->Ln(5);
        $this->SetFont('times', 'B,I', 14);
        $this->Cell(0, 10, html_entity_decode($this->data['company_branch_name']), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(6);
        $this->SetFont('times', 'B,I', 12);
        $this->Cell(0, 4, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Page footer
    public function Footer() {

    }


}

?>