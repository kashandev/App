<?php

class ControllerReportIncomeStatement extends HController {

    protected function getAlias() {
        return 'report/income_statement';
    }

    protected function getDefaultOrder() {
        return 'cao_level1_id';
    }

    protected function getDefaultSort() {
        return 'ASC';
    }

    protected function getList() {
        parent::getList();

        $this->data['date_to'] = stdDate();
        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_excel'] = $this->url->link($this->getAlias() .'/printReportExcel', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);

        $this->data['strValidation'] = "{
            'rules': {
                'date_from': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
                'date_to': {'required': true, 'remote':  {url: '" . $this->data['action_validate_date'] . "', type: 'post'}},
            },
        }";

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }

    public function printReportExcel()
    {
        $this->init();

        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        // d($post,true);
        $session = $this->session->data;
        $arrFilter['to_date'] = $post['date_to'];
        $arrFilter['level'] = $post['level'];

        $this->model['company']=$this->load->model('setup/company');
        $company=$this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['image'] = $this->load->model('tool/image');
        $company_image = $this->model['image']->resize($company['company_logo'],100,100);
        //d($company_image,true);
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company_branch=$this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['income_statement'] = $this->load->model('report/income_statement');
        $where = "l.company_id='".$this->session->data['company_id']."'";
        $where .= " AND l.fiscal_year_id='".$this->session->data['fiscal_year_id']."'";
        $where .= " AND l.document_date<='".MySqlDate($this->request->post['date_to'])."'";

        $rows = $this->model['income_statement']->getIncomeStatement($where,array('level1_code,level2_code,level3_code ASC'));
        //d($rows);
        foreach($rows as $row){
            $arrRows[$row['level1_display_name']][$row['level2_display_name']][] = array(
                'level3_display_name' => $row['level3_display_name'],
                'debit' => ($row['balance'] > 0 ? $row['balance'] : 0),
                'credit' => ($row['balance'] < 0 ? (-1 * $row['balance']) : 0)
            );
        }
        //d(array($this->request->post,$where,$rows,$arrRows),true);

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

//        echo '<pre>';
//        print_r($arrRows);
//        exit;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getProperties()
            ->setCreator("Farrukh Afaq")
            ->setLastModifiedBy("Hira")
            ->setTitle("Balance Sheet");

        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'report_name' => 'Balance Sheet'
        );

        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":I".($rowCount));
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

        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":I".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Balance Sheet');
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

        $total_debit = 0;
        $total_credit = 0;
        foreach ($arrRows as $key => $value)
        {
            if($post['display_level'] > 1)
            {
                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":I".($rowCount));
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $key);
                $rowCount ++;    
            }

            $level1_debit=0;
            $level1_credit=0;
            
            foreach ($value as $key_1 => $val_1)
            {
                if($post['display_level']==3) {
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.($rowCount).":G".($rowCount));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $key_1);
                    $rowCount ++;    
                }

                $level2_debit = 0;
                $level2_credit = 0;
                

                foreach ($val_1 as $key_2 => $val_2)
                {
                    if($post['display_level']==3) {
                        $objPHPExcel->getActiveSheet()->mergeCells('C'.($rowCount).":G".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $val_2['level3_display_name']);
                        //$objPHPExcel->getActiveSheet()->mergeCells('H'.($rowCount).":I".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Debit');
                        //$objPHPExcel->getActiveSheet()->mergeCells('F'.($rowCount).":G".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Credit');
                        $rowCount ++;
                        //$objPHPExcel->getActiveSheet()->mergeCells('C'.($rowCount).":E".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $val_2['debit']);
                        //$objPHPExcel->getActiveSheet()->mergeCells('F'.($rowCount).":G".($rowCount));
                        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $val_2['credit']);
                        $rowCount ++;
                    }

                    $level2_debit += $val_2['debit'];
                    $level2_credit += $val_2['credit'];

                    $total_debit += $val_2['debit'];
                    $total_credit += $val_2['credit'];
                }
                if($post['display_level'] > 1) {
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.($rowCount).":G".($rowCount));
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $key_1);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $level2_debit);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $level2_credit);
                    $rowCount ++;    
                }

                $level1_debit += $level2_debit;
                $level1_credit += $level2_credit;
            }
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":I".($rowCount));
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $key);
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $level1_debit);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $level1_credit);
            $rowCount ++;
        }

        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $total_debit);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $total_credit);
        $rowCount++;
        $rowCount++;
        if($total_debit - $total_credit >= 0)
        {
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Net Profit');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.($rowCount).":I".($rowCount));
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, ($total_debit - $total_credit));
                
        }
        else
        {
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Net Loss');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.($rowCount).":I".($rowCount));
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, ($total_debit - $total_credit));
            
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit and Loss.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
        exit;

    }

    public function printReport() {
        $this->init();
        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;
        $arrFilter['to_date'] = $post['date_to'];
        $arrFilter['level'] = $post['level'];
        $this->model['company']=$this->load->model('setup/company');
        $company=$this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));
        $this->model['image'] = $this->load->model('tool/image');
        $company_image = $this->model['image']->resize($company['company_logo'],100,100);
        //d($company_image,true);
        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company_branch=$this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id']));
        $this->model['income_statement'] = $this->load->model('report/income_statement');
        $where = "l.company_id='".$this->session->data['company_id']."'";
        $where .= " AND l.fiscal_year_id='".$this->session->data['fiscal_year_id']."'";
        $where .= " AND l.document_date<='".MySqlDate($this->request->post['date_to'])."'";
        $rows = $this->model['income_statement']->getIncomeStatement($where,array('level1_code,level2_code,level3_code ASC'));
        //d($rows);
        foreach($rows as $row){
            $arrRows[$row['level1_display_name']][$row['level2_display_name']][] = array(
                'level3_display_name' => $row['level3_display_name'],
                'debit' => ($row['balance'] > 0 ? $row['balance'] : 0),
                'credit' => ($row['balance'] < 0 ? (-1 * $row['balance']) : 0)
            );
        }
        //d(array($this->request->post,$where,$rows,$arrRows),true);
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
        //d($arrLedger, true);
        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Income Statement');
        $pdf->SetSubject('Income Statement');
        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'company_logo' => $company_logo
        );
        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(15, 35, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set font
        $pdf->SetFont('helvetica', '', 12);
        // add a page
        $pdf->AddPage();
        $total_debit = 0;
        $total_credit = 0;
        foreach($arrRows as $level1_display_name => $level2) {
            if($post['display_level'] > 1) {
                $pdf->ln(10);
                $pdf->SetFillColor(255,255,255);
                $pdf->Cell(0,10,$level1_display_name,'B',0,'',1);
            }
            $level1_debit=0;
            $level1_credit=0;

            foreach($level2 as $level2_display_name => $level3) {
                if($post['display_level']==3) {
                    $pdf->ln(10);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(15,10,'',0,0,'',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(175,10,$level2_display_name,'B',0,'L',1);
                }
                $level2_debit = 0;
                $level2_credit = 0;
                foreach($level3 as $record) {
                    if($post['display_level']==3) {
                        $pdf->ln(10);
                        $pdf->SetFillColor(255,255,255);
                        $pdf->Cell(15,10,'',0,0,'',1);
                        $pdf->SetFillColor(255,255,255);
                        $pdf->Cell(15,10,'',0,0,'',1);
                        $pdf->SetFillColor(255,255,255);
                        $pdf->Cell(100,10,$record['level3_display_name'],0,0,'L',1);
                        $pdf->Cell(30,10,number_format($record['debit'],2),0,0,'R',1);
                        $pdf->Cell(30,10,number_format($record['credit'],2),0,0,'R',1);
                    }
                    $level2_debit += $record['debit'];
                    $level2_credit += $record['credit'];

                    $total_debit += $record['debit'];
                    $total_credit += $record['credit'];
                }
                if($post['display_level'] > 1) {
                    $pdf->ln(10);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(15,10,'',0,0,'',1);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(115,10,$level2_display_name,0,0,'L',1);
                    $pdf->Cell(30,10,number_format($level2_debit,2),0,0,'R',1);
                    $pdf->Cell(30,10,number_format($level2_credit,2),0,0,'R',1);
                }

                $level1_debit += $level2_debit;
                $level1_credit += $level2_credit;
            }
            $pdf->ln(10);
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(130,10,$level1_display_name,0,0,'L',1);
            $pdf->Cell(30,10,number_format($level1_debit,2),0,0,'R',1);
            $pdf->Cell(30,10,number_format($level1_credit,2),0,0,'R',1);
        }
        $pdf->ln(10);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(130,10,'',0,0,'',1);
        $pdf->Cell(30,10,number_format($total_debit,2),0,0,'R',1);
        $pdf->Cell(30,10,number_format($total_credit,2),0,0,'R',1);
        if(($total_credit-$total_debit) >= 0) {
            $pdf->ln(10);
            $pdf->Cell(160,10,'Net Profit',0,0,'',1);
            $pdf->Cell(30,10,number_format(($total_credit-$total_debit),2),0,0,'R',1);
        } else {
            $pdf->ln(10);
            $pdf->SetFillColor(255,255,255);
            $pdf->Cell(160,10,'Net Loss',0,0,'',1);
            $pdf->Cell(30,10,number_format(($total_debit-$total_credit),2),0,0,'R',1);
        }
        //Close and output PDF document
        $pdf->Output('Income Statement:'.date('YmdHis').'.pdf', 'I');
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
            $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        $this->Ln(2);
        // Title
        $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
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