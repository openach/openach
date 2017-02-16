<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

class OAPluginConfig extends OAConfig
{
	const PLUGIN_CLASS = '';
	const PLUGIN_VERSION = '';
	const PARENT_MODEL = '';

	protected $plugin;
	protected $pluginConfig;
	protected $dataProvider;

	public function init( $parentId='' )
	{
		$className = $this->getClassName();
		$plugin = Plugin::model()->findByAttributes(
				array(
					'plugin_class' => $className::PLUGIN_CLASS,
					'plugin_version' => $className::PLUGIN_VERSION,
				)
			);
		if ( $plugin )
		{
			$this->plugin = $plugin;
			$this->load( $parentId );
		}
	}

	public function load( $parentId='' )
	{
		if ( ! $this->plugin )
		{
			throw new Exception( 'This plugin is not registered.' );
		}

		$criteria = new CDbCriteria;
		$criteria->compare( 'plugin_config_plugin_id', $this->plugin->plugin_id, true );
		$criteria->compare( 'plugin_config_parent_id', $parentId, true );
		$criteria->order = 'plugin_config_weight';

		$this->dataProvider = new CActiveDataProvider( 'PluginConfig', array( 'criteria'=>$criteria ) );
		$this->dataProvider->setPagination( false );

		if ( $this->dataProvider )
		{
			$this->pluginConfig = $this->dataProvider->getData();
		}
		else
		{
			$this->pluginConfig = array();
		}
/*
		$this->pluginConfig = PluginConfig::model()->findAllByAttributes( 
				array(
					'plugin_config_plugin_id' => $this->plugin->plugin_id,
					'plugin_config_parent_id' => $parentId,
				),
				$criteria
			);
*/

		
		if ( count( $this->pluginConfig ) > 0 )
		{
			foreach ( $this->pluginConfig as $configItem )
			{
				$this->configState[ $configItem->plugin_config_key ] = $configItem->plugin_config_value;
			}
		}
		else
		{
			// Load the defaults and save
			$this->configState = $this->defaults();
			$this->store( $parentId );
		}

	}

	public function register($enabled = true)
	{

		if ( $this->plugin  )
		{
			throw new Exception( 'This plugin class is already registered.' );
		}

		try
		{
			$dbTrans = Yii::app()->db->beginTransaction();

			$className = $this->getClassName();
			$plugin = new Plugin();
			if ( $enabled )
			{
				$plugin->plugin_status = 'enabled';
			}
			else
			{
				$plugin->plugin_status = 'disabled';
			}
			$plugin->plugin_class = $className::PLUGIN_CLASS;
			$plugin->plugin_version = $className::PLUGIN_VERSION;
			if ( !$plugin->save() )
			{
				throw new CDbException( 'Unable to register the plugin due to the following error(s): ' . var_export( $plugin->getErrors(), true ) );
			}
			else
			{
				$this->plugin = $plugin;
				$this->configState = $this->defaults();
				$this->store();
			}
			$dbTrans->commit();
		}
		catch ( Exception $e )
		{
			$dbTrans->rollBack();
			throw $e;
		}
	}

	public function unregister()
	{
		if ( ! $this->plugin )
		{
			throw new Exception( 'This plugin class is not registered.' );
		}

		try
		{
			$dbTrans = Yii::app()->db->beginTransaction();

			$pluginConfig = PluginConfig::model()->deleteAllByAttributes(
					array(
						'plugin_config_plugin_id' => $this->plugin->plugin_id,
					)
				);
			$this->plugin->delete();

			$dbTrans->commit();
		}
		catch ( Exception $e )
		{
			$dbTrans->rollBack();
			throw $e;
		}
	}

	public function defaults()
	{
		return array();
	}

	public function store($parentId = '')
	{
		$className = $this->getClassName();

		$criteria = new CDbCriteria;
		$criteria->compare( 'plugin_config_plugin_id', $this->plugin->plugin_id, true );
		$criteria->compare( 'plugin_config_parent_id', $parentId, true );

		$configCount = 0;

		foreach ( $this->configState as $key => $value )
		{
			// Try to load an existing config key, otherwise create a new one
			$keyCriteria = clone $criteria;
			$keyCriteria->compare( 'plugin_config_key', $key );

			if ( ! $configItem = PluginConfig::model()->find( $keyCriteria ) )
			{
				$configItem = new PluginConfig();
				$configItem->plugin_config_plugin_id = $this->plugin->plugin_id;
				$configItem->plugin_config_parent_id = $parentId;
				$configItem->plugin_config_parent_model = $className::PARENT_MODEL;
				$configItem->plugin_config_key = $key;
			}

			$configItem->plugin_config_value = $value;
			$configItem->plugin_config_weight = $configCount;

			if ( ! $configItem->save() )
			{
				throw new CDbException( 'Unable to save the plugin config due to the following error(s): ' . var_export( $configItem->getErrors(), true ) );
			}
			$configCount++;
		}
	}

	public function isRegistered()
	{
		return $this->plugin ? true : false;
	}

	public function getPluginConfig()
	{
		return $this->pluginConfig;
	}

	public function getDataProvider()
	{
		return $this->dataProvider;
	}

}


