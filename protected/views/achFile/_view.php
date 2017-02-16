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
  $this->currentPagerDivider = $data->displayDate();
  if ( Yii::app()->request->getParam('currentPagerDivider') != $this->currentPagerDivider && $this->currentPagerDivider != $this->prevPagerDivider ) :
?>
<?php if ( ! Yii::app()->request->getParam('AchFile_sort') ): ?><li data-role="list-divider"><?= strtoupper( $this->currentPagerDivider ); ?></li><?php endif; ?>
<?php endif; ?>
<li>
	<a href="<?php echo $this->createUrl( 'achFile/view', array( 'id' => $data->ach_file_id ) ); ?>">
	<img src="/images/icons/large/achfile.png" />
	<h3><?= $data->displayFileId(); ?></h3>
	<p><?= $data->displayDebits(); ?></p>
	<p><?= $data->displayCredits(); ?></p>
	<span class="ui-li-count"><?= $data->displayStatus(); ?></span>
	</a>
</li>
