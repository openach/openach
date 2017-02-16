<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class Businesses
{

	public function __construct()
	{
		$this->nameCount = count( $this->names );
	}

	public function getName()
	{
		return $this->names[ rand( 0, $this->nameCount-1 ) ];
	}

	public function getNames( $count = -1 )
	{
		if ( $count == -1 )
		{
			return $this->names;
		}
		$nameList = array();
		for ( $i = 0; $i < $count; $i++ )
		{
			$nameList[] = $this->names[ rand( 0, $this->nameCount-1 ) ];
		}
		return $nameList;
	}

	public $nameCount;

	public $names = array(
		'Hot Frog, Ltd.',
		'Hot Skunk, Co.',
		'Simple Frog, Inc.',
		'Blue Light-Switch, Co.',
		'Small Robot, LLC',
		'Foggy Book, LLC',
		'Black Squirrel, Inc.',
		'Foggy Cherry, Ltd.',
		'Pink Lime, Limited',
		'Cheeky Whale, Co.',
		'Orange Gorilla, Ltd.',
		'Silly Elephant, Inc.',
		'Beta Pigeon, Inc.',
		'Hot Shark, Ltd.',
		'Transparent Pen, Inc.',
		'Freezing Toaster, LLC',
		'Stormy Glass, Limited',
		'Fat Fish, LLC',
		'Content Tiger, Limited',
		'Red Robot, Ltd.',
		'Intelligent Pear, Inc.',
		'Piping Toaster, LLC',
		'Big Cake, Ltd.',
		'Plain Skunk, Inc.',
		'Tiny Scarf, Ltd.',
		'Beta Scarf, LLC',
		'Cheeky Panda, Inc.',
		'Piping Turtle, Limited',
		'Brown Apple, LLC',
		'Content Bull, Inc.',
		'Intelligent Apple, Ltd.',
		'The Cold Cat, LLC',
		'White Elephant, Ltd.',
		'Angry Knife, Limited',
		'Sub-Zero Turtle, Inc.',
		'Thin Meerkat, LLC',
		'Cloudy Penguin, Limited',
		'Cloudy Mouse, Ltd.',
		'Snowy Lemon, Inc.',
		'Hot Donkey, LLC',
		'Stupid Book, Inc.',
		'Sunny Ram, Ltd.',
		'Foggy Hamster, Limited',
		'Cold Frog, LLC',
		'Simple Android, Inc.',
		'Hot Scarf, Limited',
		'Snowy Light-Switch, Ltd.',
		'Transparent Android, LLC',
		'Pink Snake, Ltd.',
		'Plain Cherry, Inc.',
		'Acute Gorilla, LLC',
		'Tall Meerkat, Limited',
		'The Purple Hamster, Inc.',
		'Sunny Tiger, LLC',
		'Freezing Lime, Ltd.',
		'Blue Beaver, Inc.',
		'Peaceful Llama, Ltd.',
		'The Tall Pen, LLC',
		'Orange Phone, Inc.',
		'Sub-Zero Duck, Ltd.',
		'Hot Snake, Limited',
		'Complicated Alligator, LLC',
		'The Sunny Lime, Limited',
		'Squirrel, Ltd.',
		'Pink Box, Inc.',
		'Cheerful Android, LLC',
		'Big Pear, Ltd.',
		'White Meerkat, Ltd.',
		'Happy Shark, LLC',
		'The Brown Moose, Inc.',
		'Intelligent Fan, Limited',
		'Cheerful Tiger, LLC',
		'Sad Turtle, Inc.',
		'The Plain Camel, Ltd.',
		'Cheerful Fan, LLC',
		'Hot Beaver, Ltd.',
		'Orange Dog, Limited',
		'The Sad Shoe, Inc.',
		'Complicated Scarf, Ltd.',
		'Jealous Baboon, LLC',
		'Piping Cherry, Limited',
		'The Happy Tree, Ltd.',
		'Opaque Lamp, Inc.',
		'The Beta Snail, LLC',
		'Sad Lemon, Inc.',
		'Deep Alligator, Ltd.',
		'Green Cow, Limited',
		'Large Camel, LLC',
		'Obtuse Skunk, Inc.',
		'Peaceful, Limited',
		'Intelligent Robot, Ltd.',
	);
}

