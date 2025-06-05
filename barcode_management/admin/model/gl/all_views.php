DROP VIEW IF EXISTS `vw_bgt_budget_transaction_detail`
CREATE VIEW `vw_bgt_budget_transaction_detail` AS
SELECT DISTINCT
`btd`.`budget_transaction_detail_id` AS `budget_transaction_detail_id`,
`btd`.`budget_transaction_id`        AS `budget_transaction_id`,
`btd`.`company_id`                   AS `company_id`,
`btd`.`company_branch_id`            AS `company_branch_id`,
`btd`.`fiscal_year_id`               AS `fiscal_year_id`,
`btd`.`budget_title`                 AS `budget_title`,
`btd`.`coa_id`                       AS `coa_id`,
`btd`.`project_id`                   AS `project_id`,
`btd`.`last_year_amount`             AS `last_year_amount`,
`btd`.`current_year_amount`          AS `current_year_amount`,
`btd`.`utilize_amount`               AS `utilize_amount`,
`btd`.`created_by_id`                AS `created_by_id`,
`btd`.`created_at`                   AS `created_at`,
`bt`.`budget_name`                   AS `budget_name`,
`bt`.`from_date`                     AS `from_date`,
`bt`.`to_date`                       AS `to_date`,
`level3`.`name`                      AS `coa_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`bgt_budget_transaction_detail` `btd`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`bgt_budget_transaction` `bt`
ON ((`bt`.`budget_transaction_id` = `btd`.`budget_transaction_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `level3`
ON ((`level3`.`coa_level3_id` = `btd`.`coa_id`)));

