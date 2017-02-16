<?php
/**
 * Fextures generator
 * @author denis <thebucefal@gmail.com>
 * @link https://bitbucket.org/BuCeFaL/ext4yii/src
 */
class FixtureCode extends CCodeModel
{
	public $modelPath   = 'application.models';
	public $fixturePath = 'application.tests.fixtures';
	
	public $rowsLimit   = null;
	
	protected $_models = array();
	
	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('modelPath, fixturePath', 'filter', 'filter'=>'trim'),
			array('modelPath, fixturePath', 'required'),
			array('rowsLimit', 'numerical','allowEmpty' => true),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'modelPath'=>'Models Path',
			'fixturePath'=>'Fixtures Path',
		));
	}
	/**
	 * @see CCodeModel::requiredTemplates()
	 */
	public function requiredTemplates()
	{
		return array(
			'fixture.php'
		);
	}
	/**
	 * @see CCodeModel::prepare()
	 */
	public function prepare()
	{
		Yii::import($this->modelPath);
		$path  = Yii::getPathOfAlias($this->modelPath);
		$this->scandir($path);
		$templatePath = Yii::getPathOfAlias('application.gii.fixture.templates.default');
		$tableNames = array();
		foreach ($this->_models as $modelName){
			$class     = pathinfo($modelName,PATHINFO_FILENAME);
			if (! $class )
				continue;
			$obj       = new $class;
			if($obj instanceof CActiveRecord){
				$tableName    = $obj->tableName();
				$writeTo = Yii::getPathOfAlias($this->fixturePath).DIRECTORY_SEPARATOR.$obj->tableName().'.php';
				if(!in_array($tableName, $tableNames) && !file_exists($writeTo)){
					$tableNames[] = $tableName;
					if(!empty($this->rowsLimit)){
						$criteria        = new CDbCriteria();
						$criteria->limit = intval($this->rowsLimit);
						
						$models = $obj->findAll($criteria);
					}else
						$models = $obj->findAll();
					if(isset($models))
						$this->files[] = new CCodeFile(
								$writeTo,
								$this->render($templatePath . DIRECTORY_SEPARATOR . 'fixture.php', array('models' => $models))
							);
				}
			}
		}
	}
	/**
	 * Scan directory and sub directory
	 * @param string $path
	 */
	protected function scanDir($path){
		foreach (scandir($path) as $file)
			if('.' !== $file && '..' !== $file)
				if(is_file($filename = $path . DIRECTORY_SEPARATOR . $file) && 'php' === pathinfo($file,PATHINFO_EXTENSION))
					$this->_models[] = $file;
				else if(is_dir($filename)){
					Yii::import($this->modelPath . '.' . $file . '.*');
					$this->scanDir($filename);
				}
	}
}
