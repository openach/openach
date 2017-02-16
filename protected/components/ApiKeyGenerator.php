<?php


class ApiKeyGenerator
{

	private $key = '';

	public function __construct()
	{
		$stringKey = Yii::app()->securityManager->getEncryptionKey();
		$intKey = '';
		foreach ( (array) $stringKey as $char )
		{
			$intKey .= ord( $char );
		}
		$this->key = substr( $stringKey, 0, 32 );
	}

	public function generate()
	{
		$rand = '';
		while ( strlen( $rand ) < 32 )
		{
			$rand .= mt_rand();
		}
		$rand = substr( $rand, 0, 32 );
		$hash = hash_hmac( 'sha256', $rand, $this->key );
		return gmp_strval( '0x' . $hash, 62 );
	}

}

