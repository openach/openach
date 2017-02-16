<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_batch", and is extended for IAT specific records
 */
class AchBatchIAT extends AchBatch
{
	public $ach_batch_header_standard_entry_class = 'IAT';

	/**
	 * Returns the static model of the specified AR class.
	 * @return AchBatch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function createFromPaymentType( $paymentType )
	{
		$originatorInfo = $paymentType->originator_info;
		$odfiBranch = $originatorInfo->odfi_branch;
		$this->ach_batch_header_service_class_code = $paymentType->getServiceClassCode();
		$this->ach_batch_header_company_name = $originatorInfo->originator_info_name;
		$this->ach_batch_header_company_identification = $originatorInfo->originator_info_identification;
		$this->ach_batch_header_company_entry_description = $paymentType->payment_type_name;
		$this->ach_batch_header_company_descriptive_date = '';
		$this->ach_batch_header_effective_entry_date = '';
		$this->ach_batch_header_settlement_date = '';
		$this->ach_batch_header_originating_dfi_id = substr( $odfiBranch->odfi_branch_dfi_id, 0, 8 );
		$this->ach_batch_payment_type_id = $paymentType->payment_type_id;
		$this->ach_batch_originator_info_id = $originatorInfo->originator_info_id;

		$this->ach_batch_iat_indicator = '';
		$this->ach_batch_iat_foreign_exchange_indicator = 'FV';
		$this->ach_batch_iat_foreign_exchange_ref_indicator = '';
		$this->ach_batch_iat_foreign_exchange_rate_ref = '';
		$this->ach_batch_iat_iso_orig_currency_code = 'USD';

		return $this;
	}

	public function calculateEntryHash()
	{
		$command = Yii::app()->db->createCommand()
			->select('SUM( ach_entry_iat_go_receiving_dfi_id ) AS hash' )
			->from( 'ach_entry' )
			->join( 'ach_batch', 'ach_entry_ach_batch_id = ach_batch_id AND ach_batch_id = :ach_batch_id' );

		if ( ! $hashResult = $command->queryRow( true, array( ':ach_batch_id'=>$this->ach_batch_id ) ) )
		{
			throw new Exception( 'Unable to calculate entry hash for batch.' );
		}
		else
		{
			$this->ach_batch_control_entry_hash = substr( $hashResult['hash'], -10 );
		}
	}

}

