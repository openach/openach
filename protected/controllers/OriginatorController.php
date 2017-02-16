<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OriginatorController extends OAController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','search','delete','searchjson'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Originator;

		$this->performAjaxValidation($model);

		if( isset($_POST['Originator']))
		{
			$model->attributes=$_POST['Originator'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->originator_id));
		}

		$this->render('create',array(
			'model'=>$model,
			'parent_id'=>Yii::app()->request->getParam('parent_id')
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Originator']))
		{
			$model->attributes=$_POST['Originator'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->originator_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//$criteria = array( 'order' => 'originator_name ASC' );
		$dataProvider=new CActiveDataProvider( 'Originator', array(
				/*
				'pagination'=>array(
					'pageSize' => 10,
				),*/
				/* 'criteria' => $criteria, */
			));
		$dataProvider->sort->defaultOrder='originator_name ASC';

		$criteria = $dataProvider->getCriteria();
		Originator::addUserJoin( $criteria );

		if ( Yii::app()->request->getParam( 'ajax' ) )
		{
			$this->showOAListView( $dataProvider );
			Yii::app()->end();
		}
		else
		{
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
			));
		}
	}

	public function actionSearchJson()
	{
		$model = new Originator('search');
		$model->unsetAttributes();

		if (isset($_REQUEST['Originator']))
		{
			$model->attributes = $_REQUEST['Originator'];
		}

		$dataProvider = $model->search();
		$criteria = $dataProvider->getCriteria();
		Originator::addUserJoin( $criteria );

		print CJSON::encode( $dataProvider->getData() );
		exit;
	}

	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		$model=new Originator('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Originator']))
			$model->attributes=$_GET['Originator'];

		$dataProvider = $model->search();
		$criteria = $dataProvider->getCriteria();
		Originator::addUserJoin( $criteria );

		if ( Yii::app()->request->getParam( 'ajax' ) )
		{
			$this->showOAListView( $dataProvider );
			Yii::app()->end();
		}
		else
		{
			$this->render('search',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
			));
		}
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
				$this->_model=Originator::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
			elseif( ! Yii::app()->user->model()->isAuthorized( $this->_model ) )
				throw new CHttpException(401,'Not authorized.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='originator-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
