<?php

class ModelReportRepairDataReport extends HModel {



public function getRepairDataReport($filter=array(), $sort_order=array()) {
       
         $sql = "SELECT `joe`.`company_id` AS `company_id`,`joe`.`job_order_estimate_id` AS `job_order_estimate_id`,
        `joe`.`company_branch_id` AS `company_branch_id`,`joe`.`fiscal_year_id` AS `fiscal_year_id`,
        `joe`.`document_prefix` AS `document_prefix`,`joe`.`document_no` AS `document_no`,
        `joe`.`document_type_id` AS `document_type_id`, `joe`.`document_identity` AS `document_identity`,
        `joe`.`job_order_id` AS `job_order_id`,`joe`.`document_date`     AS `document_date`,
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
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`product_id` AS `product_id`,
        `jo`.`product_model` AS `model`,
        `jo`.`warranty_status` AS `warranty`,
        `jo`.`warranty_type` AS `warranty_type`,
        `jo`.`warranty_card_no` AS `warranty_card_no`,
        `jo`.`product_serial_no` AS `product_serial_no`,
        `jo`.`fault_description` AS `fault_description`,
        `jo`.`repair_remarks` AS `repair_remarks`,
        `jo`.`symptom` AS `symptom`,
        `joe`.`created_at` AS `created_at`,
        `joe`.`created_by_id` AS `created_by_id`,
        `joed`.`part_name` AS`part_name`,
        `joed`. `quantity` AS `qty`,
        `joed`. `amount` AS `amount`,
        `p`.`name` AS `service_name`,
        IFNULL(ABS(DATEDIFF(`jo`.`repair_receive_date`, `jo`.`repair_complete_date` )),0) AS `tat`,
       `joed`.`product_type` AS `product_type`
        FROM (((`ins_job_order_estimate` `joe`
        INNER JOIN `ins_job_order` `jo`
        ON (`joe`.`job_order_id` = `jo`.`job_order_id`))
        LEFT JOIN `in0_product` `p`
        ON (`p`.`product_id` = `jo`.`product_id`)) 
        LEFT JOIN `ins_job_order_estimate_detail` `joed`
        ON (`joed`.`job_order_estimate_id` = `joe`.`job_order_estimate_id`))
        ";
       
        if($filter) {
            if(is_array($filter)) {
                if($filter)
                    $sql .= " WHERE " . implode(" AND ", $filter);

            } else {
                $sql .= " WHERE " . $filter;
            }
        }

        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

         $query = $this->conn->query($sql);
         return $query->rows;
       
    }
}

?>