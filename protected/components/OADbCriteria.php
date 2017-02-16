<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OADbCriteria extends CDbCriteria
{
	public function addColumnSearchCondition($columns,$columnOperator='AND',$operator='AND')
	{
		if ( Yii::app()->db->schema instanceof CPgsqlSchema )
		{
			$like = 'ILIKE';
		}
		elseif ( Yii::app()->db->schema instanceof CSqliteSchema )
		{
			$like = 'LIKE';
		}
		$escape = true;
		$params=array();
		foreach($columns as $name=>$value)
		{
			if($value===null)
				$params[]=$name.' IS NULL';
			else
			{
				$keyword = $value;
				if($keyword=='')
					continue;
				if($escape)
					$keyword='%'.strtr(strtolower($keyword),array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%';

				$params[]=$name." $like ".self::PARAM_PREFIX.self::$paramCount;
				$this->params[self::PARAM_PREFIX.self::$paramCount++]=$keyword;
			}
		}
		return $this->addCondition(implode(" $columnOperator ",$params), $operator);
	}

}

