<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * ODPhonetic class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

class ODPhonetic
{
	public static function encode( $data, $method )
	{
		switch ( $method )
		{
			case 'soundex':
				return static::soundex( $data );
				break;
			case 'nysiis':
				return static::nysiis( $data );
				break;
			case 'metaphone':
				return static::metaphone( $data );
				break;
			case 'metaphone2':
			case 'doublemetaphone':
				return static::metaphone2( $data );
				break;
			default:
				throw new Exception( 'The method ' . $method . ' is not available.' );
				return '';
				break;
		}
	}
	
	public static function distance( $data1, $data2, $method )
	{
		switch ( $method )
		{
			case 'levenshtein':
				return levenshtein( $data1, $data2 );
			default:
				return '';
				break;
		}
	}
	
	public static function soundex( $data )
	{
		return soundex( $data );
	}
	
	public static function nysiis( $str, $limit=false )
	{
		// Transform to uppercase
		$str = strtoupper( $str );
	 	// Remove all leading and trailing white space
		$str = trim ( $str );
		// Remove all non alphabetical, and non-space chars
		$str = preg_replace( '/[^A-Z ]/', '', $str );
		// Remove Jr. and Sr.
		$str = preg_replace( '/ +(JR|SR)$/', '', $str );
		// Remove all trailing Roman numerals
		$str = preg_replace( '/ +(I|V|X|L|C|D|M)+$/', '', $str );
		// Remove all spaces
		$str = preg_replace( '/ /', '', $str);
	 
		// 1. Translate first characters of name: 
		// => MAC → MCC 
		$str = preg_replace( '/^MAC/', 'MCC', $str );
		// => KN → NN
		$str = preg_replace( '/^KN/', 'NN', $str );
		// => K → C
		$str = preg_replace( '/^K/', 'C', $str );
		// => PF → FF, PH → FF
		$str = preg_replace( '/^(PH|PF)/', 'FF', $str );
		// => SCH → SSS
		$str = preg_replace( '/SCH/', 'SSS', $str );
	 
		// 2. Translate last characters of name: 
		// => EE → Y, IE → Y
		$str = preg_replace( '/(EE|IE)$/', 'Y', $str );
		// => DT, RT, RD, NT, ND → D
		$str = preg_replace( '/(DT|RT|RD|NT|ND)$/', 'D', $str );
	 
		// 3. First character of key = first character of name.
		$str_first = $str[0];
		$str = substr( $str, 1 );
	 
		// 4. Translate remaining characters by following rules, 
		//	incrementing by one character each time:
		// => EV → AF else A, E, I, O, U → A
		if ( preg_match( '/EV/', $str ) )
		{
			$str = preg_replace( '/EV/', 'AF', $str );
		}
		$str = preg_replace( '/[AEIOU]+/','A', $str );
		// => Q → G
		$str = preg_replace( '/Q/', 'G', $str );
		// => Z → S
		$str = preg_replace( '/Z/', 'S', $str );
		// => M → N
		$str = preg_replace( '/M/', 'N', $str );
		// => KN → NN else K → C
		$str = preg_replace( '/KN/', 'NN', $str );
		$str = preg_replace( '/K/', 'C', $str );
		// => SCH → SSS
		$str = preg_replace( '/SCH/', 'SSS', $str );
		// => PH → FF
		$str = preg_replace( '/PH/', 'FF', $str );
		// => H → If previous or next is nonvowel, previous.
		$str = preg_replace( '/([^AEIOU])H/', '$1', $str);
		$str = preg_replace( '/(.)H[^AEIOU]/', '$1', $str);
		// => W → If previous is vowel, previous.	
		$str = preg_replace( '/[AEIOU]W/', 'A', $str );

		// 5. If last character is S, remove it.
		$str = preg_replace( '/S$/', '', $str );

		// 6. If last characters are AY, replace with Y.
		$str = preg_replace( '/AY$/', 'Y', $str );

		// 7. If last character is A, remove it.
		$str = preg_replace( '/A$/', '', $str );
		
		// Because encoding is done in place, we need to remove consecutive duplicates
		$str = preg_replace( '/[AEIOU]+/', 'A', $str );
		$str = preg_replace( '/B+/', 'B', $str );
		$str = preg_replace( '/C+/', 'C', $str );
		$str = preg_replace( '/D+/', 'D', $str );
		$str = preg_replace( '/F+/', 'F', $str );
		$str = preg_replace( '/G+/', 'G', $str );
		$str = preg_replace( '/H+/', 'H', $str );
		$str = preg_replace( '/J+/', 'J', $str );
		$str = preg_replace( '/K+/', 'K', $str );
		$str = preg_replace( '/L+/', 'L', $str );
		$str = preg_replace( '/M+/', 'M', $str );
		$str = preg_replace( '/N+/', 'N', $str );
		$str = preg_replace( '/P+/', 'P', $str );
		$str = preg_replace( '/Q+/', 'Q', $str );
		$str = preg_replace( '/R+/', 'R', $str );
		$str = preg_replace( '/S+/', 'S', $str );
		$str = preg_replace( '/T+/', 'T', $str );
		$str = preg_replace( '/V+/', 'V', $str );
		$str = preg_replace( '/W+/', 'W', $str );
		$str = preg_replace( '/X+/', 'X', $str );
		$str = preg_replace( '/Y+/', 'Y', $str );
		$str = preg_replace( '/Z+/', 'Z', $str );

		$str = $str_first . $str;

		if ( $limit )
		{
			// The original NYSIIS specification limits the key to 6 characters
			return substr( $str, 0, 6 );
		}
		else
		{
			return $str;
		}
	}

	public static function metaphone( $data )
	{
		return metaphone( $data );
	}


	public static function metaphone2( $data )
	{
		return self::doublemetaphone( $data );
	}

	public static function doublemetaphone( $data )
	{
		if (! extension_loaded("doublemetaphone") )
		{
			throw new Exception( 'Double Metaphone extension is required to use this method.  See http://pecl.php.net/package/doublemetaphone for more details.' );
		}
		else
		{
			return double_metaphone( $data );
		}
	}

	public static function levenshtein( $data1, $data2 )
	{
		return levenshtein( $data1, $data2 );
	}

}
