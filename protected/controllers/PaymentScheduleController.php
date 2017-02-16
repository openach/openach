<?php

class PaymentScheduleController extends OAController
{
	public $controllerLabel = 'Payment Schedule';

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
				'actions'=>array('index','view','create','update','delete','search','searchjson'),
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

                $paymentProfile = PaymentProfile::model()->findByPk( Yii::app()->request->getParam('parent_id') );
                if ( ! $paymentProfile )
                {
                        $this->userError( 'No Payment Profile', 'The payment profile specified does not exist.' );
			return;
                }
		elseif ( ! $paymentProfile->external_accounts )
		{
			$this->userError( 'No Bank Accounts', 'Before adding a schedule, you must add a bank account.' );
			return;
		}
		elseif ( ! $paymentProfile->originator_info->payment_types )
		{
			$this->userError( 'No Payment Types', 'Before adding a schedule, you must define payment types.' );
		}

		$model=new PaymentSchedule;

		$this->performAjaxValidation($model);

		if(isset($_POST['PaymentSchedule']))
		{
			$model->attributes=$_POST['PaymentSchedule'];
			if($model->save())
			{
				$model->refresh();
				$this->redirect(array('//paymentProfile/view','id'=>$model->external_account->external_account_payment_profile_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'paymentProfile'=>$paymentProfile,
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

		if(isset($_POST['PaymentSchedule']))
		{
			$model->attributes=$_POST['PaymentSchedule'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->payment_schedule_id));
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
		$dataProvider=new CActiveDataProvider('PaymentSchedule');
		$criteria = $dataProvider->getCriteria();
		PaymentSchedule::addUserJoin( $criteria );
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		$model=new PaymentSchedule('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaymentSchedule']))
			$model->attributes=$_GET['PaymentSchedule'];

		$dataProvider = $model->search();
		$criteria = $dataProvider->getCriteria();
		PaymentSchedule::addUserJoin( $criteria );

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
		$model=PaymentSchedule::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payment-schedule-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
