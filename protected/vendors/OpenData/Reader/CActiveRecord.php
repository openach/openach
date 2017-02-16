<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/* CActiveRecord
 * 
 * This is a placeholder class to decouple OpenData from the Yii framework.  If
 * used with the Yii framework, this class file will never be loaded.  If used
 * with the Yii framework, this class file provides the CActiveRecord parent
 * class for the ODDataSource to inherit.  Note that there is no implementation
 * here, only an empty abstract class.  You have a couple options when using
 * OpenData apart from Yii:
 *
 *   -  You may build functionality into the class definition below to support
 *      saving the records (e.g. a save() method, or insert() and update() )
 *   -  You may leave the definition empty and handle saving records by
 *      accessing public class attributes (e.g. the data fields themselves)
 *      and code functionality elsewhere to save the data.
 */
abstract class CActiveRecord
{
	public $attributes = array();
}



