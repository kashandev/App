<?php

class ControllerReportBalanceSheet extends HController {

    protected function getAlias() {
        return 'report/balance_sheet';
    }

    protected function getList() {
        parent::getList();


        $this->data['action_validate_date'] = $this->url->link('common/home/validateDate', 'token=' . $this->session->data['token']);
        $this->data['action_print'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['date_from'] = stdDate($this->session->data['fiscal_date_from']);
        $this->data['date_to'] = stdDate(($this->session->data['fiscal_date_to'] > date('Y-m-d') ? '' : $this->session->data['fiscal_date_to']));
        $this->data['href_get_report'] = $this->url->link($this->getAlias() .'/getReport', 'token=' . $this->session->data['token'], 'SSL');
//        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['strValidation'] = "{
            'rules': {
                'date_from': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'date_to': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
            },
        }";

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }

    public function printReport() {


        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $this->model['balance_sheet'] = $this->load->model('report/balance_sheet');

        //$this->model['trial_balance'] = $this->load->model('report/trial_balance');
        $post = $this->request->post;
        $session = $this->session->data;

        $date_f = MySqlDate($post['date_from']);
        $date_s = MySqlDate($post['date_to']);

        $sort_order = "ASC";

        // $where =  "from_date >='$date_f'";
        //$where .= " AND to_date <='$date_s'";


        // $arrPartner = $this->model['partner']->getArrays('partner_id','name');
        // $grouping = $this->model['goods_received_report']->getTotalGoodsReceived();
        $this->model['company'] = $this->load->model('setup/company');
        $this->model['company_branch'] = $this->load->model('setup/company_branch');

        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));

        if($post['output'] == 'Excel'){
            try {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getProperties()
                    ->setCreator("Saifuddin Zakir")
                    ->setLastModifiedBy("Saifuddin Zakir")
                    ->setTitle("Trial Balance Report");

                $objPHPExcel->data = array(
                    'company_name' => $session['company_name'],
                    'company_branch_name'=>$session['company_branch_name'],
                    'report_name' => 'Balance Sheet',
                    'date_from' => $date_f,
                    'date_to' => $date_s,
                    'company_logo' => $session['company_image'],
                    'supplier_name'=>$post['supplier_name'],
                );

                $rowCount = 1;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":D".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":D".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":D".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: '.$date_f.' - To Date: '.$date_s);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ),
                        'font' => array(
                            'size' => 10
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'ebebeb')
                        )
                    )
                );
                $rowCount ++;

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":C".($rowCount));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'D'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Description')->getStyle('A'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Amount')->getStyle('D'.$rowCount)->getFont()->setBold( true );

                $arrRows = array();
                $filter = array(
                    'date_from' => $date_f,
                    'date_to'=> $date_s
                );

                $rows = $this->model['balance_sheet']->getBalanceSheet($filter);

                foreach($rows as $group) {
                    $group_name = $group['name'];
                    $sub_group_name = $group['level1_name'];

                    $arrRows[$group_name][$sub_group_name][] = array(
                        'name' => $group['name'],
                        'level1_display_name' => $group['level1_display_name'],
                        'level2_display_name' => $group['level2_display_name'],
                        'amount' => $group['amount'],
                        'level1_name'=> $group['level1_name']
                    );
                }
                foreach($arrRows as $group_name => $group_row ) {
                    $rowCount++;
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":D".($rowCount));
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $group_name);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":D".($rowCount))->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '48D1CC')
                            ),
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setBold( true )->setSize(17)->applyFromArray(
                        array(
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            ),
                        )
                    );
//                    $pdf->Cell(50, 7,html_entity_decode($group_name), 0, false, 'L', 0, '', 1);

