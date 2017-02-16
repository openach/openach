<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * PhoneticIndexerCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

Yii::import( 'application.vendors.OpenData.Random.*' );

class ProfileSimulatorCommand extends CConsoleCommand
{

	public $maxProfiles = 500;

	public function actionRun()
	{
		$randomNames = new Names();

		$criteria = new CDbCriteria();
		$criteria->addCondition( "fedach_routing_number LIKE '1%%%%%%%%'" );
		$criteria->limit = $this->maxProfiles;

		$fedAchModels = FedACH::model()->findAll( $criteria );

		if ( ! count( $fedAchModels ) )
		{
			throw new Exception( 'Unable to load routing numbers from fedach table.' );
		}
		$accountTypes = array( 'checking', 'savings' );

		$originatorInfos = OriginatorInfo::model()->findAll();

		$dbTrans = Yii::app()->db->beginTransaction();

		try
		{

			for ( $profileCount = 0; $profileCount < $this->maxProfiles; $profileCount++ )
			{
				$originatorInfo = $originatorInfos[ array_rand( $originatorInfos ) ];

				// If the originator has no payment types, we won't be able to set up any schedules, so continue to the next originator info...
				if ( ! $originatorInfo->payment_types )
				{
					continue;
				}

				$paymentProfile = new PaymentProfile();
				$paymentProfile->payment_profile_originator_info_id = $originatorInfo->originator_info_id;
				$paymentProfile->payment_profile_external_id = EntityIndex::model()->getNextId( 'ProfileSimulator-external_id' ) . '-profilesim';
				$paymentProfile->payment_profile_first_name = $randomNames->getFirstName();
				$paymentProfile->payment_profile_last_name = $randomNames->getLastName();
				$paymentProfile->payment_profile_email_address = $randomNames->getEmailAddress();
				$paymentProfile->payment_profile_security_question_1 = 'What is your favorite color?';
				$paymentProfile->payment_profile_security_question_2 = 'What is capital of Assyria?';
				$paymentProfile->payment_profile_security_question_3 = 'What is the air-speed velocity of an unladen swallow?';
				$paymentProfile->payment_profile_security_answer_1 = 'Blue';
				$paymentProfile->payment_profile_security_answer_2 = 'Nineveh';
				$paymentProfile->payment_profile_security_answer_3 = 'African or European?';
				$paymentProfile->payment_profile_status = 'enabled';
				if ( ! $paymentProfile->save() )
				{
					throw new Exception( 'Unable to save profile. ' . var_dump( $paymentProfile->getErrors(), true ) );
				}

				$fedAch = $fedAchModels[ array_rand( $fedAchModels ) ];

				$externalAccount = new ExternalAccount();
				$externalAccount->external_account_payment_profile_id = $paymentProfile->payment_profile_id;
				$externalAccount->external_account_holder = $paymentProfile->payment_profile_first_name . ' ' . $paymentProfile->payment_profile_last_name;
				$externalAccount->external_account_type = $accountTypes[ mt_rand( 0, 1 ) ];
				$externalAccount->external_account_dfi_id = $fedAch->fedach_routing_number;
				$externalAccount->external_account_number = mt_rand( 10000000, 999999999 );
				$externalAccount->external_account_name = 'Personal Bank Account';
				$externalAccount->external_account_bank = $fedAch->fedach_customer_name;
				$externalAccount->external_account_country_code = 'US';
				$externalAccount->external_account_verification_status = 'completed';
				$externalAccount->external_account_status = 'enabled';
				$externalAccount->external_account_business = mt_rand( 0, 1 );

				if ( !$externalAccount->save() )
				{
					throw new Exception( 'Unable to save external_account. ' . var_dump( $externalAccount->getErrors(), true ) );
				}

				$nextDate = new DateTime();
				$endDate = new DateTime();
				$endDate->add( new DateInterval('P' . mt_rand( 30, 365 ) . 'D') );
				

				$frequencyList = array( 'once','daily','weekly','biweekly','monthly','bimonthly','biannually','annually','biennially' );
				$paymentSchedule = new PaymentSchedule();
				$paymentSchedule->payment_schedule_external_account_id = $externalAccount->external_account_id;
				$paymentSchedule->payment_schedule_payment_type_id = $originatorInfo->payment_types[ array_rand( $originatorInfo->payment_types ) ]->payment_type_id;
				$paymentSchedule->payment_schedule_status = 'enabled';
				$paymentSchedule->payment_schedule_amount = mt_rand( 100, 100000 ) / 100;
				$paymentSchedule->payment_schedule_currency_code = 'USD';
				$paymentSchedule->payment_schedule_next_date = $nextDate->format( 'Y-m-d' );
				$paymentSchedule->payment_schedule_frequency = $frequencyList[ array_rand( $frequencyList ) ];
				$paymentSchedule->payment_schedule_end_date = $endDate->format( 'Y-m-d' );
				if ( !$paymentSchedule->save() )
				{
					throw new Exception( 'Unable to save payment schedule. ' . var_dump( $paymentSchedule->getErrors(), true ) );
				}
				
			}
			$dbTrans->commit();
		}
		catch ( Exception $e )
		{
			$dbTrans->rollback();
			throw $e;
		}
	}
}
