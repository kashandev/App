<?php

class ModelReportAging extends HModel {
    public function getReport($filter) {
        $sql = " SELECT people_type_id, people_type, people_id, people_name" . "\n";
        $sql .= " , CASE WHEN date_diff <= 30 THEN document_identity ELSE '' END AS day_30_document_identity" . "\n";
        $sql .= " , CASE WHEN date_diff > 30 AND date_diff <= 45 THEN document_identity ELSE '' END AS day_45_document_identity" . "\n";
        $sql .= " , CASE WHEN date_diff > 45 AND date_diff <= 60 THEN document_identity ELSE '' END AS day_60_document_identity" . "\n";
        $sql .= " , CASE WHEN date_diff > 60 AND date_diff <= 90 THEN document_identity ELSE '' END AS day_90_document_identity" . "\n";
        $sql .= " , CASE WHEN date_diff > 90 THEN document_identity ELSE '' END AS day_more_document_identity" . "\n";
        $sql .= " , CASE WHEN date_diff <= 30 THEN base_amount ELSE '' END AS day_30_document_amount" . "\n";
        $sql .= " , CASE WHEN date_diff > 30 AND date_diff <= 45 THEN base_amount ELSE '' END AS day_45_document_amount" . "\n";
        $sql .= " , CASE WHEN date_diff > 45 AND date_diff <= 60 THEN base_amount ELSE '' END AS day_60_document_amount" . "\n";
        $sql .= " , CASE WHEN date_diff > 60 AND date_diff <= 90 THEN base_amount ELSE '' END AS day_90_document_amount" . "\n";
        $sql .= " , CASE WHEN date_diff > 90 THEN base_amount ELSE '' END AS day_more_document_amount" . "\n";
        $sql .= " , CASE WHEN date_diff <= 30 THEN outstanding ELSE '' END AS day_30_document_balance" . "\n";
        $sql .= " , CASE WHEN date_diff > 30 AND date_diff <= 45 THEN outstanding ELSE '' END AS day_45_document_balance" . "\n";
        $sql .= " , CASE WHEN date_diff > 45 AND date_diff <= 60 THEN outstanding ELSE '' END AS day_60_document_balance" . "\n";
        $sql .= " , CASE WHEN date_diff > 60 AND date_diff <= 90 THEN outstanding ELSE '' END AS day_90_document_balance" . "\n";
        $sql .= " , CASE WHEN date_diff > 90 THEN outstanding ELSE '' END AS day_more_document_balance" . "\n";
        $sql .= " FROM (" . "\n";
        $sql .= " SELECT l.`people_type_id`, p.`people_type`, l.`people_id`, p.`people_name`, d.`document_type_id`, d.`document_date`, DATEDIFF('2016-02-27', d.document_date) AS date_diff, d.`document_identity`, d.`base_amount`, SUM(l.debit-l.credit) AS outstanding" . "\n";
        $sql .= " FROM `vw_ledger` l" . "\n";
        $sql .= " INNER JOIN `vw_document` d ON d.company_id = l.company_id AND d.company_branch_id = l.company_branch_id AND d.fiscal_year_id = l.fiscal_year_id AND d.`document_type_id` = l.`ref_document_type_id` AND d.`document_identity` = l.`ref_document_identity`" . "\n";
        $sql .= " AND d.document_type_id NOT IN (16,17)" . "\n";
        $sql .= " INNER JOIN `vw_people` p ON p.`people_type_id` = l.`people_type_id` AND p.`people_id` = l.`people_id` AND (l.coa_id = p.outstanding_account_id OR l.coa_id = p.advance_account_id)" . "\n";
        $sql .= " WHERE TRUE" . "\n";
        $sql .= " AND l.company_id = '".$filter['company_id']."'" . "\n";
        $sql .= " AND l.company_branch_id = '".$filter['company_branch_id']."'" . "\n";
        $sql .= " AND l.fiscal_year_id = '".$filter['fiscal_year_id']."'" . "\n";
        if(isset($filter['people_type_id']))
            $sql .= " AND l.people_type_id = '".$filter['people_type_id']."'" . "\n";
        if(isset($filter['people_id']))
            $sql .= " AND l.people_id = '".$filter['people_id']."'" . "\n";
        $sql .= " GROUP BY l.`people_type_id`, p.`people_type`, l.`people_id`, p.`people_name`, d.`document_type_id`, d.`document_date`, d.`document_identity`, d.`base_amount`" . "\n";
        $sql .= " HAVING outstanding != 0" . "\n";
        $sql .= " ) AS p" . "\n";
        $sql .= " GROUP BY people_type_id, people_type, people_id, people_name" . "\n";

        $query = $this->conn->query($sql);
        d(array($filter, $sql, $query->rows));
        return $query->rows;
    }
}

?>