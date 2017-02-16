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
  $this->currentPagerDivider = substr( $data->payment_profile_last_name, 0, 1 );
  if ( Yii::app()->request->getParam('currentPagerDivider') != $this->currentPagerDivider && $this->currentPagerDivider != $this->prevPagerDivider ) :
?>
	<?php if ( false && ! Yii::app()->request->getParam('PaymentProfile_sort') ): ?>
	<li data-role="list-divider"><?= strtoupper( $this->currentPagerDivider ); ?></li>
	<?php endif; ?>
<?php endif; ?>
<li>
	<a href="<?= $this->createUrl( 'paymentProfile/view', array( 'id' => $data->payment_profile_id ) ); ?>">
	<img src="/images/icons/large/customer.png" /><h3><?= $data->displayCustomer(); ?></h3>
	<p><?= $data->displayEmailAddress(); ?></p>
	<span class="ui-li-count"><?= $data->payment_profile_status; ?></span>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentProfile/update', array( 'id' => $data->payment_profile_id ) ); ?>">Edit Payment Profile</a>
</li>

