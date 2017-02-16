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
  $this->currentPagerDivider = substr( $data->originator_name, 0, 1 );
  if ( Yii::app()->request->getParam('currentPagerDivider') != $this->currentPagerDivider && $this->currentPagerDivider != $this->prevPagerDivider ) :
?>
<?php if ( ! Yii::app()->request->getParam('Originator_sort') ): ?><li data-role="list-divider"><?= strtoupper( $this->currentPagerDivider ); ?></li><?php endif; ?>
<?php endif; ?>
<li>
	<a href="<?php echo $this->createUrl( 'originator/view', array( 'id' => $data->originator_id ) ); ?>">
	<img src="/images/icons/large/originator.png" />
	<h3><?php echo $data->originator_name; ?></h3>
	<p><strong><?= $data->displayAddress(); ?></strong></p>
	</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'originator/update', array( 'id' => $data->originator_id ) ); ?>">Edit Originator</a>
</li>
