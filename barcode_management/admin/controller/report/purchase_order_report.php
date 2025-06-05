<?php

class ControllerReportPurchaseOrderReport extends HController {

    protected function getAlias() {
        return 'report/purchase_order_report';
    }

    protected function getDefaultOrder() {
        return 'purchase_invoice_id';
    }

    protected function getDefaultSort() {
        return 'DESC';
    }

    protected function getList() {
        parent::getList();

        $this->data['partner_types'] = $this->session->data['partner_types'];

        $this->model['partner'] = $this->load->model('common/partner');
        $this->data['suppliers'] = $this->model['partner']->getRows(array('company_id' => $this->session->data['company_id'], 'partner_type_id' => 1));

        // $this->model['product'] = $this->load->model('inventory/product');
        // $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));
        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token']);

        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_excel'] = $this->url->link($this->getAlias() .'/printReportExcel', 'token=' . $this->session->data['token'], 'SSL');

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
        $this->response->setOutput($this->render());
    }

    public function getProductJson() {

        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $filter = [];
        $filter[] = "p.company_id = '". $session['company_id'] ."'";
        $filter = implode(' AND ', $filter);
        $options = $this->model['product_master']->getOptionList($post['q'], $filter, ['p.name']);
        $items = [];
        foreach($options['items'] as $row) {
            $items[] = [
                'id' => $row['product_master_id'],
                'text' => $row['product_code'].' - '.$row['name'],
                'description' => $row['description'],
                'product_code' => $row['product_code'],
                'category_id' => $row['category_id'],
                'unit_id' => $row['unit_id'],
                'unit' => $row['unit'],
            ];
        }
        $json = [
            'total_count' => $options['total_count'],
            'items' => $items,
            'filter' => $filter
        ];

        echo json_encode($json);
        exit;

    }

