<?php

class ControllerReportGoodsReceivedReport extends HController {

    protected function getAlias() {
        return 'report/goods_received_report';
    }
    
    protected function getDefaultOrder() {
        return 'goods_received_id';
    }

    protected function getDefaultSort() {
        return 'DESC';
    }

    protected function getList() {
        parent::getList();

        $this->data['partner_types'] = $this->session->data['partner_types'];

        $this->model['supplier'] = $this->load->model('setup/supplier');
        $this->data['suppliers'] = $this->model['supplier']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['product'] = $this->load->model('inventory/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
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

//        //        $this->document->addScript("view/javascript/jquery/jquery.dataTables.min.js");
//        $this->document->addLink("view/stylesheet/dataTables.css", "stylesheet");
//        $this->document->addScript("view/js/plugins/dataTables/js/jquery.dataTables.js");
//        $this->document->addScript("view/js/plugins/dataTables/js/jquery.dataTables.columnFilter.js");
////        $this->document->addLink("view/js/plugins/dataTables/css/jquery.dataTables.css", "stylesheet");
//
//
        $this->response->setOutput($this->render());
    }

    public function printReport() {
        $lang = $this->load->language($this->getAlias());

        $this->init();
        $filter = array();

        if($this->request->post['date_from'])
            $filter['GTE']['document_date'] = MySqlDate($this->request->post['date_from']);
        if($this->request->post['date_to'])
            $filter['LTE']['document_date'] = MySqlDate($this->request->post['date_to']);

        if($this->request->post['supplier_id'])
            $filter['EQ']['supplier_id'] = $this->request->post['supplier_id'];
        if($this->request->post['product_id'])
            $filter['EQ']['product_id'] = $this->request->post['product_id'];

        $cond = $this->getFilterString($filter);

        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['partner_type'] = $this->load->model('common/partner_type');
        $this->model['partner'] = $this->load->model('common/partner');

        $product = $this->model['product']->getArrays('product_id','name', array('company_id' => $this->session->data['company_id']));
        $arrProducts = $this->model['product']->getRow(array('product_id' => $this->request->post['product_id']));
        $partnerType = $this->model['partner_type']->getRow(array('partner_type_id' => $this->request->post['partner_type_id']));
        $arrPartnerType = $this->model['partner_type']->getArrays('partner_type_id','name');
        $partner = $this->model['partner']->getRow(array('partner_id' => $this->request->post['partner_id']));
        $arrPartner = $this->model['partner']->getArrays('partner_id','name');



        $this->model['currency'] = $this->load->model('setup/currency');
        $arrCurrency = $this->model['currency']->getArrays('currency_id','currency_code', array('company_id' => $this->session->data['company_id']));
//d($product,true);

        $arrfilter = array(
            'from_date' => $this->request->post['date_from'],
            'to_date' => $this->request->post['date_to'],
            'product' => $arrProducts['name'],
            'partner_type' => $partnerType['name'],
            'partner' => $partner['name'],
        );
//d($arrfilter,true);
        $this->model['company'] = $this->load->model('setup/company');
        $company=$this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company_branch=$this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['goods_received_report'] = $this->load->model('report/goods_received_report');
        $rows = $this->model['goods_received_report']->getRows($cond,array('document_date ASC'));
//        d($rows,true);
        $arrRows = array();
        foreach($rows as $row) {
            $row['document_date'] = stdDate($row['document_date']);
            if($this->request->post['group_by'] == 'partner') {
                $group_name = $arrPartner[$row['partner_id']];
            } elseif($this->request->post['group_by'] == 'product') {
                $group_name = $product[$row['product_id']];
            } elseif($this->request->post['group_by'] == 'document_date') {
                $group_name = $row['document_date'];
            } elseif($this->request->post['group_by'] == 'warehouse') {
                $group_name = $row['warehouse'];
            } else {
                $group_name = '';
            }

            $groupBy = $this->request->post['group_by'];
            $arrRows[$group_name][] = array(
                'document_type_id' => $row['document_type_id'],
                'document_id' => $row['document_id'],
                'voucher_date' => $row['document_date'],
                'voucher_no' => $row['document_identity'],
                'currency' => $arrCurrency[$row['document_currency_id']],
                'conversion_rate' => $row['conversion_rate'],
                'document_identity' => $row['document_identity'],
                'warehouse_id' => $row['warehouse_id'],
                'warehouse' => $row['warehouse'],
                'product_category_id' => $row['product_category_id'],
                'product_id' => $row['product_id'],
                'product' => $product[$row['product_id']],
                'partner_id' => $row['partner_id'],
                'partner' => $arrPartner[$row['partner_id']],
                'partner_type_id' => $row['partner_type_id'],
                'partner_type' => $arrPartnerType[$row['partner_type_id']],
                'unit_id' => $row['unit_id'],
                'qty' => $row['qty'],
                'rate' => ($row['qty']==0?0:($row['amount']/$row['qty'])),
                'amount' => $row['amount']
            );

        }
// d($arrRows,true);

        $data = array(
            'company' => $company,
            'company_branch' => $company_branch,
            'filter' => $arrfilter,
            'lang' => $lang,
            'rows' => $arrRows,
            'group' => $groupBy,
            'group_name' => $group_name
        );

    // d($data,true);

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hira Anwer');
        $pdf->SetTitle('Good Received Report');
        $pdf->SetSubject('Good Received Report');

        $pdf->data = array(
            'company_name' => $session['company_name'],
            'company_branch_name'=>$session['company_branch_name'],
            'report_name' => $lang['heading_title'],
            'company_logo' => $company_logo,
            'from_date' => $post['date_from'],
            'to_date' => $post['date_to'],
            'status' => $this->request->post['status']
        );
        $pdf->SetMargins(3, 40, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();


        

    }


    private function getPDFStyle($data) {
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
        $lang = $data['lang'];
        $company = $data['company'];
        $companyBranch = $data['company_branch'];
        $this->model['image'] = $this->load->model('tool/image');
        $company_image = $this->model['image']->resize($company['company_logo'],50,50);

        $html  = '';
        $html .= '<table class="page_header">';
        $html .= '<tr>';
        $html .= '<td style="width: 33%; text-align: left;">';
        if($company['company_logo']) {
            $html .= '<img src="' . $company_image . '" alt="Logo"/>';
        }
        $html .= '</td>';
        $html .= '<td style="width: 34%; text-align: center">';
        $html .= '<h1>' . $company['name'] .'</h1>';
        $html .= '<h2>' . $companyBranch['name'] . '</h2>';
        $html .= '<h3>' . $lang['heading_title'] . '</h3>';
        $html .= '</td>';
        $html .= '<td style="width: 33%;">';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['entry_from_date'] . '</td><td style="text-align: left;">' . $filter['from_date'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['entry_to_date'] . '</td><td style="text-align: left;">' . $filter['to_date'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['entry_partner_type'] . '</td><td style="text-align: left;">' . $filter['partner_type'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['entry_partner_name'] . '</td><td style="text-align: left;">' . $filter['partner'] . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: right; font-weight: bold">' . $lang['entry_product'] . '</td><td style="text-align: left;">' . $filter['product'] . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

    private function getPDFFooter($data) {
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
        $stocks = $data['rows'];
        $lang = $data['lang'];

        $html = '';
        foreach($stocks as $warehouse => $categories) {
            foreach($categories as $category => $products) {
                foreach($products as $product => $rows) {
                    $total_qty = 0;
                    $total_amount =0;

                    $html .= '<div style="padding-top: 10px;">';
                    $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_warehouse'] . '</strong>' . $warehouse . '</div>';
                    $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_product_category'] . '</strong>' . $category . '</div>';
                    $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_product'] . '</strong>' . $product . '</div>';
                    $html .= '<table class="page_body">';
                    $html .= '<thead>';
                    $html .= '<tr>';
                    $html .= '<th style="width: 20%;">' . $lang['column_document_date'] . '</th>';
                    $html .= '<th style="width: 20%;">' . $lang['column_document_no'] . '</th>';
                    $html .= '<th style="width: 10%;">' . $lang['column_qty'] . '</th>';
                    $html .= '<th style="width: 10%;">' . $lang['column_rate'] . '</th>';
                    $html .= '<th style="width: 10%;">' . $lang['column_amount'] . '</th>';
                    $html .= '<th style="width: 10%;">' . $lang['column_total_qty'] . '</th>';
                    $html .= '<th style="width: 10%;">' . $lang['column_total_amount'] . '</th>';
                    $html .= '<th style="width: 10%;">' . $lang['column_avg_rate'] . '</th>';
                    $html .= '</tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                    foreach($rows as $row) {
                        $total_qty += $row['qty'];
                        $total_amount += $row['amount'];
                        $html .= '<tr>';
                        $html .= '<td style="text-align:left;">' . $row['document_date'] . '</td>';
                        $html .= '<td style="text-align:left;">' . $row['document_identity'] . '</td>';
                        $html .= '<td style="text-align:right;">' . number_format($row['qty'],0) . '</td>';
                        $html .= '<td style="text-align:right;">' . number_format($row['rate'],2) . '</td>';
                        $html .= '<td style="text-align:right;">' . number_format($row['amount'],2) . '</td>';
                        $html .= '<td style="text-align:right;">' . number_format($total_qty,0) . '</td>';
                        $html .= '<td style="text-align:right;">' . number_format($total_amount,2) . '</td>';
                        $html .= '<td style="text-align:right;">' . number_format(($total_amount/$total_qty),2) . '</td>';
                        $html .= '</tr>';
                    }
                    $html .= '</tbody>';
                    $html .= '<tfoot>';
                    $html .= '<tr>';
                    $html .= '<th colspan="2">&nbsp;</th>';
                    $html .= '<th style="text-align:right;">' . number_format($total_qty,0) . '</th>';
                    $html .= '<th style="text-align:right;">&nbsp;</th>';
                    $html .= '<th style="text-align:right;">' . number_format($total_amount,2) . '</th>';
                    $html .= '<th colspan="3">&nbsp;</th>';
                    $html .= '</tr>';
                    $html .= '</tfoot>';
                    $html .= '</table>';
                    $html .= '</div>';
                    $html .= '<pagebreak />';
                }
            }
        }
        $html = substr($html,0,strlen($html)-13);
        return $html;
    }

    private function getPDFBodySummary($data) {
        $stocks = $data['rows'];
        $lang = $data['lang'];
        $group = $data['group'];
        $group_name = $data['group_name'];
//d($group_name,true);
        $html = '';
        foreach($stocks as $group_name => $products) {
            $total_qty = 0;
            $total_amount =0;
            $base_amount = 0;
            $total_base_amount = 0;

            $html .= '<div style="padding-top: 10px;">';
            if($group == 'partner')
            {
                $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_partner_name'] . '</strong>' .$group_name . '</div>';
            }
            elseif($group == 'product')
            {
                $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_product'] . '</strong>' . $group_name . '</div>';
            }
            elseif($group == 'document_date')
            {
                $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_date'] . '</strong>' . $group_name . '</div>';
            }
            elseif($group == 'warehouse')
            {
                $html .= '<div style="font-size: 12px;"><strong>' . $lang['entry_warehouse'] . '</strong>' . $group_name . '</div>';
            }
            $html .= '<table class="page_body">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="width: 10%;">' . $lang['column_voucher_date'] . '</th>';
            $html .= '<th style="width: 10%;">' . $lang['column_voucher_no'] . '</th>';
            $html .= '<th style="width: 18%;">' . $lang['partner_name'] . '</th>';
            $html .= '<th style="width: 18%;">' . $lang['column_product'] . '</th>';
            $html .= '<th style="width: 8%;">' . $lang['column_qty'] . '</th>';
            $html .= '<th style="width: 10%;">' . $lang['column_rate'] . '</th>';
            $html .= '<th style="width: 14%;">' . $lang['column_amount'] . '</th>';
//            $html .= '<th style="width: 15%;">' . $lang['column_currency'] . '</th>';
//            $html .= '<th style="width: 8%;">' . $lang['column_conversion'] . '</th>';
//            $html .= '<th style="width: 14%;">' . $lang['column_base_amount'] . '</th>';

            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach($products as $product => $row) {
                $total_qty += $row['qty'];
                $total_amount += $row['amount'];
                $base_amount = $row['amount'] * $row ['conversion_rate'] ;
                $total_base_amount += $base_amount;

                $html .= '<tr>';
                $html .= '<td style="text-align:left;">' . $row['voucher_date'] . '</td>';
                $html .= '<td style="text-align:left;">' . $row['voucher_no'] . '</td>';
                $html .= '<td style="text-align:left;">' . $row['partner'] . '</td>';
                $html .= '<td style="text-align:left;">' . $row['product'] . '</td>';
                $html .= '<td style="text-align:right;">' . number_format($row['qty'],0) . '</td>';
                $html .= '<td style="text-align:right;">' . number_format($row['rate'],2) . '</td>';
                $html .= '<td style="text-align:right;">' . number_format($row['amount'],2) . '</td>';
//                $html .= '<td style="text-align:left;">' . $row['currency'] . '</td>';
//                $html .= '<td style="text-align:right;">' . number_format($row['conversion_rate'],2) . '</td>';
//                $html .= '<td style="text-align:right;">' . number_format($base_amount,2) . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '<tfoot>';
            $html .= '<tr>';
            $html .= '<th colspan="4">&nbsp;</th>';
            $html .= '<th style="text-align:right;">' . number_format($total_qty,0) . '</th>';
            $html .= '<th style="text-align:right;">&nbsp;</th>';
            $html .= '<th style="text-align:right;">' . number_format($total_amount,2) . '</th>';
//            $html .= '<th style="text-align:right;">&nbsp;</th>';
//            $html .= '<th style="text-align:right;">&nbsp;</th>';
//            $html .= '<th style="text-align:right;">' . number_format($total_base_amount,2) . '</th>';
            $html .= '</tr>';
            $html .= '</tfoot>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '<pagebreak />';
        }
        $html = substr($html,0,strlen($html)-13);
        return $html;
    }


}





class PDF extends TCPDF
{
   var $company_name;
   var $company_branch_name;
   var $filter;
   var $group_heading;
// Page header
   function Header()
   {
        if($this->data['company_logo'] != '') {
            $image_file = DIR_IMAGE.$this->data['company_logo'];
            $this->Image($image_file, 10, 10, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
       $this->SetFont('times','B',30);
       // Move to the right
       $this->Cell(70);
       // Title
       $this->Cell(70,10,$this->data['company_name'],0,0,'C');
       $this->SetFont('helvetica','B',8);
           $this->Ln(7);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 7, 'From : '. $this->data['from_date'].' | '.'To : '. $this->data['to_date'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->ln(7);
    
   }

// Page footer
   function Footer()
   {
       // Position at 1.5 cm from bottom
       $this->SetY(-15);
       // Arial italic 8
       $this->SetFont('Arial','I',8);
       // Page number
       $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }

}

?>