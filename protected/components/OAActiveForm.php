<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAActiveForm extends CActiveForm
{
	// Normally this defaults to false, but since we typically use ajax for validation, we will enable it by default
	public $enableAjaxValidation = true;

	public function run()
	{
		// If no client options were provided, assume these defaults
		if ( ! $this->clientOptions )
		{
			$this->clientOptions = array(
				'validateOnSubmit'=>true,
				'errorCssClass'=>'error',
				'successCssClass'=>'success',
			);
		}
		parent::run();
	}

	public function rangeField( $model, $attribute, $htmlOptions=array() )
	{
		$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		return OAHtml::activeRangeField( $model, $attribute, $htmlOptions );
	}

	public function dateField( $model, $attribute, $htmlOptions=array() )
	{
		$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		return OAHtml::activeDateField( $model, $attribute, $htmlOptions );
	}

	public function currencyField( $model, $attribute, $htmlOptions=array() )
	{
		$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		return OAHtml::activeCurrencyField( $model, $attribute, $htmlOptions );
	}

	public function listBox($model,$attribute,$data,$htmlOptions=array())
	{
		$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		return OAHtml::activeListBox($model,$attribute,$data,$htmlOptions);
	}

	public function textField($model,$attribute,$htmlOptions=array())
	{
		$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		return OAHtml::activeTextField($model,$attribute,$htmlOptions);
	}

	public function textArea($model,$attribute,$htmlOptions=array())
	{
		$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		return OAHtml::activeTextArea($model,$attribute,$htmlOptions);
	}

	public function labelEx($model,$attribute,$htmlOptions=array())
	{
		return OAHtml::activeLabelEx($model,$attribute,$htmlOptions);
	}
}
