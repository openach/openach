
--
-- Name: ach_entry_status; Type: table; TableName: ach_entry_status;
--

CREATE TABLE ach_entry_status (value varchar(128) PRIMARY KEY);



--
-- Name: ach_file_conf_status; Type: table; TableName: ach_file_conf_status;
--

CREATE TABLE ach_file_conf_status (value varchar(128) PRIMARY KEY);



--
-- Name: ach_file_status; Type: table; TableName: ach_file_status;
--

CREATE TABLE ach_file_status (value varchar(128) PRIMARY KEY);



--
-- Name: external_account_dfi_id_qualifier; Type: table; TableName: external_account_dfi_id_qualifier;
--

CREATE TABLE external_account_dfi_id_qualifier (value varchar(128) PRIMARY KEY);



--
-- Name: external_account_status; Type: table; TableName: external_account_status;
--

CREATE TABLE external_account_status (value varchar(128) PRIMARY KEY);



--
-- Name: external_account_type; Type: table; TableName: external_account_type;
--

CREATE TABLE external_account_type (value varchar(128) PRIMARY KEY);



--
-- Name: external_account_verification_status; Type: table; TableName: external_account_verification_status;
--

CREATE TABLE external_account_verification_status (value varchar(128) PRIMARY KEY);



--
-- Name: file_transfer_status; Type: table; TableName: file_transfer_status;
--

CREATE TABLE file_transfer_status (value varchar(128) PRIMARY KEY);



--
-- Name: odfi_branch_dfi_id_qualifier; Type: table; TableName: odfi_branch_dfi_id_qualifier;
--

CREATE TABLE odfi_branch_dfi_id_qualifier (value varchar(128) PRIMARY KEY);



--
-- Name: odfi_branch_status; Type: table; TableName: odfi_branch_status;
--

CREATE TABLE odfi_branch_status (value varchar(128) PRIMARY KEY);



--
-- Name: payment_profile_status; Type: table; TableName: payment_profile_status;
--

CREATE TABLE payment_profile_status (value varchar(128) PRIMARY KEY);



--
-- Name: payment_schedule_frequency; Type: table; TableName: payment_schedule_frequency;
--

CREATE TABLE payment_schedule_frequency (value varchar(128) PRIMARY KEY);



--
-- Name: payment_schedule_status; Type: table; TableName: payment_schedule_status;
--

CREATE TABLE payment_schedule_status (value varchar(128) PRIMARY KEY);



--
-- Name: payment_type_status; Type: table; TableName: payment_type_status;
--

CREATE TABLE payment_type_status (value varchar(128) PRIMARY KEY);



--
-- Name: payment_type_transaction_type; Type: table; TableName: payment_type_transaction_type;
--

CREATE TABLE payment_type_transaction_type (value varchar(128) PRIMARY KEY);



--
-- Name: phonetic_data_encoding_method; Type: table; TableName: phonetic_data_encoding_method;
--

CREATE TABLE phonetic_data_encoding_method (value varchar(128) PRIMARY KEY);



--
-- Name: plugin_status; Type: table; TableName: plugin_status;
--

CREATE TABLE plugin_status (value varchar(128) PRIMARY KEY);



--
-- Name: settlement_transaction_type; Type: table; TableName: settlement_transaction_type;
--

CREATE TABLE settlement_transaction_type (value varchar(128) PRIMARY KEY);



--
-- Name: user_api_status; Type: table; TableName: user_api_status;
--

CREATE TABLE user_api_status (value varchar(128) PRIMARY KEY);



--
-- Name: user_status; Type: table; TableName: user_status;
--

CREATE TABLE user_status (value varchar(128) PRIMARY KEY);



--
-- Name: ach_batch; Type: table; TableName: ach_batch;
--

CREATE TABLE ach_batch (
    ach_batch_id character varying(36) PRIMARY KEY NOT NULL,
    ach_batch_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    ach_batch_ach_file_id character varying(36) NOT NULL,
    ach_batch_header_service_class_code character(3) DEFAULT NULL,
    ach_batch_header_company_name character varying(125) DEFAULT NULL,
    ach_batch_header_discretionary_data character varying(20) DEFAULT NULL,
    ach_batch_header_company_identification character varying(125) DEFAULT NULL,
    ach_batch_header_standard_entry_class character(3) DEFAULT NULL,
    ach_batch_header_company_entry_description character varying(10) DEFAULT NULL,
    ach_batch_header_company_descriptive_date character varying(6) DEFAULT NULL,
    ach_batch_header_effective_entry_date character varying(6) DEFAULT NULL,
    ach_batch_header_settlement_date character(3) DEFAULT NULL,
    ach_batch_header_originator_status_code character(1) DEFAULT NULL,
    ach_batch_header_originating_dfi_id character varying(8) DEFAULT NULL,
    ach_batch_header_batch_number character varying(7) DEFAULT NULL,
    ach_batch_control_entry_addenda_count character varying(6) DEFAULT NULL,
    ach_batch_control_entry_hash character varying(10) DEFAULT NULL,
    ach_batch_control_total_debits character varying(12) DEFAULT NULL,
    ach_batch_control_total_credits character varying(12) DEFAULT NULL,
    ach_batch_control_message_authentication_code character varying(19) DEFAULT NULL,
    ach_batch_iat_indicator character varying(16) DEFAULT NULL,
    ach_batch_iat_foreign_exchange_indicator character(2) DEFAULT NULL,
    ach_batch_iat_foreign_exchange_ref_indicator character(1) DEFAULT NULL,
    ach_batch_iat_foreign_exchange_rate_ref character varying(15) DEFAULT NULL,
    ach_batch_iat_iso_dest_country_code character(3) DEFAULT NULL,
    ach_batch_iat_iso_orig_currency_code character(3) DEFAULT NULL,
    ach_batch_iat_iso_dest_currency_code character(3) DEFAULT NULL,
    ach_batch_payment_type_id character varying(36) DEFAULT '' NOT NULL,
    ach_batch_originator_info_id character varying(36) NOT NULL
);



--
-- Name: ach_batch_log; Type: table; TableName: ach_batch_log;
--

CREATE TABLE ach_batch_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    ach_batch_id character varying(36) NOT NULL,
    ach_batch_header_company_descriptive_date character varying(6) DEFAULT NULL,
    ach_batch_header_effective_entry_date character varying(6) DEFAULT NULL,
    ach_batch_header_batch_number character varying(7) DEFAULT NULL,
    ach_batch_control_entry_addenda_count character varying(6) DEFAULT NULL,
    ach_batch_control_entry_hash character varying(10) DEFAULT NULL,
    ach_batch_control_total_debits character varying(12) DEFAULT NULL,
    ach_batch_control_total_credits character varying(12) DEFAULT NULL,
    ach_batch_payment_type_id character varying(36) DEFAULT '' NOT NULL,
    ach_batch_originator_info_id character varying(36) DEFAULT '' NOT NULL
);


