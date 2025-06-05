<?php

class ControllerInventoryProductMaster extends HController {

    protected function validateDocument() {
        return false;
    }

    protected function getAlias() {
        return 'inventory/product_master';
    }

    protected function getPrimaryKey() {
        return 'product_master_id';
    }

    protected function getList() {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_export_excel'] = $this->url->link($this->getAlias() . '/exportDataExcel', 'token=' . $this->session->data['token'].$url, 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists() {
        $lang = $this->load->language($this->getAlias());
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());

        $data = array();
        $aColumns = array('action','product_category','brand', 'model', 'product_code', 'name','unit','cost_price','sale_price', 'created_at','check_box');

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
            //     'text' => $lang['duplicate'],
            //     'href' => $this->url->link($this->getAlias() . '/insert', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()].'&duplicate=1', 'SSL'),
            //     'btn_class' => 'btn btn-primary btn-xs',
            //     'class' => 'fa fa-clone'
            // );

            $actions[] = array(
                'text' => $lang['delete'],
                'href' => 'javascript:void(0);',
                'click' => "ConfirmDelete('" . $this->url->link($this->getAlias() . '/delete', 'token=' . $this->session->data['token'] . '&id=' . $aRow[$this->getPrimaryKey()], 'SSL') . "')",
                'btn_class' => 'btn btn-danger btn-xs',
                'class' => 'fa fa-times'
            );


