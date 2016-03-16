<?php

namespace Base;

use \Carrera as ChildCarrera;
use \CarreraQuery as ChildCarreraQuery;
use \Exception;
use \PDO;
use Map\CarreraTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'carrera' table.
 *
 * 
 *
 * @method     ChildCarreraQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCarreraQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method     ChildCarreraQuery orderByObservacion($order = Criteria::ASC) Order by the observacion column
 *
 * @method     ChildCarreraQuery groupById() Group by the id column
 * @method     ChildCarreraQuery groupByDescripcion() Group by the descripcion column
 * @method     ChildCarreraQuery groupByObservacion() Group by the observacion column
 *
 * @method     ChildCarreraQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCarreraQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCarreraQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCarreraQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCarreraQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCarreraQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCarreraQuery leftJoinMateria($relationAlias = null) Adds a LEFT JOIN clause to the query using the Materia relation
 * @method     ChildCarreraQuery rightJoinMateria($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Materia relation
 * @method     ChildCarreraQuery innerJoinMateria($relationAlias = null) Adds a INNER JOIN clause to the query using the Materia relation
 *
 * @method     ChildCarreraQuery joinWithMateria($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Materia relation
 *
 * @method     ChildCarreraQuery leftJoinWithMateria() Adds a LEFT JOIN clause and with to the query using the Materia relation
 * @method     ChildCarreraQuery rightJoinWithMateria() Adds a RIGHT JOIN clause and with to the query using the Materia relation
 * @method     ChildCarreraQuery innerJoinWithMateria() Adds a INNER JOIN clause and with to the query using the Materia relation
 *
 * @method     ChildCarreraQuery leftJoinPeriodo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Periodo relation
 * @method     ChildCarreraQuery rightJoinPeriodo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Periodo relation
 * @method     ChildCarreraQuery innerJoinPeriodo($relationAlias = null) Adds a INNER JOIN clause to the query using the Periodo relation
 *
 * @method     ChildCarreraQuery joinWithPeriodo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Periodo relation
 *
 * @method     ChildCarreraQuery leftJoinWithPeriodo() Adds a LEFT JOIN clause and with to the query using the Periodo relation
 * @method     ChildCarreraQuery rightJoinWithPeriodo() Adds a RIGHT JOIN clause and with to the query using the Periodo relation
 * @method     ChildCarreraQuery innerJoinWithPeriodo() Adds a INNER JOIN clause and with to the query using the Periodo relation
 *
 * @method     \MateriaQuery|\PeriodoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCarrera findOne(ConnectionInterface $con = null) Return the first ChildCarrera matching the query
 * @method     ChildCarrera findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCarrera matching the query, or a new ChildCarrera object populated from the query conditions when no match is found
 *
 * @method     ChildCarrera findOneById(int $id) Return the first ChildCarrera filtered by the id column
 * @method     ChildCarrera findOneByDescripcion(string $descripcion) Return the first ChildCarrera filtered by the descripcion column
 * @method     ChildCarrera findOneByObservacion(string $observacion) Return the first ChildCarrera filtered by the observacion column *

 * @method     ChildCarrera requirePk($key, ConnectionInterface $con = null) Return the ChildCarrera by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarrera requireOne(ConnectionInterface $con = null) Return the first ChildCarrera matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCarrera requireOneById(int $id) Return the first ChildCarrera filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarrera requireOneByDescripcion(string $descripcion) Return the first ChildCarrera filtered by the descripcion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarrera requireOneByObservacion(string $observacion) Return the first ChildCarrera filtered by the observacion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCarrera[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCarrera objects based on current ModelCriteria
 * @method     ChildCarrera[]|ObjectCollection findById(int $id) Return ChildCarrera objects filtered by the id column
 * @method     ChildCarrera[]|ObjectCollection findByDescripcion(string $descripcion) Return ChildCarrera objects filtered by the descripcion column
 * @method     ChildCarrera[]|ObjectCollection findByObservacion(string $observacion) Return ChildCarrera objects filtered by the observacion column
 * @method     ChildCarrera[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CarreraQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CarreraQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Carrera', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCarreraQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCarreraQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCarreraQuery) {
            return $criteria;
        }
        $query = new ChildCarreraQuery();
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
     * @return ChildCarrera|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CarreraTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CarreraTableMap::DATABASE_NAME);
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
     * @return ChildCarrera A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, descripcion, observacion FROM carrera WHERE id = :p0';
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
            /** @var ChildCarrera $obj */
            $obj = new ChildCarrera();
            $obj->hydrate($row);
            CarreraTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCarrera|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CarreraTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CarreraTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CarreraTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CarreraTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarreraTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByDescripcion('fooValue');   // WHERE descripcion = 'fooValue'
     * $query->filterByDescripcion('%fooValue%'); // WHERE descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function filterByDescripcion($descripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descripcion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descripcion)) {
                $descripcion = str_replace('*', '%', $descripcion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CarreraTableMap::COL_DESCRIPCION, $descripcion, $comparison);
    }

    /**
     * Filter the query on the observacion column
     *
     * Example usage:
     * <code>
     * $query->filterByObservacion('fooValue');   // WHERE observacion = 'fooValue'
     * $query->filterByObservacion('%fooValue%'); // WHERE observacion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $observacion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function filterByObservacion($observacion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($observacion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $observacion)) {
                $observacion = str_replace('*', '%', $observacion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CarreraTableMap::COL_OBSERVACION, $observacion, $comparison);
    }

    /**
     * Filter the query by a related \Materia object
     *
     * @param \Materia|ObjectCollection $materia the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarreraQuery The current query, for fluid interface
     */
    public function filterByMateria($materia, $comparison = null)
    {
        if ($materia instanceof \Materia) {
            return $this
                ->addUsingAlias(CarreraTableMap::COL_ID, $materia->getCarId(), $comparison);
        } elseif ($materia instanceof ObjectCollection) {
            return $this
                ->useMateriaQuery()
                ->filterByPrimaryKeys($materia->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMateria() only accepts arguments of type \Materia or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Materia relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function joinMateria($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Materia');

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
            $this->addJoinObject($join, 'Materia');
        }

        return $this;
    }

    /**
     * Use the Materia relation Materia object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MateriaQuery A secondary query class using the current class as primary query
     */
    public function useMateriaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMateria($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Materia', '\MateriaQuery');
    }

    /**
     * Filter the query by a related \Periodo object
     *
     * @param \Periodo|ObjectCollection $periodo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCarreraQuery The current query, for fluid interface
     */
    public function filterByPeriodo($periodo, $comparison = null)
    {
        if ($periodo instanceof \Periodo) {
            return $this
                ->addUsingAlias(CarreraTableMap::COL_ID, $periodo->getCarId(), $comparison);
        } elseif ($periodo instanceof ObjectCollection) {
            return $this
                ->usePeriodoQuery()
                ->filterByPrimaryKeys($periodo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPeriodo() only accepts arguments of type \Periodo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Periodo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function joinPeriodo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Periodo');

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
            $this->addJoinObject($join, 'Periodo');
        }

        return $this;
    }

    /**
     * Use the Periodo relation Periodo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PeriodoQuery A secondary query class using the current class as primary query
     */
    public function usePeriodoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPeriodo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Periodo', '\PeriodoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCarrera $carrera Object to remove from the list of results
     *
     * @return $this|ChildCarreraQuery The current query, for fluid interface
     */
    public function prune($carrera = null)
    {
        if ($carrera) {
            $this->addUsingAlias(CarreraTableMap::COL_ID, $carrera->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the carrera table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarreraTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CarreraTableMap::clearInstancePool();
            CarreraTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CarreraTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CarreraTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            CarreraTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            CarreraTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CarreraQuery
