<?php

class ControllerReportDocumentLedger extends HController {

    protected function getAlias() {
        return 'report/document_ledger';
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
        //$lang = $this->load->language('report/party_ledger');
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['party_ledger'] = $this->load->model('report/party_ledger');
        $where = "l.company_id = '".$this->session->data['company_id']."'";
        $where .= " AND l.company_branch_id = '".$this->session->data['company_branch_id']."'";
        $where .= " AND l.fiscal_year_id = '".$this->session->data['fiscal_year_id']."'";
        if($post['from_date'] != '') {
            $where .= " AND l.document_date >= '".$post['from_date']."'";
        }
        if($post['to_date'] != '') {
            $where .= " AND l.document_date <= '".$post['to_date']."'";
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
            $arrLedger[$row['partner_type'] . ': ' . $row['partner_name']][] = $row;
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
        $rows = $this->model['party_ledger']->getPartyLedger($where, array('partner_type', 'partner_name','document_date', 'document_identity', 'ref_document_identity'));
        foreach($rows as $row) {
            $arrLedger[$row['partner_type'] . ': ' . $row['partner_name']][] = $row;
        }

        $this->model['company'] = $this->load->model('setup/company');
        $company = $this->model['company']->getRows(array('company_id' => $this->session->data['company_id']));

        $data = array(
            'lang' => $lang,
            'company' => $company,
            'filter' => $post,
            'rows' => $arrLedger
        );
        //d($data, true);
        try
        {
            $pdf=new mPDF();

            $pdf->SetDisplayMode('fullpage');
            //d($data,true);
            $pdf->mPDF('utf-8','A4','','','15','15','35','18');
            $pdf->setHTMLHeader($this->getPDFHeader($data));
            $pdf->setHTMLFooter($this->getPDFFooter($data));
            $pdf->WriteHTML($this->getPDFStyle($data));
            $pdf->WriteHTML($this->getPDFBodyDetail($data));

            $pdf->Output();
        }
        catch(Exception $e) {
            echo $e;
            exit;
        }
        exit;
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

        $where = "l.company_id = '".$this->session->data['company_id']."'";
        $where .= " AND l.company_branch_id = '".$this->session->data['company_branch_id']."'";
        $where .= " AND l.fiscal_year_id = '".$this->session->data['fiscal_year_id']."'";
        if($post['date_to'] != '') {
            $where .= " AND l.document_date <= '".$post['date_to']."'";
        }
        if($post['partner_type_id'] != '') {
            $where .= " AND l.partner_type_id = '".$post['partner_type_id']."'";
        }
        if($post['partner_id'] != '') {
            $where .= " AND l.partner_id = '".$post['partner_id']."'";
        }
        $rows = $this->model['party_ledger']->getPartyLedger($where, array('partner_type', 'partner_name','document_date', 'document_identity', 'ref_document_identity'));
        foreach($rows as $row) {
            $arrLedger[$row['partner_type'] . ': ' . $row['partner_name']][] = $row;
        }

        $this->model['company'] = $this->load->model('setup/company');
        $company = $this->model['company']->getRows(array('company_id' => $this->session->data['company_id']));

        $data = array(
            'lang' => $lang,
            'company' => $company,
            'filter' => $post,
            'rows' => $arrLedger
        );
        //d($data, true);
        try
        {
            $pdf=new mPDF();

            $pdf->SetDisplayMode('fullpage');
            //d($data,true);
            $pdf->mPDF('utf-8','A4','','','15','15','35','18');
            $pdf->setHTMLHeader($this->getPDFHeader($data));
            $pdf->setHTMLFooter($this->getPDFFooter($data));
            $pdf->WriteHTML($this->getPDFStyle($data));
            $pdf->WriteHTML($this->getPDFBodySummary($data));

            $pdf->Output();
        }
        catch(Exception $e) {
            echo $e;
            exit;
        }
        exit;
    }

    private function getPDFStyle($data) {
        //d($data['rows'],true);
        $html = '';
        $html .= '<style type="text/css">';
        $html .= 'body {';
        $html .= 'background: #FFFFFF;';
        $html .= '}';
        $html .= 'body, td, th, input, select, textarea, option, optgroup {';
        $html .= 'font-family: Arial, Helvetica, sans-serif;';
        $html .= 'font-size: 10px;';
        $html .= 'color: #000000;';
        $html .= '}';
        $html .= 'h1 {';
        $html .= 'text-transform: uppercase;';
        $html .= 'text-align: center;';
        $html .= 'font-size: 24px;';
        $html .= 'font-weight: normal;';
        $html .= 'margin: 5px 0;';
        $html .= '}';
        $html .= 'h2 {';
        $html .= 'text-transform: uppercase;';
        $html .= 'text-align: center;';
        $html .= 'font-size: 18px;';
        $html .= 'font-weight: normal;';
        $html .= 'padding: 0;';
        $html .= 'margin: 0;';
        $html .= '}';
        $html .= 'h3 {';
        $html .= 'text-align: center;';
        $html .= 'font-size: 16px;';
        $html .= 'font-weight: normal;';
        $html .= 'padding: 0;';
        $html .= 'margin: 5px 0 0 0;';
        $html .= '}';
        $html .= 'table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }';
        $html .= 'table.page_body {width: 100%; border: solid 1px #DDDDDD; border-collapse: collapse; align="center" }';
        $html .= 'table.page_body th {border: solid 1px #000000; border-collapse: collapse; background-color: #CDCDCD; text-align: center; font-size: 12px; padding: 5px;}';
        $html .= 'table.page_body td {border: solid 1px #000000; border-collapse: collapse;font-size: 10px; padding: 5px;}';
        $html .= 'table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}';
        $html .= '</style>';

        return $html;
    }

    private function getPDFHeader($data) {
        $filter = $data['filter'];
        $session = $this->session->data;
        $lang = $data['lang'];

        //d($session, true);
        $this->model['image'] = $this->load->model('tool/image');
        $company_image = $this->model['image']->resize($session['company_image'],150,50);
        //d(array($session['company_logo'], $session['name'], $session),true);

        $html  = '';
        $html .= '<table class="page_header">';
        $html .= '<tr>';
        $html .= '<td style="width: 33%; text-align: left;">';
        if($session['company_logo']) {
            $html .= '<img src="' . $company_image . '" alt="Logo"/>';
        }
        $html .= '</td>';
        $html .= '<td style="width: 34%; text-align: center">';
        $html .= '<h1>' . $session['company_name'] .'</h1>';
        $html .= '<h3>' . $lang['heading_title'] . '</h3>';
        $html .= '</td>';
        $html .= '<td style="width: 33%;">';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['from_date'] . '</td><td style="text-align: left;">' . $filter['date_from'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['to_date'] . '</td><td style="text-align: left;">' . $filter['date_to'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['partner_type'] . '</td><td style="text-align: left;">' . $filter['partner_type'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['partner_name'] . '</td><td style="text-align: left;">' . $filter['partner_name'] . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

    private function getPDFFooter($data) {
        //d(STD_DATETIME,true);
        $html = '';
        $html .= '<table class="page_footer">';
        $html .= '<tr>';
        $html .= '<td style="width: 33%; text-align: left;">';
        $html .= '&nbsp;';
        $html .= '</td>';
        $html .= '<td style="width: 34%; text-align: center">';
        $html .= 'Page: {PAGENO}';
        $html .= '</td>';
        $html .= '<td style="width: 33%; text-align: right">';
        $html .= 'Date: {DATE '.STD_DATETIME.'}';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

    private function getPDFBodyDetail($data) {
        $partners = $data['rows'];
        $lang = $data['lang'];
        $html = '';
        foreach($partners as $partner => $rows) {
            $total_debit = 0;
            $total_credit = 0;
            $total_amount = 0;
            // d(array($peoples,$people_id,$people_type_id,$rows),true);

            $html .= '<div style="padding-top: 10px;">';
            $html .= '<div style="font-size: 12px;"><strong>' . $partner . '</strong></div>';
            $html .= '<table class="page_body">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="width: 11%;">'.$lang['doc_date'].'</th>';
            $html .= '<th style="width: 14%;">'.$lang['doc_no'].'</th>';
            $html .= '<th style="width: 15%;">'.$lang['adjusted_doc'].'</th>';
            $html .= '<th style="width: 15%;">'.$lang['remarks'].'</th>';
            $html .= '<th style="width: 15%;">'.$lang['account'].'</th>';
            $html .= '<th style="width: 10%;">'.$lang['debit'].'</th>';
            $html .= '<th style="width: 10%;">'.$lang['credit'].'</th>';
            $html .= '<th style="width: 10%;">'.$lang['balance'].'</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach($rows as $row) {
                $debit = $row['debit'];
                $credit = $row['credit'];

                $total_debit += $debit;
                $total_credit += $credit;
                $total_amount = $total_debit - $total_credit;
                $balance_amount = ($total_amount==0?'-':($total_amount>0?'DR. '. number_format($total_amount,2):'CR. ' . number_format(-1 * $total_amount,2)));
                $html .= '<tr>';
                $html .= '<td style="text-align:left;">' . ($row['document_date'] != '' ? stdDate($row['document_date']):'') . '</td>';
                $html .= '<td style="text-align:left;">' . $row['document_identity'] . '</td>';
                $html .= '<td style="text-align:left;">' . $row['ref_document_identity'] . '</td>';
                $html .= '<td style="text-align:left;">' . $row['remarks'] . '</td>';
                $html .= '<td style="text-align:left;">' . $row['account'] . '</td>';
                $html .= '<td style="text-align:right;">' . number_format($row['debit'],2) . '</td>';
                $html .= '<td style="text-align:right;">' . number_format($row['credit'],2) . '</td>';
                $html .= '<td style="text-align:right;">' . $balance_amount . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '<tfoot>';
            $html .= '<tr>';
            $html .= '<th colspan="5">&nbsp;</th>';
            $html .= '<th style="text-align:right;">' . number_format($total_debit,2) . '</th>';
            $html .= '<th style="text-align:right;">' . number_format($total_credit,2) . '</th>';
            $html .= '<th>&nbsp;</th>';
            $html .= '</tr>';
            $html .= '</tfoot>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '<pagebreak />';
        }

        $html = substr($html,0,strlen($html)-13);
        //echo $html;
        return $html;
    }

    private function getPDFBodySummary($data) {
        $partners = $data['rows'];
        $lang = $data['lang'];
        $html = '';
        $html .= '<div style="padding-top: 10px;">';
        $html .= '<table class="page_body">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="width: 11%;">'.$lang['partner_type'].'</th>';
        $html .= '<th style="width: 14%;">'.$lang['partner_name'].'</th>';
        $html .= '<th style="width: 10%;">'.$lang['debit'].'</th>';
        $html .= '<th style="width: 10%;">'.$lang['credit'].'</th>';
        $html .= '<th style="width: 10%;">'.$lang['balance'].'</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach($partners as $partner => $rows) {
            $total_debit = 0;
            $total_credit = 0;
            $total_amount = 0;
            // d(array($peoples,$people_id,$people_type_id,$rows),true);

            foreach($rows as $row) {
                $debit = $row['debit'];
                $credit = $row['credit'];

                $total_debit += $debit;
                $total_credit += $credit;
                $total_amount = $total_debit - $total_credit;
            }
            $balance_amount = ($total_amount==0?'-':($total_amount>0?'DR. '. number_format($total_amount,2):'CR. ' . number_format(-1 * $total_amount,2)));
            $html .= '<tr>';
            $html .= '<td style="text-align:left;">' . $row['partner_type'] . '</td>';
            $html .= '<td style="text-align:left;">' . $row['partner_name'] . '</td>';
            $html .= '<td style="text-align:right;">' . number_format($total_debit,2) . '</td>';
            $html .= '<td style="text-align:right;">' . number_format($total_credit,2) . '</td>';
            $html .= '<td style="text-align:right;">' . $balance_amount . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';

        return $html;

    }
}


?>