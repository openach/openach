<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAClientScript extends CClientScript
{

	const POS_PAGECREATE=10;

	public function repositionReadyScripts()
	{
		// If there are jQuery Ready scripts, move them to POS_PAGECREATE
		if ( isset( $this->scripts[CClientScript::POS_READY] ) )
		{
			$this->scripts[OAClientScript::POS_PAGECREATE] = $this->scripts[CClientScript::POS_READY];
			unset( $this->scripts[CClientScript::POS_READY] );
		}
	}

	public function renderBodyEnd(&$output)
	{
		// Move ready scripts to pagecreate
		$this->repositionReadyScripts();
		// Now that they are out of the way, let the parent class do its job as normal
		parent::renderBodyEnd($output);
	}

	public function renderPageCreate( CController $controller )
	{
		$this->repositionReadyScripts();

		$scripts = '';

		if ( isset( $this->scripts[OAClientScript::POS_PAGECREATE] ) )
		{
			$scripts .= "<script>\n";
			$scripts .= "$('#page-" . $controller->id . "-" . $controller->action->id . "').live( 'pagecreate',function(){\n"
				. implode("\n",$this->scripts[self::POS_PAGECREATE])."\n});";
			$scripts .= "\n</script>\n";
		}

		return $scripts;
	}

}