--
-- Name: ach_entry; Type: table; TableName: ach_entry;
--

CREATE TABLE ach_entry (
    ach_entry_id character varying(36) NOT NULL UNIQUE,
    ach_entry_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    ach_entry_status varchar(128) DEFAULT 'pending' NOT NULL,
    ach_entry_ach_batch_id character varying(36),
    ach_entry_odfi_branch_id character varying(36) NOT NULL,
    ach_entry_external_account_id character varying(36) NOT NULL,
    ach_entry_payment_schedule_id character varying(36) DEFAULT '' NOT NULL,
    ach_entry_detail_transaction_code character(2) DEFAULT NULL,
    ach_entry_detail_receiving_dfi_id character varying(125) DEFAULT NULL,
    ach_entry_detail_receiving_dfi_id_check_digit character(1) DEFAULT NULL,
    ach_entry_detail_dfi_account_number character varying(125) DEFAULT NULL,
    ach_entry_detail_amount character varying(18) DEFAULT NULL,
    ach_entry_detail_individual_id_number character varying(15) DEFAULT NULL,
    ach_entry_detail_individual_name character varying(125) DEFAULT NULL,
    ach_entry_detail_discretionary_data character(2) DEFAULT NULL,
    ach_entry_detail_addenda_record_indicator character(1) DEFAULT NULL,
    ach_entry_detail_trace_number INTEGER PRIMARY KEY,
    ach_entry_addenda_type_code character(2) DEFAULT NULL,
    ach_entry_addenda_payment_info character varying(300) DEFAULT NULL,
    ach_entry_iat_go_receiving_dfi_id character varying(8) DEFAULT NULL,
    ach_entry_iat_go_receiving_dfi_id_check_digit character(1) DEFAULT NULL,
    ach_entry_iat_ofac_screening_indicator character(1) DEFAULT NULL,
    ach_entry_iat_secondary_ofac_screening_indicator character(1) DEFAULT NULL,
    ach_entry_iat_transaction_type_code character(3) DEFAULT NULL,
    ach_entry_iat_foreign_trace_number character varying(22) DEFAULT NULL,
    ach_entry_iat_originator_name character varying(125) DEFAULT NULL,
    ach_entry_iat_originator_street_addr character varying(125) DEFAULT NULL,
    ach_entry_iat_originator_city character varying(125) DEFAULT NULL,
    ach_entry_iat_originator_state_province character varying(125) DEFAULT NULL,
    ach_entry_iat_originator_postal_code character varying(125) DEFAULT NULL,
    ach_entry_iat_originator_country character varying(125) DEFAULT NULL,
    ach_entry_iat_originating_dfi_name character varying(125) DEFAULT NULL,
    ach_entry_iat_originating_dfi_id character varying(125) DEFAULT NULL,
    ach_entry_iat_originating_dfi_id_qualifier character varying(2) DEFAULT NULL,
    ach_entry_iat_originating_dfi_country_code character varying(3) DEFAULT NULL,
    ach_entry_iat_receiving_dfi_name character varying(125) DEFAULT NULL,
    ach_entry_iat_receiving_dfi_id character varying(125) DEFAULT NULL,
    ach_entry_iat_receiving_dfi_id_qualifier character varying(2) DEFAULT NULL,
    ach_entry_iat_receiving_dfi_country_code character varying(3) DEFAULT NULL,
    ach_entry_iat_receiver_street_addr character varying(125) DEFAULT NULL,
    ach_entry_iat_receiver_city character varying(125) DEFAULT NULL,
    ach_entry_iat_receiver_state_province character varying(125) DEFAULT NULL,
    ach_entry_iat_receiver_postal_code character varying(125) DEFAULT NULL,
    ach_entry_iat_receiver_country character varying(125) DEFAULT NULL
    , FOREIGN KEY (ach_entry_status) REFERENCES ach_entry_status(value) ON UPDATE CASCADE
);



--
-- Name: ach_entry_log; Type: table; TableName: ach_entry_log;
--

CREATE TABLE ach_entry_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    ach_entry_id character varying(36) NOT NULL,
    ach_entry_status ach_entry_status DEFAULT 'pending' NOT NULL,
    ach_entry_detail_transaction_code character(2) DEFAULT NULL,
    ach_entry_detail_amount character varying(18) DEFAULT NULL,
    ach_entry_detail_addenda_record_indicator character(1) DEFAULT NULL,
    ach_entry_detail_trace_number bigint,
    ach_entry_iat_foreign_trace_number character varying(22) DEFAULT NULL
);


--
-- Name: ach_entry_return; Type: table; TableName: ach_entry_return;
--

CREATE TABLE ach_entry_return (
    ach_entry_return_id character varying(36) NOT NULL,
    ach_entry_return_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    ach_entry_return_odfi_branch_id character varying(36) NOT NULL,
    ach_entry_return_ach_entry_id character varying(36) PRIMARY KEY NOT NULL,
    ach_entry_return_reassigned_trace_number character varying(15) DEFAULT NULL,
    ach_entry_return_date_of_death character varying(6) DEFAULT NULL,
    ach_entry_return_original_dfi_id character varying(8) DEFAULT NULL,
    ach_entry_return_trace_number character varying(15) DEFAULT NULL,
    ach_entry_return_return_reason_code character varying(3) DEFAULT NULL,
    ach_entry_return_change_code character varying(3) DEFAULT NULL,
    ach_entry_return_corrected_data character varying(29) DEFAULT NULL,
    ach_entry_return_addenda_information character varying(44) DEFAULT NULL
);



--
-- Name: ach_file; Type: table; TableName: ach_file;
--

CREATE TABLE ach_file (
    ach_file_id character varying(36) PRIMARY KEY NOT NULL,
    ach_file_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    ach_file_status ach_file_status DEFAULT 'pending' NOT NULL,
    ach_file_odfi_branch_id character varying(36) NOT NULL,
    ach_file_originator_id character varying(36) NOT NULL,
    ach_file_header_priority_code character(2) DEFAULT '01' NOT NULL,
    ach_file_header_immediate_destination character varying(125) DEFAULT NULL,
    ach_file_header_immediate_origin character varying(125) DEFAULT NULL,
    ach_file_header_file_creation_date character varying(6) DEFAULT NULL,
    ach_file_header_file_creation_time character varying(4) DEFAULT NULL,
    ach_file_header_file_id_modifier character(1) DEFAULT NULL,
    ach_file_header_record_size character(3) DEFAULT '094',
    ach_file_header_blocking_factor character(2) DEFAULT '10',
    ach_file_header_format_code character(1) DEFAULT '1',
    ach_file_header_immediate_destination_name character varying(256) DEFAULT NULL,
    ach_file_header_immediate_origin_name character varying(256) DEFAULT NULL,
    ach_file_header_reference_code character varying(8) DEFAULT NULL,
    ach_file_control_batch_count character varying(6) DEFAULT NULL,
    ach_file_control_block_count character varying(6) DEFAULT NULL,
    ach_file_control_entry_addenda_count character varying(8) DEFAULT NULL,
    ach_file_control_entry_hash character varying(10) DEFAULT NULL,
    ach_file_control_total_debits character varying(12) DEFAULT NULL,
    ach_file_control_total_credits character varying(12) DEFAULT NULL
    , FOREIGN KEY (ach_file_status) REFERENCES ach_file_status(value) ON UPDATE CASCADE
);