            $strAction = '';
            foreach ($actions as $action) {
                $strAction .= '<a '.(isset($action['btn_class'])?'class="'.$action['btn_class'].'"':'').' href="' . $action['href'] . '" data-toggle="tooltip" title="' . $action['text'] . '" ' . (isset($action['click']) ? 'onClick="' . $action['click'] . '"' : '') . '>';
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
                    $row[] = '<input type="checkbox" name="selected[]" value="' . $aRow[$this->getPrimaryKey()] . '" />';
                } else {
                    $row[] = $aRow[$aColumns[$i]];
                }

            }
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    public function exportDataExcel()
    {
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        $results = $this->model[$this->getAlias()]->getRows(['company_id' => $this->session->data['company_id']]);
        // d($results,true);

        // d('i am here');
        // exit;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $rowCount = 1;


        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':O'.$rowCount);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
                'bold' => true,
                'size' => 14,
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,'Product List')->getStyle('A'.$rowCount)->getFont()->setBold( true )->setSize(14);
        $rowCount++;

        $hColumns = array(
            'Product Category',
            'Brand',
            'Model',
            'Code',
            'Name',
            'Unit',
            'Cost Price',
            'Sale Price',
            'Created At'
        );

        $cell = 'A';
        foreach ($hColumns as $index => $column) {
            $objPHPExcel->getActiveSheet()->SetCellValue($cell.$rowCount, $column)->getStyle($cell.$rowCount)->getFont()->setBold( true );
            $cell++;
        }
        

        $rowCount++;


        $vColumns = array(
            'product_category',
            'brand',
            'model',
            'product_code',
            'name',
            'unit',
            'cost_price',
            'sale_price',
            'created_at'
        );

        foreach($results as $key => $detail) {
            $cell = 'A';
            foreach ($vColumns as $index => $value) {
                $objPHPExcel->getActiveSheet()->SetCellValue($cell.$rowCount, $detail[$value]);
                $cell++;
            }
            $rowCount++;
        }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Product List.xlsx"');
            header('Cache-Control: max-age=0');
            //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            //$objWriter->save('some_excel_file.xlsx');
            $objWriter->save('php://output');
            exit;
    }

    protected function getForm() {
        parent::getForm();
        $this->data['sale_profit'] = 0;
        $this->data['sale_price'] = 0;
        $this->data['cost_price'] = 0;
        $this->data['reorder_quantity'] = 0;

        $this->model['product_category'] = $this->load->model('inventory/product_category');
        $this->data['product_categories'] = $this->model['product_category']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['brand'] = $this->load->model('inventory/brand');
        $this->data['brands'] = $this->model['brand']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['make'] = $this->load->model('inventory/make');
        $this->data['makes'] = $this->model['make']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['model'] = $this->load->model('inventory/model');
        $this->data['models'] = $this->model['model']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['unit'] = $this->load->model('inventory/unit');
        $this->data['units'] = $this->model['unit']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['module_setting'] = $this->load->model('common/setting');
        $this->model['coa'] = $this->load->model('gl/coa_level3');

        $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'inventory',
        );
        $accounts = $this->model['module_setting']->getRows($filter, array('field'));
        foreach($accounts as $account) {
            if($account['field']=='inventory_account_id') {
                $this->data['inventory_accounts'][] = $this->model['coa']->getRow(array('coa_level3_id' => $account['value']));
            } elseif($account['field']=='revenue_account_id') {
                $this->data['revenue_accounts'][] = $this->model['coa']->getRow(array('coa_level3_id' => $account['value']));
            } elseif($account['field']=='cogs_account_id') {
                $this->data['cogs_accounts'][] = $this->model['coa']->getRow(array('coa_level3_id' => $account['value']));
            } elseif($account['field']=='adjustment_account_id') {
                $this->data['adjustment_accounts'][] = $this->model['coa']->getRow(array('coa_level3_id' => $account['value']));
            } elseif($account['field']=='auto_generate_product_code') {
                $this->data['auto_generate_product_code'] = $account['value'];
            }
        }

        if($this->data['auto_generate_product_code'] != 1) {
            $this->data['product_code'] = '';
        } else {
            $this->data['product_code'] = 'AUTO';
        }

        if (isset($this->request->get['product_master_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $result = $this->model[$this->getAlias()]->getRow(array('product_master_id' => $this->request->get['product_master_id']));
            foreach ($result as $field => $value) {
                $this->data[$field] = $value;
            }
            if(isset($this->request->get['duplicate'])) {
                if($this->data['auto_generate_product_code'] != 1) {
                    $this->data['product_code'] = '';
                } else {
                    $this->data['product_code'] = 'AUTO';
                }
            }
        }

        $this->model['image'] = $this->load->model('tool/image');
        $this->data['no_image'] = $this->model['image']->resize('no_image.jpg', 100, 100);

        if ($this->data['product_image'] && file_exists(DIR_IMAGE . $this->data['product_image']) && is_file(DIR_IMAGE . $this->data['product_image'])) {
            $this->data['src_product_image'] = $this->model['image']->resize($this->data['product_image'], 100, 100);
        } else {
            $this->data['src_product_image'] = $this->model['image']->resize('no_image.jpg', 100, 100);
        }

        $this->data['action_validate_product_code'] = $this->url->link($this->getAlias() . '/validateProductCode', 'token=' . $this->session->data['token'] . '&product_master_id=' . $this->request->get['product_master_id']);
        $this->data['action_validate_product_name'] = $this->url->link($this->getAlias() . '/validateProductName', 'token=' . $this->session->data['token'] . '&product_master_id=' . $this->request->get['product_master_id']);
        $this->data['strValidation']= "{
            'rules':{
                'product_category_id': {'required':true},
                'thickness_id': {'required':true},
                'width_id': {'required':true},
                'length_id': {'required':true},
                'grade_id': {'required':true},
                'sawmill_id': {'required':true},
                'name': {'required':true, 'minlength': 3},
                'product_code': {'required':true, 'minlength': 3, 'remote':  {url: '" . $this->data['action_validate_product_code'] . "', type: 'post'}},
                'unit_id': {'required':true},
                'inventory_account_id': {'required': true},
                'revenue_account_id': {'required': true},
                'cogs_account_id': {'required': true},
                'adjustment_account_id': {'required': true},
                'thickness_unit_id': {'required':true},
                'thickness_value': {'required':true},
                'length_unit_id': {'required':true},
                'length_value': {'required':true},
                'width_unit_id': {'required':true},
                'width_value': {'required':true},
             },
            'ignore':[]
          }";

        $this->response->setOutput($this->render());
    }

    public function validateProductCode()
    {
        $code = $this->request->post['product_code'];
//        d($code,true);
        $company_id = $this->session->data['company_id'];
        $product_master_id = $this->request->get['product_master_id'];

        $this->load->language('inventory/product_master');
        if ($code) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $where = "company_id='" . $company_id . "' AND LOWER(product_code) = '".strtolower($code)."' AND product_master_id != '".$product_master_id."'";
            $row = $this->model['product_master']->getRow($where);
//            d($coa,true);
            if ($row) {
                echo json_encode($this->language->get('error_duplicate_product_code'));
            } else {
                echo json_encode("true");
            }
        } else {
            echo json_encode($this->language->get('error_product_code'));
        }
        exit;
    }

    public function validateProductName()
    {
        $name = $this->request->post['name'];
        $company_id = $this->session->data['company_id'];
        $product_master_id = $this->request->get['product_master_id'];

        $this->load->language('inventory/product_master');
        if ($name) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $where = "company_id='" . $company_id . "' AND LOWER(name) = '".strtolower($name)."' AND product_master_id != '".$product_master_id."'";
            $coa = $this->model['product_master']->getRow($where);
            if ($coa) {
                echo json_encode($this->language->get('error_duplicate_product_master_name'));
            } else {
                echo json_encode("true");
            }
        } else {
            echo json_encode($this->language->get('error_name'));
        }
        exit;
    }

    protected function insertData($data) {
        if($data['product_code']=='AUTO') {
            $product_code = $this->model[$this->getAlias()]->getMaxProductCode();
            $data['product_code'] = str_pad($product_code,4,'0',STR_PAD_LEFT);
        }
        $data['company_id'] = $this->session->data['company_id'];
        $this->model[$this->getAlias()]->add($this->getAlias(), $data);

    }

    protected function updateData($primary_key, $data) {
        $data['company_id'] = $this->session->data['company_id'];
        $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);
        //d($data,true);
    }

    public function getProducts() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['product_category_id']) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $product_masters = $this->model['product_master']->getArrays('product_master_id','name',array('company_id' => $this->session->data['company_id'], 'product_category_id' => $this->request->post['product_category_id']));
            $html = '<option value="">&nbsp;</option>';
            foreach($product_masters as $id => $value) {
                $html .= '<option value="'.$id.'">'.$value.'</option>';
            }
            $json = array(
                'success' => true,
                'html' => $html
            );
        } else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_category')
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function getProductCharges() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['product_master_id']) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $charges = $this->model['product_master']->getProductCharges($this->request->post['product_master_id']);
            $json = array(
                'success' => true,
                'charges' => $charges
            );
        } else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_master')
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function getProductUnits() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['product_master_id']) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $product_master = $this->model['product_master']->getRow(array('product_master_id' => $this->request->post['product_master_id']));
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            //$product_master = $this->model['product_master']->getArrays('product_code','cost_price',array('product_master_id' => $this->request->post['product_master_id']));
//            d($pdcode,true);
            $this->model['unit'] = $this->load->model('inventory/unit');
            $unit = $this->model['unit']->getRow(array('unit_id' => $product_master['unit_id']));
            $html='';
            if($unit) {
                $html .= '<option value="' . $unit['unit_id'] . '">' . $unit['name'] . '</option>';
            }
            $json = array(
                'success' => true,
                'html' => $html,
                'cost_price' => $product_master['cost_price'],
                'product_code' => $product_master['product_code']
            );
        } else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_master')
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function getCostPrice(){

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['product_master_id'] ) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $costprice = $this->model['product_master']->getRow('cost_price');
            $json = array(
                'success' => true,
                'charges' => $costprice
            );
        } else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_master')
            );
        }

    }

    public function getProductInformation() {
        //  d($this->request->post['product_master_id']);
        if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['product_master_id']) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'product_master_id' => $this->request->post['product_master_id'],
            );
            $filter1 = 'product_master_id';
            $product_master = $this->model['product_master']->getRow($filter);
            $filter['company_branch_id'] = $this->session->data['company_branch_id'];
            $product_master_stock = $this->model['product_master']->getProductStock($filter);
            $this->model['unit'] = $this->load->model('inventory/unit');
            $unit = $this->model['unit']->getRow(array('unit_id' => $product_master['unit_id']));
            $html='';
            if($unit) {
                $html .= '<option value="' . $unit['unit_id'] . '">' . $unit['name'] . '</option>';
            }
            $json = array(
                'success' => true,
                'product_master_id' => $product_master['product_master_id'],
                'unit' => $html,
                'rate' => $product_master['cost_price'],
                'sale_price' => $product_master['sale_price'],
                'code' => $product_master['product_code'],
                'name' => $product_master['name'],
                'avg_rate' => $product_master_stock['rate'],
                'quantity' => $product_master_stock['qty'],
                'product_master_service' => $product_master['product_master_service'],
            );
        }
        else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_master')
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function getProductStock() {
        //d($this->request->get['product_master_id']);
        if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['warehouse_id'] ) {
            $post = $this->request->post;
            //d($post);
            $this->model['stock'] = $this->load->model('common/stock');
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'warehouse_id' => $post['warehouse_id'],
                'product_master_id' => $post['product_master_id'],

            );

            $product_master_stock = $this->model['stock']->getStock($filter);
