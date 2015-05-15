<?php



class MlmUploadMaterialMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MlmUploadMaterialMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('mlm_upload_material');
		$tMap->setPhpName('MlmUploadMaterial');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('FILE_NAME', 'FileName', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('FILE_NAME_SERVER', 'FileNameServer', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('FILE_EXT', 'FileExt', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('FILE_THUMBNAIL', 'FileThumbnail', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('FILE_SIZE', 'FileSize', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('STATUS_CODE', 'StatusCode', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('CREATED_ON', 'CreatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('UPDATED_ON', 'UpdatedOn', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 