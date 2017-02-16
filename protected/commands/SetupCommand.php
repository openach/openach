<?php
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/

/**
 * SetupCommand class file.
 *
 * @author Steven Brendtro <steven.brendtro@gmail.com>
 * @link http://www.openach.com/
 * @copyright Copyright &copy; 2011 Imagine Solutions, Ltd
 * @license http://www.openach.com/license/
 */

Yii::import( 'application.commands.*' );

class SetupCommand extends CConsoleCommand
{

	public $modelList = array(
		'AchBatch',
		'AchEntry',
		'AchEntryReturn',
		'AchFile',
		'AchFileConf',
		'EntityIndex',
		'ExternalAccount',
		'FedACH',
		'Fedwire',
		'FileTransfer',
		'MenuItem',
		'OdfiBranch',
		'OfacAdd',
		'OfacAlt',
		'OfacSdn',
		'Originator',
		'OriginatorInfo',
		'PaymentProfile',
		'PaymentSchedule',
		'PaymentType',
		'PhoneticData',
		'Plugin',
		'PluginConfig',
		'Role',
		'Settlement',
		'User',
		'UserApi',
		'UserHistory',
		'UserRole',
	);
	public $additionalTables = array(
		'auth_assignment',
		'auth_item',
		'auth_item_tree',
		'payment_event_log',
		'return_change',
		
	);

	protected $viewList = array(
			'phonetic_filtered',
		);

	protected $tableList = array();

	protected $enumList = array();

	protected $sql = array();

	public function actionRun($schema_file, $test_only=true, $confirm='', $data_file='')
	{
		$sqlConn = Yii::app()->db;
		if ( $confirm != 'fresh install' )
		{
			echo PHP_EOL;
			echo 'Your currently configured database is: ' . $sqlConn->connectionString . PHP_EOL . PHP_EOL;
			echo 'WARNING!!! WARNING!!! WARNING!!! WARNING!!! WARNING!!!WARNING!!! WARNING!!! WARNING!!! ' . PHP_EOL;
			echo 'This can seriously mess things up if you are not pointed at the right database!!!'. PHP_EOL;
			echo 'Verify the connection string above to ensure you are using the DB you expect.' . PHP_EOL;
			echo 'Do you REALLY want to do this? If so, set --confirm="fresh install".' . PHP_EOL. PHP_EOL;
			echo 'Exiting.' . PHP_EOL;
			Yii::app()->end();
		}

		if ( ! file_exists( $schema_file ) )
		{
			echo 'The schema file ' . $schema_file . ' could not be loaded.' . PHP_EOL;
			Yii::app()->end();
		}

		if ( $data_file && ! file_exists( $data_file ) )
		{
			echo 'The data file ' . $data_file . ' could not be loaded.' . PHP_EOL;
			Yii::app()->end();
		}

		try
		{
			$dbTrans = $sqlConn->beginTransaction();

			$cmds =  file_get_contents( $schema_file );
			$cmds = preg_replace('!/\*.*?\*/!s', '', $cmds);
			$cmds = preg_replace('!\-\-.*!', '', $cmds);
			$cmds = preg_replace('/\n\s*\n/', "\n", $cmds);
			foreach  (explode(';', $cmds ) as $cmd ) {
				$sql = $sqlConn->createCommand( $cmd );
				$result = $sql->execute();
			}

			if ( $data_file )
			{
				$cmds =  file_get_contents( $data_file );
				$cmds = preg_replace('!/\*.*?\*/!s', '', $cmds);
				$cmds = preg_replace('!\-\-.*!', '', $cmds);
				$cmds = preg_replace('/\n\s*\n/', "\n", $cmds);
				foreach  (explode(";", $cmds ) as $cmd ) {
					$sql = $sqlConn->createCommand( $cmd );
					$sql->execute();
				}
			}

			if ( ! $test_only )
			{
				$dbTrans->commit();
				echo 'The SQL was successfully committed to the database.' . PHP_EOL;
			}
			else
			{
				//$dbTrans->rollback();
				echo 'NOTICE!!!  Running in test only mode - rolling back the transaction.' . PHP_EOL;
				echo 'If you are seeing this message, no errors occurred.  It should be safe to commit the changes using the "--test_only=0" option.' . PHP_EOL;
			}
		}
		catch ( Exception $e )
		{
			$dbTrans->rollback();
			throw $e;
		}

	}

	public function actionExport()
	{

		if ( ! Yii::app()->db->schema instanceof CPgsqlSchema )
			throw new CException( 'Only Postgresql is currently supported for schema export.' );

		Yii::import( 'application.models.*' );

		$this->loadTables();	
		$this->loadEnums();

		$this->loadCreateTypes();

		$this->pgAddGetCreateTable();
		$this->loadCreateTables();

		$this->loadCreateViews();

		$sql = implode( PHP_EOL . PHP_EOL, $this->sql );
		$date = new DateTime();
		echo '--' . PHP_EOL;
		echo '-- OpenACH Schema Dump' . PHP_EOL;
		echo '-- ' . $date->format( 'Y-m-d H:i:s' ) . PHP_EOL;
		echo $this->sign( $sql );
		echo '-- ' . PHP_EOL. PHP_EOL;

		echo $sql;
	}

	protected function sign( $sql )
	{
		$hash = hash( 'md5', $sql );
		$signature = '-- Signature: ' . $hash . PHP_EOL;
		return $signature;
	}

