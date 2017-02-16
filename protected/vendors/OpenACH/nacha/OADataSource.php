<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OADataSource extends ODDataSource
{
	public function formatDate( $date )
	{
		return OAController::formatDate( $date );
	}
	public function apiFields()
	{
		return array();
	}
	public function apiImport( CHttpRequest $request, $scenario='edit' )
	{
		// TODO:  This method probably doesn't even need a $scenario!
		foreach ( $this->apiFields() as $attribute => $state )
		{
			if ( ! is_array( $state ) )
			{
				$state = array( $state );
			}
			if ( $scenario == 'read' )
			{
				//$this->setAttribute( $attribute, $request->getParam( $attribute ) );
			}
			elseif ( $scenario == 'edit' && in_array( 'edit', $state ) )
			{
				$this->setAttribute( $attribute, $request->getParam( $attribute ) );
			}
		}
	}
	public function apiExport( $scenario='read' )
	{
		$attributes = new stdClass();
		foreach ( $this->apiFields() as $attribute => $state )
		{
			if ( ! is_array( $state ) )
			{
				$state = array( $state );
			}
			if ( $scenario == 'summary' )
			{
				if ( in_array( $scenario, $state ) )
				{
					$attributes->{$attribute} = ( $this->getAttribute( $attribute ) ? $this->getAttribute( $attribute ) : '' );
				}
			}
			elseif ( in_array( 'edit', $state ) || in_array( $scenario, $state ) )
			{
				$attributes->{$attribute} = ( $this->getAttribute( $attribute ) ? $this->getAttribute( $attribute ) : '' );
			}
		}
		return $attributes;
	}

	// This is designed to be overridden by subclasses needing to enforce ownership rules
	public function verifyOwnership()
	{
		return false;
	}

}