--
-- Name: ach_file_conf; Type: table; TableName: ach_file_conf;
--

CREATE TABLE ach_file_conf (
    ach_file_conf_id character varying(36) PRIMARY KEY NOT NULL,
    ach_file_conf_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    ach_file_conf_odfi_branch_id character varying(36) NOT NULL,
    ach_file_conf_status ach_file_conf_status DEFAULT 'pending' NOT NULL,
    ach_file_conf_date character varying(6) DEFAULT NULL,
    ach_file_conf_time character varying(6) DEFAULT NULL,
    ach_file_conf_batch_count character varying(6) DEFAULT NULL,
    ach_file_conf_batch_item_count character varying(4) DEFAULT NULL,
    ach_file_conf_block_count character varying(6) DEFAULT NULL,
    ach_file_conf_error_message_number character varying(10) DEFAULT NULL,
    ach_file_conf_error_message text,
    ach_file_conf_total_debits character varying(12) DEFAULT NULL,
    ach_file_conf_total_credits character varying(12) DEFAULT NULL
    , FOREIGN KEY (ach_file_conf_status) REFERENCES ach_file_conf_status(value) ON UPDATE CASCADE
);



--
-- Name: ach_file_log; Type: table; TableName: ach_file_log;
--

CREATE TABLE ach_file_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    ach_file_id character varying(36) NOT NULL,
    ach_file_status ach_file_status DEFAULT 'pending' NOT NULL,
    ach_file_header_file_creation_date character varying(6) DEFAULT NULL,
    ach_file_header_file_creation_time character varying(4) DEFAULT NULL,
    ach_file_header_file_id_modifier character(1) DEFAULT NULL,
    ach_file_header_reference_code character varying(8) DEFAULT NULL,
    ach_file_control_batch_count character varying(6) DEFAULT NULL,
    ach_file_control_block_count character varying(6) DEFAULT NULL,
    ach_file_control_entry_addenda_count character varying(8) DEFAULT NULL,
    ach_file_control_entry_hash character varying(10) DEFAULT NULL,
    ach_file_control_total_debits character varying(12) DEFAULT NULL,
    ach_file_control_total_credits character varying(12) DEFAULT NULL
    , FOREIGN KEY (ach_file_status) REFERENCES ach_file_status(value) ON UPDATE CASCADE
);


--
-- Name: app_log; Type: table; TableName: app_log;
--

CREATE TABLE app_log (
    app_log_id character varying(36) PRIMARY KEY NOT NULL,
    app_log_datetime timestamp,
    app_log_message character varying(255) DEFAULT '' NOT NULL
);



--
-- Name: auth_assignment; Type: table; TableName: auth_assignment;
--

CREATE TABLE auth_assignment (
    auth_assignment_itemname character varying(64) NOT NULL REFERENCES auth_item(auth_item_name),
    auth_assignment_userid character varying(64) NOT NULL,
    auth_assignment_bizrule text,
    auth_assignment_data text
    , PRIMARY KEY (auth_assignment_itemname, auth_assignment_userid)
    , FOREIGN KEY (auth_assignment_itemname) REFERENCES auth_item(auth_item_name) ON UPDATE CASCADE ON DELETE CASCADE
);



--
-- Name: auth_item; Type: table; TableName: auth_item;
--

CREATE TABLE auth_item (
    auth_item_name character varying(64) PRIMARY KEY NOT NULL,
    auth_item_type integer NOT NULL,
    auth_item_description text,
    auth_item_bizrule text,
    auth_item_data text
);



--
-- Name: auth_item_tree; Type: table; TableName: auth_item_tree;
--

CREATE TABLE auth_item_tree (
    auth_item_tree_parent character varying(64) NOT NULL,
    auth_item_tree_child character varying(64) NOT NULL
    , PRIMARY KEY (auth_item_tree_parent, auth_item_tree_child)
    , FOREIGN KEY (auth_item_tree_parent) REFERENCES auth_item(auth_item_name) ON UPDATE CASCADE ON DELETE CASCADE
    , FOREIGN KEY (auth_item_tree_child) REFERENCES auth_item(auth_item_name) ON UPDATE CASCADE ON DELETE CASCADE
);



--
-- Name: entity_index; Type: table; TableName: entity_index;
--

CREATE TABLE entity_index (
    entity_index_id character varying(64) PRIMARY KEY NOT NULL,
    entity_index_next_id bigint DEFAULT (0) NOT NULL
);



--
-- Name: external_account; Type: table; TableName: external_account;
--

CREATE TABLE external_account (
    external_account_id character varying(36) PRIMARY KEY NOT NULL,
    external_account_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    external_account_payment_profile_id character varying(36) NOT NULL,
    external_account_type external_account_type NOT NULL,
    external_account_name character varying(250) DEFAULT NULL,
    external_account_bank character varying(250) DEFAULT NULL,
    external_account_holder character varying(250) DEFAULT NULL,
    external_account_country_code character varying(2) DEFAULT NULL,
    external_account_dfi_id character varying(125) DEFAULT NULL,
    external_account_dfi_id_qualifier TEXT DEFAULT '01' NOT NULL,
    external_account_number character varying(125) DEFAULT NULL,
    external_account_billing_address character varying(255) DEFAULT NULL,
    external_account_billing_city character varying(255) DEFAULT NULL,
    external_account_billing_state_province character varying(35) DEFAULT NULL,
    external_account_billing_postal_code character varying(35) DEFAULT NULL,
    external_account_billing_country character varying(2) DEFAULT NULL,
    external_account_verification_status external_account_verification_status DEFAULT 'pending' NOT NULL,
    external_account_status external_account_status DEFAULT 'enabled' NOT NULL,
    external_account_originator_info_id character varying(36) DEFAULT '' NOT NULL,
    external_account_business smallint DEFAULT 0 NOT NULL,
    external_account_allow_originator_payments smallint DEFAULT 0 NOT NULL
    , FOREIGN KEY (external_account_type) REFERENCES external_account_type(value) ON UPDATE CASCADE
    , FOREIGN KEY (external_account_dfi_id_qualifier) REFERENCES external_account_dfi_id_qualifier(value) ON UPDATE CASCADE
    , FOREIGN KEY (external_account_verification_status) REFERENCES external_account_verification_status(value) ON UPDATE CASCADE
    , FOREIGN KEY (external_account_status) REFERENCES external_account_status(value) ON UPDATE CASCADE
);



