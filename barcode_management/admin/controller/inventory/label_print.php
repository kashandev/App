<?php

class ControllerInventoryLabelPrint extends HController {

    protected function getAlias() {
        return 'inventory/label_print';
    }

    protected function init() {
        $this->model[$this->getAlias()] = $this->load->model('inventory/product');
        $this->data['lang'] = $this->load->language($this->getAlias());
        $this->document->setTitle($this->data['lang']['heading_title']);
        $this->data['token'] = $this->session->data['token'];
    }

    protected function getList() {
        parent::getList();

        $this->model['product_category'] = $this->load->model('inventory/product_category');
        $this->data['product_categories'] = $this->model['product_category']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->model['product'] = $this->load->model('inventory/product_master');
        $this->data['products'] = $this->model['product']->getRows(array('company_id' => $this->session->data['company_id']));

        $this->data['href_get_product_json'] = $this->url->link($this->getAlias() . '/getProductJson', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_print_label'] = $this->url->link($this->getAlias() .'/printLabel', 'token=' . $this->session->data['token'], 'SSL');

       $this->data['href_get_serial_no_by_product'] = $this->url->link($this->getAlias() . '/getSerialNoByProduct', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = $this->getAlias() . '.tpl';
        $this->response->setOutput($this->render());
    }


    
    public function getProductJson() {
        $search = $this->request->post['q'];
        $page = $this->request->post['page'];

        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $rows = $this->model['product_master']->getProductJson($search, $page);

        echo json_encode($rows);
    }




    public function getSerialNoByProduct() {
       
        $post = $this->request->post;
        $session = $this->session->data;
        $this->model['product'] = $this->load->model('inventory/product');
        $where = '';
        $where = "`company_id` =" . $this->session->data['company_id'];
        $where.= "  AND `product_master_id` = '". $post['product_master_id'] ."'";
        $where.="Order By `serial_no`";
        $serial_no = $this->model['product']->getRows($where);

        $json = [
            'product' => $serial_no,
        ];

        echo json_encode($json);
        exit;

    }

    public function printLabel() {
        ini_set('max_execution_time',0);
        ini_set('memory_limit',-1);

        //d(array('session' => $this->session->data, 'post' => $this->request->post, 'get' => $this->request->get), true);
        $lang = $this->load->language($this->getAlias());
        $post = $this->request->post;
        $session = $this->session->data;

        $this->model['product_master'] = $this->load->model('inventory/product_master');
        $this->model['product'] = $this->load->model('inventory/product');
        $product_master = $this->model['product_master']->getRow(array('product_master_id' => $post['product_master_id']),array('created_at'));
        $products = $this->model['product']->getRows(array('product_master_id' => $post['product_master_id']),array('sort_order'));

        //d(array('post'=>$post, 'session'=>$session, 'product'=>$product), true);
        $pdf = new PDF('P', PDF_UNIT, array(50.8,30.4), true, 'UTF-8', false);
        $pdf->setPageOrientation('L',false,'');
        $pdf->SetAutoPageBreak(TRUE, 0);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Huzaifa Khambaty');
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
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);


        // set auto page breaks
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('times', '', 8);

        // add a page
        $pdf->AddPage();

        $column = 1;
        $total_products = '';
        $this_code = '';
        $pdf->SetFont('helvetica', '', 8);

        // d($product,true);

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

        $total_products = $products;
        $chunks = ($post['column']==1) ? $products : array_chunk($total_products, $post['column']);
        foreach ($chunks as $key=> $products) {
            $key++;

            if($post['column']==1){

                $pdf->Cell(14, 0, '', 0, 0,'C');
                $pdf->Cell(23, 0, $session['company_name'], 0, 0,'C');


               $this_code =  (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $products['serial_no'])) ? 'C128' : 'C39';

                $pdf->ln(1);
                $pdf->Cell(48, 0, '', 0, 1,'C');
                $pdf->Cell(48, 0, $products['name'], 0, 1,'C');
                $pdf->Cell(48, 8,'',0,1);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->setXY($x,$y);
                $pdf->write1DBarcode($products['serial_no'], $this_code,$x+2,$y-9,44,12,0.4,$style,'M');
                $pdf->ln(6);
                $pdf->Cell(48, 0, $products['serial_no'], 0, 1,'C');
                $pdf->Cell(48, 0, 'Price: '.number_format($products['cost_price'],2,".",""), 0, 0,'C');
            } 
                elseif($post['column']==2) {
                    $pdf->Cell(14, 0, '', 0, 0,'C');
                    $pdf->Cell(23, 0, $session['company_name'], 0, 0,'C');

               foreach($products as $k=> $product) { // start
                
                    if($k!=0){
                         $pdf->Cell(2, 0, '', 0, 0,'C');
                         $pdf->Cell(23, 0, $product['name'], 0, 0,'C');
                    }else{
                        $pdf->ln(3);
                        $pdf->Cell(23, 0, $product['name'], 0, 0,'C');
                    }
                }
    
                foreach($products as $k=> $product) { // start

                    $this_code =  (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $product['serial_no'])) ? 'C128' : 'C39';
                    if($k!=0){
                        $pdf->ln(-4);
                        $pdf->Cell(25,8,'',0);
                    }else{
                      $pdf->ln(3);
                    }


                $pdf->Cell(23,8,'',0);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->setXY($x,$y);
                $pdf->write1DBarcode($product['serial_no'],  $this_code,$x-23,$y,23,7,0.4,$style,'M');

                }

                 foreach($products as $k=> $product) { // start
                    if($k!=0){
                         $pdf->Cell(2, 0, '', 0, 0,'C');
                         $pdf->Cell(23, 0, $product['serial_no'], 0, 0,'C');
                    }else{
                         $pdf->ln(4);
                        $pdf->Cell(23, 0, $product['serial_no'], 0, 0,'C');
                    }
                }

                 foreach($products as $k=> $product) { // start
                    if($k!=0){
                         $pdf->Cell(2, 0, '', 0, 0,'C');
                         $pdf->Cell(23, 0, $product['cost_price'], 0, 0,'C');
                    }else{
                         $pdf->ln(4);
                        $pdf->Cell(23, 0, $product['cost_price'], 0, 0,'C');
                    }
                }
            }
            //  else {
            //     $pdf->Cell(22, 0, $session['company_name'], 0, 0,'C','','',1);
            //     $pdf->Cell(2, 0, '', 0, 0,'C');
            //     $pdf->Cell(22, 0, $session['company_name'], 0, 0,'C','','',1);
            //     $pdf->Cell(2, 0, '', 0, 0,'C');
            //     $pdf->Cell(22, 0, $session['company_name'], 0, 0,'C','','',1);
            //     $pdf->ln(3);
            //     $pdf->Cell(22, 0, $product['name'], 0, 0,'C','','',1);
            //     $pdf->Cell(2, 0, '', 0, 0,'C');
            //     $pdf->Cell(22, 0, $product['name'], 0, 0,'C','','',1);
            //     $pdf->Cell(2, 0, '', 0, 0,'C');
            //     $pdf->Cell(22, 0, $product['name'], 0, 0,'C','','',1);
            //     $pdf->ln(3);
            // }

            if($key<count($chunks) && $post['column'] >= 1) {
                $pdf->AddPage();
            }
        }
        //Close and output PDF document
        $pdf->Output('Cash Register:'.date('YmdHis').'.pdf', 'I');
    }

}

class PDF extends TCPDF {
    //public $data = array();

//    //Page header
//     public function Header() {
// //        // Logo
// //        if($this->data['company_logo'] != '') {
// //            $image_file = DIR_IMAGE.$this->data['company_logo'];
// //            //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
// //            $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
// //        }
// //        // Set font
// //        $this->SetFont('helvetica', 'B', 20);
// //        $this->Ln(2);
// //        // Title
// //        $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
// //        $this->Ln(10);
// //        $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
//     }
//
//    // Page footer
//    public function Footer() {
//        // Position at 15 mm from bottom
//        $this->SetY(-15);
//        // Set font
//        $this->SetFont('helvetica', 'I', 8);
//        // Page number
//        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//    }
}

?>