DROP VIEW IF EXISTS `vw_core_building`
CREATE VIEW `vw_core_building` AS
SELECT
`cb`.`building_id`       AS `building_id`,
`cb`.`company_id`        AS `company_id`,
`cb`.`company_branch_id` AS `company_branch_id`,
`cb`.`fiscal_year_id`    AS `fiscal_year_id`,
`cb`.`building_code`     AS `building_code`,
`cb`.`coa_id`            AS `coa_id`,
`cb`.`created_by_id`     AS `created_by_id`,
`cb`.`created_at`        AS `created_at`,
`level3`.`name`          AS `coa_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`core_building` `cb`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `level3`
ON ((`level3`.`coa_level3_id` = `cb`.`coa_id`)));

DROP VIEW IF EXISTS `vw_core_customer`
CREATE VIEW `vw_core_customer` AS
SELECT
`c`.`company_id`             AS `company_id`,
`c`.`company_branch_id`      AS `company_branch_id`,
`c`.`partner_category_id`    AS `partner_category_id`,
`c`.`customer_id`            AS `customer_id`,
`c`.`name`                   AS `name`,
`c`.`address`                AS `address`,
`c`.`phone`                  AS `phone`,
`c`.`mobile`                 AS `mobile`,
`c`.`email`                  AS `email`,
`c`.`gst_no`                 AS `gst_no`,
`c`.`ntn_no`                 AS `ntn_no`,
`c`.`day_limit`              AS `day_limit`,
`c`.`amount_limit`           AS `amount_limit`,
`c`.`document_currency_id`   AS `document_currency_id`,
`c`.`cash_account_id`        AS `cash_account_id`,
`c`.`outstanding_account_id` AS `outstanding_account_id`,
`c`.`advance_account_id`     AS `advance_account_id`,
`c`.`created_at`             AS `created_at`,
`c`.`created_by_id`          AS `created_by_id`,
`cc`.`name`                  AS `partner_category`,
`ccc`.`name`                 AS `currency`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`core_customer` `c`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner_category` `cc`
ON (((`c`.`partner_category_id` = `cc`.`partner_category_id`)
AND (`c`.`company_id` = `cc`.`company_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_currency` `ccc`
ON (((`ccc`.`currency_id` = `c`.`document_currency_id`)
AND (`ccc`.`company_id` = `c`.`company_id`))));

DROP VIEW IF EXISTS `vw_core_document`
CREATE VIEW `vw_core_document` AS
SELECT
`dt`.`table_name`          AS `table_name`,
`dt`.`primary_key`         AS `primary_key`,
`p`.`partner_type`         AS `partner_type`,
`p`.`name`                 AS `partner_name`,
IF(ISNULL(`d`.`route`),`dt`.`route`,`d`.`route`) AS `route`,
IF(ISNULL(`d`.`primary_key_field`),`dt`.`primary_key`,`d`.`primary_key_field`) AS `primary_key_field`,
IF(ISNULL(`d`.`primary_key_value`),`d`.`document_id`,`d`.`primary_key_value`) AS `primary_key_value`,
`d`.`document_type_id`     AS `document_type_id`,
`dt`.`document_name`       AS `document_name`,
`d`.`document_id`          AS `document_id`,
`d`.`document_identity`    AS `document_identity`,
`d`.`document_date`        AS `document_date`,
`d`.`document_currency_id` AS `document_currency_id`,
`d`.`document_amount`      AS `document_amount`,
`d`.`conversion_rate`      AS `conversion_rate`,
`d`.`base_currency_id`     AS `base_currency_id`,
`d`.`base_amount`          AS `base_amount`,
`d`.`is_post`              AS `is_post`,
`d`.`post_date`            AS `post_date`,
`d`.`post_by_id`           AS `post_by_id`,
`d`.`created_at`           AS `created_at`,
`d`.`created_by_id`        AS `created_by_id`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`core_document` `d`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`const_document_type` `dt`
ON ((`dt`.`document_type_id` = `d`.`document_type_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `d`.`partner_type_id`)
AND (`p`.`partner_id` = `d`.`partner_id`))));

DROP VIEW IF EXISTS `vw_core_ledger`
CREATE VIEW `vw_core_ledger` AS
SELECT
`l`.`company_id`            AS `company_id`,
`l`.`company_branch_id`     AS `company_branch_id`,
`l`.`fiscal_year_id`        AS `fiscal_year_id`,
`l`.`ledger_id`             AS `ledger_id`,
`l`.`document_type_id`      AS `document_type_id`,
`l`.`document_id`           AS `document_id`,
`l`.`document_identity`     AS `document_identity`,
`l`.`document_date`         AS `document_date`,
`l`.`sort_order`            AS `sort_order`,
`l`.`partner_type_id`       AS `partner_type_id`,
`p`.`partner_type`          AS `partner_type`,
`l`.`partner_id`            AS `partner_id`,
`p`.`name`                  AS `partner_name`,
`l`.`project_id`            AS `project_id`,
`sp`.`project_name`         AS `project_name`,
`l`.`sub_project_id`        AS `sub_project_id`,
`sp`.`name`                 AS `sub_project_name`,
`l`.`ref_document_type_id`  AS `ref_document_type_id`,
`l`.`ref_document_identity` AS `ref_document_identity`,
`l`.`remarks`               AS `remarks`,
`l`.`coa_id`                AS `coa_id`,
`c`.`level3_code`           AS `level3_code`,
`c`.`name`                  AS `level3_name`,
`c`.`level3_display_name`   AS `account`,
`c`.`coa_level2_id`         AS `coa_level2_id`,
`c`.`level2_code`           AS `level2_code`,
`c`.`level2_name`           AS `level2_name`,
`c`.`level2_display_name`   AS `level2_display_name`,
`c`.`coa_level1_id`         AS `coa_level1_id`,
`c`.`level1_code`           AS `level1_code`,
`c`.`level1_name`           AS `level1_name`,
`c`.`level1_display_name`   AS `level1_display_name`,
`c`.`gl_type`               AS `gl_type`,
`l`.`document_currency_id`  AS `document_currency_id`,
`l`.`document_debit`        AS `document_debit`,
`l`.`document_credit`       AS `document_credit`,
`l`.`base_currency_id`      AS `base_currency_id`,
`l`.`conversion_rate`       AS `conversion_rate`,
`l`.`debit`                 AS `debit`,
`l`.`credit`                AS `credit`,
`l`.`its_no`                AS `its_no`,
`l`.`challan_no`            AS `challan_no`,
`l`.`cheque_date`           AS `cheque_date`,
`l`.`cheque_no`             AS `cheque_no`,
`l`.`created_at`            AS `created_at`
FROM (((`fayzehus_bharmals_bsuite_fh_1819`.`core_ledger` `l`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_partner` `p`
ON (((`p`.`company_id` = `l`.`company_id`)
AND (`p`.`partner_type_id` = `l`.`partner_type_id`)
AND (`p`.`partner_id` = `l`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `l`.`project_id`)
AND (`sp`.`sub_project_id` = `l`.`sub_project_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `c`
ON (((`c`.`company_id` = `l`.`company_id`)
AND (`c`.`coa_level3_id` = `l`.`coa_id`))));

DROP VIEW IF EXISTS `vw_core_outstanding_document`
CREATE VIEW `vw_core_outstanding_document` AS
SELECT
`l`.`company_id`            AS `company_id`,
`l`.`company_branch_id`     AS `company_branch_id`,
`l`.`fiscal_year_id`        AS `fiscal_year_id`,
`d`.`is_post`               AS `is_post`,
`l`.`partner_type_id`       AS `partner_type_id`,
`l`.`partner_id`            AS `partner_id`,
`l`.`ref_document_type_id`  AS `ref_document_type_id`,
`l`.`ref_document_identity` AS `ref_document_identity`,
`d`.`document_id`           AS `document_id`,
`d`.`document_date`         AS `document_date`,
`d`.`base_amount`           AS `document_amount`,
`d`.`route`                 AS `route`,
`d`.`primary_key_field`     AS `primary_key_field`,
`d`.`primary_key_value`     AS `primary_key_value`,
SUM((CASE WHEN (`l`.`ref_document_type_id` IN (1,24)) THEN (`l`.`credit` - `l`.`debit`) ELSE (`l`.`debit` - `l`.`credit`) END)) AS `outstanding_amount`,
SUM((CASE WHEN (`l`.`ref_document_type_id` IN (2,11,34)) THEN (`l`.`debit` - `l`.`credit`) ELSE 0 END)) AS `debit_amount`,
SUM((CASE WHEN (`l`.`ref_document_type_id` IN (1,24)) THEN (`l`.`credit` - `l`.`debit`) ELSE 0 END)) AS `credit_amount`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`vw_core_ledger` `l`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`l`.`company_id` = `p`.`company_id`)
AND (`l`.`company_branch_id` = `p`.`company_branch_id`)
AND (`l`.`partner_type_id` = `p`.`partner_type_id`)
AND (`l`.`partner_id` = `p`.`partner_id`)
AND (`l`.`coa_id` = `p`.`outstanding_account_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_document` `d`
ON (((`d`.`document_type_id` = `l`.`ref_document_type_id`)
AND (`d`.`document_identity` = `l`.`ref_document_identity`))))
GROUP BY `l`.`company_id`,`l`.`company_branch_id`,`l`.`fiscal_year_id`,`l`.`partner_type_id`,`l`.`partner_id`,`l`.`ref_document_type_id`,`l`.`ref_document_identity`;

DROP VIEW IF EXISTS `vw_core_partner`
CREATE VIEW `vw_core_partner` AS
SELECT
`p`.`company_id`             AS `company_id`,
`p`.`company_branch_id`      AS `company_branch_id`,
`p`.`partner_type_id`        AS `partner_type_id`,
`p`.`partner_type`           AS `partner_type`,
`p`.`partner_id`             AS `partner_id`,
`p`.`partner_category_id`    AS `partner_category_id`,
`p`.`its_no`                 AS `its_no`,
`p`.`name`                   AS `name`,
`p`.`address`                AS `address`,
`p`.`gst_no`                 AS `gst_no`,
`p`.`ntn_no`                 AS `ntn_no`,
`p`.`document_currency_id`   AS `document_currency_id`,
`p`.`day_limit`              AS `day_limit`,
`p`.`amount_limit`           AS `amount_limit`,
`p`.`phone`                  AS `phone`,
`p`.`mobile`                 AS `mobile`,
`p`.`fax`                    AS `fax`,
`p`.`email`                  AS `email`,
`p`.`cash_account_id`        AS `cash_account_id`,
`p`.`outstanding_account_id` AS `outstanding_account_id`,
`p`.`advance_account_id`     AS `advance_account_id`,
`p`.`created_at`             AS `created_at`,
`p`.`created_by_id`          AS `created_by_id`,
`p`.`modified_at`            AS `modified_at`,
`p`.`modified_by_id`         AS `modified_by_id`,
`pc`.`name`                  AS `partner_category`,
`c`.`name`                   AS `document_currency`,
`l3o`.`level3_display_name`  AS `outstanding_account`,
`l3c`.`level3_display_name`  AS `cash_account`,
`l3a`.`level3_display_name`  AS `advance_account`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`partner_category_id` = `p`.`partner_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_currency` `c`
ON (((`c`.`company_id` = `p`.`company_id`)
AND (`c`.`currency_id` = `p`.`document_currency_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3o`
ON (((`l3o`.`company_id` = `p`.`company_id`)
AND (`l3o`.`coa_level3_id` = `p`.`outstanding_account_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3c`
ON (((`l3c`.`company_id` = `p`.`company_id`)
AND (`l3c`.`coa_level3_id` = `p`.`cash_account_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3a`
ON (((`l3a`.`company_id` = `p`.`company_id`)
AND (`l3a`.`coa_level3_id` = `p`.`advance_account_id`))));

DROP VIEW IF EXISTS `vw_core_project`
CREATE VIEW `vw_core_project` AS
SELECT
`cp`.`project_id`        AS `project_id`,
`cp`.`name`              AS `name`,
`cp`.`created_at`        AS `created_at`,
`cp`.`company_id`        AS `company_id`,
`cp`.`company_branch_id` AS `company_branch_id`
FROM `fayzehus_bharmals_bsuite_fh_1819`.`core_project` `cp`;

DROP VIEW IF EXISTS `vw_core_stock_ledger`
CREATE VIEW `vw_core_stock_ledger` AS
SELECT
`sl`.`company_id`           AS `company_id`,
`sl`.`company_branch_id`    AS `company_branch_id`,
`sl`.`fiscal_year_id`       AS `fiscal_year_id`,
`sl`.`document_type_id`     AS `document_type_id`,
`sl`.`document_id`          AS `document_id`,
`sl`.`document_identity`    AS `document_identity`,
`sl`.`document_date`        AS `document_date`,
`sl`.`warehouse_id`         AS `warehouse_id`,
`sl`.`document_detail_id`   AS `document_detail_id`,
`sl`.`product_id`           AS `product_id`,
`sl`.`document_unit_id`     AS `document_unit_id`,
`sl`.`document_qty`         AS `document_qty`,
`sl`.`unit_conversion`      AS `unit_conversion`,
`sl`.`base_unit_id`         AS `base_unit_id`,
`sl`.`base_qty`             AS `base_qty`,
`sl`.`document_currency_id` AS `document_currency_id`,
`sl`.`document_rate`        AS `document_rate`,
`sl`.`document_amount`      AS `document_amount`,
`sl`.`currency_conversion`  AS `currency_conversion`,
`sl`.`base_currency_id`     AS `base_currency_id`,
`sl`.`base_rate`            AS `base_rate`,
`sl`.`base_amount`          AS `base_amount`,
`sl`.`remarks`              AS `remarks`,
`sl`.`created_at`           AS `created_at`,
`sl`.`created_by_id`        AS `created_by_id`,
`wh`.`name`                 AS `warehouse`,
`p`.`product_category_id`   AS `product_category_id`,
`pc`.`name`                 AS `product_category`,
`p`.`product_code`          AS `product_code`,
`p`.`name`                  AS `product_name`,
`p`.`product_image`         AS `product_image`,
`p`.`reorder_quantity`      AS `reorder_quantity`,
`p`.`cost_price`            AS `cost_price`,
`p`.`sale_price`            AS `sale_price`,
`p`.`inventory_account_id`  AS `inventory_account_id`,
`p`.`cogs_account_id`       AS `cogs_account_id`,
`p`.`revenue_account_id`    AS `revenue_account_id`,
`p`.`adjustment_account_id` AS `adjustment_account_id`,
`ud`.`code`                 AS `document_unit_code`,
`ud`.`name`                 AS `document_unit`,
`ub`.`code`                 AS `base_unit_code`,
`ub`.`name`                 AS `base_unit`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`core_stock_ledger` `sl`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `sl`.`company_id`)
AND (`wh`.`company_branch_id` = `sl`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `sl`.`warehouse_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `sl`.`company_id`)
AND (`p`.`product_id` = `sl`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `ud`
ON (((`ud`.`company_id` = `sl`.`company_id`)
AND (`ud`.`unit_id` = `sl`.`document_unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `ub`
ON (((`ub`.`company_id` = `sl`.`company_id`)
AND (`ub`.`unit_id` = `sl`.`base_unit_id`))));

DROP VIEW IF EXISTS `vw_core_sub_project`
CREATE VIEW `vw_core_sub_project` AS
SELECT
`scp`.`sub_project_id`     AS `sub_project_id`,
`scp`.`project_id`         AS `project_id`,
`scp`.`name`               AS `name`,
`scp`.`event_id`           AS `event_id`,
`scp`.`revenue_account_id` AS `revenue_account_id`,
`scp`.`bank_account_id`    AS `bank_account_id`,
`scp`.`company_id`         AS `company_id`,
`scp`.`company_branch_id`  AS `company_branch_id`,
`scp`.`created_at`         AS `created_at`,
`cp`.`name`                AS `project_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`core_sub_project` `scp`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_project` `cp`
ON ((`cp`.`project_id` = `scp`.`project_id`)));

DROP VIEW IF EXISTS `vw_core_supplier`
CREATE VIEW `vw_core_supplier` AS
SELECT
`c`.`company_id`             AS `company_id`,
`c`.`company_branch_id`      AS `company_branch_id`,
`c`.`partner_category_id`    AS `partner_category_id`,
`c`.`supplier_id`            AS `supplier_id`,
`c`.`name`                   AS `name`,
`c`.`address`                AS `address`,
`c`.`phone`                  AS `phone`,
`c`.`mobile`                 AS `mobile`,
`c`.`email`                  AS `email`,
`c`.`gst_no`                 AS `gst_no`,
`c`.`ntn_no`                 AS `ntn_no`,
`c`.`day_limit`              AS `day_limit`,
`c`.`amount_limit`           AS `amount_limit`,
`c`.`document_currency_id`   AS `document_currency_id`,
`c`.`cash_account_id`        AS `cash_account_id`,
`c`.`outstanding_account_id` AS `outstanding_account_id`,
`c`.`advance_account_id`     AS `advance_account_id`,
`c`.`created_at`             AS `created_at`,
`c`.`created_by_id`          AS `created_by_id`,
`cc`.`name`                  AS `partner_category`,
`ccc`.`name`                 AS `currency`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`core_supplier` `c`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner_category` `cc`
ON (((`c`.`partner_category_id` = `cc`.`partner_category_id`)
AND (`c`.`company_id` = `cc`.`company_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_currency` `ccc`
ON (((`ccc`.`currency_id` = `c`.`document_currency_id`)
AND (`ccc`.`company_id` = `c`.`company_id`))));

DROP VIEW IF EXISTS `vw_gl0_coa_all`
CREATE VIEW `vw_gl0_coa_all` AS
SELECT
`l1`.`company_id`    AS `company_id`,
`l1`.`gl_type_id`    AS `gl_type_id`,
`l1`.`coa_level1_id` AS `coa_level1_id`,
`l1`.`level1_code`   AS `level1_code`,
`l1`.`name`          AS `level1_name`,
CONCAT(`l1`.`level1_code`,': ',`l1`.`name`) AS `level1_display_name`,
`l2`.`coa_level2_id` AS `coa_level2_id`,
`l2`.`level2_code`   AS `level2_code`,
`l2`.`name`          AS `level2_name`,
CONCAT(`l1`.`level1_code`,'-',`l2`.`level2_code`,': ',`l2`.`name`) AS `level2_display_name`,
`l3`.`coa_level3_id` AS `coa_level3_id`,
`l3`.`level3_code`   AS `level3_code`,
`l3`.`name`          AS `level3_name`,
CONCAT(`l1`.`level1_code`,'-',`l2`.`level2_code`,'-',`l3`.`level3_code`,': ',`l3`.`name`) AS `level3_display_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level1` `l1`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level2` `l2`
ON ((`l2`.`coa_level1_id` = `l1`.`coa_level1_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level3` `l3`
ON (((`l3`.`coa_level2_id` = `l2`.`coa_level2_id`)
AND (`l3`.`coa_level1_id` = `l1`.`coa_level1_id`))));

DROP VIEW IF EXISTS `vw_gl0_coa_level1`
CREATE VIEW `vw_gl0_coa_level1` AS
SELECT
`gt`.`name`          AS `gl_type`,
`l1`.`coa_level1_id` AS `coa_level1_id`,
`l1`.`company_id`    AS `company_id`,
`l1`.`gl_type_id`    AS `gl_type_id`,
`l1`.`level1_code`   AS `level1_code`,
`l1`.`name`          AS `name`,
`l1`.`status`        AS `status`,
`l1`.`created_at`    AS `created_at`,
`l1`.`created_by_id` AS `created_by_id`,
CONCAT(`l1`.`level1_code`,':',`l1`.`name`) AS `level1_display_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level1` `l1`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`const_gl_type` `gt`
ON ((`l1`.`gl_type_id` = `gt`.`gl_type_id`)));

DROP VIEW IF EXISTS `vw_gl0_coa_level2`
CREATE VIEW `vw_gl0_coa_level2` AS
SELECT
`gt`.`name`          AS `gl_type`,
`l1`.`level1_code`   AS `level1_code`,
`l1`.`name`          AS `level1_name`,
CONCAT(`l1`.`level1_code`,':',`l1`.`name`) AS `level1_display_name`,
`l2`.`coa_level2_id` AS `coa_level2_id`,
`l2`.`company_id`    AS `company_id`,
`l2`.`coa_level1_id` AS `coa_level1_id`,
`l2`.`level2_code`   AS `level2_code`,
`l2`.`name`          AS `name`,
`l2`.`status`        AS `status`,
`l2`.`created_at`    AS `created_at`,
`l2`.`created_by_id` AS `created_by_id`,
CONCAT(`l1`.`level1_code`,'-',`l2`.`level2_code`,':',`l2`.`name`) AS `level2_display_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level2` `l2`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level1` `l1`
ON (((`l1`.`company_id` = `l2`.`company_id`)
AND (`l1`.`coa_level1_id` = `l2`.`coa_level1_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`const_gl_type` `gt`
ON ((`l1`.`gl_type_id` = `gt`.`gl_type_id`)));

DROP VIEW IF EXISTS `vw_gl0_coa_level3`
CREATE VIEW `vw_gl0_coa_level3` AS
SELECT
`gt`.`name`          AS `gl_type`,
`l1`.`level1_code`   AS `level1_code`,
`l1`.`name`          AS `level1_name`,
CONCAT(`l1`.`level1_code`,':',`l1`.`name`) AS `level1_display_name`,
`l2`.`level2_code`   AS `level2_code`,
`l2`.`name`          AS `level2_name`,
CONCAT(`l1`.`level1_code`,'-',`l2`.`level2_code`,':',`l2`.`name`) AS `level2_display_name`,
`l3`.`coa_level3_id` AS `coa_level3_id`,
`l3`.`company_id`    AS `company_id`,
`l3`.`coa_level2_id` AS `coa_level2_id`,
`l3`.`coa_level1_id` AS `coa_level1_id`,
`l3`.`level3_code`   AS `level3_code`,
`l3`.`name`          AS `name`,
`l3`.`status`        AS `status`,
`l3`.`created_at`    AS `created_at`,
`l3`.`created_by_id` AS `created_by_id`,
CONCAT(`l1`.`level1_code`,'-',`l2`.`level2_code`,'-',`l3`.`level3_code`,':',`l3`.`name`) AS `level3_display_name`
FROM (((`fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level3` `l3`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level2` `l2`
ON (((`l2`.`company_id` = `l3`.`company_id`)
AND (`l2`.`coa_level2_id` = `l3`.`coa_level2_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`gl0_coa_level1` `l1`
ON (((`l1`.`company_id` = `l2`.`company_id`)
AND (`l1`.`coa_level1_id` = `l2`.`coa_level1_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`const_gl_type` `gt`
ON ((`l1`.`gl_type_id` = `gt`.`gl_type_id`)));

DROP VIEW IF EXISTS `vw_gla_advance_payment`
CREATE VIEW `vw_gla_advance_payment` AS
SELECT
`ap`.`advance_payment_id`     AS `advance_payment_id`,
`ap`.`company_id`             AS `company_id`,
`ap`.`company_branch_id`      AS `company_branch_id`,
`ap`.`fiscal_year_id`         AS `fiscal_year_id`,
`ap`.`document_type_id`       AS `document_type_id`,
`ap`.`document_prefix`        AS `document_prefix`,
`ap`.`document_no`            AS `document_no`,
`ap`.`document_date`          AS `document_date`,
`ap`.`document_identity`      AS `document_identity`,
`ap`.`account_type`           AS `account_type`,
`ap`.`transaction_account_id` AS `transaction_account_id`,
`ap`.`partner_type_id`        AS `partner_type_id`,
`ap`.`partner_id`             AS `partner_id`,
`ap`.`base_currency_id`       AS `base_currency_id`,
`ap`.`document_currency_id`   AS `document_currency_id`,
`ap`.`conversion_rate`        AS `conversion_rate`,
`ap`.`cheque_date`            AS `cheque_date`,
`ap`.`cheque_no`              AS `cheque_no`,
`ap`.`remarks`                AS `remarks`,
`ap`.`amount`                 AS `amount`,
`ap`.`base_amount`            AS `base_amount`,
`ap`.`is_post`                AS `is_post`,
`ap`.`post_date`              AS `post_date`,
`ap`.`posted_by_id`           AS `posted_by_id`,
`ap`.`created_at`             AS `created_at`,
`ap`.`created_by_id`          AS `created_by_id`,
`p`.`partner_type`            AS `partner_type`,
`p`.`name`                    AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`gla_advance_payment` `ap`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `ap`.`partner_type_id`)
AND (`p`.`partner_id` = `ap`.`partner_id`))));

DROP VIEW IF EXISTS `vw_gla_advance_receipt`
CREATE VIEW `vw_gla_advance_receipt` AS
SELECT
`ar`.`advance_receipt_id`     AS `advance_receipt_id`,
`ar`.`company_id`             AS `company_id`,
`ar`.`company_branch_id`      AS `company_branch_id`,
`ar`.`fiscal_year_id`         AS `fiscal_year_id`,
`ar`.`document_type_id`       AS `document_type_id`,
`ar`.`document_prefix`        AS `document_prefix`,
`ar`.`document_no`            AS `document_no`,
`ar`.`document_date`          AS `document_date`,
`ar`.`document_identity`      AS `document_identity`,
`ar`.`account_type`           AS `account_type`,
`ar`.`transaction_account_id` AS `transaction_account_id`,
`ar`.`partner_type_id`        AS `partner_type_id`,
`ar`.`partner_id`             AS `partner_id`,
`ar`.`base_currency_id`       AS `base_currency_id`,
`ar`.`document_currency_id`   AS `document_currency_id`,
`ar`.`conversion_rate`        AS `conversion_rate`,
`ar`.`cheque_date`            AS `cheque_date`,
`ar`.`cheque_no`              AS `cheque_no`,
`ar`.`remarks`                AS `remarks`,
`ar`.`amount`                 AS `amount`,
`ar`.`base_amount`            AS `base_amount`,
`ar`.`is_post`                AS `is_post`,
`ar`.`post_date`              AS `post_date`,
`ar`.`posted_by_id`           AS `posted_by_id`,
`ar`.`created_at`             AS `created_at`,
`ar`.`created_by_id`          AS `created_by_id`,
`p`.`partner_type`            AS `partner_type`,
`p`.`name`                    AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`gla_advance_receipt` `ar`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `ar`.`partner_type_id`)
AND (`p`.`partner_id` = `ar`.`partner_id`))));

DROP VIEW IF EXISTS `vw_gli_credit_invoice`
CREATE VIEW `vw_gli_credit_invoice` AS
SELECT
`di`.`credit_invoice_id`    AS `credit_invoice_id`,
`di`.`company_id`           AS `company_id`,
`di`.`company_branch_id`    AS `company_branch_id`,
`di`.`fiscal_year_id`       AS `fiscal_year_id`,
`di`.`document_type_id`     AS `document_type_id`,
`di`.`document_prefix`      AS `document_prefix`,
`di`.`document_no`          AS `document_no`,
`di`.`document_identity`    AS `document_identity`,
`di`.`document_date`        AS `document_date`,
`di`.`manual_ref_no`        AS `manual_ref_no`,
`di`.`partner_type_id`      AS `partner_type_id`,
`di`.`partner_id`           AS `partner_id`,
`di`.`remarks`              AS `remarks`,
`di`.`document_currency_id` AS `document_currency_id`,
`di`.`discount`             AS `discount`,
`di`.`net_amount`           AS `net_amount`,
`di`.`base_currency_id`     AS `base_currency_id`,
`di`.`conversion_rate`      AS `conversion_rate`,
`di`.`base_amount`          AS `base_amount`,
`di`.`is_post`              AS `is_post`,
`di`.`post_date`            AS `post_date`,
`di`.`post_by_id`           AS `post_by_id`,
`di`.`created_at`           AS `created_at`,
`di`.`created_by_id`        AS `created_by_id`,
`p`.`partner_type`          AS `partner_type`,
`p`.`name`                  AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`gli_credit_invoice` `di`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `di`.`company_id`)
AND (`p`.`partner_type_id` = `di`.`partner_type_id`)
AND (`p`.`partner_id` = `di`.`partner_id`))));

DROP VIEW IF EXISTS `vw_gli_credit_invoice_detail`
CREATE VIEW `vw_gli_credit_invoice_detail` AS
SELECT
`did`.`company_id`               AS `company_id`,
`did`.`company_branch_id`        AS `company_branch_id`,
`did`.`fiscal_year_id`           AS `fiscal_year_id`,
`did`.`credit_invoice_id`        AS `credit_invoice_id`,
`did`.`credit_invoice_detail_id` AS `credit_invoice_detail_id`,
`did`.`partner_type_id`          AS `partner_type_id`,
`did`.`partner_id`               AS `partner_id`,
`did`.`sort_order`               AS `sort_order`,
`did`.`coa_id`                   AS `coa_id`,
`did`.`remarks`                  AS `remarks`,
`did`.`amount`                   AS `amount`,
`did`.`base_currency_id`         AS `base_currency_id`,
`did`.`conversion_rate`          AS `conversion_rate`,
`did`.`base_amount`              AS `base_amount`,
`did`.`created_at`               AS `created_at`,
`did`.`created_by_id`            AS `created_by_id`,
`p`.`partner_type`               AS `partner_type`,
`p`.`name`                       AS `partner_name`,
`l3`.`level3_display_name`       AS `account`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`gli_credit_invoice_detail` `did`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `did`.`company_id`)
AND (`p`.`partner_type_id` = `did`.`partner_type_id`)
AND (`p`.`partner_id` = `did`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3`
ON ((`l3`.`coa_level3_id` = `did`.`coa_id`)));

DROP VIEW IF EXISTS `vw_gli_debit_invoice`
CREATE VIEW `vw_gli_debit_invoice` AS
SELECT
`di`.`debit_invoice_id`     AS `debit_invoice_id`,
`di`.`company_id`           AS `company_id`,
`di`.`company_branch_id`    AS `company_branch_id`,
`di`.`fiscal_year_id`       AS `fiscal_year_id`,
`di`.`document_type_id`     AS `document_type_id`,
`di`.`document_prefix`      AS `document_prefix`,
`di`.`document_no`          AS `document_no`,
`di`.`document_identity`    AS `document_identity`,
`di`.`document_date`        AS `document_date`,
`di`.`manual_ref_no`        AS `manual_ref_no`,
`di`.`partner_type_id`      AS `partner_type_id`,
`di`.`partner_id`           AS `partner_id`,
`di`.`remarks`              AS `remarks`,
`di`.`document_currency_id` AS `document_currency_id`,
`di`.`discount`             AS `discount`,
`di`.`net_amount`           AS `net_amount`,
`di`.`base_currency_id`     AS `base_currency_id`,
`di`.`conversion_rate`      AS `conversion_rate`,
`di`.`base_amount`          AS `base_amount`,
`di`.`is_post`              AS `is_post`,
`di`.`post_date`            AS `post_date`,
`di`.`post_by_id`           AS `post_by_id`,
`di`.`created_at`           AS `created_at`,
`di`.`created_by_id`        AS `created_by_id`,
`p`.`partner_type`          AS `partner_type`,
`p`.`name`                  AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`gli_debit_invoice` `di`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `di`.`company_id`)
AND (`p`.`partner_type_id` = `di`.`partner_type_id`)
AND (`p`.`partner_id` = `di`.`partner_id`))));

DROP VIEW IF EXISTS `vw_gli_debit_invoice_detail`
CREATE VIEW `vw_gli_debit_invoice_detail` AS
SELECT
`did`.`company_id`              AS `company_id`,
`did`.`company_branch_id`       AS `company_branch_id`,
`did`.`fiscal_year_id`          AS `fiscal_year_id`,
`did`.`debit_invoice_id`        AS `debit_invoice_id`,
`did`.`debit_invoice_detail_id` AS `debit_invoice_detail_id`,
`did`.`partner_type_id`         AS `partner_type_id`,
`did`.`partner_id`              AS `partner_id`,
`did`.`sort_order`              AS `sort_order`,
`did`.`coa_id`                  AS `coa_id`,
`did`.`remarks`                 AS `remarks`,
`did`.`amount`                  AS `amount`,
`did`.`base_currency_id`        AS `base_currency_id`,
`did`.`conversion_rate`         AS `conversion_rate`,
`did`.`base_amount`             AS `base_amount`,
`did`.`created_at`              AS `created_at`,
`did`.`created_by_id`           AS `created_by_id`,
`p`.`partner_type`              AS `partner_type`,
`p`.`name`                      AS `partner_name`,
`l3`.`level3_display_name`      AS `account`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`gli_debit_invoice_detail` `did`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `did`.`company_id`)
AND (`p`.`partner_type_id` = `did`.`partner_type_id`)
AND (`p`.`partner_id` = `did`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3`
ON ((`l3`.`coa_level3_id` = `did`.`coa_id`)));

DROP VIEW IF EXISTS `vw_glt_bank_payment`
CREATE VIEW `vw_glt_bank_payment` AS
SELECT
`bp`.`bank_payment_id`             AS `bank_payment_id`,
`bp`.`company_id`                  AS `company_id`,
`bp`.`company_branch_id`           AS `company_branch_id`,
`bp`.`fiscal_year_id`              AS `fiscal_year_id`,
`bp`.`document_type_id`            AS `document_type_id`,
`bp`.`document_prefix`             AS `document_prefix`,
`bp`.`document_no`                 AS `document_no`,
`bp`.`document_date`               AS `document_date`,
`bp`.`document_identity`           AS `document_identity`,
`bp`.`manual_ref_no`               AS `manual_ref_no`,
`bp`.`transaction_account_id`      AS `transaction_account_id`,
`bp`.`project_id`                  AS `project_id`,
`bp`.`sub_project_id`              AS `sub_project_id`,
`bp`.`partner_type_id`             AS `partner_type_id`,
`bp`.`partner_id`                  AS `partner_id`,
`bp`.`cheque_name`                 AS `cheque_name`,
`bp`.`remarks`                     AS `remarks`,
`bp`.`document_currency_id`        AS `document_currency_id`,
`bp`.`total_amount`                AS `total_amount`,
`bp`.`total_wht_amount`            AS `total_wht_amount`,
`bp`.`total_other_tax_amount`      AS `total_other_tax_amount`,
`bp`.`total_net_amount`            AS `total_net_amount`,
`bp`.`conversion_rate`             AS `conversion_rate`,
`bp`.`base_total_amount`           AS `base_total_amount`,
`bp`.`base_total_wht_amount`       AS `base_total_wht_amount`,
`bp`.`base_total_other_tax_amount` AS `base_total_other_tax_amount`,
`bp`.`base_total_net_amount`       AS `base_total_net_amount`,
`bp`.`is_post`                     AS `is_post`,
`bp`.`post_date`                   AS `post_date`,
`bp`.`post_by_id`                  AS `post_by_id`,
`bp`.`created_at`                  AS `created_at`,
`bp`.`created_by_id`               AS `created_by_id`,
`bp`.`modified_at`                 AS `modified_at`,
`bp`.`modified_by_id`              AS `modified_by_id`,
`p`.`partner_type`                 AS `partner_type`,
`p`.`name`                         AS `partner_name`,
`sp`.`project_name`                AS `project_name`,
`sp`.`name`                        AS `sub_project_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`glt_bank_payment` `bp`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `bp`.`partner_type_id`)
AND (`p`.`partner_id` = `bp`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `bp`.`project_id`)
AND (`sp`.`sub_project_id` = `bp`.`sub_project_id`))));

DROP VIEW IF EXISTS `vw_glt_bank_payment_detail`
CREATE VIEW `vw_glt_bank_payment_detail` AS
SELECT
`bpd`.`bank_payment_detail_id` AS `bank_payment_detail_id`,
`bpd`.`company_id`             AS `company_id`,
`bpd`.`company_branch_id`      AS `company_branch_id`,
`bpd`.`fiscal_year_id`         AS `fiscal_year_id`,
`bpd`.`bank_payment_id`        AS `bank_payment_id`,
`bpd`.`sort_order`             AS `sort_order`,
`bpd`.`ref_document_type_id`   AS `ref_document_type_id`,
`bpd`.`ref_document_identity`  AS `ref_document_identity`,
`bpd`.`coa_id`                 AS `coa_id`,
`bpd`.`amaanat_no`             AS `amaanat_no`,
`bpd`.`remarks`                AS `remarks`,
`bpd`.`cheque_date`            AS `cheque_date`,
`bpd`.`cheque_no`              AS `cheque_no`,
`bpd`.`document_amount`        AS `document_amount`,
`bpd`.`amount`                 AS `amount`,
`bpd`.`wht_percent`            AS `wht_percent`,
`bpd`.`wht_amount`             AS `wht_amount`,
`bpd`.`other_tax_percent`      AS `other_tax_percent`,
`bpd`.`other_tax_amount`       AS `other_tax_amount`,
`bpd`.`net_amount`             AS `net_amount`,
`bpd`.`base_currency_id`       AS `base_currency_id`,
`bpd`.`conversion_rate`        AS `conversion_rate`,
`bpd`.`base_amount`            AS `base_amount`,
`bpd`.`base_wht_amount`        AS `base_wht_amount`,
`bpd`.`base_other_tax_amount`  AS `base_other_tax_amount`,
`bpd`.`base_net_amount`        AS `base_net_amount`,
`bpd`.`created_at`             AS `created_at`,
`bpd`.`created_by_id`          AS `created_by_id`,
`bp`.`document_type_id`        AS `document_type_id`,
`bp`.`document_identity`       AS `document_identity`,
`bp`.`document_date`           AS `document_date`,
`bp`.`is_post`                 AS `is_post`,
`bp`.`partner_type_id`         AS `partner_type_id`,
`bp`.`partner_id`              AS `partner_id`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`glt_bank_payment_detail` `bpd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`glt_bank_payment` `bp`
ON ((`bp`.`bank_payment_id` = `bpd`.`bank_payment_id`)));

DROP VIEW IF EXISTS `vw_glt_bank_receipt`
CREATE VIEW `vw_glt_bank_receipt` AS
SELECT
`br`.`bank_receipt_id`             AS `bank_receipt_id`,
`br`.`company_id`                  AS `company_id`,
`br`.`company_branch_id`           AS `company_branch_id`,
`br`.`fiscal_year_id`              AS `fiscal_year_id`,
`br`.`document_type_id`            AS `document_type_id`,
`br`.`document_prefix`             AS `document_prefix`,
`br`.`document_no`                 AS `document_no`,
`br`.`document_date`               AS `document_date`,
`br`.`document_identity`           AS `document_identity`,
`br`.`challan_no`                  AS `challan_no`,
`br`.`transaction_account_id`      AS `transaction_account_id`,
`br`.`project_id`                  AS `project_id`,
`br`.`sub_project_id`              AS `sub_project_id`,
`br`.`partner_type_id`             AS `partner_type_id`,
`br`.`partner_id`                  AS `partner_id`,
`br`.`its_no`                      AS `its_no`,
`br`.`remarks`                     AS `remarks`,
`br`.`document_currency_id`        AS `document_currency_id`,
`br`.`total_amount`                AS `total_amount`,
`br`.`total_wht_amount`            AS `total_wht_amount`,
`br`.`total_other_tax_amount`      AS `total_other_tax_amount`,
`br`.`total_net_amount`            AS `total_net_amount`,
`br`.`conversion_rate`             AS `conversion_rate`,
`br`.`base_total_amount`           AS `base_total_amount`,
`br`.`base_total_wht_amount`       AS `base_total_wht_amount`,
`br`.`base_total_other_tax_amount` AS `base_total_other_tax_amount`,
`br`.`base_total_net_amount`       AS `base_total_net_amount`,
`br`.`is_post`                     AS `is_post`,
`br`.`post_date`                   AS `post_date`,
`br`.`post_by_id`                  AS `post_by_id`,
`br`.`created_at`                  AS `created_at`,
`br`.`created_by_id`               AS `created_by_id`,
`br`.`modified_at`                 AS `modified_at`,
`br`.`modified_by_id`              AS `modified_by_id`,
`p`.`partner_type`                 AS `partner_type`,
`p`.`name`                         AS `partner_name`,
`sp`.`project_name`                AS `project_name`,
`sp`.`name`                        AS `sub_project_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`glt_bank_receipt` `br`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `br`.`partner_type_id`)
AND (`p`.`partner_id` = `br`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `br`.`project_id`)
AND (`sp`.`sub_project_id` = `br`.`sub_project_id`))))

;





DROP VIEW IF EXISTS `vw_glt_bank_receipt_detail`

CREATE VIEW `vw_glt_bank_receipt_detail` AS
SELECT
`brd`.`bank_receipt_detail_id` AS `bank_receipt_detail_id`,
`brd`.`company_id`             AS `company_id`,
`brd`.`company_branch_id`      AS `company_branch_id`,
`brd`.`fiscal_year_id`         AS `fiscal_year_id`,
`brd`.`bank_receipt_id`        AS `bank_receipt_id`,
`brd`.`sort_order`             AS `sort_order`,
`brd`.`ref_document_type_id`   AS `ref_document_type_id`,
`brd`.`ref_document_identity`  AS `ref_document_identity`,
`brd`.`coa_id`                 AS `coa_id`,
`brd`.`remarks`                AS `remarks`,
`brd`.`amaanat_no`             AS `amaanat_no`,
`brd`.`cheque_date`            AS `cheque_date`,
`brd`.`cheque_no`              AS `cheque_no`,
`brd`.`document_amount`        AS `document_amount`,
`brd`.`document_currency_id`   AS `document_currency_id`,
`brd`.`amount`                 AS `amount`,
`brd`.`wht_percent`            AS `wht_percent`,
`brd`.`wht_amount`             AS `wht_amount`,
`brd`.`other_tax_percent`      AS `other_tax_percent`,
`brd`.`other_tax_amount`       AS `other_tax_amount`,
`brd`.`net_amount`             AS `net_amount`,
`brd`.`base_currency_id`       AS `base_currency_id`,
`brd`.`conversion_rate`        AS `conversion_rate`,
`brd`.`base_amount`            AS `base_amount`,
`brd`.`base_wht_amount`        AS `base_wht_amount`,
`brd`.`base_other_tax_amount`  AS `base_other_tax_amount`,
`brd`.`base_net_amount`        AS `base_net_amount`,
`brd`.`created_at`             AS `created_at`,
`brd`.`created_by_id`          AS `created_by_id`,
`br`.`document_type_id`        AS `document_type_id`,
`br`.`document_identity`       AS `document_identity`,
`br`.`document_date`           AS `document_date`,
`br`.`is_post`                 AS `is_post`,
`br`.`partner_type_id`         AS `partner_type_id`,
`br`.`partner_id`              AS `partner_id`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`glt_bank_receipt_detail` `brd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`glt_bank_receipt` `br`
ON ((`br`.`bank_receipt_id` = `brd`.`bank_receipt_id`)))

;





DROP VIEW IF EXISTS `vw_glt_cash_payment`

CREATE VIEW `vw_glt_cash_payment` AS
SELECT
`cp`.`cash_payment_id`             AS `cash_payment_id`,
`cp`.`company_id`                  AS `company_id`,
`cp`.`company_branch_id`           AS `company_branch_id`,
`cp`.`fiscal_year_id`              AS `fiscal_year_id`,
`cp`.`document_type_id`            AS `document_type_id`,
`cp`.`document_prefix`             AS `document_prefix`,
`cp`.`document_no`                 AS `document_no`,
`cp`.`document_date`               AS `document_date`,
`cp`.`document_identity`           AS `document_identity`,
`cp`.`manual_ref_no`               AS `manual_ref_no`,
`cp`.`transaction_account_id`      AS `transaction_account_id`,
`cp`.`project_id`                  AS `project_id`,
`cp`.`sub_project_id`              AS `sub_project_id`,
`cp`.`partner_type_id`             AS `partner_type_id`,
`cp`.`partner_id`                  AS `partner_id`,
`cp`.`remarks`                     AS `remarks`,
`cp`.`document_currency_id`        AS `document_currency_id`,
`cp`.`total_amount`                AS `total_amount`,
`cp`.`total_wht_amount`            AS `total_wht_amount`,
`cp`.`total_other_tax_amount`      AS `total_other_tax_amount`,
`cp`.`total_net_amount`            AS `total_net_amount`,
`cp`.`base_currency_id`            AS `base_currency_id`,
`cp`.`conversion_rate`             AS `conversion_rate`,
`cp`.`base_total_amount`           AS `base_total_amount`,
`cp`.`base_total_wht_amount`       AS `base_total_wht_amount`,
`cp`.`base_total_other_tax_amount` AS `base_total_other_tax_amount`,
`cp`.`base_total_net_amount`       AS `base_total_net_amount`,
`cp`.`is_post`                     AS `is_post`,
`cp`.`post_date`                   AS `post_date`,
`cp`.`post_by_id`                  AS `post_by_id`,
`cp`.`created_at`                  AS `created_at`,
`cp`.`created_by_id`               AS `created_by_id`,
`cp`.`modified_at`                 AS `modified_at`,
`cp`.`modified_by_id`              AS `modified_by_id`,
`p`.`partner_type`                 AS `partner_type`,
`p`.`name`                         AS `partner_name`,
`sp`.`project_name`                AS `project_name`,
`sp`.`name`                        AS `sub_project_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`glt_cash_payment` `cp`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `cp`.`partner_type_id`)
AND (`p`.`partner_id` = `cp`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `cp`.`project_id`)
AND (`sp`.`sub_project_id` = `cp`.`sub_project_id`))))

;





DROP VIEW IF EXISTS `vw_glt_cash_payment_detail`

CREATE VIEW `vw_glt_cash_payment_detail` AS
SELECT
`cpd`.`cash_payment_detail_id` AS `cash_payment_detail_id`,
`cpd`.`company_id`             AS `company_id`,
`cpd`.`company_branch_id`      AS `company_branch_id`,
`cpd`.`fiscal_year_id`         AS `fiscal_year_id`,
`cpd`.`cash_payment_id`        AS `cash_payment_id`,
`cpd`.`sort_order`             AS `sort_order`,
`cpd`.`ref_document_type_id`   AS `ref_document_type_id`,
`cpd`.`ref_document_identity`  AS `ref_document_identity`,
`cpd`.`coa_id`                 AS `coa_id`,
`cpd`.`remarks`                AS `remarks`,
`cpd`.`cheque_date`            AS `cheque_date`,
`cpd`.`cheque_no`              AS `cheque_no`,
`cpd`.`document_amount`        AS `document_amount`,
`cpd`.`document_currency_id`   AS `document_currency_id`,
`cpd`.`amount`                 AS `amount`,
`cpd`.`wht_percent`            AS `wht_percent`,
`cpd`.`wht_amount`             AS `wht_amount`,
`cpd`.`other_tax_percent`      AS `other_tax_percent`,
`cpd`.`other_tax_amount`       AS `other_tax_amount`,
`cpd`.`net_amount`             AS `net_amount`,
`cpd`.`base_currency_id`       AS `base_currency_id`,
`cpd`.`conversion_rate`        AS `conversion_rate`,
`cpd`.`base_amount`            AS `base_amount`,
`cpd`.`base_wht_amount`        AS `base_wht_amount`,
`cpd`.`base_other_tax_amount`  AS `base_other_tax_amount`,
`cpd`.`base_net_amount`        AS `base_net_amount`,
`cpd`.`created_at`             AS `created_at`,
`cpd`.`created_by_id`          AS `created_by_id`,
`cp`.`document_type_id`        AS `document_type_id`,
`cp`.`document_identity`       AS `document_identity`,
`cp`.`document_date`           AS `document_date`,
`cp`.`is_post`                 AS `is_post`,
`cp`.`partner_type_id`         AS `partner_type_id`,
`cp`.`partner_id`              AS `partner_id`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`glt_cash_payment_detail` `cpd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`glt_cash_payment` `cp`
ON ((`cp`.`cash_payment_id` = `cpd`.`cash_payment_id`)))

;





DROP VIEW IF EXISTS `vw_glt_cash_receipt`

CREATE VIEW `vw_glt_cash_receipt` AS
SELECT
`cr`.`cash_receipt_id`             AS `cash_receipt_id`,
`cr`.`company_id`                  AS `company_id`,
`cr`.`company_branch_id`           AS `company_branch_id`,
`cr`.`fiscal_year_id`              AS `fiscal_year_id`,
`cr`.`document_type_id`            AS `document_type_id`,
`cr`.`document_prefix`             AS `document_prefix`,
`cr`.`document_no`                 AS `document_no`,
`cr`.`document_date`               AS `document_date`,
`cr`.`document_identity`           AS `document_identity`,
`cr`.`manual_ref_no`               AS `manual_ref_no`,
`cr`.`transaction_account_id`      AS `transaction_account_id`,
`cr`.`project_id`                  AS `project_id`,
`cr`.`sub_project_id`              AS `sub_project_id`,
`cr`.`partner_type_id`             AS `partner_type_id`,
`cr`.`partner_id`                  AS `partner_id`,
`cr`.`remarks`                     AS `remarks`,
`cr`.`document_currency_id`        AS `document_currency_id`,
`cr`.`total_amount`                AS `total_amount`,
`cr`.`total_wht_amount`            AS `total_wht_amount`,
`cr`.`total_other_tax_amount`      AS `total_other_tax_amount`,
`cr`.`total_net_amount`            AS `total_net_amount`,
`cr`.`conversion_rate`             AS `conversion_rate`,
`cr`.`base_total_amount`           AS `base_total_amount`,
`cr`.`base_total_wht_amount`       AS `base_total_wht_amount`,
`cr`.`base_total_other_tax_amount` AS `base_total_other_tax_amount`,
`cr`.`base_total_net_amount`       AS `base_total_net_amount`,
`cr`.`is_post`                     AS `is_post`,
`cr`.`post_date`                   AS `post_date`,
`cr`.`post_by_id`                  AS `post_by_id`,
`cr`.`created_at`                  AS `created_at`,
`cr`.`created_by_id`               AS `created_by_id`,
`cr`.`modified_at`                 AS `modified_at`,
`cr`.`modified_by_id`              AS `modified_by_id`,
`p`.`partner_type`                 AS `partner_type`,
`p`.`name`                         AS `partner_name`,
`sp`.`project_name`                AS `project_name`,
`sp`.`name`                        AS `sub_project_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`glt_cash_receipt` `cr`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `cr`.`partner_type_id`)
AND (`p`.`partner_id` = `cr`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `cr`.`project_id`)
AND (`sp`.`sub_project_id` = `cr`.`sub_project_id`))))

;





DROP VIEW IF EXISTS `vw_glt_cash_receipt_detail`

CREATE VIEW `vw_glt_cash_receipt_detail` AS
SELECT
`crd`.`cash_receipt_detail_id` AS `cash_receipt_detail_id`,
`crd`.`company_id`             AS `company_id`,
`crd`.`company_branch_id`      AS `company_branch_id`,
`crd`.`fiscal_year_id`         AS `fiscal_year_id`,
`crd`.`cash_receipt_id`        AS `cash_receipt_id`,
`crd`.`sort_order`             AS `sort_order`,
`crd`.`ref_document_type_id`   AS `ref_document_type_id`,
`crd`.`ref_document_identity`  AS `ref_document_identity`,
`crd`.`coa_id`                 AS `coa_id`,
`crd`.`remarks`                AS `remarks`,
`crd`.`cheque_date`            AS `cheque_date`,
`crd`.`cheque_no`              AS `cheque_no`,
`crd`.`document_amount`        AS `document_amount`,
`crd`.`document_currency_id`   AS `document_currency_id`,
`crd`.`amount`                 AS `amount`,
`crd`.`wht_percent`            AS `wht_percent`,
`crd`.`wht_amount`             AS `wht_amount`,
`crd`.`other_tax_percent`      AS `other_tax_percent`,
`crd`.`other_tax_amount`       AS `other_tax_amount`,
`crd`.`net_amount`             AS `net_amount`,
`crd`.`base_currency_id`       AS `base_currency_id`,
`crd`.`conversion_rate`        AS `conversion_rate`,
`crd`.`base_amount`            AS `base_amount`,
`crd`.`base_wht_amount`        AS `base_wht_amount`,
`crd`.`base_other_tax_amount`  AS `base_other_tax_amount`,
`crd`.`base_net_amount`        AS `base_net_amount`,
`crd`.`created_at`             AS `created_at`,
`crd`.`created_by_id`          AS `created_by_id`,
`cr`.`document_type_id`        AS `document_type_id`,
`cr`.`document_identity`       AS `document_identity`,
`cr`.`document_date`           AS `document_date`,
`cr`.`is_post`                 AS `is_post`,
`cr`.`partner_type_id`         AS `partner_type_id`,
`cr`.`partner_id`              AS `partner_id`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`glt_cash_receipt_detail` `crd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`glt_cash_receipt` `cr`
ON ((`cr`.`cash_receipt_id` = `crd`.`cash_receipt_id`)))