--
-- Name: external_account_log; Type: table; TableName: external_account_log;
--

CREATE TABLE external_account_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    external_account_id character varying(36) NOT NULL,
    external_account_payment_profile_id character varying(36) NOT NULL,
    external_account_type external_account_type NOT NULL,
    external_account_name character varying(125) DEFAULT NULL,
    external_account_bank character varying(125) DEFAULT NULL,
    external_account_holder character varying(125) DEFAULT NULL,
    external_account_country_code character varying(2) DEFAULT NULL,
    external_account_dfi_id character varying(125) DEFAULT NULL,
    external_account_dfi_id_qualifier TEXT DEFAULT '01' NOT NULL,
    external_account_number character varying(125) DEFAULT NULL,
    external_account_billing_address character varying(255) DEFAULT NULL,
    external_account_billing_city character varying(255) DEFAULT NULL,
    external_account_billing_state_province character varying(35) DEFAULT NULL,
    external_account_billing_postal_code character varying(35) DEFAULT NULL,
    external_account_billing_country character varying(2) DEFAULT NULL,
    external_account_business smallint DEFAULT (0) NOT NULL,
    external_account_verification_status external_account_verification_status DEFAULT 'pending' NOT NULL,
    external_account_status external_account_status DEFAULT 'enabled' NOT NULL,
    external_account_originator_info_id character varying(36) DEFAULT '' NOT NULL,
    external_account_allow_originator_payments smallint DEFAULT 0 NOT NULL
    , FOREIGN KEY (external_account_type) REFERENCES external_account_type(value) ON UPDATE CASCADE
    , FOREIGN KEY (external_account_dfi_id_qualifier) REFERENCES external_account_dfi_id_qualifier(value) ON UPDATE CASCADE
    , FOREIGN KEY (external_account_verification_status) REFERENCES external_account_verification_status(value) ON UPDATE CASCADE
    , FOREIGN KEY (external_account_status) REFERENCES external_account_status(value) ON UPDATE CASCADE
);


--
-- Name: fedach; Type: table; TableName: fedach;
--

CREATE TABLE fedach (
    fedach_routing_number character(9) PRIMARY KEY NOT NULL,
    fedach_office_code character(1) NOT NULL,
    fedach_servicing_frb_number character(9) NOT NULL,
    fedach_record_type_code character(1) NOT NULL,
    fedach_change_date character(6) NOT NULL,
    fedach_new_routing_number character(9) NOT NULL,
    fedach_customer_name character varying(36) NOT NULL,
    fedach_address character varying(36) NOT NULL,
    fedach_city character varying(20) NOT NULL,
    fedach_state_province character(2) NOT NULL,
    fedach_postal_code character(5) NOT NULL,
    fedach_postal_code_extension character(4) NOT NULL,
    fedach_phone_number character varying(10) NOT NULL,
    fedach_institution_status_code character(1) NOT NULL,
    fedach_data_view_code character(1) NOT NULL
);



--
-- Name: fedwire; Type: table; TableName: fedwire;
--

CREATE TABLE fedwire (
    fedwire_routing_number character(9) PRIMARY KEY NOT NULL,
    fedwire_telegraphic_name character varying(18) NOT NULL,
    fedwire_customer_name character varying(36) NOT NULL,
    fedwire_state_province character(2) NOT NULL,
    fedwire_city character varying(25) NOT NULL,
    fedwire_funds_transfer_status character(1) NOT NULL,
    fedwire_settlement_only_status character(1) NOT NULL,
    fedwire_securities_transfer_status character(1) NOT NULL,
    fedwire_revision_date character(8) NOT NULL
);



--
-- Name: file_transfer; Type: table; TableName: file_transfer;
--

CREATE TABLE file_transfer (
    file_transfer_id character varying(36) NOT NULL,
    file_transfer_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    file_transfer_file_id character varying(36) NOT NULL,
    file_transfer_model character varying(50) NOT NULL,
    file_transfer_status file_transfer_status,
    file_transfer_plugin character varying(36) NOT NULL,
    file_transfer_message text NOT NULL,
    file_transfer_data text
    , FOREIGN KEY (file_transfer_status) REFERENCES file_transfer_status(value) ON UPDATE CASCADE
);


--
-- Name: file_transfer_log; Type: table; TableName: file_transfer_log;
--

CREATE TABLE file_transfer_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    file_transfer_id character varying(36) NOT NULL,
    file_transfer_status file_transfer_status
    , FOREIGN KEY (file_transfer_status) REFERENCES file_transfer_status(value) ON UPDATE CASCADE
);


--
-- Name: menu_item; Type: table; TableName: menu_item;
--

CREATE TABLE menu_item (
    menu_item_id character varying(36) PRIMARY KEY NOT NULL,
    menu_item_component character varying(50) NOT NULL,
    menu_item_group character varying(50) NOT NULL,
    menu_item_parent_id character varying(36) DEFAULT NULL,
    menu_item_path character varying(50) DEFAULT NULL,
    menu_item_class character varying(50) DEFAULT NULL,
    menu_item_icon character varying(255) DEFAULT NULL,
    menu_item_label character varying(255) NOT NULL,
    menu_item_text text NOT NULL,
    menu_item_weight smallint DEFAULT (0) NOT NULL,
    menu_item_require_role character varying(50) DEFAULT '' NOT NULL
);



--
-- Name: odfi_branch; Type: table; TableName: odfi_branch;
--

CREATE TABLE odfi_branch (
    odfi_branch_id character varying(36) PRIMARY KEY NOT NULL,
    odfi_branch_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    odfi_branch_originator_id character varying(36) NOT NULL,
    odfi_branch_friendly_name character varying(50) DEFAULT NULL,
    odfi_branch_name character varying(35) DEFAULT NULL,
    odfi_branch_city character varying(35) DEFAULT NULL,
    odfi_branch_state_province character varying(35) DEFAULT NULL,
    odfi_branch_country_code character(2) DEFAULT NULL,
    odfi_branch_dfi_id character varying(125) DEFAULT NULL,
    odfi_branch_dfi_id_qualifier TEXT,
    odfi_branch_go_dfi_id character varying(9) DEFAULT NULL,
    odfi_branch_status odfi_branch_status DEFAULT 'enabled' NOT NULL,
    odfi_branch_plugin character varying(36) DEFAULT '' NOT NULL
    , FOREIGN KEY (odfi_branch_dfi_id_qualifier) REFERENCES odfi_branch_dfi_id_qualifier(value) ON UPDATE CASCADE
);



