<?php

class ControllerReportBudgetTransactionReport extends HController {

    protected function getAlias() {
        return 'report/budget_transaction_report';
    }

    protected function getList() {
        parent::getList();

        $this->model['budget_transaction'] = $this->load->model('budget/budget_transaction');
        $this->data['budgets'] = $this->model['budget_transaction']->getRows();

        $this->data['action_validate_date'] = $this->url->link('common/home/validateDate', 'token=' . $this->session->data['token']);
        $this->data['action_print'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['date_from'] = stdDate($this->session->data['fiscal_date_from']);
        $this->data['date_to'] = stdDate(($this->session->data['fiscal_date_to'] > date('Y-m-d') ? '' : $this->session->data['fiscal_date_to']));
        $this->data['href_get_sub_project'] = $this->url->link($this->getAlias() .'/getSubProject', 'token=' . $this->session->data['token'], 'SSL');
        //  $this->data['href_get_coa_level3'] = $this->url->link($this->getAlias() .'/getCOALevel3', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_report'] = $this->url->link($this->getAlias() .'/getReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['strValidation'] = "{
            'rules': {
                'date_from': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'date_to': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
            },
        }";

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }

    public function getSubProject(){
        $project_id = $this->request->post['project_id'];
        $this->model['sub_project'] = $this->load->model('setup/sub_project');
        $rows = $this->model['sub_project']->getRows(array('company_id' => $this->session->data['company_id'], 'project_id' => $project_id),array('name'));

        $html = "";
        $html .= '<option value="">&nbsp;</option>';
        foreach($rows as $row) {
            $html .= '<option value="'.$row['sub_project_id'].'">'.$row['name'].'</option>';
        }

        $json = array('success' => true, 'html' => $html);
        echo json_encode($json);

    }




    public function printReport() {


        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $this->model['budget_transaction_report'] = $this->load->model('report/budget_transaction_report');

        //$this->model['trial_balance'] = $this->load->model('report/trial_balance');
        $post = $this->request->post;
        $session = $this->session->data;

        $date_f = MySqlDate($post['date_from']);
        $date_s = MySqlDate($post['date_to']);
        $budget_id = $post['budget_transaction_id'];


        $project_id = $post['project_id'];
        $sub_project_id = $post['sub_project_id'];

        $sort_order = "ASC";

       // $where =  "from_date >='$date_f'";
        //$where .= " AND to_date <='$date_s'";
        if($budget_id != ''){
            $where = " budget_transaction_id = '".$budget_id."'";
        }


       // $arrPartner = $this->model['partner']->getArrays('partner_id','name');
        // $grouping = $this->model['goods_received_report']->getTotalGoodsReceived();
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');

        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $rows = $this->model['budget_transaction_report']->getRows($where);
        //d($rows,true);
        $branch = $this->model['company_branch']->getRow(array('company_branch_id' => $session['company_branch_id']));

        $arrRows = array();

        foreach($rows as $group) {

            $group_name = $group['budget_name'];
            $sub_group_name = $group['sub_budget_name'];

            $arrRows[$group_name][$sub_group_name][] = array(

                'budget_title' => $group['budget_title'],
                'budget_name' => $group['budget_name'],
                'last_year_amount' => $group['last_year_amount'],
                'current_year_amount' => $group['current_year_amount'],
                'utilize_amount' => $group['utilize_amount'],
                'coa_name' => $group['coa_name']

            );
        }

        //$arrFilter['supplier'] = $post['partner_type_id'];
        //$arrFilter['product_id'] = $post['product_id'];
        //$arrFilter['company_id'] = $session['company_id'];
        //$arrFilter['branch_id'] = $post['branch_id'];

//        $arrFilter['level'] = $post['level'];


        // $rows = $this->model['trial_balance']->getTrailBalanceConsolidate($arrFilter);

        if($post['output'] == 'Excel'){
            try {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getProperties()
                    ->setCreator("Saifuddin Zakir")
                    ->setLastModifiedBy("Saifuddin Zakir")
                    ->setTitle("Qarze-e-Hassana Budget Transaction Report");

                $date_from = $post['date_from'];
                $date_to = $post['date_to'];

                $objPHPExcel->data = array(
                    'company_name' => $session['company_name'],
                    'company_address' => $branch['address'],
                    'company_phone' => $branch['phone_no'],
                    'report_name' => 'Budget Transaction Report',
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                    'company_logo' => $session['company_image'],
                    'supplier_name'=>$post['supplier_name'],
                );

                $rowCount = 1;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":E".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":E".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":E".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: '.$date_from.' - To Date: '.$date_to);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ),
                        'font' => array(
                            'size' => 10,
                            'bold' => true,
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'ebebeb')
                        )
                    )
                );
                $rowCount ++;

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

//                $objPHPExcel->getActiveSheet()->freezePane('A5');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'E'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Budget Title')->getStyle('A'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Last Year')->getStyle('B'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Current Year')->getStyle('C'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Utilized Year')->getStyle('D'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Variance')->getStyle('E'.$rowCount)->getFont()->setBold( true );

                foreach($arrRows as $group_name => $group_row ) {
                    if($group_name !== ''){
                        $rowCount++;
                        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'E'.$rowCount);
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $group_name);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'E'.$rowCount)->applyFromArray(
                            array(
                                'font' => array(
                                    'size' => 11,
                                    'bold' => true,
                                ),
                                'borders' => array(
                                    'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'ffffff')
                                )
                            )
                        );
                    }
