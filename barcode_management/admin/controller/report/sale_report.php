<?php

class ControllerReportSaleReport extends HController {

    protected function getAlias() {
        return 'report/sale_report';
    }

    protected function getDefaultOrder() {
        return 'sale_invoice_id';
    }

    protected function getDefaultSort() {
        return 'DESC';
    }

    protected function getList() {
        parent::getList();

        $this->data['partner_types'] = $this->session->data['partner_types'];

        $this->model['customer'] = $this->load->model('setup/customer');
        $this->data['customers'] = $this->model['customer']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['product'] = $this->load->model('inventory/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_detail_report'] = $this->url->link($this->getAlias() .'/getDetailReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_excel_report'] = $this->url->link($this->getAlias() .'/printExcelReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['date_from'] = stdDate($this->session->data['fiscal_date_from']);
        $this->data['date_to'] = stdDate(($this->session->data['fiscal_date_to'] > date('Y-m-d') ? '' : $this->session->data['fiscal_date_to']));

        $this->data['strValidation'] = "{
            'rules': {
                'date_from': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'date_to': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
            },
            ignore:[],
        }";

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }

    public function getProductJson() {

        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $filter = [];
        $filter[] = "p.company_id = '". $session['company_id'] ."'";
        $filter = implode(' AND ', $filter);
        $options = $this->model['product_master']->getOptionList($post['q'], $filter, ['p.name']);
        $items = [];
        foreach($options['items'] as $row) {
            $items[] = [
                'id' => $row['product_master_id'],
                'text' => $row['product_code'].' - '.$row['name'],
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

    public function getDetailReport() {
        $post = $this->request->post;
        $session = $this->session->data;
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $arrWhere = array();
        $arrWhere[] = "`company_id` = '".$session['company_id']."'";
        $arrWhere[] = "`company_branch_id` = '".$session['company_branch_id']."'";
        $arrWhere[] = "`fiscal_year_id` = '".$session['fiscal_year_id']."'";
        if($post['date_from'] != '') {
            $arrWhere[] = "`document_date` >= '".MySqlDate($post['date_from'])."'";
        }
        if($post['date_to'] != '') {
            $arrWhere[] = "`document_date` <= '".MySqlDate($post['date_to'])."'";
        }
        if($post['partner_type_id'])
            $arrWhere[] = "`partner_type_id` = '" . $post['partner_type_id'] . "'";
        if($post['partner_id'])
            $arrWhere[] = "`partner_id` = '" . $post['partner_id'] . "'";
        if($post['warehouse_id'])
            $arrWhere[] = "`warehouse_id` = '" . $post['warehouse_id'] . "'";
        if($post['product_id'])
            $arrWhere[] = "`product_master_id` IN('" . implode("','", $post['product_id']) . "')";
        if($post['container_no'])
            $arrWhere[] = "`container_no` LIKE '" . $post['container_no'] . "%'";

        $where = implode(' AND ', $arrWhere);

        $rows = $this->model['sale_tax_invoice_detail']->getRows($where);
        //d($rows);
        $html = '';
        foreach($rows as $row) {
            $href = $this->url->link($row['route'].'/update',$row['primary_key_field'].'='.$row['primary_key_value'].'&token='.$this->session->data['token']);
            $html .= '<tr>';
            $html .= '<td>'.stdDate($row['document_date']).'</td>';
            $html .= '<td><a target="_blank" href="'.$href.'">'.$row['document_identity'].'</a></td>';
            $html .= '<td>'.$row['warehouse'].'</td>';
            $html .= '<td>'.$row['partner_name'].'</td>';
            // $html .= '<td>'.$row['container_no'].'</td>';
            $html .= '<td>'.$row['batch_no'].'</td>';
            $html .= '<td>'.$row['serial_no'].'</td>';
            $html .= '<td>'.$row['product_name'].'</td>';
            $html .= '<td>'.$row['qty'].'</td>';
            $html .= '<td>'.$row['rate'].'</td>';
            $html .= '<td>'.$row['amount'].'</td>';
            $html .= '</tr>';
        }

        $json = array(
            'success' => true,
            'post' => $post,
            'html' => $html,
            'rows' => $rows
        );
        //d($json,true);
        $this->response->setOutput(json_encode($json));
    }

    public function printExcelReport() {
        $this->init();
        ini_set('memory_limit','1024M');
        $post = $this->request->post;

        $filter = array();
        $filter[] = "`company_id` = '".$this->session->data['company_id']."'";
        $filter[] = "`company_branch_id` = '".$this->session->data['company_branch_id']."'";
        $filter[] = "`fiscal_year_id` = '".$this->session->data['fiscal_year_id']."'";
        if(isset($post['date_from']) && $post['date_from'] != '') {
            $filter[] = "`document_date` >= '".MySqlDate($post['date_from'])."'";
        }
        if(isset($post['date_to']) && $post['date_to'] != '') {
            $filter[] = "`document_date` <= '".MySqlDate($post['date_to'])."'";
        }
        if(isset($post['partner_type_id']) && $post['partner_type_id'] != '') {
            $filter[] = "`partner_type_id` = '".$post['partner_type_id']."'";
        }
        if(isset($post['partner_id']) && $post['partner_id'] != '') {
            $filter[] = "`partner_id` = '".$post['partner_id']."'";
        }
        if(isset($post['warehouse_id']) && $post['warehouse_id'] != '') {
            $filter[] = "`warehouse_id` = '".$post['warehouse_id']."'";
        }
        if(isset($post['warehouse_id']) && $post['warehouse_id'] != '') {
            $filter[] = "`warehouse_id` = '".$post['warehouse_id']."'";
        }

        $where = implode(' AND ', $filter);
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $rows = $this->model['sale_tax_invoice_detail']->getRows($where, array('created_at'));
        
        if($post['group_by']=='document') {
            $this->excelDocumentWise($rows);
        } elseif($post['group_by']=='partner') {
            $this->excelPartnerWise($rows);
        } elseif($post['group_by']=='warehouse') {
            $this->excelWarehouseWise($rows);
        } elseif($post['group_by']=='product') {
            $this->excelProductWise($rows);
        } elseif($post['group_by']=='container') {
            $this->excelContainerWise($rows);
        }
    }

    private function excelDocumentWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['document_identity']])) {
                $invoices[$row['document_identity']] = array(
                    'document_date' => $row['document_date'],
                    'document_identity' => $row['document_identity'],
                    'data' => array()
                );
            }
            $invoices[$row['document_identity']]['data'][] = $row;
        }

        // d($invoices, true);

        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // changing title from sale tax invoice to sale invoice for service associates
        $objPHPExcel->getProperties()
            ->setCreator("Muhammad Salman")
            ->setLastModifiedBy("Muhammad Salman")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_branch_name']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 25
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount ++;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Sale Invoice Report');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 20
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: ' . $post['date_from'].' To Date: ' . $post['date_to']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount++;

        $grand_qty = 0;
        $grand_amount = 0;
        $grand_discount_amount = 0;
        $grand_tax_amount = 0;
        $grand_total_amount = 0;

        foreach ($invoices as $key => $value)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc No.')->getStyle('B'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value['document_identity'])->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $rowCount++;

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Product');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Batch No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Serial No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Customer');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Warehouse');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Qty');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Unit');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Dis Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Tax Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'Total Amount');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;
            // d($value['data'], true);
            $qty = 0;
            $amount = 0;
            $discount_amount = 0;
            $tax_amount = 0;
            $total_amount = 0;
            foreach($value['data'] as $key_1 => $value_1)
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, stdDate($value_1['document_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value_1['product_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['batch_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['serial_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['partner_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['warehouse']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value_1['discount_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value_1['tax_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $value_1['total_amount']);
                $rowCount++;

                $qty += $value_1['qty'];
                $amount += $value_1['amount'];
                $discount_amount += $value_1['discount_amount'];
                $tax_amount += $value_1['tax_amount'];
                $total_amount += $value_1['total_amount'];

            }

            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $discount_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tax_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_amount);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;

            $grand_qty += $qty;
            $grand_amount += $amount;
            $grand_discount_amount += $discount_amount;
            $grand_tax_amount += $tax_amount;
            $grand_total_amount += $total_amount;
        }

        $rowCount+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Grand Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $grand_qty);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $grand_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $grand_discount_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $grand_tax_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $grand_total_amount);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold' => true
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sale Invoice Report.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;
    }

    private function excelPartnerWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['partner_type'].'-'.$row['partner_name']])) {
                $invoices[$row['partner_type'].'-'.$row['partner_name']] = array(
                    'partner_type' => $row['partner_type'],
                    'partner_name' => $row['partner_name'],
                    'data' => array()
                );
            }
            $invoices[$row['partner_type'].'-'.$row['partner_name']]['data'][] = $row;
        }
        //d($invoices, true);
        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // changing title from sale tax invoice to sale invoice for service associates
        $objPHPExcel->getProperties()
            ->setCreator("Muhammad Salman")
            ->setLastModifiedBy("Muhammad Salman")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_branch_name']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 25
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount ++;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Sale Invoice Report');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 20
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: ' . $post['date_from'].' To Date: ' . $post['date_to']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount++;

        $grand_qty = 0;
        $grand_amount = 0;
        $grand_discount_amount = 0;
        $grand_tax_amount = 0;
        $grand_total_amount = 0;

        foreach ($invoices as $key => $value)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Customer')->getStyle('B'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value['partner_name'])->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $rowCount++;

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Doc No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Product');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Batch No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Serial No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Warehouse');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Qty');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Unit');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Dis Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Tax Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'Total Amount');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;
            // d($value['data'], true);
            $qty = 0;
            $amount = 0;
            $discount_amount = 0;
            $tax_amount = 0;
            $total_amount = 0;
            foreach($value['data'] as $key_1 => $value_1)
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, stdDate($value_1['document_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value_1['document_identity']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['product_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['batch_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['serial_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['warehouse']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value_1['discount_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value_1['tax_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $value_1['total_amount']);
                $rowCount++;

                $qty += $value_1['qty'];
                $amount += $value_1['amount'];
                $discount_amount += $value_1['discount_amount'];
                $tax_amount += $value_1['tax_amount'];
                $total_amount += $value_1['total_amount'];

            }

            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $discount_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tax_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_amount);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;

            $grand_qty += $qty;
            $grand_amount += $amount;
            $grand_discount_amount += $discount_amount;
            $grand_tax_amount += $tax_amount;
            $grand_total_amount += $total_amount;
        }

        $rowCount+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Grand Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $grand_qty);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $grand_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $grand_discount_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $grand_tax_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $grand_total_amount);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold' => true
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sale Invoice Report.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;
    }

    private function excelWarehouseWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['warehouse']])) {
                $invoices[$row['warehouse']] = array(
                    'warehouse' => $row['warehouse'],
                    'data' => array()
                );
            }
            $invoices[$row['warehouse']]['data'][] = $row;
        }
        //d($invoices, true);
        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // changing title from sale tax invoice to sale invoice for service associates
        $objPHPExcel->getProperties()
            ->setCreator("Muhammad Salman")
            ->setLastModifiedBy("Muhammad Salman")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_branch_name']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 25
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount ++;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Sale Invoice Report');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 20
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: ' . $post['date_from'].' To Date: ' . $post['date_to']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount++;

        $grand_qty = 0;
        $grand_amount = 0;
        $grand_discount_amount = 0;
        $grand_tax_amount = 0;
        $grand_total_amount = 0;

        foreach ($invoices as $key => $value)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Warehouse')->getStyle('B'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value['warehouse'])->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $rowCount++;

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Doc No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Product');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Batch No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Serial No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Customer');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Qty');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Unit');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Dis Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Tax Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'Total Amount');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;
            // d($value['data'], true);
            $qty = 0;
            $amount = 0;
            $discount_amount = 0;
            $tax_amount = 0;
            $total_amount = 0;
            foreach($value['data'] as $key_1 => $value_1)
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, stdDate($value_1['document_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value_1['document_identity']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['product_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['batch_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['serial_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['partner_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value_1['discount_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value_1['tax_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $value_1['total_amount']);
                $rowCount++;

                $qty += $value_1['qty'];
                $amount += $value_1['amount'];
                $discount_amount += $value_1['discount_amount'];
                $tax_amount += $value_1['tax_amount'];
                $total_amount += $value_1['total_amount'];

            }

            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $discount_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tax_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_amount);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;

            $grand_qty += $qty;
            $grand_amount += $amount;
            $grand_discount_amount += $discount_amount;
            $grand_tax_amount += $tax_amount;
            $grand_total_amount += $total_amount;
        }

        $rowCount+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Grand Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $grand_qty);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $grand_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $grand_discount_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $grand_tax_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $grand_total_amount);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold' => true
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sale Invoice Report.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;
    }

    private function excelProductWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['product_id']])) {
                $invoices[$row['product_id']] = array(
                    'product_code' => $row['product_code'],
                    'product_name' => $row['product_name'],
                    'cubic_meter' => $row['cubic_meter'],
                    'cubic_feet' => $row['cubic_feet'],
                    'data' => array()
                );
            }
            $invoices[$row['product_id']]['data'][] = $row;
        }

        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // changing title from sale tax invoice to sale invoice for service associates
        $objPHPExcel->getProperties()
            ->setCreator("Muhammad Salman")
            ->setLastModifiedBy("Muhammad Salman")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_branch_name']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 25
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount ++;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Sale Invoice Report');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 20
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":N".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: ' . $post['date_from'].' To Date: ' . $post['date_to']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount++;

        $grand_qty = 0;
        $grand_amount = 0;
        $grand_discount_amount = 0;
        $grand_tax_amount = 0;
        $grand_total_amount = 0;

        foreach ($invoices as $key => $value)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Product')->getStyle('B'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value['product_code'].' - '.$value['product_name'])->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $rowCount++;

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Doc No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Warehouse');
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Batch No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Serial No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Customer');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Qty');
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Unit');
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Dis Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Tax Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'Total Amount');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;
            // d($value['data'], true);
            $qty = 0;
            $amount = 0;
            $discount_amount = 0;
            $tax_amount = 0;
            $total_amount = 0;
            foreach($value['data'] as $key_1 => $value_1)
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, stdDate($value_1['document_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value_1['document_identity']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['warehouse']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['batch_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['serial_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['partner_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value_1['discount_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value_1['tax_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $value_1['total_amount']);
                $rowCount++;

                $qty += $value_1['qty'];
                $amount += $value_1['amount'];
                $discount_amount += $value_1['discount_amount'];
                $tax_amount += $value_1['tax_amount'];
                $total_amount += $value_1['total_amount'];

            }

            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $discount_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tax_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_amount);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    ),
                    'font' => array(
                        'bold' => true
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ebebeb')
                    )
                )
            );
            $rowCount++;

            $grand_qty += $qty;
            $grand_amount += $amount;
            $grand_discount_amount += $discount_amount;
            $grand_tax_amount += $tax_amount;
            $grand_total_amount += $total_amount;
        }

        $rowCount+=2;
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Grand Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $grand_qty);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $grand_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $grand_discount_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $grand_tax_amount);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $grand_total_amount);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount . ':N'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold' => true
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sale Invoice Report.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;
    }

    public function printReport() {
        $this->init();
        ini_set('memory_limit','1024M');
        $post = $this->request->post;

        $filter = array();
        $filter[] = "`company_id` = '".$this->session->data['company_id']."'";
        $filter[] = "`company_branch_id` = '".$this->session->data['company_branch_id']."'";
        $filter[] = "`fiscal_year_id` = '".$this->session->data['fiscal_year_id']."'";
        if(isset($post['date_from']) && $post['date_from'] != '') {
            $filter[] = "`document_date` >= '".MySqlDate($post['date_from'])."'";
        }
        if(isset($post['date_to']) && $post['date_to'] != '') {
            $filter[] = "`document_date` <= '".MySqlDate($post['date_to'])."'";
        }
        if(isset($post['partner_type_id']) && $post['partner_type_id'] != '') {
            $filter[] = "`partner_type_id` = '".$post['partner_type_id']."'";
        }
        if(isset($post['partner_id']) && $post['partner_id'] != '') {
            $filter[] = "`partner_id` = '".$post['partner_id']."'";
        }

        if(isset($post['product_id']) && $post['product_id'] != '') {
            $filter[] = "`product_master_id` IN('".implode("','", $post['product_id'])."')";
        }
        if(isset($post['warehouse_id']) && $post['warehouse_id'] != '') {
            $filter[] = "`warehouse_id` = '".$post['warehouse_id']."'";
        }

        $where = implode(' AND ', $filter);
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $rows = $this->model['sale_tax_invoice_detail']->getRows($where, array('created_at'));
        
        if($post['group_by']=='document') {
            $this->pdfDocumentWise($rows);
        } elseif($post['group_by']=='partner') {
            $this->pdfPartnerWise($rows);
        } elseif($post['group_by']=='warehouse') {
            $this->pdfWarehouseWise($rows);
        } elseif($post['group_by']=='product') {
            $this->pdfProductWise($rows);
        } elseif($post['group_by']=='container') {
            $this->pdfContainerWise($rows);
        }
    }

    private function pdfDocumentWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['document_identity']])) {
                $invoices[$row['document_identity']] = array(
                    'document_date' => $row['document_date'],
                    'document_identity' => $row['document_identity'],
                    'data' => array()
                );
            }
            $invoices[$row['document_identity']]['data'][] = $row;
        }

        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $session = $this->session->data;
        $company_logo = $setting['value'];

        $pdf = new PDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');
        //Set Header
        $post = $this->request->post;
        $pdf->data = array(
            'company_name' => $session['company_branch_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'document_date',
            'date_from' => $post['date_from'],
            'date_to' => $post['date_to'],
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 40, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set font
        $pdf->SetFont('helvetica', '', 8);
        $grand_total_qty = 0;
        $grand_amount = 0;
        $grand_total_dis_amount = 0;
        $grand_total_tax_amount = 0;
        $grand_total_amount = 0;
        $pdf->AddPage();
        foreach($invoices as $row) {
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(143, 7,'Document Date: ' . stdDate($row['document_date']), 0, false, 'L', 1, '', 0, false, 'M', 'M');
            $pdf->SetFont('helvetica', '', 8);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;
            $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;
                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(98, 6, $detail['product_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['batch_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['serial_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(30, 6, html_entity_decode($detail['partner_name']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(30, 6, html_entity_decode($detail['warehouse']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(17, 6, number_format($detail['qty'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(15, 6, $detail['unit'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(17, 6, number_format($detail['rate'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(17, 6, number_format($detail['discount_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['tax_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['total_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

                $total_qty += $detail['qty'];
                $amount += $detail['amount'];
                $total_dis_amount += $detail['discount_amount'];
                $total_tax_amount += $detail['tax_amount'];
                $total_amount += $detail['total_amount'];
            }
            $pdf->Ln(6);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(260, 6,'Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(17, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(32, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(17, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total_qty += $total_qty;
            $grand_amount += $amount;
            $grand_total_dis_amount += $total_dis_amount;
            $grand_total_tax_amount += $total_tax_amount;
            $grand_total_amount += $total_amount;
            $pdf->Ln(12);
        }

        $pdf->Cell(260, 6,'Grand Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(17, 6, number_format($grand_total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(32, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(17, 6, number_format($grand_total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        //Close and output PDF document
        $pdf->Output('Sale Invoice Report:'.date('YmdHis').'.pdf', 'I');
    }

    private function pdfPartnerWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['partner_type'].'-'.$row['partner_name']])) {
                $invoices[$row['partner_type'].'-'.$row['partner_name']] = array(
                    'partner_type' => $row['partner_type'],
                    'partner_name' => $row['partner_name'],
                    'data' => array()
                );
            }
            $invoices[$row['partner_type'].'-'.$row['partner_name']]['data'][] = $row;
        }
        //d($invoices, true);
        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $pdf = new PDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_branch_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'partner',
            'date_from' => $post['date_from'],
            'date_to' => $post['date_to'],
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 35, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set font
        $pdf->SetFont('helvetica', '', 8);
        $grand_total_qty = 0;
        $grand_amount = 0;
        $grand_total_dis_amount = 0;
        $grand_total_tax_amount = 0;
        $grand_total_amount = 0;
        $pdf->AddPage();
        foreach($invoices as $row) {
            $pdf->ln(5);
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(282, 7,'Customer : ' . html_entity_decode($row['partner_name']), 0, false, 'L', 1, '', 0, false, 'M', 'M');
            $pdf->SetFont('helvetica', '', 8);
            // $pdf->ln(7);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;

            $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;
                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(15, 6, stdDate($detail['document_date']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(113, 6, $detail['product_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['batch_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['serial_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, $detail['warehouse'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['qty'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(15, 6, $detail['unit'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['rate'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['discount_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['tax_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['total_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

                $total_qty += $detail['qty'];
                $amount += $detail['amount'];
                $total_dis_amount += $detail['discount_amount'];
                $total_tax_amount += $detail['tax_amount'];
                $total_amount += $detail['total_amount'];
            }
            $pdf->Ln(6);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(250, 6,'Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total_qty += $total_qty;
            $grand_amount += $amount;
            $grand_total_dis_amount += $total_dis_amount;
            $grand_total_tax_amount += $total_tax_amount;
            $grand_total_amount += $total_amount;
            $pdf->ln(12);
        }

        $pdf->Ln(6);
        $pdf->Cell(250, 6,'Grand Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(20, 6, number_format($grand_total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(20, 6, number_format($grand_total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

        //Close and output PDF document
        $pdf->Output('Sale Invoice Report:'.date('YmdHis').'.pdf', 'I');
    }

    private function pdfWarehouseWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['warehouse']])) {
                $invoices[$row['warehouse']] = array(
                    'warehouse' => $row['warehouse'],
                    'data' => array()
                );
            }
            $invoices[$row['warehouse']]['data'][] = $row;
        }
        //d($invoices, true);
        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $pdf = new PDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'warehouse',
            'date_from' => $post['date_from'],
            'date_to' => $post['date_to'],
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 35, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set font
        $pdf->SetFont('helvetica', '', 8);
        $grand_total_qty = 0;
        $grand_amount = 0;
        $grand_total_dis_amount = 0;
        $grand_total_tax_amount = 0;
        $grand_total_amount = 0;
        $pdf->AddPage();
        foreach($invoices as $row) {
            $pdf->ln(5);
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(282, 7,'Warehouse : ' . $row['warehouse'], 0, false, 'L', 1, '', 0, false, 'M', 'M');
            $pdf->SetFont('helvetica', '', 8);
            // $pdf->ln(7);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;
            $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;
                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(15, 6, stdDate($detail['document_date']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(103, 6, $detail['product_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['batch_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['serial_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(30, 6, $detail['partner_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['qty'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(15, 6, $detail['unit'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['rate'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['discount_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['tax_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['total_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

                $total_qty += $detail['qty'];
                $amount += $detail['amount'];
                $total_dis_amount += $detail['discount_amount'];
                $total_tax_amount += $detail['tax_amount'];
                $total_amount += $detail['total_amount'];

            }
            $pdf->Ln(6);
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->Cell(250, 6,'Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total_qty += $total_qty;
            $grand_amount += $amount;
            $grand_total_dis_amount += $total_dis_amount;
            $grand_total_tax_amount += $total_tax_amount;
            $grand_total_amount += $total_amount;
            $pdf->Ln(10);  
        }

        $pdf->Cell(250, 6,'Grand Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(20, 6, number_format($grand_total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(20, 6, number_format($grand_total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

        //Close and output PDF document
        $pdf->Output('Sale Invoice Report:'.date('YmdHis').'.pdf', 'I');
    }

    private function pdfProductWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['product_id']])) {
                $invoices[$row['product_id']] = array(
                    'product_code' => $row['product_code'],
                    'product_name' => $row['product_name'],
                    'cubic_meter' => $row['cubic_meter'],
                    'cubic_feet' => $row['cubic_feet'],
                    'data' => array()
                );
            }
            $invoices[$row['product_id']]['data'][] = $row;
        }

        $lang = $this->load->language($this->getAlias());
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));

        $post = $this->request->post;
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $pdf = new PDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'warehouse',
            'date_from' => $post['date_from'],
            'date_to' => $post['date_to'],
        );

                // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, 35, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set font
        $pdf->SetFont('helvetica', '', 8);
        $grand_total_qty = 0;
        $grand_amount = 0;
        $grand_total_dis_amount = 0;
        $grand_total_tax_amount = 0;
        $grand_total_amount = 0;
        $pdf->AddPage();
        foreach($invoices as $row) {
            $pdf->ln(5);
            $pdf->SetFont('helvetica', 'B', 10);


            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(141, 7,'Product Name: ' . $row['product_name'], 0, false, 'L', 1, '', 0, false, 'M', 'M');
            $pdf->ln(6);
            $pdf->Cell(141, 7,'Product Code: ' . $row['product_code'], 0, false, 'L', 1, '', 0, false, 'M', 'M');

            $pdf->SetFont('helvetica', '', 8);
            // $pdf->ln(7);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;
            $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;
                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, stdDate($detail['document_date']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(98, 6, html_entity_decode($detail['partner_name']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['batch_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(35, 6, $detail['serial_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(30, 6, html_entity_decode($detail['warehouse']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['qty'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(15, 6, $detail['unit'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['rate'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, number_format($detail['discount_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['tax_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($detail['total_amount'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

                $total_qty += $detail['qty'];
                $amount += $detail['amount'];
                $total_dis_amount += $detail['discount_amount'];
                $total_tax_amount += $detail['tax_amount'];
                $total_amount += $detail['total_amount'];
            }
            $pdf->Ln(6);
            $pdf->Cell(250, 6,'Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total_qty += $total_qty;
            $grand_amount += $amount;
            $grand_total_dis_amount += $total_dis_amount;
            $grand_total_tax_amount += $total_tax_amount;
            $grand_total_amount += $total_amount;
            $pdf->Ln(10);
        }

        $pdf->Cell(250, 6,'Grand Total', 0, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(20, 6, number_format($grand_total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(20, 6, number_format($grand_total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
        $pdf->Cell(25, 6, number_format($grand_total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

        //Close and output PDF document
        $pdf->Output('Sale Invoice Report:'.date('YmdHis').'.pdf', 'I');
    }


}

class PDF extends TCPDF {
    public $data = array();

    //Page header
    public function Header() {
        // Logo
        if($this->data['company_logo'] != '') {
            $image_file = DIR_IMAGE.$this->data['company_logo'];
            $this->Image($image_file, 10, 10, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        // Set font
        $this->SetFont('freesans', 'B', 14);
        $this->Ln(2);
        // Title
        $this->Cell(0, 7, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);
        $this->SetFont('freesans', 'B', 10);
        $this->Cell(0, 7, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);
        $this->SetFont('freesans', 'B', 10);
        $this->Cell(0, 7, $this->data['date_from'].' - '.$this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);

        $this->SetFont('freesans', 'B', 8);
        if($this->data['group_by'] == 'document_date')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(98, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Batch No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Serial No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 7, 'Customer', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 7, 'Warehouse', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        }
        else if($this->data['group_by'] == 'partner')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(113, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Batch No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Serial No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Warehouse', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        }
        else if($this->data['group_by'] == 'warehouse')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(103, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Batch No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Serial No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 7, 'Customer', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        }
        else if($this->data['group_by'] == 'product')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(98, 7, 'Partner', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Batch No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(35, 7, 'Serial No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 7, 'Warehouse', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        }
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