--
-- Name: odfi_branch_log; Type: table; TableName: odfi_branch_log;
--

CREATE TABLE odfi_branch_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    odfi_branch_id character varying(36) NOT NULL,
    odfi_branch_friendly_name character varying(50) DEFAULT NULL,
    odfi_branch_name character varying(35) DEFAULT NULL,
    odfi_branch_city character varying(35) DEFAULT NULL,
    odfi_branch_state_province character varying(35) DEFAULT NULL,
    odfi_branch_country_code character(2) DEFAULT NULL,
    odfi_branch_dfi_id character varying(125) DEFAULT NULL,
    odfi_branch_dfi_id_qualifier TEXT,
    odfi_branch_go_dfi_id character varying(9) DEFAULT NULL,
    odfi_branch_status odfi_branch_status DEFAULT 'enabled' NOT NULL,
    odfi_branch_plugin character varying(36) DEFAULT '' NOT NULL
    , FOREIGN KEY (odfi_branch_dfi_id_qualifier) REFERENCES odfi_branch_dfi_id_qualifier(value) ON UPDATE CASCADE
    , FOREIGN KEY (odfi_branch_status) REFERENCES odfi_branch_status(value) ON UPDATE CASCADE
);


--
-- Name: ofac_add; Type: table; TableName: ofac_add;
--

CREATE TABLE ofac_add (
    ofac_add_ent_num integer NOT NULL,
    ofac_add_num integer PRIMARY KEY NOT NULL,
    ofac_add_address character varying(750) NOT NULL,
    ofac_add_city character varying(116) NOT NULL,
    ofac_add_state_province character varying(116) NOT NULL,
    ofac_add_postal_code character varying(116) NOT NULL,
    ofac_add_country character varying(250) NOT NULL,
    ofac_add_remarks character varying(200) NOT NULL
);


--
-- Name: ofac_alt; Type: table; TableName: ofac_alt;
--

CREATE TABLE ofac_alt (
    ofac_alt_ent_num integer NOT NULL,
    ofac_alt_num integer PRIMARY KEY NOT NULL,
    ofac_alt_type character varying(8) NOT NULL,
    ofac_alt_name character varying(350) NOT NULL,
    ofac_alt_remarks character varying(200) NOT NULL
);


--
-- Name: ofac_sdn; Type: table; TableName: ofac_sdn;
--

CREATE TABLE ofac_sdn (
    ofac_sdn_ent_num integer PRIMARY KEY NOT NULL,
    ofac_sdn_name character varying(350) NOT NULL,
    ofac_sdn_type character varying(12) NOT NULL,
    ofac_sdn_program character varying(50) NOT NULL,
    ofac_sdn_title character varying(200) NOT NULL,
    ofac_sdn_call_sign character varying(8) NOT NULL,
    ofac_sdn_vess_type character varying(25) NOT NULL,
    ofac_sdn_tonnage character varying(14) NOT NULL,
    ofac_sdn_grt character varying(8) NOT NULL,
    ofac_sdn_vess_flag character varying(40) NOT NULL,
    ofac_sdn_vess_owner character varying(150) NOT NULL,
    ofac_sdn_remarks character varying(1000) NOT NULL
);


--
-- Name: originator; Type: table; TableName: originator;
--

CREATE TABLE originator (
    originator_id character varying(36) PRIMARY KEY NOT NULL,
    originator_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    originator_user_id character varying(36) NOT NULL,
    originator_name character varying(255) DEFAULT NULL,
    originator_identification character varying(255) DEFAULT NULL,
    originator_address character varying(255) DEFAULT NULL,
    originator_city character varying(35) DEFAULT NULL,
    originator_state_province character varying(35) DEFAULT NULL,
    originator_postal_code character varying(35) DEFAULT NULL,
    originator_country_code character(2) DEFAULT NULL
);



--
-- Name: originator_info; Type: table; TableName: originator_info;
--

CREATE TABLE originator_info (
    originator_info_id character varying(36) PRIMARY KEY NOT NULL,
    originator_info_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    originator_info_odfi_branch_id character varying(36) NOT NULL,
    originator_info_originator_id character varying(36) NOT NULL,
    originator_info_name character varying(255) DEFAULT NULL,
    originator_info_description text,
    originator_info_identification character varying(255) DEFAULT NULL,
    originator_info_address character varying(255) DEFAULT NULL,
    originator_info_city character varying(35) DEFAULT NULL,
    originator_info_state_province character varying(35) DEFAULT NULL,
    originator_info_postal_code character varying(35) DEFAULT NULL,
    originator_info_country_code character(2) DEFAULT NULL,
    originator_info_name_hash character varying(40) DEFAULT '',
    originator_info_identification_hash character varying(40) DEFAULT ''
);



--
-- Name: originator_info_log; Type: table; TableName: originator_info_log;
--

CREATE TABLE originator_info_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    originator_info_id character varying(36) NOT NULL,
    originator_info_odfi_branch_id character varying(36) NOT NULL,
    originator_info_name character varying(255) DEFAULT NULL,
    originator_info_identification character varying(255) DEFAULT NULL,
    originator_info_address character varying(255) DEFAULT NULL,
    originator_info_city character varying(35) DEFAULT NULL,
    originator_info_state_province character varying(35) DEFAULT NULL,
    originator_info_postal_code character varying(35) DEFAULT NULL,
    originator_info_country_code character(2) DEFAULT NULL
);


--
-- Name: originator_log; Type: table; TableName: originator_log;
--

CREATE TABLE originator_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    originator_id character varying(36) NOT NULL,
    originator_user_id character varying(36) NOT NULL,
    originator_name character varying(255) DEFAULT NULL,
    originator_identification character varying(255) DEFAULT NULL,
    originator_address character varying(255) DEFAULT NULL,
    originator_city character varying(35) DEFAULT NULL,
    originator_state_province character varying(35) DEFAULT NULL,
    originator_postal_code character varying(35) DEFAULT NULL,
    originator_country_code character(2) DEFAULT NULL
);


--
-- Name: payment_event_log; Type: table; TableName: payment_event_log;
--

CREATE TABLE payment_event_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    ach_entry_id character varying(36) NOT NULL,
    payment_schedule_id character varying(36) NOT NULL,
    payment_schedule_external_account_id character varying(36) NOT NULL,
    payment_schedule_payment_type_id character varying(36) NOT NULL,
    payment_schedule_amount numeric(19,2) DEFAULT 0.00 NOT NULL
);


