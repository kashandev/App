<?php

class ModelInventorySaleTaxInvoiceDetail extends HModel {

    protected function getTable() {
        return 'ins_sale_tax_invoice_detail';
    }

    protected function getView() {
        return 'vw_ins_sale_tax_invoice_detail';
    }

    public function get_sale_tax_invoice_details($filter=array(), $sort_order=array()){
        $sql = "SELECT *";
        $sql .= " FROM " . DB_PREFIX . $this->getTable();
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "`$column`='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
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


     public function get_sale_tax_invoice_report($filter=array(), $sort_order=array()){
        
         $arrWhere = array();
         $sql="SELECT `sid`.*,`si`.`customer_name` as `customer_name`,`si`.`document_identity` AS `document_identity`,
         `si`.`document_date` AS `document_date`,`jo`.`document_identity` AS `job_order_no`,`p`.`name`AS `product_name`,
         `u`.`name` AS `unit`
         FROM ((((`ins_sale_tax_invoice_detail` `sid`
         LEFT JOIN `ins_sale_tax_invoice` `si`
         ON (`si`.`sale_tax_invoice_id` = `sid`.`sale_tax_invoice_id`)
         LEFT JOIN `in0_product` `p`
         ON (`p`.`company_id` = `sid`.`company_id`
         AND `p`.`product_id` = `sid`.`product_id`)
         LEFT JOIN `in0_unit` `u`
         ON (`u`.`company_id` = `sid`.`company_id`
         AND `u`.`unit_id` = `sid`.`unit_id`)
         LEFT JOIN `ins_job_order` `jo`
         ON `jo`.`job_order_id` = `si`.`job_order_id`))))
         ";
         if(isset($filter['company_id']) && $filter['company_id'])
         {
            $arrWhere[] = "si.`company_id` = '".$filter['company_id']."'";
         }

         if(isset($filter['company_branch_id']) && $filter['company_branch_id']) 
         {
            $arrWhere[] = "si.`company_branch_id` = '".$filter['company_branch_id']."'";
         }  

         if(isset($filter['date_from']) && $filter['date_from'] != '') {
            $arrWhere[] = "si.`document_date` >= '".$filter['date_from']."'";
         }

         if(isset($filter['date_to']) && $filter['date_to'] != '') {
            $arrWhere[] = "si.`document_date` <= '".$filter['date_to']."'";
         }

         if($filter['product_id'] && $filter['product_id']){
            $arrWhere[] = "sid.`product_id` = '".$filter['product_id']."'";
         }

         if($filter['document_type'] && $filter['document_type']){
            $arrWhere[] = "si.`document_type` = '".$filter['document_type']."'";
        }

        $sql .= " WHERE " . implode(" AND ", $arrWhere);
        
        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        $query = $this->conn->query($sql);
        return $query->rows;
    }

}

?>