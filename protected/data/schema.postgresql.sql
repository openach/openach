--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Name: ach_entry_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE ach_entry_status AS ENUM (
    'pending',
    'processing',
    'posted',
    'returned',
    'error'
);


--
-- Name: ach_file_conf_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE ach_file_conf_status AS ENUM (
    'pending',
    'processing',
    'success',
    'error'
);


--
-- Name: ach_file_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE ach_file_status AS ENUM (
    'pending',
    'processing',
    'built',
    'transferred',
    'confirmed',
    'error'
);


--
-- Name: external_account_dfi_id_qualifier; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE external_account_dfi_id_qualifier AS ENUM (
    '01',
    '02'
);


--
-- Name: external_account_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE external_account_status AS ENUM (
    'enabled',
    'frozen',
    'closed'
);


--
-- Name: external_account_type; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE external_account_type AS ENUM (
    'checking',
    'savings'
);


--
-- Name: external_account_verification_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE external_account_verification_status AS ENUM (
    'pending',
    'attempted',
    'completed',
    'failed'
);


--
-- Name: file_transfer_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE file_transfer_status AS ENUM (
    'pending',
    'transferring',
    'transferred',
    'confirmed',
    'processed',
    'failed'
);


--
-- Name: odfi_branch_dfi_id_qualifier; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE odfi_branch_dfi_id_qualifier AS ENUM (
    '01',
    '02'
);


--
-- Name: odfi_branch_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE odfi_branch_status AS ENUM (
    'enabled',
    'disabled'
);


--
-- Name: payment_profile_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE payment_profile_status AS ENUM (
    'enabled',
    'suspended'
);


--
-- Name: payment_schedule_frequency; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE payment_schedule_frequency AS ENUM (
    'once',
    'daily',
    'weekly',
    'biweekly',
    'monthly',
    'bimonthly',
    'biannually',
    'annually',
    'biennially'
);


--
-- Name: payment_schedule_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE payment_schedule_status AS ENUM (
    'enabled',
    'suspended'
);


--
-- Name: payment_type_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE payment_type_status AS ENUM (
    'enabled',
    'disabled'
);


--
-- Name: payment_type_transaction_type; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE payment_type_transaction_type AS ENUM (
    'credit',
    'debit'
);


--
-- Name: phonetic_data_encoding_method; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE phonetic_data_encoding_method AS ENUM (
    'soundex',
    'nysiis',
    'metaphone',
    'metaphone2'
);


--
-- Name: plugin_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE plugin_status AS ENUM (
    'enabled',
    'disabled'
);


--
-- Name: settlement_transaction_type; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE settlement_transaction_type AS ENUM (
    'credit',
    'debit'
);


--
-- Name: user_api_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE user_api_status AS ENUM (
    'enabled',
    'disabled'
);


--
-- Name: user_status; Type: TYPE; Schema: public; Owner: openach_test
--

CREATE TYPE user_status AS ENUM (
    'enabled',
    'suspended'
);


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: ach_batch; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_batch (
    ach_batch_id character varying(36) NOT NULL,
    ach_batch_datetime timestamp without time zone DEFAULT now() NOT NULL,
    ach_batch_ach_file_id character varying(36) NOT NULL,
    ach_batch_header_service_class_code character(3) DEFAULT NULL::bpchar,
    ach_batch_header_company_name character varying(125) DEFAULT NULL::character varying,
    ach_batch_header_discretionary_data character varying(20) DEFAULT NULL::character varying,
    ach_batch_header_company_identification character varying(125) DEFAULT NULL::character varying,
    ach_batch_header_standard_entry_class character(3) DEFAULT NULL::bpchar,
    ach_batch_header_company_entry_description character varying(10) DEFAULT NULL::character varying,
    ach_batch_header_company_descriptive_date character varying(6) DEFAULT NULL::character varying,
    ach_batch_header_effective_entry_date character varying(6) DEFAULT NULL::character varying,
    ach_batch_header_settlement_date character(3) DEFAULT NULL::bpchar,
    ach_batch_header_originator_status_code character(1) DEFAULT NULL::bpchar,
    ach_batch_header_originating_dfi_id character varying(8) DEFAULT NULL::character varying,
    ach_batch_header_batch_number character varying(7) DEFAULT NULL::character varying,
    ach_batch_control_entry_addenda_count character varying(6) DEFAULT NULL::character varying,
    ach_batch_control_entry_hash character varying(10) DEFAULT NULL::character varying,
    ach_batch_control_total_debits character varying(12) DEFAULT NULL::character varying,
    ach_batch_control_total_credits character varying(12) DEFAULT NULL::character varying,
    ach_batch_control_message_authentication_code character varying(19) DEFAULT NULL::character varying,
    ach_batch_iat_indicator character varying(16) DEFAULT NULL::character varying,
    ach_batch_iat_foreign_exchange_indicator character(2) DEFAULT NULL::bpchar,
    ach_batch_iat_foreign_exchange_ref_indicator character(1) DEFAULT NULL::bpchar,
    ach_batch_iat_foreign_exchange_rate_ref character varying(15) DEFAULT NULL::character varying,
    ach_batch_iat_iso_dest_country_code character(3) DEFAULT NULL::bpchar,
    ach_batch_iat_iso_orig_currency_code character(3) DEFAULT NULL::bpchar,
    ach_batch_iat_iso_dest_currency_code character(3) DEFAULT NULL::bpchar,
    ach_batch_payment_type_id character varying(36) DEFAULT ''::character varying NOT NULL,
    ach_batch_originator_info_id character varying(36) NOT NULL
);


--
-- Name: ach_batch_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_batch_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    ach_batch_id character varying(36) NOT NULL,
    ach_batch_header_company_descriptive_date character varying(6) DEFAULT NULL::character varying,
    ach_batch_header_effective_entry_date character varying(6) DEFAULT NULL::character varying,
    ach_batch_header_batch_number character varying(7) DEFAULT NULL::character varying,
    ach_batch_control_entry_addenda_count character varying(6) DEFAULT NULL::character varying,
    ach_batch_control_entry_hash character varying(10) DEFAULT NULL::character varying,
    ach_batch_control_total_debits character varying(12) DEFAULT NULL::character varying,
    ach_batch_control_total_credits character varying(12) DEFAULT NULL::character varying,
    ach_batch_payment_type_id character varying(36) DEFAULT ''::character varying NOT NULL,
    ach_batch_originator_info_id character varying(36) DEFAULT ''::character varying NOT NULL
);


