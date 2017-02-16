-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: openach_dev
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ach_batch`
--

DROP TABLE IF EXISTS `ach_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ach_batch` (
  `ach_batch_id` varchar(36) NOT NULL,
  `ach_batch_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ach_batch_ach_file_id` varchar(36) NOT NULL,
  `ach_batch_header_service_class_code` char(3) DEFAULT NULL,
  `ach_batch_header_company_name` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_batch_header_discretionary_data` varchar(20) DEFAULT NULL,
  `ach_batch_header_company_identification` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_batch_header_standard_entry_class` char(3) DEFAULT NULL,
  `ach_batch_header_company_entry_description` varchar(10) DEFAULT NULL,
  `ach_batch_header_company_descriptive_date` varchar(6) DEFAULT NULL,
  `ach_batch_header_effective_entry_date` varchar(6) DEFAULT NULL,
  `ach_batch_header_settlement_date` char(3) DEFAULT NULL COMMENT 'RESERVED',
  `ach_batch_header_originator_status_code` char(1) DEFAULT NULL,
  `ach_batch_header_originating_dfi_id` varchar(8) DEFAULT NULL COMMENT 'Encrypted',
  `ach_batch_header_batch_number` varchar(7) DEFAULT NULL,
  `ach_batch_control_entry_addenda_count` varchar(6) DEFAULT NULL,
  `ach_batch_control_entry_hash` varchar(10) DEFAULT NULL,
  `ach_batch_control_total_debits` varchar(12) DEFAULT NULL,
  `ach_batch_control_total_credits` varchar(12) DEFAULT NULL,
  `ach_batch_control_message_authentication_code` varchar(19) DEFAULT NULL COMMENT 'LEAVE BLANK',
  `ach_batch_iat_indicator` varchar(16) DEFAULT NULL COMMENT 'LEAVE BLANK',
  `ach_batch_iat_foreign_exchange_indicator` char(2) DEFAULT NULL,
  `ach_batch_iat_foreign_exchange_ref_indicator` char(1) DEFAULT NULL,
  `ach_batch_iat_foreign_exchange_rate_ref` varchar(15) DEFAULT NULL,
  `ach_batch_iat_iso_dest_country_code` char(3) DEFAULT NULL,
  `ach_batch_iat_iso_orig_currency_code` char(3) DEFAULT NULL,
  `ach_batch_iat_iso_dest_currency_code` char(3) DEFAULT NULL,
  PRIMARY KEY (`ach_batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ach_entry`
--

DROP TABLE IF EXISTS `ach_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ach_entry` (
  `ach_entry_id` varchar(36) NOT NULL,
  `ach_entry_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ach_entry_status` enum('pending','processing','posted','returned','error') NOT NULL DEFAULT 'pending',
  `ach_entry_ach_batch_id` varchar(36) NOT NULL,
  `ach_entry_odfi_branch_id` varchar(36) NOT NULL,
  `ach_entry_external_account_id` varchar(36) NOT NULL,
  `ach_entry_payment_schedule_id` varchar(36) NOT NULL DEFAULT '',
  `ach_entry_detail_transaction_code` char(2) DEFAULT NULL,
  `ach_entry_detail_receiving_dfi_id` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_detail_receiving_dfi_id_check_digit` char(1) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_detail_dfi_account_number` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_detail_amount` varchar(18) DEFAULT NULL COMMENT 'Length of 18 for IAT, 10 for all others',
  `ach_entry_detail_individual_id_number` varchar(15) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_detail_individual_name` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Length of 35 for IAT, 22 for all others',
  `ach_entry_detail_discretionary_data` char(2) DEFAULT NULL COMMENT 'Also handles WEB payment type code',
  `ach_entry_detail_addenda_record_indicator` char(1) DEFAULT NULL,
  `ach_entry_detail_trace_number` bigint(20) unsigned DEFAULT NULL,
  `ach_entry_addenda_type_code` char(2) DEFAULT NULL,
  `ach_entry_addenda_payment_info` varchar(300) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_go_receiving_dfi_id` varchar(8) DEFAULT NULL,
  `ach_entry_iat_go_receiving_dfi_id_check_digit` char(1) DEFAULT NULL,
  `ach_entry_iat_ofac_screening_indicator` char(1) DEFAULT NULL,
  `ach_entry_iat_secondary_ofac_screening_indicator` char(1) DEFAULT NULL,
  `ach_entry_iat_transaction_type_code` char(3) DEFAULT NULL,
  `ach_entry_iat_foreign_trace_number` varchar(22) DEFAULT NULL,
  `ach_entry_iat_originator_name` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_originator_street_addr` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_originator_city` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with state',
  `ach_entry_iat_originator_state_province` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with city',
  `ach_entry_iat_originator_postal_code` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with country',
  `ach_entry_iat_originator_country` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with postal code',
  `ach_entry_iat_originating_dfi_name` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_originating_dfi_id` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_originating_dfi_id_qualifier` varchar(2) DEFAULT NULL,
  `ach_entry_iat_originating_dfi_country_code` varchar(3) DEFAULT NULL,
  `ach_entry_iat_receiving_dfi_name` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_receiving_dfi_id` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_receiving_dfi_id_qualifier` varchar(2) DEFAULT NULL,
  `ach_entry_iat_receiving_dfi_country_code` varchar(3) DEFAULT NULL,
  `ach_entry_iat_receiver_street_addr` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_entry_iat_receiver_city` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with state',
  `ach_entry_iat_receiver_state_province` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with city',
  `ach_entry_iat_receiver_postal_code` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with country',
  `ach_entry_iat_receiver_country` varchar(125) DEFAULT NULL COMMENT 'Encrypted, Concatenated with postal code',
  PRIMARY KEY (`ach_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ach_entry_return`
--

DROP TABLE IF EXISTS `ach_entry_return`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ach_entry_return` (
  `ach_entry_return_id` varchar(36) NOT NULL,
  `ach_entry_return_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ach_entry_return_odfi_branch_id` varchar(36) NOT NULL,
  `ach_entry_return_ach_entry_id` varchar(36) NOT NULL,
  `ach_entry_return_reassigned_trace_number` varchar(15) DEFAULT NULL,
  `ach_entry_return_date_of_death` varchar(6) DEFAULT NULL,
  `ach_entry_return_original_dfi_id` varchar(8) DEFAULT NULL,
  `ach_entry_return_trace_number` varchar(15) DEFAULT NULL,
  `ach_entry_return_return_reason_code` varchar(3) DEFAULT NULL,
  `ach_entry_return_change_code` varchar(3) DEFAULT NULL,
  `ach_entry_return_corrected_data` varchar(29) DEFAULT NULL,
  `ach_entry_return_addenda_information` varchar(44) DEFAULT NULL,
  PRIMARY KEY (`ach_entry_return_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ach_file`
--

DROP TABLE IF EXISTS `ach_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ach_file` (
  `ach_file_id` varchar(36) NOT NULL,
  `ach_file_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ach_file_status` enum('pending','processing','built','transferred','confirmed','error') NOT NULL DEFAULT 'pending',
  `ach_file_odfi_branch_id` varchar(36) NOT NULL,
  `ach_file_originator_info_id` varchar(36) NOT NULL,
  `ach_file_header_priority_code` char(2) NOT NULL DEFAULT '01',
  `ach_file_header_immediate_destination` varchar(10) DEFAULT NULL,
  `ach_file_header_immediate_origin` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_file_header_file_creation_date` varchar(6) DEFAULT NULL,
  `ach_file_header_file_creation_time` varchar(4) DEFAULT NULL,
  `ach_file_header_file_id_modifier` char(1) DEFAULT NULL,
  `ach_file_header_record_size` char(3) DEFAULT '094',
  `ach_file_header_blocking_factor` char(2) DEFAULT '10',
  `ach_file_header_format_code` char(1) DEFAULT '1',
  `ach_file_header_immediate_destination_name` varchar(23) DEFAULT NULL,
  `ach_file_header_immediate_origin_name` varchar(125) DEFAULT NULL COMMENT 'Encrypted',
  `ach_file_header_reference_code` varchar(8) DEFAULT NULL,
  `ach_file_control_batch_count` varchar(6) DEFAULT NULL,
  `ach_file_control_block_count` varchar(6) DEFAULT NULL,
  `ach_file_control_entry_addenda_count` varchar(8) DEFAULT NULL,
  `ach_file_control_entry_hash` varchar(10) DEFAULT NULL,
  `ach_file_control_total_debits` varchar(12) DEFAULT NULL,
  `ach_file_control_total_credits` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`ach_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ach_file_conf`
--

DROP TABLE IF EXISTS `ach_file_conf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ach_file_conf` (
  `ach_file_conf_id` varchar(36) NOT NULL,
  `ach_file_conf_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ach_file_conf_odfi_branch_id` varchar(36) NOT NULL,
  `ach_file_conf_status` enum('pending','processing','success','error') NOT NULL DEFAULT 'pending',
  `ach_file_conf_date` varchar(6) DEFAULT NULL,
  `ach_file_conf_time` varchar(6) DEFAULT NULL,
  `ach_file_conf_batch_count` varchar(6) DEFAULT NULL,
  `ach_file_conf_batch_item_count` varchar(4) DEFAULT NULL,
  `ach_file_conf_block_count` varchar(6) DEFAULT NULL,
  `ach_file_conf_error_message_number` varchar(10) DEFAULT NULL,
  `ach_file_conf_error_message` text,
  `ach_file_conf_total_debits` varchar(12) DEFAULT NULL,
  `ach_file_conf_total_credits` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`ach_file_conf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `auth_assignment_itemname` varchar(64) NOT NULL,
  `auth_assignment_userid` varchar(64) NOT NULL,
  `auth_assignment_bizrule` text,
  `auth_assignment_data` text,
  PRIMARY KEY (`auth_assignment_itemname`,`auth_assignment_userid`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`auth_assignment_itemname`) REFERENCES `auth_item` (`auth_item_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `auth_item_name` varchar(64) NOT NULL,
  `auth_item_type` int(11) NOT NULL,
  `auth_item_description` text,
  `auth_item_bizrule` text,
  `auth_item_data` text,
  PRIMARY KEY (`auth_item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auth_item_tree`
--

DROP TABLE IF EXISTS `auth_item_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_tree` (
  `auth_item_tree_parent` varchar(64) NOT NULL,
  `auth_item_tree_child` varchar(64) NOT NULL,
  PRIMARY KEY (`auth_item_tree_parent`,`auth_item_tree_child`),
  KEY `auth_item_tree_child` (`auth_item_tree_child`),
  CONSTRAINT `auth_item_tree_ibfk_1` FOREIGN KEY (`auth_item_tree_parent`) REFERENCES `auth_item` (`auth_item_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_tree_ibfk_2` FOREIGN KEY (`auth_item_tree_child`) REFERENCES `auth_item` (`auth_item_name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entity_index`
--

DROP TABLE IF EXISTS `entity_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_index` (
  `entity_index_id` varchar(64) NOT NULL,
  `entity_index_next_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`entity_index_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `external_account`
--

DROP TABLE IF EXISTS `external_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_account` (
  `external_account_id` varchar(36) NOT NULL,
  `external_account_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  PRIMARY KEY (`external_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fedach`
--

DROP TABLE IF EXISTS `fedach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fedach` (
  `fedach_routing_number` char(9) NOT NULL,
  `fedach_office_code` char(1) NOT NULL,
  `fedach_servicing_frb_number` char(9) NOT NULL,
  `fedach_record_type_code` char(1) NOT NULL,
  `fedach_change_date` char(6) NOT NULL,
  `fedach_new_routing_number` char(9) NOT NULL,
  `fedach_customer_name` varchar(36) NOT NULL,
  `fedach_address` varchar(36) NOT NULL,
  `fedach_city` varchar(20) NOT NULL,
  `fedach_state_province` char(2) NOT NULL,
  `fedach_postal_code` char(5) NOT NULL,
  `fedach_postal_code_extension` char(4) NOT NULL,
  `fedach_phone_number` varchar(10) NOT NULL,
  `fedach_institution_status_code` char(1) NOT NULL,
  `fedach_data_view_code` char(1) NOT NULL,
  PRIMARY KEY (`fedach_routing_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fedwire`
--

DROP TABLE IF EXISTS `fedwire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fedwire` (
  `fedwire_routing_number` char(9) NOT NULL,
  `fedwire_telegraphic_name` varchar(18) NOT NULL,
  `fedwire_customer_name` varchar(36) NOT NULL,
  `fedwire_state_province` char(2) NOT NULL,
  `fedwire_city` varchar(25) NOT NULL,
  `fedwire_funds_transfer_status` char(1) NOT NULL,
  `fedwire_settlement_only_status` char(1) NOT NULL,
  `fedwire_securities_transfer_status` char(1) NOT NULL,
  `fedwire_revision_date` char(8) NOT NULL,
  PRIMARY KEY (`fedwire_routing_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file_transfer`
--

DROP TABLE IF EXISTS `file_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_transfer` (
  `file_transfer_id` varchar(36) NOT NULL,
  `file_transfer_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_transfer_file_id` varchar(36) NOT NULL,
  `file_transfer_model` varchar(50) NOT NULL,
  `file_transfer_status` enum('pending','transferring','transferred','confirmed','failed') DEFAULT NULL,
  `file_transfer_plugin` varchar(36) NOT NULL,
  `file_transfer_message` text NOT NULL,
  PRIMARY KEY (`file_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menu_item`
--

DROP TABLE IF EXISTS `menu_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_item` (
  `menu_item_id` varchar(36) NOT NULL,
  `menu_item_component` varchar(50) NOT NULL,
  `menu_item_group` varchar(50) NOT NULL,
  `menu_item_parent_id` varchar(36) DEFAULT NULL,
  `menu_item_path` varchar(50) DEFAULT NULL,
  `menu_item_class` varchar(50) DEFAULT NULL,
  `menu_item_icon` varchar(255) DEFAULT NULL,
  `menu_item_label` varchar(255) NOT NULL,
  `menu_item_text` text NOT NULL,
  `menu_item_weight` tinyint(4) NOT NULL DEFAULT '0',
  `menu_item_require_role` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`menu_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `odfi_branch`
--

DROP TABLE IF EXISTS `odfi_branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `odfi_branch` (
  `odfi_branch_id` varchar(36) NOT NULL,
  `odfi_branch_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `odfi_branch_originator_id` varchar(36) NOT NULL,
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
  PRIMARY KEY (`odfi_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ofac_add`
--

DROP TABLE IF EXISTS `ofac_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofac_add` (
  `ofac_add_ent_num` int(11) NOT NULL,
  `ofac_add_num` int(11) NOT NULL,
  `ofac_add_address` varchar(750) NOT NULL,
  `ofac_add_city` varchar(116) NOT NULL,
  `ofac_add_state_province` varchar(116) NOT NULL,
  `ofac_add_postal_code` varchar(116) NOT NULL,
  `ofac_add_country` varchar(250) NOT NULL,
  `ofac_add_remarks` varchar(200) NOT NULL,
  PRIMARY KEY (`ofac_add_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ofac_alt`
--

DROP TABLE IF EXISTS `ofac_alt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofac_alt` (
  `ofac_alt_ent_num` int(11) NOT NULL,
  `ofac_alt_num` int(11) NOT NULL,
  `ofac_alt_type` varchar(8) NOT NULL,
  `ofac_alt_name` varchar(350) NOT NULL,
  `ofac_alt_remarks` varchar(200) NOT NULL,
  PRIMARY KEY (`ofac_alt_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ofac_sdn`
--

DROP TABLE IF EXISTS `ofac_sdn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofac_sdn` (
  `ofac_sdn_ent_num` int(11) NOT NULL,
  `ofac_sdn_name` varchar(350) NOT NULL,
  `ofac_sdn_type` varchar(12) NOT NULL,
  `ofac_sdn_program` varchar(50) NOT NULL,
  `ofac_sdn_title` varchar(200) NOT NULL,
  `ofac_sdn_call_sign` varchar(8) NOT NULL,
  `ofac_sdn_vess_type` varchar(25) NOT NULL,
  `ofac_sdn_tonnage` varchar(14) NOT NULL,
  `ofac_sdn_grt` varchar(8) NOT NULL,
  `ofac_sdn_vess_flag` varchar(40) NOT NULL,
  `ofac_sdn_vess_owner` varchar(150) NOT NULL,
  `ofac_sdn_remarks` varchar(1000) NOT NULL,
  PRIMARY KEY (`ofac_sdn_ent_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `originator`
--

DROP TABLE IF EXISTS `originator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `originator` (
  `originator_id` varchar(36) NOT NULL,
  `originator_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `originator_user_id` varchar(36) NOT NULL,
  `originator_name` varchar(35) DEFAULT NULL,
  `originator_identification` varchar(10) DEFAULT NULL,
  `originator_address` varchar(35) DEFAULT NULL,
  `originator_city` varchar(35) DEFAULT NULL,
  `originator_state_province` varchar(35) DEFAULT NULL,
  `originator_postal_code` varchar(35) DEFAULT NULL,
  `originator_country_code` char(2) DEFAULT NULL,
  PRIMARY KEY (`originator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `originator_info`
--

DROP TABLE IF EXISTS `originator_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `originator_info` (
  `originator_info_id` varchar(36) NOT NULL,
  `originator_info_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `originator_info_odfi_branch_id` varchar(36) NOT NULL,
  `originator_info_originator_id` varchar(36) NOT NULL,
  `originator_info_name` varchar(16) DEFAULT NULL,
  `originator_info_description` text,
  `originator_info_identification` varchar(10) DEFAULT NULL,
  `originator_info_address` varchar(35) DEFAULT NULL,
  `originator_info_city` varchar(35) DEFAULT NULL,
  `originator_info_state_province` varchar(35) DEFAULT NULL,
  `originator_info_postal_code` varchar(35) DEFAULT NULL,
  `originator_info_country_code` char(2) DEFAULT NULL,
  PRIMARY KEY (`originator_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_profile`
--

DROP TABLE IF EXISTS `payment_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_profile` (
  `payment_profile_id` varchar(36) NOT NULL,
  `payment_profile_originator_info_id` varchar(36) NOT NULL,
  `payment_profile_external_id` varchar(50) NOT NULL,
  `payment_profile_password` varchar(50) DEFAULT NULL,
  `payment_profile_first_name` varchar(50) DEFAULT NULL,
  `payment_profile_last_name` varchar(50) DEFAULT NULL,
  `payment_profile_email_address` varchar(255) NOT NULL,
  `payment_profile_security_question_1` varchar(255) DEFAULT NULL,
  `payment_profile_security_question_2` varchar(255) DEFAULT NULL,
  `payment_profile_security_question_3` varchar(255) DEFAULT NULL,
  `payment_profile_security_answer_1` varchar(255) DEFAULT NULL COMMENT 'Encrypted',
  `payment_profile_security_answer_2` varchar(255) DEFAULT NULL COMMENT 'Encrypted',
  `payment_profile_security_answer_3` varchar(255) DEFAULT NULL COMMENT 'Encrypted',
  `payment_profile_status` enum('enabled','suspended') NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`payment_profile_id`),
  KEY `payment_profile_external_id` (`payment_profile_external_id`),
  KEY `payment_profile_originator_id` (`payment_profile_originator_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_schedule`
--

DROP TABLE IF EXISTS `payment_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_schedule` (
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
  PRIMARY KEY (`payment_schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_type`
--

DROP TABLE IF EXISTS `payment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_type` (
  `payment_type_id` varchar(36) NOT NULL,
  `payment_type_originator_info_id` varchar(36) NOT NULL,
  `payment_type_name` varchar(10) NOT NULL,
  `payment_type_transaction_type` enum('credit','debit') NOT NULL DEFAULT 'debit',
  `payment_type_status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`payment_type_id`),
  KEY `payment_type_originator_info_id` (`payment_type_originator_info_id`),
  KEY `payment_type_transaction_type` (`payment_type_transaction_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phonetic_data`
--

DROP TABLE IF EXISTS `phonetic_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phonetic_data` (
  `phonetic_data_id` varchar(36) NOT NULL,
  `phonetic_data_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `phonetic_data_entity_class` varchar(50) NOT NULL,
  `phonetic_data_entity_id` varchar(36) NOT NULL,
  `phonetic_data_entity_field` varchar(50) DEFAULT NULL,
  `phonetic_data_encoding_method` enum('soundex','nysiis','metaphone','metaphone2') NOT NULL,
  `phonetic_data_key` varchar(255) NOT NULL,
  `phonetic_data_type` varchar(50) NOT NULL,
  PRIMARY KEY (`phonetic_data_id`),
  KEY `phonetic_data_entity_id` (`phonetic_data_entity_id`),
  KEY `phonetic_data_entity_class` (`phonetic_data_entity_class`),
  KEY `phonetic_data_encoding_method` (`phonetic_data_encoding_method`),
  KEY `phonetic_data_type` (`phonetic_data_type`),
  KEY `phonetic_data_key` (`phonetic_data_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `phonetic_filtered`
--

DROP TABLE IF EXISTS `phonetic_filtered`;
/*!50001 DROP VIEW IF EXISTS `phonetic_filtered`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `phonetic_filtered` (
  `filtered_source_entity_class` varchar(50),
  `filtered_source_entity_id` varchar(36),
  `filtered_result_entity_class` varchar(50),
  `filtered_result_entity_id` varchar(36),
  `data_type` varchar(7),
  `total_hits` bigint(21)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `plugin`
--

DROP TABLE IF EXISTS `plugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugin` (
  `plugin_id` varchar(36) NOT NULL,
  `plugin_status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `plugin_class` varchar(36) NOT NULL,
  `plugin_version` varchar(36) NOT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `plugin_config`
--

DROP TABLE IF EXISTS `plugin_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugin_config` (
  `plugin_config_id` varchar(36) NOT NULL,
  `plugin_config_plugin_id` varchar(36) NOT NULL,
  `plugin_config_parent_id` varchar(36) NOT NULL,
  `plugin_config_parent_model` varchar(50) NOT NULL,
  `plugin_config_key` varchar(255) NOT NULL,
  `plugin_config_value` varchar(1000) NOT NULL,
  PRIMARY KEY (`plugin_config_id`),
  UNIQUE KEY `plugin_config_plugin_id` (`plugin_config_plugin_id`,`plugin_config_parent_id`,`plugin_config_parent_model`,`plugin_config_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` varchar(36) NOT NULL,
  `role_name` varchar(50) DEFAULT NULL,
  `role_description` text,
  `role_max_originator` int(11) NOT NULL DEFAULT '0',
  `role_max_odfi` int(11) NOT NULL DEFAULT '0',
  `role_max_daily_xfers` int(11) NOT NULL DEFAULT '0',
  `role_max_daily_files` int(11) NOT NULL DEFAULT '0',
  `role_max_daily_batches` int(11) NOT NULL DEFAULT '0',
  `role_iat_enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `routing`
--

DROP TABLE IF EXISTS `routing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routing` (
  `routing_number` char(9) NOT NULL,
  `routing_telegraphic_name` varchar(18) NOT NULL,
  `routing_customer_name` varchar(36) NOT NULL,
  `routing_state_province` char(2) NOT NULL,
  `routing_city` varchar(25) NOT NULL,
  `routing_funds_transfer_status` char(1) NOT NULL,
  `routing_settlement_only_status` char(1) NOT NULL,
  `routing_securities_transfer_status` char(1) NOT NULL,
  `routing_revision_date` char(8) NOT NULL,
  PRIMARY KEY (`routing_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` varchar(36) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `user_password` varchar(50) DEFAULT NULL,
  `user_first_name` varchar(50) DEFAULT NULL,
  `user_last_name` varchar(50) DEFAULT NULL,
  `user_email_address` varchar(255) NOT NULL,
  `user_security_question_1` varchar(255) DEFAULT NULL,
  `user_security_question_2` varchar(255) DEFAULT NULL,
  `user_security_question_3` varchar(255) DEFAULT NULL,
  `user_security_answer_1` varchar(255) DEFAULT NULL COMMENT 'Encrypted',
  `user_security_answer_2` varchar(255) DEFAULT NULL COMMENT 'Encrypted',
  `user_security_answer_3` varchar(255) DEFAULT NULL COMMENT 'Encrypted',
  `user_status` enum('enabled','suspended') NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_history`
--

DROP TABLE IF EXISTS `user_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_history` (
  `user_history_id` varchar(36) NOT NULL,
  `user_history_user_id` varchar(36) NOT NULL,
  `user_history_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_history_event_type` varchar(16) DEFAULT NULL,
  `user_history_additional_info` text,
  PRIMARY KEY (`user_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_role_user_id` varchar(36) NOT NULL,
  `user_role_role_id` varchar(36) NOT NULL,
  PRIMARY KEY (`user_role_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `phonetic_filtered`
--

/*!50001 DROP TABLE IF EXISTS `phonetic_filtered`*/;
/*!50001 DROP VIEW IF EXISTS `phonetic_filtered`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `phonetic_filtered` AS select `source`.`phonetic_data_entity_class` AS `filtered_source_entity_class`,`source`.`phonetic_data_entity_id` AS `filtered_source_entity_id`,`result`.`phonetic_data_entity_class` AS `filtered_result_entity_class`,`result`.`phonetic_data_entity_id` AS `filtered_result_entity_id`,'name' AS `data_type`,count(`source`.`phonetic_data_key`) AS `total_hits` from (`phonetic_data` `source` join `phonetic_data` `result` on(((`source`.`phonetic_data_encoding_method` = `result`.`phonetic_data_encoding_method`) and (`source`.`phonetic_data_key` = `result`.`phonetic_data_key`) and (`source`.`phonetic_data_type` = `result`.`phonetic_data_type`)))) where ((`source`.`phonetic_data_entity_class` not in ('OfacSdn','OfacAlt')) and (`result`.`phonetic_data_entity_class` in ('OfacSdn','OfacAlt')) and (`source`.`phonetic_data_type` in ('last_name','first_name'))) group by `source`.`phonetic_data_entity_class`,`source`.`phonetic_data_entity_id`,`result`.`phonetic_data_entity_id` having (`total_hits` >= 5) union select `source`.`phonetic_data_entity_class` AS `filtered_source_entity_class`,`source`.`phonetic_data_entity_id` AS `filtered_source_entity_id`,`result`.`phonetic_data_entity_class` AS `filtered_result_entity_class`,`result`.`phonetic_data_entity_id` AS `filtered_result_entity_id`,'company' AS `data_type`,count(`source`.`phonetic_data_key`) AS `total_hits` from (`phonetic_data` `source` join `phonetic_data` `result` on(((`source`.`phonetic_data_encoding_method` = `result`.`phonetic_data_encoding_method`) and (`source`.`phonetic_data_key` = `result`.`phonetic_data_key`) and (`source`.`phonetic_data_type` = `result`.`phonetic_data_type`)))) where ((`source`.`phonetic_data_entity_class` not in ('OfacSdn','OfacAlt')) and (`result`.`phonetic_data_entity_class` in ('OfacSdn','OfacAlt')) and (`source`.`phonetic_data_type` = 'company')) group by `source`.`phonetic_data_entity_class`,`source`.`phonetic_data_entity_id`,`result`.`phonetic_data_entity_id` having (`total_hits` >= 2) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-03-06 10:22:44
