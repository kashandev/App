<?php

class ControllerReportProjectSummaryReport extends HController {

    protected function getAlias() {
        return 'report/project_summary_report';
    }

    protected function getList() {
        parent::getList();

        $this->model['project'] = $this->load->model('setup/project');
        $this->data['projects'] = $this->model['project']->getRows(array('company_id' => $this->session->data['company_id']), array('name'));

        $this->model['applicant'] = $this->load->model('qarze_hassana/applicant');
        $this->data['applicants'] = $this->model['applicant']->getRows(array('company_id' => $this->session->data['company_id']));

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


        ini_set('max_execution_time',400);
        ini_set('memory_limit','3072M');

        $lang=$this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;


        $this->model['project_summary_report'] = $this->load->model('report/project_summary_report');

        $filter = array(
            'company_id' => $session['company_id'],
            'company_branch_id' => $session['company_branch_id'],
            'fiscal_year_id' => $session['fiscal_year_id'],
            'project_id' => $post['project_id'],
            'sub_project_id' => $post['sub_project_id'],
        );

        $rows = $this->model['project_summary_report']->getData($filter);

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

        if($post['output'] == 'Excel'){
            try {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getProperties()
                    ->setCreator("Saifuddin Zakir")
                    ->setLastModifiedBy("Saifuddin Zakir")
                    ->setTitle("Project Summary Report");

                $objPHPExcel->data = array(
                    'company_name' => $session['company_name'],
                    'report_name' => $lang['heading_title'],
                    'company_logo' => $company_logo,
                );

                $rowCount = 1;

                /* COMPANY NAME */
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":J".($rowCount))->applyFromArray(
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
                        ),
                        'borders' => array(
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );
                $rowCount ++;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $lang['heading_title']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":J".($rowCount))->applyFromArray(
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
                        ),
                        'borders' => array(
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );
                $rowCount ++;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Project: '.$this->project['project_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":J".($rowCount))->applyFromArray(
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
                        ),
                        'borders' => array(
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );
                $rowCount ++;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Sub Project: '.$this->project['sub_project_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":J".($rowCount))->applyFromArray(
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
                        ),
                        'borders' => array(
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );
                $rowCount ++;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":H".($rowCount));
                $objPHPExcel->getActiveSheet()->mergeCells('I'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Chart of Account');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Amount');
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":J".($rowCount))->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        ),
                        'font' => array(
                            'size' => 16
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'ebebeb')
                        ),
                        'borders' => array(
                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );

                $arrRows = array();
                if($post['project_id'] != ''){
                    foreach($rows as $detail) {

                        $objPHPExcel->project = array(
                            'project_name' => $detail['project_name']
                        );

                        $group_name = $detail['sub_project_name'];
                        $sub_group = $detail['gl'];

                        $arrRows[$group_name][$sub_group][] = array(
                            'display_name' => $detail['display_name'],
                            'balance' => $detail['balance'],
                        );
                    }
                }else{
                    foreach($rows as $detail) {
                        $group_name = '';
                        $sub_group = $detail['gl'];

                        $arrRows[$group_name][$sub_group][] = array(
                            'display_name' => $detail['display_name'],
                            'balance' => $detail['balance'],
                        );
                    }
                }

                if($post['sub_project_id'] != ''){
                    foreach($rows as $detail) {
                        $objPHPExcel->sub_project = array(
                            'sub_project_name' => $detail['sub_project_name']
                        );
                    }
                }

                $total_income = 0;
                $total_expense = 0;
