<?php

class ControllerReportBarcodeReport extends HController
{

    protected function getAlias()
    {
        return 'report/barcode_report';
    }

    protected function init()
    {
        $this->model['stock'] = $this->load->model('common/stock_ledger_history');
        $this->data['lang'] = $this->load->language($this->getAlias());
        $this->document->setTitle($this->data['lang']['heading_title']);
        $this->data['token'] = $this->session->data['token'];
    }

    protected function getList()
    {
        parent::getList();

        $this->model['warehouse'] = $this->load->model('inventory/warehouse');
        $this->data['warehouses'] = $this->model['warehouse']->getRows(array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id']));

        $this->model['product_category'] = $this->load->model('inventory/product_category');
        $this->data['product_categories'] = $this->model['product_category']->getRows(array('company_id' => $this->session->data['company_id']));


        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['date_from'] = stdDate($this->session->data['fiscal_date_from']);
        $this->data['date_to'] = stdDate(($this->session->data['fiscal_date_to'] > date('Y-m-d') ? '' : $this->session->data['fiscal_date_to']));

        $this->data['strValidation'] = "{
                'rules': {
                    'date_from': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                    'date_to': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                },
            }";

        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_report'] = $this->url->link($this->getAlias() . '/printReport', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }

    public function getProductJson()
    {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];
        $product_category_id = $this->request->post['product_category_id'];

        $this->model['product'] = $this->load->model('inventory/product');
        $rows = $this->model['product']->getProductJson($search, $page, 25, array('product_category_id' => $product_category_id));

        echo json_encode($rows);
    }


    public function printReport()
    {
        $this->init();
        ini_set('memory_limit', '1024M');
        $post = $this->request->post;
        $session = $this->session->data;

        $filter = array();
        $filter['company_id'] = $this->session->data['company_id'];
        $filter['company_branch_id'] = $this->session->data['company_branch_id'];
        $filter['fiscal_year_id'] = $this->session->data['fiscal_year_id'];

        $filter['to_date'] = MySqlDate($post['date_to']);

        if ($post['warehouse_id']) {
            $filter['warehouse_id'] = $post['warehouse_id'];
        }
        if ($post['product_id']) {
            $filter['product_id'] = $post['product_id'];
        }
        if ($post['product_category_id']) {
            $filter['product_category_id'] = $post['product_category_id'];
        }
        if ($post['brand_id']) {
            $filter['brand_id'] = $post['brand_id'];
        }

        $this->model['barcode_report'] = $this->load->model('report/barcode_report');
        $rows = $this->model['barcode_report']->getReport($filter);

        // d($rows, true);

        $rowsArr = [];
        foreach ($rows as $row) {

            $group_by = strtolower($post['report_type']) == 'warehouse' ? 'warehouse' : 'description';
            if (!isset($rowsArr[$row[$group_by]])) {
                $rowsArr[$row[$group_by]] = [
                    'warehouse' => $row['warehouse'],
                    'description' => $row['description'],
                    'data' => array()
                ];
            }
            $rowsArr[$row[$group_by]]['data'][] = $row;
        }


        if ($post['output'] == 'Excel') {

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getProperties()
                ->setCreator('Muhammad Salman')
                ->setLastModifiedBy('Muhammad Salman')
                ->setTitle('Stock Ledger Report');

            $objPHPExcel->data = array(
                'company_name' => $session['company_branch_name'],
                'report_name' => 'Barcode Report',
            );

            $rowcount = 1;

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $rowcount . ':F' . $rowcount);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcount, $session['company_branch_name']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':F' . $rowcount)->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
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
            $rowcount++;


