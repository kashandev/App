<?php

class ModelReportJobOrderReport extends HModel {


     // get job order report function 
     public function getJobOrderReport($filter=array(), $sort_order=array()) {

        $arrWhere = array();
        $status = '';

         if(isset($filter['company_id']) && $filter['company_id'])
         {
              $arrWhere[] = "jo.`company_id` = '".$filter['company_id']."'";
         }
         if(isset($filter['company_branch_id']) && $filter['company_branch_id']) 
         {
              $arrWhere[] = "jo.`company_branch_id` = '".$filter['company_branch_id']."'";
         }  
         if(isset($filter['date_from']) && $filter['date_from'] != '') 
         {
              $arrWhere[] = "jo.`document_date` >= '".$filter['date_from']."'";
         }
         if(isset($filter['date_to']) && $filter['date_to'] != '') 
         {
              $arrWhere[] = "jo.`document_date` <= '".$filter['date_to']."'";
         }
         if(isset($filter['job_order_type']) && $filter['job_order_type'] != '') 
         {
              $arrWhere[] = "jo.`job_order_type` = '".$filter['job_order_type']."'";
         }
         if(isset($filter['status']) && $filter['status'] != '')
         {
           
          if($filter['status'] == 0)
          {
              $arrWhere[] = "joe.`job_order_id` IS NULL";
          }
         else
         {
              $arrWhere[] = "joe.`is_post` = 1";
         }
        }
         if(isset($filter['pending_duration']) && $filter['pending_duration'] != '' && $filter['status'] == '') 
         {
              $arrWhere[] = "joe.`job_order_id` IS NULL";
            
              if($filter['pending_duration'] == "24 Hour") 
              {
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) >=1";
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) <=1";
              }

              if($filter['pending_duration'] == "2 Day") 
              {
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) >=2";
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) <=3";
              }

              if($filter['pending_duration'] == "3 Day") 
              {
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) >=3";
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) <=4";
              }

              if($filter['pending_duration'] == "More Than 3 Days") 
              {
                  $arrWhere[] = "DATEDIFF(NOW(), `jo`.`created_at` ) >=4";
              }
         }

         if(isset($filter['repair_status']) && $filter['repair_status'] != '') 
         {
                $arrWhere[] = "jo.`repair_status` = '".$filter['repair_status']."'";
         }
         $sql=" SELECT `jo`.`job_order_id` AS `job_order_id`,
        `jo`.`document_date` AS `document_date`,
        `jo`.`customer_name` AS `customer_name`,
        `jo`.`customer_contact` AS `customer_contact`,
        `jo`.`customer_address` AS `customer_address`,
        `jo`.`customer_email` AS `customer_email`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`purchase_date` AS `purchased_date`,
        `jo`.`repair_receive_date` AS `received_date`,
        `jo`.`repair_complete_date` AS `complete_date`,
        `jo`.`delivery_date` AS `delivery_date`,
        `jo`.`job_order_type` AS `job_order_type`,
        `jo`.`repair_status` AS `repair_status`,
        `jo`.`product_id` AS `product_id`,
        `jo`.`product_model` AS `model`,
        `jo`.`warranty_status` AS `warranty`,
        `jo`.`warranty_type` AS `warranty_type`,
        `jo`.`warranty_card_no` AS `warranty_card_no`,
        `jo`.`product_serial_no` AS `product_serial_no`,
        `jo`.`fault_description` AS `fault_description`,
        `jo`.`repair_remarks` AS `repair_remarks`,
        `jo`.`symptom` AS `symptom`,
        `p`.`name` AS `product_name`,
         IF((`joe`.`is_post`) > 0, 1,0) AS `status`
         FROM ((`ins_job_order` `jo`
         LEFT JOIN `in0_product` `p`
         ON (`p`.`product_id` = `jo`.`product_id`)) 
         LEFT JOIN `ins_job_order_estimate` `joe`
         ON (`joe`.`job_order_id` = `jo`.`job_order_id`))";

         $sql.=" WHERE " . implode(" AND ", $arrWhere);
         $sql.= " GROUP BY `jo`.`document_identity`";
         if($sort_order)
         {
             $sql.=" ORDER BY " . implode(',',$sort_order) ;
         }
        $query = $this->conn->query($sql);
        return $query->rows; 
       }

      // get pending job order report function 
      public function getPendingJobOrder($filter=array(), $sort_order=array()) {

        $arrWhere = array();
        $status = '';

         if(isset($filter['company_id']) && $filter['company_id'])
         {
             $arrWhere[] = "jo.`company_id` = '".$filter['company_id']."'";
         }
         if(isset($filter['company_branch_id']) && $filter['company_branch_id']) 
         {
             $arrWhere[] = "jo.`company_branch_id` = '".$filter['company_branch_id']."'";
         }  
         if(isset($filter['date_from']) && $filter['date_from'] != '')
         {
             $arrWhere[] = "jo.`document_date` >= '".$filter['date_from']."'";
         }
         if(isset($filter['date_to']) && $filter['date_to'] != '') 
         {
             $arrWhere[] = "jo.`document_date` <= '".$filter['date_to']."'";
         }
         if(isset($filter['job_order_type']) && $filter['job_order_type'] != '')
         {
             $arrWhere[] = "jo.`job_order_type` = '".$filter['job_order_type']."'";
         }
         if(isset($filter['status']) && $filter['status'] != '')
         {
           
          if($filter['status'] == 0)
          {
             $arrWhere[] = "`joe`.`is_post` = 0";
          }
        }
         $sql=" SELECT `jo`.`job_order_id` AS `job_order_id`,
        `jo`.`document_date` AS `document_date`,
        `jo`.`customer_name` AS `customer_name`,
        `jo`.`customer_contact` AS `customer_contact`,
        `jo`.`customer_address` AS `customer_address`,
        `jo`.`customer_email` AS `customer_email`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`purchase_date` AS `purchased_date`,
        `jo`.`repair_receive_date` AS `received_date`,
        `jo`.`repair_complete_date` AS `complete_date`,
        `jo`.`delivery_date` AS `delivery_date`,
        `jo`.`job_order_type` AS `job_order_type`,
        `jo`.`repair_status` AS `repair_status`,
        `jo`.`product_id` AS `product_id`,
        `jo`.`product_model` AS `model`,
        `jo`.`warranty_status` AS `warranty`,
        `jo`.`warranty_type` AS `warranty_type`,
        `jo`.`warranty_card_no` AS `warranty_card_no`,
        `jo`.`product_serial_no` AS `product_serial_no`,
        `jo`.`fault_description` AS `fault_description`,
        `jo`.`repair_remarks` AS `repair_remarks`,
        `jo`.`symptom` AS `symptom`,
        `p`.`name` AS `product_name`,
         IF((`joe`.`is_post`) > 0, 1,0) AS `status`
         FROM ((`ins_job_order` `jo`
         LEFT JOIN `in0_product` `p`
         ON (`p`.`product_id` = `jo`.`product_id`)) 
         LEFT JOIN `ins_job_order_estimate` `joe`
         ON (`joe`.`job_order_id` = `jo`.`job_order_id`))";

         $sql.=" WHERE " . implode(" AND ", $arrWhere);
         $sql.= " GROUP BY `jo`.`document_identity`";
         if($sort_order) {
             $sql.=" ORDER BY " . implode(',',$sort_order) ;
         }
         $query = $this->conn->query($sql);
         return $query->rows;
    }
}

?>