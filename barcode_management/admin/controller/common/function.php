<?php

class ControllerCommonFunction extends Controller {

    protected function getAlias() {
        return 'common/function';
    }

    public function openFileManager() {
        $action = $this->url->link($this->getAlias().'/uploadFile', 'token=' . $this->session->data['token'], 'SSL');
        $post = $this->request->post;
        $data = http_build_query($post);

        $html = '<form action="'.$action.'" method="post" enctype="multipart/form-data" id="file_upload">';
        $html .= '<div class="form-group">';
        $html .= '  <div class="input-group">';
        $html .= '    <input type="file" class="form-control" name="uploaded_file" id="uploaded_file" value="Upload File" readonly/>';
        $html .= '    <span class="input-group-addon"><a href="javascript:void(0);" onclick="$(\'#file_upload\').submit();" title="Upload File" data-toggle="tooltip"><i class="fa fa-cloud-upload"></i></a></span>';
        $html .= '  </div>';
        $html .= '</div>';
        $html .= '<div class="progreess">';
        $html .= '  <div style="width: 0%" role="progressbar" class="progress-bar progress-bar-primary progress-bar-striped">';
        $html .= '      <span class="sr-only">40% Complete (success)</span>';
        $html .= '  </div>';
        $html .= '</div>';
        $html .= '</form>';
        $html .= '<script src="plugins/jQuery/jQuery-form.js"></script>';
        $html .= '<script type="text/javascript">';
        $html .= '$(\'#file_upload\').ajaxForm({';
        $html .= 'dataType:  "json",';
        $html .= 'data: "' . $data . '",';
        $html .= 'beforeSend: function() {';
        $html .= '  $(\'#file_upload .progress-bar\').css("width",0)';
        $html .= '},';
        $html .= 'uploadProgress: function(event, $position, $total, $percent) {';
        $html .= '  $(\'#file_upload .progress-bar\').css("width",$percent+"%");';
        $html .= '},';
        $html .= 'complete: function($response) {';
        $html .= '  $json = $response.responseJSON;';
        $html .= '  if($json.success) {';
        $html .= '      $file_name = $json["file_name"];';
        $html .= '      $file_path = $json["file_path"];';
        $html .= '      console.log($json, $("#'.$post['file_name'].'"), $("#'.$post['file_path'].'"));';
        $html .= '      $("#'.$post['file_name'].'").val($file_name);';
        $html .= '      $("#'.$post['file_path'].'").val($file_path);';
        $html .= '  }';
        $html .= '}';
        $html .= '});';
        $html .= '</script>';

        $json  = array(
            'success' => true,
            'html' => $html,
            'post' => $post,
            'data' => $data
        );

        echo json_encode($json);
    }

    public function uploadFile() {

        $file_name = $this->request->files['uploaded_file']['name'];
        $new_file = DIR_UPLOAD . $file_name;
        $tmp_file = $this->request->files['uploaded_file']['tmp_name'];
        $ext = pathinfo($file_name,PATHINFO_EXTENSION);
        $extension = strtolower($ext);

        if ($this->request->files['uploaded_file']['size'] == 0) {
            $json = array(
                'success' => false,
                'error' => $this->data['error_invalid_file_size']
            );
        } elseif($extension != 'csv'){
            $json = array(
                'success' => false,
                'error' => 'Invalid file format!'
            );
        } elseif (is_uploaded_file($this->request->files['uploaded_file']['tmp_name'])) //file was uploaded successfully
        {
            move_uploaded_file($tmp_file, $new_file);
            $json = array(
                'success' => true,
                'file_name' => $file_name,
                'file_path' => $new_file
            );
        }

        echo json_encode($json);
        exit;
    }

    public function validateDate() {
        $lang = $this->load->language('common/function');
        $post = $this->request->post;
        foreach($post as $field => $date) {}
        $date = MySqlDate($date);
        $start_date = $this->session->data['fiscal_date_from'];
        $end_date = $this->session->data['fiscal_date_to'];
        if($date < $start_date || $date > $end_date) {
            echo json_encode($lang['error_invalid_date']);
        } else {
            echo json_encode('true');
        }
    }

