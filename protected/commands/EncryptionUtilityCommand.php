<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * EncryptionUtilityCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class EncryptionUtilityCommand extends CConsoleCommand
{

	public function actionEncrypt( $model, $field )
	{
		$securityManager = Yii::app()->securityManager;
		$dbTrans = Yii::app()->db->beginTransaction();
		try
		{
			$results = $model::model()->findAll();
			foreach ( $results as $record )
			{
				$origValue = $record->getAttribute( $field );
				if ( empty( $origValue ) )
				{
					continue;
				}
				$record->setAttribute( $field, base64_encode( $securityManager->encrypt( $origValue ) ) );
				if ( ! $record->save( false ) )
				{
					throw new Exception( var_export( $record->getErrors(), true ) );
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

	public function actionDecrypt( $model, $field )
	{
		$securityManager = Yii::app()->securityManager;
		$dbTrans = Yii::app()->db->beginTransaction();
		try
		{
			$results = $model::model()->findAll();
			foreach ( $results as $record )
			{
				$origValue = $record->getAttribute( $field );
				if ( empty( $origValue ) )
				{
					continue;
				}
				$record->setAttribute( $field, $securityManager->decrypt( base64_decode( $origValue ) ) );
				if ( ! $record->save( false ) )
				{
					throw new Exception( var_export( $record->getErrors(), true ) );
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

	public function actionEncryptValue( $value )
	{
		$securityManager = Yii::app()->securityManager;
		echo base64_encode( $securityManager->encrypt( $value ) ) . PHP_EOL;
	}

	public function actionDecryptValue( $value )
	{
		$securityManager = Yii::app()->securityManager;
		echo $securityManager->decrypt( base64_decode( $value ) ) . PHP_EOL;     
	}


}
