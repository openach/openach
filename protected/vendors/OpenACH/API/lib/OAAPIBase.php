<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAAPIBase implements IteratorAggregate
{
	protected $data = array();
	protected $records = array();

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		throw new Exception( 'Property "' . get_class( $this ) . '.' . $name . '" is not defined.' );
	}

	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	public function __unset($name)
	{
		unset($this->data[$name]);
	}

	public function merge( $object )
	{
		foreach ( $object as $key => $value )
		{
			$this->{$key} = $value;
		}
	}

	public function addRecord( $record )
	{
		$this->records[] = $record;
	}
	
	public function addRecords( OAAPIBase $records )
	{
		foreach ( $records as $record )
		{
			$this->records[] = $record;
		}
	}

	public function setRecords( $records )
	{
		$this->records = $records;
	}

	public function getIterator()
	{
		if ( count( $this->records ) )
		{
			return new ArrayIterator( $this->records );
		}
		else
		{
			return new ArrayIterator( $this->data );
		}
	}
}
