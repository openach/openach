<?php

	$inMobileApp = (isset(Yii::app()->request->cookies['inMobileApp'])) ? Yii::app()->request->cookies['inMobileApp']->value : false;

	$dialogActions = array ( 'update', 'create' );
	if ( isset( Yii::app()->controller->isDialog ) && Yii::app()->controller->isDialog )
	{
		$renderForDialog = true;
	}
	elseif ( in_array( Yii::app()->controller->action->id, $dialogActions )  )
	{
		$renderForDialog = true;
	}
	else
	{
		$renderForDialog = false;
	}

	$renderHeader = true;

	if ( $this->isPropertyPage && $this->isDialog )
	{
		$renderHeader = false;
	}

	if ( $inMobileApp && ! $renderForDialog )
	{
		$renderHeader = false;
	}

	if ( Yii::app()->controller->action->id == 'mobile' )
	{
		$renderHeader = false;
	}

	$controllerIdClass = str_replace('/','-',$this->id);
	$actionIdClass = str_replace('/','-',$this->action->id);

	$jqmVersion = '1.2.0';
	$jqmVersion = '1.4.5';

	$jquiVersion = '1.8.17';
	$jquiVersion = '1.11.4';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php
	$clientScript = Yii::app()->clientScript;

	$clientScript->registerMetaTag( 'text/html; charset=utf-8', 'Content-Type' );
	$clientScript->registerMetaTag( 'en', 'language' );
	$clientScript->registerMetaTag( 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no', 'viewport' );

	$clientScript->registerLinkTag( 'shortcut icon', 'image/png', '/favicon.png' );

	// Use Yii CClientScript to load the CSS files
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/form.css' );
	$clientScript->registerCssFile( 'http://code.jquery.com/ui/' . $jquiVersion . '/themes/base/jquery-ui.css' );
	// $clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/jquery.mobile-1.0.1.min.css' );
	$clientScript->registerCssFile( 'http://code.jquery.com/mobile/' . $jqmVersion . '/jquery.mobile-' . $jqmVersion . '.min.css' );
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/jquery.mobile.datebox-1.0.0.min.css' );
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/jquery.mobile.simpledialog.min.css' );
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/jquery.ui.keypad.css' );
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/main-mobile.css' );
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/detailview.css' );
	$clientScript->registerCssFile( Yii::app()->request->baseUrl . '/js/jquery.mobile-fixes.css' );
	
	// Use Yii CClientScript to load the javascript files so JQuery doesn't double load

	$clientScript = Yii::app()->clientScript;
	//$clientScript->registerScriptFile('http://code.jquery.com/jquery-1.6.3.min.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('http://code.jquery.com/ui/' . $jquiVersion . '/jquery-ui.min.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('/js/jquery.pre-mobile.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('/js/jquery.appear-1.1.1.min.js', CClientScript::POS_HEAD);
	//$clientScript->registerScriptFile('/js/jquery.mobile-1.0.1.min.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('http://code.jquery.com/mobile/' . $jqmVersion . '/jquery.mobile-' . $jqmVersion . '.min.js', CClientScript::POS_HEAD);

	// Load the core active form validation and list view libraries
	$clientScript->registerCoreScript('yiiactiveform');
	$listViewBaseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/listview';
	$clientScript->registerScriptFile($listViewBaseUrl.'/jquery.yiilistview.js',CClientScript::POS_END);
		

	// For the keypad
	$clientScript->registerScriptFile('/js/jquery.jkey-1.2.js', CClientScript::POS_HEAD);

	// For the datebox
	$clientScript->registerScriptFile('/js/jquery.mousewheel.min.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('/js/jquery.mobile.datebox-1.0.0.min.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('/js/jquery.mobile.datebox.i8n.en.js', CClientScript::POS_HEAD);
	$clientScript->registerScriptFile('/js/jquery.mobile.simpledialog.min.js', CClientScript::POS_HEAD);

	// For the keypad
	$clientScript->registerScriptFile('/js/jquery.ui.keypad.js', CClientScript::POS_HEAD);

	// Hide When Plugin
	$clientScript->registerScriptFile('/js/jquery.ui.hidewhen.js', CClientScript::POS_HEAD);

	// Form-specific code
	$clientScript->registerScriptFile('/js/openach-form.js', CClientScript::POS_HEAD);

?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body id="page-body">

<div data-role="page" data-add-back-btn="true" id="page-<?php echo $this->id . '-' . $this->action->id; ?>">
<?php if ( $renderHeader ): ?>
	<div data-role="header" data-theme="b"<?= ( ! $renderForDialog ) ? ' class="cloud-header"' /* ' data-position="fixed"'*/ : ''; ?> >
<?php if ( ! $renderForDialog ): ?>
		<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
<?php if ( ! Yii::app()->user->isGuest ): ?>
                <a class="header-image" href="/" alt="Home"><img src="/images/icons/large/home.png" /></a>
                <a class="header-image" href="/search/" alt="Administration"><img src="/images/icons/large/search.png" /></a>
<?php endif; ?>
		<a class="header-image back-button" href="#"><img src="/images/icons/back.png" /></a>
<?php else: ?>
		<h1><?php echo ucfirst( Yii::app()->controller->action->id ) . ' ' . $this->controllerLabel; ?></h1>
<?php endif; ?>
	</div>
<?php endif; // render header?>
<?php if ( ! $renderForDialog && false ):
		$this->beginWidget('zii.widgets.CPortlet', array(
			'htmlOptions'=>array('data-role'=>'navbar','data-position'=>'fixed'),
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations','data-theme'=>'a'),
		));
		$this->endWidget();
endif; ?>

	<div data-role="content" data-theme="c"<?= ( ! $renderForDialog ) ? ' class="cloud-content ' . $controllerIdClass . ' ' . $controllerIdClass . '_' . $actionIdClass . '"' /* ' data-position="fixed"'*/ : ''; ?>>
		<?php echo $content; ?>
<?=$clientScript->renderPageCreate( $this ); ?>

	</div>
<?php if ( ! $renderForDialog ): ?>
	<div data-role="footer" data-position="fixed" data-theme="a" class="page-footer">
		<div data-role="navbar" data-theme="a">
			<ul>
				<li><a data-icon="home" data-ajax="false" href="<?= $this->createUrl('site/index'); ?>">Home</a></li>
<?php if ( ! Yii::app()->user->isGuest ): ?>
				<li><a data-icon="gear" data-rel="popup" href="#<?= $this->getPopupMenuId(); ?>" data-position-to="window">Actions</a></li>
<?php else: ?>
				<li><a data-icon="grid" rel="external" href="http://openach.com">openach.com</a></li>
<?php endif; ?>

			</ul>
		</div>
		<?php $this->renderMenuAsPopup(); ?>
	</div>
<?php elseif( ! $renderForDialog && isset($_REQUEST['test'])): ?>
	<div data-role="footer" data-theme="a" data-position="fixed" id="oa-footer">
		<h1></h1>
		<a href="#" data-icon="grid" data-iconpos="notext" data-direction="reverse" class="ui-btn-right" id="oa-nav-menu-button">Menu</a>
		<div data-role="navbar" id="oa-nav-menu" style="display:none;">
			<ul>
				<li><a href="#" data-icon="custom" id="login">Login</a></li>
				<li><a href="#" data-icon="custom" id="email">Email</a></li>
				<li><a href="#" data-icon="custom" id="chat">Chat</a></li>
				<li><a href="#" data-icon="custom" id="coffee">Coffee</a></li>
			</ul>
		</div>
	</div>
<?php endif; ?>

</div>

</body>
</html>
