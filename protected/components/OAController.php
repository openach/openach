<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

abstract class OAController extends Controller
{
	public $prevPagerDivider = '';
	public $currentPagerDivider = '';
	public $isDialog = false;
	public $isPropertyPage = true;
	public $controllerLabel = '';

	public $parentParams = array();

	public function init()
	{
		$this->stockMenus( array( 'list', 'create', 'edit', 'delete', 'search' ) );
		if ( ! $this->controllerLabel )
		{
			$this->controllerLabel = ucfirst( $this->id );
		}
		parent::init();
	}

	/**
	 * Renders a view with a layout.
	 *
	 * NOTE: This overridden method will gracefully degrade to renderPartial if ajax is set
	 * preventing a full site rendering when only simple ajax is requested.
	 *
	 * @param string $view name of the view to be rendered. See {@link getViewFile} for details
	 * about how the view script is resolved.
	 * @param array $data data to be extracted into PHP variables and made available to the view script
	 * @param boolean $return whether the rendering result should be returned instead of being displayed to end users.
	 * @return string the rendering result. Null if the rendering result is not required.
	 * @see renderPartial
	 * @see getLayoutFile
	 */
	public function render($view,$data=null,$return=false)
	{
		if ( Yii::app()->request->getParam( 'ajax' ) )
		{
			$this->renderPartial($view,$data,$return);
			Yii::app()->end();
		}
		else
		{
			return parent::render($view,$data,$return);
		}
	}

	/**
	 * Creates a relative URL for the specified action defined in this controller.
	 * @param string $route the URL route. This should be in the format of 'ControllerID/ActionID'.
	 * If the ControllerID is not present, the current controller ID will be prefixed to the route.
	 * If the route is empty, it is assumed to be the current action.
	 * If the controller belongs to a module, the {@link CWebModule::getId module ID}
	 * will be prefixed to the route. (If you do not want the module ID prefix, the route should start with a slash '/'.)
	 * @param array $params additional GET parameters (name=>value). Both the name and value will be URL-encoded.
	 * If the name is '#', the corresponding value will be treated as an anchor
	 * and will be appended at the end of the URL.
	 * @param string $ampersand the token separating name-value pairs in the URL.
	 * @return string the constructed URL
	 *
         * NOTE: Overrides parent class functionality to protect against creating 'self-links'
         * instead creating the links as #.  This prevents any odd behavior in jQuery Mobile
	 */
	public function createUrl($route,$params=array(),$ampersand='&')
	{
		$routeParts = explode( '/', $route );
		if ( count( $routeParts ) == 2 )
		{
			if ( $this->id == $routeParts[0] && $this->action->id == $routeParts[1] )
			{
				return '#';
			}
		}
		return parent::createUrl($route,$params,$ampersand);
	}


	public function stockMenus( $menuTypes, $modelId=null )
	{
		$this->menu = array();
		foreach ( $menuTypes as $menuType )
		{
			// Handles non-Key/Value pairs
			// because menus can be expressed as 'create' => array( 'param1' => 'value1' ), or simply as 'create'
			$fullMenuItem = $menuType;
			if ( is_array( $menuType ) && isset( $menuType[0] ) && count( $menuType ) > 1 )
			{
				$menuType = $fullMenuItem[0];
			}
			if ( ( $menuType == 'edit' || $menuType == 'delete' || $menuType == 'view' ) && ! $modelId )
			{
				continue;
			}
			switch ( $menuType )
			{
				case 'list':
					$this->menu[] = array('label'=>'List', 'url'=>array('index'), 'linkOptions'=>array('rel'=>'external','data-icon'=>'grid'));
					break;
				case 'create':
					$this->menu[] = array('label'=>'New ' . $this->controllerLabel, 'url'=>$fullMenuItem, 'linkOptions'=>array('data-icon'=>'plus','data-rel'=>'dialog','data-transition'=>'pop'));
					break;
				case 'edit':
					$this->menu[] = array('label'=>'Edit' . $this->controllerLabel, 'url'=>array('update', 'id'=>$modelId), 'linkOptions'=>array('data-icon'=>'gear','data-rel'=>'dialog','data-transition'=>'pop') );
					break;
				case 'delete':
					$this->menu[] = array('label'=>'Delete' . $this->controllerLabel, 'url'=>'#', 'linkOptions'=>array('rel'=>'external','submit'=>array('delete','id'=>$modelId),'confirm'=>'Are you sure you want to delete this item?', 'data-icon'=>'delete'));
					break;
				case 'view':
					$this->menu[] = array('label'=>'Details', 'url'=>array('view', 'id'=>$modelId), 'linkOptions'=>array('data-icon'=>'info'));
					break;
				case 'search':
					$this->menu[] = array('label'=>'Search', 'url'=>array('search'), 'linkOptions'=>array('rel'=>'external','data-icon'=>'search'));
					break;
				default:
					break;
			}
			
		}
	}

