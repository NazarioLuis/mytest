<?php

namespace Base;

use \Alumno as ChildAlumno;
use \AlumnoQuery as ChildAlumnoQuery;
use \Carrera as ChildCarrera;
use \CarreraQuery as ChildCarreraQuery;
use \Examen as ChildExamen;
use \ExamenQuery as ChildExamenQuery;
use \Inscripcion as ChildInscripcion;
use \InscripcionQuery as ChildInscripcionQuery;
use \Periodo as ChildPeriodo;
use \PeriodoQuery as ChildPeriodoQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ExamenTableMap;
use Map\InscripcionTableMap;
use Map\PeriodoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'periodo' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class Periodo implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PeriodoTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * 
     * @var        int
     */
    protected $id;

    /**
     * The value for the car_id field.
     * 
     * @var        int
     */
    protected $car_id;

    /**
     * The value for the anio field.
     * 
     * @var        string
     */
    protected $anio;

    /**
     * The value for the periodo field.
     * 
     * @var        int
     */
    protected $periodo;

    /**
     * The value for the desde field.
     * 
     * @var        \DateTime
     */
    protected $desde;

    /**
     * The value for the hasta field.
     * 
     * @var        \DateTime
     */
    protected $hasta;

    /**
     * @var        ChildCarrera
     */
    protected $aCarrera;

    /**
     * @var        ObjectCollection|ChildExamen[] Collection to store aggregation of ChildExamen objects.
     */
    protected $collExamens;
    protected $collExamensPartial;

    /**
     * @var        ObjectCollection|ChildInscripcion[] Collection to store aggregation of ChildInscripcion objects.
     */
    protected $collInscripcions;
    protected $collInscripcionsPartial;

    /**
     * @var        ObjectCollection|ChildAlumno[] Cross Collection to store aggregation of ChildAlumno objects.
     */
    protected $collAlumnos;

    /**
     * @var bool
     */
    protected $collAlumnosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAlumno[]
     */
    protected $alumnosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExamen[]
     */
    protected $examensScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInscripcion[]
     */
    protected $inscripcionsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Periodo object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Periodo</code> instance.  If
     * <code>obj</code> is an instance of <code>Periodo</code>, delegates to
     * <code>equals(Periodo)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Periodo The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));
        
        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }
        
        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [car_id] column value.
     * 
     * @return int
     */
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * Get the [anio] column value.
     * 
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Get the [periodo] column value.
     * 
     * @return int
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Get the [optionally formatted] temporal [desde] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDesde($format = NULL)
    {
        if ($format === null) {
            return $this->desde;
        } else {
            return $this->desde instanceof \DateTime ? $this->desde->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [hasta] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHasta($format = NULL)
    {
        if ($format === null) {
            return $this->hasta;
        } else {
            return $this->hasta instanceof \DateTime ? $this->hasta->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PeriodoTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [car_id] column.
     * 
     * @param int $v new value
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function setCarId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->car_id !== $v) {
            $this->car_id = $v;
            $this->modifiedColumns[PeriodoTableMap::COL_CAR_ID] = true;
        }

        if ($this->aCarrera !== null && $this->aCarrera->getId() !== $v) {
            $this->aCarrera = null;
        }

        return $this;
    } // setCarId()

    /**
     * Set the value of [anio] column.
     * 
     * @param string $v new value
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function setAnio($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->anio !== $v) {
            $this->anio = $v;
            $this->modifiedColumns[PeriodoTableMap::COL_ANIO] = true;
        }

        return $this;
    } // setAnio()

    /**
     * Set the value of [periodo] column.
     * 
     * @param int $v new value
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function setPeriodo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->periodo !== $v) {
            $this->periodo = $v;
            $this->modifiedColumns[PeriodoTableMap::COL_PERIODO] = true;
        }

        return $this;
    } // setPeriodo()

    /**
     * Sets the value of [desde] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function setDesde($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->desde !== null || $dt !== null) {
            if ($this->desde === null || $dt === null || $dt->format("Y-m-d") !== $this->desde->format("Y-m-d")) {
                $this->desde = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PeriodoTableMap::COL_DESDE] = true;
            }
        } // if either are not null

        return $this;
    } // setDesde()

    /**
     * Sets the value of [hasta] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function setHasta($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->hasta !== null || $dt !== null) {
            if ($this->hasta === null || $dt === null || $dt->format("Y-m-d") !== $this->hasta->format("Y-m-d")) {
                $this->hasta = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PeriodoTableMap::COL_HASTA] = true;
            }
        } // if either are not null

        return $this;
    } // setHasta()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PeriodoTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PeriodoTableMap::translateFieldName('CarId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->car_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PeriodoTableMap::translateFieldName('Anio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anio = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PeriodoTableMap::translateFieldName('Periodo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->periodo = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PeriodoTableMap::translateFieldName('Desde', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->desde = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PeriodoTableMap::translateFieldName('Hasta', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->hasta = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = PeriodoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Periodo'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aCarrera !== null && $this->car_id !== $this->aCarrera->getId()) {
            $this->aCarrera = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PeriodoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPeriodoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCarrera = null;
            $this->collExamens = null;

            $this->collInscripcions = null;

            $this->collAlumnos = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Periodo::setDeleted()
     * @see Periodo::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PeriodoTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPeriodoQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PeriodoTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PeriodoTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCarrera !== null) {
                if ($this->aCarrera->isModified() || $this->aCarrera->isNew()) {
                    $affectedRows += $this->aCarrera->save($con);
                }
                $this->setCarrera($this->aCarrera);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->alumnosScheduledForDeletion !== null) {
                if (!$this->alumnosScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->alumnosScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \InscripcionQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->alumnosScheduledForDeletion = null;
                }

            }

            if ($this->collAlumnos) {
                foreach ($this->collAlumnos as $alumno) {
                    if (!$alumno->isDeleted() && ($alumno->isNew() || $alumno->isModified())) {
                        $alumno->save($con);
                    }
                }
            }


            if ($this->examensScheduledForDeletion !== null) {
                if (!$this->examensScheduledForDeletion->isEmpty()) {
                    \ExamenQuery::create()
                        ->filterByPrimaryKeys($this->examensScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->examensScheduledForDeletion = null;
                }
            }

            if ($this->collExamens !== null) {
                foreach ($this->collExamens as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->inscripcionsScheduledForDeletion !== null) {
                if (!$this->inscripcionsScheduledForDeletion->isEmpty()) {
                    \InscripcionQuery::create()
                        ->filterByPrimaryKeys($this->inscripcionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->inscripcionsScheduledForDeletion = null;
                }
            }

            if ($this->collInscripcions !== null) {
                foreach ($this->collInscripcions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PeriodoTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PeriodoTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PeriodoTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_CAR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'car_id';
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_ANIO)) {
            $modifiedColumns[':p' . $index++]  = 'anio';
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_PERIODO)) {
            $modifiedColumns[':p' . $index++]  = 'periodo';
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_DESDE)) {
            $modifiedColumns[':p' . $index++]  = 'desde';
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_HASTA)) {
            $modifiedColumns[':p' . $index++]  = 'hasta';
        }

        $sql = sprintf(
            'INSERT INTO periodo (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':                        
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'car_id':                        
                        $stmt->bindValue($identifier, $this->car_id, PDO::PARAM_INT);
                        break;
                    case 'anio':                        
                        $stmt->bindValue($identifier, $this->anio, PDO::PARAM_STR);
                        break;
                    case 'periodo':                        
                        $stmt->bindValue($identifier, $this->periodo, PDO::PARAM_INT);
                        break;
                    case 'desde':                        
                        $stmt->bindValue($identifier, $this->desde ? $this->desde->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'hasta':                        
                        $stmt->bindValue($identifier, $this->hasta ? $this->hasta->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PeriodoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getCarId();
                break;
            case 2:
                return $this->getAnio();
                break;
            case 3:
                return $this->getPeriodo();
                break;
            case 4:
                return $this->getDesde();
                break;
            case 5:
                return $this->getHasta();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Periodo'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Periodo'][$this->hashCode()] = true;
        $keys = PeriodoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCarId(),
            $keys[2] => $this->getAnio(),
            $keys[3] => $this->getPeriodo(),
            $keys[4] => $this->getDesde(),
            $keys[5] => $this->getHasta(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }
        
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aCarrera) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'carrera';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'carrera';
                        break;
                    default:
                        $key = 'Carrera';
                }
        
                $result[$key] = $this->aCarrera->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collExamens) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'examens';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'examens';
                        break;
                    default:
                        $key = 'Examens';
                }
        
                $result[$key] = $this->collExamens->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collInscripcions) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inscripcions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'inscripcions';
                        break;
                    default:
                        $key = 'Inscripcions';
                }
        
                $result[$key] = $this->collInscripcions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Periodo
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PeriodoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Periodo
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCarId($value);
                break;
            case 2:
                $this->setAnio($value);
                break;
            case 3:
                $this->setPeriodo($value);
                break;
            case 4:
                $this->setDesde($value);
                break;
            case 5:
                $this->setHasta($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PeriodoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCarId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAnio($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPeriodo($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDesde($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setHasta($arr[$keys[5]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Periodo The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PeriodoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PeriodoTableMap::COL_ID)) {
            $criteria->add(PeriodoTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_CAR_ID)) {
            $criteria->add(PeriodoTableMap::COL_CAR_ID, $this->car_id);
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_ANIO)) {
            $criteria->add(PeriodoTableMap::COL_ANIO, $this->anio);
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_PERIODO)) {
            $criteria->add(PeriodoTableMap::COL_PERIODO, $this->periodo);
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_DESDE)) {
            $criteria->add(PeriodoTableMap::COL_DESDE, $this->desde);
        }
        if ($this->isColumnModified(PeriodoTableMap::COL_HASTA)) {
            $criteria->add(PeriodoTableMap::COL_HASTA, $this->hasta);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPeriodoQuery::create();
        $criteria->add(PeriodoTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Periodo (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCarId($this->getCarId());
        $copyObj->setAnio($this->getAnio());
        $copyObj->setPeriodo($this->getPeriodo());
        $copyObj->setDesde($this->getDesde());
        $copyObj->setHasta($this->getHasta());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getExamens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExamen($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getInscripcions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInscripcion($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Periodo Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildCarrera object.
     *
     * @param  ChildCarrera $v
     * @return $this|\Periodo The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCarrera(ChildCarrera $v = null)
    {
        if ($v === null) {
            $this->setCarId(NULL);
        } else {
            $this->setCarId($v->getId());
        }

        $this->aCarrera = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCarrera object, it will not be re-added.
        if ($v !== null) {
            $v->addPeriodo($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCarrera object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCarrera The associated ChildCarrera object.
     * @throws PropelException
     */
    public function getCarrera(ConnectionInterface $con = null)
    {
        if ($this->aCarrera === null && ($this->car_id !== null)) {
            $this->aCarrera = ChildCarreraQuery::create()->findPk($this->car_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCarrera->addPeriodos($this);
             */
        }

        return $this->aCarrera;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Examen' == $relationName) {
            return $this->initExamens();
        }
        if ('Inscripcion' == $relationName) {
            return $this->initInscripcions();
        }
    }

    /**
     * Clears out the collExamens collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExamens()
     */
    public function clearExamens()
    {
        $this->collExamens = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExamens collection loaded partially.
     */
    public function resetPartialExamens($v = true)
    {
        $this->collExamensPartial = $v;
    }

    /**
     * Initializes the collExamens collection.
     *
     * By default this just sets the collExamens collection to an empty array (like clearcollExamens());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExamens($overrideExisting = true)
    {
        if (null !== $this->collExamens && !$overrideExisting) {
            return;
        }

        $collectionClassName = ExamenTableMap::getTableMap()->getCollectionClassName();

        $this->collExamens = new $collectionClassName;
        $this->collExamens->setModel('\Examen');
    }

    /**
     * Gets an array of ChildExamen objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPeriodo is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExamen[] List of ChildExamen objects
     * @throws PropelException
     */
    public function getExamens(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExamensPartial && !$this->isNew();
        if (null === $this->collExamens || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExamens) {
                // return empty collection
                $this->initExamens();
            } else {
                $collExamens = ChildExamenQuery::create(null, $criteria)
                    ->filterByPeriodo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExamensPartial && count($collExamens)) {
                        $this->initExamens(false);

                        foreach ($collExamens as $obj) {
                            if (false == $this->collExamens->contains($obj)) {
                                $this->collExamens->append($obj);
                            }
                        }

                        $this->collExamensPartial = true;
                    }

                    return $collExamens;
                }

                if ($partial && $this->collExamens) {
                    foreach ($this->collExamens as $obj) {
                        if ($obj->isNew()) {
                            $collExamens[] = $obj;
                        }
                    }
                }

                $this->collExamens = $collExamens;
                $this->collExamensPartial = false;
            }
        }

        return $this->collExamens;
    }

    /**
     * Sets a collection of ChildExamen objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $examens A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPeriodo The current object (for fluent API support)
     */
    public function setExamens(Collection $examens, ConnectionInterface $con = null)
    {
        /** @var ChildExamen[] $examensToDelete */
        $examensToDelete = $this->getExamens(new Criteria(), $con)->diff($examens);

        
        $this->examensScheduledForDeletion = $examensToDelete;

        foreach ($examensToDelete as $examenRemoved) {
            $examenRemoved->setPeriodo(null);
        }

        $this->collExamens = null;
        foreach ($examens as $examen) {
            $this->addExamen($examen);
        }

        $this->collExamens = $examens;
        $this->collExamensPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Examen objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Examen objects.
     * @throws PropelException
     */
    public function countExamens(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExamensPartial && !$this->isNew();
        if (null === $this->collExamens || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExamens) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExamens());
            }

            $query = ChildExamenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPeriodo($this)
                ->count($con);
        }

        return count($this->collExamens);
    }

    /**
     * Method called to associate a ChildExamen object to this object
     * through the ChildExamen foreign key attribute.
     *
     * @param  ChildExamen $l ChildExamen
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function addExamen(ChildExamen $l)
    {
        if ($this->collExamens === null) {
            $this->initExamens();
            $this->collExamensPartial = true;
        }

        if (!$this->collExamens->contains($l)) {
            $this->doAddExamen($l);

            if ($this->examensScheduledForDeletion and $this->examensScheduledForDeletion->contains($l)) {
                $this->examensScheduledForDeletion->remove($this->examensScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildExamen $examen The ChildExamen object to add.
     */
    protected function doAddExamen(ChildExamen $examen)
    {
        $this->collExamens[]= $examen;
        $examen->setPeriodo($this);
    }

    /**
     * @param  ChildExamen $examen The ChildExamen object to remove.
     * @return $this|ChildPeriodo The current object (for fluent API support)
     */
    public function removeExamen(ChildExamen $examen)
    {
        if ($this->getExamens()->contains($examen)) {
            $pos = $this->collExamens->search($examen);
            $this->collExamens->remove($pos);
            if (null === $this->examensScheduledForDeletion) {
                $this->examensScheduledForDeletion = clone $this->collExamens;
                $this->examensScheduledForDeletion->clear();
            }
            $this->examensScheduledForDeletion[]= clone $examen;
            $examen->setPeriodo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Periodo is new, it will return
     * an empty collection; or if this Periodo has previously
     * been saved, it will retrieve related Examens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Periodo.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamen[] List of ChildExamen objects
     */
    public function getExamensJoinMateria(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamenQuery::create(null, $criteria);
        $query->joinWith('Materia', $joinBehavior);

        return $this->getExamens($query, $con);
    }

    /**
     * Clears out the collInscripcions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInscripcions()
     */
    public function clearInscripcions()
    {
        $this->collInscripcions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInscripcions collection loaded partially.
     */
    public function resetPartialInscripcions($v = true)
    {
        $this->collInscripcionsPartial = $v;
    }

    /**
     * Initializes the collInscripcions collection.
     *
     * By default this just sets the collInscripcions collection to an empty array (like clearcollInscripcions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInscripcions($overrideExisting = true)
    {
        if (null !== $this->collInscripcions && !$overrideExisting) {
            return;
        }

        $collectionClassName = InscripcionTableMap::getTableMap()->getCollectionClassName();

        $this->collInscripcions = new $collectionClassName;
        $this->collInscripcions->setModel('\Inscripcion');
    }

    /**
     * Gets an array of ChildInscripcion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPeriodo is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInscripcion[] List of ChildInscripcion objects
     * @throws PropelException
     */
    public function getInscripcions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInscripcionsPartial && !$this->isNew();
        if (null === $this->collInscripcions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInscripcions) {
                // return empty collection
                $this->initInscripcions();
            } else {
                $collInscripcions = ChildInscripcionQuery::create(null, $criteria)
                    ->filterByPeriodo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInscripcionsPartial && count($collInscripcions)) {
                        $this->initInscripcions(false);

                        foreach ($collInscripcions as $obj) {
                            if (false == $this->collInscripcions->contains($obj)) {
                                $this->collInscripcions->append($obj);
                            }
                        }

                        $this->collInscripcionsPartial = true;
                    }

                    return $collInscripcions;
                }

                if ($partial && $this->collInscripcions) {
                    foreach ($this->collInscripcions as $obj) {
                        if ($obj->isNew()) {
                            $collInscripcions[] = $obj;
                        }
                    }
                }

                $this->collInscripcions = $collInscripcions;
                $this->collInscripcionsPartial = false;
            }
        }

        return $this->collInscripcions;
    }

    /**
     * Sets a collection of ChildInscripcion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inscripcions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPeriodo The current object (for fluent API support)
     */
    public function setInscripcions(Collection $inscripcions, ConnectionInterface $con = null)
    {
        /** @var ChildInscripcion[] $inscripcionsToDelete */
        $inscripcionsToDelete = $this->getInscripcions(new Criteria(), $con)->diff($inscripcions);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->inscripcionsScheduledForDeletion = clone $inscripcionsToDelete;

        foreach ($inscripcionsToDelete as $inscripcionRemoved) {
            $inscripcionRemoved->setPeriodo(null);
        }

        $this->collInscripcions = null;
        foreach ($inscripcions as $inscripcion) {
            $this->addInscripcion($inscripcion);
        }

        $this->collInscripcions = $inscripcions;
        $this->collInscripcionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Inscripcion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Inscripcion objects.
     * @throws PropelException
     */
    public function countInscripcions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInscripcionsPartial && !$this->isNew();
        if (null === $this->collInscripcions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInscripcions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInscripcions());
            }

            $query = ChildInscripcionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPeriodo($this)
                ->count($con);
        }

        return count($this->collInscripcions);
    }

    /**
     * Method called to associate a ChildInscripcion object to this object
     * through the ChildInscripcion foreign key attribute.
     *
     * @param  ChildInscripcion $l ChildInscripcion
     * @return $this|\Periodo The current object (for fluent API support)
     */
    public function addInscripcion(ChildInscripcion $l)
    {
        if ($this->collInscripcions === null) {
            $this->initInscripcions();
            $this->collInscripcionsPartial = true;
        }

        if (!$this->collInscripcions->contains($l)) {
            $this->doAddInscripcion($l);

            if ($this->inscripcionsScheduledForDeletion and $this->inscripcionsScheduledForDeletion->contains($l)) {
                $this->inscripcionsScheduledForDeletion->remove($this->inscripcionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInscripcion $inscripcion The ChildInscripcion object to add.
     */
    protected function doAddInscripcion(ChildInscripcion $inscripcion)
    {
        $this->collInscripcions[]= $inscripcion;
        $inscripcion->setPeriodo($this);
    }

    /**
     * @param  ChildInscripcion $inscripcion The ChildInscripcion object to remove.
     * @return $this|ChildPeriodo The current object (for fluent API support)
     */
    public function removeInscripcion(ChildInscripcion $inscripcion)
    {
        if ($this->getInscripcions()->contains($inscripcion)) {
            $pos = $this->collInscripcions->search($inscripcion);
            $this->collInscripcions->remove($pos);
            if (null === $this->inscripcionsScheduledForDeletion) {
                $this->inscripcionsScheduledForDeletion = clone $this->collInscripcions;
                $this->inscripcionsScheduledForDeletion->clear();
            }
            $this->inscripcionsScheduledForDeletion[]= clone $inscripcion;
            $inscripcion->setPeriodo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Periodo is new, it will return
     * an empty collection; or if this Periodo has previously
     * been saved, it will retrieve related Inscripcions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Periodo.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInscripcion[] List of ChildInscripcion objects
     */
    public function getInscripcionsJoinAlumno(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInscripcionQuery::create(null, $criteria);
        $query->joinWith('Alumno', $joinBehavior);

        return $this->getInscripcions($query, $con);
    }

    /**
     * Clears out the collAlumnos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAlumnos()
     */
    public function clearAlumnos()
    {
        $this->collAlumnos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collAlumnos crossRef collection.
     *
     * By default this just sets the collAlumnos collection to an empty collection (like clearAlumnos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initAlumnos()
    {
        $collectionClassName = InscripcionTableMap::getTableMap()->getCollectionClassName();

        $this->collAlumnos = new $collectionClassName;
        $this->collAlumnosPartial = true;
        $this->collAlumnos->setModel('\Alumno');
    }

    /**
     * Checks if the collAlumnos collection is loaded.
     *
     * @return bool
     */
    public function isAlumnosLoaded()
    {
        return null !== $this->collAlumnos;
    }

    /**
     * Gets a collection of ChildAlumno objects related by a many-to-many relationship
     * to the current object by way of the inscripcion cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPeriodo is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildAlumno[] List of ChildAlumno objects
     */
    public function getAlumnos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAlumnosPartial && !$this->isNew();
        if (null === $this->collAlumnos || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAlumnos) {
                    $this->initAlumnos();
                }
            } else {

                $query = ChildAlumnoQuery::create(null, $criteria)
                    ->filterByPeriodo($this);
                $collAlumnos = $query->find($con);
                if (null !== $criteria) {
                    return $collAlumnos;
                }

                if ($partial && $this->collAlumnos) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collAlumnos as $obj) {
                        if (!$collAlumnos->contains($obj)) {
                            $collAlumnos[] = $obj;
                        }
                    }
                }

                $this->collAlumnos = $collAlumnos;
                $this->collAlumnosPartial = false;
            }
        }

        return $this->collAlumnos;
    }

    /**
     * Sets a collection of Alumno objects related by a many-to-many relationship
     * to the current object by way of the inscripcion cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $alumnos A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPeriodo The current object (for fluent API support)
     */
    public function setAlumnos(Collection $alumnos, ConnectionInterface $con = null)
    {
        $this->clearAlumnos();
        $currentAlumnos = $this->getAlumnos();

        $alumnosScheduledForDeletion = $currentAlumnos->diff($alumnos);

        foreach ($alumnosScheduledForDeletion as $toDelete) {
            $this->removeAlumno($toDelete);
        }

        foreach ($alumnos as $alumno) {
            if (!$currentAlumnos->contains($alumno)) {
                $this->doAddAlumno($alumno);
            }
        }

        $this->collAlumnosPartial = false;
        $this->collAlumnos = $alumnos;

        return $this;
    }

    /**
     * Gets the number of Alumno objects related by a many-to-many relationship
     * to the current object by way of the inscripcion cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Alumno objects
     */
    public function countAlumnos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAlumnosPartial && !$this->isNew();
        if (null === $this->collAlumnos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAlumnos) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getAlumnos());
                }

                $query = ChildAlumnoQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPeriodo($this)
                    ->count($con);
            }
        } else {
            return count($this->collAlumnos);
        }
    }

    /**
     * Associate a ChildAlumno to this object
     * through the inscripcion cross reference table.
     * 
     * @param ChildAlumno $alumno
     * @return ChildPeriodo The current object (for fluent API support)
     */
    public function addAlumno(ChildAlumno $alumno)
    {
        if ($this->collAlumnos === null) {
            $this->initAlumnos();
        }

        if (!$this->getAlumnos()->contains($alumno)) {
            // only add it if the **same** object is not already associated
            $this->collAlumnos->push($alumno);
            $this->doAddAlumno($alumno);
        }

        return $this;
    }

    /**
     * 
     * @param ChildAlumno $alumno
     */
    protected function doAddAlumno(ChildAlumno $alumno)
    {
        $inscripcion = new ChildInscripcion();

        $inscripcion->setAlumno($alumno);

        $inscripcion->setPeriodo($this);

        $this->addInscripcion($inscripcion);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$alumno->isPeriodosLoaded()) {
            $alumno->initPeriodos();
            $alumno->getPeriodos()->push($this);
        } elseif (!$alumno->getPeriodos()->contains($this)) {
            $alumno->getPeriodos()->push($this);
        }

    }

    /**
     * Remove alumno of this object
     * through the inscripcion cross reference table.
     * 
     * @param ChildAlumno $alumno
     * @return ChildPeriodo The current object (for fluent API support)
     */
    public function removeAlumno(ChildAlumno $alumno)
    {
        if ($this->getAlumnos()->contains($alumno)) { $inscripcion = new ChildInscripcion();

            $inscripcion->setAlumno($alumno);
            if ($alumno->isPeriodosLoaded()) {
                //remove the back reference if available
                $alumno->getPeriodos()->removeObject($this);
            }

            $inscripcion->setPeriodo($this);
            $this->removeInscripcion(clone $inscripcion);
            $inscripcion->clear();

            $this->collAlumnos->remove($this->collAlumnos->search($alumno));
            
            if (null === $this->alumnosScheduledForDeletion) {
                $this->alumnosScheduledForDeletion = clone $this->collAlumnos;
                $this->alumnosScheduledForDeletion->clear();
            }

            $this->alumnosScheduledForDeletion->push($alumno);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCarrera) {
            $this->aCarrera->removePeriodo($this);
        }
        $this->id = null;
        $this->car_id = null;
        $this->anio = null;
        $this->periodo = null;
        $this->desde = null;
        $this->hasta = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collExamens) {
                foreach ($this->collExamens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInscripcions) {
                foreach ($this->collInscripcions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAlumnos) {
                foreach ($this->collAlumnos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collExamens = null;
        $this->collInscripcions = null;
        $this->collAlumnos = null;
        $this->aCarrera = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PeriodoTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
