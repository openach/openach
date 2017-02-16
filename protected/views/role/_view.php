<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/
  if ( ! $this->currentPagerDivider  )
  {
	$this->prevPagerDivider = '';
  }
  else
  {
  	$this->prevPagerDivider = $this->currentPagerDivider;
  }
  $this->currentPagerDivider = substr( $data->role_name, 0, 1 );
  if ( Yii::app()->request->getParam('currentPagerDivider') != $this->currentPagerDivider && $this->currentPagerDivider != $this->prevPagerDivider ) :
?>
<?php if ( ! Yii::app()->request->getParam('Role_sort') ): ?><li data-role="list-divider"><?= strtoupper( $this->currentPagerDivider ); ?></li><?php endif; ?>
<?php endif; ?>
<li>
	<a href="<?php echo $this->createUrl( 'role/view', array( 'id' => $data->role_id ) ); ?>">
	<img src="/images/icons/large/role.png" />
	<h3><?php echo $data->role_name; ?></h3>
	<p><?php echo CHtml::encode($data->role_description); ?></p>
	<span class="ui-li-count"><?php echo ($data->role_iat_enabled) ? 'international' : 'domestic'; ?></span>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'role/update', array( 'id' => $data->role_id ) ); ?>">Edit Role</a>
</li>
