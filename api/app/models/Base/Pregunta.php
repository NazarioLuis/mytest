<?php

namespace Base;

use \Examen as ChildExamen;
use \ExamenQuery as ChildExamenQuery;
use \Pregunta as ChildPregunta;
use \PreguntaQuery as ChildPreguntaQuery;
use \Respuesta as ChildRespuesta;
use \RespuestaQuery as ChildRespuestaQuery;
use \ResultadoDetalle as ChildResultadoDetalle;
use \ResultadoDetalleQuery as ChildResultadoDetalleQuery;
use \Exception;
use \PDO;
use Map\PreguntaTableMap;
use Map\RespuestaTableMap;
use Map\ResultadoDetalleTableMap;
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

/**
 * Base class that represents a row from the 'pregunta' table.
 *
 * 
 *
* @package    propel.generator..Base
*/
abstract class Pregunta implements ActiveRecordInterface 
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PreguntaTableMap';


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
     * The value for the exa_id field.
     * 
     * @var        int
     */
    protected $exa_id;

    /**
     * The value for the texto field.
     * 
     * @var        string
     */
    protected $texto;

    /**
     * @var        ChildExamen
     */
    protected $aExamen;

    /**
     * @var        ObjectCollection|ChildRespuesta[] Collection to store aggregation of ChildRespuesta objects.
     */
    protected $collRespuestas;
    protected $collRespuestasPartial;

    /**
     * @var        ObjectCollection|ChildResultadoDetalle[] Collection to store aggregation of ChildResultadoDetalle objects.
     */
    protected $collResultadoDetalles;
    protected $collResultadoDetallesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRespuesta[]
     */
    protected $respuestasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildResultadoDetalle[]
     */
    protected $resultadoDetallesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Pregunta object.
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
     * Compares this with another <code>Pregunta</code> instance.  If
     * <code>obj</code> is an instance of <code>Pregunta</code>, delegates to
     * <code>equals(Pregunta)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Pregunta The current object, for fluid interface
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
     * Get the [exa_id] column value.
     * 
     * @return int
     */
    public function getExaId()
    {
        return $this->exa_id;
    }

    /**
     * Get the [texto] column value.
     * 
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set the value of [id] column.
     * 
     * @param int $v new value
     * @return $this|\Pregunta The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PreguntaTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [exa_id] column.
     * 
     * @param int $v new value
     * @return $this|\Pregunta The current object (for fluent API support)
     */
    public function setExaId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->exa_id !== $v) {
            $this->exa_id = $v;
            $this->modifiedColumns[PreguntaTableMap::COL_EXA_ID] = true;
        }

        if ($this->aExamen !== null && $this->aExamen->getId() !== $v) {
            $this->aExamen = null;
        }

        return $this;
    } // setExaId()

    /**
     * Set the value of [texto] column.
     * 
     * @param string $v new value
     * @return $this|\Pregunta The current object (for fluent API support)
     */
    public function setTexto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->texto !== $v) {
            $this->texto = $v;
            $this->modifiedColumns[PreguntaTableMap::COL_TEXTO] = true;
        }

        return $this;
    } // setTexto()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PreguntaTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PreguntaTableMap::translateFieldName('ExaId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exa_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PreguntaTableMap::translateFieldName('Texto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->texto = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PreguntaTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Pregunta'), 0, $e);
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
        if ($this->aExamen !== null && $this->exa_id !== $this->aExamen->getId()) {
            $this->aExamen = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PreguntaTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPreguntaQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aExamen = null;
            $this->collRespuestas = null;

            $this->collResultadoDetalles = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Pregunta::setDeleted()
     * @see Pregunta::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreguntaTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPreguntaQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PreguntaTableMap::DATABASE_NAME);
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
                PreguntaTableMap::addInstanceToPool($this);
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

            if ($this->aExamen !== null) {
                if ($this->aExamen->isModified() || $this->aExamen->isNew()) {
                    $affectedRows += $this->aExamen->save($con);
                }
                $this->setExamen($this->aExamen);
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

            if ($this->respuestasScheduledForDeletion !== null) {
                if (!$this->respuestasScheduledForDeletion->isEmpty()) {
                    \RespuestaQuery::create()
                        ->filterByPrimaryKeys($this->respuestasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->respuestasScheduledForDeletion = null;
                }
            }

            if ($this->collRespuestas !== null) {
                foreach ($this->collRespuestas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->resultadoDetallesScheduledForDeletion !== null) {
                if (!$this->resultadoDetallesScheduledForDeletion->isEmpty()) {
                    \ResultadoDetalleQuery::create()
                        ->filterByPrimaryKeys($this->resultadoDetallesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->resultadoDetallesScheduledForDeletion = null;
                }
            }

            if ($this->collResultadoDetalles !== null) {
                foreach ($this->collResultadoDetalles as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PreguntaTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PreguntaTableMap::COL_EXA_ID)) {
            $modifiedColumns[':p' . $index++]  = 'exa_id';
        }
        if ($this->isColumnModified(PreguntaTableMap::COL_TEXTO)) {
            $modifiedColumns[':p' . $index++]  = 'texto';
        }

        $sql = sprintf(
            'INSERT INTO pregunta (%s) VALUES (%s)',
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
                    case 'exa_id':                        
                        $stmt->bindValue($identifier, $this->exa_id, PDO::PARAM_INT);
                        break;
                    case 'texto':                        
                        $stmt->bindValue($identifier, $this->texto, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = PreguntaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getExaId();
                break;
            case 2:
                return $this->getTexto();
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

        if (isset($alreadyDumpedObjects['Pregunta'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Pregunta'][$this->hashCode()] = true;
        $keys = PreguntaTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getExaId(),
            $keys[2] => $this->getTexto(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }
        
        if ($includeForeignObjects) {
            if (null !== $this->aExamen) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'examen';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'examen';
                        break;
                    default:
                        $key = 'Examen';
                }
        
                $result[$key] = $this->aExamen->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRespuestas) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'respuestas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'respuestas';
                        break;
                    default:
                        $key = 'Respuestas';
                }
        
                $result[$key] = $this->collRespuestas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collResultadoDetalles) {
                
                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'resultadoDetalles';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'resultado_detalles';
                        break;
                    default:
                        $key = 'ResultadoDetalles';
                }
        
                $result[$key] = $this->collResultadoDetalles->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Pregunta
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PreguntaTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Pregunta
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setExaId($value);
                break;
            case 2:
                $this->setTexto($value);
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
        $keys = PreguntaTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setExaId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTexto($arr[$keys[2]]);
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
     * @return $this|\Pregunta The current object, for fluid interface
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
        $criteria = new Criteria(PreguntaTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PreguntaTableMap::COL_ID)) {
            $criteria->add(PreguntaTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PreguntaTableMap::COL_EXA_ID)) {
            $criteria->add(PreguntaTableMap::COL_EXA_ID, $this->exa_id);
        }
        if ($this->isColumnModified(PreguntaTableMap::COL_TEXTO)) {
            $criteria->add(PreguntaTableMap::COL_TEXTO, $this->texto);
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
        $criteria = ChildPreguntaQuery::create();
        $criteria->add(PreguntaTableMap::COL_ID, $this->id);
        $criteria->add(PreguntaTableMap::COL_EXA_ID, $this->exa_id);

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
        $validPk = null !== $this->getId() &&
            null !== $this->getExaId();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation examenes_preguntas_fk to table examen
        if ($this->aExamen && $hash = spl_object_hash($this->aExamen)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }
        
    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getExaId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setExaId($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getId()) && (null === $this->getExaId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Pregunta (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setExaId($this->getExaId());
        $copyObj->setTexto($this->getTexto());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRespuestas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRespuesta($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getResultadoDetalles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addResultadoDetalle($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Pregunta Clone of current object.
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
     * Declares an association between this object and a ChildExamen object.
     *
     * @param  ChildExamen $v
     * @return $this|\Pregunta The current object (for fluent API support)
     * @throws PropelException
     */
    public function setExamen(ChildExamen $v = null)
    {
        if ($v === null) {
            $this->setExaId(NULL);
        } else {
            $this->setExaId($v->getId());
        }

        $this->aExamen = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildExamen object, it will not be re-added.
        if ($v !== null) {
            $v->addPregunta($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildExamen object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildExamen The associated ChildExamen object.
     * @throws PropelException
     */
    public function getExamen(ConnectionInterface $con = null)
    {
        if ($this->aExamen === null && ($this->exa_id !== null)) {
            $this->aExamen = ChildExamenQuery::create()->findPk($this->exa_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aExamen->addPreguntas($this);
             */
        }

        return $this->aExamen;
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
        if ('Respuesta' == $relationName) {
            return $this->initRespuestas();
        }
        if ('ResultadoDetalle' == $relationName) {
            return $this->initResultadoDetalles();
        }
    }

    /**
     * Clears out the collRespuestas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRespuestas()
     */
    public function clearRespuestas()
    {
        $this->collRespuestas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRespuestas collection loaded partially.
     */
    public function resetPartialRespuestas($v = true)
    {
        $this->collRespuestasPartial = $v;
    }

    /**
     * Initializes the collRespuestas collection.
     *
     * By default this just sets the collRespuestas collection to an empty array (like clearcollRespuestas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRespuestas($overrideExisting = true)
    {
        if (null !== $this->collRespuestas && !$overrideExisting) {
            return;
        }

        $collectionClassName = RespuestaTableMap::getTableMap()->getCollectionClassName();

        $this->collRespuestas = new $collectionClassName;
        $this->collRespuestas->setModel('\Respuesta');
    }

    /**
     * Gets an array of ChildRespuesta objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPregunta is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRespuesta[] List of ChildRespuesta objects
     * @throws PropelException
     */
    public function getRespuestas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRespuestasPartial && !$this->isNew();
        if (null === $this->collRespuestas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRespuestas) {
                // return empty collection
                $this->initRespuestas();
            } else {
                $collRespuestas = ChildRespuestaQuery::create(null, $criteria)
                    ->filterByPregunta($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRespuestasPartial && count($collRespuestas)) {
                        $this->initRespuestas(false);

                        foreach ($collRespuestas as $obj) {
                            if (false == $this->collRespuestas->contains($obj)) {
                                $this->collRespuestas->append($obj);
                            }
                        }

                        $this->collRespuestasPartial = true;
                    }

                    return $collRespuestas;
                }

                if ($partial && $this->collRespuestas) {
                    foreach ($this->collRespuestas as $obj) {
                        if ($obj->isNew()) {
                            $collRespuestas[] = $obj;
                        }
                    }
                }

                $this->collRespuestas = $collRespuestas;
                $this->collRespuestasPartial = false;
            }
        }

        return $this->collRespuestas;
    }

    /**
     * Sets a collection of ChildRespuesta objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $respuestas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPregunta The current object (for fluent API support)
     */
    public function setRespuestas(Collection $respuestas, ConnectionInterface $con = null)
    {
        /** @var ChildRespuesta[] $respuestasToDelete */
        $respuestasToDelete = $this->getRespuestas(new Criteria(), $con)->diff($respuestas);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->respuestasScheduledForDeletion = clone $respuestasToDelete;

        foreach ($respuestasToDelete as $respuestaRemoved) {
            $respuestaRemoved->setPregunta(null);
        }

        $this->collRespuestas = null;
        foreach ($respuestas as $respuesta) {
            $this->addRespuesta($respuesta);
        }

        $this->collRespuestas = $respuestas;
        $this->collRespuestasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Respuesta objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Respuesta objects.
     * @throws PropelException
     */
    public function countRespuestas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRespuestasPartial && !$this->isNew();
        if (null === $this->collRespuestas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRespuestas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRespuestas());
            }

            $query = ChildRespuestaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPregunta($this)
                ->count($con);
        }

        return count($this->collRespuestas);
    }

    /**
     * Method called to associate a ChildRespuesta object to this object
     * through the ChildRespuesta foreign key attribute.
     *
     * @param  ChildRespuesta $l ChildRespuesta
     * @return $this|\Pregunta The current object (for fluent API support)
     */
    public function addRespuesta(ChildRespuesta $l)
    {
        if ($this->collRespuestas === null) {
            $this->initRespuestas();
            $this->collRespuestasPartial = true;
        }

        if (!$this->collRespuestas->contains($l)) {
            $this->doAddRespuesta($l);

            if ($this->respuestasScheduledForDeletion and $this->respuestasScheduledForDeletion->contains($l)) {
                $this->respuestasScheduledForDeletion->remove($this->respuestasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRespuesta $respuesta The ChildRespuesta object to add.
     */
    protected function doAddRespuesta(ChildRespuesta $respuesta)
    {
        $this->collRespuestas[]= $respuesta;
        $respuesta->setPregunta($this);
    }

    /**
     * @param  ChildRespuesta $respuesta The ChildRespuesta object to remove.
     * @return $this|ChildPregunta The current object (for fluent API support)
     */
    public function removeRespuesta(ChildRespuesta $respuesta)
    {
        if ($this->getRespuestas()->contains($respuesta)) {
            $pos = $this->collRespuestas->search($respuesta);
            $this->collRespuestas->remove($pos);
            if (null === $this->respuestasScheduledForDeletion) {
                $this->respuestasScheduledForDeletion = clone $this->collRespuestas;
                $this->respuestasScheduledForDeletion->clear();
            }
            $this->respuestasScheduledForDeletion[]= clone $respuesta;
            $respuesta->setPregunta(null);
        }

        return $this;
    }

    /**
     * Clears out the collResultadoDetalles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addResultadoDetalles()
     */
    public function clearResultadoDetalles()
    {
        $this->collResultadoDetalles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collResultadoDetalles collection loaded partially.
     */
    public function resetPartialResultadoDetalles($v = true)
    {
        $this->collResultadoDetallesPartial = $v;
    }

    /**
     * Initializes the collResultadoDetalles collection.
     *
     * By default this just sets the collResultadoDetalles collection to an empty array (like clearcollResultadoDetalles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initResultadoDetalles($overrideExisting = true)
    {
        if (null !== $this->collResultadoDetalles && !$overrideExisting) {
            return;
        }

        $collectionClassName = ResultadoDetalleTableMap::getTableMap()->getCollectionClassName();

        $this->collResultadoDetalles = new $collectionClassName;
        $this->collResultadoDetalles->setModel('\ResultadoDetalle');
    }

    /**
     * Gets an array of ChildResultadoDetalle objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPregunta is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildResultadoDetalle[] List of ChildResultadoDetalle objects
     * @throws PropelException
     */
    public function getResultadoDetalles(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collResultadoDetallesPartial && !$this->isNew();
        if (null === $this->collResultadoDetalles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collResultadoDetalles) {
                // return empty collection
                $this->initResultadoDetalles();
            } else {
                $collResultadoDetalles = ChildResultadoDetalleQuery::create(null, $criteria)
                    ->filterByPregunta($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collResultadoDetallesPartial && count($collResultadoDetalles)) {
                        $this->initResultadoDetalles(false);

                        foreach ($collResultadoDetalles as $obj) {
                            if (false == $this->collResultadoDetalles->contains($obj)) {
                                $this->collResultadoDetalles->append($obj);
                            }
                        }

                        $this->collResultadoDetallesPartial = true;
                    }

                    return $collResultadoDetalles;
                }

                if ($partial && $this->collResultadoDetalles) {
                    foreach ($this->collResultadoDetalles as $obj) {
                        if ($obj->isNew()) {
                            $collResultadoDetalles[] = $obj;
                        }
                    }
                }

                $this->collResultadoDetalles = $collResultadoDetalles;
                $this->collResultadoDetallesPartial = false;
            }
        }

        return $this->collResultadoDetalles;
    }

    /**
     * Sets a collection of ChildResultadoDetalle objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $resultadoDetalles A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPregunta The current object (for fluent API support)
     */
    public function setResultadoDetalles(Collection $resultadoDetalles, ConnectionInterface $con = null)
    {
        /** @var ChildResultadoDetalle[] $resultadoDetallesToDelete */
        $resultadoDetallesToDelete = $this->getResultadoDetalles(new Criteria(), $con)->diff($resultadoDetalles);

        
        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->resultadoDetallesScheduledForDeletion = clone $resultadoDetallesToDelete;

        foreach ($resultadoDetallesToDelete as $resultadoDetalleRemoved) {
            $resultadoDetalleRemoved->setPregunta(null);
        }

        $this->collResultadoDetalles = null;
        foreach ($resultadoDetalles as $resultadoDetalle) {
            $this->addResultadoDetalle($resultadoDetalle);
        }

        $this->collResultadoDetalles = $resultadoDetalles;
        $this->collResultadoDetallesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ResultadoDetalle objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ResultadoDetalle objects.
     * @throws PropelException
     */
    public function countResultadoDetalles(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collResultadoDetallesPartial && !$this->isNew();
        if (null === $this->collResultadoDetalles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collResultadoDetalles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getResultadoDetalles());
            }

            $query = ChildResultadoDetalleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPregunta($this)
                ->count($con);
        }

        return count($this->collResultadoDetalles);
    }

    /**
     * Method called to associate a ChildResultadoDetalle object to this object
     * through the ChildResultadoDetalle foreign key attribute.
     *
     * @param  ChildResultadoDetalle $l ChildResultadoDetalle
     * @return $this|\Pregunta The current object (for fluent API support)
     */
    public function addResultadoDetalle(ChildResultadoDetalle $l)
    {
        if ($this->collResultadoDetalles === null) {
            $this->initResultadoDetalles();
            $this->collResultadoDetallesPartial = true;
        }

        if (!$this->collResultadoDetalles->contains($l)) {
            $this->doAddResultadoDetalle($l);

            if ($this->resultadoDetallesScheduledForDeletion and $this->resultadoDetallesScheduledForDeletion->contains($l)) {
                $this->resultadoDetallesScheduledForDeletion->remove($this->resultadoDetallesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildResultadoDetalle $resultadoDetalle The ChildResultadoDetalle object to add.
     */
    protected function doAddResultadoDetalle(ChildResultadoDetalle $resultadoDetalle)
    {
        $this->collResultadoDetalles[]= $resultadoDetalle;
        $resultadoDetalle->setPregunta($this);
    }

    /**
     * @param  ChildResultadoDetalle $resultadoDetalle The ChildResultadoDetalle object to remove.
     * @return $this|ChildPregunta The current object (for fluent API support)
     */
    public function removeResultadoDetalle(ChildResultadoDetalle $resultadoDetalle)
    {
        if ($this->getResultadoDetalles()->contains($resultadoDetalle)) {
            $pos = $this->collResultadoDetalles->search($resultadoDetalle);
            $this->collResultadoDetalles->remove($pos);
            if (null === $this->resultadoDetallesScheduledForDeletion) {
                $this->resultadoDetallesScheduledForDeletion = clone $this->collResultadoDetalles;
                $this->resultadoDetallesScheduledForDeletion->clear();
            }
            $this->resultadoDetallesScheduledForDeletion[]= clone $resultadoDetalle;
            $resultadoDetalle->setPregunta(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pregunta is new, it will return
     * an empty collection; or if this Pregunta has previously
     * been saved, it will retrieve related ResultadoDetalles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pregunta.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildResultadoDetalle[] List of ChildResultadoDetalle objects
     */
    public function getResultadoDetallesJoinResultado(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildResultadoDetalleQuery::create(null, $criteria);
        $query->joinWith('Resultado', $joinBehavior);

        return $this->getResultadoDetalles($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aExamen) {
            $this->aExamen->removePregunta($this);
        }
        $this->id = null;
        $this->exa_id = null;
        $this->texto = null;
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
            if ($this->collRespuestas) {
                foreach ($this->collRespuestas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collResultadoDetalles) {
                foreach ($this->collResultadoDetalles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRespuestas = null;
        $this->collResultadoDetalles = null;
        $this->aExamen = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PreguntaTableMap::DEFAULT_STRING_FORMAT);
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
