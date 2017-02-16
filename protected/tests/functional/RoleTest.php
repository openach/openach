<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class RoleTest extends WebTestCase
{
	public $fixtures=array(
		'roles'=>'Role',
	);

	public function testShow()
	{
		$this->open('?r=role/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=role/create');
	}

	public function testUpdate()
	{
		$this->open('?r=role/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=role/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=role/index');
	}

	public function testAdmin()
	{
		$this->open('?r=role/admin');
	}
}
