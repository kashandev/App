<?php

class ControllerReportSaleTaxReport extends HController {

    protected function getAlias() {
        return 'report/sale_tax_report';
    }

    protected function getDefaultOrder() {
        return 'sale_tax_invoice_id';
    }

    protected function getDefaultSort() {
        return 'DESC';
    }

    protected function getList() {
        parent::getList();

        $this->data['partner_types'] = $this->session->data['partner_types'];

        $this->model['customer'] = $this->load->model('setup/customer');

        $where = "company_id=" . $this->session->data['company_id'];
        // $where .= " AND partner_category_id=" .'1';

        $this->data['partners'] = $this->model['customer']->getRows($where,array('name'));

        $this->model['product'] = $this->load->model('inventory/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'], 'SSL');
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
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];


          $this->model['product'] = $this->load->model('inventory/product');
          $rows = $this->model['product']->getProductJson($search, $page);
          echo json_encode($rows);
    }

    public function printExcelReport()
    {
        $this->init();
        ini_set('memory_limit','1024M');
        $post = $this->request->post;
        $filter = array();
        $this_product = '';
         $filters = [
         'company_id' =>$this->session->data['company_id'],
         'company_branch_id' =>$this->session->data['company_branch_id'],
         'fiscal_year_id' =>$this->session->data['fiscal_year_id'],
         'document_date' =>$this->session->data['company_id'],
         'date_from' =>  MySqlDate($post['date_from']),
         'date_to' =>  MySqlDate($post['date_to']),
         'product_id' => $post['product_id'], 
         'document_type' => $post['document_type']
        ];

       $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $rows = $this->model['sale_tax_invoice_detail']->get_sale_tax_invoice_report($filters, array('si.`created_at`'));
        if($post['group_by']=='document') {
            $this->excelDocumentWise($rows);
        } elseif($post['group_by']=='document_no') {
            $this->excelDocumentNoWise($rows);
        }elseif($post['group_by']=='product') {
            $this->excelProductWise($rows);
        }
    }

    private function excelDocumentWise($rows) {
        //d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['document_date']])) {
                $invoices[$row['document_date']] = array(
                    'document_date' => $row['document_date'],
                    'document_identity' => $row['document_identity'],
                    'data' => array()
                );
            }
            $invoices[$row['document_date']]['data'][] = $row;
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

        // d($invoices,true);

        $session = $this->session->data;
        $company_logo = $setting['value'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // changing title from sale tax invoice to sale invoice for service associates
        $objPHPExcel->getProperties()
            ->setCreator("Huzaifa Khambaty")
            ->setLastModifiedBy("Huzaifa Khambaty")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":K".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_name']);
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
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":K".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $objPHPExcel->data['report_name']);
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
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":K".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFill('ebebeb');
        $rowCount ++;
        foreach ($invoices as $key => $value)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Doc. Date')->getStyle('A'.$rowCount)->getFont()->setBold( true );

            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, stdDate($value['document_date']))->getStyle('A'.$rowCount)->getFont()->setBold( true );
            $rowCount++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);


            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Doc. No.')->getStyle('A'.$rowCount)->getFont()->setBold( true );   

            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Job Order No')->getStyle('B'.$rowCount)->getFont()->setBold( true );

            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Product')->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Customer')->getStyle('D'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Quantity')->getStyle('E'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Unit')->getStyle('F'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Rate')->getStyle('G'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Amount')->getStyle('H'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Discount')->getStyle('I'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Tax Amount')->getStyle('J'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Total Amount')->getStyle('K'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':K'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    )
                )
            );
            $rowCount++;
            foreach($value['data'] as $key_1 => $value_1)
            {
                if($value_1['product_type'] == 'product' || $value_1['product_type'] == 'service')
                {
                    $this_product = $value_1['product_name'];
                }
                else
                {
                    $this_product = $value_1['part_name'];
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value_1['document_identity']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value_1['job_order_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $this_product);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['customer_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['discount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['tax_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value_1['total_amount']);
                $rowCount++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sale_invoice_report.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;

    }



    private function excelDocumentNoWise($rows) {
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

        // d($invoices,true);

        $session = $this->session->data;
        $company_logo = $setting['value'];

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        // changing title from sale tax invoice to sale invoice for service associates
        $objPHPExcel->getProperties()
            ->setCreator("Huzaifa Khambaty")
            ->setLastModifiedBy("Huzaifa Khambaty")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":K".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_name']);
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
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":K".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $objPHPExcel->data['report_name']);
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
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":K".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFill('ebebeb');
        $rowCount ++;
        foreach ($invoices as $key => $value)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Doc. No.')->getStyle('A'.$rowCount)->getFont()->setBold( true );

            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value['document_identity'])->getStyle('A'.$rowCount)->getFont()->setBold( true );
            $rowCount++;
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);


            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Doc. Date.')->getStyle('A'.$rowCount)->getFont()->setBold( true );   

            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Job Order No')->getStyle('B'.$rowCount)->getFont()->setBold( true );

            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Product')->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Customer')->getStyle('D'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Quantity')->getStyle('E'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Unit')->getStyle('F'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Rate')->getStyle('G'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Amount')->getStyle('H'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Discount')->getStyle('I'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Tax Amount')->getStyle('J'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Total Amount')->getStyle('K'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':K'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    )
                )
            );
            $rowCount++;
            foreach($value['data'] as $key_1 => $value_1)
            {
                if($value_1['product_type'] == 'product' || $value_1['product_type'] == 'service')
                {
                    $this_product = $value_1['product_name'];
                }
                else
                {
                    $this_product = $value_1['part_name'];
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, stdDate($value_1['document_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value_1['job_order_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $this_product);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['customer_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['discount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['tax_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value_1['total_amount']);
                $rowCount++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sale_invoice_report.xlsx"');
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

        $session = $this->session->data;
        $company_logo = $setting['value'];

        // d($invoices,true);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getProperties()
            ->setCreator("Huzaifa Khambaty")
            ->setLastModifiedBy("Huzaifa Khambaty")
            ->setTitle("Sale Invoice Report");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Sale Invoice Report',

        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_name']);
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

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $objPHPExcel->data['report_name']);
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

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFill('ebebeb');
        $rowCount ++;

        foreach ($invoices as $key => $value)
        {

            foreach($value['data'] as $products) {
            
               if($products['product_type'] == 'product' || $products['product_type'] == 'service')
                {
                    $this_product = $products['product_name'];
                }
                else
                {
                    $this_product = $products['part_name'];
                }   

            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Product Name')->getStyle('A'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $this_product)->getStyle('A'.$rowCount)->getFont()->setBold( true );
            // $rowCount++;
            // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Product Code')->getStyle('A'.$rowCount)->getFont()->setBold( true );
            // $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value['product_code'])->getStyle('A'.$rowCount)->getFont()->setBold( true );
            $rowCount++;

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);


            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Doc. Date')->getStyle('A'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc. No.')->getStyle('B'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Job Order No.')->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Customer')->getStyle('C'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Quantity')->getStyle('D'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Unit')->getStyle('E'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Rate')->getStyle('F'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Amount')->getStyle('G'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Discount')->getStyle('H'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Total Amount')->getStyle('J'.$rowCount)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->applyFromArray(
                array(
                    'borders' => array(
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                    )
                )
            );
            $rowCount++;
            foreach($value['data'] as $key_1 => $value_1)
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, stdDate($value_1['document_date']));
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value_1['document_identity']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value_1['job_order_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['customer_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['unit']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value_1['amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value_1['discount_amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value_1['total_amount']);
                $rowCount++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sale_invoice_report.xlsx"');
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
        // d($post);

        $filters = array();

        $filters = [
         'company_id' =>$this->session->data['company_id'],
         'company_branch_id' =>$this->session->data['company_branch_id'],
         'fiscal_year_id' =>$this->session->data['fiscal_year_id'],
         'document_date' =>$this->session->data['company_id'],
         'date_from' =>  MySqlDate($post['date_from']),
         'date_to' =>  MySqlDate($post['date_to']),
         'product_id' => $post['product_id'], 
         'document_type' => $post['document_type']
        ];

        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $rows = $this->model['sale_tax_invoice_detail']->get_sale_tax_invoice_report($filters, array('si.`created_at`'));
        ///d($rows,true);
        if($post['group_by']=='document') {
            $this->pdfDocumentWise($rows);
        } elseif($post['group_by']=='document_no') {
            $this->pdfDocumentNoWise($rows);
        }     
        elseif($post['group_by']=='product') {
            $this->pdfProductWise($rows);
        }     
    }

    private function pdfDocumentWise($rows) {
        // d($rows, true);
        $invoices = array();
        foreach($rows as $row) {
            if(!isset($invoices[$row['document_date']])) {
                $invoices[$row['document_date']] = array(
                    'document_date' => $row['document_date'],
                    'document_identity' => $row['document_identity'],
                    'data' => array()
                );
            }
            $invoices[$row['document_date']]['data'][] = $row;
        }
        // d($invoices,true);
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
        $pdf = new PDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');
        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'document_date',
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
        $grand_total = 0;
        $pdf->AddPage();
        foreach($invoices as $row) {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(143, 7,'Document Date: ' . stdDate($row['document_date']), 0, false, 'L', 1, '', 0, false, 'M', 'M');
            $pdf->SetFont('helvetica', '', 8);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;
            $this_product = '';
            $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;
                if($detail['product_type'] == 'product' || $detail['product_type'] == 'service')
                {
                    $this_product = $detail['product_name'];
                }
                else
                {
                    $this_product = $detail['part_name'];
                }
                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['job_order_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(52, 6, $this_product , 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(30, 6, html_entity_decode($detail['customer_name']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
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
            $pdf->Cell(139, 6,'', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(17, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(32, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(17, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total += $total_amount;
            $pdf->Ln(12);
        }

        //Close and output PDF document
        $pdf->Output('Sale Invoice Report:'.date('YmdHis').'.pdf', 'I');
    }



  private function pdfDocumentNoWise($rows) {
        // d($rows, true);
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
        // d($invoices,true);
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
        $pdf = new PDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');
        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'document_no',
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
        $grand_total = 0;
        $pdf->AddPage();
        foreach($invoices as $row) {
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(143, 7,'Document No: ' . $row['document_identity'], 0, false, 'L', 1, '', 0, false, 'M', 'M');
            $pdf->SetFont('helvetica', '', 8);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;
            $this_product = '';
            $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;
                if($detail['product_type'] == 'product' || $detail['product_type'] == 'service')
                {
                    $this_product = $detail['product_name'];
                }
                else
                {
                    $this_product = $detail['part_name'];
                }
                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, stdDate($detail['document_date']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['job_order_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(52, 6, $this_product , 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(30, 6, html_entity_decode($detail['customer_name']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
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
            $pdf->Cell(139, 6,'', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(17, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(32, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(17, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total += $total_amount;
            $pdf->Ln(12);
        }

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

        $session = $this->session->data;
        $company_logo = $setting['value'];

        $pdf = new PDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Sale Invoice Report');
        $pdf->SetSubject('Sale Invoice Report');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'group_by' => 'product'
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
        $grand_total = 0;
        $this_product = '';
        $pdf->AddPage();
        foreach($invoices as $row) {


            foreach($row['data'] as $products) {
            

               if($products['product_type'] == 'product' || $products['product_type'] == 'service')
                {
                    $this_product = $products['product_name'];
                }
                else
                {
                    $this_product = $products['part_name'];
                }      

            }

            $pdf->ln(4);
            $pdf->SetFont('helvetica', 'B', 10);


            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(141, 7,'Product Name: ' . $this_product, 0, false, 'L', 1, '', 0, false, 'M', 'M');
            // $pdf->ln(6);
            // $pdf->Cell(141, 7,'Product Code: ' . $row['product_code'], 0, false, 'L', 1, '', 0, false, 'M', 'M');


            $pdf->SetFont('helvetica', '', 8);
            // $pdf->ln(7);
            $sr =0;
            $total_qty = 0;
            $amount = 0;
            $total_dis_amount = 0;
            $total_tax_amount = 0;
            $total_amount = 0;
            // $pdf->Ln(1);
            foreach($row['data'] as $detail) {
                $sr++;

                $pdf->Ln(6);
                $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(20, 6, stdDate($detail['document_date']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, $detail['job_order_no'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(50, 6, html_entity_decode($detail['customer_name']), 1, false, 'L', 0, '', 1, false, 'M', 'M');
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
            $pdf->Cell(127, 6,'', 0, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_qty,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(35, 6, '', 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(20, 6, number_format($total_dis_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_tax_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(25, 6, number_format($total_amount,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $grand_total += $total_amount;
            $pdf->Ln(6);
        }

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
            //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
            $this->Image($image_file, 10, 10, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        // Set font
        $this->SetFont('times', 'B', 20);
        $this->Ln(2);
        // Title
        $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', '', 8);
        $this->ln(14);
        if($this->data['group_by'] == 'document_date')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Job Order No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(52, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 7, 'Customer', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        }


        if($this->data['group_by'] == 'document_no')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Job Order No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(52, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(30, 7, 'Customer', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(17, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        }

        else if($this->data['group_by'] == 'product')
        {
            $this->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(20, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(25, 7, 'Job Order No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Cell(50, 7, 'Customer', 1, false, 'C', 0, '', 0, false, 'M', 'M');
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
        $this->SetFont('times', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>