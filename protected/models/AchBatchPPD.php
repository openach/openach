<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * This is the model class for table "ach_batch", and is extended for PPD specific records
 */
class AchBatchPPD extends AchBatch
{
	public $ach_batch_header_standard_entry_class  = 'PPD';

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
		return $this;
	}

	public function calculateEntryHash()
	{
		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$sumField = 'ach_entry_detail_receiving_dfi_id';
		}
		if ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$sumField = "to_number( ach_entry_detail_receiving_dfi_id, '9999999999' )";
		}
		if ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$sumField = 'cast( ach_entry_detail_receiving_dfi_id AS INTEGER )';
		}

		$command = Yii::app()->db->createCommand()
			->select('SUM( ' . $sumField . ' ) AS hash' )
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

