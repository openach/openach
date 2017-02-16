<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/


class OAConnection extends OAClient
{
	const IDTYPE_INTERNAL = 1;
	const IDTYPE_EXTERNAL = 2;
	const IDTYPE_APP = self::IDTYPE_EXTERNAL;
	const IDTYPE_API = self::IDTYPE_INTERNAL;

	protected $debugLevel = 0;

        protected $lastResponse;

	protected $paymentTypes;

	protected $paymentProfileId;
	protected $paymentProfileIdType;

	protected $externalAccounts;
	protected $externalAccountId;

	protected $paymentSchedules;
	protected $paymentScheduleId;

        // Establish the connection/session to the server
        public function connect( $profileId='', $profileIdType='', $apiToken='', $apiKey='', $endpointUrl='', $portNumber='' )
        {
                $this->lastResponse = parent::connect($apiToken, $apiKey, $endpointUrl, $portNumber);
                if ( ! $this->lastResponse->success )
                {
                        var_dump( $this->lastResponse );
                        throw new Exception( $this->lastResponse->error );
                } else {
                        if ($this->debugLevel >= 1) { echo "Connected: " + var_dump( $this->lastResponse ); }
                }

                if ( $profileId ) {
                        $this->setPaymentProfileId( $profileId, $profileIdType );
                }
                return $this->lastResponse;
        }

	public function isConnected()
	{
		return isset($this->sessionId);
	}

	// Sets the current "default" profile that will be used for all functions that require a profile
	public function setPaymentProfileId( $profileId = '', $type=self::IDTYPE_APP )
	{
		$this->paymentProfileId = $profileId;
		$this->paymentProfileIdType = $type;
		if ( !$profileId ) {
			$this->setExternalAccountId('');
		}
	}


	// Retrieves the Payment Profile of the given id (if not provided, uses the preset profileId)
	public function getPaymentProfile( $profileId = '', $type = '' )
	{
		if (!$profileId) { $profileId = $this->paymentProfileId; }
		if (!$type) { $type = $this->paymentProfileIdType; }

		if ($this->debugLevel >= 1) { echo "Getting Payment Profile: " . $profileId . " - " . $type . PHP_EOL; }

		switch ($type) {
			case self::IDTYPE_APP:
				return $this->getPaymentProfileByExtId( $profileId );
			case self::IDTYPE_API:
				return $this->getPaymentProfileByIntId( $profileId );
		}
		
	}

	// The user of the API will think of things in reverse from OpenACH's perspective
	// To the API user, what OpenACH thinks of as an external id, is the app's internal id, and OA's id is OA's magic/special internal id.
	// Because of this, these methods are protected and getPaymentProfile() takes care of calling the correct method
	
	// Get PaymentProfile by OA's internal identifier (The API ID)
	protected function getPaymentProfileByIntId( $profileId = '' )
	{
		if ( !$profileId ) { $profileId = $this->paymentProfileId; }

		$req = new OAGetPaymentProfileRequest();

		//$req->payment_profile_id = '789937d2-429f-426d-9508-1efb61ac41fb';
		$req->payment_profile_id = $profileId;

        	if ($this->debugLevel >= 1) { __FUNCTION__ . " Request: " .  var_dump( $req ); }
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Request: " . var_dump( $this->lastResponse ); }
			$this->paymentProfile = $this->lastResponse;
		}

