<?php

class ControllerReportLedgerReport extends HController {

    protected function getAlias() {
        return 'report/ledger_report';
    }

    protected function getList() {
        parent::getList();

        $this->model['coa_level2'] = $this->load->model('gl/coa_level2');
        $this->data['coa_levels2'] = $this->model['coa_level2']->getRows(array('company_id' => $this->session->data['company_id']), array('name'));

        $this->model['coa_level3'] = $this->load->model('gl/coa_level3');
        $this->data['coas'] = $this->model['coa_level3']->getRows(array('company_id' => $this->session->data['company_id']), array('name'));

        $this->data['action_validate_date'] = $this->url->link('common/home/validateDate', 'token=' . $this->session->data['token']);
        $this->data['action_print'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['date_from'] = stdDate($this->session->data['fiscal_date_from']);
        $this->data['date_to'] = stdDate(($this->session->data['fiscal_date_to'] > date('Y-m-d') ? '' : $this->session->data['fiscal_date_to']));
        $this->data['href_get_coa_level2'] = $this->url->link($this->getAlias() .'/getCOALevel2', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_get_coa_level3'] = $this->url->link($this->getAlias() .'/getCOALevel3', 'token=' . $this->session->data['token'], 'SSL');
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

    public function getCOALevel2() {
        $coa_level1_id = $this->request->post['coa_level1_id'];
        $this->model['coa_level2'] = $this->load->model('gl/coa_level2');
        $rows = $this->model['coa_level2']->getRows(array('company_id' => $this->session->data['company_id'], 'coa_level1_id' => $coa_level1_id), array('name'));

        $html = "";
        $html .= '<option value="">&nbsp;</option>';
        foreach($rows as $row) {
            $html .= '<option value="'.$row['coa_level2_id'].'">'.$row['name'].'</option>';
        }

        $json = array('success' => true, 'html' => $html);
        echo json_encode($json);
    }

    public function getCOALevel3() {
        //$coa_level1_id = $this->request->post['coa_level1_id'];
        $coa_level2_id = $this->request->post['coa_level2_id'];
        $this->model['coa_level3'] = $this->load->model('gl/coa_level3');

        if($coa_level2_id != '')
        {
            $rows = $this->model['coa_level3']->getRows(array('company_id' => $this->session->data['company_id'],  'coa_level2_id' => $coa_level2_id), array('name'));

        }else {

            $rows = $this->model['coa_level3']->getRows(array('company_id' => $this->session->data['company_id']), array('name'));
        }


        $html = "";
        $html .= '<option value="">&nbsp;</option>';
        foreach($rows as $row) {
            $html .= '<option value="'.$row['coa_level3_id'].'">'.$row['name'].'</option>';
        }

        //d($html,true);
        $json = array('success' => true, 'html' => $html);
        echo json_encode($json);
    }


    public function getReport() {
        $post = $this->request->post;
        $filter = array();
        $filter[] = "`fiscal_year_id` = '".$this->session->data['fiscal_year_id']."'";
        if($post['date_from'] != '') {
            $filter[] = "`document_date` >= '".MySqlDate($post['date_from'])."'";
        }
        if($post['date_to'] != '') {
            $filter[] = "`document_date` <= '".MySqlDate($post['date_to'])."'";
        }
//        if($post['coa_level1_id'] != '') {
//            $filter[] = "`coa_level1_id` = '".$post['coa_level1_id']."'";
//        }
//        if($post['coa_level2_id'] != '') {
//            $filter[] = "`coa_level2_id` = '".$post['coa_level2_id']."'";
//        }
        if($post['coa_level3_id'] != '') {
            $filter[] = "`coa_id` = '".$post['coa_level3_id']."'";
        }
        $where = implode(' AND ', $filter);

        $this->model['ledger'] = $this->load->model('gl/ledger');
        $rows = $this->model['ledger']->getRows($where);
        $html = '';
        foreach($rows as $row) {
            $html .= '<tr>';
            $html .= '  <td>'.stdDate($row['document_date']).'</td>';
            $html .= '  <td>'.$row['document_identity'].'</td>';
            $html .= '  <td>'.$row['partner_type'].'</td>';
            $html .= '  <td>'.$row['partner_name'].'</td>';
            $html .= '  <td>'.$row['account'].'</td>';
            $html .= '  <td>'.$row['ref_document_identity'].'</td>';
            $html .= '  <td>'.$row['remarks'].'</td>';
            $html .= '  <td>'.$row['debit'].'</td>';
            $html .= '  <td>'.$row['credit'].'</td>';
            $html .= '  <td>'.stdDateTime($row['created_at']).'</td>';
            $html .= '</tr>';
        }

        $json = array(
            'success' => true,
            'post' => $post,
            'html' => $html,
        );
        echo json_encode($json);
    }

    public function printReport() {
        ini_set('max_execution_time',400);
        ini_set('memory_limit','3072M');

        $lang=$this->load->language($this->getAlias());
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

        $arrLedger = array();

        $this->model['ledger'] = $this->load->model('gl/ledger');

        $filter = array(
            'company_id' => $session['company_id'],
            'company_branch_id' => $session['company_branch_id'],
            'fiscal_year_id' => $session['fiscal_year_id'],
            'session_from' => $session['fiscal_date_from'],
            'date_from' => $post['date_from'],
            'date_to' => $post['date_to'],
            'coa_level1_id' => $post['coa_level1_id'],
            'coa_level2_id' => $post['coa_level2_id'],
            'coa_level3_id' => $post['coa_level3_id'],
        );

        $rows = $this->model['ledger']->getLedgerReport($filter);

        foreach($rows as $row) {
            $records[$row['display_name']][] = array(
                'document_date' => stdDate($row['document_date']),
                'document_identity' => $row['document_identity'],
                'remarks' => $row['remarks'],
                'cheque_no' => $row['cheque_no'],
                'debit' => $row['debit'],
                'credit' => $row['credit'],
                //'isPost' => (empty($arrDocuments[$row['document_identity']])?'':($arrDocuments[$row['document_identity']]?'Post':'Unpost'))
            );
        }

        $this->model['company'] = $this->load->model('setup/company');
        $company = $this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['coa'] = $this->load->model('gl/coa');
        $coa = $this->model['coa']->getRow(array('company_id' => $this->session->data['company_id'], 'coa_level3_id' => $post['coa_id']));

        $display_filter = array(
            'date_from' => stdDate($post['date_from']),
            'date_to' => stdDate($post['date_to']),
            'coa' => $coa['display_name']
        );

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
        //d ($row,true);
        $session = $this->session->data;
        $company_logo = $setting['value'];

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
        $pdf->SetTitle('Ledger Report');
        $pdf->SetSubject('Ledger Report');

        //Set Header d($session);
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
        $pdf->AddPage();
        foreach($records as $coa => $row) {
            $pdf->SetFont('times', 'B', 10);
            $pdf->Ln(7);
            $pdf->Cell(0,10,'Account: ' . $coa);

            $pdf->ln(12);
            $pdf->SetFont('times', 'B', 8);
            $pdf->Cell(7, 7, 'Sr.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(30, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(50, 7, 'Remarks', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, 'Cheque No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(22, 7, 'Debit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(22, 7, 'Credit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(25, 7, 'Balance', 1, false, 'C', 0, '', 0, false, 'M', 'M');

            $sr =0;
            $total_debit = 0;
            $total_credit = 0;
//            $pdf->Ln(1);
            foreach($row as $detail) {
                $total_debit += $detail['debit'];
                $total_credit += $detail['credit'];
                $balance = $total_debit - $total_credit;
                $sr++;

                if(strlen($detail['remarks'])<=40){
                    $pdf->Ln(7);
                    $pdf->SetFont('times', '', 8);
                    $pdf->Cell(7, 7, $sr, 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 7, $detail['document_date'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(30, 7, $detail['document_identity'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(50, 7, $detail['remarks'], 1, false, 'L', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(20, 7, $detail['cheque_no'], 1, false, 'C', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(22, 7, number_format($detail['debit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(22, 7, number_format($detail['credit'],2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                    $pdf->Cell(25, 7, number_format($balance,2), 1, false, 'R', 0, '', 1, false, 'M', 'M');
                } else {
                    $pdf->Ln(6);
                    $arrRemarks = splitString($detail['remarks'],40);
                    foreach ($arrRemarks as $index => $remark) {
                        if($index==0){
                            $pdf->SetFont('times', '', 8);
                            $pdf->Cell(7, 5, $sr, 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 5, $detail['document_date'], 'LTR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(30, 5, $detail['document_identity'], 'LTR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(50, 5, $remark, 'LTR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 5, $detail['cheque_no'], 'LTR', false, 'C', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(22, 5, number_format($detail['debit'],2), 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(22, 5, number_format($detail['credit'],2), 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(25, 5, number_format($balance,2), 'LTR', false, 'R', 0, '', 1, false, 'M', 'M');
                        } else if($index<=count($arrRemarks)-1){
                            $pdf->SetFont('times', '', 8);
                            $pdf->Cell(7, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 5, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(30, 5, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(50, 5, $remark, 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(22, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(22, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(25, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                        } else {
                            $pdf->SetFont('times', '', 8);
                            $pdf->Cell(7, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 5, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(30, 5, '', 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(50, 5, $remark, 'LR', false, 'L', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(20, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(22, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(22, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                            $pdf->Cell(25, 5, '', 'LR', false, 'R', 0, '', 1, false, 'M', 'M');
                        }
                        $pdf->Ln(5);
                    }
                    $pdf->Ln(-6);
                }
            }
            $pdf->Ln(7);
            $pdf->Cell(7, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(30, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(50, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(20, 5, '', 'T', false, 'R', 0, '', 1, false, 'M', 'M');
            $pdf->Cell(22, 7, number_format($total_debit,2), 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(22, 7, number_format($total_credit,4), 1, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Cell(25, 7, '', 'T', false, 'C', 0, '', 0, false, 'M', 'M');

        }

        //Close and output PDF document
        $pdf->Output('Ledger Report:'.date('YmdHis').'.pdf', 'I');
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