--
-- Name: ach_entry_detail_trace_number_seq; Type: SEQUENCE; Schema: public; Owner: openach_test
--

CREATE SEQUENCE ach_entry_detail_trace_number_seq
    START WITH 0
    INCREMENT BY 1
    MINVALUE 0
    NO MAXVALUE
    CACHE 1;


--
-- Name: ach_entry; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_entry (
    ach_entry_id character varying(36) NOT NULL,
    ach_entry_datetime timestamp without time zone DEFAULT now() NOT NULL,
    ach_entry_status ach_entry_status DEFAULT 'pending'::ach_entry_status NOT NULL,
    ach_entry_ach_batch_id character varying(36),
    ach_entry_odfi_branch_id character varying(36) NOT NULL,
    ach_entry_external_account_id character varying(36) NOT NULL,
    ach_entry_payment_schedule_id character varying(36) DEFAULT ''::character varying NOT NULL,
    ach_entry_detail_transaction_code character(2) DEFAULT NULL::bpchar,
    ach_entry_detail_receiving_dfi_id character varying(125) DEFAULT NULL::character varying,
    ach_entry_detail_receiving_dfi_id_check_digit character(1) DEFAULT NULL::bpchar,
    ach_entry_detail_dfi_account_number character varying(125) DEFAULT NULL::character varying,
    ach_entry_detail_amount character varying(18) DEFAULT NULL::character varying,
    ach_entry_detail_individual_id_number character varying(15) DEFAULT NULL::character varying,
    ach_entry_detail_individual_name character varying(125) DEFAULT NULL::character varying,
    ach_entry_detail_discretionary_data character(2) DEFAULT NULL::bpchar,
    ach_entry_detail_addenda_record_indicator character(1) DEFAULT NULL::bpchar,
    ach_entry_detail_trace_number bigint DEFAULT nextval('ach_entry_detail_trace_number_seq'::regclass),
    ach_entry_addenda_type_code character(2) DEFAULT NULL::bpchar,
    ach_entry_addenda_payment_info character varying(300) DEFAULT NULL::character varying,
    ach_entry_iat_go_receiving_dfi_id character varying(8) DEFAULT NULL::character varying,
    ach_entry_iat_go_receiving_dfi_id_check_digit character(1) DEFAULT NULL::bpchar,
    ach_entry_iat_ofac_screening_indicator character(1) DEFAULT NULL::bpchar,
    ach_entry_iat_secondary_ofac_screening_indicator character(1) DEFAULT NULL::bpchar,
    ach_entry_iat_transaction_type_code character(3) DEFAULT NULL::bpchar,
    ach_entry_iat_foreign_trace_number character varying(22) DEFAULT NULL::character varying,
    ach_entry_iat_originator_name character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originator_street_addr character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originator_city character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originator_state_province character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originator_postal_code character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originator_country character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originating_dfi_name character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originating_dfi_id character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_originating_dfi_id_qualifier character varying(2) DEFAULT NULL::character varying,
    ach_entry_iat_originating_dfi_country_code character varying(3) DEFAULT NULL::character varying,
    ach_entry_iat_receiving_dfi_name character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_receiving_dfi_id character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_receiving_dfi_id_qualifier character varying(2) DEFAULT NULL::character varying,
    ach_entry_iat_receiving_dfi_country_code character varying(3) DEFAULT NULL::character varying,
    ach_entry_iat_receiver_street_addr character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_receiver_city character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_receiver_state_province character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_receiver_postal_code character varying(125) DEFAULT NULL::character varying,
    ach_entry_iat_receiver_country character varying(125) DEFAULT NULL::character varying
);


--
-- Name: ach_entry_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_entry_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    ach_entry_id character varying(36) NOT NULL,
    ach_entry_status ach_entry_status DEFAULT 'pending'::ach_entry_status NOT NULL,
    ach_entry_detail_transaction_code character(2) DEFAULT NULL::bpchar,
    ach_entry_detail_amount character varying(18) DEFAULT NULL::character varying,
    ach_entry_detail_addenda_record_indicator character(1) DEFAULT NULL::bpchar,
    ach_entry_detail_trace_number bigint,
    ach_entry_iat_foreign_trace_number character varying(22) DEFAULT NULL::character varying
);


--
-- Name: ach_entry_return; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_entry_return (
    ach_entry_return_id character varying(36) NOT NULL,
    ach_entry_return_datetime timestamp without time zone DEFAULT now() NOT NULL,
    ach_entry_return_odfi_branch_id character varying(36) NOT NULL,
    ach_entry_return_ach_entry_id character varying(36) NOT NULL,
    ach_entry_return_reassigned_trace_number character varying(15) DEFAULT NULL::character varying,
    ach_entry_return_date_of_death character varying(6) DEFAULT NULL::character varying,
    ach_entry_return_original_dfi_id character varying(8) DEFAULT NULL::character varying,
    ach_entry_return_trace_number character varying(15) DEFAULT NULL::character varying,
    ach_entry_return_return_reason_code character varying(3) DEFAULT NULL::character varying,
    ach_entry_return_change_code character varying(3) DEFAULT NULL::character varying,
    ach_entry_return_corrected_data character varying(29) DEFAULT NULL::character varying,
    ach_entry_return_addenda_information character varying(44) DEFAULT NULL::character varying
);


