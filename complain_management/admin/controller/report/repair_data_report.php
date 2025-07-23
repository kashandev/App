<?php

class ControllerReportRepairDataReport extends HController {

    protected function getAlias() {
        return 'report/repair_data_report';
    }

    protected function getList() {
        parent::getList();

        $this->model['customer'] = $this->load->model('setup/customer');

        $where = "company_id=" . $this->session->data['company_id'];
        // $where .= " AND partner_category_id=" .'1';


        $this->data['action_validate_date'] = $this->url->link('common/function/validateDate', 'token=' . $this->session->data['token']);
        $this->data['href_print_report'] = $this->url->link($this->getAlias() .'/printReport', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['href_print_excel_report'] = $this->url->link($this->getAlias() .'/printExcelReport', 'token=' . $this->session->data['token'], 'SSL');
        
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

    

    // print report function 
    public function printReport()
    {
        $this->init();
        ini_set('memory_limit','1024M');
        $post = $this->request->post;
        $session = $this->session->data;
        $filter = array();
        $color = array();
        $header_style = array();
        $row_style = array();
        $home_type = '';
        $normal_type = '';
        $warranty_type = '';
        $no_warranty_type = '';
        $repeat_warranty_type = '';  
        $this_qty_label = '';
        $this_name_label = '';
        $this_home_job_order_type = '';
        $this_job_order_types = '';
        $this_normal_type = '';
        $remove_space = '';
        $filter[] = "joe.`company_id` = ".$this->session->data['company_id']."";
        $filter[] = "joe.`company_branch_id` = ".$this->session->data['company_branch_id']."";
        $filter[] = "joe.`fiscal_year_id` = ".$this->session->data['fiscal_year_id']."";
        if(isset($post['date_from']) && $post['date_from'] != '') {
            $filter[] = "joe.`document_date` >= '".MySqlDate($post['date_from'])."'";
        }
        if(isset($post['date_to']) && $post['date_to'] != '') {
            $filter[] = "joe.`document_date` <= '".MySqlDate($post['date_to'])."'";
        }
        if(isset($post['job_order_type']) && $post['job_order_type'] != '') {
            $filter[] = "jo.`job_order_type` = '".$post['job_order_type']."'";
        }

        $this->model['repair_data_report'] = $this->load->model('report/repair_data_report');
        $rows = $this->model['repair_data_report']->getRepairDataReport($filter,array('jo.`document_identity`'));
        $company_name = 'Name :'. ' ' . $session['company_name'];


        $month = date_create(MySqlDate($post['date_from']));
        $month = date_format($month,'M - Y');
        $date = $month;    

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;
        $this_qty_label = 'Qty';
        $this_name_label = 'Part / Service';

        $header_style = array(
         'borders' => array(
         'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

           foreach($rows as $type)
           {  

               if($type['job_order_type'] == 'home')
               {
                   $home_type = 'H/C = HOME COMPLAIN ,';
               }
               if($type['job_order_type'] == 'warranty')
               {
                   $warranty_type = 'W/C = WARRANTY ,';  
                   $this_warranty_type = $warranty_type;
               }
               if($type['job_order_type'] == 'no_warranty')
               {
                   $no_warranty_type ='NW/C = NO WARRANTY ,';
                   $this_job_order_types =  $no_warranty_type;
               }
               if($type['job_order_type'] == 'normal')
               {
                   $normal_type = 'NR = NORMAL ,';  
                   $this_normal_type =  $normal_type;  
               }
               if($type['job_order_type'] == 'repeat')
               {
                   $repeat_warranty_type = 'RP = REPEAT ,';  
                   $this_job_order_types = $repeat_warranty_type;
               }  

               if($post['job_order_type'] == '' || $post['job_order_type'] != '')  
               {
                 $this_warranty_type = $warranty_type;
                 $this_home_job_order_type = $home_type;
             }
          }

       $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,'Panasonic Repair Data')->getStyle('F'.$rowCount)->getFont()->setBold( false )->setSize(20);

      
        $objPHPExcel->getActiveSheet()->mergeCells('M'.$rowCount.':Q'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount,'Authorized Service Centre')->getStyle('M'.$rowCount)->getFont()->setBold( true )->setSize(18);

        $rowCount++;


        $objPHPExcel->getActiveSheet()->mergeCells('G'.$rowCount.':H'.$rowCount); 
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,'Month: ')->getStyle('G'.$rowCount)->getFont()->setBold( false )->setSize(20);


        $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':J'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,$date)->getStyle('I'.$rowCount)->getFont()->setBold( true )->setSize(18);


        $objPHPExcel->getActiveSheet()->mergeCells('M'.$rowCount.':Q'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $company_name)->getStyle('M'.$rowCount)->getFont()->setBold( true )->setSize(16);

        $rowCount++;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
          )
         )       
        );

        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Service Center Name')->getStyle('A'.$rowCount)->getFont()->setBold( true );


          $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
          ),    
        )         
        );

        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

         $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
         $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Job Order Type')->getStyle('D'.$rowCount)->getFont()->setBold( true );

         $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
          ),    
        )         
        );


        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':G'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Job Number')->getStyle('F'.$rowCount)->getFont()->setBold( true );




        $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
        );


        $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('H'.$rowCount.':I'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Customer Name')->getStyle('H'.$rowCount)->getFont()->setBold( true );



        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
        );


        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':L'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Address')->getStyle('J'.$rowCount)->getFont()->setBold( true );



         $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
        );

        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('M'.$rowCount.':N'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Contact No')->getStyle('M'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



          $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
        );

        $objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':P'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, 'Repair Status')->getStyle('O'.$rowCount)->getFont()->setBold( true );


           $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
         )
         )
        );


        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':R'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, 'Model')->getStyle('Q'.$rowCount)->getFont()->setBold( true );


         $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );

       $objPHPExcel->getActiveSheet()->mergeCells('S'.$rowCount.':T'.$rowCount);
       $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, 'Serial No')->getStyle('S'.$rowCount)->getFont()->setBold( true );
 

       $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );

        $objPHPExcel->getActiveSheet()->mergeCells('U'.$rowCount.':V'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, 'Warranty Status')->getStyle('U'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


      $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );

        $objPHPExcel->getActiveSheet()->mergeCells('W'.$rowCount.':X'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, 'Warranty Type')->getStyle('W'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('Y'.$rowCount.':Z'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, 'Purchase Date')->getStyle('Y'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('AA'.$rowCount.':AB'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, 'Receive Date')->getStyle('AA'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('AC'.$rowCount.':AD'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, 'Complete Date')->getStyle('AC'.$rowCount)->getFont()->setBold( true );



        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('AE'.$rowCount.':AF'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, 'Delivery Date')->getStyle('AE'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AG'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AG'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('AG'.$rowCount.':AI'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, 'Fault Description')->getStyle('AG'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AJ'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AJ'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );

        $objPHPExcel->getActiveSheet()->mergeCells('AJ'.$rowCount.':AK'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, 'Symptom')->getStyle('AJ'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('AL'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AL'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('AL'.$rowCount.':AO'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AL'.$rowCount, 'Repair Remarks')->getStyle('AL'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AP'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AP'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );

        $objPHPExcel->getActiveSheet()->mergeCells('AP'.$rowCount.':AQ'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AP'.$rowCount, $this_qty_label)->getStyle('AP'.$rowCount)->getFont()->setBold( true );




        $objPHPExcel->getActiveSheet()->getStyle('AR'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


      $objPHPExcel->getActiveSheet()->getStyle('AR'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );

        $objPHPExcel->getActiveSheet()->mergeCells('AR'.$rowCount.':AV'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AR'.$rowCount, $this_name_label)->getStyle('AR'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('AW'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



      $objPHPExcel->getActiveSheet()->getStyle('AW'.$rowCount)->applyFromArray(
           array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4285F4')
        )
        )
       );


        $objPHPExcel->getActiveSheet()->mergeCells('AW'.$rowCount.':AX'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AW'.$rowCount, 'TAT')->getStyle('AW'.$rowCount)->getFont()->setBold( true );


         $objPHPExcel->getActiveSheet()->getStyle('A3:AX3')->applyFromArray($header_style);


        if($post['job_order_type'] =='')
        {
            $rowCount++;
        }
        else
        {
           $rowCount++;
        }
        $sr = 0;

          foreach($rows as $data)
          {

            $job_order_estimate_id = $data['job_order_estimate_id'];
            $sub_filter[] = "joed.`job_order_estimate_id` = '".$job_order_estimate_id."'";
            $data['warranty'] == 'Y' ? $warranty = 'Yes' : $warranty = 'No'; 
            $data['purchased_date'] == '' ? $purchased_date = '' : $purchased_date = stdDate($data['purchased_date']);
            $data['received_date'] == '' ? $received_date = '' : $received_date = stdDate($data['received_date']);
            $data['complete_date'] == '' ? $complete_date = '' : $complete_date = stdDate($data['complete_date']); 
            $data['delivery_date'] == '' ? $delivery_date = '' : $delivery_date = stdDate($data['delivery_date']);

            if($data['product_type'] == 'part')
            {
                $data['name'] = $data['part_name'];
                $data['qty'] = $data['qty'];
                $data['amount'] = $data['amount'];
            }
            else
            { 
                $data['name'] = $data['service_name'];
                $data['qty'] = 1;
                $data['amount'] = $data['amount'];
                           
            }


           $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $session['company_name']);


            $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );


        if($data['job_order_type'] == 'home' ){
            $color = array('rgb' => 'F4B400');
        }
        // if($data['job_order_type'] == 'repeat' ){
        //     $color = array('rgb' => 'FF0000');
        // }
        if($data['job_order_type'] == 'warranty'){
            $color = array('rgb' => '4285F4');
        }
        if($data['job_order_type'] == 'normal'){
            $color = array('rgb' => 'fcfdff');
        }
        if($data['job_order_type'] == 'no_warranty'){
            $color = array('rgb' => 'fcfdff');
        }
        if($data['job_order_type'] == ''){
            $color = array('rgb' => 'fcfdff');  
        }

       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }


        $remove_space = str_replace("_", ' ', $data['job_order_type']);
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ucwords($remove_space));


        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

       //  $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
       //     array(
       //      'fill' => array(
       //      'type' => PHPExcel_Style_Fill::FILL_SOLID,
       //      'color' => $color
       //    )
       //   )
       // );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }



      $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':G'.$rowCount);
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $data['job_order_no']);



     $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

        $objPHPExcel->getActiveSheet()->mergeCells('H'.$rowCount.':I'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $data['customer_name']);


         $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }


        $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':L'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $data['customer_address']);



        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->mergeCells('M'.$rowCount.':N'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $data['customer_contact'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

        $objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':P'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $data['repair_status']);


        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        $objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':R'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Q'.$rowCount, $data['model'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

         $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
         $objPHPExcel->getActiveSheet()->mergeCells('S'.$rowCount.':T'.$rowCount);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('S'.$rowCount,  $data['product_serial_no'], PHPExcel_Cell_DataType::TYPE_STRING);



        $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

        $objPHPExcel->getActiveSheet()->mergeCells('U'.$rowCount.':V'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $warranty)->getStyle('U'.$rowCount);


        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }

        $objPHPExcel->getActiveSheet()->mergeCells('W'.$rowCount.':X'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $data['warranty_type']);



        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }


        $objPHPExcel->getActiveSheet()->mergeCells('Y'.$rowCount.':Z'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $purchased_date);


        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }


        $objPHPExcel->getActiveSheet()->mergeCells('AA'.$rowCount.':AB'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $received_date);


        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );




       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }


        $objPHPExcel->getActiveSheet()->mergeCells('AC'.$rowCount.':AD'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $complete_date);


        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );



       if($data['job_order_type']!='repeat')
       {

        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->applyFromArray(
          array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => $color
          )
         )        
       ); 
       }
       else
       {
        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->applyFromArray(
          array(
            'font' => array(
             'color' => array('rgb' => 'FF0000')
           )  
          )
         ); 
       }


        $objPHPExcel->getActiveSheet()->mergeCells('AE'.$rowCount.':AF'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, $delivery_date);


        $objPHPExcel->getActiveSheet()->getStyle('AG'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AG'.$rowCount.':AI'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, $data['fault_description']);


        $objPHPExcel->getActiveSheet()->getStyle('AJ'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AJ'.$rowCount.':AK'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, $data['symptom']);

        $objPHPExcel->getActiveSheet()->getStyle('AL'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AL'.$rowCount.':AO'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AL'.$rowCount, $data['repair_remarks']);


        $objPHPExcel->getActiveSheet()->getStyle('AP'.$rowCount1)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
          );

         $objPHPExcel->getActiveSheet()->mergeCells('AP'.$rowCount.':AQ'.$rowCount);
         $objPHPExcel->getActiveSheet()->SetCellValue('AP'.$rowCount, $data['qty']);

        $objPHPExcel->getActiveSheet()->getStyle('AR'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AR'.$rowCount.':AV'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AR'.$rowCount, $data['name']);

        $objPHPExcel->getActiveSheet()->getStyle('AW'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AW'.$rowCount.':AX'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AW'.$rowCount,  $data['tat']);


        $row_style = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
         );

         $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':AX'.$rowCount)->applyFromArray($row_style);
         $rowCount++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="repair_data_report.xlsx"');
        header('Cache-Control: max-age=0');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter->save('some_excel_file.xlsx');
        $objWriter->save('php://output');
        exit;

    }
     
}