//                d($arrRows, true);
                foreach($arrRows as $group_name => $group_row )
                {
                    $rowCount++;
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $group_row);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
                        array(
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            ),
                            'font' => array(
                                'size' => 16
                            ),
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'ebebeb')
                            ),
                        )
                    );

                    $total_amount = 0;
                    foreach($group_row as $sub_group_name => $rows){
                        $rowCount ++;
                        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":J".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $sub_group_name);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
                            array(
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                ),
                                'font' => array(
                                    'size' => 16
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'ebebeb')
                                ),

                            )
                        );
                        $amount = 0;
                        foreach($rows as $detail)
                        {
                            $rowCount++;
                            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":H".($rowCount));
                            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $detail['display_name']);
                            $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":H".($rowCount))->applyFromArray(
                                array(
                                    'alignment' => array(
                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                    ),
                                    'font' => array(
                                        'size' => 13
                                    ),
                                    'borders' => array(
                                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                                    ),
                                )
                            );

                            if($detail['balance'] < 0){
                                $objPHPExcel->getActiveSheet()->mergeCells('I'.($rowCount).":J".($rowCount));
                                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '('.($detail['balance']*-1).')');
                                $objPHPExcel->getActiveSheet()->getStyle('I'.($rowCount).":J".($rowCount))->applyFromArray(
                                    array(
                                        'alignment' => array(
                                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                        ),
                                        'font' => array(
                                            'size' => 13
                                        ),
                                        'borders' => array(
                                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                                        ),
                                    )
                                );

                            }
                            else{
                                $objPHPExcel->getActiveSheet()->mergeCells('I'.($rowCount).":J".($rowCount));
                                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $detail['balance']);
                                $objPHPExcel->getActiveSheet()->getStyle('I'.($rowCount).":J".($rowCount))->applyFromArray(
                                    array(
                                        'alignment' => array(
                                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                        ),
                                        'font' => array(
                                            'size' => 13
                                        ),
                                        'borders' => array(
                                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                                        ),
                                    )
                                );

                            }
                            $amount += $detail['balance'];
                        }
                        $total_amount += $amount;

                        if($sub_group_name == 'INCOME'){
                            $total_income += $total_amount;
                        }
                        else{
                            $total_expense += $total_amount;
                        }
                    }
                    $rowCount++;
                }
                $rowCount++;
                $objPHPExcel->getActiveSheet()->mergeCells('G'.($rowCount).":H".($rowCount));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($rowCount), 'Total Income');
                $objPHPExcel->getActiveSheet()->getStyle('G'.($rowCount).":H".($rowCount))->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ),
                        'font' => array(
                            'size' => 13
                        ),
                        'borders' => array(
                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );
                $objPHPExcel->getActiveSheet()->mergeCells('I'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($rowCount), $total_income);
                $objPHPExcel->getActiveSheet()->getStyle('I'.($rowCount).":J".($rowCount))->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        ),
                        'font' => array(
                            'size' => 13
                        ),
                        'borders' => array(
                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );

                $rowCount++;
                $objPHPExcel->getActiveSheet()->mergeCells('G'.($rowCount).":H".($rowCount));
                $objPHPExcel->getActiveSheet()->setCellValue('G'.($rowCount), 'Total Expense');
                $objPHPExcel->getActiveSheet()->getStyle('G'.($rowCount).":H".($rowCount))->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ),
                        'font' => array(
                            'size' => 13
                        ),
                        'borders' => array(
                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );
                $objPHPExcel->getActiveSheet()->mergeCells('I'.($rowCount).":J".($rowCount));
                $objPHPExcel->getActiveSheet()->setCellValue('I'.($rowCount), '('. number_format($total_expense*-1).')');
                $objPHPExcel->getActiveSheet()->getStyle('I'.($rowCount).":J".($rowCount))->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        ),
                        'font' => array(
                            'size' => 13
                        ),
                        'borders' => array(
                            'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                        ),
                    )
                );

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Project|Summary|Report.xls"');
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
            $pdf->SetTitle('Project Summary Report');
            $pdf->SetSubject('Project Summary Report');

            $date_f = stdDate($post['date_from']);
            $date_s = stdDate($post['date_to']);

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_name'],
                'report_name' => $lang['heading_title'],
                'company_logo' => $company_logo,
                'date_from' => $date_f,
                'date_to' => $date_s,

            );
            $arrRows = array();
            if($post['project_id'] != ''){
                foreach($rows as $detail) {

                    $pdf->project = array(
                        'project_name' => $detail['project_name']
                    );

                    $group_name = $detail['sub_project_name'];
                    $sub_group = $detail['gl'];

                    $arrRows[$group_name][$sub_group][] = array(
                        'display_name' => $detail['display_name'],
                        'balance' => $detail['balance'],
                    );
                }
            }else{
                foreach($rows as $detail) {

                    $group_name = '';
                    $sub_group = $detail['gl'];

                    $arrRows[$group_name][$sub_group][] = array(
                        'display_name' => $detail['display_name'],
                        'balance' => $detail['balance'],
                    );
                }
            }

            if($post['sub_project_id'] != ''){
                foreach($rows as $detail) {

                    $pdf->sub_project = array(
                        'sub_project_name' => $detail['sub_project_name']
                    );
                }
            }

