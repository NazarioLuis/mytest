<?php

namespace Base;

use \Examen as ChildExamen;
use \ExamenQuery as ChildExamenQuery;
use \Materia as ChildMateria;
use \MateriaQuery as ChildMateriaQuery;
use \Periodo as ChildPeriodo;
use \PeriodoQuery as ChildPeriodoQuery;
use \Pregunta as ChildPregunta;
use \PreguntaQuery as ChildPreguntaQuery;
use \Resultado as ChildResultado;
use \ResultadoQuery as ChildResultadoQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ExamenTableMap;
use Map\PreguntaTableMap;
use Map\ResultadoTableMap;
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
 * Base class that represents a row from the 'examen' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class Examen implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ExamenTableMap';


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
     * The value for the mat_id field.
     * 
     * @var        int
     */
    protected $mat_id;

    /**
     * The value for the per_id field.
     * 
     * @var        int
     */
    protected $per_id;

    /**
     * The value for the fecha field.
     * 
     * @var        \DateTime
     */
    protected $fecha;

    /**
     * The value for the formativa field.
     * 
     * @var        boolean
     */
    protected $formativa;

    /**
     * @var        ChildMateria
     */
    protected $aMateria;

    /**
     * @var        ChildPeriodo
     */
    protected $aPeriodo;

    /**
     * @var        ObjectCollection|ChildPregunta[] Collection to store aggregation of ChildPregunta objects.
     */
    protected $collPreguntas;
    protected $collPreguntasPartial;

    /**
     * @var        ObjectCollection|ChildResultado[] Collection to store aggregation of ChildResultado objects.
     */
    protected $collResultados;
    protected $collResultadosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPregunta[]
     */
    protected $preguntasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildResultado[]
     */
    protected $resultadosScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Examen object.
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
     * Compares this with another <code>Examen</code> instance.  If
     * <code>obj</code> is an instance of <code>Examen</code>, delegates to
     * <code>equals(Examen)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Examen The current object, for fluid interface
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
     * Get the [mat_id] column value.
     * 
     * @return int
     */
    public function getMatId()
    {
        return $this->mat_id;
    }

    /**
     * Get the [per_id] column value.
     * 
     * @return int
     */
    public function getPerId()
    {
        return $this->per_id;
    }

    /**
     * Get the [optionally formatted] temporal [fecha] column value.
     * 
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFecha($format = NULL)
    {
        if ($format === null) {
            return $this->fecha;
        } else {
            return $this->fecha instanceof \DateTime ? $this->fecha->format($format) : null;
        }
    }

    /**
     * Get the [formativa] column value.
     * 
     * @return boolean
     */
    public function getFormativa()
    {
        return $this->formativa;
    }

    /**
     * Get the [formativa] column value.
     * 
     * @return boolean
     */
    public function isFormativa()
    {
        return $this->getFormativa();
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ExamenTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [mat_id] column.
     * 
     * @param int $v new value
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function setMatId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->mat_id !== $v) {
            $this->mat_id = $v;
            $this->modifiedColumns[ExamenTableMap::COL_MAT_ID] = true;
        }

        if ($this->aMateria !== null && $this->aMateria->getId() !== $v) {
            $this->aMateria = null;
        }

        return $this;
    } // setMatId()

    /**
     * Set the value of [per_id] column.
     * 
     * @param int $v new value
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function setPerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->per_id !== $v) {
            $this->per_id = $v;
            $this->modifiedColumns[ExamenTableMap::COL_PER_ID] = true;
        }

        if ($this->aPeriodo !== null && $this->aPeriodo->getId() !== $v) {
            $this->aPeriodo = null;
        }

        return $this;
    } // setPerId()

    /**
     * Sets the value of [fecha] column to a normalized version of the date/time value specified.
     * 
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function setFecha($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->fecha !== null || $dt !== null) {
            if ($this->fecha === null || $dt === null || $dt->format("Y-m-d") !== $this->fecha->format("Y-m-d")) {
                $this->fecha = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ExamenTableMap::COL_FECHA] = true;
            }
        } // if either are not null

        return $this;
    } // setFecha()

    /**
     * Sets the value of the [formativa] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * 
     * @param  boolean|integer|string $v The new value
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function setFormativa($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->formativa !== $v) {
            $this->formativa = $v;
            $this->modifiedColumns[ExamenTableMap::COL_FORMATIVA] = true;
        }

        return $this;
    } // setFormativa()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ExamenTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ExamenTableMap::translateFieldName('MatId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mat_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ExamenTableMap::translateFieldName('PerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->per_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ExamenTableMap::translateFieldName('Fecha', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->fecha = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ExamenTableMap::translateFieldName('Formativa', TableMap::TYPE_PHPNAME, $indexType)];
            $this->formativa = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ExamenTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Examen'), 0, $e);
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
        if ($this->aMateria !== null && $this->mat_id !== $this->aMateria->getId()) {
            $this->aMateria = null;
        }
        if ($this->aPeriodo !== null && $this->per_id !== $this->aPeriodo->getId()) {
            $this->aPeriodo = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ExamenTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildExamenQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMateria = null;
            $this->aPeriodo = null;
            $this->collPreguntas = null;

            $this->collResultados = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Examen::setDeleted()
     * @see Examen::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamenTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildExamenQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ExamenTableMap::DATABASE_NAME);
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
                ExamenTableMap::addInstanceToPool($this);
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

            if ($this->aMateria !== null) {
                if ($this->aMateria->isModified() || $this->aMateria->isNew()) {
                    $affectedRows += $this->aMateria->save($con);
                }
                $this->setMateria($this->aMateria);
            }

            if ($this->aPeriodo !== null) {
                if ($this->aPeriodo->isModified() || $this->aPeriodo->isNew()) {
                    $affectedRows += $this->aPeriodo->save($con);
                }
                $this->setPeriodo($this->aPeriodo);
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

            if ($this->preguntasScheduledForDeletion !== null) {
                if (!$this->preguntasScheduledForDeletion->isEmpty()) {
                    \PreguntaQuery::create()
                        ->filterByPrimaryKeys($this->preguntasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->preguntasScheduledForDeletion = null;
                }
            }

            if ($this->collPreguntas !== null) {
                foreach ($this->collPreguntas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->resultadosScheduledForDeletion !== null) {
                if (!$this->resultadosScheduledForDeletion->isEmpty()) {
                    \ResultadoQuery::create()
                        ->filterByPrimaryKeys($this->resultadosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->resultadosScheduledForDeletion = null;
                }
            }

            if ($this->collResultados !== null) {
                foreach ($this->collResultados as $referrerFK) {
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

        $this->modifiedColumns[ExamenTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ExamenTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ExamenTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ExamenTableMap::COL_MAT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'mat_id';
        }
        if ($this->isColumnModified(ExamenTableMap::COL_PER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'per_id';
        }
        if ($this->isColumnModified(ExamenTableMap::COL_FECHA)) {
            $modifiedColumns[':p' . $index++]  = 'fecha';
        }
        if ($this->isColumnModified(ExamenTableMap::COL_FORMATIVA)) {
            $modifiedColumns[':p' . $index++]  = 'formativa';
        }

        $sql = sprintf(
            'INSERT INTO examen (%s) VALUES (%s)',
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
                    case 'mat_id':                        
                        $stmt->bindValue($identifier, $this->mat_id, PDO::PARAM_INT);
                        break;
                    case 'per_id':                        
                        $stmt->bindValue($identifier, $this->per_id, PDO::PARAM_INT);
                        break;
                    case 'fecha':                        
                        $stmt->bindValue($identifier, $this->fecha ? $this->fecha->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'formativa':
                        $stmt->bindValue($identifier, (int) $this->formativa, PDO::PARAM_INT);
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
        $pos = ExamenTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getMatId();
                break;
            case 2:
                return $this->getPerId();
                break;
            case 3:
                return $this->getFecha();
                break;
            case 4:
                return $this->getFormativa();
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

        if (isset($alreadyDumpedObjects['Examen'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Examen'][$this->hashCode()] = true;
        $keys = ExamenTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getMatId(),
            $keys[2] => $this->getPerId(),
            $keys[3] => $this->getFecha(),
            $keys[4] => $this->getFormativa(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }
        
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aMateria) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'materia';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'materia';
                        break;
                    default:
                        $key = 'Materia';
                }
        
                $result[$key] = $this->aMateria->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPeriodo) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'periodo';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'periodo';
                        break;
                    default:
                        $key = 'Periodo';
                }
        
                $result[$key] = $this->aPeriodo->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPreguntas) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'preguntas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'preguntas';
                        break;
                    default:
                        $key = 'Preguntas';
                }
        
                $result[$key] = $this->collPreguntas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collResultados) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'resultados';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'resultados';
                        break;
                    default:
                        $key = 'Resultados';
                }
        
                $result[$key] = $this->collResultados->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Examen
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ExamenTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Examen
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setMatId($value);
                break;
            case 2:
                $this->setPerId($value);
                break;
            case 3:
                $this->setFecha($value);
                break;
            case 4:
                $this->setFormativa($value);
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
        $keys = ExamenTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setMatId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPerId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFecha($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFormativa($arr[$keys[4]]);
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
     * @return $this|\Examen The current object, for fluid interface
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
        $criteria = new Criteria(ExamenTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ExamenTableMap::COL_ID)) {
            $criteria->add(ExamenTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ExamenTableMap::COL_MAT_ID)) {
            $criteria->add(ExamenTableMap::COL_MAT_ID, $this->mat_id);
        }
        if ($this->isColumnModified(ExamenTableMap::COL_PER_ID)) {
            $criteria->add(ExamenTableMap::COL_PER_ID, $this->per_id);
        }
        if ($this->isColumnModified(ExamenTableMap::COL_FECHA)) {
            $criteria->add(ExamenTableMap::COL_FECHA, $this->fecha);
        }
        if ($this->isColumnModified(ExamenTableMap::COL_FORMATIVA)) {
            $criteria->add(ExamenTableMap::COL_FORMATIVA, $this->formativa);
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
        $criteria = ChildExamenQuery::create();
        $criteria->add(ExamenTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Examen (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMatId($this->getMatId());
        $copyObj->setPerId($this->getPerId());
        $copyObj->setFecha($this->getFecha());
        $copyObj->setFormativa($this->getFormativa());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPreguntas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPregunta($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getResultados() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addResultado($relObj->copy($deepCopy));
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
     * @return \Examen Clone of current object.
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
     * Declares an association between this object and a ChildMateria object.
     *
     * @param  ChildMateria $v
     * @return $this|\Examen The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMateria(ChildMateria $v = null)
    {
        if ($v === null) {
            $this->setMatId(NULL);
        } else {
            $this->setMatId($v->getId());
        }

        $this->aMateria = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMateria object, it will not be re-added.
        if ($v !== null) {
            $v->addExamen($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMateria object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMateria The associated ChildMateria object.
     * @throws PropelException
     */
    public function getMateria(ConnectionInterface $con = null)
    {
        if ($this->aMateria === null && ($this->mat_id !== null)) {
            $this->aMateria = ChildMateriaQuery::create()->findPk($this->mat_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMateria->addExamens($this);
             */
        }

        return $this->aMateria;
    }

    /**
     * Declares an association between this object and a ChildPeriodo object.
     *
     * @param  ChildPeriodo $v
     * @return $this|\Examen The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPeriodo(ChildPeriodo $v = null)
    {
        if ($v === null) {
            $this->setPerId(NULL);
        } else {
            $this->setPerId($v->getId());
        }

        $this->aPeriodo = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPeriodo object, it will not be re-added.
        if ($v !== null) {
            $v->addExamen($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPeriodo object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPeriodo The associated ChildPeriodo object.
     * @throws PropelException
     */
    public function getPeriodo(ConnectionInterface $con = null)
    {
        if ($this->aPeriodo === null && ($this->per_id !== null)) {
            $this->aPeriodo = ChildPeriodoQuery::create()->findPk($this->per_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPeriodo->addExamens($this);
             */
        }

        return $this->aPeriodo;
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
        if ('Pregunta' == $relationName) {
            return $this->initPreguntas();
        }
        if ('Resultado' == $relationName) {
            return $this->initResultados();
        }
    }

    /**
     * Clears out the collPreguntas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPreguntas()
     */
    public function clearPreguntas()
    {
        $this->collPreguntas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPreguntas collection loaded partially.
     */
    public function resetPartialPreguntas($v = true)
    {
        $this->collPreguntasPartial = $v;
    }

    /**
     * Initializes the collPreguntas collection.
     *
     * By default this just sets the collPreguntas collection to an empty array (like clearcollPreguntas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPreguntas($overrideExisting = true)
    {
        if (null !== $this->collPreguntas && !$overrideExisting) {
            return;
        }

        $collectionClassName = PreguntaTableMap::getTableMap()->getCollectionClassName();

        $this->collPreguntas = new $collectionClassName;
        $this->collPreguntas->setModel('\Pregunta');
    }

    /**
     * Gets an array of ChildPregunta objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExamen is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPregunta[] List of ChildPregunta objects
     * @throws PropelException
     */
    public function getPreguntas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPreguntasPartial && !$this->isNew();
        if (null === $this->collPreguntas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPreguntas) {
                // return empty collection
                $this->initPreguntas();
            } else {
                $collPreguntas = ChildPreguntaQuery::create(null, $criteria)
                    ->filterByExamen($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPreguntasPartial && count($collPreguntas)) {
                        $this->initPreguntas(false);

                        foreach ($collPreguntas as $obj) {
                            if (false == $this->collPreguntas->contains($obj)) {
                                $this->collPreguntas->append($obj);
                            }
                        }

                        $this->collPreguntasPartial = true;
                    }

                    return $collPreguntas;
                }

                if ($partial && $this->collPreguntas) {
                    foreach ($this->collPreguntas as $obj) {
                        if ($obj->isNew()) {
                            $collPreguntas[] = $obj;
                        }
                    }
                }

                $this->collPreguntas = $collPreguntas;
                $this->collPreguntasPartial = false;
            }
        }

        return $this->collPreguntas;
    }

    /**
     * Sets a collection of ChildPregunta objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $preguntas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExamen The current object (for fluent API support)
     */
    public function setPreguntas(Collection $preguntas, ConnectionInterface $con = null)
    {
        /** @var ChildPregunta[] $preguntasToDelete */
        $preguntasToDelete = $this->getPreguntas(new Criteria(), $con)->diff($preguntas);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->preguntasScheduledForDeletion = clone $preguntasToDelete;

        foreach ($preguntasToDelete as $preguntaRemoved) {
            $preguntaRemoved->setExamen(null);
        }

        $this->collPreguntas = null;
        foreach ($preguntas as $pregunta) {
            $this->addPregunta($pregunta);
        }

        $this->collPreguntas = $preguntas;
        $this->collPreguntasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pregunta objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pregunta objects.
     * @throws PropelException
     */
    public function countPreguntas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPreguntasPartial && !$this->isNew();
        if (null === $this->collPreguntas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPreguntas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPreguntas());
            }

            $query = ChildPreguntaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByExamen($this)
                ->count($con);
        }

        return count($this->collPreguntas);
    }

    /**
     * Method called to associate a ChildPregunta object to this object
     * through the ChildPregunta foreign key attribute.
     *
     * @param  ChildPregunta $l ChildPregunta
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function addPregunta(ChildPregunta $l)
    {
        if ($this->collPreguntas === null) {
            $this->initPreguntas();
            $this->collPreguntasPartial = true;
        }

        if (!$this->collPreguntas->contains($l)) {
            $this->doAddPregunta($l);

            if ($this->preguntasScheduledForDeletion and $this->preguntasScheduledForDeletion->contains($l)) {
                $this->preguntasScheduledForDeletion->remove($this->preguntasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPregunta $pregunta The ChildPregunta object to add.
     */
    protected function doAddPregunta(ChildPregunta $pregunta)
    {
        $this->collPreguntas[]= $pregunta;
        $pregunta->setExamen($this);
    }

    /**
     * @param  ChildPregunta $pregunta The ChildPregunta object to remove.
     * @return $this|ChildExamen The current object (for fluent API support)
     */
    public function removePregunta(ChildPregunta $pregunta)
    {
        if ($this->getPreguntas()->contains($pregunta)) {
            $pos = $this->collPreguntas->search($pregunta);
            $this->collPreguntas->remove($pos);
            if (null === $this->preguntasScheduledForDeletion) {
                $this->preguntasScheduledForDeletion = clone $this->collPreguntas;
                $this->preguntasScheduledForDeletion->clear();
            }
            $this->preguntasScheduledForDeletion[]= clone $pregunta;
            $pregunta->setExamen(null);
        }

        return $this;
    }

    /**
     * Clears out the collResultados collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addResultados()
     */
    public function clearResultados()
    {
        $this->collResultados = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collResultados collection loaded partially.
     */
    public function resetPartialResultados($v = true)
    {
        $this->collResultadosPartial = $v;
    }

    /**
     * Initializes the collResultados collection.
     *
     * By default this just sets the collResultados collection to an empty array (like clearcollResultados());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initResultados($overrideExisting = true)
    {
        if (null !== $this->collResultados && !$overrideExisting) {
            return;
        }

        $collectionClassName = ResultadoTableMap::getTableMap()->getCollectionClassName();

        $this->collResultados = new $collectionClassName;
        $this->collResultados->setModel('\Resultado');
    }

    /**
     * Gets an array of ChildResultado objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExamen is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildResultado[] List of ChildResultado objects
     * @throws PropelException
     */
    public function getResultados(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collResultadosPartial && !$this->isNew();
        if (null === $this->collResultados || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collResultados) {
                // return empty collection
                $this->initResultados();
            } else {
                $collResultados = ChildResultadoQuery::create(null, $criteria)
                    ->filterByExamen($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collResultadosPartial && count($collResultados)) {
                        $this->initResultados(false);

                        foreach ($collResultados as $obj) {
                            if (false == $this->collResultados->contains($obj)) {
                                $this->collResultados->append($obj);
                            }
                        }

                        $this->collResultadosPartial = true;
                    }

                    return $collResultados;
                }

                if ($partial && $this->collResultados) {
                    foreach ($this->collResultados as $obj) {
                        if ($obj->isNew()) {
                            $collResultados[] = $obj;
                        }
                    }
                }

                $this->collResultados = $collResultados;
                $this->collResultadosPartial = false;
            }
        }

        return $this->collResultados;
    }

    /**
     * Sets a collection of ChildResultado objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $resultados A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExamen The current object (for fluent API support)
     */
    public function setResultados(Collection $resultados, ConnectionInterface $con = null)
    {
        /** @var ChildResultado[] $resultadosToDelete */
        $resultadosToDelete = $this->getResultados(new Criteria(), $con)->diff($resultados);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->resultadosScheduledForDeletion = clone $resultadosToDelete;

        foreach ($resultadosToDelete as $resultadoRemoved) {
            $resultadoRemoved->setExamen(null);
        }

        $this->collResultados = null;
        foreach ($resultados as $resultado) {
            $this->addResultado($resultado);
        }

        $this->collResultados = $resultados;
        $this->collResultadosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Resultado objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Resultado objects.
     * @throws PropelException
     */
    public function countResultados(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collResultadosPartial && !$this->isNew();
        if (null === $this->collResultados || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collResultados) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getResultados());
            }

            $query = ChildResultadoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByExamen($this)
                ->count($con);
        }

        return count($this->collResultados);
    }

    /**
     * Method called to associate a ChildResultado object to this object
     * through the ChildResultado foreign key attribute.
     *
     * @param  ChildResultado $l ChildResultado
     * @return $this|\Examen The current object (for fluent API support)
     */
    public function addResultado(ChildResultado $l)
    {
        if ($this->collResultados === null) {
            $this->initResultados();
            $this->collResultadosPartial = true;
        }

        if (!$this->collResultados->contains($l)) {
            $this->doAddResultado($l);

            if ($this->resultadosScheduledForDeletion and $this->resultadosScheduledForDeletion->contains($l)) {
                $this->resultadosScheduledForDeletion->remove($this->resultadosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildResultado $resultado The ChildResultado object to add.
     */
    protected function doAddResultado(ChildResultado $resultado)
    {
        $this->collResultados[]= $resultado;
        $resultado->setExamen($this);
    }

    /**
     * @param  ChildResultado $resultado The ChildResultado object to remove.
     * @return $this|ChildExamen The current object (for fluent API support)
     */
    public function removeResultado(ChildResultado $resultado)
    {
        if ($this->getResultados()->contains($resultado)) {
            $pos = $this->collResultados->search($resultado);
            $this->collResultados->remove($pos);
            if (null === $this->resultadosScheduledForDeletion) {
                $this->resultadosScheduledForDeletion = clone $this->collResultados;
                $this->resultadosScheduledForDeletion->clear();
            }
            $this->resultadosScheduledForDeletion[]= clone $resultado;
            $resultado->setExamen(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Examen is new, it will return
     * an empty collection; or if this Examen has previously
     * been saved, it will retrieve related Resultados from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Examen.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildResultado[] List of ChildResultado objects
     */
    public function getResultadosJoinAlumno(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildResultadoQuery::create(null, $criteria);
        $query->joinWith('Alumno', $joinBehavior);

        return $this->getResultados($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aMateria) {
            $this->aMateria->removeExamen($this);
        }
        if (null !== $this->aPeriodo) {
            $this->aPeriodo->removeExamen($this);
        }
        $this->id = null;
        $this->mat_id = null;
        $this->per_id = null;
        $this->fecha = null;
        $this->formativa = null;
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
            if ($this->collPreguntas) {
                foreach ($this->collPreguntas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collResultados) {
                foreach ($this->collResultados as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPreguntas = null;
        $this->collResultados = null;
        $this->aMateria = null;
        $this->aPeriodo = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ExamenTableMap::DEFAULT_STRING_FORMAT);
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
