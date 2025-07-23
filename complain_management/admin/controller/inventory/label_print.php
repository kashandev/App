<?php

class ControllerInventoryLabelPrint extends HController {

    protected function getAlias() {
        return 'inventory/label_print';
    }

    protected function init() {
        $this->model[$this->getAlias()] = $this->load->model('setup/product');
        $this->data['lang'] = $this->load->language($this->getAlias());
        $this->document->setTitle($this->data['lang']['heading_title']);
        $this->data['token'] = $this->session->data['token'];
    }

    protected function getList() {
        parent::getList();

        $this->model['product_category'] = $this->load->model('setup/product_category');
        $this->data['product_categories'] = $this->model['product_category']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['product'] = $this->load->model('setup/product');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['href_print_label'] = $this->url->link($this->getAlias() .'/printLabel', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['url_get_Product_Info'] = $this->url->link($this->getAlias() .'/getProductInfo', 'token=' . $this->session->data['token'], 'SSL');


        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }



    public function getProductInfo(){
        $post = $this->request->post;
        $this->model['product'] = $this->load->model('setup/product');
        $product = $this->model['product']->getRow(array('product_id' => $post['product_id']));
        echo json_encode([
            'post' => $post,
            'product' => $product
        ]);
    }


    public function printLabel() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        //d(array('session' => $this->session->data, 'post' => $this->request->post, 'get' => $this->request->get), true);
        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;


        $this->model['product'] = $this->load->model('setup/product');
        $product = $this->model['product']->getRow(array('product_id' => $post['product_id']));

        //d(array('post'=>$post, 'session'=>$session, 'product'=>$product), true);
        $pdf = new PDF('P', 'mm', array(99.06,27.94), true, 'UTF-8', false);
        $pdf->setPageOrientation('L',false,'');
        $pdf->SetAutoPageBreak(TRUE, 0);

        

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Label Print');
        $pdf->SetSubject('label Print');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'company_logo' => $session['company_image']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(1, 1, 1);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);

        // set font
        // $pdf->SetFont('times', '', 8);

        // add a page
        $pdf->AddPage();

        $column = 1;
        $pdf->SetFont('helvetica', '', 8);

        // define barcode style
        $style = array(
            'position' => 'S',
            'align' => 'C',
            'stretch' => true,
            'fitwidth' => false,
            'cellfitalign' => 'C',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => false,
            'font' => 'helvetica',
            'fontsize' => 5,
            //'module_width' => 13,
        );
        for($i=1;$i<=$post['quantity'];$i+=$post['column']) {
            if($post['column']==1) {
                $pdf->ln(3);
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(45, 0, $session['company_name'], 0, 0,'C');
                $pdf->Cell(45, 0, '', 0, 1,'C');
                $pdf->SetFont('helvetica', '', 8);
                $pdf->ln(9);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->setXY($x,$y);
                $pdf->write1DBarcode($product['product_code'], 'C128A',$x+2,$y-9,40,8,0.4,$style,'M');
                $pdf->ln(3);
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(45, 0, $product['name'], 0, 1,'C');
                $pdf->ln(1.5);
                $pdf->Cell(22, 0, $product['product_code'], 0, 0,'L');
                $pdf->Cell(22, 0, 'Price: '.number_format($post['total_price'],2,".",""), 0, 0,'R');

            } elseif($post['column']==2) {
                $pdf->ln(3);
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(45, 0, $session['company_name'], 0, 0,'C');
                $pdf->Cell(5, 0, '', 0, 0,'C');
                $pdf->Cell(45, 0, $session['company_name'], 0, 0,'C');
                $pdf->Cell(45, 0, '', 0, 1,'C');
                $pdf->SetFont('helvetica', '', 8);

                $pdf->ln(2);
                $pdf->Cell(45,0,'',0);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->setXY($x,$y);
                $pdf->write1DBarcode($product['product_code'], 'C128A',$x-45,$y-2,40,8,0.4,$style,'M');
                // $pdf->Cell(2,0,'',0);
                $pdf->Cell(45,0,'',0);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->setXY($x,$y);
                $pdf->write1DBarcode($product['product_code'], 'C128A',$x-35,$y-4,40,8,0.4,$style,'M');
                
                $pdf->ln(3);
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(45, 0, $product['name'], 0, 0,'C');
                $pdf->Cell(5, 0, '', 0, 0,'C');
                $pdf->Cell(45, 0, $product['name'], 0, 0,'C');
                

                $pdf->ln(5);
                $pdf->Cell(22, 0, $product['product_code'], 0, 0,'L');
                $pdf->Cell(22, 0, 'Price: '.number_format($post['total_price'],2,".",""), 0, 0,'R');
                
                $pdf->Cell(5, 0, '', 0, 0,'C');

                $pdf->Cell(22, 0, $product['product_code'], 0, 0,'L');
                $pdf->Cell(22, 0, 'Price: '.number_format($post['total_price'],2,".",""), 0, 0,'R');

            } else {
                $pdf->Cell(22, 0, $session['company_name'], 0, 0,'C','','',1);
                $pdf->Cell(2, 0, '', 0, 0,'C');
                $pdf->Cell(22, 0, $session['company_name'], 0, 0,'C','','',1);
                $pdf->Cell(2, 0, '', 0, 0,'C');
                $pdf->Cell(22, 0, $session['company_name'], 0, 0,'C','','',1);
                $pdf->ln(3);
                $pdf->Cell(22, 0, $product['name'], 0, 0,'C','','',1);
                $pdf->Cell(2, 0, '', 0, 0,'C');
                $pdf->Cell(22, 0, $product['name'], 0, 0,'C','','',1);
                $pdf->Cell(2, 0, '', 0, 0,'C');
                $pdf->Cell(22, 0, $product['name'], 0, 0,'C','','',1);
                $pdf->ln(3);
            }
            if(($i<$post['quantity'] - 1)) {
                $pdf->AddPage();
            }
        }