//            d(array($product_master_stock,$filter),true);
            $json = array(
                'success' => true,
                'avg_rate' => $product_master_stock['rate'],
                'quantity' => empty($product_master_stock['qty'])?0:$product_master_stock['qty'],
                'product_master_stock' => $product_master_stock,
            );
        } else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_master')
            );
        }

        //d($json,true);
        $this->response->setOutput(json_encode($json));
    }

    public function getProductStockWithCode() {
        //d($this->request->get['product_master_id']);
        if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['warehouse_id'] ) {
            $post = $this->request->post;
            //d($post);
            $this->model['stock'] = $this->load->model('common/stock');
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'warehouse_id' => $post['warehouse_id'],
                'product_master_id' => $post['product_master_id'],

            );
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $product_master = $this->model['product_master']->getRow(array('product_master_id' => $this->request->post['product_master_id']));
            $this->model['unit'] = $this->load->model('inventory/unit');
            $unit = $this->model['unit']->getRow(array('unit_id' => $product_master['unit_id']));
            $html='';
            if($unit) {
                $html .= '<option value="' . $unit['unit_id'] . '">' . $unit['name'] . '</option>';
            }
            $product_master_stock = $this->model['stock']->getStock($filter);
            $json = array(
                'success' => true,
                'unit' => $html,
                'avg_rate' => round($product_master_stock['rate'],3),
                'code' => $product_master['product_code'],
                'quantity' => empty($product_master_stock['qty'])?0:$product_master_stock['qty'],
                'product_master_stock' => $product_master_stock,
            );
        } else {
            $this->load->language('inventory/product_master');
            $json = array(
                'success' => false,
                'error' => $this->language->get('error_select_product_master')
            );
        }

