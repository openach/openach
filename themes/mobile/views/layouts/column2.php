<?php 
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->beginContent('//layouts/main'); ?>
	<?php
		/*
		$this->beginWidget('zii.widgets.CPortlet', array(
			//'title'=>'',
			'htmlOptions'=>array('data-role'=>'navbar','data-position'=>'fixed'),
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations','data-theme'=>'a'),
		));
		$this->endWidget();
		*/
	?>
	<div>
	<?php echo $content; ?>
	</div>
<?php $this->endContent(); ?>
