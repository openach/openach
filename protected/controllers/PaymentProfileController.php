<?php

class PaymentProfileController extends OAController
{
	public $controllerLabel = 'Payment Profile';

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PaymentProfile;

		$this->performAjaxValidation($model);

		if(isset($_POST['PaymentProfile']))
		{
			$model->attributes=$_POST['PaymentProfile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->payment_profile_id));
		}

		$this->render('create',array(
			'model'=>$model,
			'parent_id'=>Yii::app()->request->getParam('parent_id'),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['PaymentProfile']))
		{
			$model->attributes=$_POST['PaymentProfile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->payment_profile_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if ( Yii::app()->request->getParam( 'originator_info_id' ) )
		{
			$originatorInfo = OriginatorInfo::model()->findByPk( Yii::app()->request->getParam( 'originator_info_id' ) );
			if ( ! $originatorInfo )
			{
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}
			elseif( ! Yii::app()->user->model()->isAuthorized( $originatorInfo ) )
			{
				throw new CHttpException(401,'Not authoried.');
			}
			else
			{
				$criteria = new CDbCriteria();
				$criteria->addCondition( ' payment_profile_originator_info_id = :originator_info_id' );
				$criteria->params = array( ':originator_info_id'=>$originatorInfo->originator_info_id );
				$dataProvider=new CActiveDataProvider( 'PaymentProfile', array( 'criteria'=>$criteria ) );
				$this->render('index',array(
					'dataProvider'=>$dataProvider,
					'originatorInfo'=>$originatorInfo,
				));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		$model=new PaymentProfile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentProfile']))
			$model->attributes=$_GET['PaymentProfile'];

		$dataProvider = $model->search();
		$criteria = $dataProvider->getCriteria();
		PaymentProfile::addUserJoin( $criteria );

		$this->render('search',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=PaymentProfile::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		elseif ( ! Yii::app()->user->model()->isAuthorized( $model ) )
			throw new CHttpException(401,'Not authorized.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