;





DROP VIEW IF EXISTS `vw_glt_journal_voucher_detail`

CREATE VIEW `vw_glt_journal_voucher_detail` AS
SELECT
`jvd`.`journal_voucher_detail_id` AS `journal_voucher_detail_id`,
`jvd`.`company_id`                AS `company_id`,
`jvd`.`company_branch_id`         AS `company_branch_id`,
`jvd`.`fiscal_year_id`            AS `fiscal_year_id`,
`jvd`.`journal_voucher_id`        AS `journal_voucher_id`,
`jvd`.`sort_order`                AS `sort_order`,
`jvd`.`partner_type_id`           AS `partner_type_id`,
`jvd`.`partner_id`                AS `partner_id`,
`jvd`.`project_id`                AS `project_id`,
`jvd`.`sub_project_id`            AS `sub_project_id`,
`jvd`.`ref_document_type_id`      AS `ref_document_type_id`,
`jvd`.`ref_document_identity`     AS `ref_document_identity`,
`jvd`.`coa_id`                    AS `coa_id`,
`jvd`.`its_no`                    AS `its_no`,
`jvd`.`challan_no`                AS `challan_no`,
`jvd`.`remarks`                   AS `remarks`,
`jvd`.`cheque_date`               AS `cheque_date`,
`jvd`.`cheque_no`                 AS `cheque_no`,
`jvd`.`document_currency_id`      AS `document_currency_id`,
`jvd`.`document_debit`            AS `document_debit`,
`jvd`.`document_credit`           AS `document_credit`,
`jvd`.`base_currency_id`          AS `base_currency_id`,
`jvd`.`conversion_rate`           AS `conversion_rate`,
`jvd`.`base_debit`                AS `base_debit`,
`jvd`.`base_credit`               AS `base_credit`,
`jvd`.`created_at`                AS `created_at`,
`jvd`.`created_by_id`             AS `created_by_id`,
`jv`.`document_type_id`           AS `document_type_id`,
`jv`.`document_identity`          AS `document_identity`,
`jv`.`document_date`              AS `document_date`,
`jv`.`is_post`                    AS `is_post`,
`l3a`.`level3_display_name`       AS `account`,
`p`.`partner_type`                AS `partner_type`,
`p`.`name`                        AS `partner_name`,
`sp`.`project_name`               AS `project_name`,
`sp`.`name`                       AS `sub_project_name`
FROM ((((`fayzehus_bharmals_bsuite_fh_1819`.`glt_journal_voucher_detail` `jvd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`glt_journal_voucher` `jv`
ON ((`jv`.`journal_voucher_id` = `jvd`.`journal_voucher_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3a`
ON (((`l3a`.`company_id` = `jvd`.`company_id`)
AND (`l3a`.`coa_level3_id` = `jvd`.`coa_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_partner` `p`
ON (((`p`.`company_id` = `jvd`.`company_id`)
AND (`p`.`partner_id` = `jvd`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `jvd`.`project_id`)
AND (`sp`.`sub_project_id` = `jvd`.`sub_project_id`))))

;





DROP VIEW IF EXISTS `vw_glt_opening_account`

CREATE VIEW `vw_glt_opening_account` AS
SELECT
`oc`.`opening_account_id`   AS `opening_account_id`,
`oc`.`company_id`           AS `company_id`,
`oc`.`company_branch_id`    AS `company_branch_id`,
`oc`.`fiscal_year_id`       AS `fiscal_year_id`,
`oc`.`document_type_id`     AS `document_type_id`,
`oc`.`document_prefix`      AS `document_prefix`,
`oc`.`document_no`          AS `document_no`,
`oc`.`document_identity`    AS `document_identity`,
`oc`.`document_date`        AS `document_date`,
`oc`.`partner_type_id`      AS `partner_type_id`,
`oc`.`partner_id`           AS `partner_id`,
`oc`.`document_currency_id` AS `document_currency_id`,
`oc`.`document_debit`       AS `document_debit`,
`oc`.`document_credit`      AS `document_credit`,
`oc`.`base_currency_id`     AS `base_currency_id`,
`oc`.`conversion_rate`      AS `conversion_rate`,
`oc`.`remarks`              AS `remarks`,
`oc`.`base_debit`           AS `base_debit`,
`oc`.`base_credit`          AS `base_credit`,
`oc`.`is_post`              AS `is_post`,
`oc`.`post_date`            AS `post_date`,
`oc`.`post_by_id`           AS `post_by_id`,
`oc`.`created_at`           AS `created_at`,
`oc`.`created_by_id`        AS `created_by_id`,
`p`.`partner_type`          AS `partner_type`,
`p`.`name`                  AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`glt_opening_account` `oc`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `oc`.`partner_type_id`)
AND (`p`.`partner_id` = `oc`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_glt_opening_account_detail`

CREATE VIEW `vw_glt_opening_account_detail` AS
SELECT
`oad`.`opening_account_detail_id` AS `opening_account_detail_id`,
`oad`.`company_id`                AS `company_id`,
`oad`.`company_branch_id`         AS `company_branch_id`,
`oad`.`fiscal_year_id`            AS `fiscal_year_id`,
`oad`.`opening_account_id`        AS `opening_account_id`,
`oad`.`sort_order`                AS `sort_order`,
`oad`.`partner_type_id`           AS `partner_type_id`,
`oad`.`partner_id`                AS `partner_id`,
`oad`.`project_id`                AS `project_id`,
`oad`.`sub_project_id`            AS `sub_project_id`,
`oad`.`ref_document_type_id`      AS `ref_document_type_id`,
`oad`.`ref_document_identity`     AS `ref_document_identity`,
`oad`.`ref_document_date`         AS `ref_document_date`,
`oad`.`ref_document_amount`       AS `ref_document_amount`,
`oad`.`coa_level3_id`             AS `coa_level3_id`,
`oad`.`document_currency_id`      AS `document_currency_id`,
`oad`.`document_debit`            AS `document_debit`,
`oad`.`document_credit`           AS `document_credit`,
`oad`.`base_currency_id`          AS `base_currency_id`,
`oad`.`conversion_rate`           AS `conversion_rate`,
`oad`.`base_debit`                AS `base_debit`,
`oad`.`base_credit`               AS `base_credit`,
`oad`.`created_at`                AS `created_at`,
`oad`.`created_by-id`             AS `created_by-id`,
`oa`.`document_type_id`           AS `document_type_id`,
`oa`.`document_identity`          AS `document_identity`,
`oa`.`document_date`              AS `document_date`,
`oa`.`is_post`                    AS `is_post`,
`p`.`partner_type`                AS `partner_type`,
`p`.`name`                        AS `partner_name`,
`l3a`.`level3_display_name`       AS `account`,
`sp`.`project_name`               AS `project_name`,
`sp`.`name`                       AS `sub_project_name`
FROM ((((`fayzehus_bharmals_bsuite_fh_1819`.`glt_opening_account_detail` `oad`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`glt_opening_account` `oa`
ON ((`oa`.`opening_account_id` = `oad`.`opening_account_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `l3a`
ON (((`l3a`.`company_id` = `oad`.`company_id`)
AND (`l3a`.`coa_level3_id` = `oad`.`coa_level3_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`partner_type_id` = `oad`.`partner_type_id`)
AND (`p`.`partner_id` = `oad`.`partner_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `oad`.`project_id`)
AND (`sp`.`sub_project_id` = `oad`.`sub_project_id`))))

;





DROP VIEW IF EXISTS `vw_in0_product`

CREATE VIEW `vw_in0_product` AS
SELECT
`p`.`company_id`            AS `company_id`,
`p`.`product_id`            AS `product_id`,
`p`.`product_category_id`   AS `product_category_id`,
`p`.`product_code`          AS `product_code`,
`p`.`name`                  AS `name`,
`p`.`product_image`         AS `product_image`,
`p`.`unit_id`               AS `unit_id`,
`p`.`manufacture_id`        AS `manufacture_id`,
`p`.`brand_id`              AS `brand_id`,
`p`.`make_id`               AS `make_id`,
`p`.`model_id`              AS `model_id`,
`p`.`description`           AS `description`,
`p`.`reorder_quantity`      AS `reorder_quantity`,
`p`.`cost_price`            AS `cost_price`,
`p`.`sale_price`            AS `sale_price`,
`p`.`cogs_account_id`       AS `cogs_account_id`,
`p`.`inventory_account_id`  AS `inventory_account_id`,
`p`.`revenue_account_id`    AS `revenue_account_id`,
`p`.`adjustment_account_id` AS `adjustment_account_id`,
`p`.`sale_profit`           AS `sale_profit`,
`p`.`status`                AS `status`,
`p`.`created_at`            AS `created_at`,
`p`.`created_by_id`         AS `created_by_id`,
`pc`.`name`                 AS `product_category`,
`u`.`name`                  AS `unit`,
`b`.`name`                  AS `brand`,
`mk`.`name`                 AS `make`,
`md`.`name`                 AS `model`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `p`.`company_id`)
AND (`u`.`unit_id` = `p`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_brand` `b`
ON (((`b`.`company_id` = `p`.`company_id`)
AND (`b`.`brand_id` = `p`.`brand_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_make` `mk`
ON (((`mk`.`company_id` = `p`.`company_id`)
AND (`mk`.`make_id` = `p`.`make_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_model` `md`
ON (((`md`.`company_id` = `p`.`company_id`)
AND (`md`.`model_id` = `p`.`model_id`))))

;





DROP VIEW IF EXISTS `vw_ina_opening_stock`

CREATE VIEW `vw_ina_opening_stock` AS
SELECT
`os`.`opening_stock_id`     AS `opening_stock_id`,
`os`.`company_id`           AS `company_id`,
`os`.`company_branch_id`    AS `company_branch_id`,
`os`.`fiscal_year_id`       AS `fiscal_year_id`,
`os`.`document_type_id`     AS `document_type_id`,
`os`.`document_prefix`      AS `document_prefix`,
`os`.`document_no`          AS `document_no`,
`os`.`document_identity`    AS `document_identity`,
`os`.`document_date`        AS `document_date`,
`os`.`warehouse_id`         AS `warehouse_id`,
`os`.`remarks`              AS `remarks`,
`os`.`document_currency_id` AS `document_currency_id`,
`os`.`net_amount`           AS `net_amount`,
`os`.`base_currency_id`     AS `base_currency_id`,
`os`.`conversion_rate`      AS `conversion_rate`,
`os`.`base_amount`          AS `base_amount`,
`os`.`is_post`              AS `is_post`,
`os`.`post_date`            AS `post_date`,
`os`.`post_by_id`           AS `post_by_id`,
`os`.`created_at`           AS `created_at`,
`os`.`created_by_id`        AS `created_by_id`,
`w`.`name`                  AS `warehouse`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ina_opening_stock` `os`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `w`
ON (((`w`.`company_id` = `os`.`company_id`)
AND (`w`.`company_branch_id` = `os`.`company_branch_id`)
AND (`w`.`warehouse_id` = `os`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_ina_opening_stock_detail`

CREATE VIEW `vw_ina_opening_stock_detail` AS
SELECT
`os`.`company_id`               AS `company_id`,
`os`.`company_branch_id`        AS `company_branch_id`,
`os`.`fiscal_year_id`           AS `fiscal_year_id`,
`os`.`opening_stock_id`         AS `opening_stock_id`,
`os`.`document_type_id`         AS `document_type_id`,
`os`.`document_prefix`          AS `document_prefix`,
`os`.`document_no`              AS `document_no`,
`os`.`document_identity`        AS `document_identity`,
`os`.`document_date`            AS `document_date`,
`os`.`warehouse_id`             AS `warehouse_id`,
`w`.`name`                      AS `warehouse`,
`os`.`remarks`                  AS `remarks`,
`osd`.`opening_stock_detail_id` AS `opening_stock_detail_id`,
`osd`.`sort_order`              AS `sort_order`,
`osd`.`unit_id`                 AS `unit_id`,
`u`.`name`                      AS `unit`,
`osd`.`product_id`              AS `product_id`,
`p`.`product_category_id`       AS `product_category_id`,
`pc`.`name`                     AS `product_category`,
`p`.`product_code`              AS `product_code`,
`p`.`name`                      AS `product`,
`p`.`product_image`             AS `product_image`,
`osd`.`document_currency_id`    AS `document_currency_id`,
`osd`.`qty`                     AS `qty`,
`osd`.`rate`                    AS `rate`,
`osd`.`amount`                  AS `amount`,
`osd`.`base_currency_id`        AS `base_currency_id`,
`osd`.`conversion_rate`         AS `conversion_rate`,
`osd`.`base_amount`             AS `base_amount`,
`osd`.`created_at`              AS `created_at`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`ina_opening_stock_detail` `osd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`ina_opening_stock` `os`
ON (((`os`.`company_id` = `osd`.`company_id`)
AND (`os`.`company_branch_id` = `osd`.`company_branch_id`)
AND (`os`.`fiscal_year_id` = `osd`.`fiscal_year_id`)
AND (`os`.`opening_stock_id` = `osd`.`opening_stock_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `w`
ON (((`w`.`company_id` = `os`.`company_id`)
AND (`w`.`company_branch_id` = `os`.`company_branch_id`)
AND (`w`.`warehouse_id` = `os`.`warehouse_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `osd`.`company_id`)
AND (`p`.`product_id` = `osd`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `osd`.`company_id`)
AND (`u`.`unit_id` = `osd`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))

;





DROP VIEW IF EXISTS `vw_ina_stock_adjustment`

CREATE VIEW `vw_ina_stock_adjustment` AS
SELECT
`sa`.`company_id`           AS `company_id`,
`sa`.`company_branch_id`    AS `company_branch_id`,
`sa`.`fiscal_year_id`       AS `fiscal_year_id`,
`sa`.`stock_adjustment_id`  AS `stock_adjustment_id`,
`sa`.`document_type_id`     AS `document_type_id`,
`sa`.`document_prefix`      AS `document_prefix`,
`sa`.`document_no`          AS `document_no`,
`sa`.`document_identity`    AS `document_identity`,
`sa`.`document_date`        AS `document_date`,
`sa`.`warehouse_id`         AS `warehouse_id`,
`sa`.`remarks`              AS `remarks`,
`sa`.`document_currency_id` AS `document_currency_id`,
`sa`.`total_qty`            AS `total_qty`,
`sa`.`total_amount`         AS `total_amount`,
`sa`.`conversion_rate`      AS `conversion_rate`,
`sa`.`base_currency_id`     AS `base_currency_id`,
`sa`.`base_amount`          AS `base_amount`,
`sa`.`is_post`              AS `is_post`,
`sa`.`post_date`            AS `post_date`,
`sa`.`post_by_id`           AS `post_by_id`,
`sa`.`created_at`           AS `created_at`,
`sa`.`created_by_id`        AS `created_by_id`,
`w`.`name`                  AS `warehouse`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_adjustment` `sa`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `w`
ON (((`w`.`company_id` = `sa`.`company_id`)
AND (`w`.`company_branch_id` = `sa`.`company_branch_id`)
AND (`w`.`warehouse_id` = `sa`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_ina_stock_adjustment_detail`

CREATE VIEW `vw_ina_stock_adjustment_detail` AS
SELECT
`sad`.`company_id`                 AS `company_id`,
`sad`.`company_branch_id`          AS `company_branch_id`,
`sad`.`fiscal_year_id`             AS `fiscal_year_id`,
`sad`.`stock_adjustment_id`        AS `stock_adjustment_id`,
`sad`.`stock_adjustment_detail_id` AS `stock_adjustment_detail_id`,
`sad`.`product_id`                 AS `product_id`,
`sad`.`product_code`               AS `product_code`,
`sad`.`document_currency_id`       AS `document_currency_id`,
`sad`.`unit_id`                    AS `unit_id`,
`sad`.`stock_qty`                  AS `stock_qty`,
`sad`.`qty`                        AS `qty`,
`sad`.`rate`                       AS `rate`,
`sad`.`amount`                     AS `amount`,
`sad`.`base_currency_id`           AS `base_currency_id`,
`sad`.`conversion_rate`            AS `conversion_rate`,
`sad`.`base_rate`                  AS `base_rate`,
`sad`.`base_amount`                AS `base_amount`,
`sad`.`created_at`                 AS `created_at`,
`sad`.`created_by_id`              AS `created_by_id`,
`sa`.`document_type_id`            AS `document_type_id`,
`sa`.`document_identity`           AS `document_identity`,
`sa`.`document_date`               AS `document_date`,
`sa`.`is_post`                     AS `is_post`,
`p`.`product_category_id`          AS `product_category_id`,
`pc`.`name`                        AS `product_category`,
`p`.`name`                         AS `product_name`,
`u`.`name`                         AS `unit`
FROM ((((`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_adjustment_detail` `sad`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_adjustment` `sa`
ON ((`sa`.`stock_adjustment_id` = `sad`.`stock_adjustment_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `sad`.`company_id`)
AND (`p`.`product_id` = `sad`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `sad`.`company_id`)
AND (`u`.`unit_id` = `sad`.`unit_id`))))

;





DROP VIEW IF EXISTS `vw_ina_stock_in`

CREATE VIEW `vw_ina_stock_in` AS
SELECT
`si`.`company_id`           AS `company_id`,
`si`.`company_branch_id`    AS `company_branch_id`,
`si`.`fiscal_year_id`       AS `fiscal_year_id`,
`si`.`stock_in_id`          AS `stock_in_id`,
`si`.`document_type_id`     AS `document_type_id`,
`si`.`document_prefix`      AS `document_prefix`,
`si`.`document_no`          AS `document_no`,
`si`.`document_date`        AS `document_date`,
`si`.`document_identity`    AS `document_identity`,
`si`.`warehouse_id`         AS `warehouse_id`,
`si`.`remarks`              AS `remarks`,
`si`.`document_currency_id` AS `document_currency_id`,
`si`.`total_qty`            AS `total_qty`,
`si`.`total_amount`         AS `total_amount`,
`si`.`base_currency_id`     AS `base_currency_id`,
`si`.`conversion_rate`      AS `conversion_rate`,
`si`.`base_amount`          AS `base_amount`,
`si`.`created_at`           AS `created_at`,
`si`.`created_by_id`        AS `created_by_id`,
`si`.`is_post`              AS `is_post`,
`si`.`post_date`            AS `post_date`,
`si`.`post_by_id`           AS `post_by_id`,
`w`.`name`                  AS `warehouse`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_in` `si`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `w`
ON ((`w`.`warehouse_id` = `si`.`warehouse_id`)))

;





DROP VIEW IF EXISTS `vw_ina_stock_in_detail`

CREATE VIEW `vw_ina_stock_in_detail` AS
SELECT
`sid`.`company_id`           AS `company_id`,
`sid`.`company_branch_id`    AS `company_branch_id`,
`sid`.`fiscal_year_id`       AS `fiscal_year_id`,
`sid`.`stock_in_id`          AS `stock_in_id`,
`sid`.`stock_in_detail_id`   AS `stock_in_detail_id`,
`sid`.`sort_order`           AS `sort_order`,
`sid`.`product_id`           AS `product_id`,
`sid`.`product_code`         AS `product_code`,
`sid`.`document_currency_id` AS `document_currency_id`,
`sid`.`unit_id`              AS `unit_id`,
`sid`.`stock_qty`            AS `stock_qty`,
`sid`.`qty`                  AS `qty`,
`sid`.`cog_rate`             AS `cog_rate`,
`sid`.`cog_amount`           AS `cog_amount`,
`sid`.`base_currency_id`     AS `base_currency_id`,
`sid`.`conversion_rate`      AS `conversion_rate`,
`sid`.`base_cog_rate`        AS `base_cog_rate`,
`sid`.`base_cog_amount`      AS `base_cog_amount`,
`sid`.`created_at`           AS `created_at`,
`sid`.`created_by_id`        AS `created_by_id`,
`p`.`name`                   AS `product_name`,
`u`.`name`                   AS `unit`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_in_detail` `sid`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON ((`p`.`product_id` = `sid`.`product_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON ((`u`.`unit_id` = `sid`.`unit_id`)))

;





DROP VIEW IF EXISTS `vw_ina_stock_out`

CREATE VIEW `vw_ina_stock_out` AS
SELECT
`so`.`company_id`           AS `company_id`,
`so`.`company_branch_id`    AS `company_branch_id`,
`so`.`fiscal_year_id`       AS `fiscal_year_id`,
`so`.`stock_out_id`         AS `stock_out_id`,
`so`.`document_type_id`     AS `document_type_id`,
`so`.`document_prefix`      AS `document_prefix`,
`so`.`document_no`          AS `document_no`,
`so`.`document_date`        AS `document_date`,
`so`.`document_identity`    AS `document_identity`,
`so`.`warehouse_id`         AS `warehouse_id`,
`so`.`remarks`              AS `remarks`,
`so`.`document_currency_id` AS `document_currency_id`,
`so`.`total_qty`            AS `total_qty`,
`so`.`total_amount`         AS `total_amount`,
`so`.`base_currency_id`     AS `base_currency_id`,
`so`.`conversion_rate`      AS `conversion_rate`,
`so`.`base_amount`          AS `base_amount`,
`so`.`created_at`           AS `created_at`,
`so`.`created_by_id`        AS `created_by_id`,
`so`.`is_post`              AS `is_post`,
`so`.`post_date`            AS `post_date`,
`so`.`post_by_id`           AS `post_by_id`,
`w`.`name`                  AS `warehouse`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_out` `so`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `w`
ON ((`w`.`warehouse_id` = `so`.`warehouse_id`)))

;





DROP VIEW IF EXISTS `vw_ina_stock_out_detail`

CREATE VIEW `vw_ina_stock_out_detail` AS
SELECT
`sod`.`company_id`           AS `company_id`,
`sod`.`company_branch_id`    AS `company_branch_id`,
`sod`.`fiscal_year_id`       AS `fiscal_year_id`,
`sod`.`stock_out_id`         AS `stock_out_id`,
`sod`.`stock_out_detail_id`  AS `stock_out_detail_id`,
`sod`.`sort_order`           AS `sort_order`,
`sod`.`product_id`           AS `product_id`,
`sod`.`product_code`         AS `product_code`,
`sod`.`document_currency_id` AS `document_currency_id`,
`sod`.`unit_id`              AS `unit_id`,
`sod`.`stock_qty`            AS `stock_qty`,
`sod`.`qty`                  AS `qty`,
`sod`.`cog_rate`             AS `cog_rate`,
`sod`.`cog_amount`           AS `cog_amount`,
`sod`.`base_currency_id`     AS `base_currency_id`,
`sod`.`conversion_rate`      AS `conversion_rate`,
`sod`.`base_cog_rate`        AS `base_cog_rate`,
`sod`.`base_cog_amount`      AS `base_cog_amount`,
`sod`.`created_at`           AS `created_at`,
`sod`.`created_by_id`        AS `created_by_id`,
`p`.`name`                   AS `product_name`,
`u`.`name`                   AS `unit`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_out_detail` `sod`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON ((`p`.`product_id` = `sod`.`product_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON ((`u`.`unit_id` = `sod`.`unit_id`)))

;





DROP VIEW IF EXISTS `vw_ina_stock_transfer`

CREATE VIEW `vw_ina_stock_transfer` AS
SELECT
`st`.`company_id`           AS `company_id`,
`st`.`company_branch_id`    AS `company_branch_id`,
`st`.`fiscal_year_id`       AS `fiscal_year_id`,
`st`.`stock_transfer_id`    AS `stock_transfer_id`,
`st`.`document_type_id`     AS `document_type_id`,
`st`.`document_prefix`      AS `document_prefix`,
`st`.`document_no`          AS `document_no`,
`st`.`document_date`        AS `document_date`,
`st`.`document_identity`    AS `document_identity`,
`st`.`warehouse_id`         AS `warehouse_id`,
`st`.`remarks`              AS `remarks`,
`st`.`document_currency_id` AS `document_currency_id`,
`st`.`total_qty`            AS `total_qty`,
`st`.`total_amount`         AS `total_amount`,
`st`.`base_currency_id`     AS `base_currency_id`,
`st`.`conversion_rate`      AS `conversion_rate`,
`st`.`base_amount`          AS `base_amount`,
`st`.`created_at`           AS `created_at`,
`st`.`created_by_id`        AS `created_by_id`,
`st`.`is_post`              AS `is_post`,
`st`.`post_date`            AS `post_date`,
`st`.`post_by_id`           AS `post_by_id`,
`w`.`name`                  AS `warehouse`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_transfer` `st`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `w`
ON (((`w`.`company_id` = `st`.`company_id`)
AND (`w`.`company_branch_id` = `st`.`company_branch_id`)
AND (`w`.`warehouse_id` = `st`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_ina_stock_transfer_detail`

CREATE VIEW `vw_ina_stock_transfer_detail` AS
SELECT
`std`.`company_id`               AS `company_id`,
`std`.`company_branch_id`        AS `company_branch_id`,
`std`.`fiscal_year_id`           AS `fiscal_year_id`,
`std`.`stock_transfer_id`        AS `stock_transfer_id`,
`std`.`stock_transfer_detail_id` AS `stock_transfer_detail_id`,
`std`.`sort_order`               AS `sort_order`,
`std`.`product_id`               AS `product_id`,
`std`.`product_code`             AS `product_code`,
`std`.`warehouse_id`             AS `warehouse_id`,
`std`.`document_currency_id`     AS `document_currency_id`,
`std`.`unit_id`                  AS `unit_id`,
`std`.`stock_qty`                AS `stock_qty`,
`std`.`qty`                      AS `qty`,
`std`.`cog_rate`                 AS `cog_rate`,
`std`.`cog_amount`               AS `cog_amount`,
`std`.`base_currency_id`         AS `base_currency_id`,
`std`.`conversion_rate`          AS `conversion_rate`,
`std`.`base_cog_rate`            AS `base_cog_rate`,
`std`.`base_cog_amount`          AS `base_cog_amount`,
`std`.`created_at`               AS `created_at`,
`std`.`created_by_id`            AS `created_by_id`,
`st`.`document_type_id`          AS `document_type_id`,
`st`.`document_identity`         AS `document_identity`,
`st`.`document_date`             AS `document_date`,
`st`.`is_post`                   AS `is_post`,
`p`.`product_category_id`        AS `product_category_id`,
`pc`.`name`                      AS `product_category`,
`p`.`name`                       AS `product_name`,
`u`.`name`                       AS `unit`,
`wh`.`name`                      AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_transfer_detail` `std`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`ina_stock_transfer` `st`
ON ((`st`.`stock_transfer_id` = `std`.`stock_transfer_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `std`.`company_id`)
AND (`p`.`product_id` = `std`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `std`.`company_id`)
AND (`u`.`unit_id` = `std`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `std`.`company_id`)
AND (`wh`.`company_branch_id` = `std`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `std`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_inp_goods_received`

CREATE VIEW `vw_inp_goods_received` AS
SELECT
`gr`.`goods_received_id`     AS `goods_received_id`,
`gr`.`company_id`            AS `company_id`,
`gr`.`company_branch_id`     AS `company_branch_id`,
`gr`.`fiscal_year_id`        AS `fiscal_year_id`,
`gr`.`document_type_id`      AS `document_type_id`,
`gr`.`document_prefix`       AS `document_prefix`,
`gr`.`document_no`           AS `document_no`,
`gr`.`document_identity`     AS `document_identity`,
`gr`.`document_date`         AS `document_date`,
`gr`.`manual_ref_no`         AS `manual_ref_no`,
`gr`.`partner_type_id`       AS `partner_type_id`,
`gr`.`partner_id`            AS `partner_id`,
`gr`.`ref_document_type_id`  AS `ref_document_type_id`,
`gr`.`ref_document_identity` AS `ref_document_identity`,
`gr`.`remarks`               AS `remarks`,
`gr`.`document_currency_id`  AS `document_currency_id`,
`gr`.`net_amount`            AS `net_amount`,
`gr`.`base_currency_id`      AS `base_currency_id`,
`gr`.`conversion_rate`       AS `conversion_rate`,
`gr`.`base_amount`           AS `base_amount`,
`gr`.`is_post`               AS `is_post`,
`gr`.`post_date`             AS `post_date`,
`gr`.`post_by_id`            AS `post_by_id`,
`gr`.`created_at`            AS `created_at`,
`gr`.`created_by_id`         AS `created_by_id`,
`gr`.`modified_at`           AS `modified_at`,
`gr`.`modified_by_id`        AS `modified_by_id`,
`p`.`partner_type`           AS `partner_type`,
`p`.`name`                   AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`inp_goods_received` `gr`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `gr`.`company_id`)
AND (`p`.`company_branch_id` = `gr`.`company_branch_id`)
AND (`p`.`partner_type_id` = `gr`.`partner_type_id`)
AND (`p`.`partner_id` = `gr`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_inp_goods_received_detail`

CREATE VIEW `vw_inp_goods_received_detail` AS
SELECT
`grd`.`goods_received_detail_id` AS `goods_received_detail_id`,
`grd`.`company_id`               AS `company_id`,
`grd`.`company_branch_id`        AS `company_branch_id`,
`grd`.`fiscal_year_id`           AS `fiscal_year_id`,
`grd`.`goods_received_id`        AS `goods_received_id`,
`grd`.`sort_order`               AS `sort_order`,
`grd`.`product_code`             AS `product_code`,
`grd`.`product_id`               AS `product_id`,
`grd`.`unit_id`                  AS `unit_id`,
`grd`.`warehouse_id`             AS `warehouse_id`,
`grd`.`qty`                      AS `qty`,
`grd`.`rate`                     AS `rate`,
`grd`.`amount`                   AS `amount`,
`grd`.`created_at`               AS `created_at`,
`grd`.`created_by_id`            AS `created_by_id`,
`gr`.`document_type_id`          AS `document_type_id`,
`gr`.`document_identity`         AS `document_identity`,
`gr`.`document_date`             AS `document_date`,
`gr`.`is_post`                   AS `is_post`,
`gr`.`partner_type_id`           AS `partner_type_id`,
`gr`.`partner_id`                AS `partner_id`,
`p`.`product_category_id`        AS `product_category_id`,
`pc`.`name`                      AS `product_category`,
`p`.`name`                       AS `product_name`,
`u`.`name`                       AS `unit`,
`wh`.`name`                      AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`inp_goods_received_detail` `grd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`inp_goods_received` `gr`
ON ((`gr`.`goods_received_id` = `grd`.`goods_received_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `grd`.`company_id`)
AND (`p`.`product_id` = `grd`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `grd`.`company_id`)
AND (`u`.`unit_id` = `grd`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `grd`.`company_id`)
AND (`wh`.`company_branch_id` = `grd`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `grd`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_inp_purchase_invoice`

CREATE VIEW `vw_inp_purchase_invoice` AS
SELECT
`pi`.`company_id`           AS `company_id`,
`pi`.`company_branch_id`    AS `company_branch_id`,
`pi`.`fiscal_year_id`       AS `fiscal_year_id`,
`pi`.`purchase_invoice_id`  AS `purchase_invoice_id`,
`pi`.`document_type_id`     AS `document_type_id`,
`pi`.`document_prefix`      AS `document_prefix`,
`pi`.`document_no`          AS `document_no`,
`pi`.`document_identity`    AS `document_identity`,
`pi`.`document_date`        AS `document_date`,
`pi`.`batch_no`             AS `batch_no`,
`pi`.`partner_type_id`      AS `partner_type_id`,
`pi`.`partner_id`           AS `partner_id`,
`pi`.`manual_ref_no`        AS `manual_ref_no`,
`pi`.`builty_no`            AS `builty_no`,
`pi`.`remarks`              AS `remarks`,
`pi`.`remarks2`             AS `remarks2`,
`pi`.`document_currency_id` AS `document_currency_id`,
`pi`.`item_amount`          AS `item_amount`,
`pi`.`item_discount`        AS `item_discount`,
`pi`.`item_tax`             AS `item_tax`,
`pi`.`item_other_expence`   AS `item_other_expence`,
`pi`.`item_total`           AS `item_total`,
`pi`.`discount`             AS `discount`,
`pi`.`net_amount`           AS `net_amount`,
`pi`.`cash_paid`            AS `cash_paid`,
`pi`.`balance_amount`       AS `balance_amount`,
`pi`.`base_currency_id`     AS `base_currency_id`,
`pi`.`conversion_rate`      AS `conversion_rate`,
`pi`.`base_amount`          AS `base_amount`,
`pi`.`base_cash_received`   AS `base_cash_received`,
`pi`.`base_balance_amount`  AS `base_balance_amount`,
`pi`.`is_post`              AS `is_post`,
`pi`.`post_date`            AS `post_date`,
`pi`.`post_by_id`           AS `post_by_id`,
`pi`.`created_at`           AS `created_at`,
`pi`.`created_by_id`        AS `created_by_id`,
`pi`.`modified_at`          AS `modified_at`,
`pi`.`modified_by_id`       AS `modified_by_id`,
`p`.`partner_type`          AS `partner_type`,
`p`.`name`                  AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_invoice` `pi`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `pi`.`company_id`)
AND (`p`.`company_branch_id` = `pi`.`company_branch_id`)
AND (`p`.`partner_type_id` = `pi`.`partner_type_id`)
AND (`p`.`partner_id` = `pi`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_inp_purchase_invoice_detail`

CREATE VIEW `vw_inp_purchase_invoice_detail` AS
SELECT
`pid`.`company_id`                 AS `company_id`,
`pid`.`company_branch_id`          AS `company_branch_id`,
`pid`.`fiscal_year_id`             AS `fiscal_year_id`,
`pid`.`purchase_invoice_id`        AS `purchase_invoice_id`,
`pid`.`purchase_invoice_detail_id` AS `purchase_invoice_detail_id`,
`pid`.`sort_order`                 AS `sort_order`,
`pid`.`ref_document_type_id`       AS `ref_document_type_id`,
`pid`.`ref_document_identity`      AS `ref_document_identity`,
`pid`.`product_id`                 AS `product_id`,
`pid`.`product_code`               AS `product_code`,
`pid`.`warehouse_id`               AS `warehouse_id`,
`pid`.`remarks`                    AS `remarks`,
`pid`.`document_currency_id`       AS `document_currency_id`,
`pid`.`unit_id`                    AS `unit_id`,
`pid`.`qty`                        AS `qty`,
`pid`.`rate`                       AS `rate`,
`pid`.`amount`                     AS `amount`,
`pid`.`discount_percent`           AS `discount_percent`,
`pid`.`discount_amount`            AS `discount_amount`,
`pid`.`gross_amount`               AS `gross_amount`,
`pid`.`other_expence`              AS `other_expence`,
`pid`.`tax_percent`                AS `tax_percent`,
`pid`.`tax_amount`                 AS `tax_amount`,
`pid`.`total_amount`               AS `total_amount`,
`pid`.`base_currency_id`           AS `base_currency_id`,
`pid`.`conversion_rate`            AS `conversion_rate`,
`pid`.`base_total`                 AS `base_total`,
`pid`.`created_at`                 AS `created_at`,
`pid`.`created_by_id`              AS `created_by_id`,
`pi`.`document_type_id`            AS `document_type_id`,
`pi`.`document_identity`           AS `document_identity`,
`pi`.`document_date`               AS `document_date`,
`pi`.`is_post`                     AS `is_post`,
`pi`.`partner_type_id`             AS `partner_type_id`,
`pi`.`partner_id`                  AS `partner_id`,
`p`.`product_category_id`          AS `product_category_id`,
`pc`.`name`                        AS `product_category`,
`p`.`name`                         AS `product_name`,
`u`.`name`                         AS `unit`,
`wh`.`name`                        AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_invoice_detail` `pid`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_invoice` `pi`
ON ((`pi`.`purchase_invoice_id` = `pid`.`purchase_invoice_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `pid`.`company_id`)
AND (`p`.`product_id` = `pid`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `pid`.`company_id`)
AND (`u`.`unit_id` = `pid`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `pid`.`company_id`)
AND (`wh`.`company_branch_id` = `pid`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `pid`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_inp_purchase_order`

CREATE VIEW `vw_inp_purchase_order` AS
SELECT
`po`.`purchase_order_id`     AS `purchase_order_id`,
`po`.`fiscal_year_id`        AS `fiscal_year_id`,
`po`.`company_id`            AS `company_id`,
`po`.`company_branch_id`     AS `company_branch_id`,
`po`.`document_type_id`      AS `document_type_id`,
`po`.`document_prefix`       AS `document_prefix`,
`po`.`document_no`           AS `document_no`,
`po`.`document_date`         AS `document_date`,
`po`.`document_identity`     AS `document_identity`,
`po`.`batch_no`              AS `batch_no`,
`po`.`partner_type_id`       AS `partner_type_id`,
`po`.`partner_id`            AS `partner_id`,
`po`.`ref_document_type_id`  AS `ref_document_type_id`,
`po`.`ref_document_identity` AS `ref_document_identity`,
`po`.`remarks`               AS `remarks`,
`po`.`manual_ref_no`         AS `manual_ref_no`,
`po`.`terms`                 AS `terms`,
`po`.`document_currency_id`  AS `document_currency_id`,
`po`.`base_currency_id`      AS `base_currency_id`,
`po`.`conversion_rate`       AS `conversion_rate`,
`po`.`total_amount`          AS `total_amount`,
`po`.`discount`              AS `discount`,
`po`.`net_amount`            AS `net_amount`,
`po`.`base_amount`           AS `base_amount`,
`po`.`created_at`            AS `created_at`,
`po`.`created_by_id`         AS `created_by_id`,
`po`.`is_post`               AS `is_post`,
`po`.`post_date`             AS `post_date`,
`po`.`post_by_id`            AS `post_by_id`,
`p`.`partner_type`           AS `partner_type`,
`p`.`name`                   AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_order` `po`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `po`.`company_id`)
AND (`p`.`company_branch_id` = `po`.`company_branch_id`)
AND (`p`.`partner_type_id` = `po`.`partner_type_id`)
AND (`p`.`partner_id` = `po`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_inp_purchase_order_detail`

CREATE VIEW `vw_inp_purchase_order_detail` AS
SELECT
`pod`.`company_id`               AS `company_id`,
`pod`.`company_branch_id`        AS `company_branch_id`,
`pod`.`fiscal_year_id`           AS `fiscal_year_id`,
`pod`.`purchase_order_id`        AS `purchase_order_id`,
`pod`.`purchase_order_detail_id` AS `purchase_order_detail_id`,
`pod`.`ref_document_type_id`     AS `ref_document_type_id`,
`pod`.`ref_document_identity`    AS `ref_document_identity`,
`pod`.`sort_order`               AS `sort_order`,
`pod`.`product_id`               AS `product_id`,
`pod`.`product_code`             AS `product_code`,
`pod`.`product_service`          AS `product_service`,
`pod`.`expiry_date`              AS `expiry_date`,
`pod`.`document_currency_id`     AS `document_currency_id`,
`pod`.`unit_id`                  AS `unit_id`,
`pod`.`qty`                      AS `qty`,
`pod`.`conversion_rate`          AS `conversion_rate`,
`pod`.`base_amount`              AS `base_amount`,
`pod`.`rate`                     AS `rate`,
`pod`.`amount`                   AS `amount`,
`pod`.`base_currency_id`         AS `base_currency_id`,
`pod`.`created_at`               AS `created_at`,
`pod`.`created_by_id`            AS `created_by_id`,
`po`.`document_type_id`          AS `document_type_id`,
`po`.`document_identity`         AS `document_identity`,
`po`.`document_date`             AS `document_date`,
`po`.`is_post`                   AS `is_post`,
`po`.`partner_type_id`           AS `partner_type_id`,
`po`.`partner_id`                AS `partner_id`,
`p`.`product_category_id`        AS `product_category_id`,
`pc`.`name`                      AS `product_category`,
`p`.`name`                       AS `product_name`,
`u`.`name`                       AS `unit`
FROM ((((`fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_order_detail` `pod`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_order` `po`
ON ((`po`.`purchase_order_id` = `pod`.`purchase_order_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `pod`.`company_id`)
AND (`p`.`product_id` = `pod`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `pod`.`company_id`)
AND (`u`.`unit_id` = `pod`.`unit_id`))))

;





DROP VIEW IF EXISTS `vw_inp_purchase_return`

CREATE VIEW `vw_inp_purchase_return` AS
SELECT
`pr`.`company_id`            AS `company_id`,
`pr`.`company_branch_id`     AS `company_branch_id`,
`pr`.`fiscal_year_id`        AS `fiscal_year_id`,
`pr`.`purchase_return_id`    AS `purchase_return_id`,
`pr`.`document_type_id`      AS `document_type_id`,
`pr`.`document_prefix`       AS `document_prefix`,
`pr`.`document_no`           AS `document_no`,
`pr`.`document_date`         AS `document_date`,
`pr`.`document_identity`     AS `document_identity`,
`pr`.`partner_type_id`       AS `partner_type_id`,
`pr`.`partner_id`            AS `partner_id`,
`pr`.`ref_document_type_id`  AS `ref_document_type_id`,
`pr`.`ref_document_identity` AS `ref_document_identity`,
`pr`.`remarks`               AS `remarks`,
`pr`.`remarks2`              AS `remarks2`,
`pr`.`document_currency_id`  AS `document_currency_id`,
`pr`.`item_amount`           AS `item_amount`,
`pr`.`item_discount`         AS `item_discount`,
`pr`.`item_tax`              AS `item_tax`,
`pr`.`item_other_expence`    AS `item_other_expence`,
`pr`.`item_total`            AS `item_total`,
`pr`.`deduction_amount`      AS `deduction_amount`,
`pr`.`net_amount`            AS `net_amount`,
`pr`.`cash_received`         AS `cash_received`,
`pr`.`balance_amount`        AS `balance_amount`,
`pr`.`base_currency_id`      AS `base_currency_id`,
`pr`.`conversion_rate`       AS `conversion_rate`,
`pr`.`base_amount`           AS `base_amount`,
`pr`.`base_cash_received`    AS `base_cash_received`,
`pr`.`base_balanace_amount`  AS `base_balanace_amount`,
`pr`.`is_post`               AS `is_post`,
`pr`.`post_date`             AS `post_date`,
`pr`.`created_at`            AS `created_at`,
`pr`.`created_by_id`         AS `created_by_id`,
`p`.`partner_type`           AS `partner_type`,
`p`.`name`                   AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_return` `pr`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `pr`.`company_id`)
AND (`p`.`company_branch_id` = `pr`.`company_branch_id`)
AND (`p`.`partner_type_id` = `pr`.`partner_type_id`)
AND (`p`.`partner_id` = `pr`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_inp_purchase_return_detail`

CREATE VIEW `vw_inp_purchase_return_detail` AS
SELECT
`prd`.`company_id`                AS `company_id`,
`prd`.`company_branch_id`         AS `company_branch_id`,
`prd`.`fiscal_year_id`            AS `fiscal_year_id`,
`prd`.`purchase_return_id`        AS `purchase_return_id`,
`prd`.`purchase_return_detail_id` AS `purchase_return_detail_id`,
`prd`.`sort_order`                AS `sort_order`,
`prd`.`ref_document_type_id`      AS `ref_document_type_id`,
`prd`.`ref_document_identity`     AS `ref_document_identity`,
`prd`.`product_id`                AS `product_id`,
`prd`.`product_code`              AS `product_code`,
`prd`.`warehouse_id`              AS `warehouse_id`,
`prd`.`document_currency_id`      AS `document_currency_id`,
`prd`.`unit_id`                   AS `unit_id`,
`prd`.`qty`                       AS `qty`,
`prd`.`rate`                      AS `rate`,
`prd`.`amount`                    AS `amount`,
`prd`.`discount_percent`          AS `discount_percent`,
`prd`.`discount_amount`           AS `discount_amount`,
`prd`.`gross_amount`              AS `gross_amount`,
`prd`.`other_expence`             AS `other_expence`,
`prd`.`tax_percent`               AS `tax_percent`,
`prd`.`tax_amount`                AS `tax_amount`,
`prd`.`total_amount`              AS `total_amount`,
`prd`.`base_currency_id`          AS `base_currency_id`,
`prd`.`conversion_rate`           AS `conversion_rate`,
`prd`.`base_total`                AS `base_total`,
`prd`.`created_at`                AS `created_at`,
`prd`.`created_by_id`             AS `created_by_id`,
`pr`.`document_type_id`           AS `document_type_id`,
`pr`.`document_identity`          AS `document_identity`,
`pr`.`document_date`              AS `document_date`,
`pr`.`is_post`                    AS `is_post`,
`pr`.`partner_type_id`            AS `partner_type_id`,
`pr`.`partner_id`                 AS `partner_id`,
`p`.`product_category_id`         AS `product_category_id`,
`pc`.`name`                       AS `product_category`,
`p`.`name`                        AS `product_name`,
`u`.`name`                        AS `unit`,
`wh`.`name`                       AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_return_detail` `prd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`inp_purchase_return` `pr`
ON ((`pr`.`purchase_return_id` = `prd`.`purchase_return_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `prd`.`company_id`)
AND (`p`.`product_id` = `prd`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `prd`.`company_id`)
AND (`u`.`unit_id` = `prd`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `prd`.`company_id`)
AND (`wh`.`company_branch_id` = `prd`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `prd`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_ins_delivery_challan`

CREATE VIEW `vw_ins_delivery_challan` AS
SELECT
`dc`.`delivery_challan_id`   AS `delivery_challan_id`,
`dc`.`company_id`            AS `company_id`,
`dc`.`company_branch_id`     AS `company_branch_id`,
`dc`.`fiscal_year_id`        AS `fiscal_year_id`,
`dc`.`document_type_id`      AS `document_type_id`,
`dc`.`document_prefix`       AS `document_prefix`,
`dc`.`document_no`           AS `document_no`,
`dc`.`document_identity`     AS `document_identity`,
`dc`.`document_date`         AS `document_date`,
`dc`.`manual_ref_no`         AS `manual_ref_no`,
`dc`.`partner_type_id`       AS `partner_type_id`,
`dc`.`partner_id`            AS `partner_id`,
`dc`.`ref_document_type_id`  AS `ref_document_type_id`,
`dc`.`ref_document_identity` AS `ref_document_identity`,
`dc`.`remarks`               AS `remarks`,
`dc`.`document_currency_id`  AS `document_currency_id`,
`dc`.`total_qty`             AS `total_qty`,
`dc`.`total_amount`          AS `total_amount`,
`dc`.`base_currency_id`      AS `base_currency_id`,
`dc`.`conversion_rate`       AS `conversion_rate`,
`dc`.`base_amount`           AS `base_amount`,
`dc`.`is_post`               AS `is_post`,
`dc`.`post_date`             AS `post_date`,
`dc`.`post_by_id`            AS `post_by_id`,
`dc`.`created_at`            AS `created_at`,
`dc`.`created_by_id`         AS `created_by_id`,
`dc`.`modified_at`           AS `modified_at`,
`dc`.`modified_by_id`        AS `modified_by_id`,
`p`.`partner_type`           AS `partner_type`,
`p`.`name`                   AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ins_delivery_challan` `dc`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `dc`.`company_id`)
AND (`p`.`company_branch_id` = `dc`.`company_branch_id`)
AND (`p`.`partner_type_id` = `dc`.`partner_type_id`)
AND (`p`.`partner_id` = `dc`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_ins_delivery_challan_detail`

CREATE VIEW `vw_ins_delivery_challan_detail` AS
SELECT
`dcd`.`delivery_challan_detail_id` AS `delivery_challan_detail_id`,
`dcd`.`company_id`                 AS `company_id`,
`dcd`.`company_branch_id`          AS `company_branch_id`,
`dcd`.`fiscal_year_id`             AS `fiscal_year_id`,
`dcd`.`delivery_challan_id`        AS `delivery_challan_id`,
`dcd`.`product_id`                 AS `product_id`,
`dcd`.`product_code`               AS `product_code`,
`dcd`.`unit_id`                    AS `unit_id`,
`dcd`.`warehouse_id`               AS `warehouse_id`,
`dcd`.`stock_qty`                  AS `stock_qty`,
`dcd`.`qty`                        AS `qty`,
`dcd`.`document_currency_id`       AS `document_currency_id`,
`dcd`.`cog_rate`                   AS `cog_rate`,
`dcd`.`cog_amount`                 AS `cog_amount`,
`dcd`.`base_currency_id`           AS `base_currency_id`,
`dcd`.`conversion_rate`            AS `conversion_rate`,
`dcd`.`base_cog_rate`              AS `base_cog_rate`,
`dcd`.`base_cog_amount`            AS `base_cog_amount`,
`dcd`.`created_by_id`              AS `created_by_id`,
`dcd`.`created_at`                 AS `created_at`,
`dc`.`document_type_id`            AS `document_type_id`,
`dc`.`document_identity`           AS `document_identity`,
`dc`.`document_date`               AS `document_date`,
`dc`.`is_post`                     AS `is_post`,
`dc`.`partner_type_id`             AS `partner_type_id`,
`dc`.`partner_id`                  AS `partner_id`,
`p`.`product_category_id`          AS `product_category_id`,
`pc`.`name`                        AS `product_category`,
`p`.`name`                         AS `product_name`,
`u`.`name`                         AS `unit`,
`wh`.`name`                        AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`ins_delivery_challan_detail` `dcd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`ins_delivery_challan` `dc`
ON ((`dc`.`delivery_challan_id` = `dcd`.`delivery_challan_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `dcd`.`company_id`)
AND (`p`.`product_id` = `dcd`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `dcd`.`company_id`)
AND (`u`.`unit_id` = `dcd`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `dcd`.`company_id`)
AND (`wh`.`company_branch_id` = `dcd`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `dcd`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_ins_sale_invoice`

CREATE VIEW `vw_ins_sale_invoice` AS
SELECT
`si`.`company_id`           AS `company_id`,
`si`.`company_branch_id`    AS `company_branch_id`,
`si`.`fiscal_year_id`       AS `fiscal_year_id`,
`si`.`sale_invoice_id`      AS `sale_invoice_id`,
`si`.`document_type_id`     AS `document_type_id`,
`si`.`document_prefix`      AS `document_prefix`,
`si`.`document_no`          AS `document_no`,
`si`.`document_date`        AS `document_date`,
`si`.`document_identity`    AS `document_identity`,
`si`.`partner_type_id`      AS `partner_type_id`,
`si`.`partner_id`           AS `partner_id`,
`si`.`ref_invoice_no`       AS `ref_invoice_no`,
`si`.`billty_date`          AS `billty_date`,
`si`.`billty_no`            AS `billty_no`,
`si`.`manual_ref_no`        AS `manual_ref_no`,
`si`.`remarks`              AS `remarks`,
`si`.`remarks2`             AS `remarks2`,
`si`.`document_currency_id` AS `document_currency_id`,
`si`.`item_amount`          AS `item_amount`,
`si`.`item_discount`        AS `item_discount`,
`si`.`item_tax`             AS `item_tax`,
`si`.`item_other_expence`   AS `item_other_expence`,
`si`.`item_total`           AS `item_total`,
`si`.`cartage_charges`      AS `cartage_charges`,
`si`.`discount`             AS `discount`,
`si`.`net_amount`           AS `net_amount`,
`si`.`cash_received`        AS `cash_received`,
`si`.`balance_amount`       AS `balance_amount`,
`si`.`base_currency_id`     AS `base_currency_id`,
`si`.`conversion_rate`      AS `conversion_rate`,
`si`.`base_net_amount`      AS `base_net_amount`,
`si`.`is_post`              AS `is_post`,
`si`.`post_date`            AS `post_date`,
`si`.`post_by_id`           AS `post_by_id`,
`si`.`created_at`           AS `created_at`,
`si`.`created_by_id`        AS `created_by_id`,
`p`.`partner_type`          AS `partner_type`,
`p`.`name`                  AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ins_sale_invoice` `si`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `si`.`company_id`)
AND (`p`.`company_branch_id` = `si`.`company_branch_id`)
AND (`p`.`partner_type_id` = `si`.`partner_type_id`)
AND (`p`.`partner_id` = `si`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_ins_sale_invoice_detail`

CREATE VIEW `vw_ins_sale_invoice_detail` AS
SELECT
`sid`.`company_id`             AS `company_id`,
`sid`.`company_branch_id`      AS `company_branch_id`,
`sid`.`fiscal_year_id`         AS `fiscal_year_id`,
`sid`.`sale_invoice_id`        AS `sale_invoice_id`,
`sid`.`sale_invoice_detail_id` AS `sale_invoice_detail_id`,
`sid`.`sort_order`             AS `sort_order`,
`sid`.`batch_no`               AS `batch_no`,
`sid`.`warehouse_id`           AS `warehouse_id`,
`sid`.`product_id`             AS `product_id`,
`sid`.`product_code`           AS `product_code`,
`sid`.`ref_document_type_id`   AS `ref_document_type_id`,
`sid`.`ref_document_identity`  AS `ref_document_identity`,
`sid`.`expiry_date`            AS `expiry_date`,
`sid`.`documrnt_curency_id`    AS `documrnt_curency_id`,
`sid`.`unit_id`                AS `unit_id`,
`sid`.`qty`                    AS `qty`,
`sid`.`rate`                   AS `rate`,
`sid`.`amount`                 AS `amount`,
`sid`.`discount_percent`       AS `discount_percent`,
`sid`.`discount_amount`        AS `discount_amount`,
`sid`.`gross_amount`           AS `gross_amount`,
`sid`.`other_expence`          AS `other_expence`,
`sid`.`tax_percent`            AS `tax_percent`,
`sid`.`tax_amount`             AS `tax_amount`,
`sid`.`total_amount`           AS `total_amount`,
`sid`.`base_currency_id`       AS `base_currency_id`,
`sid`.`conversion_rate`        AS `conversion_rate`,
`sid`.`base_total`             AS `base_total`,
`sid`.`remarks`                AS `remarks`,
`sid`.`cog_rate`               AS `cog_rate`,
`sid`.`cog_amount`             AS `cog_amount`,
`sid`.`created_at`             AS `created_at`,
`sid`.`created_by_id`          AS `created_by_id`,
`si`.`document_type_id`        AS `document_type_id`,
`si`.`document_identity`       AS `document_identity`,
`si`.`document_date`           AS `document_date`,
`si`.`is_post`                 AS `is_post`,
`si`.`partner_type_id`         AS `partner_type_id`,
`si`.`partner_id`              AS `partner_id`,
`p`.`product_category_id`      AS `product_category_id`,
`pc`.`name`                    AS `product_category`,
`p`.`name`                     AS `product_name`,
`u`.`name`                     AS `unit`,
`wh`.`name`                    AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`ins_sale_invoice_detail` `sid`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`ins_sale_invoice` `si`
ON ((`si`.`sale_invoice_id` = `sid`.`sale_invoice_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `sid`.`company_id`)
AND (`p`.`product_id` = `sid`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `sid`.`company_id`)
AND (`u`.`unit_id` = `sid`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `sid`.`company_id`)
AND (`wh`.`company_branch_id` = `sid`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `sid`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_ins_sale_return`

CREATE VIEW `vw_ins_sale_return` AS
SELECT
`sr`.`company_id`           AS `company_id`,
`sr`.`company_branch_id`    AS `company_branch_id`,
`sr`.`fiscal_year_id`       AS `fiscal_year_id`,
`sr`.`sale_return_id`       AS `sale_return_id`,
`sr`.`document_type_id`     AS `document_type_id`,
`sr`.`document_prefix`      AS `document_prefix`,
`sr`.`document_no`          AS `document_no`,
`sr`.`document_date`        AS `document_date`,
`sr`.`document_identity`    AS `document_identity`,
`sr`.`partner_type_id`      AS `partner_type_id`,
`sr`.`partner_id`           AS `partner_id`,
`sr`.`ref_invoice_no`       AS `ref_invoice_no`,
`sr`.`billty_date`          AS `billty_date`,
`sr`.`billty_no`            AS `billty_no`,
`sr`.`manual_ref_no`        AS `manual_ref_no`,
`sr`.`remarks`              AS `remarks`,
`sr`.`remarks2`             AS `remarks2`,
`sr`.`document_currency_id` AS `document_currency_id`,
`sr`.`item_amount`          AS `item_amount`,
`sr`.`item_discount`        AS `item_discount`,
`sr`.`item_tax`             AS `item_tax`,
`sr`.`item_other_expence`   AS `item_other_expence`,
`sr`.`item_total`           AS `item_total`,
`sr`.`cartage_charges`      AS `cartage_charges`,
`sr`.`deduction_amount`     AS `deduction_amount`,
`sr`.`net_amount`           AS `net_amount`,
`sr`.`cash_returned`        AS `cash_returned`,
`sr`.`balance_amount`       AS `balance_amount`,
`sr`.`base_currency_id`     AS `base_currency_id`,
`sr`.`conversion_rate`      AS `conversion_rate`,
`sr`.`base_net_amount`      AS `base_net_amount`,
`sr`.`is_post`              AS `is_post`,
`sr`.`post_date`            AS `post_date`,
`sr`.`post_by_id`           AS `post_by_id`,
`sr`.`created_at`           AS `created_at`,
`sr`.`created_by_id`        AS `created_by_id`,
`p`.`partner_type`          AS `partner_type`,
`p`.`name`                  AS `partner_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`ins_sale_return` `sr`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`core_partner` `p`
ON (((`p`.`company_id` = `sr`.`company_id`)
AND (`p`.`company_branch_id` = `sr`.`company_branch_id`)
AND (`p`.`partner_type_id` = `sr`.`partner_type_id`)
AND (`p`.`partner_id` = `sr`.`partner_id`))))

;





DROP VIEW IF EXISTS `vw_ins_sale_return_detail`

CREATE VIEW `vw_ins_sale_return_detail` AS
SELECT
`srd`.`company_id`            AS `company_id`,
`srd`.`company_branch_id`     AS `company_branch_id`,
`srd`.`fiscal_year_id`        AS `fiscal_year_id`,
`srd`.`sale_return_id`        AS `sale_return_id`,
`srd`.`sale_return_detail_id` AS `sale_return_detail_id`,
`srd`.`sort_order`            AS `sort_order`,
`srd`.`batch_no`              AS `batch_no`,
`srd`.`warehouse_id`          AS `warehouse_id`,
`srd`.`product_id`            AS `product_id`,
`srd`.`product_code`          AS `product_code`,
`srd`.`ref_document_type_id`  AS `ref_document_type_id`,
`srd`.`ref_document_identity` AS `ref_document_identity`,
`srd`.`expiry_date`           AS `expiry_date`,
`srd`.`documrnt_curency_id`   AS `documrnt_curency_id`,
`srd`.`unit_id`               AS `unit_id`,
`srd`.`qty`                   AS `qty`,
`srd`.`rate`                  AS `rate`,
`srd`.`amount`                AS `amount`,
`srd`.`discount_percent`      AS `discount_percent`,
`srd`.`discount_amount`       AS `discount_amount`,
`srd`.`gross_amount`          AS `gross_amount`,
`srd`.`other_expence`         AS `other_expence`,
`srd`.`tax_percent`           AS `tax_percent`,
`srd`.`tax_amount`            AS `tax_amount`,
`srd`.`total_amount`          AS `total_amount`,
`srd`.`base_currency_id`      AS `base_currency_id`,
`srd`.`conversion_rate`       AS `conversion_rate`,
`srd`.`base_total`            AS `base_total`,
`srd`.`remarks`               AS `remarks`,
`srd`.`cog_rate`              AS `cog_rate`,
`srd`.`cog_amount`            AS `cog_amount`,
`srd`.`created_at`            AS `created_at`,
`srd`.`created_by_id`         AS `created_by_id`,
`sr`.`document_type_id`       AS `document_type_id`,
`sr`.`document_identity`      AS `document_identity`,
`sr`.`document_date`          AS `document_date`,
`sr`.`is_post`                AS `is_post`,
`sr`.`partner_type_id`        AS `partner_type_id`,
`sr`.`partner_id`             AS `partner_id`,
`p`.`product_category_id`     AS `product_category_id`,
`pc`.`name`                   AS `product_category`,
`p`.`name`                    AS `product_name`,
`u`.`name`                    AS `unit`,
`wh`.`name`                   AS `warehouse`
FROM (((((`fayzehus_bharmals_bsuite_fh_1819`.`ins_sale_return_detail` `srd`
JOIN `fayzehus_bharmals_bsuite_fh_1819`.`ins_sale_return` `sr`
ON ((`sr`.`sale_return_id` = `srd`.`sale_return_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product` `p`
ON (((`p`.`company_id` = `srd`.`company_id`)
AND (`p`.`product_id` = `srd`.`product_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_product_category` `pc`
ON (((`pc`.`company_id` = `p`.`company_id`)
AND (`pc`.`product_category_id` = `p`.`product_category_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_unit` `u`
ON (((`u`.`company_id` = `srd`.`company_id`)
AND (`u`.`unit_id` = `srd`.`unit_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`in0_warehouse` `wh`
ON (((`wh`.`company_id` = `srd`.`company_id`)
AND (`wh`.`company_branch_id` = `srd`.`company_branch_id`)
AND (`wh`.`warehouse_id` = `srd`.`warehouse_id`))))

;





DROP VIEW IF EXISTS `vw_qh_applicant`

CREATE VIEW `vw_qh_applicant` AS
SELECT
`app`.`applicant_id`          AS `applicant_id`,
`app`.`its_no`                AS `its_no`,
`app`.`occupation`            AS `occupation`,
`app`.`title_and_name`        AS `title_and_name`,
`app`.`surname`               AS `surname`,
`app`.`income`                AS `income`,
`app`.`mobile_no`             AS `mobile_no`,
`app`.`tel_no`                AS `tel_no`,
`app`.`email_id`              AS `email_id`,
`app`.`residential_address`   AS `residential_address`,
`app`.`business_address`      AS `business_address`,
`app`.`receivable_account_id` AS `receivable_account_id`,
`app`.`created_at`            AS `created_at`,
`app`.`created_by_id`         AS `created_by_id`,
`app`.`company_id`            AS `company_id`
FROM `fayzehus_bharmals_bsuite_fh_1819`.`qh_applicant` `app`

;





DROP VIEW IF EXISTS `vw_qh_installment_schedule`

CREATE VIEW `vw_qh_installment_schedule` AS
SELECT DISTINCT
`ins`.`installment_schedule_id` AS `installment_schedule_id`,
`ins`.`its_no`                  AS `its_no`,
`ins`.`customer_name`           AS `customer_name`,
`ins`.`project_id`              AS `project_id`,
`ins`.`sub_project_id`          AS `sub_project_id`,
`ins`.`total_amount`            AS `total_amount`,
`ins`.`no_of_payments`          AS `no_of_payments`,
`ins`.`payment_start_from`      AS `payment_start_from`,
`ins`.`reminder_day`            AS `reminder_day`,
`ins`.`created_at`              AS `created_at`,
`ins`.`created_by_id`           AS `created_by_id`,
`ins`.`company_id`              AS `company_id`,
`sp`.`project_name`             AS `project_name`,
`sp`.`name`                     AS `sub_project_name`
FROM ((`fayzehus_bharmals_bsuite_fh_1819`.`qh_installment_schedule` `ins`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `ins`.`project_id`)
AND (`sp`.`sub_project_id` = `ins`.`sub_project_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_request` `qhr`
ON ((`qhr`.`its_no` = `qhr`.`its_no`)))

;





DROP VIEW IF EXISTS `vw_qh_installment_schedule_detail`

CREATE VIEW `vw_qh_installment_schedule_detail` AS
SELECT DISTINCT
`insd`.`installment_schedule_detail_id` AS `installment_schedule_detail_id`,
`insd`.`installment_schedule_id`        AS `installment_schedule_id`,
`insd`.`cheque_no`                      AS `cheque_no`,
`insd`.`due_date`                       AS `due_date`,
`insd`.`reminder_date`                  AS `reminder_date`,
`insd`.`cheque_amount`                  AS `cheque_amount`,
`insd`.`cheque_status`                  AS `cheque_status`,
`insd`.`sort_order`                     AS `sort_order`,
`insd`.`created_by_id`                  AS `created_by_id`
FROM `fayzehus_bharmals_bsuite_fh_1819`.`qh_installment_schedule_detail` `insd`

;





DROP VIEW IF EXISTS `vw_qh_qarze_hassana_deposit_slip`

CREATE VIEW `vw_qh_qarze_hassana_deposit_slip` AS
SELECT DISTINCT
`qhds`.`qarze_hassana_deposit_slip_id` AS `qarze_hassana_deposit_slip_id`,
`qhds`.`company_id`                    AS `company_id`,
`qhds`.`fiscal_year_id`                AS `fiscal_year_id`,
`qhds`.`document_type_id`              AS `document_type_id`,
`qhds`.`document_prefix`               AS `document_prefix`,
`qhds`.`document_no`                   AS `document_no`,
`qhds`.`document_identity`             AS `document_identity`,
`qhds`.`document_date`                 AS `document_date`,
`qhds`.`cheque_date`                   AS `cheque_date`,
`qhds`.`bank_account_id`               AS `bank_account_id`,
`qhds`.`deposit_slip_no`               AS `deposit_slip_no`,
`qhds`.`remarks`                       AS `remarks`,
`qhds`.`created_at`                    AS `created_at`,
`qhds`.`created_by_id`                 AS `created_by_id`
FROM `fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_deposit_slip` `qhds`

;





DROP VIEW IF EXISTS `vw_qh_qarze_hassana_deposit_slip_detail`

CREATE VIEW `vw_qh_qarze_hassana_deposit_slip_detail` AS
SELECT DISTINCT
`qrdsd`.`qarze_hassana_deposit_slip_detail_id` AS `qarze_hassana_deposit_slip_detail_id`,
`qrdsd`.`qarze_hassana_deposit_slip_id`        AS `qarze_hassana_deposit_slip_id`,
`qrdsd`.`chk_payment`                          AS `chk_payment`,
`qrdsd`.`its_no`                               AS `its_no`,
`qrdsd`.`cheque_date`                          AS `cheque_date`,
`qrdsd`.`cheque_no`                            AS `cheque_no`,
`qrdsd`.`cheque_amount`                        AS `cheque_amount`,
`qrdsd`.`cheque_status`                        AS `cheque_status`,
`qrdsd`.`project_id`                           AS `project_id`,
`qrdsd`.`sub_project_id`                       AS `sub_project_id`,
`qrdsd`.`coa_id`                               AS `coa_id`,
`qrdsd`.`applicant_id`                         AS `applicant_id`,
`qrdsd`.`installment_schedule_detail_id`       AS `installment_schedule_detail_id`,
`qrdsd`.`created_by`                           AS `created_by`,
`qrdsd`.`created_at`                           AS `created_at`,
`sp`.`project_name`                            AS `project_name`,
`sp`.`name`                                    AS `sub_project_name`,
`level3`.`name`                                AS `coa_name`,
`app`.`title_and_name`                         AS `title_and_name`
FROM ((((`fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_deposit_slip_detail` `qrdsd`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `qrdsd`.`project_id`)
AND (`sp`.`sub_project_id` = `qrdsd`.`sub_project_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_request` `qhr`
ON ((`qhr`.`its_no` = `qrdsd`.`its_no`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`qh_applicant` `app`
ON ((`app`.`applicant_id` = `qrdsd`.`applicant_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `level3`
ON ((`level3`.`coa_level3_id` = `qrdsd`.`coa_id`)))

;





DROP VIEW IF EXISTS `vw_qh_qarze_hassana_repayment`

CREATE VIEW `vw_qh_qarze_hassana_repayment` AS
SELECT DISTINCT
`qhrp`.`qarze_hassana_repayment_id` AS `qarze_hassana_repayment_id`,
`qhrp`.`company_id`                 AS `company_id`,
`qhrp`.`fiscal_year_id`             AS `fiscal_year_id`,
`qhrp`.`document_type_id`           AS `document_type_id`,
`qhrp`.`document_prefix`            AS `document_prefix`,
`qhrp`.`document_no`                AS `document_no`,
`qhrp`.`document_identity`          AS `document_identity`,
`qhrp`.`document_date`              AS `document_date`,
`qhrp`.`bank_account_id`            AS `bank_account_id`,
`qhrp`.`remarks`                    AS `remarks`,
`qhrp`.`is_post`                    AS `is_post`,
`qhrp`.`post_date`                  AS `post_date`,
`qhrp`.`post_by_id`                 AS `post_by_id`,
`qhrp`.`created_at`                 AS `created_at`,
`qhrp`.`created_by_id`              AS `created_by_id`
FROM `fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_repayment` `qhrp`

;





DROP VIEW IF EXISTS `vw_qh_qarze_hassana_repayment_detail`

CREATE VIEW `vw_qh_qarze_hassana_repayment_detail` AS
SELECT DISTINCT
`qrd`.`qarze_hassana_repayment_detail_id` AS `qarze_hassana_repayment_detail_id`,
`qrd`.`qarze_hassana_repayment_id`        AS `qarze_hassana_repayment_id`,
`qrd`.`chk_payment`                       AS `chk_payment`,
`qrd`.`its_no`                            AS `its_no`,
`qrd`.`cheque_date`                       AS `cheque_date`,
`qrd`.`cheque_no`                         AS `cheque_no`,
`qrd`.`amount`                            AS `amount`,
`qrd`.`project_id`                        AS `project_id`,
`qrd`.`coa_id`                            AS `coa_id`,
`qrd`.`cheque_status`                     AS `cheque_status`,
`qrd`.`applicant_id`                      AS `applicant_id`,
`qrd`.`installment_schedule_detail_id`    AS `installment_schedule_detail_id`,
`qrd`.`sub_project_id`                    AS `sub_project_id`,
`qrd`.`created_at`                        AS `created_at`,
`qrd`.`created_by_id`                     AS `created_by_id`,
`sp`.`project_name`                       AS `project_name`,
`sp`.`name`                               AS `sub_project_name`,
`level3`.`name`                           AS `coa_name`,
`app`.`title_and_name`                    AS `title_and_name`
FROM ((((`fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_repayment_detail` `qrd`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `qrd`.`project_id`)
AND (`sp`.`sub_project_id` = `qrd`.`sub_project_id`))))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_request` `qhr`
ON ((`qhr`.`its_no` = `qrd`.`its_no`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`qh_applicant` `app`
ON ((`app`.`applicant_id` = `qrd`.`applicant_id`)))
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_gl0_coa_level3` `level3`
ON ((`level3`.`coa_level3_id` = `qrd`.`coa_id`)))

;





DROP VIEW IF EXISTS `vw_qh_qarze_hassana_request`

CREATE VIEW `vw_qh_qarze_hassana_request` AS
SELECT
`qhr`.`qarze_hassana_request_id` AS `qarze_hassana_request_id`,
`qhr`.`fiscal_year_id`           AS `fiscal_year_id`,
`qhr`.`document_type_id`         AS `document_type_id`,
`qhr`.`document_prefix`          AS `document_prefix`,
`qhr`.`document_no`              AS `document_no`,
`qhr`.`document_identity`        AS `document_identity`,
`qhr`.`document_date`            AS `document_date`,
`qhr`.`its_no`                   AS `its_no`,
`qhr`.`amaanat_no`               AS `amaanat_no`,
`qhr`.`occupation`               AS `occupation`,
`qhr`.`project_id`               AS `project_id`,
`qhr`.`sub_project_id`           AS `sub_project_id`,
`qhr`.`title_and_name`           AS `title_and_name`,
`qhr`.`surname`                  AS `surname`,
`qhr`.`income`                   AS `income`,
`qhr`.`mobile_no`                AS `mobile_no`,
`qhr`.`tel_no`                   AS `tel_no`,
`qhr`.`email_id`                 AS `email_id`,
`qhr`.`reg_date`                 AS `reg_date`,
`qhr`.`residential_address`      AS `residential_address`,
`qhr`.`business_address`         AS `business_address`,
`qhr`.`family_members`           AS `family_members`,
`qhr`.`amount`                   AS `amount`,
`qhr`.`receivable_account_id`    AS `receivable_account_id`,
`qhr`.`status`                   AS `status`,
`qhr`.`cheque_no`                AS `cheque_no`,
`qhr`.`cheque_date`              AS `cheque_date`,
`qhr`.`bank_account_id`          AS `bank_account_id`,
`qhr`.`remarks`                  AS `remarks`,
`qhr`.`is_post`                  AS `is_post`,
`qhr`.`post_date`                AS `post_date`,
`qhr`.`post_by_id`               AS `post_by_id`,
`qhr`.`created_by_id`            AS `created_by_id`,
`qhr`.`company_id`               AS `company_id`,
`qhr`.`created_at`               AS `created_at`,
`sp`.`project_name`              AS `project_name`,
`sp`.`name`                      AS `sub_project_name`
FROM (`fayzehus_bharmals_bsuite_fh_1819`.`qh_qarze_hassana_request` `qhr`
LEFT JOIN `fayzehus_bharmals_bsuite_fh_1819`.`vw_core_sub_project` `sp`
ON (((`sp`.`project_id` = `qhr`.`project_id`)
AND (`sp`.`sub_project_id` = `qhr`.`sub_project_id`))))

;