--
-- Name: ach_file; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_file (
    ach_file_id character varying(36) NOT NULL,
    ach_file_datetime timestamp without time zone DEFAULT now() NOT NULL,
    ach_file_status ach_file_status DEFAULT 'pending'::ach_file_status NOT NULL,
    ach_file_odfi_branch_id character varying(36) NOT NULL,
    ach_file_originator_id character varying(36) NOT NULL,
    ach_file_header_priority_code character(2) DEFAULT '01'::bpchar NOT NULL,
    ach_file_header_immediate_destination character varying(125) DEFAULT NULL::character varying,
    ach_file_header_immediate_origin character varying(125) DEFAULT NULL::character varying,
    ach_file_header_file_creation_date character varying(6) DEFAULT NULL::character varying,
    ach_file_header_file_creation_time character varying(4) DEFAULT NULL::character varying,
    ach_file_header_file_id_modifier character(1) DEFAULT NULL::bpchar,
    ach_file_header_record_size character(3) DEFAULT '094'::bpchar,
    ach_file_header_blocking_factor character(2) DEFAULT '10'::bpchar,
    ach_file_header_format_code character(1) DEFAULT '1'::bpchar,
    ach_file_header_immediate_destination_name character varying(256) DEFAULT NULL::character varying,
    ach_file_header_immediate_origin_name character varying(256) DEFAULT NULL::character varying,
    ach_file_header_reference_code character varying(8) DEFAULT NULL::character varying,
    ach_file_control_batch_count character varying(6) DEFAULT NULL::character varying,
    ach_file_control_block_count character varying(6) DEFAULT NULL::character varying,
    ach_file_control_entry_addenda_count character varying(8) DEFAULT NULL::character varying,
    ach_file_control_entry_hash character varying(10) DEFAULT NULL::character varying,
    ach_file_control_total_debits character varying(12) DEFAULT NULL::character varying,
    ach_file_control_total_credits character varying(12) DEFAULT NULL::character varying
);


--
-- Name: ach_file_conf; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_file_conf (
    ach_file_conf_id character varying(36) NOT NULL,
    ach_file_conf_datetime timestamp without time zone DEFAULT now() NOT NULL,
    ach_file_conf_odfi_branch_id character varying(36) NOT NULL,
    ach_file_conf_status ach_file_conf_status DEFAULT 'pending'::ach_file_conf_status NOT NULL,
    ach_file_conf_date character varying(6) DEFAULT NULL::character varying,
    ach_file_conf_time character varying(6) DEFAULT NULL::character varying,
    ach_file_conf_batch_count character varying(6) DEFAULT NULL::character varying,
    ach_file_conf_batch_item_count character varying(4) DEFAULT NULL::character varying,
    ach_file_conf_block_count character varying(6) DEFAULT NULL::character varying,
    ach_file_conf_error_message_number character varying(10) DEFAULT NULL::character varying,
    ach_file_conf_error_message text,
    ach_file_conf_total_debits character varying(12) DEFAULT NULL::character varying,
    ach_file_conf_total_credits character varying(12) DEFAULT NULL::character varying
);


--
-- Name: ach_file_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ach_file_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    ach_file_id character varying(36) NOT NULL,
    ach_file_status ach_file_status DEFAULT 'pending'::ach_file_status NOT NULL,
    ach_file_header_file_creation_date character varying(6) DEFAULT NULL::character varying,
    ach_file_header_file_creation_time character varying(4) DEFAULT NULL::character varying,
    ach_file_header_file_id_modifier character(1) DEFAULT NULL::bpchar,
    ach_file_header_reference_code character varying(8) DEFAULT NULL::character varying,
    ach_file_control_batch_count character varying(6) DEFAULT NULL::character varying,
    ach_file_control_block_count character varying(6) DEFAULT NULL::character varying,
    ach_file_control_entry_addenda_count character varying(8) DEFAULT NULL::character varying,
    ach_file_control_entry_hash character varying(10) DEFAULT NULL::character varying,
    ach_file_control_total_debits character varying(12) DEFAULT NULL::character varying,
    ach_file_control_total_credits character varying(12) DEFAULT NULL::character varying
);


--
-- Name: app_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE app_log (
    app_log_id character varying(36) NOT NULL,
    app_log_datetime timestamp without time zone,
    app_log_message character varying(255) DEFAULT ''::character varying NOT NULL
);


--
-- Name: auth_assignment; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE auth_assignment (
    auth_assignment_itemname character varying(64) NOT NULL,
    auth_assignment_userid character varying(64) NOT NULL,
    auth_assignment_bizrule text,
    auth_assignment_data text
);


--
-- Name: auth_item; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE auth_item (
    auth_item_name character varying(64) NOT NULL,
    auth_item_type integer NOT NULL,
    auth_item_description text,
    auth_item_bizrule text,
    auth_item_data text
);


--
-- Name: auth_item_tree; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE auth_item_tree (
    auth_item_tree_parent character varying(64) NOT NULL,
    auth_item_tree_child character varying(64) NOT NULL
);


--
-- Name: entity_index; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE entity_index (
    entity_index_id character varying(64) NOT NULL,
    entity_index_next_id bigint DEFAULT (0)::bigint NOT NULL
);


--
-- Name: external_account; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE external_account (
    external_account_id character varying(36) NOT NULL,
    external_account_datetime timestamp without time zone DEFAULT now() NOT NULL,
    external_account_payment_profile_id character varying(36) NOT NULL,
    external_account_type external_account_type NOT NULL,
    external_account_name character varying(250) DEFAULT NULL::character varying,
    external_account_bank character varying(250) DEFAULT NULL::character varying,
    external_account_holder character varying(250) DEFAULT NULL::character varying,
    external_account_country_code character varying(2) DEFAULT NULL::character varying,
    external_account_dfi_id character varying(125) DEFAULT NULL::character varying,
    external_account_dfi_id_qualifier external_account_dfi_id_qualifier DEFAULT '01'::external_account_dfi_id_qualifier NOT NULL,
    external_account_number character varying(125) DEFAULT NULL::character varying,
    external_account_billing_address character varying(255) DEFAULT NULL::character varying,
    external_account_billing_city character varying(255) DEFAULT NULL::character varying,
    external_account_billing_state_province character varying(35) DEFAULT NULL::character varying,
    external_account_billing_postal_code character varying(35) DEFAULT NULL::character varying,
    external_account_billing_country character varying(2) DEFAULT NULL::character varying,
    external_account_verification_status external_account_verification_status DEFAULT 'pending'::external_account_verification_status NOT NULL,
    external_account_status external_account_status DEFAULT 'enabled'::external_account_status NOT NULL,
    external_account_originator_info_id character varying(36) DEFAULT ''::character varying NOT NULL,
    external_account_business smallint DEFAULT 0 NOT NULL,
    external_account_allow_originator_payments smallint DEFAULT 0 NOT NULL
);


