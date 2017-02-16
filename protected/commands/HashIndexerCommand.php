<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * HashIndexerCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class HashIndexerCommand extends CConsoleCommand
{

	public function actionAll()
	{
		$this->actionPaymentProfile();
		$this->actionOriginatorInfo();
	}
	protected function indexEntity( $entityClass )
	{
		echo 'Indexing ' . $entityClass . "\t";
		$entities = $entityClass::model()->findAll();
		$recordCount = 0;
		foreach ( $entities as $entity )
		{
			// Prevent reindexing of the Phonetic index and logging
			$entity->disableBehavior( 'CPhoneticIndexBehavior' );
			$entity->disableBehavior( 'CActiveLogBehavior' );

			$recordCount++;
			$entity->save();
		}
		echo '[' . $recordCount . ']' . PHP_EOL;
	}
	public function actionPaymentProfile()
	{
		$this->indexEntity( 'PaymentProfile' );
	}
	public function actionOriginatorInfo()
	{
		$this->indexEntity( 'OriginatorInfo' );
	}

}
