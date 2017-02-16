--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Data for Name: menu_item; Type: TABLE DATA; Schema: public; Owner: openach_test
--

INSERT INTO menu_item VALUES ('001ea5d0-c7b0-11e1-b011-cba6ef56c07b', 'BottomNavigation', 'Administration', '', 'admin/', '', '', 'Administration', '', 0, 'admin');
INSERT INTO menu_item VALUES ('001eade0-c7b0-11e1-9bf1-dd6bf85c4e58', 'ProfileNavigation', 'Settings', '', 'user/profile/', '', '/images/icons/large/user.png', 'Profile', '', 0, '');
INSERT INTO menu_item VALUES ('001eb3c0-c7b0-11e1-acc9-f7b99b2bd7e8', 'AdminPanelNavigation', 'Administration', '', 'user/index/', '', '/images/icons/large/user.png', 'Users', 'Manage user accounts', 0, 'admin');
INSERT INTO menu_item VALUES ('001ebb00-c7b0-11e1-a4bb-f171fc5cc981', 'ProfileNavigation', 'Settings', '', 'user/password/', '', '', 'Password', '', 0, '');
INSERT INTO menu_item VALUES ('001ec2a0-c7b0-11e1-8d32-b1845c9de662', 'ProfileNavigation', 'Settings', '', 'user/security/', '', '', 'Security', '', 0, '');
INSERT INTO menu_item VALUES ('001ec9a0-c7b0-11e1-9f95-a907f8d33ff5', 'AdminPanelNavigation', 'Administration', '', 'role/index/', '', '/images/icons/large/role.png', 'Roles', 'Manage user roles', 0, 'admin');
INSERT INTO menu_item VALUES ('001ecfa0-c7b0-11e1-a60f-7379c0de28cc', 'ProfileNavigation', 'Settings', '', 'user/preferences/', '', '', 'Preferences', '', 0, '');
INSERT INTO menu_item VALUES ('001ed580-c7b0-11e1-b2dc-a94c1bd51aa0', 'AdminPanelNavigation', 'Administration', '', 'originator/index/', '', '/images/icons/large/originator.png', 'Originators', 'Manage ACH originators', 0, 'admin');
INSERT INTO menu_item VALUES ('001edb80-c7b0-11e1-8509-efa5ab54ebdd', 'AdminPanelNavigation', 'Administration', '', 'site/logout/', '', '/images/icons/large/secure.png', 'Log Out', 'Log out of OpenACH ', 0, '');
INSERT INTO menu_item VALUES ('001ee200-c7b0-11e1-b5ae-33b268395342', 'BottomNavigation', 'Administration', '', 'achFile/index', '', '/images/icons/large/achfile.png', 'ACH Files', '', 0, '');
INSERT INTO menu_item VALUES ('001eea00-c7b0-11e1-b617-c37bf2457836', 'BottomNavigation', 'Administration', '', 'paymentSchedule/index', '', '/images/icons/large/schedule.png', 'Payment Schedules', '', 0, '');
INSERT INTO menu_item VALUES ('001ef340-c7b0-11e1-9611-c317a92d8f6a', 'OriginatorInfoPanelNavigation', 'OriginatorInfo', '', 'achBatch/index/', '', '/images/icons/large/achbatch.png', 'Batches', 'ACH Batches', 1, '');
INSERT INTO menu_item VALUES ('001efb00-c7b0-11e1-9b33-7331c313a751', 'OriginatorInfoPanelNavigation', 'OriginatorInfo', '', 'paymentProfile/index/', '', '/images/icons/large/customer.png', 'Payment Profiles', 'Manage payment profiles', 0, '');



--
-- Data for Name: plugin; Type: TABLE DATA; Schema: public; Owner: openach_test
--

INSERT INTO plugin VALUES ('038386d2-249c-4738-acbf-5bbb2fc7e1a6', 'enabled', 'USBankConfig', '0.1');
INSERT INTO plugin VALUES ('88e9417a-fecf-4c00-9782-a003eb606101', 'enabled', 'ManualConfig', '0.1');
INSERT INTO plugin VALUES ('8ab22a88-dffe-48dc-95bb-7b16fdf5be86', 'enabled', 'WellsFargoConfig', '0.1');
INSERT INTO plugin VALUES ('f9a5e52e-8ef7-44a4-8add-c9e77d4fb678', 'enabled', 'SagePayConfig', '0.1');



--
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: openach_test
--

INSERT INTO role VALUES ('dd8705ae-b798-11e0-b684-00163e4c6b77', 'administrator', 'System administrator', 0, 0, 0, 0, 0, 0);
INSERT INTO role VALUES ('e145441c-b798-11e0-b684-00163e4c6b77', 'basic_no_iat', 'Basic origination with one ODFI, and one file per day, unlimited batches, no IAT', 1, 1, 1, 1, -1, 0);
INSERT INTO role VALUES ('e75ff8f6-b798-11e0-b684-00163e4c6b77', 'basic_iat', 'Basic origination with one ODFI, and one file per day, unlimited batches, with IAT', 1, 1, 1, 1, -1, 1);
INSERT INTO role VALUES ('ea513212-b798-11e0-b684-00163e4c6b77', 'advanced_no_iat', 'Advanced origination with unlimited ODFIs, unlimited files per day, unlimited batches, no IAT', -1, -1, -1, -1, -1, 0);
INSERT INTO role VALUES ('ed767742-b798-11e0-b684-00163e4c6b77', 'advanced_iat', 'Advanced origination with unlimited ODFIs, unlimited files per day, unlimited batches, with IAT', -1, -1, -1, -1, -1, 1);