--
-- Name: external_account_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE external_account_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    external_account_id character varying(36) NOT NULL,
    external_account_payment_profile_id character varying(36) NOT NULL,
    external_account_type external_account_type NOT NULL,
    external_account_name character varying(125) DEFAULT NULL::character varying,
    external_account_bank character varying(125) DEFAULT NULL::character varying,
    external_account_holder character varying(125) DEFAULT NULL::character varying,
    external_account_country_code character varying(2) DEFAULT NULL::character varying,
    external_account_dfi_id character varying(125) DEFAULT NULL::character varying,
    external_account_dfi_id_qualifier external_account_dfi_id_qualifier DEFAULT '01'::external_account_dfi_id_qualifier NOT NULL,
    external_account_number character varying(125) DEFAULT NULL::character varying,
    external_account_billing_address character varying(255) DEFAULT NULL::character varying,
    external_account_billing_city character varying(255) DEFAULT NULL::character varying,
    external_account_billing_state_province character varying(35) DEFAULT NULL::character varying,
    external_account_billing_postal_code character varying(35) DEFAULT NULL::character varying,
    external_account_billing_country character varying(2) DEFAULT NULL::character varying,
    external_account_business smallint DEFAULT (0)::smallint NOT NULL,
    external_account_verification_status external_account_verification_status DEFAULT 'pending'::external_account_verification_status NOT NULL,
    external_account_status external_account_status DEFAULT 'enabled'::external_account_status NOT NULL,
    external_account_originator_info_id character varying(36) DEFAULT ''::character varying NOT NULL,
    external_account_allow_originator_payments smallint DEFAULT 0 NOT NULL
);


--
-- Name: fedach; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE fedach (
    fedach_routing_number character(9) NOT NULL,
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
-- Name: fedwire; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE fedwire (
    fedwire_routing_number character(9) NOT NULL,
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
-- Name: file_transfer; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE file_transfer (
    file_transfer_id character varying(36) NOT NULL,
    file_transfer_datetime timestamp without time zone DEFAULT now() NOT NULL,
    file_transfer_file_id character varying(36) NOT NULL,
    file_transfer_model character varying(50) NOT NULL,
    file_transfer_status file_transfer_status,
    file_transfer_plugin character varying(36) NOT NULL,
    file_transfer_message text NOT NULL,
    file_transfer_data text
);


--
-- Name: file_transfer_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE file_transfer_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    file_transfer_id character varying(36) NOT NULL,
    file_transfer_status file_transfer_status
);


--
-- Name: menu_item; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE menu_item (
    menu_item_id character varying(36) NOT NULL,
    menu_item_component character varying(50) NOT NULL,
    menu_item_group character varying(50) NOT NULL,
    menu_item_parent_id character varying(36) DEFAULT NULL::character varying,
    menu_item_path character varying(50) DEFAULT NULL::character varying,
    menu_item_class character varying(50) DEFAULT NULL::character varying,
    menu_item_icon character varying(255) DEFAULT NULL::character varying,
    menu_item_label character varying(255) NOT NULL,
    menu_item_text text NOT NULL,
    menu_item_weight smallint DEFAULT (0)::smallint NOT NULL,
    menu_item_require_role character varying(50) DEFAULT ''::character varying NOT NULL
);


--
-- Name: odfi_branch; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE odfi_branch (
    odfi_branch_id character varying(36) NOT NULL,
    odfi_branch_datetime timestamp without time zone DEFAULT now() NOT NULL,
    odfi_branch_originator_id character varying(36) NOT NULL,
    odfi_branch_friendly_name character varying(50) DEFAULT NULL::character varying,
    odfi_branch_name character varying(35) DEFAULT NULL::character varying,
    odfi_branch_city character varying(35) DEFAULT NULL::character varying,
    odfi_branch_state_province character varying(35) DEFAULT NULL::character varying,
    odfi_branch_country_code character(2) DEFAULT NULL::bpchar,
    odfi_branch_dfi_id character varying(125) DEFAULT NULL::character varying,
    odfi_branch_dfi_id_qualifier odfi_branch_dfi_id_qualifier,
    odfi_branch_go_dfi_id character varying(9) DEFAULT NULL::character varying,
    odfi_branch_status odfi_branch_status DEFAULT 'enabled'::odfi_branch_status NOT NULL,
    odfi_branch_plugin character varying(36) DEFAULT ''::character varying NOT NULL
);


--
-- Name: odfi_branch_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE odfi_branch_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    odfi_branch_id character varying(36) NOT NULL,
    odfi_branch_friendly_name character varying(50) DEFAULT NULL::character varying,
    odfi_branch_name character varying(35) DEFAULT NULL::character varying,
    odfi_branch_city character varying(35) DEFAULT NULL::character varying,
    odfi_branch_state_province character varying(35) DEFAULT NULL::character varying,
    odfi_branch_country_code character(2) DEFAULT NULL::bpchar,
    odfi_branch_dfi_id character varying(125) DEFAULT NULL::character varying,
    odfi_branch_dfi_id_qualifier odfi_branch_dfi_id_qualifier,
    odfi_branch_go_dfi_id character varying(9) DEFAULT NULL::character varying,
    odfi_branch_status odfi_branch_status DEFAULT 'enabled'::odfi_branch_status NOT NULL,
    odfi_branch_plugin character varying(36) DEFAULT ''::character varying NOT NULL
);


--
-- Name: ofac_add; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ofac_add (
    ofac_add_ent_num integer NOT NULL,
    ofac_add_num integer NOT NULL,
    ofac_add_address character varying(750) NOT NULL,
    ofac_add_city character varying(116) NOT NULL,
    ofac_add_state_province character varying(116) NOT NULL,
    ofac_add_postal_code character varying(116) NOT NULL,
    ofac_add_country character varying(250) NOT NULL,
    ofac_add_remarks character varying(200) NOT NULL
);


--
-- Name: ofac_alt; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ofac_alt (
    ofac_alt_ent_num integer NOT NULL,
    ofac_alt_num integer NOT NULL,
    ofac_alt_type character varying(8) NOT NULL,
    ofac_alt_name character varying(350) NOT NULL,
    ofac_alt_remarks character varying(200) NOT NULL
);