//                    $pdf->Cell(50, 7,html_entity_decode($group_name), 0, false, 'L', 0, '', 1);

                    foreach($group_row as $sub_group_name => $rows){
                        if($sub_group_name !== ''){
                            $rowCount++;
                            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'E'.$rowCount);
                            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $sub_group_name);
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'E'.$rowCount)->applyFromArray(
                                array(
                                    'font' => array(
                                        'size' => 11,
                                        'bold' => true,
                                    ),
                                    'borders' => array(
                                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                    ),
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ffffff')
                                    )
                                )
                            );
                        }
//                        $pdf->Cell(90, 7,'' .$sub_group_name, 0, false, 'L', 0, '', 1);

                        foreach($rows as $detail) {
                            $rowCount++;

                            $variance = $detail['current_year_amount'] - $detail['utilize_amount'];

                            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, html_entity_decode($detail['coa_name']));
                            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $detail['last_year_amount']);
                            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $detail['current_year_amount']);
                            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $detail['utilize_amount']);
                            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $variance);

//                            $pdf->Cell(70, 6, html_entity_decode($detail['coa_name']), 1, false, 'C', 0, '', 1);
//                            $pdf->Cell(30, 6, $detail['last_year_amount'], 1, false, 'C', 0, '', 1);
//                            $pdf->Cell(30, 6, $detail['current_year_amount'], 1, false, 'C', 0, '', 1);
//                            $pdf->Cell(30, 6, $detail['utilize_amount'], 1, false, 'C', 0, '', 1);
//                            $pdf->Cell(30, 6, $variance, 1, false, 'C', 0, '', 1);

                        }
                    }
                }



//                $rowCount++;
//                $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'C'.$rowCount);
//                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Grand Total')->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $total_amount);
//                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'D'.$rowCount)->applyFromArray(
//                    array(
//                        'font' => array(
//                            'size' => 11,
//                            'bold' => true,
//                        ),
//                        'borders' => array(
//                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
//                        ),
//                        'fill' => array(
//                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                            'color' => array('rgb' => 'ffffff')
//                        )
//                    )
//                );

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="QH|Budget|Transaction|Report.xls"');
                header('Cache-Control: max-age=0');
                //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                //$objWriter->save('some_excel_file.xlsx');
                $objWriter->save('php://output');
                exit;
            } catch(Exception $e) {
                d($e, true);
            }
        }else{
            $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Aamir Shakil');
            $pdf->SetTitle('Budget Transaction Report');
            $pdf->SetSubject('Budget Transaction Report');

            $date_from = $post['date_from'];
            $date_to = $post['date_to'];

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_name'],
                'company_address' => $branch['address'],
                'company_phone' => $branch['phone_no'],
                'report_name' => 'Budget Transaction Report',
                'date_from' => $date_from,
                'date_to' => $date_to,
                'company_logo' => $session['company_image'],
                'supplier_name'=>$post['supplier_name'],
            );



            // set margins
            //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetMargins(10, 47, 10);
            $pdf->SetHeaderMargin(2);
            $pdf->SetFooterMargin(2);

            // set auto page breaks
            //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set font
            $pdf->SetFont('times', 'B', 10);

            $pdf->Ln(0);

            // add a page
            $pdf->AddPage();
            //d($arrRows,true);
            foreach($arrRows as $group_name => $group_row )
            {
                $pdf->ln(3);
                $pdf->SetFont('times', 'B', 10);

                $pdf->ln();
                $pdf->Cell(50, 7,html_entity_decode($group_name), 0, false, 'L', 0, '', 1);

                $pdf->ln(4);

                foreach($group_row as $sub_group_name => $rows){
                    $pdf->SetFont('freesans', 'B,U', 9);
                    $pdf->ln(3);

                    $pdf->Cell(90, 7,'' .$sub_group_name, 0, false, 'L', 0, '', 1);

                    $pdf->ln(7);


                    foreach($rows as $detail) {

                        $variance = $detail['current_year_amount'] - $detail['utilize_amount'];
                        $pdf->SetFont('times', '', 9);

                        $pdf->Cell(70, 6, html_entity_decode($detail['coa_name']), 1, false, 'C', 0, '', 1);
                        $pdf->Cell(30, 6, $detail['last_year_amount'], 1, false, 'C', 0, '', 1);
                        $pdf->Cell(30, 6, $detail['current_year_amount'], 1, false, 'C', 0, '', 1);
                        $pdf->Cell(30, 6, $detail['utilize_amount'], 1, false, 'C', 0, '', 1);
                        $pdf->Cell(30, 6, $variance, 1, false, 'C', 0, '', 1);



                        $pdf->ln(6);
                        //$total_cur_debit += $LedgerDetail['cur_debit'];
                        //$total_cur_credit += $LedgerDetail['cur_credit'];
                        //$total_tot_debit += $LedgerDetail['tot_debit'];
                        //$total_tot_credit += $LedgerDetail['tot_credit'];
                    }
                }
            }
            $pdf->Output('Budget Transaction Report :'.date('YmdHis').'.pdf', 'I');
        }
    }
}

class PDF extends TCPDF {
    public $data = array();
    public $sub_project = array();

    //Page header
    public function Header() {
        // Logo
        if($this->data['company_logo'] != '') {
            $image_file = DIR_IMAGE.$this->data['company_logo'];
            //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
            $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        $this->Ln(5);
        // Title
        $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);

        $this->Cell(0, 10, ''.$this->sub_project['sub_project_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'B', 10);
        $this->Ln(2);
        $this->Cell(0, 10, 'From Date : '.$this->data['date_from'].'     To Date  :  '.$this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(12);



        $this->SetFont('times', 'B', 9);
        $this->Cell(70, 5, 'Budget Title', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(30, 5, 'Last Year', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(30, 5, 'Current Year', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(30, 5, 'Utilize Amount', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(30, 5, 'Variance', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');

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