<?php

class ExternalAccountController extends OAController
{
	public $controllerLabel = 'Bank Account';

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
		$model=new ExternalAccount;

		$this->performAjaxValidation($model);

		if ( $originator_info_id = Yii::app()->request->getParam( 'originator_info_id' ) )
		{
			$user = Yii::app()->user->model();
			if ( $user->hasRole( 'administrator' ) )
			{
				if ( ! OriginatorInfo::model()->findByPk( $originator_info_id ) )
				{
					throw new CHttpException(404,'The requested page does not exist.');
				}
			}
			elseif ( ! $model->verifyOriginatorInfoOwnership( $originator_info_id ) )
			{
				throw new CHttpException(404,'The requested page does not exist.');
			}
			$model->external_account_allow_originator_payments = true;
			$model->external_account_originator_info_id = $originator_info_id;
		}
		elseif ( $payment_profile_id = Yii::app()->request->getParam( 'parent_id' ) )
		{
			if ( ! $paymentProfile = PaymentProfile::model()->findByPk( $payment_profile_id ) )
			{
				throw new CHttpException(404,'The requested page does not exist.');
			}
			else
			{
				$model->external_account_payment_profile_id = $paymentProfile->payment_profile_id;
			}
		}
		if(isset($_POST['ExternalAccount']))
		{
			$model->attributes=$_POST['ExternalAccount'];
			if ( $model->save() )
			{
				if ( $model->external_account_originator_info_id )
				{
					$this->redirect(array('//originatorInfo/view','id'=>$model->external_account_originator_info_id));
				}
				else
				{
					$this->redirect(array('//paymentProfile/view','id'=>$model->external_account_payment_profile_id));
				}
			}
		}

		$this->render('create', array( 'model' => $model ) );
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

		if(isset($_POST['ExternalAccount']))
		{
			$model->attributes=$_POST['ExternalAccount'];
			if( $model->save() )
			{
				if ( $model->external_account_originator_info_id )
				{
					$this->redirect(array('//originatorInfo/view','id'=>$model->external_account_originator_info_id));
				}
				else
				{
					$this->redirect(array('//paymentProfile/view','id'=>$model->external_account_payment_profile_id));
				}
			}
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
		$dataProvider=new CActiveDataProvider('ExternalAccount');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		$model=new ExternalAccount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExternalAccount']))
			$model->attributes=$_GET['ExternalAccount'];

		$dataProvider = $model->search();
		$criteria = $dataProvider->getCriteria();
		ExternalAccount::addUserJoin( $criteria );

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
		$model=ExternalAccount::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if( ! Yii::app()->user->model()->isAuthorized( $model ) )
			throw new CHttpException(401,'Not authorized.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='external-account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