		return $this->paymentProfile;
	}
 
	// Get PaymentProfile by OA's external identifier (The APP ID)
	protected function getPaymentProfileByExtId( $profileId = '' )
	{
		if ( !$profileId ) { $profileId = $this->paymentProfileId; }

		$req = new OAGetPaymentProfileByExtIdRequest();

		//$req->payment_profile_external_id = 17;
		$req->payment_profile_external_id = $profileId;

        	if ($this->debugLevel >= 1) { __FUNCTION__ . " Request: " . var_dump( $req ); }
		$this->lastResponse = $this->sendRequest( $req );
		
		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Request: " . var_dump( $this->lastResponse ); }
			$this->paymentProfile = $this->lastResponse;
		}

		return $this->paymentProfile;
	}

        public function setPaymentProfileReq( $req, $profileId = '', $type = '' )
        {
                if ( !$profileId ) { $profileId = $this->paymentProfileId; }
                if ( !$type ) { $type = $this->paymentProfileIdType; }

                switch ( $type ) {
			case self::IDTYPE_APP:
                                $req->payment_profile_external_id = $profileId;
                                break;
			case self::IDTYPE_API:
                                $req->payment_profile_id = $profileId;
                                break;
                }
                if ($this->debugLevel >= 1) { __FUNCTION__ . " Request: " . var_dump( $req ); }
                return $req;
        }

	public function changePaymentProfileStatus( $newStatus = '', $profileId = '', $type = '' )
	{
		$req = new OAChangePaymentProfileStatusRequest();
		$req->payment_profile_status = $newStatus;

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );


		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;
	}

	public function getPaymentTypes( $profileId = '', $type = '' )
	{
		$req = new OAGetPaymentTypesRequest();

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
			var_dump( $this->lastResponse );
			throw new Exception( $this->lastResponse->error );
		} else {
			if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
			$this->paymentTypes = $this->lastResponse;
		}
		return $this->paymentTypes;
	}

	public function getExternalAccountsSummary( $profileId = '', $type = '' )
	{
		$req = new OAGetExternalAccountsSummaryRequest();

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
			if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
			$this->externalAccounts = $this->lastResponse;
		}
		return $this->externalAccounts;
	}

	// Sets the current "default" external account that will be used for all functions that require an external account
	public function setExternalAccountId( $accountId )
	{
		$this->externalAccountId = $accountId;
		if ( !$accountId ) {
			$this->setPaymentScheduleId('');
		}
	}
	
	// Get PaymentProfile by OA's internal identifier (The API ID)
	public function getExternalAccount( $accountId = '', $profileId = '', $type = '' )
	{
		if ( !$accountId ) { $accountId = $this->externalAccountId; }

		$req = new OAGetExternalAccountRequest();
		//$req->external_account_id = '02702c16-f525-491d-8710-008bb0988651';
		$req->external_account_id = $accountId;

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;
	}

	public function changeExternalAccountStatus( $newStatus = '', $accountId = '', $profileId = '', $type = '' )
	{
		if ( !$accountId ) { $accountId = $this->externalAccountId; }

		$req = new OAChangeExternalAccountStatusRequest();
		$req->external_account_status = $newStatus;

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;
	}

        public function saveExternalAccount( OAAPIResponse $externalAccount = null )
	{
		$req = new OASaveExternalAccountRequest( $externalAccount );

		// If a Payment Profile hasn't been assigned yet, and the IDTYPE is API, then assign the default ProfileID
		if ( !isset($req->external_account_payment_profile_id) ) {
			if ( $this->paymentProfileIdType == self::IDTYPE_API ) {
				$req->external_account_payment_profile_id = $this->paymentProfileId;
			}
		}

		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;

        	//external_account_id =
        	//external_account_payment_profile_id =
        	//external_account_type =
        	//external_account_name =
        	//external_account_bank =
        	//external_account_holder =
        	//external_account_country_code =
        	//external_account_dfi_id =
        	//external_account_number =
        	//external_account_billing_address = 
        	//external_account_billing_city = 
        	//external_account_billing_state_province = 
        	//external_account_billing_postal_code = 
        	//external_account_billing_country = 
        	//external_account_business = 
        	//external_account_verification_status =
        	//external_account_status =

	}

	public function getPaymentSchedulesSummary( $accountId = '', $profileId = '', $type = '' ) // $scheduleId )
	{
		//$req = new OAGetPaymentSchedulesSummaryRequest();
		$req = new OAGetPaymentSchedulesRequest();

		// // It seems like an external_account_id should be optional....
		// //$req->external_account_id = '02702c16-f525-491d-8710-008bb0988651';
		// if ( !$accountId ) { $accountId = $this->externalAccountId; }
		// $req->external_account_id = $accountId;

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
			$this->paymentSchedules = $this->lastResponse;
		}
		return $this->paymentSchedules;
	}

	// Sets the current "default" paymentSchedule that will be used for all functions that require a paymentSchedule
	public function setPaymentScheduleId( $scheduleId )
	{
		$this->paymentScheduleId = $scheduleId;
	}

	public function getPaymentSchedule( $scheduleId = '', $accountId = '', $profileId = '', $type = '' ) 
	{
		if ( !$scheduleId ) { $scheduleId = $this->paymentScheduleId; }
		if ( !$accountId ) { $accountId = $this->externalAccountId; }

		$req = new OAGetPaymentScheduleRequest();
		$req->payment_schedule_id = $scheduleId;
		$req->payment_schedule_external_account_id = $accountId;

		// PaymentSchedule gets PaymentProfile through the External Account
		// $this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
			$this->paymentSchedule = $this->lastResponse;
		}

		return $this->paymentSchedule;
	}

	public function changePaymentScheduleStatus( $newStatus = '', $scheduleId = '', $profileId = '', $type = '' )
	{
		if ( !$scheduleId ) { $scheduleId = $this->paymentScheduleId; }

		$req = new OAChangePaymentScheduleStatusRequest();
		$req->payment_schedule_status = $newStatus;

		$this->setPaymentProfileReq( $req, $profileId, $type );
		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;
	}

        public function savePaymentSchedule( OAAPIResponse $paymentSchedule = null )
	{
		$req = new OASavePaymentScheduleRequest( $paymentSchedule );
		//if ( !$req->payment_schedule_external_account_id ) {
		//	$req->payment_schedule_external_account_id = $this->externalAccountId;
		//}

		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;

		//payment_schedule_id =
		//payment_schedule_external_account_id =
		//payment_schedule_payment_type_id =
		//payment_schedule_amount =
		//payment_schedule_currency_code =
		//payment_schedule_next_date =
		//payment_schedule_frequency =
		//payment_schedule_end_date =
		//payment_schedule_remaining_occurrences = 
		//payment_schedule_status =

	}

        public function savePaymentProfile( OAAPIResponse $paymentProfile = null )
	{
		$req = new OASavePaymentProfileRequest( $paymentProfile );

		$this->lastResponse = $this->sendRequest( $req );

		if ( ! $this->lastResponse->success )
		{
        		var_dump( $this->lastResponse );
        		throw new Exception( $this->lastResponse->error );
		} else {
        		if ($this->debugLevel >= 1) { __FUNCTION__ . " Response: " . var_dump( $this->lastResponse ); }
		}

		return $this->lastResponse;

        	//payment_profile_id = 
        	//payment_profile_external_id = 
        	//payment_profile_first_name = 
        	//payment_profile_last_name = 
        	//payment_profile_email_address = 
        	//payment_profile_password = 
        	//payment_profile_security_question_1 = 
        	//payment_profile_security_question_2 = 
        	//payment_profile_security_question_3 = 
        	//payment_profile_security_answer_1 = 
        	//payment_profile_security_answer_2 = 
        	//payment_profile_security_answer_3 = 
        	//payment_profile_status = enabled
	}


        public function actionSaveProfileComplete( $profileId = '', $type = '' )
	{
		// Combine all fields from Payment Profile, External Account, and Payment Schedule
	}




}

?>

