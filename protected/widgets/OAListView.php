<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

Yii::import('zii.widgets.CListView');
Yii::import('application.widgets.OAListPager');

class OAListView extends CListView
{

	public $itemsHtmlOptions = array();
	public $pager = array();

	/**
	 * Initializes the list view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function init()
	{
		parent::init();
		$this->pager = array('class'=>'OAListPager', 'listView'=>$this);
	}

	/**
	 * Renders the data item list.
	 */
	public function renderItems()
	{
		if ( isset( $this->itemsHtmlOptions['class'] ) )
		{
			$this->itemsHtmlOptions['class'] .= ' ' . $this->itemsCssClass;
		}
		else
		{
			$this->itemsHtmlOptions['class'] = $this->itemsCssClass;
		}

		if ( $this->itemsTagName )
		{
			echo CHtml::openTag($this->itemsTagName, $this->itemsHtmlOptions )."\n";
		}
		$data=$this->dataProvider->getData();
		if(($n=count($data))>0)
		{
			$owner=$this->getOwner();
			$render=$owner instanceof CController ? 'renderPartial' : 'render';
			$j=0;
			foreach($data as $i=>$item)
			{
				$data=$this->viewData;
				$data['index']=$i;
				$data['data']=$item;
				$data['widget']=$this;
				$owner->$render($this->itemView,$data);
				if($j++ < $n-1)
					echo $this->separator;
			}
		}
		else
			$this->renderEmptyText();
		if ( $this->itemsTagName )
		{
			echo CHtml::closeTag($this->itemsTagName);
		}
	}

	/**
	 * Renders the sorter.
	 */
	public function renderSorter()
	{
		if($this->dataProvider->getItemCount()<=0 || !$this->enableSorting || empty($this->sortableAttributes))
			return;
		echo CHtml::openTag('div',array('class'=>$this->sorterCssClass))."\n";
		echo $this->sorterHeader===null ? Yii::t('zii','Sort by: ') : $this->sorterHeader;
		echo "<div data-role='controlgroup' data-type='horizontal' data-mini='true'>\n";
		//echo "<div data-role='button' data-theme='b'>Sort By:</div>";
		$sort=$this->dataProvider->getSort();

		$linkHtmlOptions = array(
				//'rel' => 'external',
				'data-role' => 'button',
				'data-mini' => 'true',
			);

		$directions = $sort->getDirections();

		foreach($this->sortableAttributes as $name=>$label)
		{
			$itemHtmlOptions = $linkHtmlOptions;
			if(is_integer($name))
			{
				$name = $label;
				$label = null;
			}
			if ( isset( $directions[$name] ) )
			{
				$itemHtmlOptions['data-icon'] = ( $directions[$name] ) ? 'arrow-u' : 'arrow-d';
				$itemHtmlOptions['data-theme'] = 'b';
			}
			echo $sort->link( $name, $label, $itemHtmlOptions );
		}
		echo "</div>";
		echo $this->sorterFooter;
		echo CHtml::closeTag('div');
	}

        /**
         * Renders the view.
         * This is the main entry of the whole view rendering.
         * Child classes should mainly override {@link renderContent} method.
         */
        public function run()
        {
                $this->registerClientScript();

		if ( $this->tagName )
		{
                	echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		}

                $this->renderContent();
                $this->renderKeys();

		if ( $this->tagName )
                {
			echo CHtml::closeTag($this->tagName);
		}
        }

}