    public function getDocumentApplicant() {

        $lang = $this->load->language('qarze_hassana/applicant');
        $this->model['applicant'] = $this->load->model('qarze_hassana/applicant');
        $rows = $this->model['applicant']->getRows();
        $html = '';
        $html .= '<table id="tblDonor" class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th class="text-center">&nbsp;</th>';
        $html .= '<th class="text-center">'.$lang['its_no'].'</th>';
        $html .= '<th class="text-center">'.$lang['name'].'</th>';
        $html .= '<th class="text-center">'.$lang['surname'].'</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach($rows as $row) {
            $html .= '<tr>';
            $html .= '<td><a  class="btn btn-primary btn-xs" onclick="setITSNo(this);" data-its_no="'.$row['its_no'].'"><i class="fa fa-check"></i></a></td>';
            $html .= '<td>'.$row['its_no'].'</td>';
            $html .= '<td>'.$row['title_and_name'].'</td>';
            $html .= '<td>'.$row['surname'].'</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '</tfoot>';
        $html .= '</table>';

        $json = array(
            'success' => true,
            'query' => $rows,
            'title' => $lang['heading_title'],
            'html' => $html
        );
//d($json,true);
        echo json_encode($json);
        exit;
    }



    // public function getProductByCode() {
    //     $lang = $this->load->language('inventory/product');
    //     $product_code = $this->request->post['product_code'];
    //     $this->model['product'] = $this->load->model('inventory/product');
    //     $this->model['stock'] = $this->load->model('common/stock_ledger');
    //     $where = "company_id = '".$this->session->data['company_id']."' AND LOWER(`product_code`) = '".strtolower($product_code)."'";
    //     $product = $this->model['product']->getRow($where);

    //     if($product) {
    //         $filter = array(
    //             'company_id' => $this->session->data['company_id'],
    //             'company_branch_id' => $this->session->data['company_branch_id'],
    //             'fiscal_year_id' => $this->session->data['fiscal_year_id'],
    //             'product_id' => $product['product_id'],
    //         );
    //         $product['stock'] = $this->model['stock']->getStock($filter);

    //         $json = array(
    //             'success' => true,
    //             'product' => $product
    //         );
    //     } else {
    //         $json = array(
    //             'success' => false,
    //             'error' => $lang['error_invalid_product']
    //         );
    //     }

    //     echo json_encode($json);
    //     exit;
    // }

    public function getProductByCode() {
        $lang = $this->load->language('inventory/product_master');
        $product_code = $this->request->post['product_code'];
        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $where = "company_id = '".$this->session->data['company_id']."' AND LOWER(`product_code`) = '".strtolower($product_code)."'";
        $product = $this->model['product_master']->getRow($where);
        if($product) {
                  $json = array(
                    'success' => true,
                    'product' => $product
                );


        } else {
            $json = array(
                'success' => false,
                'error' => $lang['error_invalid_product']
            );
        }

        echo json_encode($json);
        exit;
    }



    public function getProductById() {
        $lang = $this->load->language('inventory/product');
        $product_id = $this->request->post['product_id'];
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['stock'] = $this->load->model('common/stock_ledger');
        $product = $this->model['product']->getRow(array('company_id' => $this->session->data['company_id'], 'product_id' => $product_id));
        if($product) {
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'product_id' => $product['product_id'],
            );
            $product['stock'] = $this->model['stock']->getStock($filter);

            $json = array(
                'success' => true,
                'product' => $product
            );
        } else {
            $json = array(
                'success' => false,
                'post' => $this->request->post,
                'error' => $lang['error_invalid_product']
            );
        }

