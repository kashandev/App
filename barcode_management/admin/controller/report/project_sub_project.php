<?php

class ControllerReportProjectSubProject extends HController {

    protected function getAlias() {
        return 'report/project_sub_project';
    }

    protected function getList() {
        parent::getList();

        $this->model['project'] = $this->load->model('setup/project');
        $this->data['projects'] = $this->model['project']->getRows(array('company_id' => $this->session->data['company_id']), array('name'));

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

        $where = "";
        $project_id = $post['project_id'];

        if($post['project_id'] != ''){
            //$filter[] =  "`project_id` = '".$post['project_id']."'";
            $where .= " `vw_core_sub_project`.`project_id`='$project_id'";
        }
        else{
            $where .= "";
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

        $this->model['project_sub_project'] = $this->load->model('report/project_sub_project');
        $rows = $this->model['project_sub_project']->getRows($where,array('project_name asc'));
        $project_name = $rows['project_name'];

        $session = $this->session->data;
        $company_logo = $setting['value'];



        if($post['output'] == 'Excel'){
            try {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getProperties()
                    ->setCreator("Saifuddin Zakir")
                    ->setLastModifiedBy("Saifuddin Zakir")
                    ->setTitle("Project & Sub-Project Report");

                $objPHPExcel->data = array(
                    'company_name' => $session['company_name'],
                    'report_name' => 'Project & Sub-Project Report',
                    'company_logo' => $session['company_image'],
                );

                $rowCount = 1;

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":B".($rowCount));
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

                $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":B".($rowCount));
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

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(70);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'B'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Project Name')->getStyle('A'.$rowCount)->getFont()->setBold( true )->setSize(13);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Sub-Project Name')->getStyle('B'.$rowCount)->getFont()->setBold( true )->setSize(13);
                $rowCount++;

                foreach($rows as $detail) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $detail['project_name'])->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $detail['name'])->getStyle('B'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $rowCount++;

//                    $pdf->Cell(80, 6, $detail['project_name'], 0, false, 'C', 0, '', 1);
//                    $pdf->Cell(80, 6, $detail['name'], 0, false, 'C', 0, '', 1);
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
            $pdf->SetTitle('Project & Sub Project Report');
            $pdf->SetSubject('Project & Sub Project Report');

            //Set Header
            $pdf->data = array(
                'company_name' => $session['company_name'],
                'report_name' => $lang['heading_title'],
                'company_logo' => $company_logo
            );

            // set margins
            //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetMargins(15, 35, 15);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set font
            $pdf->SetFont('times', '', 10);

            $pdf->AddPage();



            $pdf->ln(15);
            $pdf->Cell(  20, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');


            $pdf->Cell( 80, 7, 'Project Name.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell( 80, 7, 'Sub Project Name.', 1, false, 'C', 0, '', 0, false, 'M', 'M');


            $sr =0;
            $pdf->Ln(1);
            foreach($rows as $detail) {
                $sr++;
                $pdf->Ln(6);
                $pdf->Cell(20, 6, $sr, 0, false, 'C', 0, '', 1);

                $pdf->Cell(80, 6, $detail['project_name'], 0, false, 'C', 0, '', 1);

                $pdf->Cell(80, 6, $detail['name'], 0, false, 'C', 0, '', 1);
            }
            //Close and output PDF document
            $pdf->Output('Ledger Report:'.date('YmdHis').'.pdf', 'I');
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