<?php


abstract class BaseConceptobaja extends BaseObject  implements Persistent {


  const PEER = 'ConceptobajaPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $nombre;

	
	protected $descripcion;

	
	protected $collAlumnos;

	
	private $lastAlumnoCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
	}

	
	public function getId()
	{
		return $this->id;
	}

	
	public function getNombre()
	{
		return $this->nombre;
	}

	
	public function getDescripcion()
	{
		return $this->descripcion;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ConceptobajaPeer::ID;
		}

		return $this;
	} 
	
	public function setNombre($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nombre !== $v) {
			$this->nombre = $v;
			$this->modifiedColumns[] = ConceptobajaPeer::NOMBRE;
		}

		return $this;
	} 
	
	public function setDescripcion($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->descripcion !== $v) {
			$this->descripcion = $v;
			$this->modifiedColumns[] = ConceptobajaPeer::DESCRIPCION;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array())) {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->nombre = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->descripcion = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Conceptobaja object", $e);
		}
	}

	
	public function ensureConsistency()
	{

	} 
	
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ConceptobajaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = ConceptobajaPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->collAlumnos = null;
			$this->lastAlumnoCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ConceptobajaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			ConceptobajaPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ConceptobajaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			ConceptobajaPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = ConceptobajaPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ConceptobajaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ConceptobajaPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collAlumnos !== null) {
				foreach ($this->collAlumnos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = ConceptobajaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collAlumnos !== null) {
					foreach ($this->collAlumnos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ConceptobajaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getNombre();
				break;
			case 2:
				return $this->getDescripcion();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = ConceptobajaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getNombre(),
			$keys[2] => $this->getDescripcion(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ConceptobajaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setNombre($value);
				break;
			case 2:
				$this->setDescripcion($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ConceptobajaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNombre($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescripcion($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);

		if ($this->isColumnModified(ConceptobajaPeer::ID)) $criteria->add(ConceptobajaPeer::ID, $this->id);
		if ($this->isColumnModified(ConceptobajaPeer::NOMBRE)) $criteria->add(ConceptobajaPeer::NOMBRE, $this->nombre);
		if ($this->isColumnModified(ConceptobajaPeer::DESCRIPCION)) $criteria->add(ConceptobajaPeer::DESCRIPCION, $this->descripcion);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);

		$criteria->add(ConceptobajaPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNombre($this->nombre);

		$copyObj->setDescripcion($this->descripcion);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getAlumnos() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addAlumno($relObj->copy($deepCopy));
				}
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ConceptobajaPeer();
		}
		return self::$peer;
	}

	
	public function clearAlumnos()
	{
		$this->collAlumnos = null; 	}

	
	public function initAlumnos()
	{
		$this->collAlumnos = array();
	}

	
	public function getAlumnos($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
			   $this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				AlumnoPeer::addSelectColumns($criteria);
				$this->collAlumnos = AlumnoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				AlumnoPeer::addSelectColumns($criteria);
				if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
					$this->collAlumnos = AlumnoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAlumnoCriteria = $criteria;
		return $this->collAlumnos;
	}

	
	public function countAlumnos(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$count = AlumnoPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
					$count = AlumnoPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collAlumnos);
				}
			} else {
				$count = count($this->collAlumnos);
			}
		}
		return $count;
	}

	
	public function addAlumno(Alumno $l)
	{
		if ($this->collAlumnos === null) {
			$this->initAlumnos();
		}
		if (!in_array($l, $this->collAlumnos, true)) { 			array_push($this->collAlumnos, $l);
			$l->setConceptobaja($this);
		}
	}


	
	public function getAlumnosJoinProvincia($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$this->collAlumnos = AlumnoPeer::doSelectJoinProvincia($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

			if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
				$this->collAlumnos = AlumnoPeer::doSelectJoinProvincia($criteria, $con, $join_behavior);
			}
		}
		$this->lastAlumnoCriteria = $criteria;

		return $this->collAlumnos;
	}


	
	public function getAlumnosJoinTipodocumento($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$this->collAlumnos = AlumnoPeer::doSelectJoinTipodocumento($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

			if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
				$this->collAlumnos = AlumnoPeer::doSelectJoinTipodocumento($criteria, $con, $join_behavior);
			}
		}
		$this->lastAlumnoCriteria = $criteria;

		return $this->collAlumnos;
	}


	
	public function getAlumnosJoinEstablecimiento($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$this->collAlumnos = AlumnoPeer::doSelectJoinEstablecimiento($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

			if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
				$this->collAlumnos = AlumnoPeer::doSelectJoinEstablecimiento($criteria, $con, $join_behavior);
			}
		}
		$this->lastAlumnoCriteria = $criteria;

		return $this->collAlumnos;
	}


	
	public function getAlumnosJoinCuenta($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$this->collAlumnos = AlumnoPeer::doSelectJoinCuenta($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

			if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
				$this->collAlumnos = AlumnoPeer::doSelectJoinCuenta($criteria, $con, $join_behavior);
			}
		}
		$this->lastAlumnoCriteria = $criteria;

		return $this->collAlumnos;
	}


	
	public function getAlumnosJoinPais($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$this->collAlumnos = AlumnoPeer::doSelectJoinPais($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

			if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
				$this->collAlumnos = AlumnoPeer::doSelectJoinPais($criteria, $con, $join_behavior);
			}
		}
		$this->lastAlumnoCriteria = $criteria;

		return $this->collAlumnos;
	}


	
	public function getAlumnosJoinEstadosalumnos($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptobajaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlumnos === null) {
			if ($this->isNew()) {
				$this->collAlumnos = array();
			} else {

				$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

				$this->collAlumnos = AlumnoPeer::doSelectJoinEstadosalumnos($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AlumnoPeer::FK_CONCEPTOBAJA_ID, $this->id);

			if (!isset($this->lastAlumnoCriteria) || !$this->lastAlumnoCriteria->equals($criteria)) {
				$this->collAlumnos = AlumnoPeer::doSelectJoinEstadosalumnos($criteria, $con, $join_behavior);
			}
		}
		$this->lastAlumnoCriteria = $criteria;

		return $this->collAlumnos;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collAlumnos) {
				foreach ((array) $this->collAlumnos as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collAlumnos = null;
	}

} 