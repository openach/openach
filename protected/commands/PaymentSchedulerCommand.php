<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * PaymentSchedulerCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class PaymentSchedulerCommand extends CConsoleCommand
{

	protected $recordCount = 0;

	protected function findSchedules( $transactionType )
	{
/*

		if ( Yii::app()->db->schema instanceof CMysqlSchema )
		{
			$nextDateCheck = 'payment_schedule_next_date <= DATE_ADD( NOW(), INTERVAL :leadtime_next DAY )';
			$endDateCheck = 'payment_schedule_end_date >= DATE_ADD( NOW(), INTERVAL :leadtime_end DAY )';
			$leadTimeValue = Yii::app()->params['AchBatch']['LeadTime'][$transactionType];
		}
		elseif ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			// TODO:  Check that this works properly for payments scheduled TODAY for TODAY (something that probably shouldn't be happening)
			$nextDateCheck = 'payment_schedule_next_date <= NOW() + INTERVAL :leadtime_next';
			$endDateCheck = 'payment_schedule_end_date >= NOW() + INTERVAL :leadtime_end';
			$leadTimeValue =  Yii::app()->params['AchBatch']['LeadTime'][$transactionType] . ' days';
		}
		elseif ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$nextDateCheck = "payment_schedule_next_date <= date('now', :leadtime_next)";
			$endDateCheck = "payment_schedule_end_date >= date('now', :leadtime_end)";
			$leadTimeValue =  Yii::app()->params['AchBatch']['LeadTime'][$transactionType] . ' days';
		}
		else
		{
			throw new CException( 'Only MySQL and Postgresql are currently supported.' );
		}
*/
		$nextDateCheck = "payment_schedule_next_date <= :leadtime_next";
		$endDateCheck = "payment_schedule_end_date >= :leadtime_end";
		$leadTimeValue =  Yii::app()->params['AchBatch']['LeadTime'][$transactionType] . ' days';

		$command = Yii::app()->db->createCommand()
			->select( '*' )
			->from( 'payment_schedule' )
			->join( 'payment_type', 
					array( 
						'AND',
						'payment_schedule_payment_type_id = payment_type_id',
						'payment_type_status = :payment_type_status',
						'payment_type_transaction_type = :payment_type_transaction_type'
					),
					array( 
						':payment_type_status' => 'enabled',
						':payment_type_transaction_type' => $transactionType
					 )
				)
			->join( 'external_account',
					array(
						'AND',
						'external_account_id = payment_schedule_external_account_id',
						'external_account_status = :external_account_status'
					),
					array(
						':external_account_status' => 'enabled'
					)
				)
			->join( 'payment_profile',
					array(
						'AND',
						'payment_profile_id = external_account_payment_profile_id',
						'payment_profile_status = :payment_profile_status'
					),
					array(
						':payment_profile_status' => 'enabled'
					)
				)
			->where( 	array(
						'AND',
						'payment_schedule_status = :payment_schedule_status',
						$nextDateCheck,
						$endDateCheck,
						'payment_schedule_remaining_occurrences > 0'
					),
					array(
						':payment_schedule_status' => 'enabled',
						':leadtime_next' => date('Y-m-d', strtotime($leadTimeValue)),
						':leadtime_end' => date('Y-m-d', strtotime($leadTimeValue))
					)
						//':leadtime_next' => $leadTimeValue,
						//':leadtime_end' => $leadTimeValue
				);
			$result = $command->query();
			return $result;
	}

	public function actionRun()
	{
		echo 'Running schedules...' . "\t" . PHP_EOL;
		$this->recordCount = 0;
		$lastRecordCount = $this->recordCount;
		$hasUnprocessed = array( 'credit' => true, 'debit' => 'true' );

		// This will continue looping through the schedules until they are all caught up
		while ( $hasUnprocessed['credit'] && $hasUnprocessed['debit'] )
		{
			foreach ( array( 'credit', 'debit' ) as $transactionType )
			{
				$schedules = $this->findSchedules( $transactionType );
				$lastRecordCount = $this->recordCount;
				$this->runSchedules( $schedules );
				if ( $this->recordCount == $lastRecordCount )
				{
					$hasUnprocessed[$transactionType] = false;
				}
			}
		}

		echo '[' . $this->recordCount . ']' . PHP_EOL;

	}
	protected function runSchedules( $schedules )
	{
		foreach ( $schedules as $scheduleItem )
		{
			// do a quick build of a model rather than loading it from the DB again
			$schedule = new PaymentSchedule();
			$schedule->isNewRecord = false;
			$schedule->setAttributes( $scheduleItem, false );
//var_dump( $scheduleItem ); exit;

			//if ( ! $schedule = PaymentSchedule::model()->findByPk( $scheduleItem['payment_schedule_id'] ) )
			//{
			//	throw new Exception( 'Unable to load payment schedule by id ' . $scheduleItem['payment_schedule_id'] );
			//}

			echo 'Updating schedule ' . $this->recordCount . ' ' . $schedule->payment_schedule_id . PHP_EOL;
			$schedule->run();
			$this->recordCount++;
		}
	}

}
