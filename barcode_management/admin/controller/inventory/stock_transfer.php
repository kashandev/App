<?php

class ControllerInventoryStockTransfer extends HController {
    protected $document_type_id = 25;

    protected function getAlias() {
        return 'inventory/stock_transfer';
    }

    protected function getPrimaryKey() {
        return 'stock_transfer_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {
        $lang = $this->load->language('inventory/stock_transfer');
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $data = array();
        $aColumns = array('action', 'document_date', 'document_identity', 'warehouse', 'total_qty', 'created_at', 'check_box');

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

        $this->model['product'] = $this->load->model('inventory/product');
        // $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['currency'] = $this->load->model('setup/currency');
        $this->data['currencys'] = $this->model['currency']->getRows();

        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->data['units'] = $this->model['unit']->getRows(array('company_id' => $this->session->data['company_id']));
        $arrUnits = $this->model['unit']->getArrays('unit_id','name',array('company_id' => $this->session->data['company_id']));

        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['FromWarehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));

        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));
        //d($this->data['warehouses'],true);
        $this->model['customer'] = $this->load->model('setup/customer');
        // $this->data['partners'] = $this->model['customer']->getRows(array('company_id' => $this->session->data['company_id'], 'customer_id' => 'ce45eb2c-6cf1-46ac-93d2-8a050b0cf051'),array('name'));

        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->data['company_branchs'] = $this->model['company_branch']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['base_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['base_currency'] = $this->session->data['base_currency_name'];
        $this->data['document_currency_id'] = $this->session->data['base_currency_id'];
        $this->data['conversion_rate'] = "1.00";

        $this->data['document_date'] = stdDate();
        if (isset($this->request->get['stock_transfer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->data['isEdit'] = 1;
            $result = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));
            foreach ($result as $field => $value) {
                if ($field == 'document_date') {
                    $this->data[$field] = stdDate($value);
                } elseif($field=='billty_date') {
                    $this->data[$field] = stdDate($value);
                }else {
                    $this->data[$field] = $value;
                }
            }

            $this->model['stock_transfer_detail'] = $this->load->model('inventory/stock_transfer_detail');
            $rows = $this->model['stock_transfer_detail']->getRows(array('stock_transfer_id' => $this->request->get['stock_transfer_id']),array('sort_order'));
            $this->model['stock_history'] = $this->load->model('common/stock_ledger_history');
           foreach($rows as $row_no => $row) {
                
                $filter = [];
                $filter[] = "`company_id` = '{$this->session->data['company_id']}'";
                $filter[] = "`company_branch_id` = '{$this->session->data['company_branch_id']}'";
                $filter[] = "`fiscal_year_id` = '{$this->session->data['fiscal_year_id']}'";
                $filter[] = "`document_date` <= '{$result['document_date']}'";
                $filter[] = "`document_identity` != '{$result['document_identity']}'";
                $filter[] = "`serial_no` = '{$row['serial_no']}'";
                $filter[] = "`warehouse_id` = '{$result['warehouse_id']}'";
                $filter = implode(' AND ', $filter);
                // d($filter, true);
                $stock_history = $this->model['stock_history']->getStock($filter);
                // d($stock_history, true);

                $row['stock_qty'] = $stock_history['stock_qty'];
                $row['cog_rate']    = $stock_history['avg_stock_rate'];
                $row['cog_amount']  = $stock_history['stock_amount'];
                $this->data['stock_transfer_details'][$row_no] = $row;
           }

        }

        $this->data['href_get_json_products'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_un_post'] = $this->url->link($this->getAlias() . '/Unpost', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['get_warehouse_by_branch'] = $this->url->link($this->getAlias() . '/getWarehouseByBranch', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['href_get_container_data'] = $this->url->link($this->getAlias() . '/getContainerData', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_post'] = $this->url->link($this->getAlias() . '/post', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');
        $this->data['action_print'] = $this->url->link($this->getAlias() . '/printDocument', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['strValidation'] = "{
            'rules': {
                'document_date': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'partner_id': {'required': true},
                'warehouse_id': {'required': true},
                'total_qty': {'required': true, 'min':1}
            },
            'ignore': []
        }";

        $this->response->setOutput($this->render());
    }

    public function getProductJson()
    {
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['product'] = $this->load->model('inventory/product');
        $filter = [];
        $filter[] = "p.company_id = '". $session['company_id'] ."'";
        $filter[] = "(p.product_type = 'Raw Material' OR p.product_type = 'Finished Goods')";
        $filter[] = "LOWER(`p`.`status`) = 'active'";
        $filter[] = "LOWER(`p`.`tracing_type`) = 'traceable'";
        $filter = implode(' AND ', $filter);
        $options = $this->model['product']->getOptionList($post['q'], $filter, ['p.name']);
        $items = [];
        foreach($options['items'] as $row) {
            $items[] = [
                'id' => $row['product_id'],
                // 'text' => $row['name'],
                'text' => $row['product_code'].' - '.$row['name'],
                'description' => $row['description'],
                'product_code' => $row['product_code'],
                'category_id' => $row['category_id'],
                'sub_category_id' => $row['sub_category_id'],
                'unit_id' => $row['unit_id'],
                'unit' => $row['unit'],
                'charge_unit_id' => $row['charge_unit_id'],
                'charge_unit' => $row['charge_unit'],
                'calc_weight' => $row['calc_weight'],
                'width' => $row['width'],
                'length' => $row['length'],
                'thickness' => $row['thickness'],
                'dia' => $row['dia'],
                'type_of_material' => $row['type_of_material']
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

    public function getWarehouseByBranch() {
        $post = $this->request->post;
        $Company_branch_id = $post['company_branch_id'];
        $this->model['warehouse'] = $this->load->model('inventory/warehouse');

        // commented this because of client's requirements
        // $rows = $this->model['warehouse']->getRows(array('company_branch_id' => $Company_branch_id));
        $rows = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));

        // $this->data['warehouse'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id']));

        // $html = '';
        // $html .= '<option value="">&nbsp;</option>';
        // foreach($rows as $row) {
        //     $html .= '<option value="'.$row['warehouse_id'].'">'.$row['name'].'</option>';
        // }
        $json = array(
            'success' => true,
            'warehouses' => $rows
        );
//d($json,true);
        echo json_encode($json);
    }

    public function getContainerData() {
        $post = $this->request->post;
        $warehouse_id = $post['warehouse_id'];
        $container_no = $post['container_no'];
        $this->model['stock'] = $this->load->model('common/stock_ledger');
        $details = $this->model['stock']->getBalanceContainerStocks($container_no, $warehouse_id);
        $json = array(
            'success' => true,
            'details' => $details
        );

        echo json_encode($json);
    }

    protected function insertData($data) {

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

        if($data['billty_date'] != '') {
            $data['billty_date'] = MySqlDate($data['billty_date']);
        } else {
            $data['billty_date'] = NULL;
        }

        $data['base_amount'] = $data['total_amount'] * $data['conversion_rate'];
        $data['partner_type_id'] = 2;

        $stock_transfer_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        $data['document_id'] = $stock_transfer_id;


        $this->model['stock_transfer_detail'] = $this->load->model('inventory/stock_transfer_detail');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['customer'] = $this->load->model('setup/customer');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');

        $Customers = $this->model['customer']->getRow(array('customer_id' => $data['partner_id']));

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
        $stock_ledger = array();



        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $Current_Company_Branch = $this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id'],'company_branch_id' => $this->session->data['company_branch_id']));
        $To_Company_Branch = $this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id'],'company_branch_id' => $data['to_branch_id']));

        foreach ($data['stock_transfer_details'] as $sort_order => $detail) {

            $detail['stock_transfer_id'] = $stock_transfer_id;
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['sort_order'] = $sort_order;
            $detail['to_company_branch_id'] = $data['to_branch_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_cog_rate'] = ($detail['cog_rate'] * $data['conversion_rate']);
            $detail['base_cog_amount'] = ($detail['cog_amount'] * $data['conversion_rate']);
            $stock_transfer_detail_id=$this->model['stock_transfer_detail']->add($this->getAlias(), $detail);


            $stock_ledger[] = array(
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $data['warehouse_id'],
                'container_no' => $detail['container_no'],
                'batch_no' => $detail['batch_no'],
                'product_id' => $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => $detail['qty'],
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => (-1 * $detail['qty']),
                'document_rate' => $detail['cog_rate'],
                'document_amount' => (-1 * $detail['cog_amount']),
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * $detail['cog_amount'] * $detail['conversion_rate']),
                'remarks' => $data['remarks'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                // 'weight' => -1 * $detail['calc_weight']
            );

            // $this->model['warehouse'] = $this->load->model('inventory/warehouse');
            // $warehouse = $this->model['warehouse']->getRow(array('warehouse_id' => $detail['warehouse_id']));

            $stock_ledger[] = array(
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'container_no' => $detail['container_no'],
                'batch_no' => $detail['batch_no'],
                'product_id' => $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => $detail['qty'],
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => ($detail['qty']),
                'document_rate' => $detail['cog_rate'],
                'document_amount' => ($detail['cog_amount']),
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => ($detail['cog_amount'] * $detail['conversion_rate']),
                'remarks' => $data['remarks'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                // 'weight' => $detail['calc_weight']
            );

            // For Ledger //
            $stock_ledger_history = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $this->document_type_id,
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $data['warehouse_id'],
                'product_id' => $detail['product_id'],
                'product_master_id' =>  $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => 1,
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' =>  (-1 * $detail['qty']),
                'document_currency_id' => $detail['document_currency_id'],
                'document_rate' => ($detail['cog_rate']),
                'document_amount' => (-1 * ($detail['qty'] * $detail['cog_rate'])),
                'currency_conversion' => $data['conversion_rate'],
                'base_currency_id' => $data['base_currency_id'],
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * ($detail['qty'] * $detail['cog_rate'] * $detail['conversion_rate'])),
                'batch_no' => $detail['batch_no'],
                'serial_no' => $detail['serial_no'],
            );

            $stock_ledger_history_id = $this->model['stock_ledger_history']->add($this->getAlias(), $stock_ledger_history);

            // For Ledger //
            $stock_ledger_history = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $this->document_type_id,
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'product_id' => $detail['product_id'],
                'product_master_id' =>  $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => 1,
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' =>  ($detail['qty']),
                'document_currency_id' => $detail['document_currency_id'],
                'document_rate' => ($detail['cog_rate']),
                'document_amount' => (($detail['qty'] * $detail['cog_rate'])),
                'currency_conversion' => $data['conversion_rate'],
                'base_currency_id' => $data['base_currency_id'],
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (($detail['qty'] * $detail['cog_rate'] * $detail['conversion_rate'])),
                'batch_no' => $detail['batch_no'],
                'serial_no' => $detail['serial_no'],
            );

            $stock_ledger_history_id2 = $this->model['stock_ledger_history']->add($this->getAlias(), $stock_ledger_history);


        }

//        d(array($data,$detail,$stock_ledger,$gl_data,$ToBranch),true);
        // d($stock_ledger, true);
        foreach($stock_ledger as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
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
        }

        return $stock_transfer_id;
    }

