<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAHtml extends CHtml
{
	public static function searchField($name,$value='',$htmlOptions=array())
	{
		self::clientChange('change',$htmlOptions);
		return self::inputField('search',$name,$value,$htmlOptions);
	}
	/**
	 * Generates a JQuery Mobile range field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeRangeField($model,$attribute,$htmlOptions=array())
	{
		$htmlOptions['data-highlight'] = 'true';
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('range',$model,$attribute,$htmlOptions);
	}

	/**
	 * Generates an HTML5 number field using JQM Keypad plugin for entry
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeCurrencyField($model,$attribute,$htmlOptions=array())
	{
		//$htmlOptions['step'] = '0.01';
		$htmlOptions['data-role'] = 'keypad';
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('number',$model,$attribute,$htmlOptions);
	}


	/**
	 * Generates a JQuery Mobile date field input for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated input field
	 * @see clientChange
	 * @see activeInputField
	 */
	public static function activeDateField($model,$attribute,$htmlOptions=array())
	{
		if ( ! isset( $htmlOptions['data-role'] ) )
		{
			$htmlOptions['data-role'] = 'datebox';
		}
		if ( ! isset( $htmlOptions['data-options'] ) ) 
		{
			$htmlOptions['data-options'] = Yii::app()->controller->getDateboxOptions(); //'{"mode": "flipbox"}';
			$htmlOptions['encode'] = false;
		}
		
		self::resolveNameID($model,$attribute,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		return self::activeInputField('date',$model,$attribute,$htmlOptions);
	}


	/**
	 * Generates an input HTML tag for a model attribute.
	 * This method generates an input HTML tag based on the given data model and attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * This enables highlighting the incorrect input.
	 * @param string $type the input type (e.g. 'text', 'radio')
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes for the HTML tag
	 * @return string the generated input tag
	 */
	protected static function activeInputField($type,$model,$attribute,$htmlOptions)
	{
		$htmlOptions['type']=$type;

		if($type==='text' || $type==='password' || $type ==='range')
		{
			if(!isset($htmlOptions['maxlength']))
			{
				foreach($model->getValidators($attribute) as $validator)
				{
					if($validator instanceof CStringValidator && $validator->max!==null)
					{
						$htmlOptions['maxlength']=$validator->max;
						break;
					}
					if($validator instanceof CNumberValidator)
					{
						$htmlOptions['max'] = $validator->max;
						$htmlOptions['min'] = $validator->min;
					}
				}
			}
			else if($htmlOptions['maxlength']===false)
				unset($htmlOptions['maxlength']);
		}

		if($type==='file')
			unset($htmlOptions['value']);
		else if(!isset($htmlOptions['value']))
			$htmlOptions['value']=self::resolveValue($model,$attribute);
		if($model->hasErrors($attribute))
			self::addErrorCss($htmlOptions);
		return self::tag('input',$htmlOptions);
	}

	public static function renderAttributes($htmlOptions)
	{
		static $specialAttributes=array(
			'checked'=>1,
			'declare'=>1,
			'defer'=>1,
			'disabled'=>1,
			'ismap'=>1,
			'multiple'=>1,
			'nohref'=>1,
			'noresize'=>1,
			'readonly'=>1,
			'selected'=>1,
		);

		static $singleQuotedAttributes=array(
			'data-options'=>1,
		);

		if($htmlOptions===array())
			return '';

		$html='';
		if(isset($htmlOptions['encode']))
		{
			$raw=!$htmlOptions['encode'];
			unset($htmlOptions['encode']);
		}
		else
			$raw=false;

		if($raw)
		{
			foreach($htmlOptions as $name=>$value)
			{
				if(isset($specialAttributes[$name]))
				{
					if($value)
						$html .= ' ' . $name . '="' . $name . '"';
				}
				else if($value!==null)
				{
					if(isset($singleQuotedAttributes[$name]))
						$html .= ' ' . $name . "='" . $value . "'";
					else
						$html .= ' ' . $name . '="' . $value . '"';
				}
			}
		}
		else
		{
			foreach($htmlOptions as $name=>$value)
			{
				if(isset($specialAttributes[$name]))
				{
					if($value)
						$html .= ' ' . $name . '="' . $name . '"';
				}
				else if($value!==null)
				{
					if(isset($singleQuotedAttributes[$name]))
						$html .= ' ' . $name . "='" . self::encode($value) . "'";
					else
						$html .= ' ' . $name . '="' . self::encode($value) . '"';
				}
			}
		}
		return $html;
	}

	/**
	 * Generates an HTML element.
	 * @param string $tag the tag name
	 * @param array $htmlOptions the element attributes. The values will be HTML-encoded using {@link encode()}.
	 * If an 'encode' attribute is given and its value is false,
	 * the rest of the attribute values will NOT be HTML-encoded.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * @param mixed $content the content to be enclosed between open and close element tags. It will not be HTML-encoded.
	 * If false, it means there is no body content.
	 * @param boolean $closeTag whether to generate the close tag.
	 * @return string the generated HTML element tag
	 */
	public static function tag($tag,$htmlOptions=array(),$content=false,$closeTag=true)
	{
		$html='<' . $tag . self::renderAttributes($htmlOptions);
		if($content===false)
			return $closeTag ? $html.' />' : $html.'>';
		else
			return $closeTag ? $html.'>'.$content.'</'.$tag.'>' : $html.'>'.$content;
	}

	/**
	 * Generates a drop down list for a model attribute.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data data for generating the list options (value=>display)
	 * You may use {@link listData} to generate this data.
	 * Please refer to {@link listOptions} on how this data is used to generate the list options.
	 * Note, the values and labels will be automatically HTML-encoded by this method.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are recognized. See {@link clientChange} and {@link tag} for more details.
	 * In addition, the following options are also supported:
	 * <ul>
	 * <li>encode: boolean, specifies whether to encode the values. Defaults to true.</li>
	 * <li>prompt: string, specifies the prompt text shown as the first list option. Its value is empty.  Note, the prompt text will NOT be HTML-encoded.</li>
	 * <li>empty: string, specifies the text corresponding to empty selection. Its value is empty.
	 * The 'empty' option can also be an array of value-label pairs.
	 * Each pair will be used to render a list option at the beginning. Note, the text label will NOT be HTML-encoded.</li>
	 * <li>options: array, specifies additional attributes for each OPTION tag.
	 *     The array keys must be the option values, and the array values are the extra
	 *     OPTION tag attributes in the name-value pairs. For example,
	 * <pre>
	 *     array(
	 *	 'value1'=>array('disabled'=>true, 'label'=>'value 1'),
	 *	 'value2'=>array('label'=>'value 2'),
	 *     );
	 * </pre>
	 * </li>
	 * </ul>
	 * @return string the generated drop down list
	 * @see clientChange
	 * @see listData
	 */
	public static function activeDropDownList($model,$attribute,$data,$htmlOptions=array())
	{
		self::resolveNameID($model,$attribute,$htmlOptions);
		$selection=self::resolveValue($model,$attribute);
		$options="\n".self::listOptions($selection,$data,$htmlOptions);
		self::clientChange('change',$htmlOptions);
		if($model->hasErrors($attribute))
			self::addErrorCss($htmlOptions);
		if(isset($htmlOptions['multiple']))
		{
			if(substr($htmlOptions['name'],-2)!=='[]')
				$htmlOptions['name'].='[]';
		}
		return self::tag('select',$htmlOptions,$options);
	}

	/**
	 * Generates a list box for a model attribute.
	 * The model attribute value is used as the selection.
	 * If the attribute has input error, the input field's CSS class will
	 * be appended with {@link errorCss}.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data data for generating the list options (value=>display)
	 * You may use {@link listData} to generate this data.
	 * Please refer to {@link listOptions} on how this data is used to generate the list options.
	 * Note, the values and labels will be automatically HTML-encoded by this method.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are recognized. See {@link clientChange} and {@link tag} for more details.
	 * In addition, the following options are also supported:
	 * <ul>
	 * <li>encode: boolean, specifies whether to encode the values. Defaults to true.</li>
	 * <li>prompt: string, specifies the prompt text shown as the first list option. Its value is empty. Note, the prompt text will NOT be HTML-encoded.</li>
	 * <li>empty: string, specifies the text corresponding to empty selection. Its value is empty.
	 * The 'empty' option can also be an array of value-label pairs.
	 * Each pair will be used to render a list option at the beginning. Note, the text label will NOT be HTML-encoded.</li>
	 * <li>options: array, specifies additional attributes for each OPTION tag.
	 *     The array keys must be the option values, and the array values are the extra
	 *     OPTION tag attributes in the name-value pairs. For example,
	 * <pre>
	 *     array(
	 *	 'value1'=>array('disabled'=>true, 'label'=>'value 1'),
	 *	 'value2'=>array('label'=>'value 2'),
	 *     );
	 * </pre>
	 * </li>
	 * </ul>
	 * @return string the generated list box
	 * @see clientChange
	 * @see listData
	 */
	public static function activeListBox($model,$attribute,$data,$htmlOptions=array())
	{
		if(!isset($htmlOptions['size']))
			$htmlOptions['size']=4;

		return self::activeDropDownList($model,$attribute,$data,$htmlOptions);
	}

	/**
	 * Generates a label tag for a model attribute.
	 * This is an enhanced version of {@link activeLabel}. It will render additional
	 * CSS class and mark when the attribute is required.
	 * In particular, it calls {@link CModel::isAttributeRequired} to determine
	 * if the attribute is required.
	 * If so, it will add a CSS class {@link CHtml::requiredCss} to the label,
	 * and decorate the label with {@link CHtml::beforeRequiredLabel} and
	 * {@link CHtml::afterRequiredLabel}.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes.
	 * @return string the generated label tag
	 */
	public static function activeLabelEx($model,$attribute,$htmlOptions=array())
	{
		$realAttribute=$attribute;
		self::resolveName($model,$attribute); // strip off square brackets if any
		$htmlOptions['required']=$model->isAttributeRequired($attribute);
		return self::activeLabel($model,$realAttribute,$htmlOptions);
	}

	/**
	 * Generates a submit button.
	 * @param string $label the button label
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated button tag
	 * @see clientChange
	 */
	public static function submitButton($label='submit',$htmlOptions=array())
	{
		$htmlOptions['type']='submit';
		if ( !isset($htmlOptions['data-mini']) )
		{
			$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		}
		return self::button($label,$htmlOptions);
	}

	/**
	 * Generates a hyperlink tag.
	 * @param string $text link body. It will NOT be HTML-encoded. Therefore you can pass in HTML code such as an image tag.
	 * @param mixed $url a URL or an action route that can be used to create a URL.
	 * See {@link normalizeUrl} for more details about how to specify this parameter.
	 * @param array $htmlOptions additional HTML attributes. Besides normal HTML attributes, a few special
	 * attributes are also recognized (see {@link clientChange} and {@link tag} for more details.)
	 * @return string the generated hyperlink
	 * @see normalizeUrl
	 * @see clientChange
	 */
	public static function link($text,$url='#',$htmlOptions=array())
	{
		$htmlOptions['type']='submit';
		if ( !isset($htmlOptions['data-mini']) )
		{
			$htmlOptions['data-mini'] = Yii::app()->params['Design']['Forms']['JQM']['data-mini'] ? 'true' : 'false';
		}
		if($url!=='')
			$htmlOptions['href']=self::normalizeUrl($url);
		self::clientChange('click',$htmlOptions);
		return self::tag('a',$htmlOptions,$text);
	}

}
