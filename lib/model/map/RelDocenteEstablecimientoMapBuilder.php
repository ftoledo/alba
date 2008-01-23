<?php



class RelDocenteEstablecimientoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.RelDocenteEstablecimientoMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap('alba');

		$tMap = $this->dbMap->addTable('rel_docente_establecimiento');
		$tMap->setPhpName('RelDocenteEstablecimiento');

		$tMap->setUseIdGenerator(true);

		$tMap->addForeignKey('FK_ESTABLECIMIENTO_ID', 'FkEstablecimientoId', 'int', CreoleTypes::INTEGER, 'establecimiento', 'ID', true, 11);

		$tMap->addForeignKey('FK_DOCENTE_ID', 'FkDocenteId', 'int', CreoleTypes::INTEGER, 'docente', 'ID', true, 11);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 