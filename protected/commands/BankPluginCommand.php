<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * PluginCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class BankPluginCommand extends CConsoleCommand
{

	public function actionRegister( $class )
	{
		Yii::import( 'application.vendors.OpenACH.nacha.Banks.*' );
		$odfiBranch = OdfiBranch::model();
		$pluginConfig = new $class( $odfiBranch );
		try
		{
			$pluginConfig->register();
		}
		catch ( Exception $e )
		{
			echo $e->getMessage() . PHP_EOL;
		}
		Yii::app()->end();
	}

	public function actionView( $odfi_branch_id )
	{
		if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfi_branch_id ) )
		{
			throw new Exception( 'Unable to find ODFI Branch ' . $odfi_branch_id );
		}

		$config = $odfiBranch->getBankConfig();

		if ( ! $config )
		{
			throw new Exception( 'Unable to load config.' );
		}

		echo "Using Bank Plugin: " .  $odfiBranch->odfi_branch_plugin . PHP_EOL;
		echo "Transfer Configuration:" . PHP_EOL;
		echo json_encode( $config->getTransferConfig() ) . PHP_EOL . PHP_EOL;

		echo "Record Configuration:" . PHP_EOL;
		echo json_encode( $config->getRecordConfig() ) . PHP_EOL . PHP_EOL;

		Yii::app()->end();

	}

	public function actionSetPlugin( $odfi_branch_id, $plugin )
	{
		if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfi_branch_id ) )
		{
			throw new Exception( 'Unable to find ODFI Branch ' . $odfi_branch_id );
		}

		$odfiBranch->odfi_branch_plugin = $plugin;
		$odfiBranch->save();

		$config = $odfiBranch->getBankConfig();

		if ( ! $config )
		{
			throw new Exception( 'Unable to load config.' );
		}

		// The first time it will give us a default config
		$transferConfig = $config->getTransferConfig();

		// Now we can save the default config
		$config->setTransferConfig( $transferConfig );
		$config->store( $odfi_branch_id );

		echo "Using Bank Plugin: " .  $odfiBranch->odfi_branch_plugin . PHP_EOL;
		echo "Configuration:" . PHP_EOL;
		echo json_encode( $transferConfig ) . PHP_EOL;

	}

	public function actionUpdateRecordConfig( $odfi_branch_id, $newConfig )
	{
		if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfi_branch_id ) )
		{
			throw new Exception( 'Unable to find ODFI Branch ' . $odfi_branch_id );
		}

		$config = $odfiBranch->getBankConfig();

		if ( ! $config )
		{
			throw new Exception( 'Unable to load config.' );
		}

		$decoded = json_decode( $newConfig );

		if ( $decoded === null )
		{
			throw new Exception( 'Unable to json_decode the specified config.' );
		}

		$config->setRecordConfig( $newConfig );
		$config->store( $odfi_branch_id );

		Yii::app()->end();
	}


	public function actionUpdateTransferConfig( $odfi_branch_id, $newConfig )
	{
		if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfi_branch_id ) )
		{
			throw new Exception( 'Unable to find ODFI Branch ' . $odfi_branch_id );
		}

		$config = $odfiBranch->getBankConfig();

		if ( ! $config )
		{
			throw new Exception( 'Unable to load config.' );
		}

		$decoded = json_decode( $newConfig );

		if ( $decoded === null )
		{
			throw new Exception( 'Unable to json_decode the specified config.' );
		}

		$config->setTransferConfig( $decoded );
		$config->store( $odfi_branch_id );

		Yii::app()->end();
	}

	public function actionTest( $odfi_branch_id )
	{
		if ( ! $odfiBranch = OdfiBranch::model()->findByPk( $odfi_branch_id ) )
		{
			throw new Exception( 'Unable to find ODFI Branch ' . $odfi_branch_id );
		}

		$config = $odfiBranch->getBankConfig();

		if ( ! $config )
		{
			throw new Exception( 'Unable to load config.' );
		}

		$client = OATransferAgent::factory( $config );

		$client->test();

		echo 'Successfully connected to the ODFI Branch using ' . get_class( $client ) . PHP_EOL;

		Yii::app()->end();
	}


}
