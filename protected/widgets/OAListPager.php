<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import('system.web.widgets.pagers.CBasePager');

class OAListPager extends CBasePager
{

	public $listView = null;

        /**
         * Executes the widget.
         * This overrides the parent implementation by rendering javascript to 
	 * autoload the next page when scrolled to the bottom of the list.
         */
        public function run()
        {
                if(($pageCount=$this->getPageCount())<=1)
                        return;
		$currentPage = $this->getCurrentPage();
		if(($page=$currentPage+1)>=$pageCount-1)
		{
			$listViewId = $this->listView->getId();
			$listViewClass = $this->controller->id . '-' . $this->controller->action->id;
			$nextPageUrl = $this->createPageUrl( $page ) . '/ajax/1/currentPagerDivider/' . $this->controller->currentPagerDivider;
			$listViewItemsSelector = '#' . $listViewId . '.list-view ul.' . $listViewClass . '.items';
			$loadAllRecordsVar = $listViewId . '_loadAllRecords';
print <<<EOD

			<script type="text/javascript">
			$("$listViewItemsSelector li:last").appear(function(){
				$("$listViewItemsSelector").append("<div id='$listViewId-load-container' style='display:none;'></div>");
				$.mobile.showPageLoadingMsg();
				$("#$listViewId-load-container").load( "$nextPageUrl", function(){
					$("$listViewItemsSelector").append( $("#$listViewId-load-container").html() );
					$("#$listViewId-load-container").remove();
					$("$listViewItemsSelector").listview("refresh");
					$.mobile.hidePageLoadingMsg();
				});
				if ( $loadAllRecordsVar )
				{
					$("$listViewItemsSelector li:last").appear();
				}
			});
			var $loadAllRecordsVar = false;
			$("#$listViewId form.ui-listview-filter input.ui-input-text").live('focus',function(){
				$loadAllRecordsVar = true;
				$("$listViewItemsSelector li:last").appear();
			});
			$("#$listViewId form.ui-listview-filter input.ui-input-text").live('blur',function(){
				$loadAllRecordsVar = false;
			});
			</script>
EOD;

		}

        }

}
