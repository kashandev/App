<?php

class ControllerReportJobOrderReport extends HController {

    protected function getAlias() {
        return 'report/job_order_report';
    }

    protected function getList() {
        parent::getList();

        $where = "company_id=" . $this->session->data['company_id'];

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
        $home_type = '';
        $normal_type = '';
        $warranty_type = '';
        $no_warranty_type = '';
        $repeat_warranty_type = '';  
        $this_job_order_types = '';
        $this_type = '';
        $from_month = '';
        $to_month = '';
        $this_date = '';

        $filter = [
         'company_id' => $this->session->data['company_id'],
         'company_branch_id' => $this->session->data['company_branch_id'],
         'fiscal_year_id' => $this->session->data['fiscal_year_id'],
         'date_from' => MySqlDate($post['date_from']),
         'date_to' => MySqlDate($post['date_to']),
         'job_order_type' => $post['job_order_type'],
         'status' => $post['status'],
         'pending_duration' => $post['pending_duration'],
         'repair_status'    => $post['repair_status'],
        ];

        $this->model['job_order_report'] = $this->load->model('report/job_order_report');
        $rows = $this->model['job_order_report']->getJobOrderReport($filter,array('jo.`document_identity`'));
        
        if($filter['status']!='' && $filter['status'] == 0)
        {
         $pending_rows = $this->model['job_order_report']->getPendingJobOrder($filter,array('jo.`document_identity`'));

        }
        $company_name = 'Name :'. ' ' . $session['company_name'];

        $from_month = date_create(MySqlDate($post['date_from']));
        $from_month = date_format($from_month,'d-m-Y');
        $to_month = date_create(MySqlDate($post['date_to']));
        $to_month = date_format($to_month,'d-m-Y');


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;


               if($post['job_order_type'] == 'home')
               {
                   $home_type = 'HOME';
                   $this_job_order_types = $home_type;
               }
               if($post['job_order_type'] == 'warranty')
               {
                   $warranty_type = 'WARRANTY';  
                   $this_job_order_types = $warranty_type;
               }
               if($post['job_order_type'] == 'no_warranty')
               {
                   $no_warranty_type ='NO WARRANTY';
                   $this_job_order_types =  $no_warranty_type;
               }
               if($post['job_order_type'] == 'normal')
               {
                   $normal_type = 'NORMAL';  
                   $this_job_order_types =  $normal_type;   
               }
               if($post['job_order_type'] == 'repeat')
               {
                   $repeat_warranty_type = 'REPEAT';  
                   $this_job_order_types = $repeat_warranty_type;
               }  
                 

        $this_date = 'From Date: ' . ' ' . $from_month . ' - ' . 'To Date: ' . ' ' . $to_month;
        $this_type = 'Job Order Type:' . ' ' . $this_job_order_types;

         $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':L'.$rowCount);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,'Job Order Report')->getStyle('I'.$rowCount)->getFont()->setBold( false )->setSize(18);

        $rowCount++;

        $objPHPExcel->getActiveSheet()->mergeCells('H'.$rowCount.':O'.$rowCount); 
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $this_date)->getStyle('H'.$rowCount)->getFont()->setBold( false )->setSize(18);

       
       if($post['job_order_type'] !='')
       {
            $rowCount++;

           $objPHPExcel->getActiveSheet()->mergeCells('I'.$rowCount.':N'.$rowCount); 
           $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $this_type)->getStyle('I'.$rowCount)->getFont()->setBold( false )->setSize(18);
       }

        $rowCount++;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('A'.$rowCount.':C'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Service Center Name')->getStyle('A'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Doc Date')->getStyle('D'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':G'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Job Number')->getStyle('F'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('H'.$rowCount.':I'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Job Order Type')->getStyle('H'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':K'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Customer Name')->getStyle('J'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('L'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('L'.$rowCount.':N'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'Address')->getStyle('L'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':P'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, 'Contact No')->getStyle('O'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':R'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, 'Repair Status')->getStyle('Q'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('S'.$rowCount.':V'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, 'Product Name')->getStyle('S'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, 'Model')->getStyle('W'.$rowCount)->getFont()->setBold( true );

         $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, 'Serial No')->getStyle('X'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('Y'.$rowCount.':Z'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, 'Warranty Status')->getStyle('Y'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AA'.$rowCount.':AB'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, 'Warranty Type')->getStyle('AA'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AC'.$rowCount.':AD'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, 'Purchase Date')->getStyle('AC'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AE'.$rowCount.':AF'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, 'Receive Date')->getStyle('AE'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AG'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AG'.$rowCount.':AH'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, 'Complete Date')->getStyle('AG'.$rowCount)->getFont()->setBold( true );



        $objPHPExcel->getActiveSheet()->getStyle('AI'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AI'.$rowCount.':AJ'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, 'Delivery Date')->getStyle('AI'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AK'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AK'.$rowCount.':AL'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, 'Fault Description')->getStyle('AK'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AM'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AM'.$rowCount.':AN'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, 'Symptom')->getStyle('AM'.$rowCount)->getFont()->setBold( true );

        $objPHPExcel->getActiveSheet()->getStyle('AO'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AO'.$rowCount.':AP'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AO'.$rowCount, 'Repair Remarks')->getStyle('AO'.$rowCount)->getFont()->setBold( true );


        $objPHPExcel->getActiveSheet()->getStyle('AQ'.$rowCount)->getAlignment()->applyFromArray(
        array('font' => array(
        ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
      );

       $objPHPExcel->getActiveSheet()->mergeCells('AQ'.$rowCount.':AR'.$rowCount);
       $objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$rowCount, 'Status')->getStyle('AQ'.$rowCount)->getFont()->setBold( true );

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
            $sub_filter[] = "jod.`job_order_estimate_id` = '".$job_order_estimate_id."'";
            $data['warranty'] == 'Y' ? $warranty = 'Yes' : $warranty = 'No'; 
            $data['purchased_date'] == '' ? $purchased_date = '' : $purchased_date = stdDate($data['purchased_date']);
            $data['received_date'] == '' ? $received_date = '' : $received_date = stdDate($data['received_date']);
            $data['complete_date'] == '' ? $complete_date = '' : $complete_date = stdDate($data['complete_date']); 
            $data['delivery_date'] == '' ? $delivery_date = '' : $delivery_date = stdDate($data['delivery_date']);
            $data['name'] = $data['product_name'];

            if($data['status'] == 0)
            {
                $data['status'] = 'Pending';   
             }
            else
            {  
                $data['status'] = 'Cleared';
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

            $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, stdDate($data['document_date']));


            $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

            $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':G'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $data['job_order_no']);




          $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

            $objPHPExcel->getActiveSheet()->mergeCells('H'.$rowCount.':I'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $data['job_order_type']);




            $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

           $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':K'.$rowCount);
           $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $data['customer_name']);

           $objPHPExcel->getActiveSheet()->getStyle('L'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
          );

          $objPHPExcel->getActiveSheet()->mergeCells('L'.$rowCount.':N'.$rowCount);
          $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $data['customer_address']);


          $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
         );

         $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
         $objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':P'.$rowCount);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$rowCount, $data['customer_contact'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':R'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $data['repair_status']);

        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('S'.$rowCount.':V'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $data['name']);

        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        $objPHPExcel->getActiveSheet()->setCellValueExplicit('W'.$rowCount, $data['model'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
         $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('X'.$rowCount,  $data['product_serial_no'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->mergeCells('Y'.$rowCount.':Z'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $warranty)->getStyle('Y'.$rowCount);


        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AA'.$rowCount.':AB'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $data['warranty_type']);


        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AC'.$rowCount.':AD'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $purchased_date);


        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AE'.$rowCount.':AF'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, $received_date);


        $objPHPExcel->getActiveSheet()->getStyle('AG'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AG'.$rowCount.':AH'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, $complete_date);


        $objPHPExcel->getActiveSheet()->getStyle('AI'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AI'.$rowCount.':AJ'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, $delivery_date);


        $objPHPExcel->getActiveSheet()->getStyle('AK'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AK'.$rowCount.':AL'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, $data['fault_description']);


        $objPHPExcel->getActiveSheet()->getStyle('AM'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AM'.$rowCount.':AN'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, $data['symptom']);

        $objPHPExcel->getActiveSheet()->getStyle('AO'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AO'.$rowCount.':AP'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AO'.$rowCount, $data['repair_remarks']);


        $objPHPExcel->getActiveSheet()->getStyle('AQ'.$rowCount1)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
          );

        $objPHPExcel->getActiveSheet()->mergeCells('AQ'.$rowCount.':AR'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$rowCount, $data['status']);

         $rowCount++;

        }


        if($filter['status']!='' && $filter['status'] == 0)
        {
          foreach($pending_rows as $data)
          {

            $job_order_estimate_id = $data['job_order_estimate_id'];
            $sub_filter[] = "jod.`job_order_estimate_id` = '".$job_order_estimate_id."'";
            $data['warranty'] == 'Y' ? $warranty = 'Yes' : $warranty = 'No'; 
            $data['purchased_date'] == '' ? $purchased_date = '' : $purchased_date = stdDate($data['purchased_date']);
            $data['received_date'] == '' ? $received_date = '' : $received_date = stdDate($data['received_date']);
            $data['complete_date'] == '' ? $complete_date = '' : $complete_date = stdDate($data['complete_date']); 
            $data['delivery_date'] == '' ? $delivery_date = '' : $delivery_date = stdDate($data['delivery_date']);
            $data['name'] = $data['product_name'];

            if($data['status'] == 0)
            {
                $data['status'] = 'Pending';   
             }
            else
            {  
                $data['status'] = 'Cleared';
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

            $objPHPExcel->getActiveSheet()->mergeCells('D'.$rowCount.':E'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, stdDate($data['document_date']));


            $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

            $objPHPExcel->getActiveSheet()->mergeCells('F'.$rowCount.':G'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $data['job_order_no']);




          $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

            $objPHPExcel->getActiveSheet()->mergeCells('H'.$rowCount.':I'.$rowCount);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $data['job_order_type']);




            $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
           );

           $objPHPExcel->getActiveSheet()->mergeCells('J'.$rowCount.':K'.$rowCount);
           $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $data['customer_name']);

           $objPHPExcel->getActiveSheet()->getStyle('L'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
          );

          $objPHPExcel->getActiveSheet()->mergeCells('L'.$rowCount.':N'.$rowCount);
          $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $data['customer_address']);


          $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
         );

         $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
         $objPHPExcel->getActiveSheet()->mergeCells('O'.$rowCount.':P'.$rowCount);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$rowCount, $data['customer_contact'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('Q'.$rowCount.':R'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $data['repair_status']);

        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('S'.$rowCount.':V'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $data['name']);

        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        $objPHPExcel->getActiveSheet()->setCellValueExplicit('W'.$rowCount, $data['model'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
         $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCount)
           ->getNumberFormat() 
           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
         $objPHPExcel->getActiveSheet()->setCellValueExplicit('X'.$rowCount,  $data['product_serial_no'], PHPExcel_Cell_DataType::TYPE_STRING);


        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->mergeCells('Y'.$rowCount.':Z'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $warranty)->getStyle('Y'.$rowCount);


        $objPHPExcel->getActiveSheet()->getStyle('AA'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AA'.$rowCount.':AB'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $data['warranty_type']);


        $objPHPExcel->getActiveSheet()->getStyle('AC'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AC'.$rowCount.':AD'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $purchased_date);


        $objPHPExcel->getActiveSheet()->getStyle('AE'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AE'.$rowCount.':AF'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, $received_date);


        $objPHPExcel->getActiveSheet()->getStyle('AG'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AG'.$rowCount.':AH'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, $complete_date);


        $objPHPExcel->getActiveSheet()->getStyle('AI'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AI'.$rowCount.':AJ'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, $delivery_date);


        $objPHPExcel->getActiveSheet()->getStyle('AK'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );


        $objPHPExcel->getActiveSheet()->mergeCells('AK'.$rowCount.':AL'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, $data['fault_description']);


        $objPHPExcel->getActiveSheet()->getStyle('AM'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AM'.$rowCount.':AN'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, $data['symptom']);

        $objPHPExcel->getActiveSheet()->getStyle('AO'.$rowCount)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $objPHPExcel->getActiveSheet()->mergeCells('AO'.$rowCount.':AP'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AO'.$rowCount, $data['repair_remarks']);


        $objPHPExcel->getActiveSheet()->getStyle('AQ'.$rowCount1)->getAlignment()->applyFromArray(
            array('font' => array(
            ),'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
          );

        $objPHPExcel->getActiveSheet()->mergeCells('AQ'.$rowCount.':AR'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$rowCount, $data['status']);

         $rowCount++;

        }
    }


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="job_order_report.xlsx"');
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