//        foreach($revenue_rows as $group) {
//
//            $group_name = $group['project_name'];
//
//
//            $arrRows[$group_name][] = array(
//
//                'display_name' => $group['display_name'],
//                'balance' => $group['balance'],
//
//
//            );
//        }

            // set margins
            //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetMargins(15, 65, 15);
            $pdf->SetHeaderMargin(10);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set font

            $pdf->AddPage();

            $pdf->Ln(1);

            $pdf->SetFont('freesans', '', 8);
            $pdf->SetFillColor(255,255,255);

            //d($rows,true);

            $pdf->SetFont('freesans', 'B', 16);


            $total_income = 0;
            $total_expense = 0;
            //d($arrRows,true);
            foreach($arrRows as $group_name => $group_row )
            {

                $pdf->SetFont('freesans', 'B', 12);

                $pdf->Cell(0, 8,html_entity_decode($group_name), 0, false, 'L', 0, '', 1);

                $pdf->ln(8);
                $total_amount = 0;
                foreach($group_row as $sub_group_name => $rows){
                    $pdf->SetFont('freesans', 'B', 11);

                    $pdf->Cell(90, 7,'' .$sub_group_name, 0, false, 'L', 0, '', 1);

                    $pdf->ln(12);

                    $amount = 0;
                    foreach($rows as $detail)
                    {


                        $pdf->SetFont('freesans', 'B', 12);

                        $pdf->SetFont('freesans', '', 10);
                        $pdf->Cell(140, 8, $detail['display_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                        if($detail['balance'] < 0){
                            $pdf->Cell(40, 8, '('.number_format($detail['balance']*-1,2).')', 1, false, 'R', 0, '', 1, false, 'M', 'M');

                        }
                        else{
                            $pdf->Cell(40, 8, number_format($detail['balance'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');

                        }

                        $pdf->Ln(8);

                        $amount += $detail['balance'];


                    }
                    $total_amount += $amount;

                    if($sub_group_name == 'INCOME'){
                        $total_income += $total_amount;
                    }
                    else{
                        $total_expense += $total_amount;
                    }
                }

            }
            $pdf->SetFont('freesans', 'B', 10);
            $pdf->Ln(5);
            $pdf->Cell(140, 8,'Total Income : ', 0, false, 'R', 0, '', 1, false, 'M', 'M');

            $pdf->Cell(40, 8, number_format($total_income,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Ln(8);

            $pdf->Cell(140, 8,'Total Expense : ', 0, false, 'R', 0, '', 1, false, 'M', 'M');

            $pdf->Cell(40, 8,'('. number_format($total_expense*-1,2).')', 1, false, 'R', 0, '', 1, false, 'M', 'M');




            //Close and output PDF document
            $pdf->Output('Project Summary Report:'.date('YmdHis').'.pdf', 'I');
        }
    }

}

class PDF extends TCPDF {
    public $data = array();
    public $project = array();
    public  $sub_project = array();
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
        $this->SetFont('helvetica', 'B', 16);

        $this->Ln(10);
        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Ln(10);
        $this->SetFont('helvetica', 'B', 14);
//
//        //$this->Cell(0, 10, 'From Date : '.$this->data['date_from'].'     To Date  :  '.$this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $this->Cell(0, 10, 'Till Date : '.$this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
//        $this->Ln(8);

        $this->Cell(0, 10, 'Project : '.$this->project['project_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->Cell(0, 10, 'Sub Project : '.$this->sub_project['sub_project_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->SetFont('freesans', 'B',11);
        $this->Cell(140, 7, 'Chart Of Account', 'T,B', false, 'L', 0, '', 0, false, 'M', 'M');
        $this->Cell(40, 7, 'Amount', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');

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