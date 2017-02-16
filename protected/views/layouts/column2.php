<?php 
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->beginContent('//layouts/main'); ?>
<div id="pageHeader">
	<h1><?= str_replace( Yii::app()->name . ' - ', '', $this->pageTitle );?></h1>
	<div class="pageOptions"></div>
	<div class="pageControls"></div>
	<div class="highlight"></div>
	<div class="shadow"></div>
</div>
<div class="container">
	<div class="span-19 last">
		<div id="appPageContent">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-5 last">
		<div id="appPageSidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>

</div>
<?php $this->endContent(); ?>
