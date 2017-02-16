<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

return array(
'PaymentProfile_1' => array(
	'payment_profile_id' => '789937d2-429f-426d-9508-1efb61ac41fb',
// These values tend to change when testing, so there's no need to check against them
/*	'payment_profile_external_id' => '2329-profilesim',  // Commented because this field might change
	'payment_profile_first_name' => 'Cathleen',
	'payment_profile_last_name' => 'Stanley',
	'payment_profile_email_address' => 'arcu.ac.orci@pellentesquemassalobortis.com',
	'payment_profile_password' => '',
*/
	'payment_profile_security_question_1' => 'What is your favorite color?',
	'payment_profile_security_question_2' => 'What is capital of Assyria?',
	'payment_profile_security_question_3' => 'What is the air-speed velocity of an unladen swallow?',
	'payment_profile_security_answer_1' => 'Blue',
	'payment_profile_security_answer_2' => 'Nineveh',
	'payment_profile_security_answer_3' => 'African or European?',
	'payment_profile_status' => 'enabled',
),
);
