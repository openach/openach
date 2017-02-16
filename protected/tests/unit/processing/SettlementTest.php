<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class SettlementTest extends CTestCase
{
	public function testCreateSettlement()
	{
		$achBatches = AchBatch::model()->findAll();
		foreach ( $achBatches as $achBatch )
		{
			echo 'Testing ach_batch ' . $achBatch->ach_batch_id . PHP_EOL;
			$this->runBatchTest( $achBatch );
		}
	}

	protected function runBatchTest( AchBatch $achBatch )
	{

		$settlement = new Settlement();

		try
		{
			$dbTrans = Yii::app()->db->beginTransaction();
			$settlement->createFromAchBatch( $achBatch );

			// Assert it has all the fields
			$this->assertNotEmpty( $settlement->settlement_originator_info_id );
			$this->assertNotEmpty( $settlement->settlement_odfi_branch_id );
			$this->assertNotEmpty( $settlement->settlement_ach_batch_id );
			$this->assertNotEmpty( $settlement->settlement_ach_entry_id );
			$this->assertTrue( in_array( $settlement->settlement_transaction_type, array( 'credit', 'debit' ) ) );
			$this->assertNotEmpty( $settlement->settlement_amount );
			$this->assertNotEmpty( $settlement->settlement_effective_entry_date );

			$this->assertTrue( $settlement->save() );
			$this->assertNotEmpty( $settlement->settlement_id );
			$this->assertNotEmpty( $settlement->settlement_datetime );

			echo "\tSettlement transaction type: \t" . $settlement->settlement_transaction_type . PHP_EOL;
			echo "\tEffective Batch Date:\t\t" . $achBatch->ach_batch_header_effective_entry_date . PHP_EOL;
			echo "\tEffective Settlement Date:\t" . $settlement->settlement_effective_entry_date . PHP_EOL;

			if ( ! $achEntry = AchEntry::model()->findByPk( $settlement->settlement_ach_entry_id ) )
			{
				throw new Exception( 'Unable to load the ach entry for the settlement.' );
			}

			// We have to reload our model in order to use lazy loading
			$settlement = Settlement::model()->findByPk( $settlement->settlement_id );
			$this->assertLazyLoading( $settlement );

			$this->assertEntryValues( $achEntry, $settlement );

			$dbTrans->rollback();
		}
		catch ( Exception $e )
		{
			$dbTrans->rollback();
			throw $e;
		}

	}

	protected function assertLazyLoading( $settlement )
	{
		$this->assertInstanceOf( 'OriginatorInfo', $settlement->originator_info );
		$this->assertInstanceOf( 'OdfiBranch', $settlement->odfi_branch );
		$this->assertInstanceOf( 'AchEntry', $settlement->ach_entry );
		$this->assertInstanceOf( 'AchBatch', $settlement->ach_batch );
		$this->assertInstanceOf( 'PaymentType', $settlement->ach_batch->payment_type );
		$this->assertInstanceOf( 'ExternalAccount', $settlement->ach_batch->payment_type->external_account );
	}

	protected function assertEntryValues( $achEntry, $settlement )
	{
		$this->assertEquals( $achEntry->ach_entry_detail_amount, $settlement->settlement_amount );
		$this->assertEquals( $achEntry->ach_entry_external_account_id, $settlement->ach_batch->payment_type->external_account->external_account_id );
	}

	public function testCreateRequiresDbTrans()
	{
		$settlement = new Settlement();
		$achBatches = AchBatch::model()->findAll();

		// Run the test if we find at least one AchBatch
		if ( count( $achBatches ) > 0 )
		{
			$achBatch = $achBatches[0];

			$hasException = false;

			try
			{
				$settlement->createFromAchBatch( $achBatch );
			}
			catch ( Exception $e )
			{
				$hasException = true;
			}
			$this->assertTrue( $hasException );
		}
	}
	

}
