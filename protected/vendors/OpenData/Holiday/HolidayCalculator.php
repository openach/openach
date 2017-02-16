<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 *
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class HolidayCalculator 
{
	protected $currentDateString;
	protected $currentDate;
	
	public $holidays = array(
		'US' =>	array(
			// January 1st
			"New Year's Day" => array(
				'type' => 'date',
				'month' => 1,
				'day' => 1,
			),
			// 3rd Monday in January
			"Martin Luther King's Birthday" => array(
				'type' => 'day',
				'count' => 3,
				'day' => 'Monday',
				'month' => 1,
			),
			// 3rd Monday in February
			"Washington's Birthday" => array(
				'type' => 'day',
				'count' => 3,
				'day' => 'Monday',
				'month' => 2,
			),
			// Last Monday in May
			"Memorial Day" => array(
				'type' => 'day',
				'count' => 'last',
				'day' => 'Monday',
				'month' => 5,
			),
			// July 4th
			"Independence Day" => array(
				'type' => 'date',
				'month' => 7,
				'day' => 4,
			),
			// 1st Monday in September
			"Labor Day" => array(
				'type' => 'day',
				'count' => 1,
				'day' => 'Monday',
				'month' => 9,
			),
			// 2nd Monday in October
			"Columbus Day" => array(
				'type' => 'day',
				'count' => 2,
				'day' => 'Monday',
				'month' => 10,
			),
			// November 11
			"Veteran's Day" => array(
				'type' => 'date',
				'month' => 11,
				'day' => 11,
			),
			// 4th Thursday in November
			"Thanksgiving Day" => array(
				'type' => 'day',
				'count' => 4,
				'day' => 'Thursday',
				'month' => 11,
			),
			// December 25
			"Christmas Day" => array(
				'type' => 'date',
				'month' => 12,
				'day' => 25,
			),
		),
		'CA' => array(
			// January 1st
			"New Year's Day" => array(
				'type' => 'date',
				'month' => 1,
				'day' => 1,
			),
			// 3rd Monday in February
			"Family Day" => array(
				'type' => 'day',
				'count' => 3,
				'day' => 'Monday',
				'month' => 2,
			),
			// Good Friday
			"Good Friday" => array(
				'type' => 'easter',
				'day' => 'Friday',
			),
			// Easter Sunday
			"Easter" => array(
				'type' => 'easter',
				'day' => 'Sunday',
			),
			// Easter Monday
			"Easter Monday" => array(
				'type' => 'easter',
				'day' => 'Monday',
			),
			// Last Monday before May 25
			"Victoria Day" => array(
				'type' => 'day',
				'count' => 'last',
				'day'	=> 'Monday',
				'before' => 25,
				'month' => 5,
			),
			// July 1
			"Canada Day" => array(
				'type' => 'date',
				'month' => 7,
				'day' => 1,
			),
			// 1st Monday in September
			"Labour Day" => array(
				'type' => 'day',
				'count' => 1,
				'day' => 'Monday',
				'month' => 9,
			),
			// 2nd Monday in October
			"Thanksgiving Day" => array(
				'type' => 'day',
				'count' => 2,
				'day' => 'Monday',
				'month' => 10,
			),
			// November 11
			"Remembrance Day" => array(
				'type' => 'date',
				'month' => 11,
				'day' => 11,
			),
			// December 25
			"Christmas Day" => array(
				'type' => 'date',
				'month' => 12,
				'day' => 25,
			),
			// December 26
			"Boxing Day" => array(
				'type' => 'date',
				'month' => 12,
				'day' => 26,
				'observedNextIfDay' => 'Monday', // If it falls on a Monday, its observed on the next day, otherwise standard weekend rules apply
			),
		),
	);
	
	public function __construct( $currentDateString='now' )
	{
		$this->currentDate = new DateTime( $currentDateString );
		$this->currentDateString = $currentDateString;
	}
	
	public function setCurrentDate( $currentDateString='now' )
	{
		$this->currentDate = new DateTime( $currentDateString );
		$this->currentDateString = $currentDateString;
	}
	
	public function setCurrentDateTime( $currentDateTime )
	{
		$this->currentDate = $currentDateTime;
		$this->currentDateString = $currentDateTime->format( 'Y-m-d' );
	}
	
	public function getObservedHolidays( $country='US' )
	{
		$holidayList = array();
		
		foreach ( $this->holidays[$country] as $name => $holiday )
		{
			$holidayList[$name] = $this->calcHoliday( $holiday, true );
		}
		
		return $holidayList;
	}

	public function getActualHolidays( $country='US' )
	{
		$holidayList = array();

		foreach ( $this->holidays[$country] as $name => $holiday )
		{
			$holidayList[$name] = $this->calcHoliday( $holiday );
		}
		
		return $holidayList;
	}
	
	public function getAllHolidays( $country='US' )
	{
		$observedHolidays = $this->getObservedHolidays($country);
		$actualHolidays = $this->getActualHolidays($country);
		foreach ( $observedHolidays as $name => $date )
		{
			if ( ! in_array( $date, $actualHolidays ) )
			{
				$actualHolidays[$name . ' (Observed)'] = $date;
			}
		}
		
		return $actualHolidays;		
	}

	protected function calcHoliday( $holiday, $observed=false )
	{

		$currentDateParts = array(
				'year' => intval( $this->currentDate->format( 'Y' ) ),
				'month' => intval( $this->currentDate->format( 'm' ) ),
				'day' => intval( $this->currentDate->format( 'd' ) ),
			);
			
		switch ( $holiday['type'] )
		{
			case 'date':
				$dateHoliday = new DateTime();
				$dateHoliday->setDate( intval( $this->currentDate->format( 'Y' ) ), $holiday['month'], $holiday['day'] );
				$holidayDateString = $dateHoliday->format( 'Y-m-d' );
				$currentDateString = $this->currentDate->format( 'Y-m-d' );
				if ( $currentDateString > $holidayDateString )
				{
					// Get next years date by adding one year
					$dateHoliday->add( new DateInterval( 'P1Y' ) );
				}
				break;
			case 'day':
				$dateHoliday = $this->calcNthDate( $holiday );
				$holidayDateString = $dateHoliday->format( 'Y-m-d' );
				$currentDateString = $this->currentDate->format( 'Y-m-d' );
				if ( $currentDateString > $holidayDateString )
				{
					// Get next years date using calcNthDate to add a year
					$dateHoliday = $this->calcNthDate( $holiday, true );
				}
				break;
			case 'easter':
				$dateHoliday = $this->calcEasterDate( $holiday );
				$holidayDateString = $dateHoliday->format( 'Y-m-d' );
				$currentDateString = $this->currentDate->format( 'Y-m-d' );
				if ( $currentDateString > $holidayDateString )
				{
					// Get next years date using calcEasterDate to add a year
					$dateHoliday = $this->calcEasterDate( $holiday, true );
				}
				break;
			default:
				return false;
				break;
		}

		// If specified, calculate the OBSERVED day, but ignore if its an Easter holiday
		if ( $observed && $holiday['type'] != 'easter' )
		{
			// If it has an observedNextIfDay, and the holiday falls on {observedNextIfDay} the observed holiday is the following day
			if ( isset( $holiday['observedNextIfDay'] ) && intval( $dateHoliday->format( 'l' ) ) == $holiday['observedNextIfDay'] )
			{
				$dateHoliday->sub( new DateInterval( 'P1D' ) );
			} 
			// If it falls on a Sunday, the observed holiday is the following day
			elseif ( intval( $dateHoliday->format( 'w' ) ) == 0 )
			{
				$dateHoliday->add( new DateInterval( 'P1D' ) );
			}
			// If it falls on a Saturday, the observed holiday is the previous day
			elseif ( intval( $dateHoliday->format( 'w' ) ) == 6 )
			{
				$dateHoliday->sub( new DateInterval( 'P1D' ) );
			}
		}

		return $dateHoliday->format( 'Y-m-d' );
	}
	
	protected function calcNthDate( $holiday, $nextYear=false )
	{
		$dateHoliday = new DateTime();

		// Use either the current year or the next year
		$useYear = intval( $this->currentDate->format( 'Y' ) );
		if ( $nextYear )
		{
			$useYear++;
		}

		// Start with the first of the given month
		$dateHoliday->setDate( $useYear, $holiday['month'], 1 );

		// Keep adding days until we get to the correct day of the week... this will be the 1st {day} of the month
		while ( $dateHoliday->format( 'l' ) !== $holiday['day'] )
		{
			$dateHoliday->add( new DateInterval( 'P1D' ) );
		}

		// If we're looking for the LAST {day} of the month, we need to do some fancy calculations		
		if ( $holiday['count'] == 'last' )
		{
			if ( isset( $holiday['before'] ) )
			{
				// Keep adding 7 days until we're within 7 days of the {before} date without going past
				while ( ( intval( $dateHoliday->format( 'j' ) ) + 7 ) < $holiday['before'] )
				{
					$dateHoliday->add( new DateInterval( 'P7D' ) );
				}
			}
			else
			{
				// Keep adding 7 days until we're in the next month
				while ( intval( $dateHoliday->format( 'n' ) ) == $holiday['month'] )
				{
					$dateHoliday->add( new DateInterval( 'P7D' ) );
				}
				// Now back up 7 days and we'll be at the last {day} of the month
				$dateHoliday->sub( new DateInterval( 'P7D' ) );
			}
		}
		// If we're looking for the first {day}, we've already found it
		// but if we're looking for the Nth {day}, we need to continue
		elseif ( $holiday['count'] > 1 )
		{
			$dayIncrement = ( $holiday['count'] - 1 ) * 7;
			$dateHoliday->add( new DateInterval( 'P' . $dayIncrement . 'D' ) ); 
		}
		
		return $dateHoliday;
	}

	protected function calcEasterDate( $holiday, $nextYear=false )
	{
		$dateHoliday = new DateTime();

		// Use either the current year or the next year
		$useYear = intval( $this->currentDate->format( 'Y' ) );
		if ( $nextYear )
		{
			$useYear++;
		}
		
		$dateHoliday->setTimestamp( easter_date( $useYear ) );

		// If Easter Monday, add one day	
		if ( $holiday['day'] == 'Monday' )
		{
			$dateHoliday->add( new DateInterval( 'P1D' ) );
		}
		// If Good Friday, subtract two days	
		elseif ( $holiday['day'] == 'Friday' )
		{
			$dateHoliday->sub( new DateInterval( 'P2D' ) );
		}
		// If Maunday Thursday, subtract three days	
		elseif ( $holiday['day'] == 'Thursday' )
		{
			$dateHoliday->sub( new DateInterval( 'P3D' ) );
		}
		
		return $dateHoliday;
	}

}

