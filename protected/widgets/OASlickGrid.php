<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/* Note that this class extends the SlickGrid extension to provide additional features
 * and integration with Pathway's PRActiveRecords, along with a specific configuration
 */

Yii::import( 'ext.slickgrid.CSlickGrid' );

class OASlickGrid extends CSlickGrid
{
	public $htmlOptions = array( 'style'=>'width:600px;height:300px;' );

	public $slickgridOptions = array(
			'enableCellNavigation'=>false,
			'enableColumnReorder'=>true,
			'forceFitColumns'=>true,
		);

	public $slickgridPlugins = array(
			'rowselectionmodel'=>'grid.setSelectionModel(new Slick.RowSelectionModel());',
		);

	public $defaultColumnOptions = array( );

	public $enableAjax = false;

	public $loadJQuery = false;

}

