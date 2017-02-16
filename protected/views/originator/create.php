<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

$this->breadcrumbs=array(
	'Originators'=>array('index'),
	'Create',
);

$this->stockMenus( array( 'list','search' ) );

$model->originator_user_id = $parent_id;
?>

<h1>Create Originator</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'parent_id'=>$parent_id )); ?>
