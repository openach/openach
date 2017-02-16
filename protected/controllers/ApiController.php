<?php

class ApiController extends OAController
{
	protected $userApi;

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
				'class' => 'application.controllers.actions.userApi.Connect',
			),
			'disconnect' => array(
				'class' => 'application.controllers.actions.userApi.Disconnect',
			),

			// Payment Profile Actions
			'getPaymentProfile' => array(
				'class' => 'application.controllers.actions.paymentProfile.GetById',
			),
			'getPaymentProfileByExtId' => array(
				'class' => 'application.controllers.actions.paymentProfile.GetByExtId',
			),
			'savePaymentProfile' => array(
				'class' => 'application.controllers.actions.paymentProfile.Save',
			),
			'savePaymentProfileComplete' => array(
				'class' => 'application.controllers.actions.paymentProfile.SaveComplete',
			),

			// External Account Actions
			'getExternalAccount' => array(
				'class' => 'application.controllers.actions.externalAccount.GetById',
			),
			'getExternalAccounts' => array(
				'class' => 'application.controllers.actions.externalAccount.GetAllByPaymentProfileId',
			),
			'saveExternalAccount' => array(
				'class' => 'application.controllers.actions.externalAccount.Save',
			),
			'getExternalAccountsSummary' => array(
				'class' => 'application.controllers.actions.externalAccount.GetAllSummary',
			),

			// Payment Schedule Actions
			'getPaymentSchedule' => array(
				'class' => 'application.controllers.actions.paymentSchedule.GetById',
			),
			'getPaymentSchedules' => array(
				'class' => 'application.controllers.actions.paymentSchedule.GetAllByPaymentProfileId',
			),
			'getPaymentSchedulesSummary' => array(
				'class' => 'application.controllers.actions.paymentSchedule.GetAllSummary',
			),

			'savePaymentSchedule' => array(
				'class' => 'application.controllers.actions.paymentSchedule.Save',
			),

			// Payment Type Actions
			'getPaymentType' => array(
				'class' => 'application.controllers.actions.paymentType.GetById',
			),
			'getPaymentTypes' => array(
				'class' => 'application.controllers.actions.paymentType.GetAll',
			),
		);
	}

	public function getActionParams() { return array_merge($_GET, $_POST); }

	public function actionChangePaymentProfileSatus()
	{
		$this->render('changePaymentProfileSatus');
	}

	public function actionChangePaymentScheduleStatus()
	{
		$this->render('changePaymentScheduleStatus');
	}

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

	protected function assertAuth()
	{
		$this->userApi = UserApi::model()->findByAttributes( array( 'user_api_user_id' => Yii::app()->getSession()->get('user_api_user_id') ) );
		if ( ! $this->userApi )
		{
			echo json_encode( $this->formatError( 'Not authenticated with token/key. Please connect first.' ) );
			Yii::app()->end();
		}
	}

	protected function assertValidPaymentType( $payment_type_id )
	{
		foreach ( $this->userApi->originator_info->payment_types as $payment_type )
		{
			if ( $payment_type->payment_type_id == $payment_type_id && $payment_type->payment_type_status = 'enabled' )
			{
				return true;
			}
		}
		echo json_encode( $this->formatError( 'The specified payment type is either invalid or disabled.' ) );
		Yii::app()->end();
	}

	protected function loadExternalAccountSafe( $external_account_id, $payment_profile_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':payment_profile_id' => $payment_profile_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return ExternalAccount::model()->find( $criteria );
	}

	protected function loadExternalAccount( $external_account_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return ExternalAccount::model()->find( $criteria );
	}

	protected function loadPaymentScheduleSafe( $payment_schedule_id, $external_account_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'payment_schedule_id = :payment_schedule_id' );
		$criteria->addCondition( 'external_account_id = :external_account_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->join .= 'LEFT JOIN external_account ON external_account_id = payment_schedule_external_account_id ';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':payment_schedule_id' => $payment_schedule_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return PaymentSchedule::model()->find( $criteria );
	}

	protected function loadPaymentSchedule( $payment_schedule_id )
	{
		$criteria = new CDbCriteria();
		$criteria->together = true;
		$criteria->addCondition( 'payment_schedule_id = :payment_schedule_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->join = 'LEFT JOIN payment_profile ON payment_profile_id = external_account_payment_profile_id ';
		$criteria->join .= 'LEFT JOIN external_account ON external_account_id = payment_schedule_external_account_id ';
		$criteria->params = array(
				':external_account_id' => $external_account_id,
				':payment_schedule_id' => $payment_schedule_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);

		return PaymentSchedule::model()->find( $criteria );
	}

	protected function loadPaymentProfile( $payment_profile_id )
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition( 'payment_profile_id = :payment_profile_id' );
		$criteria->addCondition( 'payment_profile_originator_info_id = :originator_info_id' );
		$criteria->params = array(
				':payment_profile_id' => $payment_profile_id,
				':originator_info_id' => $this->userApi->user_api_originator_info_id,
			);
		return PaymentProfile::model()->find( $criteria );
	}

}