//                    $pdf->ln(4);
                    $total_amount = 0;
                    foreach($group_row as $sub_group_name => $rows) {
                        $rowCount++;
                        $objPHPExcel->getActiveSheet()->mergeCells('B'.($rowCount).":D".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $sub_group_name);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.($rowCount).":D".($rowCount))->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '40E0D0')
                                )
                            )
                        );
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getFont()->setBold( true )->setSize(14)->applyFromArray(
                            array(
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                ),
                            )
                        );
                        $amount = 0;
                        foreach($rows as $detail) {
                            $rowCount++;
                            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":B".($rowCount));
                            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, html_entity_decode($detail['level2_display_name']));
                            $objPHPExcel->getActiveSheet()->getStyle('C'.($rowCount).":D".($rowCount))->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'AFEEEE')
                                    ),
                                    'font' => array(
                                        'size' => 12,
                                    ),
                                )
                            );

                            if($detail['amount'] < 0){
                                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ($detail['amount']*-1));
                            }
                            else{
                                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $detail['amount']);
                            }

                            $amount += $detail['amount'];

                        }

                        $rowCount++;
                        $objPHPExcel->getActiveSheet()->mergeCells('B'.($rowCount).":C".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total '.$sub_group_name);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.($rowCount).":D".($rowCount))->applyFromArray(
                            array(
                                'borders' => array(
                                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                    'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                    'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                    'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'E0FFFF')
                                ),
                                'font' => array(
                                    'size' => 12,
                                ),
                            )
                        );

                        if($amount < 0){
                            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ($amount*-1));
                        }
                        else{
                            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $amount);
                        }

                        $total_amount += $amount;
                    }

                    $rowCount++;
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":C".($rowCount));
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Total '.$group_name);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.($rowCount).":D".($rowCount))->applyFromArray(
                        array(
                            'borders' => array(
                                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                            ),
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E0FFFF')
                            ),
                            'font' => array(
                                'size' => 12,
                            ),
                        )
                    );


                    if($total_amount < 0){
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ($total_amount*-1));
                    }
                    else{
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ($total_amount));
                    }
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Balance|Sheet|Report.xls"');
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
            $pdf->SetTitle('Balance Sheet');
            $pdf->SetSubject('Balance Sheet');

            $date_from = MySqlDate($post['date_from']);
            $date_to = MySqlDate($post['date_to']);

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_name'],
                'company_branch_name'=>$session['company_branch_name'],
                'report_name' => 'Balance Sheet',
                'date_from' => $date_from,
                'date_to' => $date_to,
                'company_logo' => $session['company_image'],
                'supplier_name'=>$post['supplier_name'],
            );
            $arrRows = array();
            $filter = array(
                'date_from' => $date_from,
                'date_to'=> $date_to
            );

            $rows = $this->model['balance_sheet']->getBalanceSheet($filter);

            foreach($rows as $group) {

                $group_name = $group['name'];
                $sub_group_name = $group['level1_name'];

                $arrRows[$group_name][$sub_group_name][] = array(

                    'name' => $group['name'],
                    'level1_display_name' => $group['level1_display_name'],
                    'level2_display_name' => $group['level2_display_name'],
                    'amount' => $group['amount'],
                    'level1_name'=> $group['level1_name']

                );
            }


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
                //$pdf->ln(3);
                $pdf->SetFont('freesans', 'B', 12);

                $pdf->ln();

                $pdf->Cell(50, 7,html_entity_decode($group_name), 0, false, 'L', 0, '', 1);

                $pdf->ln(4);
                $total_amount = 0;
                foreach($group_row as $sub_group_name => $rows){
                    $pdf->SetFont('freesans', 'B', 10);
                    $pdf->ln(3);
                    $pdf->Cell(10, 7,'', 0, false, 'L', 0, '', 1);
                    $pdf->Cell(90, 7,'' .$sub_group_name, 0, false, 'L', 0, '', 1);

                    $pdf->ln(7);

                    $pdf->SetFont('freesans', '', 9);
                    $amount = 0;
                    foreach($rows as $detail) {

                        $pdf->Cell(20, 7,'', 0, false, 'L', 0, '', 1);
                        $pdf->Cell(100, 7, html_entity_decode($detail['level2_display_name']), 0, false, 'L', 0, '', 1);
                        if($detail['amount'] < 0){
                            $pdf->Cell(60, 7, number_format($detail['amount']*-1,2), 0, false, 'R', 0, '', 1);

                        }
                        else{
                            $pdf->Cell(60, 7, number_format($detail['amount'],2), 0, false, 'R', 0, '', 1);
                        }

                        $amount += $detail['amount'];

                        $pdf->ln(7);
                    }
                    $pdf->SetFont('freesans', 'B', 9);

                    $pdf->Cell(150, 7, 'Total '.$sub_group_name, 'T', false, 'L', 0, '', 1);
                    if($amount < 0){
                        $pdf->Cell(30, 7, number_format($amount*-1,2), 'T', false, 'R', 0, '', 1);
                    }
                    else{
                        $pdf->Cell(30, 7, number_format($amount,2), 'T', false, 'R', 0, '', 1);
                    }

                    $total_amount += $amount;
                    $pdf->ln(10);
                }
                $pdf->SetFont('freesans', 'B', 9);

                $pdf->Cell(150, 7, 'Total'.$group_name, 'T', false, 'L', 0, '', 1);
                if($total_amount < 0){
                    $pdf->Cell(30, 7,number_format($total_amount*-1,2), 'T', false, 'R', 0, '', 1);
                }
                else{
                    $pdf->Cell(30, 7, number_format($total_amount,2), 'T', false, 'R', 0, '', 1);
                }

                $pdf->ln(7);
            }
            $pdf->Output('Balance Sheet :'.date('YmdHis').'.pdf', 'I');
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
        $this->Cell(0, 10, $this->data['company_branch_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'B', 10);
        $this->Ln(10);
        $this->Cell(0, 10, 'From Date : '.$this->data['date_from'].'     To Date  :  '.$this->data['date_to'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(12);



        $this->SetFont('freesans', 'B', 10);
        $this->Cell(120, 7, 'Description', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(60, 7, 'Amount', 'T,B', false, 'C', 0, '', 0, false, 'M', 'M');

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