        //Close and output PDF document
        $pdf->Output('Cash Register:'.date('YmdHis').'.pdf', 'I');
    }


    // Print Labels

    public function printLabels(){

        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        $lang = $this->load->language($this->getAlias());
        $get = $this->request->get;
        $session = $this->session->data;
        
        $this->model['sale_tax_invoice'] = $this->load->model('inventory/sale_tax_invoice');
        $this->model['sale_tax_invoice_detail'] = $this->load->model('inventory/sale_tax_invoice_detail');
        $this->model['company'] = $this->load->model('setup/company');
        $company_address = $this->model['company']->getRow(array('company_id' => $session['company_id']));
        $invoice = $this->model['sale_tax_invoice']->getRow(array('sale_tax_invoice_id' => $get['sale_tax_invoice_id']));

        $this->model['partner_category'] = $this->load->model('setup/partner_category');
        $partner_category_id = $this->model['partner_category']->getRow(array('partner_category_id' => $invoice['partner_category_id']));
        
        $details = $this->model['sale_tax_invoice_detail']->getRows(array('sale_tax_invoice_id' => $get['sale_tax_invoice_id']), array('sort_order asc'));

        $pdf = new PDF('P', 'mm', array(99.06,27.94), true, 'UTF-8', false);
        $pdf->setPageOrientation('L',false,'');
        $pdf->SetAutoPageBreak(TRUE, 0);

        

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Muhammad Salman');
        $pdf->SetTitle('Print Labels');
        $pdf->SetSubject('Print Labels');

        //Set Header
        $pdf->data = array(
            'company_name' => $session['company_name'],
            'report_name' => $lang['heading_title'],
            'company_logo' => $session['company_image']
        );

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(1, 1, 1);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);

        // set font
        // $pdf->SetFont('times', '', 8);

        // add a page
        $pdf->AddPage();

        $column = 1;
        $pdf->SetFont('helvetica', '', 8);

        // define barcode style
        $style = array(
            'position' => 'S',
            'align' => 'C',
            'stretch' => true,
            'fitwidth' => false,
            'cellfitalign' => 'C',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => false,
            'font' => 'helvetica',
            'fontsize' => 5,
            //'module_width' => 13,
        );

        $product = array();
        foreach ($details as $detail) {
            for($i=1; $i<=$detail['qty']; $i++ ){
                $product[] = $detail;
            }
        }


        // d($product);
       
       for( $i=0; $i< count($product); $i+=2 ){

                $pdf->ln(3);
                $pdf->SetFont('helvetica', 'B', 12);
                $pdf->Cell(45, 0, $session['company_name'], 0, 0,'C');
                $pdf->Cell(5, 0, '', 0, 0,'C');

                if(($i<(count($product)-1))) {
                    $pdf->Cell(45, 0, $session['company_name'], 0, 0,'C');
                }

                $pdf->Cell(45, 0, '', 0, 1,'C');
                $pdf->SetFont('helvetica', '', 8);
                $pdf->ln(2);
                
                $pdf->Cell(45,0,'',0);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->setXY($x,$y);
                $pdf->write1DBarcode(strtoupper($product[$i]['product_code']), 'C128A', ($x-45), ($y-2), 40, 8, 0.4, $style, 'M');
                // d($product[$i]['product_code']);

                if(($i<(count($product)-1))) {
                    $pdf->Cell(45,0,'',0);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->setXY($x,$y);
                    $pdf->write1DBarcode(strtoupper($product[($i+1)]['product_code']), 'C128A', ($x-35), ($y-4), 40, 8, 0.4, $style, 'M');
                    // d($product[($i+1)]['product_code']);
                }
                
                $pdf->ln(3);
                
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(45, 0, $product[$i]['product_name'], 0, 0,'C');

                if(($i<(count($product)-1))) {  
                    $pdf->Cell(5, 0, '', 0, 0,'C');
                    $pdf->Cell(45, 0, $product[($i+1)]['product_name'], 0, 0,'C');
                }
                

                $pdf->ln(5);
                $pdf->Cell(22, 0, strtoupper($product[$i]['product_code']), 0, 0,'L');
                $pdf->Cell(22, 0, 'Price: '.number_format($product[$i]['label_amount'],2,".",""), 0, 0,'R');
                
                $pdf->Cell(5, 0, '', 0, 0,'C');
                if(($i<(count($product)-1))) {    
                    $pdf->Cell(22, 0, strtoupper($product[($i+1)]['product_code']), 0, 0,'L');
                    $pdf->Cell(22, 0, 'Price: '.number_format($product[($i+1)]['label_amount'],2,".",""), 0, 0,'R');  
                }

            if(($i<(count($product)-2))) {
                $pdf->AddPage();
            }

       }

       

        //Close and output PDF document
        $pdf->Output('print_labels:'.date('YmdHis').'.pdf', 'I');


    }

}

class PDF extends TCPDF {
    public $data = array();

//    //Page header
    public function Header() { }
//    // Page footer
   public function Footer() { }
}

?>