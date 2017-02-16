<?php

class BankPluginController extends Controller
{

	public function actionGoDfiLookup()
	{
		Yii::import( 'application.vendors.OpenACH.nacha.Banks.*' );

		$returnObj = new StdClass();
		$returnObj->gateway_dfi_id = '';
		if ( ! Yii::app()->request->getParam( 'id' ) )
		{
			$returnObj->error = 'Plugin not specified';
			print json_encode( $returnObj );
		}
		else
		{
			// Remove all non alpha-numeric chars from input
			$pluginId = ereg_replace('[^A-Za-z0-9]', '', Yii::app()->request->getParam( 'id' ) );
			$pluginId .= 'Config';
			// Verify that the plugin file actually exists before continuing
			$pluginFile = Yii::app()->basePath . '/vendors/OpenACH/nacha/Banks/' . $pluginId . '.php';
			if ( file_exists( $pluginFile ) )
			{
				Yii::import( 'application.vendors.OpenACH.nacha.Banks.*' );
				$plugin = new $pluginId;
				if ( $plugin instanceOf OABankConfig )
				{
					$returnObj->gateway_dfi_id = $plugin->getGatewayDfiId();
				}
			}
			else
			{
				$returnObj->error = 'Plugin not found';
			}

			print json_encode( $returnObj );
		}
		Yii::app()->end();

	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