--
-- Name: payment_profile; Type: table; TableName: payment_profile;
--

CREATE TABLE payment_profile (
    payment_profile_id character varying(36) PRIMARY KEY NOT NULL,
    payment_profile_originator_info_id character varying(36) NOT NULL,
    payment_profile_external_id character varying(255) NOT NULL,
    payment_profile_password character varying(255) DEFAULT NULL,
    payment_profile_first_name character varying(255) DEFAULT NULL,
    payment_profile_last_name character varying(255) DEFAULT NULL,
    payment_profile_email_address character varying(255) NOT NULL,
    payment_profile_security_question_1 character varying(255) DEFAULT NULL,
    payment_profile_security_question_2 character varying(255) DEFAULT NULL,
    payment_profile_security_question_3 character varying(255) DEFAULT NULL,
    payment_profile_security_answer_1 character varying(255) DEFAULT NULL,
    payment_profile_security_answer_2 character varying(255) DEFAULT NULL,
    payment_profile_security_answer_3 character varying(255) DEFAULT NULL,
    payment_profile_status payment_profile_status DEFAULT 'enabled' NOT NULL,
    payment_profile_first_name_hash character varying(40) DEFAULT '' NOT NULL,
    payment_profile_last_name_hash character varying(40) DEFAULT '' NOT NULL
    , FOREIGN KEY (payment_profile_status) REFERENCES payment_profile_status(value) ON UPDATE CASCADE
);



--
-- Name: payment_profile_log; Type: table; TableName: payment_profile_log;
--

CREATE TABLE payment_profile_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    payment_profile_id character varying(36) NOT NULL,
    payment_profile_external_id character varying(125) NOT NULL,
    payment_profile_first_name character varying(255) DEFAULT NULL,
    payment_profile_last_name character varying(255) DEFAULT NULL,
    payment_profile_email_address character varying(255) NOT NULL,
    payment_profile_status payment_profile_status DEFAULT 'enabled' NOT NULL
    , FOREIGN KEY (payment_profile_status) REFERENCES payment_profile_status(value) ON UPDATE CASCADE
);


--
-- Name: payment_schedule; Type: table; TableName: payment_schedule;
--

CREATE TABLE payment_schedule (
    payment_schedule_id character varying(36) PRIMARY KEY NOT NULL,
    payment_schedule_external_account_id character varying(36) NOT NULL,
    payment_schedule_payment_type_id character varying(36) NOT NULL,
    payment_schedule_status payment_schedule_status NOT NULL,
    payment_schedule_amount numeric(19,2) DEFAULT 0.00 NOT NULL,
    payment_schedule_currency_code character(3) DEFAULT '' NOT NULL,
    payment_schedule_next_date date NOT NULL,
    payment_schedule_frequency payment_schedule_frequency,
    payment_schedule_end_date date NOT NULL,
    payment_schedule_remaining_occurrences smallint DEFAULT (1) NOT NULL
    , FOREIGN KEY (payment_schedule_status) REFERENCES payment_schedule_status(value) ON UPDATE CASCADE
    , FOREIGN KEY (payment_schedule_frequency) REFERENCES payment_schedule_frequency(value) ON UPDATE CASCADE
);



--
-- Name: payment_schedule_log; Type: table; TableName: payment_schedule_log;
--

CREATE TABLE payment_schedule_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    payment_schedule_id character varying(36) NOT NULL,
    payment_schedule_external_account_id character varying(36) NOT NULL,
    payment_schedule_payment_type_id character varying(36) NOT NULL,
    payment_schedule_status payment_schedule_status NOT NULL,
    payment_schedule_amount numeric(19,2) DEFAULT 0.00 NOT NULL,
    payment_schedule_currency_code character(3) DEFAULT '' NOT NULL,
    payment_schedule_next_date date NOT NULL,
    payment_schedule_frequency payment_schedule_frequency,
    payment_schedule_end_date date NOT NULL,
    payment_schedule_remaining_occurrences smallint DEFAULT (1) NOT NULL
    , FOREIGN KEY (payment_schedule_status) REFERENCES payment_schedule_status(value) ON UPDATE CASCADE
    , FOREIGN KEY (payment_schedule_frequency) REFERENCES payment_schedule_frequency(value) ON UPDATE CASCADE
);


--
-- Name: payment_type; Type: table; TableName: payment_type;
--

CREATE TABLE payment_type (
    payment_type_id character varying(36) PRIMARY KEY NOT NULL,
    payment_type_originator_info_id character varying(36) NOT NULL,
    payment_type_name character varying(10) NOT NULL,
    payment_type_transaction_type payment_type_transaction_type DEFAULT 'debit' NOT NULL,
    payment_type_status payment_type_status DEFAULT 'enabled' NOT NULL,
    payment_type_description character varying(255) DEFAULT '' NOT NULL,
    payment_type_external_account_id character varying(36) DEFAULT '' NOT NULL
    , FOREIGN KEY (payment_type_status) REFERENCES payment_type_status(value) ON UPDATE CASCADE
    , FOREIGN KEY (payment_type_transaction_type) REFERENCES payment_type_transaction_type(value) ON UPDATE CASCADE
);



--
-- Name: payment_type_log; Type: table; TableName: payment_type_log;
--

CREATE TABLE payment_type_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    payment_type_id character varying(36) NOT NULL,
    payment_type_name character varying(10) NOT NULL,
    payment_type_transaction_type payment_type_transaction_type DEFAULT 'debit' NOT NULL,
    payment_type_status payment_type_status DEFAULT 'enabled' NOT NULL,
    payment_type_description character varying(255) DEFAULT '' NOT NULL,
    payment_type_external_account_id character varying(36) DEFAULT '' NOT NULL
    , FOREIGN KEY (payment_type_status) REFERENCES payment_type_status(value) ON UPDATE CASCADE
    , FOREIGN KEY (payment_type_transaction_type) REFERENCES payment_type_transaction_type(value) ON UPDATE CASCADE
);


--
-- Name: phonetic_data; Type: table; TableName: phonetic_data;
--

CREATE TABLE phonetic_data (
    phonetic_data_id character varying(36) PRIMARY KEY NOT NULL,
    phonetic_data_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    phonetic_data_entity_class character varying(50) NOT NULL,
    phonetic_data_entity_id character varying(36) NOT NULL,
    phonetic_data_entity_field character varying(50) DEFAULT NULL,
    phonetic_data_encoding_method phonetic_data_encoding_method NOT NULL,
    phonetic_data_key character varying(255) NOT NULL,
    phonetic_data_type character varying(50) NOT NULL
    , FOREIGN KEY (phonetic_data_encoding_method) REFERENCES phonetic_data_encoding_method(value) ON UPDATE CASCADE
);