    protected function insertRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&stock_transfer_id=' . $id, 'SSL'));
    }

    protected function updateData($primary_key, $data) {
        $stock_transfer_id = $primary_key;
        $data['document_date'] = MySqlDate($data['document_date']);
        $data['partner_type_id'] = 2;

        $this->model['stock_transfer'] = $this->load->model('inventory/stock_transfer');
        $this->model['stock_transfer_detail'] = $this->load->model('inventory/stock_transfer_detail');
        $this->model['document'] = $this->load->model('common/document');
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['customer'] = $this->load->model('setup/customer');
        $this->model['ledger'] = $this->load->model('gl/ledger');
        $this->model['stock_ledger'] = $this->load->model('common/stock_ledger');
        $this->model['stock_ledger_history'] = $this->load->model('common/stock_ledger_history');

        if($data['billty_date'] != '') {
            $data['billty_date'] = MySqlDate($data['billty_date']);
        } else {
            $data['billty_date'] = NULL;
        }


        $this->model['stock_transfer']->edit($this->getAlias(), $primary_key, $data);
        $this->model['stock_transfer_detail']->deleteBulk($this->getAlias(), array('stock_transfer_id' => $stock_transfer_id));
        $this->model['document']->deleteBulk($this->getAlias(), array('document_id' => $stock_transfer_id));
        $this->model['ledger']->deleteBulk($this->getAlias(), array('document_id' => $stock_transfer_id));
        $this->model['stock_ledger']->deleteBulk($this->getAlias(), array('document_id' => $stock_transfer_id));
        $this->model['stock_ledger_history']->deleteBulk($this->getAlias(), array('document_type_id' => $this->document_type_id,'document_id' => $stock_transfer_id));


        $Customers = $this->model['customer']->getRow(array('customer_id' => $data['partner_id']));

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
        $stock_ledger = array();


        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $Current_Company_Branch = $this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id'],'company_branch_id' => $this->session->data['company_branch_id']));
        $To_Company_Branch = $this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id'],'company_branch_id' => $data['to_branch_id']));
        $Current_branch_account_id = $Current_Company_Branch['branch_account_id'];
        $To_branch_account_id = $To_Company_Branch['branch_account_id'];


        foreach ($data['stock_transfer_details'] as $sort_order => $detail) {
            $detail['stock_transfer_id'] = $stock_transfer_id;
            $detail['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
            $detail['company_branch_id'] = $this->session->data['company_branch_id'];
            $detail['company_id'] = $this->session->data['company_id'];
            $detail['sort_order'] = $sort_order;
            $detail['to_company_branch_id'] = $data['to_branch_id'];
            $detail['document_currency_id'] = $data['document_currency_id'];
            $detail['base_currency_id'] = $data['base_currency_id'];
            $detail['conversion_rate'] = $data['conversion_rate'];
            $detail['base_cog_rate'] = ($detail['cog_rate'] * $data['conversion_rate']);
            $detail['base_cog_amount'] = ($detail['cog_amount'] * $data['conversion_rate']);
            $stock_transfer_detail_id=$this->model['stock_transfer_detail']->add($this->getAlias(), $detail);



            $stock_ledger[] = array(
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $data['warehouse_id'],
                'container_no' => $detail['container_no'],
                'batch_no' => $detail['batch_no'],
                'product_id' => $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => $detail['qty'],
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => (-1 * $detail['qty']),
                'document_rate' => $detail['cog_rate'],
                'document_amount' => (-1 * $detail['cog_amount']),
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * $detail['cog_amount'] * $detail['conversion_rate']),
                'remarks' => $data['remarks'],
                'company_branch_id' => $this->session->data['company_branch_id'],
            );
            $stock_ledger[] = array(
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'container_no' => $detail['container_no'],
                'batch_no' => $detail['batch_no'],
                'product_id' => $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => $detail['qty'],
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' => ($detail['qty']),
                'document_rate' => $detail['cog_rate'],
                'document_amount' => ($detail['cog_amount']),
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => ($detail['cog_amount'] * $detail['conversion_rate']),
                'remarks' => $data['remarks'],
                'company_branch_id' => $this->session->data['company_branch_id'],
            );

            // For Ledger //
            $stock_ledger_history = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $this->document_type_id,
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $data['warehouse_id'],
                'product_id' => $detail['product_id'],
                'product_master_id' =>  $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => 1,
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' =>  (-1 * $detail['qty']),
                'document_currency_id' => $detail['document_currency_id'],
                'document_rate' => ($detail['cog_rate']),
                'document_amount' => (-1 * ($detail['qty'] * $detail['cog_rate'])),
                'currency_conversion' => $data['conversion_rate'],
                'base_currency_id' => $data['base_currency_id'],
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (-1 * ($detail['qty'] * $detail['cog_rate'] * $detail['conversion_rate'])),
                'batch_no' => $detail['batch_no'],
                'serial_no' => $detail['serial_no'],
            );

            $stock_ledger_history_id = $this->model['stock_ledger_history']->add($this->getAlias(), $stock_ledger_history);

            // For Ledger //
            $stock_ledger_history = array(
                'company_id' => $detail['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $detail['fiscal_year_id'],
                'document_type_id' => $this->document_type_id,
                'document_id' => $data['document_id'],
                'document_identity' => $data['document_identity'],
                'document_date' => $data['document_date'],
                'document_detail_id' => $stock_transfer_detail_id,
                'warehouse_id' => $detail['warehouse_id'],
                'product_id' => $detail['product_id'],
                'product_master_id' =>  $detail['product_master_id'],
                'document_unit_id' => $detail['unit_id'],
                'document_qty' => 1,
                'unit_conversion' => 1,
                'base_unit_id' => $detail['unit_id'],
                'base_qty' =>  ($detail['qty']),
                'document_currency_id' => $detail['document_currency_id'],
                'document_rate' => ($detail['cog_rate']),
                'document_amount' => (($detail['qty'] * $detail['cog_rate'])),
                'currency_conversion' => $data['conversion_rate'],
                'base_currency_id' => $data['base_currency_id'],
                'base_rate' => ($detail['cog_rate'] * $detail['conversion_rate']),
                'base_amount' => (($detail['qty'] * $detail['cog_rate'] * $detail['conversion_rate'])),
                'batch_no' => $detail['batch_no'],
                'serial_no' => $detail['serial_no'],
            );

            $stock_ledger_history_id2 = $this->model['stock_ledger_history']->add($this->getAlias(), $stock_ledger_history);


        }

        foreach($stock_ledger as $sort_order => $ledger) {
            $ledger['company_id'] = $this->session->data['company_id'];
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
        }

        return $stock_transfer_id;
    }

    protected function updateRedirect($id, $data) {
        $url = $this->getURL();
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'] . '&stock_transfer_id=' . $id, 'SSL'));
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

    public function Unpost() {

        $lang = $this->load->language($this->getAlias());
//        if (!$this->user->hasPermission('post', $this->getAlias())) {
//            $this->session->data['error_warning'] = $lang['error_permission_post'];
//        } else {

        $data = array(
            'is_post' => 0,
            'post_date' => date('Y-m-d H:i:s'),
            'post_by_id' => $this->session->data['user_id']
        );
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $this->model[$this->getAlias()]->edit($this->getAlias(),$this->request->get[$this->getPrimaryKey()],$data);

        $this->model['document'] = $this->load->model('common/document');
        $this->model['document']->edit($this->getAlias(),$this->request->get[$this->getPrimaryKey()],$data);

        //    }

        $this->redirect($this->url->link($this->getAlias(), 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $this->request->get[$this->getPrimaryKey()], 'SSL'));
    }

    protected function deleteData($primary_key) {
        $this->model['stock_transfer_detail'] = $this->load->model('inventory/stock_transfer_detail');
        $this->model['stock_transfer_detail']->deleteBulk($this->getAlias(),array('stock_transfer_id' => $primary_key));

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
        $lang = $this->load->language('inventory/stock_transfer');
        $error = array();

        if($post['voucher_date'] == '') {
            $error[] = $lang['error_voucher_date'];
        }

        if($post['supplier_id'] == '') {
            $error[] = $lang['error_supplier'];
        }

        $details = $post['stock_transfer_details'];
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
        $post = $this->request->post;
        $session = $this->session->data;
        $stock_transfer_id = $this->request->get['stock_transfer_id'];

        $this->model['partner'] = $this->load->model('common/partner');
        $this->model['stock_transfer'] = $this->load->model('inventory/stock_transfer');
        $this->model['stock_transfer_detail'] = $this->load->model('inventory/stock_transfer_detail');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $this->model['warehouse'] = $this->load->model('inventory/warehouse');

        $voucher = $this->model['stock_transfer']->getRow(array('stock_transfer_id' => $stock_transfer_id));
        $Warehouse = $this->model['warehouse']->getRow(array('warehouse_id' => $voucher['warehouse_id']));

        $details = $this->model['stock_transfer_detail']->getRows(array('stock_transfer_id' => $stock_transfer_id));



        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Transfer Note');
        $pdf->SetSubject('Transfer Note');

        if($voucher['billty_date'] != '') {
            $voucher['billty_date'] = MySqlDate($voucher['billty_date']);
        } else {
            $voucher['billty_date'] = NULL;
        }

        // d($voucher, true);
        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            //'report_name' => $lang['heading_title'],
            'report_name' => 'Transfer Note',
            'company_logo' => $session['company_image'],
            'remarks' => $voucher['remarks'],
            'document_identity' => $voucher['document_identity'],
            'dc_no' => $voucher['dc_no'],
            'document_date' => $voucher['document_date'],
            'partner_name' => $voucher['partner_name'],
            'bilty_no' => $voucher['billty_no'],
            'bilty_remarks' => $voucher['billty_remarks'],
            'bilty_date' => $voucher['billty_date'],
            'warehouse_name' => $Warehouse['name'],

        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 47, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 40);

        // add a page
        $pdf->AddPage();
        // set font

        $pdf->SetFont('helvetica', '', 8);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $total_qty = 0;
        $sr=0;
        foreach($details as $detail) {

            $ToWarehouse = $this->model['warehouse']->getRow(array('warehouse_id' => $detail['warehouse_id']));

            $sr++;
            $pdf->ln(7);
            $pdf->Cell(10, 7, $sr, 1, false, 'L', 0, '', 1);
            $pdf->Cell(90, 7, html_entity_decode($detail['description']), 1, false, 'L', 0, '', 1);
            $pdf->Cell(35, 7, $ToWarehouse['name'], 1, false, 'C', 0, '', 1);
            $pdf->Cell(30, 7, $detail['unit'], 1, false, 'C', 0, '', 1);
            $pdf->Cell(30, 7, number_format($detail['qty'],2), 1, false, 'R', 0, '', 1);
            

            $total_qty += $detail['qty'];
        }

        $pdf->ln(7);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(135, 7, '', 0, false, 'L');
        $pdf->Cell(30, 7, 'Total Qty', 1, false, 'R');
        $pdf->Cell(30, 7, number_format($total_qty,2), 1, false, 'R');

        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->setXY($x,$y);
        // Set font
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(20, 7, 'Remarks: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // set font
        $pdf->Ln(3);
        $pdf->setCellPaddings(1,1,1,1);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->MultiCell(0, 15, $pdf->data['remarks'], 0, 'L', false, 0, 10, $Y, 'M', '', '');
        
        $pdf->Ln(30);
        $pdf->Cell(33, 7, 'Prepared By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(16, 7, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Cell(33, 7, 'Received By', 'T', false, 'C', 0, '', 0, false, 'M', 'M');


        //Close and output PDF document
        $pdf->Output('Stock Transfer - '.$voucher['document_identity'].'.pdf', 'I');

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

        $this->SetFont('helvetica', 'B', 20);
        $this->Ln(2);
        // Title
        $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);

        $this->SetFont('helvetica', '', 16);
        $this->Cell(0, 8, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(15);


        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(20, 7, 'Voucher No: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // set font
        $this->SetFont('helvetica', '', 9);
        $this->Cell(60, 7, $this->data['document_identity'], 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // set font
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(25, 7, 'Voucher Date: ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // set font
        $this->SetFont('helvetica', '', 9);
        $this->Cell(30, 7, stdDate($this->data['document_date']), 0, false, 'L', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(30, 7, 'From Warehouse :', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        // set font
        $this->SetFont('helvetica', '', 9);
        $this->Cell(40, 7, $this->data['warehouse_name'], 0, false, 'L', 0, '', 0, false, 'M', 'M');

        $this->ln(6);
        $this->SetFont('helvetica', '', 7);
        $this->SetFillColor(215, 215, 215);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(10, 8, 'S.No.', 1, false, 'C', 1, '', 1);
        $this->Cell(90, 8, 'Item Description', 1, false, 'C', 1, '', 1);
        $this->Cell(35, 8, 'To Warehouse', 1, false, 'C', 1, '', 1);
        $this->Cell(30, 8, 'Unit', 1, false, 'C', 1, '', 1);
        $this->Cell(30, 8, 'Qty', 1, false, 'C', 1, '', 1);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);

        
        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>