        echo json_encode($json);
        exit;
    }

    public function getPartnerById() {
        $lang = $this->load->language('common/function');
        $post = $this->request->post;
    //d($post,true);
        $arrWhere = array();
        $arrWhere[] = "`company_id` = '{$this->session->data['company_id']}'";
        if( isset($post['partner_id']) ) {
            $arrWhere[] = "`partner_id` = '{$post['partner_id']}'";
        }
        $arrWhere = implode(' AND ', $arrWhere);

        $this->model['partner'] = $this->load->model('common/partner');
        $partner = $this->model['partner']->getRow($arrWhere);
        $json = array(
            'success' => true,
            'partner' => $partner,
            'post' => $post,
            'where' => 'WHERE ' . $arrWhere
        );
        echo json_encode($json);
        exit;
    }


    public function getProductBySerialNo() {
        $where = '';
        $lang = $this->load->language('inventory/product');
        $serial_no = $this->request->post['serial_no'];
        $product_id = $this->request->post['product_id'];  
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['stock'] = $this->load->model('common/stock_ledger');
        $this->model['stock_history'] = $this->load->model('common/stock_ledger_history');
        
        if($product_id!='')
        {

          $where2 = "company_id = '".$this->session->data['company_id']."' AND `product_master_id` = '".$product_id."' And document_type_id = 37";
          $stock_history = $this->model['stock_history']->getStockSerialNo($where2);
          $where = "company_id = '".$this->session->data['company_id']."' AND `product_master_id` = '".$product_id."' AND `serial_no` NOT IN('".$stock_history['stock_serial_no']."') ORDER BY `serial_no`";
          $product = $this->model['product']->getRows($where);

         if($product) {
            $json = array(
                    'success' => true,
                    'product' => $product
                );
        } else {
            $json = array(
                'success' => false,
                'error' => $lang['error_invalid_product']
            );
        }
        }
        else
        {
          $where = "company_id = '".$this->session->data['company_id']."' AND LOWER(`serial_no`) = '".strtolower($serial_no)."'";
          $product = $this->model['product']->getRow($where);
          $product_warehouse = $this->model['stock_history']->getRow($where);
         if($product) {
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'product_id' => $product['product_master_id'],
            );
            $product['stock'] = $this->model['stock']->getStock($filter);
            $product['product_warehouse'] = $product_warehouse['warehouse_id'];
            // d($product, true);
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'serial_no' => $serial_no,
            );
            if(isset($this->request->post['warehouse_id'])){
                $filter['warehouse_id'] = $this->request->post['warehouse_id'];
            }
            $stock_history = $this->model['stock_history']->getStock($filter);

            if($stock_history['stock_qty']>0){
                $json = array(
                    'success' => true,
                    'product' => $product,
                    'available_stock' => $stock_history
                );
            } else {
                $json = array(
                    'success' => false,
                    'product' => $product,
                    'available_stock' => $stock_history
                );
            }

        } else {
            $json = array(
                'success' => false,
                'error' => $lang['error_invalid_product']
            );
        }
        }
        echo json_encode($json);
        exit;
    }

    public function getProductBySerialNoAndWarehouse() {
        $lang = $this->load->language('inventory/product');
        $serial_no = $this->request->post['serial_no'];
        $warehouse_id = $this->request->post['warehouse_id'];
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['stock'] = $this->load->model('common/stock_ledger_history');
        $where = "company_id = '".$this->session->data['company_id']."' AND LOWER(`serial_no`) = '".strtolower($serial_no)."'";
        $product = $this->model['product']->getRow($where);

        if($product) {
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'serial_no' => $serial_no,
                'warehouse_id' => $warehouse_id,
            );
            $product['stock'] = $this->model['stock']->getStock($filter);
       // d($product,true);
            $json = array(
                'success' => true,
                'product' => $product
            );
        } else {
            $json = array(
                'success' => false,
                'error' => $lang['error_invalid_product']
            );
        }

        echo json_encode($json);
        exit;
    }

    public function QSApplicant() {
        $lang = $this->load->language('qarze_hassana/applicant');

        $html = '';
        //$html .= '<div class="table-responsive">';
        $html .= '  <table id="QSDataTable" class="table table-bordered">';
        $html .= '      <thead>';
        $html .= '      <tr>';
        $html .= '          <th class="text-center">&nbsp;</th>';
        $html .= '          <th class="text-center">'.$lang['its_no'].'</th>';
        $html .= '          <th class="text-center">'.$lang['title_and_name'].'</th>';
        $html .= '          <th class="text-center">'.$lang['surname'].'</th>';
        $html .= '      </tr>';
        $html .= '      </thead>';
        $html .= '      <tbody>';
        $html .= '      </tbody>';
        $html .= '  </table>';
        //$html .= '</div>';

        $json = array(
            'success' => true,
            'title' => $lang['heading_title'],
            'html' => $html
        );

        echo json_encode($json);
        exit;
    }

    public function QSAjaxApplicant() {
        $lang = $this->load->language('qarze_hassana/applicant');
        $this->model['applicant'] = $this->load->model('qarze_hassana/applicant');

        $data = array();
        $aColumns = array('action', 'its_no', 'title_and_name','surname');

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['start']) && $_GET['length'] != '-1') {
            $data['criteria']['start'] = $_GET['start'];
            $data['criteria']['limit'] = $_GET['length'];
        }

        /*
         * Ordering
         */
        $aOrder = array();
        if (isset($_GET['order'])) {
            foreach($_GET['order'] as $order) {
                $aOrder[] = $aColumns[$order['column']] . ' ' . $order['dir'];
            }
            $data['criteria']['orderby'] = ' ORDER BY ' . implode(',', $aOrder);
        }


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $arrWhere = array();
        $arrWhere[] = "`company_id` = '".$this->session->data['company_id']."'";
        if (isset($_GET['search']['value']) && $_GET['search']['value'] != "") {
            $arrSSearch = array();
            foreach($_GET['columns'] as $i => $column) {
                if($column['searchable']=='true') {
                    $arrSSearch[] = "LOWER(`" . $aColumns[$i] . "`) LIKE '%" . $this->db->escape(strtolower($_GET['search']['value'])) . "%'";
                }
            }
            if(!empty($arrSSearch)) {
                $arrWhere[] = '(' . implode(' OR ', $arrSSearch) . ')';
            }
        }

        /* Individual column filtering */
        foreach($_GET['columns'] as $i => $column) {
            if($column['searchable']=='true') {
                $arrSSearch[] = "LOWER(`" . $aColumns[$i] . "`) LIKE '%" . $this->db->escape(strtolower($column['search']['value'])) . "%'";
            }
        }

        if (!empty($arrWhere)) {
            //$data['filter']['RAW'] = substr($sWhere, 5, strlen($sWhere) - 5);
            $data['filter']['RAW'] = implode(' AND ', $arrWhere);
        }

        //d($data, true);
        $results = $this->model['applicant']->getLists($data);
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
            $filter = array(
                'company_id' => $this->session->data['company_id'],
                'company_branch_id' => $this->session->data['company_branch_id'],
                'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                'its_no' => $aRow['its_no'],
            );
            /*$stock = $this->model['stock']->getStock($filter);
            $data = array(
                'product_id' => $aRow['product_id'],
                'product_category_id' => $aRow['product_category_id'],
                'product_category' => $aRow['product_category'],
                'product_code' => $aRow['product_code'],
                'name' => $aRow['name'],
                'cubic_meter' => $aRow['cubic_meter'],
                'cubic_feet' => $aRow['cubic_feet'],
                'unit_id' => $aRow['unit_id'],
                'unit' => $aRow['unit'],
                'cost_price' => $aRow['cost_price'],
                'sale_price' => $aRow['sale_price'],
                'stock_qty' => ($stock['stock_qty']?$stock['stock_qty']:0),
                'stock_amount' => ($stock['stock_amount']?$stock['stock_amount']:0),
                'avg_stock_rate' => ($stock['avg_stock_rate']?$stock['avg_stock_rate']:0),
            );
            */

            if(isset($_GET['callback']) && $_GET['callback'] != '') {
                $strAction = '<button type="button" class="btn btn-primary btn-xs" onclick="'.$_GET['callback'].'(this);"';
            } else {
                $strAction = '<button type="button" class="btn btn-primary btn-xs" onclick="setProductInformation(this);"';
            }
            $strAction .= 'data-element="' . $_GET['element'] . '" ';
            $strAction .= 'data-field="' . $_GET['field'] . '" ';
            foreach($data as $c => $v) {
                $strAction .= 'data-' . $c . '="' .$v . '" ';
            }
            $strAction .= '><i class="fa fa-check"></i></button>';

            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'action') {
                    $row[] = $strAction;
                } elseif ($aColumns[$i] == 'created_at') {
                    $row[] = stdDateTime($aRow['created_at']);
                } else {
                    $row[] = $aRow[$aColumns[$i]];
                }

            }
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }


    public function getDocumentLedger() {
        $lang = $this->load->language($this->getAlias());
        $document_type_id = $this->request->post['document_type_id'];
        $document_id = $this->request->post['document_id'];
       // d($document_id,true);


        $this->model['ledger'] = $this->load->model('gl/ledger');
        $query = $this->model['ledger']->getDocumentLedger($document_type_id, $document_id);

        $total_debit = 0;
        $total_credit = 0;
        $html = '<table id="tblLedger" class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th class="text-center">'.$lang['account'].'</th>';
        $html .= '<th class="text-center">'.$lang['debit'].'</th>';
        $html .= '<th class="text-center">'.$lang['credit'].'</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach($query->rows as $row) {
            $html .= '<tr>';
            $html .= '<td class="text-left">'.$row['account'].'</td>';
            $html .= '<td class="text-right">'.number_format($row['debit'],2).'</td>';
            $html .= '<td class="text-right">'.number_format($row['credit'],2).'</td>';
            $html .= '</tr>';
            $total_debit += $row['debit'];
            $total_credit += $row['credit'];
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '<tr>';
        $html .= '<th>&nbsp;</th>';
        $html .= '<th class="text-right">'.number_format($total_debit,2).'</th>';
        $html .= '<th class="text-right">'.number_format($total_credit,2).'</th>';
        $html .= '</tr>';
        $html .= '</tfoot>';
        $html .= '</table>';

        $json = array(
            'success' => true,
            'post' => $this->request->post,
            'query' => $query,
            'title' => $lang['ledger_entry'],
            'html' => $html
        );
        echo json_encode($json);
        exit;
    }

    public function getPartner() {
        $post = $this->request->post;
        $partner_type_id = $post['partner_type_id'];
        $partner_id = $post['partner_id'];

        $this->model['coa'] = $this->load->model('gl/coa_level3');
        $arrCOAS = $this->model['coa']->getArrays('coa_level3_id', 'level3_display_name', array('company_id' => $this->session->data['company_id']));

        $this->model['partner'] = $this->load->model('common/partner');
        $filter = array(
            'company_id' => $this->session->data['company_id'],
            // 'company_branch_id' => $this->session->data['company_branch_id'],
            'partner_type_id' => $partner_type_id
        );
        $partners = $this->model['partner']->getRows($filter);
        $html = '<option value="">&nbsp;</option>';
        $this->model['document'] = $this->load->model('common/document');
        foreach($partners as $partner) {
            if($partner['partner_id'] == $partner_id) {
                $html .= '<option value="'.$partner['partner_id'].'" selected="true">'.$partner['name'].'</option>';
            } else {
                $html .= '<option value="'.$partner['partner_id'].'">'.$partner['name'].'</option>';
            }
        }
        //d($html,true);
        $json = array(
            'success' => true,
            'html' => $html,
            'partners' => $partners,
            'coa' => $arrCOAS,
            'post' => $post,
            'filter' => $filter
        );

        $this->response->setOutput(json_encode($json));
    }

    public function getWarehouseStock() {
        $post = $this->request->post;
        $this->model['stock'] = $this->load->model('common/stock_ledger');
        $stock = $this->model['stock']->getWarehouseStock($post['product_id'], $post['warehouse_id']);
        $json = array(
            'success' => true,
            'stock_qty' => $stock['stock_qty'],
            'avg_stock_rate' => $stock['avg_stock_rate'],
            'stock_amount' => ($stock['stock_qty'] * $stock['avg_stock_rate']),
        );

        echo json_encode($json);
        exit;
    }

    public function getOutstandingChart() {

        $lang = $this->load->language('report/qarze_hassana_outstanding_report');
        $this->model['qarze_hassana_outstanding_report'] = $this->load->model('report/qarze_hassana_outstanding_report');
        $rows = $this->model['qarze_hassana_outstanding_report']->getTopOutstandings();

//d($rows,true);

        foreach($rows as $r)
        {
            $categories[$r['name']] = $r['name'];
        }


        //  d($categories,true);


        foreach($categories as $category) {
            $series['Partner'][$category] = 0;
            foreach($rows as $row) {
                if($row['name']==$category) {

                    $series['Partner'][$category]=$row['outstanding_amount'];
                }}
        }

//        d($series,true);
        $series2 = array();
        foreach($series as $name => $row) {
            $data = array();
            foreach($row as $r) {
                $data[] = floatval($r);
            }
            $series2[] = array(
                'name' => $name,
                'data' => $data
            );
        }
//d(array($series,$series2));
        $data = array(
            'chart' => array(
                'type' => 'column'
            ),
            'title' => array(
                'text' => 'Top QH Partners Outstanding'
            ),
            'xAxis' => array(
                'categories' => array_values($categories)
            ),
            'yAxis' => array(
                'title' => array(
                    'text' => 'Outstanding Amount'
                ),                ),
            'series' => $series2
        );


        $json = array(
            'success' => true,
            'data' => $data
        );
//d($json,true);
        echo json_encode($json);
        exit;
    }

    public function getRequestChart() {

        $lang = $this->load->language('qarze_hassana/qarze_hassana_request');
        $this->model['qarze_hassana_request'] = $this->load->model('qarze_hassana/qarze_hassana_request');
        $rows = $this->model['qarze_hassana_request']->getTopRequestAmount();


        foreach($rows as $r)
        {
            $categories[$r['name']] = $r['name'];
        }


        //  d($categories,true);


        foreach($categories as $category) {
            $series['Partner'][$category] = 0;
            foreach($rows as $row) {
                if($row['name']==$category) {

                    $series['Partner'][$category]=$row['request_amount'];
                }}
        }

//        d($series,true);
        $series2 = array();
        foreach($series as $name => $row) {
            $data = array();
            foreach($row as $r) {
                $data[] = floatval($r);
            }
            $series2[] = array(
                'name' => $name,
                'data' => $data
            );
        }
//d(array($series,$series2));
        $data = array(
            'chart' => array(
                'type' => 'column'
            ),
            'title' => array(
                'text' => 'Top Partners Qarzan Hassana'
            ),
            'xAxis' => array(
                'categories' => array_values($categories)
            ),
            'yAxis' => array(
                'title' => array(
                    'text' => 'Qarzan Amount'
                ),                ),
            'series' => $series2
        );


        $json = array(
            'success' => true,
            'data' => $data
        );
//d($json,true);
        echo json_encode($json);
        exit;
    }


    public function getExpenseChart() {

        $lang = $this->load->language('report/project_summary_report');
        $this->model['project_summary_report'] = $this->load->model('report/project_summary_report');
        $rows = $this->model['project_summary_report']->getTopExpenses();


        foreach($rows as $r)
        {
            $categories[$r['display_name']] = $r['display_name'];
        }


        //  d($categories,true);


        foreach($categories as $category) {
            $series['Expense'][$category] = 0;

            foreach($rows as $row) {
                if($row['display_name']==$category) {

                    $series['Expense'][$category]=$row['balance'];
                }}
        }

//        d($series,true);
        $series2 = array();
        foreach($series as $name => $row) {
            $data = array();
            foreach($row as $r) {
                $data[] = floatval($r);
            }
            $series2[] = array(
                'name' => $name,
                'data' => $data
            );
        }
//d(array($series,$series2));
        $data = array(
            'chart' => array(
                'type' => 'column'
            ),
            'title' => array(
                'text' => 'Top QH Project Expenses'
            ),
            'xAxis' => array(
                'categories' => array_values($categories)
            ),
            'yAxis' => array(
                'title' => array(
                    'text' => 'Expense Amount'
                ),                ),
            'series' => $series2
        );


        $json = array(
            'success' => true,
            'data' => $data
        );
//d($json,true);
        echo json_encode($json);
        exit;
    }

}

?>