--
-- Name: ofac_sdn; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE ofac_sdn (
    ofac_sdn_ent_num integer NOT NULL,
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
-- Name: originator; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE originator (
    originator_id character varying(36) NOT NULL,
    originator_datetime timestamp without time zone DEFAULT now() NOT NULL,
    originator_user_id character varying(36) NOT NULL,
    originator_name character varying(255) DEFAULT NULL::character varying,
    originator_identification character varying(255) DEFAULT NULL::character varying,
    originator_address character varying(255) DEFAULT NULL::character varying,
    originator_city character varying(35) DEFAULT NULL::character varying,
    originator_state_province character varying(35) DEFAULT NULL::character varying,
    originator_postal_code character varying(35) DEFAULT NULL::character varying,
    originator_country_code character(2) DEFAULT NULL::bpchar
);


--
-- Name: originator_info; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE originator_info (
    originator_info_id character varying(36) NOT NULL,
    originator_info_datetime timestamp without time zone DEFAULT now() NOT NULL,
    originator_info_odfi_branch_id character varying(36) NOT NULL,
    originator_info_originator_id character varying(36) NOT NULL,
    originator_info_name character varying(255) DEFAULT NULL::character varying,
    originator_info_description text,
    originator_info_identification character varying(255) DEFAULT NULL::character varying,
    originator_info_address character varying(255) DEFAULT NULL::character varying,
    originator_info_city character varying(35) DEFAULT NULL::character varying,
    originator_info_state_province character varying(35) DEFAULT NULL::character varying,
    originator_info_postal_code character varying(35) DEFAULT NULL::character varying,
    originator_info_country_code character(2) DEFAULT NULL::bpchar,
    originator_info_name_hash character varying(40) DEFAULT ''::character varying,
    originator_info_identification_hash character varying(40) DEFAULT ''::character varying
);


--
-- Name: originator_info_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE originator_info_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    originator_info_id character varying(36) NOT NULL,
    originator_info_odfi_branch_id character varying(36) NOT NULL,
    originator_info_name character varying(255) DEFAULT NULL::character varying,
    originator_info_identification character varying(255) DEFAULT NULL::character varying,
    originator_info_address character varying(255) DEFAULT NULL::character varying,
    originator_info_city character varying(35) DEFAULT NULL::character varying,
    originator_info_state_province character varying(35) DEFAULT NULL::character varying,
    originator_info_postal_code character varying(35) DEFAULT NULL::character varying,
    originator_info_country_code character(2) DEFAULT NULL::bpchar
);


--
-- Name: originator_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE originator_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    originator_id character varying(36) NOT NULL,
    originator_user_id character varying(36) NOT NULL,
    originator_name character varying(255) DEFAULT NULL::character varying,
    originator_identification character varying(255) DEFAULT NULL::character varying,
    originator_address character varying(255) DEFAULT NULL::character varying,
    originator_city character varying(35) DEFAULT NULL::character varying,
    originator_state_province character varying(35) DEFAULT NULL::character varying,
    originator_postal_code character varying(35) DEFAULT NULL::character varying,
    originator_country_code character(2) DEFAULT NULL::bpchar
);


--
-- Name: payment_event_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_event_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    ach_entry_id character varying(36) NOT NULL,
    payment_schedule_id character varying(36) NOT NULL,
    payment_schedule_external_account_id character varying(36) NOT NULL,
    payment_schedule_payment_type_id character varying(36) NOT NULL,
    payment_schedule_amount numeric(19,2) DEFAULT 0.00 NOT NULL
);


--
-- Name: payment_profile; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_profile (
    payment_profile_id character varying(36) NOT NULL,
    payment_profile_originator_info_id character varying(36) NOT NULL,
    payment_profile_external_id character varying(255) NOT NULL,
    payment_profile_password character varying(255) DEFAULT NULL::character varying,
    payment_profile_first_name character varying(255) DEFAULT NULL::character varying,
    payment_profile_last_name character varying(255) DEFAULT NULL::character varying,
    payment_profile_email_address character varying(255) NOT NULL,
    payment_profile_security_question_1 character varying(255) DEFAULT NULL::character varying,
    payment_profile_security_question_2 character varying(255) DEFAULT NULL::character varying,
    payment_profile_security_question_3 character varying(255) DEFAULT NULL::character varying,
    payment_profile_security_answer_1 character varying(255) DEFAULT NULL::character varying,
    payment_profile_security_answer_2 character varying(255) DEFAULT NULL::character varying,
    payment_profile_security_answer_3 character varying(255) DEFAULT NULL::character varying,
    payment_profile_status payment_profile_status DEFAULT 'enabled'::payment_profile_status NOT NULL,
    payment_profile_first_name_hash character varying(40) DEFAULT ''::character varying NOT NULL,
    payment_profile_last_name_hash character varying(40) DEFAULT ''::character varying NOT NULL
);


--
-- Name: payment_profile_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_profile_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    payment_profile_id character varying(36) NOT NULL,
    payment_profile_external_id character varying(125) NOT NULL,
    payment_profile_first_name character varying(255) DEFAULT NULL::character varying,
    payment_profile_last_name character varying(255) DEFAULT NULL::character varying,
    payment_profile_email_address character varying(255) NOT NULL,
    payment_profile_status payment_profile_status DEFAULT 'enabled'::payment_profile_status NOT NULL
);


--
-- Name: payment_schedule; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_schedule (
    payment_schedule_id character varying(36) NOT NULL,
    payment_schedule_external_account_id character varying(36) NOT NULL,
    payment_schedule_payment_type_id character varying(36) NOT NULL,
    payment_schedule_status payment_schedule_status NOT NULL,
    payment_schedule_amount numeric(19,2) DEFAULT 0.00 NOT NULL,
    payment_schedule_currency_code character(3) DEFAULT ''::bpchar NOT NULL,
    payment_schedule_next_date date NOT NULL,
    payment_schedule_frequency payment_schedule_frequency,
    payment_schedule_end_date date NOT NULL,
    payment_schedule_remaining_occurrences smallint DEFAULT (1)::smallint NOT NULL
);


--
-- Name: payment_schedule_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_schedule_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    payment_schedule_id character varying(36) NOT NULL,
    payment_schedule_external_account_id character varying(36) NOT NULL,
    payment_schedule_payment_type_id character varying(36) NOT NULL,
    payment_schedule_status payment_schedule_status NOT NULL,
    payment_schedule_amount numeric(19,2) DEFAULT 0.00 NOT NULL,
    payment_schedule_currency_code character(3) DEFAULT ''::bpchar NOT NULL,
    payment_schedule_next_date date NOT NULL,
    payment_schedule_frequency payment_schedule_frequency,
    payment_schedule_end_date date NOT NULL,
    payment_schedule_remaining_occurrences smallint DEFAULT (1)::smallint NOT NULL
);


