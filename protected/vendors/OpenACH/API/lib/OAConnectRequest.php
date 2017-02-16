<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

// Make initial connection, autheticate and get sessionId
class OAConnectRequest extends OAAPIRequest
{
	public $action = 'connect';
}

// Close the connection, autheticate and get sessionId
class OADisconnectRequest extends OAAPIRequest
{
	public $action = 'disconnect';
}

// Get a single external account, given an external account id
class OAGetExternalAccountRequest extends OAAPIRequest
{
	public $action = 'getExternalAccount';
}

// Get all external accounts, given a payment profile id
class OAGetExternalAccountsRequest extends OAAPIRequest
{
	public $action = 'getExternalAccounts';
}

// Get summary information of external accounts for a given payment profile id
class OAGetExternalAccountsSummaryRequest extends OAAPIRequest
{
	public $action = 'getExternalAccountsSummary';
}

// Get a payment profile, given a payment profile id
class OAGetPaymentProfileRequest extends OAAPIRequest
{
	public $action = 'getPaymentProfile';
}

// Get a payment profile, given an external id
class OAGetPaymentProfileByExtIdRequest extends OAAPIRequest
{
	public $action = 'getPaymentProfileByExtId';
}

// Get a payment schedule, given a payment schedule id
class OAGetPaymentScheduleRequest extends OAAPIRequest
{
	public $action = 'getPaymentSchedule';
}

// Get all payment schedules, given a payment profile id
class OAGetPaymentSchedulesRequest extends OAAPIRequest
{
	public $action = 'getPaymentSchedules';
}

// Get summary information of external accounts for a given payment profile id
class OAGetPaymentSchedulesSummaryRequest extends OAAPIRequest
{
	 public $action = 'getPaymentSchedulesSummary';
}

// Get a single payment type by id
class OAGetPaymentTypeRequest extends OAAPIRequest
{
	public $action = 'getPaymentType';
}

// Get all available payment types
class OAGetPaymentTypesRequest extends OAAPIRequest
{
	public $action = 'getPaymentTypes';
}

// Save an external account
class OASaveExternalAccountRequest extends OAAPIRequest
{
	public $action = 'saveExternalAccount';
}

// Save a payment profile
class OASavePaymentProfileRequest extends OAAPIRequest
{
	public $action = 'savePaymentProfile';
}

// Save a payment schedule
class OASavePaymentScheduleRequest extends OAAPIRequest
{
	public $action = 'savePaymentSchedule';
}

// Disable or enable a payment profile
class OAChangePaymentProfileStatusRequest extends OAAPIRequest
{
	public $action = 'changePaymentProfileSatus';
}

// Disable or enable a payment schedule
class OAChangePaymentScheduleStatusRequest extends OAAPIRequest
{
	public $action = 'changePaymentScheduleStatus';
}

// Save a complete set of: payment profile, external account and payment schedule
class OASaveProfileCompleteRequest extends OAAPIRequest
{
	public $action = 'saveProfileComplete';
}


