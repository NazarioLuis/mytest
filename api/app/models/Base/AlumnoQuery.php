<?php

namespace Base;

use \Alumno as ChildAlumno;
use \AlumnoQuery as ChildAlumnoQuery;
use \Exception;
use \PDO;
use Map\AlumnoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'alumno' table.
 *
 * 
 *
 * @method     ChildAlumnoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAlumnoQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildAlumnoQuery orderByApellido($order = Criteria::ASC) Order by the apellido column
 * @method     ChildAlumnoQuery orderByDocumento($order = Criteria::ASC) Order by the documento column
 * @method     ChildAlumnoQuery orderBySenia($order = Criteria::ASC) Order by the senia column
 *
 * @method     ChildAlumnoQuery groupById() Group by the id column
 * @method     ChildAlumnoQuery groupByNombre() Group by the nombre column
 * @method     ChildAlumnoQuery groupByApellido() Group by the apellido column
 * @method     ChildAlumnoQuery groupByDocumento() Group by the documento column
 * @method     ChildAlumnoQuery groupBySenia() Group by the senia column
 *
 * @method     ChildAlumnoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlumnoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlumnoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlumnoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAlumnoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAlumnoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAlumnoQuery leftJoinInscripcion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inscripcion relation
 * @method     ChildAlumnoQuery rightJoinInscripcion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inscripcion relation
 * @method     ChildAlumnoQuery innerJoinInscripcion($relationAlias = null) Adds a INNER JOIN clause to the query using the Inscripcion relation
 *
 * @method     ChildAlumnoQuery joinWithInscripcion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inscripcion relation
 *
 * @method     ChildAlumnoQuery leftJoinWithInscripcion() Adds a LEFT JOIN clause and with to the query using the Inscripcion relation
 * @method     ChildAlumnoQuery rightJoinWithInscripcion() Adds a RIGHT JOIN clause and with to the query using the Inscripcion relation
 * @method     ChildAlumnoQuery innerJoinWithInscripcion() Adds a INNER JOIN clause and with to the query using the Inscripcion relation
 *
 * @method     ChildAlumnoQuery leftJoinResultado($relationAlias = null) Adds a LEFT JOIN clause to the query using the Resultado relation
 * @method     ChildAlumnoQuery rightJoinResultado($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Resultado relation
 * @method     ChildAlumnoQuery innerJoinResultado($relationAlias = null) Adds a INNER JOIN clause to the query using the Resultado relation
 *
 * @method     ChildAlumnoQuery joinWithResultado($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Resultado relation
 *
 * @method     ChildAlumnoQuery leftJoinWithResultado() Adds a LEFT JOIN clause and with to the query using the Resultado relation
 * @method     ChildAlumnoQuery rightJoinWithResultado() Adds a RIGHT JOIN clause and with to the query using the Resultado relation
 * @method     ChildAlumnoQuery innerJoinWithResultado() Adds a INNER JOIN clause and with to the query using the Resultado relation
 *
 * @method     \InscripcionQuery|\ResultadoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAlumno findOne(ConnectionInterface $con = null) Return the first ChildAlumno matching the query
 * @method     ChildAlumno findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAlumno matching the query, or a new ChildAlumno object populated from the query conditions when no match is found
 *
 * @method     ChildAlumno findOneById(int $id) Return the first ChildAlumno filtered by the id column
 * @method     ChildAlumno findOneByNombre(string $nombre) Return the first ChildAlumno filtered by the nombre column
 * @method     ChildAlumno findOneByApellido(string $apellido) Return the first ChildAlumno filtered by the apellido column
 * @method     ChildAlumno findOneByDocumento(string $documento) Return the first ChildAlumno filtered by the documento column
 * @method     ChildAlumno findOneBySenia(string $senia) Return the first ChildAlumno filtered by the senia column *

 * @method     ChildAlumno requirePk($key, ConnectionInterface $con = null) Return the ChildAlumno by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlumno requireOne(ConnectionInterface $con = null) Return the first ChildAlumno matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlumno requireOneById(int $id) Return the first ChildAlumno filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlumno requireOneByNombre(string $nombre) Return the first ChildAlumno filtered by the nombre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlumno requireOneByApellido(string $apellido) Return the first ChildAlumno filtered by the apellido column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlumno requireOneByDocumento(string $documento) Return the first ChildAlumno filtered by the documento column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlumno requireOneBySenia(string $senia) Return the first ChildAlumno filtered by the senia column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlumno[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAlumno objects based on current ModelCriteria
 * @method     ChildAlumno[]|ObjectCollection findById(int $id) Return ChildAlumno objects filtered by the id column
 * @method     ChildAlumno[]|ObjectCollection findByNombre(string $nombre) Return ChildAlumno objects filtered by the nombre column
 * @method     ChildAlumno[]|ObjectCollection findByApellido(string $apellido) Return ChildAlumno objects filtered by the apellido column
 * @method     ChildAlumno[]|ObjectCollection findByDocumento(string $documento) Return ChildAlumno objects filtered by the documento column
 * @method     ChildAlumno[]|ObjectCollection findBySenia(string $senia) Return ChildAlumno objects filtered by the senia column
 * @method     ChildAlumno[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AlumnoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AlumnoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Alumno', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlumnoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlumnoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAlumnoQuery) {
            return $criteria;
        }
        $query = new ChildAlumnoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAlumno|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AlumnoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlumnoTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAlumno A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nombre, apellido, documento, senia FROM alumno WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAlumno $obj */
            $obj = new ChildAlumno();
            $obj->hydrate($row);
            AlumnoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAlumno|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlumnoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlumnoTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AlumnoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AlumnoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlumnoTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the nombre column
     *
     * Example usage:
     * <code>
     * $query->filterByNombre('fooValue');   // WHERE nombre = 'fooValue'
     * $query->filterByNombre('%fooValue%'); // WHERE nombre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombre)) {
                $nombre = str_replace('*', '%', $nombre);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlumnoTableMap::COL_NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the apellido column
     *
     * Example usage:
     * <code>
     * $query->filterByApellido('fooValue');   // WHERE apellido = 'fooValue'
     * $query->filterByApellido('%fooValue%'); // WHERE apellido LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apellido The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByApellido($apellido = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apellido)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apellido)) {
                $apellido = str_replace('*', '%', $apellido);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlumnoTableMap::COL_APELLIDO, $apellido, $comparison);
    }

    /**
     * Filter the query on the documento column
     *
     * Example usage:
     * <code>
     * $query->filterByDocumento('fooValue');   // WHERE documento = 'fooValue'
     * $query->filterByDocumento('%fooValue%'); // WHERE documento LIKE '%fooValue%'
     * </code>
     *
     * @param     string $documento The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByDocumento($documento = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($documento)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $documento)) {
                $documento = str_replace('*', '%', $documento);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlumnoTableMap::COL_DOCUMENTO, $documento, $comparison);
    }

    /**
     * Filter the query on the senia column
     *
     * Example usage:
     * <code>
     * $query->filterBySenia('fooValue');   // WHERE senia = 'fooValue'
     * $query->filterBySenia('%fooValue%'); // WHERE senia LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senia The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterBySenia($senia = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senia)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $senia)) {
                $senia = str_replace('*', '%', $senia);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlumnoTableMap::COL_SENIA, $senia, $comparison);
    }

    /**
     * Filter the query by a related \Inscripcion object
     *
     * @param \Inscripcion|ObjectCollection $inscripcion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByInscripcion($inscripcion, $comparison = null)
    {
        if ($inscripcion instanceof \Inscripcion) {
            return $this
                ->addUsingAlias(AlumnoTableMap::COL_ID, $inscripcion->getAluId(), $comparison);
        } elseif ($inscripcion instanceof ObjectCollection) {
            return $this
                ->useInscripcionQuery()
                ->filterByPrimaryKeys($inscripcion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInscripcion() only accepts arguments of type \Inscripcion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Inscripcion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function joinInscripcion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Inscripcion');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Inscripcion');
        }

        return $this;
    }

    /**
     * Use the Inscripcion relation Inscripcion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \InscripcionQuery A secondary query class using the current class as primary query
     */
    public function useInscripcionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInscripcion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Inscripcion', '\InscripcionQuery');
    }

    /**
     * Filter the query by a related \Resultado object
     *
     * @param \Resultado|ObjectCollection $resultado the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAlumnoQuery The current query, for fluid interface
     */
    public function filterByResultado($resultado, $comparison = null)
    {
        if ($resultado instanceof \Resultado) {
            return $this
                ->addUsingAlias(AlumnoTableMap::COL_ID, $resultado->getAluId(), $comparison);
        } elseif ($resultado instanceof ObjectCollection) {
            return $this
                ->useResultadoQuery()
                ->filterByPrimaryKeys($resultado->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByResultado() only accepts arguments of type \Resultado or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Resultado relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function joinResultado($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Resultado');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Resultado');
        }

        return $this;
    }

    /**
     * Use the Resultado relation Resultado object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResultadoQuery A secondary query class using the current class as primary query
     */
    public function useResultadoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResultado($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Resultado', '\ResultadoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAlumno $alumno Object to remove from the list of results
     *
     * @return $this|ChildAlumnoQuery The current query, for fluid interface
     */
    public function prune($alumno = null)
    {
        if ($alumno) {
            $this->addUsingAlias(AlumnoTableMap::COL_ID, $alumno->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the alumno table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlumnoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlumnoTableMap::clearInstancePool();
            AlumnoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlumnoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlumnoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            AlumnoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            AlumnoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AlumnoQuery