--
-- Name: payment_type; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_type (
    payment_type_id character varying(36) NOT NULL,
    payment_type_originator_info_id character varying(36) NOT NULL,
    payment_type_name character varying(10) NOT NULL,
    payment_type_transaction_type payment_type_transaction_type DEFAULT 'debit'::payment_type_transaction_type NOT NULL,
    payment_type_status payment_type_status DEFAULT 'enabled'::payment_type_status NOT NULL,
    payment_type_description character varying(255) DEFAULT ''::character varying NOT NULL,
    payment_type_external_account_id character varying(36) DEFAULT ''::character varying NOT NULL
);


--
-- Name: payment_type_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE payment_type_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    payment_type_id character varying(36) NOT NULL,
    payment_type_name character varying(10) NOT NULL,
    payment_type_transaction_type payment_type_transaction_type DEFAULT 'debit'::payment_type_transaction_type NOT NULL,
    payment_type_status payment_type_status DEFAULT 'enabled'::payment_type_status NOT NULL,
    payment_type_description character varying(255) DEFAULT ''::character varying NOT NULL,
    payment_type_external_account_id character varying(36) DEFAULT ''::character varying NOT NULL
);


--
-- Name: phonetic_data; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE phonetic_data (
    phonetic_data_id character varying(36) NOT NULL,
    phonetic_data_datetime timestamp without time zone DEFAULT now() NOT NULL,
    phonetic_data_entity_class character varying(50) NOT NULL,
    phonetic_data_entity_id character varying(36) NOT NULL,
    phonetic_data_entity_field character varying(50) DEFAULT NULL::character varying,
    phonetic_data_encoding_method phonetic_data_encoding_method NOT NULL,
    phonetic_data_key character varying(255) NOT NULL,
    phonetic_data_type character varying(50) NOT NULL
);


--
-- Name: phonetic_filtered; Type: VIEW; Schema: public; Owner: openach_test
--

CREATE OR REPLACE VIEW phonetic_filtered AS 
         SELECT source.phonetic_data_entity_class AS filtered_source_entity_class, source.phonetic_data_entity_id AS filtered_source_entity_id, result.phonetic_data_entity_class AS filtered_result_entity_class, result.phonetic_data_entity_id AS filtered_result_entity_id, 'name'::text AS data_type, count(source.phonetic_data_key) AS total_hits
           FROM phonetic_data source
      JOIN phonetic_data result ON source.phonetic_data_encoding_method = result.phonetic_data_encoding_method AND source.phonetic_data_type::text = result.phonetic_data_type::text AND source.phonetic_data_key::text = result.phonetic_data_key::text AND (result.phonetic_data_entity_class::text = ANY (ARRAY['OfacSdn'::character varying, 'OfacAlt'::character varying]::text[]))
     WHERE (source.phonetic_data_entity_class::text <> ALL (ARRAY['OfacSdn'::character varying, 'OfacAlt'::character varying]::text[])) AND (source.phonetic_data_type::text = ANY (ARRAY['last_name'::character varying, 'first_name'::character varying]::text[]))
     GROUP BY result.phonetic_data_entity_class, source.phonetic_data_entity_class, source.phonetic_data_entity_id, result.phonetic_data_entity_id
    HAVING count(source.phonetic_data_key) >= 5
UNION 
         SELECT source.phonetic_data_entity_class AS filtered_source_entity_class, source.phonetic_data_entity_id AS filtered_source_entity_id, result.phonetic_data_entity_class AS filtered_result_entity_class, result.phonetic_data_entity_id AS filtered_result_entity_id, 'company'::text AS data_type, count(source.phonetic_data_key) AS total_hits
           FROM phonetic_data source
      JOIN phonetic_data result ON source.phonetic_data_encoding_method = result.phonetic_data_encoding_method AND source.phonetic_data_type::text = result.phonetic_data_type::text AND source.phonetic_data_key::text = result.phonetic_data_key::text AND (result.phonetic_data_entity_class::text = ANY (ARRAY['OfacSdn'::character varying, 'OfacAlt'::character varying]::text[]))
     WHERE (source.phonetic_data_entity_class::text <> ALL (ARRAY['OfacSdn'::character varying, 'OfacAlt'::character varying]::text[])) AND source.phonetic_data_type::text = 'company'::text
     GROUP BY result.phonetic_data_entity_class, source.phonetic_data_entity_class, source.phonetic_data_entity_id, result.phonetic_data_entity_id
    HAVING count(source.phonetic_data_key) >= 2;


--
-- Name: plugin; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE plugin (
    plugin_id character varying(36) NOT NULL,
    plugin_status plugin_status DEFAULT 'enabled'::plugin_status NOT NULL,
    plugin_class character varying(36) NOT NULL,
    plugin_version character varying(36) NOT NULL
);


--
-- Name: plugin_config; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE plugin_config (
    plugin_config_id character varying(36) NOT NULL,
    plugin_config_plugin_id character varying(36) NOT NULL,
    plugin_config_parent_id character varying(36) NOT NULL,
    plugin_config_parent_model character varying(50) NOT NULL,
    plugin_config_key character varying(255) NOT NULL,
    plugin_config_value character varying(2500) NOT NULL,
    plugin_config_weight integer DEFAULT 0 NOT NULL
);


--
-- Name: return_change; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE return_change (
    return_change_code character(3) NOT NULL,
    return_change_title character varying(150),
    return_change_description text NOT NULL
);


--
-- Name: role; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE role (
    role_id character varying(36) NOT NULL,
    role_name character varying(50) DEFAULT NULL::character varying,
    role_description text,
    role_max_originator integer DEFAULT 0 NOT NULL,
    role_max_odfi integer DEFAULT 0 NOT NULL,
    role_max_daily_xfers integer DEFAULT 0 NOT NULL,
    role_max_daily_files integer DEFAULT 0 NOT NULL,
    role_max_daily_batches integer DEFAULT 0 NOT NULL,
    role_iat_enabled smallint DEFAULT (1)::smallint NOT NULL
);