class PDF extends TCPDF {
    public $data = array();

    //Page header
    public function Header() {
        // // Logo
        // if($this->data['company_logo'] != '') {
        //     $image_file = DIR_IMAGE.$this->data['company_logo'];
        //     //$this->Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
        //     $this->Image($image_file, 10, 10, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // }
        // // Set font
        // $this->SetFont('times', 'B', 28);
        // $this->Ln(2);
        // // Title
        // $this->Cell(0, 10, $this->data['company_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln(10);
        // $this->Cell(0, 10, $this->data['report_name'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->SetFont('helvetica', '', 13);
        // $this->ln(14);
 
        //     $this->Cell(50, 7, 'Service Center Name', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(38, 7, 'Job Number', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(38, 7, 'Customer Name', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(40, 7, 'Address', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'Contact No', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(38, 7, 'Repair Status', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'Model', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'Serial Number', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'WarrantyStatus', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'WarrantyType', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'PurchaseDate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'Receiveate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'CompleteDate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'DeliveryDate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'Symptom', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(30, 7, 'FaultDesc', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(22, 7, 'RepairRemarks', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(12, 7, 'PartQty', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(14, 7, 'PartUsed', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     $this->Cell(12, 7, 'TAT', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(25, 7, 'Doc. No.', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(52, 7, 'Product', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(30, 7, 'Customer', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(30, 7, 'Warehouse', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(17, 7, 'Quantity', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(15, 7, 'Unit', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(17, 7, 'Rate', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(25, 7, 'Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(17, 7, 'Dis Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(25, 7, 'Tax Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
        //     // $this->Cell(25, 7, 'Total Amount', 1, false, 'C', 0, '', 0, false, 'M', 'M');
  
    }

    // Page footer
    public function Footer() {
        // // Position at 15 mm from bottom
        // $this->SetY(-15);
        // // Set font
        // $this->SetFont('times', 'I', 8);
        // // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>