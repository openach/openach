<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

require_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OAClientConfig.php' );

class OAClientConfigIni extends OAClientConfig
{

	const DEFAULT_CONFIG_FILE_NAME = '/conf/connection.ini';
	public $requiredSettings = array( 'apiToken', 'apiKey', 'endpointUrl' );
	public $optionalSettings = array( 'portNumber' => '80' );

	public $iniFile = '';

	public function __construct( $config_dir = '', $filename = '' ) {
		if ( !$config_dir ) {
			$config_dir = dirname(__FILE__);
		}

		if ( !$filename ) {
			$filename = self::DEFAULT_CONFIG_FILE_NAME;
		}

		$this->iniFile = $config_dir . $filename;

		if ( !file_exists( $this->iniFile ) )
			throw new Exception( 'Config file ' . $this->iniFile . ' does not exist, or is not accessible.' );

		$config = parse_ini_file( $this->iniFile );

		$this->importConfig( $config );
	}

	protected function importConfig( $config )
	{
		foreach ( $this->requiredSettings as $key )
		{
			if ( ! isset( $config[$key] ) )
			{
				throw new Exception( 'Config file ' . $this->iniFile . ' does not have a value defined for ' . $key );
			}
			$this->{ $key } = $config[$key];
		}

		foreach ( $this->optionalSettings as $key => $default )
		{
			if ( isset( $config[ $key ] ) )
			{
				$this->{ $key } = $config[ $key ];
			}
			else
			{
				$this->{ $key } = $default;
			}
		}
	}

}