//        d($json,true);
        $this->response->setOutput(json_encode($json));
    }

    public function getProductInformationCode() {
        $this->load->language('inventory/product_master');
        if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->request->post['product_code']) {
            $this->model['product_master'] = $this->load->model('inventory/product_master');
            $product_master = $this->model['product_master']->getRow(array('company_id' => $this->session->data['company_id'],'product_code' => $this->request->post['product_code']));
            //d($product_master,true);
            if($product_master) {
                $json = array(
                    'success' => true,
                    'product_code' => $product_master['product_code'],
                    'product_master_id' => $product_master['product_master_id']
                );
            } else {
                $json = array(
                    'success' => false,
                    'error' => $this->language->get('error_product_code'),
                );

            }
//            d($json,true);
        }

        $this->response->setOutput(json_encode($json));
    }

    public function quickSearch() {
        $this->load->language('inventory/product_master');
        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $product_masters = $this->model['product_master']->getQuickSearch(array('criteria' =>array('orderby'=>' order by product_code ASC')));
//        d($product_masters,true);
        $html = "";
        if ($product_masters) {
            $ref_id = $this->request->get['ref_id'];
            $callback = $this->request->get['callback'];

//            $html .= "<div class='row'>";
            $html .= "<div class='col-md-12'>";
            $html .= "<div class='table-responsive'>";
            $html .= "<table id='tblQuickSearch' class='table table-striped' style='width: 100%'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th>&nbsp;</th>";
            $html .= "<th>" . $this->language->get('column_code') . "</th>";
            $html .= "<th>" . $this->language->get('column_barcode') . "</th>";
            $html .= "<th>" . $this->language->get('column_name') . "</th>";
            $html .= "<th>" . $this->language->get('column_thickness') . "</th>";
            $html .= "<th>" . $this->language->get('column_width') . "</th>";
            $html .= "<th>" . $this->language->get('column_model') . "</th>";
            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
            foreach ($product_masters as $product_master) {
                $html .= "<tr>";
                $html .= "<td><a href='javascript:void(0);' onClick=\"_quickSearch('" . $ref_id . "','" . $product_master['product_master_id'] . "','" . $callback . "');\">Select</a></td>";

                $html .= "<td>" . $product_master['product_code'] . "</td>";
                $html .= "<td>" . $product_master['barcode'] . "</td>";
                $html .= "<td>" . $product_master['name'] . "</td>";
                $html .= "<td>" . $product_master['thickness'] . "</td>";
                $html .= "<td>" . $product_master['width'] . "</td>";
                $html .= "<td>" . $product_master['model'] . "</td>";
                $html .= "</tr>";
            }
            $html .= "</tbody>";
            $html .= "<tfoot>";
            $html .= "<tr>";
            $html .= "<th>&nbsp;</th>";
            $html .= "<th>" . $this->language->get('column_code') . "</th>";
            $html .= "<th>" . $this->language->get('column_barcode') . "</th>";
            $html .= "<th>" . $this->language->get('column_name') . "</th>";
            $html .= "<th>" . $this->language->get('column_thickness') . "</th>";
            $html .= "<th>" . $this->language->get('column_width') . "</th>";
            $html .= "<th>" . $this->language->get('column_model') . "</th>";
            $html .= "</tr>";
            $html .= "</tfoot>";
            $html .= "</table>";
            $html .= "</div>";
            $html .= "</div>";
//            $html .= "</div>";
            $json = array(
                'success' => 1,
                'html' => $html
            );
        } else {
            $json = array(
                'success' => 0,
                'error' => $this->language->get('error_no_result')
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function product_masterCostSearch() {
        $this->load->language('inventory/product_master');
        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $product_masters = $this->model['product_master']->getProductCostSearch();
        $html = "";
        if ($product_masters) {
            $ref_id = $this->request->get['ref_id'];
            $callback = $this->request->get['callback'];

//            $html .= "<div class='row'>";
            $html .= "<div class='col-md-12'>";
            $html .= "<div class='table-responsive'>";
            $html .= "<table id='tblQuickSearch' class='table table-striped' style='width: 100%'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th>&nbsp;</th>";
            $html .= "<th>" . $this->language->get('column_name') . "</th>";
            $html .= "<th>" . $this->language->get('column_cost') . "</th>";
            $html .= "<th>" . $this->language->get('column_percent') . "</th>";

            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
            foreach ($product_masters as $product_master) {
                $html .= "<tr>";
                $html .= "<td><a href='javascript:void(0);' onClick=\"_quickSearch('" . $ref_id . "','" . $product_master['product_code'] . "','" . $callback . "');\">Select</a></td>";


                $html .= "<td>" . $product_master['name'] . "</td>";
                $html .= "<td>" . $product_master['cost_price'] . "</td>";
                $html .= "<td>" . $product_master['percent'] . "</td>";

                $html .= "</tr>";
            }
            $html .= "</tbody>";
            $html .= "<tfoot>";
            $html .= "<tr>";
            $html .= "<th>&nbsp;</th>";
            $html .= "<th>" . $this->language->get('column_name') . "</th>";
            $html .= "<th>" . $this->language->get('column_cost') . "</th>";
            $html .= "<th>" . $this->language->get('column_percent') . "</th>";
            $html .= "</tr>";
            $html .= "</tfoot>";
            $html .= "</table>";
            $html .= "</div>";
            $html .= "</div>";
//            $html .= "</div>";
            $json = array(
                'success' => 1,
                'html' => $html
            );
        } else {
            $json = array(
                'success' => 0,
                'error' => $this->language->get('error_no_result')
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    protected function validateDelete($id)
    {
        if (!$this->user->hasPermission('delete', $this->getAlias())) {
            $this->error['warning'][] = $this->language->get('error_permission_delete');
        } else {
            $row = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $id));
            $this->model['ledger'] = $this->load->model('common/stock_ledger');
            $rows = $this->model['ledger']->getRows(array('company_id' => $this->session->data['company_id'],'product_id' => $id));
            //d(array(count($row), $rows), true);
            if(count($rows) > 0) {
                $this->error['warning'][] = sprintf("Cannot Delete `%s`. product_master is in use.", $row['name']);
            }
        }

        if (!$this->error) {
            //d($this->error, true);
            return true;
        } else {
            $this->session->data['warning'] = implode('<br />', $this->error['warning']);
            return false;
        }
    }

}

?>