	protected function addSql( $sql, $info )
	{
		
		$comment = '-- ' . $info . PHP_EOL;
		$comment .= $this->sign( $sql );
		$this->sql[] = $comment . PHP_EOL . $sql . PHP_EOL;
	}

	protected function loadCreateTypes()
	{
		foreach ( $this->enumList as $name => $values )
		{
			$this->addSql( "CREATE TYPE $name AS ENUM ( '" . implode( "','", $values ) . "');", 'Type: ' . $name );
		}
	}

	protected function loadTables()
	{
		foreach ( $this->modelList as $modelName )
		{
			$model = $modelName::model();
			$schema = $model->getTableSchema();
			$this->tableList[] = $schema->name;

			$behaviors = $model->behaviors();
			if ( isset( $behaviors['CActiveLogBehavior'] ) )
			{
				$this->tableList[] = $schema->name . '_log';
			}
		}

		$this->tableList = array_merge( $this->tableList, $this->additionalTables );
	}

	protected function loadEnums()
	{
		$sql = Yii::app()->db->createCommand()
			->select( 'pg_type.typname AS enumtype, pg_enum.enumlabel AS enumlabel' )
			->from( 'pg_type' );
		$sql->join( 'pg_enum', 'pg_enum.enumtypid = pg_type.oid' );

		$enums = $sql->query();

		foreach ( $enums as $enum )
		{
			$type = $enum['enumtype'];
			$label = $enum['enumlabel'];
			if ( isset( $this->enumList[ $type ] ) )
			{
				$this->enumList[ $type ][] = $label;
			}
			else
			{
				$this->enumList[ $type ] = array( $label );
			}
		}
	}

	protected function pgAddGetCreateTable()
	{
		$command = Yii::app()->db->createCommand("
CREATE OR REPLACE FUNCTION get_create_table(p_table_name varchar)
  RETURNS text AS
\$BODY\$
DECLARE
    v_table_ddl   text;
    column_record record;
BEGIN
    FOR column_record IN 
        SELECT 
            b.nspname as schema_name,
            b.relname as table_name,
            a.attname as column_name,
            pg_catalog.format_type(a.atttypid, a.atttypmod) as column_type,
            CASE WHEN 
                (SELECT substring(pg_catalog.pg_get_expr(d.adbin, d.adrelid) for 128)
                 FROM pg_catalog.pg_attrdef d
                 WHERE d.adrelid = a.attrelid AND d.adnum = a.attnum AND a.atthasdef) IS NOT NULL THEN
                'DEFAULT '|| (SELECT substring(pg_catalog.pg_get_expr(d.adbin, d.adrelid) for 128)
                              FROM pg_catalog.pg_attrdef d
                              WHERE d.adrelid = a.attrelid AND d.adnum = a.attnum AND a.atthasdef)
            ELSE
                ''
            END as column_default_value,
            CASE WHEN a.attnotnull = true THEN 
                'NOT NULL'
            ELSE
                'NULL'
            END as column_not_null,
            a.attnum as attnum,
            e.max_attnum as max_attnum
        FROM 
            pg_catalog.pg_attribute a
            INNER JOIN 
             (SELECT c.oid,
                n.nspname,
                c.relname
              FROM pg_catalog.pg_class c
                   LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
              WHERE c.relname ~ ('^('||p_table_name||')$')
                AND pg_catalog.pg_table_is_visible(c.oid)
              ORDER BY 2, 3) b
            ON a.attrelid = b.oid
            INNER JOIN 
             (SELECT 
                  a.attrelid,
                  max(a.attnum) as max_attnum
              FROM pg_catalog.pg_attribute a
              WHERE a.attnum > 0 
                AND NOT a.attisdropped
              GROUP BY a.attrelid) e
            ON a.attrelid=e.attrelid
        WHERE a.attnum > 0 
          AND NOT a.attisdropped
        ORDER BY a.attnum
    LOOP
        IF column_record.attnum = 1 THEN
            v_table_ddl:='CREATE TABLE '||column_record.schema_name||'.'||column_record.table_name||' ('||chr(10)||
                         '    '||column_record.column_name||' '||column_record.column_type||' '||column_record.column_default_value||' '||column_record.column_not_null;
        END IF;

        IF column_record.attnum < column_record.max_attnum THEN
            v_table_ddl:=v_table_ddl||','||chr(10)||
                         '    '||column_record.column_name||' '||column_record.column_type||' '||column_record.column_default_value||' '||column_record.column_not_null;
        ELSE
            v_table_ddl:=v_table_ddl||'\n);';
        END IF;
    END LOOP;

    RETURN v_table_ddl;
END;
\$BODY\$
  LANGUAGE 'plpgsql' COST 100.0 SECURITY INVOKER;
		");

		$command->execute();

	}

	protected function loadCreateTables()
	{
		$command = Yii::app()->db->createCommand('SELECT get_create_table( :table_name ) as sql');
		
		foreach ( $this->tableList as $table )
		{
			$result = $command->queryRow(true,array(':table_name'=>$table));
			
			$this->addSql( $result['sql'], 'Table: ' . $table );
		}
	}

	protected function loadCreateViews()
	{

		$command = Yii::app()->db->createCommand('SELECT pg_get_viewdef( :view_name, true ) as sql');

		foreach ( $this->viewList as $view )
		{
			$result = $command->queryRow(true,array(':view_name'=>$view));
			$this->addSql( "CREATE OR REPLACE VIEW $view AS " . PHP_EOL . $result['sql'], 'View: ' . $view );
		}

	}

}