--
-- Name: phonetic_filtered; Type: view; TableName: phonetic_filtered;
--

CREATE VIEW phonetic_filtered AS 
    SELECT source.phonetic_data_entity_class AS filtered_source_entity_class
        , source.phonetic_data_entity_id AS filtered_source_entity_id
        , result.phonetic_data_entity_class AS filtered_result_entity_class
        , result.phonetic_data_entity_id AS filtered_result_entity_id
        , 'name' AS data_type
        , count(source.phonetic_data_key) AS total_hits
    FROM phonetic_data source
        JOIN phonetic_data result ON source.phonetic_data_encoding_method = result.phonetic_data_encoding_method
            AND source.phonetic_data_type = result.phonetic_data_type AND source.phonetic_data_key = result.phonetic_data_key
            AND (result.phonetic_data_entity_class in (select 'OfacSdn' value UNION select 'OfacAlt')) 
    WHERE
        (source.phonetic_data_entity_class not in (select 'OfacSdn' value UNION select 'OfacAlt')) 
        AND (source.phonetic_data_type in (select 'last_name' value UNION select 'first_name')) 
    GROUP BY result.phonetic_data_entity_class, source.phonetic_data_entity_class, source.phonetic_data_entity_id, result.phonetic_data_entity_id
    HAVING count(source.phonetic_data_key) >= 5
UNION 
    SELECT source.phonetic_data_entity_class AS filtered_source_entity_class
        , source.phonetic_data_entity_id AS filtered_source_entity_id
        , result.phonetic_data_entity_class AS filtered_result_entity_class
        , result.phonetic_data_entity_id AS filtered_result_entity_id
        , 'company' AS data_type
        , count(source.phonetic_data_key) AS total_hits
    FROM phonetic_data source
        JOIN phonetic_data result ON source.phonetic_data_encoding_method = result.phonetic_data_encoding_method 
            AND source.phonetic_data_type = result.phonetic_data_type AND source.phonetic_data_key = result.phonetic_data_key
            AND (result.phonetic_data_entity_class in (select 'OfacSdn' UNION select 'OfacAlt')) 
    WHERE
        (source.phonetic_data_entity_class not in (select 'OfacSdn' UNION select 'OfacAlt')) 
        AND source.phonetic_data_type = 'company'
    GROUP BY result.phonetic_data_entity_class, source.phonetic_data_entity_class, source.phonetic_data_entity_id, result.phonetic_data_entity_id
    HAVING count(source.phonetic_data_key) >= 2;


--
-- Name: plugin; Type: table; TableName: plugin;
--

CREATE TABLE plugin (
    plugin_id character varying(36) PRIMARY KEY NOT NULL,
    plugin_status plugin_status DEFAULT 'enabled' NOT NULL,
    plugin_class character varying(36) NOT NULL,
    plugin_version character varying(36) NOT NULL
);



--
-- Name: plugin_config; Type: table; TableName: plugin_config;
--

CREATE TABLE plugin_config (
    plugin_config_id character varying(36) PRIMARY KEY NOT NULL,
    plugin_config_plugin_id character varying(36) NOT NULL,
    plugin_config_parent_id character varying(36) NOT NULL,
    plugin_config_parent_model character varying(50) NOT NULL,
    plugin_config_key character varying(255) NOT NULL,
    plugin_config_value character varying(2500) NOT NULL,
    plugin_config_weight integer DEFAULT 0 NOT NULL
);



--
-- Name: return_change; Type: table; TableName: return_change;
--

CREATE TABLE return_change (
    return_change_code character(3) PRIMARY KEY NOT NULL,
    return_change_title character varying(150),
    return_change_description text NOT NULL
);



--
-- Name: role; Type: table; TableName: role;
--

CREATE TABLE role (
    role_id character varying(36) PRIMARY KEY NOT NULL,
    role_name character varying(50) DEFAULT NULL,
    role_description text,
    role_max_originator integer DEFAULT 0 NOT NULL,
    role_max_odfi integer DEFAULT 0 NOT NULL,
    role_max_daily_xfers integer DEFAULT 0 NOT NULL,
    role_max_daily_files integer DEFAULT 0 NOT NULL,
    role_max_daily_batches integer DEFAULT 0 NOT NULL,
    role_iat_enabled smallint DEFAULT (1) NOT NULL
);



--
-- Name: settlement; Type: table; TableName: settlement;
--

CREATE TABLE settlement (
    settlement_id character varying(36) PRIMARY KEY NOT NULL,
    settlement_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    settlement_originator_info_id character varying(36) NOT NULL,
    settlement_odfi_branch_id character varying(36) NOT NULL,
    settlement_ach_batch_id character varying(36) NOT NULL,
    settlement_ach_entry_id character varying(36) NOT NULL,
    settlement_transaction_type settlement_transaction_type NOT NULL,
    settlement_amount character varying(18) NOT NULL,
    settlement_effective_entry_date character varying(6) NOT NULL
);



--
-- Name: settlement_log; Type: table; TableName: settlement_log;
--

CREATE TABLE settlement_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    settlement_id character varying(36) NOT NULL,
    settlement_originator_info_id character varying(36) NOT NULL,
    settlement_odfi_branch_id character varying(36) NOT NULL,
    settlement_ach_batch_id character varying(36) NOT NULL,
    settlement_ach_entry_id character varying(36) NOT NULL,
    settlement_transaction_type settlement_transaction_type NOT NULL,
    settlement_amount character varying(18) NOT NULL,
    settlement_effective_entry_date character varying(6) NOT NULL
);


--
-- Name: user; Type: table; TableName: user;
--

CREATE TABLE "user" (
    user_id character varying(36) PRIMARY KEY NOT NULL,
    user_login character varying(50) NOT NULL,
    user_password character varying(50) DEFAULT NULL,
    user_first_name character varying(50) DEFAULT NULL,
    user_last_name character varying(50) DEFAULT NULL,
    user_email_address character varying(255) NOT NULL,
    user_security_question_1 character varying(255) DEFAULT NULL,
    user_security_question_2 character varying(255) DEFAULT NULL,
    user_security_question_3 character varying(255) DEFAULT NULL,
    user_security_answer_1 character varying(255) DEFAULT NULL,
    user_security_answer_2 character varying(255) DEFAULT NULL,
    user_security_answer_3 character varying(255) DEFAULT NULL,
    user_status user_status DEFAULT 'enabled' NOT NULL
);



--
-- Name: user_api; Type: table; TableName: user_api;
--

CREATE TABLE user_api (
    user_api_token character varying(48) PRIMARY KEY NOT NULL,
    user_api_key character varying(48) NOT NULL,
    user_api_datetime timestamp NOT NULL,
    user_api_user_id character varying(36) NOT NULL,
    user_api_originator_info_id character varying(36) NOT NULL,
    user_api_status user_api_status NOT NULL
);



