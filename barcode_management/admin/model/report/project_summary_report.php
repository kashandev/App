<?php

class ModelReportProjectSummaryReport extends HModel {

    public function getData($filter){
        $sql = "";
        $sql .= "SELECT  l.level3_name AS display_name, l.project_name, l.sub_project_name ";
        $sql .= " ,l.`project_id`,l.`sub_project_id`,l.`gl_type`, SUM(credit-debit) AS balance ";
        $sql .= ",CASE WHEN l.`gl_type` = 'Expense' THEN 'EXPENSE' ELSE 'INCOME' END AS gl";
        $sql .= " FROM vw_core_ledger l ";
        $sql .= " INNER JOIN vw_gl0_coa_all coa ON coa.coa_level3_id = l.coa_id AND coa.company_id = l.company_id  ";
        $sql .= " WHERE (l.`gl_type` = 'Expense' OR l.`gl_type` = 'Revenue') ";

        if($filter['project_id'] == ''){
            $sql .= " AND (l.`project_id` != '' AND l.`project_id` != '0')";
        }
        else
        {
            $sql .=  " AND l.project_id = '".$filter['project_id']."'";
        }
        if($filter['sub_project_id'] == '')
        {
            $sql .= " AND l.`sub_project_id` != ''";
        }
        else
        {
            $sql .= " AND l.sub_project_id = '".$filter['sub_project_id']."'";
        }

        $sql .= " GROUP BY display_name;";

        $query = $this->conn->query($sql);
        // d($query,true);
        $rows = $query->rows;
        return $rows;
    }

    public function getTopExpenses(){
        $sql = " SELECT  l.level3_name AS display_name, ";
        $sql .= " SUM(debit-credit) AS balance ";
        $sql .= " FROM vw_core_ledger l ";
        $sql .= " INNER JOIN vw_gl0_coa_all coa ON coa.coa_level3_id = l.coa_id AND coa.company_id = l.company_id  ";
        $sql .= " WHERE l.`gl_type` = 'Expense' ";
        $sql .= " AND (l.`project_id` != '' AND l.`project_id` != '0')";
        $sql .= "     GROUP BY display_name ORDER BY balance DESC LIMIT 5;";

        $query = $this->conn->query($sql);
        // d($query,true);
        $rows = $query->rows;
        return $rows;

    }

}

?>