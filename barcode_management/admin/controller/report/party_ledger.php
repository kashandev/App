<?php

class ControllerReportPartyLedger extends HController {

    protected function getAlias() {
        return 'report/party_ledger';
    }

    protected function init() {
        $this->model[$this->getAlias()] = $this->load->model('gl/ledger');
        $this->data['lang'] = $this->load->language($this->getAlias());
        $this->document->setTitle($this->data['lang']['heading_title']);
        $this->data['token'] = $this->session->data['token'];
    }

    protected function getList() {
        parent::getList();

        $this->data['partner_types'] = $this->session->data['partner_types'];

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['href_get_detail_report'] = $this->url->link($this->getAlias() .'/getDetailReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_summary_report'] = $this->url->link($this->getAlias() .'/getSummaryReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_detail_report'] = $this->url->link($this->getAlias() .'/printDetailReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_summary_report'] = $this->url->link($this->getAlias() .'/printSummaryReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['date_from'] = stdDate($this->session->data['fiscal_date_from']);
        $this->data['date_to'] = stdDate(($this->session->data['fiscal_date_to'] > date('Y-m-d') ? '' : $this->session->data['fiscal_date_to']));

        $this->data['strValidation'] = "{
            'rules': {
                'date_from': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'date_to': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'people_type_id' : {'required' : true}
            },
            ignore:[],
        }";

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }

    public function getDetailReport() {
        $lang = $this->load->language('report/party_ledger');
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['party_ledger'] = $this->load->model('report/party_ledger');
        $where = "l.company_id = '".$this->session->data['company_id']."'";
        $where .= " AND l.company_branch_id = '".$this->session->data['company_branch_id']."'";
        $where .= " AND l.fiscal_year_id = '".$this->session->data['fiscal_year_id']."'";
        if($post['date_from'] != '') {
            $where .= " AND l.document_date >= '".MySqlDate($post['date_from'])."'";
        }
        if($post['date_to'] != '') {
            $where .= " AND l.document_date <= '".MySqlDate($post['date_to'])."'";
        }
        if($post['partner_type_id'] != '') {
            $where .= " AND l.partner_type_id = '".$post['partner_type_id']."'";
        }
        if($post['partner_id'] != '') {
            $where .= " AND l.partner_id = '".$post['partner_id']."'";
        }

        $rows = $this->model['party_ledger']->getPartyLedger($where);

        $html = '';
        foreach($rows as $row) {
            $html .='<tr>';
            $html .='<td>'.$row['partner_type'].'</td>';
            $html .='<td>'.$row['partner_name'].'</td>';
            $html .='<td>'.$row['document_date'].'</td>';
            $html .='<td>'.$row['document_identity'].'</td>';
            $html .='<td>'.$row['ref_document_identity'].'</td>';
            $html .='<td>'.$row['remarks'].'</td>';
            $html .='<td>'.$row['account'].'</td>';
            $html .='<td>'.$row['debit'].'</td>';
            $html .='<td>'.$row['credit'].'</td>';
            $html .='</tr>';
        }

        $json = array(
            'post' => $post,
            'rows' => $rows,
            'html' => $html,
            'success' => true,
        );

        echo json_encode($json);
        exit;
    }

