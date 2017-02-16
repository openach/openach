<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * CronNightlyCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

Yii::import( 'application.commands.*' );

class CronNightlyCommand extends CConsoleCommand
{

	public function actionRun()
	{

		echo 'Running payment scheduler...' . PHP_EOL;
		$paymentScheduler = new PaymentSchedulerCommand( $this->name, $this->commandRunner );
		$paymentScheduler->actionRun();

		echo 'Running batch builder...' . PHP_EOL;
		//$batchBuilder = new BatchBuilderCommand( $this->name, $this->commandRunner );
		$batchBuilder = new AltBatchBuilderCommand( $this->name, $this->commandRunner );
		$batchBuilder->actionRun();

		echo 'Running file builder...' . PHP_EOL;
		$fileBuilder = new FileBuilderCommand( $this->name, $this->commandRunner );
		$fileBuilder->actionRun();
	}

}
