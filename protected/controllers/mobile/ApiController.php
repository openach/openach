<?php

class ApiController extends OAController
{
	protected $paymentProfile;

	public function init()
	{
		parent::init();
		Yii::app()->setComponents(array(
				'errorHandler'=>array(
					'errorAction'=>'api/error',
				)
			));
		Yii::app()->attachEventHandler('onError',array($this,'handleError'));
		Yii::app()->attachEventHandler('onException',array($this,'handleError'));
	}

	public function handleError( CEvent $event )
	{
		if ($event instanceof CExceptionEvent)
		{
			echo json_encode( $this->formatError( $event->exception->getMessage() ) );
			Yii::app()->end();
		}
		elseif($event instanceof CErrorEvent)
		{
			echo json_encode( $this->formatError( $event->message ) );
			Yii::app()->end();
		}
		$event->handled = true;
	}

	public function actions()
	{

		return array(
			// Error Handler
			'error' => array(
				'class' => 'application.controllers.actions.ApiError',
			),

			// UserApi Actions
			'connect' => array(
				'class' => 'application.controllers.mobile.actions.paymentProfile.Connect',
			),
			'disconnect' => array(
				'class' => 'application.controllers.mobile.actions.paymentProfile.Disconnect',
			),
			'test' => array(
				'class' => 'application.controllers.mobile.actions.paymentProfile.Test',
			),

			// Payment Profile Actions
			'getPaymentProfile' => array(
				'class' => 'application.controllers.mobile.actions.paymentProfile.Get',
			),
			'savePaymentProfile' => array(
				'class' => 'application.controllers.mobile.actions.paymentProfile.Save',
			),

			// External Account Actions
			'getExternalAccount' => array(
				'class' => 'application.controllers.mobile.actions.externalAccount.Get',
			),
			'getExternalAccounts' => array(
				'class' => 'application.controllers.mobile.actions.externalAccount.GetAll',
			),
			'saveExternalAccount' => array(
				'class' => 'application.controllers.mobile.actions.externalAccount.Save',
			),
			'getExternalAccountsSummary' => array(
				'class' => 'application.controllers.mobile.actions.externalAccount.GetAllSummary',
			),

			// Payment Schedule Actions
			'getPaymentSchedule' => array(
				'class' => 'application.controllers.mobile.actions.paymentSchedule.Get',
			),
			'getPaymentSchedules' => array(
				'class' => 'application.controllers.mobile.actions.paymentSchedule.GetAll',
			),
			'getPaymentSchedulesSummary' => array(
				'class' => 'application.controllers.mobile.actions.paymentSchedule.GetAllSummary',
			),

			'savePaymentSchedule' => array(
				'class' => 'application.controllers.mobile.actions.paymentSchedule.Save',
			),

			// Payment Type Actions
			'getPaymentType' => array(
				'class' => 'application.controllers.mobile.actions.paymentType.Get',
			),
			'getPaymentTypes' => array(
				'class' => 'application.controllers.mobile.actions.paymentType.GetAll',
			),

			// Transaction Actions
			'getTransactions' => array(
				'class' => 'application.controllers.mobile.actions.transactions.GetAll',
			),
			'getTransactionsSummary' => array(
				'class' => 'application.controllers.mobile.actions.transactions.GetAllSummary',
			),
			'getTransaction' => array(
				'class' => 'application.controllers.mobile.actions.transactions.Get',
			),
		);
	}

	public function getActionParams() { return array_merge($_GET, $_POST); }

	public function actionIndex()
	{
		$this->render('index');
	}

	protected function formatError( $errorMsg )
	{
		return $this->formatResult( false, $errorMsg, null );
	}

	protected function formatSuccess( $data )
	{
		return $this->formatResult( true, null, $data );
	}

	protected function formatResult( $success, $errorMsg, $data )
	{
		$result = new stdClass();
		$result->success = $success;
		if (null !== $errorMsg) $result->error = $errorMsg;
		if (null !== $data) $result->data = $data;
		return $result;
	}

}