            $objPHPExcel->getActiveSheet()->mergeCells('A' . $rowcount . ':F' . $rowcount);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcount, 'Barcode Report');
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':F' . $rowcount)->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
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
            $rowcount++;

            foreach ($rowsArr as $group_name => $row) {
                $rowcount++;
                $objPHPExcel->getActiveSheet()->mergeCells('A' . $rowcount . ':F' . $rowcount);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcount, 'Group By:  ' . $group_name);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':F' . $rowcount)->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
                        ),
                        'font' => array(
                            'bold' => true
                        )
                    )
                );
                $rowcount++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcount, 'Serial No.');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowcount, 'Batch No.');
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowcount, 'Product Category');
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowcount, 'Model');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowcount, 'Description');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowcount, 'Warehouse');
                $objPHPExcel->getActiveSheet()->getStyle('A' . $rowcount . ':F' . $rowcount)->applyFromArray(
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
                        ),
                    )
                );


                $rowcount++;
                $qty = 0;

                foreach ($row['data'] as $detail) {
                    $qty += $detail['qty'];

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcount, $detail['serial_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rowcount, $detail['batch_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowcount, $detail['product_category']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rowcount, $detail['model']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rowcount, $detail['description']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowcount, $detail['warehouse']);
                    $rowcount++;
                }
            }


            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Barcode|Report.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save('php://output');
            exit;
        } else {


            $pdf = new PDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Muhammad Salman');
            $pdf->SetTitle('Barcode Report');
            $pdf->SetSubject('Barcode Report');

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_branch_name'],
                'report_name' => 'Barcode Report',
                'date_to' => $post['date_to'],
            );

            // set margins
            $pdf->SetMargins(7, 45, 7);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->AddPage();
            // set font

            foreach ($rowsArr as $group_name => $row) {

                $pdf->SetFont('helvetica', 'B', 7);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetFont('helvetica', 'BU', 7);
                $pdf->Cell(202, 7, 'Group Name: ' . $group_name, 0, false, 'L', false, '', 0, false, 'M', 'M');
                $pdf->Ln(7);

                $qty = 0;

                foreach ($row['data'] as $detail) {


                    $qty += $detail['qty'];

                    $pdf->SetFont('helvetica', '', 7);
                    if(multili_var_length_check([$detail['description']], 70)){
   
                        $pdf->Cell(20, 7, $detail['serial_no'], 1, false, 'C', 0, '', 1, false, 'M', 'M');
                        $pdf->Cell(20, 7, $detail['batch_no'], 1, false, 'C', 0, '', 1, false, 'M', 'M');
                        $pdf->Cell(25, 7, $detail['product_category'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                        $pdf->Cell(65, 7, $detail['model'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                        $pdf->Cell(105, 7, $detail['description'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                        $pdf->Cell(50, 7, $detail['warehouse'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                        
                        $pdf->Ln(7);
                    } else {

                        $remarksArr = splitString($detail['description'], 70);
                        $length = max_array_index_count($remarksArr);

                        $pdf->Ln(-1);

                        for($index=0;$index<=($length-1);$index++){

                            if($index==0){
                                $pdf->Cell(20, 5, $detail['serial_no'], 'TLR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(20, 5, $detail['batch_no'], 'TLR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(25, 5, $detail['product_category'], 'TLR', false, 'L', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(65, 5, $detail['model'], 'TLR', false, 'L', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(105, 5, $remarksArr[$index], 'TLR', false, 'L', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(50, 5, $detail['warehouse'], 'TLR', false, 'L', 0, '', 1, false, 'M', 'M');
                            } else if($index <= ($length-1)){
                                $pdf->Cell(20, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(20, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(25, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(65, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(105, 5, $remarksArr[$index], 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(50, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                            } else {
                                $pdf->Cell(20, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(20, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(25, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(65, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(105, 5, $remarksArr[$index], 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                $pdf->Cell(50, 5, '', 'LR', false, 'C', 0, '', 1, false, 'M', 'M');
                            }
                            $pdf->Ln(5);
                            
                            if($index==$length-1){
                                $pdf->Cell(285, 5, '', 'T', false, 'R', 0, '', 1, false, 'M', 'M');
                                $pdf->Ln(6);
                                $pdf->Ln(-5);
                            }
                            
                        }
                        
                    }
                }
                $pdf->Ln(7);
            }

            //Close and output PDF document
            $pdf->Output('Barcode|Report:' . date('YmdHis') . '.pdf', 'I');
        }
    }
}


class PDF extends TCPDF
{
    public $data = array();
    //Page header
    public function Header()
    {

        // Set font
        $this->Ln(2);
        
        
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 7, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 7, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 7, 'Till Date: ' . $this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        $this->Ln(10);
        $this->SetFont('helvetica', 'B', 7);
        $this->Cell(20, 7, 'Serial No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 7, 'Batch No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 7, 'Product Category', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(65, 7, 'Model', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(105, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(50, 7, 'Warehouse', 1, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
