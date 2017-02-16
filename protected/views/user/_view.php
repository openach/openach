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
  $this->currentPagerDivider = substr( $data->user_login, 0, 1 );
  if ( Yii::app()->request->getParam('currentPagerDivider') != $this->currentPagerDivider && $this->currentPagerDivider != $this->prevPagerDivider ) :
?>
<?php if ( ! Yii::app()->request->getParam('User_sort') ): ?><li data-role="list-divider"><?= strtoupper( $this->currentPagerDivider ); ?></li><?php endif; ?>
<?php endif; ?>
<li>
	<a href="<?php echo $this->createUrl( 'user/view', array( 'id' => $data->user_id ) ); ?>">
	<img src="/images/icons/large/user.png" />
	<h3><?php echo $data->user_login; ?></h3>
	<p><strong><?php echo implode( ', ', array( CHtml::encode($data->user_last_name), CHtml::encode($data->user_first_name) ) ); ?></strong></p>
	<p><?php echo CHtml::encode($data->user_email_address); ?></p>
	<span class="ui-li-count"><?php echo CHtml::encode($data->user_status); ?></span>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'user/update', array( 'id' => $data->user_id ) ); ?>">Edit User</a>
</li>