    public function printDetailReport() {

        ini_set('max_execution_time',400);
        ini_set('memory_limit','3072M');

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        //d(array($lang, $post, $session), true);

        if($post['date_from'] == "") {
            $post['date_from'] = $session['date_from'];
        } else {
            $post['date_from'] = MySqlDate($post['date_from']);
        }

        if($post['date_to'] == "") {
            $post['date_to'] = $session['date_to'];
        } else {
            $post['date_to'] = MySqlDate($post['date_to']);
        }

        if($post['partner_type_id'] != "") {
            $this->model['partner_type'] = $this->load->model('common/partner_type');
            $partner_type = $this->model['partner_type']->getRow(array('partner_type_id' => $post['partner_type_id']));
            $post['partner_type'] = $partner_type['name'];
        } else {
            $post['partner_type'] = '';
        }

        if($post['partner_id'] != "") {
            $this->model['partner'] = $this->load->model('common/partner');
            $partner = $this->model['partner']->getRow(array('partner_id' => $post['partner_id']));
            $post['partner_name'] = $partner['name'];
        } else {
            $post['partner_name'] = '';
        }

        $arrLedger = array();
        $this->model['party_ledger'] = $this->load->model('report/party_ledger');

        $where = "l.company_id = '".$this->session->data['company_id']."'";
        $where .= " AND l.company_branch_id = '".$this->session->data['company_branch_id']."'";
        $where .= " AND l.fiscal_year_id = '".$this->session->data['fiscal_year_id']."'";
        if($post['date_from'] != '') {
            $where .= " AND l.document_date < '".$post['date_from']."'";
        }
        if($post['partner_type_id'] != '') {
            $where .= " AND l.partner_type_id = '".$post['partner_type_id']."'";
        }
        if($post['partner_id'] != '') {
            $where .= " AND l.partner_id = '".$post['partner_id']."'";
        }
        $rows = $this->model['party_ledger']->getPartyOpening($where, array('partner_type', 'partner_name'));
        foreach($rows as $row) {
            $arrLedger[$row['partner_type'] . ': ' . $row['partner_name']][$row['account']][] = $row;
        }
        

        $where = "l.company_id = '".$this->session->data['company_id']."'";
        $where .= " AND l.company_branch_id = '".$this->session->data['company_branch_id']."'";
        $where .= " AND l.fiscal_year_id = '".$this->session->data['fiscal_year_id']."'";
        if($post['date_from'] != '') {
            $where .= " AND l.document_date >= '".$post['date_from']."'";
        }
        if($post['date_to'] != '') {
            $where .= " AND l.document_date <= '".$post['date_to']."'";
        }
        if($post['partner_type_id'] != '') {
            $where .= " AND l.partner_type_id = '".$post['partner_type_id']."'";
        }
        if($post['partner_id'] != '') {
            $where .= " AND l.partner_id = '".$post['partner_id']."'";
        }
        $rows = $this->model['party_ledger']->getPartyLedger($where, array('partner_type', 'partner_name','document_date', 'document_identity', 'sort_order'));
        foreach($rows as $row) {
            $arrLedger[$row['partner_type'] . ': ' . $row['partner_name']][$row['account']][] = $row;
        }

        // d($arrLedger, true);

        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));
        $company_logo = $setting['value'];

        if($post['output'] == 'Excel'){
            try {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getProperties()
                    ->setCreator("Saifuddin Zakir")
                    ->setLastModifiedBy("Saifuddin Zakir")
                    ->setTitle("Party Ledger Report");

                $date_f = stdDate($post['date_from']);
                $date_s = stdDate($post['date_to']);

                $objPHPExcel->data = array(
                    'company_name' => $session['company_name'],
                    'company_branch_name'=>$session['company_branch_name'],
                    'report_name' => $lang['heading_title'],
                    'company_logo' => $company_logo,
                    'date_from' => $date_f,
                    'date_to' => $date_s
                );

                $rowCount = 1;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $lang['heading_title']);
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFill('ebebeb');
                $rowCount ++;

                    foreach($arrLedger as $partner => $accounts) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $partner);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setBold( true )->setSize(13)->applyFromArray(
                            array(
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                ),
                            )
                        );
                        $rowCount++;

                        foreach($accounts as $account => $records) {
                            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $account);
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setBold( true )->setSize(13)->applyFromArray(
                                array(
                                    'alignment' => array(
                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                    ),
                                )
                            );
                            $rowCount++;
                            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(90);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Document Date')->getStyle('A'.$rowCount)->getFont()->setBold( true );
                            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Document Identity')->getStyle('B'.$rowCount)->getFont()->setBold( true );
                            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Remarks')->getStyle('C'.$rowCount)->getFont()->setBold( true );
                            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Cheque No.')->getStyle('D'.$rowCount)->getFont()->setBold( true );
                            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Debit')->getStyle('E'.$rowCount)->getFont()->setBold( true );
                            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Credit')->getStyle('F'.$rowCount)->getFont()->setBold( true );
                            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Balance')->getStyle('G'.$rowCount)->getFont()->setBold( true );

                            $total_debit = 0;
                            $total_credit = 0;
                            foreach($records as $detail) {
                                $rowCount++;
                                $total_debit += $detail['debit'];
                                $total_credit += $detail['credit'];
                                $balance = $total_debit - $total_credit;
                                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $detail['document_date']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $detail['document_identity']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $detail['remarks']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $detail['cheque_no']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $detail['debit']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $detail['credit']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $balance);
                            }
                                $rowCount++;
                                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $total_debit)->getStyle('E'.$rowCount)->getFont()->setBold(true);
                                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $total_credit)->getStyle('F'.$rowCount)->getFont()->setBold(true);
                                $rowCount++;
                        }
                    }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Party|Ledger.xlsx"');
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
            //d($arrLedger, true);
            $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Huzaifa Khambaty');
            $pdf->SetTitle('Party Ledger Report');
            $pdf->SetSubject('Party Ledger Report');

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_name'],
                'company_branch_name'=>$session['company_branch_name'],
                'report_name' => $lang['heading_title'],
                'company_logo' => $company_logo
            );

            // set margins
            //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetMargins(7, 35, 7);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set font
            $pdf->SetFont('times', '', 8);
            $pdf->AddPage();
            foreach($arrLedger as $partner => $accounts) {
                $pdf->Ln(7);
            $pdf->SetFont('times', 'B', 8);
                $pdf->Cell(0,7,$partner);
                foreach($accounts as $account => $records) {
                    $pdf->ln(7);
                    $pdf->Cell(10,7,'');
                    $pdf->SetFont('times', 'B', 8);
                    $pdf->Cell(50,7,$account);
                    $pdf->ln(9);
                    $pdf->Cell( 7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(25, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(58, 7, 'Remarks', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7, 'Cheque No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7, 'Debit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7, 'Credit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $pdf->Cell(20, 7, 'Balance', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                    $sr = 0;
                    $total_debit = 0;
                    $total_credit = 0;
                    $pdf->Ln(1);
                    $pdf->SetFont('times', '', 8);
                    foreach($records as $detail) {
                        $total_debit += $detail['debit'];
                        $total_credit += $detail['credit'];
                        $balance = $total_debit - $total_credit;
                        $sr++;

                        if(strlen($detail['remarks'])<=55){
                            $pdf->Ln(6);
                            $pdf->Cell(7, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(25, 6, $detail['document_date'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(25, 6, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(58, 6, $detail['remarks'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 6, $detail['cheque_no'], 1, false, 'C', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 6, number_format($detail['debit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 6, number_format($detail['credit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 6, number_format($balance,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                        } else {

                            $arrRemarks = splitString($detail['remarks'], 55);
                            foreach ($arrRemarks as $index => $remark) {
                                if($index==0){
                                    $pdf->Ln(6);
                                    $pdf->Cell(7, 6, $sr, 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(25, 6, $detail['document_date'], 'LTR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(25, 6, $detail['document_identity'], 'LTR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(58, 6, $remark, 'LTR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, $detail['cheque_no'], 'LTR', false, 'C', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, number_format($detail['debit'],2), 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, number_format($detail['credit'],2), 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, number_format($balance,2), 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                                } else if($index<=count($arrRemarks)-1){
                                    $pdf->Ln(6);
                                    $pdf->Cell(7, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(25, 6, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(25, 6, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(58, 6, $remark, 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                } else {
                                    $pdf->Ln(6);
                                    $pdf->Cell(7, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(25, 6, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(25, 6, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(78, 6, $remark, 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                    $pdf->Cell(20, 6, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                                }
                            }
                        }
                    }
                    $pdf->Ln(6);
                    $pdf->Cell(7, 6, '', 'T', false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 6, '', 'T', false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 6, '', 'T', false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(58, 6, '', 'T', false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 6, '', 'T', false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 6, number_format($total_debit,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 6, number_format($total_credit,4), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 6, '', 'T', false, 'R', 0, '', 1, false, 'M', 'M');

                }
            }

            //Close and output PDF document
            $pdf->Output('Party Ledger Report:'.date('YmdHis').'.pdf', 'I');
        }
    }

    public function printSummaryReport() {
        ini_set('max_execution_time',400);
        ini_set('memory_limit','3072M');

        $lang = $this->load->language($this->getAlias());
        //d($lang,true);
        $post = $this->request->post;
        $session = $this->session->data;

        if($post['date_from'] == "") {
            $post['date_from'] = $session['date_from'];
        } else {
            $post['date_from'] = MySqlDate($post['date_from']);
        }

        if($post['date_to'] == "") {
            $post['date_to'] = $session['date_to'];
        } else {
            $post['date_to'] = MySqlDate($post['date_to']);
        }

        if($post['partner_type_id'] != "") {
            $this->model['partner_type'] = $this->load->model('common/partner_type');
            $partner_type = $this->model['partner_type']->getRow(array('partner_type_id' => $post['partner_type_id']));
            $post['partner_type'] = $partner_type['name'];
        } else {
            $post['partner_type'] = '';
        }

        if($post['partner_id'] != "") {
            $this->model['partner'] = $this->load->model('common/partner');
            $partner = $this->model['partner']->getRow(array('partner_id' => $post['partner_id']));
            $post['partner_name'] = $partner['name'];
        } else {
            $post['partner_name'] = '';
        }

        $arrLedger = array();
        $this->model['party_ledger'] = $this->load->model('report/party_ledger');

        $filter['company_id'] = $this->session->data['company_id'];
        $filter['company_branch_id'] = $this->session->data['company_branch_id'];
        $filter['fiscal_year_id'] = $this->session->data['fiscal_year_id'];
        $filter['from_date'] = $post['date_from'];
        $filter['to_date'] = $post['date_to'];
        $filter['partner_type_id'] = $post['partner_type_id'];
        $filter['partner_id'] = $post['partner_id'];

        $rows = $this->model['party_ledger']->getPartySummary($filter);
        foreach($rows as $row) {
            $arrLedger[$row['partner_type']][] = array(
                'partner_type' => $row['partner_type'],
                'partner_name' => $row['partner_name'],
                'previous' => $row['previous'],
                'cheque_no' => $row['cheque_no'],
                'debit' => $row['debit'],
                'credit' => $row['credit'],
                'balance' => $row['previous'] + $row['debit'] - $row['credit'],
            );
        }

        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $setting = $this->model['setting']->getRow(array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'general',
            'field' => 'company_logo',
        ));
        $company_logo = $setting['value'];

        if($post['output'] == 'Excel'){
            try {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getProperties()
                    ->setCreator("Saifuddin Zakir")
                    ->setLastModifiedBy("Saifuddin Zakir")
                    ->setTitle("Party Ledger Summary Report");

                $date_f = stdDate($post['date_from']);
                $date_s = stdDate($post['date_to']);

                $objPHPExcel->data = array(
                    'company_name' => $session['company_name'],
                    'company_branch_name'=>$session['company_branch_name'],
                    'report_name' => $lang['heading_title'],
                    'company_logo' => $company_logo
                );

                $rowCount = 1;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":F".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":F".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $lang['heading_title']);
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

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Partner Name')->getStyle('A'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Cheque No.')->getStyle('B'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Previous')->getStyle('C'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Debit')->getStyle('D'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Credit')->getStyle('E'.$rowCount)->getFont()->setBold( true );
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Balance')->getStyle('F'.$rowCount)->getFont()->setBold( true );

                foreach($arrLedger as $partner_type => $records) {
                    if($partner_type !== ''){
                        $rowCount++;
                        // $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':F'.$rowCount);
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $partner_type);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->applyFromArray(
                            array(
                                'font' => array(
                                    'size' => 12,
                                    'bold' => true,
                                ),
                                'borders' => array(
                                    'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                                ),
                                'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                ),
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'ebebeb')
                                )
                            )
                        );
                    }
//                    $pdf->Cell(50,7,$partner_type);

//                    $pdf->Cell(70, 7, 'Partner Name', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//                    $pdf->Cell(25, 7, 'Previous', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//                    $pdf->Cell(25, 7, 'Debit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//                    $pdf->Cell(25, 7, 'Credit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
//                    $pdf->Cell(25, 7, 'Balance', 1, false, 'C', 0, '', 0, false, 'M', 'M');

                    $total_debit = 0;
                    $total_credit = 0;

                    foreach($records as $detail) {
                        $rowCount++;
                        $total_debit += $detail['debit'];
                        $total_credit += $detail['credit'];
                        $balance = $total_debit - $total_credit;

                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $detail['partner_name']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $detail['cheque_no']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, ($detail['previous'] < 0?'CR ' . (-1 * $detail['previous']):'DR ' . $detail['previous']))->getStyle('C'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $detail['debit']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $detail['credit']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, ($detail['balance'] < 0?'CR ' . (-1 * $detail['balance']):'DR ' . $detail['balance']))->getStyle('F'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//                        $pdf->Cell(70, 6, $detail['partner_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
//                        $pdf->Cell(25, 6, ($detail['previous'] < 0?'CR ' . number_format(-1 * $detail['previous'],2):'DR ' . number_format($detail['previous'],2)), 1, false, 'R', 0, '', 1, false, 'M', 'M');
//                        $pdf->Cell(25, 6, number_format($detail['debit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
//                        $pdf->Cell(25, 6, number_format($detail['credit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
//                        $pdf->Cell(25, 6, ($detail['balance'] < 0?'CR ' . number_format(-1 * $detail['balance'],2):'DR ' . number_format($detail['balance'],2)), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    }
                    $rowCount++;
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':'.'C'.$rowCount);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $total_debit);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $total_credit);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'F'.$rowCount)->applyFromArray(
                        array(
                            'font' => array(
                                'size' => 11,
                                'bold' => true,
                            ),
                            'borders' => array(
                                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            ),
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'ffffff')
                            )
                        )
                    );

//                    $pdf->Cell(105, 6,'', 0, false, 'R', 0, '', 1, false, 'M', 'M');
//                    $pdf->Cell(25, 6, number_format($total_debit,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
//                    $pdf->Cell(25, 6, number_format($total_credit,4), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Party|Ledger|Summary.xlsx"');
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
            //d($arrLedger, true);
            $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Huzaifa Khambaty');
            $pdf->SetTitle('Party Summary Report');
            $pdf->SetSubject('Party Summary Report');

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_name'],
                'company_branch_name'=>$session['company_branch_name'],
                'report_name' => $lang['heading_title'],
                'company_logo' => $company_logo
            );

            // set margins
            //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetMargins(7, 35, 7);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set font
            $pdf->SetFont('times', '', 8);
            foreach($arrLedger as $partner_type => $records) {
                $pdf->AddPage();
                $pdf->ln(7);
                $pdf->Cell(50,7,$partner_type);
                $pdf->ln(9);
                $pdf->Cell(10, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(65, 7, 'Partner Name', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(20, 7, 'Cheque No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(25, 7, 'Previous', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(25, 7, 'Debit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(25, 7, 'Credit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Cell(25, 7, 'Balance', 1, false, 'C', 0, '', 0, false, 'M', 'M');
                $sr =0;
                $total_debit = 0;
                $total_credit = 0;
                $pdf->Ln(1);
                foreach($records as $detail) {
                    $total_debit += $detail['debit'];
                    $total_credit += $detail['credit'];
                    $balance = $total_debit - $total_credit;
                    $sr++;
                    $pdf->Ln(6);
                    $pdf->Cell(10, 6, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(65, 6, $detail['partner_name'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 6, $detail['cheque_no'], 1, false, 'C', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 6, ($detail['previous'] < 0?'CR ' . number_format(-1 * $detail['previous'],2):'DR ' . number_format($detail['previous'],2)), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 6, number_format($detail['debit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 6, number_format($detail['credit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 6, ($detail['balance'] < 0?'CR ' . number_format(-1 * $detail['balance'],2):'DR ' . number_format($detail['balance'],2)), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                }
                $pdf->Ln(6);
                $pdf->Cell(120, 6,'', 0, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($total_debit,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                $pdf->Cell(25, 6, number_format($total_credit,4), 1, false, 'R', 0, '', 1, false, 'M', 'M');
            }

            //Close and output PDF document
            $pdf->Output('Party Summary Report:'.date('YmdHis').'.pdf', 'I');
        }
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
        $this->SetFont('helvetica', 'B', 20);
        $this->Ln(2);
        // Title
        $this->Cell(0, 10, $this->data['company_branch_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
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