--
-- Name: settlement; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE settlement (
    settlement_id character varying(36) NOT NULL,
    settlement_datetime timestamp without time zone DEFAULT now() NOT NULL,
    settlement_originator_info_id character varying(36) NOT NULL,
    settlement_odfi_branch_id character varying(36) NOT NULL,
    settlement_ach_batch_id character varying(36) NOT NULL,
    settlement_ach_entry_id character varying(36) NOT NULL,
    settlement_transaction_type settlement_transaction_type NOT NULL,
    settlement_amount character varying(18) NOT NULL,
    settlement_effective_entry_date character varying(6) NOT NULL
);


--
-- Name: settlement_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE settlement_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
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
-- Name: user; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE "user" (
    user_id character varying(36) NOT NULL,
    user_login character varying(50) NOT NULL,
    user_password character varying(50) DEFAULT NULL::character varying,
    user_first_name character varying(50) DEFAULT NULL::character varying,
    user_last_name character varying(50) DEFAULT NULL::character varying,
    user_email_address character varying(255) NOT NULL,
    user_security_question_1 character varying(255) DEFAULT NULL::character varying,
    user_security_question_2 character varying(255) DEFAULT NULL::character varying,
    user_security_question_3 character varying(255) DEFAULT NULL::character varying,
    user_security_answer_1 character varying(255) DEFAULT NULL::character varying,
    user_security_answer_2 character varying(255) DEFAULT NULL::character varying,
    user_security_answer_3 character varying(255) DEFAULT NULL::character varying,
    user_status user_status DEFAULT 'enabled'::user_status NOT NULL
);


--
-- Name: user_api; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE user_api (
    user_api_token character varying(48) NOT NULL,
    user_api_key character varying(48) NOT NULL,
    user_api_datetime timestamp without time zone NOT NULL,
    user_api_user_id character varying(36) NOT NULL,
    user_api_originator_info_id character varying(36) NOT NULL,
    user_api_status user_api_status NOT NULL
);


--
-- Name: user_history; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE user_history (
    user_history_id character varying(36) NOT NULL,
    user_history_user_id character varying(36) NOT NULL,
    user_history_datetime timestamp without time zone DEFAULT now() NOT NULL,
    user_history_event_type character varying(16) DEFAULT NULL::character varying,
    user_history_additional_info text
);


--
-- Name: user_log; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE user_log (
    log_datetime timestamp without time zone,
    log_remote_ip character varying(15) DEFAULT NULL::character varying,
    log_user_id character varying(36) NOT NULL,
    user_id character varying(36) NOT NULL,
    user_login character varying(50) NOT NULL,
    user_first_name character varying(50) DEFAULT NULL::character varying,
    user_last_name character varying(50) DEFAULT NULL::character varying,
    user_email_address character varying(255) NOT NULL,
    user_status user_status DEFAULT 'enabled'::user_status NOT NULL
);


--
-- Name: user_role; Type: TABLE; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE TABLE user_role (
    user_role_user_id character varying(36) NOT NULL,
    user_role_role_id character varying(36) NOT NULL
);


--
-- Name: ach_batch_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ach_batch
    ADD CONSTRAINT ach_batch_pkey PRIMARY KEY (ach_batch_id);


--
-- Name: ach_entry_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ach_entry
    ADD CONSTRAINT ach_entry_pkey PRIMARY KEY (ach_entry_id);


--
-- Name: ach_entry_return_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ach_entry_return
    ADD CONSTRAINT ach_entry_return_pkey PRIMARY KEY (ach_entry_return_id);


--
-- Name: ach_file_conf_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ach_file_conf
    ADD CONSTRAINT ach_file_conf_pkey PRIMARY KEY (ach_file_conf_id);


--
-- Name: ach_file_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ach_file
    ADD CONSTRAINT ach_file_pkey PRIMARY KEY (ach_file_id);


--
-- Name: app_log_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY app_log
    ADD CONSTRAINT app_log_pkey PRIMARY KEY (app_log_id);


--
-- Name: auth_assignment_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY auth_assignment
    ADD CONSTRAINT auth_assignment_pkey PRIMARY KEY (auth_assignment_itemname, auth_assignment_userid);


--
-- Name: auth_item_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY auth_item
    ADD CONSTRAINT auth_item_pkey PRIMARY KEY (auth_item_name);


--
-- Name: auth_item_tree_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY auth_item_tree
    ADD CONSTRAINT auth_item_tree_pkey PRIMARY KEY (auth_item_tree_parent, auth_item_tree_child);


--
-- Name: entity_index_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY entity_index
    ADD CONSTRAINT entity_index_pkey PRIMARY KEY (entity_index_id);


--
-- Name: external_account_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY external_account
    ADD CONSTRAINT external_account_pkey PRIMARY KEY (external_account_id);


--
-- Name: fedach_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY fedach
    ADD CONSTRAINT fedach_pkey PRIMARY KEY (fedach_routing_number);


--
-- Name: fedwire_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY fedwire
    ADD CONSTRAINT fedwire_pkey PRIMARY KEY (fedwire_routing_number);


--
-- Name: file_transfer_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY file_transfer
    ADD CONSTRAINT file_transfer_pkey PRIMARY KEY (file_transfer_id);


--
-- Name: menu_item_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY menu_item
    ADD CONSTRAINT menu_item_pkey PRIMARY KEY (menu_item_id);


--
-- Name: odfi_branch_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY odfi_branch
    ADD CONSTRAINT odfi_branch_pkey PRIMARY KEY (odfi_branch_id);


--
-- Name: ofac_add_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ofac_add
    ADD CONSTRAINT ofac_add_pkey PRIMARY KEY (ofac_add_num);


--
-- Name: ofac_alt_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ofac_alt
    ADD CONSTRAINT ofac_alt_pkey PRIMARY KEY (ofac_alt_num);


--
-- Name: ofac_sdn_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY ofac_sdn
    ADD CONSTRAINT ofac_sdn_pkey PRIMARY KEY (ofac_sdn_ent_num);


--
-- Name: originator_info_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY originator_info
    ADD CONSTRAINT originator_info_pkey PRIMARY KEY (originator_info_id);


--
-- Name: originator_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY originator
    ADD CONSTRAINT originator_pkey PRIMARY KEY (originator_id);


--
-- Name: payment_profile_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY payment_profile
    ADD CONSTRAINT payment_profile_pkey PRIMARY KEY (payment_profile_id);


