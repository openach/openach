<?php

class AchBatchController extends OAController
{
	public $controllerLabel = 'ACH Batch';

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model = $this->loadModel( $id );
		$criteria = new CDbCriteria();
		$criteria->join .= ' INNER JOIN odfi_branch ON ( odfi_branch_id = ach_entry_odfi_branch_id AND ach_entry_ach_batch_id = :ach_entry_ach_batch_id ) ';
		$criteria->params = array( ':ach_entry_ach_batch_id' => $model->ach_batch_id );
		OdfiBranch::addUserJoin( $criteria );

		$achEntryProvider = AchEntry::model()->findAll( $criteria );

		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'achEntryProvider'=> $achEntryProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
/*
	public function actionCreate()
	{
		$model=new AchBatch;

		$this->performAjaxValidation($model);

		if(isset($_POST['AchBatch']))
		{
			$model->attributes=$_POST['AchBatch'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ach_batch_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
*/
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
/*
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['AchBatch']))
		{
			$model->attributes=$_POST['AchBatch'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ach_batch_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
/*
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
*/

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
			elseif ( ! Yii::app()->user->model()->isAuthorized( $originatorInfo ) )
			{
				throw new CHttpException(401,'Not authorized.');
			}
			else
			{
				$criteria = new CDbCriteria();
				$criteria->addCondition( 'ach_batch_originator_info_id = :originator_info_id' );
				$criteria->params = array( ':originator_info_id'=>$originatorInfo->originator_info_id );
				$dataProvider=new CActiveDataProvider( 'AchBatch', array( 'criteria'=>$criteria ) );
				$this->render('index',array(
					'dataProvider'=>$dataProvider,
					'originatorInfo'=>$originatorInfo,
					'originator'=>$originatorInfo->originator,
				));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
/*
	public function actionAdmin()
	{
		$model=new AchBatch('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AchBatch']))
			$model->attributes=$_GET['AchBatch'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AchBatch::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		elseif( ! Yii::app()->user->model()->isAuthorized( $model ) )
			throw new CHttpException(401,'Not authorized.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ach-batch-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
