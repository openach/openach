<?php

class FileTransferController extends OAController
{

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=FileTransfer::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
			elseif( ! Yii::app()->user->model()->isAuthorized( $this->_model ) )
				throw new CHttpException(401,'Not authoried.');
		}
		return $this->_model;
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
