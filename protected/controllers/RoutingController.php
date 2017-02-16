<?php

class RoutingController extends Controller
{
	public function actionLookup()
	{
		$returnObj = new StdClass();
		if ( ! Yii::app()->request->getParam( 'dfi' ) )
		{
			$returnObj->customer_name = 'Unknown';
			print json_encode( $returnObj );
		}
		else
		{
			$routing = FedACH::model()->findByPk( Yii::app()->request->getParam( 'dfi' ) );
			$returnObj->customer_name = $routing->fedach_customer_name;
			$returnObj->city = $routing->fedach_city;
			$returnObj->state_province = $routing->fedach_state_province;
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
