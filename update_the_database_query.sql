-- run following query in your database
CREATE TABLE `global_accounting`.`template_branch_mapping` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `company_id` INT(10) NOT NULL , `branch_id` INT(10) NOT NULL , `template_id` INT(10) NOT NULL , `status` INT(10) NOT NULL , `created_by` VARCHAR(100) NULL , `created_date` VARCHAR(100) NULL , `updated_by` VARCHAR(100) NULL , `updated_date` VARCHAR(100) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


CREATE TABLE `global_accounting`.`upload_financial_data` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `gl_ac` INT(100) NOT NULL , `debit` INT(100) NOT NULL , `credit` INT(100) NOT NULL , `branch_id` INT(10) NOT NULL , `company_id` INT(10) NOT NULL , `user_id` INT(10) NOT NULL , `created_by` VARCHAR(100) NOT NULL , `created_on` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `upload_financial_data` ADD `detail` TEXT NOT NULL AFTER `credit`;
ALTER TABLE `upload_financial_data` ADD `year` INT(100) NOT NULL AFTER `detail`, ADD `quarter` VARCHAR(100) NOT NULL AFTER `year`;

CREATE TABLE `global_accounting`.`upload_intra_company_transfer` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `branch_company_id` INT(10) NOT NULL , `name` VARCHAR(150) NOT NULL , `amount` INT(100) NOT NULL , `branch_id` INT(10) NOT NULL , `company_id` INT(10) NOT NULL , `user_id` INT(10) NOT NULL , `created_by` INT(10) NOT NULL , `created_on` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `upload_intra_company_transfer` ADD `year` INT(100) NOT NULL AFTER `amount`, ADD `quarter` VARCHAR(100) NOT NULL AFTER `year`

ALTER TABLE `template_branch_mapping` CHANGE `branch_id` `branch_id` VARCHAR(100) NOT NULL;

ALTER TABLE `branch_master` ADD `default_currency_rate` INT(100) NOT NULL AFTER `currency`;


CREATE TABLE `global_accounting`.`currency_conversion_mt` ( `id` INT(100) NOT NULL AUTO_INCREMENT , `year` VARCHAR(100) NOT NULL , `month` INT(10) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `currency_conversion_mt` ADD `created_by` INT(10) NOT NULL AFTER `month`, ADD `created_on` VARCHAR(100) NOT NULL AFTER `created_by`;
ALTER TABLE `currency_conversion_mt` ADD `status` INT(10) NOT NULL AFTER `month`;
ALTER TABLE `currency_conversion_mt` ADD `branch_id` INT(10) NOT NULL AFTER `id`;
ALTER TABLE `currency_conversion_master` ADD `currency_conversion_mt_id` INT(10) NOT NULL AFTER `id`;
