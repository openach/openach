<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OriginatorTest extends WebTestCase
{
	public $fixtures=array(
		'originators'=>'Originator',
	);

	public function testShow()
	{
		$this->open('?r=originator/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=originator/create');
	}

	public function testUpdate()
	{
		$this->open('?r=originator/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=originator/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=originator/index');
	}

	public function testAdmin()
	{
		$this->open('?r=originator/admin');
	}
}
