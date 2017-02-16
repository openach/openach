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
  $this->currentPagerDivider = substr( $data->payment_type_name, 0, 1 );
  if ( Yii::app()->request->getParam('currentPagerDivider') != $this->currentPagerDivider && $this->currentPagerDivider != $this->prevPagerDivider ) :
?>
	<?php if ( false && ! Yii::app()->request->getParam('PaymentType_sort') ): ?>
	<li data-role="list-divider"><?= strtoupper( $this->currentPagerDivider ); ?></li>
	<?php endif; ?>
<?php endif; ?>
<li>
	<a href="<?= $this->createUrl( 'paymentType/view', array( 'id' => $data->payment_type_id ) ); ?>">
	<?= $data->payment_type_name; ?>
	<span class="ui-li-count"><?= $data->payment_type_status; ?></span>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'paymentType/update', array( 'id' => $data->payment_type_id ) ); ?>">Edit Payment Type</a>
</li>