--
-- Name: payment_schedule_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY payment_schedule
    ADD CONSTRAINT payment_schedule_pkey PRIMARY KEY (payment_schedule_id);


--
-- Name: payment_type_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY payment_type
    ADD CONSTRAINT payment_type_pkey PRIMARY KEY (payment_type_id);


--
-- Name: phonetic_data_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY phonetic_data
    ADD CONSTRAINT phonetic_data_pkey PRIMARY KEY (phonetic_data_id);


--
-- Name: plugin_config_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY plugin_config
    ADD CONSTRAINT plugin_config_pkey PRIMARY KEY (plugin_config_id);


--
-- Name: plugin_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY plugin
    ADD CONSTRAINT plugin_pkey PRIMARY KEY (plugin_id);


--
-- Name: return_change_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY return_change
    ADD CONSTRAINT return_change_pkey PRIMARY KEY (return_change_code);


--
-- Name: role_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY role
    ADD CONSTRAINT role_pkey PRIMARY KEY (role_id);


--
-- Name: settlement_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY settlement
    ADD CONSTRAINT settlement_pkey PRIMARY KEY (settlement_id);


--
-- Name: user_api_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY user_api
    ADD CONSTRAINT user_api_pkey PRIMARY KEY (user_api_token);


--
-- Name: user_history_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY user_history
    ADD CONSTRAINT user_history_pkey PRIMARY KEY (user_history_id);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (user_id);


--
-- Name: user_role_pkey; Type: CONSTRAINT; Schema: public; Owner: openach_test; Tablespace: 
--

ALTER TABLE ONLY user_role
    ADD CONSTRAINT user_role_pkey PRIMARY KEY (user_role_user_id);


--
-- Name: ach_batch_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX ach_batch_id_idx ON ach_batch_log USING btree (ach_batch_id);


--
-- Name: ach_entry_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX ach_entry_id_idx ON ach_entry_log USING btree (ach_entry_id);


--
-- Name: ach_file_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX ach_file_id_idx ON ach_file_log USING btree (ach_file_id);


--
-- Name: auth_item_tree_child_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX auth_item_tree_child_idx ON auth_item_tree USING btree (auth_item_tree_child);


--
-- Name: external_account_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX external_account_id_idx ON external_account USING btree (external_account_id);


--
-- Name: file_transfer_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX file_transfer_id_idx ON file_transfer_log USING btree (file_transfer_id);


--
-- Name: odfi_branch_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX odfi_branch_id_idx ON odfi_branch_log USING btree (odfi_branch_id);


--
-- Name: originator_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX originator_id_idx ON originator_log USING btree (originator_id);


--
-- Name: originator_info_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX originator_info_id_idx ON originator_info_log USING btree (originator_info_id);


--
-- Name: payment_profile_external_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_profile_external_id_idx ON payment_profile USING btree (payment_profile_external_id);


--
-- Name: payment_profile_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_profile_id_idx ON payment_profile_log USING btree (payment_profile_id);


--
-- Name: payment_profile_originator_info_external_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE UNIQUE INDEX payment_profile_originator_info_external_id_idx ON payment_profile USING btree (payment_profile_originator_info_id, payment_profile_external_id);


--
-- Name: payment_schedule_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_schedule_id_idx ON payment_event_log USING btree (payment_schedule_id);


--
-- Name: payment_schedule_payment_type_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_schedule_payment_type_id_idx ON payment_event_log USING btree (payment_schedule_payment_type_id);


--
-- Name: payment_type_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_type_id_idx ON payment_type_log USING btree (payment_type_id);


--
-- Name: payment_type_originator_info_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_type_originator_info_id_idx ON payment_type USING btree (payment_type_originator_info_id);


--
-- Name: payment_type_transaction_type_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX payment_type_transaction_type_idx ON payment_type USING btree (payment_type_transaction_type);


--
-- Name: phonetic_data_encoding_method_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX phonetic_data_encoding_method_idx ON phonetic_data USING btree (phonetic_data_entity_field);


--
-- Name: phonetic_data_entity_class_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX phonetic_data_entity_class_idx ON phonetic_data USING btree (phonetic_data_entity_class);


--
-- Name: phonetic_data_entity_field_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX phonetic_data_entity_field_idx ON phonetic_data USING btree (phonetic_data_entity_id);


--
-- Name: phonetic_data_entity_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX phonetic_data_entity_id_idx ON phonetic_data USING btree (phonetic_data_entity_id);


--
-- Name: phonetic_data_key_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX phonetic_data_key_idx ON phonetic_data USING btree (phonetic_data_key);


--
-- Name: phonetic_data_type_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX phonetic_data_type_idx ON phonetic_data USING btree (phonetic_data_type);


--
-- Name: plugin_config_plugin_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE UNIQUE INDEX plugin_config_plugin_id_idx ON plugin_config USING btree (plugin_config_plugin_id, plugin_config_parent_id, plugin_config_parent_model, plugin_config_key);


--
-- Name: settlement_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX settlement_id_idx ON settlement_log USING btree (settlement_id);


--
-- Name: settlement_unique_ach_batch_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE UNIQUE INDEX settlement_unique_ach_batch_idx ON settlement USING btree (settlement_ach_batch_id);


--
-- Name: settlement_unique_ach_entry_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE UNIQUE INDEX settlement_unique_ach_entry_idx ON settlement USING btree (settlement_ach_entry_id);


--
-- Name: user_id_idx; Type: INDEX; Schema: public; Owner: openach_test; Tablespace: 
--

CREATE INDEX user_id_idx ON user_log USING btree (user_id);


--
-- Name: auth_assignment_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: openach_test
--

ALTER TABLE ONLY auth_assignment
    ADD CONSTRAINT auth_assignment_ibfk_1 FOREIGN KEY (auth_assignment_itemname) REFERENCES auth_item(auth_item_name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item_tree_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: openach_test
--

ALTER TABLE ONLY auth_item_tree
    ADD CONSTRAINT auth_item_tree_ibfk_1 FOREIGN KEY (auth_item_tree_parent) REFERENCES auth_item(auth_item_name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item_tree_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: openach_test
--

ALTER TABLE ONLY auth_item_tree
    ADD CONSTRAINT auth_item_tree_ibfk_2 FOREIGN KEY (auth_item_tree_child) REFERENCES auth_item(auth_item_name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

