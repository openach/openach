<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Save extends OAMobileApiAction
{

	public function run()
	{
		$this->assertAuth();

		if ( ! $payment_profile_id = Yii::app()->request->getParam( 'external_account_payment_profile_id' ) )
		{
			echo json_encode( $this->formatError( 'You must provide a payment profile id (external_account_payment_profile_id)' ) );
		}

		if ( Yii::app()->request->getParam( 'external_account_payment_profile_id' ) != $this->paymentProfile->payment_profile_id )
		{
			echo json_encode( $this->formatError( 'You are not authoried to update this external account for the specified payment profile.' );
		}

		// Existing record
		if ( $external_account_id = Yii::app()->request->getParam( 'external_account_id' ) )
		{
			// If this is an existing record, make sure we can find it
			if ( ! $externalAccount = $this->loadExternalAccountSafe( $external_account_id, $payment_profile_id ) )
			{
				echo json_encode( $this->formatError( 'Unable to find the specified external account.' ) );
				Yii::app()->end();
			}
			// Remove the account number and routing number, as we don't allow modifying these via the API
			// NOTE that this is done at the _GET and _POST level, as the request object just pulls from there

			$accountNumber = $externalAccount->external_account_number;
			$accountDfiId = $externalAccount->external_account_dfi_id;
			unset( $_GET['external_account_dfi_id'] );
			unset( $_POST['external_account_dfi_id'] );
			unset( $_GET['external_account_number'] );
			unset( $_POST['external_account_number'] );
			$externalAccount->apiImport( Yii::app()->request );

			$externalAccount->external_account_dfi_id = $accountDfiId;
			$externalAccount->external_account_number = $accountNumber;

			// Ensure that we remain the owner
			$externalAccount->external_account_payment_profile_id = $this->paymentProfile->payment_profile_id;
			
		}
		// New Record
		else
		{

			$externalAccount = new ExternalAccount();
			$externalAccount->apiImport( Yii::app()->request );

			// Verify that the account isn't already set up for this payment profile
			if ( ExternalAccount::accountExists( $payment_profile_id, $externalAccount->external_account_dfi_id, $externalAccount->external_account_number ) )
			{
				echo json_encode( $this->formatError( 'An account with that routing and account number already exists for this payment profile.' ) );
				Yii::app()->end();
			}
		}

		// Set required fields that aren't pulled in through the apiImport
		$externalAccount->external_account_payment_profile_id = $this->paymentProfile->payment_profile_id;

		if ( ! $externalAccount->save() )
		{
			$errors = $externalAccount->getErrors();
			echo json_encode( array( 'success'=>false, 'error'=>$errors ) );
			Yii::app()->end();
		}
		else
		{
			$externalAccount->refresh(); // Make sure to reload from the DB, avoiding any false-saves
			$exported = $externalAccount->apiExport();
			echo json_encode( $this->formatSuccess( $exported ) );
			Yii::app()->end();
		}
	}

}