--
-- Name: user_history; Type: table; TableName: user_history;
--

CREATE TABLE user_history (
    user_history_id character varying(36) PRIMARY KEY NOT NULL,
    user_history_user_id character varying(36) NOT NULL,
    user_history_datetime timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    user_history_event_type character varying(16) DEFAULT NULL,
    user_history_additional_info text
);



--
-- Name: user_log; Type: table; TableName: user_log;
--

CREATE TABLE user_log (
    log_datetime timestamp,
    log_remote_ip character varying(15) DEFAULT NULL,
    log_user_id character varying(36) NOT NULL,
    user_id character varying(36) NOT NULL,
    user_login character varying(50) NOT NULL,
    user_first_name character varying(50) DEFAULT NULL,
    user_last_name character varying(50) DEFAULT NULL,
    user_email_address character varying(255) NOT NULL,
    user_status user_status DEFAULT 'enabled' NOT NULL
);


--
-- Name: user_role; Type: table; TableName: user_role;
--

CREATE TABLE user_role (
    user_role_user_id character varying(36) PRIMARY KEY NOT NULL,
    user_role_role_id character varying(36) NOT NULL
);



--
-- Name: ach_batch_id_idx; Type: index; TableName: ach_batch_log;
--

CREATE INDEX ach_batch_id_idx ON ach_batch_log (ach_batch_id);


--
-- Name: ach_entry_id_idx; Type: index; TableName: ach_entry_log;
--

CREATE INDEX ach_entry_id_idx ON ach_entry_log (ach_entry_id);


--
-- Name: ach_file_id_idx; Type: index; TableName: ach_file_log;
--

CREATE INDEX ach_file_id_idx ON ach_file_log (ach_file_id);


--
-- Name: auth_item_tree_child_idx; Type: index; TableName: auth_item_tree;
--

CREATE INDEX auth_item_tree_child_idx ON auth_item_tree (auth_item_tree_child);


--
-- Name: external_account_id_idx; Type: index; TableName: external_account;
--

CREATE INDEX external_account_id_idx ON external_account (external_account_id);


--
-- Name: file_transfer_id_idx; Type: index; TableName: file_transfer_log;
--

CREATE INDEX file_transfer_id_idx ON file_transfer_log (file_transfer_id);


--
-- Name: odfi_branch_id_idx; Type: index; TableName: odfi_branch_log;
--

CREATE INDEX odfi_branch_id_idx ON odfi_branch_log (odfi_branch_id);


--
-- Name: originator_id_idx; Type: index; TableName: originator_log;
--

CREATE INDEX originator_id_idx ON originator_log (originator_id);


--
-- Name: originator_info_id_idx; Type: index; TableName: originator_info_log;
--

CREATE INDEX originator_info_id_idx ON originator_info_log (originator_info_id);


--
-- Name: payment_profile_external_id_idx; Type: index; TableName: payment_profile;
--

CREATE INDEX payment_profile_external_id_idx ON payment_profile (payment_profile_external_id);


--
-- Name: payment_profile_id_idx; Type: index; TableName: payment_profile_log;
--

CREATE INDEX payment_profile_id_idx ON payment_profile_log (payment_profile_id);


--
-- Name: payment_profile_originator_info_external_id_idx; Type: index; TableName: payment_profile;
--

CREATE UNIQUE INDEX payment_profile_originator_info_external_id_idx ON payment_profile (payment_profile_originator_info_id, payment_profile_external_id);


--
-- Name: payment_schedule_id_idx; Type: index; TableName: payment_event_log;
--

CREATE INDEX payment_schedule_id_idx ON payment_event_log (payment_schedule_id);


--
-- Name: payment_schedule_payment_type_id_idx; Type: index; TableName: payment_event_log;
--

CREATE INDEX payment_schedule_payment_type_id_idx ON payment_event_log (payment_schedule_payment_type_id);


--
-- Name: payment_type_id_idx; Type: index; TableName: payment_type_log;
--

CREATE INDEX payment_type_id_idx ON payment_type_log (payment_type_id);


--
-- Name: payment_type_originator_info_id_idx; Type: index; TableName: payment_type;
--

CREATE INDEX payment_type_originator_info_id_idx ON payment_type (payment_type_originator_info_id);


--
-- Name: payment_type_transaction_type_idx; Type: index; TableName: payment_type;
--

CREATE INDEX payment_type_transaction_type_idx ON payment_type (payment_type_transaction_type);


--
-- Name: phonetic_data_encoding_method_idx; Type: index; TableName: phonetic_data;
--

CREATE INDEX phonetic_data_encoding_method_idx ON phonetic_data (phonetic_data_entity_field);


--
-- Name: phonetic_data_entity_class_idx; Type: index; TableName: phonetic_data;
--

CREATE INDEX phonetic_data_entity_class_idx ON phonetic_data (phonetic_data_entity_class);


--
-- Name: phonetic_data_entity_field_idx; Type: index; TableName: phonetic_data;
--

CREATE INDEX phonetic_data_entity_field_idx ON phonetic_data (phonetic_data_entity_id);


--
-- Name: phonetic_data_entity_id_idx; Type: index; TableName: phonetic_data;
--

CREATE INDEX phonetic_data_entity_id_idx ON phonetic_data (phonetic_data_entity_id);


--
-- Name: phonetic_data_key_idx; Type: index; TableName: phonetic_data;
--

CREATE INDEX phonetic_data_key_idx ON phonetic_data (phonetic_data_key);


--
-- Name: phonetic_data_type_idx; Type: index; TableName: phonetic_data;
--

CREATE INDEX phonetic_data_type_idx ON phonetic_data (phonetic_data_type);


--
-- Name: plugin_config_plugin_id_idx; Type: index; TableName: plugin_config;
--

CREATE UNIQUE INDEX plugin_config_plugin_id_idx ON plugin_config (plugin_config_plugin_id, plugin_config_parent_id, plugin_config_parent_model, plugin_config_key);


--
-- Name: settlement_id_idx; Type: index; TableName: settlement_log;
--

CREATE INDEX settlement_id_idx ON settlement_log (settlement_id);


--
-- Name: settlement_unique_ach_batch_idx; Type: index; TableName: settlement;
--

CREATE UNIQUE INDEX settlement_unique_ach_batch_idx ON settlement (settlement_ach_batch_id);


--
-- Name: settlement_unique_ach_entry_idx; Type: index; TableName: settlement;
--

CREATE UNIQUE INDEX settlement_unique_ach_entry_idx ON settlement (settlement_ach_entry_id);


--
-- Name: user_id_idx; Type: index; TableName: user_log;
--

CREATE INDEX user_id_idx ON user_log (user_id);