	public function showOAListView( $dataProvider, $sortableAttributes=array() )
	{
		if ( Yii::app()->request->getParam( 'ajax' ) )
		{
			$tagName = '';
			$itemsTagName = '';
			$template = '{items}{pager}';
		}
		else
		{
			$tagName = 'div';
			$itemsTagName = 'ul';
			$template = '{summary}{items}{pager}';
		}

		$listViewClass = $this->id . '-' . $this->action->id;

		$listView = $this->createWidget('application.widgets.OAListView', array(
			'summaryText'=>'',
			'enableSorting' => true,
			'sorterHeader' => '',
			'sorterFooter' => '',
			'sortableAttributes' => $sortableAttributes,
			'tagName' => $tagName,
			'dataProvider'=>$dataProvider,
			'template'=>$template,
			'itemView'=>'_view',
			'itemsTagName'=>$itemsTagName,
			'itemsHtmlOptions'=>array(
				'data-role'=>'listview',
				'data-filter'=>'true', 
				'data-inset'=>'true', 
				'data-split-icon'=>'gear', 
				'data-split-theme'=>'d',
				'data-count-theme'=>'d',
				'class'=>$listViewClass
			),
			'pagerCssClass'=>'navbar',
		));

		if ( ! Yii::app()->request->getParam( 'ajax' ) && count( $sortableAttributes ) > 0 )
		{
			$listView->renderSorter();
		}
		$listView->run();

	}

	public static function formatDate( $date )
	{
		$dateTime = new DateTime( $date );
		return $dateTime->format( 'M d, Y' );
	}

	public function getDateboxOptions()
	{
		// Set the datebox options
		// (see http://dev.jtsage.com/jQM-DateBox/demos/api/matrix.html for details)
		// and remember to keep it properly formatted JSON, with commas in the right places
		$options = '{'
			//. '"mode": "flipbox",'		// The iPhone-like datebox
			. '"useDialogForceTrue": true,'	// Force dialog mode
			. '"mode": "calbox",'		// Calendar mode
			. '"afterToday": true,'		// Only allow dates after today
			. '"blackDays": [0,6],'		// No weekends
			. '"blackDates": [' . implode(',', $this->getJSONSafeBlackoutDates() ) . ']'	// Set blackout dates
			. '}';
		return $options;
	}

	public function getBlackoutDates( $iatDates=false )
	{
		Yii::import( 'application.vendors.OpenData.Holiday.*' );
		$holidayCalc = new HolidayCalculator();
		$holidaysUS = $holidayCalc->getAllHolidays( 'US' );
		$holidaysCA = $holidayCalc->getAllHolidays( 'CA' );
		$holidayList = array();
		foreach ( $holidaysUS as $name => $date )
		{
			$holidayList[] = $date;
		}

		if ( $iatDates )
		{
			foreach ( $holidaysCA as $name => $date )
			{
				$holidayList[] = $date;
			}
		}
		return $holidayList;
	}
	public function getJSONSafeBlackoutDates()
	{
		$safeDates = array();

		$iatEnabled = Yii::app()->user->model()->hasIatRole();

		foreach ( $this->getBlackoutDates( $iatEnabled ) as $date )
		{
			$safeDates[] = '"' . $date . '"';
		}
		return $safeDates;
	}

	public function verifyOwnership( $model )
	{
		$user = Yii::app()->user->model();
		if ( $user->hasRole( 'administrator' ) )
		{
			return true;
		}
		else
		{
			return $model->verifyOwnership();
		}
	}

	public function userError( $errorTitle, $errorMessage )
	{
		$this->render( '//error/index', array( 'errorTitle' => $errorTitle, 'errorMessage' => $errorMessage ) );
	}

	public function getPopupMenuId()
	{
		return 'page-' . $this->id . '-' . $this->action->id . '-option-popup';
	}

	public function renderMenuAsPopup()
	{
		// For logged in users, always add a logout option
		if ( ! Yii::app()->user->isGuest )
		{
			$this->menu[] = array('label'=>'Edit Account', 'url'=>array('user/update', 'id'=>Yii::app()->user->model()->user_id ), 'linkOptions'=>array('data-rel'=>'dialog'));
			$this->menu[] = array('label'=>'Logout', 'url'=>array('site/logout'), 'linkOptions'=>array('rel'=>'external','data-icon'=>'back'));
		}

		echo '
		<div data-role="popup" id="' . $this->getPopupMenuId() . '" data-theme="a">
			<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="a">
				<li data-role="divider" data-theme="a">Actions</li>
		';

		foreach ( $this->menu as $item )
		{
			$this->renderPopupMenuItem( $item );
		}

		echo '
			</ul>
		</div>
		';
	}

	protected function renderPopupMenuItem( $item )
	{
		if ( ! $item || ! is_array( $item ) || ! isset( $item['linkOptions'] ) )
		{
			return;
		}
		$options = $item['linkOptions'];
		if ( isset( $options['data-icon'] ) )
		{
			unset( $options['data-icon'] );
		}
		$params = array();
echo '<!-- '; var_dump( $item['url'] ); echo ' -->' . PHP_EOL;
		if ( is_array( $item['url'] ) )
		{
			$uri = $item['url'][0];
			if ( count( $item['url'] ) > 1 )
			{
				array_shift( $item['url'] );
				$params = $item['url'];
			}
		}
		else
		{
			$uri = $item['url'];
		}
		$url = $this->createUrl( $uri, $params );
		$label = $item['label'];
		echo '
				<li>' . CHtml::link( $label, $url, $options ) . '</li>
 
		';
	}

}
