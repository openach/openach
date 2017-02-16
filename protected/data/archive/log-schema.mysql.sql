DROP TABLE IF EXISTS `app_log`;
CREATE TABLE `app_log` (
  `app_log_id` varchar(36) NOT NULL,
  `app_log_datetime` datetime DEFAULT NULL,
  `app_log_message` varchar(255) NOT NULL DEFAULT '',
  KEY `app_log_id` (`app_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ach_batch_log`;
CREATE TABLE `ach_batch_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `ach_batch_id` varchar(36) NOT NULL,
  `ach_batch_header_company_descriptive_date` varchar(6) DEFAULT NULL,
  `ach_batch_header_effective_entry_date` varchar(6) DEFAULT NULL,
  `ach_batch_header_batch_number` varchar(7) DEFAULT NULL,
  `ach_batch_control_entry_addenda_count` varchar(6) DEFAULT NULL,
  `ach_batch_control_entry_hash` varchar(10) DEFAULT NULL,
  `ach_batch_control_total_debits` varchar(12) DEFAULT NULL,
  `ach_batch_control_total_credits` varchar(12) DEFAULT NULL,
  KEY (`ach_batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ach_entry_log`;
CREATE TABLE `ach_entry_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `ach_entry_id` varchar(36) NOT NULL,
  `ach_entry_status` enum('pending','processing','posted','returned','error') NOT NULL DEFAULT 'pending',
  `ach_entry_detail_transaction_code` char(2) DEFAULT NULL,
  `ach_entry_detail_amount` varchar(18) DEFAULT NULL COMMENT 'Length of 18 for IAT, 10 for all others',
  `ach_entry_detail_addenda_record_indicator` char(1) DEFAULT NULL,
  `ach_entry_detail_trace_number` bigint(20) unsigned DEFAULT NULL,
  `ach_entry_iat_foreign_trace_number` varchar(22) DEFAULT NULL,
  KEY (`ach_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ach_file_log`;
CREATE TABLE `ach_file_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `ach_file_id` varchar(36) NOT NULL,
  `ach_file_status` enum('pending','processing','built','transferred','confirmed','error') NOT NULL DEFAULT 'pending',
  `ach_file_header_file_creation_date` varchar(6) DEFAULT NULL,
  `ach_file_header_file_creation_time` varchar(4) DEFAULT NULL,
  `ach_file_header_file_id_modifier` char(1) DEFAULT NULL,
  `ach_file_header_reference_code` varchar(8) DEFAULT NULL,
  `ach_file_control_batch_count` varchar(6) DEFAULT NULL,
  `ach_file_control_block_count` varchar(6) DEFAULT NULL,
  `ach_file_control_entry_addenda_count` varchar(8) DEFAULT NULL,
  `ach_file_control_entry_hash` varchar(10) DEFAULT NULL,
  `ach_file_control_total_debits` varchar(12) DEFAULT NULL,
  `ach_file_control_total_credits` varchar(12) DEFAULT NULL,
  KEY (`ach_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `external_account_log`;
CREATE TABLE `external_account_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `external_account_id` varchar(36) NOT NULL,
  `external_account_payment_profile_id` varchar(36) NOT NULL,
  `external_account_type` enum('checking','savings') NOT NULL,
  `external_account_name` varchar(125) DEFAULT NULL COMMENT 'User-friendly name of the account',
  `external_account_bank` varchar(125) DEFAULT NULL COMMENT 'Name of the bank where the account is held',
  `external_account_holder` varchar(125) DEFAULT NULL COMMENT 'Name of the account holder',
  `external_account_country_code` varchar(2) DEFAULT NULL COMMENT 'Country code of the bank',
  `external_account_dfi_id` varchar(125) DEFAULT NULL COMMENT 'ABA Routing or SWIFT BIC',
  `external_account_dfi_id_qualifier` enum('01','02') NOT NULL DEFAULT '01' COMMENT '01 = ABA, 02 = SWIFT BIC',
  `external_account_number` varchar(125) DEFAULT NULL COMMENT 'Account number',
  `external_account_billing_address` varchar(35) DEFAULT NULL COMMENT 'Required for IAT',
  `external_account_billing_city` varchar(35) DEFAULT NULL COMMENT 'Required for IAT',
  `external_account_billing_state_province` varchar(35) DEFAULT NULL COMMENT 'Required for IAT',
  `external_account_billing_postal_code` varchar(35) DEFAULT NULL COMMENT 'Required for IAT',
  `external_account_billing_country` varchar(2) DEFAULT NULL COMMENT 'Required for IAT',
  `external_account_business` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Business or personal account (different NACHA rules apply to business)',
  `external_account_verification_status` enum('pending','attempted','completed','failed') NOT NULL DEFAULT 'pending' COMMENT 'Status of the account''s verification',
  `external_account_status` enum('enabled','frozen','closed') NOT NULL DEFAULT 'enabled' COMMENT 'Status of the account',
  KEY (`external_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `file_transfer_log`;
CREATE TABLE `file_transfer_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `file_transfer_id` varchar(36) NOT NULL,
  `file_transfer_status` enum('pending','transferring','transferred','confirmed','failed') DEFAULT NULL,
  KEY (`file_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `odfi_branch_log`;
CREATE TABLE `odfi_branch_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `odfi_branch_id` varchar(36) NOT NULL,
  `odfi_branch_friendly_name` varchar(50) DEFAULT NULL,
  `odfi_branch_name` varchar(35) DEFAULT NULL,
  `odfi_branch_city` varchar(35) DEFAULT NULL,
  `odfi_branch_state_province` varchar(35) DEFAULT NULL,
  `odfi_branch_country_code` char(2) DEFAULT NULL,
  `odfi_branch_dfi_id` varchar(125) DEFAULT NULL COMMENT 'ABA Routing or SWIFT BIC',
  `odfi_branch_dfi_id_qualifier` enum('01','02') DEFAULT NULL COMMENT '01 = ABA, 02 = SWIFT BIC',
  `odfi_branch_go_dfi_id` varchar(9) DEFAULT NULL COMMENT 'Gateway Operator DFI ID (for IAT)',
  `odfi_branch_status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `odfi_branch_plugin` varchar(36) NOT NULL DEFAULT '',
  KEY (`odfi_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `originator_log`;
CREATE TABLE `originator_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `originator_id` varchar(36) NOT NULL,
  `originator_user_id` varchar(36) NOT NULL,
  `originator_name` varchar(35) DEFAULT NULL,
  `originator_identification` varchar(10) DEFAULT NULL,
  `originator_address` varchar(35) DEFAULT NULL,
  `originator_city` varchar(35) DEFAULT NULL,
  `originator_state_province` varchar(35) DEFAULT NULL,
  `originator_postal_code` varchar(35) DEFAULT NULL,
  `originator_country_code` char(2) DEFAULT NULL,
  KEY (`originator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `originator_info_log`;
CREATE TABLE `originator_info_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `originator_info_id` varchar(36) NOT NULL,
  `originator_info_odfi_branch_id` varchar(36) NOT NULL,
  `originator_info_name` varchar(16) DEFAULT NULL,
  `originator_info_identification` varchar(10) DEFAULT NULL,
  `originator_info_address` varchar(35) DEFAULT NULL,
  `originator_info_city` varchar(35) DEFAULT NULL,
  `originator_info_state_province` varchar(35) DEFAULT NULL,
  `originator_info_postal_code` varchar(35) DEFAULT NULL,
  `originator_info_country_code` char(2) DEFAULT NULL,
  KEY (`originator_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `payment_profile_log`;
CREATE TABLE `payment_profile_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `payment_profile_id` varchar(36) NOT NULL,
  `payment_profile_external_id` varchar(50) NOT NULL,
  `payment_profile_first_name` varchar(50) DEFAULT NULL,
  `payment_profile_last_name` varchar(50) DEFAULT NULL,
  `payment_profile_email_address` varchar(255) NOT NULL,
  `payment_profile_status` enum('enabled','suspended') NOT NULL DEFAULT 'enabled',
  KEY (`payment_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `payment_schedule_log`;
CREATE TABLE `payment_schedule_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `payment_schedule_id` varchar(36) NOT NULL,
  `payment_schedule_external_account_id` varchar(36) NOT NULL,
  `payment_schedule_payment_type_id` varchar(36) NOT NULL,
  `payment_schedule_status` enum('enabled','suspended') NOT NULL,
  `payment_schedule_amount` decimal(19,2) NOT NULL DEFAULT '0.00',
  `payment_schedule_currency_code` char(3) NOT NULL DEFAULT '',
  `payment_schedule_next_date` date NOT NULL,
  `payment_schedule_frequency` enum('once','daily','weekly','biweekly','monthly','bimonthly','bianually','anually','biennially') DEFAULT NULL,
  `payment_schedule_end_date` date NOT NULL,
  `payment_schedule_remaining_occurrences` smallint(5) unsigned NOT NULL DEFAULT '1',
  KEY (`payment_schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `payment_type_log`;
CREATE TABLE `payment_type_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `payment_type_id` varchar(36) NOT NULL,
  `payment_type_name` varchar(10) NOT NULL,
  `payment_type_transaction_type` enum('credit','debit') NOT NULL DEFAULT 'debit',
  `payment_type_status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  KEY (`payment_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE `user_log` (
  `log_datetime` datetime DEFAULT NULL,
  `log_remote_ip` varchar(15) DEFAULT NULL,
  `log_user_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `user_first_name` varchar(50) DEFAULT NULL,
  `user_last_name` varchar(50) DEFAULT NULL,
  `user_email_address` varchar(255) NOT NULL,
  `user_status` enum('enabled','suspended') NOT NULL DEFAULT 'enabled',
  KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