    public function printReportExcel(){

        $lang = $this->load->language($this->getAlias());
        $this->init();
        $filter = array();
        // d($this->request->post,true);
        if($this->request->post['date_from'])
        {
            $filter['GTE']['po.document_date'] = MySqlDate($this->request->post['date_from']);
        }
        if($this->request->post['date_to'])
        {
            $filter['LTE']['po.document_date'] = MySqlDate($this->request->post['date_to']);
        }
        if($this->request->post['partner_id'])
        {
            $filter['EQ']['po.partner_id'] = $this->request->post['partner_id'];
        }
        if($this->request->post['product_id'])
        {
            $filter['EQ']['pod.product_id'] = $this->request->post['product_id'];
        }
        // d('hello');
        $cond = parent::getFilterString($filter);
        $session = $this->session->data;
        $post = $this->request->post;

        // d($cond,true);
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

        $arrfilter = array(
            'from_date' => $this->request->post['date_from'],
            'to_date' => $this->request->post['date_to'],
            'product' => $arrProducts['name'],
            'partner_type' => $partnerType['name'],
            'partner' => $partner['name'],
        );
        $this->model['company'] = $this->load->model('setup/company');
        $company=$this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company_branch=$this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['purchase_order_report'] = $this->load->model('report/purchase_order_report');
        // $rows = $this->model['purchase_order_report']->getRows($cond,array('document_date ASC'));
        $rows = $this->model['purchase_order_report']->getPurchaseOrderReport($cond,array('document_date ASC'));
        // d($rows,true);
        $arrRows = array();
        foreach($rows as $row) {
            $row['document_date'] = stdDate($row['document_date']);
            if($this->request->post['group_by'] == 'partner') {
                $group_name = $arrPartner[$row['partner_id']];
            } elseif($this->request->post['group_by'] == 'product') {
                $group_name = $row['product_name'];
            } elseif($this->request->post['group_by'] == 'document_date') {
                $group_name = $row['document_date'];
            } else {
                $group_name = '';
            }
            $groupBy = $this->request->post['group_by'];
            $status =  'All';
            $rowStatus = (($row['mrn_qty']<$row['po_qty'])?'Pending':'Cleared');
            if($this->request->post['status']=='Cleared'&&($rowStatus==$this->request->post['status'])){
                $status = 'Cleared';
            } else if($this->request->post['status']=='Pending'&&($rowStatus==$this->request->post['status'])){
                $status = 'Pending';
            }

            $arrRows[$status][$group_name][] = array(
                    'document_type_id' => $row['document_type_id'],
                    'document_id' => $row['document_id'],
                    'voucher_date' => $row['document_date'],
                    'voucher_no' => $row['document_identity'],
                    'currency' => $arrCurrency[$row['document_currency_id']],
                    'conversion_rate' => $row['conversion_rate'],
                    'document_identity' => $row['document_identity'],
                    'warehouse_id' => $row['warehouse_id'],
                    'product_category_id' => $row['product_category_id'],
                    'product_id' => $row['product_id'],
                    'product_code'=>$row['product_code'],
                    'product' => $row['product_name'],
                    'partner_id' => $row['partner_id'],
                    'partner' => $arrPartner[$row['partner_id']],
                    'partner_type_id' => $row['partner_type_id'],
                    'partner_type' => $arrPartnerType[$row['partner_type_id']],
                    'unit_id' => $row['unit_id'],
                    'qty' => ($status=='Pending')?($row['po_qty']-$row['mrn_qty']):$row['po_qty'],
                    'mrn_qty' => $row['mrn_qty'],
                    'po_qty' => $row['po_qty'],
                    'status' => $row['mrn_qty']<$row['po_qty']?'Pending':'Cleared',
                    'rate' => ($row['po_qty']==0?0:($row['amount']/$row['po_qty'])),
                    'amount' => $row['amount'],
            );
        }
        // d($arrRows,true);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getProperties()
            ->setCreator("Hira Anwer")
            ->setTitle("Purchase Order Report");
        $objPHPExcel->data = array(
            'company_name' => $session['company_name'],
            'company_branch_name'=>$session['company_branch_name'],
            'report_name' => 'Purchase Order Report',
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
                    'size' => 14
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Purchase Order Report');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Status: ' . $post['status']);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        
        $rowCount ++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From Date: '. $post['date_from'] . ' To Data: ' . $post['date_to'] );
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'size' => 12
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':'.'I'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Doc. Date')->getStyle('A'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Doc. Identity')->getStyle('B'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Partner Name')->getStyle('C'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Product')->getStyle('D'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Qty')->getStyle('E'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Rate')->getStyle('F'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Amount')->getStyle('G'.$rowCount)->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':G'.$rowCount)->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                )
            )
        );
        $rowCount++;
        $total_amount = 0;
        foreach($arrRows[$this->request->post['status']] as $key => $value) {
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":G".($rowCount));
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $key);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFill('ebebeb');
            $rowCount ++;
            $total = 0;
            foreach ($value as $key_1 => $value_1)
            {
                // d($value_1,true);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value_1['voucher_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value_1['voucher_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value_1['partner']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value_1['product_code'].' - '.$value_1['product']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value_1['qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value_1['rate']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value_1['amount']);
                $rowCount++;
                $total += $value_1['amount'];
            }
            // 
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":F".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Total Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total);
        // d($total_amount1,true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':G'.$rowCount)->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold' => true
                )
            )
        );
            $rowCount++;
            $total_amount += $total;

        }
        // die();
        $rowCount++;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($rowCount).":F".($rowCount));
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Grand Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $total_amount);
        // d($total_amount1,true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':G'.$rowCount)->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ebebeb')
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold' => true
                )
            )
        );
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Purchase Order Report.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('php://output');
        exit;
    }

    public function printReport() {
        $lang = $this->load->language($this->getAlias());
        $this->init();
        $filter = array();
        $session = $this->session->data;
        $post = $this->request->post;
        // d($this->request->post,true);
        if($this->request->post['date_from'])
        {
            $filter['GTE']['po.document_date'] = MySqlDate($this->request->post['date_from']);
        }
        if($this->request->post['date_to'])
        {
            $filter['LTE']['po.document_date'] = MySqlDate($this->request->post['date_to']);
        }
        if($this->request->post['partner_id'])
        {
            $filter['EQ']['po.partner_id'] = $this->request->post['partner_id'];
        }
        if($this->request->post['product_id'])
        {
            $filter['EQ']['pod.product_id'] = $this->request->post['product_id'];
        }
        // d('hello');
        $cond = parent::getFilterString($filter);
        // d($cond,true);
        $this->model['product'] = $this->load->model('inventory/product');
        $this->model['partner_type'] = $this->load->model('common/partner_type');
        $this->model['partner'] = $this->load->model('common/partner');
    // d($product,true);
    $product = $this->model['product']->getRow(array('product_id' => $this->request->post['product_id']));
    $arrProducts = $this->model['product']->getArrays('product_id','name');
    // d($arrProducts,true);
    $partnerType = $this->model['partner_type']->getRow(array('partner_type_id' => $this->request->post['partner_type_id']));
    $arrPartnerType = $this->model['partner_type']->getArrays('partner_type_id','name');
    $partner = $this->model['partner']->getRow(array('partner_id' => $this->request->post['partner_id']));
    $arrPartner = $this->model['partner']->getArrays('partner_id','name');
    // d($arrPartner,true);
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
        $this->model['company'] = $this->load->model('setup/company');
        $company=$this->model['company']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['company_branch'] = $this->load->model('setup/company_branch');
        $company_branch=$this->model['company_branch']->getRow(array('company_id' => $this->session->data['company_id']));

        $this->model['purchase_order_report'] = $this->load->model('report/purchase_order_report');
        // $rows = $this->model['purchase_order_report']->getRows($cond,array('document_date ASC'));
        $rows = $this->model['purchase_order_report']->getPurchaseOrderReport($cond,array('document_date ASC'));
        // d($rows,true); 
        $arrRows = array();

        foreach($rows as $row) {
            // d($row,true);
            $row['document_date'] = stdDate($row['document_date']);
            if($this->request->post['group_by'] == 'partner') {
                $group_name = $arrPartner[$row['partner_id']];  
            } elseif($this->request->post['group_by'] == 'product') {
                $group_name = $row['product_code'].' - '.$row['product_name'];
                   // print_r($group_name);
                   // die();
            } elseif($this->request->post['group_by'] == 'document_date') {
                $group_name = $row['document_date'];
            } else {
                $group_name = '';
            }

            // d($row);
            $groupBy = $this->request->post['group_by'];
            // d($group_by,true);
            $status =  'All';

            $rowStatus = (($row['mrn_qty']<$row['po_qty'])?'Pending':'Cleared');
            if($this->request->post['status']=='Cleared'&&($rowStatus==$this->request->post['status'])){
                $status = 'Cleared';
            } else if($this->request->post['status']=='Pending'&&($rowStatus==$this->request->post['status'])){
                $status = 'Pending';
            }
                // d($row, true);
            $arrRows[$status][$group_name][] = array(
                'document_type_id' => $row['document_type_id'],
                'document_id' => $row['document_id'],
                'voucher_date' => $row['document_date'],
                'voucher_no' => $row['document_identity'],
                'currency' => $arrCurrency[$row['document_currency_id']],
                'conversion_rate' => $row['conversion_rate'],
                'document_identity' => $row['document_identity'],
                'warehouse_id' => $row['warehouse_id'],
                'product_category_id' => $row['product_category_id'],
                'product_id' => $row['product_id'],
                'product_code'=>$row['product_code'],
                'product' => $row['product_name'],
                'partner_id' => $row['partner_id'],
                'partner' => $arrPartner[$row['partner_id']],
                'partner_type_id' => $row['partner_type_id'],
                'partner_type' => $arrPartnerType[$row['partner_type_id']],
                'unit_id' => $row['unit_id'],
                'qty' => ($status=='Pending')?($row['po_qty']-$row['mrn_qty']):$row['po_qty'],
                'mrn_qty' => $row['mrn_qty'],
                'po_qty' => $row['po_qty'],
                'status' => $row['mrn_qty']<$row['po_qty']?'Pending':'Cleared',
                'rate' => ($row['po_qty']==0?0:($row['amount']/$row['po_qty'])),
                'amount' => $row['amount'],
            );
        }

        // d($arrRows, true);

        $pdf = new PDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hira Anwer');
        $pdf->SetTitle('Purchase Order Report');
        $pdf->SetSubject('Purchase Order Report');

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

        foreach ($arrRows[$this->request->post['status']] as $group_by => $value) {
            // d($value);
            $pdf->SetFont('helvetica', 'B', 7);
            $pdf->Cell(0, 5, $group_by, 0, false, 'L');
            $pdf->ln(5);
            $sr = 1;
            $total_amount = 0;
            foreach ($value as $key1 => $detail) {
                $total_amount += $detail['amount'];
                $pdf->SetFont('helvetica', '', 6);
                if(strlen($detail['product'])<=35 && strlen($detail['partner'])<=35) {
            $pdf->Cell(16, 5, $detail['voucher_date'], 1, false, 'L');
            $pdf->Cell(26, 5, $detail['voucher_no'], 1, false, 'L');
            $pdf->Cell(50, 5, $detail['partner'], 1, false, 'L');
            $pdf->Cell(55, 5, $detail['product_code'].' - '.$detail['product'], 1, false, 'L');
            $pdf->Cell(15, 5, round_decimal($detail['qty'],2), 1, false, 'R');
            $pdf->Cell(20, 5, round_decimal($detail['rate'],2), 1, false, 'R');
            $pdf->Cell(23, 5, round_decimal($detail['amount'],2), 1, false, 'R');
            $pdf->ln(5);
                }
                else
                {
                    $arrRemarks = str_split($detail['product_code'].' - '.$detail['product'], 35);
                    $arrpartner = str_split($detail['partner'], 35);
                    foreach($arrRemarks as $index => $product) {
                     if($index==0) {
                        $pdf->Cell(16, 5, $detail['voucher_date'], 'TLR', false, 'L');
                        $pdf->Cell(26, 5, $detail['voucher_no'], 'TLR', false, 'L');
                        $pdf->Cell(50, 5, $arrpartner[$index], 'TLR', false, 'L');
                        $pdf->Cell(55, 5, $product, 'TLR', false, 'L');
                        $pdf->Cell(15, 5, round_decimal($detail['qty'],2), 'TLR', false, 'R');
                        $pdf->Cell(20, 5, round_decimal($detail['rate'],2), 'TLR', false, 'R');
                        $pdf->Cell(23, 5, round_decimal($detail['amount'],2), 'TLR', false, 'R');
                        $pdf->ln(5);
                        }
                        elseif($index==count($arrRemarks)-1) {
                            $pdf->Cell(16, 5, '', 'BLR', false, 'L');
                            $pdf->Cell(26, 5, '', 'BLR', false, 'L');
                            $pdf->Cell(50, 5, $arrpartner[$index], 'BLR', false, 'L');
                            $pdf->Cell(55, 5, $product, 'BLR', false, 'L');
                            $pdf->Cell(15, 5, '', 'BLR', false, 'L');
                            $pdf->Cell(20, 5, '', 'BLR', false, 'L');
                            $pdf->Cell(23, 5, '', 'BLR', false, 'L');
                            $pdf->ln(5);
                        }
                        else {
                            $pdf->Cell(16, 5, '', 'LR', false, 'L');
                            $pdf->Cell(26, 5, '', 'LR', false, 'L');
                            $pdf->Cell(50, 5, $arrpartner[$index], 'LR', false, 'L');
                            $pdf->Cell(55, 5, $product, 'LR', false, 'L');
                            $pdf->Cell(15, 5, '', 'LR', false, 'L');
                            $pdf->Cell(20, 5,'', 'LR', false, 'L');
                            $pdf->Cell(23, 5, '', 'LR', false, 'L');
                            $pdf->ln(5);
                        }
                    }
                }

                $sr++;
            }

            $pdf->SetFont('helvetica', 'B', 6);
            $pdf->Cell(182, 5, 'Total Amount : ', 1, false, 'R');
            $pdf->Cell(23, 5, round_decimal($total_amount,2), 1, false, 'R');
            $pdf->ln(7);
        }

        //Close and output PDF document
        $pdf->Output('Purchase Order Report'.date('YmdHis').'.pdf', 'I');

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
        $this->SetFont('helvetica', 'B', 12);
        $this->Ln(2);
        // Title
        $this->Cell(0, 7, $this->data['company_branch_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);
        $this->Cell(0, 7, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 10);
        $this->Ln(7);
        $status = 'Status: ' . $this->data['status'];
        $this->Cell(0, 7, $status, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(7);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 7, 'From : '. $this->data['from_date'].' | '.'To : '. $this->data['to_date'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->ln(7);
        $this->SetFont('helvetica', 'B', 6);
        $this->Cell(16, 5, 'Doc. Date', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(26, 5, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(50, 5, 'Partner', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(55, 5, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(15, 5, 'Qty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 5, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(23, 5, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
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